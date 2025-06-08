// Detailed recipes data for each mood with complete nutritional information
console.log('detailed-recipes.js: Script loaded');

const detailedRecipes = {
    sedih: {
        color: 'blue',
        recipes: [
            {
                name: 'Bolu Pisang Kukus',
                nutrition: {
                    energi: 1567,
                    protein: 27,
                    lemak: 66,
                    karbohidrat: 226
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
                ]
            },
            {
                name: 'Kue Talam Ubi',
                nutrition: {
                    energi: 1329,
                    protein: 14,
                    lemak: 71,
                    karbohidrat: 171
                },
                ingredients: [
                    'Bahan A:',
                    '250 gr ubi jalar kukus, haluskan',
                    '200 ml santan encer',
                    '2 sdm tepung tapioca / singkong / maizena',
                    '2 sdm gula kelapa / aren (gula pasir jika tidak ada)',
                    'Sejumput garam',
                    'Bahan B:',
                    '150 ml santan kental',
                    '1 sdm tepung beras',
                    '½ sdm tepung maizena / tapioca',
                    'Sejumput garam'
                ],
                steps: [
                    'Lapisan Ubi (Bawah):',
                    'Campur semua bahan A dalam wadah, aduk hingga licin.',
                    'Tuang ke dalam cetakan talam kecil (atau loyang kecil).',
                    'Kukus selama ±15 menit hingga setengah matang.',
                    'Lapisan Putih (Atas):',
                    'Campur semua bahan B, aduk rata.',
                    'Tuang perlahan di atas lapisan ubi yang sudah dikukus.',
                    'Kukus kembali ±15 menit hingga kedua lapisan matang.',
                    'Dinginkan, lalu sajikan. Bisa disimpan di kulkas dan disantap dingin.'
                ]
            }
        ]
    },
    marah: {
        color: 'red',
        recipes: [
            {
                name: 'Banana-Choco Bites',
                nutrition: {
                    energi: 438,
                    protein: 8,
                    lemak: 32,
                    karbohidrat: 31
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
                ]
            }
        ]
    },
    cemas: {
        color: 'orange',
        recipes: [
            {
                name: 'Smoothie Alpukat-Pisang',
                nutrition: {
                    energi: 824,
                    protein: 10,
                    lemak: 71,
                    karbohidrat: 42
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
                ]
            },
            {
                name: 'Ubi Jalar Kukus dengan Kayu Manis',
                nutrition: {
                    energi: 351,
                    protein: 6,
                    lemak: 8.3,
                    karbohidrat: 66
                },
                ingredients: [
                    '2 buah ubi jalar ukuran sedang, kupas dan potong-potong',
                    '1 sdm mentega (opsional)',
                    '½ sdt bubuk kayu manis'
                ],
                steps: [
                    'Kukus potongan ubi jalar hingga empuk (sekitar 15-20 menit).',
                    'Letakkan ubi kukus di piring saji.',
                    'Olesi dengan mentega, lalu taburi dengan bubuk kayu manis.'
                ]
            }
        ]
    },
    bahagia: {
        color: 'yellow',
        recipes: [
            {
                name: 'Banana-Choco Bites',
                nutrition: {
                    energi: 438,
                    protein: 8,
                    lemak: 32,
                    karbohidrat: 31
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
                ]
            },
            {
                name: 'Avocado Yoghurt Toast Cup',
                nutrition: {
                    energi: 277,
                    protein: 6,
                    lemak: 12,
                    karbohidrat: 38
                },
                ingredients: [
                    '4 sdm oat (diblender halus)',
                    '1 sdm madu',
                    '2 sdm yogurt',
                    '¼ buah alpukat (haluskan)',
                    'Sedikit air lemon atau jeruk nipis'
                ],
                steps: [
                    'Campur oat dan madu, bentuk jadi "cup" di loyang muffin mini.',
                    'Panggang 180°C selama 15 menit hingga agak keras.',
                    'Campurkan alpukat, yogurt, dan perasan lemon.',
                    'Isi ke dalam oat cup.',
                    'Sajikan dingin atau suhu ruang.'
                ]
            }
        ]
    },
    lelah: {
        color: 'purple',
        recipes: [
            {
                name: 'Oat Pisang Almond',
                nutrition: {
                    energi: 492,
                    protein: 16,
                    lemak: 18,
                    karbohidrat: 70
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
                ]
            },
            {
                name: 'Telur Orak Arik Bayam dengan Roti',
                nutrition: {
                    energi: 360,
                    protein: 17,
                    lemak: 25,
                    karbohidrat: 17
                },
                ingredients: [
                    '2 butir telur ayam',
                    '1 genggam bayam segar, cuci bersih',
                    '1 sdm minyak zaitun (bisa pakai minyak kelapa atau sayur)',
                    '1 iris roti tawar atau gandum',
                    'Garam dan lada secukupnya'
                ],
                steps: [
                    'Panaskan minyak di wajan.',
                    'Tumis bayam sebentar hingga layu (±1 menit).',
                    'Kocok telur, tambahkan garam & lada, lalu tuang ke wajan.',
                    'Aduk pelan hingga matang (orak-arik).',
                    'Sajikan bersama roti gandum yang telah dipanggang ringan.'
                ]
            }
        ]
    },
    stress: {
        color: 'red',
        recipes: [
            {
                name: 'Homemade Granola Bar',
                nutrition: {
                    energi: 1452,
                    protein: 37,
                    lemak: 79,
                    karbohidrat: 154
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
                ]
            }
        ]
    }
};

