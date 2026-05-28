<?php

namespace Modules\B2B\Models;

use Illuminate\Database\Eloquent\Model;

class RFQ extends Model
{
    protected $fillable = ['company_id', 'subject', 'details', 'status', 'expected_date', 'budget'];
    protected $casts = ['budget' => 'float'];
}