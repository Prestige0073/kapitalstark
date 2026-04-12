@extends('layouts.dashboard')
@section('title', __('dashboard.index.title'))

@section('content')

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.index.greeting') }} {{ explode(' ', $user->name)[0] }} 👋</h2>
        <p>{{ __('dashboard.index.sub') }}</p>
    </div>
    <a href="{{ route('simulator.index') }}" class="btn btn-primary btn--sm">{{ __('dashboard.index.sim_btn') }}</a>
</div>

@php
    $totalRemaining  = array_sum(array_column($loans, 'remaining'));
    $totalMonthly    = array_sum(array_column($loans, 'monthly'));
    $activeCount     = count($loans);
    $nextDate        = collect($loans)->filter(fn($l) => !empty($l['next_date']))->sortBy('next_date')->value('next_date');
    $nextDateLabel   = $nextDate ? \Carbon\Carbon::parse($nextDate)->translatedFormat('d M') : '—';
    $weightedRate    = $totalMonthly > 0
        ? collect($loans)->sum(fn($l) => $l['rate'] * $l['monthly']) / $totalMonthly
        : 0;
    $activeRequests  = collect($requests)->whereIn('status', ['pending','analysis'])->count();
    $requestSubLabel = $activeRequests > 0
        ? (collect($requests)->whereIn('status', ['pending','analysis'])->first()['status'] === 'analysis'
            ? __('dashboard.requests.badge.under_review')
            : __('dashboard.requests.badge.pending'))
        : __('dashboard.index.status_none');
@endphp

{{-- KPIs --}}
<div class="dash-kpis">
    <div class="dash-kpi">
        <span class="dash-kpi__icon">🏦</span>
        <span class="dash-kpi__label">{{ __('dashboard.index.kpi_capital') }}</span>
        <span class="dash-kpi__value font-mono">{{ $totalRemaining > 0 ? number_format($totalRemaining, 0, ',', ' ') . ' €' : '—' }}</span>
        <span class="dash-kpi__sub">{{ trans_choice('dashboard.index.kpi_loans_sub', $activeCount, ['n' => $activeCount]) }}</span>
    </div>
    <div class="dash-kpi dash-kpi--gold">
        <span class="dash-kpi__icon">💳</span>
        <span class="dash-kpi__label">{{ __('dashboard.index.kpi_monthly') }}</span>
        <span class="dash-kpi__value font-mono">{{ $totalMonthly > 0 ? number_format($totalMonthly, 0, ',', ' ') . ' €' : '—' }}</span>
        <span class="dash-kpi__sub">{{ __('dashboard.index.kpi_next') }} {{ $nextDateLabel }}</span>
    </div>
    <div class="dash-kpi dash-kpi--success">
        <span class="dash-kpi__icon">📈</span>
        <span class="dash-kpi__label">{{ __('dashboard.index.kpi_rate') }}</span>
        <span class="dash-kpi__value font-mono">{{ $weightedRate > 0 ? number_format($weightedRate, 2, '.', '') . '%' : '—' }}</span>
        <span class="dash-kpi__sub">{{ __('dashboard.index.kpi_rate_sub') }}</span>
    </div>
    <div class="dash-kpi dash-kpi--warning">
        <span class="dash-kpi__icon">📋</span>
        <span class="dash-kpi__label">{{ __('dashboard.index.kpi_requests') }}</span>
        <span class="dash-kpi__value font-mono">{{ $activeRequests }}</span>
        <span class="dash-kpi__sub">{{ $requestSubLabel }}</span>
    </div>
</div>

