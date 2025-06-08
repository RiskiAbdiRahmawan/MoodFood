<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MoodFood Education - How Food Affects Your Mood</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/education.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-50">
    @include('components.navbar')
    
    <!-- Hero Section with Animated Background -->
    <section class="relative py-20 gradient-bg overflow-hidden">
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
                    Bagaimana Makanan 
                    <span class="text-green-200">Mempengaruhi</span> Mood?
                </h1>
                <p class="text-xl text-green-100 max-w-4xl mx-auto mb-8 leading-relaxed">
                    Temukan hubungan ilmiah antara makanan, hormon, dan suasana hati kamu. 
                    Pelajari cara menggunakan nutrisi untuk meningkatkan kesejahteraan mental.
                </p>
                <div class="flex justify-center gap-4">
                    <button onclick="scrollToSection('science')" class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-green-50 transition duration-300 hover-scale">
                        <i class="fas fa-microscope mr-2"></i>Pelajari Sains
                    </button>
                    <button onclick="scrollToSection('interactive')" class="glass-effect text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:bg-opacity-20 transition duration-300">
                        <i class="fas fa-chart-line mr-2"></i>Lihat Tabel Interaktif
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Science Section with Enhanced Visuals -->
    <section id="science" class="py-16 bg-white">
        <div class="container mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16 slide-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-brain text-green-600 mr-3"></i>
                    Sains di Balik Mood & Makanan
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Otak kita menggunakan neurotransmitter untuk mengatur suasana hati. Makanan yang kita konsumsi 
                    menyediakan bahan baku untuk produksi hormon-hormon penting ini.
                </p>
            </div>
            
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Enhanced Illustration -->
                <div class="lg:w-1/2">
                    <div class="relative bounce-in">
                        <img src="{{ asset('assets/image/foodhormon.png') }}" 
                             alt="Ilustrasi Otak dan Makanan" 
                             class="rounded-2xl shadow-2xl w-full hover-scale">
                        <div class="absolute -top-4 -right-4 bg-green-500 text-white p-3 rounded-full pulse">
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Tabs -->
                <div class="lg:w-1/2">
                    <h3 class="text-3xl font-bold text-gray-800 mb-8">
                        <i class="fas fa-flask text-green-600 mr-2"></i>
                        Peran Hormon dalam Mood
                    </h3>

                    <!-- Modern Tab Navigation -->
                    <div class="mb-8 flex flex-wrap gap-3">
                        <button onclick="showTab('serotonin')" 
                                class="tab-btn bg-green-100 text-green-700 px-6 py-3 rounded-full font-semibold hover:bg-green-200 transition duration-300 flex items-center shadow-md">
                            <i class="fas fa-smile mr-2"></i>Serotonin
                        </button>
                        <button onclick="showTab('dopamin')" 
                                class="tab-btn bg-gray-100 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition duration-300 flex items-center shadow-md">
                            <i class="fas fa-rocket mr-2"></i>Dopamin
                        </button>
                        <button onclick="showTab('kortisol')" 
                                class="tab-btn bg-gray-100 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition duration-300 flex items-center shadow-md">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Kortisol
                        </button>
                    </div>

                    <!-- Enhanced Tab Contents -->
                    <div class="tab-contents">
                        <div id="serotonin" class="tab-content bg-gradient-to-r from-green-50 to-blue-50 p-6 rounded-xl shadow-lg">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-500 p-3 rounded-full text-white">
                                    <i class="fas fa-smile text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-3">Serotonin - Hormon Kebahagiaan</h4>
                                    <p class="text-gray-700 leading-relaxed mb-4">
                                        <strong>Serotonin</strong> adalah hormon yang mengatur suasana hati, tidur, dan nafsu makan. 
                                        Kekurangan serotonin dapat menyebabkan depresi dan gangguan tidur.
                                    </p>
                                    <div class="bg-white p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-info-circle text-green-500 mr-1"></i>
                                            <strong>Tips:</strong> Konsumsi makanan kaya triptofan seperti pisang, kalkun, dan kacang-kacangan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="dopamin" class="tab-content hidden bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl shadow-lg">
                            <div class="flex items-start gap-4">
                                <div class="bg-purple-500 p-3 rounded-full text-white">
                                    <i class="fas fa-rocket text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-3">Dopamin - Hormon Motivasi</h4>
                                    <p class="text-gray-700 leading-relaxed mb-4">
                                        <strong>Dopamin</strong> berkaitan dengan rasa bahagia, motivasi, dan sistem penghargaan otak. 
                                        Makanan tinggi tirosin membantu meningkatkan dopamin.
                                    </p>
                                    <div class="bg-white p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-info-circle text-purple-500 mr-1"></i>
                                            <strong>Tips:</strong> Makanan seperti keju, telur, dan yogurt kaya akan tirosin.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="kortisol" class="tab-content hidden bg-gradient-to-r from-red-50 to-orange-50 p-6 rounded-xl shadow-lg">
                            <div class="flex items-start gap-4">
                                <div class="bg-red-500 p-3 rounded-full text-white">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-3">Kortisol - Hormon Stres</h4>
                                    <p class="text-gray-700 leading-relaxed mb-4">
                                        <strong>Kortisol</strong> adalah hormon stres yang meningkat saat kamu cemas atau kelelahan. 
                                        Pola makan sehat dapat membantu menurunkan kadar kortisol.
                                    </p>
                                    <div class="bg-white p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-info-circle text-red-500 mr-1"></i>
                                            <strong>Tips:</strong> Hindari kafein berlebih dan konsumsi makanan kaya antioksidan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Mood Cards Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-green-50">
        <div class="container mx-auto">
            <div class="text-center mb-16 slide-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-heart text-red-500 mr-3"></i>
                    Mood & Nutrisi yang Tepat
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Klik pada mood di bawah untuk melihat nutrisi dan makanan yang dapat membantu memperbaiki suasana hati kamu.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <!-- Sedih Card -->
                <div onclick="showMoodDetails('sedih')" class="mood-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl cursor-pointer">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-sad-tear text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Sedih</h3>
                        <p class="text-gray-600 text-sm">Butuh serotonin dan omega-3</p>
                    </div>
                </div>
                
                <!-- Cemas Card -->
                <div onclick="showMoodDetails('cemas')" class="mood-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl cursor-pointer">
                    <div class="text-center">
                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-dizzy text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Cemas</h3>
                        <p class="text-gray-600 text-sm">Butuh magnesium dan vitamin B</p>
                    </div>
                </div>
                
                <!-- Lelah Card -->
                <div onclick="showMoodDetails('lelah')" class="mood-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl cursor-pointer">
                    <div class="text-center">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tired text-gray-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Lelah</h3>
                        <p class="text-gray-600 text-sm">Butuh zat besi dan karbohidrat kompleks</p>
                    </div>
                </div>
                
                <!-- Bahagia Card -->
                <div onclick="showMoodDetails('bahagia')" class="mood-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl cursor-pointer">
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-smile-beam text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Bahagia</h3>
                        <p class="text-gray-600 text-sm">Pertahankan dengan tirosin</p>
                    </div>
                </div>
                
                <!-- Stres Card -->
                <div onclick="showMoodDetails('stres')" class="mood-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl cursor-pointer">
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-fire text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Stres</h3>
                        <p class="text-gray-600 text-sm">Butuh antioksidan dan vitamin C</p>
                    </div>
                </div>
                
                <!-- Energik Card -->
                <div onclick="showMoodDetails('energik')" class="mood-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl cursor-pointer">
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bolt text-orange-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Energik</h3>
                        <p class="text-gray-600 text-sm">Pertahankan dengan protein dan B-complex</p>
                    </div>
                </div>
            </div>
            
            <!-- Mood Details Display -->
            <div id="mood-details" class="hidden bg-white rounded-2xl p-8 shadow-2xl max-w-4xl mx-auto">
                <div id="mood-content">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Interactive Table -->
    <section id="interactive" class="py-16 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-16 slide-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-table text-green-600 mr-3"></i>
                    Tabel Mood, Zat Gizi, dan Makanan
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Panduan lengkap hubungan antara suasana hati, nutrisi yang dibutuhkan, dan makanan yang disarankan.
                </p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="gradient-bg text-white">
                            <tr>
                                <th class="px-8 py-6 text-left font-bold text-lg">
                                    <i class="fas fa-heart mr-2"></i>Mood
                                </th>
                                <th class="px-8 py-6 text-left font-bold text-lg">
                                    <i class="fas fa-pills mr-2"></i>Zat Gizi
                                </th>
                                <th class="px-8 py-6 text-left font-bold text-lg">
                                    <i class="fas fa-utensils mr-2"></i>Contoh Makanan
                                </th>
                                <th class="px-8 py-6 text-left font-bold text-lg">
                                    <i class="fas fa-info-circle mr-2"></i>Manfaat
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            <tr class="border-b hover:bg-blue-50 transition duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-sad-tear text-blue-600"></i>
                                        </div>
                                        <span class="font-semibold">Sedih</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-2">Triptofan</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">Omega-3</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">🍌 Pisang</span>
                                        <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded text-sm">🐟 Ikan salmon</span>
                                        <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-sm">🍫 Cokelat hitam</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-600">Meningkatkan produksi serotonin, memperbaiki mood</td>
                            </tr>
                            <tr class="border-b hover:bg-yellow-50 transition duration-300 bg-gray-50">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="bg-yellow-100 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-dizzy text-yellow-600"></i>
                                        </div>
                                        <span class="font-semibold">Cemas</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium mr-2">Magnesium</span>
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Vitamin B</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">🥑 Alpukat</span>
                                        <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-sm">🌰 Kacang almond</span>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">🥬 Bayam</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-600">Menenangkan sistem saraf, mengurangi kecemasan</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50 transition duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-tired text-gray-600"></i>
                                        </div>
                                        <span class="font-semibold">Lelah</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium mr-2">Zat Besi</span>
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">Karbohidrat kompleks</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-sm">🥣 Oatmeal</span>
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">🥩 Daging merah</span>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">🥜 Kacang-kacangan</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-600">Meningkatkan energi, mencegah anemia</td>
                            </tr>
                            <tr class="border-b hover:bg-green-50 transition duration-300 bg-gray-50">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-smile-beam text-green-600"></i>
                                        </div>
                                        <span class="font-semibold">Bahagia</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Tirosin</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">🧀 Keju</span>
                                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-sm">🥚 Telur</span>
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">🥛 Yogurt</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-600">Mempertahankan produksi dopamin, mood positif</td>
                            </tr>
                            <tr class="border-b hover:bg-red-50 transition duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="bg-red-100 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-fire text-red-600"></i>
                                        </div>
                                        <span class="font-semibold">Stres</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium mr-2">Antioksidan</span>
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">Vitamin C</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-sm">🍊 Jeruk</span>
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">🫐 Berry</span>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">🥦 Brokoli</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-600">Menurunkan kortisol, melawan radikal bebas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to Action Section -->
    <section class="py-16 gradient-bg">
        <div class="container mx-auto text-center">
            <div class="fade-in">
                <h2 class="text-4xl font-bold text-white mb-6">
                    Siap Mulai Perjalanan Mood Food kamu?
                </h2>
                <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                    Gunakan pengetahuan ini untuk memilih makanan yang tepat sesuai mood kamu hari ini!
                </p>
                <div class="flex justify-center gap-4">
                    <a href="{{ url('/mood-food-tailwind') }}" class="bg-white text-green-700 px-8 py-4 rounded-full font-semibold hover:bg-green-50 transition duration-300 hover-scale inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>
                        Mulai Mood Selection
                    </a>
                    <button onclick="scrollToTop()" class="glass-effect text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:bg-opacity-20 transition duration-300 inline-flex items-center">
                        <i class="fas fa-arrow-up mr-2"></i>
                        Kembali ke Atas
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Include JavaScript -->
    <script src="{{ asset('js/education.js') }}"></script>
</body>
</html>