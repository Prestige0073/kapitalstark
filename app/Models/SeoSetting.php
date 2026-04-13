<?php
// Modèle : paramètres SEO par type de page (meta title, description, schema JSON-LD, robots)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'page_type', 'meta_title', 'meta_description', 'og_image',
        'canonical_url', 'schema_json', 'robots_directive', 'keywords',
    ];

    /** Récupère les settings pour un type de page donné (avec mise en cache 1h) */
    public static function forPage(string $pageType): ?self
    {
        return \Cache::remember("seo_settings:{$pageType}", 3600, function () use ($pageType) {
            return static::where('page_type', $pageType)->first();
        });
    }
}
