<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['screening_date', 'schedule_id', 'sheet_id', 'email', 'name', 'is_canceled'];
    protected $dates = ['screening_date'];
    protected $primaryKey = 'id';

//    const time = 'screening_date';

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule');
    }
    public function sheet()
    {
        return $this->belongsTo('App\Models\Sheet');
    }

}
