@extends('layouts.admin')
@section('title', 'Vue d\'ensemble')

@section('content')

<div class="admin-stats">
    <div class="admin-stat admin-stat--alert">
        <div class="admin-stat__label">Demandes en attente</div>
        <div class="admin-stat__value">{{ $stats['pending'] }}</div>
        <div class="admin-stat__sub">À traiter</div>
    </div>
    <div class="admin-stat admin-stat--warning">
        <div class="admin-stat__label">Dossiers actifs</div>
        <div class="admin-stat__value">{{ $stats['active_requests'] }}</div>
        <div class="admin-stat__sub">En cours de traitement</div>
    </div>
    <div class="admin-stat admin-stat--success">
        <div class="admin-stat__label">Prêts actifs</div>
        <div class="admin-stat__value">{{ $stats['loans'] }}</div>
        <div class="admin-stat__sub">En cours de remboursement</div>
    </div>
    <div class="admin-stat admin-stat--blue">
        <div class="admin-stat__label">Clients inscrits</div>
        <div class="admin-stat__value">{{ $stats['users'] }}</div>
        <div class="admin-stat__sub">Comptes actifs</div>
    </div>
    <div class="admin-stat">
        <div class="admin-stat__label">Messages non lus</div>
        <div class="admin-stat__value" style="{{ $stats['messages'] > 0 ? 'color:#f59e0b' : '' }}">{{ $stats['messages'] }}</div>
        <div class="admin-stat__sub">Depuis les clients</div>
    </div>
    <div class="admin-stat">
        <div class="admin-stat__label">RDV à venir</div>
        <div class="admin-stat__value">{{ $stats['appointments'] }}</div>
        <div class="admin-stat__sub">Planifiés</div>
    </div>
    <div class="admin-stat">
        <div class="admin-stat__label">Contacts publics</div>
        <div class="admin-stat__value" style="{{ $stats['contacts'] > 0 ? 'color:#ef4444' : '' }}">{{ $stats['contacts'] }}</div>
        <div class="admin-stat__sub">Non traités</div>
    </div>
    <div class="admin-stat">
        <div class="admin-stat__label">RDV publics</div>
        <div class="admin-stat__value" style="{{ $stats['rdv_requests'] > 0 ? 'color:#ef4444' : '' }}">{{ $stats['rdv_requests'] }}</div>
        <div class="admin-stat__sub">En attente</div>
    </div>
</div>

<div class="admin-grid-2">

    {{-- Demandes récentes --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <span class="admin-card__title">Dernières demandes de prêt</span>
            <a href="{{ route('admin.requests') }}" class="admin-btn admin-btn--outline admin-btn--sm">Voir tout</a>
        </div>
        <div class="admin-table-scroll"><table class="admin-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_requests as $r)
                <tr>
                    <td>
                        <div class="admin-user-chip">
                            <div class="admin-user-chip__av">{{ strtoupper(substr($r->user->name ?? 'U', 0, 2)) }}</div>
                            <div>
                                <div class="admin-user-chip__name">{{ $r->user->name ?? '—' }}</div>
                                <div class="admin-user-chip__email">{{ $r->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ ucwords(str_replace(['-','_'],' ',$r->loan_type)) }}</td>
                    <td style="font-family:var(--font-mono);font-weight:700;">{{ number_format($r->amount, 0, ',', ' ') }} €</td>
                    <td><span class="admin-badge admin-badge--{{ $r->status }}">{{ $r->statusLabel() }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#718096;padding:24px;">Aucune demande</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>

    {{-- Nouveaux clients --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <span class="admin-card__title">Nouveaux clients</span>
            <a href="{{ route('admin.users') }}" class="admin-btn admin-btn--outline admin-btn--sm">Voir tout</a>
        </div>
        <div class="admin-table-scroll"><table class="admin-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Inscription</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_users as $u)
                <tr>
                    <td>
                        <div class="admin-user-chip">
                            <div class="admin-user-chip__av">{{ strtoupper(substr($u->name, 0, 2)) }}</div>
                            <div>
                                <div class="admin-user-chip__name">{{ $u->name }}</div>
                                <div class="admin-user-chip__email">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $u->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($u->is_admin)
                        <span class="admin-badge admin-badge--analysis">Admin</span>
                        @else
                        <span style="color:#718096;font-size:12px;">Client</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#718096;padding:24px;">Aucun utilisateur</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>

</div>

@endsection
