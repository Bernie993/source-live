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
        $liveSetting = LiveSetting::where('is_active', true)->first();
        $stats = [
            'keywords_created' => Keyword::where('created_by', auth()->id())->count(),
            'active_keywords' => Keyword::where('created_by', auth()->id())->where('is_active', true)->count(),
            'total_chat_messages' => ChatMessage::count(),
            'blocked_messages' => ChatMessage::where('is_blocked', true)->count(),
        ];

        return view('live-staff.dashboard', compact('liveSetting', 'stats'));
    }
}
