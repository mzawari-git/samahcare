<style>
.t3-marquee {
    background: var(--neutral-800);
    color: var(--ink-inverse);
    overflow: hidden;
    white-space: nowrap;
    padding: 10px 0;
    font-family: var(--font-en);
    font-size: 0.75rem;
    font-weight: 300;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.t3-marquee-inner {
    display: inline-block;
    animation: t3Marquee 30s linear infinite;
}
.t3-marquee-inner span {
    margin: 0 3rem;
}
@keyframes t3Marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.t3-header {
    background: var(--header-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-bottom: var(--border-subtle);
    transition: all var(--transition-base);
}

.t3-menu-overlay {
    position: fixed;
    inset: 0;
    z-index: 100;
    background: var(--neutral-800);
    clip-path: circle(0% at 50% 0%);
    transition: clip-path 0.8s cubic-bezier(0.22, 1, 0.36, 1);
    display: flex;
    align-items: center;
    justify-content: center;
}
.t3-menu-overlay.active {
    clip-path: circle(150% at 50% 0%);
}
.t3-menu-overlay a {
    display: block;
    font-size: 2.5rem;
    font-weight: 300;
    color: var(--ink-inverse);
    padding: 0.5rem 0;
    transition: color var(--transition-fast);
    letter-spacing: 1px;
}
.t3-menu-overlay a:hover {
    color: var(--brand-400);
}

.t3-img-reveal {
    position: relative;
    overflow: hidden;
}
.t3-img-reveal::after {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--neutral-800);
    transform-origin: left;
    animation: t3CurtainReveal 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
@keyframes t3CurtainReveal {
    0% { transform: scaleX(1); transform-origin: left; }
    50% { transform: scaleX(1); transform-origin: left; }
    50.01% { transform-origin: right; }
    100% { transform: scaleX(0); transform-origin: right; }
}

.t3-btn-elegant {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 32px;
    background: var(--neutral-800);
    color: white;
    border: 1px solid var(--neutral-800);
    border-radius: 0;
    font-weight: 300;
    letter-spacing: 0.5px;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all var(--transition-slow);
    text-decoration: none;
    cursor: pointer;
}
.t3-btn-elegant::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: var(--brand-400);
    top: 100%;
    left: 0;
    transition: all 0.4s ease;
    z-index: -1;
}
.t3-btn-elegant:hover::after { top: 0; }
.t3-btn-elegant:hover { border-color: var(--brand-400); color: white; }
.t3-btn-elegant span,
.t3-btn-elegant i { position: relative; z-index: 2; }

.t3-btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 32px;
    background: transparent;
    color: var(--ink);
    border: 1px solid var(--neutral-800);
    border-radius: 0;
    font-weight: 300;
    letter-spacing: 0.5px;
    transition: all var(--transition-slow);
    text-decoration: none;
    cursor: pointer;
}
.t3-btn-outline:hover {
    background: var(--neutral-800);
    color: white;
}

.t3-minimal-input {
    background: transparent;
    border: none;
    border-bottom: 1px solid var(--neutral-200);
    border-radius: 0;
    color: var(--ink);
    padding: 1rem 0;
    font-size: 0.9375rem;
    font-weight: 300;
    width: 100%;
    transition: border-color var(--transition-fast);
}
.t3-minimal-input:focus {
    outline: none;
    border-bottom-color: var(--brand-400);
}
.t3-minimal-input::placeholder {
    color: var(--ink-dim);
    font-weight: 300;
}

.t3-reveal-up {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1), transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
}
.t3-reveal-up.visible {
    opacity: 1;
    transform: translateY(0);
}

.t3-service-number {
    font-family: var(--font-en);
    font-size: 6rem;
    font-weight: 300;
    line-height: 1;
    color: var(--neutral-200);
}

.t3-hero-image {
    border-radius: 100px 0 100px 0;
    overflow: hidden;
}

.t3-stat-item {
    border-top: 1px solid var(--neutral-200);
    padding-top: 1.5rem;
}

.t3-check-icon {
    width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--brand-50);
    color: var(--brand-400);
    font-size: 0.6rem;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .t3-menu-overlay a { font-size: 1.75rem; }
    .t3-service-number { font-size: 4rem; }
    .t3-hero-image { border-radius: 60px 0 60px 0; }
}
</style>
