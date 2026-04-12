@extends('layouts.dashboard')
@section('title', __('dashboard.profile.title'))

@section('content')

<div class="dash-page-header">
    <div>
        <h2>{{ __('dashboard.profile.title') }}</h2>
        <p>{{ __('dashboard.profile.sub') }}</p>
    </div>
</div>

<div class="profile-layout">

    {{-- ── Colonne gauche : Infos personnelles ── --}}
    <div class="profile-col">

        {{-- Avatar card --}}
        <div class="profile-avatar-card">
            <div class="profile-avatar-ring">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            </div>
            <div class="profile-avatar-info">
                <strong>{{ $user->name }}</strong>
                <span>Client depuis {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}</span>
                <div class="profile-verified-badge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('dashboard.profile.verified') }}
                </div>
            </div>
        </div>

        {{-- Formulaire infos --}}
        <div class="dash-widget">
            <div class="profile-section-header">
                <div class="profile-section-icon profile-section-icon--blue">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <span>{{ __('dashboard.profile.section_info') }}</span>
            </div>

            <div class="dash-widget__body">

                <form action="{{ route('dashboard.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="pf-field {{ $errors->has('name') ? 'pf-field--error' : '' }}">
                        <label for="profile-name">{{ __('dashboard.profile.name_label') }}</label>
                        <div class="pf-input-wrap">
                            <span class="pf-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" id="profile-name" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="{{ __('dashboard.profile.name_ph') }}" required>
                        </div>
                        @error('name')<p class="pf-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pf-field {{ $errors->has('email') ? 'pf-field--error' : '' }}">
                        <label for="profile-email">{{ __('dashboard.profile.email_label') }}</label>
                        <div class="pf-input-wrap">
                            <span class="pf-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </span>
                            <input type="email" id="profile-email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="{{ __('dashboard.profile.email_ph') }}" required>
                        </div>
                        @error('email')<p class="pf-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pf-field">
                        <label for="profile-phone">{{ __('dashboard.profile.phone_label') }}</label>
                        <div class="pf-input-wrap">
                            <span class="pf-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="tel" id="profile-phone" name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="{{ __('dashboard.profile.phone_ph') }}">
                        </div>
                    </div>

                    <button type="submit" class="pf-btn pf-btn--primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        {{ __('dashboard.profile.save_btn') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Colonne droite : Sécurité + Notifications ── --}}
    <div class="profile-col">

        {{-- Sécurité --}}
        <div class="dash-widget" style="margin-bottom: 20px;">
            <div class="profile-section-header">
                <div class="profile-section-icon profile-section-icon--navy">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <span>{{ __('dashboard.profile.section_sec') }}</span>
            </div>

            <div class="dash-widget__body">

                <form action="{{ route('dashboard.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="pf-field {{ $errors->has('current_password') ? 'pf-field--error' : '' }}">
                        <label for="current-password">{{ __('dashboard.profile.current_pass') }}</label>
                        <div class="pf-input-wrap">
                            <span class="pf-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input type="password" id="current-password" name="current_password" placeholder="••••••••" required class="{{ $errors->has('current_password') ? 'pf-input--error' : '' }}">
                            <button type="button" class="pf-eye" onclick="togglePw(this)" tabindex="-1" aria-label="{{ __('dashboard.profile.show_pass') }}">
                                <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        @error('current_password')<p class="pf-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pf-field {{ $errors->has('password') ? 'pf-field--error' : '' }}">
                        <label for="new-password">{{ __('dashboard.profile.new_pass') }}</label>
                        <div class="pf-input-wrap">
                            <span class="pf-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 2-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0 3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                            </span>
                            <input type="password" id="new-password" name="password" placeholder="{{ __('dashboard.profile.new_pass_ph') }}" required oninput="checkStrength(this)">
                            <button type="button" class="pf-eye" onclick="togglePw(this)" tabindex="-1" aria-label="{{ __('dashboard.profile.show_pass') }}">
                                <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <div class="pf-strength" id="strength-bar" style="display:none;">
                            <div class="pf-strength__track">
                                <div class="pf-strength__fill" id="strength-fill"></div>
                            </div>
                            <span class="pf-strength__label" id="strength-label"></span>
                        </div>
                        @error('password')<p class="pf-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pf-field">
                        <label for="confirm-password">{{ __('dashboard.profile.confirm_pass') }}</label>
                        <div class="pf-input-wrap">
                            <span class="pf-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            <input type="password" id="confirm-password" name="password_confirmation" placeholder="••••••••" required>
                            <button type="button" class="pf-eye" onclick="togglePw(this)" tabindex="-1" aria-label="{{ __('dashboard.profile.show_pass') }}">
                                <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="pf-btn pf-btn--outline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        {{ __('dashboard.profile.change_pass') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Notifications --}}
        <div class="dash-widget">
            <div class="profile-section-header">
                <div class="profile-section-icon profile-section-icon--gold">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <span>{{ __('dashboard.profile.section_notifs') }}</span>
            </div>
            <div class="dash-widget__body" style="padding:0;">
                @foreach([
                    ['id'=>'notif-1','label'=>__('dashboard.profile.notif1_label'),'sub'=>__('dashboard.profile.notif1_sub'),'checked'=>true],
                    ['id'=>'notif-2','label'=>__('dashboard.profile.notif2_label'),'sub'=>__('dashboard.profile.notif2_sub'),'checked'=>true],
                    ['id'=>'notif-3','label'=>__('dashboard.profile.notif3_label'),'sub'=>__('dashboard.profile.notif3_sub'),'checked'=>false],
                ] as $notif)
                <div class="pf-notif-row">
                    <div class="pf-notif-row__info">
                        <strong>{{ $notif['label'] }}</strong>
                        <span>{{ $notif['sub'] }}</span>
                    </div>
                    <label class="pf-toggle" aria-label="{{ $notif['label'] }}">
                        <input type="checkbox" id="{{ $notif['id'] }}" {{ $notif['checked'] ? 'checked' : '' }}>
                        <span class="pf-toggle__track">
                            <span class="pf-toggle__thumb"></span>
                        </span>
                    </label>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
