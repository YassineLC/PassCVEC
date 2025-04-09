<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href="{{ route('backoffice.index') }}" class="navbar-brand">
            <img src="{{ asset("images/Logo-Crous-V-150x150.png") }}" alt="Logo Crous de Versailles" class="logo img-fluid">
            Crous de Versailles
        </a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
            </ul>
            
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown mr-3">
                    <button class="btn btn-link text-white dropdown-toggle" type="button" id="userMenuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
                        <a class="dropdown-item {{ request()->routeIs('backoffice.users.index') ? 'active' : '' }}" href="{{ route('backoffice.users.index') }}">
                            <i class="fas fa-user-lock"></i> Autorisations
                        </a>
                    </div>
                </div>
                
                @if(isset($shibbolethAttributes))
                    <div class="d-flex align-items-center me-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-circle text-white me-3" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        <span class="text-white fs-6 ml-3">
                            @if(isset($shibbolethAttributes['givenName']) && isset($shibbolethAttributes['sn']))
                                {{ $shibbolethAttributes['givenName'] }} {{ $shibbolethAttributes['sn'] }}
                            @elseif(isset($shibbolethAttributes['displayName']))
                                {{ $shibbolethAttributes['displayName'] }}
                            @else
                                Utilisateur
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav> 