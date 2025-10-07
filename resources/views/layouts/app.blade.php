<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google / Bunny Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 5 + icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Font Awesome (facultatif) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite (['resources/js/app.js'])


    <!-- 🌈 Couleurs Vitalait en CSS pur -->
    <style>
        :root {
            --bs-primary: #0B8A3C;
            /* Vert Vitalait */
            --bs-info: #29C9E0;
            /* Bleu ciel   */
            --bs-warning: #F4A623;
            /* Jaune       */
        }

        body {
            font-family: 'Nunito', sans-serif;
        }

        /* Logo dans la barre (si tu mets un SVG/PNG) */
        .navbar-brand img {
            height: 36px;
        }

        /* Miniature pour les images dans tes tables */
        .img-thumb {
            max-height: 60px;
            border-radius: .35rem;
        }

        /* Titre de colonnes sur fond vert */
        .table thead {
            background: var(--bs-primary);
            color: #fff;
        }
    </style>
    @livewireStyles

</head>

<body>
    <div id="app">
        <!-- ===== NAVBAR Vitalait ===== -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                {{-- Si tu as un logo, décommente la ligne suivante et place logo‑vitalait.svg dans public/images --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/vitalait-logo.png') }}" alt="Logo Vitalait">
                </a>
                <a class="navbar-brand" href="{{ url('/') }}">Gestion Matériel</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Menu gauche (vide pour l’instant) -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Menu droite -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                        @if(Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        @endif
                        @if(Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Créer un compte</a>
                        </li>
                        @endif
                        @else
                        <li><a class="nav-link" href="{{ route('users.index') }}">Utilisateurs</a></li>
                        <li><a class="nav-link" href="{{ route('roles.index') }}">Rôles</a></li>
                        <li><a class="nav-link" href="{{ route('articles.index') }}">Articles</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('affectations.index') }}">Affectations</a>
                        </li>


                        <!-- Profil / Logout -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle"
                                href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- ===== CONTENU PRINCIPAL ===== -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- ===== JS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap JS -->
    @yield('scripts')

    @stack('scripts') {{-- scripts injectés depuis les vues --}}
    @livewireScripts
    <footer class="bg-dark text-white text-center text-lg-start border-top mt-4">
        <div class="text-center p-3">
            © {{ date('Y') }} Vitalait - Tous droits réservés.
            <span class="ms-2">Développé par <strong>Chayma Dhaouadi</strong> 💻</span>
        </div>
    </footer>

</body>

</html>