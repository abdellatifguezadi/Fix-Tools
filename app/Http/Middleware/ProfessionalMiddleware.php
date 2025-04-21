<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfessionalMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isProfessional()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé - Zone Professionnels uniquement');
        }

        return $next($request);
    }
}
