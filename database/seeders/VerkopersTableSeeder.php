<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerkopersTableSeeder extends Seeder
{
    public function run(): void
    {
        // example data
        DB::table('verkopers')->insert([
            ['naam' => 'Demo Verkoper', 'email' => 'verkoper@example.com'],
        ]);
    }
}
