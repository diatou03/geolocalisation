<?php

namespace App\Http\Controllers;

use App\Models\AgentMarin;
use Illuminate\Http\Request;

class AgentMarinController extends Controller
{
    /**
     * Afficher la liste des agents marins.
     */
    public function index()
    {
        $agents = AgentMarin::latest()->get();
        return view('agent_marins.index', compact('agents'));
    }

    /**
     * Afficher le formulaire de création d'un agent marin.
     */
    public function create()
    {
        return view('agent_marins.create');
    }

    /**
     * Enregistrer un nouvel agent marin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string',
            'email' => 'nullable|email',
            'poste' => 'nullable|string'
        ]);

        AgentMarin::create($request->all());

        return redirect()->route('agent_marins.index')->with('success', 'Agent ajouté avec succès.');
    }

    /**
     * Afficher les détails d'un agent marin spécifique.
     */
    public function show($id)
    {
        $agent = AgentMarin::findOrFail($id);
        return view('agent_marins.show', compact('agent'));
    }

    /**
     * Afficher le formulaire d'édition d'un agent marin.
     */
    public function edit($id)
    {
        $agent = AgentMarin::findOrFail($id);
        return view('agent_marins.edit', compact('agent'));
    }

    /**
     * Mettre à jour un agent marin existant.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string',
            'email' => 'nullable|email',
            'poste' => 'nullable|string'
        ]);

        $agent = AgentMarin::findOrFail($id);
        $agent->update($request->all());

        return redirect()->route('agent_marins.index')->with('success', 'Agent mis à jour avec succès.');
    }

    /**
     * Supprimer un agent marin.
     */
    public function destroy($id)
    {
        $agent = AgentMarin::findOrFail($id);
        $agent->delete();

        return redirect()->route('agent_marins.index')->with('success', 'Agent supprimé avec succès.');
    }
    
}
