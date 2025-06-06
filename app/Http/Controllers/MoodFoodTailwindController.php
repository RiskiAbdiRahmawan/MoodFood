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

class MoodFoodTailwindController extends Controller
{
    /**
     * Display the MoodFood Tailwind Pro page
     */
    public function index(Request $request)
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
    }    /**
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
                    $mealPlan = $this->generateWeeklyMealPlan($session, $mood, true);
                    
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Meal plan berhasil dibuat!',
                            'meal_plan' => $mealPlan
                        ]);
                    }
                    
                    return back()->with('success', 'Meal plan berhasil dibuat!');
                }
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Mood tidak ditemukan'
                    ], 404);
                }
                break;

            case 'add_food':
                $request->validate([
                    'food_id' => 'required|exists:foods,id',
                    'meal_type' => 'required|in:sarapan,makan_siang,makan_malam',
                    'day_of_week' => 'required|integer|min:0|max:6'
                ]);

                $this->addFoodToMealPlan($session, $request->food_id, $request->meal_type, $request->day_of_week);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Makanan berhasil ditambahkan ke meal plan!'
                    ]);
                }
                
                return back()->with('success', 'Makanan berhasil ditambahkan ke meal plan!');

            case 'remove_food':
                // Implementation for removing food from meal plan
                break;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak valid'
            ], 400);
        }

        return back()->with('error', 'Aksi tidak valid');
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
                    'category' => $food->category->name ?? 'Unknown'
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }    /**
     * Generate weekly meal plan based on mood and preferences
     */
    private function generateWeeklyMealPlan(UserSession $session, MoodModel $mood, $forceRegenerate = false)
    {
        // Check if we already have a meal plan for this session
        $existingPlan = $session->mealPlans()
            ->where('created_at', '>=', now()->startOfWeek())
            ->where('is_active', true)
            ->first();

        if ($existingPlan && !$forceRegenerate) {
            return $this->formatMealPlanForView($existingPlan);
        }

        // Create new meal plan
        $mealPlan = \App\Models\MealPlan::create([
            'session_id' => $session->id,
            'start_date' => now()->startOfWeek(),
            'end_date' => now()->endOfWeek(),
            'name' => 'Meal Plan untuk mood ' . ucfirst($mood->name),
            'notes' => 'Meal plan otomatis berdasarkan mood ' . $mood->name,
            'is_active' => true,
            'preferences' => ['mood' => $mood->name]
        ]);

        // Get recommended foods for this mood
        $recommendedFoods = $mood->recommendations()
            ->with('food')
            ->get()
            ->pluck('food')
            ->filter(); // Remove null values

        if ($recommendedFoods->isEmpty()) {
            // Fallback to random foods if no recommendations
            $recommendedFoods = \App\Models\FoodModel::limit(10)->get();
        }
        
        // Generate meals for each day of the week
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $mealTypes = ['sarapan', 'makan_siang', 'makan_malam'];
        $startDate = now()->startOfWeek();

        foreach ($days as $dayIndex => $dayName) {
            $currentDate = $startDate->copy()->addDays((int) $dayIndex);
            
            foreach ($mealTypes as $mealType) {
                if ($recommendedFoods->isNotEmpty()) {
                    // Select random food from recommendations
                    $randomFood = $recommendedFoods->random();
                    
                    \App\Models\MealPlanItem::create([
                        'meal_plan_id' => $mealPlan->id,
                        'meal_date' => $currentDate->format('Y-m-d'),
                        'meal_type' => $mealType,
                        'food_id' => $randomFood->id,
                        'serving_size' => 1.0,
                        'notes' => 'Rekomendasi untuk mood ' . $mood->name
                    ]);
                }
            }
        }

        return $this->formatMealPlanForView($mealPlan);
    }    /**
     * Format meal plan for view display
     */    private function formatMealPlanForView($mealPlan)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        $formattedPlan = [
            'id' => $mealPlan->id,
            'name' => $mealPlan->name,
            'days' => []
        ];

        $startDate = now()->startOfWeek();
        
        foreach ($days as $dayIndex => $dayName) {
            $currentDate = $startDate->copy()->addDays((int) $dayIndex);
            
            $dayMeals = $mealPlan->items()
                ->where('meal_date', $currentDate->format('Y-m-d'))
                ->with(['food', 'recipe'])
                ->get()
                ->keyBy('meal_type');

            $formattedPlan['days'][] = [
                'name' => $dayName,
                'date' => $currentDate->format('Y-m-d'),
                'meals' => [
                    'sarapan' => $dayMeals->get('sarapan'),
                    'makan_siang' => $dayMeals->get('makan_siang'),
                    'makan_malam' => $dayMeals->get('makan_malam')
                ]
            ];
        }

        return $formattedPlan;
    }    /**
     * Add food to meal plan
     */
    private function addFoodToMealPlan(UserSession $session, $foodId, $mealType, $dayOfWeek)
    {
        // Get or create current week's meal plan
        $mealPlan = $session->mealPlans()
            ->where('start_date', '>=', now()->startOfWeek())
            ->where('is_active', true)
            ->first();

        if (!$mealPlan) {
            $mealPlan = \App\Models\MealPlan::create([
                'session_id' => $session->id,
                'start_date' => now()->startOfWeek(),
                'end_date' => now()->endOfWeek(),
                'name' => 'Custom Meal Plan',
                'notes' => 'Meal plan kustom',
                'is_active' => true
            ]);
        }        // Calculate the actual date for the day of week
        $startDate = now()->startOfWeek();
        $mealDate = $startDate->copy()->addDays((int) $dayOfWeek);

        // Check if item already exists for this date/meal type
        $existingItem = $mealPlan->items()
            ->where('meal_date', $mealDate->format('Y-m-d'))
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
                'meal_date' => $mealDate->format('Y-m-d'),
                'meal_type' => $mealType,
                'food_id' => $foodId,
                'serving_size' => 1.0
            ]);
        }

        return $mealPlan;
    }/**
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
            'food_preferences' => $foodInteractions->groupBy('food_name')->map(function($items) { return $items->count(); })->sortByDesc(function($value) { return $value; })->take(5),
            'mood_history' => $moodTrackings->sortByDesc('created_at')->take(10)
        ];
    }

    /**
     * Initialize or retrieve user session with persistence
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
            'expires_at' => now()->addDays(30)
        ]);

        // Store session identifier in multiple ways
        $this->storeSessionIdentifier($request, $newSessionToken);

        return $session;
    }    /**
     * Get session identifier from multiple sources
     */
    private function getSessionIdentifier(Request $request)
    {
        // First try explicit session_id parameter
        if ($request->has('session_id')) {
            $sessionId = $request->get('session_id');
            $session = UserSession::find($sessionId);
            if ($session) {
                return $session->session_id;
            }
        }
        
        // Then try other sources
        return $request->cookie('moodfood_session') ?? 
               ($request->hasSession() ? $request->session()->get('mood_food_session') : null) ??
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
            date('Y-m-d')
        );
        
        return 'mf_' . substr($fingerprint, 0, 16) . '_' . Str::random(16);
    }    /**
     * Store session identifier persistently
     */
    private function storeSessionIdentifier(Request $request, $sessionToken)
    {
        // Store in Laravel session if available
        if ($request->hasSession()) {
            $request->session()->put('mood_food_session', $sessionToken);
        }
        
        // Store in cookie for persistence (only in web context)
        if (function_exists('cookie')) {
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
    }    /**
     * Export meal plan to PDF or other format
     */
    public function exportMealPlan(Request $request)
    {
        $request->validate([
            'session_id' => 'sometimes|exists:user_sessions,id',
            'format' => 'sometimes|in:pdf,json,csv'
        ]);

        // Handle session_id parameter directly for API calls
        if ($request->has('session_id')) {
            $session = UserSession::find($request->get('session_id'));
        } else {
            $session = $this->initializeSession($request);
        }
        
        if (!$session) {
            return response()->json([
                'error' => 'Sesi pengguna tidak ditemukan.'
            ], 404);        }
        
        $format = $request->get('format', 'json');
        
        // Get current week's meal plan
        $mealPlan = $session->mealPlans()
            ->where('start_date', '>=', now()->startOfWeek())
            ->where('is_active', true)
            ->first();

        if (!$mealPlan) {
            return response()->json([
                'error' => 'Tidak ada meal plan yang ditemukan untuk diekspor.'
            ], 404);
        }

        $formattedPlan = $this->formatMealPlanForView($mealPlan);

        switch ($format) {
            case 'json':
                return response()->json([
                    'meal_plan' => $formattedPlan,
                    'exported_at' => now()->toISOString(),
                    'session_id' => $session->id
                ]);
                
            case 'csv':
                return $this->exportMealPlanAsCSV($formattedPlan);
                
            case 'pdf':
                // For PDF export, you might want to use a library like DomPDF
                return $this->exportMealPlanAsPDF($formattedPlan);
                
            default:
                return response()->json([
                    'meal_plan' => $formattedPlan,
                    'exported_at' => now()->toISOString()
                ]);
        }
    }    /**
     * Export meal plan as CSV
     */
    private function exportMealPlanAsCSV($mealPlan)
    {
        $csvData = [];
        $csvData[] = ['Tanggal', 'Hari', 'Jenis Makan', 'Makanan', 'Porsi', 'Kalori'];

        foreach ($mealPlan['days'] as $day) {
            foreach (['sarapan', 'makan_siang', 'makan_malam'] as $mealType) {
                $meal = $day['meals'][$mealType] ?? null;
                $foodName = $meal && $meal->food ? $meal->food->name : 'Belum ditentukan';
                $portion = $meal ? $meal->serving_size : '-';
                $calories = $meal && $meal->food && $meal->food->nutritionData 
                    ? $meal->food->nutritionData->calories_per_100g 
                    : 0;

                $csvData[] = [
                    $day['date'] ?? '',
                    $day['name'],
                    ucfirst(str_replace('_', ' ', $mealType)),
                    $foodName,
                    $portion,
                    $calories
                ];
            }
        }

        $filename = 'meal-plan-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export meal plan as PDF (placeholder - requires PDF library)
     */
    private function exportMealPlanAsPDF($mealPlan)
    {
        // This is a placeholder. To implement PDF export, you would need to install
        // a PDF library like barryvdh/laravel-dompdf or similar
        return response()->json([
            'error' => 'PDF export belum diimplementasikan. Silakan gunakan format JSON atau CSV.',
            'available_formats' => ['json', 'csv']
        ], 501);
    }

    /**
     * Generate custom recipe based on mood and preferences
     */
    public function generateRecipe(Request $request)
    {
        $request->validate([
            'mood' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'prep_time' => 'required|integer|min:5|max:240',
            'category' => 'required|in:sarapan,utama,cemilan,minuman',
            'session_id' => 'required|exists:user_sessions,id'
        ]);

        try {
            $session = UserSession::findOrFail($request->session_id);
            
            // Generate recipe based on mood and preferences
            $recipe = $this->generateMoodBasedRecipe(
                $request->mood,
                $request->difficulty,
                $request->prep_time,
                $request->category
            );

            // Track recipe generation
            FoodAnalytics::create([
                'session_id' => $session->id,
                'food_name' => $recipe['name'],
                'interaction_type' => 'recipe_generated',
                'metadata' => json_encode([
                    'mood' => $request->mood,
                    'difficulty' => $request->difficulty,
                    'prep_time' => $request->prep_time,
                    'category' => $request->category,
                    'generated_at' => now()->toISOString()
                ]),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'recipe' => $recipe,
                'message' => 'Recipe generated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate recipe: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save generated recipe to database
     */
    public function saveRecipe(Request $request)
    {
        $request->validate([
            'recipe' => 'required|array',
            'session_id' => 'required|exists:user_sessions,id'
        ]);

        try {
            $session = UserSession::findOrFail($request->session_id);
            $recipeData = $request->input('recipe');

            // Save recipe to database
            $recipe = \App\Models\Recipe::create([
                'name' => $recipeData['name'],
                'description' => $recipeData['description'],
                'category' => $recipeData['category'],
                'difficulty' => $recipeData['difficulty'],
                'prep_time_minutes' => $recipeData['prep_time_minutes'],
                'cook_time_minutes' => $recipeData['cook_time_minutes'] ?? 0,
                'servings' => $recipeData['servings'],
                'calories_per_serving' => $recipeData['calories_per_serving'],
                'protein_per_serving' => $recipeData['protein_per_serving'] ?? 0,
                'carbs_per_serving' => $recipeData['carbs_per_serving'] ?? 0,
                'fats_per_serving' => $recipeData['fats_per_serving'] ?? 0,
                'ingredients' => $recipeData['ingredients'],
                'instructions' => $recipeData['instructions'],
                'mood_tags' => $recipeData['mood_tags'] ?? [],
                'dietary_tags' => $recipeData['dietary_tags'] ?? [],
                'health_benefits' => $recipeData['health_benefits'] ?? [],
                'is_active' => true
            ]);

            // Track recipe save
            FoodAnalytics::create([
                'session_id' => $session->id,
                'food_name' => $recipe->name,
                'interaction_type' => 'recipe_saved',
                'metadata' => json_encode([
                    'recipe_id' => $recipe->id,
                    'saved_at' => now()->toISOString()
                ]),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'recipe_id' => $recipe->id,
                'message' => 'Recipe saved successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save recipe: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get enhanced analytics data
     */
    public function getAnalytics(Request $request)
    {
        $sessionId = $request->input('session_id');
        $timeframe = $request->input('timeframe', '7'); // days
        
        if (!$sessionId) {
            return response()->json(['error' => 'Session ID required'], 400);
        }

        $session = UserSession::find($sessionId);
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $startDate = now()->subDays((int)$timeframe);

        // Get comprehensive analytics
        $analytics = [
            'session_info' => [
                'total_visits' => $session->total_visits,
                'first_visit' => $session->created_at,
                'last_activity' => $session->last_activity_at,
                'preferences' => $session->preferences ?? []
            ],
            'mood_analytics' => $this->getMoodAnalytics($session, $startDate),
            'food_analytics' => $this->getFoodAnalytics($session, $startDate),
            'recipe_analytics' => $this->getRecipeAnalytics($session, $startDate),
            'meal_plan_analytics' => $this->getMealPlanAnalytics($session, $startDate),
            'activity_timeline' => $this->getActivityTimeline($session, $startDate)
        ];

        return response()->json($analytics);
    }

    /**
     * Export analytics data
     */
    public function exportAnalytics(Request $request)
    {
        $sessionId = $request->input('session_id');
        $format = $request->input('format', 'json');
        
        if (!$sessionId) {
            return response()->json(['error' => 'Session ID required'], 400);
        }

        $analytics = $this->getAnalytics($request)->getData();

        switch ($format) {
            case 'csv':
                return $this->exportAnalyticsAsCSV($analytics);
            case 'json':
            default:
                return response()->json([
                    'analytics' => $analytics,
                    'exported_at' => now()->toISOString(),
                    'export_format' => $format
                ]);
        }
    }

    /**
     * Generate mood-based recipe using predefined templates
     */
    private function generateMoodBasedRecipe($mood, $difficulty, $prepTime, $category)
    {
        // Recipe templates based on mood and category
        $recipeTemplates = $this->getRecipeTemplates();
        
        // Get template for the specific mood and category
        $template = $recipeTemplates[$mood][$category] ?? $recipeTemplates['default'][$category];
        
        // Customize based on difficulty and prep time
        $recipe = $this->customizeRecipe($template, $difficulty, $prepTime);
        
        return $recipe;
    }

    /**
     * Get recipe templates organized by mood and category
     */
    private function getRecipeTemplates()
    {
        return [
            'bahagia' => [
                'sarapan' => [
                    'name' => 'Smoothie Bowl Ceria',
                    'description' => 'Smoothie bowl penuh warna dengan buah-buahan segar yang akan membuat hari Anda lebih cerah',
                    'base_ingredients' => ['pisang', 'berry', 'yogurt', 'granola', 'madu'],
                    'base_instructions' => ['Blender buah dengan yogurt', 'Tuang ke mangkuk', 'Tambahkan topping'],
                    'calories_base' => 280
                ],
                'utama' => [
                    'name' => 'Nasi Goreng Rainbow',
                    'description' => 'Nasi goreng warna-warni dengan sayuran beragam yang kaya nutrisi',
                    'base_ingredients' => ['nasi', 'telur', 'wortel', 'buncis', 'jagung', 'kecap'],
                    'base_instructions' => ['Tumis bumbu', 'Masukkan nasi', 'Tambahkan sayuran', 'Aduk rata'],
                    'calories_base' => 420
                ],
                'cemilan' => [
                    'name' => 'Energy Balls Coklat',
                    'description' => 'Bola energi dengan coklat dan kacang yang memberikan boost mood',
                    'base_ingredients' => ['kurma', 'almond', 'cocoa powder', 'chia seeds'],
                    'base_instructions' => ['Haluskan kurma', 'Campur semua bahan', 'Bentuk bulat', 'Dinginkan'],
                    'calories_base' => 150
                ],
                'minuman' => [
                    'name' => 'Golden Milk Latte',
                    'description' => 'Minuman hangat dengan kunyit dan rempah yang menenangkan',
                    'base_ingredients' => ['susu almond', 'kunyit', 'jahe', 'kayu manis', 'madu'],
                    'base_instructions' => ['Panaskan susu', 'Tambahkan rempah', 'Aduk rata', 'Saring dan sajikan'],
                    'calories_base' => 120
                ]
            ],
            'sedih' => [
                'sarapan' => [
                    'name' => 'Oatmeal Comfort Bowl',
                    'description' => 'Oatmeal hangat dengan topping yang memberikan kenyamanan dan energi',
                    'base_ingredients' => ['oatmeal', 'susu', 'pisang', 'kacang', 'kayu manis'],
                    'base_instructions' => ['Masak oatmeal dengan susu', 'Tambahkan pisang', 'Taburkan kacang dan kayu manis'],
                    'calories_base' => 320
                ],
                'utama' => [
                    'name' => 'Sup Ayam Comfort',
                    'description' => 'Sup ayam hangat dengan sayuran yang memberikan rasa nyaman',
                    'base_ingredients' => ['ayam', 'wortel', 'kentang', 'bawang', 'seledri'],
                    'base_instructions' => ['Rebus ayam', 'Tambahkan sayuran', 'Masak hingga empuk', 'Bumbui secukupnya'],
                    'calories_base' => 380
                ],
                'cemilan' => [
                    'name' => 'Dark Chocolate Truffles',
                    'description' => 'Truffle coklat hitam yang kaya antioksidan untuk mood booster',
                    'base_ingredients' => ['dark chocolate', 'cream', 'butter', 'cocoa powder'],
                    'base_instructions' => ['Lelehkan coklat', 'Campur dengan cream', 'Bentuk bulat', 'Taburi cocoa'],
                    'calories_base' => 180
                ],
                'minuman' => [
                    'name' => 'Chamomile Honey Tea',
                    'description' => 'Teh chamomile dengan madu yang menenangkan dan menghangatkan',
                    'base_ingredients' => ['chamomile tea', 'madu', 'lemon', 'jahe'],
                    'base_instructions' => ['Seduh teh chamomile', 'Tambahkan madu', 'Peras lemon', 'Sajikan hangat'],
                    'calories_base' => 80
                ]
            ],
            'default' => [
                'sarapan' => [
                    'name' => 'Breakfast Bowl Sehat',
                    'description' => 'Bowl sarapan bergizi seimbang untuk memulai hari',
                    'base_ingredients' => ['oatmeal', 'buah', 'kacang', 'yogurt'],
                    'base_instructions' => ['Siapkan oatmeal', 'Tambahkan topping', 'Sajikan'],
                    'calories_base' => 300
                ],
                'utama' => [
                    'name' => 'Balanced Meal',
                    'description' => 'Makanan seimbang dengan protein, karbohidrat, dan sayuran',
                    'base_ingredients' => ['protein', 'nasi/pasta', 'sayuran', 'bumbu'],
                    'base_instructions' => ['Masak protein', 'Siapkan karbohidrat', 'Tumis sayuran', 'Sajikan'],
                    'calories_base' => 400
                ],
                'cemilan' => [
                    'name' => 'Healthy Snack',
                    'description' => 'Cemilan sehat yang mengenyangkan',
                    'base_ingredients' => ['kacang', 'buah kering', 'biji-bijian'],
                    'base_instructions' => ['Campur semua bahan', 'Sajikan'],
                    'calories_base' => 160
                ],
                'minuman' => [
                    'name' => 'Refreshing Drink',
                    'description' => 'Minuman segar dan menyehatkan',
                    'base_ingredients' => ['air', 'buah', 'madu'],
                    'base_instructions' => ['Campur semua bahan', 'Sajikan dingin'],
                    'calories_base' => 100
                ]
            ]
        ];
    }

    /**
     * Customize recipe based on difficulty and prep time
     */
    private function customizeRecipe($template, $difficulty, $prepTime)
    {
        $recipe = $template;
        
        // Adjust complexity based on difficulty
        switch ($difficulty) {
            case 'easy':
                $recipe['prep_time_minutes'] = min($prepTime, 20);
                $recipe['cook_time_minutes'] = 5;
                $recipe['servings'] = 1;
                break;
            case 'medium':
                $recipe['prep_time_minutes'] = min($prepTime, 45);
                $recipe['cook_time_minutes'] = 15;
                $recipe['servings'] = 2;
                break;
            case 'hard':
                $recipe['prep_time_minutes'] = $prepTime;
                $recipe['cook_time_minutes'] = 30;
                $recipe['servings'] = 4;
                break;
        }
        
        // Calculate nutrition values
        $recipe['calories_per_serving'] = $recipe['calories_base'] ?? 200;
        $recipe['protein_per_serving'] = round($recipe['calories_per_serving'] * 0.15 / 4, 1);
        $recipe['carbs_per_serving'] = round($recipe['calories_per_serving'] * 0.55 / 4, 1);
        $recipe['fats_per_serving'] = round($recipe['calories_per_serving'] * 0.30 / 9, 1);
        
        // Set additional properties
        $recipe['difficulty'] = ucfirst($difficulty);
        $recipe['category'] = $template['category'] ?? 'utama';
        $recipe['mood_tags'] = [$this->getCurrentMood()];
        $recipe['dietary_tags'] = [];
        $recipe['health_benefits'] = $this->generateHealthBenefits($recipe['name']);
        $recipe['ingredients'] = $this->expandIngredients($recipe['base_ingredients'], $recipe['servings']);
        $recipe['instructions'] = $this->expandInstructions($recipe['base_instructions'], $difficulty);
        
        return $recipe;
    }

    /**
     * Expand ingredients list with quantities
     */
    private function expandIngredients($baseIngredients, $servings)
    {
        $quantities = [
            'pisang' => ($servings * 1) . ' buah pisang matang',
            'berry' => ($servings * 100) . 'g mixed berries',
            'yogurt' => ($servings * 150) . 'ml yogurt plain',
            'granola' => ($servings * 50) . 'g granola',
            'madu' => ($servings * 1) . ' sdm madu',
            'nasi' => ($servings * 150) . 'g nasi putih',
            'telur' => ($servings * 1) . ' butir telur',
            'wortel' => ($servings * 50) . 'g wortel potong dadu',
            'buncis' => ($servings * 50) . 'g buncis potong',
            'jagung' => ($servings * 50) . 'g jagung pipil',
            'kecap' => ($servings * 1) . ' sdm kecap manis',
            'kurma' => ($servings * 5) . ' buah kurma tanpa biji',
            'almond' => ($servings * 30) . 'g almond',
            'cocoa powder' => ($servings * 1) . ' sdm cocoa powder',
            'chia seeds' => ($servings * 1) . ' sdt chia seeds',
            'susu almond' => ($servings * 200) . 'ml susu almond',
            'kunyit' => '1/2 sdt bubuk kunyit',
            'jahe' => '1 cm jahe segar',
            'kayu manis' => '1/4 sdt bubuk kayu manis',
            'oatmeal' => ($servings * 80) . 'g rolled oats',
            'susu' => ($servings * 200) . 'ml susu',
            'kacang' => ($servings * 30) . 'g kacang campuran',
            'ayam' => ($servings * 150) . 'g daging ayam',
            'kentang' => ($servings * 100) . 'g kentang',
            'bawang' => ($servings * 1) . ' siung bawang bombay',
            'seledri' => ($servings * 2) . ' tangkai seledri',
            'dark chocolate' => ($servings * 100) . 'g dark chocolate 70%',
            'cream' => ($servings * 50) . 'ml heavy cream',
            'butter' => ($servings * 10) . 'g butter',
            'chamomile tea' => ($servings * 1) . ' kantong teh chamomile',
            'lemon' => '1/2 buah lemon'
        ];
        
        return array_map(function($ingredient) use ($quantities) {
            return $quantities[$ingredient] ?? ($ingredient);
        }, $baseIngredients);
    }

    /**
     * Expand instructions based on difficulty
     */
    private function expandInstructions($baseInstructions, $difficulty)
    {
        $expandedInstructions = [];
        
        foreach ($baseInstructions as $instruction) {
            if ($difficulty === 'hard') {
                // Add more detailed steps for hard difficulty
                $expandedInstructions[] = $instruction . ' dengan teknik yang tepat';
                $expandedInstructions[] = 'Perhatikan suhu dan waktu memasak';
            } elseif ($difficulty === 'medium') {
                $expandedInstructions[] = $instruction . ' dengan hati-hati';
            } else {
                $expandedInstructions[] = $instruction;
            }
        }
        
        return $expandedInstructions;
    }

    /**
     * Generate health benefits for recipe
     */
    private function generateHealthBenefits($recipeName)
    {
        $benefits = [
            'Kaya antioksidan',
            'Meningkatkan mood',
            'Sumber energi alami',
            'Mendukung sistem imun',
            'Baik untuk pencernaan',
            'Mengandung vitamin dan mineral penting'
        ];
        
        return array_slice($benefits, 0, 3);
    }

    /**
     * Get current mood (helper method)
     */
    private function getCurrentMood()
    {
        return request()->input('mood', 'bahagia');
    }

    /**
     * Get mood analytics for session
     */
    private function getMoodAnalytics($session, $startDate)
    {
        $moodTrackings = MoodTracking::where('session_id', $session->id)
            ->where('created_at', '>=', $startDate)
            ->with('mood')
            ->get();

        return [
            'total_mood_changes' => $moodTrackings->count(),
            'mood_distribution' => $moodTrackings->groupBy('mood.name')->map(function($group) {
                return $group->count();
            }),
            'average_intensity' => $moodTrackings->avg('intensity'),
            'most_frequent_mood' => $moodTrackings->groupBy('mood.name')->sortByDesc(function($group) {
                return $group->count();
            })->keys()->first()
        ];
    }

    /**
     * Get food analytics for session
     */
    private function getFoodAnalytics($session, $startDate)
    {
        $foodInteractions = FoodAnalytics::where('session_id', $session->id)
            ->where('created_at', '>=', $startDate)
            ->get();

        return [
            'total_interactions' => $foodInteractions->count(),
            'unique_foods' => $foodInteractions->pluck('food_name')->unique()->count(),
            'interaction_types' => $foodInteractions->groupBy('interaction_type')->map(function($group) {
                return $group->count();
            }),
            'top_foods' => $foodInteractions->groupBy('food_name')->map(function($group) {
                return $group->count();
            })->sortByDesc(function($count) {
                return $count;
            })->take(5)
        ];
    }

    /**
     * Get recipe analytics for session
     */
    private function getRecipeAnalytics($session, $startDate)
    {
        $recipeInteractions = FoodAnalytics::where('session_id', $session->id)
            ->where('created_at', '>=', $startDate)
            ->whereIn('interaction_type', ['recipe_generated', 'recipe_saved'])
            ->get();

        return [
            'total_generated' => $recipeInteractions->where('interaction_type', 'recipe_generated')->count(),
            'total_saved' => $recipeInteractions->where('interaction_type', 'recipe_saved')->count(),
            'generated_recipes' => $recipeInteractions->where('interaction_type', 'recipe_generated')
                ->pluck('food_name')->toArray()
        ];
    }

    /**
     * Get meal plan analytics for session
     */
    private function getMealPlanAnalytics($session, $startDate)
    {
        $mealPlans = $session->mealPlans()
            ->where('created_at', '>=', $startDate)
            ->with('items')
            ->get();

        return [
            'total_meal_plans' => $mealPlans->count(),
            'total_meals_planned' => $mealPlans->sum(function($plan) {
                return $plan->items->count();
            }),
            'average_meals_per_plan' => $mealPlans->count() > 0 ? 
                $mealPlans->sum(function($plan) { return $plan->items->count(); }) / $mealPlans->count() : 0
        ];
    }

    /**
     * Get activity timeline for session
     */
    private function getActivityTimeline($session, $startDate)
    {
        $activities = collect();

        // Get mood trackings
        $moodActivities = MoodTracking::where('session_id', $session->id)
            ->where('created_at', '>=', $startDate)
            ->with('mood')
            ->get()
            ->map(function($tracking) {
                return [
                    'type' => 'mood_selection',
                    'description' => 'Selected mood: ' . $tracking->mood->name,
                    'timestamp' => $tracking->created_at,
                    'icon' => 'smile'
                ];
            });

        // Get food interactions
        $foodActivities = FoodAnalytics::where('session_id', $session->id)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->map(function($interaction) {
                return [
                    'type' => 'food_interaction',
                    'description' => ucfirst($interaction->interaction_type) . ': ' . $interaction->food_name,
                    'timestamp' => $interaction->created_at,
                    'icon' => $this->getIconForInteraction($interaction->interaction_type)
                ];
            });

        return $activities->merge($moodActivities)
            ->merge($foodActivities)
            ->sortByDesc('timestamp')
            ->take(10)
            ->values();
    }

    /**
     * Get icon for interaction type
     */
    private function getIconForInteraction($interactionType)
    {
        $icons = [
            'click' => 'mouse-pointer',
            'view' => 'eye',
            'recipe_generated' => 'magic',
            'recipe_saved' => 'heart',
            'meal_plan_created' => 'calendar',
            'default' => 'activity'
        ];

        return $icons[$interactionType] ?? $icons['default'];
    }

    /**
     * Export analytics as CSV
     */
    private function exportAnalyticsAsCSV($analytics)
    {
        $csvData = [];
        $csvData[] = ['Metric', 'Value', 'Category'];

        // Session info
        foreach ($analytics->session_info as $key => $value) {
            $csvData[] = [ucfirst(str_replace('_', ' ', $key)), $value, 'Session Info'];
        }

        // Mood analytics
        foreach ($analytics->mood_analytics as $key => $value) {
            $csvData[] = [ucfirst(str_replace('_', ' ', $key)), $value, 'Mood Analytics'];
        }

        // Food analytics
        foreach ($analytics->food_analytics as $key => $value) {
            $csvData[] = [ucfirst(str_replace('_', ' ', $key)), $value, 'Food Analytics'];
        }

        $filename = 'analytics-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
}
