<?php

namespace Database\Seeders;

use App\Models\MoodModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $moods = [
            ['name' => 'sedih', 'emoji_icon' => '😢', 'description' => 'Merasa down, kehilangan energi'],
            ['name' => 'marah', 'emoji_icon' => '😠', 'description' => 'Merasa kesal, emosi tidak stabil'],
            ['name' => 'cemas', 'emoji_icon' => '😰', 'description' => 'Merasa khawatir, gelisah'],
            ['name' => 'bahagia', 'emoji_icon' => '😊', 'description' => 'Merasa senang, bersemangat'],
            ['name' => 'lelah', 'emoji_icon' => '😴', 'description' => 'Merasa capek, butuh energi'],
            ['name' => 'stress', 'emoji_icon' => '😵', 'description' => 'Merasa tertekan, overwhelmed'],
        ];

        foreach ($moods as $mood) {
            MoodModel::updateOrCreate(['name' => $mood['name']], $mood);
        }
    }
}
