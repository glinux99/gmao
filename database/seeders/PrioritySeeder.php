<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (optional, but recommended for clean seeding)
        Priority::truncate();

        // Define the priority data
        $priorities = [
            [
                'title' => 'Elevé',
                'value' => 'Elevé', // You can keep the same value as title or use a different one
                'color' => '#FF0000', // You can use color names or hex codes (e.g., '#FF0000')
                'is_default' => false,
            ],
            [
                'title' => 'Moyen',
                'value' => 'Moyen',
                'color' => '#FBFF00FF',
                'is_default' => true, // Set this as the default priority
            ],
            [
                'title' => 'Faible',
                'value' => 'Faible',
                'color' => '#8A8888FF',
                'is_default' => false,
            ],
        ];

        // Insert the data into the database
        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
