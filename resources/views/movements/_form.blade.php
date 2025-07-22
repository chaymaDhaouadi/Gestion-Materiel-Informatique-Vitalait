<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ isset($mouvement) ? route('mouvements.update', $mouvement) : route('mouvements.store') }}" method="POST">
            @csrf
            @if(isset($mouvement))
            @method('PUT')
            @endif

            <div class="mb-3">
                <label for="article_id" class="form-label">Article</label>
                <select name="article_id" id="article_id" class="form-select" required>
                    <option value="">-- Choisir un article --</option>
                    @foreach($articles as $article)
                    <option value="{{ $article->id }}" {{ old('article_id', $mouvement->article_id ?? '') == $article->id ? 'selected' : '' }}>
                        {{ $article->nom }}
                    </option>
                    @endforeach
                </select>


            </div>
            <script>
                $('#article_id').on('change', function() {
                    const articleId = $(this).val();
                    if (!articleId) {
                        $('#stock-items').html('');
                        return;
                    }

                    $.get(`/articles/${articleId}/stock-items`, function(data) {
                        let html = '<label><strong>Numéros de série disponibles :</strong></label><div class="form-group">';
                        data.forEach(item => {
                            html += `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="stock_item_id" value="${item.id}" id="stock_${item.id}">
                        <label class="form-check-label" for="stock_${item.id}">
                            Numéro : ${item.numero_serie} – État : ${item.etat}
                        </label>
                    </div>
                `;
                        });
                        html += '</div>';
                        $('#stock-items').html(html);
                    });
                });
            </script>
            <div id="stock-items" class="mb-3">
                {{-- Le JS injectera ici les radios --}}
            </div>

            <div class="mb-3">
                <label for="destination" class="form-label">Destination</label>
                <input type="text" name="destination" class="form-control" value="{{ old('destination', $mouvement->destination ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="date_affectation" class="form-label">Date Affectation</label>
                <input type="date" name="date_affectation" class="form-control"
                    value="{{ old('date_affectation', isset($mouvement) ? $mouvement->date_affectation->format('Y-m-d') : '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="number" name="quantite" class="form-control" value="{{ old('quantite', $mouvement->quantite ?? 1) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $mouvement->description ?? '') }}</textarea>
            </div>


            <div class="d-flex justify-content-between">
                <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    {{ isset($mouvement) ? 'Modifier' : 'Enregistrer' }}
                </button>
            </div>
        </form>
    </div>
</div>