<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
        data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item  {!! classActiveRoute('home') !!}" aria-haspopup="true">
                <a href="{{ route('home') }}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon">@include('icons.dashboard')</span>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            <li class="kt-menu__item  {!! classActiveRoute('academic_sessions.index') !!}" aria-haspopup="true"><a
                    href="{{ route('academic_sessions.index') }}" class="kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.pencil')</span><span
                        class="kt-menu__link-text">Academic Sessions</span></a></li>


            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Manage</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu {!! classOpenSegment(1,'departments') !!} {!! classOpenSegment(1,'schools') !!}  {!! classOpenSegment(1,'degrees') !!}  {!! classOpenSegment(1,'programmes') !!} {!! classOpenSegment(1,'class_details') !!}"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="la la-archive fs-22"></i></span><span
                        class="kt-menu__link-text">Manage</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span
                                class="kt-menu__link"><span class="kt-menu__link-text">Users</span></span></li>
                        <li class="kt-menu__item {!! classActiveSegment('1','schools') !!}" aria-haspopup="true"><a
                                href="{{ route('schools.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Schools</span></a></li>

                        <li class="kt-menu__item {!! classActiveSegment('1','departments') !!}" aria-haspopup="true"><a
                                href="{{ route('departments.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Departments</span></a></li>

                        <li class="kt-menu__item {!! classActiveSegment('1','degrees') !!}" aria-haspopup="true"><a
                                href="{{ route('degrees.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Degrees</span></a></li>

                        <li class="kt-menu__item {!! classActiveSegment('1','programmes') !!}" aria-haspopup="true"><a
                                href="{{ route('programmes.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Programmes</span></a></li>

                                    <li class="kt-menu__item {!! classActiveSegment('1','class_details') !!}" aria-haspopup="true"><a
                                        href="{{ route('class_details.index') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                            class="kt-menu__link-text">Class Details</span></a></li>
        


                    </ul>
                </div>
            </li>


            <li class="kt-menu__item  kt-menu__item--submenu {!! classOpenSegment(2,'users') !!} {!! classOpenSegment(2,'roles') !!}  {!! classOpenSegment(1,'staff_details') !!} {!! classOpenSegment(1,'student_details') !!}"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="la la-users fs-22"></i></span><span
                        class="kt-menu__link-text">User Details</span><i
                        class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span
                                class="kt-menu__link"><span class="kt-menu__link-text">Users</span></span></li>
                        <li class="kt-menu__item {!! classActiveSegment('2','users') !!} {!! classActiveSegment('1','staff_details') !!} {!! classActiveSegment('1','student_details') !!}" aria-haspopup="true"><a
                                href="{{ route('users.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Admin</span></a></li>

                                    <li class="kt-menu__item {!! classActiveSegment('1','staff_details') !!}" aria-haspopup="true"><a
                                href="{{ route('staff_details.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Staff Details</span></a></li>
                                    
                                    <li class="kt-menu__item {!! classActiveSegment('1','student_details') !!}" aria-haspopup="true"><a
                                href="{{ route('student_details.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Student Details</span></a></li>


                        <li class="kt-menu__item {!! classActiveSegment('2','roles') !!}" aria-haspopup="true"><a
                                href="{{ route('roles.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">User Roles</span></a></li>
                    </ul>
                </div>
            </li>


            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Academic</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>


            <li class="kt-menu__item  kt-menu__item--submenu {!! classOpenSegment(1,'courses') !!}"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">@include('icons.archive')</span><span
                        class="kt-menu__link-text">Course Details</span><i
                        class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        
                    <li class="kt-menu__item {!! classActiveSegment('2','course_details') !!}" aria-haspopup="true"><a
                                href="{{ route('course_details.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Course Details</span></a></li>
                                    

                                    
                                <li class="kt-menu__item {!! classActiveSegment('2','course_types') !!}" aria-haspopup="true"><a
                                href="{{ route('course_types.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Course Types</span></a></li>

                                

                    </ul>
                </div>
            </li>


            <li class="kt-menu__item  {!! classActiveRoute('assign_courses.index') !!}" aria-haspopup="true"><a
                    href="{{ route('assign_courses.index') }}" class="kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.git')</span><span
                        class="kt-menu__link-text">Assign Courses</span></a></li>

   


            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Other Details</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>


            
            <li class="kt-menu__item  kt-menu__item--submenu {!! classOpenSegment(1,'general') !!}"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                    class="kt-menu__link kt-menu__toggle"><span
                        class="kt-menu__link-icon">@include('icons.class')</span><span
                        class="kt-menu__link-text">Activities</span><i
                        class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item {!! classActiveRoute('circulars.index')  !!}" aria-haspopup="true"><a
                                href="{{ route('circulars.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Circulars</span></a></li>

                        <li class="kt-menu__item  {!! classActiveRoute('events.index') !!}"
                            aria-haspopup="true">
                            <a href="{{ route('events.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Events</span></a></li>


                                    
                        <li class="kt-menu__item  {!! classActiveRoute('day_orders.index') !!}"
                        aria-haspopup="true">
                        <a href="{{ route('day_orders.index') }}" class="kt-menu__link "><i
                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                class="kt-menu__link-text">Day Order</span></a></li>


                                
                        <li class="kt-menu__item  {!! classActiveRoute('time_slots.index') !!}"
                        aria-haspopup="true">
                        <a href="{{ route('time_slots.index') }}" class="kt-menu__link "><i
                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                class="kt-menu__link-text">Time slots</span></a></li>




                    </ul>
                </div>
            </li>



        

            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Settings</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu {!! classOpenSegment(2,'settings') !!} {!! classOpenSegment(1,'categories') !!} {!! classOpenSegment(1,'categories_data') !!} "
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                    class="kt-menu__link kt-menu__toggle"><span
                        class="kt-menu__link-icon">@include('icons.general')</span><span
                        class="kt-menu__link-text">General</span><i
                        class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item {!! classActiveRoute('settings')  !!}" aria-haspopup="true"><a
                                href="{{ route('settings') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Settings</span></a></li>
                        <li class="kt-menu__item  {!! classActiveRoute('preference_categories.index') !!}"
                            aria-haspopup="true">
                            <a href="{{ route('preference_categories.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Preference Categories</span></a></li>
                        <li class="kt-menu__item  {!! classActiveSegment('1','preferences') !!}" aria-haspopup="true"><a
                                href="{{ route('preferences.index') }}" class="kt-menu__link "><i
                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                    class="kt-menu__link-text">Preferences</span></a></li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item" aria-haspopup="true"><a href="{{ URL::to('change_password')}}"
                    class="ajax-popup kt-menu__link "><span
                        class="kt-menu__link-icon">@include('icons.class')</span><span class="kt-menu__link-text">Change
                        Password</span></a></li>
        </ul>
    </div>
</div>
<!-- end:: Aside Menu -->
