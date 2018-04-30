# full-calendar-in-laravel5.4

# You Tube
https://youtu.be/VVo49y5nznM

# Step First:-Clone Full Project
```
Run git clone https://github.com/vermaboys/full-calendar-in-laravel5.4 command on terminal
Run php artisan migrate command on terminal
You can access calendar using localhost/full-calendar-in-laravel5.4/calendar
```

# Step Second:-You can also include files in project
```
1) Copy get_calender.blade file in resources\views\calendar and firstly create a new folder that is calendar in resources\views\ and paste in resources\views\calendar folder
2) Copy calendar.blade file in resources\views\layouts and paste in your resources\views\layouts folder
3) Copy calendar folder in public folder and paste in your public folder
```

# Route
```
Copy all routes which is given below and paste in your web.php file
Route::any('/calendar', 'CalenderController@getCalender');
Route::post('/add-calendar-data', 'CalenderController@addCalenderData');
Route::post('/calendar-holiday-del', 'CalenderController@calenderHolidayDel');
Route::post('/change-schedule', 'CalenderController@changeSchedule');
```

# In app file
```
Copy array which is given below paste in your app.php file which is inside config folder
'full_calender_schedule'=>array('0'=>'Monday to Friday','1'=>'Monday to Saturday','2'=>'Daily')
```

# Model
```
Copy CalendarAvailability and CalendarHoliday model in app folder and paste in your app folder
```

# Migration
```
Copy two migration files in database\migrations folder which is given below and paste in your database\migrations folder
1) 2018_04_30_064750_calender_availability
2) 2018_04_30_064830_calendar_holiday

Now run php artisan migrate command on terminal
```



