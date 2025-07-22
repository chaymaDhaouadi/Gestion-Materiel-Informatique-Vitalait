@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un Employé</h2>

    <form action="{{ route('employes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nom Complet</label>
            <input type="text" name="nom_complet" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Matricule</label>
            <input type="text" name="matricule" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" required>
        </div>

        <button class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection