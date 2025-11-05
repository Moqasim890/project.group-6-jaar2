<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evenements', function (Blueprint $table) {
            // prevent two events at the same date AND same locatie
            $table->unique(['Datum', 'Locatie'], 'evenements_datum_locatie_unique');
        });
    }

    public function down(): void
    {
        Schema::table('evenements', function (Blueprint $table) {
            $table->dropUnique('evenements_datum_locatie_unique');
        });
    }
};
