@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Historique des affectations</h2>

    @if($affectations->isEmpty())
    <p>Aucune affectation trouvée.</p>
    @else
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Article</th>
                <th>N° Série</th>
                <th>Date Affectation</th>
                <th>Quantité</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($affectations as $affectation)
            <tr>
                <td>{{ $affectation->employe->nom ?? '-' }}</td>
                <td>{{ $affectation->article->nom ?? '-' }}</td>
                <td>{{ $affectation->stockItem->numero_serie ?? '-' }}</td>
                <td>{{ $affectation->date_affectation }}</td>
                <td>{{ $affectation->quantite }}</td>
                <td>{{ $affectation->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection