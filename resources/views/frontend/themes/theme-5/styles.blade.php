<style>
.t5-bg-grid {
    background-image:
        linear-gradient(to right, rgba(0, 85, 255, 0.06) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(0, 85, 255, 0.06) 1px, transparent 1px);
    background-size: 50px 50px;
}

.t5-bg-grid-dark {
    background-image:
        linear-gradient(to right, rgba(0, 229, 255, 0.08) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(0, 229, 255, 0.08) 1px, transparent 1px);
    background-size: 50px 50px;
}

@keyframes t5ScannerLine {
    0% { top: -2px; }
    100% { top: 100%; }
}

.t5-scanner-line {
    position: absolute;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--accent-400), transparent);
    box-shadow: 0 0 15px var(--accent-400), 0 0 30px rgba(0, 229, 255, 0.3);
    animation: t5ScannerLine 3s linear infinite;
    z-index: 5;
}

@keyframes t5PulseGlow {
    0%, 100% { text-shadow: 0 0 5px rgba(0, 229, 255, 0.2); }
    50% { text-shadow: 0 0 20px rgba(0, 229, 255, 0.8), 0 0 40px rgba(0, 229, 255, 0.4); }
}

.t5-pulse-text {
    animation: t5PulseGlow 2.5s ease-in-out infinite;
}

@keyframes t5PulseGlowBox {
    0%, 100% { box-shadow: 0 0 5px rgba(0, 229, 255, 0.2); }
    50% { box-shadow: 0 0 20px rgba(0, 229, 255, 0.5), 0 0 40px rgba(0, 229, 255, 0.2); }
}

.t5-pulse-glow-box {
    animation: t5PulseGlowBox 2.5s ease-in-out infinite;
}

.t5-btn-tech {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 32px;
    font-weight: 700;
    font-size: 0.9375rem;
    color: white;
    background: var(--neutral-900);
    border: 1px solid var(--accent-400);
    clip-path: polygon(0 0, 100% 0, 100% calc(100% - 12px), calc(100% - 12px) 100%, 0 100%);
    overflow: hidden;
    transition: all 0.4s ease;
    cursor: pointer;
    text-decoration: none;
    letter-spacing: 0.5px;
}

.t5-btn-tech::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 229, 255, 0.4), transparent);
    transition: left 0.5s ease;
}

.t5-btn-tech:hover::before {
    left: 100%;
}

.t5-btn-tech:hover {
    box-shadow: 0 0 20px rgba(0, 229, 255, 0.5), 0 0 40px rgba(0, 229, 255, 0.2);
    border-color: var(--accent-400);
    color: white;
}

.t5-btn-tech-outline {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 32px;
    font-weight: 700;
    font-size: 0.9375rem;
    color: var(--accent-400);
    background: transparent;
    border: 1px solid var(--accent-400);
    clip-path: polygon(0 0, 100% 0, 100% calc(100% - 12px), calc(100% - 12px) 100%, 0 100%);
    overflow: hidden;
    transition: all 0.4s ease;
    cursor: pointer;
    text-decoration: none;
}

.t5-btn-tech-outline:hover {
    background: rgba(0, 229, 255, 0.1);
    box-shadow: 0 0 20px rgba(0, 229, 255, 0.3);
    color: var(--accent-400);
}

.t5-crosshair {
    position: relative;
}

.t5-crosshair::before,
.t5-crosshair::after {
    content: '';
    position: absolute;
    background: var(--accent-400);
    opacity: 0.4;
}

.t5-crosshair::before {
    width: 1px;
    height: 40px;
    top: -50px;
    left: 50%;
}

.t5-crosshair::after {
    width: 40px;
    height: 1px;
    top: -30px;
    left: calc(50% - 20px);
}

.t5-card-tech {
    background: var(--surface-elevated);
    border: 1px solid var(--neutral-100);
    clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%);
    transition: all 0.4s ease;
}

.t5-card-tech:hover {
    border-color: var(--accent-400);
    box-shadow: 0 0 20px rgba(0, 229, 255, 0.3);
    transform: translateY(-4px);
}

.t5-tech-label {
    font-family: var(--font-en);
    font-size: 0.6875rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--accent-400);
}

.t5-tech-tag {
    display: inline-block;
    padding: 4px 12px;
    font-family: var(--font-en);
    font-size: 0.6875rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--accent-400);
    border: 1px solid rgba(0, 229, 255, 0.3);
    background: rgba(0, 229, 255, 0.05);
}

@keyframes t5Reveal {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.t5-reveal {
    animation: t5Reveal 0.8s cubic-bezier(0.5, 0, 0, 1) forwards;
    opacity: 0;
}

.t5-reveal-d1 { animation-delay: 0.1s; }
.t5-reveal-d2 { animation-delay: 0.2s; }
.t5-reveal-d3 { animation-delay: 0.3s; }
.t5-reveal-d4 { animation-delay: 0.4s; }
.t5-reveal-d5 { animation-delay: 0.5s; }

.t5-panel {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: var(--border-subtle);
    border-radius: var(--radius-lg);
}

.t5-input-tech {
    width: 100%;
    padding: 14px 16px;
    background: var(--neutral-50);
    border: 1px solid var(--neutral-100);
    border-radius: var(--radius-sm);
    color: var(--ink);
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.t5-input-tech:focus {
    border-color: var(--brand-500);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 85, 255, 0.1);
}

.t5-grayscale-img {
    filter: grayscale(100%);
    transition: filter 0.5s ease;
}

.t5-grayscale-img:hover {
    filter: grayscale(0%);
}

.t5-nav-link {
    position: relative;
    color: var(--ink);
    transition: color 0.3s ease;
}

.t5-nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -4px;
    right: 0;
    background: var(--accent-400);
    transition: width 0.3s ease;
}

.t5-nav-link:hover {
    color: var(--accent-400);
}

.t5-nav-link:hover::after {
    width: 100%;
    left: 0;
    right: auto;
}

.t5-gradient-text {
    background: var(--gradient-primary);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.t5-divider-gradient {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--accent-400), var(--brand-500), transparent);
}

@keyframes t5DataFlicker {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.t5-data-flicker {
    animation: t5DataFlicker 2s ease-in-out infinite;
}
</style>
