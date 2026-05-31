<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Services\SeoService;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function __construct(
        private SeoService $seoService,
    ) {}

    public function index(Request $request)
    {
        $pages = $this->seoService->getAllPageSeoData();
        $stats = $this->seoService->getSeoStats();

        return view('admin.seo.index', compact('pages', 'stats'));
    }

    public function edit($key)
    {
        $pages = $this->seoService->getAllPageSeoData();
        $page = collect($pages)->firstWhere('key', $key);

        if (!$page) {
            return redirect()->route('admin.seo.index')->with('error', 'الصفحة غير موجودة');
        }

        return view('admin.seo.edit', compact('page'));
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:200',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'keywords' => 'nullable|string|max:500',
        ]);

        $data = $request->only([
            'meta_title', 'meta_description', 'og_title', 'og_description',
            'og_image', 'keywords', 'schema_type',
        ]);

        $this->seoService->savePageSeo($key, $data);

        return redirect()->route('admin.seo.index')
            ->with('success', 'تم تحديث بيانات SEO بنجاح');
    }

    public function autoGenerate($key)
    {
        $result = $this->seoService->generateAutoSeo($key);

        return redirect()->route('admin.seo.index')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function autoGenerateAll()
    {
        $result = $this->seoService->generateAllAutoSeo();

        return redirect()->route('admin.seo.index')
            ->with('success', $result['message']);
    }

    public function aiGenerateAll()
    {
        $pages = $this->seoService->getAllPageSeoData();

        $aiService = app(\App\Services\AI\AISanitizerService::class);

        $count = 0;
        foreach ($pages as $page) {
            if (!$page['is_saved']) {
                try {
                    $prompt = "Generate SEO meta tags in Arabic for: {$page['title']}\nURL: {$page['url']}\nReturn JSON: {\"meta_title\":\"...\",\"meta_description\":\"...\",\"keywords\":\"...\"}";
                    $result = $aiService->sanitize($prompt);

                    if ($result && $json = json_decode($result, true)) {
                        $this->seoService->savePageSeo($page['key'], [
                            'meta_title' => $json['meta_title'] ?? $page['meta_title'],
                            'meta_description' => $json['meta_description'] ?? $page['meta_description'],
                            'og_title' => $json['meta_title'] ?? $page['og_title'],
                            'og_description' => $json['meta_description'] ?? $page['og_description'],
                            'og_image' => $page['og_image'],
                            'keywords' => $json['keywords'] ?? $page['keywords'],
                            'schema_type' => $page['schema_type'],
                        ]);
                        $count++;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return redirect()->route('admin.seo.index')
            ->with('success', "تم توليد SEO بالذكاء الاصطناعي لـ {$count} صفحة");
    }

    public function schema($key)
    {
        $pages = $this->seoService->getAllPageSeoData();
        $page = collect($pages)->firstWhere('key', $key);

        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        $schema = $this->seoService->generateSchemaMarkup($page['schema_type'], [
            'name' => $page['title'],
            'url' => $page['url'],
        ]);

        return response()->json($schema)->header('Content-Type', 'application/ld+json');
    }
}
