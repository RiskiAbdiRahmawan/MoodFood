// Meal Planner functionality
class MealPlanner {
    constructor() {
        this.currentWeek = this.getWeekDates();
        this.mealPlan = this.loadMealPlan();
        this.mealTypes = ['sarapan', 'snack1', 'makan_siang', 'snack2', 'makan_malam'];
        this.draggedElement = null;
        
        this.init();
    }

    init() {
        this.renderMealPlanner();
        this.addEventListeners();
        this.loadSuggestedMeals();
        this.addDragDropVisualFeedback();
        this.setupPlaceholders();
    }
    
    setupPlaceholders() {
        // Handle meal slot hover effects
        document.querySelectorAll('.meal-slot').forEach(slot => {
            // Ensure all slots have add-meal-placeholder if they're not filled
            if (!slot.classList.contains('filled') && !slot.querySelector('.add-meal-placeholder')) {
                const placeholder = document.createElement('div');
                placeholder.className = 'add-meal-placeholder';
                placeholder.innerHTML = `
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Makanan</span>
                `;
                slot.appendChild(placeholder);
            }
        });
    }

    getWeekDates() {
        const today = new Date();
        const monday = new Date(today);
        monday.setDate(today.getDate() - today.getDay() + 1);
        
        const week = [];
        for (let i = 0; i < 7; i++) {
            const date = new Date(monday);
            date.setDate(monday.getDate() + i);
            week.push({
                date: date,
                dayName: date.toLocaleDateString('id-ID', { weekday: 'long' }),
                shortName: date.toLocaleDateString('id-ID', { weekday: 'short' }),
                dateNumber: date.getDate()
            });
        }
        return week;
    }

    loadMealPlan() {
        const saved = localStorage.getItem('mealPlan');
        if (saved) {
            return JSON.parse(saved);
        }
        
        // Initialize empty meal plan
        const plan = {};
        this.currentWeek.forEach(day => {
            const dayKey = day.date.toDateString();
            plan[dayKey] = {
                sarapan: null,
                snack1: null,
                makan_siang: null,
                snack2: null,
                makan_malam: null
            };
        });
        return plan;
    }

    saveMealPlan() {
        localStorage.setItem('mealPlan', JSON.stringify(this.mealPlan));
    }    renderMealPlanner() {
        const container = document.getElementById('meal-planner-grid');
        if (!container) return;

        let html = '<div class="week-grid">';
        
        // Header row with empty first cell
        html += '<div class="meal-time-column"></div>';
        this.currentWeek.forEach(day => {
            html += `
                <div class="day-header">
                    <div class="day-name">${day.shortName}</div>
                    <div class="day-date">${day.dateNumber}</div>
                </div>
            `;
        });

        // Meal rows
        const mealLabels = {
            sarapan: 'Sarapan',
            snack1: 'Snack Pagi',
            makan_siang: 'Makan Siang',
            snack2: 'Snack Sore',
            makan_malam: 'Makan Malam'
        };

        this.mealTypes.forEach(mealType => {
            html += `<div class="meal-time-column">${mealLabels[mealType]}</div>`;
            
            this.currentWeek.forEach(day => {
                const dayKey = day.date.toDateString();
                const meal = this.mealPlan[dayKey]?.[mealType];
                
                html += `
                    <div class="meal-slot${meal ? ' filled' : ''}" 
                         data-day="${dayKey}" 
                         data-meal="${mealType}"
                         ${meal ? `data-filled="true"` : ''}>
                        ${meal ? `
                            <div class="meal-content">
                                <div class="meal-item" draggable="true">
                                    <div class="meal-name">${meal.name}</div>
                                    <div class="meal-calories">${meal.calories} kal</div>
                                    <button class="meal-remove" onclick="window.moodFoodApp.mealPlanner.removeMeal('${dayKey}', '${mealType}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        ` : `
                            <div class="add-meal-placeholder">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Makanan</span>
                            </div>
                        `}
                    </div>
                `;
            });
        });

        html += '</div>';
        container.innerHTML = html;
        this.updateWeekDisplay();
        this.updateNutritionSummary();
    }

