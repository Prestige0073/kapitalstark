@extends('layouts.admin')
@section('title', 'Messagerie clients')

@section('content')

<div class="admin-msgs-title" style="margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:700;color:#e2e8f0;margin:0 0 4px;">Messagerie clients</h1>
    <p style="font-size:13px;color:#718096;margin:0;">Échangez avec vos clients en temps réel.</p>
</div>

<div class="admin-msgs-layout {{ $selectedUserId ? 'has-user' : '' }}">

    {{-- Colonne gauche : liste des users --}}
    <div class="admin-msgs-users">
        <div style="padding:16px;border-bottom:1px solid rgba(255,255,255,0.07);">
            <p style="font-size:13px;font-weight:700;color:#a0aec0;text-transform:uppercase;letter-spacing:.06em;margin:0 0 2px;">Clients ({{ $users->count() }})</p>
            @php $withMsg = $users->filter(fn($u) => $u->messages->isNotEmpty())->count(); @endphp
            <p style="font-size:11px;color:#4a5568;margin:0;">{{ $withMsg }} conversation{{ $withMsg > 1 ? 's' : '' }} active{{ $withMsg > 1 ? 's' : '' }}</p>
        </div>

        @forelse($users as $u)
        @php
            $isActive   = $selectedUserId === $u->id;
            $initials   = strtoupper(substr($u->name, 0, 2));
            $hasMessages = $u->messages->isNotEmpty();
            $lastMsg    = $u->messages->first();
        @endphp
        <a href="{{ route('admin.messages', ['user_id' => $u->id]) }}"
           style="display:flex;align-items:center;gap:12px;padding:14px 16px;border-bottom:1px solid rgba(255,255,255,0.04);text-decoration:none;transition:background .15s;background:{{ $isActive ? 'rgba(38,123,241,0.15)' : 'transparent' }};"
           onmouseover="if(!{{ $isActive ? 'true' : 'false' }})this.style.background='rgba(255,255,255,0.04)'"
           onmouseout="if(!{{ $isActive ? 'true' : 'false' }})this.style.background='transparent'">
            <div style="position:relative;flex-shrink:0;">
                <div style="width:38px;height:38px;border-radius:50%;background:{{ $isActive ? '#267BF1' : ($hasMessages ? 'rgba(38,123,241,0.3)' : 'rgba(100,116,139,0.25)') }};color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;">
                    {{ $initials }}
                </div>
                @if(!$hasMessages)
                <div style="position:absolute;bottom:0;right:0;width:10px;height:10px;border-radius:50%;background:#64748b;border:2px solid #151b26;" title="Aucun message"></div>
                @elseif($u->unread_count > 0)
                <div style="position:absolute;bottom:0;right:0;width:10px;height:10px;border-radius:50%;background:#e53e3e;border:2px solid #151b26;"></div>
                @else
                <div style="position:absolute;bottom:0;right:0;width:10px;height:10px;border-radius:50%;background:#38a169;border:2px solid #151b26;"></div>
                @endif
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:{{ $isActive ? '700' : '600' }};color:{{ $isActive ? '#fff' : '#cbd5e0' }};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $u->name }}</div>
                <div style="font-size:11px;color:#718096;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    @if(!$hasMessages)
                    <span style="color:#4a5568;font-style:italic;">Pas encore de conversation</span>
                    @elseif($lastMsg)
                    {{ $lastMsg->created_at->diffForHumans() }}
                    @endif
                </div>
            </div>
            @if($u->unread_count > 0)
            <span style="min-width:18px;height:18px;padding:0 5px;background:#e53e3e;color:#fff;border-radius:100px;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $u->unread_count }}</span>
            @endif
        </a>
        @empty
        <div style="padding:24px;text-align:center;color:#718096;font-size:13px;">Aucun client inscrit</div>
        @endforelse
    </div>

    {{-- Colonne droite : conversation --}}
    <div class="admin-msgs-conv">

        @if(!$selectedUserId)
        <div style="flex:1;display:flex;align-items:center;justify-content:center;color:#718096;font-size:14px;">
            Sélectionnez un client pour voir la conversation.
        </div>
        @else
        @php $selectedUser = $allUsers->firstWhere('id', $selectedUserId); @endphp

        {{-- Bouton retour (visible uniquement sur mobile) --}}
        <a href="{{ route('admin.messages') }}" class="admin-msgs-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Conversations
        </a>

        {{-- Header --}}
        <div style="padding:14px 24px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:12px;flex-shrink:0;background:#1a202c;">
            <div style="width:40px;height:40px;border-radius:50%;background:#267BF1;color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;">
                {{ strtoupper(substr($selectedUser->name ?? 'U', 0, 2)) }}
            </div>
            <div>
                <div style="font-size:15px;font-weight:700;color:#e2e8f0;">{{ $selectedUser->name ?? '—' }}</div>
                <div style="font-size:12px;color:#718096;">{{ $selectedUser->email ?? '' }}</div>
            </div>
        </div>

        {{-- Zone de chat --}}
        <div id="chat-body" style="flex:1;overflow-y:auto;padding:20px 24px;display:flex;flex-direction:column;gap:12px;">
            @forelse($conversation as $m)
            <div style="display:flex;justify-content:{{ $m->direction === 'outbound' ? 'flex-end' : 'flex-start' }};align-items:flex-end;gap:6px;margin-bottom:4px;" id="msg-{{ $m->id }}">
                {{-- Bouton supprimer (apparaît au hover via CSS inline) --}}
                @if($m->direction === 'outbound')
                <form action="{{ route('admin.messages.delete', $m->id) }}" method="POST" style="order:-1;">
                    @csrf @method('DELETE')
                    <button type="button" title="Supprimer"
                            style="width:24px;height:24px;border-radius:6px;background:rgba(239,68,68,0.15);color:#ef4444;font-size:12px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;opacity:0.6;transition:opacity .2s;"
                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'"
                            onclick="adminConfirm(this, 'Supprimer ce message ?')">✕</button>
                </form>
                @endif
                <div data-ts="{{ $m->created_at->toISOString() }}"
                     style="max-width:68%;padding:12px 16px;border-radius:{{ $m->direction === 'outbound' ? '16px 4px 16px 16px' : '4px 16px 16px 16px' }};background:{{ $m->direction === 'outbound' ? '#267BF1' : 'rgba(255,255,255,0.07)' }};color:{{ $m->direction === 'outbound' ? '#fff' : '#e2e8f0' }};font-size:14px;line-height:1.5;">
                    <p style="margin:0 0 4px;white-space:pre-wrap;">{{ $m->body }}</p>
                    <span style="font-size:11px;opacity:0.6;display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                        {{ $m->created_at->format('d/m/Y H:i') }}
                        @if($m->direction === 'outbound')
                            @if($m->read)
                            <span title="Lu par le client" style="color:{{ '#A8CFF7' }};">✓✓ Lu</span>
                            @else
                            <span title="Pas encore lu">✓ Envoyé</span>
                            @endif
                        @endif
                    </span>
                    @if($m->attachment_name)
                    <div style="margin-top:8px;">
                        <a href="{{ route('admin.messages.download', $m->id) }}"
                           style="color:{{ $m->direction === 'outbound' ? '#A8CFF7' : '#267BF1' }};font-size:12px;text-decoration:none;">
                            &#128206; {{ $m->attachment_name }}
                        </a>
                    </div>
                    @endif
                </div>
                @if($m->direction === 'inbound')
                <form action="{{ route('admin.messages.delete', $m->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" title="Supprimer"
                            style="width:24px;height:24px;border-radius:6px;background:rgba(239,68,68,0.15);color:#ef4444;font-size:12px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;opacity:0.6;transition:opacity .2s;"
                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'"
                            onclick="adminConfirm(this, 'Supprimer ce message ?')">✕</button>
                </form>
                @endif
            </div>
            @empty
            <div style="text-align:center;color:#718096;font-size:13px;margin-top:40px;">Aucun message pour ce client. Envoyez le premier message ci-dessous.</div>
            @endforelse
        </div>

        {{-- Formulaire d'envoi --}}
        @php
            $prefillSubject = request('prefill_subject', '');
            $prefillBody    = request('prefill_body', '');
        @endphp
        <div class="admin-msgs-send-area" style="padding:16px 24px;border-top:1px solid rgba(255,255,255,0.07);background:#151b26;flex-shrink:0;">
            @if($prefillBody)
            <div style="display:flex;align-items:center;gap:8px;padding:8px 12px;margin-bottom:10px;background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:8px;font-size:12px;color:#d97706;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Message pré-rempli avec le code de déblocage — vérifiez puis cliquez Envoyer.
            </div>
            @endif
            <form action="{{ route('admin.messages.send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $selectedUserId }}">
                <div class="admin-compose-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                    <div>
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Client</label>
                        <select name="user_id_display" onchange="window.location='/admin/messagerie?user_id='+this.value"
                                style="width:100%;padding:8px 10px;background:#0f1520;border:1.5px solid rgba(38,123,241,0.2);border-radius:8px;color:#e2e8f0;font-size:13px;outline:none;">
                            @foreach($allUsers as $u)
                            <option value="{{ $u->id }}" {{ $u->id === $selectedUserId ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Sujet</label>
                        <input type="text" name="subject" placeholder="Sujet du message…"
                               value="{{ $prefillSubject }}"
                               style="width:100%;padding:8px 10px;background:#0f1520;border:1.5px solid {{ $prefillSubject ? 'rgba(245,158,11,0.4)' : 'rgba(38,123,241,0.2)' }};border-radius:8px;color:#e2e8f0;font-size:13px;outline:none;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:10px;">
                    <textarea name="body" required placeholder="Rédigez votre message…"
                              style="width:100%;padding:10px 14px;background:#0f1520;border:1.5px solid {{ $prefillBody ? 'rgba(245,158,11,0.4)' : 'rgba(38,123,241,0.2)' }};border-radius:8px;color:#e2e8f0;font-size:13px;resize:vertical;min-height:80px;outline:none;font-family:inherit;box-sizing:border-box;">{{ $prefillBody }}</textarea>
                </div>
                {{-- Hidden input for library doc attachment --}}
                <input type="hidden" name="library_doc_id" id="lib-doc-id" value="">

                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <span style="font-size:12px;color:#718096;">Pièce jointe :</span>
                        <input type="file" name="attachment" id="file-attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                               style="font-size:12px;color:#a0aec0;">
                    </label>
                    <button type="button" onclick="openLibraryPicker()"
                            style="display:flex;align-items:center;gap:6px;padding:7px 12px;background:rgba(38,123,241,0.1);border:1px solid rgba(38,123,241,0.3);border-radius:8px;color:#267BF1;font-size:12px;font-weight:600;cursor:pointer;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Bibliothèque
                    </button>
                    <div id="lib-doc-preview" style="display:none;font-size:12px;color:#a0aec0;align-items:center;gap:6px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                        <span id="lib-doc-name"></span>
                        <button type="button" onclick="clearLibraryDoc()" style="background:none;border:none;cursor:pointer;color:#ef4444;font-size:14px;line-height:1;padding:0;">×</button>
                    </div>
                    <button type="submit"
                            style="margin-left:auto;padding:10px 20px;background:#267BF1;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                        Envoyer
                    </button>
                </div>
            </form>

            {{-- ── Library Picker Modal ──────────────────────────── --}}
            <div id="lib-picker-overlay" onclick="if(event.target===this)closeLibraryPicker()"
                 style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:999;align-items:center;justify-content:center;">
                <div style="background:#1a202c;border:1px solid rgba(255,255,255,0.1);border-radius:16px;width:520px;max-width:95vw;max-height:80vh;display:flex;flex-direction:column;box-shadow:0 24px 64px rgba(0,0,0,.5);">
                    <div style="padding:18px 20px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                        <span style="font-size:15px;font-weight:700;color:#e2e8f0;">Choisir depuis la bibliothèque</span>
                        <button onclick="closeLibraryPicker()" style="background:none;border:none;cursor:pointer;color:#718096;font-size:20px;line-height:1;padding:0;">×</button>
                    </div>
                    <div style="padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.07);flex-shrink:0;">
                        <input type="text" id="lib-search" oninput="filterLibDocs()" placeholder="Rechercher…"
                               style="width:100%;padding:8px 12px;background:#0f1520;border:1.5px solid rgba(38,123,241,0.2);border-radius:8px;color:#e2e8f0;font-size:13px;outline:none;box-sizing:border-box;">
                    </div>
                    <div id="lib-list" style="overflow-y:auto;padding:12px 20px;flex:1;">
                        <div style="text-align:center;color:#718096;padding:24px;font-size:13px;">Chargement…</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@section('scripts')
<script>
// ── Library picker ────────────────────────────────────────
var libDocs = [];

function openLibraryPicker() {
    var overlay = document.getElementById('lib-picker-overlay');
    overlay.style.display = 'flex';
    if (!libDocs.length) {
        fetch('{{ route('admin.documents.json') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                libDocs = data;
                renderLibDocs(data);
            })
            .catch(function() {
                document.getElementById('lib-list').innerHTML = '<div style="text-align:center;color:#ef4444;padding:24px;font-size:13px;">Erreur de chargement.</div>';
            });
    } else {
        renderLibDocs(libDocs);
    }
}

function closeLibraryPicker() {
    document.getElementById('lib-picker-overlay').style.display = 'none';
}

function filterLibDocs() {
    var q = document.getElementById('lib-search').value.toLowerCase();
    renderLibDocs(libDocs.filter(function(d) {
        return d.title.toLowerCase().includes(q) || d.category.toLowerCase().includes(q);
    }));
}

function renderLibDocs(docs) {
    var list = document.getElementById('lib-list');
    if (!docs.length) {
        list.innerHTML = '<div style="text-align:center;color:#718096;padding:24px;font-size:13px;">Aucun document trouvé.</div>';
        return;
    }
    list.innerHTML = docs.map(function(d) {
        return '<div onclick="selectLibDoc(' + d.id + ',\'' + escLib(d.title) + '\',\'' + escLib(d.original_name) + '\')" style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:8px;cursor:pointer;transition:background .15s;" onmouseover="this.style.background=\'rgba(255,255,255,0.05)\'" onmouseout="this.style.background=\'transparent\'">'
            + '<div style="width:32px;height:32px;border-radius:7px;background:rgba(38,123,241,0.12);display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#267BF1;font-family:monospace;flex-shrink:0;">' + escLib(d.ext) + '</div>'
            + '<div style="flex:1;min-width:0;">'
            + '<div style="font-size:13px;font-weight:600;color:#e2e8f0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + escLib(d.title) + '</div>'
            + '<div style="font-size:11px;color:#718096;">' + escLib(d.category) + ' · ' + escLib(d.size) + '</div>'
            + '</div>'
            + '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#267BF1" stroke-width="2" style="flex-shrink:0;opacity:0.6"><polyline points="9 18 15 12 9 6"/></svg>'
            + '</div>';
    }).join('');
}

function escLib(s) {
    return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/'/g,'&#39;').replace(/"/g,'&quot;');
}

function selectLibDoc(id, title, originalName) {
    document.getElementById('lib-doc-id').value = id;
    document.getElementById('lib-doc-name').textContent = title;
    document.getElementById('lib-doc-preview').style.display = 'flex';
    // Clear file input since library doc takes priority
    document.getElementById('file-attachment').value = '';
    closeLibraryPicker();
}

function clearLibraryDoc() {
    document.getElementById('lib-doc-id').value = '';
    document.getElementById('lib-doc-preview').style.display = 'none';
}

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLibraryPicker();
});
</script>

<script>
(function() {
    'use strict';
    const userId = {{ $selectedUserId ?? 'null' }};
    if (!userId) return;

    const chatBody    = document.getElementById('chat-body');
    const textarea    = document.querySelector('textarea[name="body"]');
    let lastTimestamp = null;
    let lastReadId    = null;   // dernier outbound lu par le client
    let pollDelay     = 2000;   // backoff : 2s → 10s quand inactif
    let idleCount     = 0;
    let typingTimer   = null;
    let isTyping      = false;
    let typingEl      = null;   // bulle "le client écrit…"
    let pollTimer     = null;

    /* ── Init ─────────────────────────────────────────────── */
    const existing = chatBody ? chatBody.querySelectorAll('[data-ts]') : [];
    if (existing.length) lastTimestamp = existing[existing.length - 1].dataset.ts;

    function scrollBottom() {
        if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
    }
    scrollBottom();

    function escHtml(s) {
        return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    /* ── Rendu d'un nouveau message ───────────────────────── */
    function renderMessage(msg) {
        const isAdmin = msg.from === 'admin';
        const wrap  = document.createElement('div');
        wrap.id = 'msg-' + msg.id;
        wrap.style.cssText = 'display:flex;justify-content:' + (isAdmin ? 'flex-end' : 'flex-start') + ';align-items:flex-end;gap:6px;margin-bottom:4px;';
        const bubble = document.createElement('div');
        bubble.dataset.ts = msg.created_at;
        bubble.style.cssText = 'max-width:68%;padding:12px 16px;border-radius:'
            + (isAdmin ? '16px 4px 16px 16px' : '4px 16px 16px 16px')
            + ';background:' + (isAdmin ? '#267BF1' : 'rgba(255,255,255,0.07)')
            + ';color:' + (isAdmin ? '#fff' : '#e2e8f0') + ';font-size:14px;line-height:1.5;';

        let readBadge = isAdmin
            ? '<span id="read-badge-' + msg.id + '" style="font-size:11px;opacity:0.6;margin-left:4px;">'
              + (msg.read ? '✓✓ Lu' : '✓ Envoyé') + '</span>'
            : '';

        bubble.innerHTML = '<p style="margin:0 0 4px;white-space:pre-wrap;">' + escHtml(msg.body) + '</p>'
            + '<span style="font-size:11px;opacity:0.6;display:flex;align-items:center;justify-content:flex-end;gap:6px;">'
            + msg.at + readBadge + '</span>';

        if (msg.attachment_name && msg.attachment_url) {
            bubble.innerHTML += '<div style="margin-top:8px;"><a href="' + escHtml(msg.attachment_url)
                + '" style="color:' + (isAdmin ? '#A8CFF7' : '#267BF1') + ';font-size:12px;text-decoration:none;">&#128206; '
                + escHtml(msg.attachment_name) + '</a></div>';
        }
        wrap.appendChild(bubble);
        return wrap;
    }

    /* ── Accusé de lecture : marque les outbound lus ─────── */
    function updateReadReceipts(lastReadIdFromServer) {
        if (!lastReadIdFromServer || lastReadIdFromServer === lastReadId) return;
        lastReadId = lastReadIdFromServer;
        // Mettre à jour tous les badges ✓ Envoyé → ✓✓ Lu pour les messages id <= lastReadId
        document.querySelectorAll('[id^="read-badge-"]').forEach(function(el) {
            const msgId = parseInt(el.id.replace('read-badge-', ''), 10);
            if (msgId <= lastReadId && el.textContent.trim() === '✓ Envoyé') {
                el.textContent = '✓✓ Lu';
                el.style.color = '#A8CFF7';
            }
        });
    }

    /* ── Typing indicator visiteur ────────────────────────── */
    function showClientTyping(show) {
        if (show && !typingEl) {
            typingEl = document.createElement('div');
            typingEl.id = 'typing-indicator';
            typingEl.style.cssText = 'display:flex;justify-content:flex-start;margin-bottom:4px;';
            typingEl.innerHTML = '<div style="padding:10px 16px;border-radius:4px 16px 16px 16px;background:rgba(255,255,255,0.07);color:#718096;font-size:13px;font-style:italic;">'
                + '&#8942; Le client est en train d\'écrire…</div>';
            chatBody.appendChild(typingEl);
            scrollBottom();
        } else if (!show && typingEl) {
            typingEl.remove();
            typingEl = null;
        }
    }

    /* ── Envoi typing signal admin → serveur ──────────────── */
    function sendTypingSignal() {
        if (isTyping) return;
        isTyping = true;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        fetch('/admin/messagerie/' + userId + '/typing', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
        }).catch(function(){});
        // Reset après 4s (TTL cache = 5s)
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() { isTyping = false; }, 4000);
    }

    if (textarea) {
        textarea.addEventListener('input', sendTypingSignal);
    }

    /* ── Polling avec backoff exponentiel ─────────────────── */
    function schedulePoll() {
        clearTimeout(pollTimer);
        pollTimer = setTimeout(doPoll, pollDelay);
    }

    function doPoll() {
        const url = '/admin/messagerie/' + userId + '/poll'
            + (lastTimestamp ? '?since=' + encodeURIComponent(lastTimestamp) : '');

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                let gotNew = false;

                if (data.messages && data.messages.length) {
                    // Supprimer typing indicator avant d'insérer de vrais messages
                    if (typingEl) { typingEl.remove(); typingEl = null; }
                    data.messages.forEach(function(msg) {
                        if (!document.getElementById('msg-' + msg.id)) {
                            chatBody.appendChild(renderMessage(msg));
                            lastTimestamp = msg.created_at;
                        }
                    });
                    scrollBottom();
                    gotNew = true;
                }

                // Accusé de lecture
                updateReadReceipts(data.last_read_id);

                // Typing indicator client
                showClientTyping(!!data.client_typing);

                // Backoff : si pas de nouveau msg → ralentir jusqu'à 10s
                if (gotNew) {
                    pollDelay = 2000;
                    idleCount = 0;
                } else {
                    idleCount++;
                    if (idleCount > 5) {
                        pollDelay = Math.min(pollDelay * 1.4, 10000);
                    }
                }
            })
            .catch(function() {
                // Erreur réseau → backoff agressif
                pollDelay = Math.min(pollDelay * 2, 15000);
            })
            .finally(schedulePoll);
    }

    // Reprendre le poll immédiatement si l'onglet redevient actif
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            pollDelay = 2000;
            idleCount = 0;
            clearTimeout(pollTimer);
            doPoll();
        }
    });

    schedulePoll();
})();
</script>
@endsection
