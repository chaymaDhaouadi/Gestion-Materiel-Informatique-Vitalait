<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   class="form-control"
                   required
                   value="{{ old('email') }}">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password"
                   type="password"
                   name="password"
                   class="form-control"
                   required>
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember -->
        <div class="mb-3 form-check">
            <input type="checkbox"
                   name="remember"
                   id="remember"
                   class="form-check-input">
            <label for="remember" class="form-check-label">Se souvenir de moi</label>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Mot de passe oublié&nbsp;?</a>
            @endif
            <button type="submit" class="btn btn-success">Se connecter</button>
        </div>
    </form>

    <!-- ✨ Nouveau bloc d’inscription -->
    <div class="text-center mt-4">
        <span class="me-2">Pas encore de compte&nbsp;?</span>
        <a href="{{ route('register') }}" class="btn btn-outline-primary">
            S’inscrire
        </a>
        {{-- Si tu préfères un simple lien au lieu d'un bouton : --}}
        {{-- <a href="{{ route('register') }}">Créer un compte</a> --}}
    </div>
</x-guest-layout>
