{{-- resources/views/admin/articles/_form.blade.php --}}
@php
$edit = isset($article) && $article;
@endphp

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">

    {{-- Référence + Nom --}}
    <div class="col-md-4">
        <label class="form-label">Référence <span class="text-danger">*</span></label>
        <input type="text" name="reference" class="form-control"
            value="{{ old('reference', $article->reference ?? '') }}" required>
    </div>

    <div class="col-md-8">
        <label class="form-label">Nom <span class="text-danger">*</span></label>
        <input type="text" name="nom" class="form-control"
            value="{{ old('nom', $article->nom ?? '') }}" required>
    </div>
    @if($edit && $article->image)
    <div class="mb-3">
        <p>Image actuelle :</p>
        <img src="{{ asset('storage/' . $article->image) }}" alt="Image de {{ $article->nom }}" style="max-width: 200px;">
    </div>
    @endif

    {{-- Image --}}
    <div class="col-md-6">
        <label class="form-label">Photo</label>
        <input class="form-control" type="file" name="image" id="image">
        @if (!empty($article->image))
        <img src="{{ asset('storage/'.$article->image) }}" class="img-thumbnail mt-2" style="max-height:120px">
        @endif
    </div>

    {{-- Description courte --}}
    <div class="col-md-12">
        <label class="form-label">Description courte</label>
        <textarea name="description_courte" class="form-control" rows="3">{{ old('description_courte', $article->description_courte ?? '') }}</textarea>
    </div>
    @if($edit)
    {{-- Quantité réelle dans la base --}}
    <input type="text" value="{{ $article->quantite }}" readonly>

    {{-- Quantité réelle liée (calculée à partir des stockItems) --}}
    <input type="text" value="{{ $article->stock_count }}" readonly>
    @endif


    {{-- Liste des exemplaires --}}
    @if($edit)
    <div class="col-12">
        <div class="card border-success shadow-sm mt-3">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <span>Liste des exemplaires ({{ $article->stockItems->count() }})</span>
                <a href="{{ route('articles.stock-items.create', $article) }}" class="btn btn-light btn-sm">
                    + Ajouter un exemplaire
                </a>




            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Numéro de série</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($article->stockItems as $item)
                        <tr>
                            <td>{{ $item->numero_serie }}</td>
                            <td>{{ ucfirst($item->etat) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">Aucun exemplaire enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($edit)
    <div class="col-12">
        <div class="card border-primary shadow-sm mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Liste des affectations ({{ $article->movements->count() }})</span>
                <a href="{{ route('movements.create', ['article_id' => $article->id]) }}" class="btn btn-light btn-sm">
                    + Ajouter une affectation
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Quantité</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($article->movements as $movement)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($movement->date_affectation)->format('d/m/Y') }}</td>
                            <td>{{ $movement->destination }}</td>
                            <td>{{ $movement->quantite }}</td>
                            <td>{{ $movement->description ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">Aucune affectation enregistrée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Modèle + Marque --}}
    <div class="col-md-3">
        <label class="form-label">Modèle</label>
        <input type="text" name="modele" class="form-control"
            value="{{ old('modele', $article->modele ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Marque</label>
        <input type="text" name="marque" class="form-control"
            value="{{ old('marque', $article->marque ?? '') }}">
    </div>

    {{-- Catégorie --}}
    <div class="col-md-6">
        <label class="form-label">Catégorie <span class="text-danger">*</span></label>
        <select name="categorie_id" class="form-control">
            @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}" {{ old('categorie_id', $article->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->nom }}
            </option>
            @endforeach

        </select>

    </div>

    {{-- État + Prix --}}
    <div class="col-md-3">
        <label class="form-label">État <span class="text-danger">*</span></label>
        <select name="etat" class="form-select" required>
            <option value="neuf" @selected(old('etat', $article->etat ?? '') === 'neuf')>Neuf</option>
            <option value="usagé" @selected(old('etat', $article->etat ?? '') === 'usagé')>Usagé</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Prix unitaire (DT)</label>
        <input type="number" name="prix_unitaire" step="0.001" min="0" class="form-control"
            value="{{ old('prix_unitaire', $article->prix_unitaire ?? '') }}">
    </div>

    {{-- Boutons --}}
    <div class="col-12 text-end mt-4">
        <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-check-circle me-1"></i> {{ $edit ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary px-3">Annuler</a>
        @if($edit)
        <a href="{{ route('articles.show', $article) }}" class="btn btn-outline-primary px-3">Voir</a>
        @endif
    </div>
</div>