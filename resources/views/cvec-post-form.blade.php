<!DOCTYPE html>
<html>
<head>
    <title>Formulaire Pass CVEC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/cvec-post-form.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .navbar {
            background-size: cover;
            background-position: center;
            height: 150px; /* Hauteur de la navbar */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand img {
            max-height: 80px;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #ddd;
        }

        @media (min-width: 1025px) {
            .navbar {
                background-image: url('{{ asset('images/header-appli-cvec-1920x300.jpg') }}');
            }
        }
        @media (min-width: 576px) and (max-width: 1024px) {
            .navbar {
                background-image: url('{{ asset('images/header-appli-cvec-1024x120.jpg') }}');
            }
        }
        @media (max-width: 575px) {
            .navbar {
                background-image: url('{{ asset('images/header-appli-cvec-320x100.jpg') }}');
            }
        }

        .navbar {
            padding: 10px 20px;
        }

        .navbar-brand img {
            max-height: 80px;
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                max-height: 60px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('form') }}" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('images/Logo-Crous-V-150x150.png') }}"
                         alt="Logo Crous de Versailles"
                         class="logo img-fluid d-none d-md-block mr-3">
                    <img src="{{ asset('images/Logo-Crous-V-80x80.png') }}"
                         alt="Logo Crous de Versailles (petit)"
                         class="logo img-fluid d-md-none mr-3">
                    <img src="{{ asset('images/Votre-pass-cvec-250x150.png') }}"
                         alt="Nouveau Logo CVEC"
                         class="logo img-fluid" style="max-height: 50px;">
                </a>
            </div>

            <a href="{{ route('form') }}" class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('images/Logo-Finance-par-cvec-200x150.png') }}"
                     alt="Logo Finance CVEC"
                     class="logo img-fluid d-none d-md-block">
                <img src="{{ asset('images/Logo-finance-cvec-100-80.png') }}"
                     alt="Logo Finance CVEC (petit)"
                     class="logo img-fluid d-md-none">
            </a>
        </div>
    </nav>

    <div class="container mt-2 mb-4">
        <div class="alert alert-danger text-center alert-cvec" role="alert">
            <h2>Qu'est-ce que le Pass CVEC ?</h2>
            <p>Le Pass CVEC est un dispositif permettant aux étudiants de bénéficier de services et d'aides spécifiques après le paiement de la Contribution Vie Étudiante et de Campus (CVEC).</p>

            <h3>Conditions d'éligibilité</h3>
            <ul class="text-left">
                <li>Être inscrit dans un établissement d'enseignement supérieur</li>
                <li>Avoir payé la contribution CVEC pour l'année universitaire en cours</li>
                <li>Fournir un justificatif de scolarité valide</li>
            </ul>

            <p class="font-weight-bold">Attention : Tous les champs du formulaire sont obligatoires.</p>
        </div>
        <p>En cas de problème, consultez la rubrique <a href="{{ route('aide') }}">d'aide</a></p>
    </div>

    <div class="container mt-4 mb-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Formulaire
            </div>
            <div class="card-body">
                <form name="add-post-form" id="add-post-form" method="POST" action="{{ url('store-form') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="InputNom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" required value="{{ old('nom') }}" placeholder="Nom">
                        @error("nom")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="InputPrenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required value="{{ old('prenom') }}" placeholder="Prénom">
                        @error("prenom")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="InputINE">INE
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Votre numéro INE (Identifiant National Étudiant)"></i>
                        </label>
                        <input type="text" id="ine" name="ine" class="form-control" required value="{{ old('ine') }}" placeholder="Numéro INE">
                        @error("ine")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="InputEmail">Email
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Votre adresse email"></i>
                        </label>
                        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="exemple@email.com">
                        @error("email")
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

                    <div class="form-group" id="room-number-fields">
                        <label for="numero_chambre">Numéro de chambre
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Le numéro de chambre est nécessaire lors de l'envoi du pass"></i>
                        </label>
                        <input type="text" id="numero_chambre" name="numero_chambre" class="form-control">
                    </div>

                    <div class="form-group" id="address-fields">
                        <label for="code_postal">Code postal</label>
                        <input type="text" id="code_postal" name="code_postal" class="form-control" value="{{ old('code_postal') }}">
                        <label for="ville">Ville</label>
                        <input type="text" id="ville" name="ville" class="form-control" value="{{ old('ville') }}">
                    </div>

                    <div class="form-group">
                        <label for="InputCertificatScolarite">Certificat de scolarité
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Téléchargez votre certificat de scolarité (uniquement au format pdf)"></i>
                        </label>
                        <input type="file" name="scolarite" class="form-control" required>
                        @error("scolarite")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="cvec-upload-group" style="display: none;">
                        <label for="InputCertificatCVEC">Attestation de paiement CVEC
                            <i class="bi bi-info-circle-fill" data-toggle="tooltip" data-placement="right" title="Téléchargez votre attestation de paiement CVEC (uniquement sous format numérique en pdf)"></i>
                        </label>
                        <input type="file" name="cvec" class="form-control">
                        @error("cvec")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="newsletter" value="opt_out">
                        <label for="newsletter_subscription form-check-label">Je ne souhaite pas recevoir la newsletter du pass CVEC</label>
                    </div>
                    <p class="text-right" id="obligatoires">Tous les champs sont obligatoires</p>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer navbar navbar-expand-lg pb-4 pt-4">
        <div class="container position-relative">
            <div class="w-100 text-center position-absolute" style="left: 0; z-index: 1;">
                <a href="{{ route('mentions-legales') }}" class="nav-link font-weight-bold">Mentions légales</a>
            </div>
            
            <div class="d-flex align-items-center ml-auto">
                <a href="{{ route('form') }}" class="navbar-brand d-flex align-items-center mr-3">
                    <img src="{{ asset('images/Logo-Crous-V-150x150.png') }}" alt="Logo Crous de Versailles" class="logo img-fluid d-none d-md-block mr-3">
                    <img src="{{ asset('images/Logo-Crous-V-80x80.png') }}" alt="Logo Crous de Versailles (petit)" class="logo img-fluid d-md-none mr-3">
                </a>
                <a href="{{ route('form') }}" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('images/Logo-Finance-par-cvec-200x150.png') }}" alt="Logo Finance CVEC" class="logo img-fluid d-none d-md-block mr-3">
                    <img src="{{ asset('images/Logo-finance-cvec-100-80.png') }}" alt="Logo Finance CVEC (petit)" class="logo img-fluid d-md-none mr-3">
                </a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/cvec-post-form.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            
            // Gestion de l'affichage du champ CVEC
            $('input[name="resident_crous"]').change(function() {
                const cvecGroup = $('#cvec-upload-group');
                const cvecInput = cvecGroup.find('input[name="cvec"]');
                
                if ($(this).val() === 'non') {
                    cvecGroup.show();
                    cvecInput.prop('required', true);
                } else {
                    cvecGroup.hide();
                    cvecInput.prop('required', false);
                }
            });
        });
    </script>
</body>
</html>
