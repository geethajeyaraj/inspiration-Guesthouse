<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
        data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item  {!! classActiveRoute('home') !!}" aria-haspopup="true"><a
                    href="{{ route('home') }}" class="kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.dashboard')</span><span
                        class="kt-menu__link-text">Dashboard</span></a></li>
                        <li class="kt-menu__section ">
                                <h4 class="kt-menu__section-text">Academic</h4>
                                <i class="kt-menu__section-icon flaticon-more-v2"></i>
                            </li>

                            <li class="kt-menu__item  {!! classActiveRoute('student_courses') !!}" aria-haspopup="true"><a
                                href="{{ route('student_courses') }}" class="kt-menu__link "><span
                                    class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">My Courses</span></a></li>
                
                                                                        
                                    <li class="kt-menu__item  {!! classActiveRoute('student_time_table') !!}" aria-haspopup="true"><a
                                        href="{{ route('student_time_table') }}" class="kt-menu__link "><span
                                            class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">Time Table</span></a></li>



                            
            <li class="kt-menu__item  {!! classActiveRoute('student_attendance') !!}" aria-haspopup="true"><a
                href="{{ route('student_attendance') }}" class="kt-menu__link "><span
                    class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">Attendance</span></a></li>

                    
            <li class="kt-menu__item  {!! classActiveRoute('student_marks') !!}" aria-haspopup="true"><a
                href="{{ route('student_marks') }}" class="kt-menu__link "><span
                    class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">Marks</span></a></li>



                            <li class="kt-menu__section ">
                                    <h4 class="kt-menu__section-text">Activities</h4>
                                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                                </li>
    
            <li class="kt-menu__item  {!! classActiveRoute('student_homeworks') !!}" aria-haspopup="true"><a
                    href="{{ route('student_homeworks') }}" class="kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">Home
                        Works</span></a></li>
            <li class="kt-menu__item  {!! classActiveRoute('student_circulars') !!}" aria-haspopup="true"><a
                    href="{{ route('student_circulars') }}" class="kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.class')</span><span
                        class="kt-menu__link-text">Circulars</span></a></li>
            <li class="kt-menu__item  {!! classActiveRoute('student_events') !!}" aria-haspopup="true"><a
                    href="{{ route('student_events') }}" class="kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.class')</span><span
                        class="kt-menu__link-text">Events</span></a></li>

                        <li class="kt-menu__section ">
                                <h4 class="kt-menu__section-text">Profile</h4>
                                <i class="kt-menu__section-icon flaticon-more-v2"></i>
                            </li>

            <li class="kt-menu__item" aria-haspopup="true"><a href="{{ URL::to('change_password')}}"
                    class="ajax-popup kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">Change
                        Password</span></a></li>
        </ul>
    </div>
</div>
<!-- end:: Aside Menu -->