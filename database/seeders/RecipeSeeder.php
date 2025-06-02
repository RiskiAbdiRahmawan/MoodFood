<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            // Mood: Sedih
            [
                'name' => 'Bolu pisang kukus',
                'description' => 'Kue pisang kukus yang lembut dan menenangkan',
                'category' => 'sarapan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 40,
                'cook_time_minutes' => 30,
                'servings' => 8,
                'calories_per_serving' => 196,
                'protein_per_serving' => 3.4,
                'carbs_per_serving' => 28.3,
                'fats_per_serving' => 8.3,
                'mood_tags' => json_encode(['sedih']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '3 buah pisang matang ukuran besar',
                    '2 butir telur',
                    '5 sdm gula',
                    '7 sdm tepung terigu',
                    '½ sdt soda kue (opsional)',
                    'Sejumput garam',
                    '4 sdm minyak kelapa/minyak sayur',
                    '½ sdt vanili (opsional)'
                ]),
                'instructions' => json_encode([
                    'Campur telur dan gula, aduk sampai tercampur rata.',
                    'Masukkan pisang lumat, minyak, dan vanili. Aduk rata.',
                    'Ayak tepung, baking powder, soda kue, dan garam. Masukkan ke adonan basah, aduk lipat sampai halus.',
                    'Tuang ke loyang atau cetakan muffin (olesi minyak sebelumnya) boleh ditambah topping sesuai selera.',
                    'Kukus 25–30 menit api sedang, tutup dilapisi kain agar uap tidak menetes.',
                    'Angkat, dinginkan sebentar, lalu sajikan.'
                ])
            ],
            [
                'name' => 'Kue talam ubi',
                'description' => 'Kue tradisional dari ubi jalar yang memberikan energi berkelanjutan',
                'category' => 'cemilan',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 45,
                'cook_time_minutes' => 30,
                'servings' => 10,
                'calories_per_serving' => 133,
                'protein_per_serving' => 1.4,
                'carbs_per_serving' => 17.1,
                'fats_per_serving' => 7.1,
                'mood_tags' => json_encode(['sedih']),
                'dietary_tags' => json_encode(['vegetarian', 'gluten-free']),
                'ingredients' => json_encode([
                    '250 gr ubi jalar kukus, haluskan',
                    '200 ml santan encer',
                    '2 sdm tepung tapioka/singkong/maizena',
                    '2 sdm gula kelapa/aren',
                    'Sejumput garam',
                    '150 ml santan kental',
                    '1 sdm tepung beras',
                    '½ sdm tepung maizena/tapioka',
                    'Sejumput garam'
                ]),
                'instructions' => json_encode([
                    'Campur semua bahan A dalam wadah, aduk hingga licin.',
                    'Tuang ke dalam cetakan talam kecil (atau loyang kecil).',
                    'Kukus selama ±15 menit hingga setengah matang.',
                    'Campur semua bahan B, aduk rata.',
                    'Tuang perlahan di atas lapisan ubi yang sudah dikukus.',
                    'Kukus kembali ±15 menit hingga kedua lapisan matang.',
                    'Dinginkan, lalu sajikan. Bisa disimpan di kulkas dan disantap dingin.'
                ])
            ],

            // Mood: Marah
            [
                'name' => 'Banana-Choco Bites',
                'description' => 'Gigitan pisang berlapis coklat yang menenangkan emosi',
                'category' => 'cemilan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 15,
                'cook_time_minutes' => 60,
                'servings' => 4,
                'calories_per_serving' => 110,
                'protein_per_serving' => 2,
                'carbs_per_serving' => 7.8,
                'fats_per_serving' => 8,
                'mood_tags' => json_encode(['marah', 'bahagia']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '1 buah pisang, potong bulat',
                    '50 gr coklat hitam, lelehkan',
                    '1 sdm kacang almond cincang',
                    '½ sdm yoghurt'
                ]),
                'instructions' => json_encode([
                    'Campur kacang dan yoghurt dalam coklat leleh',
                    'Celupkan potongan pisang ke coklat leleh.',
                    'Tambahkan almond cincang lagi untuk topping jika mau.',
                    'Simpan di freezer selama 30 menit – 1 jam.',
                    'Sajikan dingin!'
                ])
            ],

            // Mood: Cemas
            [
                'name' => 'Smoothie alpukat-pisang',
                'description' => 'Smoothie creamy yang menenangkan dengan lemak sehat',
                'category' => 'minuman',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 10,
                'cook_time_minutes' => 0,
                'servings' => 2,
                'calories_per_serving' => 412,
                'protein_per_serving' => 5,
                'carbs_per_serving' => 21,
                'fats_per_serving' => 35.5,
                'mood_tags' => json_encode(['cemas']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free']),
                'ingredients' => json_encode([
                    '1 buah alpukat matang',
                    '1 buah pisang matang',
                    '100 ml susu almond atau susu rendah lemak',
                    '1 sdm madu / sirup maple / simple sirup (opsional)',
                    'Es batu secukupnya'
                ]),
                'instructions' => json_encode([
                    'Potong alpukat dan pisang, masukkan ke dalam blender.',
                    'Tambahkan susu dan madu.',
                    'Blender hingga halus dan creamy.',
                    'Tambahkan es batu sesuai selera, blender kembali hingga tercampur rata.',
                    'Tuang ke dalam gelas dan sajikan segera.'
                ])
            ],
            [
                'name' => 'Ubi jalar kukus dengan kayu manis',
                'description' => 'Camilan sehat yang menstabilkan gula darah dan mood',
                'category' => 'cemilan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 25,
                'cook_time_minutes' => 20,
                'servings' => 2,
                'calories_per_serving' => 175.5,
                'protein_per_serving' => 3,
                'carbs_per_serving' => 33,
                'fats_per_serving' => 4.15,
                'mood_tags' => json_encode(['cemas']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free']),
                'ingredients' => json_encode([
                    '2 buah ubi jalar ukuran sedang, kupas dan potong-potong',
                    '1 sdm mentega (opsional)',
                    '½ sdt bubuk kayu manis'
                ]),
                'instructions' => json_encode([
                    'Kukus potongan ubi jalar hingga empuk (sekitar 15-20 menit).',
                    'Letakkan ubi kukus di piring saji.',
                    'Olesi dengan mentega, lalu taburi dengan bubuk kayu manis.'
                ])
            ],

            // Mood: Bahagia
            [
                'name' => 'Avocado yoghurt toast cup',
                'description' => 'Cup oat kreatif dengan topping alpukat dan yogurt',
                'category' => 'sarapan',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 25,
                'cook_time_minutes' => 15,
                'servings' => 2,
                'calories_per_serving' => 138.5,
                'protein_per_serving' => 3,
                'carbs_per_serving' => 19,
                'fats_per_serving' => 6,
                'mood_tags' => json_encode(['bahagia']),
                'dietary_tags' => json_encode(['vegetarian', 'gluten-free']),
                'ingredients' => json_encode([
                    '4 sdm oat (diblender halus)',
                    '1 sdm madu',
                    '2 sdm yogurt',
                    '¼ buah alpukat (haluskan)',
                    'Sedikit air lemon atau jeruk nipis'
                ]),
                'instructions' => json_encode([
                    'Campur oat dan madu, bentuk jadi "cup" di loyang muffin mini.',
                    'Panggang 180°C selama 15 menit hingga agak keras.',
                    'Campurkan alpukat, yogurt, dan perasan lemon.',
                    'Isi ke dalam oat cup.',
                    'Sajikan dingin atau suhu ruang.'
                ])
            ],

            // Mood: Lelah
            [
                'name' => 'Oat pisang almond',
                'description' => 'Sarapan bergizi tinggi untuk mengembalikan energi',
                'category' => 'sarapan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 10,
                'cook_time_minutes' => 0,
                'servings' => 1,
                'calories_per_serving' => 492,
                'protein_per_serving' => 16,
                'carbs_per_serving' => 70,
                'fats_per_serving' => 18,
                'mood_tags' => json_encode(['lelah']),
                'dietary_tags' => json_encode(['vegetarian', 'gluten-free']),
                'ingredients' => json_encode([
                    '4 sdm oat',
                    '1 buah pisang matang, iris',
                    '1 sdm almond cincang',
                    '150 ml air panas atau susu',
                    'Madu dan kayu manis (opsional)'
                ]),
                'instructions' => json_encode([
                    'Seduh oatmeal dengan air panas atau susu, diamkan 3–5 menit hingga lunak.',
                    'Aduk, lalu tambahkan irisan pisang dan taburi almond.',
                    'Tambahkan madu dan kayu manis jika suka rasa manis alami.'
                ])
            ],
            [
                'name' => 'Telur orak arik bayam dengan roti',
                'description' => 'Sarapan protein tinggi dengan zat besi untuk energi',
                'category' => 'sarapan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 15,
                'cook_time_minutes' => 10,
                'servings' => 1,
                'calories_per_serving' => 360,
                'protein_per_serving' => 17,
                'carbs_per_serving' => 17,
                'fats_per_serving' => 25,
                'mood_tags' => json_encode(['lelah']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '2 butir telur ayam',
                    '1 genggam bayam segar, cuci bersih',
                    '1 sdm minyak zaitun',
                    '1 iris roti tawar atau gandum',
                    'Garam dan lada secukupnya'
                ]),
                'instructions' => json_encode([
                    'Panaskan minyak di wajan.',
                    'Tumis bayam sebentar hingga layu (±1 menit).',
                    'Kocok telur, tambahkan garam & lada, lalu tuang ke wajan.',
                    'Aduk pelan hingga matang (orak-arik).',
                    'Sajikan bersama roti gandum yang telah dipanggang ringan.'
                ])
            ],

            // Mood: Stress
            [
                'name' => 'Homemade Granola Bar',
                'description' => 'Bar granola buatan sendiri yang meredakan stres',
                'category' => 'cemilan',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 20,
                'cook_time_minutes' => 120,
                'servings' => 8,
                'calories_per_serving' => 181.5,
                'protein_per_serving' => 4.6,
                'carbs_per_serving' => 19.3,
                'fats_per_serving' => 9.9,
                'mood_tags' => json_encode(['stress']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free']),
                'ingredients' => json_encode([
                    '120 gr oat instan',
                    '55 gr kacang almond cincang',
                    '85 gr madu atau sirup maple',
                    '32 gr selai kacang alami',
                    '45 gr dark chocolate chips (opsional)'
                ]),
                'instructions' => json_encode([
                    'Campur oat, dan kacang.',
                    'Panaskan madu dan selai kacang di atas api kecil hingga cair, lalu campurkan ke bahan kering.',
                    'Aduk rata, tambahkan chocolate chips jika suka.',
                    'Tuang ke loyang kecil, tekan padat.',
                    'Simpan di kulkas minimal 2 jam, lalu potong-potong.'
                ])
            ],

            // Legacy Recipes (keeping some existing ones)
            [
                'name' => 'Classic Chocolate Chip Pancakes',
                'description' => 'Fluffy pancakes with chocolate chips that bring instant happiness',
                'category' => 'sarapan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 10,
                'cook_time_minutes' => 15,
                'servings' => 4,
                'calories_per_serving' => 285,
                'protein_per_serving' => 8.5,
                'carbs_per_serving' => 45.2,
                'fats_per_serving' => 9.8,
                'mood_tags' => json_encode(['happy', 'comfort', 'energetic']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '2 cups all-purpose flour',
                    '2 tablespoons sugar',
                    '2 teaspoons baking powder',
                    '1/2 teaspoon salt',
                    '2 large eggs',
                    '1 3/4 cups milk',
                    '1/4 cup melted butter',
                    '3/4 cup chocolate chips'
                ]),
                'instructions' => json_encode([
                    'Mix dry ingredients in a large bowl',
                    'Whisk together eggs, milk, and melted butter',
                    'Combine wet and dry ingredients until just mixed',
                    'Fold in chocolate chips',
                    'Cook on griddle until bubbles form, then flip',
                    'Serve warm with syrup'
                ])
            ],
            [
                'name' => 'Power Smoothie Bowl',
                'description' => 'Energizing smoothie bowl packed with superfoods',
                'category' => 'sarapan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 10,
                'cook_time_minutes' => 0,
                'servings' => 2,
                'calories_per_serving' => 315,
                'protein_per_serving' => 12.8,
                'carbs_per_serving' => 58.4,
                'fats_per_serving' => 8.2,
                'mood_tags' => json_encode(['energetic', 'focused', 'happy']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free', 'healthy']),
                'ingredients' => json_encode([
                    '2 frozen bananas',
                    '1 cup mixed berries',
                    '1/2 cup coconut milk',
                    '2 tablespoons chia seeds',
                    '1 tablespoon almond butter',
                    '1 teaspoon honey',
                    'Toppings: granola, fresh fruit, coconut flakes'
                ]),
                'instructions' => json_encode([
                    'Blend frozen bananas, berries, and coconut milk',
                    'Add chia seeds and almond butter',
                    'Blend until smooth and thick',
                    'Pour into bowls',
                    'Top with granola, fresh fruit, and coconut flakes'
                ])
            ]
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
