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
    background-color: #076250;
    border-color: #076653;
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
  <h2>Ajouter un agent marin</h2>
  <a href="{{ route('agent_marins.index') }}" class="btn btn-secondary mb-3">← Retour à la liste</a>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('agent_marins.store') }}" method="POST" novalidate class="needs-validation">
    @csrf
    <table class="table table-bordered">
      <tbody>
        @foreach(['nom','prenom','telephone','email','poste'] as $field)
          <tr>
            <td class="font-weight-bold text-capitalize">{{ $field }}</td>
            <td>
              <input
                type="{{ $field === 'email' ? 'email' : 'text' }}"
                name="{{ $field }}"
                id="{{ $field }}"
                value="{{ old($field) }}"
                class="form-control @error($field) is-invalid @enderror"
                required
              >
              @error($field)
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <button type="submit" class="btn btn-success float-right">Enregistrer</button>
  </form>
</div>
@endsection
