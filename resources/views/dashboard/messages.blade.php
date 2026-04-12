@extends('layouts.dashboard')
@section('title', __('dashboard.messages.title'))

@section('content')
<style>
/* ── Chat wrapper ─────────────────────────────────────────── */
.chat-wrap {
    background: var(--white);
    border-radius: 20px;
    border: 1px solid rgba(38,123,241,0.08);
    overflow: hidden;
    height: calc(100vh - 196px);
    min-height: 560px;
    box-shadow: 0 2px 16px rgba(38,123,241,0.06);
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(38,123,241,0.08);
    display: flex;
    align-items: center;
    gap: 14px;
    flex-shrink: 0;
    background: var(--white);
}

.chat-header__av {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
    letter-spacing: .05em;
}

.chat-header__name   { font-size: 15px; font-weight: 700; color: var(--text); margin: 0 0 3px; }
.chat-header__status { font-size: 12px; color: var(--text-muted); margin: 0; display: flex; align-items: center; gap: 5px; }
.chat-header__online { width: 7px; height: 7px; background: var(--success); border-radius: 50%; flex-shrink: 0; }
.chat-header__count  { margin-left: auto; background: rgba(38,123,241,0.08); color: var(--blue); font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }

.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px 28px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: var(--cream);
    scroll-behavior: smooth;
}

.chat-empty {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: var(--text-muted);
    padding: 48px 24px;
    text-align: center;
}

.chat-msg {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    animation: msgIn .2s var(--ease-out);
}

@keyframes msgIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

.chat-msg--out { flex-direction: row-reverse; }

