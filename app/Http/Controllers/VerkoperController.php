<?php

namespace App\Http\Controllers;

use App\Models\Verkoper;
use App\Models\VerkoperModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerkoperController extends Controller
{

    private $VerkoperModel;

    public function __construct()
    {
        $this->VerkoperModel = new VerkoperModel();
    }
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
    public function store(Request $request)

    // Voeg commentaar toe
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

        // Set default values if not present
        $data['IsActief'] = $data['IsActief'] ?? false;
        $data['Opmerking'] = $data['Opmerking'] ?? '';

        $newId = $this->VerkoperModel->sp_CreateVerkoper(
            $data['Naam'],
            $data['SpecialeStatus'],
            $data['VerkooptSoort'],
            $data['StandType'],
            $data['Dagen'],
            $data['LogoUrl'],
            $data['IsActief'],
            $data['Opmerking']
        );

        return redirect()->route('verkoper.index')
                         ->with('success', "Allergeen is succesvol toegevoegd met id" . $newId);
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
