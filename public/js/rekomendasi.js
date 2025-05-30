// Recommendations page specific JavaScript with education.js patterns
let currentMood = '';
let currentCategory = 'all';
let foodRecommendations = [];

// Sample food recommendations data
const recommendationsData = {
    bahagia: [
        {
            id: 1,
            name: 'Smoothie Bowl Buah Naga',
            category: 'sarapan',
            image: 'smoothie-bowl.jpg',
            time: '10 menit',
            difficulty: 'Mudah',
            benefits: ['Antioksidan Tinggi', 'Vitamin C', 'Serat'],
            nutrition: {
                calories: 250,
                protein: 8,
                carbs: 45,
                fat: 6
            },
            description: 'Smoothie bowl yang kaya antioksidan untuk mempertahankan mood positif dan energi sepanjang hari.',
            ingredients: ['Buah naga', 'Pisang', 'Yogurt', 'Granola', 'Madu']
        },
        {
            id: 2,
            name: 'Salmon Panggang dengan Asparagus',
            category: 'makan-malam',
            image: 'salmon-asparagus.jpg',
            time: '25 menit',
            difficulty: 'Sedang',
            benefits: ['Omega-3', 'Protein', 'Vitamin D'],
            nutrition: {
                calories: 380,
                protein: 35,
                carbs: 8,
                fat: 22
            },
            description: 'Kombinasi sempurna omega-3 dan protein untuk mendukung kesehatan otak dan mood stabil.',
            ingredients: ['Salmon fillet', 'Asparagus', 'Lemon', 'Olive oil', 'Herbs']
        }
    ],
    sedih: [
        {
            id: 3,
            name: 'Dark Chocolate Oatmeal',
            category: 'sarapan',
            image: 'chocolate-oatmeal.jpg',
            time: '15 menit',
            difficulty: 'Mudah',
            benefits: ['Serotonin', 'Magnesium', 'Serat'],
            nutrition: {
                calories: 320,
                protein: 12,
                carbs: 58,
                fat: 8
            },
            description: 'Oatmeal dengan dark chocolate yang dapat meningkatkan serotonin dan memperbaiki mood.',
            ingredients: ['Oatmeal', 'Dark chocolate', 'Pisang', 'Almond', 'Madu']
        },
        {
            id: 4,
            name: 'Sup Ayam Kunyit',
            category: 'makan-siang',
            image: 'chicken-turmeric-soup.jpg',
            time: '30 menit',
            difficulty: 'Mudah',
            benefits: ['Anti-inflamasi', 'Protein', 'Vitamin B'],
            nutrition: {
                calories: 280,
                protein: 25,
                carbs: 18,
                fat: 12
            },
            description: 'Sup hangat dengan kunyit yang memiliki sifat anti-inflamasi dan dapat meningkatkan mood.',
            ingredients: ['Ayam', 'Kunyit', 'Jahe', 'Sayuran', 'Kaldu']
        }
    ],
    cemas: [
        {
            id: 5,
            name: 'Teh Chamomile dengan Madu',
            category: 'minuman',
            image: 'chamomile-tea.jpg',
            time: '5 menit',
            difficulty: 'Mudah',
            benefits: ['Relaksasi', 'Anti-cemas', 'Antioksidan'],
            nutrition: {
                calories: 45,
                protein: 0,
                carbs: 12,
                fat: 0
            },
            description: 'Minuman herbal yang membantu menenangkan pikiran dan mengurangi kecemasan.',
            ingredients: ['Teh chamomile', 'Madu', 'Lemon', 'Mint']
        },
        {
            id: 6,
            name: 'Salad Bayam dengan Alpukat',
            category: 'makan-siang',
            image: 'spinach-avocado-salad.jpg',
            time: '10 menit',
            difficulty: 'Mudah',
            benefits: ['Magnesium', 'Folate', 'Lemak Sehat'],
            nutrition: {
                calories: 220,
                protein: 6,
                carbs: 12,
                fat: 18
            },
            description: 'Salad kaya magnesium yang membantu menenangkan sistem saraf dan mengurangi stres.',
            ingredients: ['Bayam', 'Alpukat', 'Kacang almond', 'Olive oil', 'Balsamic']
        }
    ],
    lelah: [
        {
            id: 7,
            name: 'Protein Smoothie Energi',
            category: 'snack',
            image: 'protein-smoothie.jpg',
            time: '5 menit',
            difficulty: 'Mudah',
            benefits: ['Protein', 'Vitamin B12', 'Energi'],
            nutrition: {
                calories: 310,
                protein: 25,
                carbs: 28,
                fat: 12
            },
            description: 'Smoothie berprotein tinggi untuk mengembalikan energi dan stamina.',
            ingredients: ['Protein powder', 'Pisang', 'Susu almond', 'Selai kacang', 'Madu']
        },
        {
            id: 8,
            name: 'Steak Daging Sapi dengan Sayuran',
            category: 'makan-malam',
            image: 'beef-steak-vegetables.jpg',
            time: '35 menit',
            difficulty: 'Sedang',
            benefits: ['Zat Besi', 'Protein', 'Vitamin B12'],
            nutrition: {
                calories: 450,
                protein: 40,
                carbs: 15,
                fat: 26
            },
            description: 'Daging sapi kaya zat besi yang membantu mengatasi kelelahan dan meningkatkan energi.',
            ingredients: ['Beef steak', 'Brokoli', 'Wortel', 'Kentang', 'Herbs']
        }
    ]
};

