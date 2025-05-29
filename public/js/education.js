// Education Page JavaScript Functions

// Tab functionality with enhanced animations
function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab-content');
    const buttons = document.querySelectorAll('.tab-btn');

    // Hide all tabs with fade effect
    tabs.forEach(tab => {
        tab.style.opacity = '0';
        setTimeout(() => {
            tab.classList.add('hidden');
        }, 150);
    });

    // Reset button styles
    buttons.forEach(btn => {
        btn.classList.remove('bg-green-100', 'text-green-700');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });

    // Show selected tab with fade effect
    setTimeout(() => {
        const selectedTab = document.getElementById(tabId);
        selectedTab.classList.remove('hidden');
        setTimeout(() => {
            selectedTab.style.opacity = '1';
        }, 50);
    }, 150);

    // Update active button
    const activeBtn = [...buttons].find(btn => btn.textContent.toLowerCase().includes(tabId));
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
        activeBtn.classList.add('bg-green-100', 'text-green-700');
    }
}

// Mood details data
const moodData = {
    sedih: {
        icon: 'fas fa-sad-tear',
        color: 'blue',
        title: 'Mengatasi Perasaan Sedih',
        description: 'Ketika merasa sedih, tubuh membutuhkan nutrisi yang dapat meningkatkan produksi serotonin.',
        nutrients: ['Triptofan', 'Omega-3', 'Karbohidrat kompleks'],
        foods: [
            { name: 'Pisang', benefit: 'Kaya triptofan, meningkatkan serotonin' },
            { name: 'Ikan Salmon', benefit: 'Omega-3 untuk kesehatan otak' },
            { name: 'Cokelat Hitam', benefit: 'Melepaskan endorfin alami' },
            { name: 'Oatmeal', benefit: 'Karbohidrat kompleks untuk energi stabil' }
        ],
        tips: 'Hindari gula berlebih yang dapat menyebabkan mood swing. Pilih makanan yang dapat memberikan energi berkelanjutan.'
    },
    cemas: {
        icon: 'fas fa-dizzy',
        color: 'yellow',
        title: 'Menenangkan Kecemasan',
        description: 'Kecemasan dapat dikurangi dengan nutrisi yang menenangkan sistem saraf.',
        nutrients: ['Magnesium', 'Vitamin B kompleks', 'L-theanine'],
        foods: [
            { name: 'Alpukat', benefit: 'Kaya magnesium untuk relaksasi' },
            { name: 'Kacang Almond', benefit: 'Vitamin E dan magnesium' },
            { name: 'Bayam', benefit: 'Folat untuk kesehatan mental' },
            { name: 'Teh Hijau', benefit: 'L-theanine untuk ketenangan' }
        ],
        tips: 'Batasi kafein dan alkohol. Konsumsi makanan secara teratur untuk menjaga gula darah stabil.'
    },
    lelah: {
        icon: 'fas fa-tired',
        color: 'gray',
        title: 'Mengatasi Kelelahan',
        description: 'Kelelahan sering disebabkan oleh kekurangan zat besi atau energi yang tidak stabil.',
        nutrients: ['Zat Besi', 'Vitamin B12', 'Karbohidrat kompleks'],
        foods: [
            { name: 'Daging Merah', benefit: 'Zat besi heme yang mudah diserap' },
            { name: 'Quinoa', benefit: 'Protein lengkap dan energi berkelanjutan' },
            { name: 'Telur', benefit: 'Vitamin B12 dan protein berkualitas' },
            { name: 'Ubi Jalar', benefit: 'Karbohidrat kompleks dan beta-karoten' }
        ],
        tips: 'Pastikan tidur yang cukup dan konsumsi air yang adequate. Hindari crash diet yang dapat menurunkan energi.'
    },
    bahagia: {
        icon: 'fas fa-smile-beam',
        color: 'green',
        title: 'Mempertahankan Kebahagiaan',
        description: 'Untuk mempertahankan mood positif, konsumsi makanan yang mendukung produksi neurotransmitter bahagia.',
        nutrients: ['Tirosin', 'Vitamin D', 'Probiotik'],
        foods: [
            { name: 'Keju', benefit: 'Tirosin untuk produksi dopamin' },
            { name: 'Yogurt', benefit: 'Probiotik untuk gut-brain connection' },
            { name: 'Telur', benefit: 'Kolin untuk fungsi otak optimal' },
            { name: 'Dark Chocolate', benefit: 'Fenilethylamine untuk mood positif' }
        ],
        tips: 'Jaga pola makan seimbang dan tetap aktif. Paparan sinar matahari juga membantu produksi vitamin D.'
    },
    stres: {
        icon: 'fas fa-fire',
        color: 'red',
        title: 'Mengelola Stres',
        description: 'Stres meningkatkan kortisol. Konsumsi antioksidan dan adaptogen untuk membantu tubuh beradaptasi.',
        nutrients: ['Vitamin C', 'Antioksidan', 'Adaptogen'],
        foods: [
            { name: 'Jeruk', benefit: 'Vitamin C untuk menurunkan kortisol' },
            { name: 'Blueberry', benefit: 'Antioksidan untuk melawan stres oksidatif' },
            { name: 'Brokoli', benefit: 'Sulforaphane untuk detoksifikasi' },
            { name: 'Ashwagandha Tea', benefit: 'Adaptogen alami untuk mengelola stres' }
        ],
        tips: 'Praktikkan teknik relaksasi seperti meditasi. Batasi konsumsi kafein yang dapat meningkatkan kortisol.'
    },
    energik: {
        icon: 'fas fa-bolt',
        color: 'orange',
        title: 'Mempertahankan Energi',
        description: 'Untuk mempertahankan energi tinggi, konsumsi makanan yang memberikan energi berkelanjutan.',
        nutrients: ['Protein', 'Vitamin B kompleks', 'CoQ10'],
        foods: [
            { name: 'Kacang-kacangan', benefit: 'Protein dan lemak sehat untuk energi stabil' },
            { name: 'Ikan Tuna', benefit: 'Protein tinggi dan CoQ10' },
            { name: 'Biji Chia', benefit: 'Omega-3 dan serat untuk energi berkelanjutan' },
            { name: 'Green Smoothie', benefit: 'Vitamin dan mineral untuk vitalitas' }
        ],
        tips: 'Makan dalam porsi kecil tapi sering. Tetap terhidrasi dan lakukan olahraga ringan secara teratur.'
    }
};

