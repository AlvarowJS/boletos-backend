<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Role::factory(2)->create();
        // \App\Models\User::factory(10)->create();

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 1',
        ]);

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 2',
        ]);

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 3',
        ]);

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 4',
        ]);

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 5',
        ]);

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 6',
        ]);

        \App\Models\Day::factory()->create([
            'nameDay' => 'Día 7',
        ]);
    }
}
