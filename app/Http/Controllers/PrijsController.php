<?php

namespace App\Http\Controllers;

use App\Models\PrijsModel;
use Illuminate\Http\Request;

class PrijsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $prijzen = PrijsModel::all();
        return response()->json($prijzen);
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
    public function show(PrijsModel $prijsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrijsModel $prijsModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrijsModel $prijsModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrijsModel $prijsModel)
    {
        //
    }
}
