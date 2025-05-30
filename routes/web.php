<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodFoodController;
use App\Http\Controllers\FeedbackController;

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
