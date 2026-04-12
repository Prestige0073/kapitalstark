@extends('layouts.dashboard')
@section('title', __('dashboard.loans.title'))

@section('content')

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.loans.title') }}</h2>
        <p>{{ trans_choice('dashboard.loans.sub', count($loans), ['n' => count($loans)]) }}</p>
    </div>
    <a href="{{ route('simulator.index') }}" class="btn btn-primary btn--sm">{{ __('dashboard.loans.new_btn') }}</a>
</div>

@foreach($loans as $loan)
<div class="dash-loan-card">
    <div class="dash-loan-card__header">
        <div class="dash-loan-card__icon">{{ $loan['icon'] }}</div>
        <div style="flex:1;">
            <div class="dash-loan-card__title">{{ $loan['type'] }}</div>
            <div class="dash-loan-card__dates">
                {{ __('dashboard.loans.from') }} {{ \Carbon\Carbon::parse($loan['start'])->format('d M Y') }}
                {{ __('dashboard.loans.to') }} {{ \Carbon\Carbon::parse($loan['end'])->format('d M Y') }}
            </div>
        </div>
        <span class="dash-status dash-status--active">{{ __('dashboard.loans.active') }}</span>
    </div>

    <div class="dash-loan-card__body">
        {{-- Stats --}}
        <div class="dash-loan-card__stats">
            <div class="dash-loan-stat">
                <span class="dash-loan-stat__value">{{ number_format($loan['amount'], 0, ',', ' ') }} €</span>
                <span class="dash-loan-stat__label">{{ __('dashboard.loans.initial') }}</span>
            </div>
            <div class="dash-loan-stat">
                <span class="dash-loan-stat__value" style="color:var(--blue);">{{ number_format($loan['remaining'], 0, ',', ' ') }} €</span>
                <span class="dash-loan-stat__label">{{ __('dashboard.loans.remaining') }}</span>
            </div>
            <div class="dash-loan-stat">
                <span class="dash-loan-stat__value">{{ number_format($loan['monthly'], 0, ',', ' ') }} €</span>
                <span class="dash-loan-stat__label">{{ __('dashboard.loans.monthly') }}</span>
            </div>
            <div class="dash-loan-stat">
                <span class="dash-loan-stat__value font-mono">{{ $loan['rate'] }}%</span>
                <span class="dash-loan-stat__label">{{ __('dashboard.loans.rate') }}</span>
            </div>
        </div>

        {{-- Progression --}}
        <div style="margin-bottom:20px;">
            <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-muted);margin-bottom:8px;">
                <span>{{ __('dashboard.loans.progress') }}</span>
                <strong style="color:var(--blue);">{{ $loan['progress'] }}%</strong>
            </div>
            <div class="dash-progress__bar" style="height:10px;border-radius:5px;">
                <div class="dash-progress__fill" style="width:{{ $loan['progress'] }}%;border-radius:5px;"></div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--text-muted);margin-top:6px;">
                <span>{{ number_format($loan['amount'] - $loan['remaining'], 0, ',', ' ') }} € {{ __('dashboard.loans.repaid') }}</span>
                <span>{{ number_format($loan['remaining'], 0, ',', ' ') }} € {{ __('dashboard.loans.left') }}</span>
            </div>
        </div>

        {{-- Prochaine échéance --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px;background:rgba(38,123,241,0.05);border-radius:var(--radius-md);border:1px solid rgba(38,123,241,0.1);flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:20px;">📅</span>
                <div>
                    <strong style="font-size:13px;">{{ __('dashboard.loans.next_due') }}</strong>
                    <p style="font-size:12px;color:var(--text-muted);">{{ \Carbon\Carbon::parse($loan['next_date'])->format('d M Y') }}</p>
                </div>
            </div>
            <strong class="font-mono" style="font-size:18px;color:var(--blue);">{{ number_format($loan['monthly'], 0, ',', ' ') }} €</strong>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:10px;margin-top:18px;flex-wrap:wrap;">
            <a href="{{ route('dashboard.documents') }}" class="btn btn-outline btn--sm">{{ __('dashboard.loans.docs_btn') }}</a>
            <a href="{{ route('simulator.index') }}" class="btn btn-outline btn--sm">{{ __('dashboard.loans.refinance') }}</a>
            <a href="{{ route('contact') }}" class="btn btn-ghost btn--sm">{{ __('dashboard.loans.contact_btn') }}</a>
        </div>
    </div>
</div>
@endforeach

@endsection
