<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FoodCategoryModel;

class FoodModel extends Model
{
    //
    protected $table = 'foods';
    protected $fillable = ['name', 'category_id', 'description', 'image_url'];

    public function category()
    {
        return $this->belongsTo(FoodCategoryModel::class);
    }
}