// Nutritional data for ingredients per 100g
const nutritionIngredients = {
    sedih: [
        { name: 'Tempe', energi: 199.1, protein: 19, lemak: 7.7, karbohidrat: 17 },
        { name: 'Pisang', energi: 92, protein: 1, lemak: 0.5, karbohidrat: 23.4 },
        { name: 'Ikan mujair', energi: 83.9, protein: 18.2, lemak: 0.7, karbohidrat: 0 },
        { name: 'Daun kelor', energi: 60, protein: 5.3, lemak: 0.9, karbohidrat: 11.2 },
        { name: 'Ubi jalar', energi: 102.1, protein: 2.1, lemak: 0.1, karbohidrat: 24.3 },
        { name: 'Jambu biji', energi: 50.9, protein: 0.8, lemak: 0.6, karbohidrat: 11.9 }
    ],
    marah: [
        { name: 'Pisang', energi: 92, protein: 1, lemak: 0.5, karbohidrat: 23.4 },
        { name: 'Coklat hitam / dark chocolate', energi: 590, protein: 10, lemak: 55, karbohidrat: 14 },
        { name: 'Teh hijau (per 1 cangkir)', energi: 2, protein: 0, lemak: 0, karbohidrat: 0.3 },
        { name: 'Yoghurt', energi: 65, protein: 3.3, lemak: 3.8, karbohidrat: 4 },
        { name: 'Madu', energi: 304, protein: 0.3, lemak: 0, karbohidrat: 82.4 },
        { name: 'Alpukat', energi: 217, protein: 1.9, lemak: 23.5, karbohidrat: 0.4 }
    ],
    cemas: [
        { name: 'Ubi jalar', energi: 102.1, protein: 2.1, lemak: 0.1, karbohidrat: 24.3 },
        { name: 'Telur ayam', energi: 155, protein: 12.6, lemak: 10.6, karbohidrat: 1 },
        { name: 'Teh hijau (per 1 cangkir)', energi: 2, protein: 0, lemak: 0, karbohidrat: 0.3 },
        { name: 'Kacang-kacangan', energi: '340-450', protein: '18-36', lemak: '20-40', karbohidrat: '20-60' },
        { name: 'Pisang', energi: 92, protein: 1, lemak: 0.5, karbohidrat: 23.4 },
        { name: 'Alpukat', energi: 217, protein: 1.9, lemak: 23.5, karbohidrat: 0.4 }
    ],
    bahagia: [
        { name: 'Coklat hitam / dark chocolate', energi: 590, protein: 10, lemak: 55, karbohidrat: 14 },
        { name: 'Yoghurt', energi: 65, protein: 3.3, lemak: 3.8, karbohidrat: 4 },
        { name: 'Madu', energi: 304, protein: 0.3, lemak: 0, karbohidrat: 82.4 },
        { name: 'Oat', energi: 370, protein: 12.5, lemak: 7, karbohidrat: 63 },
        { name: 'Pisang', energi: 92, protein: 1, lemak: 0.5, karbohidrat: 23.4 },
        { name: 'Alpukat', energi: 217, protein: 1.9, lemak: 23.5, karbohidrat: 0.4 }
    ],
    lelah: [
        { name: 'Telur ayam', energi: 155, protein: 12.6, lemak: 10.6, karbohidrat: 1 },
        { name: 'Almond', energi: 570, protein: 18, lemak: 53, karbohidrat: 4 },
        { name: 'Dada ayam', energi: 164, protein: 31, lemak: 3.5, karbohidrat: 0 },
        { name: 'Oat', energi: 370, protein: 12.5, lemak: 7, karbohidrat: 63 },
        { name: 'Pisang', energi: 92, protein: 1, lemak: 0.5, karbohidrat: 23.4 },
        { name: 'Bayam', energi: 37, protein: 3.7, lemak: 0.2, karbohidrat: 7.3 }
    ],
    stress: [
        { name: 'Coklat hitam / dark chocolate', energi: 590, protein: 10, lemak: 55, karbohidrat: 14 },
        { name: 'Yoghurt', energi: 65, protein: 3.3, lemak: 3.8, karbohidrat: 4 },
        { name: 'Madu', energi: 304, protein: 0.3, lemak: 0, karbohidrat: 82.4 },
        { name: 'Oat', energi: 370, protein: 12.5, lemak: 7, karbohidrat: 63 },
        { name: 'Pisang', energi: 92, protein: 1, lemak: 0.5, karbohidrat: 23.4 },
        { name: 'Kacang-kacangan', energi: '340-450', protein: '18-36', lemak: '20-40', karbohidrat: '20-60' }
    ]
};

