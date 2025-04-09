@extends('backoffice.layouts.app')

@section('title', 'Utilisateurs non autorisés - Pass CVEC BackOffice')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Utilisateurs non autorisés</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Email</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Matricule</th>
                                <th>Fonction</th>
                                <th>Établissement</th>
                                <th>Dernière tentative</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->given_name }}</td>
                                    <td>{{ $user->matricule }}</td>
                                    <td>{{ $user->function }}</td>
                                    <td>{{ $user->establishment }}</td>
                                    <td>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i:s') : 'Jamais' }}</td>
                                    <td>
                                        <form action="{{ route('backoffice.users.activate', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir activer cet utilisateur ?')">
                                                Activer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucun utilisateur non autorisé trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('backoffice.components.pagination', ['paginator' => $users])
            </div>
        </div>
    </div>
@endsection 