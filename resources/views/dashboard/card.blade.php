@extends('layouts.dashboard')
@section('title', __('dashboard.card.title'))
@section('styles')
<link rel="stylesheet" href="{{ asset('css/card.css') }}">
@endsection

@section('content')
<div class="card-page">

    {{-- ── Colonne gauche : carte + actions ────────────────── --}}
    <div class="card-panel">

        {{-- Carte 3D flip --}}
        <div class="card-scene" id="cardScene" title="{{ __('dashboard.card.flip_title') }}" role="button" tabindex="0" aria-label="{{ __('dashboard.card.flip_aria') }}">
            <div class="card-3d" id="card3d">

                {{-- RECTO --}}
                <div class="card-face card-front">

                    @if($card['blocked'])
                    <div class="card-blocked-overlay">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                        <span>{{ __('dashboard.card.blocked_label') }}</span>
                    </div>
                    @endif

                    {{-- Top row --}}
                    <div class="card-front__top">
                        <a class="card-logo" translate="no" style="text-decoration:none;display:inline-flex;align-items:baseline;gap:0;">
                            <span style="font-family:'Playfair Display',Georgia,serif;font-weight:700;font-style:italic;font-size:17px;color:rgba(255,255,255,.95);line-height:1;letter-spacing:-0.01em;user-select:none;">Kapital</span>
                            <span style="display:inline-block;width:1.5px;height:12px;background:rgba(200,169,81,0.75);margin:0 7px;align-self:center;flex-shrink:0;transform:translateY(-1px);user-select:none;" aria-hidden="true"></span>
                            <span style="font-family:'Space Mono',monospace;font-weight:700;font-size:10px;color:rgba(168,207,247,.95);text-transform:uppercase;letter-spacing:0.2em;align-self:center;line-height:1;user-select:none;">Stark</span>
                        </a>
                        <span class="card-type-badge">{{ $card['type'] }}</span>
                    </div>

                    {{-- Chip + contactless --}}
                    <div class="card-chip">
                        <div class="card-chip__svg">
                            <svg width="32" height="24" viewBox="0 0 32 24" fill="none">
                                <rect x="1" y="1" width="30" height="22" rx="3" stroke="rgba(100,70,20,.6)" stroke-width="1" fill="none"/>
                                <line x1="11" y1="1" x2="11" y2="23" stroke="rgba(100,70,20,.5)" stroke-width="1"/>
                                <line x1="21" y1="1" x2="21" y2="23" stroke="rgba(100,70,20,.5)" stroke-width="1"/>
                                <line x1="1" y1="8"  x2="31" y2="8"  stroke="rgba(100,70,20,.5)" stroke-width="1"/>
                                <line x1="1" y1="16" x2="31" y2="16" stroke="rgba(100,70,20,.5)" stroke-width="1"/>
                                <rect x="11" y="8" width="10" height="8" rx="1" fill="rgba(160,120,40,.35)"/>
                            </svg>
                        </div>
                        <div class="card-contactless">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M8.5 12a3.5 3.5 0 0 1 7 0" opacity=".4"/>
                                <path d="M5 12a7 7 0 0 1 14 0"   opacity=".65"/>
                                <path d="M1.5 12a10.5 10.5 0 0 1 21 0" opacity=".9"/>
                                <circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Card number --}}
                    <div class="card-number" id="cardNumberDisplay">
                        @foreach(explode(' ', $card['number_mask']) as $group)
                        <span>{{ $group }}</span>
                        @endforeach
                    </div>

                    {{-- Bottom row --}}
                    <div class="card-front__bottom">
                        <div>
                            <div class="card-label">{{ __('dashboard.card.holder_label') }}</div>
                            <div class="card-holder">{{ $card['holder'] }}</div>
                        </div>
                        <div>
                            <div class="card-label">{{ __('dashboard.card.expires_label') }}</div>
                            <div class="card-expiry">{{ $card['expiry'] }}</div>
                        </div>
                        <div class="card-network">
                            <div class="card-network__circles">
                                <div class="card-network__circle"></div>
                                <div class="card-network__circle"></div>
                            </div>
                            <div class="card-network__label">Debit</div>
                        </div>
                    </div>
                </div>

                {{-- VERSO --}}
                <div class="card-face card-back">
                    <div class="card-back__stripe"></div>
                    <div class="card-back__body">
                        <div class="card-back__sig">
                            <span class="card-back__cvv-label">{{ __('dashboard.card.cvv_label') }}</span>
                            <span class="card-back__cvv-value" id="cvvDisplay">•••</span>
                        </div>
                        <p class="card-back__info">
                            {{ __('dashboard.card.back_info') }}
                        </p>
                    </div>
                </div>

            </div>{{-- .card-3d --}}
        </div>{{-- .card-scene --}}

        <p class="card-flip-hint">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6M23 20v-6h-6"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
            {{ __('dashboard.card.flip_hint') }}
        </p>

        {{-- Reveal / Block actions --}}
        <div class="card-actions">
            <button class="btn btn-outline" id="revealBtn" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                {{ __('dashboard.card.reveal_btn') }}
            </button>

            <form action="{{ route('dashboard.card.toggle') }}" method="POST" style="flex:1;display:flex;">
                @csrf
                <button type="submit" class="btn {{ $card['blocked'] ? 'btn-primary' : 'btn-danger' }}" style="flex:1;justify-content:center;">
                    @if($card['blocked'])
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    {{ __('dashboard.card.unblock_btn') }}
                    @else
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                    {{ __('dashboard.card.block_btn') }}
                    @endif
                </button>
            </form>
        </div>

        {{-- Detail grid --}}
        <div class="card-detail-grid">
            <div class="card-detail-item">
                <div class="card-detail-item__label">{{ __('dashboard.card.number_label') }}</div>
                <div class="card-detail-item__value">
                    <span id="fullNumberShort">•••• {{ substr($card['number'], -4) }}</span>
                    <button class="card-reveal-btn" id="copyBtn" title="{{ __('dashboard.card.copy_aria') }}" aria-label="{{ __('dashboard.card.copy_aria') }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    </button>
                </div>
            </div>
            <div class="card-detail-item">
                <div class="card-detail-item__label">{{ __('dashboard.card.cvv_label') }}</div>
                <div class="card-detail-item__value">
                    <span id="cvvDetailDisplay">•••</span>
                    <button class="card-reveal-btn" id="revealCvvBtn" title="{{ __('dashboard.card.cvv_aria') }}" aria-label="{{ __('dashboard.card.cvv_aria') }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <div class="card-detail-item">
                <div class="card-detail-item__label">{{ __('dashboard.card.expiry_label') }}</div>
                <div class="card-detail-item__value">{{ $card['expiry'] }}</div>
            </div>
            <div class="card-detail-item">
                <div class="card-detail-item__label">{{ __('dashboard.card.type_label') }}</div>
                <div class="card-detail-item__value" style="font-family:inherit;font-size:13px;">{{ $card['type'] }}</div>
            </div>
        </div>

    </div>{{-- .card-panel --}}

    {{-- ── Colonne droite : solde + transactions ─────────── --}}
    <div class="card-right">

        {{-- Solde & limite --}}
        <div class="card-credit-block">
            <div class="card-credit-block__title">{{ __('dashboard.card.balance_title') }}</div>
            <div class="card-credit-row">
                <span class="card-credit-label">{{ __('dashboard.card.balance_label') }}</span>
                <span class="card-credit-value card-credit-value--green">{{ number_format($balance, 2, ',', ' ') }} €</span>
            </div>
            <div class="card-credit-row">
                <span class="card-credit-label">{{ __('dashboard.card.used_label') }}</span>
                <span class="card-credit-value">{{ number_format($used, 2, ',', ' ') }} €</span>
            </div>
            <div class="card-credit-row">
                <span class="card-credit-label">{{ __('dashboard.card.limit_label') }}</span>
                <span class="card-credit-value">{{ number_format($limit, 0, ',', ' ') }} €</span>
            </div>
            <div class="card-credit-bar-wrap">
                <div class="card-credit-bar-fill" style="width: {{ $usedPct }}%"></div>
            </div>
            <p style="font-size:11px;color:var(--text-muted);margin-top:8px;text-align:right;">
                {{ str_replace(':n', $usedPct, __('dashboard.card.pct_used')) }}
            </p>
        </div>

        {{-- Dernières transactions --}}
        <div class="card-tx-block">
            <div class="card-tx-block__header">{{ __('dashboard.card.tx_title') }}</div>
            @foreach($transactions as $i => $tx)
            <div class="card-tx-item">
                <div class="card-tx-icon card-tx-icon--{{ $tx['credit'] ? 'credit' : 'debit' }}">
                    @if($tx['credit'])
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                    @else
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    @endif
                </div>
                <div class="card-tx-body">
                    <div class="card-tx-label">{{ $tx['label'] }}</div>
                    <div class="card-tx-date">{{ $tx['date'] }}</div>
                </div>
                <div class="card-tx-amount card-tx-amount--{{ $tx['credit'] ? 'credit' : 'debit' }}">
                    {{ $tx['amount'] }}
                </div>
                <a href="{{ route('dashboard.card.receipt', $i) }}"
                   class="card-tx-receipt"
                   title="{{ __('dashboard.card.receipt_title') }}"
                   aria-label="{{ __('dashboard.card.receipt_aria') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </a>
            </div>
            @endforeach
        </div>

    </div>{{-- .card-right --}}

</div>{{-- .card-page --}}
@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    var cardNumber  = '{{ $card['number'] }}';
    var cardCvv     = '{{ $card['cvv'] }}';
    var numberMask  = '{{ $card['number_mask'] }}';

    // Translated strings injected from PHP
    var TXT_REVEAL  = '{{ __('dashboard.card.reveal_btn') }}';
    var TXT_HIDE    = '{{ __('dashboard.card.hide_btn') }}';

    var scene      = document.getElementById('cardScene');
    var card3d     = document.getElementById('card3d');
    var numDisplay = document.getElementById('cardNumberDisplay');
    var cvvDisplay = document.getElementById('cvvDisplay');
    var cvvDetail  = document.getElementById('cvvDetailDisplay');
    var fullNum    = document.getElementById('fullNumberShort');
    var revealBtn  = document.getElementById('revealBtn');
    var revealCvv  = document.getElementById('revealCvvBtn');
    var copyBtn    = document.getElementById('copyBtn');

    var revealed   = false;
    var flipped    = false;

    // Flip
    function flip() {
        flipped = !flipped;
        card3d.classList.toggle('flipped', flipped);
        if (flipped && revealed) {
            cvvDisplay.textContent = cardCvv;
        }
    }
    scene.addEventListener('click', flip);
    scene.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); flip(); }
    });

    // Reveal number
    revealBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        revealed = !revealed;

        if (revealed) {
            var parts = cardNumber.split(' ');
            numDisplay.innerHTML = parts.map(function (p) { return '<span>' + p + '</span>'; }).join('');
            fullNum.textContent = cardNumber;
            cvvDisplay.textContent = cardCvv;
            cvvDetail.textContent  = cardCvv;
            revealBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg> ' + TXT_HIDE;
        } else {
            var maskedParts = numberMask.split(' ');
            numDisplay.innerHTML = maskedParts.map(function (p) { return '<span>' + p + '</span>'; }).join('');
            fullNum.textContent  = '•••• {{ substr($card['number'], -4) }}';
            cvvDisplay.textContent = '•••';
            cvvDetail.textContent  = '•••';
            revealBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> ' + TXT_REVEAL;
        }
    });

    // Reveal CVV only
    revealCvv.addEventListener('click', function (e) {
        e.stopPropagation();
        var showing = cvvDetail.textContent === cardCvv;
        cvvDetail.textContent = showing ? '•••' : cardCvv;
    });

    // Copy number
    copyBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (!navigator.clipboard) return;
        navigator.clipboard.writeText(cardNumber).then(function () {
            copyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>';
            setTimeout(function () {
                copyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
            }, 2000);
        });
    });
})();
</script>
@endsection
