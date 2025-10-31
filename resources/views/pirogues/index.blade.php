@extends('layouts.app')

@section('title', 'Liste des Pirogues')

@section('content')

<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f0f4f8;
}

/* Conteneur principal */
.container {
    background: white;
    border-radius: 15px;
    padding: 30px 40px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    margin-top: 50px;
}

/* Titre */
h2 {
    text-align: center;
    font-weight: 600;
    color: #0c203f;
    margin-bottom: 25px;
}

/* Bouton principal */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 30px;
    background-color: #0056b3;
    border: none;
    font-weight: 600;
    transition: background 0.3s ease;
}

.btn-primary:hover {
    background-color: #003f7f;
}

/* Table */
.table {
    width: 100%;
    text-align: center;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    background-color: #435d86;
    color: #fff;
    padding: 12px;
    font-size: 16px;
}

.table tbody td {
    padding: 10px;
    font-size: 15px;
    color: #333;
    vertical-align: middle;
}

.table img {
    width: 60px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}

/* ✅ Boutons d’action stylés */
.btn-sm {
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

/* Icônes + couleurs */
.btn-info {
    background-color: #17a2b8;
    color: #fff;
    border: none;
}
.btn-warning {
    background-color: #ffc107;
    color: #222;
    border: none;
}
.btn-danger {
    background-color: #dc3545;
    color: #fff;
    border: none;
}

/* Hover : meilleur contraste */
.btn-info:hover { background-color: #138496; }
.btn-warning:hover { background-color: #e0a800; color: #111; }
.btn-danger:hover { background-color: #c82333; }

/* ✅ Colonne des actions */
.table td[data-label="Actions"] {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }
    .table thead {
        display: none;
    }
    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }
    .table tr {
        margin-bottom: 1rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 10px;
    }
    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    .table td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 45%;
        font-weight: bold;
        color: #435d86;
        text-align: left;
    }
    /* Ajustement actions sur mobile */
    .table td[data-label="Actions"] {
        justify-content: flex-end;
        gap: 6px;
    }
}
</style>

<div class="container">
    <h2>Liste des Pirogues</h2>

    <div class="text-center mb-3">
        <a href="{{ route('pirogues.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Créer une nouvelle pirogue
        </a>
    </div>

    @if($pirogues->count())
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Date de création</th>
                    <th>Matricule</th>
                    <th>Positions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pirogues as $piro)
                    <tr>
                        <td data-label="Nom"><strong>{{ $piro->nom ?? '—' }}</strong></td>
                        <td data-label="Type">{{ $piro->type }}</td>
                        <td data-label="Date de création">
                            {{ \Carbon\Carbon::parse($piro->date_creation)->format('d/m/Y') }}
                        </td>
                        <td data-label="Matricule">{{ $piro->matricule }}</td>
                        <td data-label="Positions">
                            @forelse($piro->positions as $pos)
                                <p>📍 {{ $pos->latitude }}, {{ $pos->longitude }}</p>
                            @empty
                                <span class="text-muted">Aucune position</span>
                            @endforelse
                        </td>
                        <td data-label="Actions">
                            <a href="{{ route('pirogues.show', $piro) }}" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-eye"></i> Voir
                            </a>
                            <a href="{{ route('pirogues.edit', $piro) }}" class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-pen-to-square"></i> Modifier
                            </a>
                            <form action="{{ route('pirogues.destroy', $piro) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette pirogue ?')">
                                    <i class="fa-solid fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-muted mt-4">🚫 Aucune pirogue trouvée.</p>
    @endif
</div>

@endsection
