// Recommendations page specific JavaScript with education.js patterns
let currentMood = '';
let currentCategory = 'all';
let foodRecommendations = [];

// Sample food recommendations data
const recommendationsData = {
    bahagia: [
        {
            id: 1,
            name: 'Banana-Choco Bites',
            category: 'snack',
            image: 'banana-choco-bites.jpg',
            time: '45 menit',
            difficulty: 'Mudah',
            benefits: ['Serotonin', 'Antioksidan', 'Energi'],
            nutrition: {
                calories: 220,
                protein: 6,
                carbs: 25,
                fat: 12
            },
            description: 'Snack sehat pisang dengan cokelat hitam yang dapat meningkatkan mood dan memberikan energi berkelanjutan.',
            ingredients: ['Pisang', 'Cokelat hitam', 'Kacang almond', 'Yoghurt']
        },
        {
            id: 2,
            name: 'Avocado Yoghurt Toast Cup',
            category: 'sarapan',
            image: 'avocado-toast-cup.jpg',
            time: '20 menit',
            difficulty: 'Sedang',
            benefits: ['Lemak Sehat', 'Probiotik', 'Protein'],
            nutrition: {
                calories: 280,
                protein: 8,
                carbs: 35,
                fat: 12
            },
            description: 'Toast cup kreatif dengan alpukat dan yogurt yang kaya probiotik untuk mood positif.',
            ingredients: ['Oat', 'Madu', 'Yogurt', 'Alpukat', 'Lemon']
        }
    ],
    sedih: [
        {
            id: 3,
            name: 'Bolu Pisang Kukus',
            category: 'sarapan',
            image: 'bolu-pisang.jpg',
            time: '30 menit',
            difficulty: 'Mudah',
            benefits: ['Serotonin', 'Kalium', 'Energi Alami'],
            nutrition: {
                calories: 320,
                protein: 12,
                carbs: 58,
                fat: 8
            },
            description: 'Kue lembut berbahan pisang yang kaya kalium dan dapat meningkatkan mood dengan rasa manis alami.',
            ingredients: ['Pisang matang', 'Telur', 'Tepung terigu', 'Gula', 'Minyak kelapa']
        },
        {
            id: 4,
            name: 'Kue Talam Ubi',
            category: 'snack',
            image: 'kue-talam-ubi.jpg',
            time: '45 menit',
            difficulty: 'Sedang',
            benefits: ['Beta-karoten', 'Serat', 'Vitamin A'],
            nutrition: {
                calories: 280,
                protein: 8,
                carbs: 35,
                fat: 12
            },
            description: 'Kue tradisional dengan ubi jalar yang kaya antioksidan dan dapat memberikan kenyamanan emosional.',
            ingredients: ['Ubi jalar', 'Santan', 'Tepung tapioka', 'Gula aren', 'Garam']
        }
    ],
    cemas: [
        {
            id: 5,
            name: 'Smoothie Alpukat-Pisang',
            category: 'minuman',
            image: 'avocado-banana-smoothie.jpg',
            time: '5 menit',
            difficulty: 'Mudah',
            benefits: ['Magnesium', 'Kalium', 'Lemak Sehat'],
            nutrition: {
                calories: 280,
                protein: 6,
                carbs: 35,
                fat: 15
            },
            description: 'Smoothie creamy yang kaya magnesium untuk menenangkan pikiran dan mengurangi kecemasan.',
            ingredients: ['Alpukat matang', 'Pisang', 'Susu almond', 'Madu', 'Es batu']
        },
        {
            id: 6,
            name: 'Ubi Jalar Kukus dengan Kayu Manis',
            category: 'snack',
            image: 'sweet-potato-cinnamon.jpg',
            time: '20 menit',
            difficulty: 'Mudah',
            benefits: ['Beta-karoten', 'Serat', 'Anti-inflamasi'],
            nutrition: {
                calories: 220,
                protein: 4,
                carbs: 45,
                fat: 6
            },
            description: 'Ubi jalar dengan kayu manis yang memiliki efek menenangkan dan membantu stabilisasi gula darah.',
            ingredients: ['Ubi jalar', 'Bubuk kayu manis', 'Mentega', 'Garam']
        }
    ],
    lelah: [
        {
            id: 7,
            name: 'Oat Pisang Almond',
            category: 'sarapan',
            image: 'oat-banana-almond.jpg',
            time: '15 menit',
            difficulty: 'Mudah',
            benefits: ['Karbohidrat Kompleks', 'Protein', 'Magnesium'],
            nutrition: {
                calories: 310,
                protein: 12,
                carbs: 45,
                fat: 8
            },
            description: 'Oatmeal bergizi dengan pisang dan almond untuk mengembalikan energi secara berkelanjutan.',
            ingredients: ['Oat', 'Pisang', 'Kacang almond', 'Susu', 'Madu']
        },
        {
            id: 8,
            name: 'Energy Bowl Quinoa',
            category: 'makan-siang',
            image: 'quinoa-energy-bowl.jpg',
            time: '25 menit',
            difficulty: 'Sedang',
            benefits: ['Protein Lengkap', 'Zat Besi', 'Vitamin B'],
            nutrition: {
                calories: 380,
                protein: 18,
                carbs: 52,
                fat: 12
            },
            description: 'Bowl quinoa dengan sayuran yang kaya protein dan zat besi untuk mengatasi kelelahan.',
            ingredients: ['Quinoa', 'Sayuran hijau', 'Kacang-kacangan', 'Olive oil', 'Lemon']
        }
    ],
    marah: [
        {
            id: 9,
            name: 'Banana-Choco Bites',
            category: 'snack',
            image: 'banana-choco-calm.jpg',
            time: '45 menit',
            difficulty: 'Mudah',
            benefits: ['Magnesium', 'Serotonin', 'Anti-stres'],
            nutrition: {
                calories: 220,
                protein: 6,
                carbs: 25,
                fat: 12
            },
            description: 'Snack menenangkan dengan pisang dan cokelat hitam yang membantu meredakan kemarahan.',
            ingredients: ['Pisang', 'Cokelat hitam', 'Kacang almond', 'Yoghurt']
        },
        {
            id: 10,
            name: 'Herbal Tea Calming Blend',
            category: 'minuman',
            image: 'herbal-tea-calm.jpg',
            time: '10 menit',
            difficulty: 'Mudah',
            benefits: ['Relaksasi', 'Anti-inflamasi', 'Menenangkan'],
            nutrition: {
                calories: 25,
                protein: 0,
                carbs: 6,
                fat: 0
            },
            description: 'Campuran teh herbal yang membantu meredakan emosi dan memberikan ketenangan.',
            ingredients: ['Chamomile', 'Lavender', 'Madu', 'Lemon balm']
        }
    ],
    marah: [
        {
            id: 9,
            name: 'Dark Chocolate Smoothie',
            category: 'snack',
            image: 'dark-chocolate-smoothie.jpg',
            time: '5 menit',
            difficulty: 'Mudah',
            benefits: ['Serotonin', 'Endorfin', 'Magnesium'],
            nutrition: {
                calories: 280,
                protein: 8,
                carbs: 35,
                fat: 12
            },
            description: 'Smoothie coklat hitam yang membantu meredakan amarah dan meningkatkan mood.',
            ingredients: ['Dark chocolate', 'Pisang', 'Yogurt', 'Susu almond', 'Madu']
        },
        {
            id: 10,
            name: 'Teh Hijau dengan Madu',
            category: 'minuman',
            image: 'green-tea-honey.jpg',
            time: '3 menit',
            difficulty: 'Mudah',
            benefits: ['L-theanine', 'Antioksidan', 'Relaksasi'],
            nutrition: {
                calories: 45,
                protein: 0,
                carbs: 12,
                fat: 0
            },
            description: 'Teh hijau dengan L-theanine yang membantu menenangkan pikiran dan mengurangi amarah.',
            ingredients: ['Teh hijau', 'Madu', 'Lemon', 'Mint']
        }
    ],
    stress: [
        {
            id: 11,
            name: 'Granola Bowl dengan Buah',
            category: 'sarapan',
            image: 'granola-bowl.jpg',
            time: '8 menit',
            difficulty: 'Mudah',
            benefits: ['Serat', 'Vitamin C', 'Kompleks B'],
            nutrition: {
                calories: 350,
                protein: 12,
                carbs: 55,
                fat: 14
            },
            description: 'Granola dengan buah-buahan yang kaya vitamin B kompleks untuk mengatasi stress.',
            ingredients: ['Granola', 'Blueberry', 'Strawberry', 'Yogurt', 'Madu']
        },
        {
            id: 12,
            name: 'Sandwich Alpukat Telur',
            category: 'makan-siang',
            image: 'avocado-egg-sandwich.jpg',
            time: '12 menit',
            difficulty: 'Mudah',
            benefits: ['Lemak Sehat', 'Protein', 'Vitamin E'],
            nutrition: {
                calories: 380,
                protein: 18,
                carbs: 28,
                fat: 22
            },
            description: 'Sandwich dengan alpukat dan telur yang kaya lemak sehat untuk mengurangi stress.',
            ingredients: ['Roti gandum', 'Alpukat', 'Telur', 'Tomat', 'Selada']
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
        
        // Hide/show floating button based on scroll direction (only if button exists)
        if (floatingBtn) {
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                floatingBtn.style.transform = 'scale(0)';
            } else {
                floatingBtn.style.transform = 'scale(1)';
            }
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
    console.log('=== MOOD SELECTION DEBUG ===');
    console.log('Selected mood:', mood);
    
    currentMood = mood;
    
    // Check if grid element exists
    const gridElement = document.getElementById('recommendations-grid');
    console.log('Grid element found:', !!gridElement);
    console.log('Grid element classes:', gridElement?.classList.toString());
    
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
    
    // Enhanced grid setup before loading
    if (gridElement) {
        console.log('Preparing grid element...');
        gridElement.style.display = 'grid';
        gridElement.style.gridTemplateColumns = 'repeat(auto-fit, minmax(320px, 1fr))';
        gridElement.style.gap = '1.5rem';
        gridElement.style.width = '100%';
        gridElement.style.maxWidth = '1200px';
        gridElement.style.margin = '0 auto';
    }
    
    loadRecommendations(mood);
    
    // Show and populate the recipe section for the selected mood
    showRecipeSection(mood);
    
    // Smooth scroll with offset
    setTimeout(() => {
        scrollToSection('recommendations');
    }, 500);
    
    console.log('=== END MOOD SELECTION DEBUG ===');
}

// New function to show recipe section with selected mood
function showRecipeSection(mood) {
    console.log('showRecipeSection called with mood:', mood);
    
    const recipeSection = document.getElementById('recipe-tabs-section');
    const currentMoodName = document.getElementById('current-mood-name');
    
    console.log('recipe-tabs-section element:', recipeSection);
    console.log('current-mood-name element:', currentMoodName);
    
    if (recipeSection && currentMoodName) {
        // Update mood name
        const moodNames = {
            'bahagia': 'Bahagia',
            'sedih': 'Sedih', 
            'marah': 'Marah',
            'cemas': 'Cemas',
            'lelah': 'Lelah',
            'stress': 'Stress'
        };
        
        currentMoodName.textContent = moodNames[mood] || mood;
        
        // Show the recipe section
        console.log('Removing hidden class from recipe section...');
        recipeSection.classList.remove('hidden');
        
        // Force display and visibility
        recipeSection.style.display = 'block';
        recipeSection.style.opacity = '1';
        recipeSection.style.visibility = 'visible';
        
        console.log('Recipe section classes after removing hidden:', recipeSection.className);
        console.log('Recipe section style display:', recipeSection.style.display);
        console.log('Recipe section computed style:', window.getComputedStyle(recipeSection).display);
        
        // Wait a bit then check if section is visible
        setTimeout(() => {
            const isVisible = !recipeSection.classList.contains('hidden');
            const computedDisplay = window.getComputedStyle(recipeSection).display;
            console.log('Recipe section is visible:', isVisible);
            console.log('Recipe section computed display:', computedDisplay);
            
            // Force scroll to recipe section if visible
            if (isVisible && computedDisplay !== 'none') {
                setTimeout(() => {
                    recipeSection.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                    console.log('Scrolled to recipe section');
                }, 300);
            }
        }, 100);
        
        // Load recipes for the selected mood
        console.log('Checking showRecipes function availability...');
        console.log('typeof showRecipes:', typeof showRecipes);
        console.log('window.showRecipes:', typeof window.showRecipes);
        
        if (typeof showRecipes === 'function') {
            console.log('Calling showRecipes with mood:', mood);
            showRecipes(mood);
            console.log('showRecipes called successfully');
        } else if (typeof window.showRecipes === 'function') {
            console.log('Calling window.showRecipes with mood:', mood);
            window.showRecipes(mood);
            console.log('window.showRecipes called successfully');
        } else {
            console.error('showRecipes function not found!');
            console.log('Available functions in window:', Object.keys(window).filter(key => typeof window[key] === 'function'));
            
            // Fallback: manually populate recipe content
            console.log('Using fallback recipe content...');
            const recipeContentElement = document.getElementById('recipe-content');
            if (recipeContentElement) {
                // Get mood data if available
                const moodData = window.detailedRecipes?.[mood];
                const nutritionData = window.nutritionIngredients?.[mood];
                
                if (moodData && nutritionData) {
                    console.log('Using available recipe data for fallback');
                    // Use the same generateRecipeContent if available
                    if (typeof window.generateRecipeContent === 'function') {
                        recipeContentElement.innerHTML = window.generateRecipeContent(mood);
                    } else {
                        // Manual fallback with available data
                        let fallbackHTML = `
                            <div class="text-center py-8">
                                <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl p-8 max-w-4xl mx-auto">
                                    <i class="fas fa-utensils text-4xl text-green-600 mb-4"></i>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Resep untuk Mood ${mood.charAt(0).toUpperCase() + mood.slice(1)}</h3>
                                    
                                    <!-- Nutrition Table -->
                                    <div class="bg-white rounded-lg p-6 mb-6">
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
                        
                        nutritionData.forEach((ingredient, index) => {
                            fallbackHTML += `
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="border border-gray-300 px-4 py-2 text-center">${index + 1}</td>
                                                        <td class="border border-gray-300 px-4 py-2">${ingredient.name}</td>
                                                        <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.energi}</td>
                                                        <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.protein}</td>
                                                        <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.lemak}</td>
                                                        <td class="border border-gray-300 px-4 py-2 text-center">${ingredient.karbohidrat}</td>
                                                    </tr>`;
                        });
                        
                        fallbackHTML += `
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <!-- Recipes -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">`;
                        
                        moodData.recipes.forEach((recipe, index) => {
                            fallbackHTML += `
                                        <div class="bg-white rounded-xl shadow-lg p-6">
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
                                        </div>`;
                        });
                        
                        fallbackHTML += `
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        recipeContentElement.innerHTML = fallbackHTML;
                    }
                } else {
                    console.log('Recipe data not available, using simple fallback');
                    recipeContentElement.innerHTML = `
                        <div class="text-center py-8">
                            <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl p-8 max-w-2xl mx-auto">
                                <i class="fas fa-utensils text-4xl text-green-600 mb-4"></i>
                                <h3 class="text-2xl font-bold text-gray-800 mb-4">Resep untuk Mood ${mood.charAt(0).toUpperCase() + mood.slice(1)}</h3>
                                <p class="text-gray-600 mb-6">Resep detail dengan informasi Zat Gizi lengkap sedang dimuat...</p>
                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-800 mb-2">Makanan Rekomendasi:</h4>
                                        <p class="text-gray-600">Daftar makanan yang cocok untuk mood ${mood} Anda telah ditampilkan di atas.</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-800 mb-2">Informasi Zat Gizi:</h4>
                                        <p class="text-gray-600">Setiap makanan dilengkapi dengan informasi kalori, protein, karbohidrat, dan lemak.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                console.log('Fallback content loaded');
            }
        }
    } else {
        console.error('Required elements not found:');
        console.error('recipe-tabs-section:', recipeSection);
        console.error('current-mood-name:', currentMoodName);
    }
}

// Wait for DOM and all scripts to be loaded before making functions available
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    console.log('showRecipes function available:', typeof showRecipes);
    console.log('window.showRecipes available:', typeof window.showRecipes);
    
    // If showRecipes is not available yet, wait a bit more
    if (typeof showRecipes === 'undefined') {
        console.log('showRecipes not found, waiting for scripts to load...');
        
        // Check every 100ms for up to 5 seconds
        let attempts = 0;
        const maxAttempts = 50;
        
        const checkFunction = setInterval(() => {
            attempts++;
            if (typeof showRecipes === 'function') {
                console.log('showRecipes function now available!');
                clearInterval(checkFunction);
            } else if (attempts >= maxAttempts) {
                console.error('showRecipes function still not available after 5 seconds');
                clearInterval(checkFunction);
            }
        }, 100);
    }
});

