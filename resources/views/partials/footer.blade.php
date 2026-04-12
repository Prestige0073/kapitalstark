<footer class="footer">
    <div class="container">

        <!-- Colonnes principales -->
        <div class="footer__grid">

            <!-- Colonne 1 : Marque -->
            <div class="footer__col footer__col--brand">
                <a href="/" class="header__logo logo--white" aria-label="KapitalStark">
                    <span class="logo-kapital">Kapital</span>
                    <span class="logo-sep" aria-hidden="true"></span>
                    <span class="logo-stark">Stark</span>
                </a>
                <p class="footer__tagline">{{ __('ui.footer.tagline') }}</p>
                <p class="footer__desc">{{ __('ui.footer.desc') }}</p>

                <!-- Réseaux sociaux -->
                <div class="footer__social">
                    <a href="#" class="footer__social-link" aria-label="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="Twitter / X">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 4l16 16M4 20L20 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/></svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2" fill="currentColor"/></svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="YouTube">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="var(--navy)"/></svg>
                    </a>
                </div>
            </div>

            <!-- Colonne 2 : Prêts -->
            <div class="footer__col">
                <h4 class="footer__heading">{{ __('ui.nav.loans') }}</h4>
                <ul class="footer__links">
                    <li><a href="/prets/immobilier">{{ __('ui.nav.loan_mortgage') }}</a></li>
                    <li><a href="/prets/automobile">{{ __('ui.nav.loan_auto') }}</a></li>
                    <li><a href="/prets/personnel">{{ __('ui.nav.loan_personal') }}</a></li>
                    <li><a href="/prets/entreprise">{{ __('ui.nav.loan_business') }}</a></li>
                    <li><a href="/prets/agricole">{{ __('ui.nav.loan_agri') }}</a></li>
                    <li><a href="/prets/microcredit">{{ __('ui.nav.loan_micro') }}</a></li>
                </ul>
            </div>

            <!-- Colonne 3 : Ressources -->
            <div class="footer__col">
                <h4 class="footer__heading">{{ __('ui.nav.resources') }}</h4>
                <ul class="footer__links">
                    <li><a href="/simulateur">{{ __('ui.footer.sim_link') }}</a></li>
                    <li><a href="/blog">{{ __('ui.footer.blog') }}</a></li>
                    <li><a href="/guides">{{ __('ui.nav.resources_guides') }}</a></li>
                    <li><a href="/temoignages">{{ __('ui.footer.testimonials') }}</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/glossaire">{{ __('ui.nav.resources_glossary') }}</a></li>
                </ul>
            </div>

            <!-- Colonne 4 : L'Entreprise -->
            <div class="footer__col">
                <h4 class="footer__heading">{{ __('ui.footer.company') }}</h4>
                <ul class="footer__links">
                    <li><a href="/a-propos">{{ __('ui.nav.about_history') }}</a></li>
                    <li><a href="/a-propos/equipe">{{ __('ui.nav.about_team') }}</a></li>
                    <li><a href="/a-propos/valeurs">{{ __('ui.nav.about_values') }}</a></li>
                    <li><a href="/a-propos/agences">{{ __('ui.nav.about_agencies') }}</a></li>
                    <li><a href="/a-propos/carrieres">{{ __('ui.nav.about_careers') }}</a></li>
                    <li><a href="/presse">{{ __('ui.footer.press') }}</a></li>
                </ul>
            </div>

            <!-- Colonne 5 : Contact & Support -->
            <div class="footer__col">
                <h4 class="footer__heading">{{ __('ui.footer.contact_support') }}</h4>
                <ul class="footer__links">
                    <li><a href="/contact">{{ __('ui.footer.contact_form') }}</a></li>
                    <li><a href="/contact/rdv">{{ __('ui.footer.book_rdv') }}</a></li>
                    <li><a href="/a-propos/agences">{{ __('ui.footer.find_agency') }}</a></li>
                    <li><a href="/espace-client">{{ __('ui.nav.client_space') }}</a></li>
                </ul>
                <div class="footer__contact-info">
                    <p>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        +351 21 000 12 34
                    </p>
                    <p>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        contacto@kapitalstark.pt
                    </p>
                    <p>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ __('ui.footer.hours') }}
                    </p>
                </div>
            </div>

        </div><!-- /.footer__grid -->

        <!-- Badges de confiance -->
        <div class="footer__trust">
            <div class="footer__badge">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>{{ __('ui.footer.badge_encrypted') }}</span>
            </div>
            <div class="footer__badge">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ __('ui.footer.badge_regulated') }}</span>
            </div>
            <div class="footer__badge">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>{{ __('ui.footer.badge_secure') }}</span>
            </div>
            <div class="footer__badge footer__badge--trustpilot">
                <span class="footer__stars">★★★★★</span>
                <span>{{ __('ui.footer.badge_trustpilot') }}</span>
            </div>
        </div>

    </div><!-- /.container -->

    <!-- Barre du bas -->
    <div class="footer__bottom">
        <div class="container footer__bottom-inner">
            <p class="footer__copyright">{{ __('ui.footer.copyright', ['year' => date('Y')]) }}</p>
            <ul class="footer__legal">
                <li><a href="/mentions-legales">{{ __('ui.footer.legal_mentions') }}</a></li>
                <li><a href="/cgu">{{ __('ui.footer.cgu') }}</a></li>
                <li><a href="/confidentialite">{{ __('ui.footer.privacy') }}</a></li>
                <li><a href="/cookies">{{ __('ui.footer.cookies') }}</a></li>
            </ul>
            <div class="lang-selector lang-selector--footer">
                <button class="lang-selector__btn lang-selector__btn--light" aria-expanded="false">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    <span>{{ __('ui.nav.language') }}</span>
                </button>
            </div>
        </div>
    </div>

