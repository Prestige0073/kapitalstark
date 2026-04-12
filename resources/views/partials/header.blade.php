@php $currentLocale = app()->getLocale(); @endphp

<header id="header" class="header">
    <div class="container header__inner">

        <!-- Logo -->
        <a href="/" class="header__logo" aria-label="KapitalStark" translate="no">
            <span class="logo-kapital">Kapital</span>
            <span class="logo-sep" aria-hidden="true"></span>
            <span class="logo-stark">Stark</span>
        </a>

        <!-- Navigation principale (desktop) -->
        <nav class="header__nav" aria-label="{{ __('ui.nav.loans') }}">
            <ul class="header__menu">

                <!-- Nos Prêts -->
                <li class="header__item has-mega">
                    <button class="header__link" aria-expanded="false" aria-haspopup="true">
                        {{ __('ui.nav.loans') }}
                        <svg class="header__chevron" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="mega-menu" role="region">
                        <div class="mega-menu__inner">
                            <div class="mega-menu__col">
                                <p class="mega-menu__heading">{{ __('ui.nav.individuals') }}</p>
                                <a href="/prets/immobilier" class="mega-menu__item">
                                    <span class="mega-menu__icon">🏠</span>
                                    <span>
                                        <strong>{{ __('ui.nav.loan_mortgage') }}</strong>
                                        <small>{{ __('ui.nav.loan_mortgage_sub') }}</small>
                                    </span>
                                </a>
                                <a href="/prets/automobile" class="mega-menu__item">
                                    <span class="mega-menu__icon">🚗</span>
                                    <span>
                                        <strong>{{ __('ui.nav.loan_auto') }}</strong>
                                        <small>{{ __('ui.nav.loan_auto_sub') }}</small>
                                    </span>
                                </a>
                                <a href="/prets/personnel" class="mega-menu__item">
                                    <span class="mega-menu__icon">💳</span>
                                    <span>
                                        <strong>{{ __('ui.nav.loan_personal') }}</strong>
                                        <small>{{ __('ui.nav.loan_personal_sub') }}</small>
                                    </span>
                                </a>
                                <a href="/prets/microcredit" class="mega-menu__item">
                                    <span class="mega-menu__icon">🌱</span>
                                    <span>
                                        <strong>{{ __('ui.nav.loan_micro') }}</strong>
                                        <small>{{ __('ui.nav.loan_micro_sub') }}</small>
                                    </span>
                                </a>
                            </div>
                            <div class="mega-menu__col">
                                <p class="mega-menu__heading">{{ __('ui.nav.professionals') }}</p>
                                <a href="/prets/entreprise" class="mega-menu__item">
                                    <span class="mega-menu__icon">🏢</span>
                                    <span>
                                        <strong>{{ __('ui.nav.loan_business') }}</strong>
                                        <small>{{ __('ui.nav.loan_business_sub') }}</small>
                                    </span>
                                </a>
                                <a href="/prets/agricole" class="mega-menu__item">
                                    <span class="mega-menu__icon">🌾</span>
                                    <span>
                                        <strong>{{ __('ui.nav.loan_agri') }}</strong>
                                        <small>{{ __('ui.nav.loan_agri_sub') }}</small>
                                    </span>
                                </a>
                            </div>
                            <div class="mega-menu__col mega-menu__col--highlight">
                                <p class="mega-menu__heading">{{ __('ui.nav.need_help') }}</p>
                                <p class="mega-menu__desc">{{ __('ui.nav.need_help_desc') }}</p>
                                <a href="/simulateur" class="btn btn-primary" style="margin-top:16px;font-size:14px;padding:10px 20px;">{{ __('ui.nav.simulate_cta') }}</a>
                                <a href="/contact" class="btn btn-ghost" style="margin-top:8px;font-size:14px;">{{ __('ui.nav.contact_advisor') }}</a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Simulateur -->
                <li class="header__item has-mega">
                    <button class="header__link" aria-expanded="false" aria-haspopup="true">
                        {{ __('ui.nav.simulator') }}
                        <svg class="header__chevron" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="mega-menu mega-menu--sm" role="region">
                        <div class="mega-menu__inner">
                            <div class="mega-menu__col">
                                <a href="/simulateur" class="mega-menu__item">
                                    <span class="mega-menu__icon">🧮</span>
                                    <span>
                                        <strong>{{ __('ui.nav.sim_full') }}</strong>
                                        <small>{{ __('ui.nav.sim_full_sub') }}</small>
                                    </span>
                                </a>
                                <a href="/simulateur/comparateur" class="mega-menu__item">
                                    <span class="mega-menu__icon">⚖️</span>
                                    <span>
                                        <strong>{{ __('ui.nav.sim_compare') }}</strong>
                                        <small>{{ __('ui.nav.sim_compare_sub') }}</small>
                                    </span>
                                </a>
                                <a href="/simulateur/capacite" class="mega-menu__item">
                                    <span class="mega-menu__icon">📊</span>
                                    <span>
                                        <strong>{{ __('ui.nav.sim_capacity') }}</strong>
                                        <small>{{ __('ui.nav.sim_capacity_sub') }}</small>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- À Propos -->
                <li class="header__item has-mega">
                    <button class="header__link" aria-expanded="false" aria-haspopup="true">
                        {{ __('ui.nav.about') }}
                        <svg class="header__chevron" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="mega-menu mega-menu--sm" role="region">
                        <div class="mega-menu__inner">
                            <div class="mega-menu__col">
                                <a href="/a-propos" class="mega-menu__item">
                                    <span class="mega-menu__icon">📖</span>
                                    <span><strong>{{ __('ui.nav.about_history') }}</strong></span>
                                </a>
                                <a href="/a-propos/equipe" class="mega-menu__item">
                                    <span class="mega-menu__icon">👥</span>
                                    <span><strong>{{ __('ui.nav.about_team') }}</strong></span>
                                </a>
                                <a href="/a-propos/valeurs" class="mega-menu__item">
                                    <span class="mega-menu__icon">💎</span>
                                    <span><strong>{{ __('ui.nav.about_values') }}</strong></span>
                                </a>
                                <a href="/a-propos/agences" class="mega-menu__item">
                                    <span class="mega-menu__icon">📍</span>
                                    <span><strong>{{ __('ui.nav.about_agencies') }}</strong></span>
                                </a>
                                <a href="/a-propos/carrieres" class="mega-menu__item">
                                    <span class="mega-menu__icon">🚀</span>
                                    <span><strong>{{ __('ui.nav.about_careers') }}</strong></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Ressources -->
                <li class="header__item has-mega">
                    <button class="header__link" aria-expanded="false" aria-haspopup="true">
                        {{ __('ui.nav.resources') }}
                        <svg class="header__chevron" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="mega-menu mega-menu--sm" role="region">
                        <div class="mega-menu__inner">
                            <div class="mega-menu__col">
                                <a href="/blog" class="mega-menu__item">
                                    <span class="mega-menu__icon">✍️</span>
                                    <span><strong>Blog</strong></span>
                                </a>
                                <a href="/guides" class="mega-menu__item">
                                    <span class="mega-menu__icon">📚</span>
                                    <span><strong>{{ __('ui.nav.resources_guides') }}</strong></span>
                                </a>
                                <a href="/faq" class="mega-menu__item">
                                    <span class="mega-menu__icon">❓</span>
                                    <span><strong>FAQ</strong></span>
                                </a>
                                <a href="/glossaire" class="mega-menu__item">
                                    <span class="mega-menu__icon">📝</span>
                                    <span><strong>{{ __('ui.nav.resources_glossary') }}</strong></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Contact -->
                <li class="header__item">
                    <a href="/contact" class="header__link">{{ __('ui.nav.contact') }}</a>
                </li>

            </ul>
        </nav>

        <!-- Actions droite -->
        <div class="header__actions">
            <!-- Sélecteur langue -->
            <div class="lang-selector" aria-label="{{ __('ui.nav.language') }}">
                <button class="lang-selector__btn" aria-expanded="false">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    <span>{{ strtoupper($currentLocale) }}</span>
                    <svg class="header__chevron" width="12" height="12" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="lang-selector__dropdown">
                    <a href="{{ route('locale.switch', 'fr') }}" class="lang-selector__option {{ $currentLocale==='fr' ? 'active' : '' }}">🇫🇷 Français</a>
                    <a href="{{ route('locale.switch', 'en') }}" class="lang-selector__option {{ $currentLocale==='en' ? 'active' : '' }}">🇬🇧 English</a>
                    <a href="{{ route('locale.switch', 'de') }}" class="lang-selector__option {{ $currentLocale==='de' ? 'active' : '' }}">🇩🇪 Deutsch</a>
                    <a href="{{ route('locale.switch', 'es') }}" class="lang-selector__option {{ $currentLocale==='es' ? 'active' : '' }}">🇪🇸 Español</a>
                    <a href="{{ route('locale.switch', 'pt') }}" class="lang-selector__option {{ $currentLocale==='pt' ? 'active' : '' }}">🇵🇹 Português</a>
                </div>
            </div>

            <a href="/espace-client" class="btn btn-outline btn--sm">{{ __('ui.nav.client_space') }}</a>
            <a href="/simulateur" class="btn btn-primary btn--sm">{{ __('ui.nav.simulate_cta') }}</a>

            <!-- Hamburger mobile -->
            <button class="hamburger" id="hamburger" aria-label="{{ __('ui.nav.open_menu') }}" aria-expanded="false" aria-controls="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </div><!-- /.header__inner -->
