@if(session('role')==1)
@include('layouts.side_menu.admin')
@elseif(session('role')==2)
@include('layouts.side_menu.student')
@elseif(session('role')==3)
@include('layouts.side_menu.staff')
@else
@endif