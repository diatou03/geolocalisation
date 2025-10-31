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
}

h2 {
    text-align: center;
    font-weight: 600;
    color: #0c203f;
    margin-bottom: 30px;
}

/* --- Champs du formulaire --- */
.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    color: #0c203f;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-control {
    border-radius: 30px;
    padding: 12px 18px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a81d4;
    box-shadow: 0 0 8px rgba(74, 129, 212, 0.3);
}

/* --- Bouton enregistrer --- */
.btn-success {
    background: linear-gradient(135deg, #1abc9c, #16a085);
    border: none;
    border-radius: 30px;
    padding: 12px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #16a085, #149174);
    transform: translateY(-2px);
}

/* --- Erreurs --- */
.invalid-feedback {
    color: #e74c3c;
    font-size: 14px;
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .container {
        padding: 25px;
    }
}
</style>

<div class="container">
    <h2>🚤 Créer une nouvelle Pirogue</h2>

    <form action="{{ route('pirogues.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="form-group">
            <label for="nom"><i class="fa-solid fa-ship"></i> Nom</label>
            <input type="text"
                   name="nom"
                   id="nom"
                   class="form-control @error('nom') is-invalid @enderror"
                   value="{{ old('nom', $pirogue->nom ?? '') }}"
                   required>
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description"><i class="fa-solid fa-align-left"></i> Description</label>
            <textarea name="description"
                      id="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="3"
                      required>{{ old('description', $pirogue->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="type"><i class="fa-solid fa-tag"></i> Type</label>
            <input type="text"
                   name="type"
                   id="type"
                   class="form-control @error('type') is-invalid @enderror"
                   value="{{ old('type', $pirogue->type ?? '') }}"
                   required>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_creation"><i class="fa-regular fa-calendar"></i> Date de création</label>
            <input type="date"
                   name="date_creation"
                   id="date_creation"
                   class="form-control @error('date_creation') is-invalid @enderror"
                   value="{{ old('date_creation', isset($pirogue->date_creation) ? $pirogue->date_creation->format('Y-m-d') : '') }}">
            @error('date_creation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="matricule"><i class="fa-solid fa-id-card"></i> Matricule</label>
            <input type="text"
                   name="matricule"
                   id="matricule"
                   class="form-control @error('matricule') is-invalid @enderror"
                   value="{{ old('matricule', $pirogue->matricule ?? '') }}"
                   required>
            @error('matricule')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

@endsection
