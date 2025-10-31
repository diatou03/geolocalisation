@extends('layouts.app')

@section('title', 'Inscription | Nap Ak Karangue')

@section('content')
<div class="register-container">
    <h2>Inscription</h2>

    @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <input type="text" name="name" placeholder="Nom complet" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Adresse e-mail" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>

    <div class="login-link">
        <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
    </div>
</div>

<style>
.register-container {
    max-width: 400px;
    margin: 5rem auto;
    padding: 2rem;
    background-color: white;
    border-radius: 1rem;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.register-container h2 { text-align:center; color: rgb(171,100,19); margin-bottom:1.5rem; }
.register-container input, .register-container button { margin-bottom:1rem; padding:0.6rem 1rem; border-radius:0.5rem; border:1px solid #ccc; }
.register-container button { background-color: rgb(171,100,19); color:white; border:none; cursor:pointer; font-weight:600; }
.register-container button:hover { background-color:#0d1a3f; }
.login-link { text-align:center; font-size:0.95rem; }
.login-link a { color: rgb(171,100,19); font-weight:600; text-decoration:none; }
.login-link a:hover { text-decoration:underline; }
.error-message { color:red; margin-bottom:1rem; font-weight:600; }
</style>
@endsection
