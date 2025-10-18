<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ChatSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("chat_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, $value, string $description = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description ?? self::where('key', $key)->value('description'),
            ]
        );

        // Clear cache
        Cache::forget("chat_setting_{$key}");

        return $setting;
    }

    /**
     * Get message throttle seconds
     */
    public static function getThrottleSeconds(): int
    {
        return (int) self::get('message_throttle_seconds', 10);
    }

    /**
     * Check if throttle is enabled
     */
    public static function isThrottleEnabled(): bool
    {
        return (bool) self::get('throttle_enabled', true);
    }
}
