<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nom -->
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input id="name" type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input id="email" type="email" name="email" class="form-control" required value="{{ old('email') }}">
            @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Rôle -->
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select name="role" id="role" class="form-select" required>
                <option value="" disabled selected>Choisir un rôle</option>
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
            @error('role') <div class="text-danger mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required>
            @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('login') }}">Déjà inscrit ?</a>
            <button type="submit" class="btn btn-success">Créer un compte</button>
        </div>
    </form>
</x-guest-layout>
