<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'category',
        'difficulty',
        'prep_time_minutes',
        'cook_time_minutes',
        'servings',
        'calories_per_serving',
        'protein_per_serving',
        'carbs_per_serving',
        'fats_per_serving',
        'ingredients',
        'instructions',
        'mood_tags',
        'dietary_tags',
        'health_benefits',
        'image_url',
        'is_active'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
        'mood_tags' => 'array',
        'dietary_tags' => 'array',
        'health_benefits' => 'array',
        'calories_per_serving' => 'decimal:2',
        'protein_per_serving' => 'decimal:2',
        'carbs_per_serving' => 'decimal:2',
        'fats_per_serving' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Get the meal plan items that use this recipe
     */
    public function mealPlanItems()
    {
        return $this->hasMany(MealPlanItem::class);
    }

    /**
     * Scope for active recipes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for recipes by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for recipes by mood
     */
    public function scopeByMood($query, $mood)
    {
        // Map Indonesian mood names to English tags used in database
        $moodMapping = [
            'bahagia' => ['happy', 'energetic', 'social'],
            'sedih' => ['comfort', 'calm', 'healing'],
            'cemas' => ['calm', 'peaceful', 'relaxed'],
            'marah' => ['calm', 'peaceful', 'healing'],
            'lelah' => ['energetic', 'focused', 'healthy'],
            'stress' => ['calm', 'peaceful', 'relaxed']
        ];

        $englishTags = $moodMapping[$mood] ?? [$mood];
        
        return $query->where(function($q) use ($englishTags) {
            foreach ($englishTags as $tag) {
                // Simple LIKE pattern works for SQLite with JSON strings
                $q->orWhere('mood_tags', 'LIKE', '%' . $tag . '%');
            }
        });
    }

    /**
     * Scope for recipes by mood (alias for byMood for compatibility)
     */
    public function scopeForMood($query, $mood)
    {
        return $this->scopeByMood($query, $mood);
    }

    /**
     * Scope for recipes by dietary preference
     */
    public function scopeByDietaryTag($query, $tag)
    {
        // Map Indonesian dietary preference names to English tags used in database
        $dietaryMapping = [
            'vegetarian' => 'vegetarian',
            'vegan' => 'vegan',
            'gluten-free' => 'gluten-free',
            'keto' => 'keto',
            'low-carb' => 'low-carb',
            'dairy-free' => 'dairy-free'
        ];

        $englishTag = $dietaryMapping[$tag] ?? $tag;
        
        // Simple LIKE pattern works for SQLite with JSON strings
        return $query->where('dietary_tags', 'LIKE', '%' . $englishTag . '%');
    }

    /**
     * Scope for recipes with multiple dietary tags (alias for compatibility)
     */
    public function scopeWithDietaryTags($query, $tags)
    {
        if (empty($tags)) {
            return $query;
        }
        
        foreach ($tags as $tag) {
            $query->whereJsonContains('dietary_tags', $tag);
        }
        
        return $query;
    }

    /**
     * Scope for recipes by difficulty
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Get total time (prep + cook)
     */
    public function getTotalTimeAttribute()
    {
        return $this->prep_time_minutes + $this->cook_time_minutes;
    }

    /**
     * Get formatted prep time
     */
    public function getFormattedPrepTimeAttribute()
    {
        $minutes = $this->prep_time_minutes;
        if ($minutes < 60) {
            return $minutes . ' menit';
        }
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return $hours . ' jam' . ($remainingMinutes > 0 ? ' ' . $remainingMinutes . ' menit' : '');
    }
}
