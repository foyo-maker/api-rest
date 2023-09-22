<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'image',
        'date',
        'address',
        'status',
        'user_id'
    ];

    public function participants()
    {
        return $this->hasMany(EventParticipants::class, 'event_id');
    }

}
