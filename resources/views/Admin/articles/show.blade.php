@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="h4 fw-bold mb-4 text-success">Fiche article</h1>

    <div class="card shadow-sm mb-4">
        <div class="row g-0">
            {{-- Image à gauche --}}
            <div class="col-md-4 text-center p-3">
                @if($article->image)
                <img src="{{ asset('storage/'.$article->image) }}" alt="Image {{ $article->nom }}" class="img-fluid rounded" style="max-height: 240px; object-fit: contain;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 240px;">
                    <span class="text-muted">Pas d'image</span>
                </div>
                @endif
            </div>

            {{-- Détails à droite --}}
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $article->nom }}</h2>

                    <p><strong>Catégorie :</strong> {{ $article->categorie->nom ?? '—' }}</p>
                    <p><strong>Référence :</strong> {{ $article->reference }}</p>
                    <p><strong>Modèle :</strong> {{ $article->modele ?? '—' }}</p>
                    <p><strong>Marque :</strong> {{ $article->marque ?? '—' }}</p>
                    <p><strong>Prix unitaire :</strong>
                        @if($article->prix_unitaire !== null)
                        {{ number_format($article->prix_unitaire, 3, ',', ' ') }} DT
                        @else
                        —
                        @endif
                    </p>
                    <p><strong>Quantité actuelle :</strong> {{ $article->stock_count }}</p>

                    @php
                    $badgeClass = match($article->etat) {
                    'disponible' => 'success',
                    'en panne' => 'danger',
                    default => 'secondary',
                    };
                    @endphp

                    <p><strong>État :</strong>
                        <span class="badge bg-{{ $badgeClass }}">
                            {{ ucfirst($article->etat ?? 'Non défini') }}
                        </span>
                    </p>


                    <p><strong>Description courte :</strong></p>
                    <p class="text-muted">{{ $article->description_courte ?? 'Aucune description' }}</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3 fw-semibold">Liste des exemplaires</h5>
    <div class="table-responsive rounded shadow-sm mb-4">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Numéro de série</th>
                    <th>État</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($article->stockItems as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->numero_serie }}</td>
                    <td>{{ ucfirst($item->etat) }}</td>
                    <td>
                        <form action="{{ route('articles.stock-items.destroy', [$article, $item]) }}" method="POST" onsubmit="return confirm('Supprimer cet exemplaire ?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit" title="Supprimer">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">Aucun exemplaire enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <h5 class="mb-3 fw-semibold text-primary">📊 Statistiques de l'article</h5>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-info">Nombre total d’affectations</h6>
                    <p class="fs-4 fw-bold">{{ $article->affectations->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-success">Quantité totale affectée</h6>
                    <p class="fs-4 fw-bold">{{ $article->affectations->sum('quantite') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-warning">Quantité restante en stock</h6>
                    <p class="fs-4 fw-bold">{{ $quantite }}</p>
                </div>
            </div>
        </div>
    </div>

    <h5>Historique des affectations</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Destination</th>
                <th>Quantité</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($article->affectations as $affectation)
            <tr>
                <td>{{ $affectation->created_at->format('d/m/Y') }}</td>
                <td>{{ $affectation->destination ?? '-' }}</td>
                <td>{{ $affectation->quantite }}</td>
                <td>
                    {{ $affectation->description ?? "Effectué par " . ($affectation->employe->nom_complet ?? 'Employé inconnu') }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Aucune affectation enregistrée.</td>
            </tr>
            @endforelse

        </tbody>
    </table>

    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
</div>
@endsection