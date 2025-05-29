<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'type',
        'rating',
        'content',
        'scope',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the user session
     */
    public function userSession()
    {
        return $this->belongsTo(UserSession::class, 'session_id', 'session_id');
    }

    /**
     * Scope for unprocessed feedback
     */
    public function scopeUnprocessed($query)
    {
        return $query->where('is_processed', false);
    }

    /**
     * Scope for specific type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for recent feedback
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('submitted_at', '>=', now()->subDays($days));
    }

    /**
     * Mark as processed
     */
    public function markAsProcessed()
    {
        $this->update(['is_processed' => true]);
    }
}
