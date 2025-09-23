<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::table('bezoekers')->insert([
            [
                'Naam' => 'Bezoeker 1',
                'EmailAdres' => 'bezoeker1@voorbeeld.nl',
            ],
        ]);
    }
    public function down(): void {
        Schema::dropIfExists('bezoekers');
    }
};
