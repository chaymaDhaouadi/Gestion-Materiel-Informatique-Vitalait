@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'Employé</h2>

    <form action="{{ route('employes.update', $employe) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nom Complet</label>
            <input type="text" name="nom_complet" value="{{ $employe->nom_complet }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Matricule</label>
            <input type="text" name="matricule" value="{{ $employe->matricule }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" value="{{ $employe->contact }}" class="form-control" required>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection