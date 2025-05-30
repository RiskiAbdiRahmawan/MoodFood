<?php

namespace App\Http\Controllers;

use App\Models\DietaryPreferencesModel;
use App\Models\MoodModel;
use App\Models\UserSession;
use App\Models\MoodTracking;
use App\Models\FoodAnalytics;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        // Initialize or update user session
        $session = $this->initializeSession($request);
        
        $moods = MoodModel::all();
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

                // Track mood selection
                $this->trackMoodSelection($session, $mood, $request);

                // Ambil rekomendasi berdasarkan mood & preferensi diet (jika ada)
                $recommendationsQuery = $mood->recommendations()->with(['food.category', 'food.nutritionData']);

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

                // Track food recommendations shown
                $this->trackFoodRecommendations($session, $naturalFoods->merge($processedFoods));
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
            'sessionId' => $session->id,
        ]);
    }

    /**
     * Track food interaction (click, view, etc.)
     */
    public function trackFoodInteraction(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_sessions,id',
            'food_name' => 'required|string',
            'interaction_type' => 'required|in:view,click,select,add_to_plan',
            'metadata' => 'nullable|array'
        ]);

        $session = UserSession::find($request->session_id);
        
        FoodAnalytics::create([
            'session_id' => $session->id,
            'food_name' => $request->food_name,
            'interaction_type' => $request->interaction_type,
            'metadata' => $request->metadata ? json_encode($request->metadata) : null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Update session activity
        $session->update(['last_activity_at' => now()]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Submit user feedback
     */
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_sessions,id',
            'type' => 'required|in:general,recommendation,bug_report,feature_request',
            'rating' => 'nullable|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'scope' => 'nullable|in:mood_selection,food_recommendations,meal_planning,overall_experience'
        ]);

        $session = UserSession::find($request->session_id);

        Feedback::create([
            'session_id' => $session->id,
            'type' => $request->type,
            'rating' => $request->rating,
            'content' => $request->content,
            'scope' => $request->scope ?? 'general',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih atas feedback Anda!'
        ]);
    }

    /**
     * API endpoint: Track mood selection
     */
    public function trackMoodSelectionAPI(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_sessions,id',
            'mood_id' => 'required|exists:moods,id',
            'intensity' => 'nullable|integer|min:1|max:10'
        ]);

        $session = UserSession::findOrFail($request->session_id);
        $mood = MoodModel::findOrFail($request->mood_id);
        $intensity = $request->input('intensity', 5);
        
        MoodTracking::create([
            'session_id' => $session->id,
            'mood_id' => $mood->id,
            'intensity' => max(1, min(10, $intensity)),
            'tracked_at' => now(),
            'context' => json_encode([
                'time_of_day' => now()->format('H:i'),
                'day_of_week' => now()->format('l'),
                'referrer' => $request->header('referer')
            ])
        ]);

        // Update session activity
        $session->update(['last_activity_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Mood selection tracked successfully'
        ]);
    }

    /**
     * Track mood selection with intensity (internal helper)
     */
    public function trackMoodSelection(UserSession $session, MoodModel $mood, Request $request)
    {
        $intensity = $request->query('intensity', 5); // Default intensity 5
        
        MoodTracking::create([
            'session_id' => $session->id,
            'mood_id' => $mood->id,
            'intensity' => max(1, min(10, $intensity)), // Ensure within 1-10 range
            'tracked_at' => now(),
            'context' => json_encode([
                'time_of_day' => now()->format('H:i'),
                'day_of_week' => now()->format('l'),
                'referrer' => $request->header('referer')
            ])
        ]);

        // Update session with mood preference
        $preferences = $session->preferences ?? [];
        $preferences['last_mood'] = $mood->name;
        $preferences['mood_history'] = array_slice(
            array_merge([$mood->name], $preferences['mood_history'] ?? []), 
            0, 
            10
        ); // Keep last 10 moods
        
        $session->update(['preferences' => $preferences]);
    }

    /**
     * Track food recommendations shown to user
     */
    private function trackFoodRecommendations(UserSession $session, $foods)
    {
        foreach ($foods as $food) {
            FoodAnalytics::create([
                'session_id' => $session->id,
                'food_name' => $food->name,
                'interaction_type' => 'recommendation_shown',
                'metadata' => json_encode([
                    'food_id' => $food->id,
                    'category' => $food->category->name
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    /**
     * Initialize or retrieve user session
     */
    private function initializeSession(Request $request)
    {
        $sessionToken = $request->session()->get('mood_food_session');
        
        if ($sessionToken) {
            $session = UserSession::where('session_id', $sessionToken)->first();
            if ($session) {
                // Update last activity
                $session->update(['last_activity_at' => now()]);
                return $session;
            }
        }

        // Create new session
        $sessionToken = uniqid('mf_', true);
        $request->session()->put('mood_food_session', $sessionToken);

        return UserSession::create([
            'session_id' => $sessionToken,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'preferences' => [],
            'last_activity_at' => now(),
            'first_visit_at' => now(),
            'total_visits' => 1,
        ]);
    }

    /**
     * Get analytics dashboard data (admin use)
     */
    public function getAnalytics(Request $request)
    {
        $days = $request->query('days', 7);
        $startDate = now()->subDays($days);

        $data = [
            'total_sessions' => UserSession::where('created_at', '>=', $startDate)->count(),
            'total_mood_selections' => MoodTracking::where('created_at', '>=', $startDate)->count(),
            'total_food_interactions' => FoodAnalytics::where('created_at', '>=', $startDate)->count(),
            'popular_moods' => MoodTracking::with('mood')
                ->where('created_at', '>=', $startDate)
                ->selectRaw('mood_id, COUNT(*) as count')
                ->groupBy('mood_id')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get(),
            'popular_foods' => FoodAnalytics::where('created_at', '>=', $startDate)
                ->where('interaction_type', 'click')
                ->selectRaw('food_name, COUNT(*) as count')
                ->groupBy('food_name')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'feedback_summary' => [
                'total' => Feedback::where('created_at', '>=', $startDate)->count(),
                'average_rating' => Feedback::where('created_at', '>=', $startDate)
                    ->whereNotNull('rating')
                    ->avg('rating'),
                'by_type' => Feedback::where('created_at', '>=', $startDate)
                    ->selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->get()
            ]
        ];

        return response()->json($data);
    }

    /**
     * Get dietary preferences (legacy method)
     */
    public function getDietaryPreferences()
    {
        $dietaryPreferences = DietaryPreferencesModel::all();
        return view('mood-food', compact('dietaryPreferences'));
    }
}
