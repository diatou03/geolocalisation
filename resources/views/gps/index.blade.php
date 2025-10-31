@extends('layouts.app')

@section('title', 'Données GPS')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">📡 Données GPS reçues</h2>

    @if ($positions->count() > 0)
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>🆔 Appareil</th>
                        <th>🌍 Latitude</th>
                        <th>🌍 Longitude</th>
                        <th>📶 Satellites</th>
                        <th>📏 Altitude (m)</th>
                        <th>🚗 Vitesse (km/h)</th>
                        <th>🕒 Date & Heure</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($positions as $gps)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $gps->device_id }}</td>
                        <td>{{ $gps->latitude }}</td>
                        <td>{{ $gps->longitude }}</td>
                        <td>{{ $gps->satellites ?? '—' }}</td>
                        <td>{{ $gps->altitude ?? '—' }}</td>
                        <td>{{ $gps->speed ?? '—' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($gps->timestamp)->format('d/m/Y à H:i:s') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $positions->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center">
            😕 Aucune donnée GPS enregistrée pour le moment.
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('gps.map') }}" class="btn btn-primary">
            🌍 Voir la carte en temps réel
        </a>
    </div>
</div>
@endsection
