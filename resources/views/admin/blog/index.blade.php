@extends('admin.layouts.app')

@section('title', 'المدونة والمقالات')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-black mb-1">المدونة والمقالات</h2>
        <p class="text-ink-dim text-sm">إدارة المقالات والنصائح والمحتوى التوعوي</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn-primary text-sm"><i class="fas fa-plus ml-1"></i> مقال جديد</a>
</div>

<div class="glass-panel rounded-2xl p-4">
    <table class="w-full text-sm">
        <thead><tr class="text-ink-dim text-xs border-b border-white/5">
            <th class="pb-3 text-right">العنوان</th><th class="pb-3 text-right">القسم</th><th class="pb-3 text-right">التاريخ</th><th class="pb-3 text-right">الحالة</th><th class="pb-3"></th>
        </tr></thead>
        <tbody>
            @foreach($posts as $post)
            <tr class="border-b border-white/5">
                <td class="py-3">
                    <div class="font-bold">{{ $post->title_ar }}</div>
                    <div class="text-ink-dim text-xs mt-0.5">{{ Str::limit(strip_tags($post->excerpt_ar ?? $post->content_ar), 60) }}</div>
                </td>
                <td class="py-3"><span class="text-xs px-2 py-0.5 rounded-full" style="background:{{ $post->category_color }}15;color:{{ $post->category_color }};">{{ $post->category_label }}</span></td>
                <td class="py-3 text-ink-dim text-xs">{{ $post->created_at->format('Y-m-d') }}</td>
                <td class="py-3">
                    <form action="{{ route('admin.blog.toggle', $post) }}" method="POST">@csrf @method('PATCH')
                        <button class="text-xs font-bold {{ $post->is_published ? 'text-green-400' : 'text-red-400' }}">{{ $post->is_published ? 'منشور' : 'مخفي' }}</button>
                    </form>
                </td>
                <td class="py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.blog.edit', $post) }}" class="text-pink-400 text-xs font-bold">تعديل</a>
                        @if($post->trashed())
                            <form action="{{ route('admin.blog.restore', $post->id) }}" method="POST" class="inline">@csrf @method('PATCH')
                                <button class="text-green-400 text-xs font-bold">استعادة</button>
                            </form>
                        @else
                            <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('متأكد من الحذف؟')">@csrf @method('DELETE')
                                <button class="text-red-400 text-xs font-bold">حذف</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $posts->links() }}</div>
</div>
@endsection