// Function to show recipes for selected mood
function showRecipes(mood) {
    console.log('showRecipes called with mood:', mood);
    
    try {
        // Set the current mood globally
        window.currentMood = mood;
        
        // Check if mood data exists
        if (!detailedRecipes[mood]) {
            console.error('No recipe data found for mood:', mood);
            return;
        }
        
        // Update active tab
        document.querySelectorAll('.recipe-tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('bg-blue-600', 'bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-purple-600');
            btn.classList.remove('text-white');
        });
        
        const activeBtn = document.querySelector(`button[onclick="showRecipes('${mood}')"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
            const colorClass = `bg-${detailedRecipes[mood].color}-600`;
            activeBtn.classList.add(colorClass, 'text-white');
        }
        
        // Check if target element exists
        const recipeContentElement = document.getElementById('recipe-content');
        if (!recipeContentElement) {
            console.error('recipe-content element not found');
            return;
        }
        
        // Show recipes content
        const content = generateRecipeContent(mood);
        recipeContentElement.innerHTML = content;
        console.log('Recipe content updated successfully');
        
        // Smooth scroll to recipes section
        setTimeout(() => {
            const recipesSection = document.querySelector('.recipe-content');
            if (recipesSection) {
                recipesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
        
    } catch (error) {
        console.error('Error in showRecipes function:', error);
    }
}

// Function to generate recipe content HTML
function generateRecipeContent(mood) {
    const moodData = detailedRecipes[mood];
    const ingredients = nutritionIngredients[mood];
    
    let html = `
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Resep untuk Mood ${mood.charAt(0).toUpperCase() + mood.slice(1)}
            </h3>
            
            <!-- Ingredient Nutrition Table -->
            <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-table text-${moodData.color}-600 mr-2"></i>
                    Tabel Kandungan Gizi Bahan Makanan (per 100 gr)
                </h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-${moodData.color}-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Bahan Makanan</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Energi (kkal)</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Protein (gr)</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Lemak (gr)</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Karbohidrat (gr)</th>
                            </tr>
                        </thead>
                        <tbody>`;
    
    ingredients.forEach((ingredient, index) => {
        html += `
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 text-center">${index + 1}</td>
                                <td class="border border-gray-300 px-4 py-2">${ingredient.name}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.energi}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.protein}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.lemak}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.karbohidrat}</td>
                            </tr>`;
    });
    
    html += `
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recipes Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">`;
    
    moodData.recipes.forEach((recipe, index) => {
        html += generateRecipeCard(recipe, moodData.color, index);
    });
    
    html += `
            </div>
        </div>`;
    
    return html;
}

