<?php

namespace App\Http\Controllers;

use App\Models\LiveSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
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
                    
                    // Check if live is happening now (30 min before to 4 hours after)
                    $liveStartTime = $liveDateTime->copy()->subMinutes(30);
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
}
