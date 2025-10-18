<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\LiveSetting;
use App\Services\KeywordFilterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller
{
    protected $keywordFilterService;

    public function __construct(KeywordFilterService $keywordFilterService)
    {
        $this->keywordFilterService = $keywordFilterService;
    }

    /**
     * Get recent chat messages
     */
    public function getMessages(Request $request): JsonResponse
    {
        try {
            $query = ChatMessage::notBlocked();
            
            // Filter by live_setting_id if provided
            if ($request->has('live_setting_id')) {
                $liveSettingId = $request->input('live_setting_id');
                $query->where('live_setting_id', $liveSettingId);
                
                // Only show messages from live stream start time onwards
                $liveSetting = LiveSetting::find($liveSettingId);
                if ($liveSetting) {
                    $liveStartTime = \Carbon\Carbon::parse(
                        $liveSetting->live_date->format('Y-m-d') . ' ' . 
                        $liveSetting->live_time->format('H:i:s')
                    );
                    
                    // Only get messages from live start time onwards
                    $query->where('created_at', '>=', $liveStartTime);
                }
            }
            
            // Get messages after specific ID (for polling)
            if ($request->has('after')) {
                $query->where('id', '>', $request->input('after'));
            }
            
            $messages = $query->orderBy('created_at', 'desc')
                ->limit(50)
                ->get()
                ->reverse()
                ->values();

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting chat messages', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể tải tin nhắn'
            ], 500);
        }
    }

    /**
     * Send a new chat message
     */
    public function sendMessage(Request $request): JsonResponse
    {
        try {
            // Check if user is authenticated
            if (!Auth::check() && !session("external_user")) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để chat'
                ], 401);
            }

            if (Auth::check()) { $user = Auth::user(); } else { $user = (object) session("external_user"); }

            // Check rate limit (throttle) - Apply to all users except Admin and Live Staff
            $throttleEnabled = \App\Models\ChatSetting::isThrottleEnabled();
            Log::info('Throttle check START', [
                'throttle_enabled' => $throttleEnabled,
                'user_id' => Auth::id(),
                'username' => $user->name ?? $user->account ?? 'unknown'
            ]);
            
            if ($throttleEnabled) {
                // Check if user should bypass throttle (only for authenticated Admin/Live Staff)
                $shouldBypassThrottle = false;
                if (Auth::check()) {
                    $shouldBypassThrottle = $user->hasRole('Admin') || $user->hasRole('Nhân viên Live');
                }
                
                Log::info('Bypass check', [
                    'should_bypass' => $shouldBypassThrottle,
                    'is_authenticated' => Auth::check()
                ]);
                
                if (!$shouldBypassThrottle) {
                    $throttleSeconds = \App\Models\ChatSetting::getThrottleSeconds();
                    
                    Log::info('Throttle settings', [
                        'throttle_seconds' => $throttleSeconds
                    ]);
                    
                    // Build query to find last message
                    $query = ChatMessage::query();
                    
                    // For authenticated users, search by user_id
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        // For external users, search by username (session-based)
                        $username = $user->name ?? $user->account ?? null;
                        if ($username) {
                            $query->where('username', $username)
                                  ->whereNull('user_id'); // Only check messages without user_id (external users)
                        } else {
                            // No way to track this user, skip throttle
                            goto skipThrottle;
                        }
                    }
                    
                    // Get user's last message (within reasonable time - last 24 hours)
                    $lastMessage = $query->where('created_at', '>=', now()->subDay())
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    Log::info('Last message check', [
                        'has_last_message' => $lastMessage ? true : false,
                        'last_message_id' => $lastMessage ? $lastMessage->id : null,
                        'last_message_time' => $lastMessage ? $lastMessage->created_at : null
                    ]);
                    
                    // Only apply throttle if user has sent a message recently
                    if ($lastMessage) {
                        // Calculate time elapsed since last message (use absolute value to handle timezone issues)
                        $secondsSinceLastMessage = abs(now()->diffInSeconds($lastMessage->created_at, false));
                        
                        Log::info('Time check', [
                            'seconds_since_last' => $secondsSinceLastMessage,
                            'throttle_seconds' => $throttleSeconds,
                            'should_throttle' => $secondsSinceLastMessage < $throttleSeconds
                        ]);
                        
                        if ($secondsSinceLastMessage < $throttleSeconds) {
                            // User is sending too fast, apply throttle
                            $remainingSeconds = $throttleSeconds - $secondsSinceLastMessage;
                            
                            Log::warning('THROTTLE APPLIED', [
                                'user_id' => Auth::id(),
                                'remaining_seconds' => $remainingSeconds
                            ]);
                            
                            return response()->json([
                                'success' => false,
                                'message' => "Vui lòng đợi {$remainingSeconds} giây trước khi gửi tin nhắn tiếp theo",
                                'remaining_seconds' => $remainingSeconds,
                                'throttle_enabled' => true
                            ], 429); // 429 Too Many Requests
                        } else {
                            Log::info('Throttle passed - enough time elapsed');
                        }
                        // If secondsSinceLastMessage >= throttleSeconds, allow sending (no throttle)
                    } else {
                        Log::info('No last message found - first message or old messages, allow sending');
                    }
                    // If no lastMessage found (first message or old messages), allow sending
                }
            }
            
            skipThrottle:

            $request->validate([
                'message' => 'required|string|max:500',
                'live_setting_id' => 'nullable|exists:live_settings,id'
            ]);

            $messageContent = trim($request->input('message'));
            $liveSettingId = $request->input('live_setting_id');

            // Check if live stream has started
            if ($liveSettingId) {
                $liveSetting = LiveSetting::find($liveSettingId);
                if ($liveSetting) {
                    $liveStartTime = \Carbon\Carbon::parse(
                        $liveSetting->live_date->format('Y-m-d') . ' ' . 
                        $liveSetting->live_time->format('H:i:s')
                    );
                    
                    if (now()->lt($liveStartTime)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Chat chỉ được phép khi live stream đã bắt đầu'
                        ], 403);
                    }
                }
            }

            // Check for blocked keywords
            $filterResult = $this->keywordFilterService->filterMessage($messageContent);

            $chatMessage = ChatMessage::create([
                'username' => $user->name ?? $user->account,
                'message' => $messageContent,
                'user_id' => Auth::id(),
                'live_setting_id' => $liveSettingId,
                'is_blocked' => $filterResult['is_blocked'],
                'blocked_keywords' => $filterResult['blocked_keywords'],
                'sent_at' => now()
            ]);

            // Only broadcast if message is not blocked
            if (!$filterResult['is_blocked']) {
                // Broadcast the message to all connected clients
                broadcast(new NewChatMessage($chatMessage))->toOthers();

                return response()->json([
                    'success' => true,
                    'message' => 'Tin nhắn đã được gửi',
                    'chat_message' => $chatMessage
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tin nhắn chứa từ khóa không được phép: ' . implode(', ', $filterResult['blocked_keywords'])
                ], 400);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tin nhắn không hợp lệ: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error sending chat message', [
                'user_id' => Auth::id(),
                'message' => $request->input('message'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi tin nhắn'
            ], 500);
        }
    }

    /**
     * Get online users count
     */
    public function getOnlineCount(): JsonResponse
    {
        try {
            // This would typically use Redis or another cache system
            // For now, we'll return a mock count
            $count = rand(50, 200);

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'count' => 0
            ]);
        }
    }

    /**
     * Get chat settings (throttle info)
     */
    public function getSettings(): JsonResponse
    {
        try {
            $throttleEnabled = \App\Models\ChatSetting::isThrottleEnabled();
            $throttleSeconds = \App\Models\ChatSetting::getThrottleSeconds();
            
            // Check if current user bypasses throttle
            $bypassThrottle = false;
            if (Auth::check()) {
                $user = Auth::user();
                $bypassThrottle = $user->hasRole('Admin') || $user->hasRole('Nhân viên Live');
            }

            return response()->json([
                'success' => true,
                'throttle_enabled' => $throttleEnabled && !$bypassThrottle,
                'throttle_seconds' => $throttleSeconds,
                'bypass_throttle' => $bypassThrottle
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'throttle_enabled' => false,
                'throttle_seconds' => 0,
                'bypass_throttle' => true
            ]);
        }
    }
}
