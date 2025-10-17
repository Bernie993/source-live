<?php

namespace App\Http\Controllers;

use App\Models\LiveSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class LiveStreamController extends Controller
{
    /**
     * Get current stream status and URL
     */
    public function getStreamStatus(): JsonResponse
    {
        try {
            $liveSetting = LiveSetting::where('is_active', true)->first();
            
            if (!$liveSetting) {
                return response()->json([
                    'success' => true,
                    'is_live' => false,
                    'stream_url' => null,
                    'video_url' => $this->getDefaultVideoUrl(),
                    'message' => 'Chưa có lịch live'
                ]);
            }

            $now = now();
            $isLiveTime = $this->isLiveTime($liveSetting, $now);
            
            if ($isLiveTime) {
                return response()->json([
                    'success' => true,
                    'is_live' => true,
                    'stream_url' => $liveSetting->play_url,
                    'video_url' => null,
                    'live_title' => 'ĐANG LIVE',
                    'message' => 'Đang phát trực tiếp'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'is_live' => false,
                    'stream_url' => null,
                    'video_url' => $this->getDefaultVideoUrl(),
                    'next_live' => $this->getNextLiveTime($liveSetting),
                    'message' => 'Chưa đến giờ live'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error getting stream status', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'is_live' => false,
                'stream_url' => null,
                'video_url' => $this->getDefaultVideoUrl(),
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    /**
     * Check if current time is within live time
     */
    private function isLiveTime(LiveSetting $liveSetting, Carbon $now): bool
    {
        if (!$liveSetting->live_date || !$liveSetting->live_time) {
            return false;
        }

        try {
            // Create datetime from live_date and live_time
            $liveDateTime = $liveSetting->live_date->copy()->setTimeFromTimeString(
                $liveSetting->live_time->format('H:i:s')
            );
            
            // Live is considered active from 30 minutes before live_time to live_time + 4 hours
            $liveStartTime = $liveDateTime->copy()->subMinutes(30);
            $liveEndTime = $liveDateTime->copy()->addHours(4);
            
            Log::info('Live time check', [
                'current_time' => $now->toDateTimeString(),
                'live_start_time' => $liveStartTime->toDateTimeString(),
                'live_end_time' => $liveEndTime->toDateTimeString(),
                'is_live' => $now->gte($liveStartTime) && $now->lte($liveEndTime)
            ]);
            
            return $now->gte($liveStartTime) && $now->lte($liveEndTime);
            
        } catch (\Exception $e) {
            Log::error('Error checking live time', [
                'live_date' => $liveSetting->live_date,
                'live_time' => $liveSetting->live_time,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get next live time formatted
     */
    private function getNextLiveTime(LiveSetting $liveSetting): ?array
    {
        if (!$liveSetting->live_date || !$liveSetting->live_time) {
            return null;
        }

        try {
            $liveDateTime = $liveSetting->live_date->copy()->setTimeFromTimeString(
                $liveSetting->live_time->format('H:i:s')
            );
            
            return [
                'date' => $liveDateTime->format('d/m/Y'),
                'time' => $liveDateTime->format('H:i'),
                'datetime' => $liveDateTime->toISOString()
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get default video URL when not live
     */
    private function getDefaultVideoUrl(): string
    {
        // First try to get from active live setting
        $liveSetting = LiveSetting::where('is_active', true)->first();
        
        if ($liveSetting && $liveSetting->default_video_url) {
            return $liveSetting->default_video_url;
        }
        
        // Fallback to config or hardcoded URL
        return config('app.default_video_url', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4');
    }

    /**
     * Update viewer count (this would typically use WebSocket or Server-Sent Events)
     */
    public function updateViewerCount(): JsonResponse
    {
        try {
            // Mock viewer count - in production, this would track real viewers
            $count = rand(50, 500);
            
            return response()->json([
                'success' => true,
                'viewer_count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'viewer_count' => 0
            ]);
        }
    }

    /**
     * Get all live streams with schedule information
     */
    public function getAllLiveStreams(): JsonResponse
    {
        try {
            $now = now();
            
            // Get all active live settings, ordered by live date/time
            $liveSettings = LiveSetting::with('assignedUser')
                ->where('is_active', true)
                ->whereNotNull('live_date')
                ->whereNotNull('live_time')
                ->orderBy('live_date')
                ->orderBy('live_time')
                ->get()
                ->map(function ($live) use ($now) {
                    $liveDateTime = $live->live_date->copy()->setTimeFromTimeString(
                        $live->live_time->format('H:i:s')
                    );
                    
                    // Check if live is happening now (from scheduled time to 4 hours after)
                    // KHÔNG trừ 30 phút nữa - chỉ tính từ đúng giờ live
                    $liveStartTime = $liveDateTime->copy(); // Bắt đầu từ ĐÚNG giờ
                    $liveEndTime = $liveDateTime->copy()->addHours(4);
                    $isLiveNow = $now->gte($liveStartTime) && $now->lte($liveEndTime);
                    
                    // Calculate time until live starts
                    $minutesUntilLive = $now->diffInMinutes($liveDateTime, false);
                    
                    return [
                        'id' => $live->id,
                        'title' => $live->live_title ?? 'Live Stream',
                        'description' => $live->live_description,
                        'live_date' => $liveDateTime->format('d/m/Y'),
                        'live_time' => $liveDateTime->format('H:i'),
                        'live_datetime' => $liveDateTime->toISOString(),
                        'is_live_now' => $isLiveNow,
                        'minutes_until_live' => $minutesUntilLive,
                        'play_url' => $live->play_url,
                        'default_video_url' => $live->default_video_url,
                        'host' => $live->assignedUser ? [
                            'id' => $live->assignedUser->id,
                            'name' => $live->assignedUser->name,
                            'avatar' => $live->assignedUser->avatar ?? null,
                        ] : null,
                    ];
                })
                ->filter(function ($live) use ($now) {
                    // Only show lives that haven't ended yet
                    return $live['minutes_until_live'] > -240; // -240 min = 4 hours ago
                });
            
            // Find the main live (currently live or next upcoming)
            $mainLive = $liveSettings->first(function ($live) {
                return $live['is_live_now'];
            }) ?? $liveSettings->first();
            
            // Get 3 other upcoming lives
            $otherLives = $liveSettings->filter(function ($live) use ($mainLive) {
                return $mainLive && $live['id'] !== $mainLive['id'];
            })->take(3)->values();
            
            return response()->json([
                'success' => true,
                'main_live' => $mainLive,
                'other_lives' => $otherLives,
                'total_count' => $liveSettings->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getting all live streams', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'main_live' => null,
                'other_lives' => [],
                'error' => 'Có lỗi xảy ra khi tải danh sách live'
            ], 500);
        }
    }

    /**
     * Track viewer for specific live stream
     */
    public function trackViewer(Request $request, $id): JsonResponse
    {
        try {
            // Validate live exists
            $live = LiveSetting::find($id);
            if (!$live) {
                return response()->json([
                    'success' => false,
                    'message' => 'Live not found'
                ], 404);
            }

            // Get unique session/user identifier
            $sessionId = session()->getId();
            $cacheKey = "live_viewers_{$id}";
            $viewerKey = "live_viewer_{$id}_{$sessionId}";
            
            // Get current viewers set from cache
            $viewers = Cache::get($cacheKey, []);
            
            // Add this viewer with timestamp
            $viewers[$sessionId] = now()->timestamp;
            
            // Clean up old viewers (inactive for more than 30 seconds)
            $currentTime = now()->timestamp;
            $viewers = array_filter($viewers, function($timestamp) use ($currentTime) {
                return ($currentTime - $timestamp) < 30;
            });
            
            // Store updated viewers list (expire in 60 seconds)
            Cache::put($cacheKey, $viewers, 60);
            
            // Store individual viewer timestamp (expire in 30 seconds)
            Cache::put($viewerKey, now()->timestamp, 30);
            
            $viewerCount = count($viewers);
            
            Log::info("Viewer tracked for live {$id}", [
                'session_id' => $sessionId,
                'viewer_count' => $viewerCount
            ]);
            
            return response()->json([
                'success' => true,
                'viewer_count' => $viewerCount,
                'session_id' => $sessionId
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error tracking viewer', [
                'live_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'viewer_count' => 0,
                'message' => 'Error tracking viewer'
            ], 500);
        }
    }

    /**
     * Mark viewer as left
     */
    public function viewerLeave(Request $request, $id): JsonResponse
    {
        try {
            $sessionId = session()->getId();
            $cacheKey = "live_viewers_{$id}";
            $viewerKey = "live_viewer_{$id}_{$sessionId}";
            
            // Remove viewer from the set
            $viewers = Cache::get($cacheKey, []);
            unset($viewers[$sessionId]);
            
            // Update cache
            Cache::put($cacheKey, $viewers, 60);
            Cache::forget($viewerKey);
            
            Log::info("Viewer left live {$id}", [
                'session_id' => $sessionId,
                'remaining_viewers' => count($viewers)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Viewer removed'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error removing viewer', [
                'live_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error removing viewer'
            ], 500);
        }
    }
}
