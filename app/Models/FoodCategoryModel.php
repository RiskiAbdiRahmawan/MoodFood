<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FoodModel;

class FoodCategoryModel extends Model
{
    //
    protected $table = 'food_categories';
    protected $fillable = ['name'];

    public function foods()
    {
        return $this->hasMany(FoodModel::class, 'category_id');
    }
}
