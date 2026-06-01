@extends($layoutPath)

@section('title', ($siteSettings['site_name'] ?? 'سماح كير') . ' | منصة الحجز والخدمات الجمالية')
@section('meta_description', 'سماح كير - وجهتك الأولى لحجز خدمات العناية بالبشرة والشعر والتجميل. احجزي موعدك الآن بسهولة.')
@section('meta_keywords', 'سماح كير, حجز موعد, عناية بالبشرة, عناية بالشعر, خدمات تجميل, فلسطين, صالون, جمال')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ $siteSettings['site_name'] ?? 'سماح كير' }}",
  "url": "{{ url('/') }}",
  "logo": "{{ $siteSettings['site_logo_url'] ?? asset('favicon-32x32.png') }}",
  "description": "منصة حجز خدمات التجميل والعناية بالبشرة",
  "address": { "@type": "PostalAddress", "addressLocality": "رام الله", "addressCountry": "PS" },
  "contactPoint": { "@type": "ContactPoint", "telephone": "{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}", "contactType": "customer service" },
  "sameAs": ["{{ $siteSettings['facebook_url'] ?? '#' }}", "{{ $siteSettings['instagram_url'] ?? '#' }}"]
}
</script>
@endpush

@section('content')

@include("frontend.themes.theme-" . ($activeTheme ?? 1) . ".hero")

@include("frontend.themes.theme-" . ($activeTheme ?? 1) . ".services", ['featuredServices' => $featuredServices ?? collect()])

@include("frontend.themes.theme-" . ($activeTheme ?? 1) . ".features")

@include("frontend.themes.theme-" . ($activeTheme ?? 1) . ".testimonials")

@include("frontend.themes.theme-" . ($activeTheme ?? 1) . ".booking-cta")

@endsection