.chat-msg__av {
    width: 32px; height: 32px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #fff;
}
.chat-msg--in  .chat-msg__av { background: linear-gradient(135deg, var(--blue), var(--blue-dark)); }
.chat-msg--out .chat-msg__av { background: linear-gradient(135deg, #4b5563, #1f2937); }

.chat-msg__bubble {
    max-width: 70%;
    padding: 11px 16px;
    font-size: 14px;
    line-height: 1.6;
    word-break: break-word;
}

.chat-msg--in .chat-msg__bubble {
    background: var(--white);
    color: var(--text);
    border-radius: 4px 16px 16px 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}

.chat-msg--out .chat-msg__bubble {
    background: var(--blue);
    color: #fff;
    border-radius: 16px 4px 16px 16px;
}

.chat-msg__subject {
    display: block;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    margin-bottom: 5px; opacity: .7;
}

.chat-msg__text { margin: 0 0 6px; white-space: pre-wrap; }

.chat-msg__meta {
    font-size: 11px;
    display: flex; align-items: center; justify-content: flex-end;
    margin-top: 4px;
}
.chat-msg--in  .chat-msg__meta { color: var(--text-muted); opacity: .85; }
.chat-msg--out .chat-msg__meta { color: rgba(255,255,255,.65); }

.chat-msg__attach {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 8px;
    font-size: 12px; font-weight: 600;
    text-decoration: none;
    padding: 6px 10px; border-radius: 8px;
    transition: opacity .2s;
}
.chat-msg__attach:hover { opacity: .8; }
.chat-msg--in  .chat-msg__attach { background: rgba(38,123,241,0.08); color: var(--blue); }
.chat-msg--out .chat-msg__attach { background: rgba(255,255,255,.18); color: #fff; }

/* ── Compose ──────────────────────────────────────────────── */
.chat-compose {
    padding: 14px 20px;
    border-top: 1px solid rgba(38,123,241,0.08);
    background: var(--white);
    flex-shrink: 0;
}

.chat-compose__subject {
    width: 100%; padding: 8px 12px;
    border: 1.5px solid rgba(38,123,241,0.15); border-radius: 8px;
    font-size: 13px; margin-bottom: 8px;
    outline: none; font-family: inherit; color: var(--text);
    background: var(--cream);
    transition: border-color .2s, background .2s;
    box-sizing: border-box;
}
.chat-compose__subject:focus { border-color: var(--blue); background: #fff; }

.chat-compose__row   { display: flex; gap: 10px; align-items: flex-end; }

.chat-compose__textarea {
    flex: 1; padding: 10px 14px;
    border: 1.5px solid rgba(38,123,241,0.15); border-radius: 10px;
    font-size: 14px; resize: none; outline: none;
    font-family: inherit; color: var(--text);
    background: var(--cream);
    min-height: 44px; max-height: 130px;
    transition: border-color .2s, background .2s;
    box-sizing: border-box; line-height: 1.5;
}
.chat-compose__textarea:focus { border-color: var(--blue); background: #fff; }

.chat-compose__send {
    width: 44px; height: 44px;
    background: var(--blue); color: #fff;
    border: none; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
    transition: background .2s, transform .15s;
}
.chat-compose__send:hover  { background: var(--blue-dark); }
.chat-compose__send:active { transform: scale(.95); }

.chat-compose__hint { font-size: 11px; color: var(--text-muted); margin-top: 6px; text-align: right; }

@media (max-width: 600px) {
    .chat-body    { padding: 16px; }
    .chat-header  { padding: 14px 16px; }
    .chat-compose { padding: 12px 14px; }
    .chat-msg__bubble { max-width: 86%; }
}
</style>

@php
    $unreadCount  = collect($messages)->where('direction', 'outbound')->count();
    $userInitials = strtoupper(substr(Auth::user()->name, 0, 2));
@endphp

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.messages.title') }}</h2>
        <p>{{ __('dashboard.messages.sub') }}</p>
    </div>
    @if($unreadCount > 0)
    <span class="dash-nav__badge" style="font-size:12px;padding:4px 12px;">
        {{ trans_choice('dashboard.messages.msg_count', $unreadCount, ['n' => $unreadCount]) }}
    </span>
    @endif
</div>

<div class="chat-wrap">

    {{-- Header ──────────────────────────────────────────────── --}}
    <div class="chat-header">
        <div class="chat-header__av">KS</div>
        <div style="flex:1;">
            <p class="chat-header__name">{{ __('dashboard.messages.advisor_name') }}</p>
            <p class="chat-header__status">
                <span class="chat-header__online"></span>
                {{ __('dashboard.messages.advisor_status') }}
            </p>
        </div>
        @if(count($messages))
        <span class="chat-header__count">{{ trans_choice('dashboard.messages.exchanges', count($messages), ['n' => count($messages)]) }}</span>
        @endif
    </div>

    {{-- Messages ─────────────────────────────────────────────── --}}
    <div class="chat-body" id="chat-body">
        @forelse($messages as $msg)
        @php $isOut = ($msg['direction'] === 'inbound'); @endphp
        <div class="chat-msg {{ $isOut ? 'chat-msg--out' : 'chat-msg--in' }}"
             data-ts="{{ $msg['created_at'] }}"
             id="msg-{{ $msg['id'] }}">
            <div class="chat-msg__av">{{ $isOut ? $userInitials : 'KS' }}</div>
            <div class="chat-msg__bubble">
                @if(!empty($msg['subject'])
                    && $msg['subject'] !== 'Message client'
                    && $msg['subject'] !== 'Message de votre conseiller')
                <span class="chat-msg__subject">{{ $msg['subject'] }}</span>
                @endif
                <p class="chat-msg__text">{{ $msg['body'] }}</p>
                @if($msg['attachment_name'] && isset($msg['attachment_id']))
                <a href="{{ route('dashboard.messages.attachment', $msg['attachment_id']) }}"
                   class="chat-msg__attach">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         aria-hidden="true"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    {{ $msg['attachment_name'] }}
                </a>
                @endif
                <div class="chat-msg__meta">{{ $msg['at'] }}</div>
            </div>
        </div>
        @empty
        <div class="chat-empty">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                 style="color:var(--blue);opacity:.22" aria-hidden="true">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            <p style="font-size:15px;font-weight:700;color:var(--text);margin:0;">{{ __('dashboard.messages.empty_title') }}</p>
            <p style="font-size:13px;margin:0;max-width:280px;line-height:1.6;">
                {{ __('dashboard.messages.empty_hint') }}
            </p>
        </div>
        @endforelse
    </div>

    {{-- Compose ──────────────────────────────────────────────── --}}
    <div class="chat-compose">
        <form action="{{ route('dashboard.messages.send') }}" method="POST" id="chat-form">
            @csrf
            <input type="text" name="subject" class="chat-compose__subject"
                   placeholder="{{ __('dashboard.messages.subject_ph') }}" maxlength="100"
                   value="{{ old('subject') }}">
            <div class="chat-compose__row">
                <textarea name="message" id="chat-textarea" class="chat-compose__textarea"
                          placeholder="{{ __('dashboard.messages.msg_ph') }}" required maxlength="1000"
                          rows="1">{{ old('message') }}</textarea>
                <button type="submit" class="chat-compose__send" aria-label="{{ __('dashboard.messages.send_aria') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                         aria-hidden="true"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                </button>
            </div>
            <p class="chat-compose__hint">{{ __('dashboard.messages.hint') }}</p>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    var chatBody    = document.getElementById('chat-body');
    var textarea    = document.getElementById('chat-textarea');
    var chatForm    = document.getElementById('chat-form');
    var csrfToken   = (document.querySelector('meta[name=csrf-token]') || {}).content || '';
    var userInitials = @json($userInitials);

    function scrollBottom() {
        if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
    }
    scrollBottom();

    /* Auto-grow textarea */
    if (textarea) {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 130) + 'px';
        });
        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
            }
        });
    }

    /* Submit via fetch */
    if (chatForm) {
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var body = textarea ? textarea.value.trim() : '';
            if (!body) return;

            var subjectEl = chatForm.querySelector('[name="subject"]');
            var subject   = subjectEl ? subjectEl.value.trim() : '';
            var sendBtn   = chatForm.querySelector('[type="submit"]');

            if (sendBtn) sendBtn.disabled = true;

            fetch(chatForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: '_token=' + encodeURIComponent(csrfToken) +
                      '&message=' + encodeURIComponent(body) +
                      '&subject=' + encodeURIComponent(subject),
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    removeEmpty();
                    var el = renderBubble(data.message);
                    chatBody.appendChild(el);
                    lastTs = data.message.created_at;
                    scrollBottom();
                    if (textarea) { textarea.value = ''; textarea.style.height = 'auto'; }
                    if (subjectEl) subjectEl.value = '';
                }
            })
            .catch(function () {})
            .finally(function () {
                if (sendBtn) sendBtn.disabled = false;
            });
        });
    }

    var lastTs = null;
    var rendered = chatBody ? chatBody.querySelectorAll('[data-ts]') : [];
    if (rendered.length) lastTs = rendered[rendered.length - 1].dataset.ts;

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function renderBubble(msg) {
        var isOut = (msg.from === 'user');
        var cls   = 'chat-msg ' + (isOut ? 'chat-msg--out' : 'chat-msg--in');

        var subjectHtml = '';
        if (msg.subject
            && msg.subject !== 'Message client'
            && msg.subject !== 'Message de votre conseiller') {
            subjectHtml = '<span class="chat-msg__subject">' + escHtml(msg.subject) + '</span>';
        }

        var attachHtml = '';
        if (msg.attachment_name && msg.attachment_url) {
            attachHtml =
                '<a href="' + escHtml(msg.attachment_url) + '" class="chat-msg__attach">' +
                '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                '<path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>' +
                escHtml(msg.attachment_name) + '</a>';
        }

        var el = document.createElement('div');
        el.className  = cls;
        el.dataset.ts = msg.created_at;
        el.id         = 'msg-' + msg.id;
        el.innerHTML  =
            '<div class="chat-msg__av">' + escHtml(isOut ? userInitials : 'KS') + '</div>' +
            '<div class="chat-msg__bubble">' +
                subjectHtml +
                '<p class="chat-msg__text">' + escHtml(msg.body) + '</p>' +
                attachHtml +
                '<div class="chat-msg__meta">' + escHtml(msg.at) + '</div>' +
            '</div>';
        return el;
    }

    function removeEmpty() {
        var e = chatBody ? chatBody.querySelector('.chat-empty') : null;
        if (e) e.remove();
    }

    /* Polling every 3s */
    setInterval(function () {
        var url = '/dashboard/messagerie/poll' +
            (lastTs ? '?since=' + encodeURIComponent(lastTs) : '');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (!data.messages || !data.messages.length) return;
            var appended = false;
            data.messages.forEach(function (msg) {
                if (document.getElementById('msg-' + msg.id)) return;
                lastTs = msg.created_at;
                removeEmpty();
                chatBody.appendChild(renderBubble(msg));
                appended = true;
            });
            if (appended) scrollBottom();
        })
        .catch(function () {});
    }, 3000);

})();
</script>
@endsection
