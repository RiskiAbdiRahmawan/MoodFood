/**
 * Diagnostic script to check for common syntax issues in Blade templates
 * Run this in browser console to verify JavaScript syntax
 */

// Check if MOOD_FOOD_CONFIG is properly loaded
console.log('=== MoodFood Syntax Diagnostic ===');

if (typeof window.MOOD_FOOD_CONFIG === 'undefined') {
    console.error('❌ MOOD_FOOD_CONFIG is not defined - check Blade template syntax');
} else {
    console.log('✅ MOOD_FOOD_CONFIG loaded successfully');
    
    // Check each property
    const config = window.MOOD_FOOD_CONFIG;
    console.log('📋 Configuration status:');
    console.log('- sessionId:', typeof config.sessionId);
    console.log('- csrfToken:', typeof config.csrfToken);
    console.log('- baseUrl:', typeof config.baseUrl);
    console.log('- selectedMood:', config.selectedMood);
    console.log('- naturalFoods:', Array.isArray(config.naturalFoods) ? `Array(${config.naturalFoods.length})` : typeof config.naturalFoods);
    console.log('- processedFoods:', Array.isArray(config.processedFoods) ? `Array(${config.processedFoods.length})` : typeof config.processedFoods);
    console.log('- moods:', Array.isArray(config.moods) ? `Array(${config.moods.length})` : typeof config.moods);
    console.log('- dietaryPreferences:', Array.isArray(config.dietaryPreferences) ? `Array(${config.dietaryPreferences.length})` : typeof config.dietaryPreferences);
}

// Check if main app is initialized
if (typeof window.moodFoodApp === 'undefined') {
    console.warn('⚠️ MoodFoodApp not yet initialized');
} else {
    console.log('✅ MoodFoodApp initialized');
}

// Check for syntax errors in inline scripts
const scripts = document.querySelectorAll('script');
let hasInlineScript = false;
scripts.forEach((script, index) => {
    if (script.innerHTML.includes('MOOD_FOOD_CONFIG')) {
        hasInlineScript = true;
        console.log(`✅ Found MOOD_FOOD_CONFIG in script tag ${index + 1}`);
    }
});

if (!hasInlineScript) {
    console.warn('⚠️ No inline script with MOOD_FOOD_CONFIG found');
}

console.log('=== Diagnostic Complete ===');
