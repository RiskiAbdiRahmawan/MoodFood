<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoodTracking extends Model
{
    use HasFactory;
    
    protected $table = 'mood_tracking';
    
    protected $fillable = [
        'session_id',
        'mood_id',
        'dietary_preference_id',
        'intensity',
        'selected_foods',
        'tracked_at'
    ];

    protected $casts = [
        'selected_foods' => 'array',
        'tracked_at' => 'datetime',
    ];

    /**
     * Get the mood that was tracked
     */
    public function mood()
    {
        return $this->belongsTo(MoodModel::class, 'mood_id');
    }

    /**
     * Get the dietary preference
     */
    public function dietaryPreference()
    {
        return $this->belongsTo(DietaryPreferencesModel::class, 'dietary_preference_id');
    }

    /**
     * Get the user session
     */
    public function userSession()
    {
        return $this->belongsTo(UserSession::class, 'session_id', 'session_id');
    }

    /**
     * Scope for recent tracking data
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('tracked_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for specific mood
     */
    public function scopeByMood($query, $moodId)
    {
        return $query->where('mood_id', $moodId);
    }
}
