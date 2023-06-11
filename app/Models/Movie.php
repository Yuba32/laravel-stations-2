<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    public function genre()
    {
        return $this->belongsTo('App\Models\Genre');
    }
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
}
