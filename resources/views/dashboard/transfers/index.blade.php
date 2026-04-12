@extends('layouts.dashboard')
@section('title', __('dashboard.transfers.title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transfer.css') }}">
@endsection

@section('content')

{{-- ── En-tête de page ──────────────────────────────────────── --}}
<div class="tx-page-header">
    <div class="tx-page-header__left">
        <h1 class="tx-page-header__title">{{ __('dashboard.transfers.title') }}</h1>
        <p class="tx-page-header__sub">{{ __('dashboard.transfers.sub') }}</p>
    </div>
    <a href="{{ route('dashboard.transfers.create') }}" class="tx-new-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="22" y1="2" x2="11" y2="13"/>
            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
        {{ __('dashboard.transfers.new_btn') }}
    </a>
</div>

@if($transfers->isEmpty())

{{-- ── État vide ─────────────────────────────────────────────── --}}
<div class="tx-empty-wrap">
    <div class="tx-empty-card">
        <div class="tx-empty-visual">
            <div class="tx-empty-visual__ring tx-empty-visual__ring--3"></div>
            <div class="tx-empty-visual__ring tx-empty-visual__ring--2"></div>
            <div class="tx-empty-visual__ring tx-empty-visual__ring--1"></div>
            <div class="tx-empty-visual__icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </div>
        </div>
        <h3 class="tx-empty-card__title">{{ __('dashboard.transfers.empty_title') }}</h3>
        <p class="tx-empty-card__sub">{{ __('dashboard.transfers.empty_sub') }}</p>
        <a href="{{ route('dashboard.transfers.create') }}" class="tx-new-btn tx-new-btn--lg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
            {{ __('dashboard.transfers.do_transfer') }}
        </a>

        <div class="tx-empty-card__badges">
            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> {{ __('dashboard.transfers.ssl_badge') }}</span>
            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> {{ __('dashboard.transfers.fees_badge') }}</span>
            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ __('dashboard.transfers.speed_badge') }}</span>
        </div>
    </div>
</div>

@else

{{-- ── Stats récap ───────────────────────────────────────────── --}}
@php
    $total     = $stats['total'];
    $pending   = $stats['pending'];
    $ongoing   = $stats['ongoing'];
    $completed = $stats['completed'];
    $totalAmt  = $stats['totalAmt'];
@endphp

<div class="tx-stats-row">
    <div class="tx-stat">
        <div class="tx-stat__val">{{ $total }}</div>
        <div class="tx-stat__lbl">{{ __('dashboard.transfers.stat_total') }}</div>
    </div>
    <div class="tx-stat-div"></div>
    <div class="tx-stat">
        <div class="tx-stat__val tx-stat__val--warn">{{ $pending }}</div>
        <div class="tx-stat__lbl">{{ __('dashboard.transfers.stat_pending') }}</div>
    </div>
    <div class="tx-stat-div"></div>
    <div class="tx-stat">
        <div class="tx-stat__val tx-stat__val--blue">{{ $ongoing }}</div>
        <div class="tx-stat__lbl">{{ __('dashboard.transfers.stat_ongoing') }}</div>
    </div>
    <div class="tx-stat-div"></div>
    <div class="tx-stat">
        <div class="tx-stat__val tx-stat__val--green">{{ $completed }}</div>
        <div class="tx-stat__lbl">{{ __('dashboard.transfers.stat_done') }}</div>
    </div>
    <div class="tx-stat-div"></div>
    <div class="tx-stat">
        <div class="tx-stat__val">{{ number_format($totalAmt, 0, ',', ' ') }} €</div>
        <div class="tx-stat__lbl">{{ __('dashboard.transfers.stat_volume') }}</div>
    </div>
</div>

{{-- ── Liste des virements ───────────────────────────────────── --}}
<div class="dash-card">
    <div class="tx-list">
        @foreach($transfers as $t)
        <a href="{{ route('dashboard.transfers.show', $t) }}" class="tx-row">

            {{-- Icône statut --}}
            <div class="tx-row__icon tx-row__icon--{{ $t->statusClass() }}">
                @if($t->status === 'completed')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                @elseif($t->status === 'rejected')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                @elseif($t->status === 'processing')
                <div class="tx-spin"></div>
                @elseif($t->status === 'paused')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                @elseif($t->status === 'approved')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                @else
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                @endif
            </div>

            {{-- Infos bénéficiaire --}}
            <div class="tx-row__body">
                <span class="tx-row__name">{{ $t->recipient_name }}</span>
                <span class="tx-row__meta">
                    <span class="tx-row__iban">{{ substr($t->recipient_iban, 0, 2) }}••{{ substr($t->recipient_iban, -4) }}</span>
                    @if($t->label)
                    <span class="tx-dot">·</span>
                    <span>{{ Str::limit($t->label, 30) }}</span>
                    @endif
                    <span class="tx-dot">·</span>
                    <span>{{ $t->created_at->format('d/m/Y') }}</span>
                </span>
            </div>

            {{-- Mini barre de progression si applicable --}}
            @if(in_array($t->status, ['processing', 'paused', 'completed']) && $t->progress > 0)
            <div class="tx-row__prog">
                <div class="tx-row__prog-track">
                    <div class="tx-row__prog-fill tx-row__prog-fill--{{ $t->status === 'completed' ? 'completed' : ($t->status === 'paused' ? 'paused' : 'processing') }}"
                         style="width:{{ $t->progress }}%"></div>
                </div>
                <span class="tx-row__pct">{{ $t->progress }}%</span>
            </div>
            @endif

            {{-- Montant --}}
            <div class="tx-row__amount">
                {{ number_format($t->amount, 2, ',', ' ') }} €
            </div>

            {{-- Badge statut --}}
            <span class="tx-badge tx-badge--{{ $t->statusClass() }}">
                {{ $t->statusLabel() }}
            </span>

            {{-- Chevron --}}
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="tx-row__chevron">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </a>
        @endforeach
    </div>
    @if($transfers->hasPages())
    <div style="padding:16px 20px;border-top:1px solid rgba(255,255,255,0.06);">
        {{ $transfers->links('pagination::simple-tailwind') }}
    </div>
    @endif
</div>

@endif

@endsection
