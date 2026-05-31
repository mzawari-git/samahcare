{{-- ═══ Universal Theme Switcher: Architecture + Color + Font + Dark/Light ═══ --}}
<div id="themeSwitcher" class="fixed bottom-6 left-6 z-[9999] flex flex-col gap-3">
    <button onclick="toggleThemePalette()" id="themeToggleBtn" class="w-12 h-12 rounded-full flex items-center justify-center text-white hover:text-white hover:scale-110 transition-all cursor-pointer shadow-xl border border-white/20" style="background:var(--brand-500);" title="تخصيص المظهر" aria-label="تخصيص المظهر">
        <i class="ph ph-paint-brush text-xl"></i>
    </button>

    <button onclick="toggleDarkLight()" id="darkLightBtn" class="w-12 h-12 rounded-full flex items-center justify-center transition-all cursor-pointer shadow-xl border border-white/20" style="background:var(--ink);" title="داكن / فاتح" aria-label="داكن / فاتح">
        <i id="darkLightIcon" class="ph ph-sun text-xl text-white"></i>
    </button>

    <div id="themePalette" class="hidden flex-col gap-5 p-5 rounded-2xl mb-2 min-w-[300px]" style="background:white; border:1px solid rgba(0,0,0,0.08); box-shadow:0 20px 60px rgba(0,0,0,0.15);">

        <div>
            <h6 class="text-[11px] font-bold uppercase tracking-widest mb-3" style="color:var(--ink-dim);">نمط التصميم</h6>
            <div class="grid grid-cols-2 gap-2">
                @php
                $architectures = [
                    'clean-minimal' => ['name' => 'نظيف', 'icon' => 'ph ph-sparkle', 'color' => '#DC2626'],
                    'cyber-lab' => ['name' => 'سايبر', 'icon' => 'ph ph-cpu', 'color' => '#ec4899'],
                    'organic-spa' => ['name' => 'طبيعة', 'icon' => 'ph ph-leaf', 'color' => '#10b981'],
                    'editorial' => ['name' => 'تحريري', 'icon' => 'ph ph-text-aa', 'color' => '#6b7280'],
                    'luxury-boutique' => ['name' => 'فخامة', 'icon' => 'ph ph-crown', 'color' => '#eab308'],
                ];
                $currentArch = $layoutArchitecture ?? 'clean-minimal';
                @endphp
                @foreach($architectures as $key => $arch)
                <button onclick="switchArchitecture('{{ $key }}')" data-arch="{{ $key }}" class="arch-btn text-right p-3 rounded-xl border-2 transition-all text-xs {{ $currentArch === $key ? 'border-current' : 'border-transparent hover:border-gray-200' }}" style="{{ $currentArch === $key ? 'background:var(--brand-50);color:var(--brand-500);' : 'background:#f9fafb;color:var(--ink-muted);' }}">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="{{ $arch['icon'] }} text-base" style="color:{{ $arch['color'] }};"></i>
                        <span class="font-bold">{{ $arch['name'] }}</span>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        <div>
            <h6 class="text-[11px] font-bold uppercase tracking-widest mb-3" style="color:var(--ink-dim);">لوحة الألوان</h6>
            <div class="flex gap-2 flex-wrap" id="colorPaletteContainer">
                @php
                $palettes = [
                    'clean' => ['name' => 'نظيف', 'color' => '#DC2626', 'arch' => 'clean-minimal'],
                    'rose' => ['name' => 'روز', 'color' => '#ec4899', 'arch' => 'cyber-lab'],
                    'midnight' => ['name' => 'ليلي', 'color' => '#7c3aed', 'arch' => 'cyber-lab'],
                    'natural' => ['name' => 'طبيعي', 'color' => '#10b981', 'arch' => 'organic-spa'],
                    'forest' => ['name' => 'غابة', 'color' => '#059669', 'arch' => 'organic-spa'],
                    'minimal' => ['name' => 'مينيمال', 'color' => '#6b7280', 'arch' => 'editorial'],
                    'ocean' => ['name' => 'محيط', 'color' => '#0ea5e9', 'arch' => 'editorial'],
                    'sunset' => ['name' => 'غروب', 'color' => '#f97316', 'arch' => 'luxury-boutique'],
                    'luxury' => ['name' => 'فخامة', 'color' => '#eab308', 'arch' => 'luxury-boutique'],
                ];
                $currentColor = $siteSettings['site_theme'] ?? 'clean';
                @endphp
                @foreach($palettes as $key => $p)
                <button onclick="switchColor('{{ $key }}')" data-color="{{ $key }}" data-arch="{{ $p['arch'] }}" class="color-btn w-9 h-9 rounded-full border-3 transition-all {{ $currentColor === $key ? 'border-gray-800 scale-110' : 'border-transparent opacity-70 hover:opacity-100 hover:scale-105' }}" style="background:{{ $p['color'] }};" title="{{ $p['name'] }}" aria-label="لون {{ $p['name'] }}"></button>
                @endforeach
            </div>
        </div>

        <div>
            <h6 class="text-[11px] font-bold uppercase tracking-widest mb-3" style="color:var(--ink-dim);">الخط</h6>
            <div class="flex gap-2 flex-wrap">
                @php
                $fonts = [
                    'Tajawal' => 'تجوال',
                    'Cairo' => 'قاهرة',
                    'El+Messiri' => 'المسيري',
                    'Changa' => 'تشانغا',
                ];
                @endphp
                @foreach($fonts as $fontKey => $fontName)
                <button onclick="switchFont('{{ $fontKey }}')" data-font="{{ $fontKey }}" class="font-btn px-3 py-2 rounded-lg border-2 text-xs transition-all" style="font-family:'{{ str_replace('+',' ',$fontKey) }}',sans-serif;background:#f9fafb;color:var(--ink-muted);border-color:transparent;">{{ $fontName }}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
