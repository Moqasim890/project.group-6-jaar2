<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerkopersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('verkopers')->insert([
            [
                'id' => 1,
                'Naam' => 'Sneaker King',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'SNEAKERS',
                'StandType' => 'A',
                'Dagen' => 'EEN',
                'LogoUrl' => null,
                'IsActief' => true,
                'Opmerking' => 'Populaire sneakerverkoper',
            ],
            [
                'id' => 2,
                'Naam' => 'Food Express',
                'SpecialeStatus' => 'PARTNER',
                'VerkooptSoort' => 'ETEN_DRINKEN',
                'StandType' => 'AA',
                'Dagen' => 'TWEE',
                'LogoUrl' => null,
                'IsActief' => true,
                'Opmerking' => 'Streetfood met flair',
            ],
            [
                'id' => 3,
                'Naam' => 'Kids Corner BV',
                'SpecialeStatus' => 'GEEN',
                'VerkooptSoort' => 'KIDS_CORNER',
                'StandType' => 'AAplus',
                'Dagen' => 'EEN',
                'LogoUrl' => null,
                'IsActief' => true,
                'Opmerking' => 'Leuke activiteiten voor kinderen',
            ],
        ]);
    }
}