// Initialize recommendations page with education.js patterns
document.addEventListener('DOMContentLoaded', function() {
    initializeRecommendationsPage();
    initializeIntersectionObserver();
    initializeAnimations();
    initializeParallaxEffects();
    initializeAdvancedInteractions();
    showEmptyState();
    
    // Add loading animation to elements like education.js
    const elements = document.querySelectorAll('.fade-in, .slide-up, .bounce-in');
    elements.forEach((element, index) => {
        element.classList.add('loading');
        setTimeout(() => {
            element.classList.add('loaded');
        }, index * 100);
    });
    
    // Add stagger classes to mood cards
    const moodCards = document.querySelectorAll('.mood-card');
    moodCards.forEach((card, index) => {
        card.classList.add(`stagger-${Math.min(index + 1, 5)}`);
        card.classList.add('bounce-in');
    });
});

// Initialize page like education.js
function initializeRecommendationsPage() {
    // Add event listeners for smooth interactions
    addGlobalEventListeners();
    
    // Initialize mood card animations
    initializeMoodCards();
    
    // Initialize category buttons
    initializeCategoryButtons();
    
    // Set up parallax and scroll effects
    initializeScrollEffects();
}

// Intersection Observer for animations like education.js
function initializeIntersectionObserver() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Stagger animation for grid items
                if (entry.target.classList.contains('recommendation-card')) {
                    const delay = Array.from(entry.target.parentNode.children).indexOf(entry.target) * 100;
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, delay);
                }
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.fade-in-up, .scale-in').forEach((el) => {
        observer.observe(el);
    });
}

// Initialize animations like education.js
function initializeAnimations() {
    // Add stagger animation classes to elements
    const animateElements = document.querySelectorAll('.slide-up');
    animateElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });
}

// Initialize mood cards with hover effects
function initializeMoodCards() {
    const moodCards = document.querySelectorAll('.mood-card');
    moodCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Initialize category buttons with enhanced interactions
function initializeCategoryButtons() {
    const categoryButtons = document.querySelectorAll('.category-btn');
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add ripple effect
            addRippleEffect(this, e);
        });
    });
}

// Add ripple effect like education.js
function addRippleEffect(element, event) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    
    // Use event coordinates if provided, otherwise center the ripple
    let x, y;
    if (event) {
        x = event.clientX - rect.left - size / 2;
        y = event.clientY - rect.top - size / 2;
    } else {
        x = rect.width / 2 - size / 2;
        y = rect.height / 2 - size / 2;
    }
    
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('ripple');
    
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Initialize scroll effects like education.js
function initializeScrollEffects() {
    let lastScrollTop = 0;
    const floatingBtn = document.querySelector('.floating-action-btn');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Hide/show floating button based on scroll direction
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            floatingBtn.style.transform = 'scale(0)';
        } else {
            floatingBtn.style.transform = 'scale(1)';
        }
        
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        
        // Parallax effect for hero section
        const heroSection = document.querySelector('.mood-selector');
        if (heroSection) {
            const scrolled = window.pageYOffset;
            const speed = scrolled * 0.5;
            heroSection.style.transform = `translateY(${speed}px)`;
        }
    }, { passive: true });
}

