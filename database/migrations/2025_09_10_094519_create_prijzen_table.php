<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('prijzen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('EvenementId')->constrained('evenements')->cascadeOnDelete();
            $table->date('Datum');
            $table->time('Tijdslot'); // '11:00:00', etc.
            $table->decimal('Tarief',8,2);
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['EvenementId','Datum','Tijdslot']);
            // $table->check('Tarief >= 0');
        });
    }
    public function down(): void {
        Schema::dropIfExists('prijzen');
    }
};
