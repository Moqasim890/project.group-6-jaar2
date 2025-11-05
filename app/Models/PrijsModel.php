<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrijsModel extends Model
{
    protected $table = 'prijzen';

    /** Helper: draai je op MySQL/MariaDB? */
    protected static function isMySql(): bool
    {
        try {
            return DB::getDriverName() === 'mysql';
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Haal alle actieve prijzen op (met event-naam).
     * - MySQL: CALL SP_GetAllPrijzen()
     * - SQLite: Query Builder fallback
     */
    public static function getAllPrijzen()
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_GetAllPrijzen (MySQL)');
                $result = DB::select('CALL SP_GetAllPrijzen()');
                Log::info('SP_GetAllPrijzen completed', ['count' => count($result)]);
                return $result;
            }

            Log::info('Using Query Builder fallback for getAllPrijzen (SQLite)');
            return DB::table('prijzen as p')
                ->leftJoin('evenements as e', 'p.EvenementId', '=', 'e.id')
                ->where('p.IsActief', 1)
                ->orderByDesc('p.Datum')
                ->orderBy('p.Tijdslot')
                ->selectRaw('
                    p.id,
                    p.EvenementId,
                    e.Naam AS EventNaam,
                    p.Datum,
                    p.Tijdslot,
                    p.Tarief,
                    p.IsActief,
                    p.Opmerking,
                    p.DatumAangemaakt,
                    p.DatumGewijzigd
                ')
                ->get();
        } catch (\Throwable $e) {
            Log::error('Error in getAllPrijzen: '.$e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    /**
     * Haal één prijs op via id.
     * - MySQL: CALL SP_GetPrijsByID(?)
     * - SQLite: Query Builder fallback (geen IsActief-filter zodat admin ook inactief ziet)
     */
    public static function getPrijsById(int $id)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_GetPrijsByID (MySQL)', ['id' => $id]);
                $rows = DB::select('CALL SP_GetPrijsByID(?)', [$id]);
                return $rows[0] ?? null;
            }

            Log::info('Using QB fallback for getPrijsById (SQLite)', ['id' => $id]);
            return DB::table('prijzen as p')
                ->leftJoin('evenements as e', 'p.EvenementId', '=', 'e.id')
                ->where('p.id', $id)
                ->selectRaw('
                    p.id,
                    p.EvenementId,
                    e.Naam AS EventNaam,
                    p.Datum,
                    p.Tijdslot,
                    p.Tarief,
                    p.IsActief,
                    p.Opmerking,
                    p.DatumAangemaakt,
                    p.DatumGewijzigd
                ')
                ->first();
        } catch (\Throwable $e) {
            Log::error('Error in getPrijsById: '.$e->getMessage(), ['id' => $id, 'exception' => $e]);
            throw $e;
        }
    }

    /**
     * Maak nieuwe prijs aan.
     * - MySQL: CALL SP_CreatePrijs(...)
     * - SQLite: QB fallback inclusief duplicate + tarief-range checks
     */
    public static function createPrijs(int $evenementId, string $datum, string $tijdslot, float $tarief, string $opmerking = '')
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_CreatePrijs (MySQL)', compact('evenementId','datum','tijdslot','tarief'));
                $rows = DB::select('CALL SP_CreatePrijs(?, ?, ?, ?, ?)', [
                    $evenementId, $datum, $tijdslot, $tarief, $opmerking
                ]);
                return $rows[0] ?? null; // verwacht { id: <newId> }
            }

            Log::info('Using QB fallback for createPrijs (SQLite)', compact('evenementId','datum','tijdslot','tarief'));
            // Validaties (mimic SP)
            if ($tarief < 0.01 || $tarief > 999.99) {
                throw new \RuntimeException('Het tarief moet tussen 0.01 en 999.99 euro liggen.');
            }

            // Duplicate check: zelfde event+datum+tijdslot en actief
            $dupes = DB::table('prijzen')
                ->where('EvenementId', $evenementId)
                ->where('Datum', $datum)
                ->where('Tijdslot', $tijdslot)
                ->where('IsActief', 1)
                ->count();

            if ($dupes > 0) {
                throw new \RuntimeException('Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.');
            }

            $id = DB::table('prijzen')->insertGetId([
                'EvenementId'    => $evenementId,
                'Datum'          => $datum,
                'Tijdslot'       => $tijdslot,
                'Tarief'         => $tarief,
                'IsActief'       => 1,
                'Opmerking'      => $opmerking,
                'DatumAangemaakt'=> now(),
                'DatumGewijzigd' => now(),
            ]);

            return (object) ['id' => $id];
        } catch (\Throwable $e) {
            Log::error('Error in createPrijs: '.$e->getMessage(), [
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief,
                'exception' => $e,
            ]);
            throw $e;
        }
    }

    /**
     * Update bestaande prijs.
     * - MySQL: CALL SP_UpdatePrijs(...)
     * - SQLite: QB fallback inclusief checks + DatumGewijzigd bijwerken
     * Return: object met Affected (0/1) voor consistentie met SP.
     */
    public static function updatePrijs(int $id, int $evenementId, string $datum, string $tijdslot, float $tarief, int $isActief, string $opmerking = '')
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_UpdatePrijs (MySQL)', compact('id','evenementId','datum','tijdslot','tarief','isActief'));
                $row = DB::selectOne('CALL SP_UpdatePrijs(?, ?, ?, ?, ?, ?, ?)', [
                    $id, $evenementId, $datum, $tijdslot, $tarief, $isActief, $opmerking
                ]);
                return $row; // verwacht { Affected: 0|1 } uit SELECT ROW_COUNT()
            }

            Log::info('Using QB fallback for updatePrijs (SQLite)', compact('id','evenementId','datum','tijdslot','tarief','isActief'));

            if ($tarief < 0.01 || $tarief > 999.99) {
                throw new \RuntimeException('Het tarief moet tussen 0.01 en 999.99 euro liggen.');
            }

            // Event moet bestaan en actief zijn, net als in SP_UpdatePrijs
            $eventIsActief = DB::table('evenements')
                ->where('id', $evenementId)
                ->where('IsActief', 1)
                ->exists();

            if (!$eventIsActief) {
                return (object) ['Affected' => 0, 'message' => 'Dit ticket kan niet worden gewijzigd omdat het evenement niet actief is.'];
            }

            // Duplicate check (exclusief eigen record)
            $dupes = DB::table('prijzen')
                ->where('EvenementId', $evenementId)
                ->where('Datum', $datum)
                ->where('Tijdslot', $tijdslot)
                ->where('IsActief', 1)
                ->where('id', '<>', $id)
                ->count();

            if ($dupes > 0) {
                return (object) ['Affected' => 0, 'message' => 'Er bestaat al een actieve prijs voor dit evenement op deze datum en dit tijdslot.'];
            }

            $affected = DB::table('prijzen')
                ->where('id', $id)
                ->update([
                    'EvenementId'    => $evenementId,
                    'Datum'          => $datum,
                    'Tijdslot'       => $tijdslot,
                    'Tarief'         => $tarief,
                    'IsActief'       => $isActief,
                    'Opmerking'      => $opmerking,
                    'DatumGewijzigd' => now(),
                ]);

            return (object) ['Affected' => (int) $affected];
        } catch (\Throwable $e) {
            Log::error('Error in updatePrijs: '.$e->getMessage(), [
                'id' => $id,
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief,
                'isActief' => $isActief,
                'exception' => $e,
            ]);
            throw $e;
        }
    }

    /**
     * Soft delete (IsActief = 0).
     * - MySQL: CALL SP_DeletePrijs(?)
     * - SQLite: QB fallback (update IsActief=0 + DatumGewijzigd)
     * Return: object met Affected (0/1).
     */
    public static function deletePrijs(int $id)
    {
        try {
            if (self::isMySql()) {
                Log::info('Calling SP_DeletePrijs (MySQL)', ['id' => $id]);
                $row = DB::selectOne('CALL SP_DeletePrijs(?)', [$id]); // verwacht { Affected: 0|1 }
                return $row;
            }

            Log::info('Using QB fallback for deletePrijs (SQLite)', ['id' => $id]);

            // Als al inactief of niet bestaand, Affected = 0
            $existsActive = DB::table('prijzen')->where('id', $id)->where('IsActief', 1)->exists();
            if (!$existsActive) {
                return (object) ['Affected' => 0, 'message' => 'Prijs bestaat niet (actief) of is al verwijderd.'];
            }

            $affected = DB::table('prijzen')
                ->where('id', $id)
                ->update([
                    'IsActief'       => 0,
                    'DatumGewijzigd' => now(),
                ]);

            return (object) ['Affected' => (int) $affected];
        } catch (\Throwable $e) {
            Log::error('Error in deletePrijs: '.$e->getMessage(), ['id' => $id, 'exception' => $e]);
            throw $e;
        }
    }
}
