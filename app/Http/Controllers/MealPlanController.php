<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\Recipe;
use App\Models\Food;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MealPlanController extends Controller
{
    /**
     * Get all meal plans for a session
     */
    public function index(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json(['error' => 'Session ID required'], 400);
        }

        $mealPlans = MealPlan::where('session_id', $sessionId)
            ->notExpired()
            ->with(['items.recipe', 'items.food'])
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'start_date' => $plan->start_date,
                    'end_date' => $plan->end_date,
                    'preferences' => $plan->preferences,
                    'total_calories' => $plan->total_calories,
                    'items_count' => $plan->items->count(),
                    'created_at' => $plan->created_at
                ];
            });

        return response()->json(['meal_plans' => $mealPlans]);
    }

    /**
     * Get a specific meal plan with all items
     */
    public function show($id)
    {
        $mealPlan = MealPlan::with(['items.recipe', 'items.food'])->find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        // Group items by day and meal type
        $groupedItems = $mealPlan->items->groupBy(function ($item) {
            return Carbon::parse($item->planned_date)->format('Y-m-d');
        })->map(function ($dayItems) {
            return $dayItems->groupBy('meal_type');
        });

        return response()->json([
            'meal_plan' => [
                'id' => $mealPlan->id,
                'name' => $mealPlan->name,
                'start_date' => $mealPlan->start_date,
                'end_date' => $mealPlan->end_date,
                'preferences' => $mealPlan->preferences,
                'total_calories' => $mealPlan->total_calories,
                'items' => $groupedItems
            ]
        ]);
    }

    /**
     * Create a new meal plan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|string',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'preferences' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mealPlan = MealPlan::create([
            'session_id' => $request->session_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'preferences' => $request->preferences ?? []
        ]);

        return response()->json(['meal_plan' => $mealPlan], 201);
    }

    /**
     * Update an existing meal plan
     */
    public function update(Request $request, $id)
    {
        $mealPlan = MealPlan::find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'preferences' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mealPlan->update($request->only(['name', 'start_date', 'end_date', 'preferences']));

        return response()->json(['meal_plan' => $mealPlan]);
    }

    /**
     * Delete a meal plan
     */
    public function destroy($id)
    {
        $mealPlan = MealPlan::find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        $mealPlan->delete();
        
        return response()->json(['message' => 'Meal plan deleted successfully']);
    }

    /**
     * Add an item to a meal plan
     */
    public function addItem(Request $request, $id)
    {
        $mealPlan = MealPlan::find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'meal_date' => 'required|date',
            'meal_type' => 'required|in:sarapan,snack1,makan_siang,snack2,makan_malam',
            'serving_size' => 'numeric|min:0.1',
            'recipe_id' => 'nullable|exists:recipes,id',
            'food_id' => 'nullable|exists:foods,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ensure either recipe_id or food_id is provided
        if (!$request->recipe_id && !$request->food_id) {
            return response()->json(['error' => 'Either recipe_id or food_id must be provided'], 422);
        }

        // Check if an item already exists for this meal slot
        $existingItem = MealPlanItem::where('meal_plan_id', $mealPlan->id)
            ->where('meal_date', $request->meal_date)
            ->where('meal_type', $request->meal_type)
            ->first();

        if ($existingItem) {
            // Update the existing item instead of creating a new one
            $existingItem->update([
                'serving_size' => $request->serving_size ?? 1,
                'recipe_id' => $request->recipe_id,
                'food_id' => $request->food_id
            ]);
            
            $mealPlanItem = $existingItem;
        } else {
            // Create new item
            $mealPlanItem = MealPlanItem::create([
                'meal_plan_id' => $mealPlan->id,
                'meal_date' => $request->meal_date,
                'meal_type' => $request->meal_type,
                'serving_size' => $request->serving_size ?? 1,
                'recipe_id' => $request->recipe_id,
                'food_id' => $request->food_id
            ]);
        }

        // Update meal plan total calories
        $mealPlan->updateTotalCalories();

        return response()->json(['meal_plan_item' => $mealPlanItem->load(['recipe', 'food'])], 201);
    }

    /**
     * Remove an item from a meal plan by item ID only
     */
    public function removeItem($itemId)
    {
        $item = MealPlanItem::find($itemId);
        
        if (!$item) {
            return response()->json(['error' => 'Meal plan item not found'], 404);
        }

        $mealPlan = $item->mealPlan;
        $item->delete();
        
        // Update meal plan total calories
        if ($mealPlan) {
            $mealPlan->updateTotalCalories();
        }

        return response()->json([
            'success' => true,
            'message' => 'Meal plan item removed successfully'
        ]);
    }

    /**
     * Search recipes by mood and preferences
     */
    public function searchRecipes(Request $request)
    {
        $mood = $request->input('mood');
        $category = $request->input('category');
        $dietary_tags = $request->input('dietary_tags', []);
        $difficulty = $request->input('difficulty');
        $max_prep_time = $request->input('max_prep_time');

        $query = Recipe::query()->where('is_active', true);

        // Filter by mood
        if ($mood) {
            $query->forMood($mood);
        }

        // Filter by category
        if ($category) {
            $query->where('category', $category);
        }

        // Filter by dietary requirements
        if (!empty($dietary_tags)) {
            $query->withDietaryTags($dietary_tags);
        }

        // Filter by difficulty
        if ($difficulty) {
            $query->where('difficulty', $difficulty);
        }

        // Filter by preparation time
        if ($max_prep_time) {
            $query->where('prep_time_minutes', '<=', $max_prep_time);
        }

        $recipes = $query->select([
            'id', 'name', 'description', 'category', 'difficulty',
            'prep_time_minutes', 'cook_time_minutes', 'servings',
            'calories_per_serving', 'protein_per_serving', 'carbs_per_serving', 'fats_per_serving',
            'mood_tags', 'dietary_tags', 'image_url'
        ])->get();

        return response()->json(['recipes' => $recipes]);
    }

    /**
     * Generate a smart meal plan based on mood and preferences
     */
    public function generateSmartPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|string',
            'mood' => 'required|string',
            'days' => 'required|integer|min:1|max:14',
            'dietary_preferences' => 'array',
            'target_calories' => 'numeric|min:1000|max:5000',
            'meals_per_day' => 'integer|min:1|max:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mood = $request->mood;
        $days = (int) $request->days; // Cast to integer to fix Carbon error
        $dietaryPreferences = $request->dietary_preferences ?? [];
        $targetCalories = $request->target_calories ?? 2000;
        $mealsPerDay = $request->meals_per_day ?? 3;

        // Create meal plan
        $mealPlan = MealPlan::create([
            'session_id' => $request->session_id,
            'name' => ucfirst($mood) . ' Mood Plan - ' . $days . ' Days',
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays($days - 1),
            'preferences' => [
                'mood' => $mood,
                'dietary_preferences' => $dietaryPreferences,
                'target_calories' => $targetCalories,
                'meals_per_day' => $mealsPerDay
            ]
        ]);

        // Generate meal plan items
        $mealTypes = ['sarapan', 'makan_siang', 'makan_malam'];
        if ($mealsPerDay > 3) {
            $mealTypes[] = 'snack1';
        }
        if ($mealsPerDay > 4) {
            $mealTypes[] = 'snack2';
        }

        // Map meal types to recipe categories
        $mealTypeToCategory = [
            'sarapan' => 'sarapan',
            'makan_siang' => 'utama',
            'makan_malam' => 'utama',
            'snack1' => 'cemilan',
            'snack2' => 'cemilan'
        ];

        $caloriesPerMeal = $targetCalories / $mealsPerDay;

        for ($day = 0; $day < $days; $day++) {
            $currentDate = Carbon::today()->addDays((int) $day); // Cast to integer to fix Carbon error
            
            foreach ($mealTypes as $mealType) {
                $recipeCategory = $mealTypeToCategory[$mealType];
                
                // Find suitable recipe for this meal type and mood
                $recipeQuery = Recipe::where('is_active', true)
                    ->where('category', $recipeCategory)
                    ->byMood($mood)
                    ->where('calories_per_serving', '<=', $caloriesPerMeal * 1.5); // Allow some flexibility

                // Apply dietary preferences if provided
                if (!empty($dietaryPreferences)) {
                    foreach ($dietaryPreferences as $preference) {
                        $recipeQuery->byDietaryTag($preference);
                    }
                }

                $recipe = $recipeQuery->inRandomOrder()->first();

                if ($recipe) {
                    MealPlanItem::create([
                        'meal_plan_id' => $mealPlan->id,
                        'meal_date' => $currentDate,
                        'meal_type' => $mealType,
                        'recipe_id' => $recipe->id,
                        'serving_size' => 1
                    ]);
                }
            }
        }

        // Update total calories
        $mealPlan->updateTotalCalories();

        return response()->json([
            'meal_plan' => $mealPlan->load(['items.recipe']),
            'message' => 'Smart meal plan generated successfully!'
        ], 201);
    }

    /**
     * Generate smart meals for an existing meal plan
     */
    public function generateSmart(Request $request, $id)
    {
        $mealPlan = MealPlan::find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'preferences' => 'array',
            'preferences.mood' => 'string',
            'preferences.dietary_restrictions' => 'array',
            'preferences.target_calories' => 'numeric|min:1000|max:5000',
            'preferences.activity_level' => 'string',
            'start_date' => 'date',
            'end_date' => 'date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Extract preferences from request or use existing meal plan preferences
        $requestPreferences = $request->input('preferences', []);
        $mood = $requestPreferences['mood'] ?? $mealPlan->preferences['mood'] ?? 'bahagia';
        $dietaryRestrictions = $requestPreferences['dietary_restrictions'] ?? [];
        $targetCalories = $requestPreferences['target_calories'] ?? 2000;
        $activityLevel = $requestPreferences['activity_level'] ?? 'moderate';

        // Update meal plan dates if provided
        if ($request->has('start_date')) {
            $mealPlan->start_date = $request->start_date;
        }
        if ($request->has('end_date')) {
            $mealPlan->end_date = $request->end_date;
        }

        // Update meal plan preferences
        $preferences = array_merge($mealPlan->preferences ?? [], [
            'mood' => $mood,
            'dietary_restrictions' => $dietaryRestrictions,
            'target_calories' => $targetCalories,
            'activity_level' => $activityLevel
        ]);
        
        $mealPlan->update(['preferences' => $preferences]);

        // Clear existing items to regenerate
        $mealPlan->items()->delete();

        // Calculate date range from meal plan
        $startDate = Carbon::parse($mealPlan->start_date);
        $endDate = Carbon::parse($mealPlan->end_date);
        $days = $startDate->diffInDays($endDate) + 1;

        // Generate meal plan items
        $mealTypes = ['sarapan', 'makan_siang', 'makan_malam'];
        $mealsPerDay = 3; // Can be made configurable

        // Map meal types to recipe categories
        $mealTypeToCategory = [
            'sarapan' => 'sarapan',
            'makan_siang' => 'utama',
            'makan_malam' => 'utama',
            'snack1' => 'cemilan',
            'snack2' => 'cemilan'
        ];

        $caloriesPerMeal = $targetCalories / $mealsPerDay;

        for ($day = 0; $day < $days; $day++) {
            $currentDate = $startDate->copy()->addDays((int) $day); // Cast to integer to fix Carbon error
            
            foreach ($mealTypes as $mealType) {
                $recipeCategory = $mealTypeToCategory[$mealType];
                
                // Find suitable recipe for this meal type and mood
                $recipeQuery = Recipe::where('is_active', true)
                    ->where('category', $recipeCategory)
                    ->byMood($mood)
                    ->where('calories_per_serving', '<=', $caloriesPerMeal * 1.5); // Allow some flexibility

                // Apply dietary restrictions if provided
                if (!empty($dietaryRestrictions)) {
                    foreach ($dietaryRestrictions as $restriction) {
                        $recipeQuery->byDietaryTag($restriction);
                    }
                }

                $recipe = $recipeQuery->inRandomOrder()->first();

                if ($recipe) {
                    MealPlanItem::create([
                        'meal_plan_id' => $mealPlan->id,
                        'meal_date' => $currentDate->format('Y-m-d'),
                        'meal_type' => $mealType,
                        'recipe_id' => $recipe->id,
                        'serving_size' => 1
                    ]);
                }
            }
        }

        // Update total calories
        $mealPlan->updateTotalCalories();

        return response()->json([
            'meal_plan' => $mealPlan->load(['items.recipe']),
            'message' => 'Smart meal plan updated successfully!'
        ], 200);
    }

    /**
     * Get nutrition summary for a meal plan
     */
    public function getNutritionSummary($id)
    {
        $mealPlan = MealPlan::with(['items.recipe', 'items.food'])->find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFats = 0;

        foreach ($mealPlan->items as $item) {
            $calories = $item->calculated_calories;
            $protein = $item->calculated_protein;
            $carbs = $item->calculated_carbs;
            $fats = $item->calculated_fats;

            $totalCalories += $calories;
            $totalProtein += $protein;
            $totalCarbs += $carbs;
            $totalFats += $fats;
        }

        // Calculate daily averages
        $days = Carbon::parse($mealPlan->start_date)->diffInDays(Carbon::parse($mealPlan->end_date)) + 1;
        
        return response()->json([
            'nutrition_summary' => [
                'total' => [
                    'calories' => round($totalCalories, 2),
                    'protein' => round($totalProtein, 2),
                    'carbs' => round($totalCarbs, 2),
                    'fats' => round($totalFats, 2)
                ],
                'daily_average' => [
                    'calories' => round($totalCalories / $days, 2),
                    'protein' => round($totalProtein / $days, 2),
                    'carbs' => round($totalCarbs / $days, 2),
                    'fats' => round($totalFats / $days, 2)
                ],
                'days' => $days,
                'items_count' => $mealPlan->items->count()
            ]
        ]);
    }

    /**
     * Export meal plan as JSON
     */
    public function export($id)
    {
        $mealPlan = MealPlan::with(['items.recipe', 'items.food'])->find($id);
        
        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        $exportData = [
            'meal_plan' => [
                'name' => $mealPlan->name,
                'start_date' => $mealPlan->start_date,
                'end_date' => $mealPlan->end_date,
                'preferences' => $mealPlan->preferences,
                'exported_at' => Carbon::now()->toISOString()
            ],
            'items' => $mealPlan->items->map(function ($item) {
                return [
                    'date' => $item->planned_date,
                    'meal_type' => $item->meal_type,
                    'serving_size' => $item->serving_size,
                    'recipe' => $item->recipe ? [
                        'name' => $item->recipe->name,
                        'description' => $item->recipe->description,
                        'ingredients' => $item->recipe->ingredients,
                        'instructions' => $item->recipe->instructions,
                        'nutrition' => [
                            'calories' => $item->recipe->calories_per_serving,
                            'protein' => $item->recipe->protein_per_serving,
                            'carbs' => $item->recipe->carbs_per_serving,
                            'fats' => $item->recipe->fats_per_serving
                        ]
                    ] : null,
                    'food' => $item->food ? [
                        'name' => $item->food->name,
                        'nutrition' => [
                            'calories' => $item->food->calories,
                            'protein' => $item->food->protein,
                            'carbs' => $item->food->carbs,
                            'fats' => $item->food->fats
                        ]
                    ] : null
                ];
            })
        ];

        return response()->json(['export_data' => $exportData]);
    }

    /**
     * Get recipes by mood for frontend
     */
    public function getRecipesByMood($mood)
    {
        $recipes = Recipe::where('is_active', true)
            ->byMood($mood)
            ->select([
                'id', 'name', 'description', 'category', 'difficulty',
                'prep_time_minutes', 'cook_time_minutes', 'servings',
                'calories_per_serving', 'protein_per_serving', 'carbs_per_serving', 'fats_per_serving',
                'mood_tags', 'dietary_tags', 'ingredients', 'instructions', 'health_benefits'
            ])
            ->get()
            ->map(function ($recipe) {
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'description' => $recipe->description,
                    'category' => $recipe->category,
                    'difficulty' => $recipe->difficulty,
                    'prepTime' => $recipe->formatted_prep_time,
                    'servings' => $recipe->servings,
                    'calories' => $recipe->calories_per_serving,
                    'protein' => $recipe->protein_per_serving,
                    'carbs' => $recipe->carbs_per_serving,
                    'fats' => $recipe->fats_per_serving,
                    'mood' => $recipe->mood_tags,
                    'benefits' => $recipe->health_benefits,
                    'ingredients' => $recipe->ingredients,
                    'instructions' => $recipe->instructions
                ];
            });

        return response()->json(['recipes' => $recipes]);
    }

    /**
     * Add a food item to a meal plan
     */
    public function addFoodToMealPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|string',
            'food_id' => 'required|integer|exists:foods,id',
            'meal_type' => 'required|in:sarapan,makan_siang,makan_malam,snack1,snack2',
            'day_of_week' => 'required|integer|min:0|max:6',
            'serving_size' => 'nullable|numeric|min:0.1|max:10',
            'meal_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Get or create user session
            $session = UserSession::where('session_id', $request->session_id)->first();
            if (!$session) {
                $session = UserSession::create([
                    'session_id' => $request->session_id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
            }

            // Get or create meal plan for this week
            $weekStart = now()->startOfWeek();
            $weekEnd = now()->endOfWeek();
            
            $mealPlan = $session->mealPlans()
                ->whereBetween('start_date', [$weekStart, $weekEnd])
                ->orWhereBetween('end_date', [$weekStart, $weekEnd])
                ->where('is_active', true)
                ->first();

            if (!$mealPlan) {
                $mealPlan = MealPlan::create([
                    'session_id' => $session->id,
                    'name' => 'Weekly Meal Plan - ' . $weekStart->format('M d'),
                    'start_date' => $weekStart,
                    'end_date' => $weekEnd,
                    'is_active' => true,
                    'preferences' => [
                        'auto_generated' => false,
                        'created_via' => 'food_recommendation'
                    ]
                ]);
            }

            // Calculate meal date if not provided
            $mealDate = $request->meal_date ? 
                Carbon::parse($request->meal_date) : 
                $weekStart->copy()->addDays((int) $request->day_of_week);

            // Check if meal plan item already exists for this slot
            $existingItem = $mealPlan->items()
                ->where('meal_date', $mealDate->format('Y-m-d'))
                ->where('meal_type', $request->meal_type)
                ->first();

            if ($existingItem) {
                // Update existing item
                $existingItem->update([
                    'food_id' => $request->food_id,
                    'serving_size' => $request->serving_size ?? 1,
                    'notes' => 'Updated from food recommendation'
                ]);
                $mealPlanItem = $existingItem;
            } else {
                // Create new meal plan item
                $mealPlanItem = MealPlanItem::create([
                    'meal_plan_id' => $mealPlan->id,
                    'meal_date' => $mealDate->format('Y-m-d'),
                    'meal_type' => $request->meal_type,
                    'food_id' => $request->food_id,
                    'serving_size' => $request->serving_size ?? 1,
                    'notes' => 'Added from food recommendation'
                ]);
            }

            // Update meal plan total calories
            $mealPlan->updateTotalCalories();

            // Load the meal plan item with relationships
            $mealPlanItem->load(['food.nutritionData', 'mealPlan']);

            return response()->json([
                'success' => true,
                'message' => 'Food added to meal plan successfully',
                'meal_plan_item' => [
                    'id' => $mealPlanItem->id,
                    'meal_date' => $mealPlanItem->meal_date,
                    'meal_type' => $mealPlanItem->meal_type,
                    'serving_size' => $mealPlanItem->serving_size,
                    'food' => [
                        'id' => $mealPlanItem->food->id,
                        'name' => $mealPlanItem->food->name,
                        'calories' => $mealPlanItem->food->nutritionData->calories_per_100g ?? 0,
                        'protein' => $mealPlanItem->food->nutritionData->protein_g ?? 0,
                        'carbs' => $mealPlanItem->food->nutritionData->carbohydrates_g ?? 0,
                        'fats' => $mealPlanItem->food->nutritionData->fat_g ?? 0
                    ]
                ],
                'meal_plan' => [
                    'id' => $mealPlan->id,
                    'name' => $mealPlan->name,
                    'total_calories' => $mealPlan->total_calories
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error adding food to meal plan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add food to meal plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search foods from the database
     */
    public function searchFoods(Request $request)
    {
        $query = $request->input('query', '');
        $mood = $request->input('mood', '');
        $limit = $request->input('limit', 20);

        $foodsQuery = \App\Models\FoodModel::with(['category', 'nutritionData']);

        // Filter by search query if provided
        if (!empty($query)) {
            $foodsQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        // If mood is provided, prioritize foods that are good for that mood
        if (!empty($mood)) {
            // Get mood-related recommendations first
            $moodModel = \App\Models\MoodModel::where('name', $mood)->first();
            if ($moodModel) {
                $recommendedFoodIds = $moodModel->recommendations()
                    ->pluck('food_id')
                    ->toArray();
                
                if (!empty($recommendedFoodIds)) {
                    $foodsQuery->orderByRaw('FIELD(id, ' . implode(',', $recommendedFoodIds) . ') DESC');
                }
            }
        }

        $foods = $foodsQuery->limit($limit)->get();

        $formattedFoods = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->name,
                'category' => $food->category->name ?? 'Umum',
                'calories' => $food->nutritionData->calories_per_100g ?? 0,
                'protein' => $food->nutritionData->protein_g ?? 0,
                'carbs' => $food->nutritionData->carbohydrates_g ?? 0,
                'fats' => $food->nutritionData->fat_g ?? 0,
                'fiber' => $food->nutritionData->fiber_g ?? 0,
                'description' => $food->description ?? ''
            ];
        });

        return response()->json([
            'success' => true,
            'foods' => $formattedFoods,
            'total' => $formattedFoods->count()
        ]);
    }
}
