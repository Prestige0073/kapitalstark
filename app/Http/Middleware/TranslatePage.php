<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils as PromiseUtils;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\Tokens\GoogleTokenGenerator;
use Symfony\Component\HttpFoundation\Response;

class TranslatePage
{
    private const SEP        = ' ||| ';
    private const CHUNK_CHARS = 4000;
    private const GT_URL     = 'https://translate.google.com/translate_a/single';

    /** Paramètres Google Translate (mêmes que Stichoza) */
    private const GT_PARAMS = [
        'client'   => 'gtx',
        'dt'       => ['t','bd','at','ex','ld','md','qca','rw','rm','ss'],
        'ie'       => 'UTF-8',
        'oe'       => 'UTF-8',
        'multires' => 1,
        'otf'      => 0,
        'pc'       => 1,
        'trs'      => 1,
        'ssel'     => 0,
        'tsel'     => 0,
        'kc'       => 1,
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $locale   = app()->getLocale();

        if (
            $locale === 'fr'
            || !$request->isMethod('GET')
            || !($response instanceof \Illuminate\Http\Response)
            || !str_contains($response->headers->get('Content-Type', ''), 'text/html')
            || $request->is('dashboard*', 'admin*')
        ) {
            return $response;
        }

        $html = $response->getContent();

        // Normalise le token CSRF avant le hash pour que le cache soit stable
        // quelle que soit la valeur du token (qui change à chaque session).
        $htmlForHash = preg_replace(
            '/(<meta\s+name="csrf-token"\s+content=")[^"]*(")/i',
            '$1__CSRF__$2',
            $html
        );
        $cacheKey = 'trans:' . $locale . ':' . md5($htmlForHash);

        if (cache()->has($cacheKey)) {
            $response->setContent(cache()->get($cacheKey));
            return $response;
        }

        // Traduction synchrone en parallèle (requêtes Guzzle concurrentes).
        // Premier chargement ~2-3s, puis cache instantané pour 30 jours.
        try {
            [$translated, $translatedCount] = $this->translateHtml($html, $locale);
            if ($translatedCount > 0) {
                cache()->put($cacheKey, $translated, now()->addDays(30));
                $response->setContent($translated);
            }
        } catch (\Throwable) {
            // Échec API → servir le contenu français sans bloquer
        }

        return $response;
    }

    /* ──────────────────────────────────────────────────────── */

    private function translateHtml(string $html, string $locale): array
    {
        // ── Protéger les blocs <script> et <style> ──────────────
        // DOMDocument::saveHTML() encode les caractères non-ASCII en entités HTML
        // dans ces blocs, ce qui corrompt le JavaScript/CSS. On les extrait
        // avant le traitement et on les restaure après.
        $protected = [];
        $counter   = 0;
        $htmlSafe  = preg_replace_callback(
            '/<(script|style)(\s[^>]*)?>.*?<\/\1>/si',
            function (array $m) use (&$protected, &$counter): string {
                $key              = '__PROTECTED_BLOCK_' . $counter++ . '__';
                $protected[$key]  = $m[0];
                return $key;
            },
            $html
        );

        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML($htmlSafe);
        libxml_clear_errors();

        $xpath     = new \DOMXPath($dom);
        $textNodes = $xpath->query(
            '//text()[
                not(ancestor::script) and
                not(ancestor::style) and
                not(ancestor::noscript) and
                not(ancestor::*[@translate="no"]) and
                string-length(normalize-space(.)) > 1
            ]'
        );

        // ── Collecter textes + attributs traduisibles ───────────
        // Chaque item : ['kind'=>'text'|'attr', 'node'=>DOMNode, 'attr'=>string, 'text'=>string]
        $items = [];

        foreach ($textNodes as $node) {
            $text = $node->nodeValue;
            if (mb_strlen(trim($text)) > 1) {
                $items[] = ['kind' => 'text', 'node' => $node, 'attr' => '', 'text' => $text];
            }
        }

        // Attributs visibles que le moteur de rendu affiche à l'utilisateur
        $translatableAttrs = ['placeholder', 'aria-label', 'aria-placeholder', 'title', 'alt'];
        $attrQuery = '//*[not(ancestor::*[@translate="no"])]' .
            '[' . implode(' or ', array_map(fn ($a) => "@$a", $translatableAttrs)) . ']';

        foreach ($xpath->query($attrQuery) as $el) {
            foreach ($translatableAttrs as $attr) {
                if ($el->hasAttribute($attr)) {
                    $val = $el->getAttribute($attr);
                    if (mb_strlen(trim($val)) > 1) {
                        $items[] = ['kind' => 'attr', 'node' => $el, 'attr' => $attr, 'text' => $val];
                    }
                }
            }
        }

        if (empty($items)) {
            return [$html, 0];
        }

        // ── Déduplication ──────────────────────────────────────
        $texts       = array_column($items, 'text');
        $unique      = array_values(array_unique($texts));
        $uniqueXlat  = $this->translateUnique($unique, $locale);