#themePalette { animation: fadeUpTheme 0.25s ease; }
@keyframes fadeUpTheme { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
#themeToggleBtn:hover { box-shadow: 0 8px 24px rgba(220,38,38,0.3); }
.color-btn { border-width: 3px; }
.arch-btn.border-current { border-color: var(--brand-500); }
</style>

<script>
function setCookie(name, value, days) { var d = new Date(); d.setTime(d.getTime() + (days*86400000)); document.cookie = name + '=' + value + ';path=/;expires=' + d.toUTCString(); }
function getCookie(name) { var n = name + '='; var ca = document.cookie.split(';'); for(var i=0; i<ca.length; i++) { var c = ca[i].trim(); if(c.indexOf(n)===0) return c.substring(n.length); } return null; }

function toggleDarkLight() {
    var html = document.documentElement;
    var isLight = html.getAttribute('data-theme-mode') === 'light';
    if (isLight) {
        html.removeAttribute('data-theme-mode');
        localStorage.setItem('samahcare_mode', 'dark');
        setCookie('samahcare_mode', 'dark', 365);
        updateDarkLightIcon(false);
    } else {
        html.setAttribute('data-theme-mode', 'light');
        localStorage.setItem('samahcare_mode', 'light');
        setCookie('samahcare_mode', 'light', 365);
        updateDarkLightIcon(true);
    }
}

function updateDarkLightIcon(isLight) {
    var icon = document.getElementById('darkLightIcon');
    if (icon) {
        icon.className = isLight ? 'ph ph-moon text-xl' : 'ph ph-sun text-xl';
    }
    var btn = document.getElementById('darkLightBtn');
    if (btn) {
        btn.style.background = isLight ? '#1a1a1a' : 'var(--ink)';
    }
}

function toggleThemePalette() {
    var p = document.getElementById('themePalette');
    p.classList.contains('hidden') ? (p.classList.remove('hidden'), p.classList.add('flex')) : (p.classList.add('hidden'), p.classList.remove('flex'));
}

function switchArchitecture(arch) {
    var colorMap = { 'clean-minimal': ['clean'], 'cyber-lab': ['rose','midnight'], 'organic-spa': ['natural','forest'], 'editorial': ['minimal','ocean'], 'luxury-boutique': ['sunset','luxury'] };
    var defaults = { 'clean-minimal': 'clean', 'cyber-lab': 'rose', 'organic-spa': 'natural', 'editorial': 'minimal', 'luxury-boutique': 'sunset' };
    var currentColor = localStorage.getItem('samahcare_color') || defaults[arch] || 'clean';
    var compatibleColors = colorMap[arch] || [];
    if (compatibleColors.indexOf(currentColor) === -1) {
        currentColor = defaults[arch] || 'clean';
    }
    localStorage.setItem('samahcare_architecture', arch);
    localStorage.setItem('samahcare_color', currentColor);
    setCookie('samahcare_arch', arch, 365);
    setCookie('samahcare_color', currentColor, 365);
    location.reload();
}

function switchColor(color) {
    localStorage.setItem('samahcare_color', color);
    setCookie('samahcare_color', color, 365);
    location.reload();
}

function switchFont(font) {
    localStorage.setItem('samahcare_font', font);
    setCookie('samahcare_font', font, 365);
    var link = document.getElementById('googleFontsLink');
    if(link) {
        link.href = 'https://fonts.googleapis.com/css2?family=' + font.replace('+','+') + ':wght@300;400;500;700;800;900&display=swap';
        document.body.style.fontFamily = "'" + font.replace('+',' ') + "', sans-serif";
    }
    var btns = document.querySelectorAll('.font-btn');
    btns.forEach(function(b) { 
        b.style.background = '#f9fafb'; 
        b.style.color = 'var(--ink-muted)'; 
        b.style.borderColor = 'transparent'; 
    });
    var fb = document.querySelector('.font-btn[data-font="' + font + '"]');
    if(fb) { 
        fb.style.background = 'var(--brand-50)'; 
        fb.style.color = 'var(--brand-500)'; 
        fb.style.borderColor = 'var(--brand-500)'; 
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var savedArch = localStorage.getItem('samahcare_architecture') || 'clean-minimal';
    var savedColor = localStorage.getItem('samahcare_color') || 'clean';
    var savedFont = localStorage.getItem('samahcare_font') || 'Tajawal';
    var savedMode = localStorage.getItem('samahcare_mode') || 'light';

    var archBtns = document.querySelectorAll('.arch-btn');
    archBtns.forEach(function(b) { 
        b.style.background = '#f9fafb'; 
        b.style.color = 'var(--ink-muted)'; 
        b.classList.remove('border-current');
        b.classList.add('border-transparent');
    });
    var ab = document.querySelector('.arch-btn[data-arch="' + savedArch + '"]');
    if(ab) { 
        ab.style.background = 'var(--brand-50)'; 
        ab.style.color = 'var(--brand-500)'; 
        ab.classList.add('border-current');
        ab.classList.remove('border-transparent');
    }

    var colorBtns = document.querySelectorAll('.color-btn');
    colorBtns.forEach(function(b) { 
        b.classList.remove('border-gray-800','scale-110'); 
        b.classList.add('border-transparent','opacity-70'); 
    });
    var cb = document.querySelector('.color-btn[data-color="' + savedColor + '"]');
    if(cb) { 
        cb.classList.add('border-gray-800','scale-110'); 
        cb.classList.remove('border-transparent','opacity-70'); 
    }

    if(savedFont && savedFont !== 'Tajawal') {
        var link = document.getElementById('googleFontsLink');
        if(link) {
            link.href = 'https://fonts.googleapis.com/css2?family=' + savedFont.replace('+','+') + ':wght@300;400;500;700;800;900&display=swap';
            document.body.style.fontFamily = "'" + savedFont.replace('+',' ') + "', sans-serif";
        }
        var fb = document.querySelector('.font-btn[data-font="' + savedFont + '"]');
        if(fb) { 
            fb.style.background = 'var(--brand-50)'; 
            fb.style.color = 'var(--brand-500)'; 
            fb.style.borderColor = 'var(--brand-500)'; 
        }
    }

    if(savedMode === 'light') {
        updateDarkLightIcon(true);
    }
});

document.addEventListener('click', function(e) {
    var palette = document.getElementById('themePalette');
    var toggleBtn = document.getElementById('themeToggleBtn');
    if(palette && toggleBtn && !palette.contains(e.target) && !toggleBtn.contains(e.target)) {
        palette.classList.add('hidden'); palette.classList.remove('flex');
    }
});
</script>
