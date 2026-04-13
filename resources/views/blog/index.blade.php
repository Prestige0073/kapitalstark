@extends('layouts.app')
@section('title', __('pages.blog.meta_title'))
@section('description', __('pages.blog.meta_desc'))
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages.css') }}">
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.blog.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.blog.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:560px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.blog.hero_sub') }}
        </p>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container">

        {{-- Filtres + recherche --}}
        @php
        $tags = array_values(array_unique(array_column($articles, 'tag')));
        @endphp
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:40px;padding-top:8px;" class="reveal">
            <div class="blog-filter-bar">
                <button class="blog-filter-btn active" data-tag="all">{{ __('pages.blog.filter_all') }}</button>
                @foreach($tags as $tag)
                <button class="blog-filter-btn" data-tag="{{ $tag }}">{{ $tag }}</button>
                @endforeach
            </div>
            <div class="blog-search" style="margin-left:auto;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="search" id="blog-search-input" placeholder="{{ __('pages.blog.search_ph') }}" aria-label="{{ __('pages.blog.search_aria') }}">
            </div>
        </div>

        {{-- Article featured --}}
        @if(count($articles) > 0)
        @php $featured = $articles[0]; @endphp
        <div class="blog-featured reveal" data-tag="{{ $featured['tag'] }}" style="margin-bottom:48px;">
            <a href="{{ route('blog.show', $featured['slug']) }}" class="blog-card card blog-featured-grid">
                <div class="blog-card__img" style="border-radius:0;aspect-ratio:auto;min-height:280px;">
                    <span style="font-size:80px;opacity:0.25;">{{ $featured['icon'] }}</span>
                    <div class="blog-card__img-overlay"></div>
                </div>
                <div class="blog-card__body" style="border:none;border-left:1px solid rgba(38,123,241,0.08);display:flex;flex-direction:column;justify-content:center;padding:40px;">
                    <span class="blog-card__tag">{{ $featured['tag'] }}</span>
                    <h2 class="blog-card__title" style="font-size:22px;font-family:var(--font-sans);">{{ $featured['title'] }}</h2>
                    <p class="blog-card__excerpt">{{ $featured['excerpt'] }}</p>
                    <div class="blog-card__meta" style="margin-bottom:20px;">
                        <span>{{ $featured['date'] }}</span>
                        <span class="blog-card__meta-dot"></span>
                        <span>{{ $featured['read'] }} {{ __('pages.blog.read_time') }}</span>
                    </div>
                    <span class="btn btn-primary" style="align-self:flex-start;pointer-events:none;">{{ __('pages.blog.read_more') }}</span>
                </div>
            </a>
        </div>
        @endif

        {{-- Grille articles --}}
        <div id="blog-grid" class="g-3" style="gap:24px;">
            @foreach(array_slice($articles, 1) as $i => $article)
            <a href="{{ route('blog.show', $article['slug']) }}"
               class="blog-card card reveal stagger-{{ ($i % 3) + 1 }}"
               data-tag="{{ $article['tag'] }}"
               data-title="{{ strtolower($article['title']) }} {{ strtolower($article['excerpt']) }}"
               style="text-decoration:none;color:inherit;">
                <div class="blog-card__img">
                    <span class="blog-card__img-placeholder" style="font-size:48px;">{{ $article['icon'] }}</span>
                    <div class="blog-card__img-overlay"></div>
                </div>
                <div class="blog-card__body">
                    <span class="blog-card__tag">{{ $article['tag'] }}</span>
                    <h3 class="blog-card__title">{{ $article['title'] }}</h3>
                    <p class="blog-card__excerpt">{{ $article['excerpt'] }}</p>
                    <div class="blog-card__meta">
                        <span>{{ $article['date'] }}</span>
                        <span class="blog-card__meta-dot"></span>
                        <span>{{ $article['read'] }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- État vide recherche --}}
        <div id="blog-empty" style="display:none;text-align:center;padding:60px 20px;">
            <p style="font-size:32px;margin-bottom:16px;">🔍</p>
            <h3 style="font-size:20px;margin-bottom:8px;">{{ __('pages.blog.no_results') }}</h3>
            <p style="color:var(--text-muted);font-size:15px;">{{ __('pages.blog.no_results_hint') }} <button onclick="resetFilters()" style="background:none;border:none;color:var(--blue);font-weight:600;cursor:pointer;font-size:15px;">{{ __('pages.blog.reset_filters') }}</button>.</p>
        </div>

    </div>
</section>

{{-- CTA newsletter --}}
<section style="background:var(--cream);padding-block:80px;">
    <div class="container" style="max-width:600px;text-align:center;">
        <span class="section-label reveal">{{ __('pages.blog.nl_label') }}</span>
        <h2 class="section-title reveal stagger-1" style="font-size:32px;">{{ __('pages.blog.nl_title') }}</h2>
        <p class="section-desc reveal stagger-2" style="margin-bottom:32px;">
            {{ __('pages.blog.nl_desc') }}
        </p>
        <form class="reveal stagger-3" data-newsletter data-source="blog" style="display:flex;gap:12px;max-width:440px;margin-inline:auto;flex-wrap:wrap;">
            <input type="email" placeholder="{{ __('pages.blog.nl_ph') }}" aria-label="{{ __('pages.blog.nl_ph') }}"
                   style="flex:1;min-width:200px;padding:13px 18px;border:2px solid rgba(38,123,241,0.15);border-radius:var(--radius-md);font-size:15px;outline:none;transition:border-color 0.2s;"
                   onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='rgba(38,123,241,0.15)'">
            <button type="submit" class="btn btn-primary" style="padding:13px 24px;">{{ __('pages.blog.nl_btn') }}</button>
        </form>
        <p style="font-size:12px;color:var(--text-muted);margin-top:12px;" class="reveal stagger-4">{{ __('pages.blog.nl_legal') }}</p>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    var filterBtns   = document.querySelectorAll('.blog-filter-btn');
    var cards        = document.querySelectorAll('#blog-grid .blog-card');
    var featured     = document.querySelector('.blog-featured');
    var emptyState   = document.getElementById('blog-empty');
    var searchInput  = document.getElementById('blog-search-input');
    var activeTag    = 'all';
    var searchQuery  = '';

    function applyFilters() {
        var visibleCount = 0;

        // Featured
        if (featured) {
            var fTag   = featured.getAttribute('data-tag');
            var show   = (activeTag === 'all' || fTag === activeTag);
            featured.style.display = show ? '' : 'none';
        }

        cards.forEach(function (card) {
            var tag   = card.getAttribute('data-tag') || '';
            var title = card.getAttribute('data-title') || '';
            var tagOk   = activeTag === 'all' || tag === activeTag;
            var searchOk = searchQuery === '' || title.indexOf(searchQuery) !== -1;
            var visible  = tagOk && searchOk;
            card.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });

        emptyState.style.display = visibleCount === 0 && !(featured && featured.style.display !== 'none') ? 'block' : 'none';
    }

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            activeTag = btn.getAttribute('data-tag');
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = searchInput.value.toLowerCase().trim();
            applyFilters();
        });
    }

    window.resetFilters = function () {
        filterBtns.forEach(function (b) { b.classList.remove('active'); });
        filterBtns[0] && filterBtns[0].classList.add('active');
        activeTag   = 'all';
        searchQuery = '';
        if (searchInput) searchInput.value = '';
        applyFilters();
    };
})();
</script>
@endsection
