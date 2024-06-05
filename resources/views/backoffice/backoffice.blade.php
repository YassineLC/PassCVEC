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
        @include('backoffice/_navbar')
    </header>

    <div class="container">
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
