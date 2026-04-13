<?php
// Service : injection GTM et gestion des conversions Google Ads

namespace App\Services;

class GoogleAdsTrackingService
{
    private ?string $gtmId;
    private ?string $adsId;
    private ?string $conversionId;
    private ?string $conversionLabel;

    public function __construct()
    {
        $this->gtmId          = config('google_ads.gtm_container_id');
        $this->adsId          = config('google_ads.ads_id');
        $this->conversionId   = config('google_ads.conversion_id');
        $this->conversionLabel = config('google_ads.conversion_label');
    }

    public function isEnabled(): bool
    {
        return !empty($this->gtmId) || !empty($this->adsId);
    }

    public function getGtmId(): ?string    { return $this->gtmId; }
    public function getAdsId(): ?string    { return $this->adsId; }
    public function getConversionId(): ?string   { return $this->conversionId; }
    public function getConversionLabel(): ?string { return $this->conversionLabel; }

    /** Construit le dataLayer initial pour une page */
    public function buildDataLayer(string $pageType, bool $userLoggedIn = false, ?string $loanType = null): array
    {
        return array_filter([
            'page_type'       => $pageType,
            'user_logged_in'  => $userLoggedIn,
            'loan_type_viewed'=> $loanType,
        ]);
    }
}
