<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Evenement;
=======
use App\Models\EvenementModel;
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
use Illuminate\Http\Request;

class EvenementController extends Controller
{
<<<<<<< HEAD
    public function index() {
        $events = Evenement::orderBy('Datum','desc')->paginate(10);
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
        Evenement::create($data);
        return redirect()->route('evenements.index')->with('ok','Evenement gemaakt.');
    }

    public function edit(Evenement $evenement) {
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, Evenement $evenement) {
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

    public function destroy(Evenement $evenement) {
        $evenement->delete();
        return back()->with('ok','Evenement verwijderd.');
=======
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EvenementModel $evenementModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EvenementModel $evenementModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EvenementModel $evenementModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EvenementModel $evenementModel)
    {
        //
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
    }
}
