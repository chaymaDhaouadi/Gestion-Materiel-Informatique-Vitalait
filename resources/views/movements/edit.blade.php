@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Modifier l'affectation</h3>

    <form action="{{ route('affectations.update', $affectation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="employe_id">Nouvel employé</label>
            <select name="employe_id" class="form-select" required>
                @foreach($employes as $employe)
                <option value="{{ $employe->id }}" {{ $affectation->employe_id == $employe->id ? 'selected' : '' }}>
                    {{ $employe->nom_complet }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
@endsection