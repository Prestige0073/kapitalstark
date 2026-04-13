<?php
// Service : génération dynamique des données structurées JSON-LD (Schema.org)
// Injecté via ViewComposer dans le <head> de chaque page

namespace App\Services;

class SchemaMarkupService
{
    private string $baseUrl;
    private string $siteName = 'KapitalStark';

    public function __construct()
    {
        $this->baseUrl = url('/');
    }

    // ── Organisation (Knowledge Panel Google) ─────────────────────────────────

    public function organization(): array
    {
        return [
            '@type'       => ['FinancialService', 'Organization'],
            '@id'         => $this->baseUrl . '#organization',
            'name'        => $this->siteName,
            'url'         => $this->baseUrl,
            'logo'        => [
                '@type'   => 'ImageObject',
                'url'     => asset('img/og-cover.svg'),
                'width'   => 512,
                'height'  => 512,
            ],
            'description' => 'Solutions de prêt sur mesure — immobilier, automobile, personnel, entreprise.',
            'telephone'   => '+351210001234',
            'email'       => 'contacto@kapitalstarks.com',
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Avenida da Liberdade, 110, 3.º andar',
                'addressLocality' => 'Lisboa',
                'postalCode'      => '1269-046',
                'addressCountry'  => 'PT',
            ],
            'areaServed'          => 'PT',
            'currenciesAccepted'  => 'EUR',
            'priceRange'          => '€€',
            'openingHoursSpecification' => [
                ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'], 'opens' => '08:00', 'closes' => '19:00'],
                ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Saturday', 'opens' => '09:00', 'closes' => '17:00'],
            ],
            'sameAs' => [
                'https://www.linkedin.com/company/kapitalstark',
                'https://www.facebook.com/kapitalstark',
            ],
        ];
    }

    // ── WebSite + SearchAction ─────────────────────────────────────────────────

    public function website(): array
    {
        return [
            '@type'     => 'WebSite',
            '@id'       => $this->baseUrl . '#website',
            'url'       => $this->baseUrl,
            'name'      => $this->siteName,
            'publisher' => ['@id' => $this->baseUrl . '#organization'],
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => $this->baseUrl . '/faq?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    // ── BreadcrumbList ─────────────────────────────────────────────────────────

    public function breadcrumbs(array $items): array
    {
        $list = [];
        foreach ($items as $pos => $item) {
            $el = ['@type' => 'ListItem', 'position' => $pos + 1, 'name' => $item['name']];
            if (isset($item['url'])) $el['item'] = $item['url'];
            $list[] = $el;
        }
        return [
            '@type'           => 'BreadcrumbList',
            '@id'             => url()->current() . '#breadcrumb',
            'itemListElement' => $list,
        ];
    }

    // ── WebPage (générique) ────────────────────────────────────────────────────

    public function webpage(string $type, string $title, string $description): array
    {
        return [
            '@type'       => $type, // WebPage, FAQPage, ContactPage, etc.
            '@id'         => url()->current() . '#webpage',
            'url'         => url()->current(),
            'name'        => $title,
            'description' => $description,
            'isPartOf'    => ['@id' => $this->baseUrl . '#website'],
            'publisher'   => ['@id' => $this->baseUrl . '#organization'],
        ];
    }

    // ── FinancialProduct (page service prêt) ───────────────────────────────────

    public function financialProduct(string $name, string $description, string $type = 'LoanOrCredit'): array
    {
        return [
            '@type'       => $type,
            '@id'         => url()->current() . '#product',
            'name'        => $name,
            'description' => $description,
            'provider'    => ['@id' => $this->baseUrl . '#organization'],
            'areaServed'  => 'PT',
            'currency'    => 'EUR',
        ];
    }

    // ── FAQPage (Featured Snippets) ────────────────────────────────────────────

    public function faqPage(\Illuminate\Support\Collection $faqs): array
    {
        return [
            '@type'            => 'FAQPage',
            '@id'              => url()->current() . '#faqpage',
            'mainEntity'       => $faqs->map(fn ($f) => [
                '@type'          => 'Question',
                'name'           => is_array($f) ? $f['question'] : $f->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => is_array($f) ? strip_tags($f['answer']) : strip_tags($f->answer),
                ],
            ])->values()->all(),
        ];
    }

    // ── Article / Blog ─────────────────────────────────────────────────────────

    public function article(string $title, string $description, string $datePublished, ?string $image = null): array
    {
        return [
            '@type'            => 'Article',
            '@id'              => url()->current() . '#article',
            'headline'         => $title,
            'description'      => $description,
            'datePublished'    => $datePublished,
            'dateModified'     => $datePublished,
            'image'            => $image ?? asset('img/og-cover.svg'),
            'author'           => ['@id' => $this->baseUrl . '#organization'],
            'publisher'        => ['@id' => $this->baseUrl . '#organization'],
            'isPartOf'         => ['@id' => $this->baseUrl . '#website'],
        ];
    }

    // ── LocalBusiness (agences) ────────────────────────────────────────────────

    public function localBusiness(array $agency): array
    {
        return [
            '@type'       => ['LocalBusiness', 'FinancialService'],
            '@id'         => $this->baseUrl . '#agence-' . \Str::slug($agency['name']),
            'name'        => $agency['name'],
            'url'         => $this->baseUrl . '/a-propos/agences',
            'telephone'   => $agency['phone'] ?? '+351210001234',
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $agency['address'],
                'addressLocality' => $agency['city'],
                'postalCode'      => $agency['zip'] ?? '',
                'addressCountry'  => 'PT',
            ],
            'geo'         => isset($agency['lat']) ? ['@type' => 'GeoCoordinates', 'latitude' => $agency['lat'], 'longitude' => $agency['lng']] : null,
            'openingHours'=> ['Mo-Fr 08:00-19:00', 'Sa 09:00-17:00'],
            'image'       => asset('img/og-cover.svg'),
            'parentOrganization' => ['@id' => $this->baseUrl . '#organization'],
        ];
    }

    // ── Génère le bloc @graph complet ─────────────────────────────────────────

    public function buildGraph(array $nodes): string
    {
        $graph = array_filter($nodes, fn ($n) => !empty($n));
        return json_encode([
            '@context' => 'https://schema.org',
            '@graph'   => array_values($graph),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
