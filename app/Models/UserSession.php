<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSession extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'preferences',
        'total_visits',
        'first_visit_at',
        'last_activity_at'
    ];

    protected $casts = [
        'preferences' => 'array',
        'first_visit_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get mood tracking records for this session
     */
    public function moodTracking()
    {
        return $this->hasMany(MoodTracking::class, 'session_id', 'session_id');
    }

    /**
     * Get food analytics for this session
     */
    public function foodAnalytics()
    {
        return $this->hasMany(FoodAnalytics::class, 'session_id', 'session_id');
    }

    /**
     * Get feedback from this session
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'session_id', 'session_id');
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
}
