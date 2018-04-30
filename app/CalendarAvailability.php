<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarAvailability extends Model
{
    protected $table = 'calendar_availability'; 
    protected $fillable = ['user_id','start_time','end_time','reocuuring'];
}
