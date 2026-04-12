@extends('layouts.app')
@section('title', __('pages.appointment.title'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;">
            <a href="{{ route('contact') }}" style="color:rgba(255,255,255,0.5);text-decoration:none;">{{ __('ui.nav.contact') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span style="color:rgba(255,255,255,0.85);">{{ __('pages.appointment.breadcrumb_rdv') }}</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.appointment.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.appointment.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;max-width:580px;margin-inline:auto;">
            {{ __('pages.appointment.hero_sub') }}
        </p>
    </div>
</section>

{{-- Calendrier & Formulaire --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="rdv-grid">

            {{-- Gauche : Formulaire + calendrier --}}
            <div class="reveal stagger-1">

                {{-- Étapes --}}
                <div style="display:flex;gap:0;margin-bottom:36px;border-radius:var(--radius-md);overflow:hidden;border:1px solid rgba(38,123,241,0.12);">
                    @foreach([['1', __('pages.appointment.step1')], ['2', __('pages.appointment.step2')], ['3', __('pages.appointment.step3')]] as $step)
                    <div id="step-tab-{{ $step[0] }}" style="flex:1;padding:14px 12px;text-align:center;font-size:13px;font-weight:700;transition:background 0.2s;{{ $step[0]==='1' ? 'background:var(--blue);color:#fff;' : 'background:var(--cream);color:var(--text-muted);' }}">
                        <span style="display:block;font-size:18px;{{ $step[0]==='1' ? 'color:rgba(255,255,255,0.85)' : '' }}">{{ $step[0] }}</span>
                        {{ $step[1] }}
                    </div>
                    @endforeach
                </div>

                {{-- Step 1 : Type de projet + Infos --}}
                <div id="step-1">
                    <h3 style="font-size:18px;margin-bottom:24px;">{{ __('pages.appointment.step1_title') }}</h3>

                    <div class="form-group" style="margin-bottom:20px;">
                        <label for="rdv-type">{{ __('pages.appointment.label_project') }}</label>
                        <select id="rdv-type" class="compare-select" style="font-family:var(--font-sans);font-size:15px;padding:13px 16px;">
                            <option value="">{{ __('pages.appointment.ph_project') }}</option>
                            <option value="immobilier">{{ __('pages.appointment.project_immobilier') }}</option>
                            <option value="automobile">{{ __('pages.appointment.project_automobile') }}</option>
                            <option value="personnel">{{ __('pages.appointment.project_personnel') }}</option>
                            <option value="entreprise">{{ __('pages.appointment.project_entreprise') }}</option>
                            <option value="agricole">{{ __('pages.appointment.project_agricole') }}</option>
                            <option value="microcredit">{{ __('pages.appointment.project_microcredit') }}</option>
                            <option value="rachat">{{ __('pages.appointment.project_rachat') }}</option>
                            <option value="autre">{{ __('pages.appointment.project_autre') }}</option>
                        </select>
                    </div>

                    <div class="form-row" style="margin-bottom:20px;">
                        <div class="form-group">
                            <label for="rdv-fname">{{ __('pages.appointment.label_fname') }}</label>
                            <input type="text" id="rdv-fname" placeholder="{{ __('pages.appointment.ph_fname') }}" autocomplete="given-name">
                        </div>
                        <div class="form-group">
                            <label for="rdv-lname">{{ __('pages.appointment.label_lname') }}</label>
                            <input type="text" id="rdv-lname" placeholder="{{ __('pages.appointment.ph_lname') }}" autocomplete="family-name">
                        </div>
                    </div>

                    <div class="form-row" style="margin-bottom:20px;">
                        <div class="form-group">
                            <label for="rdv-phone">{{ __('pages.appointment.label_phone') }}</label>
                            <input type="tel" id="rdv-phone" placeholder="{{ __('pages.appointment.ph_phone') }}" autocomplete="tel">
                        </div>
                        <div class="form-group">
                            <label for="rdv-email">{{ __('pages.appointment.label_email') }}</label>
                            <input type="email" id="rdv-email" placeholder="{{ __('pages.appointment.ph_email') }}" autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:28px;">
                        <label for="rdv-notes">{{ __('pages.appointment.label_notes') }}</label>
                        <textarea id="rdv-notes" placeholder="{{ __('pages.appointment.ph_notes') }}" style="min-height:90px;"></textarea>
                    </div>

                    <button class="btn btn-primary" style="width:100%;justify-content:center;padding:15px;" onclick="goStep(2)">
                        {{ __('pages.appointment.btn_next') }}
                    </button>
                </div>

                {{-- Step 2 : Date + Heure --}}
                <div id="step-2" style="display:none;">
                    <h3 style="font-size:18px;margin-bottom:24px;">{{ __('pages.appointment.step2_title') }}</h3>

                    {{-- Navigation mois --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <button onclick="prevMonth()" style="padding:8px 14px;border-radius:var(--radius-md);border:1px solid rgba(38,123,241,0.15);background:transparent;cursor:pointer;font-size:16px;color:var(--blue);">‹</button>
                        <span id="cal-month-label" style="font-weight:700;font-size:16px;"></span>
                        <button onclick="nextMonth()" style="padding:8px 14px;border-radius:var(--radius-md);border:1px solid rgba(38,123,241,0.15);background:transparent;cursor:pointer;font-size:16px;color:var(--blue);">›</button>
                    </div>

                    {{-- Grille calendrier --}}
                    <div id="cal-grid" class="rdv-date-grid"></div>

                    {{-- Créneaux --}}
                    <div id="time-section" style="margin-top:28px;display:none;">
                        <h3 style="font-size:16px;margin-bottom:12px;">{{ __('pages.appointment.times_title') }}</h3>
                        <div id="time-grid" class="rdv-times"></div>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:28px;">
                        <button onclick="goStep(1)" class="btn btn-outline" style="flex:1;justify-content:center;padding:13px;">
                            {{ __('pages.appointment.btn_back') }}
                        </button>
                        <button id="btn-confirm" class="btn btn-primary" style="flex:2;justify-content:center;padding:13px;opacity:0.4;cursor:not-allowed;" disabled onclick="goStep(3)">
                            {{ __('pages.appointment.btn_confirm') }}
                        </button>
                    </div>
                </div>

                {{-- Step 3 : placeholder (la confirmation s'affiche dans le modal) --}}
                <div id="step-3" style="display:none;"></div>
            </div>

            {{-- Droite : Infos --}}
            <div class="reveal stagger-2" style="align-self:start;">

                {{-- Comment ça marche --}}
                <div class="card" style="padding:32px;margin-bottom:24px;">
                    <h3 style="font-size:17px;margin-bottom:20px;">{{ __('pages.appointment.how_title') }}</h3>
                    @foreach([
                        ['1', __('pages.appointment.how_1')],
                        ['2', __('pages.appointment.how_2')],
                        ['3', __('pages.appointment.how_3')],
                        ['4', __('pages.appointment.how_4')],
                    ] as $s)
                    <div style="display:flex;gap:14px;{{ !$loop->last ? 'margin-bottom:16px;' : '' }}">
                        <div style="width:28px;height:28px;border-radius:50%;background:var(--blue);color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;">{{ $s[0] }}</div>
                        <p style="font-size:14px;color:var(--text-muted);line-height:1.6;padding-top:4px;">{{ $s[1] }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- Garanties --}}
                <div class="card" style="padding:32px;margin-bottom:24px;">
                    <h3 style="font-size:17px;margin-bottom:16px;">{{ __('pages.appointment.guarantees_title') }}</h3>
                    @foreach([
                        __('pages.appointment.guarantee_1'),
                        __('pages.appointment.guarantee_2'),
                        __('pages.appointment.guarantee_3'),
                        __('pages.appointment.guarantee_4'),
                    ] as $g)
                    <div style="display:flex;align-items:center;gap:10px;{{ !$loop->last ? 'margin-bottom:12px;' : '' }}font-size:14px;color:var(--text);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $g }}
                    </div>
                    @endforeach
                </div>

                {{-- Contact direct --}}
                <div style="background:var(--cream);border-radius:16px;padding:24px;">
                    <p style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--text-muted);margin-bottom:14px;">{{ __('pages.appointment.call_label') }}</p>
                    <a href="tel:+33142000001" style="display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--text);font-weight:700;font-size:20px;margin-bottom:6px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.63 19.79 19.79 0 01-0 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                        01 42 00 00 01
                    </a>
                    <p style="font-size:13px;color:var(--text-muted);">{{ __('pages.appointment.call_hours') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Modal confirmation RDV ──────────────────────────────── --}}
<div class="rdv-modal" id="rdv-modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="rdv-modal__backdrop"></div>
    <div class="rdv-modal__box">

        {{-- Icone succès --}}
        <div class="rdv-modal__icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>

        <h2 class="rdv-modal__title">{{ __('pages.appointment.modal_title') }}</h2>
        <p class="rdv-modal__sub">
            {{ __('pages.appointment.modal_sub') }}<br>
            <strong id="conf-email" class="rdv-modal__email"></strong>
        </p>

        {{-- Récapitulatif --}}
        <div class="rdv-modal__recap">
            <p class="rdv-modal__recap-label">{{ __('pages.appointment.modal_recap_label') }}</p>
            <div class="rdv-modal__recap-row">
                <span>{{ __('pages.appointment.modal_project') }}</span>
                <span id="conf-type"></span>
            </div>
            <div class="rdv-modal__recap-row">
                <span>{{ __('pages.appointment.modal_date') }}</span>
                <span id="conf-date" style="font-family:var(--font-mono);font-size:13px;"></span>
            </div>
            <div class="rdv-modal__recap-row">
                <span>{{ __('pages.appointment.modal_time') }}</span>
                <span id="conf-time" style="font-family:var(--font-mono);"></span>
            </div>
        </div>

        <p class="rdv-modal__note">{{ __('pages.appointment.modal_note') }}</p>

        <a href="/" class="btn btn-primary rdv-modal__cta">{{ __('pages.appointment.modal_cta') }}</a>
    </div>
</div>

<style>
.rdv-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 900;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.rdv-modal.open { display: flex; }
.rdv-modal__backdrop {
    position: absolute;
    inset: 0;
    background: rgba(13,27,42,0.65);
    animation: rdv-fade .12s ease;
}
@keyframes rdv-fade { from{opacity:0} to{opacity:1} }

.rdv-modal__box {
    position: relative;
    background: #fff;
    border-radius: 20px;
    padding: 48px 40px 40px;
    width: 100%;
    max-width: 480px;
    text-align: center;
    box-shadow: 0 24px 80px rgba(13,27,42,0.22);
    animation: rdv-slide .18s ease-out;
    will-change: transform, opacity;
}
@keyframes rdv-slide {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}

.rdv-modal__icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    color: #fff;
    box-shadow: 0 8px 24px rgba(34,197,94,0.35);
}
.rdv-modal__title {
    font-size: 24px;
    font-weight: 700;
    color: var(--navy, #0D1B2A);
    margin: 0 0 12px;
}
.rdv-modal__sub {
    font-size: 15px;
    color: var(--text-muted, #718096);
    line-height: 1.7;
    margin: 0 0 24px;
}
.rdv-modal__email {
    color: var(--blue, #267BF1);
    font-weight: 700;
}
.rdv-modal__recap {
    background: var(--cream, #F5F8FF);
    border-radius: 14px;
    padding: 20px 24px;
    text-align: left;
    margin-bottom: 20px;
}
.rdv-modal__recap-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted, #718096);
    margin: 0 0 14px;
}
.rdv-modal__recap-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    font-size: 14px;
    padding: 6px 0;
    border-bottom: 1px solid rgba(38,123,241,0.08);
}
.rdv-modal__recap-row:last-child { border-bottom: none; }
.rdv-modal__recap-row > span:first-child { color: var(--text-muted, #718096); }
.rdv-modal__recap-row > span:last-child  { font-weight: 600; text-align: right; }
.rdv-modal__note {
    font-size: 13px;
    color: var(--text-muted, #718096);
    margin: 0 0 28px;
    line-height: 1.6;
}
.rdv-modal__cta { width: 100%; justify-content: center; }

@media (max-width: 520px) {
    .rdv-modal__box { padding: 36px 20px 28px; }
    .rdv-modal__title { font-size: 20px; }
}
</style>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    var MONTHS = {!! json_encode(explode(',', __('pages.appointment.js_months'))) !!};
    var DAYS   = {!! json_encode(explode(',', __('pages.appointment.js_days'))) !!};

    var TXT_SENDING        = '{{ __('pages.appointment.js_sending') }}';
    var TXT_CONFIRM_BTN    = '{{ __('pages.appointment.js_confirm_btn') }}';
    var MSG_FIELDS_TITLE   = '{{ __('pages.appointment.js_err_fields_title') }}';
    var MSG_FIELDS_BODY    = '{{ __('pages.appointment.js_err_fields_msg') }}';
    var MSG_SELECT_TITLE   = '{{ __('pages.appointment.js_err_select_title') }}';
    var MSG_SELECT_BODY    = '{{ __('pages.appointment.js_err_select_msg') }}';
    var MSG_ERR_TITLE      = '{{ __('pages.appointment.js_err_send_title') }}';
    var MSG_ERR_DEFAULT    = '{{ __('pages.appointment.js_err_default') }}';
    var PAGE_LOCALE        = '{{ str_replace('_', '-', app()->getLocale()) }}';

    var selectedDate = null;
    var selectedTime = null;
    var currentYear, currentMonth;

    // Fake unavailable times
    var UNAVAILABLE = ['09:00','11:00','14:30'];

    function init() {
        var now = new Date();
        currentYear  = now.getFullYear();
        currentMonth = now.getMonth();
        renderCalendar();
    }

    function renderCalendar() {
        document.getElementById('cal-month-label').textContent =
            MONTHS[currentMonth] + ' ' + currentYear;

        var grid  = document.getElementById('cal-grid');
        var today = new Date();
        today.setHours(0,0,0,0);

        var firstDay = new Date(currentYear, currentMonth, 1);
        var lastDay  = new Date(currentYear, currentMonth + 1, 0);

        // Day headers
        var html = DAYS.map(function (d) {
            return '<div class="rdv-day rdv-day--header">' + d + '</div>';
        }).join('');

        // Offset (Mon=0)
        var offset = (firstDay.getDay() + 6) % 7;
        for (var i = 0; i < offset; i++) html += '<div></div>';

        for (var d = 1; d <= lastDay.getDate(); d++) {
            var date = new Date(currentYear, currentMonth, d);
            var isWeekend = date.getDay() === 0 || date.getDay() === 6;
            var isPast    = date < today;
            var isToday   = date.getTime() === today.getTime();

            var classes = ['rdv-day'];
            if (isPast || isWeekend) classes.push('rdv-day--past');
            if (isToday) classes.push('rdv-day--today');

            var sel = selectedDate && selectedDate.getTime() === date.getTime() ? ' selected' : '';
            var onclick  = !isPast && !isWeekend ? 'onclick="selectDate(new Date(' + currentYear + ',' + currentMonth + ',' + d + '))"' : '';

            html += '<div class="' + classes.join(' ') + sel + '" ' + onclick + '>' + d + '</div>';
        }

        grid.innerHTML = html;
    }

    window.selectDate = function (date) {
        selectedDate = date;
        selectedTime = null;
        renderCalendar();
        renderTimes();
        document.getElementById('time-section').style.display = 'block';
        document.getElementById('btn-confirm').disabled = true;
        document.getElementById('btn-confirm').style.opacity = '0.4';
        document.getElementById('btn-confirm').style.cursor = 'not-allowed';
    };

    function renderTimes() {
        var times = ['09:00','09:30','10:00','10:30','11:00','11:30',
                     '14:00','14:30','15:00','15:30','16:00','16:30','17:00'];
        var html = times.map(function (t) {
            var unavail = UNAVAILABLE.indexOf(t) !== -1 ? ' rdv-time--unavailable' : '';
            var sel     = selectedTime === t ? ' selected' : '';
            return '<div class="rdv-time' + unavail + sel + '" onclick="selectTime(\'' + t + '\')">' + t + '</div>';
        }).join('');
        document.getElementById('time-grid').innerHTML = html;
    }

    window.selectTime = function (t) {
        selectedTime = t;
        renderTimes();
        var btn = document.getElementById('btn-confirm');
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
    };

    window.prevMonth = function () {
        currentMonth--;
        if (currentMonth < 0) { currentMonth = 11; currentYear--; }
        selectedDate = null; selectedTime = null;
        document.getElementById('time-section').style.display = 'none';
        renderCalendar();
    };

    window.nextMonth = function () {
        currentMonth++;
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        selectedDate = null; selectedTime = null;
        document.getElementById('time-section').style.display = 'none';
        renderCalendar();
    };

    // Step navigation
    window.goStep = function (n) {
        if (n === 2) {
            var type  = document.getElementById('rdv-type').value;
            var fname = document.getElementById('rdv-fname').value.trim();
            var lname = document.getElementById('rdv-lname').value.trim();
            var phone = document.getElementById('rdv-phone').value.trim();
            var email = document.getElementById('rdv-email').value.trim();
            if (!type || !fname || !lname || !phone || !email) {
                if (window.showFeedback) showFeedback('error', MSG_FIELDS_TITLE, MSG_FIELDS_BODY);
                return;
            }
        }
        if (n === 3) {
            if (!selectedDate || !selectedTime) {
                if (window.showFeedback) showFeedback('error', MSG_SELECT_TITLE, MSG_SELECT_BODY);
                return;
            }

            var typeEl   = document.getElementById('rdv-type');
            var typeText = typeEl.options[typeEl.selectedIndex].text;
            var fname    = document.getElementById('rdv-fname').value.trim();
            var lname    = document.getElementById('rdv-lname').value.trim();
            var phone    = document.getElementById('rdv-phone').value.trim();
            var email    = document.getElementById('rdv-email').value.trim();
            var notes    = document.getElementById('rdv-notes').value.trim();

            var pad = function (v) { return String(v).padStart(2, '0'); };
            var dateStr = selectedDate.getFullYear() + '-' + pad(selectedDate.getMonth() + 1) + '-' + pad(selectedDate.getDate());

            var csrf = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').content : '';

            var btn = document.getElementById('btn-confirm');
            btn.disabled = true;
            btn.textContent = TXT_SENDING;

            fetch('{{ route("contact.rdv.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    first_name:   fname,
                    last_name:    lname,
                    phone:        phone,
                    email:        email,
                    project_type: typeEl.value,
                    date:         dateStr,
                    time:         selectedTime,
                    notes:        notes,
                }),
            })
            .then(function (r) {
                if (!r.ok) return r.json().then(function (d) { throw d; });
                return r.json();
            })
            .then(function () {
                document.getElementById('conf-email').textContent = email;
                document.getElementById('conf-type').textContent  = typeText;
                document.getElementById('conf-date').textContent  = selectedDate.toLocaleDateString(PAGE_LOCALE, {weekday:'long',day:'numeric',month:'long',year:'numeric'});
                document.getElementById('conf-time').textContent  = selectedTime;

                var modal = document.getElementById('rdv-modal');
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            })
            .catch(function (err) {
                btn.disabled = false;
                btn.textContent = TXT_CONFIRM_BTN;
                var msg = MSG_ERR_DEFAULT;
                if (err && err.errors) {
                    msg = Object.values(err.errors).flat().join(' ');
                }
                if (window.showFeedback) showFeedback('error', MSG_ERR_TITLE, msg);
            });

            return;
        }
        [1, 2, 3].forEach(function (i) {
            document.getElementById('step-' + i).style.display = i === n ? 'block' : 'none';
            var tab = document.getElementById('step-tab-' + i);
            if (tab) {
                tab.style.background   = i === n ? 'var(--blue)' : 'var(--cream)';
                tab.style.color        = i === n ? '#fff' : 'var(--text-muted)';
            }
        });
    };

    init();

    // Fermer le modal RDV avec Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var modal = document.getElementById('rdv-modal');
            if (modal && modal.classList.contains('open')) {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        }
    });
})();
</script>
@endsection
