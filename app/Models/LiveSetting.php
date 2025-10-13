<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSetting extends Model
{
    protected $fillable = [
        'live_url',
        'play_url',
        'live_date',
        'live_time',
        'is_active',
        'default_video_url',
        'live_title',
        'live_description',
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
     * Check if live is accessible (30 minutes before live time)
     */
    public function isAccessible(): bool
    {
        if (!$this->live_date || !$this->live_time || !$this->is_active) {
            return false;
        }

        try {
            $liveDateTime = $this->live_date->copy()->setTimeFromTimeString($this->live_time->format('H:i:s'));
            $accessTime = $liveDateTime->copy()->subMinutes(30);
            
            return now()->gte($accessTime) && now()->lte($liveDateTime);
        } catch (\Exception $e) {
            return false;
        }
    }
}
