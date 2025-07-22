<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\StockItem;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    public function create(Article $article)
    {
        // $article est automatiquement injecté via Route Model Binding
        return view('stock_items.create', compact('article'));
    }


    public function store(Request $request, Article $article)
    {

        $request->validate([
            'numero_serie' => 'required|unique:stock_items',
            'etat' => 'required|in:disponible,en panne',
        ]);

        $article->stockItems()->create([
            'numero_serie' => $request->numero_serie,
            'etat' => $request->etat,
        ]);

        return redirect()->route('articles.show', $article)->with('success', 'Exemplaire ajouté avec succès.');
    }


    public function destroy(Article $article, StockItem $stockItem)
    {
        $stockItem->delete();
        return back()->with('success', 'Exemplaire supprimé.');
    }
}
