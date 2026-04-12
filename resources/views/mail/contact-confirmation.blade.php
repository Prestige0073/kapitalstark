@extends('mail.layouts.base')

@section('hero')
<div class="hi hi--bl" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(38,123,241,.10);">✉️</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Message bien reçu</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Nous vous répondrons sous 24 heures ouvrées</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $name }}</strong>,<br><br>
  Merci de nous avoir contactés. Votre message a bien été enregistré et transmis à notre équipe. Un conseiller va prendre connaissance de votre demande et vous répondra dans les meilleurs délais.
</p>

<div class="ic" style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div class="ic__hd" style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Récapitulatif de votre message</div>
  <table class="ic__tb" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Expéditeur</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $name }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Email de contact</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $email }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Sujet</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $subject }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Date d'envoi</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ now()->format('d/m/Y à H:i') }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Statut</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;text-align:right;"><span class="badge badge--amber" style="display:inline-block;padding:4px 12px;border-radius:100px;font-size:12px;font-weight:700;background:rgba(217,119,6,.10);color:#b45309;">⏳ En attente</span></td>
    </tr>
  </table>
</div>

<div class="hb hb--bl" style="background:rgba(38,123,241,.06);border:1px solid rgba(38,123,241,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">📋 <strong>Votre message :</strong><br><span style="color:#475569;font-style:italic;">"{{ \Illuminate\Support\Str::limit($contactMessage, 300) }}"</span></p>
</div>

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ url('/contact') }}" class="cb" style="display:inline-block;padding:15px 34px;background:#267BF1;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Nous contacter à nouveau</a>
</div>

<div class="dv" style="height:1px;background:#f1f5f9;margin:20px 0;font-size:0;line-height:0;"></div>

<p class="ts" style="font-size:13px;color:#0d1b35;font-weight:700;margin-bottom:8px;">Besoin d'une réponse urgente ?</p>
<p class="ts" style="font-size:13px;color:#64748b;line-height:1.7;margin-bottom:16px;">Notre équipe est disponible du lundi au vendredi, de 9h à 18h. Pour toute urgence, vous pouvez également nous joindre directement via votre espace client si vous êtes déjà client KapitalStark.</p>

<div class="cw" style="text-align:center;margin:16px 0 0;">
  <a href="{{ url('/espace-client') }}" style="display:inline-block;padding:12px 28px;border:2px solid #267BF1;color:#267BF1 !important;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;">Accéder à mon espace client</a>
</div>
@endsection
