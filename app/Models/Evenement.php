<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'evenements';
    protected $fillable = [
        'Naam','Datum','Locatie','AantalTicketsPerTijdslot',
        'BeschikbareStands','IsActief','Opmerking',
    ];
    public $timestamps = false;

    public function stands() {
        return $this->hasMany(Stand::class, 'EvenementId');
    }
}
