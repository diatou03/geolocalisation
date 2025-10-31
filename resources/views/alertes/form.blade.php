@csrf

<div class="mb-3">
  <label class="form-label">Type</label>
  <select name="type" class="form-select" required>
    <option value="zone_danger" @selected(old('type', $alerte->type ?? '') === 'zone_danger')>Zone de danger</option>
    <option value="panique" @selected(old('type', $alerte->type ?? '') === 'panique')>Panique</option>
    <option value="meteo" @selected(old('type', $alerte->type ?? '') === 'meteo')>Météo</option>
  </select>
</div>

<div class="mb-3">
  <label class="form-label">Message</label>
  <textarea name="message" class="form-control" required>{{ old('message', $alerte->message ?? '') }}</textarea>
</div>

<div class="row mb-3">
  <div class="col">
    <label class="form-label">Latitude</label>
    <input type="number" step="0.000001" name="latitude"
           class="form-control"
           value="{{ old('latitude', $alerte->latitude ?? '') }}" required>
  </div>
  <div class="col">
    <label class="form-label">Longitude</label>
    <input type="number" step="0.000001" name="longitude"
           class="form-control"
           value="{{ old('longitude', $alerte->longitude ?? '') }}" required>
  </div>
</div>

<div class="form-check mb-3">
  <input type="checkbox" name="envoyee" class="form-check-input" value="1"
         @checked(old('envoyee', $alerte->envoyee ?? false))>
  <label class="form-check-label">Envoyée</label>
</div>

<div class="mb-3">
  <label class="form-label">Pirogue</label>
  <select name="pirogue_id" class="form-select" required>
    @foreach ($pirogues as $pirogue)
      <option value="{{ $pirogue->id }}"
        @selected(old('pirogue_id', $alerte->pirogue_id ?? '') == $pirogue->id)>
        {{ $pirogue->nom }}
      </option>
    @endforeach
  </select>
</div>
