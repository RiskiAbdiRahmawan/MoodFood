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
    // Mood Trend Chart
    const moodCtx = document.getElementById('moodTrendChart');
    if (moodCtx) {
        new Chart(moodCtx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Mood Score',
                    data: [7.2, 8.1, 6.8, 7.5, 8.3, 7.9, 8.5],
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
        new Chart(foodCtx, {
            type: 'doughnut',
            data: {
                labels: ['Makanan Alami', 'Makanan Olahan', 'Minuman', 'Snack Sehat'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
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