</header>

<!-- Menu mobile plein écran -->
<div class="mobile-menu" id="mobile-menu" aria-hidden="true" role="dialog">
    <div class="mobile-menu__header">
        <a href="/" class="header__logo header__logo--white" translate="no">
            <span class="logo-kapital">Kapital</span>
            <span class="logo-sep" aria-hidden="true"></span>
            <span class="logo-stark">Stark</span>
        </a>
        <button class="mobile-menu__close" id="mobile-close" aria-label="{{ __('ui.nav.close_menu') }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="mobile-menu__nav">
        <ul>
            <li class="mobile-menu__item">
                <button class="mobile-menu__link" aria-expanded="false">
                    {{ __('ui.nav.loans') }}
                    <svg class="header__chevron" width="16" height="16" viewBox="0 0 14 14" fill="none">
                        <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <ul class="mobile-menu__sub">
                    <li><a href="/prets/immobilier">{{ __('ui.nav.loan_mortgage') }}</a></li>
                    <li><a href="/prets/automobile">{{ __('ui.nav.loan_auto') }}</a></li>
                    <li><a href="/prets/personnel">{{ __('ui.nav.loan_personal') }}</a></li>
                    <li><a href="/prets/entreprise">{{ __('ui.nav.loan_business') }}</a></li>
                    <li><a href="/prets/agricole">{{ __('ui.nav.loan_agri') }}</a></li>
                    <li><a href="/prets/microcredit">{{ __('ui.nav.loan_micro') }}</a></li>
                </ul>
            </li>
            <li class="mobile-menu__item">
                <a href="/simulateur" class="mobile-menu__link">{{ __('ui.nav.simulator') }}</a>
            </li>
            <li class="mobile-menu__item">
                <button class="mobile-menu__link" aria-expanded="false">
                    {{ __('ui.nav.about') }}
                    <svg class="header__chevron" width="16" height="16" viewBox="0 0 14 14" fill="none">
                        <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <ul class="mobile-menu__sub">
                    <li><a href="/a-propos">{{ __('ui.nav.about_history') }}</a></li>
                    <li><a href="/a-propos/equipe">{{ __('ui.nav.about_team') }}</a></li>
                    <li><a href="/a-propos/agences">{{ __('ui.nav.about_agencies') }}</a></li>
                    <li><a href="/a-propos/carrieres">{{ __('ui.nav.about_careers') }}</a></li>
                </ul>
            </li>
            <li class="mobile-menu__item">
                <button class="mobile-menu__link" aria-expanded="false">
                    {{ __('ui.nav.resources') }}
                    <svg class="header__chevron" width="16" height="16" viewBox="0 0 14 14" fill="none">
                        <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <ul class="mobile-menu__sub">
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/glossaire">{{ __('ui.nav.resources_glossary') }}</a></li>
                </ul>
            </li>
            <li class="mobile-menu__item">
                <a href="/contact" class="mobile-menu__link">{{ __('ui.nav.contact') }}</a>
            </li>
        </ul>
    </nav>

    <div class="mobile-lang">
        <span class="mobile-lang__label">{{ __('ui.nav.language') }}</span>
        <div class="mobile-lang__flags">
            <a href="{{ route('locale.switch', 'fr') }}" class="mobile-lang__flag {{ $currentLocale==='fr' ? 'active' : '' }}" title="Français">🇫🇷</a>
            <a href="{{ route('locale.switch', 'en') }}" class="mobile-lang__flag {{ $currentLocale==='en' ? 'active' : '' }}" title="English">🇬🇧</a>
            <a href="{{ route('locale.switch', 'de') }}" class="mobile-lang__flag {{ $currentLocale==='de' ? 'active' : '' }}" title="Deutsch">🇩🇪</a>
            <a href="{{ route('locale.switch', 'es') }}" class="mobile-lang__flag {{ $currentLocale==='es' ? 'active' : '' }}" title="Español">🇪🇸</a>
            <a href="{{ route('locale.switch', 'pt') }}" class="mobile-lang__flag {{ $currentLocale==='pt' ? 'active' : '' }}" title="Português">🇵🇹</a>
        </div>
    </div>

    <div class="mobile-menu__footer">
        <a href="/espace-client" class="btn btn-outline">{{ __('ui.nav.client_space') }}</a>
        <a href="/simulateur" class="btn btn-primary">{{ __('ui.nav.simulate_cta') }}</a>
    </div>
