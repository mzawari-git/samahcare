<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = collect([]);
        $stats = [
            'total' => 0,
            'pending' => 0,
            'approved' => 0,
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    public function show($id)
    {
        return redirect()->route('admin.reviews.index')->with('error', 'التقييم غير موجود');
    }

    public function approve($id)
    {
        return redirect()->route('admin.reviews.index')->with('info', 'إدارة التقييمات غير متاحة حالياً');
    }

    public function reject($id)
    {
        return redirect()->route('admin.reviews.index')->with('info', 'إدارة التقييمات غير متاحة حالياً');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.reviews.index')->with('info', 'إدارة التقييمات غير متاحة حالياً');
    }
}
