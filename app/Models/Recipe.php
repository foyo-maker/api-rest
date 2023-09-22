<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_name','recipe_image','recipe_description','recipe_servings'];

    public function recipediseases()
    {
        return $this->belongsToMany(Disease::class,'disease_recipes','disease_id','recipe_id')->withPivot('id');
    }

}
