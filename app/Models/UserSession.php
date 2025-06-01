<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSession extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'last_ip_address',
        'last_user_agent',
        'preferences',
        'total_visits',
        'first_visit_at',
        'last_activity_at',
        'expires_at'
    ];

    protected $casts = [
        'preferences' => 'array',
        'first_visit_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    /**
     * Relationship with meal plans
     */
    public function mealPlans(): HasMany
    {
        return $this->hasMany(MealPlan::class, 'session_id', 'id');
    }

    /**
     * Get mood tracking records for this session
     */
    public function moodTracking(): HasMany
    {
        return $this->hasMany(MoodTracking::class, 'session_id', 'id');
    }

    /**
     * Get food analytics for this session
     */
    public function foodAnalytics(): HasMany
    {
        return $this->hasMany(FoodAnalytics::class, 'session_id', 'id');
    }

    /**
     * Get feedback from this session
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class, 'session_id', 'id');
    }

    /**
     * Update last activity
     */
    public function updateActivity()
    {
        $this->update([
            'last_activity_at' => now(),
            'total_visits' => $this->total_visits + 1
        ]);
    }

    /**
     * Scope for active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Scope for expired sessions
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Check if session is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at <= now();
    }

    /**
     * Extend session expiry
     */
    public function extend(int $days = 30): void
    {
        $this->update(['expires_at' => now()->addDays($days)]);
    }
}
