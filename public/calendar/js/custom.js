/*
getHoursTime function returns getUTCMinutes,getUTCHours ,getDate,getMonth ,getFullYear,getUTCSeconds in Sun Mar 11 2018 07:30:00 GMT+0000
*/
function getHoursTime(time){
  var time,get_min,get_hours,get_date,get_month,get_year,data,get_second;

  time        = new Date(time);
  get_min     = time.getUTCMinutes();
  get_hours   = time.getUTCHours();
  get_date    = time.getDate();
  get_month   = time.getMonth();
  get_year    = time.getFullYear();
  get_second  = time.getUTCSeconds();
  get_month   = parseInt(get_month) + 1;

  data  = { hours:get_hours, 
            minute:get_min, 
            date:get_date,
            month:get_month,
            year:get_year,
            second:get_second
          };
  
  return data;
}

/*
* getMonthName return month name according to number
*/
function getMonthName(number){

  month_name = { 1:"January",2: "February",3: "March",4: "April",5: "May",
                 6: "June",7: "July", 8: "August",9: "September",
                 10:"October",11:"November",12: "December"
                }
  return month_name[number];

}
/*
convertTimeIntoAmPm function convert time into AM or PM like 16:30:12 is 4:30PM
*/
function convertTimeIntoAmPm(time){
  var timeString = time;
  var hourEnd = timeString.indexOf(":");
  var H = +timeString.substr(0, hourEnd);
  var h = H % 12 || 12;
  var ampm = H < 12 ? "AM" : "PM";
  timeString = h + timeString.substr(hourEnd, 3) + ampm;
  return timeString

}
/*
* loadPopupBox function is call that time when user add new schedule
*/
function loadPopupBox(from_time, to_time){
  var start_time,end_time,monthNames,data_header,from_time,to_time,month_name,date_hidden;

  start_time=getHoursTime(from_time);
  end_time=getHoursTime(to_time);
  
  month_name=getMonthName(start_time['month']);

  data_header=month_name+' '+start_time['date']+', '+start_time['year'];


  from_time=start_time['hours']+':'+start_time['minute']+':'+start_time['second'];
  end_time=end_time['hours']+':'+end_time['minute']+':'+end_time['second'];

  data_header = "Your schedule is "+data_header+' at '+convertTimeIntoAmPm(from_time)+' to '+convertTimeIntoAmPm(end_time);

  $('#date-header').html(data_header);

  date_hidden=start_time['year']+'-'+start_time['month']+'-'+start_time['date'];
  $('.date-hidden').val(date_hidden);
  $('#from_time').val(from_time);
  $('#to_time').val(end_time);

  
  $('#calenderModal').modal( 'show' );
}
/*
* fullCalender function check radio button is selected or not
*/
function fullCalender(){

  
  if($('.schedule').is(":checked")){
    $('.full-calender-form').submit();
    return true;
  }else{
    $('.schedule-error').show();
    $('.schedule-error').html('<strong>Please select above action</strong>');
    return false;
  }

}
/*
* one argument pass dt in loadPopupHoliday function 
*/
function loadPopupHoliday(dt){
  var full_date,data_header,date,data='';

  date=getHoursTime(dt);

  month_name=getMonthName(date['month']);

  data_header='Your schedule is '+month_name+' '+date['date']+', '+date['year'];

  full_date=date['year']+'-'+date['month']+'-'+date['date'];
  
  data += "<label class='checkbox-inline'>";
  data += "<input type='radio' value='1' class='schedule' id='schedule' name='schedule'>&nbsp;&nbsp;Holiday";
  data += "</label>";
  data += "<label class='checkbox-inline'>";
  data += "<input type='radio' value='2' class='schedule' id='schedule' name='schedule'>&nbsp;&nbsp;Delete(All ocuurs will be delete)";
  data += "</label>";
  
  $('#checkboxGroup').html(data);
  $('.date-hidden').val(full_date);
  $('#date-header').html(data_header);

  $('#calenderModal').modal( 'show' );
}
/*
* two argument pass dt,start_time in loadPopupResize
* dt means end time
*/
function loadPopupResize(dt,start_time){
  var time,convert_time,end_time,full_date;
  end_time=getHoursTime(dt);

  month_name=getMonthName(end_time['month']);

  data_header=month_name+' '+end_time['date']+', '+end_time['year'];

  time=dt.substr(dt.indexOf("T") + 1);
  start_time=start_time.substr(start_time.indexOf("T") + 1);

  convert_time=convertTimeIntoAmPm(time);
  data_header='Your schedule on '+data_header+' at '+convert_time;
  full_date=time;

  $('#checkboxGroup').html('<h4>All schedule day will be change after submit </h4>');
  $('#date-header').html(data_header);
  $('#to_time').val(full_date);
  $('#from_time').val(start_time);
  $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success">Submit</button>');
  $('#calenderModal').modal( 'show' );
}

