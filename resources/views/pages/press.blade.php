@extends('layouts.app')
@section('title', __('pages.titles.press'))
@section('description', __('pages.press.description'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">{{ __('ui.seo.breadcrumb_home') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span>{{ __('pages.press.breadcrumb') }}</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.press.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.press.page_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:600px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.press.hero_sub') }}
        </p>
        <div class="reveal stagger-3" style="margin-top:28px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="mailto:presse@kapitalstark.fr" class="btn btn-primary" style="font-size:15px;padding:12px 28px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                {{ __('pages.press.contact_btn') }}
            </a>
            <a href="#kit-media" class="btn" style="background:rgba(255,255,255,0.12);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:15px;padding:12px 28px;">
                {{ __('pages.press.kit_btn') }}
            </a>
        </div>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container">

        {{-- Key stats --}}
        <div class="reveal g-4" style="gap:20px;margin-bottom:72px;">
            @foreach(trans('pages.press.stats') as $k)
            <div class="card" style="padding:28px;text-align:center;">
                <div style="font-size:32px;margin-bottom:10px;">{{ $k['icon'] }}</div>
                <div class="font-mono" style="font-size:28px;font-weight:700;color:var(--blue);margin-bottom:6px;">{{ $k['val'] }}</div>
                <p style="font-size:13px;color:var(--text-muted);">{{ $k['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Press releases --}}
        <div class="section-header reveal" style="margin-bottom:40px;">
            <span class="section-label">{{ __('pages.press.releases_label') }}</span>
            <h2 class="section-title">{{ __('pages.press.releases_title') }}</h2>
        </div>

        <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:72px;">
            @foreach(trans('pages.press.releases') as $rel)
            @php $parts = explode(' ', $rel['date']); @endphp
            <div class="card reveal" style="padding:28px;display:flex;gap:24px;align-items:flex-start;">
                <div style="min-width:90px;text-align:center;flex-shrink:0;">
                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.06em;font-weight:700;color:var(--text-muted);">{{ ($parts[1] ?? '').' '.($parts[2] ?? '') }}</div>
                    <div class="font-mono" style="font-size:26px;font-weight:700;color:var(--text);">{{ $parts[0] ?? '' }}</div>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:{{ $rel['color'] }};background:rgba(38,123,241,0.07);padding:3px 10px;border-radius:100px;">{{ $rel['tag'] }}</span>
                    </div>
                    <h3 style="font-size:17px;margin-bottom:8px;line-height:1.4;">{{ $rel['title'] }}</h3>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.65;">{{ $rel['excerpt'] }}</p>
                </div>
                <a href="mailto:presse@kapitalstark.fr" class="btn btn-outline btn--sm" style="flex-shrink:0;white-space:nowrap;">
                    {{ __('pages.press.releases_cta') }}
                </a>
            </div>
            @endforeach
        </div>

        {{-- Media kit --}}
        <div id="kit-media" class="reveal" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));border-radius:24px;padding:56px;margin-bottom:72px;">
            <div class="g-2-split" style="gap:48px;align-items:center;">
                <div>
                    <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.press.kit_label') }}</span>
                    <h2 style="color:#fff;margin-top:14px;margin-bottom:16px;">{{ __('pages.press.kit_title') }}</h2>
                    <p style="color:rgba(255,255,255,0.65);font-size:15px;line-height:1.75;margin-bottom:28px;">{{ __('pages.press.kit_desc') }}</p>
                    <a href="mailto:presse@kapitalstark.fr" class="btn btn-primary" style="font-size:15px;padding:13px 28px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        {{ __('pages.press.kit_cta') }}
                    </a>
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach(trans('pages.press.kit_assets') as $asset)
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;background:rgba(255,255,255,0.07);border-radius:12px;padding:14px 18px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span style="font-size:20px;">{{ $asset['icon'] }}</span>
                            <span style="font-size:14px;color:rgba(255,255,255,0.85);font-weight:600;">{{ $asset['label'] }}</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.4);">{{ $asset['size'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Press contact --}}
        <div class="g-2" style="gap:32px;margin-bottom:80px;">
            <div class="card reveal" style="padding:36px;">
                <div style="font-size:40px;margin-bottom:16px;">📞</div>
                <h3 style="font-size:19px;margin-bottom:8px;">{{ __('pages.press.contact_title') }}</h3>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:20px;line-height:1.65;">{{ __('pages.press.contact_desc') }}</p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <p style="font-size:14px;color:var(--text);font-weight:600;">{{ __('pages.press.contact_name') }}</p>
                    <p style="font-size:13px;color:var(--text-muted);">{{ __('pages.press.contact_role') }}</p>
                    <a href="mailto:presse@kapitalstark.fr" style="font-size:14px;color:var(--blue);font-weight:600;">presse@kapitalstark.fr</a>
                    <a href="tel:+33142000002" style="font-size:14px;color:var(--blue);">+33 1 42 00 00 02</a>
                    <p style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ __('pages.press.contact_hours') }}</p>
                </div>
            </div>
            <div class="card reveal stagger-1" style="padding:36px;">
                <div style="font-size:40px;margin-bottom:16px;">📰</div>
                <h3 style="font-size:19px;margin-bottom:8px;">{{ __('pages.press.accred_title') }}</h3>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:20px;line-height:1.65;">{{ __('pages.press.accred_desc') }}</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach(trans('pages.press.accred_items') as $item)
                    <div style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--text-muted);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $item }}
                    </div>
                    @endforeach
                    <a href="mailto:presse@kapitalstark.fr?subject={{ __('pages.press.accred_title') }}" class="btn btn-outline" style="margin-top:12px;width:fit-content;">{{ __('pages.press.accred_cta') }}</a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
