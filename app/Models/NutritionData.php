<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NutritionData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'food_id',
        'calories_per_100g',
        'protein_g',
        'carbohydrates_g',
        'fat_g',
        'fiber_g',
        'sugar_g',
        'sodium_mg',
        'vitamin_c_mg',
        'iron_mg',
        'calcium_mg',
        'other_nutrients',
        'health_benefits',
        'mood_effects'
    ];

    protected $casts = [
        'other_nutrients' => 'array',
        'calories_per_100g' => 'decimal:2',
        'protein_g' => 'decimal:2',
        'carbohydrates_g' => 'decimal:2',
        'fat_g' => 'decimal:2',
        'fiber_g' => 'decimal:2',
        'sugar_g' => 'decimal:2',
        'sodium_mg' => 'decimal:2',
        'vitamin_c_mg' => 'decimal:2',
        'iron_mg' => 'decimal:2',
        'calcium_mg' => 'decimal:2',
    ];

    /**
     * Get the food that this nutrition data belongs to
     */
    public function food()
    {
        return $this->belongsTo(FoodModel::class, 'food_id');
    }

    /**
     * Calculate nutrition for specific portion
     */
    public function calculatePortionNutrition($grams)
    {
        $multiplier = $grams / 100;
        
        return [
            'calories' => $this->calories_per_100g * $multiplier,
            'protein' => $this->protein_g * $multiplier,
            'carbohydrates' => $this->carbohydrates_g * $multiplier,
            'fat' => $this->fat_g * $multiplier,
            'fiber' => $this->fiber_g * $multiplier,
            'sugar' => $this->sugar_g * $multiplier,
            'sodium' => $this->sodium_mg * $multiplier,
            'vitamin_c' => $this->vitamin_c_mg * $multiplier,
            'iron' => $this->iron_mg * $multiplier,
            'calcium' => $this->calcium_mg * $multiplier,
        ];
    }

    /**
     * Get foods high in specific nutrient
     */
    public static function highIn($nutrient, $limit = 10)
    {
        $column = $nutrient . '_per_100g';
        if (!in_array($column, ['calories_per_100g'])) {
            $column = $nutrient . '_g';
            if (!in_array($column, ['protein_g', 'carbohydrates_g', 'fat_g', 'fiber_g', 'sugar_g'])) {
                $column = $nutrient . '_mg';
            }
        }
        
        return static::with('food')
                    ->orderByDesc($column)
                    ->limit($limit)
                    ->get();
    }
}
