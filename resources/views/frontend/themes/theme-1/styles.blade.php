<style>
.t1-glass-header {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(183, 110, 121, 0.1);
    transition: all 0.3s ease;
}
.t1-glass-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(183, 110, 121, 0.1);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
}
.t1-glass-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px -10px rgba(183, 110, 121, 0.2);
    border-color: rgba(183, 110, 121, 0.3);
}
.t1-hero-overlay {
    background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0.2) 100%);
}
.t1-pattern-bg {
    background-color: #FFF0F5;
    background-image: radial-gradient(#B76E79 0.5px, transparent 0.5px);
    background-size: 20px 20px;
    opacity: 0.8;
}
.t1-nav-link { position: relative; }
.t1-nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -4px;
    right: 0;
    background: linear-gradient(135deg, #B76E79, #D4AF37);
    transition: width 0.3s ease;
}
.t1-nav-link:hover::after { width: 100%; left: 0; right: auto; }
.t1-service-img-mask {
    -webkit-mask-image: radial-gradient(circle, white 100%, black 100%);
    mask-image: radial-gradient(circle, white 100%, black 100%);
    overflow: hidden;
    border-radius: 20px 20px 0 0;
}
@keyframes t1FadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes t1Float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
}
.t1-animate-fade-up { animation: t1FadeInUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
.t1-animate-float { animation: t1Float 6s ease-in-out infinite; }
.t1-delay-100 { animation-delay: 0.1s; }
.t1-delay-200 { animation-delay: 0.2s; }
.t1-delay-300 { animation-delay: 0.3s; }
.t1-delay-400 { animation-delay: 0.4s; }
.t1-delay-500 { animation-delay: 0.5s; }
.t1-btn-primary {
    background: linear-gradient(135deg, #B76E79 0%, #D4AF37 100%);
    color: white;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.4s ease;
}
.t1-btn-primary::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(135deg, #D4AF37 0%, #B76E79 100%);
    z-index: -1;
    transition: opacity 0.4s ease;
    opacity: 0;
}
.t1-btn-primary:hover::before { opacity: 1; }
.t1-btn-primary:hover {
    box-shadow: 0 10px 20px -5px rgba(212, 175, 55, 0.4);
    transform: translateY(-2px);
}
.t1-btn-outline {
    border: 2px solid #B76E79;
    color: #B76E79;
    background: transparent;
    transition: all 0.3s ease;
}
.t1-btn-outline:hover {
    background: #B76E79;
    color: white;
    box-shadow: 0 10px 20px -5px rgba(183, 110, 121, 0.3);
}
.t1-text-gradient {
    background: linear-gradient(135deg, #B76E79 0%, #D4AF37 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
