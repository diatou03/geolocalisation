@extends('layouts.app')

@section('title', 'Tableau de bord — Nap ak karangue')

@section('content')
@if(session('success'))
  <div class="alert alert-success text-center mt-3">
    {{ session('success') }}
  </div>
@endif

<style>
/* --- Dashboard Container --- */
.dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1.5rem;
    justify-items: center;
    margin: 2rem auto;
    max-width: 1200px;
    padding: 0 1rem;
    perspective: 1000px;
}

/* --- Card Style --- */
.card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    padding: 1.5rem 1rem;
    width: 200px;
    height: 200px;
    text-decoration: none;
    color: #182878;
    text-align: center;
    font-weight: 600;
    /* transition: transform 0.3s, box-shadow 0.3s, background 0.3s; */ */
    /* background: linear-gradient(135deg, #1936a8, #ff921e); */
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    transform-style: preserve-3d;
    position: relative;
    overflow: hidden;
}

/* Neon Glow */
.card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
}

.card:hover::before {
    opacity: 1;
}

/* Hover Card */
.card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.35);
    background: linear-gradient(135deg, #9bfa02, #e18505);
}

/* --- Icon --- */
.icon-small {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    transition: transform 0.3s, text-shadow 0.3s;
    text-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

/* Icon hover animation */
.card:hover .icon-small {
    transform: rotate(20deg) scale(1.3);
    text-shadow: 0 4px 14px rgba(0,0,0,0.5);
}

/* --- Title --- */
.card h3 {
    font-size: 1rem;
    margin: 0;
    font-weight: 700;
    background: linear-gradient(90deg, #2e7585, #1d68da);
    background-size: 300%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradientShift 4s ease infinite;
}

/* Gradient animation for titles */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* --- Colors / Gradients by card type --- */
.card.alertes { background: linear-gradient(135deg, #3498db, #2980b9); }
.card.pirogues { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
.card.gps { background: linear-gradient(135deg, #e74c3c, #c0392b); }
.card.positions { background: linear-gradient(135deg, #e67e22, #d35400); }
.card.meteo { background: linear-gradient(135deg, #2ecc71, #27ae60); }
.card.marees { background: linear-gradient(135deg, #1abc9c, #16a085); }
.card.agents { background: linear-gradient(135deg, #f1c40f, #f39c12); }

/* --- Pulsation Animation --- */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.card:hover .icon-small {
    animation: pulse 1s infinite;
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .card {
        width: 130px;
        height: 130px;
        padding: 1rem;
    }

    .icon-small {
        font-size: 1.7rem;
        margin-bottom: 0.4rem;
    }

    .card h3 {
        font-size: 0.9rem;
    }
}

</style>

<div class="dashboard">
    <a href="{{ route('alertes.index') }}" class="card">
        <x-fas-bell class="icon-small text-blue-800" />
        <h3>Alertes</h3>
    </a>

    {{-- ✅ Réservé aux administrateurs --}}
    {{-- @if(Auth::user() && Auth::user()->role === 'admin') --}}
        <a href="{{ route('pirogues.index') }}" class="card">
            <x-fas-ship class="icon-small text-indigo-700" />
            <h3>Pirogues</h3>
        </a>
    {{-- @endif --}}

    <a href="{{ route('gps.map') }}" class="card">
        <x-fas-map-marker-alt class="icon-small text-red-600" />
        <h3>GPS</h3>
    </a> 

    <a href="{{ route('positions.map') }}" class="card">
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

    {{-- ✅ Réservé aux administrateurs --}}
    {{-- @if(Auth::user() && Auth::user()->role === 'admin') --}}
        <a href="{{ route('agent_marins.index') }}" class="card">
            <x-fas-user-shield class="icon-small text-yellow-600" />
            <h3>Agents Marins</h3>
        </a>
    {{-- @endif --}}
</div>
@endsection
