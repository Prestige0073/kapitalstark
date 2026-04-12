@extends('mail.layouts.base')

@section('hero')
<div class="hi hi--am" style="display:block;width:64px;height:64px;border-radius:18px;margin:0 auto 18px;text-align:center;line-height:62px;font-size:26px;background:rgba(217,119,6,.10);">🔑</div>
<p class="ht2" style="font-size:24px;font-weight:800;color:#0d1b35;letter-spacing:-.5px;margin:0 0 8px;">Réinitialisation de mot de passe</p>
<p class="hs" style="font-size:15px;color:#64748b;line-height:1.6;margin:0;">Lien valable 60 minutes</p>
@endsection

@section('content')
<p class="gr" style="font-size:16px;color:#334155;line-height:1.7;margin-bottom:24px;">
  Bonjour <strong style="color:#0d1b35;">{{ $name }}</strong>,<br><br>
  Nous avons reçu une demande de réinitialisation du mot de passe associé à votre compte KapitalStark. Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe.
</p>

<div class="cw" style="text-align:center;margin:28px 0;">
  <a href="{{ $url }}" class="cb" style="display:inline-block;padding:15px 34px;background:#267BF1;color:#fff !important;border-radius:12px;font-size:15px;font-weight:800;text-decoration:none;">Réinitialiser mon mot de passe →</a>
</div>

<div class="hb hb--am" style="background:rgba(217,119,6,.05);border:1px solid rgba(217,119,6,.15);border-radius:14px;padding:18px 22px;margin-bottom:24px;">
  <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">⏱️ <strong>Ce lien expire dans 60 minutes.</strong> Passé ce délai, soumettez une nouvelle demande depuis la page de connexion.</p>
</div>

<div class="dv" style="height:1px;background:#f1f5f9;margin:20px 0;font-size:0;line-height:0;"></div>

<p class="ts" style="font-size:13px;color:#0d1b35;font-weight:700;margin-bottom:8px;">Vous n'avez pas fait cette demande ?</p>
<p class="ts" style="font-size:13px;color:#64748b;line-height:1.7;margin-bottom:16px;">Ignorez simplement cet email — votre compte reste sécurisé et votre mot de passe n'a pas été modifié. Aucune action n'est requise de votre part.</p>

<p class="ts" style="font-size:12px;color:#94a3b8;line-height:1.7;margin-bottom:24px;">Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur :<br>
<a href="{{ $url }}" style="color:#267BF1;word-break:break-all;">{{ $url }}</a></p>

<div class="sec" style="overflow:hidden;background:#f8faff;border-radius:10px;padding:14px 18px;margin-bottom:24px;border:1px solid rgba(38,123,241,.08);">
  <span class="sec__i" style="float:left;font-size:18px;line-height:1.4;margin-right:12px;">🔒</span>
  <p class="sec__t" style="overflow:hidden;font-size:12px;color:#64748b;line-height:1.6;margin:0;">Ne partagez jamais ce lien. KapitalStark ne vous demandera jamais votre mot de passe par email ou téléphone. En cas de doute, contactez notre support via votre espace client.</p>
</div>
@endsection
