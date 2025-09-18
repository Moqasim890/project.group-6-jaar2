<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('Naam',200);
            $table->date('Datum');            // evt. uitbreiden naar start/eind
            $table->string('Locatie',200);
            $table->unsignedInteger('AantalTicketsPerTijdslot');
            $table->unsignedInteger('BeschikbareStands');
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();

            $table->index('Datum');
        });

        DB::table('evenements')->insert([
            [
            'Naam' => 'Test Evenement 1',
            'Datum' => date('Y-m-d', strtotime('+1 month')),
            'Locatie' => 'Utrecht',
            'AantalTicketsPerTijdslot' => 100,
            'BeschikbareStands' => 20,
            'IsActief' => true,
            'Opmerking' => null,
            ],
            [
            'Naam' => 'Test Evenement 2',
            'Datum' => date('Y-m-d', strtotime('+2 months')),
            'Locatie' => 'Amsterdam',
            'AantalTicketsPerTijdslot' => 150,
            'BeschikbareStands' => 25,
            'IsActief' => true,
            'Opmerking' => null,
            ],
            [
            'Naam' => 'Test Evenement 3',
            'Datum' => date('Y-m-d', strtotime('+3 months')),
            'Locatie' => 'Rotterdam',
            'AantalTicketsPerTijdslot' => 120,
            'BeschikbareStands' => 15,
            'IsActief' => true,
            'Opmerking' => null,
            ],
        ]);
    }
    public function down(): void {
        Schema::dropIfExists('evenements');
    }
};
