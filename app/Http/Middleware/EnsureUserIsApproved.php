<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_approved) {
            Auth::logout();

            return redirect('/login')->withErrors([
                'email' => 'Votre compte est en attente d’approbation par le Super Admin.',
            ]);
        }

        return $next($request);
    }
}
