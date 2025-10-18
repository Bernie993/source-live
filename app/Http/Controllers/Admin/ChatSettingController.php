<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSetting;
use Illuminate\Http\Request;

class ChatSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin'); // Only admin can access
    }

    /**
     * Show chat settings page
     */
    public function index()
    {
        $settings = ChatSetting::all()->keyBy('key');
        
        return view('admin.chat.settings', compact('settings'));
    }

    /**
     * Update chat settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'message_throttle_seconds' => 'required|integer|min:0|max:300',
            'throttle_enabled' => 'nullable|in:0,1',
        ]);

        ChatSetting::set('message_throttle_seconds', $request->message_throttle_seconds);
        // Checkbox returns null when unchecked, so default to 0
        ChatSetting::set('throttle_enabled', $request->input('throttle_enabled', 0));

        return redirect()->route('admin.chat.settings')
            ->with('success', 'Cài đặt chat đã được cập nhật thành công!');
    }
}
