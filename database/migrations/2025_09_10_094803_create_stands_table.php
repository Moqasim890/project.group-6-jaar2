<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('EvenementId')->constrained('evenements')->cascadeOnDelete();
            $table->foreignId('VerkoperId')->constrained('verkopers')->cascadeOnDelete();
            $table->enum('StandType', ['A','AA','AAplus']);
            $table->decimal('Prijs',10,2);
            $table->boolean('VerhuurdStatus')->default(true);
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();

            $table->index(['EvenementId','VerkoperId']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('stands');
    }
};
