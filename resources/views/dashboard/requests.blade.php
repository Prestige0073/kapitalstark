@extends('layouts.dashboard')
@section('title', __('dashboard.requests.title'))

@section('content')

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.requests.title') }}</h2>
        <p>{{ __('dashboard.requests.sub') }}</p>
    </div>
    @if(!$hasActive)
    <a href="{{ route('dashboard.requests.new') }}" class="pf-btn pf-btn--primary" style="gap:8px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        {{ __('dashboard.requests.new_btn') }}
    </a>
    @endif
</div>

@forelse($requests as $req)
@php
    $steps = [
        ['label' => __('dashboard.requests.step1'), 'status' => 'pending'],
        ['label' => __('dashboard.requests.step2'), 'status' => 'contract_sent'],
        ['label' => __('dashboard.requests.step3'), 'status' => 'documents_submitted'],
        ['label' => __('dashboard.requests.step4'), 'status' => 'validated'],
        ['label' => __('dashboard.requests.step5'), 'status' => 'confirmed'],
        ['label' => __('dashboard.requests.step6'), 'status' => 'approved'],
    ];
    $stepIdx = $req['step'];   // 1-based
    $isRejected = $req['status'] === 'rejected';
@endphp

<div class="req-card" style="margin-bottom:28px;">

    {{-- ── En-tête ──────────────────────────────────────────── --}}
    <div class="req-card__head">
        <div class="req-card__head-left">
            <div class="req-card__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <strong class="req-card__title">{{ $req['type'] }}</strong>
                <span class="req-card__ref">{{ __('dashboard.requests.ref') }} #REF-{{ str_pad($req['id'], 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        <div class="req-card__head-right">
            <span class="req-amount">
                @if($req['approved_amount'])
                    {{ number_format($req['approved_amount'], 0, ',', ' ') }} €
                    <small style="font-size:11px;color:var(--text-muted);font-family:var(--font-body);font-weight:500;"> {{ __('dashboard.granted') }}</small>
                @else
                    {{ number_format($req['amount'], 0, ',', ' ') }} € <small style="font-size:11px;color:var(--text-muted);font-family:var(--font-body);font-weight:500;">{{ __('dashboard.requested') }}</small>
                @endif
            </span>
            @php
                $badgeCls = match($req['status']) {
                    'approved'            => 'req-badge--success',
                    'rejected'            => 'req-badge--danger',
                    'validated','confirmed'=> 'req-badge--success',
                    default               => 'req-badge--warning',
                };
            @endphp
            <span class="req-badge {{ $badgeCls }}">{{ __('dashboard.requests.badge.' . $req['status'], [], null) ?: ucfirst($req['status']) }}</span>
        </div>
    </div>

    <div class="req-card__body">

        {{-- ── Stepper ──────────────────────────────────────── --}}
        @if(!$isRejected)
        <div class="req-stepper">
            @foreach($steps as $i => $step)
            @php
                $stepNum  = $i + 1;
                $isDone   = $stepIdx > $stepNum;
                $isCurrent= $stepIdx === $stepNum;
            @endphp
            <div class="req-step {{ $isDone ? 'req-step--done' : ($isCurrent ? 'req-step--current' : '') }}">
                <div class="req-step__dot">
                    @if($isDone)
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    @else
                    <span>{{ $stepNum }}</span>
                    @endif
                </div>
                <span class="req-step__label">{{ $step['label'] }}</span>
            </div>
            @if($i < count($steps) - 1)
            <div class="req-step__line {{ $stepIdx > $i + 1 ? 'req-step__line--done' : '' }}"></div>
            @endif
            @endforeach
        </div>
        @else
        <div class="req-rejected-banner">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ __('dashboard.requests.rejected') }}
            @if($req['admin_notes'])<span style="font-weight:400;color:#ef4444;opacity:0.8;"> — {{ $req['admin_notes'] }}</span>@endif
        </div>
        @endif

        {{-- ── Zone d'action selon le statut ─────────────────── --}}
        @if($req['status'] === 'pending')
        <div class="req-action-box req-action-box--info">
            <div class="req-action-box__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <strong>{{ __('dashboard.requests.action_pending_title') }}</strong>
                <p>{{ __('dashboard.requests.action_pending_text') }}</p>
            </div>
        </div>

        @elseif($req['status'] === 'contract_sent')
        <div class="req-action-box req-action-box--blue">
            <div class="req-action-box__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div style="flex:1;">
                <strong>{{ __('dashboard.requests.action_contract_title') }}</strong>
                <p>{{ __('dashboard.requests.action_contract_text') }}</p>
                <a href="{{ route('dashboard.requests.contract', $req['id']) }}" class="pf-btn pf-btn--primary" style="margin-top:12px;display:inline-flex;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    {{ __('dashboard.requests.download_contract') }}
                </a>
            </div>
        </div>

        {{-- Formulaire upload --}}
        <div class="req-upload-form">
            <h4 class="req-upload-form__title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                {{ __('dashboard.requests.return_contract') }}
            </h4>
            <form action="{{ route('dashboard.requests.documents', $req['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="req-upload-field">
                    <label>{{ __('dashboard.requests.signed_contract') }} <span style="color:var(--error);">*</span></label>
                    <input type="file" name="signed_contract" accept=".pdf" required class="req-file-input">
                    @error('signed_contract')<p class="pf-error">{{ $message }}</p>@enderror
                </div>
                <div class="req-upload-field">
                    <label>{{ __('dashboard.requests.supporting_docs') }}</label>
                    <div class="req-docs-list" style="margin-bottom:8px;font-size:12px;color:var(--text-muted);">
                        {{ __('dashboard.requests.accepted_docs') }}
                    </div>
                    <input type="file" name="files[]" accept=".pdf,.jpg,.jpeg,.png" multiple class="req-file-input">
                </div>
                <button type="submit" class="pf-btn pf-btn--primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('dashboard.requests.send_dossier') }}
                </button>
            </form>
        </div>

        @elseif(in_array($req['status'], ['documents_submitted', 'under_review']))
        <div class="req-action-box req-action-box--info">
            <div class="req-action-box__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <div>
                <strong>{{ __('dashboard.requests.action_review_title') }}</strong>
                <p>{{ __('dashboard.requests.action_review_text') }}</p>
                @if(count($req['docs']))
                <div style="margin-top:10px;display:flex;flex-wrap:wrap;gap:6px;">
                    @foreach($req['docs'] as $doc)
                    <span style="font-size:11px;background:rgba(38,123,241,0.08);color:var(--blue);padding:3px 10px;border-radius:20px;font-weight:600;">
                        📎 {{ $doc['name'] }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        @elseif($req['status'] === 'validated')
        <div class="req-action-box req-action-box--success">
            <div class="req-action-box__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div style="flex:1;">
                <strong>{{ __('dashboard.requests.action_validated_title') }}</strong>
                <p>{{ __('dashboard.requests.action_validated_text') }}</p>
                <form action="{{ route('dashboard.requests.confirm', $req['id']) }}" method="POST" style="margin-top:12px;">
                    @csrf
                    <button type="submit" class="pf-btn pf-btn--primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ __('dashboard.requests.action_confirm_btn') }}
                    </button>
                </form>
            </div>
        </div>

        @elseif($req['status'] === 'confirmed')
        <div class="req-action-box req-action-box--info">
            <div class="req-action-box__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <strong>{{ __('dashboard.requests.action_confirmed_title') }}</strong>
                <p>{{ __('dashboard.requests.action_confirmed_text') }}</p>
            </div>
        </div>

        @elseif($req['status'] === 'approved')
        <div class="req-action-box req-action-box--approved">
            <div class="req-action-box__icon req-action-box__icon--gold">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
            </div>
            <div>
                <strong>{{ __('dashboard.requests.action_approved_title') }}</strong>
                <p>{!! __('dashboard.requests.action_approved_text', ['amount' => '<strong>' . number_format($req['approved_amount'], 0, ',', ' ') . ' €</strong>']) !!}</p>
                <div style="margin-top:12px;display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="{{ route('dashboard.card') }}" class="pf-btn pf-btn--primary" style="background:var(--gold);border-color:var(--gold);">
                        {{ __('dashboard.requests.action_account_btn') }}
                    </a>
                    <a href="{{ route('dashboard.loans') }}" class="pf-btn pf-btn--outline">
                        {{ __('dashboard.requests.action_loans_btn') }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div style="margin-top:14px;font-size:12px;color:var(--text-muted);">
            {{ __('dashboard.requests.submitted_on') }} {{ \Carbon\Carbon::parse($req['date'])->format('d M Y') }}
        </div>

    </div>
</div>
@empty
<div class="dash-widget" style="padding:60px;text-align:center;">
    <p style="font-size:40px;margin-bottom:16px;">📭</p>
    <h3 style="font-size:18px;margin-bottom:8px;">{{ __('dashboard.requests.empty_title') }}</h3>
    <p style="color:var(--text-muted);margin-bottom:24px;">{{ __('dashboard.requests.empty_text') }}</p>
    <a href="{{ route('dashboard.requests.new') }}" class="btn btn-primary">{{ __('dashboard.requests.empty_btn') }}</a>
</div>
@endforelse

@endsection

@section('styles')
<style>
/* ── Boutons réutilisés depuis profil ──── */
.pf-btn { display:inline-flex;align-items:center;gap:8px;padding:11px 20px;border-radius:var(--radius-md);font-size:14px;font-weight:700;font-family:var(--font-body);cursor:pointer;transition:all .2s;border:2px solid transparent;text-decoration:none; }
.pf-btn--primary { background:var(--blue);color:#fff;border-color:var(--blue);box-shadow:0 4px 14px rgba(38,123,241,.25); }
.pf-btn--primary:hover { background:var(--blue-dark);border-color:var(--blue-dark);transform:translateY(-1px); }
.pf-btn--outline { background:transparent;color:var(--navy);border-color:rgba(13,27,42,.2); }
.pf-btn--outline:hover { background:var(--navy);color:#fff;transform:translateY(-1px); }
.pf-error { font-size:12px;color:var(--error);margin-top:4px; }

/* ── Flash ─────────────────────────────── */
.req-flash { display:flex;align-items:center;gap:10px;padding:13px 18px;border-radius:var(--radius-md);font-size:14px;font-weight:600; }
.req-flash--success { background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#15803d; }
.req-flash--danger  { background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#dc2626; }
.req-flash--info    { background:rgba(38,123,241,.08);border:1px solid rgba(38,123,241,.2);color:var(--blue-dark); }

/* ── Request card ───────────────────────── */
.req-card { background:var(--white);border-radius:var(--radius-lg);border:1px solid rgba(38,123,241,.08);box-shadow:0 2px 16px rgba(38,123,241,.06);overflow:hidden; }

.req-card__head { display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;border-bottom:1px solid rgba(38,123,241,.07);flex-wrap:wrap; }
.req-card__head-left { display:flex;align-items:center;gap:14px; }
.req-card__icon { width:44px;height:44px;background:rgba(38,123,241,.08);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:var(--blue);flex-shrink:0; }
.req-card__title { font-size:16px;font-weight:700;color:var(--text);display:block; }
.req-card__ref { font-size:12px;color:var(--text-muted);font-family:var(--font-mono); }
.req-card__head-right { display:flex;align-items:center;gap:12px; }
.req-amount { font-family:var(--font-mono);font-size:18px;font-weight:700;color:var(--blue); }

.req-badge { display:inline-flex;align-items:center;font-size:12px;font-weight:700;padding:4px 10px;border-radius:20px; }
.req-badge--success { background:rgba(34,197,94,.12);color:#15803d; }
.req-badge--danger  { background:rgba(239,68,68,.1);color:#dc2626; }
.req-badge--warning { background:rgba(245,158,11,.12);color:#b45309; }

.req-card__body { padding:24px; }

/* ── Stepper ─────────────────────────────── */
.req-stepper { display:flex;align-items:center;margin-bottom:24px;overflow-x:auto;padding-bottom:4px; }
.req-step { display:flex;flex-direction:column;align-items:center;gap:8px;flex-shrink:0; }
.req-step__dot { width:32px;height:32px;border-radius:50%;background:var(--cream);border:2px solid rgba(38,123,241,.2);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--text-muted);transition:all .3s; }
.req-step--done .req-step__dot { background:var(--blue);border-color:var(--blue);color:#fff; }
.req-step--current .req-step__dot { background:var(--white);border-color:var(--blue);color:var(--blue);box-shadow:0 0 0 4px rgba(38,123,241,.12); }
.req-step__label { font-size:11px;font-weight:600;color:var(--text-muted);text-align:center;white-space:nowrap;max-width:90px; }
.req-step--done .req-step__label,.req-step--current .req-step__label { color:var(--text); }

.req-step__line { flex:1;height:2px;background:rgba(38,123,241,.12);margin:0 6px;margin-bottom:20px;min-width:20px;transition:background .3s; }
.req-step__line--done { background:var(--blue); }

/* ── Action boxes ───────────────────────── */
.req-action-box { display:flex;gap:16px;align-items:flex-start;padding:16px 20px;border-radius:var(--radius-md);margin-bottom:8px; }
.req-action-box p { font-size:13px;color:var(--text-muted);margin-top:4px;line-height:1.6; }
.req-action-box strong { font-size:14px;font-weight:700; }
.req-action-box__icon { width:40px;height:40px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.req-action-box__icon--gold { background:rgba(200,169,81,.15);color:var(--gold); }

.req-action-box--info    { background:rgba(38,123,241,.05);border:1px solid rgba(38,123,241,.12); }
.req-action-box--info    .req-action-box__icon { background:rgba(38,123,241,.1);color:var(--blue); }
.req-action-box--blue    { background:rgba(38,123,241,.06);border:1px solid rgba(38,123,241,.15); }
.req-action-box--blue    .req-action-box__icon { background:rgba(38,123,241,.12);color:var(--blue); }
.req-action-box--success { background:rgba(34,197,94,.06);border:1px solid rgba(34,197,94,.2); }
.req-action-box--success .req-action-box__icon { background:rgba(34,197,94,.12);color:#15803d; }
.req-action-box--approved{ background:linear-gradient(135deg,rgba(200,169,81,.08),rgba(34,197,94,.06));border:1px solid rgba(200,169,81,.25); }

.req-rejected-banner { display:flex;align-items:center;gap:10px;padding:12px 16px;background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.15);border-radius:var(--radius-md);font-size:14px;font-weight:700;color:#dc2626;margin-bottom:16px; }

/* ── Upload form ─────────────────────────── */
.req-upload-form { background:var(--cream);border-radius:var(--radius-md);border:1px solid rgba(38,123,241,.1);padding:20px 24px;margin-top:16px; }
.req-upload-form__title { font-size:14px;font-weight:700;color:var(--text);margin-bottom:16px;display:flex;align-items:center;gap:8px; }
.req-upload-field { margin-bottom:16px; }
.req-upload-field label { display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);margin-bottom:6px; }
.req-file-input { display:block;width:100%;padding:10px 14px;background:var(--white);border:2px solid rgba(38,123,241,.15);border-radius:var(--radius-md);font-size:13px;color:var(--text);transition:border-color .2s; }
.req-file-input:focus { outline:none;border-color:var(--blue);box-shadow:0 0 0 3px rgba(38,123,241,.1); }

@media (max-width: 600px) {
  .req-card__head { padding: 14px 16px; gap: 10px; }
  .req-card__body { padding: 16px; }
  .req-card__icon { width: 38px; height: 38px; }
  .req-card__title { font-size: 14px; }
  .req-amount { font-size: 15px; }
  .req-stepper { gap: 0; }
  .req-step__dot { width: 26px; height: 26px; font-size: 10px; }
  .req-step__label { font-size: 10px; max-width: 60px; }
  .req-step__line { min-width: 10px; }
  .req-action-box { padding: 12px 14px; gap: 10px; }
  .req-action-box__icon { width: 32px; height: 32px; }
  .req-upload-form { padding: 14px 16px; }
}

@media (max-width: 480px) {
  .req-card__head-right { width: 100%; justify-content: space-between; }
  .req-step__label { display: none; }
  .req-stepper { overflow-x: auto; }
  .req-rejected-banner { font-size: 13px; }
  .pf-btn { width: 100%; justify-content: center; }
}
</style>
@endsection
