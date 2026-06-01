<footer class="pt-16 pb-8 relative overflow-hidden" style="background: #050B14;">
    <div class="t5-bg-grid-dark absolute inset-0 opacity-30"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-8">
            <div class="w-12 h-12 flex items-center justify-center" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.3); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%);">
                <i class="fas fa-microchip text-xl" style="color: var(--accent-400);"></i>
            </div>
            <div class="flex flex-col leading-tight text-right">
                <span class="text-xl font-bold text-white">{{ $siteSettings['site_name'] ?? 'سماح' }}</span>
                <span class="t5-tech-label" style="font-size: 0.6rem;">Clinic Sys_</span>
            </div>
        </a>

        <p class="text-sm mb-10 max-w-md mx-auto" style="color: var(--neutral-400);">
            نقدم أحدث تقنيات الليزر والعناية بالبشرة بأعلى المعايير الطبية العالمية
        </p>

        <div class="flex flex-wrap justify-center gap-6 mb-10">
            <a href="{{ route('home') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">Home</a>
            <a href="{{ route('booking') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">Booking</a>
            <a href="{{ route('blog.index') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">Blog</a>
            <a href="{{ route('contact') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">Contact</a>
            <a href="{{ route('faq') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">FAQ</a>
            <a href="{{ route('privacy') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">Privacy</a>
            <a href="{{ route('terms') }}" class="text-xs font-bold tracking-widest uppercase transition-colors" style="color: var(--neutral-400); font-family: var(--font-en);" onmouseover="this.style.color='var(--accent-400)'" onmouseout="this.style.color='var(--neutral-400)'">Terms</a>
        </div>

        <div class="t5-divider-gradient mb-8"></div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs" style="color: var(--neutral-600); font-family: var(--font-en);">
                &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. ALL RIGHTS RESERVED.
            </p>
            <p class="text-xs tracking-widest uppercase" style="color: rgba(0, 229, 255, 0.4); font-family: var(--font-en);">
                Powered by Advanced Med-Tech
            </p>
        </div>

        <div class="flex justify-center gap-4 mt-8">
            @if(!empty($siteSettings['instagram_url']))
            <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center transition-all duration-300" style="background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.15); color: var(--neutral-400);" onmouseover="this.style.borderColor='var(--accent-400)';this.style.color='var(--accent-400)';this.style.boxShadow='0 0 15px rgba(0,229,255,0.3)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.15)';this.style.color='var(--neutral-400)';this.style.boxShadow='none'"><i class="fab fa-instagram text-sm"></i></a>
            @endif
            @if(!empty($siteSettings['facebook_url']))
            <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center transition-all duration-300" style="background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.15); color: var(--neutral-400);" onmouseover="this.style.borderColor='var(--accent-400)';this.style.color='var(--accent-400)';this.style.boxShadow='0 0 15px rgba(0,229,255,0.3)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.15)';this.style.color='var(--neutral-400)';this.style.boxShadow='none'"><i class="fab fa-facebook-f text-sm"></i></a>
            @endif
            @if(!empty($siteSettings['tiktok_url']))
            <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center transition-all duration-300" style="background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.15); color: var(--neutral-400);" onmouseover="this.style.borderColor='var(--accent-400)';this.style.color='var(--accent-400)';this.style.boxShadow='0 0 15px rgba(0,229,255,0.3)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.15)';this.style.color='var(--neutral-400)';this.style.boxShadow='none'"><i class="fab fa-tiktok text-sm"></i></a>
            @endif
            @if(!empty($siteSettings['whatsapp_number']))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-9 h-9 flex items-center justify-center transition-all duration-300" style="background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.15); color: var(--neutral-400);" onmouseover="this.style.borderColor='var(--accent-400)';this.style.color='var(--accent-400)';this.style.boxShadow='0 0 15px rgba(0,229,255,0.3)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.15)';this.style.color='var(--neutral-400)';this.style.boxShadow='none'"><i class="fab fa-whatsapp text-sm"></i></a>
            @endif
        </div>
    </div>
</footer>
