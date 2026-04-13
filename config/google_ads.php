<?php
// Configuration Google Ads & GTM — toutes les constantes de tracking
// Renseigner les valeurs dans le fichier .env

return [

    /* ── Google Tag Manager ────────────────────────────────────── */
    'gtm_container_id'  => env('GTM_CONTAINER_ID'),          // ex: GTM-XXXXXXX

    /* ── Google Ads ─────────────────────────────────────────────── */
    'ads_id'            => env('GOOGLE_ADS_ID'),             // ex: AW-123456789
    'conversion_id'     => env('GOOGLE_ADS_CONVERSION_ID'),  // ex: AW-123456789/AbCdEfGh
    'conversion_label'  => env('GOOGLE_ADS_CONVERSION_LABEL'),

    /* ── Pages de conversion et valeurs associées ──────────────── */
    'conversion_pages'  => [
        '/dashboard/demandes/nouvelle' => ['type' => 'form_submit',    'value' => 50.00],
        '/simulateur'                  => ['type' => 'simulator_click', 'value' => 5.00],
        '/lp'                          => ['type' => 'landing_submit',  'value' => 75.00],
    ],

    /* ── Mapping URL → type de conversion ─────────────────────── */
    'url_conversion_map' => [
        'dashboard/demandes'  => 'form_submit',
        'simulateur'          => 'simulator_click',
        'lp/'                 => 'landing_submit',
    ],
];
