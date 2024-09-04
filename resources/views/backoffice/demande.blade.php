<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande - {{ $data['ine'] }}</title>
    <link rel="stylesheet" href="{{ asset('css/pdf-render.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demande.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

<header>
    @include('backoffice/_navbar')
</header>

<div style="margin: 20px;">
    <div class="container">
        <h3>Détails de la demande nº{{ $data['id']  }}</h3>
        <table id="details-table" class="table">
            <tr>
                <th>Champ</th>
                <th>Valeur</th>
            </tr>
            <tr>
                <td>Statut</td>
                <td>
                    @if($data['statut'] == 'A traiter')
                        <span class="badge badge-success">A traiter</span>
                    @elseif($data['statut'] == 'En cours')
                        <span class="badge badge-warning">En cours</span>
                    @elseif($data['statut'] == 'Traité')
                        <span class="badge badge-danger">Traité</span>
                    @else
                        <span>{{ $data['statut'] }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Nom</td>
                <td>{{ $data['nom'] }}</td>
            </tr>
            <tr>
                <td>Prénom</td>
                <td>{{ $data['prenom'] }}</td>
            </tr>
            <tr>
                <td>INE</td>
                <td>{{ $data['ine'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $data['email'] }}</td>
            </tr>
            <tr>
                <td>Code Postal</td>
                <td>{{ $data['code_postal'] }}</td>
            </tr>
            <tr>
                <td>Ville</td>
                <td>{{ $data['ville'] }}</td>
            </tr>
            <tr>
                <td>Résident logement Crous</td>
                <td>{{ $data['is_in_residence'] ? 'Oui' : 'Non' }}</td>
            </tr>
            @if ($data['is_in_residence'])
            <tr>
                <td>Résidence</td>
                <td>{{ $data['residence'] }}</td>
            </tr>
            <tr>
                <td>Numéro de Chambre</td>
                <td>{{ $data['numero_chambre'] }}</td>
            </tr>
            @else
            <tr>
                <td>Adresse</td>
                <td>{{ $data['adresse'] }}</td>
            </tr>
            @endif
            <tr>
                <td>Date de création</td>
                <td>{{ \Carbon\Carbon::parse($data['created_at'])->isoFormat('DD/MM/YYYY HH:mm:ss') }}</td>
            </tr>
            <tr>
                <td>Certificat de scolarité</td>
                <td><button id="openScolaritePdf" class="openPdf btn btn-primary" data-type="scolarite">Ouvrir le PDF</button></td>
            </tr>
            <tr>
                <td>Attestation de paiement CVEC</td>
                <td><button id="openCvecPdf" class="openPdf btn btn-primary" data-type="cvec">Ouvrir le PDF</button></td>
            </tr>

        </table>
        <form action="{{ route('backoffice.updateRequestStatus', ['id' => $data['id']]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="new-status">Changer le statut :</label>
                <select id="new-status" name="status" class="form-control w-auto">
                    <option value="A traiter" {{ $data['statut'] == 'A traiter' ? 'selected' : '' }}>A traiter</option>
                    <option value="En cours" {{ $data['statut'] == 'En cours' ? 'selected' : '' }}>En cours</option>
                    <option value="Traité" {{ $data['statut'] == 'Traité' ? 'selected' : '' }}>Traité</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour le statut</button>
        </form>

        <a href="{{ route('backoffice.index') }}"><button class="btn btn-primary">Retour</button></a>
    </div>
</div>

<div class="modal-overlay" id="overlay">
    <span class="close-overlay">&times;</span>
</div>
<div class="modal" id="pdfModal">
    <iframe id="pdfIframe"></iframe>
    <button id="openInNewTabBtn" class="btn btn-primary">Ouvrir dans un nouvel onglet</button>
</div>

<script type="module" src="{{ asset('js/pdfjs-dist/build/pdf.mjs') }}"></script>
<script type="module">
    const pdfUrls = {
        'scolarite': "{{ route('assets.pdf.scolarite', ['id' => $data['id']]) }}",
        'cvec': "{{ route('assets.pdf.cvec', ['id' => $data['id']]) }}"
    };
    pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset('js/pdfjs-dist/build/pdf.worker.mjs') }}';

    async function renderPdfInIframe(pdfUrl) {
        const pdfIframe = document.getElementById('pdfIframe');
        pdfIframe.src = pdfUrl;
    }

    const openPdfLinks = document.querySelectorAll('.openPdf');

    openPdfLinks.forEach(link => {
        link.addEventListener('click', async function(event) {
            event.preventDefault();
            const type = link.dataset.type;
            const pdfUrl = pdfUrls[type];
            overlay.style.display = 'block';
            pdfModal.style.display = 'block';
            await renderPdfInIframe(pdfUrl);
        });
    });

    let lastClickedPdfType = null; // Variable pour stocker le dernier type de PDF cliqué

    openPdfLinks.forEach(link => {
        link.addEventListener('click', async function(event) {
            event.preventDefault();
            const type = link.dataset.type;
            lastClickedPdfType = type; // Enregistrer le type du PDF cliqué
            const pdfUrl = pdfUrls[type];
            overlay.style.display = 'block';
            pdfModal.style.display = 'block';
            await renderPdfInIframe(pdfUrl);
        });
    });

    const openInNewTabBtn = document.getElementById('openInNewTabBtn');
    openInNewTabBtn.addEventListener('click', function() {
        if (lastClickedPdfType) {
            const pdfUrl = pdfUrls[lastClickedPdfType]; // Utiliser le type du dernier PDF cliqué
            window.open(pdfUrl, '_blank');
        }
    });

    const overlay = document.getElementById('overlay');
    const pdfModal = document.getElementById('pdfModal');

    overlay.addEventListener('click', function() {
        overlay.style.display = 'none';
        pdfModal.style.display = 'none';
        // Pour arrêter le chargement du PDF lors de la fermeture du modal
        document.getElementById('pdfIframe').src = '';
    });
</script>

</body>
</html>
