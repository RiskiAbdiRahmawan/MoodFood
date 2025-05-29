<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Food</title>
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
                <button class="bg-transparent border-3 border-white text-white px-6 py-2 rounded-full hover:bg-green-800 hover:text-white 
         transition duration-300 ease-in-out transform hover:scale-105">Keep With MoodFood</button>
                <a href="{{ url('/mood-food') }}" class="inline-block bg-transparent border-3 border-white text-white px-6 py-2 rounded-full hover:bg-green-800 hover:text-white">Coba MoodFood Pro</a>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
<section class="py-16 bg-white" id="about">
    <div class="container mx-auto">
        <!-- Judul Section -->
        <div class="text-center mb-12">
            <h2 class="text-5xl font-bold text-gray-800">Tentang MoodFood</h2>
            <p class="text-gray-600 mt-2">Kenali bagaimana makanan bisa memengaruhi suasana hatimu</p>
        </div>

        <div class="flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2 mb-10 md:mb-0">
                <img src="{{ asset('assets/image/about.png') }}" alt="Avocado" class="rounded-full transition duration-300 ease-in-out transform hover:scale-105">
            </div>
            <div class="w-full md:w-1/2 md:pl-10">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Makanan Bukan Cuma Soal Lapar, Tapi Juga Perasaan.</h3>
                <p class="text-gray-600 mb-4">Kami percaya bahwa apa yang kamu makan bisa memengaruhi bagaimana kamu merasa. Aplikasi ini hadir untuk membantu kamu memilih makanan berdasarkan suasana hati—baik saat sedang sedih, cemas, marah, bahagia, atau bahkan lelah.</p>
                <p class="text-gray-600 mb-6">Dengan dukungan ilmu gizi dan riset tentang hormon seperti serotonin, dopamin, dan kortisol, kami ingin menjadikan momen makan sebagai cara alami untuk memperbaiki mood kamu.</p>
                <p class="text-gray-600 mb-4 font-semibold">Apa yang bisa kamu lakukan di sini?</p>
                <div class="flex flex-col space-y-2">
                    <span class="text-green-600 font-semibold">• Pilih mood kamu secara manual</span>
                    <span class="text-green-600 font-semibold">• Dapatkan rekomendasi makanan alami & olahan</span>
                    <span class="text-green-600 font-semibold">• Pelajari manfaat gizi yang mendukung keseimbangan emosi</span>
                    <span class="text-green-600 font-semibold">• Berikan feedback dan bantu kami jadi lebih baik</span>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Keunggulan Sistem -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Keunggulan Sistem MoodFood</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-2xl hover:scale-105 transition transform duration-300">
                <img src="{{ asset('assets/image/fitur1.png') }}" alt="Personalisasi Mood" class="mx-auto mb-4 rounded-full">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Personalisasi Berdasarkan Mood</h3>
                <p class="text-gray-600">Sistem kami mampu memberikan rekomendasi makanan sesuai suasana hati kamu, mulai dari senang, sedih, hingga stres.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-2xl hover:scale-105 transition transform duration-300">
                <img src="{{ asset('assets/image/fitur2.png') }}" alt="Edukasi Gizi" class="mx-auto mb-4 rounded-full">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Edukasi Gizi dan Hormon</h3>
                <p class="text-gray-600">Dapatkan wawasan tentang bagaimana makanan memengaruhi hormon seperti serotonin, dopamin, dan kortisol.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-2xl hover:scale-105 transition transform duration-300">
                <img src="{{ asset('assets/image/fitur3.png') }}" alt="Akses Mudah" class="mx-auto mb-4 rounded-full">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Akses Mudah dan Interaktif</h3>
                <p class="text-gray-600">Antarmuka yang ramah pengguna memungkinkan kamu memilih mood, melihat rekomendasi, dan memberi feedback dengan mudah.</p>
            </div>
        </div>
    </div>
</section>

    <!-- Rekomendasi Makanan Section -->
<section class="py-16 bg-white" id="rekomendasi">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
        <!-- Gambar ilustratif -->
        <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="{{ asset('assets/image/rekomendasi.png') }}" alt="Ilustrasi Rekomendasi Makanan" class="rounded-lg shadow-lg w-full transition duration-300 ease-in-out transform hover:scale-105">
        </div>

        <!-- Konten teks -->
        <div class="md:w-1/2 md:pl-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">Rekomendasi Makanan Sesuai Mood Kamu</h2>
            <p class="text-gray-600 mb-6">
                Setelah kamu memilih mood, kami akan menampilkan:
            </p>
            <ul class="space-y-4 text-gray-700 mb-8">
                <li class="flex items-start">
                    <span class="text-green-500 text-xl mr-2">✔</span>
                    Daftar bahan makanan alami seperti pisang, semangka, dan lainnya.
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 text-xl mr-2">✔</span>
                    Contoh makanan olahan seperti smoothie, salad, atau sup.
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 text-xl mr-2">✔</span>
                    Informasi manfaat gizi dan pengaruhnya terhadap emosi kamu.
                </li>
            </ul>
            <a href="/rekomendasi" class="inline-block bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition duration-300 ease-in-out transform hover:scale-105">
                Lihat Rekomendasi Sekarang
            </a>
        </div>
    </div>
