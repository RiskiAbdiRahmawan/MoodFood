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
        // Create a test user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123')
            ]
        );

        // Run all seeders in the correct order
        $this->call([
            // Basic data structures
            MoodsSeeder::class,
            DietaryPreferencesSeeder::class,
            FoodCategoriesSeeder::class,
            FoodsSeeder::class,
            
            // Relationships and advanced data
            RecommendationsSeeder::class,
            RecipeSeeder::class,
            // NutritionDataSeeder::class, // Commented out - nutrition data now in foods table
            
            // User feedback and reviews
            FeedbackSeeder::class,
        ]);
    }
}
