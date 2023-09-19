<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'gifimage',
        'calorie',
        'link',
        'bmi_status'
        // Add any other fields you need for the Workout entity here
    ];

    protected $table = 'workouts'; // Set the table name to 'workouts'
}
