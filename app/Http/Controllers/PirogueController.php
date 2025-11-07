<?php
namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Pirogue;
use Illuminate\Http\Request;

class PirogueController extends Controller
{
    public function index()
    {
        $pirogues = Pirogue::all();
        return view('pirogues.index', compact('pirogues'));
    }

    public function create()
    {
        $pirogue = new Pirogue;
        return view('pirogues.create', compact('pirogue'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'matricule' => 'required|unique:pirogues',
            'nom' => 'required',
            'type' => 'required',
            'date_creation' => 'nullable|date',
        ]);

        Pirogue::create($r->only('matricule', 'nom', 'description', 'type', 'date_creation'));
        return redirect()->route('pirogues.index')->with('success', 'Pirogue créée.');
    }

    public function show(Pirogue $pirogue)
    {
        $pirogue->load('positions');
        return view('pirogues.show', compact('pirogue'));
    }

    public function edit($id)
    {
        $pirogue = Pirogue::findOrFail($id);
        return view('pirogues.edit', compact('pirogue'));
    }

    public function update(Request $r, Pirogue $pirogue)
    {
        $r->validate([
            'nom' => 'required',
            'type' => 'required',
            'date_creation' => 'nullable|date',
        ]);

        $pirogue->update($r->only('nom', 'description', 'type', 'date_creation'));
        return redirect()->route('pirogues.index')->with('success', 'Modifications enregistrées.');
    }

    public function destroy(Pirogue $pirogue)
    {
        $pirogue->delete();
        return redirect()->route('pirogues.index')->with('success', 'Pirogue supprimée.');
    }

    public function map()
    {
        $positions = Position::with('pirogue')->get();
        return view('pirogues.map', compact('positions'));
    }
}
