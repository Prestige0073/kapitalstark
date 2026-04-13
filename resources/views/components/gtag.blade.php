{{--
  Composant : Google Tag Manager + Google Ads gtag.js
  Insérer @include('components.gtag') dans <head> (snippet head) et après <body> (snippet noscript)
  Variable $gtagSection : 'head' (défaut) ou 'body'
--}}

@php
    $gtmId   = config('google_ads.gtm_container_id');
    $adsId   = config('google_ads.ads_id');
    $section = $gtagSection ?? 'head';
    $dataLayer = $dataLayer ?? [];
    $pageType  = $pageType ?? 'generic';
    $userLoggedIn = auth()->check();
@endphp

@if($section === 'head' && ($gtmId || $adsId))
<!-- Google Tag Manager -->
<script>
window.dataLayer = window.dataLayer || [];
@if(!empty($dataLayer))
dataLayer.push({{ json_encode($dataLayer, JSON_UNESCAPED_UNICODE) }});
@else
dataLayer.push({
    'page_type': '{{ $pageType }}',
    'user_logged_in': {{ $userLoggedIn ? 'true' : 'false' }}
});
@endif
@if($gtmId)
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $gtmId }}');
@endif
</script>
@if($adsId && !$gtmId)
<!-- Google Ads gtag.js (si pas de GTM) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $adsId }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{{ $adsId }}');
</script>
@endif
<!-- End Google Tag Manager -->
@endif

@if($section === 'body' && $gtmId)
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif

@if($section === 'events')
{{-- Événements de conversion JS — à placer avant </body> --}}
<script>
(function(){
    function gtag(){if(window.dataLayer){window.dataLayer.push(arguments);}}

    // Clic simulateur
    document.querySelectorAll('[data-gtag="simulator_click"], a[href*="simulateur"]').forEach(function(el){
        el.addEventListener('click', function(){
            gtag('event', 'simulator_click', {'event_category':'engagement','event_label':'simulateur'});
        });
    });

    // Clic téléphone
    document.querySelectorAll('a[href^="tel:"]').forEach(function(el){
        el.addEventListener('click', function(){
            gtag('event', 'phone_call', {'event_category':'conversion','event_label': el.href});
        });
    });

    // Téléchargement PDF
    document.querySelectorAll('a[href$=".pdf"], a[data-gtag="pdf_download"]').forEach(function(el){
        el.addEventListener('click', function(){
            gtag('event', 'pdf_download', {'event_category':'engagement','event_label': el.href || 'pdf'});
        });
    });

    // Scroll > 75%
    var scroll75Sent = false;
    window.addEventListener('scroll', function(){
        if (scroll75Sent) return;
        var scrolled = (window.scrollY + window.innerHeight) / document.body.scrollHeight;
        if (scrolled >= 0.75) {
            scroll75Sent = true;
            gtag('event', 'scroll_75', {'event_category':'engagement','event_label': window.location.pathname});
        }
    }, {passive: true});

    // Temps passé > 3 minutes
    setTimeout(function(){
        gtag('event', 'engagement_3min', {'event_category':'engagement','event_label': window.location.pathname});
    }, 180000);
})();
</script>
@endif
