<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\LiveSetting;

class StreamController extends Controller
{
    /**
     * Hiển thị trang quản lý stream
     */
    public function index()
    {
        $liveSettings = LiveSetting::first();
        return view('admin.stream.index', compact('liveSettings'));
    }

    /**
     * Bắt đầu stream từ file video
     */
    public function startFileStream(Request $request)
    {
        $request->validate([
            'video_file' => 'required|file|mimes:mp4,avi,mov,mkv|max:1048576', // 1GB
            'quality' => 'in:low,medium,high',
            'duration' => 'nullable|integer|min:1|max:3600'
        ]);

        try {
            // Lưu file video
            $videoPath = $request->file('video_file')->store('streams', 'public');
            $fullPath = storage_path('app/public/' . $videoPath);

            // Lấy cấu hình stream
            $liveSettings = LiveSetting::first();
            $streamUrl = $this->buildStreamUrl($liveSettings);

            // Tạo command FFmpeg
            $command = $this->buildFFmpegCommand([
                'type' => 'file',
                'input' => $fullPath,
                'stream_url' => $streamUrl,
                'quality' => $request->quality ?? 'medium',
                'duration' => $request->duration
            ]);

            // Chạy FFmpeg trong background
            $process = Process::start($command);
            
            // Lưu thông tin process
            $processInfo = [
                'pid' => $process->id(),
                'command' => $command,
                'type' => 'file',
                'input' => $videoPath,
                'started_at' => now(),
                'status' => 'running'
            ];

            Storage::put('stream_process.json', json_encode($processInfo));

            Log::info('Stream started', $processInfo);

            return response()->json([
                'success' => true,
                'message' => 'Stream đã bắt đầu thành công',
                'process_id' => $process->id(),
                'stream_url' => $streamUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Stream start failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi bắt đầu stream: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bắt đầu test stream
     */
    public function startTestStream(Request $request)
    {
        $request->validate([
            'duration' => 'required|integer|min:10|max:3600',
            'quality' => 'in:low,medium,high'
        ]);

        try {
            $liveSettings = LiveSetting::first();
            $streamUrl = $this->buildStreamUrl($liveSettings);

            $command = $this->buildFFmpegCommand([
                'type' => 'test',
                'stream_url' => $streamUrl,
                'quality' => $request->quality ?? 'medium',
                'duration' => $request->duration
            ]);

            $process = Process::start($command);
            
            $processInfo = [
                'pid' => $process->id(),
                'command' => $command,
                'type' => 'test',
                'duration' => $request->duration,
                'started_at' => now(),
                'status' => 'running'
            ];

            Storage::put('stream_process.json', json_encode($processInfo));

            Log::info('Test stream started', $processInfo);

            return response()->json([
                'success' => true,
                'message' => 'Test stream đã bắt đầu thành công',
                'process_id' => $process->id(),
                'duration' => $request->duration,
                'stream_url' => $streamUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Test stream start failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi bắt đầu test stream: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dừng stream
     */
    public function stopStream()
    {
        try {
            if (!Storage::exists('stream_process.json')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có stream nào đang chạy'
                ]);
            }

            $processInfo = json_decode(Storage::get('stream_process.json'), true);
            $pid = $processInfo['pid'];

            // Dừng process
            if ($this->isProcessRunning($pid)) {
                exec("kill -TERM $pid");
                sleep(2);
                
                if ($this->isProcessRunning($pid)) {
                    exec("kill -KILL $pid");
                }
            }

            // Xóa file process info
            Storage::delete('stream_process.json');

            Log::info('Stream stopped', ['pid' => $pid]);

            return response()->json([
                'success' => true,
                'message' => 'Stream đã được dừng thành công'
            ]);

        } catch (\Exception $e) {
            Log::error('Stream stop failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi dừng stream: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy trạng thái stream
     */
    public function getStreamStatus()
    {
        try {
            if (!Storage::exists('stream_process.json')) {
                return response()->json([
                    'status' => 'stopped',
                    'message' => 'Không có stream nào đang chạy'
                ]);
            }

            $processInfo = json_decode(Storage::get('stream_process.json'), true);
            $pid = $processInfo['pid'];

            $isRunning = $this->isProcessRunning($pid);

            if (!$isRunning) {
                Storage::delete('stream_process.json');
                $processInfo['status'] = 'stopped';
            }

            return response()->json([
                'status' => $isRunning ? 'running' : 'stopped',
                'process_info' => $processInfo,
                'uptime' => $isRunning ? now()->diffInSeconds($processInfo['started_at']) : 0
            ]);

        } catch (\Exception $e) {
            Log::error('Get stream status failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi khi lấy trạng thái stream: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test kết nối stream
     */
    public function testConnection()
    {
        try {
            $liveSettings = LiveSetting::first();
            
            if (!$liveSettings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chưa cấu hình thông tin stream'
                ]);
            }

            $streamUrl = $this->buildStreamUrl($liveSettings);
            
            // Parse URL để test
            $parsedUrl = parse_url($streamUrl);
            $host = $parsedUrl['host'];
            $port = $parsedUrl['port'] ?? 1935;

            // Test kết nối
            $connection = @fsockopen($host, $port, $errno, $errstr, 10);
            
            if ($connection) {
                fclose($connection);
                $connectionStatus = true;
                $connectionMessage = 'Kết nối thành công';
            } else {
                $connectionStatus = false;
                $connectionMessage = "Không thể kết nối: $errstr ($errno)";
            }

            return response()->json([
                'success' => true,
                'connection_status' => $connectionStatus,
                'connection_message' => $connectionMessage,
                'stream_url' => $streamUrl,
                'host' => $host,
                'port' => $port
            ]);

        } catch (\Exception $e) {
            Log::error('Test connection failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi test kết nối: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xây dựng URL stream từ cấu hình
     */
    private function buildStreamUrl($liveSettings)
    {
        if (!$liveSettings) {
            throw new \Exception('Chưa cấu hình thông tin stream');
        }

        // Sử dụng URL từ database hoặc URL mặc định
        $baseUrl = $liveSettings->stream_url ?? 'rtmp://push.u888live.club/live/u888';
        $secret = $liveSettings->stream_secret ?? 'e0d4b77a6552738e91b4fd2f8c39419d';
        $time = $liveSettings->stream_time ?? '70B2684D';

        return $baseUrl . "?txSecret=$secret&txTime=$time";
    }

    /**
     * Xây dựng command FFmpeg
     */
    private function buildFFmpegCommand($options)
    {
        $quality = $this->getQualitySettings($options['quality']);
        $command = ['ffmpeg'];

        switch ($options['type']) {
            case 'file':
                $command = array_merge($command, [
                    '-re', '-i', $options['input']
                ]);
                break;

            case 'test':
                $duration = $options['duration'] ?? 30;
                $command = array_merge($command, [
                    '-f', 'lavfi', '-i', "testsrc=duration=$duration:size={$quality['resolution']}:rate={$quality['fps']}",
                    '-f', 'lavfi', '-i', "sine=frequency=1000:duration=$duration"
                ]);
                break;
        }

        // Thêm duration nếu có
        if (isset($options['duration']) && $options['type'] !== 'test') {
            $command = array_merge($command, ['-t', $options['duration']]);
        }

        // Cấu hình video
        $command = array_merge($command, [
            '-c:v', 'libx264',
            '-preset', 'veryfast',
            '-tune', 'zerolatency',
            '-b:v', $quality['video_bitrate'],
            '-maxrate', $quality['video_bitrate'],
            '-bufsize', $quality['buffer_size'],
            '-vf', "scale={$quality['resolution']}",
            '-r', $quality['fps']
        ]);

        // Cấu hình audio
        $command = array_merge($command, [
            '-c:a', 'aac',
            '-b:a', $quality['audio_bitrate'],
            '-ar', '44100'
        ]);

        // Output
        $command = array_merge($command, [
            '-f', 'flv',
            $options['stream_url']
        ]);

        return $command;
    }

    /**
     * Lấy cấu hình chất lượng
     */
    private function getQualitySettings($quality)
    {
        $settings = [
            'low' => [
                'video_bitrate' => '500k',
                'audio_bitrate' => '64k',
                'resolution' => '640x480',
                'fps' => '15',
                'buffer_size' => '1000k'
            ],
            'medium' => [
                'video_bitrate' => '1500k',
                'audio_bitrate' => '128k',
                'resolution' => '1280x720',
                'fps' => '25',
                'buffer_size' => '3000k'
            ],
            'high' => [
                'video_bitrate' => '3000k',
                'audio_bitrate' => '192k',
                'resolution' => '1920x1080',
                'fps' => '30',
                'buffer_size' => '6000k'
            ]
        ];

        return $settings[$quality] ?? $settings['medium'];
    }

    /**
     * Kiểm tra process có đang chạy không
     */
    private function isProcessRunning($pid)
    {
        return file_exists("/proc/$pid");
    }
}
