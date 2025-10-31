@extends('layouts.app')

@section('content')
<style>
 /* --- Style global des cartes --- */
.card {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
    background-color: #fff;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

.card-header {
    background-color: #f8f9fa;
    font-weight: 600;
    font-size: 1.2rem;
    color: #0c203f;
    border-bottom: 1px solid #dee2e6;
}

.card-body {
    color: #495057;
}

/* --- Table --- */
.table {
    width: 100%;
    margin-bottom: 1.5rem;
    color: #495057;
    border-collapse: separate;
    border-spacing: 0;
}

.table th, .table td {
    vertical-align: middle;
    padding: 0.75rem 1rem;
    border-top: 1px solid #dee2e6;
    text-align: left;
}

.table thead th {
    background-color: #435d86;
    color: #fff;
    border-bottom: 2px solid #dee2e6;
    font-weight: 700;
    text-align: center;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(67, 93, 134, 0.05);
}

.table-hover tbody tr:hover {
    background-color: rgba(67, 93, 134, 0.1);
    cursor: pointer;
}

/* --- Buttons --- */
.btn-success {
    background-color: #1abc9c;
    border-color: #1abc9c;
}

.btn-primary {
    background-color: #4fc6e1;
    border-color: #4fc6e1;
}

.btn-warning {
    background-color: #f7b84b;
    border-color: #f7b84b;
}

.btn-danger {
    background-color: #f1556c;
    border-color: #f1556c;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

/* --- Responsive --- */
.table-responsive {
    overflow-x: auto;
}

@media (max-width: 767px) {
    .table th, .table td {
        padding: 0.5rem;
        font-size: 0.85rem;
    }
    .card-header h3 {
        font-size: 1rem;
    }
    .btn {
        font-size: 0.75rem;
        padding: 0.3rem 0.5rem;
    }
}

/* --- Text truncation --- */
.text-truncate {
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

</style>
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Liste des agents marins</h3>
      <a href="{{ route('agent_marins.create') }}" class="btn btn-success">
        Ajouter un agent
      </a>
    </div>
    <div class="card-body">
      @if($agents->count())
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Poste</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($agents as $index => $agent)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td class="text-truncate" style="max-width: 120px;">{{ $agent->nom }}</td>
                  <td class="text-truncate" style="max-width: 120px;">{{ $agent->prenom }}</td>
                  <td>{{ $agent->telephone }}</td>
                  <td class="text-truncate" style="max-width: 180px;">{{ $agent->email }}</td>
                  <td>{{ $agent->poste }}</td>
                  <td class="text-center">
                    <a href="{{ route('agent_marins.show', $agent->id) }}" class="btn btn-sm btn-primary">Voir</a>
                    <a href="{{ route('agent_marins.edit', $agent->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('agent_marins.destroy', $agent->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">Supprimer</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="alert alert-info text-center">
          Aucun agent trouvé.
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
