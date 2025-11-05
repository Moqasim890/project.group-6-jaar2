<?php

namespace App\Http\Controllers;

use App\Models\EvenementModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder as QueryBuilder; // belangrijk: Query\Builder

class EvenementController extends Controller
{
    public function index(Request $request)
    {
        $query = EvenementModel::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('Naam', 'like', "%{$search}%")
                  ->orWhere('Locatie', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('Datum', 'desc')->paginate(10);

        return view('evenements.index', compact('events'));
    }

    public function create()
    {
        $existingDateLocations = EvenementModel::query()
            ->get(['Datum', 'Locatie'])
            ->map(fn($e) => [
                'date' => \Illuminate\Support\Carbon::parse($e->Datum)->format('Y-m-d'),
                'location' => $e->Locatie,
            ])
            ->values()
            ->all();

        return view('evenements.create', compact('existingDateLocations'));
    }

    public function store(Request $request)
    {
        // basisvalidatie
        $data = $request->validate([
            'Naam' => ['required','string','max:255'],
            'Datum' => ['required','date','after_or_equal:today'],
            'Locatie' => ['required','string','max:255'],
            'AantalTicketsPerTijdslot' => ['required','integer','min:0','max:500000'],
            'BeschikbareStands'       => ['required','integer','min:0','max:500000'],
            'IsActief' => ['sometimes','boolean'],
            'Opmerking' => ['nullable','string','max:255'],
        ]);

        // uniek: zelfde Datum + zelfde Locatie niet toegestaan
        $request->validate([
            'Datum' => Rule::unique((new EvenementModel)->getTable(), 'Datum')
                ->where(fn (QueryBuilder $q) => $q->where('Locatie', $request->input('Locatie'))),
        ]);

        // normaliseer checkbox
        $data['IsActief'] = $request->boolean('IsActief');

        EvenementModel::create($data);

        return redirect()->route('evenements.index')->with('ok', 'Evenement succesvol aangemaakt.');
    }

    public function edit(EvenementModel $evenement)
    {
        // stuur andere events mee voor client-side duplicate check
        $existingDateLocations = EvenementModel::query()
            ->where('id', '!=', $evenement->id)
            ->get(['Datum', 'Locatie'])
            ->map(fn($e) => [
                'date' => \Illuminate\Support\Carbon::parse($e->Datum)->format('Y-m-d'),
                'location' => $e->Locatie,
            ])
            ->values()
            ->all();

        return view('evenements.edit', compact('evenement', 'existingDateLocations'));
    }

    public function update(Request $request, EvenementModel $evenement)
    {
        $data = $request->validate([
            'Naam' => ['required','string','max:255'],
            'Datum' => ['required','date','after_or_equal:today'],
            'Locatie' => ['required','string','max:255'],
            'AantalTicketsPerTijdslot' => ['required','integer','min:0','max:500000'],
            'BeschikbareStands'       => ['required','integer','min:0','max:500000'],
            'IsActief' => ['sometimes','boolean'],
            'Opmerking' => ['nullable','string','max:255'],
        ]);

        // uniek met ignore voor deze rij
        $request->validate([
            'Datum' => Rule::unique((new EvenementModel)->getTable(), 'Datum')
                ->where(fn (QueryBuilder $q) => $q->where('Locatie', $request->input('Locatie')))
                ->ignore($evenement->id, 'id'),
        ]);

        $data['IsActief'] = $request->boolean('IsActief');

        $evenement->update($data);

        return redirect()->route('evenements.index')->with('ok', 'Evenement succesvol bijgewerkt.');
    }

    public function show(EvenementModel $evenement)
    {
        return view('evenements.show', compact('evenement'));
    }

    public function destroy(EvenementModel $evenement)
    {
        try {
            if ($evenement->IsActief) {
                return back()->with('error', 'Actieve evenementen kunnen niet worden verwijderd. Zet het evenement eerst inactief.');
            }

            $evenement->delete();

            return back()->with('ok', 'Evenement succesvol verwijderd.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Kon het evenement niet verwijderen: '.$e->getMessage());
        }
    }
}
