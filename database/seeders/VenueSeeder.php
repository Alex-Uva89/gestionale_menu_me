<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // devo inserire 3 locali diversi
        $venues = [
            [
                'name' => 'La Cucina',
                'image' => 'img/laCucina_logo.jpeg',
                'path' => '',
                'color' => 'green',
                'address' => 'Via Ludovico Maremonti, 33, 73100 Lecce LE',
                'phone' => '+39 331 579 5127',
                'email' => 'lacucina@mammaelvira',
                'icon' => '',
            ],
            [
                'name' => "'Scante'",
                'image' => 'img/scante_logo.png',
                'path' => '',
                'color' => 'gray',
                'address' => 'Via Ludovico Maremonti, 41, 73100 Lecce LE',
                'phone' => '+39 348 302 1637',
                'email' => 'scante@mammaelvira.com',
                'icon' => '',
            ],
            [
                'name' => 'Enoteca',
                'image' => 'img/enoteca_logo.png',
                'path' => '',
                'color' => 'red',
                'address' => 'Via Umberto I, 19, 73100 Lecce LE',
                'phone' => '+39 349 113 3126',
                'email' => 'enoteca@mammaelvira.com',
                'icon' => '',
            ],
        ];

        DB::table('venues')->insert($venues);
        
    }
}
