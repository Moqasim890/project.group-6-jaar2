<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// zorgt voor toegang to DB
use Illuminate\Support\Facades\DB;

class OrganisatorModel extends Model
{
    public function sp_GetAllVerkopers() 
    {
        //uitvoeren Stored Procedure en resultaten terug geven
        return DB::select('CALL Sp_GetAllVerkopers');
    }
}
