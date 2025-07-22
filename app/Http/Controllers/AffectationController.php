<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Article;
use App\Models\Employe;
use App\Models\StockItem;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    // Affiche le formulaire d'affectation
    public function create()
    {
        $employes = Employe::all();
        $articles = Article::with('stockItems')->get();

        $stockItemsGrouped = [];

        foreach ($articles as $article) {
            $stockItemsGrouped[$article->id] = $article->stockItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'numero_serie' => $item->numero_serie,
                    'etat' => $item->etat,
                ];
            });
        }

        return view('affectations.create', [
            'employes' => $employes,
            'articles' => $articles,
            'stockItemsJson' => $stockItemsGrouped
        ]);
    }

    // Enregistre une ou plusieurs affectations
    public function store(Request $request)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'article_id' => 'required|exists:articles,id',
            'quantite' => 'required|integer|min:1',
            'date_affectation' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $article = Article::findOrFail($request->article_id);

        // Vérifier s'il y a assez de stock disponible
        $stockDisponible = StockItem::where('article_id', $request->article_id)
            ->where('etat', 'disponible')
            ->take($request->quantite)
            ->get();

        if ($stockDisponible->count() < $request->quantite) {
            return back()->withErrors(['quantite' => 'Quantité demandée supérieure au stock disponible.']);
        }

        foreach ($stockDisponible as $stockItem) {
            // 1. Créer une affectation pour chaque stockItem
            Affectation::create([
                'employe_id' => $request->employe_id,
                'article_id' => $request->article_id,
                'stock_item_id' => $stockItem->id,
                'quantite' => 1,
                'date_affectation' => $request->date_affectation,
                'description' => $request->description,
            ]);

            // 2. Modifier l'état du stockItem en "affecté" (ou "effectué" si tu préfères)
            $stockItem->etat = 'affecté'; // ou 'effectué'
            $stockItem->save();
            $article->refresh();

            // 3. Diminuer la quantité dans l'article
            $article->quantite -= 1;
        }

        // Enregistrer la nouvelle quantité de l'article après toutes les modifications
        $article->save();

        return redirect()->route('articles.show', ['article' => $request->article_id])
            ->with('success', 'Article(s) affecté(s) avec succès.');
    }
    public function index()
    {
        $affectations = Affectation::with(['employe', 'article', 'stockItem'])->latest()->get();
        return view('affectations.index', compact('affectations'));
    }
}