<div class="dash-grid">

    {{-- Mes Prêts --}}
    <div class="dash-widget">
        <div class="dash-widget__header">
            <span class="dash-widget__title">{{ __('dashboard.index.widget_loans') }}</span>
            <a href="{{ route('dashboard.loans') }}" class="dash-widget__link">{{ __('dashboard.see_all') }}</a>
        </div>
        <div class="dash-widget__body">
            @foreach($loans as $loan)
            <div class="dash-loan-row">
                <div class="dash-loan-row__icon">{{ $loan['icon'] }}</div>
                <div class="dash-loan-row__info">
                    <div class="dash-loan-row__title">{{ $loan['type'] }}</div>
                    <div class="dash-loan-row__meta">
                        <span class="dash-status dash-status--active">{{ __('dashboard.loans.active') }}</span>
                        &nbsp;·&nbsp; {{ __('dashboard.rate_label') }} {{ $loan['rate'] }}%
                    </div>
                    <div class="dash-progress" style="margin-top:8px;">
                        <div class="dash-progress__bar">
                            <div class="dash-progress__fill" style="width:{{ $loan['progress'] }}%"></div>
                        </div>
                        <div class="dash-progress__labels">
                            <span>{{ $loan['progress'] }}{{ __('dashboard.index.repaid') }}</span>
                            <span>{{ number_format($loan['remaining'], 0, ',', ' ') }} {{ __('dashboard.index.remaining_kpi') }}</span>
                        </div>
                    </div>
                </div>
                <div class="dash-loan-row__right">
                    <div class="dash-loan-row__amount">{{ number_format($loan['monthly'], 0, ',', ' ') }} €</div>
                    <div class="dash-loan-row__monthly">{{ __('dashboard.per_month') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Notifications --}}
    <div class="dash-widget">
        <div class="dash-widget__header">
            <span class="dash-widget__title">{{ __('dashboard.index.widget_notifs') }}</span>
            <span class="dash-nav__badge" style="font-size:11px;">{{ count($notifs) }}</span>
        </div>
        <div class="dash-widget__body">
            @foreach($notifs as $n)
            <div class="dash-notif-item">
                <div class="dash-notif-item__icon dash-notif-item__icon--{{ $n['color'] }}">{{ $n['icon'] }}</div>
                <div>
                    <p class="dash-notif-item__text">{{ $n['text'] }}</p>
                    <p class="dash-notif-item__time">{{ $n['time'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Demande en cours --}}
@if(count($requests) > 0)
<div class="dash-widget" style="margin-bottom:24px;">
    <div class="dash-widget__header">
        <span class="dash-widget__title">{{ __('dashboard.index.widget_requests') }}</span>
        <a href="{{ route('dashboard.requests') }}" class="dash-widget__link">{{ __('dashboard.see_all') }}</a>
    </div>
    <div class="dash-widget__body">
        @foreach($requests as $req)
        @php
            $statusMap = [
                'pending'  => ['analysis', __('dashboard.requests.badge.pending')],
                'analysis' => ['analysis', __('dashboard.requests.badge.under_review')],
                'offer'    => ['success',  __('dashboard.requests.badge.validated')],
                'signed'   => ['success',  __('dashboard.requests.badge.confirmed')],
                'rejected' => ['error',    __('dashboard.requests.badge.rejected')],
            ];
            [$statusClass, $statusLabel] = $statusMap[$req['status']] ?? ['analysis', ucfirst($req['status'])];
        @endphp
        <div style="margin-bottom:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <span style="font-size:24px;">{{ $req['icon'] }}</span>
                    <div>
                        <strong style="font-size:15px;">{{ $req['type'] }} — {{ number_format($req['amount'], 0, ',', ' ') }} €</strong>
                        <p style="font-size:12px;color:var(--text-muted);">{{ __('dashboard.index.submitted_on') }} {{ \Carbon\Carbon::parse($req['date'])->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="dash-status dash-status--{{ $statusClass }}">{{ $statusLabel }}</span>
            </div>
            <div class="dash-stepper-wrap">
                <div class="dash-stepper">
                    @foreach($req['steps'] as $i => $step)
                    <div class="dash-step {{ $i < $req['step'] ? 'done' : ($i === $req['step'] ? 'current' : '') }}">
                        <div class="dash-step__dot">{{ $i < $req['step'] ? '✓' : $i + 1 }}</div>
                        <span class="dash-step__label">{{ $step }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Virements récents --}}
@if($recentTransfers->isNotEmpty())
<div class="dash-widget" style="margin-bottom:24px;">
    <div class="dash-widget__header">
        <span class="dash-widget__title">{{ __('dashboard.index.widget_transfers') }}</span>
        <a href="{{ route('dashboard.transfers.index') }}" class="dash-widget__link">{{ __('dashboard.see_all') }}</a>
    </div>

    {{-- Alerte si virement en pause --}}
    @if($transferStats['paused'] > 0)
    <div class="dash-transfer-alert" style="margin:0 20px 16px;padding:12px 16px;background:rgba(217,119,6,0.06);border:1px solid rgba(217,119,6,0.25);border-radius:10px;display:flex;align-items:center;gap:10px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5" style="flex-shrink:0;"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
        <span style="font-size:13px;color:#92400e;font-weight:600;">{{ trans_choice('dashboard.index.paused_alert', $transferStats['paused'], ['n' => $transferStats['paused']]) }}</span>
        <a href="{{ route('dashboard.transfers.index') }}" style="margin-left:auto;font-size:12px;color:#d97706;font-weight:700;text-decoration:none;white-space:nowrap;">{{ __('dashboard.index.unlock') }}</a>
    </div>
    @endif

    <div class="dash-widget__body" style="padding:0;">
        @foreach($recentTransfers as $t)
        @php
            $statusColors = [
                'pending'    => ['bg'=>'#fef3c7','color'=>'#92400e'],
                'approved'   => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                'processing' => ['bg'=>'#eff6ff','color'=>'#267BF1'],
                'paused'     => ['bg'=>'#fef3c7','color'=>'#d97706'],
                'completed'  => ['bg'=>'#dcfce7','color'=>'#15803d'],
                'rejected'   => ['bg'=>'#fee2e2','color'=>'#dc2626'],
            ];
            $sc = $statusColors[$t->status] ?? ['bg'=>'#f1f5f9','color'=>'#64748b'];
        @endphp
        <a href="{{ route('dashboard.transfers.show', $t) }}"
           style="display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid var(--border);text-decoration:none;transition:background .15s;"
           onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background=''">

            {{-- Icône statut --}}
            <div style="width:38px;height:38px;border-radius:12px;background:{{ $sc['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                @if($t->status === 'completed')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $sc['color'] }}" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                @elseif($t->status === 'rejected')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $sc['color'] }}" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                @elseif($t->status === 'paused')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $sc['color'] }}" stroke-width="2.5"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                @elseif($t->status === 'processing')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $sc['color'] }}" stroke-width="2.5"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                @elseif($t->status === 'approved')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $sc['color'] }}" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                @else
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $sc['color'] }}" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                @endif
            </div>

            {{-- Infos --}}
            <div style="flex:1;min-width:0;">
                <div style="font-size:14px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $t->recipient_name }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">{{ $t->created_at->format('d/m/Y') }}</div>
                @if(in_array($t->status, ['processing','paused']) && $t->progress > 0)
                <div style="margin-top:6px;display:flex;align-items:center;gap:8px;">
                    <div style="flex:1;height:4px;background:#eef2f9;border-radius:2px;overflow:hidden;">
                        <div style="height:100%;width:{{ $t->progress }}%;background:{{ $t->status==='paused' ? '#d97706' : '#267BF1' }};border-radius:2px;transition:width .3s;"></div>
                    </div>
                    <span style="font-size:11px;font-weight:700;color:{{ $t->status==='paused' ? '#d97706' : '#267BF1' }};">{{ $t->progress }}%</span>
                </div>
                @endif
            </div>

            {{-- Montant + badge --}}
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-size:15px;font-weight:800;color:var(--text);font-family:var(--font-mono);">{{ number_format($t->amount, 0, ',', ' ') }} €</div>
                <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:6px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $t->statusLabel() }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- Actions rapides --}}
