// Main application state and initialization
class MoodFoodApp {
    constructor() {
        this.currentMood = '';
        this.moodIntensity = 5;
        this.selectedPreferences = [];
        this.selectedRating = 0;
        this.moodData = {};
        this.recipesData = {};
        
        // Session tracking
        this.sessionId = window.MOOD_FOOD_CONFIG?.sessionId || null;
        this.trackingEnabled = window.MOOD_FOOD_CONFIG?.trackingEnabled || false;
        this.csrfToken = window.MOOD_FOOD_CONFIG?.csrfToken || '';
        this.baseUrl = window.MOOD_FOOD_CONFIG?.baseUrl || '';
        
        this.init();
    }

    async init() {
        try {
            // Load data files
            await this.loadData();
            
            // Initialize components
            this.initializeEventListeners();
            this.createBackgroundShapes();
            this.loadUserData();
            this.updateStats();

            // Initialize meal planner after DOM is ready
            setTimeout(() => {
                if (typeof MealPlanner !== 'undefined') {
                    this.mealPlanner = new MealPlanner();
                    
                    // Check if there's a pending recipe to add
                    if (window.pendingRecipeToAdd) {
                        setTimeout(() => {
                            this.addRecipeToMealPlan(window.pendingRecipeToAdd);
                            window.pendingRecipeToAdd = null;
                        }, 500);
                    }
                }
                
                // Initialize charts manager
                if (typeof ChartsManager !== 'undefined' && typeof Chart !== 'undefined') {
                    window.ChartsManager = new ChartsManager();
                }
                
                // Initialize chatbot
                if (typeof MoodFoodChatbot !== 'undefined') {
                    window.chatbot = new MoodFoodChatbot();
                }
            }, 100);
              // Show welcome message
            this.showNotification('Selamat datang di MoodFood Pro! 🌟');
            
            // Show session status if tracking is enabled
            if (this.trackingEnabled && this.sessionId) {
                setTimeout(() => {
                    this.showSessionStatus();
                }, 1000);
            }
        } catch (error) {
            console.error('Failed to initialize app:', error);
            this.showNotification('Terjadi kesalahan saat memuat aplikasi', 'error');
        }
    }

    async loadData() {
        try {
            // Load mood data
            const moodResponse = await fetch('./data/mood-data.json');
            this.moodData = await moodResponse.json();
            
            // Load recipes data
            const recipesResponse = await fetch('./data/recipes.json');
            this.recipesData = await recipesResponse.json();
        } catch (error) {
            console.error('Error loading data files:', error);
            // Fallback to embedded data if files not found
            this.loadFallbackData();
        }
    }

    loadFallbackData() {
        // Fallback data structure (simplified version)
        this.moodData = {
            sedih: {
                natural: [
                    { name: "Pisang", benefits: "Meningkatkan serotonin", calories: 89, protein: 1.1, carbs: 23, fats: 0.3, vitamins: ["B6", "C"] },
                    { name: "Dark Chocolate", benefits: "Melepas endorfin", calories: 155, protein: 2.2, carbs: 13, fats: 12 }
                ],
                processed: [
                    { name: "Smoothie Pisang", benefits: "Energi dan mood booster", calories: 180, prepTime: "5 menit" }
                ]
            },
            bahagia: {
                natural: [
                    { name: "Alpukat", benefits: "Energi berkelanjutan", calories: 160, protein: 2, carbs: 9, fats: 15, vitamins: ["K", "E"] }
                ],
                processed: [
                    { name: "Avocado Toast", benefits: "Mempertahankan mood positif", calories: 280, prepTime: "10 menit" }
                ]
            },
            marah: {
                natural: [
                    { name: "Yogurt", benefits: "Probiotik untuk menenangkan", calories: 100, protein: 10, carbs: 12, fats: 0 }
                ]
            },
            cemas: {
                natural: [
                    { name: "Chamomile Tea", benefits: "Efek menenangkan alami", calories: 2 }
                ]
            },
            stress: {
                natural: [
                    { name: "Blueberry", benefits: "Antioksidan anti-stress", calories: 84, carbs: 21, vitamins: ["C", "K"] }
                ]
            },
            lelah: {
                natural: [
                    { name: "Kopi", benefits: "Boost energi", calories: 2 },
                    { name: "Telur", benefits: "Protein berkualitas tinggi", calories: 78, protein: 6, fats: 5 }
                ]
            }
        };
        
        this.recipesData = { 
            recipes: [
                {
                    name: "Smoothie Anti-Sedih",
                    mood: "sedih",
                    difficulty: "mudah",
                    prepTime: "5 menit",
                    servings: 1,
                    calories: 180,
                    protein: 6,
                    carbs: 35,
                    fats: 2,
                    benefits: "Meningkatkan produksi serotonin"
                }
            ]
        };
    }

