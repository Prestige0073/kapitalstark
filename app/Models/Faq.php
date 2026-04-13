<?php
// Modèle : FAQ — questions/réponses pour Featured Snippets et accordéons

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model
{
    protected $fillable = [
        'question', 'answer', 'category', 'page_slug', 'is_published', 'sort_order',
    ];

    protected $casts = ['is_published' => 'boolean'];

    /** Catégories disponibles */
    public const CATEGORIES = [
        'conditions_pret'   => 'Conditions de prêt',
        'taux_interet'      => 'Taux d\'intérêt',
        'eligibilite'       => 'Éligibilité',
        'remboursement'     => 'Remboursement',
        'documents_requis'  => 'Documents requis',
    ];

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)->orderBy('sort_order');
    }

    public function scopeForSlug(Builder $q, string $slug): Builder
    {
        return $q->where(fn ($sub) => $sub->whereNull('page_slug')->orWhere('page_slug', $slug));
    }

    /** FAQ pour la page /faq globale groupées par catégorie */
    public static function forFaqPage(): array
    {
        return \Cache::remember('faqs:global', 1800, function () {
            return static::published()
                ->get()
                ->groupBy('category')
                ->toArray();
        });
    }

    /** FAQ pour une page de service donnée (slug) */
    public static function forPage(string $slug): \Illuminate\Support\Collection
    {
        // On stocke en tableau pour éviter les problèmes de désérialisation Eloquent via cache DB
        $data = \Cache::remember("faqs_arr:{$slug}", 1800, function () use ($slug) {
            return static::published()->forSlug($slug)->get()->toArray();
        });
        return collect($data)->map(fn ($item) => (object) $item);
    }
}
