<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LiveSetting;
use App\Models\Keyword;
use App\Models\ChatMessage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::whereHas('roles', function($q) {
                $q->where('name', 'Admin');
            })->count(),
            'live_staff' => User::whereHas('roles', function($q) {
                $q->where('name', 'Nhân viên Live');
            })->count(),
            'cskh_staff' => User::whereHas('roles', function($q) {
                $q->where('name', 'CSKH');
            })->count(),
            'external_users' => User::where('user_type', 'external_login')->count(),
            'active_keywords' => Keyword::where('is_active', true)->count(),
            'total_chat_messages' => ChatMessage::count(),
            'blocked_messages' => ChatMessage::where('is_blocked', true)->count(),
            'live_settings' => LiveSetting::where('is_active', true)->first()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
