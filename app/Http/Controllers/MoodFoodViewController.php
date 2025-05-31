<?php

namespace App\Http\Controllers;

use App\Models\DietaryPreferencesModel;
use App\Models\MoodModel;
use Illuminate\Http\Request;

class MoodFoodViewController extends Controller
{
    /**
     * Display the MoodFood view
     */
    public function index()
    {
        return view('mood-food', [
            'dietaryPreferences' => DietaryPreferencesModel::all(),
            'selectedMood' => null,
            'selectedDietaryPreference' => null,
            'naturalFoods' => collect(),
            'processedFoods' => collect(),
            'moods' => MoodModel::all(),
            'sessionId' => 'simple-session-' . time(),
        ]);
    }
}
