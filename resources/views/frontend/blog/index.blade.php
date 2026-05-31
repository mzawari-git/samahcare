@extends($layoutPath)

@section('title', 'مدونة سماح كير | مقالات ونصائح للعناية الشاملة')
@section('meta_description', 'مدونة سماح كير - مقالات ونصائح للعناية الشاملة، أحدث أخبار التجميل، وأدلة استخدام متكاملة.')

@php
function readingTime($content) {
    $words = str_word_count(strip_tags($content));
    return max(1, ceil($words / 200));
}
@endphp

@section('content')
<section class="py-20 lg:py-28" style="background:var(--surface-alt);">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color:var(--ink);">
            مدونة <span class="gradient-text">سماح كير</span>
        </h1>
        <p class="text-base mb-8" style="color:var(--ink-muted);">اكتشفي أحدث المقالات والنصائح في عالم التجميل والعناية</p>
        <div class="flex flex-wrap justify-center gap-2">
            <a href="{{ route('blog.index') }}" class="px-4 py-2 rounded-full text-xs font-bold text-white" style="background:var(--brand-500);">الكل</a>
            <a href="{{ route('blog.category', 'articles') }}" class="px-4 py-2 rounded-full text-xs font-bold transition-all hover:opacity-80" style="background:white;color:var(--ink);border:1px solid rgba(0,0,0,0.06);">مقالات</a>
            <a href="{{ route('blog.category', 'guides') }}" class="px-4 py-2 rounded-full text-xs font-bold transition-all hover:opacity-80" style="background:white;color:var(--ink);border:1px solid rgba(0,0,0,0.06);">أدلة الاستخدام</a>
            <a href="{{ route('blog.category', 'tips') }}" class="px-4 py-2 rounded-full text-xs font-bold transition-all hover:opacity-80" style="background:white;color:var(--ink);border:1px solid rgba(0,0,0,0.06);">نصائح</a>
        </div>
    </div>
</section>

@if($featuredPosts->isNotEmpty())
<div class="py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl font-black mb-8" style="color:var(--ink);">مقالات مميزة</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredPosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" style="background:white;border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
                @if($post->image_url)
                <div class="relative overflow-hidden" style="height:200px;">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                </div>
                @else
                <div class="flex items-center justify-center" style="height:140px;background:var(--brand-50);">
                    <i class="ph ph-article text-4xl" style="color:var(--brand-300);"></i>
                </div>
                @endif
                <div class="p-6">
                    <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-full mb-3" style="color:{{ $post->category_color }};background:{{ $post->category_color }}12;">{{ $post->category_label }}</span>
                    <h3 class="text-base font-bold mb-2" style="color:var(--ink);line-height:1.5;">{{ $post->title_ar }}</h3>
                    <p class="text-sm mb-4 line-clamp-2" style="color:var(--ink-muted);">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 100) }}</p>
                    <div class="flex items-center gap-3 text-xs" style="color:var(--ink-dim);">
                        <span>{{ $post->created_at->format('Y-m-d') }}</span>
                        <span>&middot;</span>
                        <span>{{ readingTime($post->content_ar) }} دقيقة قراءة</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($articlePosts->isNotEmpty())
<div class="py-16" style="background:var(--surface-alt);">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-black" style="color:var(--ink);">مقالات عن الخدمات</h2>
            <a href="{{ route('blog.category', 'articles') }}" class="text-sm font-bold" style="color:var(--brand-500);">عرض الكل &larr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articlePosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="background:white;border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
                <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-full mb-3" style="color:{{ $post->category_color }};background:{{ $post->category_color }}12;">{{ $post->category_label }}</span>
                <h3 class="text-sm font-bold mb-2" style="color:var(--ink);line-height:1.5;">{{ $post->title_ar }}</h3>
                <p class="text-xs mb-3 line-clamp-2" style="color:var(--ink-muted);">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 80) }}</p>
                <div class="flex items-center gap-3 text-[10px]" style="color:var(--ink-dim);">
                    <span>{{ $post->created_at->format('Y-m-d') }}</span>
                    <span>{{ readingTime($post->content_ar) }} دقائق</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($tipPosts->isNotEmpty())
<div class="py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-black" style="color:var(--ink);">نصائح للعناية</h2>
            <a href="{{ route('blog.category', 'tips') }}" class="text-sm font-bold" style="color:var(--brand-500);">عرض الكل &larr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tipPosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="background:white;border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
                <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-full mb-3" style="color:{{ $post->category_color }};background:{{ $post->category_color }}12;">{{ $post->category_label }}</span>
                <h3 class="text-sm font-bold mb-2" style="color:var(--ink);line-height:1.5;">{{ $post->title_ar }}</h3>
                <p class="text-xs mb-3 line-clamp-2" style="color:var(--ink-muted);">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 80) }}</p>
                <div class="flex items-center gap-3 text-[10px]" style="color:var(--ink-dim);">
                    <span>{{ $post->created_at->format('Y-m-d') }}</span>
                    <span>{{ readingTime($post->content_ar) }} دقائق</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($guidePosts->isNotEmpty())
<div class="py-16" style="background:var(--surface-alt);">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-black" style="color:var(--ink);">أدلة الاستخدام</h2>
            <a href="{{ route('blog.category', 'guides') }}" class="text-sm font-bold" style="color:var(--brand-500);">عرض الكل &larr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($guidePosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="background:white;border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
                <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-full mb-3" style="color:{{ $post->category_color }};background:{{ $post->category_color }}12;">{{ $post->category_label }}</span>
                <h3 class="text-sm font-bold mb-2" style="color:var(--ink);line-height:1.5;">{{ $post->title_ar }}</h3>
                <p class="text-xs mb-3 line-clamp-2" style="color:var(--ink-muted);">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 80) }}</p>
                <div class="flex items-center gap-3 text-[10px]" style="color:var(--ink-dim);">
                    <span>{{ $post->created_at->format('Y-m-d') }}</span>
                    <span>{{ readingTime($post->content_ar) }} دقائق</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($latestPosts->isNotEmpty())
<div class="py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-black mb-2" style="color:var(--ink);">أحدث المقالات</h2>
            <p class="text-sm" style="color:var(--ink-muted);">كل ما هو جديد في عالم التجميل والعناية</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestPosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" style="background:white;border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
                @if($post->image_url)
                <div class="relative overflow-hidden" style="height:180px;">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                </div>
                @else
                <div style="height:120px;background:var(--surface-alt);"></div>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" style="color:{{ $post->category_color }};background:{{ $post->category_color }}12;">{{ $post->category_label }}</span>
                        <span class="text-[10px]" style="color:var(--ink-dim);">{{ $post->created_at->format('Y-m-d') }}</span>
                    </div>
                    <h3 class="text-sm font-bold mb-2" style="color:var(--ink);line-height:1.5;">{{ $post->title_ar }}</h3>
                    <p class="text-xs line-clamp-2" style="color:var(--ink-muted);">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 90) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($latestPosts->isEmpty())
<div class="py-20 text-center">
    <i class="ph ph-article text-5xl mb-4" style="color:var(--ink-dim);opacity:0.3;"></i>
    <h2 class="text-xl font-black mb-2" style="color:var(--ink);">المقالات قريباً</h2>
    <p style="color:var(--ink-muted);">نعمل على تجهيز محتوى قيّم ومفيد لكِ</p>
</div>
@endif
@endsection
