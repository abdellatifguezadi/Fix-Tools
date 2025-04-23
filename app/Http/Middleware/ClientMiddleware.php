<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->route('home')->with('error', 'Accès non autorisé - Zone Clients uniquement');
        }

        return $next($request);
    }
}
