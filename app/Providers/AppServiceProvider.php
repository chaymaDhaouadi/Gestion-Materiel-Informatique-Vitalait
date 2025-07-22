<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Router;                              // 👈 ajouté
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use App\Http\Middleware\SuperAdminOnly;                     // 👈 ajouté

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Router $router): void              // 👈 on injecte le Router
    {
        Schema::defaultStringLength(191);
        DB::statement("SET SESSION sql_mode=''");

        /* ─────  Enregistre l’alias UNE FOIS pour toutes les requêtes  ───── */
        $router->aliasMiddleware('superadmin', SuperAdminOnly::class);

        /* ─────  Fortify : login + vérification d’approbation  ───── */
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if (!$user->is_approved) {
                    session()->flash('status', 'Votre compte est en attente de validation par un administrateur.');
                    return null;
                }
                return $user;                               // tout est OK
            }
            return null;
        });
    }
}
