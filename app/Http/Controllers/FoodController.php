<?php

namespace App\Http\Controllers;

use App\Models\FoodModel;
use App\Models\FoodCategoryModel;
use App\Models\NutritionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    /**
     * Get all foods with their nutrition data
     */
    public function index(Request $request)
    {
        $query = FoodModel::with(['category', 'nutritionData']);

        // Filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name if provided
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query->paginate(50);

        return response()->json([
            'success' => true,
            'foods' => $foods->items(),
            'pagination' => [
                'current_page' => $foods->currentPage(),
                'last_page' => $foods->lastPage(),
                'per_page' => $foods->perPage(),
                'total' => $foods->total()
            ]
        ]);
    }

    /**
     * Get a specific food with its nutrition data
     */
    public function show($id)
    {
        $food = FoodModel::with(['category', 'nutritionData'])->find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'food' => $food
        ]);
    }

    /**
     * Create a new custom food with nutrition data
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:foods,name',
            'calories' => 'required|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbs' => 'nullable|numeric|min:0',
            'fats' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'session_id' => 'nullable|string' // For tracking custom foods
        ]);

        try {
            DB::beginTransaction();

            // Get or create "Custom Foods" category
            $customCategory = FoodCategoryModel::firstOrCreate(
                ['name' => 'Custom Foods'],
                ['name' => 'Custom Foods']
            );

            // Create the food entry
            $food = FoodModel::create([
                'name' => $request->name,
                'category_id' => $customCategory->id,
                'description' => $request->description ?? 'Custom food created by user',
                'image_url' => null
            ]);

            // Create nutrition data
            $nutritionData = NutritionData::create([
                'food_id' => $food->id,
                'calories_per_100g' => $request->calories,
                'protein_g' => $request->protein ?? 0,
                'carbohydrates_g' => $request->carbs ?? 0,
                'fat_g' => $request->fats ?? 0,
                'fiber_g' => 0,
                'sugar_g' => 0,
                'sodium_mg' => 0,
                'vitamin_c_mg' => 0,
                'iron_mg' => 0,
                'calcium_mg' => 0,
                'other_nutrients' => null,
                'health_benefits' => 'Custom food',
                'mood_effects' => 'User-defined nutrition'
            ]);

            DB::commit();

            // Load the food with all relationships for response
            $food->load(['category', 'nutritionData']);

            // Transform for frontend compatibility
            $foodForFrontend = [
                'id' => $food->id,
                'name' => $food->name,
                'category' => $food->category->name,
                'description' => $food->description,
                'calories' => $nutritionData->calories_per_100g,
                'protein' => $nutritionData->protein_g,
                'carbs' => $nutritionData->carbohydrates_g,
                'fats' => $nutritionData->fat_g
            ];

            return response()->json([
                'success' => true,
                'message' => 'Custom food created successfully',
                'food' => $foodForFrontend
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create custom food: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing food
     */
    public function update(Request $request, $id)
    {
        $food = FoodModel::with('nutritionData')->find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:foods,name,' . $id,
            'calories' => 'sometimes|numeric|min:0',
            'protein' => 'sometimes|numeric|min:0',
            'carbs' => 'sometimes|numeric|min:0',
            'fats' => 'sometimes|numeric|min:0',
            'description' => 'sometimes|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Update food basic info
            $food->update([
                'name' => $request->name ?? $food->name,
                'description' => $request->description ?? $food->description
            ]);

            // Update nutrition data if provided
            if ($food->nutritionData && ($request->has('calories') || $request->has('protein') || $request->has('carbs') || $request->has('fats'))) {
                $food->nutritionData->update([
                    'calories_per_100g' => $request->calories ?? $food->nutritionData->calories_per_100g,
                    'protein_g' => $request->protein ?? $food->nutritionData->protein_g,
                    'carbohydrates_g' => $request->carbs ?? $food->nutritionData->carbohydrates_g,
                    'fat_g' => $request->fats ?? $food->nutritionData->fat_g
                ]);
            }

            DB::commit();

            $food->load(['category', 'nutritionData']);

            return response()->json([
                'success' => true,
                'message' => 'Food updated successfully',
                'food' => $food
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update food: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a food
     */
    public function destroy($id)
    {
        $food = FoodModel::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        try {
            // Delete associated nutrition data first
            if ($food->nutritionData) {
                $food->nutritionData->delete();
            }

            // Delete the food
            $food->delete();

            return response()->json([
                'success' => true,
                'message' => 'Food deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete food: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search foods by name or nutrition criteria
     */
    public function search(Request $request)
    {
        $query = FoodModel::with(['category', 'nutritionData']);

        // Search by name
        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Filter by nutrition criteria
        if ($request->has('min_protein')) {
            $query->whereHas('nutritionData', function($q) use ($request) {
                $q->where('protein_g', '>=', $request->min_protein);
            });
        }

        if ($request->has('max_calories')) {
            $query->whereHas('nutritionData', function($q) use ($request) {
                $q->where('calories_per_100g', '<=', $request->max_calories);
            });
        }

        $foods = $query->limit(20)->get();

        return response()->json([
            'success' => true,
            'foods' => $foods
        ]);
    }

    /**
     * Get food categories
     */
    public function getCategories()
    {
        $categories = FoodCategoryModel::all();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
}
