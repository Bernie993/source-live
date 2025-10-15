<?php

namespace App\Http\Controllers\LiveStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveSetting;
use App\Models\Keyword;
use App\Models\ChatMessage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Nhân viên Live');
    }

    public function index()
    {
        // Get live settings assigned to current user
        $liveSetting = LiveSetting::where('is_active', true)
            ->where('assigned_to', auth()->id())
            ->where('live_date', '>=', now()->startOfDay())
            ->orderBy('live_date')
            ->orderBy('live_time')
            ->first();
        
        // If no assigned live, get any active live
        if (!$liveSetting) {
            $liveSetting = LiveSetting::where('is_active', true)
                ->where('live_date', '>=', now()->startOfDay())
                ->orderBy('live_date')
                ->orderBy('live_time')
                ->first();
        }
        
        $stats = [
            'total_chat_messages' => ChatMessage::count(),
            'blocked_messages' => ChatMessage::where('is_blocked', true)->count(),
        ];

        return view('live-staff.dashboard', compact('liveSetting', 'stats'));
    }
}
