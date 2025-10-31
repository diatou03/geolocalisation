@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Historique des connexions</h2>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Utilisateur</th>
                <th>Adresse IP</th>
                <th>Pays</th>
                <th>Ville</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Date de connexion</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logins as $login)
                <tr>
                    <td>{{ $login->user?->name ?? 'Utilisateur inconnu' }}</td>
                    <td>{{ $login->ip }}</td>
                    <td>{{ $login->country }}</td>
                    <td>{{ $login->city }}</td>
                    <td>{{ $login->latitude }}</td>
                    <td>{{ $login->longitude }}</td>
                    <td>{{ $login->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Aucune connexion enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $logins->links() }}
    </div>
</div>
@endsection
