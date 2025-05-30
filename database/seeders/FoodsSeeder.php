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
            ['name' => 'Pisang', 'category_id' => $naturalCategory->id, 'description' => 'Mengandung triptofan yang bantu produksi serotonin', 'image_url' => null],
            ['name' => 'Ubi jalar', 'category_id' => $naturalCategory->id, 'description' => 'Karbohidrat kompleks penambah energi', 'image_url' => null],
            ['name' => 'Kacang mete', 'category_id' => $naturalCategory->id, 'description' => 'Sumber magnesium alami untuk mood', 'image_url' => null],
            ['name' => 'Sup krim vegan', 'category_id' => $processedCategory->id, 'description' => 'Sup hangat dari jamur & santan, menenangkan saat sedih', 'image_url' => null],
            ['name' => 'Banana bread vegan', 'category_id' => $processedCategory->id, 'description' => 'Kue pisang sehat tanpa gluten dan dairy', 'image_url' => null],

            // Mood: Marah
            ['name' => 'Teh hijau', 'category_id' => $naturalCategory->id, 'description' => 'Mengandung L-theanine yang menenangkan', 'image_url' => null],
            ['name' => 'Biji labu', 'category_id' => $naturalCategory->id, 'description' => 'Kaya magnesium dan zinc untuk stabilisasi mood', 'image_url' => null],
            ['name' => 'Blueberry', 'category_id' => $naturalCategory->id, 'description' => 'Antioksidan tinggi untuk bantu redakan stres oksidatif', 'image_url' => null],
            ['name' => 'Smoothie blueberry almond', 'category_id' => $processedCategory->id, 'description' => 'Minuman sehat kaya antioksidan', 'image_url' => null],
            ['name' => 'Energy ball kurma-kacang', 'category_id' => $processedCategory->id, 'description' => 'Camilan sehat penstabil energi dan emosi', 'image_url' => null],

            // Mood: Cemas
            ['name' => 'Teh chamomile', 'category_id' => $naturalCategory->id, 'description' => 'Teh herbal untuk relaksasi dan tidur', 'image_url' => null],
            ['name' => 'Kenari', 'category_id' => $naturalCategory->id, 'description' => 'Mengandung asam lemak omega-3 untuk menenangkan', 'image_url' => null],
            ['name' => 'Coklat hitam', 'category_id' => $naturalCategory->id, 'description' => 'Meningkatkan endorfin dan serotonin', 'image_url' => null],
            ['name' => 'Chia pudding coklat', 'category_id' => $processedCategory->id, 'description' => 'Camilan sehat berbasis chia & santan, bantu rileks', 'image_url' => null],
            ['name' => 'Vegan trail mix', 'category_id' => $processedCategory->id, 'description' => 'Campuran kacang dan buah kering untuk ngemil sehat', 'image_url' => null],

            // Mood: Bahagia
            ['name' => 'Stroberi', 'category_id' => $naturalCategory->id, 'description' => 'Vitamin C tinggi, menyegarkan dan meningkatkan mood', 'image_url' => null],
            ['name' => 'Jeruk', 'category_id' => $naturalCategory->id, 'description' => 'Sumber vitamin C dan antioksidan', 'image_url' => null],
            ['name' => 'Almond', 'category_id' => $naturalCategory->id, 'description' => 'Kaya vitamin E, protein, dan lemak sehat untuk dukung sistem saraf dan daya tahan tubuh', 'image_url' => null],
            ['name' => 'Dessert coklat-berry', 'category_id' => $processedCategory->id, 'description' => 'Makanan penutup sehat dan nikmat', 'image_url' => null],
            ['name' => 'Salad buah saus kelapa', 'category_id' => $processedCategory->id, 'description' => 'Salad segar dengan saus kelapa vegan', 'image_url' => null],

            // Mood: Lelah
            ['name' => 'Kurma', 'category_id' => $naturalCategory->id, 'description' => 'Sumber energi cepat dari gula alami', 'image_url' => null],
            ['name' => 'Bayam', 'category_id' => $naturalCategory->id, 'description' => 'Kaya zat besi dan vitamin B untuk energi', 'image_url' => null],
            ['name' => 'Protein shake vegan', 'category_id' => $processedCategory->id, 'description' => 'Minuman energi dari pisang & susu almond', 'image_url' => null],
            ['name' => 'Sup bayam tofu', 'category_id' => $processedCategory->id, 'description' => 'Sup hangat mengandung protein nabati', 'image_url' => null],

            // Mood: Stres
            ['name' => 'Oat bebas gluten', 'category_id' => $naturalCategory->id, 'description' => 'Karbo kompleks yang menstabilkan gula darah', 'image_url' => null],
            ['name' => 'Biji chia', 'category_id' => $naturalCategory->id, 'description' => 'Sumber omega-3 dan serat', 'image_url' => null],
            ['name' => 'Overnight oat', 'category_id' => $processedCategory->id, 'description' => 'Oat semalaman dengan susu nabati, bantu relaksasi', 'image_url' => null],
            ['name' => 'Granola bar vegan', 'category_id' => $processedCategory->id, 'description' => 'Camilan praktis kaya energi dan nutrisi', 'image_url' => null],
            ['name' => 'Teh Lavender', 'category_id' => $naturalCategory->id, 'description' => 'Mengandung senyawa aktif seperti linalool, linalyl acetate, dan flavonoid', 'image_url' => null],
            ['name' => 'Lemon', 'category_id' => $naturalCategory->id, 'description' => 'Kaya vitamin C yang dapat membantu menurunkan kadar kortisol (hormon stres) dan meningkatkan daya tahan tubuh.', 'image_url' => null],
        ];

        foreach ($foods as $food) {
            FoodModel::updateOrCreate(['name' => $food['name']], $food);
        }
    }
}
