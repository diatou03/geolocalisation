@extends('layouts.app')

@section('title', 'Alertes Météo')

@section('content')
<style>
/* Conteneur principal */
.alert-container {
    max-width: 900px;
    margin: 40px auto;
    font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
    color: #0c203f;
    background-color: #ffffff;
    padding: 0 15px;
}

/* Cartes pour alertes récentes */
.alert-card {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 15px 20px;
    margin-bottom: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    line-height: 1.4;
    word-break: break-word; /* Pour les longs messages */
}

.alert-card .alert-date {
    font-weight: 700;
    color: #435d86;
    margin-bottom: 8px;
}

.alert-card .alert-message {
    white-space: pre-wrap;
    color: #6c757d;
}

/* Tableau historique */
.alert-table-wrapper {
    overflow-x: auto; /* Scroll horizontal sur petits écrans */
    margin-top: 30px;
}

.alert-table {
    width: 100%;
    min-width: 600px; /* Table ne devient pas trop étroite */
    border-collapse: collapse;
    background-color: #194bb1;
    border-radius: 8px;
    overflow: hidden;
    font-size: 0.9rem;
}

.alert-table th {
    background-color: #435d86;
    color: #2508e179;
    font-weight: 700;
    text-align: center;
    padding: 0.85rem;
}

.alert-table td {
    padding: 0.85rem;
    border-top: 1px solid #115396;
    vertical-align: top;
    color: #0c203f;
}

/* Formulaire ajout alerte */
.alert-form textarea {
    width: 100%;
    border-radius: 8px;
    padding: 10px;
    border: 1px solid #0a427a;
    font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
    resize: vertical;
}

.alert-form button {
    margin-top: 10px;
    background-color: #6658dd;
    color: #0d348f;
    border-radius: 20px;
    padding: 8px 25px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.alert-form button:hover {
    background-color: #4a3ecf;
}

/* Responsive */
@media (max-width: 767.98px) {
    .alert-container {
        padding: 0 10px;
    }

    .alert-card {
        padding: 12px 15px;
        font-size: 0.9rem;
    }

    .alert-table th, .alert-table td {
        padding: 0.6rem;
        font-size: 0.85rem;
    }

    .alert-form button {
        width: 100%;
        padding: 10px;
    }
}

</style>

<div class="container">
    {{-- <h1 class="mb-4">Alertes Météo</h1> --}}

    @if($alertes->isEmpty())
        <p>Aucune alerte pour le moment.</p>
    @else
        <h2 class="mb-3">Alertes récentes</h2>
        @foreach($alertes->take(5) as $alerte) {{-- On prend les 5 dernières --}}
            <div class="alert-card">
                <div class="alert-date">
                    {{ $alerte->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="alert-message">
                    {{ $alerte->message }}
                </div>
            </div>
        @endforeach

        <h2 class="mt-5 mb-3">Historique complet</h2>
        <table class="table table-striped table-history">
            <thead>
                <tr>
                    <th>Date / Heure</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alertes as $alerte)
                    <tr>
                        <td>{{ $alerte->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $alerte->message }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Formulaire pour ajouter une alerte manuelle -->
    <div class="mt-5">
        <h2>Ajouter une alerte manuelle</h2>
        <form action="{{ route('alertes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="3" placeholder="Message de l'alerte" required></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-submit">Enregistrer l’alerte</button>
            </div>
        </form>
    </div>
</div>
@endsection
