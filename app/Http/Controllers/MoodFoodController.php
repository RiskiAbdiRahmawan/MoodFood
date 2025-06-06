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
        return view('mood-food-legacy', [
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
     * Display the MoodFood Tailwind Pro page
     */
    public function moodFoodTailwind(Request $request)
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
        $weeklyMealPlan = null;
        $analytics = null;

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

                // Generate weekly meal plan if requested
                $weeklyMealPlan = $this->generateWeeklyMealPlan($session, $mood);

                // Get analytics data
                $analytics = $this->getSessionAnalytics($session);

                // Track food recommendations shown
                $this->trackFoodRecommendations($session, $naturalFoods->merge($processedFoods));
            }
        }

        // Prepare session info
        $sessionInfo = [
            'is_returning_visitor' => $session->total_visits > 1,
            'total_visits' => $session->total_visits,
            'meal_plans_count' => $session->mealPlans()->count() ?? 0,
            'last_mood' => $session->preferences['last_mood'] ?? null,
            'preferred_foods' => $session->preferences['preferred_foods'] ?? []
        ];

        // Tampilkan view dengan data dan session info
        return view('mood-food-tailwind', [
            'dietaryPreferences' => $dietaryPreferences,
            'selectedMood' => $mood,
            'selectedDietaryPreference' => $dietPref,
            'naturalFoods' => $naturalFoods,
            'processedFoods' => $processedFoods,
            'moods' => $moods,
            'sessionId' => $session->id,
            'sessionToken' => $session->session_id,
            'weeklyMealPlan' => $weeklyMealPlan,
            'analytics' => $analytics,
            'sessionInfo' => $sessionInfo
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

    /**
     * Handle meal plan operations
     */
    public function handleMealPlan(Request $request)
    {
        $request->validate([
            'action' => 'required|in:generate,add_food,remove_food',
            'session_id' => 'sometimes|exists:user_sessions,id'
        ]);

        $session = $this->initializeSession($request);

        switch ($request->action) {
            case 'generate':
                $mood = MoodModel::where('name', $request->mood)->first();
                if ($mood) {
                    $this->generateWeeklyMealPlan($session, $mood, true);
                    return back()->with('success', 'Meal plan berhasil dibuat!');
                }
                break;

            case 'add_food':
                $request->validate([
                    'food_id' => 'required|exists:foods,id',
                    'meal_type' => 'required|in:sarapan,makan_siang,makan_malam',
                    'day_of_week' => 'required|integer|min:0|max:6'
                ]);

                $this->addFoodToMealPlan($session, $request->food_id, $request->meal_type, $request->day_of_week);
                return back()->with('success', 'Makanan berhasil ditambahkan ke meal plan!');

            case 'remove_food':
                // Implementation for removing food from meal plan
                break;
        }

        return back()->with('error', 'Aksi tidak valid');
    }

    /**
     * Generate weekly meal plan based on mood and preferences
     */
    private function generateWeeklyMealPlan(UserSession $session, MoodModel $mood, $forceRegenerate = false)
    {
        // Check if we already have a meal plan for this session and mood
        $existingPlan = $session->mealPlans()
            ->where('mood_id', $mood->id)
            ->where('created_at', '>=', now()->startOfWeek())
            ->first();

        if ($existingPlan && !$forceRegenerate) {
            return $this->formatMealPlanForView($existingPlan);
        }

        // Create new meal plan
        $mealPlan = \App\Models\MealPlan::create([
            'session_id' => $session->id,
            'mood_id' => $mood->id,
            'week_start_date' => now()->startOfWeek(),
            'name' => 'Meal Plan untuk mood ' . ucfirst($mood->name),
            'description' => 'Meal plan otomatis berdasarkan mood ' . $mood->name,
            'is_active' => true
        ]);

        // Get recommended foods for this mood
        $recommendedFoods = $mood->recommendations()
            ->with('food')
            ->get()
            ->pluck('food');

        // Generate meals for each day of the week
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $mealTypes = ['sarapan', 'makan_siang', 'makan_malam'];

        foreach ($days as $dayIndex => $dayName) {
            foreach ($mealTypes as $mealType) {
                // Select random food from recommendations
                $randomFood = $recommendedFoods->random();
                
                \App\Models\MealPlanItem::create([
                    'meal_plan_id' => $mealPlan->id,
                    'day_of_week' => (int) $dayIndex,
                    'meal_type' => $mealType,
                    'food_id' => $randomFood->id,
                    'portion_size' => '1 porsi',
                    'notes' => 'Rekomendasi untuk mood ' . $mood->name
                ]);
            }
        }

        return $this->formatMealPlanForView($mealPlan);
    }

    /**
     * Format meal plan for view display
     */
    private function formatMealPlanForView($mealPlan)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $formattedPlan = [
            'id' => $mealPlan->id,
            'name' => $mealPlan->name,
            'days' => []
        ];

        foreach ($days as $dayIndex => $dayName) {
            $dayMeals = $mealPlan->items()
                ->where('day_of_week', (int) $dayIndex)
                ->with(['food', 'recipe'])
                ->get()
                ->keyBy('meal_type');

            $formattedPlan['days'][] = [
                'name' => $dayName,
                'meals' => [
                    'sarapan' => $dayMeals->get('sarapan'),
                    'makan_siang' => $dayMeals->get('makan_siang'),
                    'makan_malam' => $dayMeals->get('makan_malam')
                ]
            ];
        }

        return $formattedPlan;
    }

    /**
     * Add food to meal plan
     */
    private function addFoodToMealPlan(UserSession $session, $foodId, $mealType, $dayOfWeek)
    {
        // Get or create current week's meal plan
        $mealPlan = $session->mealPlans()
            ->where('week_start_date', '>=', now()->startOfWeek())
            ->where('is_active', true)
            ->first();

        if (!$mealPlan) {
            $mealPlan = \App\Models\MealPlan::create([
                'session_id' => $session->id,
                'week_start_date' => now()->startOfWeek(),
                'name' => 'Custom Meal Plan',
                'description' => 'Meal plan kustom',
                'is_active' => true
            ]);
        }

        // Check if item already exists for this day/meal type
        $existingItem = $mealPlan->items()
            ->where('day_of_week', $dayOfWeek)
            ->where('meal_type', $mealType)
            ->first();

        if ($existingItem) {
            // Update existing item
            $existingItem->update([
                'food_id' => $foodId,
                'updated_at' => now()
            ]);
        } else {
            // Create new item
            \App\Models\MealPlanItem::create([
                'meal_plan_id' => $mealPlan->id,
                'day_of_week' => $dayOfWeek,
                'meal_type' => $mealType,
                'food_id' => $foodId,
                'portion_size' => '1 porsi'
            ]);
        }

        return $mealPlan;
    }

    /**
     * Get analytics data for session
     */
    private function getSessionAnalytics(UserSession $session)
    {
        $moodTrackings = MoodTracking::where('session_id', $session->id)->get();
        $foodInteractions = FoodAnalytics::where('session_id', $session->id)->get();

        return [
            'activity_summary' => [
                'total_interactions' => $foodInteractions->count(),
                'unique_foods' => $foodInteractions->pluck('food_name')->unique()->count(),
                'mood_changes' => $moodTrackings->count(),
                'favorite_mood' => $moodTrackings->isNotEmpty() ? 
                    $moodTrackings->groupBy('mood_id')->map(function($group) { 
                        return $group->count(); 
                    })->sortByDesc(function($value) { 
                        return $value; 
                    })->keys()->first() : null
            ],
            'food_preferences' => $foodInteractions->groupBy('food_name')->map(function($items) { 
                return $items->count(); 
            })->sortByDesc(function($value) { 
                return $value; 
            })->take(5),
            'mood_history' => $moodTrackings->sortByDesc('created_at')->take(10)
        ];
    }
}
