<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrijsModel extends Model
{
    // Static methods calling stored procedures
    public static function getAllPrijzen()
    {
        try {
            return DB::select('CALL SP_GetAllPrijzen()');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting all prijzen: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function getPrijsById($id)
    {
        try {
            $results = DB::select('CALL SP_GetPrijsByID(?)', [$id]);
            return !empty($results) ? $results[0] : null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting prijs by ID: ' . $e->getMessage(), ['id' => $id]);
            throw $e;
        }
    }

    public static function createPrijs($evenementId, $datum, $tijdslot, $tarief, $opmerking = '')
    {
        try {
            $results = DB::select('CALL SP_CreatePrijs(?, ?, ?, ?, ?)', [
                $evenementId,
                $datum,
                $tijdslot,
                $tarief,
                $opmerking
            ]);
            return !empty($results) ? $results[0] : null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating prijs: ' . $e->getMessage(), [
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief
            ]);
            throw $e;
        }
    }

    public static function updatePrijs($id, $evenementId, $datum, $tijdslot, $tarief, $isActief, $opmerking = '')
    {
        try {
            $results = DB::select('CALL SP_UpdatePrijs(?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $evenementId,
                $datum,
                $tijdslot,
                $tarief,
                $isActief,
                $opmerking
            ]);
            return !empty($results) ? $results[0]->Affected : 0;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating prijs: ' . $e->getMessage(), [
                'id' => $id,
                'evenementId' => $evenementId,
                'datum' => $datum,
                'tijdslot' => $tijdslot,
                'tarief' => $tarief
            ]);
            throw $e;
        }
    }

    public static function deletePrijs($id)
    {
        try {
            $results = DB::select('CALL SP_DeletePrijs(?)', [$id]);
            return !empty($results) ? $results[0]->Affected : 0;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting prijs: ' . $e->getMessage(), ['id' => $id]);
            throw $e;
        }
    }
}
