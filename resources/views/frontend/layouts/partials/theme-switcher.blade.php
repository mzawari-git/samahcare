{{-- ═══════════════════════════════════════════════════════════════
     THEME SWITCHER — Professional Edition
     ═══════════════════════════════════════════════════════════════ --}}
<div id="themeSwitcher" class="fixed bottom-6 left-6 z-[9999] flex flex-col gap-3">
    
    {{-- Toggle Button --}}
    <button onclick="toggleThemePalette()" id="themeToggleBtn" class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg transition-all hover:scale-110 hover:shadow-xl" style="background: var(--gradient-primary);" title="تخصيص المظهر" aria-label="تخصيص المظهر">
        <i class="ph ph-paint-brush text-xl"></i>
    </button>

    {{-- Dark/Light Toggle --}}
    <button onclick="toggleDarkLight()" id="darkLightBtn" class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg transition-all hover:scale-110" style="background: var(--neutral-800); color: white;" title="داكن / فاتح" aria-label="داكن / فاتح">
        <i id="darkLightIcon" class="ph ph-sun text-xl"></i>
    </button>

    {{-- Palette Panel --}}
    <div id="themePalette" class="hidden flex-col gap-5 p-5 rounded-2xl mb-2 min-w-[300px] shadow-2xl" style="background: var(--surface); border: var(--border-subtle);">

        {{-- Architecture Picker --}}
        <div>
            <h6 class="text-xs font-bold uppercase tracking-wider mb-3" style="color: var(--ink-dim);">نمط التصميم</h6>
            <div class="grid grid-cols-2 gap-2">
                @php
                $architectures = [
                    'clean-minimal' => ['name' => 'أنيق', 'icon' => 'ph ph-sparkle', 'color' => '#dc4a6b'],
                    'cyber-lab' => ['name' => 'عصري', 'icon' => 'ph ph-cpu', 'color' => '#ec4899'],
                    'organic-spa' => ['name' => 'طبيعي', 'icon' => 'ph ph-leaf', 'color' => '#10b981'],
                    'editorial' => ['name' => 'كلاسيك', 'icon' => 'ph ph-text-aa', 'color' => '#64748b'],
                    'luxury-boutique' => ['name' => 'فاخر', 'icon' => 'ph ph-crown', 'color' => '#eab308'],
                ];
                $currentArch = $layoutArchitecture ?? 'clean-minimal';
                @endphp
                @foreach($architectures as $key => $arch)
                <button onclick="switchArchitecture('{{ $key }}')" data-arch="{{ $key }}" class="arch-btn text-right p-3 rounded-xl border-2 transition-all text-sm {{ $currentArch === $key ? 'border-[var(--brand-500)] bg-[var(--brand-50)]' : 'border-transparent hover:border-[var(--neutral-200)] bg-[var(--neutral-50)]' }}">
                    <div class="flex items-center gap-2">
                        <i class="{{ $arch['icon'] }} text-base" style="color: {{ $arch['color'] }};"></i>
                        <span class="font-semibold" style="color: var(--ink);">{{ $arch['name'] }}</span>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        {{-- Color Palette --}}
        <div>
            <h6 class="text-xs font-bold uppercase tracking-wider mb-3" style="color: var(--ink-dim);">اللون الرئيسي</h6>
            <div class="flex gap-2 flex-wrap" id="colorPaletteContainer">
                @php
                $palettes = [
                    'clean' => ['name' => 'وردي', 'color' => '#dc4a6b', 'arch' => 'clean-minimal'],
                    'rose' => ['name' => 'روز', 'color' => '#ec4899', 'arch' => 'cyber-lab'],
                    'midnight' => ['name' => 'ليلي', 'color' => '#8b5cf6', 'arch' => 'cyber-lab'],
                    'natural' => ['name' => 'طبيعي', 'color' => '#10b981', 'arch' => 'organic-spa'],
                    'forest' => ['name' => 'غابة', 'color' => '#059669', 'arch' => 'organic-spa'],
                    'minimal' => ['name' => 'رمادي', 'color' => '#64748b', 'arch' => 'editorial'],
                    'ocean' => ['name' => 'محيط', 'color' => '#0ea5e9', 'arch' => 'editorial'],
                    'sunset' => ['name' => 'غروب', 'color' => '#f97316', 'arch' => 'luxury-boutique'],
                    'luxury' => ['name' => 'ذهبي', 'color' => '#eab308', 'arch' => 'luxury-boutique'],
                ];
                $currentColor = $siteSettings['site_theme'] ?? 'clean';
                @endphp
                @foreach($palettes as $key => $p)
                <button onclick="switchColor('{{ $key }}')" data-color="{{ $key }}" data-arch="{{ $p['arch'] }}" class="color-btn w-9 h-9 rounded-full border-3 transition-all {{ $currentColor === $key ? 'border-[var(--ink)] scale-110 ring-2 ring-offset-2 ring-[var(--brand-500)]' : 'border-transparent opacity-70 hover:opacity-100 hover:scale-105' }}" style="background: {{ $p['color'] }};" title="{{ $p['name'] }}" aria-label="لون {{ $p['name'] }}"></button>
                @endforeach
            </div>
        </div>

        {{-- Font Picker --}}
        <div>
            <h6 class="text-xs font-bold uppercase tracking-wider mb-3" style="color: var(--ink-dim);">الخط</h6>
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
                <button onclick="switchFont('{{ $fontKey }}')" data-font="{{ $fontKey }}" class="font-btn px-3 py-2 rounded-lg border-2 text-sm font-semibold transition-all" style="font-family: '{{ str_replace('+', ' ', $fontKey) }}', sans-serif; background: var(--neutral-50); color: var(--ink-muted); border-color: transparent;">
                    {{ $fontName }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     STYLES
     ═══════════════════════════════════════════════════════════════ --}}
