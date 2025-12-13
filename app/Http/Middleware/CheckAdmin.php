<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Verificar que el usuario sea administrador
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            return redirect('/')->with('error', 'No tienes acceso a esta sección.');
        }

        return $next($request);
    }
}

