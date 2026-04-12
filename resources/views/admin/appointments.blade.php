@extends('layouts.admin')
@section('title', 'Rendez-vous')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Tous les rendez-vous</span>
        <form method="GET" style="display:flex;gap:8px;">
            <select name="status" onchange="this.form.submit()" style="padding:6px 10px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;">
                <option value="">Tous</option>
                <option value="upcoming"  {{ request('status')==='upcoming'  ? 'selected' : '' }}>À venir</option>
                <option value="past"      {{ request('status')==='past'      ? 'selected' : '' }}>Passés</option>
                <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>Annulés</option>
            </select>
        </form>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Sujet</th>
                <th>Canal</th>
                <th>Conseiller</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $a)
            <tr>
                <td style="color:#718096;font-size:11px;font-family:var(--font-mono);">#{{ $a->id }}</td>
                <td>
                    <div class="admin-user-chip">
                        <div class="admin-user-chip__av">{{ strtoupper(substr($a->user->name ?? 'U', 0, 2)) }}</div>
                        <div>
                            <div class="admin-user-chip__name">{{ $a->user->name ?? '—' }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                <td>{{ $a->time }}</td>
                <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $a->subject }}</td>
                <td>{{ $a->channelLabel() }}</td>
                <td>{{ $a->advisor ?? '—' }}</td>
                <td><span class="admin-badge admin-badge--{{ $a->status }}">
                    {{ match($a->status){'upcoming'=>'À venir','past'=>'Passé','cancelled'=>'Annulé',default=>$a->status} }}
                </span></td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                        <form action="{{ route('admin.appointments.update', $a->id) }}" method="POST" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                            @csrf
                            <input type="hidden" name="notes" value="{{ $a->notes }}">
                            <input type="text" name="advisor" value="{{ $a->advisor }}" placeholder="Conseiller…"
                                style="padding:4px 8px;border:1.5px solid rgba(38,123,241,0.15);border-radius:6px;font-size:12px;width:110px;">
                            <select name="status" style="padding:4px 8px;border:1.5px solid rgba(38,123,241,0.15);border-radius:6px;font-size:12px;">
                                <option value="upcoming"  {{ $a->status==='upcoming'  ? 'selected':'' }}>À venir</option>
                                <option value="past"      {{ $a->status==='past'      ? 'selected':'' }}>Passé</option>
                                <option value="cancelled" {{ $a->status==='cancelled' ? 'selected':'' }}>Annulé</option>
                            </select>
                            <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">OK</button>
                        </form>
                        <form action="{{ route('admin.appointments.delete', $a->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                    onclick="adminConfirm(this, 'Supprimer le RDV #{{ $a->id }} de {{ addslashes($a->user->name ?? '') }} ? Cette action est irréversible.')">✕</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#718096;padding:32px;">Aucun rendez-vous</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($appointments->hasPages())
    <div class="admin-pagination">{{ $appointments->links('pagination::simple-tailwind') }}</div>
    @endif
</div>

@endsection
