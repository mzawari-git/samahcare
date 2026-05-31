<div id="themeToast" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[99999] px-6 py-3 rounded-xl shadow-2xl text-white font-bold text-sm transition-all duration-500 opacity-0 -translate-y-4 pointer-events-none flex items-center gap-3" style="background: var(--ink); backdrop-filter: blur(12px);">
    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--brand-500);">
        <i class="ph ph-paint-brush text-lg text-white"></i>
    </div>
    <div>
        <span id="themeToastText">تم تغيير التصميم</span>
        <div class="text-xs opacity-60 mt-0.5">Ctrl + 1-5 للتبديل بين التصاميم</div>
    </div>
</div>

<style>
#themeToast.show {
    opacity: 1 !important;
    transform: translate(-50%, 0) !important;
}
</style>
