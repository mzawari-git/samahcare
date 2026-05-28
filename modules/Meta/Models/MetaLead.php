<?php

namespace Modules\Meta\Models;

use Illuminate\Database\Eloquent\Model;

class MetaLead extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'source', 'campaign_id', 'ad_id', 'event_id', 'event_name', 'data'];
    protected $casts = ['data' => 'array'];
}

class MetaWebhookLog extends Model
{
    protected $fillable = ['event_type', 'payload', 'response', 'status', 'processed_at'];
    protected $casts = ['payload' => 'array', 'response' => 'array'];
}