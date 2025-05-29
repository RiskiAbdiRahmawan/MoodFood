<?php

namespace Database\Seeders;

use App\Models\FoodModel;
use App\Models\NutritionData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NutritionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nutritionData = [
            // Natural Foods
            'Bayam' => [
                'calories_per_100g' => 23,
                'protein_g' => 2.9,
                'carbohydrates_g' => 3.6,
                'fat_g' => 0.4,
                'fiber_g' => 2.2,
                'sugar_g' => 0.4,
                'sodium_mg' => 79,
                'vitamin_c_mg' => 28.1,
                'iron_mg' => 2.7,
                'calcium_mg' => 99,
                'other_nutrients' => json_encode([
                    'potassium_mg' => 558,
                    'magnesium_mg' => 79,
                    'phosphorus_mg' => 49,
                    'zinc_mg' => 0.5,
                    'vitamin_a_mcg' => 469,
                    'vitamin_d_mcg' => 0,
                    'vitamin_e_mg' => 2.0,
                    'vitamin_k_mcg' => 483,
                    'vitamin_b1_mg' => 0.1,
                    'vitamin_b2_mg' => 0.2,
                    'vitamin_b3_mg' => 0.7,
                    'vitamin_b6_mg' => 0.2,
                    'vitamin_b12_mcg' => 0,
                    'folate_mcg' => 194,
                    'cholesterol_mg' => 0,
                    'saturated_fat_g' => 0.1,
                    'monounsaturated_fat_g' => 0.0,
                    'polyunsaturated_fat_g' => 0.2
                ]),
                'health_benefits' => 'Kaya zat besi, vitamin K, dan folat. Baik untuk kesehatan mata dan tulang.',
                'mood_effects' => 'Membantu mengurangi stres dan meningkatkan energi karena kandungan zat besi dan magnesium.'
            ],
            'Alpukat' => [
                'calories_per_100g' => 160,
                'protein_g' => 2.0,
                'carbohydrates_g' => 8.5,
                'fat_g' => 14.7,
                'fiber_g' => 6.7,
                'sugar_g' => 0.7,
                'sodium_mg' => 7,
                'vitamin_c_mg' => 10.0,
                'iron_mg' => 0.6,
                'calcium_mg' => 12,
                'other_nutrients' => json_encode([
                    'potassium_mg' => 485,
                    'magnesium_mg' => 29,
                    'phosphorus_mg' => 52,
                    'zinc_mg' => 0.6,
                    'vitamin_a_mcg' => 7,
                    'vitamin_d_mcg' => 0,
                    'vitamin_e_mg' => 2.1,
                    'vitamin_k_mcg' => 21,
                    'vitamin_b1_mg' => 0.1,
                    'vitamin_b2_mg' => 0.1,
                    'vitamin_b3_mg' => 1.7,
                    'vitamin_b6_mg' => 0.3,
                    'vitamin_b12_mcg' => 0,
                    'folate_mcg' => 20,
                    'cholesterol_mg' => 0,
                    'saturated_fat_g' => 2.1,
                    'monounsaturated_fat_g' => 9.8,
                    'polyunsaturated_fat_g' => 1.8
                ]),
                'health_benefits' => 'Kaya lemak sehat, serat, dan potasium. Baik untuk jantung dan pencernaan.',
                'mood_effects' => 'Lemak sehat membantu produksi serotonin dan mengurangi peradangan yang dapat mempengaruhi mood.'
            ],

            // Processed Foods
            'Tempe' => [
                'calories_per_100g' => 190,
                'protein_g' => 20.3,
                'carbohydrates_g' => 7.6,
                'fat_g' => 10.8,
                'fiber_g' => 9.0,
                'sugar_g' => 0.7,
                'sodium_mg' => 9,
                'vitamin_c_mg' => 0,
                'iron_mg' => 2.7,
                'calcium_mg' => 111,
                'other_nutrients' => json_encode([
                    'potassium_mg' => 412,
                    'magnesium_mg' => 81,
                    'phosphorus_mg' => 266,
                    'zinc_mg' => 1.1,
                    'vitamin_a_mcg' => 0,
                    'vitamin_d_mcg' => 0,
                    'vitamin_e_mg' => 0.8,
                    'vitamin_k_mcg' => 0,
                    'vitamin_b1_mg' => 0.1,
                    'vitamin_b2_mg' => 0.4,
                    'vitamin_b3_mg' => 2.6,
                    'vitamin_b6_mg' => 0.2,
                    'vitamin_b12_mcg' => 0.1,
                    'folate_mcg' => 24,
                    'cholesterol_mg' => 0,
                    'saturated_fat_g' => 1.8,
                    'monounsaturated_fat_g' => 3.1,
                    'polyunsaturated_fat_g' => 5.3
                ]),
                'health_benefits' => 'Protein lengkap, probiotik, dan isoflavon. Baik untuk pencernaan dan kesehatan jantung.',
                'mood_effects' => 'Protein berkualitas tinggi membantu produksi neurotransmitter untuk mood yang stabil.'
            ],
            'Yogurt' => [
                'calories_per_100g' => 59,
                'protein_g' => 10.0,
                'carbohydrates_g' => 3.6,
                'fat_g' => 0.4,
                'fiber_g' => 0,
                'sugar_g' => 3.6,
                'sodium_mg' => 36,
                'vitamin_c_mg' => 0.5,
                'iron_mg' => 0.1,
                'calcium_mg' => 110,
                'other_nutrients' => json_encode([
                    'potassium_mg' => 141,
                    'magnesium_mg' => 11,
                    'phosphorus_mg' => 135,
                    'zinc_mg' => 0.6,
                    'vitamin_a_mcg' => 3,
                    'vitamin_d_mcg' => 0,
                    'vitamin_e_mg' => 0.1,
                    'vitamin_k_mcg' => 0.2,
                    'vitamin_b1_mg' => 0.0,
                    'vitamin_b2_mg' => 0.3,
                    'vitamin_b3_mg' => 0.8,
                    'vitamin_b6_mg' => 0.1,
                    'vitamin_b12_mcg' => 0.5,
                    'folate_mcg' => 7,
                    'cholesterol_mg' => 5,
                    'saturated_fat_g' => 0.3,
                    'monounsaturated_fat_g' => 0.1,
                    'polyunsaturated_fat_g' => 0.0
                ]),
                'health_benefits' => 'Probiotik untuk kesehatan usus, protein berkualitas, dan kalsium untuk tulang.',
                'mood_effects' => 'Probiotik dapat mempengaruhi gut-brain axis dan membantu mengurangi kecemasan.'
            ]
        ];

        foreach ($nutritionData as $foodName => $nutrition) {
            $food = FoodModel::where('name', $foodName)->first();
            
            if ($food) {
                NutritionData::updateOrCreate(
                    ['food_id' => $food->id],
                    array_merge($nutrition, [
                        'created_at' => now(),
                        'updated_at' => now()
                    ])
                );
            }
        }
    }
}
