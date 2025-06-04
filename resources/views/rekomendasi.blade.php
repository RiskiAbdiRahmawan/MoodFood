<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MoodFood Recommendations - Personalized Food Suggestions</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/education.css') }}" rel="stylesheet">
    <link href="{{ asset('css/food-components.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <!-- Rekomendasi page specific styles -->
    <link href="{{ asset('css/rekomendasi.css') }}" rel="stylesheet"></head>
<body class="bg-gray-50">
</head>
<body class="bg-gray-50">
    @include('components.navbar')
    
    <!-- Hero Section with Mood Selection -->
    <section class="relative py-20 mood-selector overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-16 h-16 bg-white opacity-10 rounded-full float"></div>
            <div class="absolute top-40 right-20 w-12 h-12 bg-white opacity-10 rounded-full float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/4 w-20 h-20 bg-white opacity-10 rounded-full float" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-40 right-1/3 w-8 h-8 bg-white opacity-10 rounded-full float" style="animation-delay: 0.5s;"></div>
        </div>
        
        <div class="container mx-auto text-center relative z-10">
            <div class="fade-in">
                <h1 class="text-6xl font-bold text-white mb-6 leading-tight">
                    Rekomendasi Makanan
                    <span class="text-green-200">Personal</span>
                </h1>
                <p class="text-xl text-white max-w-4xl mx-auto mb-8 leading-relaxed opacity-90">
                    Dapatkan rekomendasi makanan yang disesuaikan dengan mood dan kebutuhan nutrisi kamu. 
                    Pilih mood kamu saat ini dan temukan makanan yang tepat untuk meningkatkan kesejahteraan.
                </p>
                  <!-- Quick Mood Selector Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mb-8">                    <div onclick="selectMood('bahagia')" 
                         data-tooltip="Klik untuk melihat makanan yang mempertahankan mood positif"
                         class="mood-card glass-effect cursor-pointer text-white p-6 rounded-xl hover:scale-105 transition duration-300 backdrop-blur-sm text-center progressive-load animate-child">
                        <div class="mood-icon-wrapper">
                            <i class="fas fa-smile mood-icon-large text-yellow-300 text-3xl mb-2"></i>
                        </div>
                        <p class="font-semibold text-lg">Bahagia</p>
                        <p class="text-sm text-green-100 opacity-75 mt-1">Pertahankan mood positif</p>
                    </div>                    <div onclick="selectMood('sedih')" 
                         data-tooltip="Klik untuk melihat makanan yang meningkatkan serotonin"
                         class="mood-card glass-effect cursor-pointer text-white p-6 rounded-xl hover:scale-105 transition duration-300 backdrop-blur-sm text-center progressive-load animate-child">
                        <div class="mood-icon-wrapper">
                            <i class="fas fa-sad-tear mood-icon-large text-blue-300 text-3xl mb-2"></i>
                        </div>
                        <p class="font-semibold text-lg">Sedih</p>
                        <p class="text-sm text-green-100 opacity-75 mt-1">Tingkatkan serotonin</p>
                    </div>                    <div onclick="selectMood('cemas')" 
                         data-tooltip="Klik untuk melihat makanan yang menenangkan pikiran"
                         class="mood-card glass-effect cursor-pointer text-white p-6 rounded-xl hover:scale-105 transition duration-300 backdrop-blur-sm text-center progressive-load animate-child">
                        <div class="mood-icon-wrapper">
                            <i class="fas fa-dizzy mood-icon-large text-orange-300 text-3xl mb-2"></i>
                        </div>
                        <p class="font-semibold text-lg">Cemas</p>
                        <p class="text-sm text-green-100 opacity-75 mt-1">Tarik napas dan rilek</p>
                    </div>                    
                    <div onclick="selectMood('lelah')" 
                         data-tooltip="Klik untuk melihat makanan yang mengembalikan energi"
                         class="mood-card glass-effect cursor-pointer text-white p-6 rounded-xl hover:scale-105 transition duration-300 backdrop-blur-sm text-center progressive-load animate-child">
                        <div class="mood-icon-wrapper">
                            <i class="fas fa-tired mood-icon-large text-purple-300 text-3xl mb-2"></i>
                        </div>
                        <p class="font-semibold text-lg">Lelah</p>
                        <p class="text-sm text-green-100 opacity-75 mt-1">Kembalikan energi</p>
                    </div>
                    <div onclick="selectMood('stress')" 
                         data-tooltip="Klik untuk melihat makanan yang mengembalikan energi"
                         class="mood-card glass-effect cursor-pointer text-white p-6 rounded-xl hover:scale-105 transition duration-300 backdrop-blur-sm text-center progressive-load animate-child">
                        <div class="mood-icon-wrapper">
                            <i class="fas fa-tired mood-icon-large text-purple-300 text-3xl mb-2"></i>
                        </div>
                        <p class="font-semibold text-lg">Stress</p>
                        <p class="text-sm text-green-100 opacity-75 mt-1">Tenangkan Pikiran</p>
                    </div>
                </div>
                  <div class="flex justify-center gap-4">
                    <button onclick="scrollToSection('recommendations')" class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300 hover-scale">
                        <i class="fas fa-utensils mr-2"></i>Lihat Rekomendasi
                    </button>
                    <button onclick="scrollToSection('categories')" class="glass-effect text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:bg-opacity-20 transition duration-300">
                        <i class="fas fa-list mr-2"></i>Jelajahi Kategori
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Current Mood Summary -->
    <section class="py-8 bg-white">
        <div class="container mx-auto">
            <div id="mood-summary" class="mood-summary rounded-2xl p-6 hidden">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center gap-4 mb-4 md:mb-0">
                        <div id="current-mood-icon" class="text-4xl"></div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Mood Kamu Saat Ini</h3>
                            <p id="current-mood-text" class="text-gray-600"></p>
                        </div>
                    </div>
                    <div class="recommendation-stats text-white px-6 py-3 rounded-full">
                        <span id="recommendation-count" class="font-bold">0</span> Rekomendasi Tersedia
                    </div>
                </div>
            </div>
        </div>
    </section>    <!-- Food Categories Filter -->
    <section id="categories" class="py-16 bg-gradient-to-br from-green-50 to-emerald-50">
        <div class="container mx-auto">
            <div class="text-center mb-12 slide-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-filter text-green-600 mr-3"></i>
                    Filter Berdasarkan Kategori
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Pilih kategori makanan untuk mendapatkan rekomendasi yang lebih spesifik sesuai preferensi kamu.
                </p>
            </div>
            
            <div class="category-filter rounded-2xl p-6 mb-8">
                <div class="flex flex-wrap justify-center gap-3">
                    <button onclick="filterByCategory('all')" 
                            class="category-btn active bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition duration-300">
                        <i class="fas fa-globe mr-2"></i>Semua
                    </button>
                    <button onclick="filterByCategory('sarapan')" 
                            class="category-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-coffee mr-2"></i>Sarapan
                    </button>
                    <button onclick="filterByCategory('makan-siang')" 
                            class="category-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-hamburger mr-2"></i>Makan Siang
                    </button>
                    <button onclick="filterByCategory('makan-malam')" 
                            class="category-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-moon mr-2"></i>Makan Malam
                    </button>
                    <button onclick="filterByCategory('snack')" 
                            class="category-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-cookie mr-2"></i>Snack
                    </button>
                    <button onclick="filterByCategory('minuman')" 
                            class="category-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-glass-water mr-2"></i>Minuman
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Food Recommendations Grid -->
    <section id="recommendations" class="py-16 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12 slide-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-star text-yellow-500 mr-3"></i>
                    Rekomendasi untuk Kamu
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Berikut adalah makanan yang dipersonalisasi berdasarkan mood dan preferensi kamu.
                </p>
            </div>
            
            <!-- Loading State -->
            <div id="loading-recommendations" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                <p class="mt-4 text-gray-600">Memuat rekomendasi...</p>
            </div>
              <!-- Recommendations Grid -->
            <div id="recommendations-grid" class="recommendation-grid hidden">
                <!-- Recommendations will be populated here by JavaScript -->
            </div>
            
            <!-- Food Details Display Section (Education Style) -->
            <div id="food-details" class="hidden bg-white rounded-2xl p-8 shadow-2xl max-w-4xl mx-auto mt-8">
                <div id="food-content">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            
            <!-- Empty State -->
            <div id="empty-recommendations" class="text-center py-12 hidden">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Rekomendasi</h3>
                <p class="text-gray-500 mb-6">Pilih mood kamu terlebih dahulu untuk mendapatkan rekomendasi makanan yang tepat.</p>
                <button onclick="scrollToSection('mood-selector')" class="bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition duration-300">
                    <i class="fas fa-arrow-up mr-2"></i>Pilih Mood
                </button>
            </div>
        </div>
    </section>

    <!-- Nutrition Tips Section -->
    <section class="py-16 bg-gradient-to-br from-green-50 to-blue-50">
        <div class="container mx-auto">
            <div class="text-center mb-12 slide-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
                    Tips Nutrisi Berdasarkan Mood
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Panduan cepat untuk memahami nutrisi yang dibutuhkan sesuai dengan kondisi mood kamu.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Bahagia Tips -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-smile text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Bahagia</h3>
                        <p class="text-gray-600 text-sm mb-4">Pertahankan mood positif dengan:</p>
                        <div class="space-y-2 text-left">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Makanan kaya antioksidan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Buah-buahan segar</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Protein seimbang</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sedih Tips -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-sad-tear text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Sedih</h3>
                        <p class="text-gray-600 text-sm mb-4">Tingkatkan serotonin dengan:</p>
                        <div class="space-y-2 text-left">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Triptofan (pisang, kalkun)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Omega-3 (ikan, kacang)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Karbohidrat kompleks</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cemas Tips -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-dizzy text-orange-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Cemas</h3>
                        <p class="text-gray-600 text-sm mb-4">Tenangkan diri dengan:</p>
                        <div class="space-y-2 text-left">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Magnesium (sayuran hijau)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Vitamin B complex</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Teh herbal (chamomile)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Lelah Tips -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tired text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Lelah</h3>
                        <p class="text-gray-600 text-sm mb-4">Kembalikan energi dengan:</p>
                        <div class="space-y-2 text-left">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Zat besi (daging, bayam)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Vitamin B12</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <span class="text-sm text-gray-700">Protein berkualitas tinggi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <!-- Floating Action Button -->
    {{-- <a href="#" onclick="showMoodSelector()" class="floating-action-btn" title="Ganti Mood">
        <i class="fas fa-heart text-xl"></i>
    </a> --}}

    @include('components.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Rekomendasi page specific JavaScript -->
    <script src="{{ asset('js/rekomendasi.js') }}"></script>
</body>
</html>