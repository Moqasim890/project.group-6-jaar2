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
        try {
            return DB::select('CALL SP_CreateTicket(?, ?, ?, ?)', [
                $data['evenement_id'],
                $data['tarief'],
                $data['tijdslot'],
                $data['datum']
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating ticket: ' . $e->getMessage(), [
                'data' => $data
            ]);
            throw $e;
        }
    }

    public static function getTicketsByEventId($eventId)
    {
        try {
            $tickets = DB::select('CALL SP_GetTicketsByEventId(?)', [$eventId]);
            $grouped = [];
            foreach ($tickets as $ticket) {
                $datum = $ticket->Datum ?? '';
                if ($datum) {
                    $grouped[$datum][] = $ticket;
                }
            }
            return $grouped;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting tickets by event: ' . $e->getMessage(), [
                'eventId' => $eventId
            ]);
            throw $e;
        }
    }

    public static function updateTicket($id, $data)
    {
        try {
            return DB::select('CALL SP_UpdateTicket(?, ?, ?, ?, ?)', [
                $id,
                $data['tarief'],
                $data['tijdslot'],
                $data['datum'],
                $data['evenement_id']
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating ticket: ' . $e->getMessage(), [
                'id' => $id,
                'data' => $data
            ]);
            throw $e;
        }
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
