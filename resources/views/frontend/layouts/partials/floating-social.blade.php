<div class="floating-social-v3">
    @if(!empty($siteSettings['facebook_url']))<a href="{{ $siteSettings['facebook_url'] }}" data-platform="facebook" target="_blank" aria-label="فيسبوك"><i class="ph-fill ph-facebook-logo"></i></a>@endif
    @if(!empty($siteSettings['instagram_url']))<a href="{{ $siteSettings['instagram_url'] }}" data-platform="instagram" target="_blank" aria-label="إنستغرام"><i class="ph-fill ph-instagram-logo"></i></a>@endif
    @if(!empty($siteSettings['twitter_url']))<a href="{{ $siteSettings['twitter_url'] }}" data-platform="twitter" target="_blank" aria-label="تويتر"><i class="ph-fill ph-twitter-logo"></i></a>@endif
    @if(!empty($siteSettings['tiktok_url']))<a href="{{ $siteSettings['tiktok_url'] }}" data-platform="tiktok" target="_blank" aria-label="تيك توك"><i class="ph-fill ph-tiktok-logo"></i></a>@endif
    @if(!empty($siteSettings['linkedin_url']))<a href="{{ $siteSettings['linkedin_url'] }}" data-platform="linkedin" target="_blank" aria-label="لينكد إن"><i class="ph-fill ph-linkedin-logo"></i></a>@endif
    @if(!empty($siteSettings['youtube_url']))<a href="{{ $siteSettings['youtube_url'] }}" data-platform="youtube" target="_blank" aria-label="يوتيوب"><i class="ph-fill ph-youtube-logo"></i></a>@endif
    @if(!empty($siteSettings['whatsapp_number']))<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" data-platform="whatsapp" target="_blank" aria-label="واتساب"><i class="ph-fill ph-whatsapp-logo"></i></a>@endif
</div>

<style>
.floating-social-v3 {
    position: fixed;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 9998;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.floating-social-v3 a {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.2rem;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid transparent;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.floating-social-v3 a[data-platform="facebook"] { background: #1877F2; border-color: #1877F2; }
.floating-social-v3 a[data-platform="instagram"] { background: linear-gradient(135deg, #833AB4, #E4405F, #FCAF45); border-color: #E4405F; }
.floating-social-v3 a[data-platform="twitter"] { background: #0F1419; border-color: #0F1419; }
.floating-social-v3 a[data-platform="tiktok"] { background: #000000; border-color: #000000; }
.floating-social-v3 a[data-platform="linkedin"] { background: #0A66C2; border-color: #0A66C2; }
.floating-social-v3 a[data-platform="youtube"] { background: #FF0000; border-color: #FF0000; }
.floating-social-v3 a[data-platform="whatsapp"] { background: #25D366; border-color: #25D366; }

.floating-social-v3 a:hover {
    transform: scale(1.15) translateX(5px);
    box-shadow: 0 6px 24px rgba(0,0,0,0.4);
}

@media (max-width: 768px) {
    .floating-social-v3 {
        left: 10px;
        bottom: 100px;
        top: auto;
        transform: none;
    }
    .floating-social-v3 a {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }
}
</style>
