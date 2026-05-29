@extends('frontend.layouts.editorial.app')

@section('title', $categoryTitle . ' | مدونة جنين للتجميل')

@section('content')
<section style="background:#ffffff;min-height:100vh;">
    <div style="padding:6rem 1rem 3rem;text-align:center;background:#f8fafc;border-bottom:1px solid #e2e8f0;">
        <div style="max-width:600px;margin:0 auto;">
            <a href="{{ route('blog.index') }}" style="color:#be185d;font-size:.8rem;font-weight:700;text-decoration:none;margin-bottom:1rem;display:inline-block;">&larr; العودة للمدونة</a>
            <h1 style="font-size:clamp(1.75rem,4vw,2.5rem);font-weight:900;color:#0f172a;margin-bottom:.5rem;">{{ $categoryTitle }}</h1>
            <p style="color:#64748b;font-size:.9rem;">{{ $posts->total() }} مقال</p>
        </div>
    </div>

    <div style="max-width:1100px;margin:0 auto;padding:3rem 1rem;">
        @if($posts->isEmpty())
            <div style="text-align:center;padding:3rem;">
                <p style="color:#94a3b8;">لا توجد مقالات في هذا القسم بعد.</p>
            </div>
        @else
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;">
                @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;display:block;background:#fff;border:1px solid #e2e8f0;border-radius:1.25rem;overflow:hidden;transition:all .2s;">
                    @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" style="width:100%;height:200px;object-fit:cover;">
                    @else
                    <div style="height:140px;background:linear-gradient(135deg,{{ $post->category_color }}10,{{ $post->category_color }}05);"></div>
                    @endif
                    <div style="padding:1.25rem;">
                        <span style="display:inline-block;font-size:.65rem;font-weight:700;color:{{ $post->category_color }};background:{{ $post->category_color }}10;padding:.25rem .75rem;border-radius:9999px;margin-bottom:.75rem;">{{ $post->category_label }}</span>
                        <h3 style="font-size:1.1rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;line-height:1.5;">{{ $post->title_ar }}</h3>
                        <p style="color:#64748b;font-size:.8rem;line-height:1.6;">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 100) }}</p>
                        <div style="margin-top:.75rem;font-size:.7rem;color:#94a3b8;">{{ $post->created_at->format('Y-m-d') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
            <div style="margin-top:2rem;">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