</div>
<div class="mobile-overlay" id="mobile-overlay"></div>

<style>
/* ── Header ────────────────────────────────────────────────── */
.header {
  position: sticky;
  top: 0;
  z-index: 1000;
  height: var(--header-h);
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid rgba(38,123,241,0.08);
  transition: height 0.3s var(--ease), box-shadow 0.3s var(--ease);
}
.header.scrolled { height: 64px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
.header__inner { display: flex; align-items: center; height: 100%; gap: 32px; }
.header__logo { display: inline-flex; align-items: baseline; flex-shrink: 0; text-decoration: none; gap: 0; }
.header__logo--white .logo-kapital { color: #fff; }
.header__logo--white .logo-sep     { background: rgba(200,169,81,0.65); }
.header__logo--white .logo-stark   { color: var(--blue-light); }
.header__nav { flex: 1; }
.header__menu { display: flex; align-items: center; gap: 4px; }
.header__item { position: relative; }
.header__link { display: flex; align-items: center; gap: 4px; padding: 8px 14px; border-radius: var(--radius-sm); font-size: 15px; font-weight: 500; color: var(--text); transition: color 0.2s var(--ease), background 0.2s var(--ease); position: relative; }
.header__link::after { content: ''; position: absolute; bottom: 4px; left: 14px; right: 14px; height: 2px; background: var(--blue); transform: scaleX(0); transform-origin: left; transition: transform 0.25s var(--ease-out); }
.header__item:hover > .header__link, .header__item:focus-within > .header__link { color: var(--blue); background: rgba(38,123,241,0.06); }
.header__item:hover > .header__link::after, .header__item:focus-within > .header__link::after { transform: scaleX(1); }
.header__chevron { transition: transform 0.25s var(--ease); flex-shrink: 0; }
.header__item:hover > .header__link .header__chevron, .header__item:focus-within > .header__link .header__chevron { transform: rotate(180deg); }
.header__actions { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
.btn--sm { padding: 9px 18px; font-size: 14px; }

/* ── Méga-menus ────────────────────────────────────────────── */
.mega-menu { position: absolute; top: calc(100% + 8px); left: 50%; transform: translateX(-50%) translateY(-8px); background: var(--white); border-radius: var(--radius-lg); box-shadow: 0 20px 60px rgba(0,0,0,0.12); border: 1px solid rgba(38,123,241,0.08); min-width: 680px; opacity: 0; pointer-events: none; transition: opacity 0.25s var(--ease-out), transform 0.25s var(--ease-out); z-index: 100; }
.mega-menu--sm { min-width: 280px; }
.header__item:hover .mega-menu, .header__item:focus-within .mega-menu { opacity: 1; pointer-events: auto; transform: translateX(-50%) translateY(0); }
.mega-menu__inner { display: flex; gap: 0; padding: 28px; }
.mega-menu__col { flex: 1; padding-inline: 12px; }
.mega-menu__col:not(:last-child) { border-right: 1px solid rgba(38,123,241,0.08); margin-right: 12px; }
.mega-menu__col--highlight { background: var(--cream); border-radius: var(--radius-md); padding: 20px; display: flex; flex-direction: column; }
.mega-menu__heading { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px; }
.mega-menu__item { display: flex; align-items: flex-start; gap: 12px; padding: 10px; border-radius: var(--radius-sm); transition: background 0.2s var(--ease); color: var(--text); }
.mega-menu__item:hover { background: rgba(38,123,241,0.06); color: var(--blue); }
.mega-menu__item strong { display: block; font-size: 14px; font-weight: 600; line-height: 1.3; }
.mega-menu__item small { display: block; font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.mega-menu__item:hover small { color: var(--blue-dark); }
.mega-menu__icon { font-size: 20px; flex-shrink: 0; line-height: 1; margin-top: 1px; }
.mega-menu__desc { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

/* ── Langue ────────────────────────────────────────────────── */
.lang-selector { position: relative; }
.lang-selector__btn { display: flex; align-items: center; gap: 5px; padding: 7px 10px; border-radius: var(--radius-sm); font-size: 14px; font-weight: 500; color: var(--text-muted); transition: color 0.2s var(--ease), background 0.2s var(--ease); }
.lang-selector__btn:hover { color: var(--blue); background: rgba(38,123,241,0.06); }
.lang-selector__dropdown { position: absolute; top: calc(100% + 6px); right: 0; background: var(--white); border-radius: var(--radius-md); box-shadow: 0 8px 30px rgba(0,0,0,0.1); border: 1px solid rgba(38,123,241,0.08); padding: 8px; min-width: 160px; opacity: 0; pointer-events: none; transform: translateY(-6px); transition: opacity 0.2s var(--ease-out), transform 0.2s var(--ease-out); z-index: 100; }
.lang-selector:hover .lang-selector__dropdown, .lang-selector:focus-within .lang-selector__dropdown { opacity: 1; pointer-events: auto; transform: translateY(0); }
.lang-selector__option { display: block; padding: 8px 12px; border-radius: var(--radius-sm); font-size: 14px; color: var(--text); transition: background 0.15s var(--ease); }
.lang-selector__option:hover, .lang-selector__option.active { background: rgba(38,123,241,0.08); color: var(--blue); }

/* ── Hamburger ─────────────────────────────────────────────── */
.hamburger { display: none; flex-direction: column; gap: 5px; padding: 8px; border-radius: var(--radius-sm); transition: background 0.2s var(--ease); }
.hamburger:hover { background: rgba(38,123,241,0.06); }
.hamburger span { display: block; width: 22px; height: 2px; background: var(--text); border-radius: 2px; transition: transform 0.3s var(--ease), opacity 0.3s var(--ease); }
.hamburger.active span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.active span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ── Menu mobile ───────────────────────────────────────────── */
.mobile-menu { position: fixed; inset: 0; background: linear-gradient(160deg, #0D1B2A 0%, #0f2236 55%, #162d4a 100%); z-index: 2000; display: flex; flex-direction: column; padding: 24px 28px; padding-bottom: max(24px, env(safe-area-inset-bottom)); transform: translateX(100%); transition: transform 0.38s cubic-bezier(0.4, 0, 0.2, 1); overflow-y: auto; will-change: transform; }
.mobile-menu::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--blue), var(--blue-light)); }
.mobile-menu.open { transform: translateX(0); }
.mobile-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 1999; opacity: 0; pointer-events: none; transition: opacity 0.3s var(--ease); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px); }
.mobile-overlay.open { opacity: 1; pointer-events: auto; }
.mobile-menu__header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 36px; padding-top: env(safe-area-inset-top, 0px); }
.mobile-menu__close { color: rgba(255,255,255,0.8); padding: 10px; border-radius: var(--radius-sm); border: 1px solid rgba(255,255,255,0.12); transition: background 0.2s var(--ease), color 0.2s var(--ease), border-color 0.2s var(--ease); }
.mobile-menu__close:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.25); }
.mobile-menu__nav { flex: 1; }
.mobile-menu__item { border-bottom: 1px solid rgba(255,255,255,0.07); }
.mobile-menu__link { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 17px 0; font-size: 17px; font-weight: 500; color: rgba(255,255,255,0.9); text-align: left; letter-spacing: 0.01em; transition: color 0.2s var(--ease); }
.mobile-menu__link:hover, .mobile-menu__item.open > .mobile-menu__link { color: #fff; }
.mobile-menu__item.open > .mobile-menu__link { color: var(--blue-light); }
.mobile-menu__sub { max-height: 0; overflow: hidden; transition: max-height 0.35s var(--ease-out); }
.mobile-menu__sub li { border-left: 2px solid rgba(38,123,241,0.3); margin-left: 4px; }
.mobile-menu__sub li a { display: block; padding: 10px 0 10px 16px; font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.6); transition: color 0.2s var(--ease), padding-left 0.2s var(--ease); }
.mobile-menu__sub li a:hover { color: var(--blue-light); padding-left: 20px; }
.mobile-menu__sub { padding-bottom: 12px; }
.mobile-menu__item.open .mobile-menu__sub { max-height: 400px; }
.mobile-menu__item.open .header__chevron { transform: rotate(180deg); }
.mobile-menu__footer { margin-top: 28px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.08); display: flex; flex-direction: column; gap: 10px; }
.mobile-menu__footer .btn { width: 100%; justify-content: center; }
.mobile-menu__footer .btn-outline { color: #fff; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.05); }
.mobile-menu__footer .btn-outline:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.5); color: #fff; }

/* ── Sélecteur de langue mobile ────────────────────────────── */
.mobile-lang { margin-top: 20px; padding-top: 20px; display: flex; align-items: center; gap: 12px; }
.mobile-lang__label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: rgba(255,255,255,0.45); flex-shrink: 0; }
.mobile-lang__flags { display: flex; gap: 6px; flex-wrap: wrap; }
.mobile-lang__flag { font-size: 22px; line-height: 1; border-radius: 6px; padding: 4px; text-decoration: none; opacity: 0.45; transition: opacity 0.15s, background 0.15s; }
.mobile-lang__flag:hover { opacity: 1; }
.mobile-lang__flag.active { opacity: 1; background: rgba(255,255,255,0.12); }

/* ── Responsive ────────────────────────────────────────────── */
@media (max-width: 1024px) {
  .header__nav { display: none; }
  .lang-selector { display: none; }
  .header__actions .btn:not(.hamburger) { display: none; }
  .hamburger { display: flex; }
  .header__inner { justify-content: space-between; }
}
</style>
