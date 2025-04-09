<div class="filter-container">
    <form method="GET" action="{{ $action ?? route('backoffice.index') }}" class="form-inline flex-wrap">
        <div class="form-group mr-3 mb-2">
            <label for="nom" class="mr-1">Nom:</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ request('nom') }}">
        </div>
        <div class="form-group mr-3 mb-2">
            <label for="prenom" class="mr-1">Prénom:</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ request('prenom') }}">
        </div>
        <div class="form-group mr-3 mb-2">
            <label for="ine" class="mr-1">INE:</label>
            <input type="text" name="ine" id="ine" class="form-control" value="{{ request('ine') }}">
        </div>
        <div class="form-group mr-3 mb-2">
            <label for="id" class="mr-1">ID:</label>
            <input type="text" name="id" id="id" class="form-control" value="{{ request('id') }}">
        </div>
        <div class="form-group mr-3 mb-2">
            <label for="statut" class="mr-1">Statut: </label>
            <select id="statut" name="statut" class="form-control w-auto" style="width: auto;">
                <option value="" disabled selected></option>
                <option value="A traiter" {{ request('statut') == 'A traiter' ? 'selected' : '' }}>A traiter</option>
                <option value="En cours" {{ request('statut') == 'En cours' ? 'selected' : '' }}>En cours</option>
                <option value="Traité" {{ request('statut') == 'Traité' ? 'selected' : '' }}>Traité</option>
            </select>
        </div>
        <div class="form-group mb-2">
            <button type="submit" class="btn btn-primary mr-2">Rechercher</button>
            <a href="{{ $resetUrl ?? route('backoffice.index', ['rowsPerPage' => request('rowsPerPage', 25)]) }}" class="btn btn-secondary">Réinitialiser</a>
        </div>
        @if(request('rowsPerPage'))
            <input type="hidden" name="rowsPerPage" value="{{ request('rowsPerPage') }}">
        @endif
    </form>
</div> 