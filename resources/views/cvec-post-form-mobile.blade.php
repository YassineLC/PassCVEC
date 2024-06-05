<!DOCTYPE html>
<html>
<head>
    <title>Formulaire Pass CVEC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.1, maximum-scale=1.1, user-scalable=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/cvec-post-form.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <style>
        body {
            font-size: 1.1rem;
        }
        .form-control {
            font-size: 1.1rem;
        }
        .card-header {
            font-size: 1.3rem;
        }
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-4" style="max-width: 600px;">
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
                <form name="add-post-form" id="add-post-form" method="POST" action="{{url('store-form')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="InputNom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" required value ="{{ old('nom') }}" placeholder="Nom">
                        @error("nom")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="InputPrenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required value ="{{ old('prenom') }}" placeholder="Prénom">
                        @error("prenom")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="InputINE">INE</label>
                        <input type="text" id="ine" name="ine" class="form-control" required value ="{{ old('ine') }}" placeholder="Numéro INE">
                        @error("ine")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Mail</label>
                        <input type="email" id="email" name="email" class="form-control" required value ="{{ old('email') }}" placeholder="exemple@email.com">
                        @error("email")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="InputAdresse">Adresse</label>
                        <input type="text" name="adresse" class="form-control" required value ="{{ old('adresse') }}" placeholder="10 Rue de l'Exemple">
                        @error("adresse")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
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
                    <input type="hidden" id="is_in_residence" name="is_in_residence" value="true">
                    <div class="form-group" id="div-logements">
                        <label for="residence">Résidence</label>
                        <select name="residence" id="residence" class="form-control" required onchange="disablePlaceholderOption()">
                            <option disabled selected hidden>Sélectionnez une résidence</option>
                            @foreach ($logements as $logement)
                            <option value="{{ $logement['title'] /* $logement['id'] */ }}">
                                {{ $logement['title'] }} @if(!empty($logement['short_desc'])) - {{ $logement['short_desc'] }} @endif
                            </option>
                            @endforeach
                        </select>
                        @error("logement")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="InputCertificatScolarite">Certificat de scolarité</label>
                        <input type="file" name="scolarite" class="form-control" required>
                        @error("scolarite")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="InputCertificatCVEC">Attestation de paiement CVEC</label>
                        <input type="file" name="cvec" class="form-control" required>
                        @error("cvec")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="text-right" id="obligatoires">Tous les champs sont obligatoires</p>
                    <button type="submit" class="btn btn-primary btn-block">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/cvec-post-form.js') }}"></script>
</body>
</html>
