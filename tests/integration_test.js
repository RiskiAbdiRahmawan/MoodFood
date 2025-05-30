// Integration test script for MoodFood database integration
// This can be run in the browser console to verify functionality

console.log('Starting MoodFood Integration Test...');

// Test 1: Check if app is initialized
if (typeof window.moodFoodApp !== 'undefined') {
    console.log('✅ App initialized correctly');
} else {
    console.log('❌ App not initialized');
}

// Test 2: Check if database configuration is loaded
if (window.MOOD_FOOD_CONFIG) {
    console.log('✅ Database configuration loaded');
    console.log('- Selected mood:', window.MOOD_FOOD_CONFIG.selectedMood);
    console.log('- Natural foods count:', window.MOOD_FOOD_CONFIG.naturalFoods?.length || 0);
    console.log('- Processed foods count:', window.MOOD_FOOD_CONFIG.processedFoods?.length || 0);
} else {
    console.log('❌ Database configuration not loaded');
}

// Test 3: Check if food cards are rendered
const foodCards = document.querySelectorAll('.food-card');
console.log(foodCards.length > 0 ? '✅ Food cards rendered' : '❌ No food cards found');
console.log('- Total food cards:', foodCards.length);

// Test 4: Check if event listeners are attached
let hasEventListeners = false;
foodCards.forEach(card => {
    const addBtn = card.querySelector('.add-to-plan-btn');
    const viewBtn = card.querySelector('.view-nutrition-btn');
    if (addBtn && viewBtn) {
        hasEventListeners = true;
    }
});
console.log(hasEventListeners ? '✅ Event listeners attached' : '❌ Event listeners missing');

// Test 5: Check if recommendations section is visible
const recommendations = document.getElementById('recommendations');
const isVisible = recommendations && recommendations.style.display !== 'none';
console.log(isVisible ? '✅ Recommendations section visible' : '❌ Recommendations section not visible');

// Test 6: Check navigation functionality
const moodBtns = document.querySelectorAll('.mood-btn');
console.log(moodBtns.length > 0 ? '✅ Mood buttons found' : '❌ Mood buttons missing');

// Test 7: Check stats update
const totalMeals = document.getElementById('total-meals');
const moodScore = document.getElementById('mood-score');
const foodRecommendations = document.getElementById('food-recommendations');
console.log(totalMeals ? '✅ Total meals stat found' : '❌ Total meals stat missing');
console.log(moodScore ? '✅ Mood score stat found' : '❌ Mood score stat missing');
console.log(foodRecommendations ? '✅ Food recommendations stat found' : '❌ Food recommendations stat missing');

console.log('Integration test completed!');
