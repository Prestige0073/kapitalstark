@extends('layouts.dashboard')
@section('title', __('dashboard.receipts.title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/receipts.css') }}">
@endsection

@section('content')

{{-- ── Documents d'approbation ─────────────────────────────── --}}
<div class="dash-card receipts-approval-card">
    <div class="dash-card__header">
        <div>
            <h2 class="dash-card__title">{{ __('dashboard.receipts.approval_title') }}</h2>
            <p class="dash-card__sub">{{ __('dashboard.receipts.approval_sub') }}</p>
        </div>
        @if($approvalDocs->isNotEmpty())
        <span class="receipts-count-badge">{{ $approvalDocs->count() }} document{{ $approvalDocs->count() > 1 ? 's' : '' }}</span>
        @endif
    </div>

    @if($approvalDocs->isEmpty())
    <div class="receipts-empty">
        <div class="receipts-empty__icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="9" y1="15" x2="15" y2="15"/>
            </svg>
        </div>
        <p class="receipts-empty__title">{{ __('dashboard.receipts.empty_approval') }}</p>
        <p class="receipts-empty__sub">{{ __('dashboard.receipts.empty_approval_sub') }}</p>
    </div>
    @else
    <div class="receipts-doc-list">
        @foreach($approvalDocs as $doc)
        <div class="receipts-doc-row">
            <div class="receipts-doc-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <path d="M9 15l2 2 4-4"/>
                </svg>
            </div>
            <div class="receipts-doc-body">
                <span class="receipts-doc-name">{{ $doc->original_name }}</span>
                <span class="receipts-doc-meta">
                    {{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y à H:i') }}
                    <span class="rdot">·</span> PDF
                    @if($doc->size_bytes)
                    <span class="rdot">·</span> {{ number_format($doc->size_bytes / 1024, 0, ',', ' ') }} Ko
                    @endif
                </span>
            </div>
            <span class="receipts-badge receipts-badge--approved">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                {{ __('dashboard.receipts.approved_badge') }}
            </span>
            <a href="{{ route('dashboard.documents.download', $doc->id) }}" class="receipts-dl-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                {{ __('dashboard.receipts.download_btn') }}
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- ── Mouvements de fonds ───────────────────────────────────── --}}
@php
    $totalCredits = collect($transactions)->where('credit', true)->sum('amount');
    $totalDebits  = collect($transactions)->where('credit', false)->sum('amount');
    $net          = $totalCredits - $totalDebits;
    $txCount      = count($transactions);
@endphp

<div class="dash-card receipts-tx-card">
    <div class="dash-card__header">
        <div>
            <h2 class="dash-card__title">{{ __('dashboard.receipts.funds_title') }}</h2>
            <p class="dash-card__sub">
                @if($txCount === 0)
                    {{ __('dashboard.receipts.funds_none') }}
                @else
                    {{ $txCount }} mouvement{{ $txCount > 1 ? 's' : '' }} · crédits et virements
                @endif
            </p>
        </div>
        <a href="{{ route('dashboard.card') }}" class="receipts-card-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            {{ __('dashboard.receipts.my_card_link') }}
        </a>
    </div>

    @if($txCount === 0)
    <div class="receipts-empty">
        <div class="receipts-empty__icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 12h18M3 6h18M3 18h18"/>
            </svg>
        </div>
        <p class="receipts-empty__title">{{ __('dashboard.receipts.empty_funds') }}</p>
        <p class="receipts-empty__sub">{{ __('dashboard.receipts.empty_funds_sub') }}</p>
    </div>
    @else

    {{-- Stats --}}
    <div class="receipts-stats">
        <div class="receipts-stat">
            <span class="receipts-stat__label">{{ __('dashboard.receipts.stat_credits') }}</span>
            <span class="receipts-stat__value receipts-stat__value--credit">+{{ number_format($totalCredits, 2, ',', ' ') }} €</span>
        </div>
        <div class="receipts-stat-divider"></div>
        <div class="receipts-stat">
            <span class="receipts-stat__label">{{ __('dashboard.receipts.stat_debits') }}</span>
            <span class="receipts-stat__value receipts-stat__value--debit">-{{ number_format($totalDebits, 2, ',', ' ') }} €</span>
        </div>
        <div class="receipts-stat-divider"></div>
        <div class="receipts-stat">
            <span class="receipts-stat__label">{{ __('dashboard.receipts.stat_net') }}</span>
            <span class="receipts-stat__value receipts-stat__value--{{ $net >= 0 ? 'credit' : 'debit' }}">
                {{ $net >= 0 ? '+' : '-' }}{{ number_format(abs($net), 2, ',', ' ') }} €
            </span>
        </div>
    </div>

    {{-- Liste --}}
    <div class="receipts-tx-list">
        @foreach($transactions as $i => $tx)
        <div class="receipts-tx-row">
            <div class="receipts-tx-icon receipts-tx-icon--{{ $tx['credit'] ? 'credit' : 'debit' }}">
                @if($tx['credit'])
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="19" x2="12" y2="5"/>
                    <polyline points="5 12 12 5 19 12"/>
                </svg>
                @else
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <polyline points="19 12 12 19 5 12"/>
                </svg>
                @endif
            </div>
            <div class="receipts-tx-body">
                <span class="receipts-tx-label">{{ $tx['label'] }}</span>
                <span class="receipts-tx-meta">
                    <span class="receipts-tx-date">{{ $tx['date'] }}</span>
                    <span class="rdot">·</span>
                    <span>{{ __('dashboard.receipts.account_prefix') }}{{ $num4 }}</span>
                    <span class="rdot">·</span>
                    <span class="receipts-tx-status">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $tx['credit'] ? __('dashboard.receipts.funds_disbursed') : __('dashboard.receipts.transfer_done') }}
                    </span>
                </span>
            </div>
            <div class="receipts-tx-amount receipts-tx-amount--{{ $tx['credit'] ? 'credit' : 'debit' }}">
                {{ $tx['credit'] ? '+' : '-' }}{{ number_format($tx['amount'], 2, ',', ' ') }} €
            </div>
            @if(!$tx['credit'])
            <a href="{{ route('dashboard.card.receipt', $i) }}"
               class="receipts-dl-btn receipts-dl-btn--ghost"
               title="{{ __('dashboard.receipts.receipt_btn') }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                {{ __('dashboard.receipts.receipt_btn') }}
            </a>
            @else
            <span class="receipts-dl-btn receipts-dl-btn--disabled" style="opacity:0;pointer-events:none;"></span>
            @endif
        </div>
        @endforeach
    </div>

    @endif
</div>

@endsection
