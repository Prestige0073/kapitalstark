@extends('layouts.admin')
@section('title', 'Utilisateurs')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Tous les clients</span>
        <span style="font-size:12px;color:#718096;">{{ $users->total() }} utilisateur(s)</span>
    </div>
    <form method="GET" action="{{ route('admin.users') }}" class="admin-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom ou email…">
        <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Chercher</button>
        @if(request('search'))
        <a href="{{ route('admin.users') }}" class="admin-btn admin-btn--outline admin-btn--sm">Effacer</a>
        @endif
    </form>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Téléphone</th>
                <th>Inscription</th>
                <th>Demandes</th>
                <th>Prêts</th>
                <th>Documents</th>
                <th>Rôle</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
            <tr>
                <td style="color:#718096;font-size:11px;font-family:var(--font-mono);">{{ $u->id }}</td>
                <td>
                    <div class="admin-user-chip">
                        <div class="admin-user-chip__av">{{ strtoupper(substr($u->name, 0, 2)) }}</div>
                        <div>
                            <div class="admin-user-chip__name">{{ $u->name }}</div>
                            <div class="admin-user-chip__email">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $u->phone ?? '—' }}</td>
                <td>{{ $u->created_at->format('d/m/Y') }}</td>
                <td style="text-align:center;font-family:var(--font-mono);font-weight:700;">{{ $u->loan_requests_count }}</td>
                <td style="text-align:center;font-family:var(--font-mono);font-weight:700;">{{ $u->loans_count }}</td>
                <td style="text-align:center;font-family:var(--font-mono);">{{ $u->documents_count }}</td>
                <td>
                    @if($u->is_admin)
                    <span class="admin-badge admin-badge--analysis">Admin</span>
                    @else
                    <span style="font-size:12px;color:#718096;">Client</span>
                    @endif
                </td>
                <td style="display:flex;gap:6px;align-items:center;">
                    <a href="{{ route('admin.users.show', $u->id) }}" class="admin-btn admin-btn--outline admin-btn--sm">Détail</a>
                    @if(!$u->is_admin)
                    <form action="{{ route('admin.users.delete', $u->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                onclick="adminConfirm(this, 'Supprimer {{ addslashes($u->name) }} ? Cette action est irréversible.')">✕</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#718096;padding:32px;">Aucun utilisateur</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())
    <div class="admin-pagination">{{ $users->links('pagination::simple-tailwind') }}</div>
    @endif
</div>

@endsection
