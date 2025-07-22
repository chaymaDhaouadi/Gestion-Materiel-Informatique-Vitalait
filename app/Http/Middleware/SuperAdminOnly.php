<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur n'est pas connecté OU pas super admin
        if (!auth()->check() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Accès réservé au Super Admin.');
        }

        return $next($request);
    }
}
