<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MoodFood Pro - Tailwind Edition</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/n            // Download as text file
            const blob = new Blob([content], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `meal-plan-${new Date().toISOString().split('T')[0]}.txt`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            // Track export action
            trackFoodInteraction('meal_plan_export', 'export');
        }"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'mood-primary': '#667eea',
                        'mood-secondary': '#764ba2',
                        'mood-accent': '#f093fb'
                    },
                    backgroundImage: {
                        'mood-gradient': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'card-gradient': 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-mood-primary to-mood-secondary min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-sm shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-brain text-mood-primary text-2xl mr-3"></i>
                    <span class="text-xl font-bold text-gray-800">MoodFood Pro</span>
                    <span class="ml-2 px-2 py-1 bg-mood-gradient text-white text-xs rounded-full">Tailwind</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if(isset($sessionInfo) && $sessionInfo['is_returning_visitor'])
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-user-check text-green-500"></i>
                            Kunjungan ke-{{ $sessionInfo['total_visits'] }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Bagaimana perasaan Anda hari ini?
            </h1>
            <p class="text-lg text-white/80 max-w-2xl mx-auto">
                Pilih mood Anda dan dapatkan rekomendasi makanan yang sesuai untuk meningkatkan suasana hati
            </p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Mood Selection -->
        <div class="bg-white/95 rounded-3xl shadow-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                <i class="fas fa-smile text-mood-primary mr-2"></i>
                Pilih Mood Anda
            </h2>
            
            <form method="GET" action="{{ route('mood-food-tailwind') }}" class="space-y-6">
                <!-- Mood Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach($moods as $mood)
                        <label class="mood-selector cursor-pointer">
                            <input type="radio" name="mood" value="{{ $mood->name }}" 
                                   {{ $selectedMood && $selectedMood->name === $mood->name ? 'checked' : '' }}
                                   class="sr-only peer">                            <div class="p-6 bg-white border-2 border-gray-200 rounded-2xl text-center transition-all duration-300 
                                        hover:scale-105 hover:shadow-lg peer-checked:border-mood-primary peer-checked:bg-mood-gradient peer-checked:text-white">
                                <div class="text-3xl mb-2">{{ $mood->emoji_icon ?? '😊' }}</div>
                                <div class="font-semibold text-sm">{{ ucfirst($mood->name) }}</div>
                                <div class="text-xs mt-1 opacity-75">{{ $mood->description ?? '' }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <!-- Intensity Slider -->
                @if($selectedMood)
                    <div class="bg-gray-50 p-6 rounded-xl">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Intensitas Perasaan (1-10)
                        </label>
                        <input type="range" name="intensity" min="1" max="10" value="{{ request('intensity', 5) }}" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>Ringan</span>
                            <span id="intensity-value">{{ request('intensity', 5) }}</span>
                            <span>Sangat Kuat</span>
                        </div>
                    </div>
                @endif

                <!-- Dietary Preferences -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Preferensi Diet (Opsional)
                    </label>
                    <select name="dietary_preference" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mood-primary focus:border-transparent">
                        <option value="">Pilih Preferensi Diet</option>
                        @foreach($dietaryPreferences as $pref)
                            <option value="{{ $pref->name }}" 
                                    {{ $selectedDietaryPreference && $selectedDietaryPreference->name === $pref->name ? 'selected' : '' }}>
                                {{ $pref->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" 
                            class="bg-mood-gradient text-white px-8 py-3 rounded-full font-semibold 
                                   hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-search mr-2"></i>
                        Dapatkan Rekomendasi
                    </button>
                </div>
            </form>
        </div>

        @if($selectedMood)
            <!-- Food Recommendations -->
            <div class="grid lg:grid-cols-2 gap-8 mb-8">
                <!-- Natural Foods -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-leaf text-green-500 mr-2"></i>
                        Makanan Alami
                    </h3>
                    @if($naturalFoods->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($naturalFoods->take(6) as $food)
                                <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-xl border border-green-200 hover:shadow-lg transition-all duration-300 cursor-pointer" data-food-name="{{ $food->name }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $food->name }}</h4>
                                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($food->description, 50) }}</p>
                                            @if($food->nutritionData)
                                                <div class="text-xs text-green-600 mt-2">
                                                    <i class="fas fa-fire mr-1"></i>{{ $food->nutritionData->calories_per_100g }} kal/100g
                                                </div>
                                            @endif                                        </div>
                                        <form method="POST" action="{{ route('mood-food-tailwind.meal-plan') }}" class="ml-2">
                                            @csrf
                                            <input type="hidden" name="action" value="add_food">
                                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                                            <input type="hidden" name="meal_type" value="makan_siang">
                                            <input type="hidden" name="day_of_week" value="{{ now()->dayOfWeek }}">
                                            <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada rekomendasi makanan alami untuk mood ini.</p>
                    @endif
                </div>

                <!-- Processed Foods -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-cookie-bite text-orange-500 mr-2"></i>
                        Makanan Olahan
                    </h3>
                    @if($processedFoods->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($processedFoods->take(6) as $food)
                                <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-4 rounded-xl border border-orange-200 hover:shadow-lg transition-all duration-300 cursor-pointer" data-food-name="{{ $food->name }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $food->name }}</h4>
                                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($food->description, 50) }}</p>
                                            @if($food->nutritionData)
                                                <div class="text-xs text-orange-600 mt-2">
                                                    <i class="fas fa-fire mr-1"></i>{{ $food->nutritionData->calories_per_100g }} kal/100g
                                                </div>                                            @endif
                                        </div>
                                        <form method="POST" action="{{ route('mood-food-tailwind.meal-plan') }}" class="ml-2">
                                            @csrf
                                            <input type="hidden" name="action" value="add_food">
                                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                                            <input type="hidden" name="meal_type" value="makan_siang">
                                            <input type="hidden" name="day_of_week" value="{{ now()->dayOfWeek }}">
                                            <button type="submit" class="bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada rekomendasi makanan olahan untuk mood ini.</p>
                    @endif
                </div>            </div>

            <!-- Meal Plan Generation Button (when no plan exists) -->
            @if(!$weeklyMealPlan && $selectedMood)
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6 mb-8 text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-calendar-plus text-purple-500 mr-2"></i>
                        Buat Rencana Makan Mingguan
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Buat rencana makan selama seminggu berdasarkan mood <strong>{{ $selectedMood->name }}</strong> Anda!
                    </p>
                    <button 
                        id="generate-meal-plan-btn"
                        onclick="generateMealPlan()" 
                        class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-8 py-3 rounded-full hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg"
                    >
                        <i class="fas fa-magic mr-2"></i>
                        Generate Meal Plan
                    </button>
                </div>
            @endif

            <!-- Weekly Meal Plan -->
            @if($weeklyMealPlan)
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-calendar-week text-purple-500 mr-2"></i>
                            Rencana Makan Mingguan
                        </h3>
                        <div class="flex space-x-2">
                            <button 
                                onclick="exportMealPlan()"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors"
                                title="Export Meal Plan"
                            >
                                <i class="fas fa-download mr-1"></i>
                                Export
                            </button>
                            <form method="POST" action="{{ route('mood-food-tailwind.meal-plan') }}" class="inline">
                                @csrf
                                <input type="hidden" name="action" value="generate">
                                <input type="hidden" name="mood" value="{{ $selectedMood->name }}">
                                <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    Regenerate
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Meal Plan Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4">
                        @foreach($weeklyMealPlan['days'] as $dayIndex => $day)
                            <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors">
                                <h4 class="font-semibold text-center mb-3 text-gray-800">{{ $day['name'] }}</h4>
                                <div class="space-y-2">
                                    @foreach(['sarapan', 'makan_siang', 'makan_malam'] as $mealType)
                                        <div class="bg-white p-3 rounded-lg text-xs border hover:shadow-sm transition-all">
                                            <div class="flex justify-between items-center">
                                                <div class="font-medium text-gray-600 capitalize mb-1">
                                                    {{ str_replace('_', ' ', $mealType) }}
                                                </div>
                                                @if(isset($day['meals'][$mealType]) && $day['meals'][$mealType])
                                                    <button 
                                                        onclick="showMealDetails('{{ $day['meals'][$mealType]->id ?? '' }}')"
                                                        class="text-blue-500 hover:text-blue-700"
                                                        title="Lihat Detail"
                                                    >
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            @if(isset($day['meals'][$mealType]) && $day['meals'][$mealType])
                                                <div class="text-gray-800 font-medium">
                                                    @if($day['meals'][$mealType]->recipe)
                                                        {{ $day['meals'][$mealType]->recipe->name }}
                                                    @elseif($day['meals'][$mealType]->food)
                                                        {{ $day['meals'][$mealType]->food->name }}
                                                    @endif
                                                </div>
                                                @if($day['meals'][$mealType]->food && $day['meals'][$mealType]->food->nutritionData)
                                                    <div class="text-orange-600 text-xs mt-1">
                                                        <i class="fas fa-fire mr-1"></i>
                                                        {{ $day['meals'][$mealType]->food->nutritionData->calories_per_100g ?? 0 }} kal
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-gray-400">Belum ada</div>
                                                <button 
                                                    onclick="addMealToDay({{ $dayIndex }}, '{{ $mealType }}')"
                                                    class="text-green-500 hover:text-green-700 text-xs mt-1"
                                                >
                                                    <i class="fas fa-plus mr-1"></i>Tambah
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Daily Calories Summary -->
                                @php
                                    $dailyCalories = 0;
                                    foreach(['sarapan', 'makan_siang', 'makan_malam'] as $mealType) {
                                        if(isset($day['meals'][$mealType]) && $day['meals'][$mealType] && $day['meals'][$mealType]->food && $day['meals'][$mealType]->food->nutritionData) {
                                            $dailyCalories += $day['meals'][$mealType]->food->nutritionData->calories_per_100g ?? 0;
                                        }
                                    }
                                @endphp
                                @if($dailyCalories > 0)
                                    <div class="mt-3 p-2 bg-gradient-to-r from-orange-100 to-red-100 rounded-lg text-center">
                                        <div class="text-xs text-gray-600">Total Hari Ini</div>
                                        <div class="font-bold text-orange-600">{{ $dailyCalories }} kal</div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Meal Plan Summary -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php
                            $totalMeals = collect($weeklyMealPlan['days'])->flatMap(function($day) {
                                return collect($day['meals'])->filter();
                            })->count();
                            
                            $totalCalories = collect($weeklyMealPlan['days'])->flatMap(function($day) {
                                return collect($day['meals'])->filter();
                            })->sum(function($meal) {
                                return $meal && $meal->food && $meal->food->nutritionData ? $meal->food->nutritionData->calories_per_100g : 0;
                            });
                            
                            $avgCaloriesPerDay = $totalCalories > 0 ? round($totalCalories / 7) : 0;
                        @endphp
                        
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $totalMeals }}</div>
                            <div class="text-sm text-blue-800">Total Meals</div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-xl text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $totalCalories }}</div>
                            <div class="text-sm text-green-800">Total Kalori/Minggu</div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-xl text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $avgCaloriesPerDay }}</div>
                            <div class="text-sm text-purple-800">Rata-rata/Hari</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Analytics Dashboard -->
            @if(isset($analytics))
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats Cards -->
                    <div class="bg-white/95 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-mood-primary mb-2">{{ $sessionInfo['total_visits'] }}</div>
                        <div class="text-sm text-gray-600">Total Kunjungan</div>
                    </div>
                    
                    <div class="bg-white/95 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-green-500 mb-2">{{ $sessionInfo['meal_plans_count'] }}</div>
                        <div class="text-sm text-gray-600">Meal Plans Aktif</div>
                    </div>
                    
                    <div class="bg-white/95 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-orange-500 mb-2">{{ $analytics['activity_summary']['total_interactions'] }}</div>
                        <div class="text-sm text-gray-600">Interaksi Total</div>
                    </div>
                    
                    <div class="bg-white/95 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-purple-500 mb-2">{{ $analytics['activity_summary']['unique_foods'] }}</div>
                        <div class="text-sm text-gray-600">Makanan Unik</div>
                    </div>
                </div>            @endif
        @endif

        <!-- User Feedback Section -->
        @if($selectedMood)
            <div class="bg-white/95 rounded-3xl shadow-2xl p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-comment-dots text-blue-500 mr-2"></i>
                    Bagaimana Pengalaman Anda?
                </h3>
                <form id="feedback-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ $sessionId }}">
                    <input type="hidden" name="type" value="recommendation">
                    <input type="hidden" name="scope" value="overall_experience">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating Pengalaman:</label>
                        <div class="flex space-x-2" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 transition-colors" 
                                        data-rating="{{ $i }}" onclick="setRating({{ $i }})">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="">
                    </div>
                    
                    <div>
                        <label for="feedback-content" class="block text-sm font-medium text-gray-700 mb-2">
                            Komentar (opsional):
                        </label>
                        <textarea 
                            id="feedback-content" 
                            name="content" 
                            rows="3" 
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Ceritakan pengalaman Anda menggunakan fitur ini..."
                        ></textarea>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors disabled:opacity-50"
                        id="feedback-submit-btn"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Feedback
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- JavaScript -->
    <script>
        // Intensity slider update
        const intensitySlider = document.querySelector('input[name="intensity"]');
        const intensityValue = document.getElementById('intensity-value');
        
        if (intensitySlider && intensityValue) {
            intensitySlider.addEventListener('input', function() {
                intensityValue.textContent = this.value;
            });
        }        // Auto-submit form when mood is selected
        document.querySelectorAll('input[name="mood"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Small delay to show selection animation
                setTimeout(() => {
                    this.closest('form').submit();
                }, 200);
            });
        });

        // Meal Plan Generation
        function generateMealPlan() {
            const sessionId = '{{ $sessionId ?? '' }}';
            const selectedMood = '{{ $selectedMood->name ?? '' }}';
            
            if (!sessionId || !selectedMood) {
                alert('Silakan pilih mood terlebih dahulu');
                return;
            }

            // Show loading state
            const button = document.getElementById('generate-meal-plan-btn');
            const originalText = button.textContent;
            button.textContent = 'Generating...';
            button.disabled = true;

            fetch('{{ route("mood-food-tailwind.meal-plan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: 'generate',
                    session_id: sessionId,
                    mood: selectedMood
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh to show new meal plan
                } else {
                    alert('Gagal membuat meal plan: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membuat meal plan');
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        }        // Export Meal Plan
        function exportMealPlan() {
            const mealPlanData = @json($weeklyMealPlan ?? null);
            
            if (!mealPlanData) {
                alert('Tidak ada meal plan untuk di-export');
                return;
            }
            
            // Create downloadable content
            let content = `Meal Plan - ${mealPlanData.name}\n`;
            content += `Generated: ${new Date().toLocaleDateString('id-ID')}\n\n`;
            
            mealPlanData.days.forEach((day, index) => {
                content += `${day.name}:\n`;
                ['sarapan', 'makan_siang', 'makan_malam'].forEach(mealType => {
                    const meal = day.meals[mealType];
                    const mealName = mealType.replace('_', ' ').charAt(0).toUpperCase() + mealType.replace('_', ' ').slice(1);
                    if (meal && (meal.food || meal.recipe)) {
                        const foodName = meal.recipe ? meal.recipe.name : meal.food.name;
                        content += `  ${mealName}: ${foodName}\n`;
                    } else {
                        content += `  ${mealName}: -\n`;
                    }
                });
                content += '\n';
            });
            
            // Download as text file
            const blob = new Blob([content], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `meal-plan-${new Date().toISOString().split('T')[0]}.txt`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }

        // Track food interactions
        function trackFoodInteraction(foodName, interactionType) {
            const sessionId = '{{ $sessionId ?? '' }}';
            
            if (!sessionId) return;

            fetch('/api/track-food', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    food_name: foodName,
                    interaction_type: interactionType,
                    metadata: {
                        timestamp: new Date().toISOString(),
                        page: 'mood-food-tailwind'
                    }
                })
            })
            .catch(error => console.error('Tracking error:', error));        }        // Add click tracking to food items
        document.addEventListener('DOMContentLoaded', function() {
            // Track food card clicks
            document.querySelectorAll('[data-food-name]').forEach(card => {
                card.addEventListener('click', function() {
                    const foodName = this.getAttribute('data-food-name');
                    trackFoodInteraction(foodName, 'click');
                });
            });
        });

        function showMealDetails(mealId) {
            if (!mealId) return;
            
            // This could be expanded to show a modal with detailed nutrition info
            alert('Fitur detail makanan akan segera hadir!');
        }

        function addMealToDay(dayIndex, mealType) {
            // This could open a modal to select food for the specific day/meal
            alert(`Tambah makanan untuk ${mealType.replace('_', ' ')} pada hari ke-${dayIndex + 1}`);
        }

        // Rating system
        function setRating(rating) {
            document.getElementById('rating-input').value = rating;
            const stars = document.querySelectorAll('#rating-stars button');
            
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Feedback form submission
        document.getElementById('feedback-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const rating = document.getElementById('rating-input').value;
            const content = document.getElementById('feedback-content').value;
            
            if (!rating) {
                alert('Silakan berikan rating terlebih dahulu');
                return;
            }
            
            if (!content.trim()) {
                formData.set('content', 'Rating saja tanpa komentar');
            }
            
            const submitBtn = document.getElementById('feedback-submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Mengirim...';
            submitBtn.disabled = true;
            
            fetch('/api/feedback', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Terima kasih atas feedback Anda!');
                    document.getElementById('feedback-form').reset();
                    document.querySelectorAll('#rating-stars button').forEach(star => {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    });
                } else {
                    alert('Gagal mengirim feedback: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim feedback');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        // Smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const cards = document.querySelectorAll('.bg-white\\/95');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            });

            cards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>

    <style>
        .slider {
            background: linear-gradient(to right, #667eea 0%, #764ba2 100%);
        }
        
        .slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html>
