@extends('layouts.app')
@section('title', __('pages.titles.agencies'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('schema')
@php
    // Les agences sont définies dans la vue elle-même (bloc @php plus bas).
    // On reconstruit ici les données minimales pour le schema LocalBusiness.
    $schemaService = app(\App\Services\SchemaMarkupService::class);
    $agenciesForSchema = [
        ['name' => 'KapitalStark Lisboa',       'address' => 'Av. da Liberdade, 110, 3.º andar', 'city' => 'Lisboa', 'zip' => '1269-046', 'phone' => '+351210001234', 'lat' => 38.7197, 'lng' => -9.1468],
        ['name' => 'KapitalStark Porto',         'address' => 'Rua de Santa Catarina, 85',         'city' => 'Porto',  'zip' => '4000-447', 'phone' => '+351220001234', 'lat' => 41.1496, 'lng' => -8.6109],
        ['name' => 'KapitalStark Coimbra',       'address' => 'Rua Ferreira Borges, 25',           'city' => 'Coimbra','zip' => '3000-191', 'phone' => '+351239001234'],
        ['name' => 'KapitalStark Braga',         'address' => 'Rua do Souto, 20',                  'city' => 'Braga',  'zip' => '4700-239', 'phone' => '+351253001234'],
        ['name' => 'KapitalStark Faro (Algarve)','address' => 'Rua de Santo António, 40',          'city' => 'Faro',   'zip' => '8000-283', 'phone' => '+351289001234'],
    ];
    $agenciesSchema = array_map(fn($a) => $schemaService->localBusiness($a), $agenciesForSchema);
    $breadcrumb = $schemaService->breadcrumbs([
        ['name' => 'Accueil', 'url' => url('/')],
        ['name' => 'À propos', 'url' => url('/a-propos')],
        ['name' => 'Nos agences', 'url' => url('/a-propos/agences')],
    ]);
@endphp
<script type="application/ld+json">
{!! $schemaService->buildGraph(array_merge($agenciesSchema, [$breadcrumb])) !!}
</script>
@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;">
            <a href="{{ route('about') }}" style="color:rgba(255,255,255,0.5);text-decoration:none;">{{ __('pages.agencies.breadcrumb_about') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span style="color:rgba(255,255,255,0.85);">{{ __('pages.agencies.breadcrumb_cur') }}</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.agencies.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.agencies.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;max-width:600px;margin-inline:auto;">
            {{ __('pages.agencies.hero_sub') }}
        </p>
    </div>
</section>

{{-- Agences --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.agencies.section_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.agencies.section_title') }}</h2>
        </div>

        @php
        $agencies = [
            ['emoji'=>'🏙️','name'=>'Lisboa — Sede Social','type'=>__('pages.agencies.type_hq'),      'address'=>'Av. da Liberdade, 110, 3.º andar, 1269-046 Lisboa','phone'=>'+351 21 000 12 34','hours'=>'Seg–Sex : 9h–18h30','metro'=>'Avenida (Linha Azul)'],
            ['emoji'=>'🌊','name'=>'Porto',               'type'=>__('pages.agencies.type_regional'),'address'=>'Rua de Santa Catarina, 85, 4000-447 Porto',         'phone'=>'+351 22 000 12 35','hours'=>'Seg–Sex : 9h–18h', 'metro'=>'Bolhão (Linha Amarela/Vermelha)'],
            ['emoji'=>'🎓','name'=>'Coimbra',             'type'=>__('pages.agencies.type_regional'),'address'=>'Rua Ferreira Borges, 25, 3000-191 Coimbra',         'phone'=>'+351 23 900 12 36','hours'=>'Seg–Sex : 9h–18h', 'metro'=>'Centro (autocarros urbanos)'],
            ['emoji'=>'🌿','name'=>'Braga',               'type'=>__('pages.agencies.type_regional'),'address'=>'Rua do Souto, 20, 4700-239 Braga',                 'phone'=>'+351 25 300 12 37','hours'=>'Seg–Sex : 9h–17h30','metro'=>'Centro Histórico'],
            ['emoji'=>'☀️','name'=>'Faro (Algarve)',      'type'=>__('pages.agencies.type_regional'),'address'=>'Rua de Santo António, 40, 8000-283 Faro',           'phone'=>'+351 28 900 12 38','hours'=>'Seg–Sex : 9h–18h', 'metro'=>'Centro (autocarros urbanos)'],
        ];
        @endphp

        <div class="agencies-grid reveal">
            @foreach($agencies as $a)
            <div class="agency-card reveal">
                <div class="agency-card__map">{{ $a['emoji'] }}</div>
                <div class="agency-card__body">
                    <h3 class="agency-card__name">{{ $a['name'] }}</h3>
                    <p class="agency-card__type">{{ $a['type'] }}</p>
                    <div class="agency-card__info">
                        <div class="agency-info-row">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>{{ $a['address'] }}</span>
                        </div>
                        <div class="agency-info-row">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.63 19.79 19.79 0 01-0 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                            <a href="tel:{{ str_replace(' ', '', $a['phone']) }}" style="color:var(--blue);text-decoration:none;font-weight:600;">{{ $a['phone'] }}</a>
                        </div>
                        <div class="agency-info-row">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span>{{ $a['hours'] }}</span>
                        </div>
                        <div class="agency-info-row">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><path d="M16 8l5 5v5H16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            <span>{{ __('pages.agencies.transport') }} : {{ $a['metro'] }}</span>
                        </div>
                    </div>
                    <a href="{{ route('contact.rdv') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:20px;padding:12px;">
                        {{ __('pages.agencies.btn_rdv') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Agence en ligne --}}
<section style="background:var(--cream);">
    <div class="container" style="max-width:900px;">
        <div class="card reveal" style="padding:48px;display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;">
            <div>
                <span class="section-label" style="margin-bottom:16px;display:inline-block;">{{ __('pages.agencies.online_label') }}</span>
                <h2 style="font-size:28px;margin-bottom:16px;">{{ __('pages.agencies.online_title') }}</h2>
                <p style="color:var(--text-muted);line-height:1.75;margin-bottom:24px;">
                    {{ __('pages.agencies.online_desc') }}
                </p>
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:28px;">
                    @foreach(trans('pages.agencies.online_features') as $f)
                    <div style="display:flex;align-items:center;gap:10px;font-size:14px;font-weight:600;color:var(--text);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $f }}
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('client.register') }}" class="btn btn-primary">{{ __('pages.agencies.online_cta') }}</a>
            </div>
            <div style="display:flex;justify-content:center;">
                <div style="width:220px;height:220px;background:linear-gradient(135deg,var(--navy),var(--blue));border-radius:30px;display:flex;align-items:center;justify-content:center;font-size:80px;opacity:0.7;">
                    💻
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
