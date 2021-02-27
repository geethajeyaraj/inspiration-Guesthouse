


@auth
                          

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('reservation') }}">Reservation</a>
                            </li>

@endauth 


<li class="nav-item">
    <a class="nav-link" href="{{ url('who-can-stay') }}">Who can stay</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ url('tariff') }}">Tariff</a>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{ url('information') }}">General Information</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ url('contact') }}">Contact</a>
</li>






                            @auth

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ url('products') }}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hi, {{ str_limit(auth()->user()->display_name, 10) }}
                                </a>
                                 <ul class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdownMenuLink">

                                        @if(auth()->user()->role_id!=3)
                                        <li><a class="dropdown-item" href="{{ url('admin') }}">Admin</a></li>
                                    
                                        @endif

                                        
                                    <li><a class="dropdown-item" href="{{ url('myprofile') }}">My Profile</a></li>
                                    
                                    <li><a class="dropdown-item" href="{{ url('myreservations') }}">Reservation Status</a></li>

                                    <li><a class="dropdown-item" href="{{ url('mybookings') }}">My Bookings</a></li>
                                    
                                    
                                    <li><a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                    
                                
                                </ul>
                                </li>
    

                                
                          
                            @endauth
                            @guest
                            <li class="nav-item">
                                <a class="nav-link ajax-popup"  href="{{ url('ajax_login/login') }}">Login</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link ajax-popup" href="{{ url('ajax_login/ajaxregister') }}">Register</a>
                            </li>
                            @endguest
			  