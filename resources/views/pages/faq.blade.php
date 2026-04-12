@extends('layouts.app')
@section('title', __('pages.titles.faq'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--blue-dark),var(--navy));">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.faq.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.faq.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:560px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.faq.hero_sub') }}
        </p>
        <div class="faq-search reveal stagger-3" style="margin-top:32px;">
            <input type="text" id="faq-search" placeholder="{{ __('pages.faq.search_ph') }}" class="faq-search__input" aria-label="{{ __('pages.faq.search_aria') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        </div>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container faq-page">

        {{-- Catégories --}}
        <div class="faq-cats reveal" style="margin-bottom:48px;">
            <button class="faq-cat active" data-cat="__all__">{{ __('pages.faq.cat_all') }}</button>
            @foreach(trans('pages.faq.cats') as $cat)
            <button class="faq-cat" data-cat="{{ $cat }}">{{ $cat }}</button>
            @endforeach
        </div>

        @php $faqs = trans('pages.faq.items'); @endphp

        <div class="faq-list" id="faq-list">
            @foreach($faqs as $i => $item)
            <div class="faq-item reveal stagger-{{ ($i % 5) + 1 }}" data-cat="{{ $item['cat'] }}">
                <button class="faq-item__q" aria-expanded="false">
                    <span>{{ $item['q'] }}</span>
                    <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="faq-item__a">
                    <p>{{ $item['r'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div id="faq-empty" style="display:none;text-align:center;padding:60px 0;color:var(--text-muted);">
            <p style="font-size:40px;">🔍</p>
            <p style="margin-top:16px;font-size:16px;">{{ __('pages.faq.empty') }} <a href="/contact" style="color:var(--blue);">{{ __('pages.faq.empty_link') }}</a></p>
        </div>

    </div>
</section>

{{-- CTA --}}
<section style="background:var(--cream);padding-block:80px;text-align:center;">
    <div class="container">
        <h2 class="reveal">{{ __('pages.faq.cta_h2') }}</h2>
        <p class="reveal stagger-1" style="color:var(--text-muted);margin-top:12px;margin-bottom:32px;">{{ __('pages.faq.cta_p') }}</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;" class="reveal stagger-2">
            <a href="/contact" class="btn btn-primary">{{ __('pages.faq.cta_btn1') }}</a>
            <a href="/glossaire" class="btn btn-outline">{{ __('pages.faq.cta_btn2') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
// Accordéon
document.querySelectorAll('.faq-item__q').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(el => { el.classList.remove('open'); el.querySelector('button').setAttribute('aria-expanded','false'); });
    if (!isOpen) { item.classList.add('open'); btn.setAttribute('aria-expanded','true'); }
  });
});

// Filtrage catégories
document.querySelectorAll('.faq-cat').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.faq-cat').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const cat = btn.dataset.cat;
    const items = document.querySelectorAll('.faq-item');
    items.forEach(item => {
      item.style.display = (cat === '__all__' || item.dataset.cat === cat) ? '' : 'none';
    });
    filterFaq();
  });
});

// Recherche
const searchInput = document.getElementById('faq-search');
if (searchInput) {
  searchInput.addEventListener('input', filterFaq);
}

function filterFaq() {
  const q = (searchInput?.value || '').toLowerCase();
  const activeCat = document.querySelector('.faq-cat.active')?.dataset.cat || '__all__';
  const items = document.querySelectorAll('.faq-item');
  let visible = 0;
  items.forEach(item => {
    const catMatch = activeCat === '__all__' || item.dataset.cat === activeCat;
    const textMatch = !q || item.querySelector('.faq-item__q span').textContent.toLowerCase().includes(q)
                        || item.querySelector('.faq-item__a p').textContent.toLowerCase().includes(q);
    const show = catMatch && textMatch;
    item.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('faq-empty').style.display = visible === 0 ? '' : 'none';
}
</script>
@endsection
