@extends('layouts.app')

@section('title', 'Suivi des positions GPS')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary">
        <i class="fa-solid fa-location-dot"></i> Suivi des positions GPS
    </h1>

    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Appareil</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Altitude (m)</th>
                        <th>Vitesse (km/h)</th>
                        <th>Satellites</th>
                        <th>Horodatage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($positions as $pos)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pos->device_id }}</td>
                            <td>{{ number_format($pos->latitude, 6) }}</td>
                            <td>{{ number_format($pos->longitude, 6) }}</td>
                            <td>{{ $pos->altitude ?? '-' }}</td>
                            <td>{{ $pos->speed ?? '-' }}</td>
                            <td>{{ $pos->satellites ?? '-' }}</td>
                            <td>{{ $pos->timestamp ?? $pos->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">Aucune donnée GPS reçue pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
