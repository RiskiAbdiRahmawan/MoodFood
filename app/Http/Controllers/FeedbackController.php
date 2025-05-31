<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Import the Feedback model

class FeedbackController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            // Validate the form data with custom messages
            $validated = $request->validate([
                'name' => 'required|string|max:255|min:2',
                'email' => 'required|email|max:255',
                'message' => 'required|string|min:10|max:1000',
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.min' => 'Nama harus terdiri dari minimal 2 karakter.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
                'message.required' => 'Pesan feedback wajib diisi.',
                'message.min' => 'Pesan harus terdiri dari minimal 10 karakter.',
                'message.max' => 'Pesan tidak boleh lebih dari 1000 karakter.',
            ]);

            // Store the feedback in the database
            $feedback = Feedback::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);

            // Redirect back to feedback section with a success message
            return redirect()->to(url()->previous() . '#feedback')
                ->with('success', '🎉 Terima kasih! Feedback Anda berhasil dikirim dan sangat berarti bagi kami.')
                ->with('refresh_reviews', true);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect back to feedback section with validation errors
            return redirect()->to(url()->previous() . '#feedback')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang Anda masukkan.');
        } catch (\Exception $e) {
            // Handle any other exceptions
            return redirect()->to(url()->previous() . '#feedback')
                ->withInput()
                ->with('error', 'Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    public function getFeedback()
    {
        $feedbacks = Feedback::latest()->take(6)->get(); // Get more reviews for better display
        
        // Transform the data to include additional information
        $transformedFeedbacks = $feedbacks->map(function ($feedback) {
            return [
                'id' => $feedback->id,
                'name' => $feedback->name,
                'email' => $feedback->email,
                'message' => $feedback->message,
                'created_at' => $feedback->created_at,
                'updated_at' => $feedback->updated_at,
                // Add formatted date for easier frontend usage
                'formatted_date' => $feedback->created_at ? $feedback->created_at->format('d M Y') : 'Baru saja',
                // Add relative time
                'time_ago' => $feedback->created_at ? $feedback->created_at->diffForHumans() : 'Baru saja'
            ];
        });
        
        return response()->json($transformedFeedbacks);
    }
}
