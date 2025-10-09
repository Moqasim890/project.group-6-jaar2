<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TicketModel extends Model
{
    function getAllTickets()
    {
        return DB::select('CALL SP_GetAllTickets()');
    }

    function getTicketById($id)
    {
        return DB::select('CALL SP_GetTicketById(?)', [$id]);
    }

    function createTicket($data)
    {
        return DB::select('CALL SP_CreateTicket(?, ?, ?)', [$data['name'], $data['price'], $data['event_id']]);
    }
    function getTicketsByEventId($eventId)
    {
        return DB::select('CALL SP_GetTicketsByEventId(?)', [$eventId]);
    }

    function updateTicket($id, $data)
    {
        return DB::select('CALL SP_UpdateTicket(?, ?, ?, ?)', [$id, $data['name'], $data['price'], $data['event_id']]);
    }
    function deleteTicket($id)
    {
        return DB::select('CALL SP_DeleteTicket(?)', [$id]);
    }

}
