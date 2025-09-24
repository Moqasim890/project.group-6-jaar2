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

        DB::table('prijzen')->insert([
            [
                'EvenementId' => 1,
                'Datum' => '2023-10-01',
                'Tijdslot' => '10:00:00',
                'Tarief' => 15.00,
                'IsActief' => true,
                'Opmerking' => 'Vroege vogel korting',
            ],
            [
                'EvenementId' => 1,
                'Datum' => '2023-10-01',
                'Tijdslot' => '14:00:00',
                'Tarief' => 20.00,
                'IsActief' => true,
                'Opmerking' => null,
            ],
            [
                'EvenementId' => 2,
                'Datum' => '2023-11-15',
                'Tijdslot' => '18:00:00',
                'Tarief' => 25.00,
                'IsActief' => true,
                'Opmerking' => 'Inclusief drankje',
            ],
        ]);
    }
    public function down(): void {
        Schema::dropIfExists('prijzen');
    }
};
