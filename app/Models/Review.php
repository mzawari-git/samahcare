<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'service_id',
        'rating', 'title', 'content',
        'pros', 'cons',
        'is_approved', 'is_verified_purchase',
    ];

    protected $casts = [
        'pros' => 'array',
        'cons' => 'array',
        'is_approved' => 'boolean',
        'is_verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
