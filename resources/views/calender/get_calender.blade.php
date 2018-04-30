@extends('layouts.calendar')
@section('content')

     
<div class="">
  <section class="content">
    @if (session('status'))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
                    {{ session('status') }}
                </div>
            </div>
        </div>
      @endif
      @if (session('status_warning'))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
                    {{ session('status_warning') }}
                </div>
            </div>
        </div>
      @endif
    <div class="row">
      <div class="col-xs-12">
        <div class="box newBorderTop newBox">
          <div class="box-header" id="calender-header">
            <h3>Your daily Schedule</h3>
          </div>
          <div class="box-body" id="calender-box-body">
              <div id='calendar'></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
  
<div id="calenderModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="calender-header">
            <span id="date-header"></span>
          </h4>
        </div>
        <div class="modal-body" id="calender_modal_body">
          <form class="full-calender-form" id="full-calender-form" action="{{url('add-calendar-data')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="from_time" id="from_time" value="">
            <input type="hidden" name="to_time" id="to_time" value="">
            <input type="hidden" name="date_hidden" class="date-hidden" value="">
              <div id="checkboxGroup">
                @foreach(config('app.full_calender_schedule') as $key=>$value)
                <label class="checkbox-inline">
                  <input type="radio" value="{{$key}}" class="schedule" name="schedule">&nbsp;&nbsp;{{$value}}
                </label>
                @endforeach
              </div>
              <div class="error schedule-error" style="display: none;"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="fullCalender();">Submit</button>
              </div>
          </form>
        </div>
    </div>
  </div>
</div>

<style>
body {margin: 0;padding: 0;font-size: 14px;}
</style>
<script>

$(document).ready(function() {

  $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
         right: 'agendaWeek'
      },
      defaultView: 'agendaWeek',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectHelper: true,
      selectOverlap: false,
      select: function(start, end) {
        loadPopupBox(start, end);
      },
      editable: true,
      eventStartEditable: false,
      eventLimit: true,
      showNonCurrentDates: false,
      events: '<?php echo url("calendar");  ?>',
      eventClick: function(calEvent, jsEvent, view) {
        dt = calEvent.start;
        loadPopupHoliday(dt);
        $('#full-calender-form').attr('action',"<?php echo url('calendar-holiday-del'); ?>");
      },
      eventResize: function(event, delta, revertFunc) {
        end=event.end.format();
        start=event.start.format();
        loadPopupResize(end,start);
        $('#full-calender-form').attr('action',"<?php echo url('change-schedule'); ?>");
      }
  });

});
</script>


@endsection