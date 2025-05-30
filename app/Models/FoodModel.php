<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FoodCategoryModel;
use App\Models\NutritionData;

class FoodModel extends Model
{
    //
    protected $table = 'foods';
    protected $fillable = ['name', 'category_id', 'description', 'image_url'];

    public function category()
    {
        return $this->belongsTo(FoodCategoryModel::class);
    }

    public function nutritionData()
    {
        return $this->hasOne(NutritionData::class, 'food_id');
    }
}
