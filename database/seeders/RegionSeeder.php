<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'titre' => 'Goma',
                'description' => 'Région de Goma',
            ],
            [
                'titre' => 'Matebe',
                'description' => 'Région de Matebe',
            ],
            [
                'titre' => 'Luviro',
                'description' => 'Région de Luviro',
            ],
            [
                'titre' => 'Kimbulu',
                'description' => 'Région de Kimbulu',
            ],
            [
                'titre' => 'Mutwanga',
                'description' => 'Région de Mutwanga',
            ],
            // Add more regions as needed
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
