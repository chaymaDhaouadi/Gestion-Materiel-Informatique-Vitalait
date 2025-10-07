@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Détails de l'affectation</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Article : <strong>{{ $affectation->article->nom }}</strong></h5>

            <p class="mb-2">
                <strong>Employé :</strong> {{ $affectation->employe->nom_complet }}
            </p>

            <p class="mb-2">
                <strong>N° de série :</strong> {{ $affectation->stockItem->numero_serie ?? '-' }}
            </p>

            <p class="mb-2">
                <strong>Date d'affectation :</strong> {{ $affectation->date_affectation }}
            </p>

            <p class="mb-2">
                <strong>Statut :</strong>
                <span class="badge bg-{{ $affectation->active ? 'success' : 'secondary' }}">
                    {{ $affectation->active ? 'Active' : 'Historique' }}
                </span>
            </p>

            @if($affectation->description)
            <p class="mb-2">
                <strong>Description :</strong> {{ $affectation->description }}
            </p>
            @endif
        </div>
    </div>

    <a href="{{ route('affectations.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection