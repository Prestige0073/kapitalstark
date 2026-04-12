<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }

        // Utilisateur client connecté → renvoyer sur son espace
        if (!$request->user()->is_admin) {
            return redirect()->route('dashboard.index')
                ->withErrors(['auth' => 'Accès réservé aux administrateurs.']);
        }

        return $next($request);
    }
}
