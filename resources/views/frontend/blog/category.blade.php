@extends($layoutPath)

@section('title', $categoryTitle . ' | مدونة سماح كير')

@php
function readingTime($content) {
    $words = str_word_count(strip_tags($content));
    return max(1, ceil($words / 200));
}
@endphp

@section('content')
<section class="py-20 lg:py-28" style="background:var(--surface-alt);">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 text-sm font-bold mb-6" style="color:var(--brand-500);">
            <i class="ph ph-arrow-right"></i> العودة للمدونة
        </a>
        <h1 class="text-3xl md:text-4xl font-black mb-2" style="color:var(--ink);">{{ $categoryTitle }}</h1>
        <p class="text-sm" style="color:var(--ink-muted);">{{ $posts->total() }} مقال</p>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 py-16">
    @if($posts->isEmpty())
    <div class="text-center py-16">
        <p style="color:var(--ink-muted);">لا توجد مقالات في هذا القسم بعد.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" style="background:white;border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
            @if($post->image_url)
            <div class="relative overflow-hidden" style="height:200px;">
                <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
            </div>
            @else
            <div style="height:120px;background:var(--surface-alt);"></div>
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
    <div class="mt-10">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
