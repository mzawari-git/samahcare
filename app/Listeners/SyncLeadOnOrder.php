<?php

namespace App\Listeners;

use App\Models\Booking;

class SyncLeadOnOrder
{
    public function handle($event): void
    {
        $booking = $event instanceof Booking ? $event : ($event->booking ?? null);

        if (!$booking) {
            return;
        }

        try {
            $this->syncLeadFromBooking($booking);
            $this->processAffiliateCommission($booking);
        } catch (\Exception $e) {
            report($e);
        }
    }

    private function syncLeadFromBooking(Booking $booking): void
    {
        $metaLeadClass = 'Modules\Meta\Models\MetaLead';
        if (!class_exists($metaLeadClass)) {
            return;
        }

        $lead = $metaLeadClass::where('email', $booking->customer_email)
            ->orWhere('phone', $booking->customer_phone)
            ->first();

        if ($lead) {
            $lead->update([
                'stage' => 'customer',
                'lead_score' => max($lead->lead_score, 100),
                'total_interactions' => $lead->total_interactions + 1,
                'last_activity_at' => now(),
                'engagement_type' => 'purchase',
            ]);
        } else {
            $metaLeadClass::create([
                'sender_name' => $booking->customer_name ?? 'Customer',
                'email' => $booking->customer_email,
                'phone' => $booking->customer_phone,
                'source' => 'website',
                'engagement_type' => 'purchase',
                'stage' => 'customer',
                'lead_score' => 100,
                'purchase_probability' => 100,
                'total_interactions' => 1,
                'last_activity_at' => now(),
            ]);
        }
    }

    private function processAffiliateCommission(Booking $booking): void
    {
        $affiliateId = session('affiliate_id');
        $affiliateRef = session('affiliate_ref');

        if (!$affiliateId || !$affiliateRef) {
            return;
        }

        $affiliate = \App\Models\Affiliate::find($affiliateId);
        if (!$affiliate || $affiliate->status !== 'active') {
            return;
        }

        $commissionRate = $affiliate->commission_value ?: 10;
        $commissionAmount = round($booking->total_amount * ($commissionRate / 100), 2);

        $holdUntil = now()->addDays(30);

        \App\Models\AffiliateCommission::create([
            'affiliate_id' => $affiliate->id,
            'order_id' => $booking->id,
            'customer_id' => null,
            'source_type' => 'booking',
            'source_code' => $booking->booking_number,
            'order_amount' => $booking->total_amount,
            'commission_amount' => $commissionAmount,
            'commission_rate' => $commissionRate,
            'status' => 'pending',
            'hold_until' => $holdUntil,
            'notes' => 'Auto-commission from booking #' . $booking->booking_number,
        ]);

        $click = \App\Models\AffiliateClick::where('affiliate_id', $affiliate->id)
            ->where('session_id', session()->getId())
            ->where('converted', false)
            ->latest()
            ->first();

        if ($click) {
            $click->update([
                'converted' => true,
                'converted_at' => now(),
            ]);
        }

        $affiliate->increment('wallet_balance', $commissionAmount);
        $affiliate->increment('total_earned', $commissionAmount);
    }
}
