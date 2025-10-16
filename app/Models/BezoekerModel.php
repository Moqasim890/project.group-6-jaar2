<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            $results = DB::select('CALL SP_CreateOrGetBezoeker(?, ?)', [$email, $naam]);
            return !empty($results) ? $results[0] : null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating or getting bezoeker: ' . $e->getMessage(), [
                'email' => $email,
                'naam' => $naam
            ]);
            throw $e;
        }
    }
}
