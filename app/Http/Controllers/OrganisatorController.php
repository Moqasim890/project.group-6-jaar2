<?php

namespace App\Http\Controllers;

use App\Models\OrganisatorModel;
use Illuminate\Http\Request;

class OrganisatorController extends Controller
{
    //defiëneren Property
    private $OrganisatorModel;

    public function __construct()
    {
        //Object maken en toevoegen aan Property zodat model kan aangeroepen worden
        $this->OrganisatorModel = new OrganisatorModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //opslaan results in $verkopers
        $verkopers = $this->OrganisatorModel->sp_GetAllverkopers();

        //weergeven view en data meegeven
        return view('verkopers.index', [
            'verkopers' => $verkopers
        ]);
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
    public function show(OrganisatorModel $OrganisatorModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganisatorModel $OrganisatorModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganisatorModel $OrganisatorModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganisatorModel $OrganisatorModel)
    {
        //
    }
}
