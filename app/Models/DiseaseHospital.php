<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseHospital extends Model
{
    use HasFactory;
    protected $fillable = ['disease_id, hospital_id'];
}
