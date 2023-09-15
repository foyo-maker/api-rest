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


