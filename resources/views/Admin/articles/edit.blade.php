{{-- resources/views/admin/articles/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 fw-bold mb-4">Modifier l’article — {{ $article->reference }}</h1>

    <form method="POST" action="{{ route('articles.update', $article) }}">
        @csrf @method('PUT')
        @include('admin.articles._form')
    </form>
</div>
@endsection
