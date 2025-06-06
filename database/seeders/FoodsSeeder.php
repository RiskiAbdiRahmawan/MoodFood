<?php

namespace Database\Seeders;

use App\Models\FoodCategoryModel;
use App\Models\FoodModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $naturalCategory = FoodCategoryModel::where('name', 'Bahan Makanan Alami')->first();
        $processedCategory = FoodCategoryModel::where('name', 'Makanan Olahan')->first();

        $foods = [
            // Mood: Sedih
            [
                'name' => 'Tempe', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Kaya protein dan meningkatkan produksi serotonin',
                'calories_per_100g' => 199.1,
                'protein_per_100g' => 19,
                'fats_per_100g' => 7.7,
                'carbs_per_100g' => 17,
                'mood_tags' => json_encode(['sedih']),
                'image_url' => null
            ],
            [
                'name' => 'Pisang', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Mengandung vitamin B6 yang membantu produksi serotonin',
                'calories_per_100g' => 92,
                'protein_per_100g' => 1,
                'fats_per_100g' => 0.5,
                'carbs_per_100g' => 23.4,
                'mood_tags' => json_encode(['sedih', 'marah', 'cemas', 'bahagia', 'lelah', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Ikan mujair', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Kaya omega-3 yang mendukung kesehatan otak',
                'calories_per_100g' => 83.9,
                'protein_per_100g' => 18.2,
                'fats_per_100g' => 0.7,
                'carbs_per_100g' => 0,
                'mood_tags' => json_encode(['sedih']),
                'image_url' => null
            ],
            [
                'name' => 'Daun kelor', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Kaya antioksidan dan vitamin yang meningkatkan mood',
                'calories_per_100g' => 60,
                'protein_per_100g' => 5.3,
                'fats_per_100g' => 0.9,
                'carbs_per_100g' => 11.2,
                'mood_tags' => json_encode(['sedih']),
                'image_url' => null
            ],
            [
                'name' => 'Ubi jalar', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Karbohidrat kompleks yang menstabilkan gula darah',
                'calories_per_100g' => 102.1,
                'protein_per_100g' => 2.1,
                'fats_per_100g' => 0.1,
                'carbs_per_100g' => 24.3,
                'mood_tags' => json_encode(['sedih', 'cemas']),
                'image_url' => null
            ],
            [
                'name' => 'Jambu biji', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Kaya vitamin C yang mendukung sistem imun',
                'calories_per_100g' => 50.9,
                'protein_per_100g' => 0.8,
                'fats_per_100g' => 0.6,
                'carbs_per_100g' => 11.9,
                'mood_tags' => json_encode(['sedih']),
                'image_url' => null
            ],

            // Mood: Marah
            [
                'name' => 'Coklat hitam', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Mengandung triptofan yang meningkatkan serotonin dan meredakan emosi',
                'calories_per_100g' => 590,
                'protein_per_100g' => 10,
                'fats_per_100g' => 55,
                'carbs_per_100g' => 14,
                'mood_tags' => json_encode(['marah', 'bahagia', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Teh hijau', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Mengandung L-theanine yang menenangkan pikiran',
                'calories_per_100g' => 2,
                'protein_per_100g' => 0,
                'fats_per_100g' => 0,
                'carbs_per_100g' => 0.3,
                'mood_tags' => json_encode(['marah', 'cemas']),
                'image_url' => null
            ],
            [
                'name' => 'Yoghurt', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Probiotik yang mendukung kesehatan pencernaan dan otak',
                'calories_per_100g' => 65,
                'protein_per_100g' => 3.3,
                'fats_per_100g' => 3.8,
                'carbs_per_100g' => 4,
                'mood_tags' => json_encode(['marah', 'bahagia', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Madu', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Gula alami yang memberikan energi tanpa menyebabkan lonjakan gula darah',
                'calories_per_100g' => 304,
                'protein_per_100g' => 0.3,
                'fats_per_100g' => 0,
                'carbs_per_100g' => 82.4,
                'mood_tags' => json_encode(['marah', 'bahagia', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Alpukat', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Lemak sehat yang mendukung fungsi otak',
                'calories_per_100g' => 217,
                'protein_per_100g' => 1.9,
                'fats_per_100g' => 23.5,
                'carbs_per_100g' => 0.4,
                'mood_tags' => json_encode(['marah', 'cemas', 'bahagia']),
                'image_url' => null
            ],

            // Mood: Cemas
            [
                'name' => 'Telur ayam', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Protein berkualitas tinggi dan kolin untuk fungsi saraf',
                'calories_per_100g' => 155,
                'protein_per_100g' => 12.6,
                'fats_per_100g' => 10.6,
                'carbs_per_100g' => 1,
                'mood_tags' => json_encode(['cemas', 'lelah']),
                'image_url' => null
            ],
            [
                'name' => 'Kacang-kacangan', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Sumber magnesium alami yang menenangkan sistem saraf',
                'calories_per_100g' => 400,
                'protein_per_100g' => 25,
                'fats_per_100g' => 30,
                'carbs_per_100g' => 30,
                'mood_tags' => json_encode(['cemas', 'stress']),
                'image_url' => null
            ],

            // Mood: Bahagia & Lelah & Stress
            [
                'name' => 'Oat', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Melepaskan energi perlahan dan menjaga kadar gula darah stabil',
                'calories_per_100g' => 370,
                'protein_per_100g' => 12.5,
                'fats_per_100g' => 7,
                'carbs_per_100g' => 63,
                'mood_tags' => json_encode(['bahagia', 'lelah', 'stress']),
                'image_url' => null
            ],

            // Mood: Lelah
            [
                'name' => 'Almond', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Kaya magnesium dan vitamin E yang mendukung energi',
                'calories_per_100g' => 570,
                'protein_per_100g' => 18,
                'fats_per_100g' => 53,
                'carbs_per_100g' => 4,
                'mood_tags' => json_encode(['lelah']),
                'image_url' => null
            ],
            [
                'name' => 'Dada ayam', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Protein tanpa lemak untuk membangun dan memperbaiki jaringan',
                'calories_per_100g' => 164,
                'protein_per_100g' => 31,
                'fats_per_100g' => 3.5,
                'carbs_per_100g' => 0,
                'mood_tags' => json_encode(['lelah']),
                'image_url' => null
            ],
            [
                'name' => 'Bayam', 
                'category_id' => $naturalCategory->id, 
                'description' => 'Kaya zat besi yang membantu transportasi oksigen',
                'calories_per_100g' => 37,
                'protein_per_100g' => 3.7,
                'fats_per_100g' => 0.2,
                'carbs_per_100g' => 7.3,
                'mood_tags' => json_encode(['lelah']),
                'image_url' => null
            ],

            // Legacy natural items (keeping some existing ones)
            ['name' => 'Teh chamomile', 'category_id' => $naturalCategory->id, 'description' => 'Teh herbal untuk relaksasi dan tidur', 'image_url' => null],
            ['name' => 'Kenari', 'category_id' => $naturalCategory->id, 'description' => 'Mengandung asam lemak omega-3 untuk menenangkan', 'image_url' => null],
            ['name' => 'Stroberi', 'category_id' => $naturalCategory->id, 'description' => 'Vitamin C tinggi, menyegarkan dan meningkatkan mood', 'image_url' => null],
            ['name' => 'Jeruk', 'category_id' => $naturalCategory->id, 'description' => 'Sumber vitamin C dan antioksidan', 'image_url' => null],
            ['name' => 'Kurma', 'category_id' => $naturalCategory->id, 'description' => 'Sumber energi cepat dari gula alami', 'image_url' => null],
            ['name' => 'Biji chia', 'category_id' => $naturalCategory->id, 'description' => 'Sumber omega-3 dan serat', 'image_url' => null],
            ['name' => 'Teh Lavender', 'category_id' => $naturalCategory->id, 'description' => 'Mengandung senyawa aktif seperti linalool, linalyl acetate, dan flavonoid', 'image_url' => null],
            ['name' => 'Lemon', 'category_id' => $naturalCategory->id, 'description' => 'Kaya vitamin C yang dapat membantu menurunkan kadar kortisol (hormon stres) dan meningkatkan daya tahan tubuh', 'image_url' => null],

            // PROCESSED FOODS (Makanan Olahan)
            // Mood: Sedih
            [
                'name' => 'Susu UHT coklat', 
                'category_id' => $processedCategory->id, 
                'description' => 'Kombinasi kalsium dan coklat yang dapat meningkatkan mood dan memberikan rasa nyaman',
                'calories_per_100g' => 80,
                'protein_per_100g' => 3.2,
                'fats_per_100g' => 3.5,
                'carbs_per_100g' => 9.5,
                'mood_tags' => json_encode(['sedih', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Biskuit gandum', 
                'category_id' => $processedCategory->id, 
                'description' => 'Karbohidrat kompleks yang membantu menstabilkan mood dengan pelepasan serotonin',
                'calories_per_100g' => 435,
                'protein_per_100g' => 10.7,
                'fats_per_100g' => 14.9,
                'carbs_per_100g' => 66.6,
                'mood_tags' => json_encode(['sedih', 'lelah']),
                'image_url' => null
            ],

            // Mood: Marah
            [
                'name' => 'Es krim vanilla', 
                'category_id' => $processedCategory->id, 
                'description' => 'Memberikan efek menenangkan dan membantu menurunkan tingkat stres melalui rasa manis',
                'calories_per_100g' => 207,
                'protein_per_100g' => 3.5,
                'fats_per_100g' => 11,
                'carbs_per_100g' => 23.6,
                'mood_tags' => json_encode(['marah', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Smoothie buah kemasan', 
                'category_id' => $processedCategory->id, 
                'description' => 'Minuman buah praktis yang kaya vitamin dan memberikan efek menyegarkan',
                'calories_per_100g' => 54,
                'protein_per_100g' => 0.4,
                'fats_per_100g' => 0.2,
                'carbs_per_100g' => 13.3,
                'mood_tags' => json_encode(['marah', 'bahagia']),
                'image_url' => null
            ],

            // Mood: Cemas
            [
                'name' => 'Teh herbal kemasan', 
                'category_id' => $processedCategory->id, 
                'description' => 'Teh herbal siap minum dengan kandungan chamomile atau lavender untuk relaksasi',
                'calories_per_100g' => 1,
                'protein_per_100g' => 0,
                'fats_per_100g' => 0,
                'carbs_per_100g' => 0.2,
                'mood_tags' => json_encode(['cemas', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Roti gandum utuh', 
                'category_id' => $processedCategory->id, 
                'description' => 'Sumber karbohidrat kompleks yang membantu menstabilkan kadar gula darah dan mood',
                'calories_per_100g' => 247,
                'protein_per_100g' => 13,
                'fats_per_100g' => 4.2,
                'carbs_per_100g' => 41,
                'mood_tags' => json_encode(['cemas', 'lelah']),
                'image_url' => null
            ],

            // Mood: Bahagia
            [
                'name' => 'Coklat susu batangan', 
                'category_id' => $processedCategory->id, 
                'description' => 'Merangsang pelepasan endorfin dan serotonin yang meningkatkan perasaan bahagia',
                'calories_per_100g' => 535,
                'protein_per_100g' => 7.3,
                'fats_per_100g' => 29.7,
                'carbs_per_100g' => 59.4,
                'mood_tags' => json_encode(['bahagia', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Yogurt cup dengan buah', 
                'category_id' => $processedCategory->id, 
                'description' => 'Kombinasi probiotik dan vitamin dari buah yang mendukung kesehatan pencernaan dan mood',
                'calories_per_100g' => 89,
                'protein_per_100g' => 4.3,
                'fats_per_100g' => 3.3,
                'carbs_per_100g' => 11.9,
                'mood_tags' => json_encode(['bahagia', 'sedih']),
                'image_url' => null
            ],

            // Mood: Lelah
            [
                'name' => 'Energy bar protein', 
                'category_id' => $processedCategory->id, 
                'description' => 'Camilan tinggi protein dan karbohidrat untuk mengembalikan energi dengan cepat',
                'calories_per_100g' => 400,
                'protein_per_100g' => 20,
                'fats_per_100g' => 15,
                'carbs_per_100g' => 45,
                'mood_tags' => json_encode(['lelah', 'stress']),
                'image_url' => null
            ],
            [
                'name' => 'Jus jeruk kemasan', 
                'category_id' => $processedCategory->id, 
                'description' => 'Sumber vitamin C dan gula alami yang memberikan energi instan',
                'calories_per_100g' => 45,
                'protein_per_100g' => 0.7,
                'fats_per_100g' => 0.2,
                'carbs_per_100g' => 10.4,
                'mood_tags' => json_encode(['lelah', 'bahagia']),
                'image_url' => null
            ],

            // Mood: Stress
            [
                'name' => 'Granola bar', 
                'category_id' => $processedCategory->id, 
                'description' => 'Camilan sereal dengan kacang dan buah kering yang memberikan energi berkelanjutan',
                'calories_per_100g' => 471,
                'protein_per_100g' => 10.1,
                'fats_per_100g' => 19.8,
                'carbs_per_100g' => 64.8,
                'mood_tags' => json_encode(['stress', 'lelah']),
                'image_url' => null
            ],
            [
                'name' => 'Keju slice', 
                'category_id' => $processedCategory->id, 
                'description' => 'Sumber protein dan kalsium yang dapat membantu meredakan stres',
                'calories_per_100g' => 336,
                'protein_per_100g' => 22.2,
                'fats_per_100g' => 27.4,
                'carbs_per_100g' => 2.2,
                'mood_tags' => json_encode(['stress', 'cemas']),
                'image_url' => null
            ]
        ];

        foreach ($foods as $food) {
            FoodModel::updateOrCreate(['name' => $food['name']], $food);
        }
    }
}
