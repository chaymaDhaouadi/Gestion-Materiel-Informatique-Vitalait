@extends('layouts.app')

@section('content')
    <h2 class="mb-4 text-primary">Bienvenue, {{ Auth::user()->name }}</h2>

    @livewire('dashboard-stats')
@endsection
