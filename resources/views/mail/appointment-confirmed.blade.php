@extends('mail.layouts.base')

@section('hero')
<div class="hi hi--gr" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(5,150,105,.10);">📅</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Rendez-vous confirmé</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Votre réservation a bien été enregistrée</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $userName }}</strong>,<br><br>
  Votre rendez-vous avec KapitalStark est confirmé. Retrouvez ci-dessous tous les détails de votre réservation.
</p>

<div class="ic" style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div class="ic__hd" style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Détails de votre rendez-vous</div>
  <table class="ic__tb" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Date</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#059669;font-weight:800;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $date }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Heure</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $time }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Objet</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $subject }}</td>
    </tr>
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Format</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $channel }}</td>
    </tr>
    @if($advisor)
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Conseiller</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ $advisor }}</td>
    </tr>
    @endif
    <tr>
      <td class="ic__lb" style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Statut</td>
      <td class="ic__vl" style="padding:12px 20px;font-size:14px;text-align:right;"><span class="badge badge--green" style="display:inline-block;padding:4px 12px;border-radius:100px;font-size:12px;font-weight:700;background:rgba(5,150,105,.10);color:#047857;">✓ Confirmé</span></td>
    </tr>
  </table>
</div>

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ url('/dashboard/calendrier') }}" class="cb cb--gr" style="display:inline-block;padding:15px 34px;background:#059669;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Voir mon calendrier →</a>
</div>

<div class="dv" style="height:1px;background:#f1f5f9;margin:20px 0;font-size:0;line-height:0;"></div>

<p class="ts" style="font-size:13px;color:#0d1b35;font-weight:700;margin-bottom:12px;">Préparez votre rendez-vous</p>

<ul class="sl" style="list-style:none;margin:0 0 24px;padding:0;">
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">1</span>
    <span style="display:block;overflow:hidden;"><strong>Notez vos questions</strong> — Listez les points que vous souhaitez aborder pour un échange plus efficace</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">2</span>
    <span style="display:block;overflow:hidden;"><strong>Préparez vos questions</strong> — Notez les points que vous souhaitez aborder avec votre conseiller</span>
  </li>
  <li style="overflow:hidden;padding:10px 0;font-size:14px;color:#475569;line-height:1.6;">
    <span class="sn" style="float:left;width:26px;height:26px;border-radius:50%;background:#267BF1;color:#fff;font-size:12px;font-weight:800;text-align:center;line-height:26px;margin:1px 14px 0 0;">3</span>
    <span style="display:block;overflow:hidden;">
      @if($channel === 'Visioconférence')
        <strong>Préparez votre connexion</strong> — Vérifiez votre caméra et micro. Le lien sera disponible dans votre espace client
      @elseif($channel === 'Téléphone')
        <strong>Soyez disponible</strong> — Votre conseiller vous appellera au numéro enregistré sur votre compte à l'heure convenue
      @else
        <strong>Connectez-vous</strong> — Accédez à votre espace client 5 minutes avant l'heure du rendez-vous
      @endif
    </span>
  </li>
</ul>

<div class="hb hb--am" style="background:rgba(217,119,6,.05);border:1px solid rgba(217,119,6,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">⚠️ <strong>Annulation ou report :</strong> Merci de nous prévenir au moins <strong>24h à l'avance</strong> via la messagerie de votre espace client ou en nous appelant au <strong>+33 1 23 45 67 89</strong>.</p>
</div>

<div class="sec" style="overflow:hidden;background:#f8faff;border-radius:10px;padding:14px 18px;margin-bottom:24px;border:1px solid rgba(38,123,241,.08);">
  <span class="sec__i" style="float:left;font-size:18px;line-height:1.4;margin-right:12px;">🔒</span>
  <p class="sec__t" style="overflow:hidden;font-size:12px;color:#64748b;line-height:1.6;margin:0;">Ce rendez-vous est visible dans votre espace client. KapitalStark ne vous demandera jamais d'informations bancaires sensibles par email.</p>
</div>
@endsection
