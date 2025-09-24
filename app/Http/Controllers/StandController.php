<?php

namespace App\Http\Controllers;

use App\Models\Standmodel;
use App\Models\Evenementmodel;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function index() {
        $stands = Standmodel::with('evenement')->latest('DatumAangemaakt')->paginate(10);
        return view('stands.index', compact('stands'));
    }

    public function create() {
        $events = Evenementmodel::orderBy('Datum','desc')->get(['id','Naam']);
        return view('stands.create', compact('events'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'EvenementId'  => 'required|exists:evenements,id',
            'VerkoperId'   => 'required|integer', // FK; validated by the other team later
            'StandType'    => 'required|in:A,AA,AAplus',
            'Prijs'        => 'required|numeric|min:0',
            'VerhuurdStatus'=> 'boolean',
            'IsActief'     => 'boolean',
            'Opmerking'    => 'nullable|string',
        ]);
        Standmodel::create($data);
        return redirect()->route('stands.index')->with('ok','Stand gemaakt.');
    }

    public function edit(Standmodel $stand) {
        $events = Evenementmodel::orderBy('Datum','desc')->get(['id','Naam']);
        return view('stands.edit', compact('stand','events'));
    }

    public function update(Request $request, Standmodel $stand) {
        $data = $request->validate([
            'EvenementId'  => 'required|exists:evenements,id',
            'VerkoperId'   => 'required|integer',
            'StandType'    => 'required|in:A,AA,AAplus',
            'Prijs'        => 'required|numeric|min:0',
            'VerhuurdStatus'=> 'boolean',
            'IsActief'     => 'boolean',
            'Opmerking'    => 'nullable|string',
        ]);
        $stand->update($data);
        return redirect()->route('stands.index')->with('ok','Stand bijgewerkt.');
    }

    public function destroy(Standmodel $stand) {
        $stand->delete();
        return back()->with('ok','Stand verwijderd.');
    }
}
