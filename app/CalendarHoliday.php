<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarHoliday extends Model
{
    protected $table = 'calendar_holiday'; 
    protected $fillable = ['user_id','holiday_date'];
}
