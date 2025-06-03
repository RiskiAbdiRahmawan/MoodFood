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
use Illuminate\Support\Str;

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
     * Display the MoodFood Pro page with improved session management
     */
    public function moodFoodPro(Request $request)
    {
        // Initialize or update user session with improved persistence
        $session = $this->initializeSession($request);
        
        $feedbacks = Feedback::latest()->limit(3)->get();
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

        // Tampilkan view dengan data dan session info
        return view('mood-food', [
            'dietaryPreferences' => $dietaryPreferences,
            'selectedMood' => $mood,
            'selectedDietaryPreference' => $dietPref,
            'naturalFoods' => $naturalFoods,
            'processedFoods' => $processedFoods,
            'moods' => $moods,
            'sessionId' => $session->id,
            'sessionToken' => $session->session_id,
            'sessionInfo' => [
                'is_returning_visitor' => $session->total_visits > 1,
                'total_visits' => $session->total_visits,
                'expires_at' => $session->expires_at ?? now()->addDays(30),
                'meal_plans_count' => $session->mealPlans()->notExpired()->count(),
                'last_activity' => $session->last_activity_at,
                'preferences' => $session->preferences ?? []
            ]
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
     * IMPROVED: Initialize or retrieve user session with persistence
     */
    private function initializeSession(Request $request)
    {
        // Try multiple sources for session identifier
        $sessionToken = $this->getSessionIdentifier($request);
        
        if ($sessionToken) {
            // Find existing valid session
            $session = UserSession::where('session_id', $sessionToken)
                ->where(function($query) {
                    $query->where('expires_at', '>', now())
                          ->orWhereNull('expires_at');
                })
                ->first();
            
            if ($session) {
                // Update for returning visitor
                $session->increment('total_visits');
                $session->update([
                    'last_activity_at' => now(),
                    'last_ip_address' => $request->ip(),
                    'last_user_agent' => $request->userAgent(),
                    'expires_at' => $session->expires_at ?? now()->addDays(30)
                ]);
                
                // Auto-extend if close to expiry
                if ($session->expires_at && $session->expires_at->diffInDays(now()) < 5) {
                    $session->update(['expires_at' => now()->addDays(30)]);
                }
                
                return $session;
            }
        }

        // Create new persistent session
        $newSessionToken = $this->generateSessionToken($request);
        
        $session = UserSession::create([
            'session_id' => $newSessionToken,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'last_ip_address' => $request->ip(),
            'last_user_agent' => $request->userAgent(),
            'preferences' => [],
            'last_activity_at' => now(),
            'first_visit_at' => now(),
            'total_visits' => 1,
            'expires_at' => now()->addDays(30) // 30 days persistence
        ]);

        // Store session identifier in multiple ways
        $this->storeSessionIdentifier($request, $newSessionToken);

        return $session;
    }

    /**
     * Get session identifier from multiple sources
     */
    private function getSessionIdentifier(Request $request)
    {
        return $request->cookie('moodfood_session') ?? 
               $request->session()->get('mood_food_session') ??
               $request->header('X-MoodFood-Session');
    }

    /**
     * Generate unique session token
     */
    private function generateSessionToken(Request $request)
    {
        // Create persistent identifier based on browser fingerprint
        $fingerprint = hash('sha256', 
            $request->userAgent() . 
            $request->ip() . 
            ($request->header('Accept-Language') ?? '') .
            date('Y-m-d') // Changes daily for privacy
        );
        
        return 'mf_' . substr($fingerprint, 0, 16) . '_' . Str::random(16);
    }

    /**
     * Store session identifier persistently
     */
    private function storeSessionIdentifier(Request $request, $sessionToken)
    {
        // Store in Laravel session
        $request->session()->put('mood_food_session', $sessionToken);
        
        // Store in cookie for persistence
        cookie()->queue(cookie(
            'moodfood_session', 
            $sessionToken, 
            60 * 24 * 30, // 30 days
            '/', 
            null, 
            request()->secure(),
            true
        ));
    }

    /**
     * NEW: Session management API endpoints
     */
    public function checkSession(Request $request)
    {
        $sessionToken = $this->getSessionIdentifier($request);
        
        if (!$sessionToken) {
            return response()->json(['has_session' => false]);
        }

        $session = UserSession::where('session_id', $sessionToken)
            ->where('expires_at', '>', now())
            ->first();

        if (!$session) {
            return response()->json(['has_session' => false]);
        }

        return response()->json([
            'has_session' => true,
            'session_info' => [
                'id' => $session->id,
                'total_visits' => $session->total_visits,
                'expires_at' => $session->expires_at,
                'meal_plans_count' => $session->mealPlans()->notExpired()->count(),
                'is_returning_visitor' => $session->total_visits > 1
            ]
        ]);
    }

    public function clearSession(Request $request)
    {
        $sessionToken = $this->getSessionIdentifier($request);
        
        if ($sessionToken) {
            UserSession::where('session_id', $sessionToken)->delete();
            $request->session()->forget('mood_food_session');
            cookie()->queue(cookie()->forget('moodfood_session'));
        }

        return response()->json(['message' => 'Session cleared successfully']);
    }

    public function exportAllData(Request $request)
    {
        $sessionToken = $this->getSessionIdentifier($request);
        
        if (!$sessionToken) {
            return response()->json(['error' => 'No session found'], 401);
        }

        $session = UserSession::where('session_id', $sessionToken)
            ->with(['mealPlans.items.recipe'])
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $exportData = [
            'app' => 'MoodFood Pro',
            'exported_at' => now()->toISOString(),
            'session_info' => [
                'total_visits' => $session->total_visits,
                'preferences' => $session->preferences
            ],
            'meal_plans' => $session->mealPlans->map(function ($plan) {
                return [
                    'name' => $plan->name,
                    'start_date' => $plan->start_date,
                    'end_date' => $plan->end_date,
                    'preferences' => $plan->preferences,
                    'items_count' => $plan->items->count()
                ];
            })
        ];

        return response()->json($exportData);
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
                'average_rating' => null, // Rating column doesn't exist in current feedback table
                'by_type' => [] // Type column doesn't exist in current feedback table
            ]
        ];

        return response()->json($data);
    }

    /**
     * Get foods by mood for frontend
     */
    public function getFoodsByMood($mood)
    {
        // Get foods with mood-related tags or benefits
        $foods = \App\Models\FoodModel::with(['category'])
            ->where('name', 'LIKE', '%pisang%')
            ->orWhere('name', 'LIKE', '%coklat%')
            ->orWhere('name', 'LIKE', '%alpukat%')
            ->orWhere('name', 'LIKE', '%ubi%')
            ->orWhere('name', 'LIKE', '%teh%')
            ->orWhere('name', 'LIKE', '%madu%')
            ->get()
            ->map(function ($food) {
                return [
                    'id' => $food->id,
                    'name' => $food->name,
                    'category' => $food->category->name ?? 'Umum',
                    'calories' => $food->calories ?? 0,
                    'protein' => $food->protein ?? 0,
                    'carbs' => $food->carbs ?? 0,
                    'fats' => $food->fats ?? 0,
                    'benefits' => $food->description ?? 'Makanan bergizi'
                ];
            });

        // Group foods by natural/processed categories
        $naturalFoods = $foods->filter(function ($food) {
            return !str_contains(strtolower($food['name']), 'olahan');
        })->values();

        $processedFoods = $foods->filter(function ($food) {
            return str_contains(strtolower($food['name']), 'olahan');
        })->values();

        return response()->json([
            'natural' => $naturalFoods,
            'processed' => $processedFoods
        ]);
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
