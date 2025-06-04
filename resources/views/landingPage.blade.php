<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Food</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/landing-page.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="font-['Inter'] bg-gradient-to-br from-gray-50 via-white to-green-50 overflow-x-hidden">
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden" style="background-image: url('{{ asset('assets/image/image.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <!-- Overlay with gradient -->
        <div class="absolute inset-0 bg-gradient-hero opacity-95"></div>
        
        <!-- Animated background elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: -2s;"></div>
            <div class="absolute bottom-40 left-20 w-12 h-12 bg-white/10 rounded-full animate-float" style="animation-delay: -4s;"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 bg-white/10 rounded-full animate-float" style="animation-delay: -1s;"></div>
        </div>

        <!-- Navbar -->
        @include('components.navbar')
        
        <div class="container mx-auto px-6 relative z-10" data-aos="fade-up" data-aos-duration="1000">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 hero-text leading-tight">
                    <span class="block" data-aos="fade-up" data-aos-delay="200">Mood Kamu,</span>
                    <span class="block text-yellow-300" data-aos="fade-up" data-aos-delay="400">Menu Kamu</span>
                </h1>
                <p class="text-xl md:text-2xl lg:text-3xl text-white/90 mb-8 font-light max-w-3xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="600">
                    Simpel dan catchy. Menekankan personalisasi saran makanan untuk meningkatkan suasana hati Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center" data-aos="fade-up" data-aos-delay="800">
                    <a href="{{ url('/mood-food') }}" class="group inline-flex items-center px-8 py-4 bg-white text-green-600 font-semibold rounded-full hover:bg-yellow-300 hover:text-green-700 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <span>Coba MoodFood Pro</span>
                        <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="#about" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-green-600 transition-all duration-300 transform hover:scale-105">
                        <span>Pelajari Lebih Lanjut</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce" data-aos="fade-up" data-aos-delay="1000">
            <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
<section class="py-20 lg:py-32 bg-white relative overflow-hidden" id="about">
    <!-- Background decorative elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-green-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Judul Section -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-800 mb-6">
                Tentang <span class="text-gradient">MoodFood</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Apakah kamu pernah merasa ingin makan cokelat saat sedang sedih? Atau ingin makanan pedas saat stres? Itu bukan kebetulan.
            </p>
        </div>

        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="w-full lg:w-1/2" data-aos="fade-right" data-aos-duration="800">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-3xl transform rotate-6 opacity-20"></div>
                    <img src="{{ asset('assets/image/about.png') }}" alt="Avocado" class="relative rounded-3xl shadow-2xl transition duration-500 ease-in-out transform hover:scale-105 hover:rotate-2">
                </div>
            </div>
            <div class="w-full lg:w-1/2 space-y-8" data-aos="fade-left" data-aos-duration="800">
                <h3 class="text-3xl md:text-5xl font-bold text-gray-800 leading-tight">
                    Makan tidak hanya soal <span class="text-gradient">Kenyang</span>, tapi juga tentang merasa lebih baik, lebih tenang, dan lebih <span class="text-gradient">Bahagia</span>.
                </h3>
                <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                    <p>Food Mood adalah konsep yang menghubungkan apa yang kamu makan dengan suasana hatimu. Berbagai penelitian menunjukkan bahwa makanan memiliki peran besar dalam mengatur hormon seperti serotonin, dopamin, dan kortisol—yang semuanya memengaruhi perasaanmu setiap hari.</p>
                </div>
                <div class="bg-gradient-to-r from-green-50 to-blue-50 p-6 rounded-2xl border border-green-100">
                    <p class="text-gray-700 font-semibold mb-4 text-lg">Apa yang bisa kamu lakukan di sini?</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <!-- Item -->
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                          <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                          </div>
                        </div>
                        <span class="text-gray-700 font-medium">Pilih mood kamu secara manual</span>
                      </div>
                  
                      <!-- Item -->
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                          <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                          </div>
                        </div>
                        <span class="text-gray-700 font-medium">Dapatkan rekomendasi makanan alami & olahan</span>
                      </div>
                  
                      <!-- Item -->
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                          <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                          </div>
                        </div>
                        <span class="text-gray-700 font-medium">Pelajari manfaat gizi yang mendukung keseimbangan emosi</span>
                      </div>
                  
                      <!-- Item -->
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                          <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                          </div>
                        </div>
                        <span class="text-gray-700 font-medium">Berikan feedback dan bantu kami jadi lebih baik</span>
                      </div>
                    </div>
                  </div>
                  
            </div>
        </div>
    </div>
</section>


    <!-- Keunggulan Sistem -->
<section class="py-20 lg:py-32 bg-gradient-to-br from-gray-50 via-blue-50 to-green-50 relative overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(34, 197, 94, 0.3) 1px, transparent 0); background-size: 50px 50px;"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-6xl font-bold text-gray-800 mb-6">
                Keunggulan Sistem <span class="text-gradient">MoodFood</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                Teknologi canggih yang memahami emosi dan memberikan solusi nutrisi terpersonalisasi
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-3xl p-8 lg:p-10 text-center card-hover shadow-xl border border-gray-100 relative overflow-hidden">
                    <!-- Background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400/5 to-blue-400/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="{{ asset('assets/image/fitur1.png') }}" alt="Personalisasi Mood" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-4">Personalisasi Berdasarkan Mood</h3>
                        <p class="text-gray-600 leading-relaxed">Sistem AI kami mampu memberikan rekomendasi makanan sesuai suasana hati kamu, mulai dari senang, sedih, hingga stres dengan akurasi tinggi.</p>
                    </div>
                </div>
            </div>
            
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-3xl p-8 lg:p-10 text-center card-hover shadow-xl border border-gray-100 relative overflow-hidden">
                    <!-- Background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/5 to-purple-400/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="{{ asset('assets/image/fitur2.png') }}" alt="Edukasi Gizi" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-4">Edukasi Gizi dan Hormon</h3>
                        <p class="text-gray-600 leading-relaxed">Dapatkan wawasan mendalam tentang bagaimana makanan memengaruhi hormon seperti serotonin, dopamin, dan kortisol dalam tubuh Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-3xl p-8 lg:p-10 text-center card-hover shadow-xl border border-gray-100 relative overflow-hidden">
                    <!-- Background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400/5 to-pink-400/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="{{ asset('assets/image/fitur3.png') }}" alt="Akses Mudah" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-4">Akses Mudah dan Interaktif</h3>
                        <p class="text-gray-600 leading-relaxed">Antarmuka yang intuitif dan responsif memungkinkan kamu memilih mood, melihat rekomendasi, dan memberi feedback dengan mudah di semua perangkat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Rekomendasi Makanan Section -->
<section class="py-20 lg:py-32 bg-white relative overflow-hidden" id="rekomendasi">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-yellow-200 to-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-green-200 to-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow" style="animation-delay: -2s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <!-- Gambar ilustratif -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1" data-aos="fade-right" data-aos-duration="800">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-3xl transform -rotate-6 opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-3xl transform rotate-3 opacity-10"></div>
                    <img src="{{ asset('assets/image/rekomendasi.png') }}" alt="Ilustrasi Rekomendasi Makanan" class="relative rounded-3xl shadow-2xl w-full transition duration-500 ease-in-out transform hover:scale-105 hover:-rotate-2">
                </div>
            </div>

            <!-- Konten teks -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2" data-aos="fade-left" data-aos-duration="800">
                <h2 class="text-4xl md:text-6xl font-bold text-gray-800 mb-8 leading-tight">
                    Food <span class="text-gradient">Mood</span>
                </h2>
                <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed">
                    Hadir sebagai teman pintar yang membantumu memilih makanan sesuai dengan mood-mu saat ini. Cukup pilih suasana hati yang kamu rasakan, dan kami akan memberikan saran bahan makanan, makanan olahan, hingga kandungan gizi yang bermanfaat untuk menyeimbangkan emosi dan menjaga kesehatan mentalmu.
                </p>
                <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed">
                    Yuk, jelajahi dan temukan makanan yang bisa mengangkat suasana hatimu hari ini!</p>
                {{-- <div class="space-y-6 mb-10">
                    <div class="flex items-start group" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Bahan Makanan Alami</h4>
                            <p class="text-gray-600">Daftar bahan makanan segar seperti pisang, semangka, alpukat, dan bahan alami lainnya yang terbukti meningkatkan mood.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start group" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Makanan Olahan Sehat</h4>
                            <p class="text-gray-600">Contoh resep makanan olahan seperti smoothie nutrisi, salad segar, atau sup hangat yang mudah dibuat di rumah.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start group" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Informasi Gizi & Manfaat</h4>
                            <p class="text-gray-600">Penjelasan ilmiah tentang manfaat gizi dan bagaimana makanan tersebut dapat mempengaruhi keseimbangan emosi kamu.</p>
                        </div>
                    </div>
                </div> --}}
                <a href="/rekomendasi" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-full hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl" data-aos="fade-up" data-aos-delay="400">
                    <span>Yuk, Jelajahi Sekarang!</span>
                    <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Edukasi Singkat Section -->
<section class="py-20 lg:py-32 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden" id="edukasi">
    <!-- Background decorative elements -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-60 animate-float"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-60 animate-float" style="animation-delay: -3s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <!-- Konten edukatif -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1" data-aos="fade-right" data-aos-duration="800">
                <h2 class="text-4xl md:text-6xl font-bold text-gray-800 mb-8 leading-tight">
                    Edukasi Singkat: <span class="text-gradient">Mood & Makanan</span>
                </h2>
                <p class="text-lg md:text-xl text-gray-700 mb-8 leading-relaxed">
                    Tahukah kamu bahwa apa yang kamu makan bisa berdampak langsung pada suasana hati dan kesehatan mental?
                </p>
                
                <div class="space-y-6 mb-10">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Mengapa makanan bisa memengaruhi mood?</h4>
                                <p class="text-gray-600">Makanan mengandung nutrisi yang dapat mempengaruhi produksi neurotransmitter di otak, yang berperan dalam regulasi suasana hati.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Peran Hormon <strong>Serotonin</strong> dan <strong>Dopamin</strong></h4>
                                <p class="text-gray-600">Kedua hormon ini berperan penting dalam regulasi emosi. Makanan tertentu dapat meningkatkan produksi hormon kebahagiaan ini secara alami.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Tabel Interaktif: Mood → Zat Gizi → Makanan</h4>
                                <p class="text-gray-600">Sistem kami menyediakan panduan lengkap yang menghubungkan suasana hati dengan nutrisi yang dibutuhkan dan makanan yang mendukung.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="/edukasi" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-full hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl" data-aos="fade-up" data-aos-delay="400">
                    <span>Pelajari Lebih Lanjut</span>
                    <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Gambar edukasi -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2" data-aos="fade-left" data-aos-duration="800">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-3xl transform rotate-6 opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-500 rounded-3xl transform -rotate-3 opacity-10"></div>
                    <img src="{{ asset('assets/image/education.png') }}" alt="Ilustrasi Edukasi Mood dan Makanan" class="relative rounded-3xl shadow-2xl w-full transition duration-500 ease-in-out transform hover:scale-105 hover:rotate-2">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="reviews" class="py-20 lg:py-32 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-blue-200 to-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-gradient-to-br from-purple-200 to-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow" style="animation-delay: -2s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-6xl font-bold text-gray-800 mb-6">
                Apa Kata <span class="text-gradient">Mereka</span>?
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Pengguna MoodFood merasa lebih bahagia, sehat, dan puas setelah mencoba rekomendasi makanan dari kami.
            </p>
        </div>
        
        <div id="reviews-container" class="grid gap-8 sm:grid-cols-1 lg:grid-cols-3 max-w-7xl mx-auto">
            <!-- Reviews will be dynamically inserted here -->
        </div>
        
        <div id="no-reviews" class="text-center text-gray-600 hidden">
            Belum ada ulasan. Jadilah yang pertama memberikan feedback!
        </div>
    </div>
</section>  

    <!-- Feedback Form Section -->
<section class="py-20 bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 relative overflow-hidden" id="feedback">
    <!-- Background decorative elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-gradient-to-br from-green-400 to-blue-400 rounded-full opacity-20 animate-float"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full opacity-20 animate-float" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-20 left-20 w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full opacity-20 animate-float" style="animation-delay: -1s;"></div>
        <div class="absolute bottom-40 right-10 w-12 h-12 bg-gradient-to-br from-pink-400 to-green-400 rounded-full opacity-20 animate-float" style="animation-delay: -3s;"></div>
        
        <!-- Pattern overlay -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(34, 197, 94, 0.3) 1px, transparent 0); background-size: 30px 30px;"></div>
        </div>
    </div>
    
    <div class="container mx-auto max-w-4xl px-6 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-full mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gradient mb-4">Tinggalkan Feedback</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Masukan kamu sangat berarti untuk kami. Bantu kami agar bisa menjadi lebih baik!
            </p>
        </div>
        
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 p-8 md:p-12 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <!-- Card background gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/50 to-gray-50/50 rounded-3xl"></div>
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
             @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Mohon periksa input berikut:</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            <form action="{{ route('feedback.store') }}" method="POST" class="space-y-8 relative z-10" id="feedback-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group" data-aos="fade-right" data-aos-delay="300">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-green-600 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama Lengkap
                            </span>
                        </label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}"
                            class="w-full rounded-2xl border-2 {{ $errors->has('name') ? 'border-red-300 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-green-400 focus:ring-green-100' }} focus:ring-4 px-6 py-4 shadow-sm transition-all duration-300 bg-white/80 backdrop-blur-sm placeholder-gray-400 text-lg"
                            placeholder="Masukkan nama lengkap Anda">
                    </div>
                    <div class="group" data-aos="fade-left" data-aos-delay="400">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-green-600 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Address
                            </span>
                        </label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}"
                            class="w-full rounded-2xl border-2 {{ $errors->has('email') ? 'border-red-300 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-green-400 focus:ring-green-100' }} focus:ring-4 px-6 py-4 shadow-sm transition-all duration-300 bg-white/80 backdrop-blur-sm placeholder-gray-400 text-lg"
                            placeholder="contoh@email.com">
                    </div>
                </div>

                <div class="group" data-aos="fade-up" data-aos-delay="500">
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-green-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Pesan / Saran
                        </span>
                    </label>
                    <textarea name="message" id="message" rows="6" required
                        class="w-full rounded-2xl border-2 {{ $errors->has('message') ? 'border-red-300 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-green-400 focus:ring-green-100' }} focus:ring-4 px-6 py-4 shadow-sm resize-none transition-all duration-300 bg-white/80 backdrop-blur-sm placeholder-gray-400 text-lg"
                        placeholder="Ceritakan pengalaman Anda dengan MoodFood atau berikan saran untuk perbaikan...">{{ old('message') }}</textarea>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                    <button type="submit" id="submit-btn"
                        class="group inline-flex items-center px-10 py-4 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-bold text-lg rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span class="submit-text">Kirim Feedback</span>
                        <svg class="ml-3 w-5 h-5 transform group-hover:translate-x-1 transition-transform submit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <div class="loading-spinner hidden ml-3">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <p class="mt-4 text-gray-500 text-sm">
                        Dengan mengirim feedback, Anda membantu kami memberikan layanan yang lebih baik untuk semua pengguna MoodFood.
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Contact alternatives -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="700">
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Email Support</h4>
                <p class="text-gray-600 text-sm">support@moodfood.com</p>
            </div>
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Twitter</h4>
                <p class="text-gray-600 text-sm">@MoodFoodApp</p>
            </div>
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.017 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Instagram</h4>
                <p class="text-gray-600 text-sm">@moodfood.id</p>
            </div>
        </div>
    </div>
</section>
@include('components.footer')

<script src="{{ asset('js/landing-page.js') }}"></script>
<script>
    // Session-based notifications
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof showNotification === 'function') {
                    showNotification('{{ session('success') }}', 'success');
                }
                
                // If refresh_reviews session exists, reload review cards
                @if (session('refresh_reviews'))
                    setTimeout(() => {
                        if (typeof loadReviewCards === 'function') {
                            console.log('Refreshing review cards after new feedback...');
                            // Clear existing reviews
                            const reviewsContainer = document.getElementById('reviews-container');
                            if (reviewsContainer) {
                                reviewsContainer.innerHTML = '';
                            }
                            // Reload reviews
                            loadReviewCards();
                        }
                    }, 1000);
                @endif
            }, 500);
        });
    @endif
    
    @if (session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof showNotification === 'function') {
                    showNotification('{{ session('error') }}', 'error');
                }
            }, 500);
        });
    @endif
    
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof showNotification === 'function') {
                    showNotification('Mohon periksa kembali form yang Anda isi', 'warning');
                }
            }, 500);
        });
    @endif
    </script>
</body>
</html>