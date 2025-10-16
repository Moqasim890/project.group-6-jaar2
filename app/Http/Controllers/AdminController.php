<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrijsModel;
use App\Models\EvenementModel;

class AdminController extends Controller
{
    // Display all prijzen for admin
    public function index()
    {
        $prijzen = PrijsModel::getAllPrijzen();
        return view('admin.prijzen.index', compact('prijzen'));
    }

    // Show form to create new prijs
    public function create()
    {
        $evenements = EvenementModel::getAllEvents();
        return view('admin.prijzen.create', compact('evenements'));
    }

    // Store new prijs
    public function store(Request $request)
    {
        $validated = $request->validate([
            'evenement_id' => 'required|integer',
            'datum' => 'required|date|after_or_equal:today',
            'tijdslot' => 'required',
            'tarief' => 'required|numeric|min:0.01',
            'opmerking' => 'nullable|string'
        ], [
            'datum.after_or_equal' => 'De datum mag niet in het verleden liggen.',
            'tarief.min' => 'Het tarief moet minimaal €0.01 zijn.'
        ]);

        // Check for duplicates before calling stored procedure
        $duplicate = \Illuminate\Support\Facades\DB::selectOne(
            'SELECT COUNT(*) as count FROM prijzen
             WHERE EvenementId = ? AND Datum = ? AND Tijdslot = ? AND IsActief = 1',
            [$validated['evenement_id'], $validated['datum'], $validated['tijdslot']]
        );

        if ($duplicate->count > 0) {
            return back()
                ->withErrors(['tijdslot' => 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.'])
                ->withInput();
        }

        try {
            PrijsModel::createPrijs(
                $validated['evenement_id'],
                $validated['datum'],
                $validated['tijdslot'],
                $validated['tarief'],
                $validated['opmerking']
            );

            return redirect()->route('admin.prijzen.index')
                ->with('success', 'Ticket prijs succesvol aangemaakt!');
        } catch (\Exception $e) {
            // Handle database errors (including SIGNAL from stored procedure)
            if (str_contains($e->getMessage(), 'bestaat al een prijs')) {
                return back()
                    ->withErrors(['tijdslot' => 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.'])
                    ->withInput();
            }

            return back()
                ->withErrors(['error' => 'Er is een fout opgetreden bij het aanmaken van de prijs.'])
                ->withInput();
        }
    }

    // Show form to edit prijs
    public function edit($id)
    {
        $prijs = PrijsModel::getPrijsById($id);
        $evenements = EvenementModel::getAllEvents();

        if (!$prijs) {
            return redirect()->route('admin.prijzen.index')
                ->with('error', 'Ticket prijs niet gevonden!');
        }

        return view('admin.prijzen.edit', compact('prijs', 'evenements'));
    }

    // Update existing prijs
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'evenement_id' => 'required|integer',
            'datum' => 'required|date|after_or_equal:today',
            'tijdslot' => 'required',
            'tarief' => 'required|numeric|min:0.01',
            'is_actief' => 'required|boolean',
            'opmerking' => 'nullable|string'
        ], [
            'datum.after_or_equal' => 'De datum mag niet in het verleden liggen.',
            'tarief.min' => 'Het tarief moet minimaal €0.01 zijn.'
        ]);

        // Check for duplicates (excluding current record)
        $duplicate = \Illuminate\Support\Facades\DB::selectOne(
            'SELECT COUNT(*) as count FROM prijzen
             WHERE EvenementId = ? AND Datum = ? AND Tijdslot = ? AND IsActief = 1 AND id != ?',
            [$validated['evenement_id'], $validated['datum'], $validated['tijdslot'], $id]
        );

        if ($duplicate->count > 0) {
            return back()
                ->withErrors(['tijdslot' => 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.'])
                ->withInput();
        }

        try {
            $affected = PrijsModel::updatePrijs(
                $id,
                $validated['evenement_id'],
                $validated['datum'],
                $validated['tijdslot'],
                $validated['tarief'],
                $validated['is_actief'],
                $validated['opmerking']
            );

            if ($affected > 0) {
                return redirect()->route('admin.prijzen.index')
                    ->with('success', 'Ticket prijs succesvol bijgewerkt!');
            }

            return redirect()->route('admin.prijzen.index')
                ->with('error', 'Ticket prijs kon niet worden bijgewerkt!');
        } catch (\Exception $e) {
            // Handle database errors (including SIGNAL from stored procedure)
            if (str_contains($e->getMessage(), 'bestaat al een prijs')) {
                return back()
                    ->withErrors(['tijdslot' => 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.'])
                    ->withInput();
            }

            return back()
                ->withErrors(['error' => 'Er is een fout opgetreden bij het bijwerken van de prijs.'])
                ->withInput();
        }
    }

    // Delete prijs
    public function destroy($id)
    {
        $affected = PrijsModel::deletePrijs($id);

        if ($affected > 0) {
            return redirect()->route('admin.prijzen.index')
                ->with('success', 'Ticket prijs succesvol verwijderd!');
        }

        return redirect()->route('admin.prijzen.index')
            ->with('error', 'Ticket prijs kon niet worden verwijderd!');
    }
}