// Initialize parallax effects like education.js
function initializeParallaxEffects() {
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.float, .parallax-bg');
        
        parallaxElements.forEach(element => {
            const speed = element.getAttribute('data-speed') || 0.2;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
        
        // Parallax background for hero section
        const heroBackground = document.querySelector('.hero-background');
        if (heroBackground) {
            heroBackground.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    }, { passive: true });
}

// Initialize advanced interactions like education.js
function initializeAdvancedInteractions() {
    // Progressive loading animations
    const progressiveElements = document.querySelectorAll('.progressive-load');
    progressiveElements.forEach((element, index) => {
        setTimeout(() => {
            element.classList.add('loaded');
        }, index * 150);
    });
    
    // Enhanced hover effects for cards
    const interactiveCards = document.querySelectorAll('.mood-card, .food-card, .recommendation-card');
    interactiveCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
        });
        
        // Add ripple effect on click
        card.addEventListener('click', function(e) {
            addRippleEffect(this, e);
        });
    });
    
    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Initialize tooltips and enhanced interactions
    initializeTooltips();
    initializeEnhancedAnimations();
}

// Initialize tooltips for better UX
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            
            this._tooltip = tooltip;
        });
        
        element.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                this._tooltip = null;
            }
        });
    });
}

// Initialize enhanced animations
function initializeEnhancedAnimations() {
    // Stagger animation for grid items
    const gridItems = document.querySelectorAll('.grid > *');
    gridItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add('fade-in-up');
    });
    
    // Progressive reveal for sections
    const sections = document.querySelectorAll('section');
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-revealed');
                
                // Animate children
                const children = entry.target.querySelectorAll('.animate-child');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('child-revealed');
                    }, index * 100);
                });
            }
        });
    }, { threshold: 0.1 });
    
    sections.forEach(section => sectionObserver.observe(section));
}

// Add global event listeners
function addGlobalEventListeners() {
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFoodDetail();
        }
        
        // Number keys for mood selection
        const moodKeys = {
            '1': 'bahagia',
            '2': 'sedih', 
            '3': 'cemas',
            '4': 'lelah'
        };
        
        if (moodKeys[e.key]) {
            selectMood(moodKeys[e.key]);
        }
    });
    
    // Touch gesture support for mobile
    let touchStartY = 0;
    document.addEventListener('touchstart', e => {
        touchStartY = e.touches[0].clientY;
    }, { passive: true });
    
    document.addEventListener('touchend', e => {
        const touchEndY = e.changedTouches[0].clientY;
        const diff = touchStartY - touchEndY;
        
        if (Math.abs(diff) > 50) {
            // Implement swipe gestures if needed
        }
    }, { passive: true });
}

// Enhanced mood selection with animations
function selectMood(mood) {
    currentMood = mood;
    
    // Add visual feedback to selected mood card
    document.querySelectorAll('.mood-card').forEach(card => {
        card.style.transform = 'translateY(0) scale(1)';
        card.style.opacity = '0.7';
    });
    
    const selectedCard = event?.target?.closest('.mood-card');
    if (selectedCard) {
        selectedCard.style.transform = 'translateY(-10px) scale(1.1)';
        selectedCard.style.opacity = '1';
        
        // Add selection animation
        selectedCard.style.animation = 'pulse 0.6s ease-in-out';
        setTimeout(() => {
            selectedCard.style.animation = '';
        }, 600);
    }
    
    updateMoodSummary(mood);
    loadRecommendations(mood);
    
    // Smooth scroll with offset
    setTimeout(() => {
        scrollToSection('recommendations');
    }, 500);
}

// Update mood summary
function updateMoodSummary(mood) {
    const summaryElement = document.getElementById('mood-summary');
    const iconElement = document.getElementById('current-mood-icon');
    const textElement = document.getElementById('current-mood-text');
    const countElement = document.getElementById('recommendation-count');

    const moodConfig = {
        bahagia: {
            icon: '😊',
            text: 'Bahagia - Pertahankan mood positif kamu!',
            color: 'text-yellow-500'
        },
        sedih: {
            icon: '😢',
            text: 'Sedih - Mari tingkatkan mood dengan makanan yang tepat',
            color: 'text-blue-500'
        },
        cemas: {
            icon: '😰',
            text: 'Cemas - Tenangkan diri dengan nutrisi yang menenangkan',
            color: 'text-orange-500'
        },
        lelah: {
            icon: '😴',
            text: 'Lelah - Kembalikan energi dengan makanan bernutrisi',
            color: 'text-purple-500'
        }
    };

    const config = moodConfig[mood];
    if (config) {
        iconElement.textContent = config.icon;
        iconElement.className = `text-4xl ${config.color}`;
        textElement.textContent = config.text;
        
        const recommendations = recommendationsData[mood] || [];
        countElement.textContent = recommendations.length;
        
        // Animate counter
        animateCounter(countElement, 0, recommendations.length, 1000);
        
        summaryElement.classList.remove('hidden');
        summaryElement.style.animation = 'slideUp 0.5s ease-out';
    }
}

