@extends('layouts.admin')
@section('title', 'Chat — ' . $session->ip_address)

@section('content')
<div class="admin-page-header">
    <div>
        <a href="{{ route('admin.chat.index') }}" style="color:var(--text-muted);font-size:13px;">← Retour</a>
        <h1 class="admin-page-title" style="margin-top:4px;">Visiteur {{ $session->ip_address }}</h1>
        <p class="admin-page-sub">Depuis le {{ $session->created_at->format('d/m/Y à H:i') }}</p>
    </div>
</div>

<div class="admin-card" style="max-width:720px;">

    {{-- Fil de discussion --}}
    <div id="chat-thread" style="display:flex;flex-direction:column;gap:12px;padding:24px;max-height:520px;overflow-y:auto;">
        @foreach($messages as $msg)
        <div style="display:flex;justify-content:{{ $msg->direction === 'visitor' ? 'flex-start' : 'flex-end' }};" data-id="{{ $msg->id }}">
            <div style="
                max-width:75%;
                padding:10px 14px;
                border-radius:14px;
                font-size:14px;
                line-height:1.5;
                background:{{ $msg->direction === 'visitor' ? '#f0f4f8' : 'var(--blue)' }};
                color:{{ $msg->direction === 'visitor' ? 'var(--navy)' : '#fff' }};
            ">
                <p style="margin:0;">{{ $msg->body }}</p>
                <span style="font-size:11px;opacity:0.6;display:block;margin-top:4px;text-align:right;">
                    {{ $msg->created_at->format('H:i') }}
                    @if($msg->direction === 'visitor') · Visiteur @else · Vous @endif
                </span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Formulaire de réponse --}}
    <form action="{{ route('admin.chat.reply', $session) }}" method="POST"
          style="display:flex;gap:10px;padding:16px 24px;border-top:1px solid var(--border);">
        @csrf
        <input type="text" name="body" id="reply-input"
               placeholder="Votre réponse…"
               required
               style="flex:1;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-size:14px;outline:none;">
        <button type="submit" class="admin-btn">Envoyer</button>
    </form>
</div>

<script>
(function () {
    var thread  = document.getElementById('chat-thread');
    var lastId  = {{ $messages->last()?->id ?? 0 }};

    // Scroll en bas au chargement
    thread.scrollTop = thread.scrollHeight;

    // Polling toutes les 4s pour nouveaux messages visiteur
    setInterval(function () {
        fetch('{{ route('admin.chat.poll', $session) }}?since=' + lastId)
            .then(function(r){ return r.json(); })
            .then(function(data){
                data.messages.forEach(function(msg){
                    if (msg.id > lastId) {
                        lastId = msg.id;
                        var wrap = document.createElement('div');
                        wrap.style.cssText = 'display:flex;justify-content:flex-start;';
                        wrap.setAttribute('data-id', msg.id);
                        wrap.innerHTML = '<div style="max-width:75%;padding:10px 14px;border-radius:14px;font-size:14px;line-height:1.5;background:#f0f4f8;color:var(--navy);">'
                            + '<p style="margin:0;">' + msg.body + '</p>'
                            + '<span style="font-size:11px;opacity:0.6;display:block;margin-top:4px;text-align:right;">' + msg.created_at.substring(11,16) + ' · Visiteur</span>'
                            + '</div>';
                        thread.appendChild(wrap);
                        thread.scrollTop = thread.scrollHeight;
                    }
                });
            });
    }, 4000);
})();
</script>
@endsection
