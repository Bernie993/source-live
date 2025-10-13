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
}
