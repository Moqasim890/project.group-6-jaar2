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

    // Aangepaste timestamp-kolommen
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'Naam',
        'Locatie',
        'Datum',
        'AantalTicketsPerTijdslot',
        'BeschikbareStands',
        'IsActief',
        'Opmerking'
    ];

    // Handige casts (pas aan als je kolomtypes anders zijn)
    protected $casts = [
        'Datum' => 'datetime',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
        'IsActief' => 'boolean',
        'AantalTicketsPerTijdslot' => 'integer',
        'BeschikbareStands' => 'integer',
    ];

    /*
     |--------------------------------------------------------------------------
     | Model events -> loggen naar backlog (laravel.log)
     |--------------------------------------------------------------------------
     |
     | - creating/created: wanneer een event wordt aangemaakt
     | - updating/updated: schrijft een nette diff (van -> naar) van gewijzigde velden
     | - deleting/deleted: wanneer een event wordt verwijderd
     |
     | Hiermee zie je de updates meteen terug in de backlog.
     |
     */
    protected static function booted()
    {
        // Voor het opslaan (optioneel, context)
        static::creating(function ($event) {
            Log::info('Evenement creating...', [
                'attributes' => $event->getAttributes()
            ]);
        });

        // Na het opslaan (nieuw record)
        static::created(function ($event) {
            Log::info('Evenement created', [
                'id' => $event->id,
                'attributes' => $event->fresh()?->getAttributes()
            ]);
        });

        // Voor update (optioneel, context)
        static::updating(function ($event) {
            Log::info('Evenement updating...', [
                'id' => $event->id,
                'dirty' => $event->getDirty()
            ]);
        });

        // Na update: schrijf een diff van gewijzigde velden
        static::updated(function ($event) {
            // Velden die veranderd zijn na save
            $changed = $event->getChanges();

            // Laat de timestamp desgewenst buiten de diff
            unset($changed[static::UPDATED_AT]);

            $diff = [];
            foreach ($changed as $key => $newValue) {
                $oldValue = $event->getOriginal($key);
                $diff[$key] = [
                    'from' => $oldValue,
                    'to'   => $newValue,
                ];
            }

            Log::info('Evenement updated', [
                'id' => $event->id,
                'changes' => $diff,
            ]);
        });

        // Voor delete (optioneel, context)
        static::deleting(function ($event) {
            Log::info('Evenement deleting...', [
                'id' => $event->id,
                'attributes' => $event->getAttributes()
            ]);
        });

        // Na delete
        static::deleted(function ($event) {
            Log::info('Evenement deleted', [
                'id' => $event->id
            ]);
        });
    }

    // Relatie: Evenement heeft veel stands
    public function stands()
    {
        return $this->hasMany(StandModel::class, 'EvenementId', 'id');
    }

    // Relatie: Evenement heeft veel prijzen
    public function prijzen()
    {
        return $this->hasMany(PrijsModel::class, 'EvenementId', 'id');
    }

    /*
     |--------------------------------------------------------------------------
     | Stored procedures
     |--------------------------------------------------------------------------
     */
    // Alle events via stored procedure
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

    // Event op ID via stored procedure
    public static function getEventById($id)
    {
        try {
            Log::info('Calling SP_GetEventByID', ['id' => $id]);
            $results = DB::select('CALL SP_GetEventByID(?)', [$id]);
            $result = !empty($results) ? $results[0] : null;
            Log::info('SP_GetEventByID completed', [
                'id' => $id,
                'found' => !empty($result)
            ]);
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
