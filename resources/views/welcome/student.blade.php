<div class="row row-no-padding">

        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_attendance') }}"><div class="topwidget"  style="background:#e83e8c;">@include('icons.academic.attendance')
                        <p class="text-center m-0 mt-3">Attendance</p>
                </div></a>
        </div>
      
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_marks') }}"><div class="topwidget"  style="background:#17a2b8;">@include('icons.academic.exam')
                        <p class="text-center m-0 mt-3">Marks</p>
                </div></a>
        </div>
        
        
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_homeworks') }}"><div class="topwidget" style="background:#ffc107;">@include('icons.academic.homeworks')
                <p class="text-center m-0 mt-3">Home Works</p>
                </div></a>
        </div>
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_circulars') }}"><div class="topwidget"  style="background:#20c997;">@include('icons.academic.circulars')
                        <p class="text-center m-0 mt-3">Circulars</p>
                </div></a>
        </div>
    
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_events') }}"><div class="topwidget"  style="background:#5867dd;">@include('icons.academic.events')
                        <p class="text-center m-0 mt-3">Events</p>
                </div></a>
        </div>
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_profile') }}"><div class="topwidget"  style="background:#dc3545;">@include('icons.academic.student')
                        <p class="text-center m-0 mt-3">Profile</p>
                </div></a>
        </div>

    
    </div>

