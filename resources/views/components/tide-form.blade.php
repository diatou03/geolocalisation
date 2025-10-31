<form method="GET" action="{{ route('tides.index') }}" class="row g-3 mb-4">
    <div class="col-md-4">
        <label for="location" class="form-label">Localité</label>
        <select name="location" id="location" class="form-select" onchange="this.form.submit()">
            @foreach($cities as $key => $loc)
                <option value="{{ $key }}" {{ $key === $location ? 'selected' : '' }}>
                    {{ $loc['name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label for="commune" class="form-label">Commune</label>
        <select name="commune" id="commune" class="form-select">
            @foreach($cities[$location]['communes'] as $key => $comm)
                <option value="{{ $key }}" {{ $key === $commune ? 'selected' : '' }}>
                    {{ $comm['name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" name="date" id="date" value="{{ $date }}" class="form-control">
    </div>

    <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>
