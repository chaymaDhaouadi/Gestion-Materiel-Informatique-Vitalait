<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /* … index() et create() inchangés … */

    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'reference'          => 'required|unique:articles,reference',
            'nom'                => 'required|string|max:255',
            'description_courte' => 'nullable|string|max:500',
            'categorie_id'       => 'required|exists:categories,id',
            'etat'               => 'required|in:neuf,usagé',
            'prix_unitaire'      => 'nullable|numeric|min:0',
            'modele'             => 'nullable|string|max:255',
            'marque'             => 'nullable|string|max:255',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);

        // 2. Si une image est uploadée
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        // 3. Création de l’article avec toutes les données validées
        Article::create($validated);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article ajouté avec succès.');
    }

    public function edit(Article $article)
    {
        // liste des catégories pour le <select>
        $categories = Categorie::all();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $rules = [
            'reference'          => "required|unique:articles,reference,{$article->id}",
            'nom'                => 'required|string|max:255',
            'description_courte' => 'nullable|string|max:500',
            'categorie_id'       => 'required|exists:categories,id',
            'etat'               => 'required|in:neuf,usagé',
            'prix_unitaire'      => 'nullable|numeric|min:0',
            'modele'             => 'nullable|string|max:255',
            'marque'             => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validated = $request->validate($rules);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article)
    {
        $article->delete();          // soft delete
        return back()->with('success', 'Article archivé.');
    }
    // app/Http/Controllers/Admin/ArticleController.php
    public function index()
    {
        // eager‑load pour éviter N+1
        $articles = Article::with('categorie')
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        // Liste des catégories pour le <select>
        $categories = Categorie::all();

        return view('admin.articles.create', compact('categories'));
    }
    // app/Http/Controllers/Admin/ArticleController.php
    public function show(Article $article)
    {
        $article->load('categorie', 'stockItems', 'affectations.employe', 'affectations.stockItem');

        // Quantité restante en stock par exemple
        $quantite = $article->stockItems()->where('etat', 'disponible')->count();

        return view('admin.articles.show', compact('article', 'quantite'));
    }

    public function getStockItems($id)
    {
        $stockItems = \App\Models\StockItem::where('article_id', $id)
            ->where('etat', 'disponible') // ✅ Ne prend que les exemplaires disponibles
            ->get(['id', 'numero_serie', 'etat']);

        return response()->json($stockItems);
    }
}
