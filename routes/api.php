<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodFoodController;

// API routes for analytics and tracking (no CSRF protection)
Route::post('/track-food-interaction', [MoodFoodController::class, 'trackFoodInteraction']);
Route::post('/submit-feedback', [MoodFoodController::class, 'submitFeedback']);
Route::post('/track-mood-selection', [MoodFoodController::class, 'trackMoodSelectionAPI']);
Route::get('/analytics', [MoodFoodController::class, 'getAnalytics']);
Route::get('/initialize-session', [MoodFoodController::class, 'initializeSession']);
