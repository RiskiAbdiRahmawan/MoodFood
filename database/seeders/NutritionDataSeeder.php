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
        $nutritions = [
            // Mood: Sedih
            [
                'food_id' => 1, // Pisang
                'calories_per_100g' => 89,
                'protein_g' => 1.1,
                'carbohydrates_g' => 22.8,
                'fat_g' => 0.3,
                'fiber_g' => 2.6,
                'sugar_g' => 12.2,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 8.7,
                'iron_mg' => 0.3,
                'calcium_mg' => 5,
                'other_nutrients' => 'Triptofan, Vitamin B6',
                'health_benefits' => 'Meningkatkan produksi serotonin, mendukung kesehatan jantung',
                'mood_effects' => 'Meningkatkan suasana hati saat sedih',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 2, // Ubi jalar
                'calories_per_100g' => 86,
                'protein_g' => 1.6,
                'carbohydrates_g' => 20.1,
                'fat_g' => 0.1,
                'fiber_g' => 3,
                'sugar_g' => 4.2,
                'sodium_mg' => 55,
                'vitamin_c_mg' => 2.4,
                'iron_mg' => 0.6,
                'calcium_mg' => 30,
                'other_nutrients' => 'Vitamin A, Beta-karoten',
                'health_benefits' => 'Menambah energi, mendukung kesehatan mata',
                'mood_effects' => 'Menambah energi saat sedih',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 3, // Kacang mete
                'calories_per_100g' => 553,
                'protein_g' => 18.2,
                'carbohydrates_g' => 30.2,
                'fat_g' => 43.9,
                'fiber_g' => 3.3,
                'sugar_g' => 5.9,
                'sodium_mg' => 12,
                'vitamin_c_mg' => 0.5,
                'iron_mg' => 6.7,
                'calcium_mg' => 37,
                'other_nutrients' => 'Magnesium, Zinc',
                'health_benefits' => 'Mendukung kesehatan tulang, meningkatkan mood',
                'mood_effects' => 'Meningkatkan suasana hati saat sedih',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 4, // Sup krim vegan
                'calories_per_100g' => 120,
                'protein_g' => 2.5,
                'carbohydrates_g' => 10,
                'fat_g' => 8,
                'fiber_g' => 2,
                'sugar_g' => 2,
                'sodium_mg' => 400,
                'vitamin_c_mg' => 3,
                'iron_mg' => 1,
                'calcium_mg' => 20,
                'other_nutrients' => 'Vitamin D (dari jamur)',
                'health_benefits' => 'Menghangatkan tubuh, mendukung relaksasi',
                'mood_effects' => 'Menenangkan saat sedih',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 5, // Banana bread vegan
                'calories_per_100g' => 250,
                'protein_g' => 4,
                'carbohydrates_g' => 40,
                'fat_g' => 8,
                'fiber_g' => 4,
                'sugar_g' => 15,
                'sodium_mg' => 200,
                'vitamin_c_mg' => 5,
                'iron_mg' => 1.5,
                'calcium_mg' => 30,
                'other_nutrients' => 'Triptofan',
                'health_benefits' => 'Meningkatkan energi, mendukung suasana hati',
                'mood_effects' => 'Meningkatkan suasana hati saat sedih',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Marah
            [
                'food_id' => 6, // Teh hijau
                'calories_per_100g' => 1,
                'protein_g' => 0.2,
                'carbohydrates_g' => 0,
                'fat_g' => 0,
                'fiber_g' => 0,
                'sugar_g' => 0,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 0,
                'iron_mg' => 0.02,
                'calcium_mg' => 0,
                'other_nutrients' => 'L-theanine, Kafein',
                'health_benefits' => 'Menenangkan pikiran, meningkatkan fokus',
                'mood_effects' => 'Meredakan kemarahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 7, // Biji labu
                'calories_per_100g' => 559,
                'protein_g' => 30,
                'carbohydrates_g' => 10.7,
                'fat_g' => 49,
                'fiber_g' => 6,
                'sugar_g' => 1.4,
                'sodium_mg' => 7,
                'vitamin_c_mg' => 1.9,
                'iron_mg' => 8.8,
                'calcium_mg' => 46,
                'other_nutrients' => 'Magnesium, Zinc',
                'health_benefits' => 'Menstabilkan mood, mendukung kesehatan jantung',
                'mood_effects' => 'Meredakan kemarahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 8, // Blueberry
                'calories_per_100g' => 57,
                'protein_g' => 0.7,
                'carbohydrates_g' => 14.5,
                'fat_g' => 0.3,
                'fiber_g' => 2.4,
                'sugar_g' => 10,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 9.7,
                'iron_mg' => 0.3,
                'calcium_mg' => 6,
                'other_nutrients' => 'Antioksidan (Anthocyanin)',
                'health_benefits' => 'Meredakan stres oksidatif, mendukung kesehatan otak',
                'mood_effects' => 'Meredakan kemarahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 9, // Smoothie blueberry almond
                'calories_per_100g' => 150,
                'protein_g' => 3,
                'carbohydrates_g' => 20,
                'fat_g' => 7,
                'fiber_g' => 3,
                'sugar_g' => 12,
                'sodium_mg' => 50,
                'vitamin_c_mg' => 10,
                'iron_mg' => 0.8,
                'calcium_mg' => 100,
                'other_nutrients' => 'Antioksidan, Vitamin E',
                'health_benefits' => 'Meningkatkan energi, mendukung kesehatan otak',
                'mood_effects' => 'Meredakan kemarahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 10, // Energy ball kurma-kacang
                'calories_per_100g' => 350,
                'protein_g' => 7,
                'carbohydrates_g' => 50,
                'fat_g' => 15,
                'fiber_g' => 8,
                'sugar_g' => 30,
                'sodium_mg' => 10,
                'vitamin_c_mg' => 1,
                'iron_mg' => 2,
                'calcium_mg' => 50,
                'other_nutrients' => 'Magnesium, Potassium',
                'health_benefits' => 'Menstabilkan energi, mendukung kesehatan jantung',
                'mood_effects' => 'Meredakan kemarahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Cemas
            [
                'food_id' => 11, // Teh chamomile
                'calories_per_100g' => 1,
                'protein_g' => 0,
                'carbohydrates_g' => 0,
                'fat_g' => 0,
                'fiber_g' => 0,
                'sugar_g' => 0,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 0,
                'iron_mg' => 0.08,
                'calcium_mg' => 2,
                'other_nutrients' => 'Apigenin',
                'health_benefits' => 'Mendukung relaksasi, meningkatkan kualitas tidur',
                'mood_effects' => 'Menenangkan saat cemas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 12, // Kenari
                'calories_per_100g' => 654,
                'protein_g' => 15.2,
                'carbohydrates_g' => 13.7,
                'fat_g' => 65.2,
                'fiber_g' => 6.7,
                'sugar_g' => 2.6,
                'sodium_mg' => 2,
                'vitamin_c_mg' => 1.3,
                'iron_mg' => 2.9,
                'calcium_mg' => 98,
                'other_nutrients' => 'Omega-3, Vitamin B6',
                'health_benefits' => 'Mendukung kesehatan otak, menenangkan sistem saraf',
                'mood_effects' => 'Menenangkan saat cemas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 13, // Coklat hitam
                'calories_per_100g' => 604,
                'protein_g' => 7.9,
                'carbohydrates_g' => 61,
                'fat_g' => 43.1,
                'fiber_g' => 11,
                'sugar_g' => 24,
                'sodium_mg' => 20,
                'vitamin_c_mg' => 0,
                'iron_mg' => 11.9,
                'calcium_mg' => 73,
                'other_nutrients' => 'Flavonoid, Magnesium',
                'health_benefits' => 'Meningkatkan endorfin, mendukung kesehatan jantung',
                'mood_effects' => 'Menenangkan saat cemas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 14, // Chia pudding coklat
                'calories_per_100g' => 180,
                'protein_g' => 5,
                'carbohydrates_g' => 20,
                'fat_g' => 10,
                'fiber_g' => 8,
                'sugar_g' => 8,
                'sodium_mg' => 50,
                'vitamin_c_mg' => 2,
                'iron_mg' => 2.5,
                'calcium_mg' => 150,
                'other_nutrients' => 'Omega-3, Flavonoid',
                'health_benefits' => 'Mendukung relaksasi, meningkatkan kesehatan pencernaan',
                'mood_effects' => 'Menenangkan saat cemas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 15, // Vegan trail mix
                'calories_per_100g' => 450,
                'protein_g' => 12,
                'carbohydrates_g' => 40,
                'fat_g' => 30,
                'fiber_g' => 7,
                'sugar_g' => 20,
                'sodium_mg' => 10,
                'vitamin_c_mg' => 5,
                'iron_mg' => 3,
                'calcium_mg' => 80,
                'other_nutrients' => 'Vitamin E, Magnesium',
                'health_benefits' => 'Menyediakan energi berkelanjutan, mendukung kesehatan saraf',
                'mood_effects' => 'Menenangkan saat cemas',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Bahagia
            [
                'food_id' => 16, // Stroberi
                'calories_per_100g' => 32,
                'protein_g' => 0.7,
                'carbohydrates_g' => 7.7,
                'fat_g' => 0.3,
                'fiber_g' => 2,
                'sugar_g' => 4.9,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 58.8,
                'iron_mg' => 0.4,
                'calcium_mg' => 16,
                'other_nutrients' => 'Antioksidan (Anthocyanin)',
                'health_benefits' => 'Meningkatkan mood, mendukung sistem imun',
                'mood_effects' => 'Meningkatkan suasana hati saat bahagia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 17, // Jeruk
                'calories_per_100g' => 47,
                'protein_g' => 0.9,
                'carbohydrates_g' => 11.8,
                'fat_g' => 0.1,
                'fiber_g' => 2.4,
                'sugar_g' => 9.4,
                'sodium_mg' => 0,
                'vitamin_c_mg' => 53.2,
                'iron_mg' => 0.1,
                'calcium_mg' => 40,
                'other_nutrients' => 'Folat, Antioksidan',
                'health_benefits' => 'Meningkatkan sistem imun, menyegarkan tubuh',
                'mood_effects' => 'Meningkatkan suasana hati saat bahagia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 18, // Almond (untuk Bahagia dan Lelah)
                'calories_per_100g' => 579,
                'protein_g' => 21.2,
                'carbohydrates_g' => 21.6,
                'fat_g' => 49.9,
                'fiber_g' => 12.5,
                'sugar_g' => 4.4,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 0,
                'iron_mg' => 3.7,
                'calcium_mg' => 269,
                'other_nutrients' => 'Vitamin E, Magnesium',
                'health_benefits' => 'Mendukung kesehatan saraf, meningkatkan energi dan daya tahan tubuh',
                'mood_effects' => 'Meningkatkan suasana hati saat bahagia, meningkatkan energi saat lelah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 19, // Dessert coklat-berry
                'calories_per_100g' => 200,
                'protein_g' => 4,
                'carbohydrates_g' => 30,
                'fat_g' => 8,
                'fiber_g' => 5,
                'sugar_g' => 15,
                'sodium_mg' => 50,
                'vitamin_c_mg' => 20,
                'iron_mg' => 2,
                'calcium_mg' => 60,
                'other_nutrients' => 'Antioksidan, Flavonoid',
                'health_benefits' => 'Meningkatkan mood, mendukung kesehatan jantung',
                'mood_effects' => 'Meningkatkan suasana hati saat bahagia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 20, // Salad buah saus kelapa
                'calories_per_100g' => 120,
                'protein_g' => 2,
                'carbohydrates_g' => 18,
                'fat_g' => 5,
                'fiber_g' => 3,
                'sugar_g' => 12,
                'sodium_mg' => 20,
                'vitamin_c_mg' => 30,
                'iron_mg' => 0.5,
                'calcium_mg' => 40,
                'other_nutrients' => 'Vitamin A, Potassium',
                'health_benefits' => 'Menyegarkan tubuh, mendukung hidrasi',
                'mood_effects' => 'Meningkatkan suasana hati saat bahagia',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Lelah
            [
                'food_id' => 21, // Kurma
                'calories_per_100g' => 277,
                'protein_g' => 1.8,
                'carbohydrates_g' => 75,
                'fat_g' => 0.2,
                'fiber_g' => 6.7,
                'sugar_g' => 66.5,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 0.4,
                'iron_mg' => 0.9,
                'calcium_mg' => 64,
                'other_nutrients' => 'Potassium, Magnesium',
                'health_benefits' => 'Menyediakan energi cepat, mendukung pencernaan',
                'mood_effects' => 'Meningkatkan energi saat lelah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 22, // Bayam
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
                'other_nutrients' => 'Vitamin A, Folat',
                'health_benefits' => 'Meningkatkan energi, mendukung pembentukan darah',
                'mood_effects' => 'Meningkatkan energi saat lelah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 23, // Protein shake vegan
                'calories_per_100g' => 150,
                'protein_g' => 10,
                'carbohydrates_g' => 20,
                'fat_g' => 5,
                'fiber_g' => 3,
                'sugar_g' => 10,
                'sodium_mg' => 100,
                'vitamin_c_mg' => 5,
                'iron_mg' => 1,
                'calcium_mg' => 150,
                'other_nutrients' => 'Vitamin B12 (fortifikasi)',
                'health_benefits' => 'Meningkatkan energi, mendukung pemulihan otot',
                'mood_effects' => 'Meningkatkan energi saat lelah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 24, // Sup bayam tofu
                'calories_per_100g' => 80,
                'protein_g' => 5,
                'carbohydrates_g' => 8,
                'fat_g' => 3,
                'fiber_g' => 2,
                'sugar_g' => 1,
                'sodium_mg' => 300,
                'vitamin_c_mg' => 15,
                'iron_mg' => 2,
                'calcium_mg' => 100,
                'other_nutrients' => 'Vitamin A, Magnesium',
                'health_benefits' => 'Meningkatkan energi, mendukung kesehatan tulang',
                'mood_effects' => 'Meningkatkan energi saat lelah',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mood: Stres
            [
                'food_id' => 25, // Oat bebas gluten
                'calories_per_100g' => 389,
                'protein_g' => 16.9,
                'carbohydrates_g' => 66.3,
                'fat_g' => 6.9,
                'fiber_g' => 10.6,
                'sugar_g' => 0,
                'sodium_mg' => 2,
                'vitamin_c_mg' => 0,
                'iron_mg' => 4.7,
                'calcium_mg' => 54,
                'other_nutrients' => 'Beta-glukan, Magnesium',
                'health_benefits' => 'Menstabilkan gula darah, mendukung pencernaan',
                'mood_effects' => 'Meredakan stres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 26, // Biji chia
                'calories_per_100g' => 486,
                'protein_g' => 16.5,
                'carbohydrates_g' => 42.1,
                'fat_g' => 30.7,
                'fiber_g' => 34.4,
                'sugar_g' => 0,
                'sodium_mg' => 16,
                'vitamin_c_mg' => 1.6,
                'iron_mg' => 7.7,
                'calcium_mg' => 631,
                'other_nutrients' => 'Omega-3, Antioksidan',
                'health_benefits' => 'Mendukung kesehatan jantung, meningkatkan pencernaan',
                'mood_effects' => 'Meredakan stres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 27, // Overnight oat
                'calories_per_100g' => 180,
                'protein_g' => 6,
                'carbohydrates_g' => 30,
                'fat_g' => 5,
                'fiber_g' => 8,
                'sugar_g' => 5,
                'sodium_mg' => 50,
                'vitamin_c_mg' => 2,
                'iron_mg' => 2,
                'calcium_mg' => 100,
                'other_nutrients' => 'Beta-glukan, Magnesium',
                'health_benefits' => 'Menstabilkan gula darah, mendukung relaksasi',
                'mood_effects' => 'Meredakan stres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 28, // Granola bar vegan
                'calories_per_100g' => 400,
                'protein_g' => 10,
                'carbohydrates_g' => 60,
                'fat_g' => 15,
                'fiber_g' => 8,
                'sugar_g' => 20,
                'sodium_mg' => 100,
                'vitamin_c_mg' => 1,
                'iron_mg' => 3,
                'calcium_mg' => 80,
                'other_nutrients' => 'Magnesium, Vitamin E',
                'health_benefits' => 'Menyediakan energi berkelanjutan, mendukung kesehatan saraf',
                'mood_effects' => 'Meredakan stres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 29, // Teh Lavender
                'calories_per_100g' => 0,
                'protein_g' => 0,
                'carbohydrates_g' => 0,
                'fat_g' => 0,
                'fiber_g' => 0,
                'sugar_g' => 0,
                'sodium_mg' => 1,
                'vitamin_c_mg' => 0,
                'iron_mg' => 0.2,
                'calcium_mg' => 2,
                'other_nutrients' => 'Linalool, Linalyl acetate, Antioksidan',
                'health_benefits' => 'Menenangkan sistem saraf, meningkatkan kualitas tidur',
                'mood_effects' => 'Mengurangi stres dan kecemasan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 30, // Lemon
                'calories_per_100g' => 29,
                'protein_g' => 1.1,
                'carbohydrates_g' => 9.3,
                'fat_g' => 0.3,
                'fiber_g' => 2.8,
                'sugar_g' => 2.5,
                'sodium_mg' => 2,
                'vitamin_c_mg' => 53,
                'iron_mg' => 0.6,
                'calcium_mg' => 26,
                'other_nutrients' => 'Flavonoid, Kalium, Antioksidan',
                'health_benefits' => 'Meningkatkan daya tahan tubuh, membantu detoksifikasi, menurunkan kortisol',
                'mood_effects' => 'Menyegarkan pikiran, membantu meredakan stres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($nutritions as $nutrition) {
            NutritionData::create($nutrition);
        }
    }
}