    addEventListeners() {
        // Drag and drop functionality
        document.addEventListener('dragstart', (e) => {
            if (e.target.classList.contains('meal-item') || e.target.classList.contains('suggested-meal')) {
                this.draggedElement = e.target;
                e.target.style.opacity = '0.5';
            }
        });

        document.addEventListener('dragend', (e) => {
            if (e.target.classList.contains('meal-item') || e.target.classList.contains('suggested-meal')) {
                e.target.style.opacity = '1';
                this.draggedElement = null;
            }
        });

        document.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        document.addEventListener('drop', (e) => {
            e.preventDefault();
            const mealSlot = e.target.closest('.meal-slot');
            if (mealSlot && this.draggedElement) {
                this.handleDrop(mealSlot);
            }
        });

        // Click to add meal
        document.addEventListener('click', (e) => {
            const mealSlot = e.target.closest('.meal-slot');
            if (mealSlot && !mealSlot.dataset.filled) {
                this.showMealSelector(mealSlot);
            }
        });

        // Week navigation
        const prevWeekBtn = document.getElementById('prev-week');
        const nextWeekBtn = document.getElementById('next-week');
        
        if (prevWeekBtn) {
            prevWeekBtn.addEventListener('click', () => this.navigateWeek(-1));
        }
        
        if (nextWeekBtn) {
            nextWeekBtn.addEventListener('click', () => this.navigateWeek(1));
        }
    }

    handleDrop(mealSlot) {
        if (!this.draggedElement) return;

        const day = mealSlot.dataset.day;
        const mealType = mealSlot.dataset.meal;
        
        let mealData;
        
        if (this.draggedElement.classList.contains('suggested-meal')) {
            // Adding from suggested meals
            mealData = {
                name: this.draggedElement.querySelector('.meal-name').textContent,
                calories: parseInt(this.draggedElement.dataset.calories),
                protein: parseFloat(this.draggedElement.dataset.protein),
                carbs: parseFloat(this.draggedElement.dataset.carbs),
                fats: parseFloat(this.draggedElement.dataset.fats),
                source: 'suggested'
            };
        } else {
            // Moving existing meal
            const sourceMealSlot = this.draggedElement.closest('.meal-slot');
            const sourceDay = sourceMealSlot.dataset.day;
            const sourceMealType = sourceMealSlot.dataset.meal;
            
            mealData = this.mealPlan[sourceDay][sourceMealType];
            
            // Remove from source
            this.mealPlan[sourceDay][sourceMealType] = null;
        }

        // Add to target
        this.mealPlan[day][mealType] = mealData;
        this.saveMealPlan();
        this.renderMealPlanner();
        this.updateNutritionSummary();
    }

    removeMeal(day, mealType) {
        this.mealPlan[day][mealType] = null;
        this.saveMealPlan();
        this.renderMealPlanner();
        this.updateNutritionSummary();
    }

