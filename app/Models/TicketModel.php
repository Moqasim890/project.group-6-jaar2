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
        return DB::select('CALL SP_GetAllTickets_NoParam()');
    }

    public static function getEventById($id)
    {
        return DB::selectOne('CALL SP_GetEventByID(?)', [$id]);
    }

    public static function getTicketById($id)
    {
        return DB::selectOne('CALL SP_GetTicketByID(?)', [$id]);
    }

    public static function createTicket($data)
    {
        // Accept multiple possible keys from different form implementations
        $eventId = $data['EvenementId'] ?? $data['event_id'] ?? $data['id'] ?? $data['Event'] ?? null;
        $tarief = $data['Tarief'] ?? $data['prijs'] ?? $data['price'] ?? null;
        $tijdslot = $data['Tijdslot'] ?? $data['tijdslot'] ?? null;
        $datum = $data['Datum'] ?? $data['datum'] ?? null;

        return DB::select('CALL SP_CreateTicket(?, ?, ?, ?)', [$eventId, $tarief, $tijdslot, $datum]);
    }

    public static function getTicketsByEventId($eventId)
    {
        $tickets = DB::select('CALL SP_GetTicketsByEventId(?)', [$eventId]);
        $grouped = [];
        foreach ($tickets as $ticket) {
            $date = $ticket->Datum ?? $ticket->datum ?? null;
            if ($date) {
                $grouped[$date][] = $ticket;
            }
        }
        return $grouped;
    }

    public static function updateTicket($id, $data)
    {
        $tarief = $data['Tarief'] ?? $data['prijs'] ?? $data['price'] ?? null;
        $tijdslot = $data['Tijdslot'] ?? $data['tijdslot'] ?? null;
        $datum = $data['Datum'] ?? $data['datum'] ?? null;
        $eventId = $data['EvenementId'] ?? $data['event_id'] ?? null;

        return DB::select('CALL SP_UpdateTicket(?, ?, ?, ?, ?)', [$id, $tarief, $tijdslot, $datum, $eventId]);
    }

    public static function deleteTicket($id)
    {
        return DB::select('CALL SP_DeleteTicket(?)', [$id]);
    }

//TODO: stored procedure afmaken
    public static function kopenTicket($data){
        return DB::select('CALL SP_KopenTicket(?,?,?,?)', $data);
    }

}
