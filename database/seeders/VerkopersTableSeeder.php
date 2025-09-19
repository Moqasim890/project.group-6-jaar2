<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VerkopersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //welke table moet gevult worden
        DB::table('verkopers')->insert([
            //inhoud als array/arrays
            [
                'Naam' => 'test',
                'SpecialeStatus' => 'Partner',
                'StandType' => 'AAPLUS', 
                'Dagen' => 'TWEE',
            ],
            [
                'Naam' => 'test2',
                'SpecialeStatus' => 'Partner',
                'StandType' => 'A', 
                'Dagen' => 'EEN',
            ],
            [
                'Naam' => 'test3',
                'SpecialeStatus' => 'Partner',
                'StandType' => 'AA', 
                'Dagen' => 'TWEE',
            ],
            [
                'Naam' => 'test4',
                'SpecialeStatus' => 'GEEN',
                'StandType' => 'AAPLUS', 
                'Dagen' => 'TWEE',
            ],
            [
                'Naam' => 'test5',
                'SpecialeStatus' => 'GEEN',
                'StandType' => 'A', 
                'Dagen' => 'EEN',
            ]
        ]);
    }
}
