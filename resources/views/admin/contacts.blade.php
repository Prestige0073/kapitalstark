@extends('layouts.admin')
@section('title', 'Contacts publics')

@section('content')

{{-- ── Formulaires de contact ─────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:24px;">
    <div class="admin-card__header">
        <span class="admin-card__title">Formulaires de contact</span>
        <span style="font-size:12px;color:#718096;">{{ $contacts->total() }} message(s)</span>
    </div>
    <div class="admin-table-scroll"><table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $c)
            <tr class="admin-table__row--clickable"
                style="{{ !$c->handled ? 'background:#fffbf0;' : '' }}"
                onclick="openContactModal({{ $c->id }})">
                <td style="color:#718096;font-size:11px;font-family:var(--font-mono);">#{{ $c->id }}</td>
                <td style="font-weight:600;">{{ $c->name }}</td>
                <td style="font-size:12px;color:#718096;">{{ $c->email }}</td>
                <td>{{ $c->subject }}</td>
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#718096;">{{ Str::limit($c->message, 60) }}</td>
                <td>{{ $c->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($c->handled)
                    <span class="admin-badge admin-badge--offer">Traité</span>
                    @else
                    <span class="admin-badge admin-badge--pending">En attente</span>
                    @endif
                </td>
                <td onclick="event.stopPropagation()">
                    <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                        @if(!$c->handled)
                        <form action="{{ route('admin.contacts.handled', $c->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="admin-btn admin-btn--outline admin-btn--sm">Marquer traité</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.contacts.delete', $c->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                    onclick="adminConfirm(this, 'Supprimer ce contact ? Action irréversible.')">✕</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#718096;padding:32px;">Aucun contact</td></tr>
            @endforelse
        </tbody>
    </table></div>
    @if($contacts->hasPages())
    <div class="admin-pagination">{{ $contacts->links('pagination::simple-tailwind') }}</div>
    @endif
</div>

{{-- ── Demandes de RDV publics ─────────────────────────────────── --}}
<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Demandes de rendez-vous (formulaire public)</span>
        <span style="font-size:12px;color:#718096;">{{ $rdv->total() }} demande(s)</span>
    </div>
    <div class="admin-table-scroll"><table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Projet</th>
                <th>Date souhaitée</th>
                <th>Heure</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rdv as $r)
            <tr class="admin-table__row--clickable"
                style="{{ !$r->handled ? 'background:#fffbf0;' : '' }}"
                onclick="openRdvModal({{ $r->id }})">
                <td style="color:#718096;font-size:11px;font-family:var(--font-mono);">#{{ $r->id }}</td>
                <td style="font-weight:600;">{{ $r->first_name }} {{ $r->last_name }}</td>
                <td style="font-size:12px;color:#718096;">{{ $r->email }}</td>
                <td>{{ $r->phone }}</td>
                <td>{{ $r->project_type }}</td>
                <td>{{ \Carbon\Carbon::parse($r->date)->format('d/m/Y') }}</td>
                <td>{{ $r->time }}</td>
                <td>
                    @if($r->handled)
                    <span class="admin-badge admin-badge--offer">Traité</span>
                    @else
                    <span class="admin-badge admin-badge--pending">En attente</span>
                    @endif
                </td>
                <td onclick="event.stopPropagation()">
                    <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                        @if(!$r->handled)
                        <form action="{{ route('admin.rdv.handled', $r->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="admin-btn admin-btn--outline admin-btn--sm">Traité</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.rdv.delete', $r->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                    onclick="adminConfirm(this, 'Supprimer cette demande de RDV ? Action irréversible.')">✕</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#718096;padding:32px;">Aucune demande de RDV</td></tr>
            @endforelse
        </tbody>
    </table></div>
    @if($rdv->hasPages())
    <div class="admin-pagination">{{ $rdv->links('pagination::simple-tailwind') }}</div>
    @endif
</div>

{{-- ── Modal Contact ────────────────────────────────────────────── --}}
<div class="detail-modal" id="modal-contact" aria-hidden="true">
    <div class="detail-modal__backdrop" onclick="closeModal('modal-contact')"></div>
    <div class="detail-modal__box" role="dialog" aria-modal="true">
        <button class="detail-modal__close" onclick="closeModal('modal-contact')" aria-label="Fermer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="detail-modal__head">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <div>
                <h3 class="detail-modal__title" id="cm-name">—</h3>
                <p class="detail-modal__sub" id="cm-email">—</p>
            </div>
            <span class="admin-badge" id="cm-badge"></span>
        </div>
        <div class="detail-modal__meta">
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">Sujet</span>
                <span id="cm-subject">—</span>
            </div>
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">Date</span>
                <span id="cm-date">—</span>
            </div>
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">IP</span>
                <span id="cm-ip" style="font-family:var(--font-mono);font-size:12px;">—</span>
            </div>
        </div>
        <div class="detail-modal__body">
            <p class="detail-modal__meta-label" style="margin-bottom:8px;">Message</p>
            <p id="cm-message" style="line-height:1.7;white-space:pre-wrap;"></p>
        </div>
        <div class="detail-modal__actions" id="cm-actions"></div>
    </div>
</div>

{{-- ── Modal RDV ────────────────────────────────────────────────── --}}
<div class="detail-modal" id="modal-rdv" aria-hidden="true">
    <div class="detail-modal__backdrop" onclick="closeModal('modal-rdv')"></div>
    <div class="detail-modal__box" role="dialog" aria-modal="true">
        <button class="detail-modal__close" onclick="closeModal('modal-rdv')" aria-label="Fermer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="detail-modal__head">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <div>
                <h3 class="detail-modal__title" id="rm-name">—</h3>
                <p class="detail-modal__sub" id="rm-email">—</p>
            </div>
            <span class="admin-badge" id="rm-badge"></span>
        </div>
        <div class="detail-modal__meta">
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">Téléphone</span>
                <span id="rm-phone">—</span>
            </div>
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">Projet</span>
                <span id="rm-project">—</span>
            </div>
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">Date souhaitée</span>
                <span id="rm-date">—</span>
            </div>
            <div class="detail-modal__meta-item">
                <span class="detail-modal__meta-label">Heure</span>
                <span id="rm-time">—</span>
            </div>
        </div>
        <div class="detail-modal__body" id="rm-notes-block" style="display:none;">
            <p class="detail-modal__meta-label" style="margin-bottom:8px;">Notes / Précisions</p>
            <p id="rm-notes" style="line-height:1.7;white-space:pre-wrap;"></p>
        </div>
        <div class="detail-modal__actions" id="rm-actions"></div>
    </div>
</div>

{{-- ── Données JSON pour le JS ─────────────────────────────────── --}}
@php
$contactsJson = $contacts->map(fn($c) => [
    'id'      => $c->id,
    'name'    => $c->name,
    'email'   => $c->email,
    'subject' => $c->subject,
    'message' => $c->message,
    'date'    => $c->created_at->format('d/m/Y à H:i'),
    'ip'      => $c->ip ?? '—',
    'handled' => $c->handled,
])->values()->all();
$rdvJson = $rdv->map(fn($r) => [
    'id'           => $r->id,
    'name'         => $r->first_name . ' ' . $r->last_name,
    'email'        => $r->email,
    'phone'        => $r->phone,
    'project_type' => $r->project_type,
    'date'         => \Carbon\Carbon::parse($r->date)->format('d/m/Y'),
    'time'         => $r->time,
    'notes'        => $r->notes ?? '',
    'handled'      => $r->handled,
])->values()->all();
@endphp
<script>
var CONTACTS = {!! json_encode($contactsJson, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT) !!};
var RDV      = {!! json_encode($rdvJson,      JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT) !!};

var CONTACT_BASE = "{{ url('admin/contacts') }}";
var RDV_BASE     = "{{ url('admin/rdv-publics') }}";
var CSRF_TOKEN          = document.querySelector('meta[name="csrf-token"]').content;

/* ── helpers ─────────────────────────────────────────────────── */
function openModal(id) {
    var m = document.getElementById(id);
    m.classList.add('open');
    m.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    var m = document.getElementById(id);
    m.classList.remove('open');
    m.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ closeModal('modal-contact'); closeModal('modal-rdv'); } });

