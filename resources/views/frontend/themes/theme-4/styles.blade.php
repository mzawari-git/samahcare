<style>
.t4-blob-shape {
    border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
    animation: t4Morph 8s ease-in-out infinite;
}
.t4-blob-shape-2 {
    border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%;
    animation: t4Morph2 10s ease-in-out infinite;
}
@keyframes t4Morph {
    0% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
    50% { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; }
    100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
}
@keyframes t4Morph2 {
    0% { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; }
    50% { border-radius: 40% 60% 30% 70% / 60% 40% 60% 40%; }
    100% { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; }
}
.t4-btn-nature {
    background: var(--brand-800);
    color: var(--neutral-50);
    border: 1px solid var(--brand-800);
    border-radius: var(--radius-full);
    padding: 14px 32px;
    font-weight: 600;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.4s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    text-decoration: none;
}
.t4-btn-nature::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: var(--brand-500);
    z-index: -1;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.5s ease;
}
.t4-btn-nature:hover::before {
    transform: scaleX(1);
    transform-origin: left;
}
.t4-btn-nature:hover {
    border-color: var(--brand-500);
    box-shadow: 0 10px 24px rgba(44, 62, 45, 0.25);
    color: white;
}
.t4-btn-outline {
    background: transparent;
    color: var(--brand-800);
    border: 1px solid var(--brand-800);
    border-radius: var(--radius-full);
    padding: 14px 32px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    text-decoration: none;
}
.t4-btn-outline:hover {
    background: var(--brand-800);
    color: var(--neutral-50);
}
.t4-bg-lines {
    background-image: repeating-linear-gradient(
        -45deg,
        transparent,
        transparent 40px,
        rgba(92, 113, 94, 0.04) 40px,
        rgba(92, 113, 94, 0.04) 41px
    );
}
.t4-leaf-input {
    background: var(--neutral-100);
    border: 1px solid transparent;
    border-radius: 20px 2px 20px 2px;
    color: var(--ink);
    padding: 1rem 1.5rem;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    width: 100%;
}
.t4-leaf-input:focus {
    outline: none;
    border-color: var(--brand-500);
    background: var(--neutral-50);
    box-shadow: 0 0 0 3px rgba(92, 113, 94, 0.1);
}
.t4-leaf-input::placeholder {
    color: var(--ink-dim);
}
@keyframes t4FadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes t4Float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}
@keyframes t4FloatSlow {
    0% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-8px) rotate(3deg); }
    100% { transform: translateY(0px) rotate(0deg); }
}
.t4-fade-up {
    animation: t4FadeUp 0.8s ease-out forwards;
    opacity: 0;
}
.t4-float {
    animation: t4Float 6s ease-in-out infinite;
}
.t4-float-slow {
    animation: t4FloatSlow 8s ease-in-out infinite;
}
.t4-delay-100 { animation-delay: 0.1s; }
.t4-delay-200 { animation-delay: 0.2s; }
.t4-delay-300 { animation-delay: 0.3s; }
.t4-delay-400 { animation-delay: 0.4s; }
.t4-delay-500 { animation-delay: 0.5s; }
.t4-nav-link {
    position: relative;
    transition: color 0.3s ease;
}
.t4-nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -4px;
    right: 0;
    background: var(--brand-500);
    border-radius: 2px;
    transition: width 0.3s ease;
}
.t4-nav-link:hover::after {
    width: 100%;
    left: 0;
    right: auto;
}
.t4-glass-dark {
    background: rgba(44, 62, 45, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(137, 159, 138, 0.2);
}
.t4-pill-header {
    background: rgba(244, 241, 237, 0.8);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(230, 226, 221, 0.5);
    border-radius: var(--radius-full);
    transition: all 0.3s ease;
}
.t4-text-gradient {
    background: var(--gradient-primary);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
.t4-card-nature {
    background: var(--surface-elevated);
    border: var(--border-subtle);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: all 0.4s ease;
}
.t4-card-nature:hover {
    border-color: var(--brand-500);
    box-shadow: var(--shadow-lg);
    transform: translateY(-6px);
}
.t4-topo-line {
    stroke: rgba(137, 159, 138, 0.15);
    stroke-width: 1;
    fill: none;
}
</style>
