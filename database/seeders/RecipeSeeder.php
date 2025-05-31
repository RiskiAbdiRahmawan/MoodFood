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
            // Comfort/Happy Mood Recipes
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
                'name' => 'Creamy Mac and Cheese',
                'description' => 'Ultimate comfort food with three types of cheese',
                'category' => 'utama',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 15,
                'cook_time_minutes' => 25,
                'servings' => 6,
                'calories_per_serving' => 420,
                'protein_per_serving' => 18.3,
                'carbs_per_serving' => 38.7,
                'fats_per_serving' => 22.1,
                'mood_tags' => json_encode(['comfort', 'happy', 'nostalgic']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '1 lb elbow macaroni',
                    '4 tablespoons butter',
                    '4 tablespoons flour',
                    '3 cups milk',
                    '2 cups sharp cheddar cheese',
                    '1 cup gruyere cheese',
                    '1/2 cup parmesan cheese',
                    'Salt and pepper to taste',
                    '1/2 cup breadcrumbs'
                ]),
                'instructions' => json_encode([
                    'Cook macaroni according to package directions',
                    'Make cheese sauce with butter, flour, and milk',
                    'Add cheeses gradually until melted',
                    'Combine pasta and cheese sauce',
                    'Top with breadcrumbs and bake at 375°F for 20 minutes'
                ])
            ],

            // Energetic/Active Mood Recipes
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
            ],
            [
                'name' => 'Quinoa Power Salad',
                'description' => 'Protein-packed salad to fuel your day',
                'category' => 'utama',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 20,
                'cook_time_minutes' => 15,
                'servings' => 4,
                'calories_per_serving' => 285,
                'protein_per_serving' => 11.5,
                'carbs_per_serving' => 42.3,
                'fats_per_serving' => 9.7,
                'mood_tags' => json_encode(['energetic', 'focused', 'healthy']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free', 'healthy']),
                'ingredients' => json_encode([
                    '1 cup quinoa',
                    '2 cups vegetable broth',
                    '1 can black beans',
                    '1 bell pepper, diced',
                    '1 cup corn kernels',
                    '1/4 cup red onion',
                    '2 tablespoons olive oil',
                    '2 tablespoons lime juice',
                    'Fresh cilantro, salt, pepper'
                ]),
                'instructions' => json_encode([
                    'Cook quinoa in vegetable broth',
                    'Let quinoa cool completely',
                    'Mix in black beans, bell pepper, corn, and onion',
                    'Whisk together olive oil and lime juice',
                    'Toss with dressing and cilantro',
                    'Season with salt and pepper'
                ])
            ],

            // Calm/Relaxed Mood Recipes
            [
                'name' => 'Lavender Honey Tea Cookies',
                'description' => 'Delicate cookies with calming lavender and honey',
                'category' => 'cemilan',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 20,
                'cook_time_minutes' => 12,
                'servings' => 24,
                'calories_per_serving' => 95,
                'protein_per_serving' => 1.8,
                'carbs_per_serving' => 14.2,
                'fats_per_serving' => 3.7,
                'mood_tags' => json_encode(['calm', 'relaxed', 'peaceful']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '2 cups flour',
                    '1/2 cup butter, softened',
                    '1/3 cup honey',
                    '1 egg',
                    '1 teaspoon dried lavender',
                    '1/2 teaspoon vanilla',
                    '1/4 teaspoon salt',
                    '1/2 teaspoon baking powder'
                ]),
                'instructions' => json_encode([
                    'Cream butter and honey until light',
                    'Beat in egg and vanilla',
                    'Mix dry ingredients and lavender',
                    'Combine wet and dry ingredients',
                    'Roll into balls and flatten slightly',
                    'Bake at 350°F for 10-12 minutes'
                ])
            ],
            [
                'name' => 'Chamomile Chicken Soup',
                'description' => 'Soothing soup with gentle chamomile and herbs',
                'category' => 'utama',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 25,
                'cook_time_minutes' => 45,
                'servings' => 6,
                'calories_per_serving' => 245,
                'protein_per_serving' => 22.5,
                'carbs_per_serving' => 18.3,
                'fats_per_serving' => 8.9,
                'mood_tags' => json_encode(['calm', 'comfort', 'peaceful']),
                'dietary_tags' => json_encode(['gluten-free', 'healthy']),
                'ingredients' => json_encode([
                    '2 lbs chicken breast',
                    '8 cups chicken broth',
                    '2 carrots, diced',
                    '2 celery stalks, diced',
                    '1 onion, diced',
                    '2 tablespoons chamomile tea',
                    '1 cup egg noodles',
                    'Fresh thyme, salt, pepper'
                ]),
                'instructions' => json_encode([
                    'Simmer chicken in broth until cooked',
                    'Remove chicken and shred',
                    'Steep chamomile tea in hot broth for 5 minutes, strain',
                    'Sauté vegetables until tender',
                    'Add vegetables and noodles to broth',
                    'Return chicken to pot and season'
                ])
            ],

            // Stressed/Anxious Relief Recipes
            [
                'name' => 'Dark Chocolate Avocado Mousse',
                'description' => 'Rich, healthy dessert that helps reduce stress',
                'category' => 'cemilan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 15,
                'cook_time_minutes' => 0,
                'servings' => 4,
                'calories_per_serving' => 185,
                'protein_per_serving' => 4.2,
                'carbs_per_serving' => 22.8,
                'fats_per_serving' => 11.3,
                'mood_tags' => json_encode(['calm', 'comfort', 'indulgent']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free', 'healthy']),
                'ingredients' => json_encode([
                    '2 ripe avocados',
                    '1/3 cup cocoa powder',
                    '1/4 cup maple syrup',
                    '2 tablespoons almond milk',
                    '1 teaspoon vanilla',
                    'Pinch of salt',
                    'Fresh berries for topping'
                ]),
                'instructions' => json_encode([
                    'Blend all ingredients until smooth and creamy',
                    'Taste and adjust sweetness',
                    'Chill for at least 30 minutes',
                    'Serve topped with fresh berries',
                    'Enjoy mindfully for stress relief'
                ])
            ],
            [
                'name' => 'Turmeric Golden Milk Latte',
                'description' => 'Anti-inflammatory drink to soothe stress and anxiety',
                'category' => 'minuman',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 5,
                'cook_time_minutes' => 10,
                'servings' => 2,
                'calories_per_serving' => 125,
                'protein_per_serving' => 4.8,
                'carbs_per_serving' => 18.5,
                'fats_per_serving' => 4.2,
                'mood_tags' => json_encode(['calm', 'peaceful', 'healing']),
                'dietary_tags' => json_encode(['vegetarian', 'gluten-free', 'healthy']),
                'ingredients' => json_encode([
                    '2 cups milk (dairy or plant-based)',
                    '1 teaspoon turmeric',
                    '1/2 teaspoon cinnamon',
                    '1/4 teaspoon ginger',
                    'Pinch of black pepper',
                    '1 tablespoon honey',
                    '1/2 teaspoon vanilla'
                ]),
                'instructions' => json_encode([
                    'Heat milk in a saucepan',
                    'Whisk in turmeric, cinnamon, ginger, and pepper',
                    'Simmer for 5 minutes',
                    'Stir in honey and vanilla',
                    'Strain if desired and serve warm'
                ])
            ],

            // Focused/Productive Mood Recipes
            [
                'name' => 'Brain-Boosting Blueberry Muffins',
                'description' => 'Antioxidant-rich muffins to enhance mental clarity',
                'category' => 'sarapan',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 15,
                'cook_time_minutes' => 25,
                'servings' => 12,
                'calories_per_serving' => 195,
                'protein_per_serving' => 4.5,
                'carbs_per_serving' => 32.8,
                'fats_per_serving' => 6.2,
                'mood_tags' => json_encode(['focused', 'energetic', 'sharp']),
                'dietary_tags' => json_encode(['vegetarian']),
                'ingredients' => json_encode([
                    '2 cups flour',
                    '3/4 cup sugar',
                    '2 teaspoons baking powder',
                    '1/2 teaspoon salt',
                    '1/3 cup vegetable oil',
                    '1 egg',
                    '1 cup milk',
                    '1 1/2 cups fresh blueberries',
                    '1 tablespoon lemon zest'
                ]),
                'instructions' => json_encode([
                    'Preheat oven to 400°F',
                    'Mix dry ingredients in large bowl',
                    'Whisk together oil, egg, and milk',
                    'Combine wet and dry ingredients',
                    'Fold in blueberries and lemon zest',
                    'Bake for 20-25 minutes until golden'
                ])
            ],
            [
                'name' => 'Omega-3 Salmon Bowl',
                'description' => 'Brain-healthy salmon bowl with omega-3 rich ingredients',
                'category' => 'utama',
                'difficulty' => 'sedang',
                'prep_time_minutes' => 20,
                'cook_time_minutes' => 15,
                'servings' => 4,
                'calories_per_serving' => 385,
                'protein_per_serving' => 28.7,
                'carbs_per_serving' => 35.2,
                'fats_per_serving' => 15.8,
                'mood_tags' => json_encode(['focused', 'sharp', 'healthy']),
                'dietary_tags' => json_encode(['gluten-free', 'healthy', 'high-protein']),
                'ingredients' => json_encode([
                    '4 salmon fillets',
                    '2 cups brown rice',
                    '1 avocado, sliced',
                    '1 cup edamame',
                    '1 cucumber, diced',
                    '2 tablespoons sesame oil',
                    '2 tablespoons soy sauce',
                    '1 tablespoon rice vinegar',
                    'Sesame seeds, nori sheets'
                ]),
                'instructions' => json_encode([
                    'Cook brown rice according to package directions',
                    'Season salmon and pan-fry until cooked through',
                    'Steam edamame until tender',
                    'Prepare cucumber and avocado',
                    'Mix sesame oil, soy sauce, and vinegar for dressing',
                    'Assemble bowls with rice, salmon, and vegetables'
                ])
            ],

            // Social/Party Mood Recipes
            [
                'name' => 'Rainbow Veggie Hummus Platter',
                'description' => 'Colorful, healthy appetizer perfect for gatherings',
                'category' => 'cemilan',
                'difficulty' => 'mudah',
                'prep_time_minutes' => 25,
                'cook_time_minutes' => 0,
                'servings' => 8,
                'calories_per_serving' => 145,
                'protein_per_serving' => 5.8,
                'carbs_per_serving' => 18.5,
                'fats_per_serving' => 6.7,
                'mood_tags' => json_encode(['social', 'happy', 'festive']),
                'dietary_tags' => json_encode(['vegan', 'gluten-free', 'healthy']),
                'ingredients' => json_encode([
                    '2 cups hummus (store-bought or homemade)',
                    '2 bell peppers, sliced',
                    '2 carrots, cut into sticks',
                    '1 cucumber, sliced',
                    '1 cup cherry tomatoes',
                    '1 cup snap peas',
                    'Pita chips or crackers',
                    'Olive oil and paprika for garnish'
                ]),
                'instructions' => json_encode([
                    'Spread hummus on large serving platter',
                    'Arrange vegetables in rainbow pattern around hummus',
                    'Drizzle hummus with olive oil',
                    'Sprinkle with paprika',
                    'Serve with pita chips or crackers',
                    'Perfect for sharing and socializing'
                ])
            ]
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
