<?php

namespace App\Http\Controllers;

use App\Models\Verkoper;
use App\Models\VerkoperModel;
use Illuminate\Auth\Events\Validated;
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
        $verkopers = $this->VerkoperModel->sp_GetAllVerkopers();

        return view('verkoper.index', [
            'verkopers' => $verkopers
        ]);
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
    {
        // data uit de request valideren en opslaan in de $data variabele
        $data = $request->validate(
            [ 
              'Naam' =>          'required|string|max:200',
              'SpecialeStatus'=> 'nullable|string', 
              'VerkooptSoort' => 'required|string', 
              'StandType' =>     'nullable|string', 
              'Dagen' =>         'nullable|string', 
              'LogoUrl' =>       'nullable|string|max:500', 
              'IsActief' =>      'nullable|boolean', 
              'Opmerking' =>     'nullable|string', 
            ]
        ); 
        
        $data['IsActief'] = true; // <- IsActief is altijd TRUE tenzij anders wordt aangegeven
        $data['Opmerking'] = $data['Opmerking'] ?? ''; // <- Opmerking is een database systeemveld die altijd leeg is tenzij anders aangegeven 
        
        // checkt of sp_GetVerkoperByNaam TRUE is
        // als het TRUE is laat "error" zien
        if ($this->VerkoperModel->sp_GetVerkoperByNaam($data['Naam']))
        { 
            //     redirect naar zelfde pagina
            return redirect()->back() 
                            // met inputs zodat niet alles opnieuw ingevuld hoeft te worden
                             ->withInput()
                            // met errors met als Key Naam en Value ...
                             ->withErrors(['Naam' => 'Deze naam bestaat al.']); 
        } 
        
        // roep stored procedure aan in model en geef data mee
        $this->VerkoperModel->sp_CreateVerkoper( 
            $data['Naam'], 
            $data['SpecialeStatus'], 
            $data['VerkooptSoort'], 
            $data['StandType'], 
            $data['Dagen'], 
            $data['LogoUrl'], 
            $data['IsActief'], 
            $data['Opmerking'] 
        ); 
        
        //     redirect naar index
        return redirect()->route('verkoper.index')
                        // met melding met als Key success en Value ... 
                         ->with('success', "Verkoper is succesvol toegevoegd:" . $data['Naam']); 
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
            'SpecialeStatus'=> 'required|string',
            'VerkooptSoort' => 'required|string',
            'StandType'     => 'required|string',
            'Dagen'         => 'required|string',
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
