@extends('layouts.page')
@section('title', 'Dashboard')
@push('pre_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" rel="stylesheet" type="text/css" />
@endpush
@push('css')
<style>
	.kt-svg-icon--success  .kt-svg-icon g [fill] {
    fill:#0abb87 }
	.kt-svg-icon--warning  .kt-svg-icon g [fill] {
    fill:#ffb822; }
	.kt-svg-icon--danger  .kt-svg-icon g [fill] {
    fill:#fd397a; }
	.kt-svg-icon--dark  .kt-svg-icon g [fill] {
    fill:#282a3c;	 }

.topwidget{width: 100%;
    text-align: center;
    background: red;
    padding: 20px 0px;
    color: #fff;
}
.topwidget  svg {
    height: 53px;
    width: 53px;    fill: #fff;
}
.fc-basic-view .fc-body .fc-row {
    min-height: 6em;
}
</style>
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.js" type="text/javascript"></script>


<script>
var KTCalendarBasic = function() {

return {
    //main function to initiate the module
    init: function() {
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        $('#kt_calendar').fullCalendar({
            isRTL: KTUtil.isRTL(),
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listYear,month'
            },
            defaultView: 'listYear',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            events: [
                @foreach($data->get('events') as $e)
                {
                    title: '{{ $e->title }}',
                    start: '{{ $e->start_date }}',
                    end: '{{ $e->end_date }}',
                    description: '{{ $e->description }}',
                    className: 'fc-day-grid-event fc-event-danger fc-event-solid-primary'
                },
                @endforeach

       /*       {
    title:"My repeating event",
    start: '10:00', // a start time (10am in this example)
    end: '10:30', // an end time (2pm in this example)
    dow: [ 1, 4 ], // Repeat monday and thursday,
    description: 'My repeating Events',
    className: 'fc-day-grid-event fc-event-danger fc-event-solid-primary',

    ranges: [{ //repeating events are only displayed if they are within at least one of the following ranges.
        start: moment().startOf('week'), //next two weeks
        end: moment().endOf('week').add(7,'d'),
    },{
        start: moment('2015-02-01','YYYY-MM-DD'), //all of february
        end: moment('2015-02-01','YYYY-MM-DD').endOf('month'),
    },],


},
*/



/*
{
    title:"CSE18R101",
    id: 1,
    start: '10:00', // a start time (10am in this example)
    end: '11:00', // an end time (6pm in this example)
    dow: [ 1 ], // Repeat monday and thursday
    ranges: [{
        start: moment('2019-05-01','YYYY-MM-DD'), //all of february
        end: moment('2019-06-01','YYYY-MM-DD').endOf('month'),
    }],
	description: 'My description',
},

{
    title:"CSE18R102",
    id: 1,
    start: '11:00', // a start time (10am in this example)
    end: '12:00', // an end time (6pm in this example)
    dow: [ 1 ], // Repeat monday and thursday
    ranges: [{
        start: moment('2019-05-01','YYYY-MM-DD'), //all of february
        end: moment('2019-05-01','YYYY-MM-DD').endOf('month'),
    }],
	description: 'My description',
},

{
    title:"MAT18R101",
    id: 1,
    start: '13:00', // a start time (10am in this example)
    end: '14:00', // an end time (6pm in this example)
    dow: [ 1 ], // Repeat monday and thursday
    ranges: [{
        start: moment('2019-05-01','YYYY-MM-DD'), //all of february
        end: moment('2019-05-01','YYYY-MM-DD').endOf('month'),
    }],
	description: 'My description',
},
*/

               ],

            eventRender: function(event, element) {

                if (element.hasClass('fc-day-grid-event')) {
                    element.data('content', event.description);
                    element.data('placement', 'top');
                    KTApp.initPopover(element);
                } else if (element.hasClass('fc-time-grid-event')) {
                    element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                    element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                }

			/*	if (event.ranges) {
    return (event.ranges.filter(function(range) { // test event against all the ranges

      return (event.start.isBefore(range.end) &&
        event.end.isAfter(range.start));

    }).length) > 0; //if it isn't in one of the ranges, don't render it (by returning false)
  } else {
    return true; //just allow the event to render normally if it's not recurring
  }

  */


            }
        });
    }
};
}();

jQuery(document).ready(function() {
KTCalendarBasic.init();
});
</script>

@endpush
@section('body_class','')
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

    

						<!-- begin:: Content -->
						<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

                        
                                
                 
                                        <div class="kt-portlet" id="kt_portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <span class="kt-portlet__head-icon">
                                                            <i class="flaticon-map-location"></i>
                                                        </span>
                                                        <h3 class="kt-portlet__head-title">
                                                            Event Calendar
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">

                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div id="kt_calendar"></div>
                                                </div>
                                            </div>



							<!--End::Section-->

						</div>
						<!-- end:: Content -->
					</div>


@stop