// Function to generate individual recipe card
function generateRecipeCard(recipe, color, index) {
    return `
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-${color}-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-utensils text-${color}-600 text-xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800">${recipe.name}</h4>
                </div>
                
                <!-- Nutrition Summary -->
                <div class="bg-${color}-50 rounded-xl p-4 mb-6">
                    <h5 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-chart-pie text-${color}-600 mr-2"></i>
                        Kandungan Gizi Total
                    </h5>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Energi:</span>
                            <span class="font-semibold">${recipe.nutrition.energi} kkal</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Protein:</span>
                            <span class="font-semibold">${recipe.nutrition.protein} gr</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lemak:</span>
                            <span class="font-semibold">${recipe.nutrition.lemak} gr</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Karbohidrat:</span>
                            <span class="font-semibold">${recipe.nutrition.karbohidrat} gr</span>
                        </div>
                    </div>
                </div>
                
                <!-- Ingredients -->
                <div class="mb-6">
                    <h5 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-list-ul text-${color}-600 mr-2"></i>
                        Bahan-bahan
                    </h5>
                    <ul class="space-y-2">
                        ${recipe.ingredients.map(ingredient => `
                            <li class="flex items-start gap-2 text-sm text-gray-700">
                                <i class="fas fa-circle text-${color}-400 text-xs mt-2 flex-shrink-0"></i>
                                <span class="leading-relaxed">${ingredient}</span>
                            </li>
                        `).join('')}
                    </ul>
                </div>
                
                <!-- Steps -->
                <div>
                    <h5 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-list-ol text-${color}-600 mr-2"></i>
                        Cara Membuat
                    </h5>
                    <ol class="space-y-3">
                        ${recipe.steps.map((step, stepIndex) => `
                            <li class="flex items-start gap-3 text-sm text-gray-700">
                                <span class="bg-${color}-100 text-${color}-700 w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5">
                                    ${stepIndex + 1}
                                </span>
                                <span class="leading-relaxed">${step}</span>
                            </li>
                        `).join('')}
                    </ol>
                </div>
            </div>
        </div>`;
}

