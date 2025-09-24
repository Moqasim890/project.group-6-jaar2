<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Evenementmodel;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    public function index() {
        $events = Evenementmodel::orderBy('Datum','desc')->paginate(10);
        return view('evenements.index', compact('events'));
    }

    public function create() {
        return view('evenements.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'Naam' => 'required|string|max:200',
            'Datum' => 'required|date',
            'Locatie' => 'required|string|max:200',
            'AantalTicketsPerTijdslot' => 'required|integer|min:0',
            'BeschikbareStands' => 'required|integer|min:0',
            'IsActief' => 'boolean',
            'Opmerking' => 'nullable|string',
        ]);
        Evenementmodel::create($data);
        return redirect()->route('evenements.index')->with('ok','Evenement gemaakt.');
    }

    public function edit(Evenementmodel $evenement) {
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, Evenementmodel $evenement) {
        $data = $request->validate([
            'Naam' => 'required|string|max:200',
            'Datum' => 'required|date',
            'Locatie' => 'required|string|max:200',
            'AantalTicketsPerTijdslot' => 'required|integer|min:0',
            'BeschikbareStands' => 'required|integer|min:0',
            'IsActief' => 'boolean',
            'Opmerking' => 'nullable|string',
        ]);
        $evenement->update($data);
        return redirect()->route('evenements.index')->with('ok','Evenement bijgewerkt.');
    }

    public function destroy(Evenementmodel $evenement) {
        $evenement->delete();
        return back()->with('ok','Evenement verwijderd.');
    }
}
