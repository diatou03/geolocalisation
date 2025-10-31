<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <h1> Méteo</h1>
    <form method="GET" action="{{ route('weather.fetch') }}">
    <label for="city">Ville :</label>
    <input type="text" name="city" id="city" value="{{ old('city', 'Kaolack') }}">
    <button type="submit">Rechercher</button>
</form>

</head>
<body>
    
</body>
</html>