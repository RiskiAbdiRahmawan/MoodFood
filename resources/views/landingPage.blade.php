<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodDelio - Organic & Fresh</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans bg-gray-50">
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[600px]" style="background-image: url('{{ asset('assets/image/image.jpg') }}');">
        <!-- Navbar -->
    @include('components.navbar')
        <div class="container mx-auto flex py-30 justify-center h-full">
            <div class="text-center">
                <h1 class="text-6xl font-bold text-white mb-4">Mood Kamu, Menu Kamu</h1>
                <p class="text-2xl text-white mb-6">Simpel dan catchy. Menekankan personalisasi saran makanan.</p>
                <button class="bg-transparent border-3 border-white text-white px-6 py-2 rounded-full hover:bg-green-800 hover:text-white">Keep With FoodDelio</button>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto flex items-center">
            <div class="w-1/2">
                <img src= "{{ asset('assets/image/hero.jpg') }}" alt="Avocado" class="rounded-full">
            </div>
            <div class="w-1/2 pl-10">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Makanan Bukan Cuma Soal Lapar, Tapi Juga Perasaan.</h2>
                <p class="text-gray-600 mb-4">Kami percaya bahwa apa yang kamu makan bisa memengaruhi bagaimana kamu merasa. Aplikasi ini hadir untuk membantu kamu memilih makanan berdasarkan suasana hati—baik saat sedang sedih, cemas, marah, bahagia, atau bahkan lelah.</p>
                <p class="text-gray-600 mb-6">Dengan dukungan ilmu gizi dan riset tentang hormon seperti serotonin, dopamin, dan kortisol, kami ingin menjadikan momen makan sebagai cara alami untuk memperbaiki mood kamu.</p>
                <p class="text-gray-600 mb-4">Apa yang bisa kamu lakukan di sini?</p>
                <div class="flex space-x-4">
                    <span class="text-green-600 font-semibold">Pilih mood kamu secara manual</span>
                    <span class="text-green-600 font-semibold">Natural Foods</span>
                    <span class="text-green-600 font-semibold">Naturally Grown</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Natural Market Healthy Food</h2>
            <div class="grid grid-cols-3 gap-8">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <img src="https://via.placeholder.com/200?text=Hazelnuts" alt="Hazelnuts" class="mx-auto mb-4 rounded-full">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Hazelnuts</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <img src="https://via.placeholder.com/200?text=Peanuts" alt="Peanuts" class="mx-auto mb-4 rounded-full">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Peanuts</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <img src="https://via.placeholder.com/200?text=Pumpkin+Seeds" alt="Pumpkin Seeds" class="mx-auto mb-4 rounded-full">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pumpkin Seeds</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Featured Products Latest Arrivals</h2>
            <div class="grid grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl text-green-600">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pick a Starter Option</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl text-green-600">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Shop</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl text-green-600">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">We Deliver Your Joy</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>