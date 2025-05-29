<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\dietary_preferences_model;

class dietary_preferences extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $preferences = [
            ['name' => 'vegetarian', 'emoji_icon' => '🥬'],
            ['name' => 'vegan', 'emoji_icon' => '🌱'],
            ['name' => 'gluten-free', 'emoji_icon' => '🌾'],
            ['name' => 'keto', 'emoji_icon' => '🥑'],
            ['name' => 'low-carb', 'emoji_icon' => '🥩'],
            ['name' => 'dairy-free', 'emoji_icon' => '🥛'],
        ];

        foreach ($preferences as $pref) {
            dietary_preferences::updateOrCreate(['name' => $pref['name']], $pref);
        }
    }
}