</footer>

<style>
/* ── Footer ────────────────────────────────────────────────── */
.footer {
  background: var(--navy);
  color: rgba(255,255,255,0.75);
  margin-top: auto;
}

.footer .container {
  padding-top: 80px;
  padding-bottom: 48px;
}

.footer__grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr 1.2fr;
  gap: 48px;
}

/* Marque */
.footer__col--brand .header__logo { margin-bottom: 16px; }

.footer__tagline {
  font-family: var(--font-serif);
  font-size: 15px;
  font-style: italic;
  color: rgba(255,255,255,0.5);
  margin-bottom: 12px;
}

.footer__desc {
  font-size: 13px;
  line-height: 1.7;
  color: rgba(255,255,255,0.5);
  margin-bottom: 24px;
}

.footer__social {
  display: flex;
  gap: 8px;
}

.footer__social-link {
  width: 36px;
  height: 36px;
  border-radius: var(--radius-sm);
  background: rgba(255,255,255,0.08);
  color: rgba(255,255,255,0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s var(--ease), color 0.2s var(--ease), transform 0.2s var(--ease);
}

.footer__social-link:hover {
  background: var(--blue);
  color: #fff;
  transform: translateY(-2px);
}

/* Colonnes liens */
.footer__heading {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: #fff;
  margin-bottom: 20px;
}

.footer__links { display: flex; flex-direction: column; gap: 10px; }

.footer__links a {
  font-size: 14px;
  color: rgba(255,255,255,0.6);
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: color 0.2s var(--ease), transform 0.2s var(--ease);
}

.footer__links a:hover {
  color: var(--blue-light);
  transform: translateX(4px);
}

.footer__links a::before {
  content: '→';
  opacity: 0;
  transform: translateX(-6px);
  transition: opacity 0.2s var(--ease), transform 0.2s var(--ease);
  font-size: 12px;
}

.footer__links a:hover::before {
  opacity: 1;
  transform: translateX(0);
}

/* Contact info */
.footer__contact-info {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.footer__contact-info p {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: rgba(255,255,255,0.55);
}

/* Badges de confiance */
.footer__trust {
  display: flex;
  align-items: center;
  gap: 24px;
  padding-block: 32px;
  border-top: 1px solid rgba(255,255,255,0.08);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  margin-top: 48px;
  flex-wrap: wrap;
}

.footer__badge {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: rgba(255,255,255,0.5);
}

.footer__badge--trustpilot { margin-left: auto; }

.footer__stars {
  color: #00B67A;
  font-size: 16px;
  letter-spacing: 1px;
}

/* Barre du bas */
.footer__bottom {
  background: rgba(0,0,0,0.2);
}

.footer__bottom-inner {
  display: flex;
  align-items: center;
  gap: 24px;
  padding-top: 20px;
  padding-bottom: 20px;
  flex-wrap: wrap;
}

.footer__copyright {
  font-size: 13px;
  color: rgba(255,255,255,0.4);
}

.footer__legal {
  display: flex;
  gap: 20px;
  flex: 1;
  flex-wrap: wrap;
}

.footer__legal a {
  font-size: 13px;
  color: rgba(255,255,255,0.4);
  transition: color 0.2s var(--ease);
}

.footer__legal a:hover { color: var(--blue-light); }

.lang-selector__btn--light {
  color: rgba(255,255,255,0.4) !important;
}

.lang-selector__btn--light:hover {
  color: #fff !important;
  background: rgba(255,255,255,0.08) !important;
}

/* Responsive */
@media (max-width: 1200px) {
  .footer__grid {
    grid-template-columns: 1fr 1fr 1fr;
    gap: 40px;
  }
  .footer__col--brand { grid-column: 1 / -1; }
  .footer__badge--trustpilot { margin-left: 0; }
}

@media (max-width: 768px) {
  .footer .container { padding-top: 48px; }
  .footer__grid {
    grid-template-columns: 1fr 1fr;
    gap: 32px;
  }
  .footer__trust { gap: 16px; }
  .footer__bottom-inner { flex-direction: column; align-items: flex-start; gap: 12px; }
  .footer__badge--trustpilot { margin-left: 0; }
}

@media (max-width: 480px) {
  .footer__grid { grid-template-columns: 1fr; }
}
</style>
