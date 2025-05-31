<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MealPlan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'name',
        'start_date',
        'end_date',
        'preferences',
        'notes',
        'total_calories',
        'is_active'
    ];

    protected $casts = [
        'preferences' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Get the meal plan items
     */
    public function items()
    {
        return $this->hasMany(MealPlanItem::class);
    }

    /**
     * Get the user session
     */
    public function userSession()
    {
        return $this->belongsTo(UserSession::class, 'session_id', 'session_id');
    }

    /**
     * Scope for active meal plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for current week meal plans
     */
    public function scopeCurrentWeek($query)
    {
        $now = now();
        $startOfWeek = $now->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();
        
        return $query->where(function($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('start_date', [$startOfWeek, $endOfWeek])
              ->orWhereBetween('end_date', [$startOfWeek, $endOfWeek])
              ->orWhere(function($q2) use ($startOfWeek, $endOfWeek) {
                  $q2->where('start_date', '<=', $startOfWeek)
                     ->where('end_date', '>=', $endOfWeek);
              });
        });
    }

    /**
     * Update the total calories for this meal plan
     */
    public function updateTotalCalories()
    {
        $totalCalories = $this->items->sum(function ($item) {
            return $item->calculated_calories;
        });

        $this->update(['total_calories' => $totalCalories]);
        
        return $totalCalories;
    }
}
