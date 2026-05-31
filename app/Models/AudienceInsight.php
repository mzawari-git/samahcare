<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudienceInsight extends Model
{
    protected $fillable = [
        'audience_id',
        'date',
        'impressions',
        'clicks',
        'ctr',
        'spend',
        'conversions',
        'cpa',
        'roas',
        'fatigue_indicator',
    ];

    protected $casts = [
        'date' => 'date',
        'impressions' => 'integer',
        'clicks' => 'integer',
        'ctr' => 'decimal:2',
        'spend' => 'decimal:2',
        'conversions' => 'integer',
        'cpa' => 'decimal:2',
        'roas' => 'decimal:2',
        'fatigue_indicator' => 'decimal:1',
    ];

    public function audience()
    {
        return $this->belongsTo(CustomAudience::class, 'audience_id');
    }
}
