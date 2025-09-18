<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            // $table->check('Prijs >= 0');
        });

        // Insert 5 rows of dummy data into stands table
        DB::table('stands')->insert([
            [
            'EvenementId' => 1,
            'VerkoperId' => 1,
            'StandType' => 'A',
            'Prijs' => 100.00,
            'VerhuurdStatus' => true,
            ],
            [
            'EvenementId' => 1,
            'VerkoperId' => 2,
            'StandType' => 'AA',
            'Prijs' => 150.00,
            'VerhuurdStatus' => false,
            ],
            [
            'EvenementId' => 2,
            'VerkoperId' => 3,
            'StandType' => 'AAplus',
            'Prijs' => 200.00,
            'VerhuurdStatus' => true,
            ],
            [
            'EvenementId' => 2,
            'VerkoperId' => 1,
            'StandType' => 'A',
            'Prijs' => 120.00,
            'VerhuurdStatus' => true,
            ],
            [
            'EvenementId' => 3,
            'VerkoperId' => 2,
            'StandType' => 'AA',
            'Prijs' => 180.00,
            'VerhuurdStatus' => false,
            ],
        ]);
    }
    public function down(): void {
        Schema::dropIfExists('stands');
    }
};
