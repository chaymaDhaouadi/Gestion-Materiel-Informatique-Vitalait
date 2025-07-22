<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue chez Vitalait</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e6ffe6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background-color:rgb(252, 253, 253);
            padding: 1rem 2rem;
            border-bottom: 3px solid #2ecc71;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 60px;
        }

        .header h1 {
            flex: 1;
            text-align: center;
            margin: 0;
            color: #2d6a4f;
            font-weight: bold;
        }

        .auth-buttons a {
            margin-left: 10px;
        }

        .container {
            margin-top: 5rem;
            text-align: center;
        }

        .btn-success {
            background-color: #38b000;
            border: none;
        }

        .btn-success:hover {
            background-color:rgb(230, 238, 234);
        }
    </style>
</head>
<body>

    <!-- Header avec logo, titre et boutons -->
    <div class="header">
        <!-- Logo -->
        <img src="{{ asset('images/vitalait-logo.png') }}" alt="Logo Vitalait">

        <!-- Titre -->
        <h1>Bienvenue chez Vitalait</h1>

        <!-- Boutons -->
        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn btn-outline-success">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary">Créer un compte</a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <p class="lead">Système de gestion du matériel de la société Vitalait.</p>
    </div>

</body>
</html>
