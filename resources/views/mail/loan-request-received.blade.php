@extends('mail.layouts.base')

@section('hero')
<div class="hi hi--bl" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(38,123,241,.10);">📋</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Demande de prêt enregistrée</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Votre dossier est en cours d'analyse</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $userName }}</strong>,<br><br>
  Nous avons bien reçu votre demande de prêt. Notre équipe crédit va examiner votre dossier et vous contactera sous <strong>24 heures ouvrées</strong> pour la suite du traitement.
</p>

<div class="ic" style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div class="ic__hd" style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Détails de votre demande — Réf. #{{ str_pad($requestId, 5, '0', STR_PAD_LEFT) }}</div>
  <table class="ic__tb" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Type de prêt</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $loanType }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Montant demandé</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:18px;color:#267BF1;font-weight:800;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ number_format($amount, 0, ',', ' ') }} €</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Durée souhaitée</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $duration }} mois ({{ round($duration/12, 1) }} ans)</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Date de dépôt</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ now()->format('d/m/Y à H:i') }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Statut</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;text-align:right;"><span class="badge badge--pending" style="display:inline-block;padding:4px 12px;border-radius:100px;font-size:12px;font-weight:700;background:rgba(245,158,11,.10);color:#b45309;">⏳ Dossier déposé</span></td>
    </tr>
  </table>
</div>

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ url('/dashboard/demandes') }}" class="cb" style="display:inline-block;padding:15px 34px;background:#267BF1;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Suivre mon dossier →</a>
</div>

<div class="dv" style="height:1px;background:#f1f5f9;margin:20px 0;font-size:0;line-height:0;"></div>

<p class="ts" style="font-size:13px;color:#0d1b35;font-weight:700;margin-bottom:12px;">Les prochaines étapes de votre dossier</p>

<ul class="sl" style="list-style:none;margin:0 0 24px;padding:0;">
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">1</span>
    <span style="display:block;overflow:hidden;"><strong>Analyse en cours</strong> — Votre conseiller dédié examine votre demande et vérifie votre capacité d'emprunt</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">2</span>
    <span style="display:block;overflow:hidden;"><strong>Contrat à signer</strong> — Un contrat vous est envoyé pour signature électronique (sous 24h ouvrées)</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">3</span>
    <span style="display:block;overflow:hidden;"><strong>Suivi en temps réel</strong> — Consultez l'avancement de votre dossier depuis votre espace client à tout moment</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">4</span>
    <span style="display:block;overflow:hidden;"><strong>Décision finale</strong> — Validation et déblocage des fonds sur votre compte KapitalStark</span>
  </li>
</ul>

<div class="hb hb--am" style="background:rgba(217,119,6,.05);border:1px solid rgba(217,119,6,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">⚡ <strong>Conseil :</strong> Restez disponible — votre conseiller dédié pourrait vous contacter sous <strong>24 heures ouvrées</strong> pour la suite du traitement de votre dossier.</p>
</div>

<div class="sec" style="overflow:hidden;background:#f8faff;border-radius:10px;padding:14px 18px;margin-bottom:24px;border:1px solid rgba(38,123,241,.08);">
  <span class="sec__i" style="float:left;font-size:18px;line-height:1.4;margin-right:12px;">🔒</span>
  <p class="sec__t" style="overflow:hidden;font-size:12px;color:#64748b;line-height:1.6;margin:0;">Toutes vos données sont transmises de manière sécurisée et chiffrée. Référence dossier : <strong>#{{ str_pad($requestId, 5, '0', STR_PAD_LEFT) }}</strong> — conservez-la pour vos échanges avec votre conseiller.</p>
</div>
@endsection