// Animate counter like education.js
function animateCounter(element, start, end, duration) {
    const startTime = performance.now();
    
    function updateCounter(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const current = Math.floor(start + (end - start) * progress);
        
        element.textContent = current;
        
        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        }
    }
    
    requestAnimationFrame(updateCounter);
}

// Load recommendations
function loadRecommendations(mood) {
    const gridElement = document.getElementById('recommendations-grid');
    const loadingElement = document.getElementById('loading-recommendations');
    const emptyElement = document.getElementById('empty-recommendations');

    // Show loading
    loadingElement.classList.remove('hidden');
    gridElement.classList.add('hidden');
    emptyElement.classList.add('hidden');

    // Simulate loading delay
    setTimeout(() => {
        const recommendations = recommendationsData[mood] || [];
        foodRecommendations = recommendations;

        if (recommendations.length > 0) {
            renderRecommendations(recommendations);
            loadingElement.classList.add('hidden');
            gridElement.classList.remove('hidden');
        } else {
            loadingElement.classList.add('hidden');
            emptyElement.classList.remove('hidden');
        }
    }, 1000);
}

// Render recommendations
function renderRecommendations(recommendations) {
    const gridElement = document.getElementById('recommendations-grid');
    
    // Filter by category if not 'all'
    let filteredRecommendations = recommendations;
    if (currentCategory !== 'all') {
        filteredRecommendations = recommendations.filter(rec => rec.category === currentCategory);
    }

    gridElement.innerHTML = filteredRecommendations.map(rec => `
        <div class="recommendation-card bg-white rounded-2xl shadow-lg overflow-hidden" onclick="showFoodDetail(${rec.id})">
            <div class="relative h-48 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                <i class="fas fa-utensils text-6xl text-white opacity-50"></i>
                <div class="absolute top-4 right-4">
                    <span class="badge time-badge">${rec.time}</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-800">${rec.name}</h3>
                    <span class="badge difficulty-badge">${rec.difficulty}</span>
                </div>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">${rec.description}</p>
                
                <div class="flex flex-wrap gap-2 mb-4">
                    ${rec.benefits.map(benefit => `
                        <span class="badge benefit-badge">${benefit}</span>
                    `).join('')}
                </div>
                
                <div class="grid grid-cols-4 gap-2 text-center text-sm text-gray-600 mb-4">
                    <div>
                        <div class="font-semibold">${rec.nutrition.calories}</div>
                        <div class="text-xs">kcal</div>
                    </div>
                    <div>
                        <div class="font-semibold">${rec.nutrition.protein}g</div>
                        <div class="text-xs">protein</div>
                    </div>
                    <div>
                        <div class="font-semibold">${rec.nutrition.carbs}g</div>
                        <div class="text-xs">karbo</div>
                    </div>
                    <div>
                        <div class="font-semibold">${rec.nutrition.fat}g</div>
                        <div class="text-xs">lemak</div>
                    </div>
                </div>
                
                <button class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition duration-300">
                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                </button>
            </div>
        </div>
    `).join('');
}

// Filter by category
function filterByCategory(category) {
    currentCategory = category;
    
    // Update active button
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-green-600', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    event.target.classList.add('active', 'bg-green-600', 'text-white');
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    
    // Re-render recommendations with filter
    if (currentMood && foodRecommendations.length > 0) {
        renderRecommendations(foodRecommendations);
    }
}

