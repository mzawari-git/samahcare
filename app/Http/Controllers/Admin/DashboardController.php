<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::count();

        $todayBookings = Booking::whereDate('created_at', today())->count();
        $todayRevenue = Booking::whereDate('created_at', today())->where('status', '!=', 'cancelled')->sum('total_amount');

        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        $recentBookings = Booking::with('service')->latest()->take(10)->get();

        $chartData = $this->getChartData();
        $analytics = $this->getAnalyticsData();

        return view('admin.dashboard', compact(
            'totalBookings', 'totalRevenue', 'totalCustomers', 'totalServices',
            'todayBookings', 'todayRevenue',
            'pendingBookings', 'confirmedBookings', 'completedBookings', 'cancelledBookings',
            'recentBookings', 'chartData', 'analytics'
        ));
    }

    private function getChartData(): array
    {
        $last30Days = collect(range(0, 29))->map(function ($days) {
            return Carbon::now()->subDays($days)->format('Y-m-d');
        })->reverse()->values();

        $dailyRevenue = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $dailyBookings = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $revenueData = $last30Days->map(fn($date) => $dailyRevenue[$date] ?? 0);
        $bookingsData = $last30Days->map(fn($date) => $dailyBookings[$date] ?? 0);

        $weekDays = $last30Days->map(fn($date) => Carbon::parse($date)->format('d/m'));

        $statusDistribution = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        $paymentMethods = Booking::select('payment_method', DB::raw('COUNT(*) as count'))
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method');

        $serviceBookings = Booking::select(
            'services.name_ar as service',
            DB::raw('COUNT(*) as total_booked')
        )
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->where('bookings.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('services.id', 'services.name_ar')
            ->orderByDesc('total_booked')
            ->limit(6)
            ->pluck('total_booked', 'service');

        return [
            'labels' => $weekDays,
            'revenue' => $revenueData,
            'bookings' => $bookingsData,
            'status' => $statusDistribution,
            'paymentMethods' => $paymentMethods,
            'serviceBookings' => $serviceBookings,
        ];
    }

    private function getAnalyticsData(): array
    {
        $lastWeekRevenue = Booking::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->sum('total_amount');

        $previousWeekRevenue = Booking::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()->subDays(7)])
            ->sum('total_amount');

        $revenueGrowth = $previousWeekRevenue > 0
            ? round((($lastWeekRevenue - $previousWeekRevenue) / $previousWeekRevenue) * 100, 1)
            : 0;

        $avgBookingValue = Booking::where('status', '!=', 'cancelled')
            ->avg('total_amount') ?? 0;

        $newCustomers = User::where('role', 'customer')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $returningCustomers = Booking::select('customer_phone')
            ->where('status', '!=', 'cancelled')
            ->whereNotNull('customer_phone')
            ->groupBy('customer_phone')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        return [
            'revenueGrowth' => $revenueGrowth,
            'avgBookingValue' => round($avgBookingValue, 2),
            'newCustomers' => $newCustomers,
            'returningCustomers' => $returningCustomers,
            'topCities' => collect([]),
        ];
    }
}