/* ── Layout ─────────────────────────────────────────── */
.profile-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: start;
}

.profile-col { display: flex; flex-direction: column; gap: 20px; }

/* ── Avatar card ────────────────────────────────────── */
.profile-avatar-card {
    background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
    border-radius: var(--radius-lg);
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 8px 24px rgba(38,123,241,0.25);
}

.profile-avatar-ring {
    flex-shrink: 0;
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
}

.profile-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    letter-spacing: 0.05em;
    font-family: var(--font-title);
}

.profile-avatar-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.profile-avatar-info strong {
    font-size: 17px;
    font-weight: 700;
    color: #fff;
}

.profile-avatar-info > span {
    font-size: 13px;
    color: rgba(255,255,255,0.7);
}

.profile-verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    background: rgba(34,197,94,0.3);
    border: 1px solid rgba(34,197,94,0.5);
    border-radius: 20px;
    padding: 3px 10px;
    margin-top: 2px;
    width: fit-content;
}

/* ── Section header ─────────────────────────────────── */
.profile-section-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 16px 20px;
    border-bottom: 1px solid rgba(38,123,241,0.07);
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
}

.profile-section-icon {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profile-section-icon--blue  { background: rgba(38,123,241,0.1);  color: var(--blue); }
.profile-section-icon--navy  { background: rgba(13,27,42,0.08);   color: var(--navy); }
.profile-section-icon--gold  { background: rgba(200,169,81,0.12); color: #a87d20; }

/* ── Form fields ────────────────────────────────────── */
.pf-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
}

.pf-field:last-of-type { margin-bottom: 20px; }

.pf-field label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    transition: color 0.2s;
}

.pf-field:focus-within label { color: var(--blue); }

.pf-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.pf-icon {
    position: absolute;
    left: 14px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    pointer-events: none;
    transition: color 0.2s;
    z-index: 1;
}

.pf-field:focus-within .pf-icon { color: var(--blue); }

.pf-input-wrap input {
    width: 100%;
    padding: 12px 16px 12px 42px;
    border: 2px solid rgba(38,123,241,0.15);
    border-radius: var(--radius-md);
    font-size: 14px;
    color: var(--text);
    background: var(--white);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    font-family: var(--font-body);
}

.pf-input-wrap input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(38,123,241,0.1);
    background: #fafcff;
}

