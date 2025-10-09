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
        return view('Tickets.index', compact( 'evenementen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TicketModel::createTicket($request->all());
        return redirect()->route('Tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = TicketModel::getTicketByID($id);
        return view('Tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        TicketModel::updateTicket($id, $request->all());
        return redirect()->route('Tickets.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TicketModel::deleteTicket($id);
        return redirect()->route('Tickets.index');
    }

    public function showkopen($id){

        $evenement = TicketModel::getEventByID($id);
        $prijzen = TicketModel::getTicketsByEventID($id);
        return view('Tickets.kopen', compact('evenement', 'prijzen'));
    }

    public function kopen(){
        $data = request()->validate([
            'evenement_id' => 'required|exists:evenements,id',
            'aantal' => 'required|array',
        ]);

        $data['ticketids'] = array_keys($data['aantal']);
        $res = TicketModel::kopenTicket($data);

        if($res){
            return redirect()->route('Tickets.index');
        }
        else{
            return redirect()->route("Tickets.kopen");
        }
        // Verwerk de aankoop van tickets hier

        // return redirect()->route('Tickets.index');
    
    }
}
