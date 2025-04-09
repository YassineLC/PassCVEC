<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Générer 50 fausses lignes
        Post::factory()->count(50)->create();
    }
} 