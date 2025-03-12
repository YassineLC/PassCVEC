<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href="{{ route('backoffice.index') }}" class="navbar-brand">
            <img src="{{ asset("images/Logo-Crous-V-150x150.png") }}" alt="Logo Crous de Versailles" class="logo img-fluid">
            Crous de Versailles
        </a>
        <div class="ms-auto d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person text-white mr-3 mt-1" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
            <span class="me-3 text-white mr-5">Jean</span>
            <form>
                @csrf
                <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>
