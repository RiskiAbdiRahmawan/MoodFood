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
                'food_id' => 1, // Tempe
                'dietary_preference_id' => 2, // Vegan
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 2, // Pisang
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 5, // Ubi jalar
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 1,
                'food_id' => 10, // Madu
                'dietary_preference_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Marah (mood_id = 2)
            [
                'mood_id' => 2,
                'food_id' => 8, // Teh hijau
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 18, // Teh chamomile
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 7, // Coklat hitam
                'dietary_preference_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 2,
                'food_id' => 2, // Pisang
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Cemas (mood_id = 3)
            [
                'mood_id' => 3,
                'food_id' => 18, // Teh chamomile
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 19, // Kenari
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 7, // Coklat hitam
                'dietary_preference_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 23, // Biji chia
                'dietary_preference_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 3,
                'food_id' => 24, // Teh Lavender
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Bahagia (mood_id = 4)
            [
                'mood_id' => 4,
                'food_id' => 20, // Stroberi
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 21, // Jeruk
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 15, // Almond
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 6, // Jambu biji
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 4,
                'food_id' => 25, // Lemon
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Lelah (mood_id = 5)
            [
                'mood_id' => 5,
                'food_id' => 15, // Almond
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 22, // Kurma
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 17, // Bayam
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 12, // Telur ayam
                'dietary_preference_id' => 4, // Contains eggs
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 5,
                'food_id' => 16, // Dada ayam
                'dietary_preference_id' => 4, // Contains meat
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Stres (mood_id = 6)
            [
                'mood_id' => 6,
                'food_id' => 14, // Oat
                'dietary_preference_id' => 3, // Gluten-free
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 23, // Biji chia
                'dietary_preference_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 24, // Teh Lavender
                'dietary_preference_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 13, // Kacang-kacangan
                'dietary_preference_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mood_id' => 6,
                'food_id' => 11, // Alpukat
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
