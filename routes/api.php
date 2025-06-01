<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MealPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodFoodController;

// Main routes
Route::get('/', [MoodFoodController::class, 'index'])->name('landing');
Route::get('/mood-food', [MoodFoodController::class, 'moodFoodPro'])->name('mood-food');

// Session management routes
Route::prefix('api/session')->group(function () {
    Route::get('/check', [MoodFoodController::class, 'checkSession']);
    Route::delete('/clear', [MoodFoodController::class, 'clearSession']);
    Route::get('/export-all', [MoodFoodController::class, 'exportAllData']);
});

// API routes for analytics and tracking (no CSRF protection)
Route::post('/track-food-interaction', [MoodFoodController::class, 'trackFoodInteraction']);
Route::post('/submit-feedback', [MoodFoodController::class, 'submitFeedback']);
Route::post('/track-mood-selection', [MoodFoodController::class, 'trackMoodSelectionAPI']);
Route::get('/analytics', [MoodFoodController::class, 'getAnalytics']);
Route::get('/initialize-session', [MoodFoodController::class, 'initializeSession']);
Route::get('/feedback', [FeedbackController::class, 'getFeedback']);

// Meal Planner API routes
Route::prefix('api/meal-plans')->group(function () {
    Route::get('/', [MealPlanController::class, 'index']);
    Route::post('/generate-weekly', [MealPlanController::class, 'generateWeeklyPlan']);
    Route::get('/{id}', [MealPlanController::class, 'show']);
    Route::put('/{id}', [MealPlanController::class, 'update']);
    Route::delete('/{id}', [MealPlanController::class, 'destroy']);
    Route::get('/{id}/export', [MealPlanController::class, 'export']);
    Route::post('/', [MealPlanController::class, 'store']);
});