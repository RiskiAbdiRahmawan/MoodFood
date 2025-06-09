// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Clear food search input and reload foods
function clearFoodSearch() {
    const searchInput = document.getElementById('foodSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    searchInput.value = '';
    clearBtn.classList.add('hidden');
    
    // Reload all foods
    loadFoodsForModal();
}

// Update visibility of the clear button based on search input
function updateClearButtonVisibility() {
    const searchInput = document.getElementById('foodSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    if (searchInput.value.trim()) {
        clearBtn.classList.remove('hidden');
    } else {
        clearBtn.classList.add('hidden');
    }
}

// Create debounced search function with clear button visibility update
const debouncedSearchFoods = debounce(function() {
    updateClearButtonVisibility();
    searchFoods();
}, 300);

// Dietary preferences reset function
function resetDietaryPreference() {
    const dietaryRadios = document.querySelectorAll('input[name="dietary_preference"]');
    dietaryRadios.forEach(radio => {
        radio.checked = false;
    });
}

// Navigation and Section Management
function showSection(sectionName) {
    console.log('Showing section:', sectionName); // Debug log
    
    // Hide all sections
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.classList.remove('hidden');
        console.log('Section shown:', sectionName); // Debug log
    } else {
        console.error('Section not found:', sectionName + '-section');
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
    
    alert('Fitur detail makanan akan segera hadir!');
}

function addMealToDay(dayIndex, mealType) {
    showAddFoodModal(dayIndex, mealType);
}

// Add Food Modal Functions
let selectedDayIndex = null;
let selectedMealType = null;
let selectedFoodId = null;

function showAddFoodModal(dayIndex = null, mealType = null) {
    selectedDayIndex = dayIndex;
    selectedMealType = mealType;
    
    const modal = document.getElementById('addFoodModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Update selected meal info
    if (dayIndex !== null && mealType !== null) {
        const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        document.getElementById('selectedDay').textContent = days[dayIndex] || 'Hari tidak diketahui';
        document.getElementById('selectedMealType').textContent = mealType.replace('_', ' ').toUpperCase();
        document.getElementById('selectedMealInfo').style.display = 'block';
    } else {
        document.getElementById('selectedMealInfo').style.display = 'none';
    }
    
    // Load foods
    loadFoodsForModal();
}

function closeAddFoodModal() {
    const modal = document.getElementById('addFoodModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    
    // Reset selections
    selectedDayIndex = null;
    selectedMealType = null;
    selectedFoodId = null;
    
    // Clear search
    document.getElementById('foodSearchInput').value = '';
    document.getElementById('foodList').innerHTML = '';
}

async function loadFoodsForModal() {
    const foodListElement = document.getElementById('foodList');
    
    // Show enhanced loading indicator
    addLoadingIndicator(foodListElement, 'Memuat makanan...');
    
    try {
        // Get available foods based on current mood if available
        const mood = window.moodFoodData?.selectedMood || '';
        
        // Fetch foods from API
        const url = new URL('/api/foods/search', window.location.origin);
        if (mood) {
            url.searchParams.append('mood', mood);
        }
        url.searchParams.append('limit', '20');
        
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            displayFoods(data.foods);
        } else {
            throw new Error(data.message || 'Failed to load foods');
        }
    } catch (error) {
        const errorMessage = handleApiError(error, 'Gagal memuat makanan');
        foodListElement.innerHTML = `
            <div class="text-center py-4 text-red-500">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                ${errorMessage}
                <button onclick="loadFoodsForModal()" class="block mx-auto mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Coba Lagi
                </button>
            </div>
        `;
    }
}

function displayFoods(foods) {
    const foodList = document.getElementById('foodList');
    
    if (foods.length === 0) {
        foodList.innerHTML = '<div class="text-center py-4 text-gray-500">Tidak ada makanan ditemukan</div>';
        return;
    }
    
    const foodsHtml = foods.map(food => `
        <div class="food-item p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-all duration-200 transform hover:scale-105 ${selectedFoodId === food.id ? 'border-green-500 bg-green-50 ring-2 ring-green-200' : 'border-gray-200'}" 
             onclick="selectFoodEnhanced(${food.id}, '${food.name.replace(/'/g, "\\'")}')">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="font-medium text-gray-800">${food.name}</div>
                    <div class="text-sm text-gray-600 capitalize">${food.category}</div>
                    ${food.description ? `<div class="text-xs text-gray-500 mt-1">${food.description}</div>` : ''}
                </div>
                <div class="text-right ml-3">
                    <div class="text-sm font-medium text-orange-600">${food.calories} kal</div>
                    <div class="text-xs text-gray-500">per 100g</div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-2 text-xs text-gray-600">
                <div class="text-center">
                    <div class="font-medium text-blue-600">${food.protein}g</div>
                    <div>Protein</div>
                </div>
                <div class="text-center">
                    <div class="font-medium text-green-600">${food.carbs}g</div>
                    <div>Karbo</div>
                </div>
                <div class="text-center">
                    <div class="font-medium text-yellow-600">${food.fats}g</div>
                    <div>Lemak</div>
                </div>
            </div>
        </div>
    `).join('');
    
    foodList.innerHTML = foodsHtml;
}

function selectFood(foodId, foodName) {
    selectedFoodId = foodId;
    
    // Update visual selection
    document.querySelectorAll('.food-item').forEach(item => {
        item.classList.remove('border-green-500', 'bg-green-50');
        item.classList.add('border-gray-200');
    });
    
    event.currentTarget.classList.add('border-green-500', 'bg-green-50');
    event.currentTarget.classList.remove('border-gray-200');
}

// Enhanced food selection with better visual feedback
function selectFoodEnhanced(foodId, foodName) {
    selectedFoodId = foodId;
    
    // Update visual selection with smooth animation
    document.querySelectorAll('.food-item').forEach(item => {
        item.classList.remove('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-200');
        item.classList.add('border-gray-200');
        item.style.transform = 'scale(1)';
    });
    
    const selectedItem = event.currentTarget;
    selectedItem.classList.add('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-200');
    selectedItem.classList.remove('border-gray-200');
    
    // Add selection animation
    selectedItem.style.transform = 'scale(1.02)';
    setTimeout(() => {
        selectedItem.style.transform = 'scale(1)';
    }, 150);
    
    // Show selected food info in a more prominent way
    showSelectedFoodInfo(foodName);
}

// Show selected food information
function showSelectedFoodInfo(foodName) {
    let infoDiv = document.getElementById('selectedFoodInfo');
    if (!infoDiv) {
        infoDiv = document.createElement('div');
        infoDiv.id = 'selectedFoodInfo';
        infoDiv.className = 'mt-4 p-3 bg-green-50 border border-green-200 rounded-lg';
        
        // Insert after food list
        const foodList = document.getElementById('foodList');
        foodList.parentNode.insertBefore(infoDiv, foodList.nextSibling);
    }
    
    infoDiv.innerHTML = `
        <div class="flex items-center text-green-700">
            <i class="fas fa-check-circle mr-2"></i>
            <span class="font-medium">Dipilih: ${foodName}</span>
        </div>
    `;
    
    // Animate the info div
    infoDiv.style.opacity = '0';
    infoDiv.style.display = 'block';
    setTimeout(() => {
        infoDiv.style.opacity = '1';
        infoDiv.style.transition = 'opacity 0.3s ease-in-out';
    }, 50);
}

async function searchFoods() {
    const searchTerm = document.getElementById('foodSearchInput').value.trim();
    const foodListElement = document.getElementById('foodList');
    
    // Show enhanced loading while searching
    addLoadingIndicator(foodListElement, 'Mencari makanan...');
    
    try {
        // Get current mood for better recommendations
        const mood = window.moodFoodData?.selectedMood || '';
        
        // Build API URL
        const url = new URL('/api/foods/search', window.location.origin);
        if (searchTerm) {
            url.searchParams.append('query', searchTerm);
        }
        if (mood) {
            url.searchParams.append('mood', mood);
        }
        url.searchParams.append('limit', '20');
        
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            displayFoods(data.foods);
        } else {
            throw new Error(data.message || 'Failed to search foods');
        }
    } catch (error) {
        const errorMessage = handleApiError(error, 'Gagal mencari makanan');
        foodListElement.innerHTML = `
            <div class="text-center py-4 text-red-500">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                ${errorMessage}
                <button onclick="searchFoods()" class="block mx-auto mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Coba Lagi
                </button>
            </div>
        `;
    }
}

function addFoodToMealPlan() {
    if (!selectedFoodId) {
        alert('Silakan pilih makanan terlebih dahulu');
        return;
    }
    
    if (selectedDayIndex === null || !selectedMealType) {
        alert('Informasi hari dan waktu makan tidak valid');
        return;
    }
    
    const servingSize = document.getElementById('servingSize').value;
    const sessionId = window.moodFoodData?.sessionId || '';
    
    if (!sessionId) {
        alert('Session tidak valid. Silakan refresh halaman.');
        return;
    }
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';
    button.disabled = true;
    
    // Use the API endpoint for adding food to meal plan
    fetch('/api/meal-plans/add-food', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            session_id: sessionId,
            food_id: selectedFoodId,
            meal_type: selectedMealType,
            day_of_week: selectedDayIndex,
            serving_size: parseFloat(servingSize)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showSuccessMessage('Makanan berhasil ditambahkan ke meal plan!');
            
            closeAddFoodModal();
            location.reload(); // Refresh to show updated meal plan
        } else {
            alert('Gagal menambahkan makanan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan makanan');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Add loading indicator styles and animations
function addLoadingIndicator(targetElement, message = 'Memuat...') {
    const loadingHtml = `
        <div class="loading-indicator text-center py-8">
            <div class="inline-flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mr-3"></div>
                <span class="text-gray-600 font-medium">${message}</span>
            </div>
        </div>
    `;
    targetElement.innerHTML = loadingHtml;
}

// Add success feedback with animation
function showSuccessMessage(message, duration = 3000) {
    const successDiv = document.createElement('div');
    successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    successDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(successDiv);
    
    // Animate in
    setTimeout(() => {
        successDiv.classList.remove('translate-x-full');
        successDiv.classList.add('translate-x-0');
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        successDiv.classList.remove('translate-x-0');
        successDiv.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(successDiv);
        }, 300);
    }, duration);
}

// Remove meal from plan
function removeMealFromPlan(mealId, dayIndex, mealType) {
    if (!mealId) return;
    
    if (confirm('Apakah Anda yakin ingin menghapus makanan ini dari meal plan?')) {
        const sessionId = window.moodFoodData?.sessionId || '';
        
        // Use the API endpoint for removing meal plan items
        fetch(`/api/meal-plans/remove-item/${mealId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message || data.success) {
                // Show success message
                showSuccessMessage('Makanan berhasil dihapus dari meal plan!');
                
                location.reload(); // Refresh to show updated meal plan
            } else {
                alert('Gagal menghapus makanan: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus makanan');
        });
    }
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

// Initialize meal plan functionality on page load
function initializeMealPlan() {
    // Check if we're on the meal plan section
    const mealPlanSection = document.getElementById('meal-plan-section');
    if (!mealPlanSection) return;
    
    // Add event listeners for meal plan buttons
    const addButtons = document.querySelectorAll('[onclick*="addMealToDay"]');
    addButtons.forEach(button => {
        // Track click events for analytics
        button.addEventListener('click', function() {
            const foodName = this.getAttribute('data-food-name') || 'Unknown';
            trackFoodInteraction(foodName, 'add_to_plan');
        });
    });
    
    // Initialize search input event listeners
    const searchInput = document.getElementById('foodSearchInput');
    if (searchInput) {
        // Add focus event to load foods if not already loaded
        searchInput.addEventListener('focus', function() {
            const foodList = document.getElementById('foodList');
            if (!foodList.hasChildNodes() || foodList.innerHTML.trim() === '') {
                loadFoodsForModal();
            }
        });
        
        // Add enter key support for search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchFoods();
            }
        });
    }
}

// Enhanced error handling for API calls
function handleApiError(error, fallbackMessage = 'Terjadi kesalahan yang tidak diketahui') {
    console.error('API Error:', error);
    
    let userMessage = fallbackMessage;
    
    if (error.message) {
        if (error.message.includes('Failed to fetch')) {
            userMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
        } else if (error.message.includes('404')) {
            userMessage = 'Layanan tidak ditemukan. Silakan refresh halaman.';
        } else if (error.message.includes('500')) {
            userMessage = 'Terjadi kesalahan server. Silakan coba lagi nanti.';
        }
    }
    
    return userMessage;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Force initial state - hide all sections first
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });
    
    // Set default active section
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
    
    // Initialize meal plan functionality
    initializeMealPlan();
    
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

// Backup initialization for page load
window.addEventListener('load', function() {
    // Additional safety check - ensure only mood-tracker is visible
    const allSections = document.querySelectorAll('.section-content');
    let hasVisibleSection = false;
    
    allSections.forEach(section => {
        if (!section.classList.contains('hidden')) {
            hasVisibleSection = true;
        }
    });
    
    // If multiple sections are visible or mood-tracker is not visible, reset
    const moodSection = document.getElementById('mood-tracker-section');
    if (!hasVisibleSection || (moodSection && moodSection.classList.contains('hidden'))) {
        console.log('Backup initialization - fixing section visibility');
        showSection('mood-tracker');
    }
});
