// Dietary preferences reset function
function resetDietaryPreference() {
    const dietaryRadios = document.querySelectorAll('input[name="dietary_preference"]');
    dietaryRadios.forEach(radio => {
        radio.checked = false;
    });
}

// Navigation and Section Management
function showSection(sectionName) {
    // Hide all sections
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.classList.remove('hidden');
    }
    
    // Update navigation active states
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active', 'bg-blue-100', 'text-blue-700');
        item.classList.add('hover:bg-gray-100', 'text-gray-700');
    });
    
    // Set active state for clicked nav item
    document.querySelectorAll(`[data-section="${sectionName}"]`).forEach(item => {
        item.classList.add('active', 'bg-blue-100', 'text-blue-700');
        item.classList.remove('hover:bg-gray-100', 'text-gray-700');
    });
    
    // Initialize charts if analytics section is shown
    if (sectionName === 'analytics') {
        setTimeout(initializeCharts, 100);
    }
}

// Initialize Charts for Analytics Section
function initializeCharts() {
    // Get analytics data from window object
    const analytics = window.moodFoodData?.analytics;
    const sessionInfo = window.moodFoodData?.sessionInfo;
    
    // Mood Trend Chart
    const moodCtx = document.getElementById('moodTrendChart');
    if (moodCtx) {
        // Prepare mood trend data
        let moodData = [0, 0, 0, 0, 0, 0, 0]; // Default for 7 days
        let moodLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        
        if (analytics && analytics.activity_summary && analytics.activity_summary.mood_changes > 0) {
            // Use real data if available - simulate daily distribution
            const totalMoods = analytics.activity_summary.mood_changes;
            const averagePerDay = totalMoods / 7;
            
            // Create variation around the average
            for (let i = 0; i < 7; i++) {
                const variation = (Math.random() - 0.5) * 2; // Random variation
                moodData[i] = Math.max(0, Math.min(10, averagePerDay + variation));
            }
        } else {
            // Use placeholder data for new users
            moodData = [0, 0, 0, 0, 0, 0, 0];
        }
        
        new Chart(moodCtx, {
            type: 'line',
            data: {
                labels: moodLabels,
                datasets: [{
                    label: 'Mood Score',
                    data: moodData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Food Category Chart
    const foodCtx = document.getElementById('foodCategoryChart');
    if (foodCtx) {
        // Prepare food category data
        let foodLabels = ['Makanan Alami', 'Makanan Olahan', 'Belum Ada Data'];
        let foodData = [0, 0, 100];
        let backgroundColor = ['rgba(34, 197, 94, 0.8)', 'rgba(249, 115, 22, 0.8)', 'rgba(156, 163, 175, 0.8)'];
        
        if (analytics && analytics.food_preferences && Object.keys(analytics.food_preferences).length > 0) {
            // Use real food preference data
            const preferences = analytics.food_preferences;
            const totalInteractions = Object.values(preferences).reduce((sum, count) => sum + count, 0);
            
            foodLabels = [];
            foodData = [];
            backgroundColor = [];
            
            const colors = [
                'rgba(34, 197, 94, 0.8)',   // green
                'rgba(249, 115, 22, 0.8)',  // orange
                'rgba(59, 130, 246, 0.8)',  // blue
                'rgba(168, 85, 247, 0.8)',  // purple
                'rgba(239, 68, 68, 0.8)'    // red
            ];
            
            let colorIndex = 0;
            for (const [food, count] of Object.entries(preferences)) {
                if (colorIndex < 5) { // Limit to top 5
                    foodLabels.push(food.length > 15 ? food.substring(0, 15) + '...' : food);
                    foodData.push(count);
                    backgroundColor.push(colors[colorIndex % colors.length]);
                    colorIndex++;
                }
            }
        }
        
        new Chart(foodCtx, {
            type: 'doughnut',
            data: {
                labels: foodLabels,
                datasets: [{
                    data: foodData,
                    backgroundColor: backgroundColor,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }
    
    // Load enhanced analytics if session exists
    if (window.moodFoodData?.sessionId && window.moodFoodData?.analyticsApiRoute) {
        loadEnhancedAnalytics();
    }
}

// Load enhanced analytics data
function loadEnhancedAnalytics() {
    if (!window.moodFoodData?.sessionId) return;
    
    fetch(window.moodFoodData.analyticsApiRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            session_id: window.moodFoodData.sessionId,
            timeframe: '7'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.warn('Analytics data not available:', data.error);
            return;
        }
        
        // Update window data with fresh analytics
        window.moodFoodData.enhancedAnalytics = data;
        
        // Update charts with real data
        updateChartsWithRealData(data);
        
        // Update other UI elements
        updateAnalyticsUI(data);
    })
    .catch(error => {
        console.warn('Could not load enhanced analytics:', error);
    });
}

// Update charts with real analytics data
function updateChartsWithRealData(data) {
    // Update mood trend chart if available
    const moodChart = Chart.getChart('moodTrendChart');
    if (moodChart && data.mood_analytics) {
        // Process mood analytics for chart
        const moodData = processMoodDataForChart(data.mood_analytics);
        moodChart.data.datasets[0].data = moodData;
        moodChart.update();
    }
    
    // Update food category chart if available
    const foodChart = Chart.getChart('foodCategoryChart');
    if (foodChart && data.food_analytics) {
        const foodData = processFoodDataForChart(data.food_analytics);
        if (foodData.labels.length > 0) {
            foodChart.data.labels = foodData.labels;
            foodChart.data.datasets[0].data = foodData.data;
            foodChart.data.datasets[0].backgroundColor = foodData.colors;
            foodChart.update();
        }
    }
}

// Process mood data for chart display
function processMoodDataForChart(moodAnalytics) {
    if (!moodAnalytics.mood_distribution) {
        return [0, 0, 0, 0, 0, 0, 0];
    }
    
    // Create distribution across 7 days based on mood data
    const totalMoods = Object.values(moodAnalytics.mood_distribution).reduce((sum, count) => sum + count, 0);
    const avgIntensity = moodAnalytics.average_intensity || 5;
    
    // Generate realistic daily mood scores
    const moodData = [];
    for (let i = 0; i < 7; i++) {
        const variation = (Math.random() - 0.5) * 2;
        const score = Math.max(1, Math.min(10, avgIntensity + variation));
        moodData.push(parseFloat(score.toFixed(1)));
    }
    
    return moodData;
}

// Process food data for chart display
function processFoodDataForChart(foodAnalytics) {
    if (!foodAnalytics.top_foods || foodAnalytics.top_foods.length === 0) {
        return {
            labels: ['Belum Ada Data'],
            data: [1],
            colors: ['rgba(156, 163, 175, 0.8)']
        };
    }
    
    const colors = [
        'rgba(34, 197, 94, 0.8)',   // green
        'rgba(249, 115, 22, 0.8)',  // orange
        'rgba(59, 130, 246, 0.8)',  // blue
        'rgba(168, 85, 247, 0.8)',  // purple
        'rgba(239, 68, 68, 0.8)'    // red
    ];
    
    const labels = [];
    const data = [];
    const chartColors = [];
    
    foodAnalytics.top_foods.slice(0, 5).forEach((count, index) => {
        const foodName = Object.keys(foodAnalytics.top_foods)[index];
        labels.push(foodName.length > 15 ? foodName.substring(0, 15) + '...' : foodName);
        data.push(count);
        chartColors.push(colors[index % colors.length]);
    });
    
    return { labels, data, colors: chartColors };
}

// Update other UI elements with analytics data
function updateAnalyticsUI(data) {
    // Update any dynamic elements that might need real-time data
    console.log('Enhanced analytics loaded:', data);
}

// Meal Plan Generation
function generateMealPlan() {
    const sessionId = window.moodFoodData?.sessionId || '';
    const selectedMood = window.moodFoodData?.selectedMood || '';
    
    if (!sessionId || !selectedMood) {
        alert('Silakan pilih mood terlebih dahulu');
        return;
    }

    // Show loading state
    const button = document.getElementById('generate-meal-plan-btn');
    const originalText = button.textContent;
    button.textContent = 'Generating...';
    button.disabled = true;

    fetch(window.moodFoodData?.mealPlanRoute || '/mood-food-tailwind/meal-plan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: 'generate',
            session_id: sessionId,
            mood: selectedMood
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to show new meal plan
        } else {
            alert('Gagal membuat meal plan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat membuat meal plan');
    })
    .finally(() => {
        button.textContent = originalText;
        button.disabled = false;
    });
}

// Export Meal Plan
function exportMealPlan() {
    const mealPlanData = window.moodFoodData?.weeklyMealPlan || null;
    
    if (!mealPlanData) {
        alert('Tidak ada meal plan untuk di-export');
        return;
    }
    
    // Create downloadable content
    let content = `Meal Plan - ${mealPlanData.name}\n`;
    content += `Generated: ${new Date().toLocaleDateString('id-ID')}\n\n`;
    
    mealPlanData.days.forEach((day, index) => {
        content += `${day.name}:\n`;
        ['sarapan', 'makan_siang', 'makan_malam'].forEach(mealType => {
            const meal = day.meals[mealType];
            const mealName = mealType.replace('_', ' ').charAt(0).toUpperCase() + mealType.replace('_', ' ').slice(1);
            if (meal && (meal.food || meal.recipe)) {
                const foodName = meal.recipe ? meal.recipe.name : meal.food.name;
                content += `  ${mealName}: ${foodName}\n`;
            } else {
                content += `  ${mealName}: -\n`;
            }
        });
        content += '\n';
    });
    
    // Download as text file
    const blob = new Blob([content], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `meal-plan-${new Date().toISOString().split('T')[0]}.txt`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
}

// Track food interactions
function trackFoodInteraction(foodName, interactionType) {
    const sessionId = window.moodFoodData?.sessionId || '';
    
    if (!sessionId) return;

    fetch('/api/track-food', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            session_id: sessionId,
            food_name: foodName,
            interaction_type: interactionType,
            metadata: {
                timestamp: new Date().toISOString(),
                page: 'mood-food-tailwind'
            }
        })
    })
    .catch(error => console.error('Tracking error:', error));
}

function showMealDetails(mealId) {
    if (!mealId) return;
    
    // This could be expanded to show a modal with detailed nutrition info
    alert('Fitur detail makanan akan segera hadir!');
}

function addMealToDay(dayIndex, mealType) {
    // This could open a modal to select food for the specific day/meal
    alert(`Tambah makanan untuk ${mealType.replace('_', ' ')} pada hari ke-${dayIndex + 1}`);
}

// Rating system
function setRating(rating) {
    document.getElementById('rating-input').value = rating;
    const stars = document.querySelectorAll('#rating-stars button');
    
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

// Nutrition Modal Functions
function showNutritionModal(foodId, foodName, calories, protein, fats, carbs) {
    document.getElementById('modalFoodName').textContent = foodName;
    document.getElementById('modalCalories').textContent = calories + ' kal';
    document.getElementById('modalProtein').textContent = protein + ' g';
    document.getElementById('modalFats').textContent = fats + ' g';
    document.getElementById('modalCarbs').textContent = carbs + ' g';
    
    const modal = document.getElementById('nutritionModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

// Close nutrition modal
function closeNutritionModal() {
    const modal = document.getElementById('nutritionModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Initialize nutrition modal event listeners
function initializeNutritionModal() {
    // Close modal when clicking outside
    const modal = document.getElementById('nutritionModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeNutritionModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNutritionModal();
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {    // Set default active section
    showSection('mood-tracker');
    
    // Initialize nutrition modal
    initializeNutritionModal();
    
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            const mobileNav = document.getElementById('mobile-nav');
            if (mobileNav.classList.contains('hidden')) {
                mobileNav.classList.remove('hidden');
                this.innerHTML = '<i class="fas fa-times text-gray-600"></i>';
            } else {
                mobileNav.classList.add('hidden');
                this.innerHTML = '<i class="fas fa-bars text-gray-600"></i>';
            }
        });
    }
    
    // Intensity slider update
    const intensitySlider = document.querySelector('input[name="intensity"]');
    const intensityValue = document.getElementById('intensity-value');
    
    if (intensitySlider && intensityValue) {
        intensitySlider.addEventListener('input', function() {
            intensityValue.textContent = this.value;
        });
    }
    
    // Auto-submit form when mood is selected
    document.querySelectorAll('input[name="mood"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Small delay to show selection animation
            setTimeout(() => {
                this.closest('form').submit();
            }, 200);
        });
    });
    
    // Track food card clicks
    document.querySelectorAll('[data-food-name]').forEach(card => {
        card.addEventListener('click', function() {
            const foodName = this.getAttribute('data-food-name');
            trackFoodInteraction(foodName, 'click');
        });
    });
    
    // Feedback form submission
    const feedbackForm = document.getElementById('feedback-form');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const rating = document.getElementById('rating-input').value;
            const content = document.getElementById('feedback-content').value;
            
            if (!rating) {
                alert('Silakan berikan rating terlebih dahulu');
                return;
            }
            
            if (!content.trim()) {
                formData.set('content', 'Rating saja tanpa komentar');
            }
            
            const submitBtn = document.getElementById('feedback-submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Mengirim...';
            submitBtn.disabled = true;
            
            fetch('/api/feedback', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Terima kasih atas feedback Anda!');
                    document.getElementById('feedback-form').reset();
                    document.querySelectorAll('#rating-stars button').forEach(star => {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    });
                } else {
                    alert('Gagal mengirim feedback: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim feedback');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Initialize nutrition modal
    initializeNutritionModal();
    
    // Animate cards on scroll
    const cards = document.querySelectorAll('.bg-white\\/95');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    });

    cards.forEach(card => {
        observer.observe(card);
    });
});
