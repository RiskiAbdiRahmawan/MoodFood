<!-- Navbar -->
<div class="fixed top-7 left-0 right-0 z-50 bg-transparent px-4 sm:px-6 lg:px-8">
    <nav class="bg-white shadow max-w-screen-lg mx-auto rounded-4xl px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo Kiri -->
            <div class="flex items-center">
                <span class="text-2xl font-bold text-green-600">MoodFood</span>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-6">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-green-600">Home</a>
                <a href="{{ url('/#about') }}" class="text-gray-600 hover:text-green-600">About</a>
                <a href="{{ url('/#rekomendasi') }}" class="text-gray-600 hover:text-green-600">Mood</a>
                <a href="{{ url('/#edukasi') }}" class="text-gray-600 hover:text-green-600">Education</a>
                <a href="{{ url('/#feedback') }}" class="text-gray-600 hover:text-green-600">Feedback</a>
            </div>

            <!-- Gambar Logo Kanan -->
            <div class="hidden md:flex items-center">
                <a href="/">
                    <img src="{{ asset('assets/image/logo.png') }}" alt="Logo MoodFood" class="h-10 w-auto rounded-4xl">
                </a>
            </div>

            <!-- Hamburger Button -->
            <div class="md:hidden">
                <button id="menu-toggle" class="text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 space-y-2">
            <a href="{{ url('/') }}" class="block text-gray-600 hover:text-green-600">Home</a>
            <a href="{{ url('/#about') }}" class="block text-gray-600 hover:text-green-600">About</a>
            <a href="{{ url('/#rekomendasi') }}" class="block text-gray-600 hover:text-green-600">Mood</a>
            <a href="{{ url('/edukasi') }}" class="block text-gray-600 hover:text-green-600">Education</a>
            <a href="{{ url('/#feedback') }}" class="block text-gray-600 hover:text-green-600">Feedback</a>
            <!-- Logo di Mobile -->
            <div class="pt-2">
                <a href="/">
                    <img src="{{ asset('assets/image/logo.png') }}" alt="Logo MoodFood" class="h-10 w-auto mx-auto">
                </a>
            <div class="flex items-center space-x-4">
                <a href="{{ url('/mood-food') }}" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">Try MoodFood Pro</a>
            </div>
        </div>
    </nav>
</div>

<!-- Spacer agar konten tidak tertutup navbar -->
<div class="h-[92px] md:h-[100px]"></div>

<!-- Script Toggle -->
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
