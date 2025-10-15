<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EvenementModel extends Model
{
    protected $table = 'evenements';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'Naam',
        'Locatie',
        'Datum',
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
            return DB::select('CALL SP_GetAllEvents()');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting all events: ' . $e->getMessage());
            throw $e;
        }
    }
}

