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
        // User::factory(10)->create();
$user=
        User::factory()->create([
            'name' => 'Daniel Kikimba',
            'email' => 'genesiskikimba@gmail.com',
            'password'=>'genesiskikimba@gmail.com'
        ]);

        $this->call([
            PermissionSeeder::class,
            PrioritySeeder::class,
            RegionSeeder::class,
        ]);
        $user->assignRole('Root');
    }
}