// Show mood details function
function showMoodDetails(mood) {
    const data = moodData[mood];
    const detailsDiv = document.getElementById('mood-details');
    const contentDiv = document.getElementById('mood-content');
    
    if (data) {
        contentDiv.innerHTML = `
            <div class="text-center mb-8">
                <div class="bg-${data.color}-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="${data.icon} text-${data.color}-600 text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-4">${data.title}</h3>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">${data.description}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-${data.color}-50 rounded-xl p-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-pills text-${data.color}-600 mr-2"></i>
                        Nutrisi yang Dibutuhkan
                    </h4>
                    <div class="space-y-2">
                        ${data.nutrients.map(nutrient => `
                            <span class="bg-${data.color}-200 text-${data.color}-800 px-3 py-1 rounded-full text-sm font-medium inline-block mr-2 mb-2">${nutrient}</span>
                        `).join('')}
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Tips Khusus
                    </h4>
                    <p class="text-gray-700">${data.tips}</p>
                </div>
            </div>
            
            <div class="mt-8">
                <h4 class="text-xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
                    <i class="fas fa-utensils text-green-600 mr-2"></i>
                    Makanan yang Disarankan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    ${data.foods.map(food => `
                        <div class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition duration-300">
                            <h5 class="font-semibold text-gray-800 mb-2">${food.name}</h5>
                            <p class="text-sm text-gray-600">${food.benefit}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <div class="text-center mt-8">
                <button onclick="hideMoodDetails()" class="bg-gray-500 text-white px-6 py-3 rounded-full hover:bg-gray-600 transition duration-300">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        `;
        
        detailsDiv.classList.remove('hidden');
        detailsDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Hide mood details function
function hideMoodDetails() {
    const moodDetails = document.getElementById('mood-details');
    moodDetails.classList.add('hidden');
}

// Smooth scroll functions
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Initialize page animations when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize first tab as active
    showTab('serotonin');
    
    // Add loading animation to elements
    const elements = document.querySelectorAll('.fade-in, .slide-up, .bounce-in');
    elements.forEach((element, index) => {
        element.classList.add('loading');
        setTimeout(() => {
            element.classList.add('loaded');
        }, index * 100);
    });

    // Add scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-up');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
    
    // Observe mood cards and table rows
    const animatedElements = document.querySelectorAll('.mood-card, table tbody tr');
    animatedElements.forEach(el => observer.observe(el));
});

// Scroll animations
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelectorAll('.float');
    
    parallax.forEach(element => {
        const speed = 0.2;
        element.style.transform = `translateY(${scrolled * speed}px)`;
    });
});
