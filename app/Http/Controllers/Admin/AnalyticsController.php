<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays((int) $period);
        $endDate = Carbon::now();

        $overview = $this->getOverview($startDate, $endDate);
        $bookingAnalytics = $this->getBookingAnalytics($startDate, $endDate);
        $customerAnalytics = $this->getCustomerAnalytics($startDate, $endDate);

        return view('admin.analytics.index', compact(
            'overview', 'bookingAnalytics', 'customerAnalytics',
            'period', 'startDate', 'endDate'
        ));
    }

    private function getOverview($startDate, $endDate): array
    {
        $bookings = Booking::whereBetween('created_at', [$startDate, $endDate]);
        $previousPeriodBookings = Booking::whereBetween('created_at', [
            $startDate->copy()->subDays($endDate->diffInDays($startDate)),
            $startDate
        ]);

        $revenue = (clone $bookings)->where('status', '!=', 'cancelled')->sum('total_amount');
        $previousRevenue = (clone $previousPeriodBookings)->where('status', '!=', 'cancelled')->sum('total_amount');

        $bookingsCount = (clone $bookings)->count();
        $previousBookingsCount = (clone $previousPeriodBookings)->count();

        $avgBookingValue = $bookingsCount > 0 ? $revenue / $bookingsCount : 0;
        $previousAvgBookingValue = $previousBookingsCount > 0 ? $previousRevenue / $previousBookingsCount : 0;

        return [
            'revenue' => $revenue,
            'revenueGrowth' => $this->calculateGrowth($revenue, $previousRevenue),
            'bookings' => $bookingsCount,
            'bookingsGrowth' => $this->calculateGrowth($bookingsCount, $previousBookingsCount),
            'avgBookingValue' => $avgBookingValue,
            'avgBookingValueGrowth' => $this->calculateGrowth($avgBookingValue, $previousAvgBookingValue),
            'customers' => User::where('role', 'customer')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }

    private function getBookingAnalytics($startDate, $endDate): array
    {
        $topServices = Booking::select(
            'services.id',
            'services.name_ar',
            DB::raw('COUNT(*) as total_bookings'),
            DB::raw('SUM(bookings.total_amount) as total_revenue')
        )
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('services.id', 'services.name_ar')
            ->orderByDesc('total_bookings')
            ->limit(10)
            ->get();

        $dailyBookings = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('COALESCE(SUM(total_amount), 0) as revenue')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'topServices' => $topServices,
            'dailyBookings' => $dailyBookings,
            'totalBookings' => Booking::whereBetween('created_at', [$startDate, $endDate])->count(),
            'totalBookingRevenue' => Booking::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount'),
        ];
    }

    private function getCustomerAnalytics($startDate, $endDate): array
    {
        $newCustomers = User::where('role', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $activeCustomers = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->distinct('customer_phone')
            ->count('customer_phone');

        $topCustomers = Booking::select(
            'customer_name',
            'customer_phone',
            'customer_email',
            DB::raw('COUNT(*) as booking_count'),
            DB::raw('SUM(total_amount) as total_spent'),
            DB::raw('MAX(created_at) as last_booking')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('customer_name', 'customer_phone', 'customer_email')
            ->havingRaw('COUNT(*) > 0')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        return [
            'newCustomers' => $newCustomers,
            'activeCustomers' => $activeCustomers,
            'topCustomers' => $topCustomers,
        ];
    }

    private function calculateGrowth($current, $previous): float
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function export(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays((int) $period);
        $endDate = Carbon::now();

        $data = [
            'overview' => $this->getOverview($startDate, $endDate),
            'topServices' => $this->getBookingAnalytics($startDate, $endDate)['topServices'],
            'customers' => $this->getCustomerAnalytics($startDate, $endDate)['topCustomers'],
        ];

        return response()->json($data);
    }
}
