<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standmodel extends Model
{
    protected $table = 'stands';
    protected $fillable = [
        'EvenementId','VerkoperId','StandType','Prijs',
        'VerhuurdStatus','IsActief','Opmerking',
    ];
    public $timestamps = false;

    public function evenement() {
        return $this->belongsTo(Evenement::class, 'EvenementId');
    }

    // keep this here; it won’t break anything even if Verkoper is added later
    //public function verkoper() {
       // return $this->belongsTo(\App\Models\Verkoper::class, 'VerkoperId');
    //}
}
