<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model
{
    //
    protected $table = 'Ticket';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
