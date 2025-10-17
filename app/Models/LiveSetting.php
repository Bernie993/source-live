<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSetting extends Model
{
    protected $fillable = [
        'live_url',
        'play_url_flv',
        'play_url_m3u8',
        'live_date',
        'live_time',
        'is_active',
        'default_video_url',
        'live_title',
        'live_description',
        'assigned_to',
    ];

    protected function casts(): array
    {
        return [
            'live_date' => 'date',
            'live_time' => 'datetime:H:i:s',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user assigned to this live setting
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Check if live is accessible (30 minutes before live time and during live)
     */
    public function isAccessible(): bool
    {
        if (!$this->live_date || !$this->live_time || !$this->is_active) {
            return false;
        }

        try {
            $liveDateTime = $this->live_date->copy()->setTimeFromTimeString($this->live_time->format('H:i:s'));
            $accessTime = $liveDateTime->copy()->subMinutes(30);
            $endTime = $liveDateTime->copy()->addHours(4); // Live lasts 4 hours
            
            // Accessible from 30 minutes before until 4 hours after
            return now()->gte($accessTime) && now()->lte($endTime);
        } catch (\Exception $e) {
            return false;
        }
    }
}
