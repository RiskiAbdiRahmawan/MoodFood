<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecommendationModel;

class MoodModel extends Model
{
    //
    protected $table = 'moods';
    protected $fillable = ['name', 'emoji_icon', 'description'];

    public function recommendations()
    {
        return $this->hasMany(RecommendationModel::class, 'mood_id');
    }
}
