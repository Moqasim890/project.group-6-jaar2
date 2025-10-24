<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvenementModel extends Model
{
    protected $table = 'evenements';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'Naam',
        'Locatie',
        'Datum',
        'AantalTicketsPerTijdslot',
        'BeschikbareStands',
        'IsActief',
        'Opmerking'
    ];

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    // Relationship: Evenement has many stands
    public function stands()
    {
        return $this->hasMany(StandModel::class, 'EvenementId', 'id');
    }

    // Relationship: Evenement has many prijzen
    public function prijzen()
    {
        return $this->hasMany(PrijsModel::class, 'EvenementId', 'id');
    }

    // Static method to get all events using stored procedure
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

    // Static method to get event by ID using stored procedure
    public static function getEventById($id)
    {
        try {
            Log::info('Calling SP_GetEventByID', ['id' => $id]);
            $results = DB::select('CALL SP_GetEventByID(?)', [$id]);
            $result = !empty($results) ? $results[0] : null;
            Log::info('SP_GetEventByID completed', ['id' => $id, 'found' => !empty($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_GetEventByID: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);
            throw $e;
        }
    }
}
