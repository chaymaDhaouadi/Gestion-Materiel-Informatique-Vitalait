<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Movement;
use App\Models\Employe;
use App\Models\StockItem;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index()
    {
        $mouvements = Movement::latest()->paginate(5); // ou un autre nombre
        return view('mouvements.index', compact('mouvements'));
    }

    public function create()
    {
        $articles = Article::all();
        $employes = Employe::all();

        $stockItems = StockItem::all();

        $stockItemsFormatted = $stockItems->groupBy('article_id')->map(function ($items) {
            return $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'serie_numero' => $item->serie_numero,
                ];
            })->values();
        })->toArray();

        return view('movements.create', [
            'articles' => $articles,
            'employes' => $employes,
            'stockItemsFormatted' => $stockItemsFormatted,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'employe_id' => 'required|exists:employes,id', // <-- ici
            'stock_item_id' => 'required|exists:stock_items,id',

            'destination' => 'required|string',
            'date_affectation' => 'required|date',
            'quantite' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Movement::create($request->all());
        $stockItem = StockItem::find($request->stock_item_id);
        $stockItem->etat = 'affecté'; // si tu veux changer l'état
        $stockItem->save();
        return redirect()->route('mouvements.index')->with('success', 'Mouvement ajouté avec succès.');
    }

    public function show(Movement $mouvement)
    {
        return view('mouvements.show', compact('mouvement'));
    }

    public function edit(Movement $mouvement)
    {
        $articles = Article::all();
        $employes = \App\Models\Employe::all(); // <-- ici

        return view('mouvements.edit', compact('mouvement', 'articles', 'employes'));
    }

    public function update(Request $request, Movement $mouvement)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'destination' => 'required|string',
            'date_affectation' => 'required|date',
            'quantite' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $mouvement->update($request->all());

        return redirect()->route('mouvements.index')->with('success', 'Mouvement modifié avec succès.');
    }

    public function destroy(Movement $mouvement)
    {
        $mouvement->delete();
        return redirect()->route('mouvements.index')->with('success', 'Mouvement supprimé.');
    }
    // MovementController.php
    public function getSerialsByArticle($articleId)
    {
        $serials = \App\Models\StockItem::where('article_id', $articleId)->get();

        return response()->json($serials);
    }
}
