@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Liste des Mouvements d'Affectation</h3>
        <a href="{{ route('mouvements.create') }}" class="btn btn-outline-primary">Ajouter Mouvement</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Article</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Quantité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mouvements as $mouvement)
                    <tr>
                        <td>{{ $mouvement->id }}</td>
                        <td>{{ $mouvement->article->nom }}</td>
                        <td>{{ $mouvement->destination }}</td>
                        <td>{{ $mouvement->date_affectation }}</td>
                        <td>{{ $mouvement->quantite }}</td>
                        <td>
                            <a href="{{ route('mouvements.show', $mouvement) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{ route('mouvements.edit', $mouvement) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('mouvements.destroy', $mouvement) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $mouvements->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection