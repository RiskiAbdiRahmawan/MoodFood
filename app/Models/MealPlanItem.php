<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MealPlanItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'meal_plan_id',
        'meal_date',
        'meal_type',
        'recipe_id',
        'food_id',
        'custom_food_name',
        'custom_calories',
        'custom_protein',
        'custom_carbs',
        'custom_fats',
        'serving_size',
        'notes'
    ];

    protected $casts = [
        'meal_date' => 'date',
        'custom_calories' => 'decimal:2',
        'custom_protein' => 'decimal:2',
        'custom_carbs' => 'decimal:2',
        'custom_fats' => 'decimal:2',
        'serving_size' => 'decimal:2'
    ];

    /**
     * Get the meal plan
     */
    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }

    /**
     * Get the recipe
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Get the food
     */
    public function food()
    {
        return $this->belongsTo(FoodModel::class, 'food_id');
    }

    /**
     * Get calculated calories
     */
    public function getCalculatedCaloriesAttribute()
    {
        if ($this->custom_calories) {
            return $this->custom_calories * $this->serving_size;
        }
        
        if ($this->recipe) {
            return $this->recipe->calories_per_serving * $this->serving_size;
        }
        
        if ($this->food && $this->food->nutritionData) {
            return $this->food->nutritionData->calories_per_100g * $this->serving_size;
        }
        
        return 0;
    }

    /**
     * Get calculated protein
     */
    public function getCalculatedProteinAttribute()
    {
        if ($this->custom_protein) {
            return $this->custom_protein * $this->serving_size;
        }
        
        if ($this->recipe) {
            return $this->recipe->protein_per_serving * $this->serving_size;
        }
        
        if ($this->food && $this->food->nutritionData) {
            return $this->food->nutritionData->protein_g * $this->serving_size;
        }
        
        return 0;
    }

    /**
     * Get calculated carbs
     */
    public function getCalculatedCarbsAttribute()
    {
        if ($this->custom_carbs) {
            return $this->custom_carbs * $this->serving_size;
        }
        
        if ($this->recipe) {
            return $this->recipe->carbs_per_serving * $this->serving_size;
        }
        
        if ($this->food && $this->food->nutritionData) {
            return $this->food->nutritionData->carbohydrates_g * $this->serving_size;
        }
        
        return 0;
    }

    /**
     * Get calculated fats
     */
    public function getCalculatedFatsAttribute()
    {
        if ($this->custom_fats) {
            return $this->custom_fats * $this->serving_size;
        }
        
        if ($this->recipe) {
            return $this->recipe->fats_per_serving * $this->serving_size;
        }
        
        if ($this->food && $this->food->nutritionData) {
            return $this->food->nutritionData->fat_g * $this->serving_size;
        }
        
        return 0;
    }

    /**
     * Get the display name
     */
    public function getDisplayNameAttribute()
    {
        if ($this->custom_food_name) {
            return $this->custom_food_name;
        }
        
        if ($this->recipe) {
            return $this->recipe->name;
        }
        
        if ($this->food) {
            return $this->food->name;
        }
        
        return 'Unknown Food';
    }

    /**
     * Scope for specific date
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('meal_date', $date);
    }

    /**
     * Scope for specific meal type
     */
    public function scopeForMealType($query, $mealType)
    {
        return $query->where('meal_type', $mealType);
    }
}
