<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'username',
        'message',
        'user_id',
        'live_setting_id',
        'is_blocked',
        'blocked_keywords',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'is_blocked' => 'boolean',
            'blocked_keywords' => 'json',
            'sent_at' => 'datetime',
        ];
    }

    /**
     * Get the live setting this chat belongs to
     */
    public function liveSetting()
    {
        return $this->belongsTo(LiveSetting::class);
    }

    /**
     * Get the user who sent this message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get non-blocked messages
     */
    public function scopeNotBlocked($query)
    {
        return $query->where('is_blocked', false);
    }

    /**
     * Scope to get blocked messages
     */
    public function scopeBlocked($query)
    {
        return $query->where('is_blocked', true);
    }

    /**
     * Scope to filter by live setting
     */
    public function scopeForLiveSetting($query, $liveSettingId)
    {
        return $query->where('live_setting_id', $liveSettingId);
    }
}
