<?php

namespace App\Http\Controllers;
use App\Models\Pirogue;
use App\Models\Alerte;
use Illuminate\Http\Request;

class AlerteController extends Controller
{
    // Afficher la liste des alertes
    public function show(Alerte $alerte)
{
    return view('alertes.show', compact('alerte'));
}

public function index()
{
    $alertes = Alerte::with('pirogue')->latest()->paginate(15);
    return view('alertes.index', compact('alertes'));
}

   public function send(Alerte $alerte) {
    return view('alertes.send', compact('alerte'));
}

public function edit(Alerte $alerte) {
    $pirogues = Pirogue::all();
    return view('alertes.edit', compact('alerte', 'pirogues'));
}


public function create() {
    return view('alertes.create', [
        'alerte' => new Alerte,
        'pirogues' => Pirogue::all(),
    ]);
}
public function map()
{
    $positions = Alerte::with('pirogue')
        ->latest()
        ->take(50)
        ->get()
        ->map(fn($a) => [
            'latitude'    => $a->latitude,
            'longitude'   => $a->longitude,
            'pirogue_nom' => $a->pirogue->nom,
            'message'     => $a->message,
            'created_at'  => $a->created_at->toDateTimeString(),
        ]);

    return view('alertes.map', compact('positions'));
}
 public function store(Request $request)
    {
        $alerte = Alerte::create($request->all());
    // Par exemple si vous déclenchez un envoi via email ou broadcast ici
    $alerte->envoyee = true;
    $alerte->save();

    return redirect()->route('alertes.index')
                     ->with('success', 'Alerte créée et envoyée.');
    }
    
}
