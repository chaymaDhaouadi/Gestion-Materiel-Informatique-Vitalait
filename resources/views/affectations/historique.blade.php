@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Historique des Affectations</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Article</th>
                <th>Employé</th>
                <th>N° Série</th>
                <th>Date Affectation</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($affectations as $aff)
            <tr>
                <td>{{ $aff->article->nom }}</td>
                <td>{{ $aff->employe->nom_complet }}</td>
                <td>{{ $aff->stockItem->numero_serie ?? '-' }}</td>
                <td>{{ $aff->date_affectation }}</td>
                <td>
                    <span class="badge bg-{{ $aff->active ? 'success' : 'secondary' }}">
                        {{ $aff->active ? 'Active' : 'Historique' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection