<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isClient()) {
            return redirect()->route('home')->with('error', 'Accès non autorisé - Zone Clients uniquement');
        }

        return $next($request);
    }
}
