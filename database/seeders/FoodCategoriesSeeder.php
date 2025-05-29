<?php

namespace Database\Seeders;

use App\Models\FoodCategoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Bahan Makanan Alami'],
            ['name' => 'Makanan Olahan'],
        ];

        foreach ($categories as $cat) {
            FoodCategoryModel::updateOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