<div class="dash-quick-actions">
    @foreach([
        ['icon'=>'🧮','title'=>__('dashboard.index.quick_sim'),'desc'=>__('dashboard.index.quick_sim_desc'),'href'=>route('simulator.index'),'color'=>'var(--blue)'],
        ['icon'=>'📁','title'=>__('dashboard.index.quick_docs'),'desc'=>__('dashboard.index.quick_docs_desc'),'href'=>route('dashboard.documents'),'color'=>'var(--gold)'],
        ['icon'=>'💬','title'=>__('dashboard.index.quick_contact'),'desc'=>__('dashboard.index.quick_contact_desc'),'href'=>route('contact'),'color'=>'var(--success)'],
    ] as $a)
    <a href="{{ $a['href'] }}" class="dash-widget" style="padding:22px;display:flex;gap:14px;align-items:center;text-decoration:none;transition:transform 0.2s,box-shadow 0.2s;" onmouseenter="this.style.transform='translateY(-3px)';this.style.boxShadow='var(--shadow-md)'" onmouseleave="this.style.transform='';this.style.boxShadow=''">
        <span style="font-size:28px;width:48px;height:48px;background:rgba(0,0,0,0.04);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $a['icon'] }}</span>
        <div>
            <strong style="font-size:14px;color:var(--text);display:block;">{{ $a['title'] }}</strong>
            <span style="font-size:12px;color:var(--text-muted);">{{ $a['desc'] }}</span>
        </div>
    </a>
    @endforeach
</div>

@endsection
