@extends('frontend.layouts.editorial.app')

@section('title', $post->meta_title ?: $post->title_ar . ' | مدونة جنين للتجميل')
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 160))

@section('content')
<section style="background:#ffffff;min-height:100vh;">
    <article style="max-width:800px;margin:0 auto;padding:6rem 1rem 4rem;">

        <a href="{{ route('blog.index') }}" style="color:#be185d;font-size:.8rem;font-weight:700;text-decoration:none;margin-bottom:1.5rem;display:inline-block;">&larr; العودة للمدونة</a>

        <div style="margin-bottom:2rem;">
            <span style="display:inline-block;font-size:.7rem;font-weight:700;color:{{ $post->category_color }};background:{{ $post->category_color }}10;padding:.3rem .85rem;border-radius:9999px;margin-bottom:1rem;">{{ $post->category_label }}</span>
            <h1 style="font-size:clamp(1.5rem,4vw,2.5rem);font-weight:900;color:#0f172a;line-height:1.3;margin-bottom:.75rem;">{{ $post->title_ar }}</h1>
            <div style="display:flex;align-items:center;gap:.75rem;color:#94a3b8;font-size:.8rem;">
                <span><i class="ph ph-calendar ml-1"></i> {{ $post->created_at->format('Y-m-d') }}</span>
                @if($post->excerpt_ar)
                <span style="color:#cbd5e1;">|</span>
                <span>{{ Str::limit(strip_tags($post->excerpt_ar), 60) }}</span>
                @endif
            </div>
        </div>

        @if($post->image_url)
        <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" style="width:100%;max-height:450px;object-fit:cover;border-radius:1.25rem;margin-bottom:2rem;">
        @endif

        <div style="color:#334155;font-size:1.05rem;line-height:2;text-align:justify;" class="blog-content">
            {!! $post->content_ar !!}
        </div>

        {{-- RELATED POSTS --}}
        @if($relatedPosts->isNotEmpty())
        <div style="margin-top:4rem;padding-top:2.5rem;border-top:1px solid #e2e8f0;">
            <h3 style="font-size:1.25rem;font-weight:900;color:#0f172a;margin-bottom:1.5rem;">مقالات ذات صلة</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
                @foreach($relatedPosts as $related)
                <a href="{{ route('blog.show', $related->slug) }}" style="text-decoration:none;display:block;background:#f8fafc;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;transition:all .2s;">
                    <span style="display:inline-block;font-size:.6rem;font-weight:700;color:{{ $related->category_color }};background:{{ $related->category_color }}10;padding:.2rem .55rem;border-radius:9999px;margin-bottom:.5rem;">{{ $related->category_label }}</span>
                    <h4 style="font-size:.9rem;font-weight:900;color:#0f172a;margin-bottom:.4rem;line-height:1.5;">{{ $related->title_ar }}</h4>
                    <p style="color:#94a3b8;font-size:.7rem;line-height:1.5;">{{ Str::limit(strip_tags($related->excerpt_ar ?? $related->content_ar), 60) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </article>
</section>

<style>
.blog-content h2 { font-size:1.5rem; font-weight:900; color:#0f172a; margin-top:2rem; margin-bottom:1rem; }
.blog-content h3 { font-size:1.2rem; font-weight:800; color:#1e293b; margin-top:1.5rem; margin-bottom:.75rem; }
.blog-content p { margin-bottom:1rem; }
.blog-content ul, .blog-content ol { margin-bottom:1rem; padding-right:1.5rem; }
.blog-content li { margin-bottom:.35rem; }
.blog-content strong { color:#0f172a; }
.blog-content a { color:#be185d; text-decoration:underline; }
.blog-content blockquote { border-right:3px solid #ec4899; padding:.75rem 1.25rem; margin:1.5rem 0; background:#fdf2f8; border-radius:0 .75rem .75rem 0; font-size:.95rem; color:#475569; }
.blog-content img { max-width:100%; border-radius:.75rem; margin:1rem 0; }
</style>
@endsection