// Show food detail modal
function showFoodDetail(foodId) {
    const food = foodRecommendations.find(f => f.id === foodId);
    if (!food) return;

    const detailsDiv = document.getElementById('food-details');
    const contentDiv = detailsDiv;

    contentDiv.innerHTML = `
        <div class="flex justify-between items-start mb-8">
            <div class="text-center">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-utensils text-green-600 text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">${food.name}</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">${food.description}</p>
            </div>
            <button onclick="closeFoodDetail()" class="text-gray-400 hover:text-gray-600 text-2xl bg-gray-100 hover:bg-gray-200 w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="food-details-image mb-8">
            <div class="h-64 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-utensils text-8xl text-white opacity-50"></i>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="food-details-nutrition">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-green-600 mr-2"></i>Informasi Nutrisi
                </h3>
                <div class="nutrition-grid">
                    <div class="nutrition-item">
                        <div class="text-2xl font-bold text-green-600">${food.nutrition.calories}</div>
                        <div class="text-sm text-gray-600">Kalori</div>
                    </div>
                    <div class="nutrition-item">
                        <div class="text-2xl font-bold text-blue-600">${food.nutrition.protein}g</div>
                        <div class="text-sm text-gray-600">Protein</div>
                    </div>
                    <div class="nutrition-item">
                        <div class="text-2xl font-bold text-yellow-600">${food.nutrition.carbs}g</div>
                        <div class="text-sm text-gray-600">Karbohidrat</div>
                    </div>
                    <div class="nutrition-item">
                        <div class="text-2xl font-bold text-red-600">${food.nutrition.fat}g</div>
                        <div class="text-sm text-gray-600">Lemak</div>
                    </div>
                </div>
            </div>
            
            <div class="food-details-benefits">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-heart text-green-600 mr-2"></i>Manfaat untuk Mood
                </h3>
                <div class="space-y-3">
                    ${food.benefits.map(benefit => `
                        <div class="flex items-center gap-2 bg-green-50 p-3 rounded-lg">
                            <i class="fas fa-check text-green-500 text-sm"></i>
                            <span class="text-gray-700">${benefit}</span>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
        
        <div class="food-details-ingredients mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-list text-green-600 mr-2"></i>Bahan-bahan
            </h3>
            <div class="ingredients-grid">
                ${food.ingredients.map(ingredient => `
                    <div class="ingredient-item">
                        <i class="fas fa-check text-green-500 text-sm"></i>
                        <span class="text-gray-700">${ingredient}</span>
                    </div>
                `).join('')}
            </div>
        </div>
        
        <div class="food-details-actions text-center">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="trackFoodRecommendation(${food.id})" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-3 rounded-full font-semibold hover:from-green-700 hover:to-emerald-700 transition duration-300 flex items-center justify-center">
                    <i class="fas fa-bookmark mr-2"></i>Simpan Rekomendasi
                </button>
                <button onclick="shareFoodRecommendation(${food.id})" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-700 hover:to-blue-800 transition duration-300 flex items-center justify-center">
                    <i class="fas fa-share mr-2"></i>Bagikan
                </button>
                <button onclick="closeFoodDetail()" class="bg-gray-500 text-white px-8 py-3 rounded-full hover:bg-gray-600 transition duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>
    `;

    detailsDiv.classList.remove('hidden');
    detailsDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Close food detail expandable section
function closeFoodDetail() {
    const detailsDiv = document.getElementById('food-details');
    detailsDiv.classList.add('hidden');
}

// Track food recommendation
function trackFoodRecommendation(foodId) {
    const food = foodRecommendations.find(f => f.id === foodId);
    if (food) {
        // Save to localStorage or send to server
        const savedRecommendations = JSON.parse(localStorage.getItem('savedRecommendations') || '[]');
        if (!savedRecommendations.find(r => r.id === foodId)) {
            savedRecommendations.push({
                ...food,
                savedAt: new Date().toISOString(),
                mood: currentMood
            });
            localStorage.setItem('savedRecommendations', JSON.stringify(savedRecommendations));
            
            // Show success message
            showNotification('Rekomendasi berhasil disimpan!', 'success');
        } else {
            showNotification('Rekomendasi sudah tersimpan sebelumnya.', 'info');
        }
    }
}

// Share food recommendation
function shareFoodRecommendation(foodId) {
    const food = foodRecommendations.find(f => f.id === foodId);
    if (food && navigator.share) {
        navigator.share({
            title: `MoodFood: ${food.name}`,
            text: `Rekomendasi makanan untuk mood ${currentMood}: ${food.description}`,
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const text = `MoodFood: ${food.name}\n${food.description}\n\nCoba di: ${window.location.href}`;
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Link rekomendasi berhasil disalin!', 'success');
        });
    }
}

// Show empty state
function showEmptyState() {
    document.getElementById('loading-recommendations').classList.add('hidden');
    document.getElementById('recommendations-grid').classList.add('hidden');
    document.getElementById('empty-recommendations').classList.remove('hidden');
}

// Show mood selector (floating action button)
function showMoodSelector() {
    scrollToSection('mood-selector');
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transform translate-x-full transition-transform duration-300`;
    
    switch(type) {
        case 'success':
            notification.classList.add('bg-green-500');
            break;
        case 'error':
            notification.classList.add('bg-red-500');
            break;
        case 'info':
        default:
            notification.classList.add('bg-blue-500');
            break;
    }
    
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Scroll to section function
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId) || document.querySelector(`[class*="${sectionId}"]`);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Initialize page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize page animations if needed
    console.log('Rekomendasi page loaded successfully');
});