@extends('frontend.layouts.editorial.app')

@section('title', 'مدونة جنين للتجميل | مقالات ونصائح للعناية الشاملة')
@section('meta_description', 'مدونة جنين للتجميل - مقالات عن المنتجات، نصائح للعناية الشاملة، أحدث أخبار التجميل، وأدلة استخدام متكاملة.')

@section('content')
<section style="background:#ffffff;min-height:100vh;">

    {{-- HERO --}}
    <div style="padding:7rem 1rem 4rem;text-align:center;background:linear-gradient(135deg,#fdf2f8 0%,#ecfdf5 50%,#f0f9ff 100%);">
        <div style="max-width:700px;margin:0 auto;">
            <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.35rem 1.25rem;border-radius:9999px;border:1px solid rgba(236,72,153,0.25);background:rgba(236,72,153,0.06);margin-bottom:1.5rem;">
                <span style="font-size:.75rem;font-weight:700;color:#be185d;letter-spacing:.1em;">مدونة جنين للتجميل</span>
            </div>
            <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;color:#0f172a;line-height:1.2;margin-bottom:1rem;">جمالكِ يبدأ من المعلومة الصحيحة</h1>
            <p style="color:#475569;font-size:1.1rem;line-height:1.7;">اكتشفي أحدث المقالات والنصائح في عالم التجميل والعناية. كل ما تحتاجين معرفته عن المنتجات، التركيبات، وطرق العناية المثلى.</p>
        </div>
    </div>

    {{-- FEATURED POSTS --}}
    @if($featuredPosts->isNotEmpty())
    <div style="padding:3rem 1rem;background:#ffffff;">
        <div style="max-width:1100px;margin:0 auto;">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:2rem;">
                <span style="font-size:.75rem;font-weight:700;color:#be185d;letter-spacing:.1em;background:rgba(236,72,153,0.08);padding:.3rem .85rem;border-radius:9999px;">مقالات مميزة</span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;">
                @foreach($featuredPosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;display:block;border-radius:1.25rem;overflow:hidden;border:1px solid #e2e8f0;background:#fff;transition:all .2s;">
                    @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" style="width:100%;height:200px;object-fit:cover;">
                    @else
                    <div style="height:200px;background:linear-gradient(135deg,{{ $post->category_color }}15,{{ $post->category_color }}08);display:flex;align-items:center;justify-content:center;">
                        <i class="ph ph-article" style="font-size:3rem;color:{{ $post->category_color }}30;"></i>
                    </div>
                    @endif
                    <div style="padding:1.25rem;">
                        <span style="display:inline-block;font-size:.65rem;font-weight:700;color:{{ $post->category_color }};background:{{ $post->category_color }}10;padding:.25rem .75rem;border-radius:9999px;margin-bottom:.75rem;">{{ $post->category_label }}</span>
                        <h3 style="font-size:1.1rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;line-height:1.5;">{{ $post->title_ar }}</h3>
                        <p style="color:#64748b;font-size:.8rem;line-height:1.6;">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 100) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ARTICLES SECTION --}}
    @if($articlePosts->isNotEmpty())
    <div style="padding:3rem 1rem;background:#f8fafc;">
        <div style="max-width:1100px;margin:0 auto;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:.75rem;background:#fce7f3;">
                        <i class="ph ph-flask" style="color:#ec4899;"></i>
                    </span>
                    <div>
                        <h2 style="font-size:1.35rem;font-weight:900;color:#0f172a;">مقالات عن المنتجات</h2>
                        <p style="color:#64748b;font-size:.75rem;">تعرفي على كل ما يخص منتجات التجميل والعناية</p>
                    </div>
                </div>
                <a href="{{ route('blog.category', 'articles') }}" style="color:#be185d;font-size:.8rem;font-weight:700;text-decoration:none;">عرض الكل &larr;</a>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.25rem;">
                @foreach($articlePosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;display:block;background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;transition:all .2s;">
                    <span style="display:inline-block;font-size:.65rem;font-weight:700;color:#ec4899;background:#fce7f3;padding:.2rem .65rem;border-radius:9999px;margin-bottom:.75rem;">{{ $post->category_label }}</span>
                    <h3 style="font-size:1rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;line-height:1.5;">{{ $post->title_ar }}</h3>
                    <p style="color:#64748b;font-size:.75rem;line-height:1.6;">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 80) }}</p>
                    <div style="margin-top:.75rem;font-size:.7rem;color:#94a3b8;">{{ $post->created_at->format('Y-m-d') }}</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- TIPS SECTION --}}
    @if($tipPosts->isNotEmpty())
    <div style="padding:3rem 1rem;background:#ffffff;">
        <div style="max-width:1100px;margin:0 auto;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:.75rem;background:#e0f2fe;">
                        <i class="ph ph-sparkle" style="color:#0891b2;"></i>
                    </span>
                    <div>
                        <h2 style="font-size:1.35rem;font-weight:900;color:#0f172a;">نصائح للعناية الشاملة</h2>
                        <p style="color:#64748b;font-size:.75rem;">دليلكِ المتكامل لروتين عناية صحيح وفعّال</p>
                    </div>
                </div>
                <a href="{{ route('blog.category', 'tips') }}" style="color:#0891b2;font-size:.8rem;font-weight:700;text-decoration:none;">عرض الكل &larr;</a>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.25rem;">
                @foreach($tipPosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;display:block;background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;transition:all .2s;">
                    <span style="display:inline-block;font-size:.65rem;font-weight:700;color:#0891b2;background:#e0f2fe;padding:.2rem .65rem;border-radius:9999px;margin-bottom:.75rem;">{{ $post->category_label }}</span>
                    <h3 style="font-size:1rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;line-height:1.5;">{{ $post->title_ar }}</h3>
                    <p style="color:#64748b;font-size:.75rem;line-height:1.6;">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 80) }}</p>
                    <div style="margin-top:.75rem;font-size:.7rem;color:#94a3b8;">{{ $post->created_at->format('Y-m-d') }}</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- GUIDES SECTION --}}
    @if($guidePosts->isNotEmpty())
    <div style="padding:3rem 1rem;background:#ffffff;">
        <div style="max-width:1100px;margin:0 auto;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:.75rem;background:#dcfce7;">
                        <i class="ph ph-book-open" style="color:#16a34a;"></i>
                    </span>
                    <div>
                        <h2 style="font-size:1.35rem;font-weight:900;color:#0f172a;">أدلة الاستخدام</h2>
                        <p style="color:#64748b;font-size:.75rem;">أدلة شاملة ومقارنات بين الأجهزة والمنتجات</p>
                    </div>
                </div>
                <a href="{{ route('blog.category', 'guides') }}" style="color:#16a34a;font-size:.8rem;font-weight:700;text-decoration:none;">عرض الكل &larr;</a>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.25rem;">
                @foreach($guidePosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;display:block;background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;transition:all .2s;">
                    <span style="display:inline-block;font-size:.65rem;font-weight:700;color:#16a34a;background:#dcfce7;padding:.2rem .65rem;border-radius:9999px;margin-bottom:.75rem;">{{ $post->category_label }}</span>
                    <h3 style="font-size:1rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;line-height:1.5;">{{ $post->title_ar }}</h3>
                    <p style="color:#64748b;font-size:.75rem;line-height:1.6;">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 80) }}</p>
                    <div style="margin-top:.75rem;font-size:.7rem;color:#94a3b8;">{{ $post->created_at->format('Y-m-d') }}</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- LATEST POSTS --}}
    @if($latestPosts->isNotEmpty())
    <div style="padding:3rem 1rem 5rem;background:#f8fafc;">
        <div style="max-width:1100px;margin:0 auto;">
            <div style="text-align:center;margin-bottom:2.5rem;">
                <h2 style="font-size:1.75rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;">أحدث المقالات</h2>
                <p style="color:#64748b;font-size:.85rem;">كل ما هو جديد في عالم التجميل والعناية</p>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;">
                @foreach($latestPosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;display:block;background:#fff;border:1px solid #e2e8f0;border-radius:1.25rem;overflow:hidden;transition:all .2s;">
                    @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title_ar }}" style="width:100%;height:180px;object-fit:cover;">
                    @else
                    <div style="height:120px;background:linear-gradient(135deg,{{ $post->category_color }}10,{{ $post->category_color }}05);"></div>
                    @endif
                    <div style="padding:1.25rem;">
                        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem;">
                            <span style="font-size:.6rem;font-weight:700;color:{{ $post->category_color }};background:{{ $post->category_color }}10;padding:.15rem .55rem;border-radius:9999px;">{{ $post->category_label }}</span>
                            <span style="font-size:.65rem;color:#94a3b8;">{{ $post->created_at->format('Y-m-d') }}</span>
                        </div>
                        <h3 style="font-size:1rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;line-height:1.5;">{{ $post->title_ar }}</h3>
                        <p style="color:#64748b;font-size:.78rem;line-height:1.6;">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 90) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($latestPosts->isEmpty())
    <div style="padding:5rem 1rem;text-align:center;">
        <i class="ph ph-article" style="font-size:4rem;color:#e2e8f0;margin-bottom:1rem;"></i>
        <h2 style="font-size:1.5rem;font-weight:900;color:#0f172a;margin-bottom:.5rem;">المقالات قريباً</h2>
        <p style="color:#94a3b8;">نعمل على تجهيز محتوى قيّم ومفيد لكِ. تابعينا!</p>
    </div>
    @endif

</section>
@endsection
