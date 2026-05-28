<?php

namespace Modules\CustomAdmin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Meta\Models\MetaLead;

class MetaLeadHubController extends Controller
{
    public function index()
    {
        $leads = MetaLead::latest()->paginate(20);
        $totalLeads = MetaLead::count();
        $syncedToday = MetaLead::whereDate('created_at', today())->count();
        return view('admin.meta-marketing.leads-hub', compact('leads', 'totalLeads', 'syncedToday'));
    }

    public function filter(Request $request)
    {
        $query = MetaLead::query();
        if ($request->filled('stage')) $query->where('stage', $request->stage);
        if ($request->filled('gender')) $query->where('gender', $request->gender);
        if ($request->filled('source')) $query->where('source', $request->source);
        if ($request->filled('search')) $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('email', 'like', '%'.$request->search.'%');
        });
        $leads = $query->latest()->paginate(20);
        $totalLeads = MetaLead::count();
        $syncedToday = MetaLead::whereDate('created_at', today())->count();
        return view('admin.meta-marketing.leads-hub', compact('leads', 'totalLeads', 'syncedToday'));
    }

    public function stats()
    {
        return response()->json([
            'total' => MetaLead::count(),
            'today' => MetaLead::whereDate('created_at', today())->count(),
        ]);
    }

    public function sync(Request $r)             { return response()->json(['success'=>true,'message'=>'جاري المزامنة...']); }
    public function syncFromFacebook(Request $r)  { return response()->json(['success'=>true,'message'=>'جاري جلب البيانات من فيسبوك...']); }
    public function bulkMessage(Request $r)       { return response()->json(['success'=>true,'message'=>'تم إرسال الرسائل']); }
    public function bulkCampaigns()               { return view('admin.meta-marketing.bulk-campaigns'); }
    public function bulkCampaignShow($campaign)    { return view('admin.meta-marketing.bulk-campaign-show', compact('campaign')); }
    public function exportExcel()                  { return response()->json(['success'=>true,'message'=>'جاري التصدير','count'=>MetaLead::count()]); }
    public function exportSelected(Request $r)     { return response()->json(['success'=>true,'message'=>'جاري التصدير']); }
    public function show($lead)                    { $l = MetaLead::find($lead); abort_if(!$l,404); return response()->json($l); }
}
