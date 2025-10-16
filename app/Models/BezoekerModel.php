<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BezoekerModel extends Model
{
    protected $table = 'bezoekers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'Naam',
        'EmailAdres',
        'IsActief',
        'Opmerking'
    ];

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    // Relationship: Bezoeker has many tickets
    public function tickets()
    {
        return $this->hasMany(TicketModel::class, 'BezoekerId', 'id');
    }

    // Static method to create or get bezoeker by email
    public static function createOrGetBezoeker($email, $naam = '')
    {
        try {
            Log::info('Calling SP_CreateOrGetBezoeker', [
                'email' => $email,
                'naam' => $naam
            ]);
            $results = DB::select('CALL SP_CreateOrGetBezoeker(?, ?)', [$email, $naam]);
            $result = !empty($results) ? $results[0] : null;
            Log::info('SP_CreateOrGetBezoeker completed', [
                'email' => $email,
                'bezoekerId' => $result->id ?? null
            ]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error in SP_CreateOrGetBezoeker: ' . $e->getMessage(), [
                'email' => $email,
                'naam' => $naam,
                'exception' => $e
            ]);
            throw $e;
        }
    }
}
