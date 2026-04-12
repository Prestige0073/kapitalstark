@extends('layouts.dashboard')
@section('title', __('dashboard.documents.title'))

@section('content')

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.documents.title') }}</h2>
        <p>{{ trans_choice('dashboard.documents.count', count($docs), ['n' => count($docs)]) }}</p>
    </div>
    <button class="btn btn-primary btn--sm" onclick="document.getElementById('upload-area').scrollIntoView({behavior:'smooth'})">
        {{ __('dashboard.documents.upload_btn') }}
    </button>
</div>

@if(session('success'))
<div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:var(--radius-md);padding:14px 16px;margin-bottom:20px;font-size:13px;color:#15803d;display:flex;gap:10px;align-items:center;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="dash-grid dash-grid--equal">

    {{-- Liste docs --}}
    <div class="dash-widget">
        <div class="dash-widget__header">
            <span class="dash-widget__title">{{ __('dashboard.documents.my_docs') }}</span>
        </div>
        @foreach($docs as $doc)
        <div class="dash-doc-item">
            <div class="dash-doc-item__icon">📄</div>
            <div class="dash-doc-item__info">
                <div class="dash-doc-item__name">{{ $doc['name'] }}</div>
                <div class="dash-doc-item__meta">{{ $doc['date'] }} · {{ $doc['size'] }} · {{ $doc['loan'] }}</div>
            </div>
            <div class="dash-doc-item__actions">
                @if(!empty($doc['stored']))
                <a href="{{ route('dashboard.documents.download', $doc['id']) }}"
                   class="dash-doc-item__btn" title="{{ __('dashboard.documents.download_aria') }}" aria-label="{{ __('dashboard.documents.download_aria') }} {{ $doc['name'] }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                </a>
                @else
                <button class="dash-doc-item__btn" title="{{ __('dashboard.documents.download_aria') }}" aria-label="{{ __('dashboard.documents.download_aria') }} {{ $doc['name'] }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Upload --}}
    <div>
        <div class="dash-widget" id="upload-area">
            <div class="dash-widget__header">
                <span class="dash-widget__title">{{ __('dashboard.documents.send_widget') }}</span>
            </div>
            <div class="dash-widget__body">
                <form id="upload-form" action="{{ route('dashboard.documents.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="dash-upload-zone" id="upload-zone">
                        <span style="font-size:36px;">📎</span>
                        <strong style="font-size:15px;color:var(--text);margin-top:12px;">{{ __('dashboard.documents.drag_here') }}</strong>
                        <span style="font-size:13px;color:var(--text-muted);margin-top:4px;">{{ __('dashboard.documents.or') }}</span>
                        <label for="file-input" class="btn btn-outline btn--sm" style="margin-top:10px;cursor:pointer;">{{ __('dashboard.documents.browse') }}</label>
                        <input type="file" id="file-input" name="file" accept=".pdf,.jpg,.jpeg,.png" style="display:none;" aria-label="{{ __('dashboard.documents.browse_aria') }}">
                        <span style="font-size:11px;color:var(--text-muted);margin-top:12px;">{{ __('dashboard.documents.format_hint') }}</span>
                    </div>

                    <div id="upload-selected" style="display:none;margin-top:14px;background:rgba(38,123,241,0.05);border-radius:var(--radius-md);padding:12px 14px;font-size:13px;color:var(--text);display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <span id="upload-filename"></span>
                    </div>

                    <div style="margin-top:16px;">
                        <label style="font-size:12px;font-weight:600;color:var(--text);display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">{{ __('dashboard.documents.category') }}</label>
                        <select name="category" style="width:100%;padding:10px 14px;border:2px solid rgba(38,123,241,0.15);border-radius:var(--radius-md);font-size:14px;color:var(--text);background:var(--white);outline:none;">
                            <option>{{ __('dashboard.documents.cat_id') }}</option>
                            <option>{{ __('dashboard.documents.cat_salary') }}</option>
                            <option>{{ __('dashboard.documents.cat_bank') }}</option>
                            <option>{{ __('dashboard.documents.cat_tax') }}</option>
                            <option>{{ __('dashboard.documents.cat_purchase') }}</option>
                            <option>{{ __('dashboard.documents.cat_address') }}</option>
                            <option>{{ __('dashboard.documents.cat_other') }}</option>
                        </select>
                    </div>

                    <button type="submit" id="upload-btn" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:16px;" disabled>
                        {{ __('dashboard.documents.send_btn') }}
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="dash-widget" style="margin-top:16px;">
            <div class="dash-widget__header">
                <span class="dash-widget__title">{{ __('dashboard.documents.missing') }}</span>
            </div>
            <div class="dash-widget__body">
                @foreach([__('dashboard.documents.missing_1'), __('dashboard.documents.missing_2')] as $missing)
                <div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(38,123,241,0.06);">
                    <span style="width:20px;height:20px;background:rgba(239,68,68,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;color:var(--error);flex-shrink:0;">!</span>
                    <span style="font-size:13px;color:var(--text);">{{ $missing }}</span>
                </div>
                @endforeach
                <p style="font-size:12px;color:var(--text-muted);margin-top:10px;">{{ __('dashboard.documents.missing_note') }}</p>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    var FILE_TOO_LARGE = '{{ __('dashboard.documents.file_too_large') }}';

    var zone     = document.getElementById('upload-zone');
    var input    = document.getElementById('file-input');
    var btn      = document.getElementById('upload-btn');
    var nameEl   = document.getElementById('upload-filename');
    var selectedEl = document.getElementById('upload-selected');

    function setFile(file) {
        if (!file) return;
        if (file.size > 10 * 1024 * 1024) {
            alert(FILE_TOO_LARGE);
            return;
        }
        nameEl.textContent = file.name + ' (' + (file.size > 1048576 ? (file.size / 1048576).toFixed(1) + ' Mo' : Math.round(file.size / 1024) + ' Ko') + ')';
        selectedEl.style.display = 'flex';
        btn.disabled = false;
    }

    zone.addEventListener('dragover', function (e) { e.preventDefault(); zone.classList.add('dragging'); });
    zone.addEventListener('dragleave', function () { zone.classList.remove('dragging'); });
    zone.addEventListener('drop', function (e) {
        e.preventDefault();
        zone.classList.remove('dragging');
        var files = e.dataTransfer.files;
        if (files.length) {
            var dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            setFile(files[0]);
        }
    });

    zone.addEventListener('click', function (e) {
        if (e.target !== input && !e.target.closest('label')) {
            input.click();
        }
    });

    input.addEventListener('change', function () {
        if (input.files.length) setFile(input.files[0]);
    });
})();
</script>
<style>
.dash-upload-zone {
    border: 2px dashed rgba(38,123,241,0.2);
    border-radius: var(--radius-md);
    padding: 32px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: border-color 0.2s, background 0.2s;
    cursor: pointer;
}
.dash-upload-zone:hover,
.dash-upload-zone.dragging {
    border-color: var(--blue);
    background: rgba(38,123,241,0.03);
}
</style>
@endsection
