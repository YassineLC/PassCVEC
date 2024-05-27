<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset("css/backoffice.css") }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Pass CVEC - BackOffice</title>
</head>
<body>

    <header>
        @include('_navbar')
    </header>

    <div class="container">
        <form action="{{ route('backoffice.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="is_in_residence">En résidence :</label>
                        <select name="is_in_residence" id="is_in_residence" class="form-control">
                            <option value="">Tous</option>
                            <option value="1" {{ old('is_in_residence') == '1' ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ old('is_in_residence') == '0' ? 'selected' : '' }}>Non</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search_nom">Nom :</label>
                        <input type="text" name="search_nom" id="search_nom" class="form-control" placeholder="Recherche par nom" value="{{ old('search_nom') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search_prenom">Prénom :</label>
                        <input type="text" name="search_prenom" id="search_prenom" class="form-control" placeholder="Recherche par prénom" value="{{ old('search_prenom') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
            <a href="{{ route('backoffice.index') }}" class="btn btn-secondary">Réinitialiser</a>
        </form>

        <table class="table table-striped table-bordered mb-3">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>INE</th>
                    <th>NOM</th>
                    <th>PRENOM</th>
                    <th>MAIL</th>
                    <th>ADRESSE</th>
                    <th>EN RESIDENCE</th>
                    <th>RESIDENCE</th>
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
                    <td>{{ $request->adresse }}</td>
                    <td>{{ $request->is_in_residence ? 'Oui' : 'Non' }}</td>
                    <td>{{ $request->residence ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->created_at)->isoFormat('DD/MM/YYYY HH:mm:ss') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
