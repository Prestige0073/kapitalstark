@php
$isSuccess  = in_array($status, ['approved', 'validated', 'confirmed', 'signed', 'offer']);
$isRejected = $status === 'rejected';
$iconColor  = $isSuccess ? 'hi--gr' : ($isRejected ? 'hi--re' : 'hi--bl');
$iconBg     = $isSuccess ? 'rgba(5,150,105,.10)' : ($isRejected ? 'rgba(220,38,38,.10)' : 'rgba(38,123,241,.10)');
$icon       = $isSuccess ? '✅' : ($isRejected ? '❌' : '🔄');
$badgeCls   = $isSuccess ? 'badge--green' : ($isRejected ? 'badge--red' : 'badge--blue');
$badgeStyle = $isSuccess
  ? 'background:rgba(5,150,105,.10);color:#047857;'
  : ($isRejected
    ? 'background:rgba(220,38,38,.10);color:#b91c1c;'
    : 'background:rgba(38,123,241,.10);color:#1a56b0;');
@endphp

@extends('mail.layouts.base')

@section('hero')
<div class="hi {{ $iconColor }}" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:{{ $iconBg }};">{{ $icon }}</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">
  @if($isSuccess) Bonne nouvelle pour votre dossier
  @elseif($isRejected) Décision sur votre dossier
  @else Mise à jour de votre dossier
  @endif
</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Réf. #{{ str_pad($requestId, 5, '0', STR_PAD_LEFT) }} — {{ $loanType }}</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $userName }}</strong>,<br><br>
  @if($status === 'approved')
    Nous avons le plaisir de vous informer que votre demande de prêt a été <strong>approuvée</strong>. Les fonds seront virés sur votre compte KapitalStark selon les modalités convenues dans votre contrat.
  @elseif($status === 'validated' || $status === 'confirmed')
    Excellente nouvelle ! Votre dossier vient d'être <strong>validé</strong> par notre équipe crédit. La prochaine étape est l'émission de votre contrat de prêt.
  @elseif($status === 'contract_sent')
    Votre contrat de prêt est prêt. Nous vous invitons à vous connecter à votre espace client pour le <strong>consulter et le signer électroniquement</strong> dans les meilleurs délais.
  @elseif($status === 'documents_submitted')
    Vos documents ont été reçus. Notre équipe crédit va maintenant procéder à l'<strong>analyse de votre dossier complet</strong>. Vous serez notifié(e) de la décision.
  @elseif($status === 'under_review' || $status === 'analysis')
    Votre dossier est actuellement en cours d'<strong>analyse approfondie</strong> par notre équipe crédit. Une décision vous sera communiquée sous <strong>48h ouvrées</strong>.
  @elseif($status === 'signed')
    Félicitations ! Votre contrat de prêt a été <strong>signé</strong>. Le déblocage des fonds interviendra sous <strong>2 à 5 jours ouvrés</strong>.
  @elseif($status === 'offer')
    Une offre de prêt vient d'être émise pour votre dossier. Connectez-vous à votre espace client pour la consulter — elle est valable <strong>30 jours</strong>.
  @elseif($status === 'rejected')
    Après étude approfondie de votre dossier, nous sommes dans l'impossibilité de donner suite à votre demande. Votre conseiller reste disponible pour vous expliquer cette décision et étudier d'autres solutions.
  @else
    Le statut de votre demande de prêt vient d'être mis à jour.
  @endif
</p>

<div class="ic" style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div class="ic__hd" style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Votre dossier — Réf. #{{ str_pad($requestId, 5, '0', STR_PAD_LEFT) }}</div>
  <table class="ic__tb" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Type de prêt</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $loanType }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Montant</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:18px;color:#267BF1;font-weight:800;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ number_format($amount, 0, ',', ' ') }} €</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Nouveau statut</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);"><span class="badge {{ $badgeCls }}" style="display:inline-block;padding:4px 12px;border-radius:100px;font-size:12px;font-weight:700;{{ $badgeStyle }}">{{ $statusLabel }}</span></td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Mise à jour le</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;">{{ now()->format('d/m/Y à H:i') }}</td>
    </tr>
  </table>
</div>

@if($status === 'contract_sent')
<div class="hb hb--bl" style="background:rgba(38,123,241,.06);border:1px solid rgba(38,123,241,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">📝 <strong>Action requise :</strong> Votre contrat est disponible dans votre espace client. Vous disposez de <strong>30 jours</strong> pour le signer. Passé ce délai, votre dossier sera archivé.</p>
</div>
@elseif($status === 'approved' || $status === 'signed')
<div class="hb hb--gr" style="background:rgba(5,150,105,.05);border:1px solid rgba(5,150,105,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">🎊 <strong>Félicitations !</strong> Votre prêt est accordé. Les fonds seront crédités sur votre compte KapitalStark sous <strong>2 à 5 jours ouvrés</strong>.</p>
</div>
@elseif($status === 'rejected')
<div class="hb hb--am" style="background:rgba(217,119,6,.05);border:1px solid rgba(217,119,6,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">💬 <strong>Besoin d'aide ?</strong> Notre équipe est disponible pour vous accompagner. Prenez rendez-vous avec votre conseiller pour explorer des solutions alternatives adaptées à votre profil.</p>
</div>
@endif

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ url('/dashboard/demandes') }}" class="cb {{ ($isSuccess) ? 'cb--gr' : '' }}" style="display:inline-block;padding:15px 34px;background:{{ $isSuccess ? '#059669' : '#267BF1' }};color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Consulter mon dossier →</a>
</div>

<div class="sec" style="overflow:hidden;background:#f8faff;border-radius:10px;padding:14px 18px;margin-bottom:24px;border:1px solid rgba(38,123,241,.08);">
  <span class="sec__i" style="float:left;font-size:18px;line-height:1.4;margin-right:12px;">🔒</span>
  <p class="sec__t" style="overflow:hidden;font-size:12px;color:#64748b;line-height:1.6;margin:0;">Toutes vos informations sont traitées de manière sécurisée. Pour toute question, contactez votre conseiller via la messagerie de votre espace client — ne répondez pas directement à cet email.</p>
</div>
@endsection
