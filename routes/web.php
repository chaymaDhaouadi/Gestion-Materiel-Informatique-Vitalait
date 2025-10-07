<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* ────────────────  Controllers  ──────────────── */
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\MovementController;
use App\Livewire\DashboardStats;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\DashboardController;

/* Zone admin */
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController      as AdminUserController;
use App\Http\Controllers\Admin\ApprovalController;           // super‑admin

/* ────────────────  Page d’accueil / redirection  ──────────────── */

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/* ────────────────  Tableau de bord après login  ──────────────── */
Route::get('/home', [HomeController::class, 'index'])->name('home');

/* ────────────────  Routes protégées (auth)  ──────────────── */
Route::middleware('auth')->group(function () {

    /* CRUD généraux */
    Route::resource('roles',    RoleController::class);
    Route::resource('users',    AdminUserController::class);
    Route::resource('products', ProductController::class);

    /* Profil */
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/',     'edit')->name('edit');
        Route::patch('/',     'update')->name('update');
        Route::delete('/',    'destroy')->name('destroy');
    });

    /* Tableau de bord */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


    /* (Sous‑)routes Admin / Utilisateurs en attente  */
    Route::prefix('admin')->group(function () {

        /* Gestion utilisateurs (Admin simple) */
        Route::get('/utilisateurs',              [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::post('/utilisateurs/{user}/valider', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/utilisateurs/{user}/rejeter', [AdminUserController::class, 'reject'])->name('admin.users.reject');

        /* Zone Super‑Admin uniquement */
        Route::middleware('superadmin')->group(function () {
            Route::get('/approbations',                    [ApprovalController::class, 'index'])->name('admin.approbations');
            Route::post('/approbations/{user}/accepter',    [ApprovalController::class, 'accepter'])->name('admin.approuver');
            Route::post('/approbations/{user}/refuser',     [ApprovalController::class, 'refuser'])->name('admin.refuser');
        });
    });
});


/*_____________________Articles__________________ */
Route::middleware(['auth', 'superadmin'])   // ou ['auth', 'admin'] si tu crées un middleware admin
    ->prefix('admin')->group(function () {
        Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
    });

Route::middleware(['auth'])  // ajoute ton middleware si besoin
    ->prefix('articles/{article}')
    ->group(function () {
        Route::get('stock-items/create', [StockItemController::class, 'create'])
            ->name('articles.stock-items.create');

        Route::post('stock-items',        [StockItemController::class, 'store'])
            ->name('articles.stock-items.store');

        // bouton de suppression
        Route::delete('stock-items/{stockItem}', [StockItemController::class, 'destroy'])
            ->name('articles.stock-items.destroy');
    });

// Route::resource('stock-items', \App\Http\Controllers\StockItemController::class)
//->only(['create','store','destroy']);   // ultra-basique pour commencer
// routes/web.php
Route::prefix('articles/{article}')->group(function () {
    Route::get('stock-items/create', [StockItemController::class, 'create'])->name('articles.stock-items.create');
    Route::post('stock-items', [StockItemController::class, 'store'])->name('articles.stock-items.store');
});


Route::resource('movements', App\Http\Controllers\MovementController::class);
Route::resource('employes', EmployeController::class);

use App\Models\StockItem;

Route::get('/api/articles/{article}/stock-items-disponibles', function ($articleId) {
    return StockItem::where('article_id', $articleId)
        ->where('etat', 'disponible')
        ->get(['id', 'numero_serie']);
});

// web.php
Route::get('/get-serials/{id}', [MovementController::class, 'getSerialsByArticle']);
Route::get('/test-mouvement', function () {
    return view('movements.create');
});
Route::get('/articles/{id}/stock-items', [ArticleController::class, 'getStockItems']);

Route::get('/affectations/create', [AffectationController::class, 'create'])->name('affectations.create');
Route::post('/affectations', [AffectationController::class, 'store'])->name('affectations.store');
Route::get('/affectations', [AffectationController::class, 'index'])->name('affectations.index');
Route::get('/affectations/historique', [AffectationController::class, 'historique'])->name('affectations.historique');
Route::get('/affectations/{affectation}/edit', [AffectationController::class, 'edit'])->name('affectations.edit');
Route::put('/affectations/{affectation}', [AffectationController::class, 'update'])->name('affectations.update');
Route::delete('/affectations/{affectation}', [AffectationController::class, 'destroy'])->name('affectations.destroy');
Route::get('/affectations/{affectation}', [AffectationController::class, 'show'])->name('affectations.show');

/* ────────────────  Déconnexion  ──────────────── */
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/* ────────────────  Routes Auth Breeze / Fortify  ──────────────── */
require __DIR__ . '/auth.php';
