<?php

namespace Database\Seeders;

use App\Models\DietaryPreferencesModel;
use App\Models\FoodModel;
use App\Models\MoodModel;
use App\Models\RecommendationModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecommendationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $recommendations = [
            // Mood: Sedih (mood_id = 1)
            [
                'mood_id' => 1,
                'food_id' => 1, // Pisang
                'dietary_preference_id' => 2, // Vegan
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 2, // Ubi jalar
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 3, // Kacang mete
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 4, // Sup krim vegan
                'dietary_preference_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 5, // Banana bread vegan
                'dietary_preference_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Marah (mood_id = 2)
            [
                'mood_id' => 2,
                'food_id' => 6, // Teh hijau
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 7, // Biji labu
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 8, // Blueberry
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 9, // Smoothie blueberry almond
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 10, // Energy ball kurma-kacang
                'dietary_preference_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Cemas (mood_id = 3)
            [
                'mood_id' => 3,
                'food_id' => 11, // Teh chamomile
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 12, // Kenari
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 13, // Coklat hitam
                'dietary_preference_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 14, // Chia pudding coklat
                'dietary_preference_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 15, // Vegan trail mix
                'dietary_preference_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Bahagia (mood_id = 4)
            [
                'mood_id' => 4,
                'food_id' => 16, // Stroberi
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 17, // Jeruk
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 18, // Almond
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 19, // Dessert coklat-berry
                'dietary_preference_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 20, // Salad buah saus kelapa
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Lelah (mood_id = 5)
            [
                'mood_id' => 5,
                'food_id' => 18, // Almond
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 21, // Kurma
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 22, // Bayam
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 23, // Protein shake vegan
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 24, // Sup bayam tofu
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Stres (mood_id = 6)
            [
                'mood_id' => 6,
                'food_id' => 25, // Oat bebas gluten
                'dietary_preference_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 26, // Biji chia
                'dietary_preference_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 27, // Overnight oat
                'dietary_preference_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 28, // Granola bar vegan
                'dietary_preference_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 29, // Granola bar vegan
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 30, // Granola bar vegan
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($recommendations as $recommendation) {
            RecommendationModel::create($recommendation);
        }
    }
}
