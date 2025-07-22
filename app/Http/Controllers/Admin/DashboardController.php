<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Movement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::count();
        $totalMouvements = Movement::count();
        $totalQuantite = Article::sum('quantite'); // ✅ Correct
        $labels = ['Jan', 'Feb', 'Mar', 'Apr']; // exemple ou généré dynamiquement
        $data = [10, 20, 30, 40]; // exemple

        // Préparer les données du graphique : mouvements par mois
        $mouvementsParMois = Movement::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->pluck('total', 'mois');

        // Format des mois pour le graphique
        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->locale('fr')->isoFormat('MMMM'); // Mois en français
            $data[] = $mouvementsParMois[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalArticles',
            'totalMouvements',
            'totalQuantite', // <-- le bon nom
            'labels',
            'data'
        ));
    }
}
