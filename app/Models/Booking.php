<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_number', 'service_id', 'service_name', 'service_price',
        'sessions_count',
        'customer_name', 'customer_phone', 'customer_email',
        'booking_date', 'booking_time',
        'total_amount', 'discount_amount', 'coupon_code', 'notes',
        'status', 'payment_status', 'payment_method',
        'admin_notes', 'confirmed_at', 'completed_at', 'cancelled_at',
        'cancellation_reason', 'ip_address', 'source',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'total_amount' => 'float',
        'discount_amount' => 'float',
        'service_price' => 'float',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public static function generateBookingNumber(): string
    {
        return 'BKG-' . date('Ymd') . '-' . str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
