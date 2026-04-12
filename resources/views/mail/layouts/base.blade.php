<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<title>{{ $subject ?? 'KapitalStark' }}</title>
<!--[if mso]>
<noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
<![endif]-->
<style>
/* ── Reset ───────────────────────────── */
*, *::before, *::after { box-sizing: border-box; }
body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
table { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; }
img { border: 0; display: block; height: auto; line-height: 100%; outline: none; text-decoration: none; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #eef2f9; color: #1a2540; margin: 0; padding: 0; }

/* ── Wrapper ─────────────────────────── */
.ew { width: 100%; background: #eef2f9; }
.ec { max-width: 600px; width: 100%; margin: 0 auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 40px rgba(26,37,64,0.10); }

/* ── Accent bar ──────────────────────── */
.ab { height: 4px; line-height: 4px; font-size: 0; background: linear-gradient(90deg,#267BF1,#1a56db,#0f3fa8); }

/* ── Header ──────────────────────────── */
.hd { background: linear-gradient(135deg,#0d1b35,#112040,#0f2d5e); padding: 32px 48px; text-align: center; }
.lb { display: inline-block; width: 44px; height: 44px; background: #267BF1; border-radius: 12px; text-align: center; line-height: 44px; font-weight: 900; font-size: 22px; color: #fff; vertical-align: middle; }
.ls { display: inline-block; width: 1px; height: 20px; background: rgba(255,255,255,.2); margin: 0 10px; vertical-align: middle; }
.ln { font-size: 22px; font-weight: 800; color: #fff; vertical-align: middle; }
.ht { margin-top: 10px; font-size: 12px; color: rgba(255,255,255,.45); letter-spacing: 2px; text-transform: uppercase; font-weight: 600; }

/* ── Hero ────────────────────────────── */
.hero    { padding: 36px 48px 0; text-align: center; }
.hi      { display: block; width: 64px; height: 64px; border-radius: 18px; margin: 0 auto 18px; text-align: center; line-height: 62px; font-size: 26px; }
.hi--bl  { background: rgba(38,123,241,.10); }
.hi--gr  { background: rgba(5,150,105,.10); }
.hi--am  { background: rgba(217,119,6,.10); }
.hi--re  { background: rgba(220,38,38,.10); }
.ht2 { font-size: 24px; font-weight: 800; color: #0d1b35; letter-spacing: -.5px; line-height: 1.25; margin: 0 0 8px; }
.hs  { font-size: 15px; color: #64748b; line-height: 1.6; margin: 0; }

/* ── Body ────────────────────────────── */
.bd { padding: 28px 48px 40px; }
.gr { font-size: 16px; color: #334155; line-height: 1.7; margin-bottom: 24px; }
.gr strong { color: #0d1b35; }

/* ── Info card ───────────────────────── */
.ic      { background: #f8faff; border-radius: 14px; border: 1px solid rgba(38,123,241,.10); overflow: hidden; margin-bottom: 24px; }
.ic__hd  { background: rgba(38,123,241,.06); padding: 10px 20px; font-size: 11px; font-weight: 800; color: #267BF1; text-transform: uppercase; letter-spacing: 1.5px; border-bottom: 1px solid rgba(38,123,241,.08); }
.ic__tb  { width: 100%; border-collapse: collapse; table-layout: auto; }
.ic__tb td { padding: 12px 20px; font-size: 14px; border-bottom: 1px solid rgba(38,123,241,.06); vertical-align: middle; }
.ic__tb tr:last-child td { border-bottom: none; }
.ic__lb  { color: #64748b; font-weight: 500; white-space: nowrap; }
.ic__vl  { color: #0d1b35; font-weight: 700; text-align: right; }

/* ── Highlight box ───────────────────── */
.hb       { border-radius: 14px; padding: 18px 22px; margin-bottom: 24px; }
.hb--bl   { background: rgba(38,123,241,.06); border: 1px solid rgba(38,123,241,.15); }
.hb--gr   { background: rgba(5,150,105,.05); border: 1px solid rgba(5,150,105,.15); }
.hb--am   { background: rgba(217,119,6,.05); border: 1px solid rgba(217,119,6,.15); }
.hb p     { font-size: 14px; color: #475569; line-height: 1.7; margin: 0; }

/* ── Step list (float-based, email-safe) */
.sl       { list-style: none; margin: 0 0 24px; padding: 0; }
.sl li    { overflow: hidden; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #475569; line-height: 1.6; }
.sl li:last-child { border-bottom: none; }
.sn       { float: left; width: 26px; height: 26px; border-radius: 50%; background: #267BF1; color: #fff; font-size: 12px; font-weight: 800; text-align: center; line-height: 26px; margin: 1px 14px 0 0; flex-shrink: 0; }
.sl li > span:last-child { display: block; overflow: hidden; }

/* ── CTA ─────────────────────────────── */
.cw  { text-align: center; margin: 28px 0; }
.cb  { display: inline-block; padding: 15px 34px; background: linear-gradient(135deg,#267BF1,#1a56db); color: #fff !important; border-radius: 12px; font-size: 15px; font-weight: 800; text-decoration: none; letter-spacing: -.2px; }
.cb--gr { background: linear-gradient(135deg,#059669,#047857); }

/* ── Divider ─────────────────────────── */
.dv  { height: 1px; background: #f1f5f9; margin: 20px 0; font-size: 0; line-height: 0; }

/* ── Badge ───────────────────────────── */
.badge   { display: inline-block; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700; white-space: nowrap; }
.badge--blue    { background: rgba(38,123,241,.10); color: #1a56b0; }
.badge--green   { background: rgba(5,150,105,.10);  color: #047857; }
.badge--amber   { background: rgba(217,119,6,.10);  color: #b45309; }
.badge--red     { background: rgba(220,38,38,.10);  color: #b91c1c; }
.badge--pending { background: rgba(245,158,11,.10); color: #b45309; }

/* ── Text helpers ────────────────────── */
.ts  { font-size: 13px; color: #64748b; line-height: 1.7; margin-bottom: 10px; }
.tm  { font-size: 13px; color: #94a3b8; line-height: 1.6; }

/* ── Security note (float-based) ─────── */
.sec    { overflow: hidden; background: #f8faff; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; border: 1px solid rgba(38,123,241,.08); }
.sec__i { float: left; font-size: 18px; line-height: 1.4; margin-right: 12px; }
.sec__t { overflow: hidden; font-size: 12px; color: #64748b; line-height: 1.6; margin: 0; }

/* ── Footer ──────────────────────────── */
.ft   { background: #f8faff; border-top: 1px solid #f1f5f9; padding: 24px 48px; text-align: center; }
.ft__b { font-size: 13px; font-weight: 700; color: #0d1b35; margin-bottom: 8px; }
.ft__l { margin-bottom: 10px; }
.ft__l a { font-size: 12px; color: #267BF1 !important; text-decoration: none; margin: 0 6px; }
.ft__c { font-size: 11px; color: #94a3b8; line-height: 1.9; }
.ft__c a { color: #94a3b8 !important; text-decoration: underline; }

/* ── Responsive ──────────────────────── */
@media only screen and (max-width: 600px) {
  .ew { padding: 0 !important; }
  .ec { border-radius: 0 !important; }
  .hd { padding: 24px 20px !important; }
  .hero { padding: 28px 20px 0 !important; }
  .bd  { padding: 22px 20px 32px !important; }
  .ft  { padding: 20px !important; }
  .ht2 { font-size: 20px !important; }
  .hs  { font-size: 14px !important; }
  .hi  { width: 56px !important; height: 56px !important; line-height: 54px !important; font-size: 22px !important; }
  /* Info card : stack label/value on mobile */
  .ic__lb { display: block !important; padding-bottom: 2px !important; }
  .ic__vl { display: block !important; text-align: left !important; padding-top: 0 !important; }
  /* CTA full width */
  .cb { display: block !important; padding: 15px 20px !important; }
  /* Highlight box */
  .hb { padding: 14px 16px !important; }
}
</style>
</head>
<body style="margin:0;padding:0;background:#eef2f9;">
{{-- Gmail-safe centering: outer table --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="ew" style="background:#eef2f9;">
<tr>
<td align="center" style="padding:36px 16px;">
  <!--[if mso]><table width="600" align="center" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
  <div class="ec" style="max-width:600px;width:100%;background:#fff;border-radius:20px;overflow:hidden;">

    {{-- Accent bar --}}
    <div class="ab" style="height:4px;background:linear-gradient(90deg,#267BF1,#1a56db,#0f3fa8);font-size:0;line-height:4px;">&nbsp;</div>

    {{-- Header --}}
    <div class="hd" style="background:#0d1b35;padding:32px 48px;text-align:center;">
      <a href="{{ url('/') }}" style="text-decoration:none;display:inline-block;">
        <span class="lb" style="display:inline-block;width:44px;height:44px;background:#267BF1;border-radius:12px;text-align:center;line-height:44px;font-weight:900;font-size:22px;color:#fff;vertical-align:middle;">K</span><!--
        --><span class="ls" style="display:inline-block;width:1px;height:20px;background:rgba(255,255,255,.2);margin:0 10px;vertical-align:middle;"></span><!--
        --><span class="ln" style="font-size:22px;font-weight:800;color:#fff;vertical-align:middle;letter-spacing:-.3px;">KapitalStark</span>
      </a>
      <div class="ht" style="margin-top:10px;font-size:12px;color:rgba(255,255,255,.45);letter-spacing:2px;text-transform:uppercase;font-weight:600;">Votre avenir financier commence ici</div>
    </div>

    {{-- Hero --}}
    @hasSection('hero')
    <div class="hero" style="padding:36px 48px 0;text-align:center;">
      @yield('hero')
    </div>
    @endif

    {{-- Content --}}
    <div class="bd" style="padding:28px 48px 40px;">
      @yield('content')
    </div>

    {{-- Footer --}}
    <div class="ft" style="background:#f8faff;border-top:1px solid #f1f5f9;padding:24px 48px;text-align:center;">
      <div class="ft__b">KapitalStark Financial Services</div>
      <div class="ft__l">
        <a href="{{ url('/dashboard') }}">Mon espace</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="{{ url('/faq') }}">FAQ</a>
        <a href="{{ url('/confidentialite') }}">Confidentialité</a>
      </div>
      <div class="ft__c">
        © {{ date('Y') }} KapitalStark, S.A. — Av. da Liberdade, 110, 3.º andar, 1269-046 Lisboa, Portugal<br>
        Instituição de crédito registada no Banco de Portugal N° 4567 · NIF 506 789 123<br>
        <a href="{{ url('/mentions-legales') }}">Mentions légales</a> ·
        <a href="{{ url('/cgu') }}">CGU</a> ·
        <a href="{{ url('/confidentialite') }}">Politique de confidentialité</a><br>
        <span style="display:block;margin-top:6px;color:#cbd5e0;">
          Envoyé depuis <a href="mailto:Kontakte@kapitalstarks.com" style="color:#94a3b8 !important;">Kontakte@kapitalstarks.com</a> ·
          <a href="{{ url('/contact') }}" style="color:#94a3b8 !important;">nous contacter</a>
        </span>
      </div>
    </div>

  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</td>
</tr>
</table>
</body>
</html>
