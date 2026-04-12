@extends('layouts.app')
@section('title', __('pages.titles.legal'))
@section('description', __('pages.legal.description'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:60px 40px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">{{ __('pages.legal_chrome.home') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span>{{ __('pages.legal.breadcrumb') }}</span>
        </nav>
        <h1 style="color:#fff;">{{ __('pages.legal.page_title') }}</h1>
        <p style="color:rgba(255,255,255,0.55);margin-top:8px;font-size:14px;">{{ __('pages.legal_chrome.last_update') }} : {{ date('d/m/Y') }}</p>
    </div>
</section>

@php
$sections = trans('pages.legal.sections');
@endphp

<section style="background:var(--white);padding-block:0 80px;">
    <div class="container" style="max-width:1080px;">
        <div class="legal-layout">

            {{-- TOC sticky --}}
            <aside class="legal-toc" id="legal-toc">
                <div class="legal-toc__inner">
                    <p class="legal-toc__title">{{ __('pages.legal_chrome.toc_title') }}</p>
                    <nav>
                        @foreach($sections as $s)
                        <a class="legal-toc__link" href="#{{ $s['id'] }}" id="toc-{{ $s['id'] }}">{{ $s['title'] }}</a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Contenu --}}
            <div class="legal-content">
                @foreach($sections as $s)
                <div class="legal-section reveal" id="{{ $s['id'] }}">
                    <h2 class="legal-section__title">{{ $s['title'] }}</h2>
                    <p class="legal-section__body">{!! str_replace('{privacy_url}', route('privacy'), $s['content']) !!}</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
.legal-layout {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 48px;
    padding-top: 56px;
}
.legal-toc__inner {
    position: sticky;
    top: 100px;
    background: rgba(38,123,241,0.03);
    border: 1px solid rgba(38,123,241,0.1);
    border-radius: var(--radius-lg);
    padding: 24px;
}
.legal-toc__title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    margin-bottom: 14px;
}
.legal-toc__link {
    display: block;
    font-size: 13px;
    color: var(--text-muted);
    padding: 7px 10px;
    border-radius: 8px;
    transition: all 0.2s;
    margin-bottom: 2px;
    border-left: 2px solid transparent;
    text-decoration: none;
    line-height: 1.4;
}
.legal-toc__link:hover { color: var(--blue); background: rgba(38,123,241,0.05); }
.legal-toc__link.active { color: var(--blue); background: rgba(38,123,241,0.08); border-left-color: var(--blue); font-weight: 600; }

.legal-content { min-width: 0; }
.legal-section {
    padding-block: 36px;
    border-bottom: 1px solid rgba(38,123,241,0.07);
    scroll-margin-top: 110px;
}
.legal-section:last-child { border-bottom: none; }
.legal-section__title {
    font-size: 19px;
    font-family: var(--font-sans);
    font-weight: 700;
    color: var(--text);
    margin-bottom: 14px;
}
.legal-section__body {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.8;
}

@media (max-width: 1024px) {
    .legal-layout { grid-template-columns: 1fr; gap: 0; }
    .legal-toc    { display: none; }
}
</style>
<script>
(function () {
    'use strict';
    var links = document.querySelectorAll('.legal-toc__link');
    var ids   = Array.from(links).map(function (l) { return l.getAttribute('href').slice(1); });

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                links.forEach(function (l) { l.classList.remove('active'); });
                var active = document.querySelector('.legal-toc__link[href="#' + e.target.id + '"]');
                if (active) active.classList.add('active');
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });

    ids.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) observer.observe(el);
    });

    links.forEach(function (l) {
        l.addEventListener('click', function (e) {
            e.preventDefault();
            var id = l.getAttribute('href').slice(1);
            var el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        });
    });
})();
</script>
@endsection
