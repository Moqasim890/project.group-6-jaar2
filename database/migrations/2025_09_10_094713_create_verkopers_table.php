<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


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

      
    }
    public function down(): void {
        Schema::dropIfExists('verkopers');
    }
};