function makeHandledBtn(base, id, label) {
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = base + '/' + id + '/traite';
    form.innerHTML = '<input type="hidden" name="_token" value="' + CSRF_TOKEN + '"><button type="submit" class="admin-btn admin-btn--sm">' + label + '</button>';
    return form;
}

/* ── Contact modal ───────────────────────────────────────────── */
function openContactModal(id) {
    var c = CONTACTS.find(function(x){ return x.id === id; });
    if (!c) return;
    document.getElementById('cm-name').textContent    = c.name;
    document.getElementById('cm-email').textContent   = c.email;
    document.getElementById('cm-subject').textContent = c.subject;
    document.getElementById('cm-date').textContent    = c.date;
    document.getElementById('cm-ip').textContent      = c.ip;
    document.getElementById('cm-message').textContent = c.message;
    var badge = document.getElementById('cm-badge');
    badge.textContent = c.handled ? 'Traité' : 'En attente';
    badge.className   = 'admin-badge ' + (c.handled ? 'admin-badge--offer' : 'admin-badge--pending');
    var actions = document.getElementById('cm-actions');
    actions.innerHTML = '';
    if (!c.handled) actions.appendChild(makeHandledBtn(CONTACT_BASE, c.id, 'Marquer traité'));
    openModal('modal-contact');
}

/* ── RDV modal ───────────────────────────────────────────────── */
function openRdvModal(id) {
    var r = RDV.find(function(x){ return x.id === id; });
    if (!r) return;
    document.getElementById('rm-name').textContent    = r.name;
    document.getElementById('rm-email').textContent   = r.email;
    document.getElementById('rm-phone').textContent   = r.phone;
    document.getElementById('rm-project').textContent = r.project_type;
    document.getElementById('rm-date').textContent    = r.date;
    document.getElementById('rm-time').textContent    = r.time;
    var badge = document.getElementById('rm-badge');
    badge.textContent = r.handled ? 'Traité' : 'En attente';
    badge.className   = 'admin-badge ' + (r.handled ? 'admin-badge--offer' : 'admin-badge--pending');
    var notesBlock = document.getElementById('rm-notes-block');
    if (r.notes && r.notes.trim()) {
        document.getElementById('rm-notes').textContent = r.notes;
        notesBlock.style.display = 'block';
    } else {
        notesBlock.style.display = 'none';
    }
    var actions = document.getElementById('rm-actions');
    actions.innerHTML = '';
    if (!r.handled) actions.appendChild(makeHandledBtn(RDV_BASE, r.id, 'Marquer traité'));
    openModal('modal-rdv');
}
</script>

@endsection
