@extends('layouts.app')

@section('title', 'Détails de la Pirogue')

@section('content')

<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f0f4f8;
}

.container {
    background: white;
    border-radius: 15px;
    padding: 40px 50px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    margin-top: 60px;
}

/* Titre principal */
h2 {
    text-align: center;
    font-weight: 600;
    color: #0c203f;
    margin-bottom: 25px;
}

/* Bouton retour */
.btn-outline-secondary {
    border-radius: 30px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: #435d86;
    color: white;
}

/* Carte principale */
.card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #4a81d4, #435d86);
    color: white;
    padding: 25px;
}

.card-title {
    font-size: 24px;
    font-weight: 600;
}

.badge {
    background-color: #4fc6e1;
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 12px;
}

/* Corps de la carte */
.card-body {
    padding: 25px;
    font-size: 16px;
    color: #333;
}

.card-body p {
    margin-bottom: 12px;
}

/* Pied de carte */
.card-footer {
    background-color: #f9fafb;
    padding: 20px;
    border-top: 1px solid #e5e5e5;
}

/* Bouton d’alerte */
.btn-danger {
    background-color: #f1556c;
    border: none;
    font-weight: 600;
    border-radius: 12px;
    padding: 10px 20px;
    transition: transform 0.2s ease, background 0.3s;
}

.btn-danger:hover {
    background-color: #d94a5e;
    transform: scale(1.05);
}

/* Effet alerte animée */
@keyframes pulseAlert {
    0% { box-shadow: 0 0 0 0 rgba(241, 85, 108, 0.6); }
    70% { box-shadow: 0 0 0 15px rgba(241, 85, 108, 0); }
    100% { box-shadow: 0 0 0 0 rgba(241, 85, 108, 0); }
}
.btn-danger:active {
    animation: pulseAlert 1s;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 25px;
    }
    .card-header {
        text-align: center;
    }
    .card-title {
        font-size: 20px;
    }
}
</style>

<div class="container">
    <h2>🚤 Détails de la Pirogue</h2>

    <a href="{{ route('pirogues.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Retour à la liste
    </a>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="card-title mb-0">
                <i class="fa-solid fa-ship"></i> {{ $pirogue->nom }}
            </h5>
            <span class="badge">{{ $pirogue->type }}</span>
        </div>

        <div class="card-body">
            <p><strong><i class="fa-solid fa-align-left"></i> Description :</strong> {{ $pirogue->description ?? '—' }}</p>
            <p><strong><i class="fa-regular fa-calendar"></i> Date de création :</strong> {{ \Carbon\Carbon::parse($pirogue->date_creation)->format('d/m/Y') }}</p>
            <p><strong><i class="fa-solid fa-id-card"></i> Matricule :</strong> {{ $pirogue->matricule }}</p>
        </div>

        <div class="card-footer text-end">
            <form action="{{ route('pirogues.panic', $pirogue) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> Alerte d'urgence
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
