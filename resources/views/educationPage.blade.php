<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('components.navbar')
<!-- Header Section -->
<section class="py-16 bg-green-100">
    <div class="container mx-auto text-center">
        <h1 class="text-5xl font-bold text-green-700 mb-4">Bagaimana Makanan Mempengaruhi Mood?</h1>
        <p class="text-lg text-gray-700 max-w-3xl mx-auto">Temukan hubungan ilmiah antara makanan, hormon, dan suasana hati kamu.</p>
    </div>
</section>

<!-- Ilustrasi & Penjelasan dengan Tab -->
<section class="py-12 bg-white">
    <div class="container mx-auto flex flex-col md:flex-row items-start gap-10">
        <!-- Ilustrasi -->
        <div class="md:w-1/2">
            <img src="{{ asset('assets/image/foodhormon.png') }}" alt="Ilustrasi Otak dan Makanan" class="rounded-lg shadow-lg w-full">
        </div>

        <!-- Tabs Penjelasan -->
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Peran Hormon dalam Mood</h2>

            <!-- Tabs -->
            <div class="mb-4 flex space-x-2">
                <button onclick="showTab('serotonin')" class="tab-btn bg-green-100 text-green-700 px-4 py-2 rounded font-medium hover:bg-green-200">Serotonin</button>
                <button onclick="showTab('dopamin')" class="tab-btn bg-gray-100 text-gray-700 px-4 py-2 rounded font-medium hover:bg-gray-200">Dopamin</button>
                <button onclick="showTab('kortisol')" class="tab-btn bg-gray-100 text-gray-700 px-4 py-2 rounded font-medium hover:bg-gray-200">Kortisol</button>
            </div>

            <!-- Tab Contents -->
            <div id="serotonin" class="tab-content text-gray-700">
                <p><strong>Serotonin</strong> adalah hormon yang mengatur suasana hati, tidur, dan nafsu makan. Kekurangan serotonin dapat menyebabkan depresi dan gangguan tidur.</p>
            </div>
            <div id="dopamin" class="tab-content hidden text-gray-700">
                <p><strong>Dopamin</strong> berkaitan dengan rasa bahagia, motivasi, dan sistem penghargaan otak. Makanan tinggi tirosin membantu meningkatkan dopamin.</p>
            </div>
            <div id="kortisol" class="tab-content hidden text-gray-700">
                <p><strong>Kortisol</strong> adalah hormon stres yang meningkat saat kamu cemas atau kelelahan. Pola makan sehat dapat membantu menurunkan kadar kortisol.</p>
            </div>
        </div>
    </div>
</section>

<!-- Tabel Interaktif Mood vs Makanan -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Tabel Mood, Zat Gizi, dan Makanan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden text-left">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3">Mood</th>
                        <th class="px-6 py-3">Zat Gizi</th>
                        <th class="px-6 py-3">Contoh Makanan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr class="border-b">
                        <td class="px-6 py-4">Sedih</td>
                        <td class="px-6 py-4">Triptofan, Omega-3</td>
                        <td class="px-6 py-4">Pisang, Ikan salmon, Cokelat hitam</td>
                    </tr>
                    <tr class="border-b bg-gray-100">
                        <td class="px-6 py-4">Cemas</td>
                        <td class="px-6 py-4">Magnesium, Vitamin B</td>
                        <td class="px-6 py-4">Alpukat, Kacang almond, Bayam</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6 py-4">Lelah</td>
                        <td class="px-6 py-4">Zat Besi, Karbohidrat kompleks</td>
                        <td class="px-6 py-4">Oatmeal, Daging merah, Kacang-kacangan</td>
                    </tr>
                    <tr class="border-b bg-gray-100">
                        <td class="px-6 py-4">Bahagia</td>
                        <td class="px-6 py-4">Dopamin booster (Tirosin)</td>
                        <td class="px-6 py-4">Keju, Telur, Yogurt</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">Stres</td>
                        <td class="px-6 py-4">Antioksidan, Vitamin C</td>
                        <td class="px-6 py-4">Jeruk, Berry, Brokoli</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- Tambahkan script di akhir body -->
<script>
    function showTab(tabId) {
        const tabs = document.querySelectorAll('.tab-content');
        const buttons = document.querySelectorAll('.tab-btn');

        tabs.forEach(tab => {
            tab.classList.add('hidden');
        });

        buttons.forEach(btn => {
            btn.classList.remove('bg-green-100', 'text-green-700');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });

        document.getElementById(tabId).classList.remove('hidden');
        const activeBtn = [...buttons].find(btn => btn.textContent.toLowerCase().includes(tabId));
        if (activeBtn) {
            activeBtn.classList.add('bg-green-100', 'text-green-700');
            activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
        }
    }

    // Set default tab
    document.addEventListener('DOMContentLoaded', () => {
        showTab('serotonin');
    });
</script>
</body>
</html>