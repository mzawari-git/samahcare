<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdAutoPauseLog extends Model
{
    protected $table = 'ad_auto_pause_logs';

    protected $fillable = [
        'platform', 'campaign_id', 'campaign_name', 'trigger_type',
        'trigger_value', 'threshold', 'action', 'success',
        'error_message', 'context',
    ];

    protected $casts = [
        'trigger_value' => 'decimal:2',
        'threshold' => 'decimal:2',
        'success' => 'boolean',
        'context' => 'json',
    ];

    public function scopeByPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeByCampaign($query, string $campaignId)
    {
        return $query->where('campaign_id', $campaignId);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    public function scopeSuccessful($query)
    {
        return $query->where('success', true);
    }
}
