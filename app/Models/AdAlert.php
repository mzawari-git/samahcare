<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdAlert extends Model
{
    protected $table = 'ad_alerts';

    protected $fillable = [
        'platform', 'type', 'severity', 'title', 'body', 'data',
        'campaign_id', 'acknowledged', 'acknowledged_at', 'resolved_at',
    ];

    protected $casts = [
        'data' => 'json',
        'acknowledged' => 'boolean',
        'acknowledged_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function scopeByPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeBySeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }

    public function scopeUnacknowledged($query)
    {
        return $query->where('acknowledged', false);
    }

    public function scopeUnresolved($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }
}