// Backup function with fixed colors to test if dynamic colors are the issue
function generateRecipeContentWithFixedColors(mood) {
    const moodData = detailedRecipes[mood];
    const ingredients = nutritionIngredients[mood];
    
    if (!moodData || !ingredients) {
        console.error('Missing data for mood:', mood);
        return '<div class="text-center py-8"><p class="text-gray-500">Data tidak tersedia untuk mood ini.</p></div>';
    }
    
    let html = `
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Resep untuk Mood ${mood.charAt(0).toUpperCase() + mood.slice(1)}
            </h3>
            
            <!-- Ingredient Nutrition Table -->
            <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-table text-green-600 mr-2"></i>
                    Tabel Kandungan Gizi Bahan Makanan (per 100 gr)
                </h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-green-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Bahan Makanan</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Energi (kkal)</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Protein (gr)</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Lemak (gr)</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Karbohidrat (gr)</th>
                            </tr>
                        </thead>
                        <tbody>`;
    
    ingredients.forEach((ingredient, index) => {
        html += `
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 text-center">${index + 1}</td>
                                <td class="border border-gray-300 px-4 py-2">${ingredient.name}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.energi}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.protein}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.lemak}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.karbohidrat}</td>
                            </tr>`;
    });
    
    html += `
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recipes Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">`;
    
    moodData.recipes.forEach((recipe, index) => {
        html += generateRecipeCardWithFixedColors(recipe, index);
    });
    
    html += `
            </div>
        </div>`;
    
    return html;
}

// Function to generate individual recipe card with fixed colors
function generateRecipeCardWithFixedColors(recipe, index) {
    return `
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-utensils text-green-600 text-xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800">${recipe.name}</h4>
                </div>
                
                <!-- Nutrition Summary -->
                <div class="bg-green-50 rounded-xl p-4 mb-6">
                    <h5 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                        Kandungan Gizi Total
                    </h5>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Energi:</span>
                            <span class="font-semibold">${recipe.nutrition.energi} kkal</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Protein:</span>
                            <span class="font-semibold">${recipe.nutrition.protein} gr</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lemak:</span>
                            <span class="font-semibold">${recipe.nutrition.lemak} gr</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Karbohidrat:</span>
                            <span class="font-semibold">${recipe.nutrition.karbohidrat} gr</span>
                        </div>
                    </div>
                </div>
                
                <!-- Ingredients -->
                <div class="mb-6">
                    <h5 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-list-ul text-green-600 mr-2"></i>
                        Bahan-bahan
                    </h5>
                    <ul class="space-y-2">
                        ${recipe.ingredients.map(ingredient => `
                            <li class="flex items-start gap-2 text-sm text-gray-700">
                                <i class="fas fa-circle text-green-400 text-xs mt-2 flex-shrink-0"></i>
                                <span class="leading-relaxed">${ingredient}</span>
                            </li>
                        `).join('')}
                    </ul>
                </div>
                
                <!-- Steps -->
                <div>
                    <h5 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-list-ol text-green-600 mr-2"></i>
                        Cara Membuat
                    </h5>
                    <ol class="space-y-3">
                        ${recipe.steps.map((step, stepIndex) => `
                            <li class="flex items-start gap-3 text-sm text-gray-700">
                                <span class="bg-green-100 text-green-700 w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5">
                                    ${stepIndex + 1}
                                </span>
                                <span class="leading-relaxed">${step}</span>
                            </li>
                        `).join('')}
                    </ol>
                </div>
            </div>
        </div>`;
}

// Make data and functions available globally
window.detailedRecipes = detailedRecipes;
window.nutritionIngredients = nutritionIngredients;
window.generateRecipeContent = generateRecipeContent;
window.generateRecipeCard = generateRecipeCard;
window.generateRecipeContentWithFixedColors = generateRecipeContentWithFixedColors;
window.generateRecipeCardWithFixedColors = generateRecipeCardWithFixedColors;

// Make showRecipes function available globally
window.showRecipes = showRecipes;

// Initialize with default mood if needed
document.addEventListener('DOMContentLoaded', function() {
    console.log('detailed-recipes.js: DOM Content Loaded');
    console.log('detailed-recipes.js: showRecipes function defined:', typeof showRecipes);
    console.log('detailed-recipes.js: window.showRecipes assigned:', typeof window.showRecipes);
    
    // Auto-show recipes if a mood is already selected
    if (window.currentMood && detailedRecipes[window.currentMood]) {
        console.log('detailed-recipes.js: Auto-showing recipes for mood:', window.currentMood);
        showRecipes(window.currentMood);
    }
});
