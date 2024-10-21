<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href="{{ route('backoffice.index') }}" class="navbar-brand">
            <img src="{{ asset("images/logo.png") }}" alt="Logo Crous de Versailles" class="logo img-fluid">
            Crous de Versailles
        </a>
        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 text-white mr-5">{{ Auth::guard('backoffice')->user()->name }}</span>
            <form action="{{ route('backoffice.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>
