<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::withTrashed()->latest()->paginate(20);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'category' => 'required|in:articles,tips,news,guides',
            'excerpt_ar' => 'nullable|string|max:500',
            'content_ar' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['slug'] = $this->uniqueSlug($data['title_ar']);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'تم إنشاء المقال بنجاح.');
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blog.edit', ['post' => $blog]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'category' => 'required|in:articles,tips,news,guides',
            'excerpt_ar' => 'nullable|string|max:500',
            'content_ar' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($data['title_ar'] !== $blog->title_ar) {
            $data['slug'] = $this->uniqueSlug($data['title_ar'], $blog->id);
        }

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($blog->image) Storage::disk('public')->delete($blog->image);
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'تم تحديث المقال بنجاح.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return back()->with('success', 'تم حذف المقال.');
    }

    public function restore($id)
    {
        BlogPost::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'تم استعادة المقال.');
    }

    public function toggle(BlogPost $blog)
    {
        $blog->update(['is_published' => !$blog->is_published]);
        return back()->with('success', 'تم تحديث حالة النشر.');
    }

    private function uniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug(preg_replace('/[^\x{0600}-\x{06FF}\w\s]/u', '', $title), '-');
        $slug = $slug ?: 'post';
        $original = $slug;
        $counter = 1;

        $query = BlogPost::where('slug', $slug);
        if ($excludeId) $query->where('id', '!=', $excludeId);

        while ($query->exists()) {
            $slug = $original . '-' . $counter;
            $query = BlogPost::where('slug', $slug);
            if ($excludeId) $query->where('id', '!=', $excludeId);
            $counter++;
        }

        return $slug;
    }
}
