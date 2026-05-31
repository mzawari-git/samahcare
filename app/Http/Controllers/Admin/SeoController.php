<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        $products = collect([]);
        $total = 0;

        $stats = [
            'total' => $total,
            'seo_ready' => 0,
            'missing_meta' => $total,
            'missing_keywords' => $total,
            'missing_og' => $total,
        ];

        return view('admin.seo.index', compact('products', 'stats'));
    }

    public function edit($id)
    {
        return redirect()->route('admin.seo.index')->with('error', 'إدارة SEO للخدمات غير متاحة حالياً');
    }

    public function autoGenerate($id)
    {
        return redirect()->route('admin.seo.index')->with('info', 'التوليد التلقائي غير متاح حالياً');
    }

    public function autoGenerateAll()
    {
        return redirect()->route('admin.seo.index')->with('info', 'التوليد التلقائي للكل غير متاح حالياً');
    }

    public function aiGenerateAll()
    {
        return redirect()->route('admin.seo.index')->with('info', 'التوليد الذكي AI غير متاح حالياً');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.seo.index')->with('info', 'تحديث SEO غير متاح حالياً');
    }
}
