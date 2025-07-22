@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Affecter un article à un employé</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('affectations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="employe_id" class="form-label">Employé</label>
            <select name="employe_id" id="employe_id" class="form-control" required>
                <option value="" disabled selected>---Choisir un employé---</option>
                @foreach($employes as $emp)
                <option value="{{ $emp->id }}" {{ old('employe_id') == $emp->id ? 'selected' : '' }}>
                    {{ $emp->nom_complet}}
                </option>
                @endforeach
            </select>
        </div>

        @if($articles->isEmpty())
        <div class="alert alert-warning">
            Aucun article disponible à affecter pour le moment.
        </div>
        @else
        <div class="mb-3">
            <label for="article_id" class="form-label">Article</label>
            <select name="article_id" id="article_id" class="form-control" required>
                <option value="">-- Choisir un article --</option>
                @foreach($articles as $article)
                <option value="{{ $article->id }}">{{ $article->nom }}</option>
                @endforeach
            </select>
        </div>



        @endif



        <div id="stock-items-container" class="mt-3">
            <!-- Les boutons radio seront injectés ici -->
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $('#article_id').on('change', function() {
                var articleId = $(this).val();

                if (articleId) {
                    $.ajax({
                        url: '/articles/' + articleId + '/stock-items',
                        type: 'GET',
                        success: function(stockItems) {
                            var html = '';
                            if (stockItems.length === 0) {
                                html = '<p>Aucun numéro de série disponible.</p>';
                            } else {
                                stockItems.forEach(function(item, index) {
                                    html += `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="stock_item_id" id="stock_item_${item.id}" value="${item.id}" required>
                                    <label class="form-check-label" for="stock_item_${item.id}">
                                        N° Série: ${item.numero_serie} - État: ${item.etat}
                                    </label>
                                </div>
                            `;
                                });
                            }

                            $('#stock-items-container').html(html);
                        },
                        error: function() {
                            $('#stock-items-container').html('<p>Erreur lors du chargement.</p>');
                        }
                    });
                } else {
                    $('#stock-items-container').html('');
                }
            });
            $(document).ready(function() {
                $('#article_id').trigger('change');
            });
        </script>





        <div class="mb-3">
            <label for="date_affectation" class="form-label">Date d'affectation</label>
            <input type="date" name="date_affectation" id="date_affectation" class="form-control" value="{{ old('date_affectation', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" name="quantite" id="quantite" class="form-control" min="1" value="{{ old('quantite', 1) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optionnel)</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Affecter</button>
    </form>
</div>



@endsection