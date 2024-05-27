<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Critères d'éligibilité au Pass CVEC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset("css/aide.css") }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body>
    <header class="bg-danger text-white p-4">
        <div class="container">
            <h1>Critères d'éligibilité au Pass CVEC</h1>
        </div>
    </header>
    <main class="container mt-5">
        <section>
            <h2>Éligibilité</h2>
            <p>Le Pass CVEC du Crous de Versailles est <b>uniquement à destination de tous les étudiants du supérieur inscrits sur l’académie de Versailles et assujettis à la CVEC sur l’académie de Versailles (l’attestation CVEC doit commencer par VER).</b> Si ce n’est pas le cas, nous ne pouvons pas vous envoyer de Pass.</p>
            <p>De ce fait, les lycéens et étudiants en BTS inscrits dans un lycée ne sont pas assujettis à la CVEC et ne peuvent pas en bénéficier. Un étudiant en BTS inscrit dans un établissement du supérieur est assujetti à la CVEC et peut en obtenir un.</p>
            <p><b><i>Une seule dérogation existe en dehors de ces critères.</i></b> Tous les étudiants logés au sein d’une des résidences du Crous de Versailles peuvent se voir attribuer un Pass CVEC quel que soit leur lieu d’étude.</p>
        </section>
        <section>
            <h2>Contact</h2>
            <p>Pour tous cas particuliers, vous pouvez nous contacter à l'adresse : <a href="mailto:culture@crous-versailles.fr">culture@crous-versailles.fr</a></p>
        </section>
        <a href="{{ url()->previous() }}"><button class="btn btn-danger">Retour</button></a>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
