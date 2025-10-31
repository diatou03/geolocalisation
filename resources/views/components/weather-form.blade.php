<form method="GET" action="{{ route('weather.alert') }}" class="mb-4 d-flex">
    <input
        type="text"
        name="city"
        class="form-control me-2"
        placeholder="Entrez une ville (ex. Dakar)"
        value="{{ old('city', $city) }}"
    >
    <button class="btn btn-primary">Vérifier</button>
</form>
