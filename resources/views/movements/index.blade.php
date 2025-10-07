@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Liste des Affectations</h3>
        <a href="{{ route('affectations.create') }}" class="btn btn-outline-primary">Nouvelle Affectation</a>
    </div>

    <a href="{{ route('affectations.historique') }}" class="btn btn-outline-dark mb-3">Voir l'historique complet</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Employé</th>
                        <th>N° Série</th>
                        <th>Date Affectation</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($affectations as $aff)
                    <tr>
                        <td>{{ $aff->article->nom }}</td>
                        <td>{{ $aff->employe->nom_complet }}</td>
                        <td>{{ $aff->stockItem->numero_serie ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($aff->date_affectation)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $aff->active ? 'success' : 'secondary' }}">
                                {{ $aff->active ? 'Active' : 'Historique' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('affectations.edit', $aff->id) }}" class="btn btn-sm btn-warning">Modifier</a>

                            <form action="{{ route('affectations.destroy', $aff->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?')">
                                    Supprimer
                                </button>
                            </form>

                            <a href="{{ route('affectations.show', $aff->id) }}" class="btn btn-sm btn-info">Consulter</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune affectation trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection