<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Import the Feedback model

class FeedbackController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Store the feedback in the database
        Feedback::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    public function getFeedback()
    {
        $feedbacks = Feedback::latest()->take(3)->get(); // Corrected syntax
        return response()->json($feedbacks);
    }
}
