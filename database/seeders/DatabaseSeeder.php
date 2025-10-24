<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            VerkopersTableSeeder::class,
        ]);

        DB::table('organisators')->insert([
            [
                'Naam' => 'Admin',
                'Gebruikersnaam' => 'admin',
                'Wachtwoord' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // 'password'
            ],
        ]);

        DB::table('bezoekers')->insert([
            [
                'Naam' => 'Bezoeker 1',
                'EmailAdres' => 'bezoeker1@voorbeeld.nl',
            ],
        ]);

        DB::table('evenements')->insert([
            [
                'id' => 1,
                'Naam' => 'Evenement A',
                'Datum' => '2023-10-01',
                'Locatie' => 'Utrecht',
                'AantalTicketsPerTijdslot' => 5,
                'BeschikbareStands' => 20
            ],
            [
                'id' => 2,
                'Naam' => 'Evenement B',
                'Datum' => '2023-11-15',
                'Locatie' => 'Amsterdam',
                'AantalTicketsPerTijdslot' => 5,
                'BeschikbareStands' => 20
            ],
            [
                'id' => 3,
                'Naam' => 'Evenement C',
                'Datum' => '2023-12-01',
                'Locatie' => 'Rotterdam',
                'AantalTicketsPerTijdslot' => 5,
                'BeschikbareStands' => 20
            ],
        ]);

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
}
