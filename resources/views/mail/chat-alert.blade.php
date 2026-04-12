@extends('mail.layouts.base')

@section('hero')
<div style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(38,123,241,.10);">💬</div>
<p style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Nouveau message chat</p>
<p style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Un visiteur attend une réponse humaine</p>
@endsection

@section('content')
<p style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Un visiteur du site a envoyé un message que le bot <strong>n'a pas pu traiter automatiquement</strong>. Il attend votre réponse.
</p>

<div style="background:#f8faff;border-radius:14px;border:1px solid rgba(38,123,241,.10);overflow:hidden;margin-bottom:24px;">
  <div style="background:rgba(38,123,241,.06);padding:10px 20px;font-size:11px;font-weight:800;color:#267BF1;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid rgba(38,123,241,.08);">Informations du visiteur</div>
  <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Adresse IP</td>
      <td style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);font-family:monospace;">{{ $session->ip_address }}</td>
    </tr>
    <tr>
      <td style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;border-bottom:1px solid rgba(38,123,241,.06);">Date</td>
      <td style="padding:12px 20px;font-size:14px;color:#0d1b35;font-weight:700;text-align:right;border-bottom:1px solid rgba(38,123,241,.06);">{{ now()->format('d/m/Y à H:i') }}</td>
    </tr>
    <tr>
      <td style="padding:12px 20px;font-size:14px;color:#64748b;font-weight:500;">Navigateur</td>
      <td style="padding:12px 20px;font-size:13px;color:#475569;text-align:right;">{{ \Illuminate\Support\Str::limit($session->user_agent ?? 'Inconnu', 60) }}</td>
    </tr>
  </table>
</div>

<div style="background:rgba(38,123,241,.06);border:1px solid rgba(38,123,241,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:13px;color:#267BF1;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin:0 0 8px;">Message du visiteur</p>
  <p style="font-size:15px;color:#0d1b35;line-height:1.7;margin:0;font-style:italic;">"{{ $visitorMessage }}"</p>
</div>

<div style="text-align:center;margin:28px 0;">
  <a href="{{ $chatUrl }}" style="display:inline-block;padding:15px 34px;background:#267BF1;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Voir la conversation →</a>
</div>
@endsection
