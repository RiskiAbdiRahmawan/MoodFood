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
            ['name' => 'Bayam', 'category_id' => $naturalCategory->id, 'description' => 'Sayuran hijau kaya zat besi', 'image_url' => null],
            ['name' => 'Alpukat', 'category_id' => $naturalCategory->id, 'description' => 'Buah kaya lemak sehat', 'image_url' => null],
            ['name' => 'Tempe', 'category_id' => $processedCategory->id, 'description' => 'Makanan fermentasi dari kedelai', 'image_url' => null],
            ['name' => 'Yogurt', 'category_id' => $processedCategory->id, 'description' => 'Produk susu fermentasi', 'image_url' => null],
        ];

        foreach ($foods as $food) {
            FoodModel::updateOrCreate(['name' => $food['name']], $food);
        }
    }
}
