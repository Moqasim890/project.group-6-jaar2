<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrijsModel;
use App\Models\EvenementModel;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isNull;

/**
 * AdminController - Beheer van ticket prijzen voor administrators
 * 
 * Deze controller handelt alle CRUD operaties af voor het beheren van ticket prijzen
 * door admin gebruikers. Alle data operaties worden uitgevoerd via stored procedures
 * in PrijsModel voor database consistentie en beveiliging.
 * 
 * Routes:
 * - GET    /admin/prijzen          -> index()    Overzicht van alle prijzen
 * - GET    /admin/prijzen/create   -> create()   Formulier voor nieuwe prijs
 * - POST   /admin/prijzen          -> store()    Opslaan nieuwe prijs
 * - GET    /admin/prijzen/{id}/edit-> edit()     Formulier voor bewerken prijs
 * - PUT    /admin/prijzen/{id}     -> update()   Bijwerken bestaande prijs
 * - DELETE /admin/prijzen/{id}     -> destroy()  Verwijderen (soft delete) prijs
 * 
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Toon overzichtspagina met alle actieve prijzen
     * 
     * Haalt alle actieve ticket prijzen op inclusief evenement informatie
     * en toont deze in een tabel met bewerk/verwijder opties.
     * 
     * @return \Illuminate\View\View View met prijzen collectie
     */
    public function index()
    {
        // Haal alle actieve prijzen op via stored procedure
        $prijzen = PrijsModel::getAllPrijzen();
        
        // Retourneer index view met prijzen data
        return view('admin.prijzen.index', compact('prijzen'));
    }

    /**
     * Toon formulier voor het aanmaken van een nieuwe prijs
     * 
     * Laadt alle beschikbare evenementen voor de dropdown selectie.
     * Gebruiker moet een evenement kiezen voordat een prijs kan worden aangemaakt.
     * 
     * @return \Illuminate\View\View View met evenementen collectie
     */
    public function create()
    {
        // Haal alle evenementen op voor dropdown selectie
        $evenements = EvenementModel::getAllEvents();
        
        // Retourneer create view met evenementen data
        return view('admin.prijzen.create', compact('evenements'));
    }

    /**
     * Sla nieuwe ticket prijs op in database
     * 
     * Valideert invoer en controleert op duplicaten voordat de stored procedure
     * wordt aangeroepen. Een prijs is uniek per combinatie van evenement, datum en tijdslot.
     * 
     * Validatie regels:
     * - evenement_id: Verplicht, moet bestaan in evenements tabel
     * - datum: Verplicht, mag niet in verleden liggen
     * - tijdslot: Verplicht, moet 08:00, 11:00 of 14:00 zijn
     * - tarief: Verplicht, tussen €0.01 en €999.99
     * - opmerking: Optioneel, vrije tekst
     * 
     * @param \Illuminate\Http\Request $request HTTP request met form data
     * @return \Illuminate\Http\RedirectResponse Redirect naar index met success/error bericht
     */
    public function store(Request $request)
    {
        // Valideer alle invoervelden met custom foutmeldingen
        $validated = $request->validate([
            'evenement_id' => 'required|integer',
            'datum' => 'required|date|after_or_equal:today',
            'tijdslot' => 'required',
            'tarief' => 'required|numeric|min:0.01|max:999.99',
            'opmerking' => 'nullable|string'
        ], [
            'datum.after_or_equal' => 'De datum mag niet in het verleden liggen.',
            'tarief.min' => 'Het tarief moet minimaal €0.01 zijn.',
            'tarief.max' => 'Het tarief moet maximaal 999.99 zijn'
        ]);

        // Extra controle op duplicaten voor betere gebruikerservaring
        // Voorkomt onnodige stored procedure aanroepen bij duidelijke duplicaten
        $duplicate = \Illuminate\Support\Facades\DB::selectOne(
            'SELECT COUNT(*) as count FROM prijzen
             WHERE EvenementId = ? AND Datum = ? AND Tijdslot = ? AND IsActief = 1',
            [$validated['evenement_id'], $validated['datum'], $validated['tijdslot']]
        );

        // Als duplicaat gevonden, toon specifieke foutmelding en behoud invoer
        if ($duplicate->count > 0) {
            return back()
                ->withErrors(['tijdslot' => 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.'])
                ->withInput();
        }

        try {
            // Roep stored procedure aan om nieuwe prijs aan te maken
            PrijsModel::createPrijs(
                $validated['evenement_id'],
                $validated['datum'],
                $validated['tijdslot'],
                $validated['tarief'],
                $validated['opmerking']
            );

            // Succesvol aangemaakt - redirect naar overzicht met success bericht
            return redirect()->route('admin.prijzen.index')
                ->with('success', 'Ticket prijs succesvol aangemaakt!');
        } catch (\Exception $e) {
            // Bij database fouten, ga terug met foutmelding en behoud invoer
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Toon formulier voor het bewerken van een bestaande prijs
     * 
     * Laadt de specifieke prijs gegevens en alle evenementen voor de dropdowns.
     * Controleert of de prijs bestaat voordat het formulier wordt getoond.
     * 
     * @param int $id De ID van de prijs die bewerkt moet worden
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View 
     *         Redirect bij niet gevonden, anders view met prijs en evenementen data
     */
    public function edit($id)
    {
        // Haal specifieke prijs op (inclusief inactieve prijzen voor admin)
        $prijs = PrijsModel::getPrijsById($id);
        
        // Haal alle evenementen op voor dropdown selectie
        $evenements = EvenementModel::getAllEvents();

        // Controleer of prijs bestaat
        if (!$prijs) {
            return redirect()->route('admin.prijzen.index')
                ->with('error', 'Ticket prijs niet gevonden!');
        }

        // Retourneer edit view met prijs en evenementen data
        return view('admin.prijzen.edit', compact('prijs', 'evenements'));
    }

    /**
     * Update bestaande ticket prijs in database
     * 
     * Valideert alle wijzigingen en update de prijs via stored procedure.
     * Admin kan ook de IsActief status wijzigen om prijzen te deactiveren
     * zonder deze volledig te verwijderen.
     * 
     * Validatie regels:
     * - evenement_id: Verplicht, moet bestaan in evenements tabel
     * - datum: Verplicht, mag niet in verleden liggen
     * - tijdslot: Verplicht, moet 08:00, 11:00 of 14:00 zijn
     * - tarief: Verplicht, tussen €0.01 en €999.99
     * - is_actief: Verplicht, 0 of 1
     * - opmerking: Optioneel, vrije tekst
     * 
     * @param \Illuminate\Http\Request $request HTTP request met form data
     * @param int $id De ID van de prijs die bijgewerkt moet worden
     * @return \Illuminate\Http\RedirectResponse Redirect naar index met success/error bericht
     */
    public function update(Request $request, $id)
    {
        // Valideer alle invoervelden inclusief is_actief status
        $validated = $request->validate([
            'evenement_id' => 'required|integer',
            'datum' => 'required|date|after_or_equal:today',
            'tijdslot' => 'required',
            'tarief' => 'required|numeric|min:0.01|max:999.99',
            'is_actief' => 'required|boolean',
            'opmerking' => 'nullable|string'
        ], [
            'datum.after_or_equal' => 'De datum mag niet in het verleden liggen.',
            'tarief.min' => 'Het tarief moet minimaal €0.01 zijn.',
            'tarief.max' => 'Het tarief moet maximaal 999.99 zijn'
        ]);

        try {
            // Roep stored procedure aan om prijs bij te werken
            // Opmerking wordt als lege string meegegeven indien niet ingevuld
            $res = PrijsModel::updatePrijs(
                $id,
                $validated['evenement_id'],
                $validated['datum'],
                $validated['tijdslot'],
                $validated['tarief'],
                $validated['is_actief'],
                $validated['opmerking'] ?? ''
            );

            // Controleer of er daadwerkelijk een rij is bijgewerkt
            if ($res->Affected > 0) {
                return redirect()->route('admin.prijzen.index')
                    ->with('success', 'Ticket is succesvol verwijderd');
            }

            // Geen rijen bijgewerkt - mogelijk duplicate of andere validatie fout
            return redirect()->route('admin.prijzen.index')
                ->with('error', $res->message);
        } catch (\Exception $e) {
            // Bij database fouten, ga terug met foutmelding en behoud invoer
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Verwijder (deactiveer) een ticket prijs
     * 
     * Voert een soft delete uit door IsActief op 0 te zetten via stored procedure.
     * Dit voorkomt foreign key problemen met gekochte tickets en behoudt historische data.
     * Fysiek verwijderen uit database is niet mogelijk als er tickets aan gekoppeld zijn.
     * 
     * @param int $id De ID van de prijs die verwijderd moet worden
     * @return \Illuminate\Http\RedirectResponse Redirect naar index met success/error bericht
     */
    public function destroy($id)
    {
        // Roep stored procedure aan voor soft delete (IsActief = 0)
        $res = PrijsModel::deletePrijs($id);

        // Controleer of er daadwerkelijk een rij is bijgewerkt
        if ($res->Affected > 0) {
            return redirect()->route('admin.prijzen.index')
                ->with('success', 'Ticket prijs succesvol verwijderd!');
        }

        // Geen rijen bijgewerkt - mogelijk al verwijderd of bestaat niet
        return redirect()->route('admin.prijzen.index')
            ->with('error', $res->message ?? 'Er is een fout opgetreden bij het verwijderen van de ticket prijs.');
    }
}
