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

        // dd($verkopers);
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
                             ->withErrors(['Naam' => 'Deze naam bestaat am l.']);
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

    /*
        naar pagina sturen en checken of de id bestaat
    */
    public function edit($id)
    {
        // voert stored procedure uit en slaat gegevens op in $verkoper
        $verkoper = $this->VerkoperModel->sp_getVerkoperById($id);

        // controleer of er iets is opgehaald
        if (!$verkoper) {
            // als er niks is opgehaald redirect terug met fout melding
            return redirect()->back()->with('error', 'Deze verkoper bestaat niet.');
        }

        // dd($verkoper);

        // de view
        return view(
        'verkoper.edit', [
            'title' => 'verkoper wijzigen'
        ], compact('verkoper'));
    }

    /*
    *   probleem:
    *   check of naam in array zit wat zo is
    *   als je iets anders dan naam weizigd dan krijg je error
    */
    public function update(Request $request, $id)
    {
        // haalt data op uit request en valideert het en zet het in $data
        $data = $request->validate([
            'Naam'          => 'required|string|max:200',
            'SpecialeStatus'=> 'required|string',
            'VerkooptSoort' => 'required|string',
            'StandType'     => 'required|string',
            'Dagen'         => 'required|string',
            'LogoUrl'       => 'nullable|string|max:500',
            'IsActief'      => 'nullable|boolean',
        ]);

        // Checkbox fix
        $data['IsActief'] = $request->has('IsActief');


        $verkopers = $this->VerkoperModel->sp_GetAllVerkopers();
        
        $namen = [];

        // verzamel eerst alle namen
        foreach ($verkopers as $verkoper) {
            $namen[] = $verkoper->Naam; // <-array vullen met alle namen die in verkoper zitten
        }

        // controleer of de ingevoerde naam al voorkomt
        if (in_array($data['Naam'], $namen)) {
            return redirect()->back()->with('error', 'Deze naam wordt al gebruikt.');
        }


        // controlleert of Naam of logoUrl alleen nummers zijn want dat mag niet van mazin
        if (is_numeric($data['Naam']) || is_numeric($data['LogoUrl'])) {
            // stuurt terug naar edit met melding
            return redirect()->back()->with('error', 'Mag niet alleen getallen zijn');
        }

        // voer stored procedure uit met gevalideerde data en id
        $this->VerkoperModel->sp_UpdateVerkoper($id, $data);

        // redirect naar index met success melding
        return redirect()->route('verkoper.index')->with('success', 'Verkoper bijgewerkt!');
    }

    /*
        Verwijder verkoper op id
    */
    public function destroy($id)
    {   
        $verkoper = $this->VerkoperModel->sp_getVerkoperById($id);

        if ($verkoper->IsActief) {
            return redirect()->back()
                            ->with('error', 'Deze gebruiker is nog actief');
        }

        // voer stored procedure uit en sla het resultaat op in $result
        $result = $this->VerkoperModel->sp_DeleteVerkoper($id);

        // controleer of de verkoper succesvol is verwijderd
        if ($result > 0) {
            // redirect naar de index met een succes melding
            return redirect()->route('verkoper.index')
                             ->with('success', 'Verkoper is succesvol verwijdert.');
        }

        // als verwijderen is mislukt redirect terug met een fout melding
        return redirect()->route('verkoper.index')
                         ->with('error', 'Verkoper is niet gevonden of niet verwijderd.');
    }
}
