<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketModel extends Model
{
    // NB: dit model wordt gebruikt als "service" laag; geen $table nodig.

    /** Draait de app op MySQL/MariaDB? */
    protected static function isMySql(): bool
    {
        try {
            return DB::getDriverName() === 'mysql';
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * EVENTS: alle events ophalen (voor ticketscherm)
     * - MySQL: CALL SP_GetAllEvents()
     * - SQLite: SELECT ... FROM evenements
     */
    public static function getAllEvents()
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_GetAllEvents (MySQL)');
                $rows = DB::select('CALL SP_GetAllEvents()');
                Log::info('SP_GetAllEvents done', ['count' => count($rows)]);
                return $rows;
            }

            Log::info('Using QB fallback getAllEvents (SQLite)');
            return DB::table('evenements')
                ->select('id', 'Naam', 'Locatie', 'Datum')
                ->orderByDesc('Datum')
                ->get();

        } catch (\Throwable $e) {
            Log::error('getAllEvents failed: '.$e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    /**
     * PRIJZEN/TICKETS-LIJST voor 1 event (ticket-keuze per event)
     * - MySQL: CALL SP_GetAllTickets(?)
     * - SQLite: SELECT prijzen JOIN evenements
     */
    public static function getAllTicketsByEvent(int $eventId)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_GetAllTickets (MySQL)', ['eventId' => $eventId]);
                return DB::select('CALL SP_GetAllTickets(?)', [$eventId]);
            }

            Log::info('Using QB fallback getAllTicketsByEvent (SQLite)', ['eventId' => $eventId]);
            return DB::table('prijzen as p')
                ->leftJoin('evenements as e', 'p.EvenementId', '=', 'e.id')
                ->where('p.IsActief', 1)
                ->where('p.EvenementId', $eventId)
                ->orderBy('p.Datum')
                ->orderBy('p.Tijdslot')
                ->selectRaw('
                    p.id          as PrijsID,
                    e.Naam        as EventNaam,
                    p.Tarief      as TicketPrijs,
                    p.Tijdslot    as TicketTijdslot,
                    p.Datum       as TicketDatum,
                    e.Locatie     as EventLocatie
                ')
                ->get();

        } catch (\Throwable $e) {
            Log::error('getAllTicketsByEvent failed: '.$e->getMessage(), ['eventId' => $eventId, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * PRIJZEN/TICKETS-LIJST (zonder event filter)
     * - MySQL: CALL SP_GetAllTickets_NoParam()
     * - SQLite: SELECT prijzen JOIN evenements
     */
    public static function getAllTickets()
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_GetAllTickets_NoParam (MySQL)');
                return DB::select('CALL SP_GetAllTickets_NoParam()');
            }

            Log::info('Using QB fallback getAllTickets (SQLite)');
            return DB::table('prijzen as p')
                ->leftJoin('evenements as e', 'p.EvenementId', '=', 'e.id')
                ->where('p.IsActief', 1)
                ->orderBy('p.Datum')
                ->orderBy('p.Tijdslot')
                ->selectRaw('
                    p.id          as PrijsID,
                    e.Naam        as EventNaam,
                    p.Tarief      as TicketPrijs,
                    p.Tijdslot    as TicketTijdslot,
                    p.Datum       as TicketDatum,
                    e.Locatie     as EventLocatie
                ')
                ->get();

        } catch (\Throwable $e) {
            Log::error('getAllTickets failed: '.$e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    /**
     * 1 prijs/ticket ophalen (voor details of bewerken)
     * - MySQL: CALL SP_GetTicketByID(?)
     * - SQLite: SELECT prijzen JOIN evenements WHERE p.id = ?
     */
    public static function getTicketById(int $prijsId)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_GetTicketByID (MySQL)', ['prijsId' => $prijsId]);
                $rows = DB::select('CALL SP_GetTicketByID(?)', [$prijsId]);
                return $rows[0] ?? null;
            }

            Log::info('Using QB fallback getTicketById (SQLite)', ['prijsId' => $prijsId]);
            return DB::table('prijzen as p')
                ->leftJoin('evenements as e', 'p.EvenementId', '=', 'e.id')
                ->where('p.id', $prijsId)
                ->selectRaw('
                    p.id          as PrijsID,
                    e.Naam        as EventNaam,
                    p.Tarief      as TicketPrijs,
                    p.Tijdslot    as TicketTijdslot,
                    p.Datum       as TicketDatum,
                    e.Locatie     as EventLocatie
                ')
                ->first();

        } catch (\Throwable $e) {
            Log::error('getTicketById failed: '.$e->getMessage(), ['prijsId' => $prijsId, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * Aanmaken van een 'ticket' record in prijzen (admin create prijs)
     * - MySQL: CALL SP_CreateTicket(...)
     * - SQLite: insert in prijzen (actief=1)
     */
    public static function createTicket(int $eventId, float $prijs, string $tijdslot, string $datum)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_CreateTicket (MySQL)', compact('eventId','prijs','tijdslot','datum'));
                $rows = DB::select('CALL SP_CreateTicket(?, ?, ?, ?)', [$eventId, $prijs, $tijdslot, $datum]);
                return $rows[0] ?? (object)['Affected' => 0];
            }

            Log::info('Using QB fallback createTicket (SQLite)', compact('eventId','prijs','tijdslot','datum'));
            $affected = DB::table('prijzen')->insertGetId([
                'EvenementId'    => $eventId,
                'Tarief'         => $prijs,
                'Tijdslot'       => $tijdslot,
                'Datum'          => $datum,
                'IsActief'       => 1,
                'DatumAangemaakt'=> now(),
                'DatumGewijzigd' => now(),
            ]);

            return (object)['Affected' => $affected ? 1 : 0];

        } catch (\Throwable $e) {
            Log::error('createTicket failed: '.$e->getMessage(), ['eventId' => $eventId, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * Updaten van prijs 'ticket' rij in prijzen
     * - MySQL: CALL SP_UpdateTicket(...)
     * - SQLite: update prijzen
     */
    public static function updateTicket(int $prijsId, float $prijs, string $tijdslot, string $datum, int $eventId)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_UpdateTicket (MySQL)', compact('prijsId','prijs','tijdslot','datum','eventId'));
                $row = DB::selectOne('CALL SP_UpdateTicket(?, ?, ?, ?, ?)', [$prijsId, $prijs, $tijdslot, $datum, $eventId]);
                return $row ?? (object)['Affected' => 0];
            }

            Log::info('Using QB fallback updateTicket (SQLite)', compact('prijsId','prijs','tijdslot','datum','eventId'));
            $affected = DB::table('prijzen')
                ->where('id', $prijsId)
                ->update([
                    'EvenementId'    => $eventId,
                    'Tarief'         => $prijs,
                    'Tijdslot'       => $tijdslot,
                    'Datum'          => $datum,
                    'DatumGewijzigd' => now(),
                ]);

            return (object)['Affected' => (int)$affected];

        } catch (\Throwable $e) {
            Log::error('updateTicket failed: '.$e->getMessage(), ['prijsId' => $prijsId, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * Verwijderen van prijs 'ticket' (hard delete, overeenkomstig je SP_DeleteTicket)
     * - MySQL: CALL SP_DeleteTicket(?)
     * - SQLite: DELETE FROM prijzen WHERE id = ?
     */
    public static function deleteTicket(int $id)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_DeleteTicket (MySQL)', ['id' => $id]);
                $row = DB::selectOne('CALL SP_DeleteTicket(?)', [$id]); // verwacht { Affected: 0|1 }
                return $row ?? (object)['Affected' => 0];
            }

            Log::info('Using QB fallback deleteTicket (SQLite)', ['id' => $id]);
            $affected = DB::table('prijzen')->where('id', $id)->delete();
            return (object)['Affected' => (int)$affected];

        } catch (\Throwable $e) {
            Log::error('deleteTicket failed: '.$e->getMessage(), ['id' => $id, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * Kopen van tickets (end-user flow) -> INSERT in tickets
     * - MySQL: CALL SP_KopenTicket(...)
     * - SQLite: direct insert in tickets
     */
    public static function kopenTicket(int $bezoekerId, int $evenementId, int $prijsId, int $aantalTickets, string $datum)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_KopenTicket (MySQL)', compact('bezoekerId','evenementId','prijsId','aantalTickets','datum'));
                $rows = DB::select('CALL SP_KopenTicket(?, ?, ?, ?, ?)', [$bezoekerId, $evenementId, $prijsId, $aantalTickets, $datum]);
                return $rows[0] ?? (object)['Affected' => 0];
            }

            Log::info('Using QB fallback kopenTicket (SQLite)', compact('bezoekerId','evenementId','prijsId','aantalTickets','datum'));
            $affected = DB::table('tickets')->insert([
                'BezoekerId' => $bezoekerId,
                'EvenementId'=> $evenementId,
                'PrijsId'    => $prijsId,
                'AantalTickets' => $aantalTickets,
                'Datum'      => $datum,
            ]);

            return (object)['Affected' => $affected ? 1 : 0];

        } catch (\Throwable $e) {
            Log::error('kopenTicket failed: '.$e->getMessage(), ['bezoekerId' => $bezoekerId, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * Tickets ophalen voor gebruiker+datum
     * - MySQL: CALL SP_Ticketophalen(?, ?)
     * - SQLite: SELECT uit tickets
     */
    public static function ticketOphalen(int $bezoekerId, string $datum)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_Ticketophalen (MySQL)', compact('bezoekerId','datum'));
                return DB::select('CALL SP_Ticketophalen(?, ?)', [$bezoekerId, $datum]);
            }

            Log::info('Using QB fallback ticketOphalen (SQLite)', compact('bezoekerId','datum'));
            return DB::table('tickets')
                ->where('BezoekerId', $bezoekerId)
                ->where('Datum', $datum)
                ->select('BezoekerId', 'EvenementId', 'PrijsId', 'AantalTickets', 'Datum')
                ->get();

        } catch (\Throwable $e) {
            Log::error('ticketOphalen failed: '.$e->getMessage(), ['bezoekerId' => $bezoekerId, 'exception' => $e]);
            throw $e;
        }
    }
}
