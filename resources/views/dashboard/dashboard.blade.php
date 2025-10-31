@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
    padding: 2rem;
}

.dashboard-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 160px;
    height: 160px;
    background-color: #fff;
    border-radius: 1rem;
    text-decoration: none;
    color: #fff;
    font-weight: 600;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
    padding: 1rem;
    text-align: center;
}

.dashboard-card .icon {
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
}

/* Hover effect */
.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Couleurs par type */
.dashboard-card.alertes { background-color: #3498db; }
.dashboard-card.pirogues { background-color: #9b59b6; }
.dashboard-card.gps { background-color: #e74c3c; }
.dashboard-card.positions { background-color: #e67e22; }
.dashboard-card.meteo { background-color: #2ecc71; }
.dashboard-card.marees { background-color: #1abc9c; }
.dashboard-card.agents { background-color: #f1c40f; color: #000; }

/* Responsive */
@media (max-width: 768px) {
    .dashboard-card {
        width: 130px;
        height: 130px;
        font-size: 0.9rem;
    }
    .dashboard-card .icon {
        font-size: 1.8rem;
    }
}

</style>
<div class="dashboard">
    <a href="{{ route('alertes.index') }}" class="card">
        <x-fas-bell class="icon-small text-blue-800" />
        <h3>Alertes</h3>
    </a>
    <a href="{{ route('pirogues.index') }}" class="card">
        <x-fas-ship class="icon-small text-indigo-700" />
        <h3>Pirogues</h3>
    </a>
    <a href="{{ route('gps.map') }}" class="card">
        <x-fas-map-marker-alt class="icon-small text-red-600" />
        <h3>GPS</h3>
    </a>
    <a href="{{ route('positions.json') }}" class="card">
        <x-fas-map-marker-alt class="icon-small text-red-600" />
        <h3>Positions</h3>
    </a>
    <a href="{{ route('weather.show') }}" class="card">
        <x-fas-cloud-rain class="icon-small text-green-700" />
        <h3>Météo</h3>
    </a>
    <a href="{{ route('tides.index') }}" class="card">
        <x-fas-water class="icon-small text-cyan-700" />
        <h3>Marées</h3>
    </a>
    <a href="{{ route('agent_marins.index') }}" class="card">
        <x-fas-user-shield class="icon-small text-yellow-600" />
        <h3>Agents Marins</h3>
    </a>
</div>
@endsection
