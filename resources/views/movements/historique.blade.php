@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Historique des Affectations</h3>
        <a href="{{ route('affectations.index') }}" class="btn btn-outline-secondary">
            Retour aux affectations actives
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Employé</th>
                        <th>Article</th>
                        <th>N° Série</th>
                        <th>Date Affectation</th>
                        <th>Quantité</th>
                        <th>Description</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($affectations as $aff)
                    <tr>
                        <td>{{ $aff->id }}</td>
                        <td>{{ $aff->employe->nom_complet ?? '—' }}</td>
                        <td>{{ $aff->article->nom ?? '—' }}</td>
                        <td>{{ $aff->stockItem->numero_serie ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($aff->date_affectation)->format('d/m/Y') }}</td>
                        <td>{{ $aff->quantite }}</td>
                        <td>{{ $aff->description ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $aff->active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $aff->active ? 'Active' : 'Archivée' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Aucune affectation trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection