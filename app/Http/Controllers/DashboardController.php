<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Article;
use App\Models\StockItem;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalArticles' => Article::count(),
            'availableCount' => StockItem::where('etat', 'disponible')->count(),
            'assignedCount' => StockItem::where('etat', 'affecté')->count(),
            'brokenCount' => StockItem::where('etat', 'en panne')->count(),

            'topArticles' => Affectation::selectRaw('article_id, COUNT(*) as total')
                ->with('article')
                ->groupBy('article_id')
                ->orderByDesc('total')
                ->take(5)
                ->get(),

            'lastAffectations' => Affectation::with('article', 'employe')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
