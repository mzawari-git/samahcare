<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_ar', 'like', "%{$request->search}%")
                  ->orWhere('name_en', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'missing_meta') {
                $query->where(function ($q) {
                    $q->whereNull('meta_title')->orWhere('meta_title', '')->orWhere('meta_description', '')->orWhereNull('meta_description');
                });
            } elseif ($request->filter === 'missing_keywords') {
                $query->whereNull('meta_keywords');
            } elseif ($request->filter === 'missing_og') {
                $query->whereNull('og_image')->orWhere('og_image', '');
            } elseif ($request->filter === 'seo_ready') {
                $query->whereNotNull('meta_title')->where('meta_title', '!=', '')
                      ->whereNotNull('meta_description')->where('meta_description', '!=', '')
                      ->whereNotNull('meta_keywords');
            }
        }

        $products = $query->paginate(30);

        foreach ($products as $product) {
            $product->seo_score = $this->calculateSeoScore($product);
        }

        $stats = [
            'total' => Product::count(),
            'seo_ready' => Product::whereNotNull('meta_title')->where('meta_title', '!=', '')->whereNotNull('meta_description')->where('meta_description', '!=', '')->whereNotNull('meta_keywords')->count(),
            'missing_meta' => Product::where(function ($q) { $q->whereNull('meta_title')->orWhere('meta_title', '')->orWhere('meta_description', '')->orWhereNull('meta_description'); })->count(),
            'missing_keywords' => Product::whereNull('meta_keywords')->count(),
            'missing_og' => Product::whereNull('og_image')->orWhere('og_image', '')->count(),
        ];

        return view('admin.seo.index', compact('products', 'stats'));
    }

    public function bulkEdit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.seo.edit', compact('product'));
    }

    public function bulkUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'meta_title' => 'nullable|string|max:160',
            'meta_title_ar' => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:320',
            'meta_description_ar' => 'nullable|string|max:320',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
        ]);

        $product->update($data);

        return redirect()->route('admin.seo.index')->with('success', 'تم تحديث SEO لـ ' . $product->name_ar);
    }

    public function autoGenerate($id)
    {
        $product = Product::findOrFail($id);
        $categoryName = $product->category->name_ar ?? '';

        $product->update([
            'meta_title' => $product->meta_title ?: ($product->name_ar . ' - ' . $categoryName . ' | JeninCare'),
            'meta_description' => $product->meta_description ?: \Str::limit(strip_tags($product->description_ar ?? $product->name_ar), 160),
            'meta_keywords' => $product->meta_keywords ?: json_encode($this->generateKeywords($product)),
        ]);

        return redirect()->route('admin.seo.index')->with('success', 'تم إنشاء SEO تلقائياً لـ ' . $product->name_ar);
    }

    public function autoGenerateAll()
    {
        $products = Product::whereNull('meta_title')->orWhere('meta_title', '')->orWhereNull('meta_description')->orWhere('meta_description', '')->get();

        $count = 0;
        foreach ($products as $product) {
            $categoryName = $product->category->name_ar ?? '';
            $product->update([
                'meta_title' => $product->meta_title ?: ($product->name_ar . ' - ' . $categoryName . ' | JeninCare'),
                'meta_description' => $product->meta_description ?: \Str::limit(strip_tags($product->description_ar ?? $product->name_ar), 160),
                'meta_keywords' => $product->meta_keywords ?: json_encode($this->generateKeywords($product)),
            ]);
            $count++;
        }

        return redirect()->route('admin.seo.index')->with('success', "تم إنشاء SEO تلقائياً لـ {$count} منتج");
    }

    private function calculateSeoScore($product)
    {
        $score = 0;
        if (!empty($product->meta_title)) $score += 25;
        if (!empty($product->meta_description)) $score += 25;
        if (!empty($product->meta_keywords)) $score += 20;
        if (!empty($product->og_image)) $score += 15;
        if (!empty($product->slug)) $score += 15;
        return $score;
    }

    private function generateKeywords($product)
    {
        $keywords = [];
        $nameWords = explode(' ', $product->name_ar);
        foreach ($nameWords as $w) {
            if (mb_strlen($w) > 2) $keywords[] = $w;
        }
        if ($product->category) {
            $catWords = explode(' ', $product->category->name_ar ?? '');
            foreach ($catWords as $w) {
                if (mb_strlen($w) > 2) $keywords[] = $w;
            }
        }
        $keywords[] = 'JeninCare';
        $keywords[] = 'تجميل';
        $keywords[] = 'عناية';
        return array_unique($keywords);
    }
}
