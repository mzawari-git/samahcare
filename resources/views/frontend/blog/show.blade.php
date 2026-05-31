@extends($layoutPath)

@section('title', $post->meta_title ?: $post->title_ar . ' | مدونة سماح كير')
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 160))

@php
$dc = $post->design_color;
$primaryColor = $dc ?? '#c4727f';

function formatBlogContent($raw) {
    $raw = trim($raw);
    if (empty($raw)) return '';
    if (str_contains($raw, 'blog-section')) return $raw;
    if (preg_match('/<[a-z][\s\S]*>/i', $raw)) {
        return '<div class="blog-section">' . "\n" . $raw . "\n" . '</div>';
    }
    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    if (!empty($lines)) {
        $html = '<div class="blog-section">' . "\n";
        foreach ($lines as $line) {
            if (!empty($line)) {
                $html .= '    <p>' . e($line) . '</p>' . "\n";
            }
        }
        $html .= '</div>';
        return $html;
    }
    return '<div class="blog-section"><p>' . e($raw) . '</p></div>';
}
@endphp

@section('content')
<section class="py-16 lg:py-24">
    <article class="max-w-3xl mx-auto px-4">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 text-sm font-bold mb-8 transition-opacity hover:opacity-80" style="color:var(--brand-500);">
            <i class="ph ph-arrow-right"></i> العودة للمدونة
        </a>

        <div class="mb-8">
            <span class="inline-block text-xs font-bold px-3 py-1.5 rounded-full mb-4" style="color:{{ $post->category_color }};background:{{ $post->category_color }}12;">{{ $post->category_label }}</span>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black mb-4" style="color:var(--ink);line-height:1.3;">{{ $post->title_ar }}</h1>
            <div class="flex items-center gap-4 text-sm" style="color:var(--ink-dim);">
                <span><i class="ph ph-calendar ml-1"></i> {{ $post->created_at->format('Y-m-d') }}</span>
                @if($post->excerpt_ar)
                <span style="color:rgba(0,0,0,0.1);">|</span>
                <span>{{ Str::limit(strip_tags($post->excerpt_ar), 60) }}</span>
                @endif
            </div>
        </div>

        @if($post->image_url)
        <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" class="w-full rounded-2xl mb-10" style="max-height:450px;object-fit:cover;">
        @endif

        <div class="blog-content" style="color:var(--ink);font-size:1.05rem;line-height:2;">
            {!! formatBlogContent($post->content_ar) !!}
        </div>

        @if($relatedPosts->isNotEmpty())
        <div class="mt-16 pt-10" style="border-top:1px solid rgba(0,0,0,0.06);">
            <h3 class="text-xl font-black mb-6" style="color:var(--ink);">مقالات ذات صلة</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($relatedPosts as $related)
                <a href="{{ route('blog.show', $related->slug) }}" class="block rounded-xl p-5 transition-all hover:-translate-y-0.5 hover:shadow-md" style="background:var(--surface-alt);border:1px solid rgba(0,0,0,0.04);text-decoration:none;">
                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full mb-2" style="color:{{ $related->category_color }};background:{{ $related->category_color }}12;">{{ $related->category_label }}</span>
                    <h4 class="text-sm font-bold mb-2" style="color:var(--ink);line-height:1.5;">{{ $related->title_ar }}</h4>
                    <p class="text-xs line-clamp-2" style="color:var(--ink-muted);">{{ Str::limit(strip_tags($related->excerpt_ar ?? $related->content_ar), 60) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </article>
</section>

<style>
.blog-content h2 { font-size: 1.5rem; font-weight: 900; color: var(--ink); margin-top: 2rem; margin-bottom: 1rem; }
.blog-content h3 { font-size: 1.2rem; font-weight: 800; color: var(--ink); margin-top: 1.5rem; margin-bottom: 0.75rem; }
.blog-content p { margin-bottom: 1rem; line-height: 1.9; color: #4b5563; }
.blog-content ul, .blog-content ol { margin-bottom: 1rem; padding-right: 1.5rem; }
.blog-content li { margin-bottom: 0.5rem; line-height: 1.8; color: #4b5563; }
.blog-content strong { color: var(--ink); }
.blog-content a { color: var(--brand-500); text-decoration: underline; }
.blog-content blockquote { border-right: 3px solid var(--brand-500); padding: 0.75rem 1.25rem; margin: 1.5rem 0; background: var(--brand-50); border-radius: 0 0.75rem 0.75rem 0; font-size: 0.95rem; color: #4b5563; }
.blog-content img { max-width: 100%; border-radius: 0.75rem; margin: 1rem 0; }
.blog-section { margin-bottom: 0; }
.blog-section p { color: #4B5563; line-height: 1.9; margin-bottom: 15px; }
.blog-section ul { list-style: none; padding: 0; margin: 15px 0; }
.blog-section ul li { padding: 12px 18px; margin-bottom: 10px; background: var(--surface-alt); border-radius: 10px; border-right: 4px solid var(--brand-500); color: #4B5563; line-height: 1.7; }
.blog-section ul li strong { color: var(--ink); }
.blog-section ol { margin: 15px 0; padding-right: 1.5rem; }
.blog-section ol li { padding: 8px 0; margin-bottom: 10px; color: #4B5563; line-height: 1.7; }
.blog-warning-box { background: #fef2f2; border: 2px solid #ef4444; border-radius: 12px; padding: 20px; margin: 20px 0; }
.blog-warning-box h4 { color: #dc2626; font-weight: 700; margin-bottom: 10px; }
.blog-info-box { background: #eff6ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 20px 0; }
.blog-info-box h4 { color: #1e40af; font-weight: 700; margin-bottom: 10px; }
.blog-highlight { background: #fef3c7; padding: 2px 8px; border-radius: 4px; font-weight: 600; color: #92400e; }
.blog-section table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
.blog-section table th, .blog-section table td { padding: 10px 12px; border: 1px solid rgba(0,0,0,0.06); }
.blog-section table th { background: var(--brand-500); color: #fff; font-weight: 700; }
.blog-section table tr:nth-child(even) { background: var(--surface-alt); }
@media (max-width: 768px) { .blog-section h2 { font-size: 1.15rem; } }
</style>
@endsection
