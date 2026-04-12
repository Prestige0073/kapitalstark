@extends('layouts.admin')
@section('title', 'Virements')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Demandes de virement</span>
    </div>
    <form method="GET" class="admin-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un client…">
        <select name="status">
            <option value="">Tous les statuts</option>
            <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>En attente</option>
            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>En cours</option>
            <option value="completed"  {{ request('status') === 'completed'  ? 'selected' : '' }}>Terminés</option>
            <option value="rejected"   {{ request('status') === 'rejected'   ? 'selected' : '' }}>Rejetés</option>
        </select>
        <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Filtrer</button>
    </form>

    <div class="admin-table-scroll"><table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Bénéficiaire</th>
                <th>Montant</th>
                <th>Progression</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transfers as $t)
            <tr>
                <td><span style="font-family:monospace;color:#8a9bb8;">{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                <td>
                    <div style="font-weight:600;">{{ $t->user->name }}</div>
                    <div style="font-size:11px;color:#8a9bb8;">{{ $t->user->email }}</div>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $t->recipient_name }}</div>
                    <div style="font-size:11px;font-family:monospace;color:#8a9bb8;">
                        {{ substr($t->recipient_iban, 0, 4) }}•••• {{ substr($t->recipient_iban, -4) }}
                    </div>
                </td>
                <td>
                    <span style="font-family:monospace;font-weight:700;font-size:14px;">
                        {{ number_format($t->amount, 2, ',', ' ') }} €
                    </span>
                </td>
                <td>
                    @if(in_array($t->status, ['processing', 'completed']))
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="flex:1;height:6px;background:#e5eaf5;border-radius:3px;overflow:hidden;">
                            <div style="height:100%;width:{{ $t->progress }}%;background:{{ $t->status==='completed' ? '#15803d' : '#267BF1' }};border-radius:3px;"></div>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:#1a2540;min-width:32px;">{{ $t->progress }}%</span>
                    </div>
                    @else
                    <span style="color:#c4cede;font-size:12px;">—</span>
                    @endif
                </td>
                <td>
                    @php
                        $cls = match($t->status) {
                            'pending'    => 'warning',
                            'processing' => 'info',
                            'completed'  => 'success',
                            'rejected'   => 'danger',
                            default      => 'muted',
                        };
                    @endphp
                    <span class="admin-badge admin-badge--{{ $cls }}">{{ $t->statusLabel() }}</span>
                </td>
                <td style="font-size:12px;color:#8a9bb8;">{{ $t->created_at->format('d/m/Y') }}</td>
                <td style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                    <a href="{{ route('admin.transfers.show', $t) }}" class="admin-btn admin-btn--outline admin-btn--sm">
                        Voir →
                    </a>
                    <form action="{{ route('admin.transfers.delete', $t->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                onclick="adminConfirm(this, 'Supprimer ce virement ? Action irréversible.')">✕</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:32px;color:#8a9bb8;">
                    Aucune demande de virement
                </td>
            </tr>
            @endforelse
        </tbody>
    </table></div>

    <div style="padding:16px 24px;">
        {{ $transfers->links() }}
    </div>
</div>

@endsection
