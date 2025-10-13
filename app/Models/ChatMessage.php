<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'username',
        'message',
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
}
