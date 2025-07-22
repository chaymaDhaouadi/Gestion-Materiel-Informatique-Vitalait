@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="text-primary">Détail Mouvement #{{ $mouvement->id }}</h3>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <p><strong>Article :</strong> {{ $mouvement->article->nom }}</p>
            <p><strong>Destination :</strong> {{ $mouvement->destination }}</p>
            <p><strong>Date Affectation :</strong> {{ $mouvement->date_affectation }}</p>
            <p><strong>Quantité :</strong> {{ $mouvement->quantite }}</p>
            <p><strong>Description :</strong> {{ $mouvement->description }}</p>

            <a href="{{ route('mouvements.edit', $mouvement) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection