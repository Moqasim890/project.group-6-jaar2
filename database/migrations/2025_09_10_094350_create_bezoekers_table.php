<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bezoekers', function (Blueprint $table) {
            $table->id();
            $table->string('Naam',150);
            $table->string('EmailAdres',190)->unique();
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();
        });
    }
    public function down(): void {
        Schema::dropIfExists('bezoekers');
    }
};