<style>
#themePalette {
    animation: themePanelIn 0.25s ease-out;
}

@keyframes themePanelIn {
    from { opacity: 0; transform: translateY(8px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

#themeToggleBtn:hover {
    box-shadow: 0 8px 24px -4px rgba(220, 74, 107, 0.4);
}

.color-btn {
    border-width: 3px;
}

.arch-btn {
    transition: all 0.2s ease;
}

.arch-btn:hover {
    transform: translateY(-1px);
}
</style>

{{-- ═══════════════════════════════════════════════════════════════
     SCRIPTS
     ═══════════════════════════════════════════════════════════════ --}}
<script>
// Cookie helpers
function setCookie(name, value, days) {
    var d = new Date();
    d.setTime(d.getTime() + (days * 86400000));
    document.cookie = name + '=' + value + ';path=/;expires=' + d.toUTCString();
}

function getCookie(name) {
    var n = name + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(n) === 0) return c.substring(n.length);
    }
    return null;
}

// Dark/Light toggle
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
        btn.style.background = isLight ? 'var(--neutral-800)' : 'var(--neutral-200)';
        btn.style.color = isLight ? 'white' : 'var(--ink)';
    }
}

// Palette toggle
function toggleThemePalette() {
    var p = document.getElementById('themePalette');
    if (p.classList.contains('hidden')) {
        p.classList.remove('hidden');
        p.classList.add('flex');
    } else {
        p.classList.add('hidden');
        p.classList.remove('flex');
    }
}

