<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodFoodController;

Route::get('/', function () {
    return view('landingPage');
});
Route::get('/edukasi', function () {
    return view('educationPage');
});

// Main website routes
Route::get('/', [MoodFoodController::class, 'index']);
Route::get('/mood-food', [MoodFoodController::class, 'getDietaryPreferences']);

