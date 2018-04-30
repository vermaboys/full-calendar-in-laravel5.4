<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CalendarAvailability;
use App\CalendarHoliday;
use Auth;
use Session;
class CalenderController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    * getCalender function is call that time when user visit calender page
    * there are two parameters in $_REQUEST like start and end
    * start like 2017-11-11T9:15:25 and end like 2017-11-17T12:35:35 
    */
    function getCalender(Request $request){

        $auth_id=Auth::user()->id;

        if((isset($request->start) && $request->start!='') && (isset($request->end) && $request->end!='')){
            
            /*
            * start_date is getting only date like 2017-11-11 in 2017-11-11T9:15:25
            * end_date is getting only date like 2017-11-17 in 2017-11-17T12:35:35 
            */
            $start_date= str_replace(strstr($request->start, 'T') , "", $request->start);

            $end_date= str_replace(strstr($request->end, 'T') , "", $request->end);

            $array=array();

            /*
            * get_time is getting the record according to user logged id 
            */
            $get_time=CalendarAvailability::select('start_time','end_time','reocuuring')
                ->where('user_id',$auth_id)
                ->get();
            
            /*
            * $array[] is getting all dates between two dates 2017-11-11 to 2017-11-17
            * 2017-11-11,
            * 2017-11-12,
            * 2017-11-13,
            * 2017-11-14,
            * 2017-11-15,
            * 2017-11-16,
            * 2017-11-17
            */
            for ($x=strtotime($start_date);$x<strtotime($end_date);$x+=86400){
                
             $array[]=date('Y-m-d',$x);

            }

            /*
            * $get_time[0]->reocuuring==0 the sunday,saturday schedule is not display
            * $get_time[0]->reocuuring==1 the sunday schedule is not display
            * $get_time[0]->reocuuringis not equal to 0 or 1 then schedule is display for all days means daily
            */
            if(isset($get_time[0]->reocuuring) && $get_time[0]->reocuuring=='0'){
                unset($array[0]);
                unset($array[6]);
            }elseif (isset($get_time[0]->reocuuring) && $get_time[0]->reocuuring=='1') {
                 unset($array[0]);
            }
            
            /*
            * get_holiday_days is getting the holiday dates user logged id and all dates 
            */
            $get_holiday_days=CalendarHoliday::select('holiday_date')
                ->where('user_id',$auth_id)
                ->whereIn('holiday_date', $array)
                ->get();
            
            /*
            * $array is gettting that dates which is not in CalenderHoliday table
            */
            for ($i=0; $i <count($get_holiday_days) ; $i++) {
                if(array_search ($get_holiday_days[$i]->holiday_date, $array)){
                 $array = array_diff($array, [$get_holiday_days[$i]->holiday_date]);
                }
              
            }

            /*
            * $arr is getting start date with start time  and end date with end time 
            */
            $arr = array();
            foreach ($array as $key => $value) {
                $start=$value.'T'.$get_time[0]->start_time;
                $end=$value.'T'.$get_time[0]->end_time;
                $arr[] = array('start' =>$start ,'end' =>$end);
            }

            echo json_encode($arr);die;
            
        }
 
       return view('calender.get_calender');
    }

    /*
    * addCalenderData function is called taht time when user create new schedule
    * there are four parameters in $_REQUEST like from_time, to_time, schedule , date_hidden
    */
    function addCalenderData(Request $request){

        /*
        * from time means start time
        * to_time means end time
        * date_hidden means your selected schedule date
        * schedule either 0 ,1 or 2
        * 1 means monday to friday
        * 2 means monday to saturday
        * 3 means daily
        */

        $from_time      = $request->from_time;
        $to_time        = $request->to_time;
        $id             = Auth::user()->id;
        $schedule_day   = $request->schedule;
        $date           = $request->date_hidden;

        /*
        * get_data count the roes according to user logged id in CalendarAvailability table 
        */

        $get_data=CalendarAvailability::where('user_id',$id)->count();
        /*
        * if get_data > 0 the redirect back with message
        */

        if($get_data>0){
            Session::flash('status_warning','Your schedule event already has been created');
            return redirect()->back();
        }

        /*
        * if get_data in not grater then 0 then data will add in CalendarAvailability
        */
        $data=array('user_id'=>$id,
                    'start_time'=>$from_time,
                    'end_time'=>$to_time,
                    'reocuuring'=>$schedule_day
                    );

        CalendarAvailability::create($data);
        
        Session::flash('status','Successfully added');
        return redirect()->back();

    }

    /*
    *  calenderHolidayDel function is call that time when user mark schedule as a holiday or delete
    * there are two parameters in $_REQUEST like date_hidden,schedule
    * date_hiiden means selected schedule day
    * schedule is either 1 or 2
    * 1 means holiday and 2 means delete
    */
    function calenderHolidayDel(Request $request){

        $id     = Auth::user()->id;
        $date   = $request->date_hidden;
        $action = $request->schedule;

        if($action==1){

            CalendarHoliday::create(['user_id'=>$id,
                                        'holiday_date'=>$date]);

            $status_msg='Successfully updated';
            
        }
        else{

            CalendarAvailability::where('user_id',$id)->delete();

            CalendarHoliday::where('user_id',$id)->delete();

            $status_msg='Successfully deleted';
        }

        Session::flash('status',$status_msg);

        return redirect()->back();

    }

    /*
    * changeSchedule function is call when user change schedule time
    * There are three parameters in $_REQUEST  like start time,end time and today date 
    */
    function changeSchedule(Request $request){

        $id         =  Auth::user()->id;
        $from_time  =  $request->from_time;
        $to_time    =  $request->to_time;
        $today_date =  date('Y-m-d');

        /*
        * update end time using to_time variable
        * according to logged id
        */

        CalendarAvailability::where('user_id',$id)
                                        ->update(['end_time'=>$to_time]);

        Session::flash('status','Successfully updated');

        return redirect()->back();
    }

}