// Architecture switch
function switchArchitecture(arch) {
    var colorMap = {
        'clean-minimal': ['clean'],
        'cyber-lab': ['rose', 'midnight'],
        'organic-spa': ['natural', 'forest'],
        'editorial': ['minimal', 'ocean'],
        'luxury-boutique': ['sunset', 'luxury']
    };
    var defaults = {
        'clean-minimal': 'clean',
        'cyber-lab': 'rose',
        'organic-spa': 'natural',
        'editorial': 'minimal',
        'luxury-boutique': 'sunset'
    };
    
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

// Color switch
function switchColor(color) {
    localStorage.setItem('samahcare_color', color);
    setCookie('samahcare_color', color, 365);
    location.reload();
}

// Font switch
function switchFont(font) {
    localStorage.setItem('samahcare_font', font);
    setCookie('samahcare_font', font, 365);
    
    var link = document.getElementById('googleFontsLink');
    if (link) {
        link.href = 'https://fonts.googleapis.com/css2?family=' + font.replace('+', '+') + ':wght@300;400;500;700;800;900&display=swap';
        document.body.style.fontFamily = "'" + font.replace('+', ' ') + "', sans-serif";
    }
    
    var btns = document.querySelectorAll('.font-btn');
    btns.forEach(function(b) {
        b.style.background = 'var(--neutral-50)';
        b.style.color = 'var(--ink-muted)';
        b.style.borderColor = 'transparent';
    });
    
    var fb = document.querySelector('.font-btn[data-font="' + font + '"]');
    if (fb) {
        fb.style.background = 'var(--brand-50)';
        fb.style.color = 'var(--brand-600)';
        fb.style.borderColor = 'var(--brand-500)';
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    var savedArch = localStorage.getItem('samahcare_architecture') || 'clean-minimal';
    var savedColor = localStorage.getItem('samahcare_color') || 'clean';
    var savedFont = localStorage.getItem('samahcare_font') || 'Tajawal';
    var savedMode = localStorage.getItem('samahcare_mode') || 'light';

    // Update architecture buttons
    var archBtns = document.querySelectorAll('.arch-btn');
    archBtns.forEach(function(b) {
        b.classList.remove('border-[var(--brand-500)]', 'bg-[var(--brand-50)]');
        b.classList.add('border-transparent', 'bg-[var(--neutral-50)]');
    });
    var ab = document.querySelector('.arch-btn[data-arch="' + savedArch + '"]');
    if (ab) {
        ab.classList.add('border-[var(--brand-500)]', 'bg-[var(--brand-50)]');
        ab.classList.remove('border-transparent', 'bg-[var(--neutral-50)]');
    }

    // Update color buttons
    var colorBtns = document.querySelectorAll('.color-btn');
    colorBtns.forEach(function(b) {
        b.classList.remove('border-[var(--ink)]', 'scale-110', 'ring-2', 'ring-offset-2', 'ring-[var(--brand-500)]');
        b.classList.add('border-transparent', 'opacity-70');
    });
    var cb = document.querySelector('.color-btn[data-color="' + savedColor + '"]');
    if (cb) {
        cb.classList.add('border-[var(--ink)]', 'scale-110', 'ring-2', 'ring-offset-2', 'ring-[var(--brand-500)]');
        cb.classList.remove('border-transparent', 'opacity-70');
    }

    // Update font buttons
    if (savedFont && savedFont !== 'Tajawal') {
        var link = document.getElementById('googleFontsLink');
        if (link) {
            link.href = 'https://fonts.googleapis.com/css2?family=' + savedFont.replace('+', '+') + ':wght@300;400;500;700;800;900&display=swap';
            document.body.style.fontFamily = "'" + savedFont.replace('+', ' ') + "', sans-serif";
        }
        var fb = document.querySelector('.font-btn[data-font="' + savedFont + '"]');
        if (fb) {
            fb.style.background = 'var(--brand-50)';
            fb.style.color = 'var(--brand-600)';
            fb.style.borderColor = 'var(--brand-500)';
        }
    }

    // Update dark/light mode
    if (savedMode === 'light') {
        updateDarkLightIcon(true);
    }
});

// Close palette on outside click
document.addEventListener('click', function(e) {
    var palette = document.getElementById('themePalette');
    var toggleBtn = document.getElementById('themeToggleBtn');
    if (palette && toggleBtn && !palette.contains(e.target) && !toggleBtn.contains(e.target)) {
        palette.classList.add('hidden');
        palette.classList.remove('flex');
    }
});
</script>
