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
        User::factory()->create([
            'name' => 'encargado',
            'email' => 'encargado@gmail.com',
            'usertype' => 'encargado'
        ]);

        User::factory()->create([
            'name' => 'administrador',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin'
        ]);

        User::factory(20)->create();
        
    }
}
