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
        $moods = MoodModel::all(); // Ambil semua mood
        // Ambil semua dietary preferences untuk ditampilkan di halaman
        $dietaryPreferences = DietaryPreferencesModel::all();

        // Ambil mood dan preferensi diet dari query param
        $moodName = $request->query('mood');
        $dietPrefName = $request->query('dietary_preference');

        $mood = null;
        $dietPref = null;
        $naturalFoods = collect();
        $processedFoods = collect();

        if ($moodName) {
            $mood = MoodModel::where('name', $moodName)->first();

            if ($mood) {
                $dietPref = $dietPrefName ? DietaryPreferencesModel::where('name', $dietPrefName)->first() : null;

                // Ambil rekomendasi berdasarkan mood & preferensi diet (jika ada)
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
            }
        }

        // Tampilkan view dengan data
        return view('mood-food', [
            'dietaryPreferences' => $dietaryPreferences,
            'selectedMood' => $mood,
            'selectedDietaryPreference' => $dietPref,
            'naturalFoods' => $naturalFoods,
            'processedFoods' => $processedFoods,
            'moods' => $moods,
        ]);
    }

    // public function showMoodFoodPage()
    // {
    //     return view('mood-food');
    // }

    public function getDietaryPreferences()
    {
        $dietaryPreferences = DietaryPreferencesModel::all(); // pastikan icon disediakan jika pakai emoji
        return view('mood-food', compact('dietaryPreferences'));
    }
}