    initializeEventListeners() {
        // Navigation
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const section = e.target.closest('.nav-btn').dataset.section;
                this.switchSection(section);
            });
        });

        // Mood buttons
        document.querySelectorAll('.mood-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const mood = e.target.closest('.mood-btn').dataset.mood;
                this.selectMood(mood);
            });
        });

        // Preference tags
        document.querySelectorAll('.preference-tag').forEach(tag => {
            tag.addEventListener('click', (e) => {
                const preference = e.target.closest('.preference-tag').dataset.pref;
                this.togglePreference(preference);
            });
        });

        // Mood intensity slider
        const intensitySlider = document.getElementById('moodIntensity');
        if (intensitySlider) {
            intensitySlider.addEventListener('input', (e) => {
                this.moodIntensity = parseInt(e.target.value);
                this.updateMoodDisplay();
            });
        }

        // Star rating
        document.querySelectorAll('.star').forEach((star, index) => {
            star.addEventListener('click', () => {
                this.selectedRating = index + 1;
                this.updateStars();
            });
        });
    }    switchSection(sectionId) {
        // Update navigation
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        const navBtn = document.querySelector(`[data-section="${sectionId}"]`);
        if (navBtn) {
            navBtn.classList.add('active');
        } else {
            console.error(`Navigation button for section ${sectionId} not found`);
        }

        // Update sections
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        const sectionElement = document.getElementById(sectionId);
        if (sectionElement) {
            sectionElement.classList.add('active');
        } else {
            console.error(`Section element with id ${sectionId} not found`);
        }

        // Load section-specific content
        if (sectionId === 'analytics') {
            if (typeof this.updateCharts === 'function') {
                this.updateCharts();
            } else {
                console.error('updateCharts method not found');
            }
        } else if (sectionId === 'recipes') {
            if (typeof this.generateSmartRecipes === 'function') {
                this.generateSmartRecipes();
            } else {
                console.error('generateSmartRecipes method not found');
            }
        }
        
        // Trigger an event that section has changed
        window.dispatchEvent(new CustomEvent('sectionChanged', { detail: { section: sectionId } }));
    }    selectMood(mood) {
        this.currentMood = mood;
        
        // Update UI
        document.querySelectorAll('.mood-btn').forEach(b => b.classList.remove('active'));
        const moodBtn = document.querySelector(`[data-mood="${mood}"]`);
        if (moodBtn) moodBtn.classList.add('active');
        
        // Show recommendations
        this.showRecommendations(mood);
        
        // Save mood entry locally
        this.saveMoodEntry(mood, this.moodIntensity);
        
        // Track mood selection on server if available
        if (this.trackingEnabled && this.sessionId) {
            this.trackMoodSelection(mood, this.moodIntensity);
        }
        
        // Dispatch event for chatbot
        this.dispatchMoodChange(mood);
    }

    async trackMoodSelection(mood, intensity) {
        try {
            // Note: This will be handled by the controller automatically when mood is selected
            // via the mood-food route with parameters, but we can also track it via API
            const response = await fetch(`${this.baseUrl}/mood-food?mood=${mood}&intensity=${intensity}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken
                }
            });
            
            if (response.ok) {
                console.log('Mood selection tracked successfully');
            }
        } catch (error) {
            console.warn('Error tracking mood selection:', error);
        }
    }

    togglePreference(preference) {
        const tag = document.querySelector(`[data-pref="${preference}"]`);
        const index = this.selectedPreferences.indexOf(preference);
        
        if (index === -1) {
            this.selectedPreferences.push(preference);
            tag.classList.add('active');
        } else {
            this.selectedPreferences.splice(index, 1);
            tag.classList.remove('active');
        }
        
        // Update recommendations if mood is selected
        if (this.currentMood) {
            this.showRecommendations(this.currentMood);
        }
    }

    showRecommendations(mood) {
        const recommendations = document.getElementById('recommendations');
        if (!recommendations) return;

        recommendations.style.display = 'block';
        
        // Update mood label
        const selectedMoodSpan = document.getElementById('selected-mood');
        if (selectedMoodSpan) {
            selectedMoodSpan.textContent = mood.charAt(0).toUpperCase() + mood.slice(1);
        }

        const data = this.moodData[mood];
        if (!data) {
            recommendations.innerHTML = '<div class="card"><p>Data mood tidak tersedia</p></div>';
            return;
        }

        // Update natural foods section
        const naturalFoodsContainer = document.getElementById('natural-foods');
        if (naturalFoodsContainer && data.natural) {
            naturalFoodsContainer.innerHTML = '';
            data.natural.forEach(food => {
                const foodCard = this.createFoodCard(food, 'natural');
                naturalFoodsContainer.appendChild(foodCard);
            });
        }
        
        // Update processed foods section
        const processedFoodsContainer = document.getElementById('processed-foods');
        if (processedFoodsContainer && data.processed) {
            processedFoodsContainer.innerHTML = '';
            data.processed.forEach(food => {
                const foodCard = this.createFoodCard(food, 'processed');
                processedFoodsContainer.appendChild(foodCard);
            });
        }
    }    createFoodCard(food, type) {
        const foodCard = document.createElement('div');
        foodCard.className = 'food-card';
        foodCard.dataset.type = type;
        foodCard.dataset.foodName = food.name;
        
        const typeLabel = type === 'natural' ? 'Alami' : 'Olahan';
        
        foodCard.innerHTML = `
            <div class="food-header">
                <h4>${food.name}</h4>
                <span class="food-type">${typeLabel}</span>
            </div>
            <p class="food-benefits">${food.benefits}</p>
            <div class="nutrition-info">
                <div class="nutrition-item">
                    <span class="nutrition-label">Kalori</span>
                    <span class="nutrition-value">${food.calories}</span>
                </div>
                ${food.protein ? `
                <div class="nutrition-item">
                    <span class="nutrition-label">Protein</span>
                    <span class="nutrition-value">${food.protein}g</span>
                </div>` : ''}
                ${food.carbs ? `
                <div class="nutrition-item">
                    <span class="nutrition-label">Karbo</span>
                    <span class="nutrition-value">${food.carbs}g</span>
                </div>` : ''}
                ${food.fats ? `
                <div class="nutrition-item">
                    <span class="nutrition-label">Lemak</span>
                    <span class="nutrition-value">${food.fats}g</span>
                </div>` : ''}
                ${food.vitamins ? `
                <div class="nutrition-item vitamins">
                    <strong>Vitamin:</strong> ${food.vitamins.join(', ')}
                </div>` : ''}
            </div>
            <div class="food-actions">
                <button class="btn btn-primary add-to-plan-btn" data-food="${food.name}">
                    <i class="fas fa-plus"></i> Tambah ke Meal Plan
                </button>
                <button class="btn btn-secondary view-nutrition-btn" data-food="${food.name}">
                    <i class="fas fa-info-circle"></i> Detail Nutrisi
                </button>
            </div>
        `;

        // Add click tracking for the food card
        foodCard.addEventListener('click', (e) => {
            if (!e.target.closest('.btn')) {
                this.trackFoodInteraction(food.name, 'view', {
                    type: type,
                    mood: this.currentMood,
                    calories: food.calories
                });
            }
        });

        // Add event listeners for buttons
        const addToPlanBtn = foodCard.querySelector('.add-to-plan-btn');
        const viewNutritionBtn = foodCard.querySelector('.view-nutrition-btn');

        if (addToPlanBtn) {
            addToPlanBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.addToMealPlan(food.name);
                this.trackFoodInteraction(food.name, 'add_to_plan', {
                    type: type,
                    mood: this.currentMood
                });
            });
        }

        if (viewNutritionBtn) {
            viewNutritionBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.showNutritionDetails(food);
                this.trackFoodInteraction(food.name, 'click', {
                    type: type,
                    action: 'view_nutrition',
                    mood: this.currentMood
                });
            });
        }

        return foodCard;
    }

    showNutritionDetails(food) {
        const modal = document.createElement('div');
        modal.className = 'nutrition-modal';
        modal.innerHTML = `
            <div class="nutrition-modal-content">
                <div class="nutrition-modal-header">
                    <h3><i class="fas fa-apple-alt"></i> ${food.name}</h3>
                    <button class="nutrition-modal-close">&times;</button>
                </div>
                <div class="nutrition-modal-body">
                    <div class="nutrition-detail-grid">
                        <div class="nutrition-detail-item">
                            <span class="label">Kalori</span>
                            <span class="value">${food.calories} kcal</span>
                        </div>
                        ${food.protein ? `
                        <div class="nutrition-detail-item">
                            <span class="label">Protein</span>
                            <span class="value">${food.protein}g</span>
                        </div>` : ''}
                        ${food.carbs ? `
                        <div class="nutrition-detail-item">
                            <span class="label">Karbohidrat</span>
                            <span class="value">${food.carbs}g</span>
                        </div>` : ''}
                        ${food.fats ? `
                        <div class="nutrition-detail-item">
                            <span class="label">Lemak</span>
                            <span class="value">${food.fats}g</span>
                        </div>` : ''}
                        ${food.vitamins ? `
                        <div class="nutrition-detail-item vitamins">
                            <span class="label">Vitamin</span>
                            <span class="value">${food.vitamins.join(', ')}</span>
                        </div>` : ''}
                    </div>
                    <div class="nutrition-benefits">
                        <h4>Manfaat untuk Mood:</h4>
                        <p>${food.benefits}</p>
                    </div>
                    <div class="nutrition-actions">
                        <button class="btn btn-primary" onclick="window.moodFoodApp.addToMealPlan('${food.name}'); this.closest('.nutrition-modal').remove();">
                            <i class="fas fa-plus"></i> Tambah ke Meal Plan
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Add close functionality
        modal.querySelector('.nutrition-modal-close').addEventListener('click', () => {
            modal.remove();
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }

    saveMoodEntry(mood, intensity) {
        const entry = {
            mood,
            intensity,
            timestamp: new Date().toISOString(),
            date: new Date().toDateString(),
            preferences: [...this.selectedPreferences]
        };

        let moodHistory = JSON.parse(localStorage.getItem('moodHistory') || '[]');
        moodHistory.push(entry);
        
        // Keep only last 30 entries
        if (moodHistory.length > 30) {
            moodHistory = moodHistory.slice(-30);
        }
        
        localStorage.setItem('moodHistory', JSON.stringify(moodHistory));
        this.updateStats();
    }

    loadUserData() {
        const userData = JSON.parse(localStorage.getItem('userData') || '{}');
        if (userData.preferences) {
            this.selectedPreferences = userData.preferences;
            userData.preferences.forEach(pref => {
                const tag = document.querySelector(`[data-pref="${pref}"]`);
                if (tag) tag.classList.add('active');
            });
        }
    }

    saveUserData() {
        const userData = {
            preferences: this.selectedPreferences,
            lastVisit: new Date().toISOString()
        };
        localStorage.setItem('userData', JSON.stringify(userData));
    }

    updateStats() {
        const moodHistory = JSON.parse(localStorage.getItem('moodHistory') || '[]');
        
        // Update total meals tracked
        const totalMealsElement = document.getElementById('total-meals');
        if (totalMealsElement) {
            totalMealsElement.textContent = moodHistory.length;
        }

        // Update average mood score
        const moodScoreElement = document.getElementById('mood-score');
        if (moodScoreElement) {
            const average = this.calculateMoodAverage(moodHistory);
            moodScoreElement.textContent = average.toFixed(1);
        }

        // Update goals achieved (simplified calculation)
        const goalsElement = document.getElementById('goals-achieved');
        if (goalsElement) {
            const goals = Math.min(moodHistory.length, 10); // Simple goal system
            goalsElement.textContent = goals;
        }
    }

    calculateMoodAverage(history) {
        if (history.length === 0) return 0;
        
        const total = history.reduce((sum, entry) => sum + entry.intensity, 0);
        return total / history.length;
    }

    updateMoodDisplay() {
        // Update intensity display if needed
        const intensityDisplay = document.getElementById('intensityDisplay');
        if (intensityDisplay) {
            intensityDisplay.textContent = this.moodIntensity;
        }
    }

    updateStars() {
        document.querySelectorAll('.star').forEach((star, index) => {
            if (index < this.selectedRating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }    submitFeedback() {
        const feedbackText = document.getElementById('feedback-text')?.value || '';
        
        if (this.selectedRating === 0) {
            this.showNotification('Silakan berikan rating terlebih dahulu', 'warning');
            return;
        }

        const feedback = {
            rating: this.selectedRating,
            text: feedbackText,
            content: feedbackText,
            timestamp: new Date().toISOString(),
            mood: this.currentMood,
            intensity: this.moodIntensity,
            type: 'general',
            scope: 'overall_experience'
        };

        // Try to submit to server first
        if (this.trackingEnabled && this.sessionId) {
            this.submitFeedbackToServer(feedback);
        } else {
            // Fallback to local storage
            let feedbackHistory = JSON.parse(localStorage.getItem('feedbackHistory') || '[]');
            feedbackHistory.push(feedback);
            localStorage.setItem('feedbackHistory', JSON.stringify(feedbackHistory));
            
            this.showNotification(`Terima kasih atas feedback Anda! Rating: ${this.selectedRating} ⭐`);
        }

        // Reset form
        this.selectedRating = 0;
        this.updateStars();
        const feedbackTextArea = document.getElementById('feedback-text');
        if (feedbackTextArea) feedbackTextArea.value = '';
    }generateSmartRecipes() {
        if (!this.currentMood) {
            this.showNotification('Pilih mood Anda terlebih dahulu untuk rekomendasi resep', 'warning');
            return;
        }

        const recipeContainer = document.getElementById('recipe-container');
        if (!recipeContainer) {
            console.error('Recipe container element not found');
            return;
        }

        // Check if recipes data is available
        if (!this.recipesData || !this.recipesData.recipes) {
            console.error('Recipes data not loaded properly');
            recipeContainer.innerHTML = '<p>Tidak dapat memuat data resep.</p>';
            return;
        }

        const moodRecipes = this.recipesData.recipes.filter(recipe => 
            recipe.mood === this.currentMood ||
            (recipe.tags && recipe.tags.includes(this.currentMood))
        ) || [];

        // If no recipes match the exact mood, show some general recipes
        if (moodRecipes.length === 0) {
            // Fallback to general recipes or recipes from similar moods
            const generalRecipes = this.recipesData.recipes.slice(0, 3);
            
            if (generalRecipes.length > 0) {
                recipeContainer.innerHTML = `
                    <div class="recipe-info-message">
                        <p>Belum ada resep khusus untuk mood "${this.currentMood}", tapi berikut adalah beberapa resep yang mungkin Anda sukai:</p>
                    </div>
                    <div class="recipe-grid">
                        ${generalRecipes.map(recipe => this.createRecipeCard(recipe)).join('')}
                    </div>
                `;
            } else {
                recipeContainer.innerHTML = '<p>Belum ada resep tersedia untuk mood ini.</p>';
            }
            return;
        }

        // Display mood-specific recipes
        let html = `
            <div class="recipe-info-message">
                <p>Berikut adalah resep yang cocok untuk mood "${this.currentMood}" Anda:</p>
            </div>
            <div class="recipe-grid">
        `;
        
        moodRecipes.forEach(recipe => {
            html += this.createRecipeCard(recipe);
        });
        
        html += '</div>';
        
        recipeContainer.innerHTML = html;
        
        // Add animation to recipe cards
        setTimeout(() => {
            const cards = recipeContainer.querySelectorAll('.recipe-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animated');
            });
        }, 100);
    }    createRecipeCard(recipe) {
        // Make sure recipe has all required properties, or provide defaults
        const safeRecipe = {
            name: recipe.name || 'Unnamed Recipe',
            difficulty: recipe.difficulty || 'medium',
            prepTime: recipe.prepTime || '15 menit',
            servings: recipe.servings || 1,
            calories: recipe.calories || 0,
            protein: recipe.protein || 0,
            carbs: recipe.carbs || 0,
            fats: recipe.fats || 0,
            benefits: recipe.benefits || 'No benefits information',
            mood: recipe.mood || ''
        };
        
        // Get emoji for the mood
        const moodEmojis = {
            'sedih': '😢',
            'marah': '😠',
            'cemas': '😰',
            'bahagia': '😊',
            'lelah': '😴',
            'stress': '😫'
        };
        
        const moodEmoji = moodEmojis[safeRecipe.mood] || '🍽️';
        
        return `
            <div class="recipe-card">
                <div class="recipe-header">
                    <div class="recipe-title">
                        <span class="recipe-emoji">${moodEmoji}</span>
                        <h4>${safeRecipe.name}</h4>
                    </div>
                    <span class="difficulty ${safeRecipe.difficulty}">${safeRecipe.difficulty}</span>
                </div>
                <div class="recipe-meta">
                    <span><i class="fas fa-clock"></i> ${safeRecipe.prepTime}</span>
                    <span><i class="fas fa-users"></i> ${safeRecipe.servings} porsi</span>
                    <span><i class="fas fa-fire"></i> ${safeRecipe.calories} kal</span>
                </div>
                <p class="recipe-benefits">${safeRecipe.benefits}</p>
                <div class="recipe-nutrition">
                    <span>P: ${safeRecipe.protein}g</span>
                    <span>C: ${safeRecipe.carbs}g</span>
                    <span>F: ${safeRecipe.fats}g</span>
                </div>
                <div class="recipe-actions">
                    <button class="btn btn-primary" onclick="window.moodFoodApp.showRecipeDetails('${safeRecipe.name}')">
                        <i class="fas fa-book-open"></i> Lihat Resep
                    </button>
                    <button class="btn btn-secondary" onclick="window.moodFoodApp.addRecipeToMealPlan('${safeRecipe.name}')">
                        <i class="fas fa-plus"></i> Tambah ke Meal Plan
                    </button>
                </div>
            </div>
        `;
    }    showRecipeDetails(recipeName) {
        const recipe = this.recipesData.recipes?.find(r => r.name === recipeName);
        if (!recipe) {
            this.showNotification(`Recipe not found: ${recipeName}`, 'error');
            return;
        }

        // Create a modal to display recipe details
        const modal = document.createElement('div');
        modal.className = 'recipe-modal';
        modal.innerHTML = `
            <div class="recipe-modal-content">
                <div class="recipe-modal-header">
                    <h3>${recipe.name}</h3>
                    <button class="recipe-modal-close">&times;</button>
                </div>
                <div class="recipe-modal-body">
                    <div class="recipe-meta">
                        <span><i class="fas fa-clock"></i> ${recipe.prepTime}</span>
                        <span><i class="fas fa-users"></i> ${recipe.servings} porsi</span>
                        <span><i class="fas fa-fire"></i> ${recipe.calories} kal</span>
                        <span><i class="fas fa-balance-scale"></i> ${recipe.difficulty}</span>
                    </div>
                    
                    <div class="recipe-detail-section">
                        <h4>Manfaat</h4>
                        <p>${recipe.benefits}</p>
                    </div>
                    
                    <div class="recipe-detail-section">
                        <h4>Informasi Nutrisi</h4>
                        <div class="recipe-nutrition" style="margin-bottom: 0">
                            <span>Protein: ${recipe.protein}g</span>
                            <span>Karbohidrat: ${recipe.carbs}g</span>
                            <span>Lemak: ${recipe.fats}g</span>
                        </div>
                    </div>
                    
                    <div class="recipe-detail-section">
                        <h4>Bahan-bahan</h4>
                        ${recipe.ingredients ? `
                            <ul class="recipe-ingredients-list">
                                ${recipe.ingredients.map(ing => `
                                    <li>${typeof ing === 'object' ? `${ing.amount} ${ing.item}` : ing}</li>
                                `).join('')}
                            </ul>
                        ` : `<p>Belum ada daftar bahan.</p>`}
                    </div>
                    
                    <div class="recipe-detail-section">
                        <h4>Cara Memasak</h4>
                        ${recipe.instructions ? `
                            <ol class="recipe-steps">
                                ${recipe.instructions.map(step => `<li>${step}</li>`).join('')}
                            </ol>
                        ` : `<p>Belum ada petunjuk memasak.</p>`}
                    </div>
                    
                    <div class="recipe-detail-section">
                        <h4>Cocok untuk Mood</h4>
                        <p>Resep ini sangat cocok untuk mood: <strong>${recipe.mood}</strong></p>
                    </div>
                    
                    <div class="recipe-actions">
                        <button class="btn btn-primary" onclick="window.moodFoodApp.addRecipeToMealPlan('${recipe.name}')">
                            <i class="fas fa-plus"></i> Tambah ke Meal Plan
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add to document and set up event listeners
        document.body.appendChild(modal);
        
        modal.querySelector('.recipe-modal-close').addEventListener('click', () => {
            modal.classList.add('fadeOut');
            setTimeout(() => {
                modal.remove();
            }, 300);
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('fadeOut');
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        });
        
        // Animation
        setTimeout(() => {
            modal.querySelector('.recipe-modal-content').classList.add('animated');
        }, 10);
        
        this.showNotification(`Menampilkan detail resep: ${recipeName}`);
    }    async updateCharts() {
        // Try to load analytics data from server
        const serverAnalytics = await this.loadAnalyticsData();
        
        if (serverAnalytics) {
            // Use server data if available
            this.updateChartsWithServerData(serverAnalytics);
        } else {
            // Fallback to local data
            this.updateChartsWithLocalData();
        }
        
        // Update charts manager if available
        if (window.ChartsManager) {
            window.ChartsManager.updateAllCharts();
        }
    }

    updateChartsWithServerData(data) {
        // Update stats with server data
        const totalMealsElement = document.getElementById('total-meals');
        const moodScoreElement = document.getElementById('mood-score');
        const goalsElement = document.getElementById('goals-achieved');

        if (totalMealsElement && data.total_mood_selections) {
            totalMealsElement.textContent = data.total_mood_selections;
        }

        if (moodScoreElement && data.popular_moods && data.popular_moods.length > 0) {
            // Calculate average mood score from popular moods
            const avgScore = data.popular_moods.reduce((sum, mood) => sum + (mood.count * 5), 0) / 
                           data.popular_moods.reduce((sum, mood) => sum + mood.count, 0);
            moodScoreElement.textContent = avgScore.toFixed(1);
        }

        if (goalsElement && data.total_sessions) {
            goalsElement.textContent = Math.min(data.total_sessions, 10);
        }

        // Store server data for charts
        window.serverAnalyticsData = data;
    }

    updateChartsWithLocalData() {
        // Use existing local data update logic
        const moodHistory = JSON.parse(localStorage.getItem('moodHistory') || '[]');
        
        const totalMealsElement = document.getElementById('total-meals');
        const moodScoreElement = document.getElementById('mood-score');
        const goalsElement = document.getElementById('goals-achieved');

        if (totalMealsElement) {
            totalMealsElement.textContent = moodHistory.length;
        }

        if (moodScoreElement) {
            const average = this.calculateMoodAverage(moodHistory);
            moodScoreElement.textContent = average.toFixed(1);
        }

        if (goalsElement) {
            const goals = Math.min(moodHistory.length, 10);
            goalsElement.textContent = goals;
        }
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'error' ? '#e74c3c' : 
                         type === 'warning' ? '#f39c12' : '#27ae60'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 1001;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease-out;
            max-width: 300px;
            font-size: 14px;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    createBackgroundShapes() {
        const container = document.querySelector('.background-shapes');
        if (!container) return;

        // Clear existing shapes
        container.innerHTML = '';

        for (let i = 0; i < 6; i++) {
            const shape = document.createElement('div');
            shape.className = 'shape';
            shape.style.left = Math.random() * 100 + '%';
            shape.style.top = Math.random() * 100 + '%';
            shape.style.width = shape.style.height = (Math.random() * 100 + 50) + 'px';
            shape.style.animationDelay = Math.random() * 6 + 's';
            shape.style.animationDuration = (Math.random() * 3 + 4) + 's';
            container.appendChild(shape);
        }
    }    // Additional utility methods
    addToMealPlan(foodName) {
        if (this.mealPlanner) {
            this.mealPlanner.addFoodToCurrentSlot(foodName);
            this.showNotification(`${foodName} ditambahkan ke meal plan!`);
        } else {
            this.switchSection('meal-planner');
            this.showNotification('Silahkan pilih slot waktu makan di meal planner', 'info');
        }
    }

    addRecipeToMealPlan(recipeName) {
        const recipe = this.recipesData.recipes?.find(r => r.name === recipeName);
        
        if (!recipe) {
            this.showNotification(`Resep ${recipeName} tidak ditemukan`, 'error');
            return;
        }
        
        if (!this.mealPlanner) {
            // Navigate to meal planner section
            this.switchSection('meal-planner');
            
            // Save recipe name to be added after meal planner is initialized
            window.pendingRecipeToAdd = recipeName;
            
            this.showNotification('Silahkan pilih slot waktu makan di meal planner untuk menambahkan resep', 'info');
            return;
        }
        
        // Find first empty slot
        const emptySlots = document.querySelectorAll('.meal-slot:not([data-filled="true"])');
        if (emptySlots.length > 0) {
            const slot = emptySlots[0];
            const day = slot.dataset.day;
            const mealType = slot.dataset.meal;
            
            // Create meal object from recipe
            const meal = {
                name: recipe.name,
                calories: recipe.calories || 0,
                protein: recipe.protein || 0,
                carbs: recipe.carbs || 0,
                fats: recipe.fats || 0,
                source: 'recipe',
                recipe: recipe
            };
            
            // Add to meal plan
            this.mealPlanner.mealPlan[day][mealType] = meal;
            this.mealPlanner.saveMealPlan();
            this.mealPlanner.renderMealPlanner();
            this.mealPlanner.updateNutritionSummary();
            
            this.showNotification(`Resep ${recipeName} ditambahkan ke meal plan!`);
            
            // Highlight the added meal
            setTimeout(() => {
                const addedSlot = document.querySelector(`.meal-slot[data-day="${day}"][data-meal="${mealType}"]`);
                if (addedSlot) {
                    addedSlot.classList.add('highlight-added');
                    setTimeout(() => {
                        addedSlot.classList.remove('highlight-added');
                    }, 2000);
                }
            }, 100);
        } else {
            this.showNotification('Semua slot waktu makan sudah terisi. Hapus salah satu untuk menambahkan resep baru.', 'warning');
        }
    }

    exportMealPlan() {
        if (!this.mealPlanner) {
            this.showNotification('Meal planner belum tersedia', 'warning');
            return;
        }

        const mealPlan = this.mealPlanner.mealPlan;
        const exportData = {
            weekStarting: this.mealPlanner.currentWeek[0].date.toDateString(),
            mealPlan: mealPlan,
            preferences: this.selectedPreferences,
            exportDate: new Date().toISOString()
        };

        const dataStr = JSON.stringify(exportData, null, 2);
        const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
        
        const exportFileDefaultName = `meal-plan-${new Date().toISOString().split('T')[0]}.json`;
        
        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
        
        this.showNotification('Meal plan berhasil diekspor!');
    }

    importMealPlan(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const importData = JSON.parse(e.target.result);
                
                if (importData.mealPlan && this.mealPlanner) {
                    this.mealPlanner.mealPlan = importData.mealPlan;
                    this.mealPlanner.saveMealPlan();
                    this.mealPlanner.renderMealPlanner();
                    
                    if (importData.preferences) {
                        this.selectedPreferences = importData.preferences;
                        this.saveUserData();
                    }
                    
                    this.showNotification('Meal plan berhasil diimpor!');
                } else {
                    this.showNotification('Format file tidak valid', 'error');
                }
            } catch (error) {
                console.error('Error importing meal plan:', error);
                this.showNotification('Gagal mengimpor meal plan', 'error');
            }
        };
        reader.readAsText(file);
    }

    generateNutritionReport() {
        const moodHistory = JSON.parse(localStorage.getItem('moodHistory') || '[]');
        const feedbackHistory = JSON.parse(localStorage.getItem('feedbackHistory') || '[]');
        
        const report = {
            totalEntries: moodHistory.length,
            avgMoodScore: this.calculateMoodAverage(moodHistory),
            moodDistribution: this.getMoodDistribution(moodHistory),
            avgRating: this.calculateAverageRating(feedbackHistory),
            streakDays: this.calculateStreak(moodHistory),
            reportDate: new Date().toISOString()
        };

        // Create a simple text report
        let reportText = `=== LAPORAN NUTRISI & MOOD ===\n`;
        reportText += `Tanggal: ${new Date().toLocaleDateString('id-ID')}\n\n`;
        reportText += `📊 RINGKASAN:\n`;
        reportText += `• Total Entri Mood: ${report.totalEntries}\n`;
        reportText += `• Rata-rata Skor Mood: ${report.avgMoodScore.toFixed(1)}/10\n`;
        reportText += `• Streak Hari: ${report.streakDays} hari\n`;
        reportText += `• Rating Pengalaman: ${report.avgRating.toFixed(1)}/5 ⭐\n\n`;
        
        reportText += `📈 DISTRIBUSI MOOD:\n`;
        Object.entries(report.moodDistribution).forEach(([mood, count]) => {
            reportText += `• ${mood.charAt(0).toUpperCase() + mood.slice(1)}: ${count} kali\n`;
        });

        // Download as text file
        const dataUri = 'data:text/plain;charset=utf-8,'+ encodeURIComponent(reportText);
        const exportFileDefaultName = `nutrition-report-${new Date().toISOString().split('T')[0]}.txt`;
        
        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
        
        this.showNotification('Laporan nutrisi berhasil diunduh!');
    }

    getMoodDistribution(history) {
        const distribution = {};
        history.forEach(entry => {
            distribution[entry.mood] = (distribution[entry.mood] || 0) + 1;
        });
        return distribution;
    }

    calculateAverageRating(feedbackHistory) {
        if (feedbackHistory.length === 0) return 0;
        const total = feedbackHistory.reduce((sum, feedback) => sum + feedback.rating, 0);
        return total / feedbackHistory.length;
    }    // Method to trigger mood change event for chatbot
    dispatchMoodChange(mood) {
        const moodChangeEvent = new CustomEvent('moodChanged', {
            detail: { mood: mood }
        });
        document.dispatchEvent(moodChangeEvent);
    }

    // Session tracking methods
    async trackFoodInteraction(foodName, interactionType, metadata = {}) {
        if (!this.trackingEnabled || !this.sessionId) return;

        try {
            const response = await fetch(`${this.baseUrl}/api/track-food-interaction`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    food_name: foodName,
                    interaction_type: interactionType,
                    metadata: metadata
                })
            });

            if (!response.ok) {
                console.warn('Failed to track food interaction:', response.statusText);
            }
        } catch (error) {
            console.warn('Error tracking food interaction:', error);
        }
    }

    async submitFeedbackToServer(feedbackData) {
        if (!this.trackingEnabled || !this.sessionId) {
            // Fallback to local storage
            this.submitFeedback();
            return;
        }

        try {
            const response = await fetch(`${this.baseUrl}/api/submit-feedback`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    type: feedbackData.type || 'general',
                    rating: feedbackData.rating,
                    content: feedbackData.content || feedbackData.text || '',
                    scope: feedbackData.scope || 'overall_experience'
                })
            });

            if (response.ok) {
                const result = await response.json();
                this.showNotification(result.message || 'Terima kasih atas feedback Anda!');
            } else {
                throw new Error('Failed to submit feedback');
            }
        } catch (error) {
            console.warn('Error submitting feedback to server:', error);
            // Fallback to local storage
            this.submitFeedback();
        }
    }

    async loadAnalyticsData() {
        if (!this.trackingEnabled) return null;

        try {
            const response = await fetch(`${this.baseUrl}/api/analytics`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken
                }
            });

            if (response.ok) {
                return await response.json();
            }
        } catch (error) {
            console.warn('Error loading analytics data:', error);
        }
        return null;
    }

    // Enhanced session notification system
    showSessionStatus() {
        if (this.sessionId) {
            const indicator = document.createElement('div');
            indicator.className = 'session-indicator';
            indicator.innerHTML = `
                <i class="fas fa-shield-alt"></i>
                <span>Session Active</span>
            `;
            indicator.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: rgba(34, 197, 94, 0.9);
                color: white;
                padding: 8px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                z-index: 1000;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            document.body.appendChild(indicator);
            
            setTimeout(() => {
                indicator.style.opacity = '1';
            }, 100);
            
            setTimeout(() => {
                indicator.style.opacity = '0';
                setTimeout(() => {
                    indicator.remove();
                }, 300);
            }, 3000);
        }
    }
}

// Global function wrappers for HTML onclick handlers
window.generateWeeklyPlan = function() {
    if (window.moodFoodApp && window.moodFoodApp.mealPlanner) {
        window.moodFoodApp.mealPlanner.generateWeeklyPlan();
    }
};

window.submitFeedback = function() {
    if (window.moodFoodApp) {
        window.moodFoodApp.submitFeedback();
    }
};

window.sendMessage = function() {
    if (window.chatbot) {
        window.chatbot.sendMessage();
    }
};

window.handleChatKeyPress = function(event) {
    if (window.chatbot) {
        window.chatbot.handleKeyPress(event);
    }
};

window.toggleChatbot = function() {
    const chatbot = document.getElementById('chatbot');
    const toggle = document.querySelector('.chatbot-toggle');
    const container = document.querySelector('.chatbot-container');
    
    if (chatbot && toggle) {
        if (chatbot.style.display === 'flex') {
            chatbot.style.display = 'none';
            chatbot.classList.remove('show');
            container.classList.remove('active');
            toggle.innerHTML = '<i class="fas fa-robot"></i>';
            
            // Add animation for hiding
            chatbot.style.animation = 'slideDownOut 0.3s ease-out forwards';
            
            // Remove active background after animation completes
            setTimeout(() => {
                chatbot.style.animation = '';
            }, 300);
        } else {
            chatbot.style.display = 'flex';
            chatbot.classList.add('show');
            container.classList.add('active');
            toggle.innerHTML = '<i class="fas fa-times"></i>';
            
            // Add animation for showing
            chatbot.style.animation = 'slideUpIn 0.3s ease-out forwards';
            
            // Auto-scroll to bottom of messages
            const messages = document.getElementById('chatMessages');
            if (messages) {
                setTimeout(() => {
                    messages.scrollTop = messages.scrollHeight;
                }, 100);
            }
        }
    }
};

// Add notification animations to CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .star.active {
        color: #ffd700;
    }
    
    .preference-tag.active {
        background: var(--accent-color, #667eea);
        color: white;
    }
    
    .mood-btn.active {
        background: var(--accent-color, #667eea);
        color: white;
        transform: scale(1.05);
    }
`;
document.head.appendChild(style);

// Initialize the app when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.moodFoodApp = new MoodFoodApp();
});
