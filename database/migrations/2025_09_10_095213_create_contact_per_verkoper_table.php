<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_per_verkoper', function (Blueprint $table) {
            $table->id();
            $table->foreignId('VerkoperId')->constrained('verkopers')->cascadeOnDelete();
            $table->foreignId('ContactpersoonId')->constrained('contactpersonen')->cascadeOnDelete();
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['VerkoperId','ContactpersoonId']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('contact_per_verkoper');
    }
};
