@extends('layouts.app')
@section('title', __('pages.contact.title'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.contact.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.contact.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:560px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.contact.hero_sub') }}
        </p>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container">

        {{-- Infos rapides --}}
        @php
        $channels = [
            ['icon' => '📞', 'title' => '+351 21 000 12 34',        'sub' => __('pages.contact.channel_phone_sub')],
            ['icon' => '📧', 'title' => 'contacto@kapitalstark.pt', 'sub' => __('pages.contact.channel_email_sub')],
            ['icon' => '💬', 'title' => __('pages.contact.channel_chat_title'),   'sub' => __('pages.contact.channel_chat_sub')],
            ['icon' => '📍', 'title' => __('pages.contact.channel_agency_title'), 'sub' => __('pages.contact.channel_agency_sub')],
        ];
        @endphp
        <div class="contact-channels reveal" style="margin-bottom:60px;">
            @foreach($channels as $i => $c)
            <div class="contact-channel card reveal stagger-{{ $i + 1 }}">
                <span style="font-size:32px;">{{ $c['icon'] }}</span>
                <strong>{{ $c['title'] }}</strong>
                <span style="font-size:13px;color:var(--text-muted);">{{ $c['sub'] }}</span>
            </div>
            @endforeach
        </div>

        <div class="contact-grid">

            {{-- Formulaire --}}
            <div class="reveal">
                <h2 style="margin-bottom:32px;">{{ __('pages.contact.form_title') }}</h2>

                <form action="/contact" method="POST" class="contact-form" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">{{ __('pages.contact.label_name') }}</label>
                            <input type="text" id="name" name="name" placeholder="{{ __('pages.contact.ph_name') }}" required value="{{ old('name') }}" class="{{ $errors->has('name') ? 'error' : '' }}">
                            @error('name')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('pages.contact.label_email') }}</label>
                            <input type="email" id="email" name="email" placeholder="{{ __('pages.contact.ph_email') }}" required value="{{ old('email') }}" class="{{ $errors->has('email') ? 'error' : '' }}">
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">{{ __('pages.contact.label_subject') }}</label>
                        <select id="subject" name="subject" required class="{{ $errors->has('subject') ? 'error' : '' }}">
                            <option value="">{{ __('pages.contact.ph_subject') }}</option>
                            <option value="simulation"  {{ old('subject')==='simulation'  ? 'selected' : '' }}>{{ __('pages.contact.subject_simulation') }}</option>
                            <option value="dossier"     {{ old('subject')==='dossier'     ? 'selected' : '' }}>{{ __('pages.contact.subject_dossier') }}</option>
                            <option value="information" {{ old('subject')==='information' ? 'selected' : '' }}>{{ __('pages.contact.subject_information') }}</option>
                            <option value="reclamation" {{ old('subject')==='reclamation' ? 'selected' : '' }}>{{ __('pages.contact.subject_reclamation') }}</option>
                            <option value="autre"       {{ old('subject')==='autre'       ? 'selected' : '' }}>{{ __('pages.contact.subject_autre') }}</option>
                        </select>
                        @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="message">{{ __('pages.contact.label_message') }}</label>
                        <textarea id="message" name="message" rows="6" placeholder="{{ __('pages.contact.ph_message') }}" required class="{{ $errors->has('message') ? 'error' : '' }}">{{ old('message') }}</textarea>
                        @error('message')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:16px;">
                        {{ __('pages.contact.btn_send') }}
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="reveal stagger-2">
                <div class="contact-sidebar">
                    <h3 style="margin-bottom:20px;">{{ __('pages.contact.rdv_title') }}</h3>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.7;margin-bottom:24px;">{{ __('pages.contact.rdv_desc') }}</p>
                    <a href="/contact/rdv" class="btn btn-primary" style="width:100%;justify-content:center;">{{ __('pages.contact.rdv_btn') }}</a>
                </div>

                <div class="contact-sidebar" style="margin-top:20px;">
                    <h3 style="margin-bottom:16px;">{{ __('pages.contact.schedule_title') }}</h3>
                    @php
                    $schedule = [
                        __('pages.contact.day_mon') => __('pages.contact.hours_weekday'),
                        __('pages.contact.day_tue') => __('pages.contact.hours_weekday'),
                        __('pages.contact.day_wed') => __('pages.contact.hours_weekday'),
                        __('pages.contact.day_thu') => __('pages.contact.hours_weekday'),
                        __('pages.contact.day_fri') => __('pages.contact.hours_weekday'),
                        __('pages.contact.day_sat') => __('pages.contact.hours_sat'),
                        __('pages.contact.day_sun') => __('pages.contact.hours_sun'),
                    ];
                    @endphp
                    <table style="width:100%;font-size:14px;border-collapse:collapse;">
                        @foreach($schedule as $dayName => $dayHours)
                        <tr style="border-bottom:1px solid rgba(38,123,241,0.06);">
                            <td style="padding:8px 0;color:var(--text-muted);">{{ $dayName }}</td>
                            <td style="padding:8px 0;font-weight:600;text-align:right;color:{{ $loop->last ? 'var(--text-muted)' : 'var(--text)' }};">{{ $dayHours }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
