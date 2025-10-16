<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * PrijsModel - Ticket prijzen beheer via stored procedures
 *
 * Dit model beheert alle prijzen voor evenement tickets.
 * Alle database operaties gebeuren via stored procedures voor:
 * - Betere performance
 * - Database-level validatie
 * - Consistente business logica
 *
 * @package App\Models
 */

class PrijsModel extends Model
{
    /**
     * Haal alle actieve prijzen op
     *
     * Gebruikt SP_GetAllPrijzen om alle actieve prijzen (IsActief=1) op te halen
     * inclusief evenement informatie via JOIN.
     *
     * @return array Array van prijs objecten met evenement details
     * @throws \Exception Bij database fouten
     */
    public static function getAllPrijzen()
    {
        try {
            Log::info('Calling SP_GetAllPrijzen');
            $result = DB::select('CALL SP_GetAllPrijzen()');
            Log::info('SP_GetAllPrijzen completed', ['count' => count($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetAllPrijzen: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Haal een specifieke prijs op via ID
     *
     * Gebruikt SP_GetPrijsByID. Deze procedure filtert NIET op IsActief,
     * zodat admins ook inactieve prijzen kunnen bewerken.
     *
     * @param int $id De prijs ID
     * @return object|null Prijs object of null als niet gevonden
     * @throws \Exception Bij database fouten
     */
    public static function getPrijsById($id)
    {
        try {
            Log::info('Calling SP_GetPrijsByID', ['id' => $id]);
            $results = DB::select('CALL SP_GetPrijsByID(?)', [$id]);
            $result = !empty($results) ? $results[0] : null;
            Log::info('SP_GetPrijsByID completed', ['id' => $id, 'found' => !empty($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetPrijsByID: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Maak een nieuwe prijs aan
     *
     * Gebruikt SP_CreatePrijs met duplicate checking op database niveau.
     * Gooit SIGNAL SQLSTATE '45000' bij duplicaten.
     *
     * @param int $evenementId FK naar evenements tabel
     * @param string $datum Datum in YYYY-MM-DD formaat
     * @param string $tijdslot Tijdslot (08:00:00, 11:00:00, of 14:00:00)
     * @param float $tarief Prijs in euros (min 0.01)
     * @param string $opmerking Optionele opmerking
     * @return object|null Result object met nieuwe prijs ID
     * @throws \Exception Bij database fouten of duplicate entries
     */
    public static function createPrijs($evenementId, $datum, $tijdslot, $tarief, $opmerking = '')
    {
        try {
            Log::info('Calling SP_CreatePrijs', [
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief
            ]);
            $results = DB::select('CALL SP_CreatePrijs(?, ?, ?, ?, ?)', [
                $evenementId,
                $datum,
                $tijdslot,
                $tarief,
                $opmerking
            ]);
            $result = !empty($results) ? $results[0] : null;
            Log::info('SP_CreatePrijs completed successfully', ['result' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_CreatePrijs: ' . $e->getMessage(), [
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Update een bestaande prijs
     *
     * Gebruikt SP_UpdatePrijs met duplicate checking (exclusief huidige record).
     * Updates ook DatumGewijzigd automatisch.
     *
     * @param int $id De prijs ID om te updaten
     * @param int $evenementId FK naar evenements tabel
     * @param string $datum Datum in YYYY-MM-DD formaat
     * @param string $tijdslot Tijdslot (08:00:00, 11:00:00, of 14:00:00)
     * @param float $tarief Prijs in euros (min 0.01)
     * @param int $isActief Status: 1=actief, 0=inactief
     * @param string $opmerking Optionele opmerking
     * @return int Aantal affected rows (0 of 1)
     * @throws \Exception Bij database fouten of duplicate entries
     */
    public static function updatePrijs($id, $evenementId, $datum, $tijdslot, $tarief, $isActief, $opmerking = '')
    {
        try {
            Log::info('Calling SP_UpdatePrijs', [
                'id' => $id,
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief,
                'isActief' => $isActief
            ]);
            $results = DB::select('CALL SP_UpdatePrijs(?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $evenementId,
                $datum,
                $tijdslot,
                $tarief,
                $isActief,
                $opmerking
            ]);
            $affected = !empty($results) ? $results[0]->Affected : 0;
            Log::info('SP_UpdatePrijs completed', ['id' => $id, 'affected' => $affected]);
            return $affected;
        } catch (\Exception $e) {
            Log::error('Error in SP_UpdatePrijs: ' . $e->getMessage(), [
                'id' => $id,
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Verwijder een prijs (soft delete)
     *
     * Gebruikt SP_DeletePrijs die IsActief=0 zet in plaats van DELETE.
     * Dit voorkomt foreign key constraint violations met tickets tabel.
     * Updates ook DatumGewijzigd.
     *
     * @param int $id De prijs ID om te verwijderen
     * @return int Aantal affected rows (0 of 1)
     * @throws \Exception Bij database fouten
     */
    public static function deletePrijs($id)
    {
        try {
            Log::info('Calling SP_DeletePrijs', ['id' => $id]);
            $results = DB::select('CALL SP_DeletePrijs(?)', [$id]);
            $affected = !empty($results) ? $results[0]->Affected : 0;
            Log::info('SP_DeletePrijs completed', ['id' => $id, 'affected' => $affected]);
            return $affected;
        } catch (\Exception $e) {
            Log::error('Error in SP_DeletePrijs: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);
            throw $e;
        }
    }
}
