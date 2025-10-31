@extends('layouts.app')

@section('title', 'Connexion | Nap Ak Karangue')

@section('content')
<div class="login-container">
    <h2>Connexion</h2>

    {{-- Message d'erreur --}}
    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    {{-- Validation --}}
    @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <input type="email" name="email" placeholder="Adresse e-mail" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>

    <div class="signup-link">
        <p>Pas encore inscrit ? <a href="{{ route('register') }}">S'inscrire</a></p>
    </div>
</div>

<style>
.login-container {
    max-width: 400px;
    margin: 5rem auto;
    padding: 2rem;
    background-color: white;
    border-radius: 1rem;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.login-container h2 { text-align:center; color: rgb(171,100,19); margin-bottom:1.5rem; }
.login-container input, .login-container button { margin-bottom:1rem; padding:0.6rem 1rem; border-radius:0.5rem; border:1px solid #ccc; }
.login-container button { background-color: rgb(171,100,19); color:white; border:none; cursor:pointer; font-weight:600; }
.login-container button:hover { background-color:#0d1a3f; }
.signup-link { text-align:center; font-size:0.95rem; }
.signup-link a { color: rgb(171,100,19); font-weight:600; text-decoration:none; }
.signup-link a:hover { text-decoration:underline; }
.error-message { color:red; margin-bottom:1rem; font-weight:600; }
</style>
@endsection
