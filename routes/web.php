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

// Legacy route (if needed)
Route::get('/mood-food-legacy', [MoodFoodController::class, 'getDietaryPreferences']);

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
