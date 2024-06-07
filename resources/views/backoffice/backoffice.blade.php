<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/backoffice.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Pass CVEC - BackOffice</title>
</head>
<body>

    <header>
        @include('backoffice/_navbar')
    </header>

    <div class="container-fluid">

        <div class="d-flex justify-content-start mb-4 status-card-container">
            <div class="status-card status-green">
                <h3>{{ $incomingRequests ?? 0 }}</h3>
                <p>Demandes à traiter</p>
            </div>
            <div class="status-card status-orange">
                <h3>{{ $pendingRequests ?? 0 }}</h3>
                <p>Demandes en cours</p>
            </div>
            <div class="status-card status-red">
                <h3>{{ $assignedRequestsCount ?? 0 }}</h3>
                <p>Demandes traités</p>
            </div>
        </div>

        <div class="filter-container">
            <form method="GET" action="{{ route('backoffice.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" id="nom" class="form-control ml-1" value="{{ request('nom') }}">
                </div>
                <div class="form-group mr-2">
                    <label for="prenom">Prénom:</label>
                    <input type="text" name="prenom" id="prenom" class="form-control ml-1" value="{{ request('prenom') }}">
                </div>
                <div class="form-group mr-2">
                    <label for="ine">INE:</label>
                    <input type="text" name="ine" id="ine" class="form-control ml-1" value="{{ request('ine') }}">
                </div>
                <div class="form-group mr-2">
                    <label for="id">ID:</label>
                    <input type="text" name="id" id="id" class="form-control ml-1" value="{{ request('id') }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mr-2">Rechercher</button>
                    <a href="{{ route('backoffice.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>




        <table class="table table-striped table-bordered mb-3">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>INE</th>
                    <th>NOM</th>
                    <th>PRENOM</th>
                    <th>MAIL</th>
                    <th>ADRESSE</th>
                    <th>CODE POSTAL</th>
                    <th>VILLE</th>
                    <th>EN RESIDENCE</th>
                    <th>RESIDENCE</th>
                    <th>STATUT</th>
                    <th>DATE DE CREATION</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($allRequests as $request)
                <tr>
                    <td><a href="{{ route('backoffice.demande', ['id' => $request->id]) }}">{{ $request->id }}</a></td>
                    <td>{{ $request->ine }}</td>
                    <td>{{ $request->nom }}</td>
                    <td>{{ $request->prenom }}</td>
                    <td>{{ $request->email }}</td>
                    <td>{{ $request->adresse ?? '-' }}</td>
                    <td>{{ $request->code_postal }}</td>
                    <td>{{ $request->ville }}</td>
                    <td>{{ $request->is_in_residence ? 'Oui' : 'Non' }}</td>
                    <td>{{ $request->residence ?? '-' }}</td>
                    <td>
                        @if($request->statut == 'A traiter')
                            <span class="badge badge-success">A traiter</span>
                        @elseif($request->statut == 'En cours')
                            <span class="badge badge-warning">En cours</span>
                        @elseif($request->statut == 'Traité')
                            <span class="badge badge-danger">Traité</span>
                        @else
                            <span>{{ $request->statut }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($request->created_at)->isoFormat('DD/MM/YYYY HH:mm:ss') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
