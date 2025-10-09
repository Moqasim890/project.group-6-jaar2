<?php

namespace App\Http\Controllers;

use App\Models\TicketModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenementen = TicketModel::getAllEvents();

        return view('Tickets.index', compact( 'evenementen', 'prijzen'));
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
    public function show()
    {
        //van de evenementen pagina de tickets tonen(prijzen)
        return "";
        //view('Tickets.show', compact( 'prijzen', 'evenement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketModel $ticketModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketModel $ticketModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketModel $ticketModel)
    {
        //
    }
}
