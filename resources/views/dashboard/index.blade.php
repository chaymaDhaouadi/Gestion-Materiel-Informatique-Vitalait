@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <p>Total articles: {{ $totalArticles }}</p>
    <p>Disponibles: {{ $availableCount }}</p>
    <p>Affectés: {{ $assignedCount }}</p>
    <p>En panne: {{ $brokenCount }}</p>
    <p>Total stock: {{ $totalStock }}</p>

    <h2>Top Articles par stock</h2>
    <ul>
        @foreach ($topLabels as $key => $label)
        <li>{{ $label }} : {{ $topQuantities[$key] }}</li>
        @endforeach
    </ul>
</div>
@livewire('dashboard-stats')

@endsection