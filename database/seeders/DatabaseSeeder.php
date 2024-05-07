<?php

namespace Database\Seeders;

use App\Models\Product;
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
            'role' => 'admin',
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'role' => 'customer',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        Product::factory(10)->create(['status' => 1]);
    }
}
