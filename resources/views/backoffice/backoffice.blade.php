@extends('backoffice.layouts.app')

@section('title', 'Tableau de bord - Pass CVEC BackOffice')

@section('content')
    @include('backoffice.components.status-cards')

    <div class="content-wrapper">
        <div class="sticky-top">
            @include('backoffice.components.search-filter')

            <form action="{{ route('backoffice.updateStatus') }}" method="POST">
                @csrf
                <div class="mt-3 d-flex align-items-center">
                    <label for="status" class="form-label mr-2">Changer le statut des demandes sélectionnées :</label>
                    <select id="status" name="status" class="form-control form-control-sm w-auto mr-2" style="width: auto;" required>
                        <option value="" disabled selected></option>
                        <option value="A traiter">A traiter</option>
                        <option value="En cours">En cours</option>
                        <option value="Traité">Traité</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
                @foreach(request()->all() as $key => $value)
                    <input type="hidden" name="redirect_params[{{ $key }}]" value="{{ $value }}">
                @endforeach
            </form>

            <table class="table table-striped table-bordered mb-3">
                <thead class="thead-dark">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
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
                        <td><input type="checkbox" name="demande_ids[]" value="{{ $request->id }}"></td>
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

            @include('backoffice.components.pagination', ['paginator' => $allRequests])
        </div>
    </div>
@endsection

@section('additional_js')
<script>
    document.getElementById('select-all').addEventListener('click', function(event) {
        const checkboxes = document.querySelectorAll('input[name="demande_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
    });
</script>
@endsection
