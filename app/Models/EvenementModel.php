<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvenementModel extends Model
{
    //
    protected $table = 'Evenement';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
