@extends('layouts.app')

@section('title', 'Modifier une Pirogue')

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
    max-width: 800px;
}

h2 {
    text-align: center;
    font-weight: 600;
    color: #0c203f;
    margin-bottom: 30px;
}

/* --- Bouton Mettre à jour --- */
.btn-update {
    background: linear-gradient(135deg, #4a81d4, #1e56a0);
    border: none;
    border-radius: 30px;
    padding: 12px 25px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-update:hover {
    background: linear-gradient(135deg, #1e56a0, #163e73);
    transform: translateY(-2px);
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .container {
        padding: 25px;
    }
}
</style>

<div class="container">
    <h2>✏️ Modifier la Pirogue</h2>

    <a href="{{ route('pirogues.index') }}" class="btn btn-outline-secondary mb-3">
        ← Retour à la liste
    </a>

    <form action="{{ route('pirogues.update', $pirogue) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        {{-- Inclusion du même formulaire réutilisable --}}
        @include('pirogues.form')

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-update">
                <i class="fa-solid fa-rotate-right"></i> Mettre à jour
            </button>
        </div>
    </form>
</div>

@endsection
