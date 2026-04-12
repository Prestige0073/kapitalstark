@extends('layouts.app')
@section('title', __('pages.titles.testimonials'))
@section('description', __('pages.testimonials.hero_sub'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/testimonials.css') }}">
@endsection

@section('content')

{{-- ── Hero ─────────────────────────────────────────────────── --}}
<section class="tm-hero">
    <div class="container">
        <div class="tm-hero__label">{{ __('pages.testimonials.hero_label') }}</div>
        <h1 class="tm-hero__title">{{ __('pages.testimonials.hero_title') }}</h1>
        <p class="tm-hero__sub">{{ __('pages.testimonials.hero_sub') }}</p>

        <div class="tm-hero__stats">
            <div class="tm-hero__stat">
                <div class="tm-hero__stat-val">{{ count($testimonials) }}+</div>
                <div class="tm-hero__stat-lbl">{{ __('pages.testimonials.stat_count') }}</div>
            </div>
            <div class="tm-hero__stat">
                <div class="tm-hero__stat-val">{{ count(array_unique(array_column($testimonials, 'country'))) }}</div>
                <div class="tm-hero__stat-lbl">{{ __('pages.testimonials.stat_countries') }}</div>
            </div>
            <div class="tm-hero__stat">
                <div class="tm-hero__stat-val">5</div>
                <div class="tm-hero__stat-lbl">{{ __('pages.testimonials.stat_languages') }}</div>
            </div>
            <div class="tm-hero__stat">
                <div class="tm-hero__stat-val">4,9/5</div>
                <div class="tm-hero__stat-lbl">{{ __('pages.testimonials.stat_rating') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ── Filters ──────────────────────────────────────────────── --}}
<div class="tm-filters">
    <div class="container">
        <div class="tm-filters__inner">
            <span class="tm-filter-label">{{ __('pages.testimonials.filter_region') }}</span>
            <div class="tm-filter-group">
                <button class="tm-filter-btn active" data-filter="region" data-value="all">{{ __('pages.testimonials.filter_all') }}</button>
                <button class="tm-filter-btn" data-filter="region" data-value="europe">Europe</button>
                <button class="tm-filter-btn" data-filter="region" data-value="americas">Amériques</button>
            </div>

            <div class="tm-filter-sep"></div>

            <span class="tm-filter-label">{{ __('pages.testimonials.filter_loan') }}</span>
            <div class="tm-filter-group">
                <button class="tm-filter-btn active" data-filter="loan" data-value="all">{{ __('pages.testimonials.filter_all') }}</button>
                @foreach($loanTypes as $slug => $label)
                <button class="tm-filter-btn" data-filter="loan" data-value="{{ $slug }}">{{ $label }}</button>
                @endforeach
            </div>

            <span class="tm-filter-count" id="tm-count"
                  data-singular="{{ __('pages.testimonials.count_singular') }}"
                  data-plural="{{ __('pages.testimonials.count_plural') }}">{{ count($testimonials) }} {{ __('pages.testimonials.count_plural') }}</span>
        </div>
    </div>
</div>

{{-- ── Grid ─────────────────────────────────────────────────── --}}
<section class="tm-section">
    <div class="container">
        <div class="tm-grid" id="tm-grid">

            @foreach($testimonials as $t)
            <div class="tm-card"
                 data-region="{{ $t['region'] }}"
                 data-loan="{{ $t['loan_type'] }}">
                <div class="tm-card__stars">{{ str_repeat('★', $t['stars']) }}{{ $t['stars'] < 5 ? str_repeat('☆', 5 - $t['stars']) : '' }}</div>
                <p class="tm-card__text">{{ $t['text'] }}</p>
                <div class="tm-card__footer">
                    <div class="tm-card__avatar">{{ strtoupper(substr($t['name'], 0, 1)) }}{{ strtoupper(substr(strrchr($t['name'], ' '), 1, 1)) }}</div>
                    <div class="tm-card__info">
                        <div class="tm-card__name">{{ $t['name'] }}</div>
                        <div class="tm-card__role">{{ $t['role'] }} · {{ $t['city'] }}</div>
                    </div>
                </div>
                <div class="tm-card__tags">
                    <span class="tm-card__loan">{{ $t['loan'] }}</span>
                    <span class="tm-card__country">{{ $t['country_code'] }} · {{ $t['country'] }}</span>
                </div>
            </div>
            @endforeach

        </div>

        <p class="tm-no-results" id="tm-no-results">{{ __('pages.testimonials.no_results') }}</p>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
  const grid    = document.getElementById('tm-grid');
  const cards   = grid ? [...grid.querySelectorAll('.tm-card')] : [];
  const counter = document.getElementById('tm-count');
  const noRes   = document.getElementById('tm-no-results');

  let activeRegion = 'all';
  let activeLoan   = 'all';

  function applyFilters() {
    let visible = 0;
    cards.forEach(card => {
      const matchRegion = activeRegion === 'all' || card.dataset.region === activeRegion;
      const matchLoan   = activeLoan   === 'all' || card.dataset.loan   === activeLoan;
      const show = matchRegion && matchLoan;
      card.hidden = !show;
      if (show) visible++;
    });
    if (counter) {
      const singular = counter.dataset.singular;
      const plural   = counter.dataset.plural;
      counter.textContent = visible + ' ' + (visible !== 1 ? plural : singular);
    }
    if (noRes) noRes.classList.toggle('visible', visible === 0);
  }

  document.querySelectorAll('.tm-filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const filter = this.dataset.filter;
      const value  = this.dataset.value;

      // Deactivate siblings in the same group
      this.closest('.tm-filter-group').querySelectorAll('.tm-filter-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      if (filter === 'region') activeRegion = value;
      if (filter === 'loan')   activeLoan   = value;

      applyFilters();
    });
  });
})();
</script>
@endsection
