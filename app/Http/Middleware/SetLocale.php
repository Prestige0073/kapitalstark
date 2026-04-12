<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['fr', 'en', 'de', 'es', 'pt'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'de'));

        if (!in_array($locale, self::SUPPORTED, true)) {
            $locale = 'de';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
