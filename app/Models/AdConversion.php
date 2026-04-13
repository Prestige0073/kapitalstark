<?php
// Modèle : suivi des conversions Google Ads côté serveur (RGPD : IP anonymisée)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdConversion extends Model
{
    public $timestamps = false;
    public $fillable = [
        'gclid', 'conversion_type', 'page_url', 'value', 'currency',
        'ip_address', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
    ];

    public const TYPES = [
        'form_submit',       // soumission formulaire de demande
        'simulator_click',   // clic sur "Simuler mon prêt"
        'phone_call',        // clic sur lien tel:
        'pdf_download',      // téléchargement PDF
        'scroll_75',         // scroll > 75% de la page
        'engagement_3min',   // temps passé > 3 minutes
        'landing_submit',    // soumission formulaire landing page
    ];

    /** Anonymise les 2 derniers octets IPv4 ou les 80 derniers bits IPv6 */
    public static function anonymizeIp(string $ip): string
    {
        if (str_contains($ip, ':')) {
            // IPv6 : garder les 48 premiers bits
            $parts = explode(':', $ip);
            return implode(':', array_slice($parts, 0, 3)) . ':xxxx:xxxx:xxxx:xxxx:xxxx';
        }
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            $parts[2] = 'x';
            $parts[3] = 'x';
            return implode('.', $parts);
        }
        return 'x.x.x.x';
    }

    /** Enregistre une conversion à partir de la requête courante */
    public static function record(string $type, \Illuminate\Http\Request $request, ?float $value = null): self
    {
        return static::create([
            'gclid'           => $request->cookie('_gcl_aw') ?? $request->session()->get('gclid'),
            'conversion_type' => $type,
            'page_url'        => $request->url(),
            'value'           => $value,
            'currency'        => 'EUR',
            'ip_address'      => static::anonymizeIp($request->ip()),
            'utm_source'      => $request->session()->get('utm_source'),
            'utm_medium'      => $request->session()->get('utm_medium'),
            'utm_campaign'    => $request->session()->get('utm_campaign'),
            'utm_term'        => $request->session()->get('utm_term'),
            'utm_content'     => $request->session()->get('utm_content'),
        ]);
    }
}
