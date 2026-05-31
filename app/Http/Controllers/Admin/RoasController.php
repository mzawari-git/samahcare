<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MetaReportingService;
use Illuminate\Http\Request;

class RoasController extends Controller
{
    public function index()
    {
        return view('admin.roas.index');
    }

    public function data(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $reporting = app(MetaReportingService::class);

        $overview = $reporting->getOverview($days);
        $sourceBreakdown = $reporting->getSourceBreakdown($days);
        $rawCampaigns = $reporting->getCampaignPerformance();
        $campaigns = array_map(function($c) {
            return [
                'utm_source' => 'meta',
                'utm_medium' => 'social',
                'utm_campaign' => $c['name'],
                'unique_visitors' => $c['reach'],
                'total_events' => $c['conversions'],
            ];
        }, $rawCampaigns);

        $totalOrders = $overview['total_orders'];
        $attributedOrders = collect($sourceBreakdown)->sum('orders');
        $attributionRate = $totalOrders > 0 ? round(($attributedOrders / $totalOrders) * 100, 1) : 0;

        $topSources = collect($sourceBreakdown)
            ->where('source', '!=', 'direct')
            ->sortByDesc('orders')
            ->take(5)
            ->map(fn($s) => ['utm_source' => $s['source'], 'unique_visitors' => (int) $s['orders']])
            ->values()
            ->toArray();

        return response()->json([
            'summary' => [
                'total_orders' => $totalOrders,
                'total_revenue' => $overview['total_revenue'],
                'attribution_rate' => $attributionRate,
                'aov' => $overview['aov'],
                'roas' => $overview['roas'],
                'attributed_revenue' => $overview['total_revenue'],
            ],
            'source_breakdown' => $sourceBreakdown,
            'top_sources' => $topSources,
            'campaign_performance' => $campaigns,
        ]);
    }
}
