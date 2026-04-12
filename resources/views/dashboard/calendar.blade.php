@extends('layouts.dashboard')
@section('title', __('dashboard.calendar.title'))

@section('content')

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.calendar.title') }}</h2>
        <p>{{ __('dashboard.calendar.sub') }}</p>
    </div>
    <button onclick="calShowForm()" class="btn btn-primary btn--sm">{{ __('dashboard.calendar.book_btn') }}</button>
</div>

@php
$upcoming = array_filter($appointments, fn($a) => $a['status'] === 'upcoming');
$past     = array_filter($appointments, fn($a) => $a['status'] === 'past');
@endphp

<div class="cal-layout">

    {{-- ── Colonne gauche : mini calendrier + formulaire ─────── --}}
    <div>

        {{-- Mini calendrier --}}
        <div class="dash-widget" style="margin-bottom:20px;">
            <div class="dash-widget__header">
                <span class="dash-widget__title">{{ __('dashboard.calendar.widget_cal') }}</span>
                <div style="display:flex;gap:6px;">
                    <button onclick="calPrev()" class="cal-nav-btn" aria-label="{{ __('dashboard.calendar.prev_aria') }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button onclick="calNext()" class="cal-nav-btn" aria-label="{{ __('dashboard.calendar.next_aria') }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
            <div class="dash-widget__body" style="padding:0 16px 16px;">
                <p class="cal-month-label" id="cal-month-label"></p>
                <div class="cal-grid-head">
                    @foreach(['L','M','M','J','V','S','D'] as $d)
                    <span>{{ $d }}</span>
                    @endforeach
                </div>
                <div class="cal-grid" id="cal-grid"></div>
            </div>
        </div>

        {{-- Formulaire prise de RDV (caché par défaut) --}}
        <div class="dash-widget" id="cal-form-box" style="display:none;">
            <div class="dash-widget__header">
                <span class="dash-widget__title">{{ __('dashboard.calendar.book_widget') }}</span>
                <button onclick="calHideForm()" style="background:none;border:none;cursor:pointer;color:var(--text-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="dash-widget__body">
                <form action="{{ route('dashboard.calendar.store') }}" method="POST" id="cal-form">
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:14px;">

                        <div>
                            <label class="cal-label">{{ __('dashboard.calendar.advisor') }}</label>
                            <div style="position:relative;">
                                <select name="advisor" class="cal-select">
                                    <option>{{ __('dashboard.calendar.advisor_1') }}</option>
                                    <option>{{ __('dashboard.calendar.advisor_2') }}</option>
                                    <option>{{ __('dashboard.calendar.advisor_3') }}</option>
                                    <option>{{ __('dashboard.calendar.advisor_4') }}</option>
                                </select>
                                <svg style="position:absolute;right:10px;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--text-muted);" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>

                        <div>
                            <label class="cal-label" for="rdv-date">{{ __('dashboard.calendar.date_label') }} <span style="color:var(--blue);">*</span></label>
                            <input type="date" name="date" id="rdv-date" class="cal-input" required
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>

                        <div>
                            <label class="cal-label">{{ __('dashboard.calendar.time_label') }} <span style="color:var(--blue);">*</span></label>
                            <div class="cal-times" id="cal-times">
                                @foreach(['09:00','09:30','10:00','10:30','11:00','11:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00'] as $t)
                                <label class="cal-time-pill">
                                    <input type="radio" name="time" value="{{ $t }}" {{ $loop->first ? 'checked' : '' }}>
                                    <span>{{ $t }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="cal-label" for="rdv-subject">{{ __('dashboard.calendar.subject_label') }} <span style="color:var(--blue);">*</span></label>
                            <input type="text" name="subject" id="rdv-subject" class="cal-input"
                                   placeholder="{{ __('dashboard.calendar.subject_ph') }}" required maxlength="200">
                        </div>

                        <div>
                            <label class="cal-label">{{ __('dashboard.calendar.mode_label') }} <span style="color:var(--blue);">*</span></label>
                            <div style="display:flex;flex-direction:column;gap:8px;margin-top:4px;">
                                @php
                                $modes = [
                                    __('dashboard.calendar.mode_video'),
                                    __('dashboard.calendar.mode_phone'),
                                    __('dashboard.calendar.mode_paris'),
                                    __('dashboard.calendar.mode_lyon'),
                                ];
                                @endphp
                                @foreach($modes as $i => $mode)
                                <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:14px;color:var(--text-muted);">
                                    <input type="radio" name="channel" value="{{ $mode }}" {{ $i === 0 ? 'checked' : '' }} style="accent-color:var(--blue);">
                                    <span>{{ $mode }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="cal-label" for="rdv-notes">{{ __('dashboard.calendar.notes_label') }}</label>
                            <textarea name="notes" id="rdv-notes" class="cal-textarea" rows="2"
                                      placeholder="{{ __('dashboard.calendar.notes_ph') }}" maxlength="400"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                            {{ __('dashboard.calendar.confirm_btn') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- ── Colonne droite : liste RDV ──────────────────────────── --}}
    <div>

        {{-- Prochains --}}
        <div class="dash-widget" style="margin-bottom:20px;">
            <div class="dash-widget__header">
                <span class="dash-widget__title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2" style="vertical-align:-2px;margin-right:6px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ __('dashboard.calendar.upcoming') }}
                </span>
                <span class="dash-nav__badge">{{ count($upcoming) }}</span>
            </div>
            <div class="dash-widget__body" style="padding:0;">
                @forelse($upcoming as $appt)
                <div class="cal-appt-row cal-appt-row--upcoming">
                    <div class="cal-appt-date">
                        <span class="cal-appt-day font-mono">{{ \Carbon\Carbon::parse($appt['date'])->format('d') }}</span>
                        <span class="cal-appt-month">{{ \Carbon\Carbon::parse($appt['date'])->translatedFormat('M') }}</span>
                    </div>
                    <div class="cal-appt-info">
                        <strong class="cal-appt-subject">{{ $appt['subject'] }}</strong>
                        <span class="cal-appt-meta">
                            <span class="cal-appt-avatar">{{ $appt['avatar'] }}</span>
                            {{ $appt['advisor'] }} · {{ $appt['time'] }}
                        </span>
                        <span class="cal-appt-location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $appt['location'] }}
                        </span>
                    </div>
                    <div class="cal-appt-actions">
                        <span class="dash-status dash-status--active" style="font-size:11px;">{{ __('dashboard.calendar.confirmed') }}</span>
                        <button onclick="calCancel({{ $appt['id'] }})" class="cal-appt-cancel">
                            {{ __('dashboard.calendar.cancel') }}
                        </button>
                    </div>
                </div>
                @empty
                <div style="padding:32px;text-align:center;color:var(--text-muted);">
                    <p style="font-size:32px;margin-bottom:10px;">📅</p>
                    <p style="font-size:14px;">{{ __('dashboard.calendar.empty') }}</p>
                    <button onclick="calShowForm()" class="btn btn-outline btn--sm" style="margin-top:12px;">{{ __('dashboard.calendar.book_empty') }}</button>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Passés --}}
        <div class="dash-widget">
            <div class="dash-widget__header">
                <span class="dash-widget__title">{{ __('dashboard.calendar.history') }}</span>
                <span style="font-size:12px;color:var(--text-muted);">{{ trans_choice('dashboard.calendar.history_count', count($past), ['n' => count($past)]) }}</span>
            </div>
            <div class="dash-widget__body" style="padding:0;">
                @foreach($past as $appt)
                <div class="cal-appt-row cal-appt-row--past">
                    <div class="cal-appt-date" style="opacity:0.5;">
                        <span class="cal-appt-day font-mono">{{ \Carbon\Carbon::parse($appt['date'])->format('d') }}</span>
                        <span class="cal-appt-month">{{ \Carbon\Carbon::parse($appt['date'])->translatedFormat('M') }}</span>
                    </div>
                    <div class="cal-appt-info">
                        <strong class="cal-appt-subject" style="color:var(--text-muted);">{{ $appt['subject'] }}</strong>
                        <span class="cal-appt-meta">
                            <span class="cal-appt-avatar" style="opacity:0.6;">{{ $appt['avatar'] }}</span>
                            {{ $appt['advisor'] }} · {{ $appt['time'] }}
                        </span>
                        <span class="cal-appt-location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $appt['location'] }}
                        </span>
                    </div>
                    <div class="cal-appt-actions">
                        <span class="dash-status" style="font-size:11px;background:rgba(0,0,0,0.05);color:var(--text-muted);">{{ __('dashboard.calendar.past') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<style>
.cal-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 20px;
    align-items: start;
}

/* ── Mini calendrier ── */
.cal-month-label { font-size:14px;font-weight:700;color:var(--text);text-align:center;padding:12px 0 8px;text-transform:capitalize; }
.cal-grid-head   { display:grid;grid-template-columns:repeat(7,1fr);gap:2px;margin-bottom:4px; }
.cal-grid-head span { text-align:center;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;padding:4px 0; }
.cal-grid        { display:grid;grid-template-columns:repeat(7,1fr);gap:2px; }

.cal-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    border-radius: 8px;
    cursor: pointer;
    font-family: var(--font-mono);
    color: var(--text);
    transition: all 0.15s;
}
.cal-day:hover:not(.cal-day--empty):not(.cal-day--past) { background: rgba(38,123,241,0.1); color: var(--blue); }
.cal-day--empty  { cursor: default; }
.cal-day--past   { color: rgba(0,0,0,0.2); cursor: default; }
.cal-day--today  { background: rgba(38,123,241,0.1); color: var(--blue); font-weight: 700; }
.cal-day--has-appt { position: relative; }
.cal-day--has-appt::after {
    content: '';
    position: absolute;
    bottom: 3px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--blue);
}
.cal-day--selected { background: var(--blue) !important; color: #fff !important; font-weight: 700; }

.cal-nav-btn {
    width: 28px; height: 28px;
    border: 1px solid rgba(38,123,241,0.15);
    border-radius: 8px;
    background: transparent;
    color: var(--text-muted);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.cal-nav-btn:hover { border-color: var(--blue); color: var(--blue); }

/* ── Formulaire ── */
.cal-label { font-size:13px;font-weight:600;color:var(--text);display:block;margin-bottom:6px; }
.cal-input, .cal-select, .cal-textarea {
    width:100%;
    border:1.5px solid rgba(38,123,241,0.18);
    border-radius:var(--radius-sm);
    padding:10px 14px;
    font-size:13px;
    font-family:var(--font-sans);
    color:var(--text);
    background:var(--white);
    outline:none;
    transition:border-color 0.2s;
}
.cal-select { appearance:none;-webkit-appearance:none;padding-right:32px;cursor:pointer; }
.cal-textarea { resize:vertical;min-height:60px; }
.cal-input:focus,.cal-select:focus,.cal-textarea:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(38,123,241,0.08); }

.cal-times { display:flex;flex-wrap:wrap;gap:6px; }
.cal-time-pill { cursor:pointer; }
.cal-time-pill input { display:none; }
.cal-time-pill span {
    display:inline-block;
    padding:6px 10px;
    border:1.5px solid rgba(38,123,241,0.18);
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    font-family:var(--font-mono);
    color:var(--text-muted);
    transition:all 0.15s;
}
.cal-time-pill input:checked + span { border-color:var(--blue);background:var(--blue);color:#fff; }
.cal-time-pill span:hover { border-color:var(--blue);color:var(--blue); }

/* ── Appointment action column ── */
.cal-appt-actions {
    display: flex;
    flex-direction: column;
    gap: 6px;
    align-items: flex-end;
    flex-shrink: 0;
}
.cal-appt-cancel {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 12px;
    color: var(--text-muted);
    transition: color 0.2s;
    padding: 0;
    font-family: var(--font-sans);
}
.cal-appt-cancel:hover { color: #ef4444; }

/* ── Appointment rows ── */
.cal-appt-row {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 18px 24px;
    border-bottom: 1px solid rgba(38,123,241,0.06);
    transition: background 0.15s;
}
.cal-appt-row:last-child { border-bottom: none; }
.cal-appt-row:hover { background: rgba(38,123,241,0.02); }

.cal-appt-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 44px;
    background: rgba(38,123,241,0.06);
    border-radius: 10px;
    padding: 8px 6px;
    flex-shrink: 0;
}
.cal-appt-day  { font-size: 22px; font-weight: 700; color: var(--blue); line-height: 1; }
.cal-appt-month { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-top: 2px; }

.cal-appt-row--past .cal-appt-date { background: rgba(0,0,0,0.04); }
.cal-appt-row--past .cal-appt-day  { color: var(--text-muted); }

.cal-appt-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 4px; }
.cal-appt-subject { font-size: 14px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cal-appt-meta {
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}
.cal-appt-avatar {
    width: 20px; height: 20px;
    border-radius: 50%;
    background: var(--blue);
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.cal-appt-location {
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
}

@media (max-width: 1024px) {
    .cal-layout { grid-template-columns: 1fr; }
}

/* ── Responsive mobile ─────────────────────────────────── */
@media (max-width: 640px) {
    .dash-page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .dash-page-header .btn {
        width: 100%;
        justify-content: center;
    }

    /* Appointment rows */
    .cal-appt-row {
        padding: 14px 16px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .cal-appt-info {
        /* let info grow but allow it to shrink */
        min-width: 0;
        flex: 1 1 0;
    }
    .cal-appt-subject {
        white-space: normal;
        word-break: break-word;
    }
    /* Push action column to a full-width row below date+info */
    .cal-appt-actions {
        width: 100%;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding-top: 4px;
        border-top: 1px solid rgba(38,123,241,0.06);
        margin-top: 2px;
    }

    /* Calendar widget body */
    .dash-widget__body { padding: 0 12px 12px; }
}

@media (max-width: 480px) {
    /* Form booking */
    .cal-times { gap: 5px; }
    .cal-time-pill span { padding: 6px 8px; font-size: 11px; }

    /* Reduce date box */
    .cal-appt-date { min-width: 38px; padding: 6px 4px; }
    .cal-appt-day  { font-size: 18px; }
    .cal-appt-month { font-size: 10px; }

    /* Meta row: allow wrapping */
    .cal-appt-meta { flex-wrap: wrap; gap: 4px; }
}
</style>

<script>
(function () {
    'use strict';

    var CAL_CANCEL_CONFIRM = '{{ __('dashboard.calendar.cancel_confirm') }}';
    var CAL_CANCEL_DONE    = '{{ __('dashboard.calendar.cancel_done') }}';
    var CAL_MONTHS         = '{{ __('dashboard.calendar.months') }}'.split(',');

    var apptDates = @json(array_column($appointments, 'date'));
    var today     = new Date();
    today.setHours(0,0,0,0);
    var cur = { year: today.getFullYear(), month: today.getMonth() };

    function renderCal() {
        document.getElementById('cal-month-label').textContent = CAL_MONTHS[cur.month] + ' ' + cur.year;

        var grid  = document.getElementById('cal-grid');
        var first = new Date(cur.year, cur.month, 1);
        var last  = new Date(cur.year, cur.month + 1, 0);
        var startDow = (first.getDay() + 6) % 7; // Monday = 0
        var html  = '';

        for (var i = 0; i < startDow; i++) html += '<span class="cal-day cal-day--empty"></span>';

        for (var d = 1; d <= last.getDate(); d++) {
            var date   = new Date(cur.year, cur.month, d);
            var dateStr= cur.year + '-' + String(cur.month+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
            var cls    = 'cal-day';
            if (date < today) cls += ' cal-day--past';
            else if (date.getTime() === today.getTime()) cls += ' cal-day--today';
            if (apptDates.indexOf(dateStr) !== -1) cls += ' cal-day--has-appt';
            html += '<span class="' + cls + '" data-date="' + dateStr + '" onclick="calSelectDay(this)">' + d + '</span>';
        }
        grid.innerHTML = html;
    }

    window.calPrev = function () { cur.month--; if (cur.month < 0) { cur.month = 11; cur.year--; } renderCal(); };
    window.calNext = function () { cur.month++; if (cur.month > 11) { cur.month = 0; cur.year++; } renderCal(); };

    window.calSelectDay = function (el) {
        if (el.classList.contains('cal-day--past')) return;
        document.querySelectorAll('.cal-day--selected').forEach(function(d){ d.classList.remove('cal-day--selected'); });
        el.classList.add('cal-day--selected');
        var inp = document.getElementById('rdv-date');
        if (inp) inp.value = el.getAttribute('data-date');
        calShowForm();
    };

    window.calShowForm = function () {
        document.getElementById('cal-form-box').style.display = '';
        document.getElementById('cal-form-box').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    };
    window.calHideForm = function () { document.getElementById('cal-form-box').style.display = 'none'; };

    window.calCancel = function (id) {
        if (confirm(CAL_CANCEL_CONFIRM)) {
            // TODO: appel AJAX annulation
            alert(CAL_CANCEL_DONE);
        }
    };

    renderCal();
})();
</script>
@endsection
