<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodAnalytics extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'food_name',
        'interaction_type',
        'metadata',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the user session
     */
    public function userSession()
    {
        return $this->belongsTo(UserSession::class, 'session_id', 'session_id');
    }

    /**
     * Scope for specific interaction type
     */
    public function scopeByInteractionType($query, $interactionType)
    {
        return $query->where('interaction_type', $interactionType);
    }

    /**
     * Scope for popular foods (most interactions)
     */
    public function scopePopularFoods($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
                    ->selectRaw('food_name, COUNT(*) as interaction_count')
                    ->groupBy('food_name')
                    ->orderByDesc('interaction_count');
    }

    /**
     * Scope for recent analytics
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
