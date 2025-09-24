<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //roept seeder aan zodat deze wordt uitgevoerd
        $this->call([
            //de seeder/seeders
            VerkopersTableSeeder::class
        ]);
    }
}
