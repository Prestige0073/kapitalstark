@extends('layouts.admin')
@section('title', 'Chat public')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Chat public</h1>
    <p class="admin-page-sub">Conversations des visiteurs anonymes</p>
</div>

<div class="admin-card">
    @if($sessions->isEmpty())
        <p style="padding:32px;text-align:center;color:var(--text-muted);">Aucune conversation pour l'instant.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>IP visiteur</th>
                    <th>Dernier message</th>
                    <th>Non lus</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $s)
                <tr>
                    <td><code>{{ $s->ip_address }}</code></td>
                    <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ $s->lastMessage?->body ?? '—' }}
                    </td>
                    <td>
                        @if($s->unread > 0)
                            <span class="admin-badge admin-badge--warning">{{ $s->unread }}</span>
                        @else
                            <span style="color:var(--text-muted)">0</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">{{ $s->last_seen_at?->format('d/m H:i') ?? $s->created_at->format('d/m H:i') }}</td>
                    <td style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('admin.chat.show', $s) }}" class="admin-btn admin-btn--sm">Voir →</a>
                        <form action="{{ route('admin.chat.delete', $s) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                    onclick="adminConfirm(this, 'Supprimer cette conversation ? Action irréversible.')">✕</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px;">{{ $sessions->links() }}</div>
    @endif
</div>
@endsection
