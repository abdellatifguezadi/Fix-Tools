<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfessionalMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isProfessional()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access - Professionals area only');
        }

        return $next($request);
    }
}