    showMealSelector(mealSlot) {
        // Create modal for meal selection
        const modal = document.createElement('div');
        modal.className = 'meal-selector-modal';
        
        // Store meal slot info in data attributes
        modal.dataset.day = mealSlot.dataset.day;
        modal.dataset.mealType = mealSlot.dataset.meal;
        
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Pilih Makanan</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="meal-categories">
                        <button class="category-btn active" data-category="recommended">Rekomendasi</button>
                        <button class="category-btn" data-category="custom">Custom</button>
                        <button class="category-btn" data-category="recipes">Resep</button>
                    </div>
                    <div class="meal-options" id="meal-options">
                        ${this.getSuggestedMealsHTML()}
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Add event listeners
        modal.querySelector('.close-modal').addEventListener('click', () => {
            modal.remove();
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });

        // Category switching
        modal.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                modal.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                
                const category = e.target.dataset.category;
                const optionsContainer = modal.querySelector('#meal-options');
                
                switch (category) {
                    case 'recommended':
                        optionsContainer.innerHTML = this.getSuggestedMealsHTML();
                        break;
                    case 'custom':
                        optionsContainer.innerHTML = this.getCustomMealForm();
                        break;
                    case 'recipes':
                        optionsContainer.innerHTML = this.getRecipesHTML();
                        break;
                }
            });
        });

        // Meal selection
        modal.addEventListener('click', (e) => {
            const mealOption = e.target.closest('.meal-option');
            if (mealOption) {
                const meal = {
                    name: mealOption.dataset.name,
                    calories: parseInt(mealOption.dataset.calories),
                    protein: parseFloat(mealOption.dataset.protein || 0),
                    carbs: parseFloat(mealOption.dataset.carbs || 0),
                    fats: parseFloat(mealOption.dataset.fats || 0),
                    source: 'selected'
                };

                const day = mealSlot.dataset.day;
                const mealType = mealSlot.dataset.meal;
                
                this.mealPlan[day][mealType] = meal;
                this.saveMealPlan();
                this.renderMealPlanner();
                this.updateNutritionSummary();
                
                modal.remove();
            }
        });
    }

    getSuggestedMealsHTML() {
        const meals = [
            { name: 'Oatmeal with Berries', calories: 250, protein: 8, carbs: 45, fats: 4 },
            { name: 'Greek Yogurt Parfait', calories: 180, protein: 15, carbs: 20, fats: 5 },
            { name: 'Avocado Toast', calories: 300, protein: 8, carbs: 25, fats: 20 },
            { name: 'Grilled Chicken Salad', calories: 350, protein: 30, carbs: 15, fats: 18 },
            { name: 'Quinoa Bowl', calories: 400, protein: 14, carbs: 60, fats: 12 },
            { name: 'Salmon Teriyaki', calories: 420, protein: 35, carbs: 25, fats: 20 },
            { name: 'Apple with Almond Butter', calories: 190, protein: 7, carbs: 20, fats: 12 },
            { name: 'Mixed Nuts', calories: 160, protein: 6, carbs: 6, fats: 14 }
        ];

        return meals.map(meal => `
            <div class="meal-option" 
                 data-name="${meal.name}"
                 data-calories="${meal.calories}"
                 data-protein="${meal.protein}"
                 data-carbs="${meal.carbs}"
                 data-fats="${meal.fats}">
                <div class="meal-name">${meal.name}</div>
                <div class="meal-nutrition">
                    ${meal.calories} kal | P: ${meal.protein}g | C: ${meal.carbs}g | F: ${meal.fats}g
                </div>
            </div>
        `).join('');
    }

    getCustomMealForm() {
        return `
            <div class="custom-meal-form">
                <input type="text" id="custom-meal-name" placeholder="Nama makanan" required>
                <input type="number" id="custom-meal-calories" placeholder="Kalori" required>
                <input type="number" id="custom-meal-protein" placeholder="Protein (g)" step="0.1">
                <input type="number" id="custom-meal-carbs" placeholder="Karbohidrat (g)" step="0.1">
                <input type="number" id="custom-meal-fats" placeholder="Lemak (g)" step="0.1">
                <button class="btn btn-primary" onclick="window.moodFoodApp.mealPlanner.addCustomMeal()">Tambah Makanan</button>
            </div>
        `;
    }

    getRecipesHTML() {
        // Get recipes from app if available
        const recipes = window.moodFoodApp?.recipesData?.recipes || [];
        
        if (recipes.length === 0) {
            return '<p>Belum ada resep tersedia. Silakan tambahkan resep di bagian Smart Recipes.</p>';
        }

        return recipes.map(recipe => `
            <div class="meal-option" 
                 data-name="${recipe.name}"
                 data-calories="${recipe.calories}"
                 data-protein="${recipe.protein}"
                 data-carbs="${recipe.carbs}"
                 data-fats="${recipe.fats}">
                <div class="meal-name">${recipe.name}</div>
                <div class="meal-nutrition">
                    ${recipe.calories} kal | P: ${recipe.protein}g | C: ${recipe.carbs}g | F: ${recipe.fats}g
                </div>
                <div class="meal-prep-time">
                    <i class="fas fa-clock"></i> ${recipe.prepTime}
                </div>
            </div>
        `).join('');
    }

    addCustomMeal() {
        const name = document.getElementById('custom-meal-name').value;
        const calories = parseInt(document.getElementById('custom-meal-calories').value);
        const protein = parseFloat(document.getElementById('custom-meal-protein').value) || 0;
        const carbs = parseFloat(document.getElementById('custom-meal-carbs').value) || 0;
        const fats = parseFloat(document.getElementById('custom-meal-fats').value) || 0;

        if (!name || !calories) {
            alert('Nama makanan dan kalori harus diisi!');
            return;
        }

        const meal = { name, calories, protein, carbs, fats, source: 'custom' };
        
        // Get the active meal slot from the current modal
        const modal = document.querySelector('.meal-selector-modal');
        if (!modal) return;
        
        // Get data attributes from the modal
        const mealSlotDay = modal.dataset.day;
        const mealSlotType = modal.dataset.mealType;
        
        if (mealSlotDay && mealSlotType) {
            // Add to meal plan
            this.mealPlan[mealSlotDay][mealSlotType] = meal;
            this.saveMealPlan();
            this.renderMealPlanner();
            this.updateNutritionSummary();
            
            // Close modal
            modal.remove();
            
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification(`Makanan custom "${name}" berhasil ditambahkan!`);
            }
        } else {
            // Just close the modal and show notification
            modal.remove();
            
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification(`Makanan custom "${name}" berhasil dibuat!`);
            }
        }
    }

    loadSuggestedMeals() {
        const container = document.getElementById('suggested-meals');
        if (!container) return;

        const meals = [
            { name: 'Overnight Oats', calories: 280, protein: 10, carbs: 45, fats: 8 },
            { name: 'Protein Smoothie', calories: 220, protein: 25, carbs: 20, fats: 5 },
            { name: 'Buddha Bowl', calories: 450, protein: 15, carbs: 65, fats: 18 },
            { name: 'Grilled Fish', calories: 300, protein: 35, carbs: 5, fats: 15 }
        ];

        const html = meals.map(meal => `
            <div class="suggested-meal" 
                 draggable="true"
                 data-calories="${meal.calories}"
                 data-protein="${meal.protein}"
                 data-carbs="${meal.carbs}"
                 data-fats="${meal.fats}">
                <div class="meal-name">${meal.name}</div>
                <div class="meal-calories">${meal.calories} kal</div>
            </div>
        `).join('');

        container.innerHTML = html;
    }

    navigateWeek(direction) {
        const firstDay = this.currentWeek[0].date;
        firstDay.setDate(firstDay.getDate() + (direction * 7));
        
        this.currentWeek = this.getWeekDates();
        this.mealPlan = this.loadMealPlan();
        this.renderMealPlanner();
        this.updateWeekDisplay();
    }

    updateWeekDisplay() {
        const weekDisplay = document.getElementById('current-week');
        if (weekDisplay) {
            const start = this.currentWeek[0].date.toLocaleDateString('id-ID');
            const end = this.currentWeek[6].date.toLocaleDateString('id-ID');
            weekDisplay.textContent = `${start} - ${end}`;
        }
    }    updateNutritionSummary() {
        const today = new Date().toDateString();
        const todayMeals = this.mealPlan[today];
        
        if (!todayMeals) return;

        let totalCalories = 0;
        let totalProtein = 0;
        let totalCarbs = 0;
        let totalFats = 0;

        Object.values(todayMeals).forEach(meal => {
            if (meal) {
                totalCalories += meal.calories || 0;
                totalProtein += meal.protein || 0;
                totalCarbs += meal.carbs || 0;
                totalFats += meal.fats || 0;
            }
        });
        
        // Update summary display
        const summaryContainer = document.getElementById('nutrition-summary');
        if (summaryContainer) {
            summaryContainer.innerHTML = `
                <h3>Ringkasan Nutrisi Hari Ini</h3>
                <div class="daily-nutrition">
                    <div class="nutrition-card">
                        <div class="nutrition-label">Kalori</div>
                        <div class="nutrition-value">${totalCalories}</div>
                        <div class="nutrition-unit">kal</div>
                    </div>
                    <div class="nutrition-card">
                        <div class="nutrition-label">Protein</div>
                        <div class="nutrition-value">${totalProtein.toFixed(1)}</div>
                        <div class="nutrition-unit">g</div>
                    </div>
                    <div class="nutrition-card">
                        <div class="nutrition-label">Karbohidrat</div>
                        <div class="nutrition-value">${totalCarbs.toFixed(1)}</div>
                        <div class="nutrition-unit">g</div>
                    </div>
                    <div class="nutrition-card">
                        <div class="nutrition-label">Lemak</div>
                        <div class="nutrition-value">${totalFats.toFixed(1)}</div>
                        <div class="nutrition-unit">g</div>
                    </div>
                </div>
            `;
        }
    }
        
