<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingSetting extends Model
{
    protected $table = 'marketing_settings';

    protected $fillable = [
        'key', 'value', 'group', 'type', 'options', 'description',
        'is_translatable', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'value' => 'json',
        'options' => 'json',
        'is_translatable' => 'boolean',
    ];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting || $setting->value === null) return $default;
        $decoded = json_decode($setting->value, true);
        return $decoded ?? $setting->value;
    }

    public static function set($key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => json_encode($value, JSON_UNESCAPED_UNICODE)]
        );
    }

    public static function setValue($key, $value, $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => json_encode($value, JSON_UNESCAPED_UNICODE), 'group' => $group]
        );
    }

    public static function getAllTrackingSettings(): array
    {
        return [
            'facebook' => [
                'enabled' => (bool) static::get('facebook_pixel_enabled', false),
                'pixel_id' => static::get('facebook_pixel_id'),
                'capi_enabled' => (bool) static::get('facebook_capi_enabled', false),
                'access_token' => static::get('facebook_access_token'),
                'test_event_code' => static::get('facebook_test_event_code'),
            ],
            'tiktok' => [
                'enabled' => (bool) static::get('tiktok_pixel_enabled', false),
                'pixel_id' => static::get('tiktok_pixel_id'),
                'capi_enabled' => (bool) static::get('tiktok_capi_enabled', false),
                'access_token' => static::get('tiktok_access_token'),
            ],
            'test_mode' => (bool) static::get('tracking_test_mode', false),
        ];
    }

    public static function getMarketingDefaults(): array
    {
        return [
            'facebook_pixel_enabled' => false,
            'facebook_capi_enabled' => false,
            'tiktok_pixel_enabled' => false,
            'tiktok_capi_enabled' => false,
            'tracking_enabled' => true,
            'tracking_test_mode' => false,
            'tracking_async_mode' => true,
        ];
    }

    public static function saveFacebookSettings(array $data): void
    {
        $keys = ['facebook_pixel_enabled', 'facebook_pixel_id', 'facebook_capi_enabled', 'facebook_access_token', 'facebook_test_event_code'];
        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                static::setValue($key, $data[$key], 'facebook');
            }
        }
    }

    public static function saveTikTokSettings(array $data): void
    {
        $keys = ['tiktok_pixel_enabled', 'tiktok_pixel_id', 'tiktok_capi_enabled', 'tiktok_access_token'];
        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                static::setValue($key, $data[$key], 'tiktok');
            }
        }
    }

    public static function isFacebookPixelEnabled(): bool { return (bool) static::get('facebook_pixel_enabled', false); }
    public static function isFacebookCAPIEnabled(): bool { return (bool) static::get('facebook_capi_enabled', false); }
    public static function getFacebookPixelId(): ?string { return static::get('facebook_pixel_id'); }
    public static function getFacebookAccessToken(): ?string { return static::get('facebook_access_token'); }

    public static function isTikTokPixelEnabled(): bool { return (bool) static::get('tiktok_pixel_enabled', false); }
    public static function isTikTokCAPIEnabled(): bool { return (bool) static::get('tiktok_capi_enabled', false); }
    public static function getTikTokPixelId(): ?string { return static::get('tiktok_pixel_id'); }
    public static function getTikTokAccessToken(): ?string { return static::get('tiktok_access_token'); }

    public static function isTrackingEnabled(): bool { return (bool) static::get('tracking_enabled', true); }
    public static function isTestMode(): bool { return (bool) static::get('tracking_test_mode', false); }
}
