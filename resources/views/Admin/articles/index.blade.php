{{-- resources/views/admin/articles/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold text-success">Liste du matériel</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Ajouter un article
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive shadow-sm rounded-4 bg-white p-3">
        <table id="articlesTable" class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="align-middle">
                    <th>#</th>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Disponibles</th>
                    <th>En Panne</th>
                    <th>Total</th>
                    <th>État</th> <!-- ✅ AJOUT -->

                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $article->reference }}</td>
                    <td>{{ $article->nom }}</td>

                    <td>
                        @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="Image de {{ $article->nom }}" style="max-width: 150px;">
                        @else
                        <p>Aucune image</p>
                        @endif
                    </td>

                    <td>{{ \Illuminate\Support\Str::limit($article->description_courte, 50) }}</td>
                    <td>{{ $article->categorie->nom ?? '—' }}</td>
                    <td>{{ $article->stockItems->where('etat', 'disponible')->count() }}</td>
                    <td>{{ $article->stockItems->where('etat', 'en panne')->count() }}</td>
                    <td>{{ $article->stockItems->count() }}</td>
                    <td>
                        <span class="badge bg-{{ $article->etat === 'neuf' ? 'success' : 'secondary' }}">
                            {{ ucfirst($article->etat) }}
                        </span>
                    </td>


                    <td class="text-end">
                        {{-- Voir --}}
                        <a href="{{ route('articles.show', $article) }}"
                            class="btn btn-sm text-white me-1"
                            style="background-color: #0B8A3C;" title="Voir">
                            <i class="bi bi-eye"></i>
                        </a>

                        {{-- Modifier --}}
                        <a href="{{ route('articles.edit', $article) }}"
                            class="btn btn-sm text-white me-1"
                            style="background-color: #F4A623;" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>

                        {{-- Supprimer --}}
                        <form action="{{ route('articles.destroy', $article) }}"
                            method="POST" class="d-inline delete-form" title="Supprimer">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        $('#articlesTable').DataTable({
            order: [
                [0, 'asc']
            ],
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
            },
            columnDefs: [{
                targets: [3, 10],
                orderable: false
            }]
        });

        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Supprimer ?',
                text: 'Cette action est irréversible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
@endpush