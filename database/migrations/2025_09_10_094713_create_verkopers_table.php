<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('verkopers', function (Blueprint $table) {
            $table->id();
            $table->string('Naam',200);
            $table->enum('SpecialeStatus', ['GEEN','PARTNER'])->default('GEEN');
            $table->enum('VerkooptSoort', ['SNEAKERS','ETEN_DRINKEN','KIDS_CORNER','CUSTOMIZERS','TATTOO','BARBERSHOP','DJ_SET','OVERIG']);
            $table->enum('StandType', ['A','AA','AAplus'])->nullable();
            $table->enum('Dagen', ['EEN','TWEE'])->nullable();
            $table->string('LogoUrl',500)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();

            $table->index('SpecialeStatus');
            $table->index('VerkooptSoort');
        });

        DB::table('verkopers')->insert([
            [
                'Naam' => 'Verkoper 1',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'SNEAKERS',
                'StandType' => 'A',
                'Dagen' => 'EEN',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 2',
                'SpecialeStatus' => 'PARTNER',
                'VerkooptSoort' => 'ETEN_DRINKEN',
                'StandType' => 'AA',
                'Dagen' => 'TWEE',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 3',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'KIDS_CORNER',
                'StandType' => 'AAplus',
                'Dagen' => 'EEN',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 4',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'CUSTOMIZERS',
                'StandType' => null,
                'Dagen' => 'TWEE',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 5',
                'SpecialeStatus' => 'PARTNER',
                'VerkooptSoort' => 'TATTOO',
                'StandType' => 'A',
                'Dagen' => 'EEN',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 6',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'BARBERSHOP',
                'StandType' => 'AA',
                'Dagen' => 'TWEE',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 7',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'DJ_SET',
                'StandType' => 'AAplus',
                'Dagen' => 'EEN',
                'LogoUrl' => null,
            ],
            [
                'Naam' => 'Verkoper 8',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'OVERIG',
                'StandType' => null,
                'Dagen' => 'TWEE',
                'LogoUrl' => null,
            ],

        ]);

    }
    public function down(): void {
        Schema::dropIfExists('verkopers');
    }
};
