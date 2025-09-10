<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
    }
    public function down(): void {
        Schema::dropIfExists('evenements');
    }
};
