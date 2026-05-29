<div class="glass-panel rounded-2xl p-5 space-y-4">
    <div>
        <label class="block text-ink-dim text-xs mb-1">عنوان المقال <span class="text-red-400">*</span></label>
        <input type="text" name="title_ar" value="{{ $post->title_ar ?? old('title_ar') }}" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none">
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-ink-dim text-xs mb-1">القسم <span class="text-red-400">*</span></label>
            <select name="category" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none">
                <option value="">اختر القسم</option>
                <option value="articles" {{ ($post->category ?? old('category')) === 'articles' ? 'selected' : '' }}>مقالات عن المنتجات</option>
                <option value="tips" {{ ($post->category ?? old('category')) === 'tips' ? 'selected' : '' }}>نصائح للعناية الشاملة</option>
                <option value="news" {{ ($post->category ?? old('category')) === 'news' ? 'selected' : '' }}>أخبار التجميل</option>
                <option value="guides" {{ ($post->category ?? old('category')) === 'guides' ? 'selected' : '' }}>أدلة الاستخدام</option>
            </select>
        </div>
        <div>
            <label class="block text-ink-dim text-xs mb-1">ترتيب العرض</label>
            <input type="number" name="sort_order" value="{{ $post->sort_order ?? old('sort_order', 0) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none">
        </div>
    </div>

    <div>
        <label class="block text-ink-dim text-xs mb-1">ملخص المقال</label>
        <textarea name="excerpt_ar" rows="2" maxlength="500" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none">{{ $post->excerpt_ar ?? old('excerpt_ar') }}</textarea>
    </div>

    <div>
        <label class="block text-ink-dim text-xs mb-1">محتوى المقال <span class="text-red-400">*</span></label>
        <textarea id="blogContentArea" name="content_ar" rows="16" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none font-mono ltr text-left" dir="ltr">{{ $post->content_ar ?? old('content_ar') }}</textarea>
        <p class="text-ink-dim text-[10px] mt-1">يمكن استخدام HTML: p, h2, h3, ul, ol, li, strong, a, img, blockquote, br</p>
    </div>

    {{-- Inline Image Upload --}}
    <div class="border border-white/10 rounded-xl p-4 space-y-3">
        <label class="block text-ink-dim text-xs mb-1 flex items-center gap-1.5 font-bold">
            <i class="fas fa-images text-pink-400"></i> إدراج صور داخل المقال
        </label>
        <div id="inlineImageUpload">
            <input type="file" id="inlineImageInput" accept="image/*" class="w-full text-sm text-ink-dim file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-pink-500/80 file:text-white cursor-pointer">
            <p class="text-ink-dim text-[10px] mt-1.5">ارفعي صورة وسيتم إدراجها تلقائياً في محتوى المقال عند موضع المؤشر</p>
            <div id="inlineImageProgress" class="hidden mt-2">
                <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-pink-500 transition-all duration-300" style="width:0%"></div>
                </div>
                <p class="text-[10px] text-pink-400 mt-1">جاري الرفع...</p>
            </div>
            <div id="inlineImageResult" class="hidden mt-2 p-2 rounded-lg bg-green-500/10 border border-green-500/20">
                <p class="text-[10px] text-green-400 flex items-center gap-1"><i class="fas fa-check-circle"></i> تم رفع الصورة وإدراجها في المقال</p>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-ink-dim text-xs mb-1">صورة المقال الرئيسية</label>
        @if(!empty($post->image_url))
            <img src="{{ $post->image_url }}" class="w-32 h-20 object-cover rounded-lg mb-2">
        @endif
        <input type="file" name="image" accept="image/*" class="w-full text-sm text-ink-dim file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-pink-500 file:text-white">
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div class="flex items-center gap-3">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ ($post->is_published ?? true) ? 'checked' : '' }} class="accent-pink-500">
                <span class="text-sm">منشور</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" {{ ($post->is_featured ?? false) ? 'checked' : '' }} class="accent-yellow-500">
                <span class="text-sm">مميز</span>
            </label>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 pt-4 border-t border-white/5">
        <div>
            <label class="block text-ink-dim text-xs mb-1">Meta Title (SEO)</label>
            <input type="text" name="meta_title" value="{{ $post->meta_title ?? old('meta_title') }}" maxlength="255" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none ltr text-left" dir="ltr">
        </div>
        <div>
            <label class="block text-ink-dim text-xs mb-1">Meta Description (SEO)</label>
            <textarea name="meta_description" rows="2" maxlength="500" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-pink-500 focus:outline-none ltr text-left" dir="ltr">{{ $post->meta_description ?? old('meta_description') }}</textarea>
        </div>
    </div>
</div>

<script>
(function() {
    const input = document.getElementById('inlineImageInput');
    const progress = document.getElementById('inlineImageProgress');
    const progressBar = progress?.querySelector('div > div');
    const result = document.getElementById('inlineImageResult');
    const textarea = document.getElementById('blogContentArea');

    if (!input || !textarea) return;

    input.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        progress?.classList.remove('hidden');
        result?.classList.add('hidden');
        if (progressBar) progressBar.style.width = '30%';

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

        try {
            const response = await fetch('{{ route("admin.blog.upload-inline-image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            if (progressBar) progressBar.style.width = '70%';
            const data = await response.json();

            if (data.success && data.html) {
                const cursorPos = textarea.selectionStart;
                const textBefore = textarea.value.substring(0, cursorPos);
                const textAfter = textarea.value.substring(cursorPos);
                const insert = '\n' + data.html + '\n';
                textarea.value = textBefore + insert + textAfter;
                textarea.selectionStart = textarea.selectionEnd = cursorPos + insert.length;
                textarea.focus();

                if (progressBar) progressBar.style.width = '100%';
                setTimeout(() => {
                    progress?.classList.add('hidden');
                    result?.classList.remove('hidden');
                    setTimeout(() => result?.classList.add('hidden'), 3000);
                }, 400);
            } else {
                alert('حدث خطأ أثناء رفع الصورة');
                progress?.classList.add('hidden');
            }
        } catch (err) {
            console.error(err);
            alert('حدث خطأ في الاتصال');
            progress?.classList.add('hidden');
        }

        input.value = '';
    });
})();
</script>
