@extends('layouts.app')

@section('content')
<h1>Ajouter un exemplaire pour {{ $article->nom }}</h1>

<x-errors />

<form method="POST"
    action="{{ route('articles.stock-items.store', $article) }}">
    @csrf
    <div>
        <label>N° de série</label>
        <input name="numero_serie" class="form-control" required>
    </div>

    <div>
        <label for="etat">État</label>
        <select name="etat" id="etat" class="form-control" required>
            <option value="">-- Choisir l'état --</option>
            <option value="disponible">Disponible</option>
            <option value="en panne">En panne</option>
        </select>


    </div>

    <button class="btn btn-primary mt-3">Enregistrer</button>
</form>
@endsection