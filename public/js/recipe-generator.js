// Recipe Generation Functions
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
