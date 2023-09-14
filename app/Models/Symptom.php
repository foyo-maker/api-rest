<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = ['symptom_name','symptom_image','symptom_descriptionn'];

    public function diseases()
    {
        return $this->belongsToMany(Disease::class,'disease_symptoms','disease_id','symptom_id')->withPivot('id');
    }
}
