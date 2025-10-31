@extends('layouts.app')

@section('title', 'Logs des connexions | Nap Ak Karangue')

@section('content')
<div class="container mt-5">
    <h2 style="text-align:center; color: rgb(171,100,19); margin-bottom:2rem;">Logs des connexions</h2>

    @if($logs->isEmpty())
        <p style="text-align:center;">Aucun log trouvé.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead style="background-color: rgb(171,100,19); color:white;">
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>IP</th>
                    <th>Ville</th>
                    <th>Pays</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Date/Heure</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $log->user->name ?? 'Inconnu' }}</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ $log->city }}</td>
                        <td>{{ $log->country }}</td>
                        <td>{{ $log->latitude ?? '-' }}</td>
                        <td>{{ $log->longitude ?? '-' }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<style>
table { width:100%; border-collapse: collapse; }
table th, table td { padding:0.5rem; text-align:center; border:1px solid #ddd; }
table th { font-weight:700; }
</style>
@endsection