</section>

<!-- Edukasi Singkat Section -->
<section class="py-16 bg-gray-50" id="edukasi">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
        <!-- Konten edukatif -->
        <div class="md:w-1/2 md:pr-12 order-2 md:order-1">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">Edukasi Singkat: Mood & Makanan</h2>
            <p class="text-gray-700 mb-4">Tahukah kamu bahwa apa yang kamu makan bisa berdampak langsung pada suasana hati?</p>
            <ul class="space-y-4 text-gray-700 mb-6">
                <li class="flex items-start">
                    <span class="text-green-500 text-xl mr-2">✔</span>
                    Penjelasan singkat: “Mengapa makanan bisa memengaruhi mood?”
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 text-xl mr-2">✔</span>
                    Peran hormon seperti <strong>serotonin</strong> dan <strong>dopamin</strong> dalam regulasi emosi.
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 text-xl mr-2">✔</span>
                    Tabel interaktif: Mood → Zat Gizi → Makanan yang mendukung.
                </li>
            </ul>
            <a href="/edukasi" class="inline-block bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition duration-300 ease-in-out transform hover:scale-105">
                Pelajari Lebih Lanjut
            </a>
        </div>

        <!-- Gambar edukasi -->
        <div class="md:w-1/2 mb-8 md:mb-0 order-1 md:order-2">
            <img src="{{ asset('assets/image/education.png') }}" alt="Ilustrasi Edukasi Mood dan Makanan" class="rounded-lg shadow-lg w-full transition duration-300 ease-in-out transform hover:scale-105">
        </div>
    </div>
</section>

<!-- Section: Ulasan Pengguna -->
<section id="reviews" class="bg-gray-50 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto text-center">
      <h2 class="text-3xl font-extrabold text-gray-900">Apa Kata Mereka?</h2>
      <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
        Pengguna MoodFood merasa lebih bahagia, sehat, dan puas setelah mencoba rekomendasi makanan dari kami.
      </p>
    </div>
  
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto">
      <!-- Card Ulasan -->
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
        <div class="flex items-center space-x-4">
          <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
          <div>
            <h4 class="text-lg font-semibold text-gray-900">Aulia Rahma</h4>
            <div class="flex text-yellow-400 text-sm">
              ★★★★★
            </div>
          </div>
        </div>
        <p class="mt-4 text-gray-700">
          MoodFood membantu banget pas lagi stres! Rekomendasi makanannya enak dan bikin hati tenang. UI-nya juga cakep!
        </p>
      </div>
  
      <!-- Card Ulasan -->
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
        <div class="flex items-center space-x-4">
          <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
          <div>
            <h4 class="text-lg font-semibold text-gray-900">Rizky Maulana</h4>
            <div class="flex text-yellow-400 text-sm">
              ★★★★☆
            </div>
          </div>
        </div>
        <p class="mt-4 text-gray-700">
          Awalnya ragu, tapi ternyata hasilnya nyata. Sekarang tiap galau langsung buka MoodFood. Rekomendasi makanannya cocok!
        </p>
      </div>
  
      <!-- Card Ulasan -->
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
        <div class="flex items-center space-x-4">
          <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
          <div>
            <h4 class="text-lg font-semibold text-gray-900">Nadya Putri</h4>
          </div>
        </div>
        <p class="mt-4 text-gray-700">
          UI-nya lucu, UX-nya smooth, dan insight makanannya insightful banget. MoodFood bener-bener jadi sahabat baru aku!
        </p>
      </div>
    </div>
  </section>
  

    <!-- Feedback Form Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-white" id="feedback">
    <div class="container mx-auto max-w-2xl px-6">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 text-center mb-4">Tinggalkan Feedback</h2>
            <p class="text-center text-gray-500 mb-10">Masukan kamu sangat berarti untuk kami. Bantu kami agar bisa menjadi lebih baik!</p>
            <form action="" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 px-4 py-2 shadow-sm">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 px-4 py-2 shadow-sm">
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Pesan / Saran</label>
                    <textarea name="message" id="message" rows="5" required
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 px-4 py-3 shadow-sm resize-none"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-200">
                        Kirim Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@include('components.footer')

</body>
</html>