<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('client.login');
        }

        // Compte admin → renvoyer sur l'espace admin
        if ($request->user()->is_admin) {
            return redirect()->route('admin.index');
        }

        return $next($request);
    }
}
