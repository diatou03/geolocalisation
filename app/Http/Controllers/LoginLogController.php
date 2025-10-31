<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginLog;

class LoginLogController extends Controller
{
    // 1️⃣ Affiche le formulaire de connexion
    public function index()
    {
        return view('login.index');
    }

    // 2️⃣ Traite la connexion
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Sauvegarder le log de connexion
            $ip = $request->ip();
            $geo = @json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);

            LoginLog::create([
                'user_id'   => Auth::id(),
                'ip'        => $ip,
                'city'      => $geo['city'] ?? 'Inconnue',
                'country'   => $geo['country'] ?? 'Inconnu',
                'latitude'  => $geo['lat'] ?? null,
                'longitude' => $geo['lon'] ?? null,
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects. Veuillez réessayer.',
        ])->onlyInput('email');
    }

    // 3️⃣ Formulaire d’inscription
    public function registerForm()
    {
        return view('login.register');
    }

    // 4️⃣ Enregistrement d’un nouvel utilisateur
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:4|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // 5️⃣ Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome'); // redirige vers la page publique
    }

    // 6️⃣ Affiche les logs de connexion
    public function logs()
    {
        $logs = LoginLog::with('user')->latest()->get();
        return view('login.logs', compact('logs'));
    }
}
