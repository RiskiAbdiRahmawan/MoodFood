<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MoodModel;
use App\Models\FoodModel;
use App\Models\DietaryPreferencesModel;

class RecommendationModel extends Model
{
    //
    protected $table = 'recommendations';
    protected $fillable = ['mood_id', 'food_id', 'dietary_preference_id'];

    public function mood()
    {
        return $this->belongsTo(MoodModel::class);
    }

    public function food()
    {
        return $this->belongsTo(FoodModel::class);
    }

    public function dietaryPreference()
    {
        return $this->belongsTo(DietaryPreferencesModel::class);
    }
}
