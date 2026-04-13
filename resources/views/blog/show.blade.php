@extends('layouts.app')
@section('title', $article['title'])
@section('description', $article['excerpt'])
@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection

@section('content')

{{-- Hero article --}}
<section class="article-hero">
    <div class="container article-hero__inner">
        <nav class="breadcrumb reveal" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}">Accueil</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('blog.index') }}">Blog</a>
            <span aria-hidden="true">›</span>
            <span>{{ $article['tag'] }}</span>
        </nav>

        <span class="section-label reveal stagger-1" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);margin-top:16px;">
            {{ $article['tag'] }}
        </span>
        <h1 class="reveal stagger-2" style="color:#fff;margin-top:12px;max-width:800px;margin-inline:auto;">
            {{ $article['title'] }}
        </h1>

        <div class="article-hero__meta reveal stagger-3">
            <div class="article-hero__author">
                <div class="article-hero__author-avatar">{{ strtoupper(substr($article['author'], 0, 1)) }}</div>
                <div>
                    <span style="font-weight:600;font-size:14px;color:rgba(255,255,255,0.9);">{{ explode(' — ', $article['author'])[0] }}</span>
                    <span style="font-size:12px;color:rgba(255,255,255,0.5);display:block;">{{ explode(' — ', $article['author'])[1] ?? 'KapitalStark' }}</span>
                </div>
            </div>
            <div class="article-hero__stats">
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $article['date'] }}
                </span>
                <span class="article-hero__dot" aria-hidden="true"></span>
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $article['read'] }} de lecture
                </span>
                @if(!empty($article['sections']))
                <span class="article-hero__dot" aria-hidden="true"></span>
                <span>{{ count($article['sections']) }} sections</span>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Barre de progression lecture --}}
<div id="reading-progress" role="progressbar" aria-label="Progression de lecture" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>

