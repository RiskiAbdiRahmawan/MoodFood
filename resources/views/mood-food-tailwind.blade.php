<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MoodFood Pro </title>
      <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
      <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'mood-primary': '#22c55e',
                        'mood-secondary': '#10b981',
                        'mood-accent': '#059669',
                        'mood-light': '#dcfce7',
                        'mood-yellow': '#fbbf24'
                    },
                    backgroundImage: {
                        'mood-gradient': 'linear-gradient(135deg, #22c55e 0%, #10b981 50%, #059669 100%)',
                        'card-gradient': 'linear-gradient(135deg, #22c55e 0%, #10b981 100%)',
                        'hero-gradient': 'linear-gradient(135deg, rgba(34, 197, 94, 0.9) 0%, rgba(16, 185, 129, 0.9) 50%, rgba(5, 150, 105, 0.9) 100%)'
                    }
                }
            }
        }
    </script>
      <style>
        /* Font */
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Text Gradient Effects */
        .text-gradient {
            background: linear-gradient(135deg, #059669, #10b981, #22c55e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Card Hover Effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Navigation Styles */
        .nav-item.active {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #059669;
            font-weight: 600;
        }
        
        .nav-item:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }
        
        /* Section Animations */
        .section-content {
            animation: fadeInUp 0.5s ease-out;
        }
        
        /* Animation Classes */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px); 
            }
            50% { 
                transform: translateY(-20px); 
            }
        }

        @keyframes blob {
            0% { 
                transform: translate(0px, 0px) scale(1); 
            }
            33% { 
                transform: translate(30px, -50px) scale(1.1); 
            }
            66% { 
                transform: translate(-20px, 20px) scale(0.9); 
            }
            100% { 
                transform: translate(0px, 0px) scale(1); 
            }
        }
        
        /* Text Effects */
        .hero-text {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .text-shadow-sm {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        /* Chart Containers */
        #moodTrendChart, #foodCategoryChart {
            max-height: 300px;
        }
        
        /* Mobile Navigation */
        @media (max-width: 768px) {
            .nav-item {
                justify-content: flex-start;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-mood-primary to-mood-secondary min-h-screen">    
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-sm shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Bar -->
            <div class="flex justify-between items-center h-16 border-b border-gray-100">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <i class="fas fa-brain text-mood-primary text-2xl mr-3"></i>
                        <span class="text-xl font-bold text-gray-800">MoodFood Pro</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @if(isset($sessionInfo) && $sessionInfo['is_returning_visitor'])
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-user-check text-green-500"></i>
                            Kunjungan ke-{{ $sessionInfo['total_visits'] }}
                        </span>
                    @endif
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <div class="hidden md:flex items-center justify-center py-3" id="main-nav">
                <div class="flex space-x-1">
                    <!-- Home -->
                    <a href="{{ url('/') }}" 
                       class="nav-item flex items-center px-6 py-2 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                       data-section="home">
                        <i class="fas fa-home text-blue-500 mr-2"></i>
                        <span class="font-medium text-gray-700">Home</span>
                    </a>
                    
                    <!-- Mood Tracker -->
                    <button onclick="showSection('mood-tracker')" 
                            class="nav-item flex items-center px-6 py-2 rounded-lg transition-all duration-300 hover:bg-gray-100 active" 
                            data-section="mood-tracker">
                        <i class="fas fa-smile text-mood-primary mr-2"></i>
                        <span class="font-medium text-gray-700">Mood Tracker</span>
                    </button>
                    
                    <!-- Meal Plan -->
                    <button onclick="showSection('meal-plan')" 
                            class="nav-item flex items-center px-6 py-2 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                            data-section="meal-plan">
                        <i class="fas fa-calendar-week text-green-500 mr-2"></i>
                        <span class="font-medium text-gray-700">Meal Plan</span>
                    </button>
                    
                    <!-- Smart Recipe -->
                    <button onclick="showSection('smart-recipe')" 
                            class="nav-item flex items-center px-6 py-2 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                            data-section="smart-recipe">
                        <i class="fas fa-utensils text-orange-500 mr-2"></i>
                        <span class="font-medium text-gray-700">Smart Recipe</span>
                    </button>
                    
                    <!-- Analytics -->
                    <button onclick="showSection('analytics')" 
                            class="nav-item flex items-center px-6 py-2 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                            data-section="analytics">
                        <i class="fas fa-chart-line text-purple-500 mr-2"></i>
                        <span class="font-medium text-gray-700">Analytics</span>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div class="md:hidden hidden" id="mobile-nav">
                <div class="py-3 space-y-1">
                    <!-- Home for Mobile -->
                    <a href="{{ url('/') }}" 
                       class="nav-item w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                       data-section="home">
                        <i class="fas fa-home text-blue-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Home</span>
                    </a>
                    
                    <button onclick="showSection('mood-tracker')" 
                            class="nav-item w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 hover:bg-gray-100 active" 
                            data-section="mood-tracker">
                        <i class="fas fa-smile text-mood-primary mr-3"></i>
                        <span class="font-medium text-gray-700">Mood Tracker</span>
                    </button>
                    
                    <button onclick="showSection('meal-plan')" 
                            class="nav-item w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                            data-section="meal-plan">
                        <i class="fas fa-calendar-week text-green-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Meal Plan</span>
                    </button>
                    
                    <button onclick="showSection('smart-recipe')" 
                            class="nav-item w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                            data-section="smart-recipe">
                        <i class="fas fa-utensils text-orange-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Smart Recipe</span>
                    </button>
                    
                    <button onclick="showSection('analytics')" 
                            class="nav-item w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 hover:bg-gray-100" 
                            data-section="analytics">
                        <i class="fas fa-chart-line text-purple-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Analytics</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>    
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Mood Tracker Section -->
        <div id="mood-tracker-section" class="section-content">
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
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    @foreach($moods as $mood)
                        <label class="mood-selector cursor-pointer">
                            <input type="radio" name="mood" value="{{ $mood->name }}" 
                                   {{ $selectedMood && $selectedMood->name === $mood->name ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="p-4 bg-white border-2 border-gray-200 rounded-2xl text-center transition-all duration-300 
                                    hover:scale-105 hover:shadow-lg peer-checked:border-mood-primary peer-checked:bg-mood-gradient peer-checked:text-white
                                    flex flex-col items-center justify-center min-h-[140px]">
                                <div class="text-2xl mb-2">{{ $mood->emoji_icon ?? '😊' }}</div>
                                <div class="font-semibold text-sm">{{ ucfirst($mood->name) }}</div>
                                <div class="text-xs mt-2 opacity-80">{{ Str::limit($mood->description ?? '', 60) }}</div>
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
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">
                            <i class="fas fa-utensils text-mood-primary mr-2"></i>Preferensi Diet (Opsional)
                        </label>
                        <button type="button" onclick="resetDietaryPreference()" 
                                class="text-xs text-gray-500 hover:text-mood-primary transition-colors">
                            <i class="fas fa-undo mr-1"></i>Reset
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($dietaryPreferences as $pref)
                            <label class="cursor-pointer">
                                <input type="radio" name="dietary_preference" value="{{ $pref->name }}" {{ $selectedDietaryPreference && $selectedDietaryPreference->name === $pref->name ? 'checked' : '' }} class="sr-only peer">
                                <div class="px-4 py-2 border-2 border-gray-200 rounded-full text-center transition-all duration-300 hover:bg-gray-50 peer-checked:border-mood-primary peer-checked:bg-mood-gradient peer-checked:text-white">
                                    @if($pref->name == 'Vegetarian')
                                        <i class="fas fa-leaf mr-1"></i>
                                    @elseif($pref->name == 'Vegan')
                                        <i class="fas fa-seedling mr-1"></i>
                                    @elseif($pref->name == 'Gluten Free')
                                        <i class="fas fa-wheat-slash mr-1"></i>
                                    @elseif($pref->name == 'Keto')
                                        <i class="fas fa-bacon mr-1"></i>
                                    @elseif($pref->name == 'Low Carb')
                                        <i class="fas fa-weight-scale mr-1"></i>
                                    @elseif($pref->name == 'Paleo')
                                        <i class="fas fa-drumstick-bite mr-1"></i>
                                    @elseif($pref->name == 'Pescatarian')
                                        <i class="fas fa-fish mr-1"></i>
                                    @elseif($pref->name == 'Dairy Free')
                                        <i class="fas fa-ban mr-1"></i><i class="fas fa-cheese mr-1"></i>
                                    @else
                                        <i class="fas fa-apple-alt mr-1"></i>
                                    @endif
                                    {{ $pref->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <script>
                    function resetDietaryPreference() {
                        const dietaryRadios = document.querySelectorAll('input[name="dietary_preference"]');
                        dietaryRadios.forEach(radio => {
                            radio.checked = false;
                        });
                    }
                </script>

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
            <!-- Mood-Specific Fact Card -->
            <div class="bg-white/95 rounded-3xl shadow-2xl p-8 mb-8">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center justify-center">
                <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
                Fakta Menarik
                </h3>
            </div>
            
            @if($selectedMood->name === 'sedih')
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 border-l-4 border-blue-500">
                <div class="flex items-start">
                    <div class="bg-blue-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-brain text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-blue-800 mb-3">Mengapa Makanan Penting Saat Sedih?</h4>
                    <p class="text-blue-700 leading-relaxed">
                        Saat seseorang merasa sedih, tubuh sebenarnya sedang mengalami ketidakseimbangan kimia di otak, terutama berkaitan dengan neurotransmitter seperti <strong>serotonin dan dopamin</strong>—dua senyawa yang berperan besar dalam mengatur perasaan senang, motivasi, dan ketenangan.
                    </p>
                    <p class="text-blue-700 leading-relaxed mt-3">
                        Nah, tubuh tidak bisa memproduksi kedua zat ini dengan optimal tanpa dukungan gizi yang tepat. Makanan kaya <strong>vitamin B, C, magnesium, triptofan, dan omega-3</strong> sangat membantu karena mendukung produksi neurotransmitter "bahagia" seperti serotonin dan dopamin.
                    </p>
                    </div>
                </div>
                </div>
                
            @elseif($selectedMood->name === 'marah')
                <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-2xl p-6 border-l-4 border-red-500">
                <div class="flex items-start">
                    <div class="bg-red-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-fire text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-red-800 mb-3">Menenangkan Emosi dengan Nutrisi</h4>
                    <p class="text-red-700 leading-relaxed">
                        Saat mood sedang marah, tubuh dan otak berada dalam kondisi tegang, terstimulasi berlebihan, dan penuh hormon stres seperti <strong>kortisol dan adrenalin</strong>. Untuk menetralkannya, kita cenderung memerlukan makanan yang mengandung <strong>magnesium, vitamin B kompleks, lemak sehat, antioksidan, dan probiotik</strong> serta gula alami.
                    </p>
                    <p class="text-red-700 leading-relaxed mt-3">
                        Makanan ini bekerja secara alami untuk menurunkan ketegangan, menjaga stabilitas emosi, dan mengembalikan ketenangan secara bertahap — bukan dengan menekan emosi, tapi dengan mendukung sistem tubuh agar kembali ke kondisi seimbang.
                    </p>
                    </div>
                </div>
                </div>
            @elseif($selectedMood->name === 'bahagia')
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-2xl p-6 border-l-4 border-yellow-500">
                <div class="flex items-start">
                    <div class="bg-yellow-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-smile text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-yellow-800 mb-3">Mempertahankan Mood Positif</h4>
                    <p class="text-yellow-700 leading-relaxed">
                        Mood bahagia atau senang, bersemangat biasanya berkaitan dengan makanan yang mengandung <strong>dopamine booster atau serotonin booster</strong> (hormon bahagia), kaya <strong>vitamin B, magnesium, triptofan, omega-3, antioksidan, atau flavonoid</strong>.
                    </p>
                    <p class="text-yellow-700 leading-relaxed mt-3">
                        Makanan-makanan ini memberikan rasa puas dan kenyang tanpa bikin "crash" setelahnya, membantu mempertahankan energi positif dan mood yang stabil sepanjang hari.
                    </p>
                    </div>
                </div>
                </div>
            @elseif($selectedMood->name === 'lelah')
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl p-6 border-l-4 border-purple-500">
                <div class="flex items-start">
                    <div class="bg-purple-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-battery-quarter text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-purple-800 mb-3">Mengembalikan Energi Tubuh</h4>
                    <p class="text-purple-700 leading-relaxed">
                        Saat mood lelah, tubuh dan otak memerlukan makanan yang mengandung <strong>karbohidrat kompleks, vitamin B, zat besi, magnesium, dan protein</strong> untuk mengisi ulang energi, meningkatkan aliran oksigen, dan menstabilkan fungsi otak serta sistem saraf.
                    </p>
                    <p class="text-purple-700 leading-relaxed mt-3">
                        Nutrisi-nutrisi ini bekerja sama untuk mengembalikan vitalitas tubuh secara bertahap dan berkelanjutan, bukan hanya memberikan dorongan energi sesaat.
                    </p>
                    </div>
                </div>
                </div>
            @elseif($selectedMood->name === 'stress' || $selectedMood->name === 'stress')
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border-l-4 border-orange-500">
                <div class="flex items-start">
                    <div class="bg-orange-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-heart-pulse text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-orange-800 mb-3">Menenangkan Sistem Saraf</h4>
                    <p class="text-orange-700 leading-relaxed">
                        Saat stres, tubuh membutuhkan makanan yang kaya <strong>magnesium, vitamin B, triptofan, antioksidan, probiotik, dan karbohidrat kompleks</strong>. Makanan tersebut bekerja sama membantu menenangkan sistem saraf, menstabilkan energi otak, serta memperbaiki suasana hati secara bertahap dan alami.
                    </p>
                    <p class="text-orange-700 leading-relaxed mt-3">
                        Kombinasi nutrisi ini membantu tubuh mengelola hormon stres dengan lebih baik dan menciptakan keseimbangan emosional yang lebih stabil.
                    </p>
                    </div>
                </div>
                </div>
            @elseif($selectedMood->name === 'cemas')
                <div class="bg-gradient-to-r from-teal-50 to-teal-100 rounded-2xl p-6 border-l-4 border-teal-500">
                <div class="flex items-start">
                    <div class="bg-teal-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-wind text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-teal-800 mb-3">Meredakan Kecemasan dengan Makanan</h4>
                    <p class="text-teal-700 leading-relaxed">
                        Kecemasan sering ditandai dengan peningkatan hormon stres dan ketidakseimbangan neurotransmitter di otak. Makanan yang kaya <strong>magnesium, zinc, omega-3, vitamin B kompleks, dan antioksidan</strong> dapat membantu menstabilkan sistem saraf dan mengurangi gejala kecemasan.
                    </p>
                    <p class="text-teal-700 leading-relaxed mt-3">
                        Selain itu, makanan yang mengandung <strong>L-theanine</strong> (seperti teh hijau) dan <strong>triptofan</strong> membantu meningkatkan produksi GABA dan serotonin yang berperan penting dalam menenangkan pikiran dan menciptakan rasa rileks tanpa kantuk.
                    </p>
                    </div>
                </div>
                </div>
            @else
                <!-- Default fact for other moods -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 border-l-4 border-gray-500">
                <div class="flex items-start">
                    <div class="bg-gray-500 rounded-full p-3 mr-4 flex-shrink-0">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                    </div>
                    <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Hubungan Mood dan Nutrisi</h4>
                    <p class="text-gray-700 leading-relaxed">
                        Setiap mood memiliki kebutuhan nutrisi yang spesifik. Makanan yang tepat dapat membantu menyeimbangkan neurotransmitter di otak dan mendukung kesehatan mental secara keseluruhan.
                    </p>
                    <p class="text-gray-700 leading-relaxed mt-3">
                        Dengan memilih makanan yang sesuai dengan kondisi emosional, kita dapat membantu tubuh mencapai keseimbangan yang optimal.
                    </p>
                    </div>
                </div>
                </div>
            @endif
            </div>

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
                    @if($food->calories_per_100g)
                    <div class="text-xs text-green-600 mt-2">
                    <i class="fas fa-fire mr-1"></i>{{ $food->calories_per_100g }} kal/100g
                    </div>
                    @endif
                </div>
                <div class="flex space-x-2 ml-2">
                    <!-- Nutrition Details Button -->
                    <button 
                    onclick="showNutritionModal('{{ $food->id }}', '{{ addslashes($food->name) }}', {{ $food->calories_per_100g ?? 0 }}, {{ $food->protein_per_100g ?? 0 }}, {{ $food->fats_per_100g ?? 0 }}, {{ $food->carbs_per_100g ?? 0 }})"
                    class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors"
                    title="Lihat Detail Nutrisi"
                    >
                    <i class="fas fa-info-circle text-xs"></i>
                    </button>
                    <!-- Add to Meal Plan Button -->
                    <form method="POST" action="{{ route('mood-food-tailwind.meal-plan') }}">
                    @csrf
                    <input type="hidden" name="action" value="add_food">
                    <input type="hidden" name="food_id" value="{{ $food->id }}">
                    <input type="hidden" name="meal_type" value="makan_siang">
                    <input type="hidden" name="day_of_week" value="{{ now()->dayOfWeek }}">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors" title="Tambah ke Rencana Makan">
                    <i class="fas fa-plus text-xs"></i>
                    </button>
                    </form>
                </div>
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
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $food->name }}</h4>
                    <p class="text-xs text-gray-600 mt-1">{{ Str::limit($food->description, 50) }}</p>
                    @if($food->calories_per_100g)
                    <div class="text-xs text-orange-600 mt-2">
                    <i class="fas fa-fire mr-1"></i>{{ $food->calories_per_100g }} kal/100g
                    </div>
                    @endif
                </div>
                <div class="flex space-x-2 ml-2">
                    <!-- Nutrition Details Button -->
                    <button 
                    onclick="showNutritionModal('{{ $food->id }}', '{{ addslashes($food->name) }}', {{ $food->calories_per_100g ?? 0 }}, {{ $food->protein_per_100g ?? 0 }}, {{ $food->fats_per_100g ?? 0 }}, {{ $food->carbs_per_100g ?? 0 }})"
                    class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors"
                    title="Lihat Detail Nutrisi"
                    >
                    <i class="fas fa-info-circle text-xs"></i>
                    </button>
                    <!-- Add to Meal Plan Button -->
                    <form method="POST" action="{{ route('mood-food-tailwind.meal-plan') }}">
                    @csrf
                    <input type="hidden" name="action" value="add_food">
                    <input type="hidden" name="food_id" value="{{ $food->id }}">
                    <input type="hidden" name="meal_type" value="makan_siang">
                    <input type="hidden" name="day_of_week" value="{{ now()->dayOfWeek }}">
                    <button type="submit" class="bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition-colors" title="Tambah ke Rencana Makan">
                    <i class="fas fa-plus text-xs"></i>
                    </button>
                    </form>
                </div>
                </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada rekomendasi makanan olahan untuk mood ini.</p>
            @endif
            </div>
            </div>

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

        @endif
    </div>
    <!-- End Mood Tracker Section -->

        <!-- Meal Plan Section -->
        <div id="meal-plan-section" class="section-content hidden">
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    <i class="fas fa-calendar-week mr-3"></i>
                    Rencana Makan Mingguan
                </h1>
                <p class="text-lg text-white/80 max-w-2xl mx-auto">
                    Kelola dan atur rencana makan Anda untuk satu minggu penuh
                </p>
            </div>

            {{-- rencana makan mingguan --}}

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


        </div>
        <!-- End Meal Plan Section -->
        <!-- Smart Recipe Section -->
        <div id="smart-recipe-section" class="section-content hidden">
            <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            <i class="fas fa-utensils mr-3"></i>
            Smart Recipe Generator
            </h1>
            <p class="text-lg text-white/80 max-w-2xl mx-auto">
            Dapatkan resep cerdas sesuai mood Anda
            </p>
            </div>

            <!-- Recipe Generator -->
            <div class="bg-white/95 rounded-3xl shadow-2xl p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center justify-center">
            <i class="fas fa-magic text-orange-500 mr-2"></i>
            Generator Resep
            </h3>

            <div class="max-w-md mx-auto mb-8">
            <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Mood Anda</label>
                <select id="recipe-mood" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                <option value="">Pilih Mood</option>
                <option value="bahagia">Bahagia</option>
                <option value="sedih">Sedih</option>
                <option value="lelah">Lelah</option>
                <option value="stress">Stress</option>
                <option value="cemas">Cemas</option>
                <option value="marah">Marah</option>
                </select>
            </div>

            <button id="generate-recipe-btn" onclick="generateRecipe()" class="w-full bg-orange-500 text-white py-3 rounded-lg hover:bg-orange-600 transition-colors">
                <i class="fas fa-wand-magic-sparkles mr-2"></i>
                Generate Resep
            </button>
            </div>
            </div>

            <!-- Generated Recipe Preview -->
            <div id="recipe-container" class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border border-orange-200 max-w-2xl mx-auto hidden">
            <h4 id="recipe-title" class="font-bold text-xl text-gray-800 mb-4 text-center"></h4>
            
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center text-gray-600">
                <i class="fas fa-tag text-orange-500 mr-2"></i>
                <span class="font-medium">Mood:</span>
                <span id="recipe-mood-tag" class="ml-2 px-3 py-1 bg-orange-500 text-white text-xs rounded-full"></span>
                </div>
                <div class="flex items-center text-gray-600">
                <i class="fas fa-clock text-orange-500 mr-2"></i>
                <span class="font-medium">Waktu:</span>
                <span id="recipe-time" class="ml-2"></span>
                </div>
                <div class="flex items-center text-gray-600">
                <i class="fas fa-fire text-orange-500 mr-2"></i>
                <span class="font-medium">Kalori:</span>
                <span id="recipe-calories" class="ml-2"></span>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 mb-4">
                <h5 class="font-semibold text-gray-700 mb-2">
                <i class="fas fa-chart-pie text-orange-500 mr-2"></i>Nutrisi per Sajian:
                </h5>
                <div class="grid grid-cols-3 gap-2">
                <div class="bg-blue-50 p-2 rounded-lg text-center">
                    <div class="text-xs text-gray-600">Protein</div>
                    <div id="recipe-protein" class="font-semibold text-blue-600"></div>
                </div>
                <div class="bg-yellow-50 p-2 rounded-lg text-center">
                    <div class="text-xs text-gray-600">Lemak</div>
                    <div id="recipe-fat" class="font-semibold text-yellow-600"></div>
                </div>
                <div class="bg-green-50 p-2 rounded-lg text-center">
                    <div class="text-xs text-gray-600">Karbohidrat</div>
                    <div id="recipe-carbs" class="font-semibold text-green-600"></div>
                </div>
                </div>
            </div>
            
            <div class="space-y-4">
            <div>
                <h5 class="font-semibold text-gray-700 mb-2">
                <i class="fas fa-shopping-basket text-orange-500 mr-2"></i>Bahan-bahan:
                </h5>
                <ul id="recipe-ingredients" class="list-disc pl-5 text-gray-600 space-y-1"></ul>
            </div>
            
            <div>
                <h5 class="font-semibold text-gray-700 mb-2">
                <i class="fas fa-list-ol text-orange-500 mr-2"></i>Cara Membuat:
                </h5>
                <ol id="recipe-steps" class="list-decimal pl-5 text-gray-600 space-y-2"></ol>
            </div>
            
            <div>
                <h5 class="font-semibold text-gray-700 mb-2">
                <i class="fas fa-lightbulb text-orange-500 mr-2"></i>Manfaat untuk Mood:
                </h5>
                <p id="recipe-benefits" class="text-gray-600"></p>
            </div>
            </div>
            </div>
            
            <div id="recipe-loading" class="text-center py-8 hidden">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
            <p class="mt-2 text-gray-600">Sedang menyiapkan resep sesuai mood Anda...</p>
            </div>
            </div>
        </div>
        <!-- End Smart Recipe Section -->
        
        <script>
            function generateRecipe() {
            const moodSelect = document.getElementById('recipe-mood');
            const selectedMood = moodSelect.value;
            
            if (!selectedMood) {
            alert('Silakan pilih mood terlebih dahulu');
            return;
            }
            
            // Show loading
            document.getElementById('recipe-loading').classList.remove('hidden');
            document.getElementById('recipe-container').classList.add('hidden');
            
            // Simulate API call with timeout
            setTimeout(() => {
            const recipeData = getRecipeForMood(selectedMood);
            displayRecipe(recipeData);
            
            // Hide loading
            document.getElementById('recipe-loading').classList.add('hidden');
            document.getElementById('recipe-container').classList.remove('hidden');
            }, 1500);
            }
            
            function displayRecipe(recipe) {
            document.getElementById('recipe-title').textContent = recipe.title;
            document.getElementById('recipe-mood-tag').textContent = recipe.mood;
            document.getElementById('recipe-time').textContent = recipe.time;
            document.getElementById('recipe-calories').textContent = recipe.nutrition.calories;
            document.getElementById('recipe-protein').textContent = recipe.nutrition.protein;
            document.getElementById('recipe-fat').textContent = recipe.nutrition.fat;
            document.getElementById('recipe-carbs').textContent = recipe.nutrition.carbs;
            
            const ingredientsList = document.getElementById('recipe-ingredients');
            ingredientsList.innerHTML = '';
            recipe.ingredients.forEach(ingredient => {
            const li = document.createElement('li');
            li.textContent = ingredient;
            ingredientsList.appendChild(li);
            });
            
            const stepsList = document.getElementById('recipe-steps');
            stepsList.innerHTML = '';
            recipe.steps.forEach(step => {
            const li = document.createElement('li');
            li.textContent = step;
            stepsList.appendChild(li);
            });
            
            document.getElementById('recipe-benefits').textContent = recipe.benefits;
            }
            
            function getRecipeForMood(mood) {
            const recipes = {
            bahagia: {
            title: 'Banana-Choco Bites',
            mood: 'Bahagia',
            time: '40 menit',
            nutrition: {
                calories: '438 kkal',
                protein: '8 gr',
                fat: '32 gr',
                carbs: '31 gr'
            },
            ingredients: [
                '1 buah pisang, potong bulat',
                '50 gr coklat hitam, lelehkan',
                '1 sdm kacang almond cincang (bisa diganti kacang lain)',
                '½ sdm yoghurt'
            ],
            steps: [
                'Campur kacang dan yoghurt dalam coklat leleh',
                'Celupkan potongan pisang ke coklat leleh.',
                'Tambahkan almond cincang lagi untuk topping jika mau.',
                'Simpan di freezer selama 30 menit – 1 jam.',
                'Sajikan dingin!'
            ],
            benefits: 'Cokelat hitam mengandung theobromine dan phenylethylamine yang dapat meningkatkan mood. Pisang kaya akan triptofan yang membantu produksi serotonin (hormon kebahagiaan).'
            },
            sedih: {
            title: 'Bolu Pisang Kukus',
            mood: 'Sedih',
            time: '30 menit',
            nutrition: {
                calories: '1.567 kkal',
                protein: '27 gr',
                fat: '66 gr',
                carbs: '226 gr'
            },
            ingredients: [
                '3 buah pisang matang uk. besar, lumatkan',
                '2 butir telur',
                '5 sdm gula (boleh dikurangi)',
                '7 sdm tepung terigu (bisa dicampur dengan 1 sdm oat atau mocaf)',
                '½ sdt soda kue (opsional, untuk hasil lebih mengembang)',
                'Sejumput garam',
                '4 sdm minyak kelapa/minyak sayur',
                '½ sdt vanili (opsional)'
            ],
            steps: [
                'Campur telur dan gula, aduk sampai tercampur rata.',
                'Masukkan pisang lumat, minyak, dan vanili. Aduk rata.',
                'Ayak tepung, baking powder, soda kue, dan garam. Masukkan ke adonan basah, aduk lipat sampai halus.',
                'Tuang ke loyang atau cetakan muffin (olesi minyak sebelumnya) boleh ditambah topping sesuai selera.',
                'Kukus 25–30 menit api sedang, tutup dilapisi kain agar uap tidak menetes.',
                'Angkat, dinginkan sebentar, lalu sajikan.'
            ],
            benefits: 'Pisang mengandung vitamin B6 yang membantu produksi serotonin dan dopamin untuk meredakan kesedihan. Karbohidrat kompleks dalam tepung membantu meningkatkan energi dan menstabilkan mood.'
            },
            lelah: {
            title: 'Oat Pisang Almond',
            mood: 'Lelah',
            time: '10 menit',
            nutrition: {
                calories: '492 kkal',
                protein: '16 gr',
                fat: '18 gr',
                carbs: '70 gr'
            },
            ingredients: [
                '4 sdm oat',
                '1 buah pisang matang, iris',
                '1 sdm almond cincang',
                '150 ml air panas atau susu (boleh pakai susu nabati)',
                'Madu dan kayu manis (opsional)'
            ],
            steps: [
                'Seduh oatmeal dengan air panas atau susu, diamkan 3–5 menit hingga lunak.',
                'Aduk, lalu tambahkan irisan pisang dan taburi almond.',
                'Tambahkan madu dan kayu manis jika suka rasa manis alami.'
            ],
            benefits: 'Oat memberikan energi berkelanjutan melalui karbohidrat kompleks. Pisang kaya akan potasium dan vitamin B6 yang membantu mengatasi kelelahan, sementara almond menyediakan protein dan lemak sehat untuk daya tahan.'
            },
            stress: {
            title: 'Homemade Granola Bar',
            mood: 'Stress',
            time: '2 jam 30 menit (termasuk waktu pendinginan)',
            nutrition: {
                calories: '1.452 kkal',
                protein: '37 gr',
                fat: '79 gr',
                carbs: '154 gr'
            },
            ingredients: [
                '120 gr oat instan',
                '55 gr kacang almond cincang',
                '85 gr madu atau sirup maple',
                '32 gr selai kacang alami',
                '45 gr dark chocolate chips (opsional)'
            ],
            steps: [
                'Campur oat, dan kacang.',
                'Panaskan madu dan selai kacang di atas api kecil hingga cair, lalu campurkan ke bahan kering.',
                'Aduk rata, tambahkan chocolate chips jika suka.',
                'Tuang ke loyang kecil, tekan padat.',
                'Simpan di kulkas minimal 2 jam, lalu potong-potong.'
            ],
            benefits: 'Oat mengandung vitamin B yang membantu meredakan stres dan menstabilkan suasana hati. Kacang-kacangan mengandung magnesium dan zinc yang membantu menenangkan sistem saraf. Madu memberikan gula alami yang membantu menstabilkan kadar gula darah.'
            },
            cemas: {
            title: 'Smoothie Alpukat-Pisang',
            mood: 'Cemas',
            time: '5 menit',
            nutrition: {
                calories: '824 kkal',
                protein: '10 gr',
                fat: '71 gr',
                carbs: '42 gr'
            },
            ingredients: [
                '1 buah alpukat matang',
                '1 buah pisang matang',
                '100 ml susu almond atau susu rendah lemak',
                '1 sdm madu / sirup maple / simple sirup (opsional)',
                'Es batu secukupnya'
            ],
            steps: [
                'Potong alpukat dan pisang, masukkan ke dalam blender.',
                'Tambahkan susu dan madu.',
                'Blender hingga halus dan creamy.',
                'Tambahkan es batu sesuai selera, blender kembali hingga tercampur rata.',
                'Tuang ke dalam gelas dan sajikan segera.'
            ],
            benefits: 'Alpukat kaya akan magnesium yang membantu menenangkan sistem saraf, serta lemak sehat yang mendukung kesehatan otak. Pisang mengandung vitamin B6 yang membantu memproduksi serotonin untuk meredakan kecemasan.'
            },
            marah: {
            title: 'Banana-Choco Bites',
            mood: 'Marah',
            time: '40 menit',
            nutrition: {
                calories: '438 kkal',
                protein: '8 gr',
                fat: '32 gr',
                carbs: '31 gr'
            },
            ingredients: [
                '1 buah pisang, potong bulat',
                '50 gr coklat hitam, lelehkan',
                '1 sdm kacang almond cincang (bisa diganti kacang lain)',
                '½ sdm yoghurt'
            ],
            steps: [
                'Campur kacang dan yoghurt dalam coklat leleh',
                'Celupkan potongan pisang ke coklat leleh.',
                'Tambahkan almond cincang lagi untuk topping jika mau.',
                'Simpan di freezer selama 30 menit – 1 jam.',
                'Sajikan dingin!'
            ],
            benefits: 'Cokelat hitam membantu melepaskan endorfin yang menenangkan emosi. Pisang mengandung vitamin B6 dan magnesium yang membantu mengatur mood dan menenangkan sistem saraf.'
            }
            };
            
            return recipes[mood] || recipes.bahagia;
            }
        </script>

        <!-- Analytics Section -->
        <div id="analytics-section" class="section-content hidden">
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    <i class="fas fa-chart-line mr-3"></i>
                    Analytics Dashboard
                </h1>
                <p class="text-lg text-white/80 max-w-2xl mx-auto">
                    Analisis mendalam tentang pola mood dan kebiasaan makan Anda
                </p>
            </div>


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
            @endif

        
            </div>

            <!-- Charts Section -->
            <div class="grid lg:grid-cols-2 gap-8 mb-8">
                <!-- Mood Trend Chart -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                        Tren Mood Mingguan
                    </h3>
                    <canvas id="moodTrendChart" width="400" height="200"></canvas>
                </div>

                <!-- Food Category Distribution -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-green-500 mr-2"></i>
                        Distribusi Kategori Makanan
                    </h3>
                    <canvas id="foodCategoryChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Detailed Analytics -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Mood Patterns -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-brain text-purple-500 mr-2"></i>
                        Pola Mood
                    </h3>
                    <div class="space-y-4">
                        @php 
                        $moodPatterns = [
                            ['mood' => 'Bahagia', 'percentage' => 35, 'color' => 'yellow'],
                            ['mood' => 'Tenang', 'percentage' => 25, 'color' => 'blue'],
                            ['mood' => 'Energik', 'percentage' => 20, 'color' => 'green'],
                            ['mood' => 'Stress', 'percentage' => 12, 'color' => 'red'],
                            ['mood' => 'Sedih', 'percentage' => 8, 'color' => 'gray']
                        ]
                        @endphp
                        @foreach($moodPatterns as $pattern)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">{{ $pattern['mood'] }}</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-{{ $pattern['color'] }}-500 h-2 rounded-full" style="width: {{ $pattern['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $pattern['percentage'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Nutrition Insights -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-orange-500 mr-2"></i>
                        Insight Nutrisi
                    </h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="font-medium text-green-800">Konsumsi Protein</div>
                            <div class="text-sm text-green-600">85g/hari (Target: 80g)</div>
                            <div class="text-xs text-green-500 mt-1">
                                <i class="fas fa-check mr-1"></i>Target tercapai!
                            </div>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="font-medium text-blue-800">Hidrasi</div>
                            <div class="text-sm text-blue-600">2.1L/hari (Target: 2.5L)</div>
                            <div class="text-xs text-orange-500 mt-1">
                                <i class="fas fa-exclamation mr-1"></i>Perlu ditingkatkan
                            </div>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <div class="font-medium text-purple-800">Kalori</div>
                            <div class="text-sm text-purple-600">1,850 kal/hari</div>
                            <div class="text-xs text-green-500 mt-1">
                                <i class="fas fa-balance-scale mr-1"></i>Seimbang
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="bg-white/95 rounded-3xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Rekomendasi 
                    </h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                            <div class="font-medium text-blue-800 text-sm">Mood Booster</div>
                            <div class="text-xs text-blue-600 mt-1">Konsumsi lebih banyak omega-3 untuk meningkatkan mood</div>
                        </div>
                        <div class="p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                            <div class="font-medium text-green-800 text-sm">Pola Makan</div>
                            <div class="text-xs text-green-600 mt-1">Atur jadwal makan yang lebih konsisten</div>
                        </div>
                        <div class="p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                            <div class="font-medium text-purple-800 text-sm">Aktivitas</div>
                            <div class="text-xs text-purple-600 mt-1">Tambahkan olahraga ringan untuk keseimbangan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Analytics Section -->
    </div>    
    <!-- JavaScript -->
    <script>
        // Navigation and Section Management
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Show selected section
            const targetSection = document.getElementById(sectionName + '-section');
            if (targetSection) {
                targetSection.classList.remove('hidden');
            }
            
            // Update navigation active states
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active', 'bg-blue-100', 'text-blue-700');
                item.classList.add('hover:bg-gray-100', 'text-gray-700');
            });
            
            // Set active state for clicked nav item
            document.querySelectorAll(`[data-section="${sectionName}"]`).forEach(item => {
                item.classList.add('active', 'bg-blue-100', 'text-blue-700');
                item.classList.remove('hover:bg-gray-100', 'text-gray-700');
            });
            
            // Initialize charts if analytics section is shown
            if (sectionName === 'analytics') {
                setTimeout(initializeCharts, 100);
            }
        }

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const mobileNav = document.getElementById('mobile-nav');
            if (mobileNav.classList.contains('hidden')) {
                mobileNav.classList.remove('hidden');
                this.innerHTML = '<i class="fas fa-times text-gray-600"></i>';
            } else {
                mobileNav.classList.add('hidden');
                this.innerHTML = '<i class="fas fa-bars text-gray-600"></i>';
            }
        });

        // Initialize Charts for Analytics Section
        function initializeCharts() {
            // Mood Trend Chart
            const moodCtx = document.getElementById('moodTrendChart');
            if (moodCtx) {
                new Chart(moodCtx, {
                    type: 'line',
                    data: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        datasets: [{
                            label: 'Mood Score',
                            data: [7.2, 8.1, 6.8, 7.5, 8.3, 7.9, 8.5],
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 10,
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Food Category Chart
            const foodCtx = document.getElementById('foodCategoryChart');
            if (foodCtx) {
                new Chart(foodCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Makanan Alami', 'Makanan Olahan', 'Minuman', 'Snack Sehat'],
                        datasets: [{
                            data: [45, 25, 20, 10],
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(249, 115, 22, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(168, 85, 247, 0.8)'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            }
                        }
                    }
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set default active section
            showSection('mood-tracker');
        });

        // Intensity slider update
        const intensitySlider = document.querySelector('input[name="intensity"]');
        const intensityValue = document.getElementById('intensity-value');
        
        if (intensitySlider && intensityValue) {
            intensitySlider.addEventListener('input', function() {
                intensityValue.textContent = this.value;
            });
        }// Auto-submit form when mood is selected
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
            }        }
    </style>    <!-- Nutrition Details Modal -->
    <div id="nutritionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-2xl max-w-md w-full max-h-90vh overflow-y-auto">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-chart-pie text-orange-500 mr-2"></i>
                        Detail Nutrisi
                    </h3>
                    <button onclick="closeNutritionModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Food Name -->
                <div class="mb-4">
                    <h4 id="modalFoodName" class="text-lg font-semibold text-gray-800"></h4>
                    <p class="text-sm text-gray-600">Per 100 gram</p>
                </div>

                <!-- Nutrition Information -->
                <div class="space-y-4">
                    <!-- Calories -->
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                        <div class="flex items-center">
                            <i class="fas fa-fire text-red-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Kalori</span>
                        </div>
                        <span id="modalCalories" class="font-bold text-red-600"></span>
                    </div>

                    <!-- Protein -->
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center">
                            <i class="fas fa-dumbbell text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Protein</span>
                        </div>
                        <span id="modalProtein" class="font-bold text-blue-600"></span>
                    </div>

                    <!-- Fats -->
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="flex items-center">
                            <i class="fas fa-drop text-yellow-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Lemak</span>
                        </div>
                        <span id="modalFats" class="font-bold text-yellow-600"></span>
                    </div>

                    <!-- Carbohydrates -->
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center">
                            <i class="fas fa-seedling text-green-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Karbohidrat</span>
                        </div>
                        <span id="modalCarbs" class="font-bold text-green-600"></span>
                    </div>
                </div>

                <!-- Close Button -->
                <div class="mt-6 text-center">
                    <button onclick="closeNutritionModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>    <script>
        // Show nutrition modal
        function showNutritionModal(foodId, foodName, calories, protein, fats, carbs) {
            document.getElementById('modalFoodName').textContent = foodName;
            document.getElementById('modalCalories').textContent = calories + ' kal';
            document.getElementById('modalProtein').textContent = protein + ' g';
            document.getElementById('modalFats').textContent = fats + ' g';
            document.getElementById('modalCarbs').textContent = carbs + ' g';
            
            const modal = document.getElementById('nutritionModal');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close nutrition modal
        function closeNutritionModal() {
            const modal = document.getElementById('nutritionModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close modal when clicking outside
        document.getElementById('nutritionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNutritionModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNutritionModal();
            }
        });
    </script>
</body>
</html>
