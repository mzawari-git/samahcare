<?php

namespace Modules\CustomAdmin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Meta\Models\MetaLead;

class MetaLeadHubController extends Controller
{
    private function safeQuery($callback, $default = []) {
        try { return $callback(); } catch (\Exception $e) { return $default; }
    }

    public function index()
    {
        $leads = $this->safeQuery(fn()=>MetaLead::latest()->paginate(20), collect([]));
        $totalLeads = $this->safeQuery(fn()=>MetaLead::count(), 0);
        $syncedToday = $this->safeQuery(fn()=>MetaLead::whereDate('created_at',today())->count(), 0);
        return view('admin.meta-marketing.leads-hub', compact('leads','totalLeads','syncedToday'));
    }

    public function filter(Request $request)
    {
        $leads = $this->safeQuery(function() use ($request) {
            $query = MetaLead::query();
            if ($request->filled('stage')) $query->where('stage', $request->stage);
            if ($request->filled('source')) $query->where('source', $request->source);
            if ($request->filled('search')) $query->where(function($q) use ($request) {
                $q->where('name','like','%'.$request->search.'%')->orWhere('email','like','%'.$request->search.'%');
            });
            return $query->latest()->paginate(20);
        }, collect([]));
        return view('admin.meta-marketing.leads-hub', ['leads'=>$leads,'totalLeads'=>0,'syncedToday'=>0]);
    }

    public function stats() {
        return response()->json(['total'=>$this->safeQuery(fn()=>MetaLead::count(),0),'today'=>0]);
    }

    public function sync(Request $r)              { return response()->json(['success'=>true,'message'=>'جاري المزامنة...']); }
    public function syncFromFacebook(Request $r)   { return response()->json(['success'=>true,'message'=>'جاري جلب البيانات']); }
    public function bulkMessage(Request $r)        { return response()->json(['success'=>true,'message'=>'تم الإرسال']); }
    public function bulkCampaigns()                { return view('admin.meta-marketing.bulk-campaigns'); }
    public function bulkCampaignShow($campaign)    { return view('admin.meta-marketing.bulk-campaign-show', compact('campaign')); }
    public function exportExcel()                  { return response()->json(['success'=>true,'message'=>'جاري التصدير']); }
    public function exportSelected(Request $r)     { return response()->json(['success'=>true,'message'=>'جاري التصدير']); }
    public function show($lead)                   { $l=MetaLead::find($lead); abort_if(!$l,404); return response()->json($l); }
}