// Generate automatic weekly meal plan based on mood and preferences
async generateWeeklyPlan() {
        try {
            // Show loading notification
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification('Generating smart meal plan...', 'info');
            }

            // Try to use server APIs first, then fallback to static data
            let moodData, recipes;
            const baseUrl = window.moodFoodApp?.baseUrl || '';
            const currentMood = window.moodFoodApp ? window.moodFoodApp.currentMood : 'bahagia';
            
            try {
                if (baseUrl) {
                    // Fetch from server APIs
                    const [moodDataResponse, recipesResponse] = await Promise.all([
                        fetch(`${baseUrl}/api/foods/by-mood/${currentMood}`),
                        fetch(`${baseUrl}/api/recipes/by-mood/${currentMood}`)
                    ]);

                    if (moodDataResponse.ok && recipesResponse.ok) {
                        const moodResult = await moodDataResponse.json();
                        const recipesResult = await recipesResponse.json();
                        
                        // Transform server data to expected format
                        moodData = {
                            [currentMood]: {
                                natural: moodResult.natural_foods || [],
                                processed: moodResult.processed_foods || [],
                                foods: [...(moodResult.natural_foods || []), ...(moodResult.processed_foods || [])]
                            }
                        };
                        
                        recipes = {
                            recipes: recipesResult.recipes || []
                        };
                        
                        console.log('Successfully loaded meal planning data from server');
                    } else {
                        throw new Error('Server APIs not available');
                    }
                } else {
                    throw new Error('Base URL not available');
                }
            } catch (error) {
                console.log('Server APIs not available, trying static files...');
                
                try {
                    // Fallback to static files
                    const [moodDataResponse, recipesResponse] = await Promise.all([
                        fetch('./data/mood-data.json'),
                        fetch('./data/recipes.json')
                    ]);
                    
                    moodData = await moodDataResponse.json();
                    recipes = await recipesResponse.json();
                } catch (fileError) {
                    console.log('Static files not available, using fallback data');
                    // Use fallback data
                    moodData = this.getFallbackMoodData();
                    recipes = this.getFallbackRecipes();
                }
            }
            
            // Get user's mood foods
            const moodFoods = moodData[currentMood] || moodData.bahagia || moodData.sedih;
            
            // Clear current meal plan
            this.mealPlan = {};
            
            // Generate meals for each day of the week
            this.currentWeek.forEach((day, dayIndex) => {
                const dayKey = day.date.toDateString();
                this.mealPlan[dayKey] = {};
                
                // Generate meals for each meal type
                this.mealTypes.forEach(mealType => {
                    let meal = null;
                    
                    if (mealType === 'sarapan') {
                        // Breakfast - prioritize energy foods
                        meal = this.selectMealForType(moodFoods, recipes, 'breakfast', dayIndex);
                    } else if (mealType === 'makan_siang') {
                        // Lunch - balanced meal
                        meal = this.selectMealForType(moodFoods, recipes, 'lunch', dayIndex);
                    } else if (mealType === 'makan_malam') {
                        // Dinner - lighter but nutritious
                        meal = this.selectMealForType(moodFoods, recipes, 'dinner', dayIndex);
                    } else {
                        // Snacks
                        meal = this.selectMealForType(moodFoods, recipes, 'snack', dayIndex);
                    }
                    
                    this.mealPlan[dayKey][mealType] = meal;
                });
            });
            
            // Try to save to server if available
            await this.saveMealPlanToServer();
            
            // Save and render the new plan
            this.saveMealPlan();
            this.renderMealPlanner();
            this.updateNutritionSummary();
            
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification('✨ Smart meal plan generated successfully!');
            }
            
        } catch (error) {
            console.error('Error generating weekly plan:', error);
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification('Error generating meal plan. Please try again.', 'error');
            }
        }
    }

    async saveMealPlanToServer() {
        const baseUrl = window.moodFoodApp?.baseUrl || '';
        const sessionId = window.moodFoodApp?.sessionId;
        const csrfToken = window.moodFoodApp?.csrfToken;
        
        if (!baseUrl || !sessionId || !csrfToken) {
            console.log('Server meal plan save not available');
            return;
        }

        try {
            const response = await fetch(`${baseUrl}/api/meal-plans`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    start_date: this.currentWeek[0].date.toISOString().split('T')[0],
                    end_date: this.currentWeek[6].date.toISOString().split('T')[0],
                    meal_plan_data: this.mealPlan,
                    target_calories: 2000, // Could be made configurable
                    dietary_restrictions: window.moodFoodApp?.selectedPreferences || []
                })
            });

            if (response.ok) {
                console.log('Meal plan saved to server successfully');
            }
        } catch (error) {
            console.warn('Failed to save meal plan to server:', error);
        }
    }

    async loadMealPlanFromServer() {
        const baseUrl = window.moodFoodApp?.baseUrl || '';
        const sessionId = window.moodFoodApp?.sessionId;
        
        if (!baseUrl || !sessionId) {
            return null;
        }

        try {
            const startDate = this.currentWeek[0].date.toISOString().split('T')[0];
            const response = await fetch(`${baseUrl}/api/meal-plans/recipes?session_id=${sessionId}&start_date=${startDate}`);
            
            if (response.ok) {
                const data = await response.json();
                console.log('Loaded meal plan from server:', data);
                return data;
            }
        } catch (error) {
            console.warn('Failed to load meal plan from server:', error);
        }
        
        return null;
    }

    getFallbackMoodData() {
        return {
            sedih: {
                natural: [
                    { name: "Pisang", benefits: "Meningkatkan serotonin", calories: 89, protein: 1.1, carbs: 23, fats: 0.3 },
                    { name: "Dark Chocolate", benefits: "Melepas endorfin", calories: 155, protein: 2.2, carbs: 13, fats: 12 }
                ]
            },
            bahagia: {
                natural: [
                    { name: "Alpukat", benefits: "Energi berkelanjutan", calories: 160, protein: 2, carbs: 9, fats: 15 }
                ]
            }
        };
    }

    getFallbackRecipes() {
        return {
            recipes: [
                {
                    name: "Smoothie Pisang",
                    mood: "sedih",
                    difficulty: "mudah",
                    prepTime: "5 menit",
                    servings: 1,
                    calories: 180,
                    protein: 6,
                    carbs: 35,
                    fats: 2,
                    benefits: "Meningkatkan produksi serotonin"
                },
                {
                    name: "Avocado Toast",
                    mood: "bahagia",
                    difficulty: "mudah",
                    prepTime: "10 menit",
                    servings: 1,
                    calories: 280,
                    protein: 8,
                    carbs: 30,
                    fats: 18,
                    benefits: "Mempertahankan mood positif"
                }
            ]
        };
    }

    selectMealForType(moodFoods, recipes, mealCategory, dayIndex) {
        // Get foods suitable for the current mood
        const suitableFoods = moodFoods.foods || [];
        
        // Filter recipes based on meal category and mood foods
        let categoryRecipes = [];
        
        if (mealCategory === 'breakfast') {
            categoryRecipes = recipes.filter(recipe => 
                recipe.category === 'sarapan' || 
                recipe.tags?.includes('breakfast') ||
                suitableFoods.some(food => 
                    recipe.name.toLowerCase().includes(food.toLowerCase()) ||
                    recipe.ingredients?.some(ing => ing.toLowerCase().includes(food.toLowerCase()))
                )
            );
        } else if (mealCategory === 'lunch') {
            categoryRecipes = recipes.filter(recipe => 
                recipe.category === 'utama' || 
                recipe.tags?.includes('lunch') ||
                suitableFoods.some(food => 
                    recipe.name.toLowerCase().includes(food.toLowerCase()) ||
                    recipe.ingredients?.some(ing => ing.toLowerCase().includes(food.toLowerCase()))
                )
            );
        } else if (mealCategory === 'dinner') {
            categoryRecipes = recipes.filter(recipe => 
                recipe.category === 'utama' || 
                recipe.tags?.includes('dinner') ||
                suitableFoods.some(food => 
                    recipe.name.toLowerCase().includes(food.toLowerCase()) ||
                    recipe.ingredients?.some(ing => ing.toLowerCase().includes(food.toLowerCase()))
                )
            );
        } else { // snack
            categoryRecipes = recipes.filter(recipe => 
                recipe.category === 'cemilan' || 
                recipe.tags?.includes('snack') ||
                suitableFoods.some(food => 
                    recipe.name.toLowerCase().includes(food.toLowerCase()) ||
                    recipe.ingredients?.some(ing => ing.toLowerCase().includes(food.toLowerCase()))
                )
            );
        }
        
        // If no specific recipes found, use mood foods
        if (categoryRecipes.length === 0 && suitableFoods.length > 0) {
            const foodIndex = (dayIndex * this.mealTypes.indexOf(mealCategory)) % suitableFoods.length;
            const selectedFood = suitableFoods[foodIndex];
            
            return {
                name: selectedFood,
                calories: this.estimateCalories(selectedFood, mealCategory),
                protein: this.estimateProtein(selectedFood, mealCategory),
                carbs: this.estimateCarbs(selectedFood, mealCategory),
                fats: this.estimateFats(selectedFood, mealCategory),
                source: 'mood-based'
            };
        }
        
        // Select a recipe ensuring variety across the week
        if (categoryRecipes.length > 0) {
            const recipeIndex = (dayIndex * this.mealTypes.length + this.mealTypes.indexOf(mealCategory)) % categoryRecipes.length;
            const selectedRecipe = categoryRecipes[recipeIndex];
            
            return {
                name: selectedRecipe.name,
                calories: selectedRecipe.nutrition?.calories || this.estimateCalories(selectedRecipe.name, mealCategory),
                protein: selectedRecipe.nutrition?.protein || this.estimateProtein(selectedRecipe.name, mealCategory),
                carbs: selectedRecipe.nutrition?.carbs || this.estimateCarbs(selectedRecipe.name, mealCategory),
                fats: selectedRecipe.nutrition?.fats || this.estimateFats(selectedRecipe.name, mealCategory),
                recipe: selectedRecipe,
                source: 'recipe'
            };
        }
        
        return null;
    }

    // Helper methods for nutrition estimation
    estimateCalories(foodName, mealCategory) {
        const baseCalories = {
            'breakfast': 300,
            'lunch': 500,
            'dinner': 400,
            'snack': 150
        };
        
        // Adjust based on food type
        const food = foodName.toLowerCase();
        let multiplier = 1;
        
        if (food.includes('nasi') || food.includes('pasta')) multiplier = 1.2;
        else if (food.includes('salad') || food.includes('sayur')) multiplier = 0.7;
        else if (food.includes('daging') || food.includes('ayam')) multiplier = 1.1;
        else if (food.includes('buah')) multiplier = 0.6;
        
        return Math.round((baseCalories[mealCategory] || 200) * multiplier);
    }

    estimateProtein(foodName, mealCategory) {
        const food = foodName.toLowerCase();
        if (food.includes('daging') || food.includes('ayam') || food.includes('ikan')) return 25;
        if (food.includes('telur')) return 15;
        if (food.includes('tahu') || food.includes('tempe')) return 12;
        if (food.includes('susu') || food.includes('yogurt')) return 8;
        return 5;
    }

    estimateCarbs(foodName, mealCategory) {
        const food = foodName.toLowerCase();
        if (food.includes('nasi') || food.includes('pasta') || food.includes('roti')) return 45;
        if (food.includes('kentang')) return 30;
        if (food.includes('buah')) return 20;
        if (food.includes('sayur')) return 10;
        return 15;
    }

    estimateFats(foodName, mealCategory) {
        const food = foodName.toLowerCase();
        if (food.includes('alpukat') || food.includes('kacang')) return 15;
        if (food.includes('minyak') || food.includes('mentega')) return 10;
        if (food.includes('daging')) return 8;
        if (food.includes('ikan')) return 6;
        return 3;
    }

    // Method to add food to the first available slot or currently selected slot
    addFoodToCurrentSlot(foodName) {
        // Find food data from app if available
        let food = null;
        
        if (window.moodFoodApp && window.moodFoodApp.moodData) {
            // Search through mood data
            for (const mood in window.moodFoodApp.moodData) {
                const moodFoods = window.moodFoodApp.moodData[mood];
                
                if (moodFoods.natural) {
                    const found = moodFoods.natural.find(f => f.name === foodName);
                    if (found) {
                        food = found;
                        break;
                    }
                }
                
                if (moodFoods.processed) {
                    const found = moodFoods.processed.find(f => f.name === foodName);
                    if (found) {
                        food = found;
                        break;
                    }
                }
            }
        }
        
        // Create basic meal data if not found
        if (!food) {
            food = { 
                name: foodName, 
                calories: 200, 
                protein: 5, 
                carbs: 15, 
                fats: 5
            };
        }
        
        // Create meal object
        const meal = {
            name: food.name,
            calories: food.calories || 0,
            protein: food.protein || 0,
            carbs: food.carbs || 0,
            fats: food.fats || 0,
            source: 'added'
        };
        
        // Find today's slot that is empty
        const today = new Date().toDateString();
        
        // If today is not in the current week, we can't add a meal
        if (!this.mealPlan[today]) {
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification('Hari ini tidak ada dalam tampilan minggu ini. Silakan navigasi ke minggu saat ini.', 'warning');
            }
            return false;
        }
        
        // Find first empty slot for today
        let slotFound = false;
        
        for (const mealType of this.mealTypes) {
            if (!this.mealPlan[today][mealType]) {
                this.mealPlan[today][mealType] = meal;
                slotFound = true;
                break;
            }
        }
        
        if (!slotFound) {
            if (window.moodFoodApp) {
                window.moodFoodApp.showNotification('Semua slot makanan untuk hari ini sudah terisi. Hapus makanan terlebih dahulu.', 'warning');
            }
            return false;
        }
        
        // Update the UI
        this.saveMealPlan();
        this.renderMealPlanner();
        this.updateNutritionSummary();
        
        return true;
    }

    // Add drag and drop visual feedback functionality within the class
    addDragDropVisualFeedback() {
        // Add dragover class to meal slots when dragging
        document.addEventListener('dragover', (e) => {
            const mealSlot = e.target.closest('.meal-slot');
            if (mealSlot) {
                mealSlot.classList.add('drag-over');
            }
        });

        // Remove dragover class when dragleave
        document.addEventListener('dragleave', (e) => {
            const mealSlot = e.target.closest('.meal-slot');
            if (mealSlot) {
                mealSlot.classList.remove('drag-over');
            }
        });

        // Remove dragover class when drop
        document.addEventListener('drop', (e) => {
            document.querySelectorAll('.meal-slot.drag-over').forEach(slot => {
                slot.classList.remove('drag-over');
            });
        });
    }};
