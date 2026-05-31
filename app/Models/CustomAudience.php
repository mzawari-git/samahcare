<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomAudience extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'platform',
        'platform_audience_id',
        'source_type',
        'seed_source',
        'audience_size',
        'lookalike_ratio',
        'country',
        'status',
        'fatigue_score',
        'last_synced_at',
        'performance_ctr',
        'performance_cpa',
        'performance_roas',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'lookalike_ratio' => 'decimal:1',
        'audience_size' => 'integer',
        'fatigue_score' => 'integer',
        'performance_ctr' => 'decimal:2',
        'performance_cpa' => 'decimal:2',
        'performance_roas' => 'decimal:2',
    ];

    public function insights()
    {
        return $this->hasMany(AudienceInsight::class, 'audience_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'ready' => 'success',
            'syncing' => 'info',
            'draft' => 'secondary',
            'fatigued' => 'warning',
            'error' => 'danger',
            default => 'secondary',
        };
    }

    public function getFatigueColorAttribute(): string
    {
        return match (true) {
            $this->fatigue_score >= 70 => 'danger',
            $this->fatigue_score >= 40 => 'warning',
            default => 'success',
        };
    }
}
