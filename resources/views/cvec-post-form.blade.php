<!DOCTYPE html>
<html>
<head>
    <title>Formulaire Pass CVEC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/cvec-post-form.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a href="{{ route('form') }}" class="navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Crous de Versailles" class="logo img-fluid">
        <h1 class="navbar-brand">Pass CVEC</h1>
        </a>
    </nav>

    <div class="container mt-4 mb-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <p><a href="{{ route('aide') }}">Aide</a></p>
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Formulaire Pass CVEC
            </div>
            <div class="card-body">
                <form name="add-post-form" id="add-post-form" method="POST" action="{{ url('store-form') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Nom -->
                    <div class="form-group">
                        <label for="InputNom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" required value="{{ old('nom') }}" placeholder="Nom">
                        @error("nom")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="form-group">
                        <label for="InputPrenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required value="{{ old('prenom') }}" placeholder="Prénom">
                        @error("prenom")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- INE -->
                    <div class="form-group">
                        <label for="InputINE">INE
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Votre numéro INE (Identifiant National Étudiant)"></i>
                        </label>
                        <input type="text" id="ine" name="ine" class="form-control" required value="{{ old('ine') }}" placeholder="Numéro INE">
                        @error("ine")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="InputEmail">Email
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Votre adresse email"></i>
                        </label>
                        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="exemple@email.com">
                        @error("email")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Résidence Crous -->
                    <div class="form-group" id="residence-radio">
                        <label for="resident_crous">Êtes-vous en résidence Crous ?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resident_crous" id="resident_crous_oui" value="oui" autocomplete="off" required>
                            <label class="form-check-label" for="resident_crous_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resident_crous" id="resident_crous_non" value="non" autocomplete="off" required>
                            <label class="form-check-label" for="resident_crous_non">Non</label>
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="form-group" id="adresse-div">
                        <label for="InputAdresse">Adresse
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Votre adresse postale"></i>
                        </label>
                        <input type="text" id="adresse" name="adresse" class="form-control" placeholder="10 Rue de l'Exemple">
                        @error("adresse")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" id="is_in_residence" name="is_in_residence" value="true">

                    <!-- Sélection de la résidence -->
                    <div class="form-group" id="div-logements">
                        <label for="residence">Résidence
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Sélectionnez votre résidence"></i>
                        </label>
                        <select name="residence" id="residence" class="form-control custom-select" onchange="disablePlaceholderOption()">
                            <option disabled selected hidden>Sélectionnez une résidence</option>
                            @foreach ($logements as $logement)
                                <option value="{{ $logement['title'] }}">{{ $logement['title'] }}@if(!empty($logement['short_desc'])) - {{ $logement['short_desc'] }}@endif</option>
                            @endforeach
                        </select>
                        @error("logement")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Numéro de chambre -->
                    <div class="form-group" id="room-number-fields">
                        <label for="numero_chambre">Numéro de chambre
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Le numéro de chambre est nécessaire lors de l'envoi du pass"></i>
                        </label>
                        <input type="text" id="numero_chambre" name="numero_chambre" class="form-control">
                    </div>


                    <!-- Complément d'adresse -->
                    <div class="form-group" id="address-fields">
                        <label for="code_postal">Code postal</label>
                        <input type="text" id="code_postal" name="code_postal" class="form-control" value="{{ old('code_postal') }}">
                        <label for="ville">Ville</label>
                        <input type="text" id="ville" name="ville" class="form-control" value="{{ old('ville') }}">
                    </div>


                    <!-- Certificat de scolarité -->
                    <div class="form-group">
                        <label for="InputCertificatScolarite">Certificat de scolarité
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Téléchargez votre certificat de scolarité"></i>
                        </label>
                        <input type="file" name="scolarite" class="form-control" required>
                        @error("scolarite")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Attestation de paiement CVEC -->
                    <div class="form-group">
                        <label for="InputCertificatCVEC">Attestation de paiement CVEC
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Téléchargez votre attestation de paiement CVEC"></i>
                        </label>
                        <input type="file" name="cvec" class="form-control" required>
                        @error("cvec")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Newsletter -->
                    <div class="form-group form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="newsletter" value="">
                        <label for="newsletter_subscription form-check-label">Je souhaite recevoir la newsletter du pass CVEC</label>
                    </div>
                    <p class="text-right" id="obligatoires">Tous les champs sont obligatoires</p>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer navbar navbar-expand-lg pb-4 pt-4">
        <div class="mx-auto">
            <a href="{{ route('mentions-legales') }}" class="nav-link">Mentions légales</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/cvec-post-form.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>
