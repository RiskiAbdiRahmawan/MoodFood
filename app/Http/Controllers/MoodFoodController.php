<?php

namespace App\Http\Controllers;

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
    public function moodFoodPro()
    {
        return view('mood-food');
    }
}
