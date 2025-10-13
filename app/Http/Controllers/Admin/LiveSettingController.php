<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveSetting;

class LiveSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage-live-settings');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $liveSettings = LiveSetting::latest()->paginate(10);
        return view('admin.live-settings.index', compact('liveSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.live-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'live_url' => 'required|string',
            'play_url' => 'required|string', 
            'live_date' => 'required|date|after_or_equal:today',
            'live_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'default_video_url' => 'nullable|string|url',
            'live_title' => 'nullable|string|max:255',
            'live_description' => 'nullable|string'
        ]);

        // Deactivate all other live settings if this one is active
        if ($validated['is_active'] ?? false) {
            LiveSetting::where('is_active', true)->update(['is_active' => false]);
        }

        LiveSetting::create($validated);

        return redirect()->route('admin.live-settings.index')
            ->with('success', 'Cài đặt live đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LiveSetting $liveSetting)
    {
        return view('admin.live-settings.show', compact('liveSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LiveSetting $liveSetting)
    {
        return view('admin.live-settings.edit', compact('liveSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LiveSetting $liveSetting)
    {
        $validated = $request->validate([
            'live_url' => 'required|string',
            'play_url' => 'required|string',
            'live_date' => 'required|date|after_or_equal:today',
            'live_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'default_video_url' => 'nullable|string|url',
            'live_title' => 'nullable|string|max:255',
            'live_description' => 'nullable|string'
        ]);

        // Deactivate all other live settings if this one is active
        if ($validated['is_active'] ?? false) {
            LiveSetting::where('id', '!=', $liveSetting->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $liveSetting->update($validated);

        return redirect()->route('admin.live-settings.index')
            ->with('success', 'Cài đặt live đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LiveSetting $liveSetting)
    {
        $liveSetting->delete();

        return redirect()->route('admin.live-settings.index')
            ->with('success', 'Cài đặt live đã được xóa thành công!');
    }
}
