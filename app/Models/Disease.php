<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = ['disease_name','disease_image','disease_causes','disease_description'];
  
    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class,'disease_symptoms','disease_id','symptom_id')->withPivot('id');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class,'disease_recipes','disease_id','recipe_id')->withPivot('id');
    }
   
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class,'disease_hospitals','disease_id','hospital_id')->withPivot('id');
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diseases');
    }
}


