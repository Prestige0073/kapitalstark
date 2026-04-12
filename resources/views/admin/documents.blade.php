@extends('layouts.admin')
@section('title', 'Bibliothèque de documents')

@section('content')

@if(session('success'))
<div class="admin-alert admin-alert--success" style="margin-bottom:20px;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="admin-alert admin-alert--error" style="margin-bottom:20px;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
    {{ session('error') }}
</div>
@endif

<div style="margin-bottom:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:#e2e8f0;margin:0 0 4px;">Bibliothèque de documents</h1>
        <p style="font-size:13px;color:#718096;margin:0;">Sauvegardez vos modèles et documents réutilisables.</p>
    </div>
    <button type="button" onclick="var p=document.getElementById('upload-panel');p.style.display=p.style.display==='none'?'block':'none';"
            class="admin-btn admin-btn--primary admin-btn--sm" style="display:flex;align-items:center;gap:8px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Ajouter un document
    </button>
</div>

{{-- ── Panneau d'upload ─────────────────────────────────── --}}
<div id="upload-panel" style="display:none;background:#1a202c;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:24px;margin-bottom:24px;">
    <h3 style="font-size:15px;font-weight:700;color:#e2e8f0;margin:0 0 20px;">Nouveau document</h3>
    <form action="{{ route('admin.documents.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:6px;">Titre <span style="color:#ef4444">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required maxlength="120"
                       placeholder="Ex : Contrat de prêt standard, Justificatif…"
                       style="width:100%;padding:9px 12px;background:#0f1520;border:1.5px solid rgba(38,123,241,0.2);border-radius:8px;color:#e2e8f0;font-size:13px;outline:none;box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:6px;">Catégorie <span style="color:#ef4444">*</span></label>
                <input type="text" name="category" value="{{ old('category', 'Général') }}" required maxlength="60"
                       list="cat-list"
                       placeholder="Contrats, Modèles, Guides…"
                       style="width:100%;padding:9px 12px;background:#0f1520;border:1.5px solid rgba(38,123,241,0.2);border-radius:8px;color:#e2e8f0;font-size:13px;outline:none;box-sizing:border-box;">
                <datalist id="cat-list">
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}">
                    @endforeach
                    <option value="Contrats">
                    <option value="Modèles">
                    <option value="Guides">
                    <option value="Formulaires">
                    <option value="Général">
                </datalist>
            </div>
        </div>
        <div style="margin-bottom:14px;">
            <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:6px;">Description (optionnelle)</label>
            <input type="text" name="description" value="{{ old('description') }}" maxlength="300"
                   placeholder="Brève description du document…"
                   style="width:100%;padding:9px 12px;background:#0f1520;border:1.5px solid rgba(38,123,241,0.2);border-radius:8px;color:#e2e8f0;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div style="margin-bottom:20px;">
            <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:6px;">Fichier <span style="color:#ef4444">*</span></label>
            <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                   style="color:#a0aec0;font-size:13px;">
            <div style="font-size:11px;color:#718096;margin-top:4px;">PDF, Word, Excel, images — max 20 Mo</div>
        </div>
        @if($errors->any())
        <div style="padding:10px 14px;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:8px;font-size:13px;color:#dc2626;margin-bottom:14px;">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif
        <div style="display:flex;gap:10px;">
            <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Enregistrer</button>
            <button type="button" onclick="document.getElementById('upload-panel').style.display='none';"
                    class="admin-btn admin-btn--outline admin-btn--sm">Annuler</button>
        </div>
    </form>
</div>

{{-- ── Filtres ───────────────────────────────────────────── --}}
<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Documents ({{ $docs->total() }})</span>
    </div>

    <form method="GET" action="{{ route('admin.documents') }}" class="admin-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un document…">
        <select name="category" onchange="this.form.submit()">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Filtrer</button>
        @if(request('search') || request('category'))
        <a href="{{ route('admin.documents') }}" class="admin-btn admin-btn--outline admin-btn--sm">Réinitialiser</a>
        @endif
    </form>

    @if($docs->isEmpty())
    <div style="padding:48px;text-align:center;color:#718096;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="margin-bottom:12px;opacity:.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <p style="margin:0;font-size:14px;">Aucun document dans la bibliothèque.</p>
        <p style="margin:4px 0 0;font-size:12px;">Cliquez sur "Ajouter un document" pour commencer.</p>
    </div>
    @else
    <div class="admin-table-scroll"><table class="admin-table">
        <thead>
            <tr>
                <th>Document</th>
                <th>Catégorie</th>
                <th>Taille</th>
                <th>Ajouté le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docs as $doc)
            <tr>
                <td>
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(38,123,241,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:10px;font-weight:700;color:#267BF1;font-family:monospace;">
                            {{ strtoupper(pathinfo($doc->original_name, PATHINFO_EXTENSION)) }}
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#e2e8f0;">{{ $doc->title }}</div>
                            @if($doc->description)
                            <div style="font-size:11px;color:#718096;margin-top:2px;">{{ $doc->description }}</div>
                            @endif
                            <div style="font-size:11px;color:#4a5568;margin-top:2px;font-family:monospace;">{{ $doc->original_name }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="admin-badge admin-badge--info">{{ $doc->category }}</span></td>
                <td style="font-size:12px;color:#718096;font-family:monospace;">{{ $doc->sizeForHumans() }}</td>
                <td style="font-size:12px;color:#718096;">{{ $doc->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('admin.documents.download', $doc->id) }}"
                           class="admin-btn admin-btn--outline admin-btn--sm" title="Télécharger">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </a>
                        <form action="{{ route('admin.documents.delete', $doc->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="admin-btn admin-btn--sm"
                                    style="color:#ef4444;border-color:rgba(239,68,68,.3);background:rgba(239,68,68,.05);" title="Supprimer"
                                    onclick="adminConfirm(this, 'Supprimer ce document ?')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table></div>
    @if($docs->hasPages())
    <div class="admin-pagination">{{ $docs->links('pagination::simple-tailwind') }}</div>
    @endif
    @endif
</div>

@endsection

@section('scripts')
<script>
@if($errors->any())
document.getElementById('upload-panel').style.display = 'block';
@endif
</script>
@endsection