{{-- Corps article --}}
<section class="article-body-section">
    <div class="container article-layout">

        {{-- Sidebar TOC (desktop) --}}
        @if(!empty($article['sections']))
        <aside class="article-toc" aria-label="Table des matières">
            <div class="article-toc__inner" id="toc-sticky">
                <p class="article-toc__title">Dans cet article</p>
                <nav>
                    <ol class="article-toc__list">
                        @foreach($article['sections'] as $i => $section)
                        <li>
                            <a href="#{{ $section['id'] }}" class="article-toc__link" id="toc-{{ $section['id'] }}">
                                <span class="article-toc__num font-mono">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                                {{ $section['title'] }}
                            </a>
                        </li>
                        @endforeach
                    </ol>
                </nav>
                <div class="article-toc__progress">
                    <div class="article-toc__progress-fill" id="toc-progress-fill"></div>
                </div>
                <a href="{{ route('contact.rdv') }}" class="btn btn-primary" style="width:100%;justify-content:center;font-size:13px;padding:12px;margin-top:16px;">
                    Parler à un conseiller
                </a>
            </div>
        </aside>
        @endif

        {{-- Article principal --}}
        <article class="article-main" id="article-content">

            {{-- Chapeau --}}
            <p class="article-lead">{{ $article['excerpt'] }}</p>

            @if(!empty($article['sections']))
                @foreach($article['sections'] as $i => $section)
                <section class="article-section" id="{{ $section['id'] }}">
                    <h2 class="article-section__title">
                        <span class="article-section__num font-mono">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                        {{ $section['title'] }}
                    </h2>
                    <div class="article-section__body">
                        {!! $section['body'] !!}
                    </div>
                </section>
                @endforeach
            @else
                <p>Cet article est en cours de rédaction. Revenez bientôt pour le contenu complet.</p>
            @endif

            {{-- CTA dans l'article --}}
            <div class="article-cta-box">
                <div class="article-cta-box__icon">💬</div>
                <div>
                    <h3 style="font-size:17px;margin-bottom:6px;">Besoin d'un conseil personnalisé ?</h3>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.6;">Nos conseillers KapitalStark sont disponibles pour étudier votre situation et vous proposer les meilleures solutions de financement.</p>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;flex-shrink:0;">
                    <a href="{{ route('simulator.index') }}" class="btn btn-outline" style="font-size:13px;padding:10px 18px;">Simuler</a>
                    <a href="{{ route('contact.rdv') }}" class="btn btn-primary" style="font-size:13px;padding:10px 18px;">Prendre RDV</a>
                </div>
            </div>

            {{-- Partage --}}
            <div class="article-share">
                <span class="article-share__label">Partager cet article</span>
                <div class="article-share__buttons">
                    <button class="article-share__btn" onclick="shareArticle('linkedin')" aria-label="Partager sur LinkedIn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        LinkedIn
                    </button>
                    <button class="article-share__btn" onclick="shareArticle('twitter')" aria-label="Partager sur Twitter/X">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        Twitter
                    </button>
                    <button class="article-share__btn" onclick="copyLink()" id="copy-btn" aria-label="Copier le lien">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                        Copier le lien
                    </button>
                </div>
            </div>

            {{-- Tags --}}
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:32px;">
                <span style="font-size:13px;color:var(--text-muted);font-weight:600;">Tags :</span>
                @foreach([$article['tag'], 'Finance', 'Crédit', 'Conseil'] as $tag)
                <a href="{{ route('blog.index') }}" class="blog-card__tag" style="text-decoration:none;">{{ $tag }}</a>
                @endforeach
            </div>

        </article>
    </div>
</section>

{{-- Articles similaires --}}
<section style="background:var(--cream);padding-block:60px 80px;">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">Lire aussi</span>
            <h2 class="section-title reveal stagger-1" style="font-size:32px;">Articles similaires</h2>
        </div>
        <div class="related-grid">
            @foreach($related as $i => $rel)
            <a href="{{ route('blog.show', $rel['slug']) }}" class="blog-card card reveal stagger-{{ $i+1 }}">
                <div class="blog-card__img">
                    <span class="blog-card__img-placeholder" style="font-size:36px;">{{ $rel['icon'] }}</span>
                    <div class="blog-card__img-overlay"></div>
                </div>
                <div class="blog-card__body">
                    <span class="blog-card__tag">{{ $rel['tag'] }}</span>
                    <h3 class="blog-card__title">{{ $rel['title'] }}</h3>
                    <div class="blog-card__meta" style="margin-top:8px;">
                        <span>{{ $rel['date'] }}</span>
                        <span class="blog-card__meta-dot"></span>
                        <span>{{ $rel['read'] }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    // ── Lecture progress bar ─────────────────────────────────
    var progressBar = document.getElementById('reading-progress');
    var article     = document.getElementById('article-content');

    function updateReadingProgress() {
        if (!article || !progressBar) return;
        var rect   = article.getBoundingClientRect();
        var total  = article.offsetHeight - window.innerHeight;
        var scrolled = -rect.top;
        var pct    = Math.max(0, Math.min(100, (scrolled / total) * 100));
        progressBar.style.width = pct + '%';
        progressBar.setAttribute('aria-valuenow', Math.round(pct));

        var fill = document.getElementById('toc-progress-fill');
        if (fill) fill.style.height = pct + '%';
    }

    // ── TOC active link ──────────────────────────────────────
    var sections = document.querySelectorAll('.article-section');
    function updateTocActive() {
        var scrollY = window.scrollY + 120;
        sections.forEach(function (sec) {
            var tocLink = document.getElementById('toc-' + sec.id);
            if (!tocLink) return;
            var top    = sec.offsetTop;
            var bottom = top + sec.offsetHeight;
            tocLink.classList.toggle('active', scrollY >= top && scrollY < bottom);
        });
    }

    window.addEventListener('scroll', function () {
        updateReadingProgress();
        updateTocActive();
    }, { passive: true });

    updateReadingProgress();
    updateTocActive();

    // ── TOC smooth scroll ────────────────────────────────────
    document.querySelectorAll('.article-toc__link').forEach(function (a) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            var target = document.getElementById(a.getAttribute('href').slice(1));
            if (target) {
                window.scrollTo({ top: target.offsetTop - 100, behavior: 'smooth' });
            }
        });
    });

    // ── Share ────────────────────────────────────────────────
    window.shareArticle = function (platform) {
        var url   = encodeURIComponent(window.location.href);
        var title = encodeURIComponent(document.title);
        var links = {
            linkedin: 'https://www.linkedin.com/sharing/share-offsite/?url=' + url,
            twitter:  'https://twitter.com/intent/tweet?url=' + url + '&text=' + title,
        };
        window.open(links[platform], '_blank', 'width=600,height=400');
    };

    window.copyLink = function () {
        navigator.clipboard.writeText(window.location.href).then(function () {
            var btn = document.getElementById('copy-btn');
            if (btn) {
                btn.textContent = 'Copié !';
                setTimeout(function () { btn.textContent = 'Copier le lien'; }, 2000);
            }
        });
    };
})();
</script>
@endsection
