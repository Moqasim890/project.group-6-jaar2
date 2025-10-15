<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Evenementmodel;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    public function index(Request $request)
    {
        $query = Evenementmodel::query();

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
        return view('evenements.create');
    }

    public function store(Request $request)
    {
        // Valideer de invoer
        $data = $request->validate([
            'Naam' => 'required|string|max:200',
            'Datum' => 'required|date|after_or_equal:today', // <-- updated
            'Locatie' => 'required|string|max:200',
            'AantalTicketsPerTijdslot' => 'required|integer|min:0',
            'BeschikbareStands' => 'required|integer|min:0',
            'IsActief' => 'boolean',
            'Opmerking' => 'nullable|string',
        ]);
        Evenementmodel::create($data);
        return redirect()->route('evenements.index')->with('ok', 'Evenement succesvol aangemaakt.');
    }

    public function edit(Evenementmodel $evenement)
    {
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, Evenementmodel $evenement)
    {
        $data = $request->validate([
            'Naam' => 'required|string|max:200',
            'Datum' => 'required|date|after_or_equal:today', // <-- updated
            'Locatie' => 'required|string|max:200',
            'AantalTicketsPerTijdslot' => 'required|integer|min:0',
            'BeschikbareStands' => 'required|integer|min:0',
            'IsActief' => 'boolean',
            'Opmerking' => 'nullable|string',
        ]);
        $evenement->update($data);
        return redirect()->route('evenements.index')->with('ok', 'Evenement succesvol bijgewerkt.');
    }

    public function show(Evenementmodel $evenement)
    {
        return view('evenements.show', compact('evenement'));
    }

    // try catch 
    public function destroy(Evenementmodel $evenement)
    {
        try {
            $evenement->delete();
            return back()->with('ok', 'Evenement succesvol verwijderd.');
        } catch (\Exception $e) {
            return back()->with('error', 'Kon het evenement niet verwijderen: ' . $e->getMessage());
        }
    }
}
