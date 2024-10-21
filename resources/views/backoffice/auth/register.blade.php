<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Backoffice Crous de Versailles</title>
    <style>
        @font-face {
            font-family: 'Marianne';
            src: url('../fonts/Marianne/Marianne/fontes\ web/Marianne-Regular.woff') format('woff');
        }

        body {
            font-family: 'Marianne', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 0.5rem;
            color: #1e1e1e;
        }
        input {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Marianne', sans-serif;
        }
        button {
            background-color: #dc3545;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Marianne', sans-serif;
            font-weight: 600;
        }
        button:hover {
            background-color: #dc3545;
        }
        .error {
            color: #ff0000;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Inscription Backoffice</h1>
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('backoffice.register') }}">
            @csrf
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" required autofocus>

            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
