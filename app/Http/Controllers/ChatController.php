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

            $request->validate([
                'message' => 'required|string|max:500',
                'live_setting_id' => 'nullable|exists:live_settings,id'
            ]);

            if (Auth::check()) { $user = Auth::user(); } else { $user = (object) session("external_user"); }
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
}
