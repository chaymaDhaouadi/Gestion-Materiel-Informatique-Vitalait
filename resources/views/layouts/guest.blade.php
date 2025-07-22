<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Vitalait') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e6ffe6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .auth-logo {
            display: block;
            margin: 0 auto 20px;
            max-height: 80px;
        }

        .auth-title {
            text-align: center;
            margin-bottom: 20px;
            color: #38b000;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <img src="{{ asset('images/vitalait-logo.png') }}" alt="Logo Vitalait" class="auth-logo">
        <h2 class="auth-title">{{ $title ?? 'Bienvenue chez Vitalait' }}</h2>

        <!-- Main content -->
        {{ $slot }}
    </div>

</body>
</html>
