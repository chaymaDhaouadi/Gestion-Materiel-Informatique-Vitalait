@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des employés</h2>
    <a href="{{ route('employes.create') }}" class="btn btn-primary mb-3">Ajouter un employé</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom Complet</th>
                <th>Matricule</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employes as $employe)
            <tr>
                <td>{{ $employe->nom_complet }}</td>
                <td>{{ $employe->matricule }}</td>
                <td>{{ $employe->contact }}</td>
                <td>
                    <a href="{{ route('employes.edit', $employe) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('employes.destroy', $employe) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection