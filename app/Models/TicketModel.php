<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TicketModel extends Model
{
    public static function getAllEvents()
    {
        return DB::select('CALL SP_GetAllEvents()');
    }

    public static function getAllTickets()
    {
        return DB::select('CALL SP_GetAllTickets()');
    }

    public static function getTicketById($id)
    {
        return DB::select('CALL SP_GetTicketByID(?)', [$id]);
    }

    public static function createTicket($data)
    {
        return DB::select('CALL SP_CreateTicket(?, ?, ?, ?, ?)', [$data['id'], $data['prijs'], $data['tijdslot'], $data['datum'], $data['Event']]);
    }

    public static function getTicketsByEventId($eventId)
    {
        return DB::select('CALL SP_GetTicketsByEventId(?)', [$eventId]);
    }

    public static function updateTicket($id, $data)
    {
        return DB::select('CALL SP_UpdateTicket(?, ?, ?, ?)', [$id, $data['name'], $data['price'], $data['event_id']]);
    }

    public static function deleteTicket($id)
    {
        return DB::select('CALL SP_DeleteTicket(?)', [$id]);
    }

}
