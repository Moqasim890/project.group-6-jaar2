<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandModel extends Model
{
    protected $table = 'stand'; // in ERD it's singular "Stand"
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'VerkoperId',
        'StandType',
        'Prijs',
        'VerhuurdStatus',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'VerhuurdStatus'   => 'boolean',
        'IsActief'         => 'boolean',
        'DatumAangemaakt'  => 'datetime',
        'DatumGewijzigd'   => 'datetime',
    ];

    // Relations
    public function verkoper()
    {
        return $this->belongsTo(VerkoperModel ::class, 'VerkoperId');
    }
}
