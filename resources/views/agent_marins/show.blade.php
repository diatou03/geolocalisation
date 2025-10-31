@extends('layouts.app')

@section('content')
<style>
/* --- Conteneur --- */
.container-agent {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1rem;
}

/* --- Carte --- */
.card-agent {
    background-color: #fff;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card-agent:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

/* --- Titre --- */
.card-agent h2 {
    font-size: 1.9rem;
    font-weight: 700;
    color: #15222f;
    margin-bottom: 2rem;
    text-align: center;
}

/* --- Tableau moderne --- */
.agent-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem 2rem;
}

.agent-info div {
    display: flex;
    align-items: center;
    background: #f7f9fb;
    padding: 0.8rem 1rem;
    border-radius: 0.6rem;
    box-shadow: inset 0 0 0 1px #e0e6ed;
    transition: background 0.2s, box-shadow 0.2s;
}

.agent-info div:hover {
    background: #eaf1f8;
    box-shadow: inset 0 0 0 1px #b0c4d6;
}

.agent-info span.icon {
    font-size: 1.4rem;
    margin-right: 0.6rem;
    color: #4fc6e1;
    flex-shrink: 0;
}

.agent-info span.label {
    font-weight: 600;
    color: #6c757d;
    flex: 0 0 90px;
}

.agent-info span.value {
    color: #343a40;
    word-break: break-word;
}

/* --- Boutons --- */
.actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.btn-back, .btn-edit {
    padding: 0.6rem 1.2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
}

.btn-back {
    color: #185d6d;
    border: 1px solid #185d6d;
}

.btn-back:hover {
    background-color: #185d6d;
    color: #fff;
}

.btn-edit {
    background-color: #186c7e;
    color: #fff;
}

.btn-edit:hover {
    background-color: #0d5a6b;
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .agent-info {
        grid-template-columns: 1fr;
    }

    .card-agent h2 {
        font-size: 1.6rem;
    }

    .actions {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<div class="container-agent">
    <div class="card-agent">
        <h2>Détail de l’agent marin</h2>

        <div class="agent-info">
            <div><span class="icon">👤</span><span class="label">Nom:</span><span class="value">{{ $agent->nom }}</span></div>
            <div><span class="icon">🧑‍💼</span><span class="label">Prénom:</span><span class="value">{{ $agent->prenom }}</span></div>
            <div><span class="icon">📞</span><span class="label">Téléphone:</span><span class="value">{{ $agent->telephone }}</span></div>
            <div><span class="icon">✉️</span><span class="label">Email:</span><span class="value">{{ $agent->email }}</span></div>
            <div><span class="icon">💼</span><span class="label">Poste:</span><span class="value">{{ $agent->poste }}</span></div>
        </div>

        <div class="actions">
            <a href="{{ route('agent_marins.index') }}" class="btn-back">← Retour à la liste</a>
            <a href="{{ route('agent_marins.edit', $agent->id) }}" class="btn-edit">Modifier</a>
        </div>
    </div>
</div>
@endsection
