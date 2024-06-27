<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de votre demande Pass CVEC</title>
</head>
<body>
    <h1>Bonjour {{ $data['prenom'] }} {{ $data['nom'] }},</h1>
    <p>Nous avons bien reçu votre demande de Pass CVEC.</p>
    <p>Voici les informations que vous avez fournies :</p>
    <ul>
        <li>Nom : {{ $data['nom'] }}</li>
        <li>Prénom : {{ $data['prenom'] }}</li>
        <li>INE : {{ $data['ine'] }}</li>
        <li>Email : {{ $data['email'] }}</li>
        @if($data['is_in_residence'])
            <li>Résidence : {{ $data['residence'] }}</li>
            <li>Numéro de chambre : {{ $data['numero_chambre'] }}</li>
        @else
            <li>Adresse : {{ $data['adresse'] }}</li>
            <li>Code postal : {{ $data['code_postal'] }}</li>
            <li>Ville : {{ $data['ville'] }}</li>
        @endif
    </ul>
    <p>Nous traiterons votre demande dans les plus brefs délais.</p>
    <p>Merci,</p>
    <p>L'équipe Pass CVEC</p>
</body>
</html>
