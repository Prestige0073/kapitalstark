@extends('mail.layouts.base')

@section('hero')
<div class="hi hi--bl" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(38,123,241,.10);">💬</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Message de votre conseiller</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Un message vous attend dans votre espace client</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $userName }}</strong>,<br><br>
  Votre conseiller KapitalStark vous a adressé un nouveau message. Vous pouvez le consulter et y répondre directement depuis votre espace client sécurisé.
</p>

<div class="ic" style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div class="ic__hd" style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Informations du message</div>
  <table class="ic__tb" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Sujet</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $subject }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Expéditeur</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">Votre conseiller KapitalStark</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Reçu le</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ now()->format('d/m/Y à H:i') }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Statut</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;text-align:right;"><span class="badge badge--blue" style="display:inline-block;padding:4px 12px;border-radius:100px;font-size:12px;font-weight:700;background:rgba(38,123,241,.10);color:#1a56b0;">📬 Non lu</span></td>
    </tr>
  </table>
</div>

<div class="hb hb--bl" style="background:rgba(38,123,241,.06);border:1px solid rgba(38,123,241,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">📋 <strong>Aperçu du message :</strong><br>
  <span style="color:#475569;font-style:italic;line-height:1.8;">"{{ \Illuminate\Support\Str::limit($body, 400) }}"</span></p>
</div>

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ url('/dashboard/messagerie') }}" class="cb" style="display:inline-block;padding:15px 34px;background:#267BF1;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Lire et répondre →</a>
</div>

<div class="dv" style="height:1px;background:#f1f5f9;margin:20px 0;font-size:0;line-height:0;"></div>

<p class="ts" style="font-size:13px;color:#0d1b35;font-weight:700;margin-bottom:8px;">Pourquoi votre conseiller vous a-t-il écrit ?</p>
<p class="ts" style="font-size:13px;color:#64748b;line-height:1.7;margin-bottom:24px;">Votre conseiller peut vous contacter pour vous informer de l'avancement de votre dossier, vous demander des documents complémentaires, ou simplement répondre à vos questions. Nous vous recommandons de consulter ce message rapidement.</p>

<div class="sec" style="overflow:hidden;background:#f8faff;border-radius:10px;padding:14px 18px;margin-bottom:24px;border:1px solid rgba(38,123,241,.08);">
  <span class="sec__i" style="float:left;font-size:18px;line-height:1.4;margin-right:12px;">🔒</span>
  <p class="sec__t" style="overflow:hidden;font-size:12px;color:#64748b;line-height:1.6;margin:0;">Pour répondre à ce message, utilisez exclusivement la <strong>messagerie sécurisée</strong> de votre espace client. Ne répondez jamais à cet email et ne communiquez aucune information personnelle par email.</p>
</div>
@endsection
