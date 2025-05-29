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
        $sedih = MoodModel::where('name', 'sedih')->first();
        $bahagia = MoodModel::where('name', 'bahagia')->first();

        $vegetarian = DietaryPreferencesModel::where('name', 'vegetarian')->first();
        $vegan = DietaryPreferencesModel::where('name', 'vegan')->first();

        $bayam = FoodModel::where('name', 'Bayam')->first();
        $alpukat = FoodModel::where('name', 'Alpukat')->first();
        $tempe = FoodModel::where('name', 'Tempe')->first();
        $yogurt = FoodModel::where('name', 'Yogurt')->first();

        // Rekomendasi untuk sedih dan vegetarian
        RecommendationModel::updateOrCreate([
            'mood_id' => $sedih->id,
            'food_id' => $bayam->id,
            'dietary_preference_id' => $vegetarian->id,
        ]);

        RecommendationModel::updateOrCreate([
            'mood_id' => $sedih->id,
            'food_id' => $alpukat->id,
            'dietary_preference_id' => $vegan->id,
        ]);

        // Rekomendasi untuk bahagia tanpa preferensi diet khusus (null)
        RecommendationModel::updateOrCreate([
            'mood_id' => $bahagia->id,
            'food_id' => $tempe->id,
            'dietary_preference_id' => null,
        ]);

        RecommendationModel::updateOrCreate([
            'mood_id' => $bahagia->id,
            'food_id' => $yogurt->id,
            'dietary_preference_id' => null,
        ]);
    }
}
