@extends('layouts.app')

@section('title', 'Créer une Pirogue')

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

/* --- Bouton Créer --- */
.btn-create {
    background: linear-gradient(135deg, #28a745, #1c7c31);
    border: none;
    border-radius: 30px;
    padding: 12px 25px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-create:hover {
    background: linear-gradient(135deg, #1c7c31, #14521f);
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
    <h2>🛶 Créer une nouvelle Pirogue</h2>

    <a href="{{ route('pirogues.index') }}" class="btn btn-outline-secondary mb-3">
        ← Retour à la liste
    </a>

    <form action="{{ route('pirogues.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        {{-- Inclusion du formulaire réutilisable --}}
        @include('pirogues.form')

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-create">
                <i class="fa-solid fa-plus"></i> Créer
            </button>
        </div>
    </form>
</div>

@endsection
