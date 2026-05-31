<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Services\LtvMultiplierService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PredictiveController extends Controller
{
    public function __construct(
        private LtvMultiplierService $ltvService,
    ) {}

    public function index()
    {
        return view('admin.predictive.index');
    }

    public function data(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $bookings = Booking::where('created_at', '>=', now()->subDays($days))
            ->select('id', 'customer_name', 'customer_email', 'total_amount', 'created_at')
            ->where('status', '!=', 'cancelled')
            ->take(200)
            ->get();

        $segments = ['b2b' => 0, 'b2c' => 0, 'one_time' => 0];
        $totalLtv = 0;
        $segmentedBookings = [];

        foreach ($bookings as $booking) {
            $aov = (float) $booking->total_amount;
            $prediction = $this->ltvService->predictLtv($aov);
            $segment = $prediction['segment'];

            $segments[$segment]++;
            $totalLtv += $prediction['ltv_365d'];

            $segmentedBookings[] = [
                'id' => $booking->id,
                'email' => $booking->customer_email,
                'aov' => $aov,
                'ltv_30d' => $prediction['ltv_30d'],
                'ltv_365d' => $prediction['ltv_365d'],
                'segment' => $segment,
            ];
        }

        return response()->json([
            'segments' => $segments,
            'total_ltv_365d' => round($totalLtv, 2),
            'total_bookings' => $bookings->count(),
            'average_ltv' => $bookings->count() > 0 ? round($totalLtv / $bookings->count(), 2) : 0,
            'bookings' => $segmentedBookings,
        ]);
    }
}
