<?php

namespace App\Http\Controllers;

use App\Models\DietaryPreferencesModel;
use App\Models\MoodModel;
use Illuminate\Http\Request;

class MoodFoodController extends Controller
{
    /**
     * Display the landing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('landingPage');
    }

    /**
     * Display the MoodFood Pro page
     *
     * @return \Illuminate\View\View
     */

    public function moodFoodPro(Request $request)
    {
        // Ambil mood dan preferensi diet dari query param (misal)
        $moodName = $request->query('mood'); // ex: 'sedih'
        $dietPrefName = $request->query('dietary_preference'); // ex: 'vegan'

        $mood = MoodModel::where('name', $moodName)->firstOrFail();
        $dietPref = $dietPrefName ? DietaryPreferencesModel::where('name', $dietPrefName)->first() : null;

        // Query rekomendasi berdasarkan mood dan preferensi diet (jika ada)
        $recommendationsQuery = $mood->recommendations()->with('food.category');

        if ($dietPref) {
            $recommendationsQuery->where('dietary_preference_id', $dietPref->id);
        }

        $recommendations = $recommendationsQuery->get();

        // Pisahkan natural foods dan processed foods
        $naturalFoods = $recommendations->filter(function ($rec) {
            return $rec->food->category->name === 'Bahan Makanan Alami';
        })->pluck('food');

        $processedFoods = $recommendations->filter(function ($rec) {
            return $rec->food->category->name === 'Makanan Olahan';
        })->pluck('food');

        // Kembalikan dalam bentuk JSON
        return response()->json([
            'mood' => $mood->name,
            'natural_foods' => $naturalFoods,
            'processed_foods' => $processedFoods,
        ]);
    }

    public function showMoodFoodPage()
    {
        return view('mood-food');
    }
}
