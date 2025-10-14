<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerkoperModel extends Model
{
    use HasFactory;

    // Table + key
    protected $table = 'verkopers';
    protected $primaryKey = 'id';

    // We don't use created_at / updated_at in this table
    public $timestamps = false;

    // Mass-assignable columns
    protected $fillable = [
        'Naam',
        'SpecialeStatus',   // 'GEEN' | 'PARTNER'
        'VerkooptSoort',    // 'SNEAKERS' | 'ETEN_DRINKEN' | ...
        'StandType',        // 'A' | 'AA' | 'AAplus' | null
        'Dagen',            // 'EEN' | 'TWEE' | null
        'LogoUrl',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    // Helpful casts
    protected $casts = [
        'IsActief'        => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd'  => 'datetime',
    ];

    public function sp_CreateVerkoper($naam, $specialeStatus, $verkooptSoort, $standType, $dagen, $logoUrl, $isActief, $opmerking)
    {
        // Voeg commentaar toe
        $row = DB::selectOne(
            'CALL sp_CreateVerkoper(:Naam, :SpecialeStatus, :VerkooptSoort, :StandType, :Dagen, :LogoUrl, :IsActief, :Opmerking)', 
            [
                'Naam'          => $naam,
                'SpecialeStatus'=> $specialeStatus,
                'VerkooptSoort' => $verkooptSoort,
                'StandType'     => $standType,
                'Dagen'         => $dagen,
                'LogoUrl'       => $logoUrl,
                'IsActief'      => $isActief,
                'Opmerking'     => $opmerking,
            ]
        );

        return $row->new_id ?? null; // Return the new ID or null if no row is returned
    }
}