<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TicketModel - Ticket en evenement beheer via stored procedures
 *
 * Dit model beheert tickets en evenement data.
 * Gebruikt stored procedures voor alle CRUD operaties.
 * Tickets worden gekoppeld aan bezoekers en prijzen.
 *
 * @package App\Models
 */
class TicketModel extends Model
{
    /**
     * Haal alle evenementen op
     *
     * Gebruikt SP_GetAllEvents om alle evenementen op te halen.
     * Filtert op IsActief=1 in de stored procedure.
     *
     * @return array Array van evenement objecten
     * @throws \Exception Bij database fouten
     */
    public static function getAllEvents()
    {
        try {
            Log::info('Calling SP_GetAllEvents');
            $result = DB::select('CALL SP_GetAllEvents()');
            Log::info('SP_GetAllEvents completed', ['count' => count($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetAllEvents: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Haal een specifiek evenement op via ID
     *
     * Gebruikt SP_GetEventByID.
     * Gebruikt voor detail pagina's en dropdown selecties.
     *
     * @param int $id Het evenement ID
     * @return object|null Evenement object of null als niet gevonden
     * @throws \Exception Bij database fouten
     */
    public static function getEventById($id)
    {
        try {
            Log::info('Calling SP_GetEventByID', ['id' => $id]);
            $result = DB::selectOne('CALL SP_GetEventByID(?)', [$id]);
            Log::info('SP_GetEventByID completed', ['found' => !empty($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetEventByID: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Haal een specifiek ticket op via ID
     *
     * Gebruikt SP_GetTicketByID.
     * Joined met prijzen en evenement informatie.
     * Filtert op IsActief=1 voor prijzen.
     *
     * @param int $id Het ticket ID
     * @return object|null Ticket object met price en event info, of null
     * @throws \Exception Bij database fouten
     */
    public static function getTicketById($id)
    {
        try {
            Log::info('Calling SP_GetTicketByID', ['id' => $id]);
            $result = DB::selectOne('CALL SP_GetTicketByID(?)', [$id]);
            Log::info('SP_GetTicketByID completed', ['found' => !empty($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetTicketByID: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Maak een nieuw ticket aan
     *
     * Gebruikt SP_CreateTicket.
     * Verwacht gevalideerde data van controller.
     * Koppelt ticket aan bezoeker en prijs.
     *
     * @param array $data Gevalideerde ticket data met keys:
     *                    - evenement_id: FK naar evenements
     *                    - tarief: Prijs bedrag
     *                    - tijdslot: Tijdslot (08:00:00, 11:00:00, 14:00:00)
     *                    - datum: Datum in YYYY-MM-DD formaat
     * @return array Result van stored procedure
     * @throws \Exception Bij database fouten of validatie fouten
     */
    public static function createTicket($data)
    {
        try {
            Log::info('Calling SP_CreateTicket', ['data' => $data]);
            $result = DB::select('CALL SP_CreateTicket(?, ?, ?, ?)', [
                $data['evenement_id'],
                $data['tarief'],
                $data['tijdslot'],
                $data['datum']
            ]);
            Log::info('SP_CreateTicket completed successfully');
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_CreateTicket: ' . $e->getMessage(), [
                'data' => $data,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Haal alle tickets voor een evenement op, gegroepeerd per datum
     *
     * Gebruikt SP_GetTicketsByEventId.
     * Joined met prijzen tabel, filtert IsActief=1.
     * Groepeert resultaten per datum voor betere weergave.
     *
     * @param int $eventId Het evenement ID
     * @return array Associatieve array met datum als key, tickets als value
     *               Voorbeeld: ['2025-10-16' => [ticket1, ticket2], '2025-10-17' => [...]]
     * @throws \Exception Bij database fouten
     */
    public static function getTicketsByEventId($eventId)
    {
        try {
            Log::info('Calling SP_GetTicketsByEventId', ['eventId' => $eventId]);
            $tickets = DB::select('CALL SP_GetTicketsByEventId(?)', [$eventId]);

            // Groepeer tickets per datum voor betere structuur
            $grouped = [];
            foreach ($tickets as $ticket) {
                $datum = $ticket->Datum ?? '';
                if ($datum) {
                    $grouped[$datum][] = $ticket;
                }
            }

            Log::info('SP_GetTicketsByEventId completed', [
                'eventId' => $eventId,
                'totalTickets' => count($tickets),
                'groupedByDates' => count($grouped)
            ]);
            return $grouped;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetTicketsByEventId: ' . $e->getMessage(), [
                'eventId' => $eventId,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Update een bestaand ticket
     *
     * Gebruikt SP_UpdateTicket.
     * Verwacht gevalideerde data van controller.
     *
     * @param int $id Het ticket ID om te updaten
     * @param array $data Gevalideerde ticket data met keys:
     *                    - tarief: Prijs bedrag
     *                    - tijdslot: Tijdslot (08:00:00, 11:00:00, 14:00:00)
     *                    - datum: Datum in YYYY-MM-DD formaat
     *                    - evenement_id: FK naar evenements
     * @return array Result van stored procedure
     * @throws \Exception Bij database fouten
     */
    public static function updateTicket($id, $data)
    {
        try {
            Log::info('Calling SP_UpdateTicket', ['id' => $id, 'data' => $data]);
            $result = DB::select('CALL SP_UpdateTicket(?, ?, ?, ?, ?)', [
                $id,
                $data['tarief'],
                $data['tijdslot'],
                $data['datum'],
                $data['evenement_id']
            ]);
            Log::info('SP_UpdateTicket completed successfully', ['id' => $id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_UpdateTicket: ' . $e->getMessage(), [
                'id' => $id,
                'data' => $data,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Verwijder een ticket
     *
     * Gebruikt SP_DeleteTicket.
     * LET OP: Dit is een harde delete, geen soft delete.
     *
     * @param int $id Het ticket ID om te verwijderen
     * @return array Result van stored procedure
     * @throws \Exception Bij database fouten of foreign key constraints
     */
    public static function deleteTicket($id)
    {
        try {
            Log::info('Calling SP_DeleteTicket', ['id' => $id]);
            $result = DB::select('CALL SP_DeleteTicket(?)', [$id]);
            Log::info('SP_DeleteTicket completed successfully', ['id' => $id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_DeleteTicket: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);
            throw $e;
        }
    }
}
