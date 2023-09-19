<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    
    protected $fillable = ['hospital_name','hospital_contact','hospital_address'];

    public function hospitaldiseases()
    {
        return $this->belongsToMany(Disease::class,'disease_hospitals','disease_id','hospital_id')->withPivot('id');
    }
}
