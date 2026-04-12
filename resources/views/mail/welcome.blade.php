@extends('mail.layouts.base')

@section('hero')
<div class="hi hi--bl" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(38,123,241,.10);">🎉</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Bienvenue chez KapitalStark</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Votre compte a été créé avec succès</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $userName }}</strong>,<br><br>
  Nous sommes ravis de vous accueillir dans la communauté KapitalStark. Votre espace client est maintenant actif et prêt à être utilisé.
</p>

<div class="ic" style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div class="ic__hd" style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Vos informations de compte</div>
  <table class="ic__tb" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Nom complet</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $userName }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Adresse email</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $userEmail }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Date d'inscription</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ now()->format('d/m/Y') }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Statut du compte</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;text-align:right;"><span class="badge badge--green" style="display:inline-block;padding:4px 12px;border-radius:100px;font-size:12px;font-weight:700;background:rgba(5,150,105,.10);color:#047857;">✓ Actif</span></td>
    </tr>
  </table>
</div>

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ url('/dashboard') }}" class="cb" style="display:inline-block;padding:15px 34px;background:#267BF1;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Accéder à mon espace →</a>
</div>

<div class="dv" style="height:1px;background:#f1f5f9;margin:20px 0;font-size:0;line-height:0;"></div>

<p class="ts" style="font-size:13px;color:#0d1b35;font-weight:700;margin-bottom:12px;">Que pouvez-vous faire depuis votre espace client ?</p>

<ul class="sl" style="list-style:none;margin:0 0 24px;padding:0;">
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">1</span>
    <span style="display:block;overflow:hidden;">Déposer une demande de prêt immobilier, automobile, personnel ou professionnel</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">2</span>
    <span style="display:block;overflow:hidden;">Suivre l'avancement de votre dossier en temps réel, étape par étape</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">3</span>
    <span style="display:block;overflow:hidden;">Échanger directement avec votre conseiller dédié via la messagerie sécurisée</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">4</span>
    <span style="display:block;overflow:hidden;">Gérer vos virements et télécharger vos contrats de prêt</span>
  </li>
</ul>

<div class="hb hb--bl" style="background:rgba(38,123,241,.06);border:1px solid rgba(38,123,241,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">💡 <strong>Conseil :</strong> Avant de soumettre une demande de prêt, utilisez notre <a href="{{ url('/simulateur') }}" style="color:#267BF1;font-weight:600;">simulateur de crédit</a> pour estimer vos mensualités et vérifier votre capacité d'emprunt.</p>
</div>

<div class="sec" style="overflow:hidden;background:#f8faff;border-radius:10px;padding:14px 18px;margin-bottom:24px;border:1px solid rgba(38,123,241,.08);">
  <span class="sec__i" style="float:left;font-size:18px;line-height:1.4;margin-right:12px;">🔒</span>
  <p class="sec__t" style="overflow:hidden;font-size:12px;color:#64748b;line-height:1.6;margin:0;">Votre compte est protégé par un chiffrement de bout en bout. Ne communiquez jamais votre mot de passe par email. KapitalStark ne vous le demandera jamais.</p>
</div>
@endsection
