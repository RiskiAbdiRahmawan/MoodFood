<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodFoodController;

// Main website routes
Route::get('/', [MoodFoodController::class, 'index']);
Route::get('/mood-food', [MoodFoodController::class, 'moodFoodPro']);