.pf-input-wrap input::placeholder { color: #b0b8c9; }

.pf-input-wrap:has(.pf-eye) input {
    padding-right: 44px;
}

.pf-eye {
    position: absolute;
    right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    color: var(--text-muted);
    transition: color 0.2s, background 0.2s;
    cursor: pointer;
    background: transparent;
    border: none;
    padding: 0;
}

.pf-eye:hover { color: var(--blue); background: rgba(38,123,241,0.08); }

.pf-field--error .pf-input-wrap input {
    border-color: var(--error);
    box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
}

.pf-error {
    font-size: 12px;
    color: var(--error);
    display: flex;
    align-items: center;
    gap: 4px;
}

/* ── Password strength ──────────────────────────────── */
.pf-strength {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 2px;
}

.pf-strength__track {
    flex: 1;
    height: 4px;
    background: rgba(38,123,241,0.1);
    border-radius: 2px;
    overflow: hidden;
}

.pf-strength__fill {
    height: 100%;
    border-radius: 2px;
    transition: width 0.3s, background 0.3s;
}

.pf-strength__label {
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

/* ── Flash ──────────────────────────────────────────── */
.profile-flash {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 11px 14px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 16px;
}

.profile-flash--success {
    background: rgba(34,197,94,0.1);
    border: 1px solid rgba(34,197,94,0.25);
    color: #15803d;
}

/* ── Buttons ────────────────────────────────────────── */
.pf-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 700;
    font-family: var(--font-body);
    cursor: pointer;
    transition: all 0.2s var(--ease);
    border: 2px solid transparent;
    text-decoration: none;
}

.pf-btn--primary {
    background: var(--blue);
    color: #fff;
    border-color: var(--blue);
    box-shadow: 0 4px 14px rgba(38,123,241,0.25);
}

.pf-btn--primary:hover {
    background: var(--blue-dark);
    border-color: var(--blue-dark);
    box-shadow: 0 6px 20px rgba(38,123,241,0.35);
    transform: translateY(-1px);
}

.pf-btn--outline {
    background: transparent;
    color: var(--navy);
    border-color: rgba(13,27,42,0.2);
}

.pf-btn--outline:hover {
    background: var(--navy);
    color: #fff;
    border-color: var(--navy);
    transform: translateY(-1px);
}

/* ── Notification toggle rows ───────────────────────── */
.pf-notif-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 14px 20px;
    border-bottom: 1px solid rgba(38,123,241,0.06);
    transition: background 0.15s;
}

.pf-notif-row:last-child { border-bottom: none; }
.pf-notif-row:hover { background: rgba(38,123,241,0.02); }

.pf-notif-row__info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.pf-notif-row__info strong {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}

.pf-notif-row__info span {
    font-size: 12px;
    color: var(--text-muted);
}

/* Toggle switch */
.pf-toggle {
    position: relative;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    flex-shrink: 0;
}

.pf-toggle input { position: absolute; opacity: 0; width: 0; height: 0; }

.pf-toggle__track {
    width: 44px;
    height: 24px;
    background: rgba(38,123,241,0.15);
    border-radius: 12px;
    position: relative;
    transition: background 0.25s;
}

.pf-toggle__thumb {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 5px rgba(0,0,0,0.18);
    transition: transform 0.25s var(--ease);
}

.pf-toggle input:checked ~ .pf-toggle__track { background: var(--blue); }
.pf-toggle input:checked ~ .pf-toggle__track .pf-toggle__thumb { transform: translateX(20px); }

/* ── Responsive ─────────────────────────────────────── */
@media (max-width: 860px) {
    .profile-layout { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
    .profile-avatar-card { flex-direction: column; text-align: center; align-items: center; padding: 20px 16px; }
    .profile-avatar-info { align-items: center; }
    .pf-btn { width: 100%; justify-content: center; }
    .profile-section-header { padding: 14px 16px; }
    .pf-section-body { padding: 16px; }
    .pf-notif-row { padding: 12px 16px; }
}

@media (max-width: 375px) {
    .profile-avatar { width: 60px; height: 60px; font-size: 22px; }
    .pf-input { font-size: 16px; }
}
</style>
@endsection

@section('scripts')
<script>
var STRENGTH_LEVELS = [
    { w: '20%',  bg: '#ef4444', txt: '{{ __('dashboard.profile.strength_1') }}', col: '#ef4444' },
    { w: '40%',  bg: '#f97316', txt: '{{ __('dashboard.profile.strength_2') }}', col: '#f97316' },
    { w: '60%',  bg: '#f59e0b', txt: '{{ __('dashboard.profile.strength_3') }}', col: '#f59e0b' },
    { w: '80%',  bg: '#84cc16', txt: '{{ __('dashboard.profile.strength_4') }}', col: '#84cc16' },
    { w: '100%', bg: '#22c55e', txt: '{{ __('dashboard.profile.strength_5') }}', col: '#22c55e' },
];

/* Show/hide password */
function togglePw(btn) {
    const input = btn.closest('.pf-input-wrap').querySelector('input');
    const show  = btn.querySelector('.eye-show');
    const hide  = btn.querySelector('.eye-hide');
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    show.style.display = isText ? '' : 'none';
    hide.style.display = isText ? 'none' : '';
}

/* Password strength */
function checkStrength(input) {
    const bar   = document.getElementById('strength-bar');
    const fill  = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');
    const v = input.value;

    if (!v) { bar.style.display = 'none'; return; }
    bar.style.display = 'flex';

    let score = 0;
    if (v.length >= 8)  score++;
    if (v.length >= 12) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;

    const lvl = STRENGTH_LEVELS[Math.min(score - 1, 4)] || STRENGTH_LEVELS[0];
    fill.style.width      = lvl.w;
    fill.style.background = lvl.bg;
    label.textContent     = lvl.txt;
    label.style.color     = lvl.col;
}
</script>
@endsection
