{{-- resources/views/admin/approvals/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="h4 fw-bold mb-4">
        <i class="bi bi-person-check-fill text-success me-1"></i>
        Utilisateurs en attente d’approbation
    </h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <div class="table-responsive shadow-sm rounded bg-white border">
        <table class="table align-middle table-hover mb-0">
            <thead class="table-success text-nowrap">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th class="text-center" style="width:140px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-success-subtle text-success px-2">
                            <i class="bi bi-person-badge me-1"></i>{{ $user->role }}
                        </span>
                    </td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('admin.approuver', $user->id) }}">
                            @csrf
                            <button class="btn btn-outline-success btn-sm">
                                <i class="bi bi-check-circle me-1"></i> Approuver
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-person-dash"></i> Aucun utilisateur en attente.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Notification SweetAlert (facultative) --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: "{{ session('success') }}", // ✅ guillemets doubles ici
        confirmButtonColor: '#0B8A3C'
    });
</script>

@endif

{{-- SweetAlert2 (si pas déjà inclus dans ton layout) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection