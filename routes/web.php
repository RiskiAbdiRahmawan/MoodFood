<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodFoodController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\DB;

// Health check endpoint for Railway
Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'ok',
            'database' => 'connected',
            'timestamp' => now()->toISOString()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'disconnected',
            'error' => $e->getMessage(),
            'timestamp' => now()->toISOString()
        ], 500);
    }
});

Route::get('/', function () {
    return view('landingPage');
});
Route::get('/edukasi', function () {
    return view('educationPage');
});

Route::get('/rekomendasi', function () {
    return view('rekomendasi');
});

// Main website routes
Route::get('/', [MoodFoodController::class, 'index']);
Route::get('/mood-food', [MoodFoodController::class, 'moodFoodPro']);
Route::get('/mood-food-tailwind', [App\Http\Controllers\MoodFoodTailwindController::class, 'index'])->name('mood-food-tailwind');

// Meal planning routes
Route::post('/mood-food-tailwind/meal-plan', [App\Http\Controllers\MoodFoodTailwindController::class, 'handleMealPlan'])->name('mood-food-tailwind.meal-plan');
Route::post('/mood-food-tailwind/meal-plan/export', [App\Http\Controllers\MoodFoodTailwindController::class, 'exportMealPlan'])->name('mood-food-tailwind.meal-plan.export');

// Recipe Generation Routes
Route::post('/mood-food-tailwind/generate-recipe', [App\Http\Controllers\MoodFoodTailwindController::class, 'generateRecipe'])->name('mood-food-tailwind.generate-recipe');
Route::post('/mood-food-tailwind/save-recipe', [App\Http\Controllers\MoodFoodTailwindController::class, 'saveRecipe'])->name('mood-food-tailwind.save-recipe');

// Analytics Routes
Route::get('/mood-food-tailwind/analytics', [App\Http\Controllers\MoodFoodTailwindController::class, 'getAnalytics'])->name('mood-food-tailwind.analytics');
Route::get('/mood-food-tailwind/analytics/export', [App\Http\Controllers\MoodFoodTailwindController::class, 'exportAnalytics'])->name('mood-food-tailwind.analytics.export');

// API Routes for AJAX functionality
Route::post('/api/track-mood', [App\Http\Controllers\MoodFoodTailwindController::class, 'trackMoodSelectionAPI']);
Route::post('/api/track-food', [App\Http\Controllers\MoodFoodTailwindController::class, 'trackFoodInteraction']);
Route::post('/api/feedback', [App\Http\Controllers\MoodFoodTailwindController::class, 'submitFeedback']);

// Legacy route (if needed)
// Route::get('/mood-food-legacy', [MoodFoodController::class, 'getDietaryPreferences']);

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
