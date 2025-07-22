{{-- resources/views/admin/articles/create.blade.php --}}
@extends('layouts.app')

@section('content')
{{-- … bloc erreurs … --}}
<div class="container py-4">
    <h1 class="h4 fw-bold mb-4">Ajouter un article</h1>

    <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
        @csrf
        {{-- on passe article=null à la vue incluse ▶️ --}}
        @include('admin.articles._form', ['article' => null])
    </form>
</div>
@endsection