        $xlateMap        = [];
        $translatedCount = 0;
        foreach ($unique as $i => $t) {
            $tr = $uniqueXlat[$i] ?? $t;
            $xlateMap[$t] = $tr;
            if ($tr !== $t) {
                $translatedCount++;
            }
        }

        foreach ($items as $item) {
            $orig = $item['text'];
            $tr   = $xlateMap[$orig] ?? $orig;
            if ($item['kind'] === 'text') {
                $item['node']->nodeValue = $tr;
            } else {
                $item['node']->setAttribute($item['attr'], $tr);
            }
        }

        $htmlEl = $dom->getElementsByTagName('html')->item(0);
        if ($htmlEl) {
            $htmlEl->setAttribute('lang', $locale);
        }

        $result = $dom->saveHTML();

        // ── Restaurer les blocs <script> et <style> originaux ───
        foreach ($protected as $key => $original) {
            $result = str_replace($key, $original, $result);
        }

        return [$result, $translatedCount];
    }

    /**
     * Traduit un tableau de textes uniques via des requêtes Guzzle parallèles.
     *
     * @param  string[]  $texts
     * @return string[]  Tableau de traductions dans le même ordre
     */
    private function translateUnique(array $texts, string $locale): array
    {
        $chunks   = $this->buildChunks($texts);
        $client   = new Client(['timeout' => 30, 'connect_timeout' => 15]);
        $tokenGen = new GoogleTokenGenerator();

        // ── Lancer toutes les requêtes en parallèle ──
        $promises = [];
        foreach ($chunks as $key => $chunk) {
            $joined = implode(self::SEP, $chunk['texts']);
            $params = array_merge(self::GT_PARAMS, [
                'hl' => $locale,
                'sl' => 'fr',
                'tl' => $locale,
                'tk' => $tokenGen->generateToken('fr', $locale, $joined),
                'q'  => $joined,
            ]);
            $queryUrl = preg_replace('/%5B\d+%5D=/', '=', http_build_query($params));
            $promises[$key] = $client->getAsync(self::GT_URL, ['query' => $queryUrl]);
        }

        // ── Attendre toutes les réponses ──
        $settled = PromiseUtils::settle($promises)->wait();

        // ── Reconstruire le tableau de traductions ──
        $results = [];
        foreach ($settled as $key => $outcome) {
            $chunk = $chunks[$key];

            if ($outcome['state'] === 'fulfilled') {
                $body  = (string) $outcome['value']->getBody();
                $json  = json_decode($body, true);
                $raw   = $this->extractTranslation($json);
                $parts = array_map('trim', explode('|||', $raw));

                while (count($parts) < count($chunk['indices'])) {
                    $parts[] = $chunk['texts'][count($parts)] ?? '';
                }

                foreach ($chunk['indices'] as $pos => $origIdx) {
                    $results[$origIdx] = $parts[$pos] ?? $chunk['texts'][$pos];
                }
            } else {
                // Requête échouée → garder l'original
                foreach ($chunk['indices'] as $pos => $origIdx) {
                    $results[$origIdx] = $chunk['texts'][$pos];
                }
            }
        }

        ksort($results);
        return array_values($results);
    }

    /** Extrait la chaîne traduite d'un tableau JSON Google Translate */
    private function extractTranslation(mixed $json): string
    {
        if (is_string($json)) {
            return $json;
        }
        if (!is_array($json) || !isset($json[0])) {
            return '';
        }
        if (is_array($json[0])) {
            return (string) array_reduce(
                $json[0],
                static fn($carry, $item) => $carry . ($item[0] ?? ''),
                ''
            );
        }
        return (string) $json[0];
    }

    /**
     * Regroupe les textes en batches ≤ CHUNK_CHARS chars.
     *
     * @return array<array{indices: int[], texts: string[]}>
     */
    private function buildChunks(array $texts): array
    {
        $chunks  = [];
        $curTexts  = [];
        $curIdx    = [];
        $curLen    = 0;
        $sepLen    = mb_strlen(self::SEP);

        foreach ($texts as $i => $text) {
            $tLen   = mb_strlen($text);
            $addLen = ($curLen > 0 ? $sepLen : 0) + $tLen;

            if ($tLen > self::CHUNK_CHARS) {
                if (!empty($curTexts)) {
                    $chunks[]  = ['indices' => $curIdx, 'texts' => $curTexts];
                    $curTexts  = [];
                    $curIdx    = [];
                    $curLen    = 0;
                }
                $chunks[] = ['indices' => [$i], 'texts' => [$text]];
                continue;
            }

            if ($curLen + $addLen > self::CHUNK_CHARS && !empty($curTexts)) {
                $chunks[]  = ['indices' => $curIdx, 'texts' => $curTexts];
                $curTexts  = [];
                $curIdx    = [];
                $curLen    = 0;
                $addLen    = $tLen;
            }

            $curTexts[] = $text;
            $curIdx[]   = $i;
            $curLen    += $addLen;
        }

        if (!empty($curTexts)) {
            $chunks[] = ['indices' => $curIdx, 'texts' => $curTexts];
        }

        return $chunks;
    }

}
