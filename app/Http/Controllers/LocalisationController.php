<?php
namespace App\Http\Controllers;

use App\Models\Localisation;
use Illuminate\Http\Request;

class LocalisationController extends Controller
{
    // GET /localisations
    public function index()
    {
        $localisations = Localisation::all();
        return view('localisations.index', compact('localisations'));
    }

    // GET /localisations/create
    public function create()
    {
        return view('localisations.create');
    }

    // POST /localisations
    public function store(Request $request)
    {
        // Si vous utilisez un formulaire manuel :
        $request->validate([
            'nom'        => 'required|string|max:255',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        Localisation::create($request->all());

        return redirect()->route('localisations.index')
                         ->with('success', 'Localisation créée avec succès.');
    }

    // GET /localisations/{localisation}
    public function show(Localisation $localisation)
    {
        return view('localisations.show', compact('localisation'));
    }

    // GET /localisations/{localisation}/edit
    public function edit(Localisation $localisation)
    {
        return view('localisations.edit', compact('localisation'));
    }

    // PUT/PATCH /localisations/{localisation}
    public function update(Request $request, Localisation $localisation)
    {
        // Validation si formulaire manuel
        $request->validate([
            'nom'        => 'required|string|max:255',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        $localisation->update($request->all());

        return redirect()->route('localisations.index')
                         ->with('success', 'Localisation mise à jour avec succès.');
    }

    // DELETE /localisations/{localisation}
    public function destroy(Localisation $localisation)
    {
        $localisation->delete();

        return redirect()->route('localisations.index')
                         ->with('success', 'Localisation supprimée avec succès.');
    }

    // POST /api/localisations/update ou /localisations/update
    public function apiUpdate(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'lat'       => 'required|numeric',
            'lng'       => 'required|numeric',
        ]);

        $loc = Localisation::updateOrCreate(
            ['device_id' => $data['device_id']],
            ['latitude'  => $data['lat'], 'longitude' => $data['lng']]
        ); // updateOrCreate garantit création ou mise à jour :contentReference[oaicite:1]{index=1}

        event(new \App\Events\LocalisationUpdated($loc));

        return response()->json(['status' => 'ok']);
    }
}
