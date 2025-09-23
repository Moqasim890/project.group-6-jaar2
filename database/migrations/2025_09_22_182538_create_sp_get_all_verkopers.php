<?php
//unprepared zorgt ervoor dat laravel bij migrate direct sql uitvoert i.p.v de manier waarop laravel dat doet (php omzetten naar sql)

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS Sp_GetAllVerkopers');
        DB::unprepared('
            CREATE PROCEDURE Sp_GetAllVerkopers()
            BEGIN
                SELECT VKPR.Id,
                       VKPR.Naam,
                       VKPR.SpecialeStatus,
                       VKPR.VerkooptSoort,
                       VKPR.StandType,
                       VKPR.Dagen,
                       VKPR.LogoUrl
                FROM verkopers AS VKPR;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS Sp_GetAllVerkopers');
    }
};
