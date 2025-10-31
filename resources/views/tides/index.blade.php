@extends('layouts.app')

@section('title', 'Données marées')

@section('content')

<style>
body { 
    font-family: 'Segoe UI', Arial, sans-serif; 
    background-color: #f0f4f8; 
}
.container { 
    background: white;
    border-radius: 15px; 
    padding: 30px 40px; 
    box-shadow: 0 6px 16px rgba(0,0,0,0.15); 
    margin-top: 50px; 
}
h2 { 
    text-align: center; 
    font-weight: 600; 
    color: #0c203f; 
    margin-bottom: 25px; 
}
form { 
    background: #e9f0ff; 
    border-radius: 50px; 
    padding: 20px 30px; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
    margin-bottom: 40px; 
}
form label { font-weight: 600; color: #0c203f; } 
form .form-control { border-radius: 30px; padding: 10px 15px; } 
form button { border-radius: 30px; background-color: #0056b3; border: none; font-weight: 600; transition: background 0.3s ease; } 
form button:hover { background-color: #003f7f; } 
.table { width: 100%; text-align: center; border-collapse: collapse; background-color: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); } 
.table thead th { background-color: #435d86; color: #fff; padding: 12px; font-size: 16px; } 
.table tbody td { padding: 10px; font-size: 15px; color: #333; } 
.table-bordered td, .table-bordered th { border: 1px solid #dee2e6; } 
.badge { font-size: 14px; padding: 6px 12px; border-radius: 12px; }
.bg-primary { background-color: #0056b3 !important; } 
.bg-warning { background-color: #f7b84b !important; } 

@media (max-width: 768px) { 
    .container { padding: 20px; } 
    form { border-radius: 20px; padding: 15px; } 
    .table thead { display: none; } 
    .table, .table tbody, .table tr, .table td { display: block; width: 100%; } 
    .table tr { margin-bottom: 1rem; background: #fff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; } 
    .table td { text-align: right; padding-left: 50%; position: relative; } 
    .table td::before { content: attr(data-label); position: absolute; left: 10px; width: 45%; font-weight: bold; color: #435d86; text-align: left; } 
}

/* Onglets marées */
.tide-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}
.tide-tab {
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s, color 0.3s;
}
.tide-tab.active {
    background-color: #0056b3;
    color: white;
}
.tide-tab.inactive {
    background-color: #f0f0f0;
    color: #333;
}
.tide-forecast {
    display: none;
    margin-top: 30px;
}
</style>

<div class="container">
    <h2>Données marées du {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h2>

    {{-- Messages --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    {{-- Onglets --}}
    <div class="tide-tabs">
        <div class="tide-tab active" onclick="showTideTab('today')">Marées du jour</div>
        <div class="tide-tab inactive" onclick="showTideTab('forecast')">Prévisions 3 jours</div>
    </div>

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('tides.index') }}">
        <div class="row g-3 align-items-end justify-content-center">
            <div class="col-md-3">
                <label for="region">Région</label>
                <select name="region" id="region" class="form-control" onchange="updateCommunes()" required>
                    <option value="">Sélectionnez une région</option>
                    @foreach($regions as $regionKey => $regionData)
                        <option value="{{ $regionKey }}" {{ $regionKey === $selectedRegion ? 'selected' : '' }}>
                            {{ $regionData['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="commune">Commune</label>
                <select name="commune" id="commune" class="form-control" required>
                    <option value="">Sélectionnez une commune</option>
                    @foreach($communes as $key => $communeData)
                        <option value="{{ $key }}" {{ $key === $selectedCommune ? 'selected' : '' }}>
                            {{ $communeData['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="{{ $date }}" class="form-control" required>
            </div>

            <div class="col-md-2 text-center">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-magnifying-glass"></i> Rechercher
                </button>
            </div>
        </div>
    </form>

    {{-- Marées du jour --}}
    <div id="today" class="tide-forecast" style="display:block;">
        @if(!empty($tideData))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Heure</th>
                        <th>Hauteur (m)</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tideData as $tide)
                        <tr>
                            <td data-label="Heure">{{ \Carbon\Carbon::parse($tide['time'])->format('H:i') }}</td>
                            <td data-label="Hauteur">{{ number_format($tide['height'], 2) }}</td>
                            <td data-label="Type">
                                @php $type = strtolower($tide['type'] ?? ''); @endphp
                                @if($type === 'high')
                                    <span class="badge bg-primary">Haute</span>
                                @elseif($type === 'low')
                                    <span class="badge bg-warning text-dark">Basse</span>
                                @else
                                    <span class="badge bg-secondary">Inconnue</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">Aucune donnée disponible. Sélectionnez une région et une commune puis cliquez sur Rechercher.</p>
        @endif
    </div>

    {{-- Prévisions 3 jours --}}
    <div id="forecast" class="tide-forecast">
        @if(!empty($forecastData))
            @foreach($forecastData as $forecastDate => $tides)
                <h3 class="mt-4">{{ \Carbon\Carbon::parse($forecastDate)->translatedFormat('d F Y') }}</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Heure</th>
                            <th>Hauteur (m)</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tides as $tide)
                            <tr>
                                <td data-label="Heure">{{ \Carbon\Carbon::parse($tide['time'])->format('H:i') }}</td>
                                <td data-label="Hauteur">{{ number_format($tide['height'], 2) }}</td>
                                <td data-label="Type">
                                    @php $type = strtolower($tide['type'] ?? ''); @endphp
                                    @if($type === 'high')
                                        <span class="badge bg-primary">Haute</span>
                                    @elseif($type === 'low')
                                        <span class="badge bg-warning text-dark">Basse</span>
                                    @else
                                        <span class="badge bg-secondary">Inconnue</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @else
            <p class="text-center">Aucune prévision disponible.</p>
        @endif
    </div>

</div>

<script>
function showTideTab(tab) {
    const tabs = document.querySelectorAll('.tide-tab');
    const contents = document.querySelectorAll('.tide-forecast');

    tabs.forEach(t => t.classList.remove('active'));
    tabs.forEach(t => t.classList.add('inactive'));
    contents.forEach(c => c.style.display = 'none');

    document.getElementById(tab).style.display = 'block';
    document.querySelector(`.tide-tab[onclick="showTideTab('${tab}')"]`).classList.add('active');
}

const allRegions = @json($regions);
function updateCommunes() {
    const regionSelect = document.getElementById("region");
    const communeSelect = document.getElementById("commune");
    const selectedRegion = regionSelect.value;
    communeSelect.innerHTML = '<option value="">Sélectionnez une commune</option>';

    if (selectedRegion && allRegions[selectedRegion]?.communes) {
        const communes = allRegions[selectedRegion].communes;
        for (const key in communes) {
            const option = document.createElement("option");
            option.value = key;
            option.textContent = communes[key].name;
            communeSelect.appendChild(option);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateCommunes();
    const selectedCommune = "{{ $selectedCommune }}";
    if(selectedCommune) document.getElementById('commune').value = selectedCommune;
});
</script>

@endsection
