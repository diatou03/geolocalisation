@extends('layouts.admin')

@section('content')
<h2>Liste des positions GPS</h2>

<form method="GET" class="mb-4">
    <div class="flex space-x-4">
        <select name="client_id" class="form-select">
            <option value="">-- Tous les clients --</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->nom }}
                </option>
            @endforeach
        </select>

        <input type="date" name="date" value="{{ request('date') }}" class="form-input" />

        <button class="btn btn-primary">Filtrer</button>
    </div>
</form>

<table class="table-auto w-full border mt-4">
    <thead>
        <tr>
            <th>Client</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($positions as $pos)
        <tr>
            <td>{{ $pos->client->nom }}</td>
            <td>{{ $pos->latitude }}</td>
            <td>{{ $pos->longitude }}</td>
            <td>{{ $pos->date_position }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $positions->withQueryString()->links() }}
@endsection
