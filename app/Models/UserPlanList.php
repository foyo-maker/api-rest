<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlanList extends Model
{
    use HasFactory;
    protected $fillable = ['user_plan_id', 'workout_id','name','user_id','description','link','gifimage','calorie','bmi_status'];

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
