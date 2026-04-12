@extends('layouts.admin')
@section('title', 'Client — ' . $member->name)

@section('content')

<div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
    <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#267BF1,#1a56b0);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;color:#fff;flex-shrink:0;">
        {{ strtoupper(substr($member->name, 0, 2)) }}
    </div>
    <div>
        <h2 style="margin:0;font-size:20px;font-weight:800;color:#1a2540;">{{ $member->name }}</h2>
        <p style="margin:2px 0 0;font-size:13px;color:#718096;">{{ $member->email }} · Client depuis {{ $member->created_at->format('M Y') }}</p>
    </div>
    @if($member->is_admin)
    <span class="admin-badge admin-badge--analysis" style="margin-left:auto;">Admin</span>
    @endif
</div>

<div class="admin-grid-2" style="margin-bottom:24px;">
    {{-- Infos perso --}}
    <div class="admin-card">
        <div class="admin-card__header"><span class="admin-card__title">Informations</span></div>
        <div style="padding:20px 24px;display:flex;flex-direction:column;gap:12px;">
            @foreach([['Email', $member->email], ['Téléphone', $member->phone ?? '—'], ['Inscription', $member->created_at->format('d/m/Y à H:i')]] as [$label, $val])
            <div style="display:flex;justify-content:space-between;font-size:13px;border-bottom:1px solid rgba(38,123,241,0.05);padding-bottom:10px;">
                <span style="color:#718096;font-weight:600;">{{ $label }}</span>
                <span style="color:#1a2540;">{{ $val }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Prêts --}}
    <div class="admin-card">
        <div class="admin-card__header"><span class="admin-card__title">Prêts ({{ $member->loans->count() }})</span></div>
        <div class="admin-table-scroll"><table class="admin-table">
            <thead><tr><th>Type</th><th>Montant</th><th>Statut</th></tr></thead>
            <tbody>
                @forelse($member->loans as $l)
                <tr>
                    <td>{{ $l->typeLabel() }}</td>
                    <td style="font-family:var(--font-mono);font-weight:700;">{{ number_format($l->amount, 0, ',', ' ') }} €</td>
                    <td><span class="admin-badge admin-badge--{{ $l->status }}">{{ $l->statusLabel() }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#718096;padding:16px;">Aucun prêt</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
</div>

<div class="admin-grid-2">
    {{-- Demandes --}}
    <div class="admin-card">
        <div class="admin-card__header"><span class="admin-card__title">Demandes ({{ $member->loanRequests->count() }})</span></div>
        <div class="admin-table-scroll"><table class="admin-table">
            <thead><tr><th>Type</th><th>Montant</th><th>Statut</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($member->loanRequests as $r)
                <tr>
                    <td>{{ ucwords(str_replace(['-','_'],' ',$r->loan_type)) }}</td>
                    <td style="font-family:var(--font-mono);">{{ number_format($r->amount, 0, ',', ' ') }} €</td>
                    <td><span class="admin-badge admin-badge--{{ $r->status }}">{{ $r->statusLabel() }}</span></td>
                    <td>{{ $r->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#718096;padding:16px;">Aucune demande</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>

    {{-- Rendez-vous --}}
    <div class="admin-card">
        <div class="admin-card__header"><span class="admin-card__title">Rendez-vous ({{ $member->appointments->count() }})</span></div>
        <div class="admin-table-scroll"><table class="admin-table">
            <thead><tr><th>Date</th><th>Sujet</th><th>Statut</th></tr></thead>
            <tbody>
                @forelse($member->appointments as $a)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }} {{ $a->time }}</td>
                    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $a->subject }}</td>
                    <td><span class="admin-badge admin-badge--{{ $a->status }}">{{ match($a->status){'upcoming'=>'À venir','past'=>'Passé','cancelled'=>'Annulé',default=>$a->status} }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#718096;padding:16px;">Aucun RDV</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
</div>

<div style="margin-top:16px;">
    <a href="{{ route('admin.users') }}" class="admin-btn admin-btn--outline">← Retour à la liste</a>
</div>

@endsection
