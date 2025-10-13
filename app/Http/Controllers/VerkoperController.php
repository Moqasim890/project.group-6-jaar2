<?php

namespace App\Http\Controllers;

use App\Models\Verkoper;
use App\Models\VerkoperModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerkoperController extends Controller
{
    /**
     * Lijst met alle verkopers.
     */
    public function index(): View
    {
        $verkopers = VerkoperModel::all();

        return view('verkoper.index', compact('verkopers'));
    }

    /**
     * Formulier voor nieuwe verkoper.
     */
    public function create(): View
    {
        return view('verkoper.create', [
            'title' => 'Verkoper toevoegen'
        ]);
    }

    /**
     * Opslaan van nieuwe verkoper.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'Naam'          => 'required|string|max:200',
            'SpecialeStatus'=> 'nullable|string',
            'VerkooptSoort' => 'required|string',
            'StandType'     => 'nullable|string',
            'Dagen'         => 'nullable|string',
            'LogoUrl'       => 'nullable|string|max:500',
            'IsActief'      => 'nullable|boolean',
            'Opmerking'     => 'nullable|string',
        ]);

        VerkoperModel::create($data);

        return redirect()->route('verkoper.index')->with('success', 'Verkoper toegevoegd!');
        // Als je plural route names gebruikt: ->route('verkopers.index')
    }

    /**
     * Toon één verkoper.
     */
    public function show(VerkoperModel $verkoper): View
    {
        return view('verkoper.show', compact('verkoper'));
    }

    /**
     * Formulier bewerken van een verkoper.
     */
    public function edit(VerkoperModel $verkoper): View
    {
        return view('verkoper.edit', compact('verkoper'));
    }

    /**
     * Update een verkoper.
     */
    public function update(Request $request, VerkoperModel $verkoper): RedirectResponse
    {
        $data = $request->validate([
            'Naam'          => 'required|string|max:200',
            'SpecialeStatus'=> 'nullable|string',
            'VerkooptSoort' => 'required|string',
            'StandType'     => 'nullable|string',
            'Dagen'         => 'nullable|string',
            'LogoUrl'       => 'nullable|string|max:500',
            'IsActief'      => 'nullable|boolean',
            'Opmerking'     => 'nullable|string',
        ]);

        $verkoper->update($data);

        return redirect()->route('verkoper.index')->with('success', 'Verkoper bijgewerkt!');
    }

    /**
     * Verwijder een verkoper.
     */
    public function destroy(VerkoperModel $verkoper): RedirectResponse
    {
        $verkoper->delete();

        return redirect()->route('verkoper.index')->with('success', 'Verkoper verwijderd!');
    }
}
