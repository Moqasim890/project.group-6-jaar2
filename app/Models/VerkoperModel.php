<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}