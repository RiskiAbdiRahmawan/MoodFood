    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MoodFood Pro - AI-Powered Mood & Nutrition Assistant</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- CSS Files -->    
        <link rel="stylesheet" href="./css/variables.css">
        <link rel="stylesheet" href="./css/animations.css">
        <link rel="stylesheet" href="./css/layout.css">
        <link rel="stylesheet" href="./css/header.css">
        <link rel="stylesheet" href="./css/mood-tracker.css">
        <link rel="stylesheet" href="./css/food-components.css">
        <link rel="stylesheet" href="./css/recipes.css">
        <link rel="stylesheet" href="./css/meal-planner.css">
        <link rel="stylesheet" href="./css/charts.css">    
        <link rel="stylesheet" href="./css/chatbot.css">
        <link rel="stylesheet" href="./css/forms.css">
        <link rel="stylesheet" href="./css/forms-feedback.css">
        <link rel="stylesheet" href="./css/feedback-animations.css">
        <link rel="stylesheet" href="./css/responsive.css">
        <link rel="stylesheet" href="./css/custom-animations.css">
    </head>
    <body>
        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="header">
                <h1><i class="fas fa-utensils"></i> MoodFood Pro</h1>
                <p>AI-Powered Mood & Nutrition Assistant</p>
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number" id="total-meals">0</span>
                        <span class="stat-label">Meals Tracked</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" id="mood-score">0</span>
                        <span class="stat-label">Avg Mood Score</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" id="food-recommendations">0</span>
                        <span class="stat-label">Food Recommendations</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="navigation">
                <!-- Home Button -->
                <a href="{{ url('/') }}" class="nav-btn back-btn">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
                
                <!-- Section Navigation -->
                <div>
                    <button class="nav-btn active" data-section="mood-tracker">
                        <i class="fas fa-smile"></i> Mood Tracker
                    </button>
                    <button class="nav-btn" data-section="meal-planner">
                        <i class="fas fa-calendar-alt"></i> Meal Planner
                    </button>
                    <button class="nav-btn" data-section="recipes">
                        <i class="fas fa-book"></i> Smart Recipes
                    </button>
                    <button class="nav-btn" data-section="analytics">
                        <i class="fas fa-chart-line"></i> Analytics
                    </button>
                </div>
            </div>

            <!-- Mood Tracker Section -->
            <div class="section active" id="mood-tracker">
                <!-- Mood Selector -->
                <div class="card mood-selector">
                    <h2><i class="fas fa-heart"></i> Bagaimana perasaanmu hari ini?</h2>
                    
                    <!-- Mood Intensity Slider -->
                    <div class="mood-intensity-slider">
                        <h3>Intensitas Mood</h3>
                        <div class="slider-container">
                            <input type="range" min="1" max="10" value="5" class="intensity-slider" id="moodIntensity">
                            <div class="intensity-labels">
                                <span>Sangat Rendah</span>
                                <span>Sedang</span>
                                <span>Sangat Tinggi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dietary Preferences -->
                    <div class="dietary-preferences">
                        <h3>Preferensi Diet</h3>
                        <div class="preference-tags">
                            @foreach ($dietaryPreferences as $pref)
                                <button class="preference-tag" data-pref="{{ $pref->name }}">
                                    {{ $pref->emoji_icon ?? '' }} {{ ucfirst($pref->name) }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="mood-grid">
                        <button class="mood-btn" data-mood="sedih">
                            😢 Sedih
                            <div class="mood-description">Merasa down, kehilangan energi</div>
                        </button>
                        <button class="mood-btn" data-mood="marah">
                            😠 Marah
                            <div class="mood-description">Merasa kesal, emosi tidak stabil</div>
                        </button>
                        <button class="mood-btn" data-mood="cemas">
                            😰 Cemas
                            <div class="mood-description">Merasa khawatir, gelisah</div>
                        </button>
                        <button class="mood-btn" data-mood="bahagia">
                            😊 Bahagia
                            <div class="mood-description">Merasa senang, bersemangat</div>
                        </button>
                        <button class="mood-btn" data-mood="lelah">
                            😴 Lelah
                            <div class="mood-description">Merasa capek, butuh energi</div>
                        </button>
                        <button class="mood-btn" data-mood="stress">
                            😵 Stress
                            <div class="mood-description">Merasa tertekan, overwhelmed</div>
                        </button>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="recommendations {{ $selectedMood ? 'active' : '' }}" id="recommendations">
                    <div class="card">
                        <h2><i class="fas fa-magic"></i> Rekomendasi untuk Mood: <span id="selected-mood">{{ $selectedMood->name ?? '' }}</span></h2>
                        
                        <div class="food-section">
                            <h3>🥗 Bahan Makanan Alami</h3>
                            <div class="food-grid" id="natural-foods">
                                @if($selectedMood && $naturalFoods->count() > 0)
                                    @foreach($naturalFoods as $food)
                                        <div class="food-card" data-type="natural" data-food-name="{{ $food->name }}">
                                            <div class="food-header">
                                                <h4>{{ $food->name }}</h4>
                                                <span class="food-type">Alami</span>
                                            </div>
                                            <p class="food-benefits">{{ $food->description ?? 'Makanan sehat alami' }}</p>
                                            @if($food->nutritionData)
                                            <div class="nutrition-info">
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Kalori</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->calories_per_100g ?? '0' }}</span>
                                                </div>
                                                @if($food->nutritionData->protein_g)
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Protein</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->protein_g }}g</span>
                                                </div>
                                                @endif
                                                @if($food->nutritionData->carbohydrates_g)
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Karbo</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->carbohydrates_g }}g</span>
                                                </div>
                                                @endif
                                                @if($food->nutritionData->fat_g)
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Lemak</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->fat_g }}g</span>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                            <div class="food-actions">
                                                <button class="btn btn-primary add-to-plan-btn" data-food="{{ $food->name }}">
                                                    <i class="fas fa-plus"></i> Tambah ke Meal Plan
                                                </button>
                                                <button class="btn btn-secondary view-nutrition-btn" data-food="{{ $food->name }}">
                                                    <i class="fas fa-info-circle"></i> Detail Nutrisi
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="food-section">
                            <h3>🍽️ Makanan Olahan</h3>
                            <div class="food-grid" id="processed-foods">
                                @if($selectedMood && $processedFoods->count() > 0)
                                    @foreach($processedFoods as $food)
                                        <div class="food-card" data-type="processed" data-food-name="{{ $food->name }}">
                                            <div class="food-header">
                                                <h4>{{ $food->name }}</h4>
                                                <span class="food-type">Olahan</span>
                                            </div>
                                            <p class="food-benefits">{{ $food->description ?? 'Makanan olahan yang lezat' }}</p>
                                            @if($food->nutritionData)
                                            <div class="nutrition-info">
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Kalori</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->calories_per_100g ?? '0' }}</span>
                                                </div>
                                                @if($food->nutritionData->protein_g)
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Protein</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->protein_g }}g</span>
                                                </div>
                                                @endif
                                                @if($food->nutritionData->carbohydrates_g)
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Karbo</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->carbohydrates_g }}g</span>
                                                </div>
                                                @endif
                                                @if($food->nutritionData->fat_g)
                                                <div class="nutrition-item">
                                                    <span class="nutrition-label">Lemak</span>
                                                    <span class="nutrition-value">{{ $food->nutritionData->fat_g }}g</span>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                            <div class="food-actions">
                                                <button class="btn btn-primary add-to-plan-btn" data-food="{{ $food->name }}">
                                                    <i class="fas fa-plus"></i> Tambah ke Meal Plan
                                                </button>
                                                <button class="btn btn-secondary view-nutrition-btn" data-food="{{ $food->name }}">
                                                    <i class="fas fa-info-circle"></i> Detail Nutrisi
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meal Planner Section -->        
            <div class="section" id="meal-planner">
                <div class="card">
                    <h2><i class="fas fa-calendar-week"></i> Meal Planner Minggu Ini</h2>
                    <div class="week-navigation">
                        <button id="prev-week" class="nav-btn"><i class="fas fa-chevron-left"></i></button>
                        <span id="current-week">Minggu ini</span>
                        <button id="next-week" class="nav-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="meal-planner" id="meal-planner-grid">
                        <!-- Meal planner grid will be generated by JavaScript -->
                    </div>
                    <div class="suggested-meals-container">
                        <h3>Makanan yang Disarankan</h3>
                        <div id="suggested-meals" class="suggested-meals">
                            <!-- Suggested meals will be loaded here -->
                        </div>
                    </div>
                    <div class="nutrition-summary" id="nutrition-summary">
                        <!-- Daily nutrition summary -->
                    </div>
                    <div class="meal-planner-actions">
                        <button class="submit-btn" onclick="generateWeeklyPlan()">
                            <i class="fas fa-magic"></i> Generate Smart Plan
                        </button>
                        <button class="submit-btn secondary" onclick="window.moodFoodApp.exportMealPlan()">
                            <i class="fas fa-download"></i> Export Plan
                        </button>
                        <label class="submit-btn secondary" for="import-meal-plan">
                            <i class="fas fa-upload"></i> Import Plan
                            <input type="file" id="import-meal-plan" accept=".json" style="display: none;" onchange="window.moodFoodApp.importMealPlan(event)">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Smart Recipes Section -->
            <div class="section" id="recipes">
                <div class="card">
                    <h2><i class="fas fa-book-open"></i> Smart Recipe Generator</h2>
                    <div id="recipe-container">
                        <!-- Recipes will be generated based on mood and preferences -->
                    </div>
                </div>
            </div>        <!-- Analytics Section -->
            <div class="section" id="analytics">
                <div class="card">
                    <h2><i class="fas fa-chart-pie"></i> Mood & Nutrition Analytics</h2>
                    <div class="charts-grid">
                        <div class="chart-container">
                            <h3>Mood Trend (7 Hari)</h3>
                            <canvas id="moodTrendChart"></canvas>
                        </div>
                        <div class="chart-container">
                            <h3>Distribusi Mood</h3>
                            <canvas id="moodDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h2><i class="fas fa-chart-bar"></i> Weekly Nutrition Overview</h2>
                    <div class="charts-grid">
                        <div class="chart-container">
                            <h3>Nutrisi Harian</h3>
                            <canvas id="nutritionChart"></canvas>
                        </div>
                        <div class="chart-container">
                            <h3>Progress Mingguan</h3>
                            <canvas id="weeklyProgressChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="card education-section">
                <h2>💡 Tahukah Kamu?</h2>
                <div class="info-grid">
                    <div class="info-box">
                        <h3>Mengapa Makanan Mempengaruhi Mood?</h3>
                        <p>Makanan yang kita konsumsi memengaruhi produksi neurotransmitter seperti serotonin dan dopamin di otak, yang berperan penting dalam mengatur suasana hati dan emosi.</p>
                    </div>
                    <div class="info-box">
                        <h3>Serotonin & Kebahagiaan</h3>
                        <p>90% serotonin diproduksi di usus. Makanan kaya triptofan seperti pisang dan dark chocolate dapat meningkatkan produksi serotonin.</p>
                    </div>
                    <div class="info-box">
                        <h3>Omega-3 untuk Otak</h3>
                        <p>Asam lemak omega-3 dari ikan salmon dan kacang-kacangan membantu mengurangi peradangan dan mendukung kesehatan mental.</p>
                    </div>
                </div>
            </div>        

        </div>

        <!-- AI Chatbot -->
        <div class="chatbot-container">
            <button class="chatbot-toggle" onclick="toggleChatbot()">
                <i class="fas fa-robot"></i>
            </button>
            <div class="chatbot-window" id="chatbot">
                <div class="chatbot-header">
                    <i class="fas fa-robot"></i> FoodBot Assistant
                </div>
                <div class="chatbot-messages" id="chatMessages">
                    <div class="message bot">
                        Halo! Saya FoodBot, asisten nutrisi AI Anda. Bagaimana saya bisa membantu Anda hari ini?
                    </div>
                </div>
                <div class="chatbot-input">
                    <input type="text" id="chatInput" placeholder="Tanya tentang makanan..." onkeypress="handleChatKeyPress(event)">
                    <button onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- JavaScript Files -->
        <script src="./js/app.js"></script>
        <script src="./js/chatbot.js"></script>
        <script src="./js/charts.js"></script>
        <script src="./js/meal-planner.js"></script>
        <script src="./js/feedback.js"></script>
        <script>
            // Session configuration
            window.MOOD_FOOD_CONFIG = {
                sessionId: {{ $sessionId ?? 'null' }},
                csrfToken: '{{ csrf_token() }}',
                baseUrl: '{{ url('/') }}',
                trackingEnabled: true,
                selectedMood: @if($selectedMood) '{{ $selectedMood->name }}' @else null @endif,
                selectedDietaryPreference: @if($selectedDietaryPreference) '{{ $selectedDietaryPreference->name }}' @else null @endif,
                naturalFoods: {!! json_encode($naturalFoods->map(function($food) {
                    return [
                        'id' => $food->id,
                        'name' => $food->name,
                        'description' => $food->description,
                        'category' => $food->category->name ?? 'Unknown',
                        'calories' => $food->nutritionData->calories_per_100g ?? 0,
                        'protein' => $food->nutritionData->protein_g ?? 0,
                        'carbs' => $food->nutritionData->carbohydrates_g ?? 0,
                        'fats' => $food->nutritionData->fat_g ?? 0,
                        'benefits' => $food->nutritionData->mood_effects ?? $food->description ?? 'Baik untuk kesehatan',
                        'vitamins' => []
                    ];
                })->toArray()) !!},
                processedFoods: {!! json_encode($processedFoods->map(function($food) {
                    return [
                        'id' => $food->id,
                        'name' => $food->name,
                        'description' => $food->description,
                        'category' => $food->category->name ?? 'Unknown',
                        'calories' => $food->nutritionData->calories_per_100g ?? 0,
                        'protein' => $food->nutritionData->protein_g ?? 0,
                        'carbs' => $food->nutritionData->carbohydrates_g ?? 0,
                        'fats' => $food->nutritionData->fat_g ?? 0,
                        'benefits' => $food->nutritionData->mood_effects ?? $food->description ?? 'Lezat dan bergizi',
                        'vitamins' => []
                    ];
                })->toArray()) !!},
                moods: {!! json_encode($moods->map(function($mood) {
                    return [
                        'id' => $mood->id,
                        'name' => $mood->name,
                        'emoji' => $mood->emoji_icon,
                        'description' => $mood->description
                    ];
                })->toArray()) !!},
                dietaryPreferences: {!! json_encode($dietaryPreferences->map(function($pref) {
                    return [
                        'id' => $pref->id,
                        'name' => $pref->name,
                        'emoji' => $pref->emoji_icon
                    ];
                })->toArray()) !!}
            };

            // Initialize the application when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                window.moodFoodApp = new MoodFoodApp();
                
                // Save data when page unloads
                window.addEventListener('beforeunload', () => {
                    if (window.moodFoodApp) {
                        window.moodFoodApp.saveUserData();
                    }
                });
            });
        </script>
    </body>
    </html>
