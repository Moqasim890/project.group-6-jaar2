<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('BezoekerId')->constrained('bezoekers')->cascadeOnDelete();
            $table->foreignId('EvenementId')->constrained('evenements')->cascadeOnDelete();
            $table->foreignId('PrijsId')->constrained('prijzen')->restrictOnDelete();
            $table->unsignedInteger('AantalTickets');
            $table->timestamp('Datum')->useCurrent(); // besteldatum
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();

            $table->index('PrijsId');
            $table->index('EvenementId');
            // $table->check('AantalTickets > 0');
        });
        // Optional: Add some initial data if needed
        
    }
    public function down(): void {
        Schema::dropIfExists('tickets');
    }
};
