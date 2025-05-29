<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietaryPreferencesModel extends Model
{
    //
    protected $table = 'dietary_preferences';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'emoji_icon'];
}
