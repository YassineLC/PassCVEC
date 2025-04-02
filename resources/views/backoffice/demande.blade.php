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
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: none;
        }
        
        .pdf-modal {
            position: fixed;
            top: 5%;
            left: 5%;
            right: 5%;
            bottom: 5%;
            background-color: white;
            z-index: 1001;
            display: none;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
        }
        
        .pdf-modal-header {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .pdf-modal-title {
            margin: 0;
            font-size: 1.25rem;
        }
        
        .pdf-modal-body {
            flex: 1;
            padding: 15px;
            overflow-y: auto; /* Permet le défilement vertical */
            background-color: #f8f9fa;
        }
        
        .pdf-modal-footer {
            padding: 15px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
        }
        
        .close-overlay {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 28px;
            color: white;
            cursor: pointer;
        }
        
        #pdfViewer canvas {
            margin: 0 auto 15px auto !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            height: auto;
        }
    </style>
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
                <td>
                    @if($has_scolarite)
                        <button id="openScolaritePdf" class="openPdf btn btn-primary" data-type="scolarite">Ouvrir le PDF</button>
                    @else
                        <span class="text-muted">Non disponible</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Attestation de paiement CVEC</td>
                <td>
                    @if($needs_cvec)
                        @if($has_cvec)
                            <button id="openCvecPdf" class="openPdf btn btn-primary" data-type="cvec">Ouvrir le PDF</button>
                        @else
                            <span class="text-muted">Non disponible</span>
                        @endif
                    @else
                        <span class="text-muted">Non requis (résident)</span>
                    @endif
                </td>
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
            <button type="submit" class="btn btn-primary update-button">Mettre à jour le statut</button>
        </form>

        <a href="{{ route('backoffice.index') }}"><button class="btn btn-primary">Retour</button></a>
    </div>
</div>

<div class="modal-overlay" id="overlay">
    <span class="close-overlay">&times;</span>
</div>

<div class="pdf-modal" id="pdfModal">
    <div class="pdf-modal-header">
        <h5 class="pdf-modal-title" id="pdfTitle">Visualisation du document</h5>
        <button type="button" class="close-btn" id="closeModalBtn">&times;</button>
    </div>
    <div class="pdf-modal-body">
        <div id="pdfViewer"></div>
    </div>
    <div class="pdf-modal-footer">
        <button id="openInNewTabBtn" class="btn btn-primary">Ouvrir dans un nouvel onglet</button>
        <button id="closePdfBtn" class="btn btn-secondary">Fermer</button>
    </div>
</div>

<script type="module">
    import * as pdfjsLib from '{{ asset('js/pdfjs-dist/build/pdf.mjs') }}';
    
    pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset('js/pdfjs-dist/build/pdf.worker.mjs') }}';
    
    // Définir les URLs pour les PDFs
    const pdfUrls = {};
    const pdfTitles = {};
    
    @if($has_scolarite)
    pdfUrls.scolarite = "{{ route('backoffice.assets.pdf.scolarite', ['id' => $data->id]) }}";
    pdfTitles.scolarite = "Certificat de scolarité";
    @endif
    
    @if($needs_cvec && $has_cvec)
    pdfUrls.cvec = "{{ route('backoffice.assets.pdf.cvec', ['id' => $data->id]) }}";
    pdfTitles.cvec = "Attestation de paiement CVEC";
    @endif
    
    let currentPdfDocument = null;
    let lastClickedPdfType = null;
    
    // Fonction pour rendre le PDF avec PDF.js
    async function renderPdfWithPdfjs(pdfUrl, pdfType) {
        const container = document.getElementById('pdfViewer');
        const pdfTitle = document.getElementById('pdfTitle');
        
        // Mettre à jour le titre du modal
        pdfTitle.textContent = pdfTitles[pdfType] || "Visualisation du document";
        
        container.innerHTML = '';
        
        try {
            // Afficher un message de chargement
            container.innerHTML = '<div class="text-center p-5"><div class="spinner-border" role="status"></div><p class="mt-2">Chargement du PDF...</p></div>';
            
            // Charger le document PDF
            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            currentPdfDocument = await loadingTask.promise;
            
            // Vider le conteneur après le chargement
            container.innerHTML = '';
            
            // Afficher chaque page du PDF
            for (let pageNum = 1; pageNum <= currentPdfDocument.numPages; pageNum++) {
                const page = await currentPdfDocument.getPage(pageNum);
                
                // Créer un canvas pour la page
                // Utiliser une échelle plus grande pour une meilleure qualité
                const scale = 1.8;
                const viewport = page.getViewport({ scale: scale });
                const canvas = document.createElement('canvas');
                canvas.style.display = 'block';
                canvas.style.margin = '10px auto';
                canvas.style.border = '1px solid #ddd';
                container.appendChild(canvas);
                
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                
                // Rendre la page dans le canvas
                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;
                
                // Ajouter un peu d'espace entre les pages
                if (pageNum < currentPdfDocument.numPages) {
                    const spacer = document.createElement('div');
                    spacer.style.height = '20px';
                    container.appendChild(spacer);
                }
            }
        } catch (error) {
            console.error('Erreur lors du chargement du PDF:', error);
            container.innerHTML = `<div class="alert alert-danger">Erreur lors du chargement du PDF: ${error.message}</div>`;
        }
    }
    
    // Gestionnaires d'événements pour les boutons
    const openPdfLinks = document.querySelectorAll('.openPdf');
    
    openPdfLinks.forEach(link => {
        link.addEventListener('click', async function(event) {
            event.preventDefault();
            const type = this.dataset.type;
            lastClickedPdfType = type;
            
            if (pdfUrls[type]) {
                const overlay = document.getElementById('overlay');
                const pdfModal = document.getElementById('pdfModal');
                
                overlay.style.display = 'block';
                pdfModal.style.display = 'flex';
                await renderPdfWithPdfjs(pdfUrls[type], type);
            }
        });
    });
    
    // Gestionnaire pour le bouton "Ouvrir dans un nouvel onglet"
    const openInNewTabBtn = document.getElementById('openInNewTabBtn');
    openInNewTabBtn.addEventListener('click', function() {
        if (lastClickedPdfType && pdfUrls[lastClickedPdfType]) {
            window.open(pdfUrls[lastClickedPdfType], '_blank');
        }
    });
    
    // Fonction pour fermer le modal et nettoyer les ressources
    function closeModal() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('pdfModal').style.display = 'none';
        
        // Nettoyer les ressources
        if (currentPdfDocument) {
            currentPdfDocument.destroy();
            currentPdfDocument = null;
        }
        
        // Vider le conteneur du PDF
        document.getElementById('pdfViewer').innerHTML = '';
    }
    
    // Gestionnaires pour fermer le modal
    document.getElementById('overlay').addEventListener('click', closeModal);
    document.getElementById('closePdfBtn').addEventListener('click', closeModal);
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
</script>

</body>
</html>