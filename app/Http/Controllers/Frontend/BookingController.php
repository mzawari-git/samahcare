<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Coupon;
use App\Models\Affiliate;
use App\Models\AffiliateClick;
use App\Models\AffiliateCommission;
use App\Services\AdvertisingTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $paymentMethods = $this->getActivePaymentMethods($settings);

        return view('frontend.booking.index', compact('services', 'settings', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string',
            'notes' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:50',
            'payment_method' => 'nullable|string|in:cod,bank_transfer,jawwal_pay,reflect',
        ]);

        DB::beginTransaction();
        try {
            $service = Service::findOrFail($request->service_id);
            $totalAmount = $service->final_price;
            $discountAmount = 0;

            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->first();
                if ($coupon) {
                    if ($coupon->type === 'percentage') {
                        $discountAmount = round($totalAmount * ($coupon->value / 100), 2);
                    } else {
                        $discountAmount = min($coupon->value, $totalAmount);
                    }
                    $totalAmount = max(0, $totalAmount - $discountAmount);
                }
            }

            $booking = Booking::create([
                'booking_number' => Booking::generateBookingNumber(),
                'service_id' => $service->id,
                'service_name' => $service->name_ar,
                'service_price' => $service->final_price,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'booking_date' => $request->booking_date,
                'booking_time' => $request->booking_time,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'coupon_code' => $request->coupon_code,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            try {
                $tracking = app(AdvertisingTrackingService::class);
                $userData = array_filter([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'email' => $request->customer_email,
                ]);
                $result = $tracking->trackPurchase($booking, $userData);
                if (!empty($result['event_id'])) {
                    session()->flash('purchase_event_id', $result['event_id']);
                }
            } catch (\Exception $e) {
                Log::error('Failed to track CAPI Purchase event', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }

            try {
                $this->processAffiliateCommission($booking);
            } catch (\Exception $e) {
                Log::error('Failed to process affiliate commission', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return redirect()->route('booking.success', $booking->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'فشل في إنشاء الحجز. يرجى المحاولة مرة أخرى.');
        }
    }

    public function success($id)
    {
        $booking = Booking::findOrFail($id);
        $trackingData = null;

        $purchaseEventId = session('purchase_event_id');
        if ($purchaseEventId) {
            try {
                $tracking = app(AdvertisingTrackingService::class);
                $trackingData = [
                    'event_id' => $purchaseEventId,
                    'pixel_id' => $tracking->getFbPixelId(),
                    'pixel_enabled' => $tracking->isFbPixelEnabled(),
                    'value' => (float) ($booking->total_amount ?? 0),
                    'currency' => 'ILS',
                    'content_name' => $booking->service_name ?? '',
                    'content_id' => (string) ($booking->service_id ?? ''),
                    'content_type' => 'product',
                    'order_id' => $booking->booking_number ?? (string) $booking->id,
                ];
            } catch (\Exception $e) {
                Log::debug('Failed to load tracking data for success page', ['error' => $e->getMessage()]);
            }
        }

        return view('frontend.booking.success', compact('booking', 'trackingData'));
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'كود خصم غير صالح']);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'انتهت صلاحية كود الخصم']);
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['success' => false, 'message' => 'تم استنفاذ عدد استخدامات كود الخصم']);
        }

        if ($request->amount < $coupon->min_order_amount) {
            return response()->json(['success' => false, 'message' => 'الحد الأدنى للطلب لتطبيق الخصم هو ' . number_format($coupon->min_order_amount) . ' ₪']);
        }

        if ($coupon->type === 'percentage') {
            $discount = round($request->amount * ($coupon->value / 100), 2);
        } else {
            $discount = min($coupon->value, $request->amount);
        }

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'message' => 'تم تطبيق الخصم بنجاح',
        ]);
    }

    private function processAffiliateCommission(Booking $booking): void
    {
        $affiliateId = session('affiliate_id');
        $affiliateRef = session('affiliate_ref');

        if (!$affiliateId || !$affiliateRef) {
            return;
        }

        $affiliate = Affiliate::find($affiliateId);
        if (!$affiliate || $affiliate->status !== 'active') {
            return;
        }

        $commissionRate = $affiliate->commission_value ?: 10;
        $commissionAmount = round($booking->total_amount * ($commissionRate / 100), 2);
        $holdUntil = now()->addDays(30);

        AffiliateCommission::create([
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

        $click = AffiliateClick::where('affiliate_id', $affiliate->id)
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

    private function getActivePaymentMethods(array $settings): array
    {
        $methods = [];

        if (($settings['payment_cod_enabled'] ?? '1') == '1') {
            $methods['cod'] = [
                'id' => 'cod',
                'name' => 'الدفع عند الاستلام',
                'description' => 'ادفع نقداً عند الحضور',
                'icon' => 'fa-money-bill-wave',
                'color' => '#10B981',
            ];
        }

        if (($settings['payment_bank_enabled'] ?? '0') == '1') {
            $methods['bank_transfer'] = [
                'id' => 'bank_transfer',
                'name' => 'التحويل البنكي',
                'description' => 'حوّل المبلغ إلى حسابنا البنكي',
                'icon' => 'fa-university',
                'color' => '#3B82F6',
            ];
        }

        if (($settings['payment_jawwal_enabled'] ?? '0') == '1') {
            $methods['jawwal_pay'] = [
                'id' => 'jawwal_pay',
                'name' => 'جوال باي (Jawwal Pay)',
                'description' => 'ادفع عبر محفظة جوال باي',
                'icon' => 'fa-mobile-alt',
                'color' => '#F59E0B',
            ];
        }

        if (($settings['payment_reflect_enabled'] ?? '0') == '1') {
            $methods['reflect'] = [
                'id' => 'reflect',
                'name' => 'ريفلكت (Reflect)',
                'description' => 'ادفع عبر تطبيق Reflect البنكي الرقمي',
                'icon' => 'fa-university',
                'color' => '#0891B2',
            ];
        }

        return $methods;
    }
}