// Test function to verify recipe section functionality
function testRecipeSection() {
    console.log('=== TESTING RECIPE SECTION ===');
    
    // Test DOM elements
    const recipeSection = document.getElementById('recipe-tabs-section');
    const currentMoodName = document.getElementById('current-mood-name');
    const recipeContent = document.getElementById('recipe-content');
    
    console.log('DOM Elements Check:');
    console.log('- recipe-tabs-section:', recipeSection ? 'Found' : 'Missing');
    console.log('- current-mood-name:', currentMoodName ? 'Found' : 'Missing');
    console.log('- recipe-content:', recipeContent ? 'Found' : 'Missing');
    
    // Test function availability
    console.log('\nFunction Availability Check:');
    console.log('- showRecipes function:', typeof showRecipes);
    console.log('- window.showRecipes:', typeof window.showRecipes);
    
    // Test with bahagia mood
    console.log('\nTesting with mood: bahagia');
    showRecipeSection('bahagia');
    
    setTimeout(() => {
        const isVisible = recipeSection && !recipeSection.classList.contains('hidden');
        console.log('Recipe section visible after test:', isVisible);
        console.log('=== TEST COMPLETE ===');
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
        marah: {
            icon: '😠',
            text: 'Marah - Tenangkan amarah dengan makanan penenang',
            color: 'text-red-500'
        },
        cemas: {
            icon: '😰',
            text: 'Cemas - Tenangkan diri dengan Zat Gizi yang menenangkan',
            color: 'text-orange-500'
        },
        lelah: {
            icon: '😴',
            text: 'Lelah - Kembalikan energi dengan makanan bernutrisi',
            color: 'text-purple-500'
        },
        stress: {
            icon: '🤯',
            text: 'Stress - Redakan ketegangan dengan makanan yang tepat',
            color: 'text-red-500'
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

    // Enhanced debugging for grid visibility
    console.log('Loading recommendations for mood:', mood);
    console.log('Grid element:', gridElement);
    console.log('Grid element classes before:', gridElement?.classList.toString());

    // Show loading
    loadingElement.classList.remove('hidden');
    gridElement.classList.add('hidden');
    emptyElement.classList.add('hidden');

    // Simulate loading delay
    setTimeout(() => {
        const recommendations = recommendationsData[mood] || [];
        foodRecommendations = recommendations;

        console.log('Found recommendations:', recommendations.length);

        if (recommendations.length > 0) {
            renderRecommendations(recommendations);
            loadingElement.classList.add('hidden');
            gridElement.classList.remove('hidden');
            
            // Explicit display and grid setup for better reliability
            gridElement.style.display = 'grid';
            gridElement.style.gridTemplateColumns = 'repeat(auto-fit, minmax(320px, 1fr))';
            gridElement.style.gap = '1.5rem';
            gridElement.style.padding = '0';
            gridElement.style.margin = '0 auto';
            gridElement.style.maxWidth = '1200px';
            
            console.log('Grid element classes after show:', gridElement.classList.toString());
            console.log('Grid element display style:', gridElement.style.display);
            console.log('Grid children count:', gridElement.children.length);
        } else {
            loadingElement.classList.add('hidden');
            emptyElement.classList.remove('hidden');
        }
    }, 1000);
}

// Render recommendations
function renderRecommendations(recommendations) {
    const gridElement = document.getElementById('recommendations-grid');
    
    console.log('Rendering recommendations:', recommendations.length);
    
    // Filter by category if not 'all'
    let filteredRecommendations = recommendations;
    if (currentCategory !== 'all') {
        filteredRecommendations = recommendations.filter(rec => rec.category === currentCategory);
    }

    console.log('Filtered recommendations:', filteredRecommendations.length);

    // Ensure grid element exists and clear it
    if (!gridElement) {
        console.error('Grid element not found!');
        return;
    }

    gridElement.innerHTML = filteredRecommendations.map(rec => `
        <div class="recommendation-card" onclick="showFoodDetail(${rec.id})">
            <div class="relative h-48 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-inner">
                <i class="fas fa-utensils text-3xl text-white opacity-70 drop-shadow-sm"></i>
                <div class="absolute top-4 right-4">
                    <span class="badge time-badge">${rec.time}</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-800 flex-1 pr-2">${rec.name}</h3>
                    <span class="badge difficulty-badge flex-shrink-0">${rec.difficulty}</span>
                </div>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">${rec.description}</p>
                
                <div class="flex flex-wrap gap-2 mb-4">
                    ${rec.benefits.map(benefit => `
                        <span class="badge benefit-badge">${benefit}</span>
                    `).join('')}
                </div>
                
                <div class="grid grid-cols-4 gap-2 text-center text-sm text-gray-600 mb-4">
                    <div class="bg-gray-50 rounded-lg p-2">
                        <div class="font-semibold text-green-600">${rec.nutrition.calories}</div>
                        <div class="text-xs">kcal</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-2">
                        <div class="font-semibold text-blue-600">${rec.nutrition.protein}g</div>
                        <div class="text-xs">protein</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-2">
                        <div class="font-semibold text-yellow-600">${rec.nutrition.carbs}g</div>
                        <div class="text-xs">karbo</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-2">
                        <div class="font-semibold text-orange-600">${rec.nutrition.fat}g</div>
                        <div class="text-xs">lemak</div>
                    </div>
                </div>
                
                <button class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-300 hover:shadow-lg hover:transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-eye mr-2 text-sm"></i>Lihat Detail
                </button>
            </div>
        </div>
    `).join('');
    
    // Add a "View Detailed Recipes" button at the end if we have recommendations
    if (filteredRecommendations.length > 0) {
        gridElement.innerHTML += `
            <div class="col-span-full flex justify-center mt-8 w-full">
                <button onclick="scrollToRecipeSection()" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-full font-semibold hover:from-purple-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-utensils mr-3"></i>Lihat Resep Detail dengan Zat Gizi Lengkap
                    <i class="fas fa-arrow-down ml-3"></i>
                </button>
            </div>
        `;
    }

    console.log('Grid HTML updated, children count:', gridElement.children.length);
    
    // Ensure proper display and add animation
    setTimeout(() => {
        const cards = gridElement.querySelectorAll('.recommendation-card');
        console.log('Found cards after render:', cards.length);
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }, 50);
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

// Helper function to find detailed recipe that matches a food recommendation
function findDetailedRecipeForFood(food, mood) {
    // Check if detailedRecipes is available (from detailed-recipes.js)
    if (typeof detailedRecipes === 'undefined' || !detailedRecipes[mood]) {
        return null;
    }
    
    // Create a mapping between food recommendations and detailed recipes
    const recipeMapping = {
        // Bahagia mood mappings
        'bahagia': {
            'Banana-Choco Bites': 'Banana-Choco Bites',
            'Avocado Yoghurt Toast Cup': 'Avocado Yoghurt Toast Cup'
        },
        // Sedih mood mappings
        'sedih': {
            'Bolu Pisang Kukus': 'Bolu Pisang Kukus',
            'Kue Talam Ubi': 'Kue Talam Ubi'
        },
        // Cemas mood mappings
        'cemas': {
            'Smoothie Alpukat-Pisang': 'Smoothie Alpukat-Pisang',
            'Ubi Jalar Kukus dengan Kayu Manis': 'Ubi Jalar Kukus dengan Kayu Manis'
        },
        // Marah mood mappings
        'marah': {
            'Banana-Choco Bites': 'Banana-Choco Bites',
            'Herbal Tea Calming Blend': 'Banana-Choco Bites' // fallback to available recipe
        },
        // Lelah mood mappings
        'lelah': {
            'Oat Pisang Almond': 'Oat Pisang Almond',
            'Energy Bowl Quinoa': 'Oat Pisang Almond' // fallback to available recipe
        }
    };
    
    // Try to find a matching detailed recipe
    const moodMapping = recipeMapping[mood];
    if (moodMapping && moodMapping[food.name]) {
        const targetRecipeName = moodMapping[food.name];
        const recipes = detailedRecipes[mood]?.recipes || [];
        
        return recipes.find(recipe => recipe.name === targetRecipeName);
    }
    
    // If no specific mapping, try to find a recipe with similar name or ingredients
    const recipes = detailedRecipes[mood]?.recipes || [];
    
    // Look for recipes with similar names (fuzzy matching)
    for (const recipe of recipes) {
        if (recipe.name.toLowerCase().includes(food.name.toLowerCase().split(' ')[0]) ||
            food.name.toLowerCase().includes(recipe.name.toLowerCase().split(' ')[0])) {
            return recipe;
        }
    }
    
    // Look for recipes with similar ingredients
    for (const recipe of recipes) {
        const hasCommonIngredient = food.ingredients.some(foodIngredient => 
            recipe.ingredients.some(recipeIngredient => 
                recipeIngredient.toLowerCase().includes(foodIngredient.toLowerCase()) ||
                foodIngredient.toLowerCase().includes(recipeIngredient.toLowerCase())
            )
        );
        if (hasCommonIngredient) {
            return recipe;
        }
    }
    
    // Return the first recipe as fallback if available
    return recipes.length > 0 ? recipes[0] : null;
}

// Show food detail modal
function showFoodDetail(foodId) {
    const food = foodRecommendations.find(f => f.id === foodId);
    if (!food) return;

    // Try to find a detailed recipe that matches this food recommendation
    const detailedRecipe = findDetailedRecipeForFood(food, currentMood);
    
    const detailsDiv = document.getElementById('food-details');
    const contentDiv = detailsDiv;

    if (detailedRecipe) {
        // Show detailed recipe with comprehensive nutritional data
        contentDiv.innerHTML = `
            <div class="flex justify-between items-start mb-8">
                <div class="text-center">
                    <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-green-600 text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">${detailedRecipe.name}</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">${food.description}</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4 max-w-lg mx-auto">
                        <p class="text-blue-700 text-sm">
                            <i class="fas fa-star text-blue-600 mr-2"></i>
                            Resep lengkap dengan informasi Zat Gizi detail
                        </p>
                    </div>
                </div>
                <button onclick="closeFoodDetail()" class="text-gray-400 hover:text-gray-600 text-2xl bg-gray-100 hover:bg-gray-200 w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="food-details-image mb-8">
                <div class="h-64 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-utensils text-4xl text-white opacity-60"></i>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="food-details-nutrition">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-green-600 mr-2"></i>Informasi Zat Gizi Detail
                    </h3>
                    <div class="nutrition-grid" style="display: grid !important; visibility: visible !important; opacity: 1 !important;">
                        <div class="nutrition-item">
                            <div class="text-2xl font-bold text-green-600">${detailedRecipe.nutrition.energi}</div>
                            <div class="text-sm text-gray-600">Energi (kJ)</div>
                        </div>
                        <div class="nutrition-item">
                            <div class="text-2xl font-bold text-blue-600">${detailedRecipe.nutrition.protein}g</div>
                            <div class="text-sm text-gray-600">Protein</div>
                        </div>
                        <div class="nutrition-item">
                            <div class="text-2xl font-bold text-yellow-600">${detailedRecipe.nutrition.karbohidrat}g</div>
                            <div class="text-sm text-gray-600">Karbohidrat</div>
                        </div>
                        <div class="nutrition-item">
                            <div class="text-2xl font-bold text-red-600">${detailedRecipe.nutrition.lemak}g</div>
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
                    <i class="fas fa-list text-green-600 mr-2"></i>Bahan-bahan Detail
                </h3>
                <div class="ingredients-grid">
                    ${detailedRecipe.ingredients.map(ingredient => `
                        <div class="ingredient-item">
                            <i class="fas fa-check text-green-500 text-sm"></i>
                            <span class="text-gray-700">${ingredient}</span>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <div class="food-details-steps mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clipboard-list text-green-600 mr-2"></i>Langkah Memasak
                </h3>
                <div class="space-y-4">
                    ${detailedRecipe.steps.map((step, index) => `
                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                ${index + 1}
                            </div>
                            <div class="text-gray-700">${step}</div>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <div class="food-details-actions text-center">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="trackFoodRecommendation(${food.id})" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-3 rounded-full font-semibold hover:from-green-700 hover:to-emerald-700 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-bookmark mr-2"></i>Simpan Resep
                    </button>
                    <button onclick="shareFoodRecommendation(${food.id})" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-700 hover:to-blue-800 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-share mr-2"></i>Bagikan Resep
                    </button>
                    <button onclick="closeFoodDetail()" class="bg-gray-500 text-white px-8 py-3 rounded-full hover:bg-gray-600 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                </div>
            </div>
        `;
    } else {
        // Fallback to basic nutrition if no detailed recipe is found
        contentDiv.innerHTML = `
            <div class="flex justify-between items-start mb-8">
                <div class="text-center">
                    <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-green-600 text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">${food.name}</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">${food.description}</p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4 max-w-lg mx-auto">
                        <p class="text-yellow-700 text-sm">
                            <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                            Menampilkan informasi Zat Gizi dasar
                        </p>
                    </div>
                </div>
                <button onclick="closeFoodDetail()" class="text-gray-400 hover:text-gray-600 text-2xl bg-gray-100 hover:bg-gray-200 w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="food-details-image mb-8">
                <div class="h-64 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-utensils text-4xl text-white opacity-60"></i>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="food-details-nutrition">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-green-600 mr-2"></i>Informasi Zat Gizi
                    </h3>
                    <div class="nutrition-grid" style="display: grid !important; visibility: visible !important; opacity: 1 !important;">
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
                <div class="ingredients-grid" style="display: grid !important; visibility: visible !important; opacity: 1 !important;">
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
    }

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

// Scroll to recipe section function
function scrollToRecipeSection() {
    const recipeSection = document.getElementById('recipe-tabs-section');
    if (recipeSection && !recipeSection.classList.contains('hidden')) {
        recipeSection.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        
        // Add a subtle highlight animation
        recipeSection.style.animation = 'pulse 1s ease-in-out';
        setTimeout(() => {
            recipeSection.style.animation = '';
        }, 1000);
    }
}

// Initialize page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize page animations if needed
    console.log('Rekomendasi page loaded successfully');
});

// Test function to verify recipe section functionality
function testRecipeSection() {
    console.log('=== TESTING RECIPE SECTION ===');
    
    // Test DOM elements
    const recipeSection = document.getElementById('recipe-tabs-section');
    const currentMoodName = document.getElementById('current-mood-name');
    const recipeContent = document.getElementById('recipe-content');
    
    console.log('DOM Elements Check:');
    console.log('- recipe-tabs-section:', recipeSection ? 'Found' : 'Missing');
    console.log('- current-mood-name:', currentMoodName ? 'Found' : 'Missing');
    console.log('- recipe-content:', recipeContent ? 'Found' : 'Missing');
    
    // Test function availability
    console.log('\nFunction Availability Check:');
    console.log('- showRecipes function:', typeof showRecipes);
    console.log('- window.showRecipes:', typeof window.showRecipes);
    
    // Test with bahagia mood
    console.log('\nTesting with mood: bahagia');
    showRecipeSection('bahagia');
    
    setTimeout(() => {
        const isVisible = recipeSection && !recipeSection.classList.contains('hidden');
        console.log('Recipe section visible after test:', isVisible);
        console.log('=== TEST COMPLETE ===');
    }, 500);
}

// Test function to verify grid alignment and card display
function testGridAlignment() {
    console.log('=== GRID ALIGNMENT TEST ===');
    
    const gridElement = document.getElementById('recommendations-grid');
    const containerElement = gridElement?.parentElement;
    
    console.log('Grid element:', gridElement);
    console.log('Container element:', containerElement);
    
    if (gridElement) {
        console.log('Grid classes:', gridElement.classList.toString());
        console.log('Grid computed styles:');
        const computedStyle = window.getComputedStyle(gridElement);
        console.log('- display:', computedStyle.display);
        console.log('- grid-template-columns:', computedStyle.gridTemplateColumns);
        console.log('- gap:', computedStyle.gap);
        console.log('- width:', computedStyle.width);
        console.log('- max-width:', computedStyle.maxWidth);
        console.log('- margin:', computedStyle.margin);
        
        console.log('Grid children count:', gridElement.children.length);
        
        // Force grid display and alignment
        gridElement.style.display = 'grid';
        gridElement.style.gridTemplateColumns = 'repeat(auto-fit, minmax(320px, 1fr))';
        gridElement.style.gap = '1.5rem';
        gridElement.style.width = '100%';
        gridElement.style.maxWidth = '1200px';
        gridElement.style.margin = '0 auto';
        gridElement.classList.remove('hidden');
        
        console.log('Grid forced to display with proper styles');
        
        // Test with sample cards
        if (gridElement.children.length === 0) {
            console.log('No cards found, adding test cards...');
            gridElement.innerHTML = `
                <div class="recommendation-card" style="background: white; border-radius: 20px; padding: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <h3>Test Card 1</h3>
                    <p>This is a test card to verify grid alignment.</p>
                </div>
                <div class="recommendation-card" style="background: white; border-radius: 20px; padding: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <h3>Test Card 2</h3>
                    <p>This is another test card.</p>
                </div>
                <div class="recommendation-card" style="background: white; border-radius: 20px; padding: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <h3>Test Card 3</h3>
                    <p>This is a third test card.</p>
                </div>
            `;
            console.log('Test cards added');
        }
        
        // Check card visibility
        const cards = gridElement.querySelectorAll('.recommendation-card');
        console.log('Cards found:', cards.length);
        cards.forEach((card, index) => {
            const cardStyle = window.getComputedStyle(card);
            console.log(`Card ${index + 1}:`, {
                display: cardStyle.display,
                visibility: cardStyle.visibility,
                opacity: cardStyle.opacity,
                width: cardStyle.width,
                height: cardStyle.height
            });
        });
    }
    
    console.log('=== END GRID ALIGNMENT TEST ===');
    return {
        gridElement,
        containerElement,
        hasCards: gridElement?.children.length > 0
    };
}

// Quick test function for mood selection
function testMoodSelection(mood = 'bahagia') {
    console.log(`Testing mood selection: ${mood}`);
    selectMood(mood);
    
    setTimeout(() => {
        testGridAlignment();
    }, 2000);
}

// Global test functions available in browser console
window.testGridAlignment = testGridAlignment;
window.testMoodSelection = testMoodSelection;
window.testRecipeSection = testRecipeSection;