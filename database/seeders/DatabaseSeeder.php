<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

         // Make sure there are products and users first
            \App\Models\User::factory(5)->create();
             \App\Models\Product::factory(5)->create();

             Review::factory(20)->create();

             $this->call(ProductSeeder::class);

    }
}
