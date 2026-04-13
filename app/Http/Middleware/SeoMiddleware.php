<?php
// Middleware SEO : X-Robots-Tag, Cache-Control adapté, partage des settings SEO dans les vues

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\SeoSetting;
use Symfony\Component\HttpFoundation\Response;

class SeoMiddleware
{
    // Routes qui ne doivent pas être indexées
    private const NO_INDEX_PREFIXES = [
        'dashboard', 'admin', 'espace-client', 'logout',
        'gestion-interne', 'chat/poll', 'sitemap',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!method_exists($response, 'header')) {
            return $response;
        }

        $path = ltrim($request->path(), '/');

        // Déterminer si la page doit être indexée
        $noIndex = false;
        foreach (self::NO_INDEX_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $noIndex = true;
                break;
            }
        }

        // X-Robots-Tag
        $robotsValue = $noIndex ? 'noindex, nofollow' : 'index, follow';
        $response->header('X-Robots-Tag', $robotsValue);

        // Cache-Control
        if ($noIndex) {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        } else {
            $response->header('Cache-Control', 'public, max-age=3600, stale-while-revalidate=86400');
        }

        // Partage les settings SEO de la page courante dans toutes les vues
        $pageType = $this->resolvePageType($path);
        $seoSettings = SeoSetting::forPage($pageType);
        View::share('seoSettings', $seoSettings);
        View::share('seoPageType', $pageType);

        return $response;
    }

    private function resolvePageType(string $path): string
    {
        if ($path === '/')       return 'home';
        if ($path === '')        return 'home';

        $map = [
            'prets/immobilier'  => 'loan_immobilier',
            'prets/automobile'  => 'loan_automobile',
            'prets/personnel'   => 'loan_personnel',
            'prets/entreprise'  => 'loan_entreprise',
            'prets/agricole'    => 'loan_agricole',
            'prets/microcredit' => 'loan_microcredit',
            'prets'             => 'loans',
            'simulateur'        => 'simulator',
            'faq'               => 'faq',
            'blog'              => 'blog',
            'contact'           => 'contact',
            'a-propos/agences'  => 'agencies',
            'a-propos'          => 'about',
            'lp'                => 'landing',
        ];

        foreach ($map as $prefix => $type) {
            if (str_starts_with($path, $prefix)) return $type;
        }

        return 'generic';
    }
}
