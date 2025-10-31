<!DOCTYPE html>
<html>
<head><title>Météo</title></head>
<body>
  <h1>Rechercher la météo</h1>
<form action="{{ url('/weather') }}" method="get">
  @csrf
  <label for="city">Ville :</label>
  <input type="text" id="city" name="city" required>
  <button type="submit">Voir la météo</button>
</form>

  @if ($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
  @endif
</body>
</html>
