<style>
.t2-arch {
    border-radius: 200px 200px 0 0;
    overflow: hidden;
}

.t2-text-outline {
    -webkit-text-stroke: 2px var(--accent-400);
    -webkit-text-fill-color: transparent;
    opacity: 0.08;
    font-family: var(--font-en);
    font-weight: 700;
    user-select: none;
    pointer-events: none;
}

.t2-btn-luxury {
    background-color: var(--brand-500);
    color: var(--accent-400);
    border: 1px solid var(--brand-500);
    border-radius: 0;
    padding: 14px 32px;
    font-weight: 600;
    font-size: 0.9375rem;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
}

.t2-btn-luxury::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 0%;
    background-color: var(--accent-400);
    transition: height 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    z-index: -1;
}

.t2-btn-luxury:hover {
    color: var(--brand-500);
    border-color: var(--accent-400);
}

.t2-btn-luxury:hover::before {
    height: 100%;
}

.t2-reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s cubic-bezier(0.165, 0.84, 0.44, 1), transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.t2-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

.t2-reveal-delay-1 { transition-delay: 0.1s; }
.t2-reveal-delay-2 { transition-delay: 0.2s; }
.t2-reveal-delay-3 { transition-delay: 0.3s; }
.t2-reveal-delay-4 { transition-delay: 0.4s; }

.t2-scroll-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: var(--ink-dim);
    font-size: 0.75rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    font-family: var(--font-en);
}

.t2-scroll-indicator .t2-scroll-line {
    width: 1px;
    height: 60px;
    background: var(--accent-400);
    position: relative;
    overflow: hidden;
}

.t2-scroll-indicator .t2-scroll-line::after {
    content: '';
    position: absolute;
    top: -100%;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--brand-500);
    animation: t2ScrollLine 2s ease-in-out infinite;
}

@keyframes t2ScrollLine {
    0% { top: -100%; }
    50% { top: 100%; }
    100% { top: 100%; }
}

.t2-decor-line {
    width: 60px;
    height: 1px;
    background: var(--accent-400);
    display: inline-block;
}

.t2-img-zoom {
    overflow: hidden;
}

.t2-img-zoom img,
.t2-img-zoom .t2-img-placeholder {
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.t2-img-zoom:hover img,
.t2-img-zoom:hover .t2-img-placeholder {
    transform: scale(1.08);
}

.t2-nav-link {
    position: relative;
    color: var(--ink);
    font-weight: 500;
    transition: color 0.3s ease;
}

.t2-nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 1px;
    bottom: -4px;
    right: 0;
    background: var(--accent-400);
    transition: width 0.3s ease;
}

.t2-nav-link:hover {
    color: var(--accent-400);
}

.t2-nav-link:hover::after {
    width: 100%;
    left: 0;
    right: auto;
}

.t2-header {
    background: var(--header-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-bottom: var(--border-subtle);
    transition: all 0.3s ease;
}

.t2-header.scrolled {
    box-shadow: var(--shadow-md);
    background: rgba(250, 248, 245, 0.98);
}

.t2-fullscreen-menu {
    position: fixed;
    inset: 0;
    background: var(--brand-500);
    z-index: 100;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s ease;
}

.t2-fullscreen-menu.active {
    opacity: 1;
    pointer-events: all;
}

.t2-fullscreen-menu a {
    color: var(--ink-inverse);
    font-size: 2rem;
    font-weight: 700;
    transition: color 0.3s ease;
    text-decoration: none;
}

.t2-fullscreen-menu a:hover {
    color: var(--accent-400);
}

.t2-input-luxury {
    background: var(--neutral-100);
    border: none;
    border-radius: 0;
    padding: 14px 16px;
    color: var(--ink);
    font-size: 0.9375rem;
    width: 100%;
    transition: all 0.2s ease;
}

.t2-input-luxury:focus {
    outline: none;
    box-shadow: 0 2px 0 0 var(--accent-400);
}

.t2-input-luxury::placeholder {
    color: var(--ink-dim);
}

.t2-underlined-input {
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 0;
    padding: 12px 0;
    color: white;
    font-size: 0.9375rem;
    width: 100%;
    transition: all 0.3s ease;
}

.t2-underlined-input:focus {
    outline: none;
    border-bottom-color: var(--accent-400);
}

.t2-underlined-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.t2-service-number {
    font-family: var(--font-en);
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: var(--accent-400);
}

.t2-underline-link {
    color: var(--ink);
    font-weight: 600;
    text-decoration: none;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 2px;
    border-bottom: 1px solid var(--accent-400);
    transition: color 0.3s ease, gap 0.3s ease;
}

.t2-underline-link:hover {
    color: var(--accent-400);
    gap: 12px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var reveals = document.querySelectorAll('.t2-reveal');
    if (!reveals.length) return;
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(function(el) { observer.observe(el); });
});
</script>
