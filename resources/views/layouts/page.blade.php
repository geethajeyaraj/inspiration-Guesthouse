@extends('layouts.app')
@section('section_pre_css')
@stack('pre_css')
@stop
@section('section_post_css')
<link href="{{ url('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ url('assets/plugins/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/theme/s3.css?ver=1') }}" rel="stylesheet" type="text/css" />

@stack('css')
<style>
  .datepicker {
    text-align: center;
  }

  .datepicker:hover {
    cursor: pointer;
  }

  .select2-container {
    width: 100% !important;
  }

  .fs-22 {
    font-size: 22px;
  }

  .dataTables_wrapper .dataTable th,
  .dataTables_wrapper .dataTable td {
    color: #000000;
  }

  .form-control {
    border: 1px solid #d3d3d3;
  }

  .select2-container--default .select2-selection--multiple,
  .select2-container--default .select2-selection--single {
    border: 1px solid #d3d3d3;
  }

  .table {
    color: #000;
  }

  .input-group-text {
    border: 1px solid #d3d3d3;
  }

  .fc-unthemed .fc-list-heading td {
    background: #17a2b8;
  }

  .fc-unthemed .fc-list-heading .fc-list-heading-main,
  .fc-unthemed .fc-list-heading .fc-list-heading-alt {
    color: #f4f4f4;
  }

  html,
  body {
    font-weight: 400;
  }

  .select2-container--default .select2-results__option.select2-results__option--highlighted {
    background: #dcdcdc;
    color: #272727;
  }

  .dt-bootstrap4 table tr td .dropdown-menu {
    background: rgb(228, 228, 228);
    border: 1px solid #d0d0d0 !important;
  }

  .dt-bootstrap4 table tr td .dropdown-item {
    color: #353535;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
    color: #1f1f1f;
  }

  .datetimepicker {
    transform: translate(0, 3.1em);
  }

  .nav-sidebar .nav-header:not(:first-of-type) {
    padding: 15px;
  }

  .brand-link img {
    max-width: 100%;
    background: #fff;
  }
</style>
@stop

@section('section_js')
<script src="{{ url('assets/plugins/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/popper.js/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/tooltip.js/tooltip.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>


<script src="{{ url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/magnific-popup/magnific-popup.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/theme/App.js') }}" type="text/javascript"></script>
<script>
  const container = document.querySelector('#main-sidebar');
  const ps = new PerfectScrollbar(container, {
    wheelSpeed: 0.5,
    swipeEasing: true,
    wheelPropagation: false,
    minScrollbarLength: 40,
    maxScrollbarLength: 300
  });

  $(document).ready(function() {
    $(window).resize(function() {
      ps.update();
    });
  });

  toastr.options = {
    "closeButton": true,
    "newestOnTop": true,
    "progressBar": true,
  };

  @if(session('message'))
  toastr.success("{{ session('message') }}");
  @endif

  @if(session('status'))
  toastr.success("{{ session('status') }}");
  @endif





  $(document).ready(function() {
    $('.ajax-popup').magnificPopup({
      type: 'ajax',
      midClick: true,
      modal: true
    });
    $(document).on('click', '.ajax-close', function(e) {
      e.preventDefault();
      $.magnificPopup.close();
    });

    function toggleDropdown(e) {
      $(e.target).closest('a.btn').click();
    }
    $('body').on('mouseenter mouseleave', '.dropdown', toggleDropdown)
      .on('click', '.dropdown-menu a', toggleDropdown);
    $.magnificPopup.instance._onFocusIn = function(e) {
      if ($(e.target).hasClass('select2-search__field')) {
        return true;
      }
      $.magnificPopup.proto._onFocusIn.call(this, e);
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });
</script>
@stack('js')
<!--begin::Global App Bundle(used by all pages) -->
@stop
@section('body')
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="la la-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Reports</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto pr-4">
      {{--
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="la la-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
        </div>
    </li>
    --}}
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="la la-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="user-card">
            <div class="user-card-avatar">
              <span class="badge badge-success">{{ auth()->user()->user_name[0] }}</span>
            </div>
          </div>
          <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="la la-key"></i> Logout
          </a>
          <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" id="main-sidebar">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      @if(Storage::disk('public')->exists(Helpers::settings('dashboard_logo')))
      <img alt="Logo" src="{{ asset(Storage::url(Helpers::settings('dashboard_logo'))) }}" />
      @else
      <img alt="Logo" src="{{ asset('assets/media/logo.png') }}" />
      @endif
    </a>
    <!-- Sidebar -->
    <div class="sidebar" style="height:100%;overflow:visible;margin-bottom:100px;">
      <!-- Sidebar user panel (optional) -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column  nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item   ">
            <a href="{{ route('admin_home') }}" class="nav-link {!! classActiveRoute('admin_home') !!}">
              <i class="nav-icon la la-tachometer"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <li class="nav-item has-treeview {!! classOpenSegment(2,'users') !!} {!! classOpenSegment(2,'roles') !!} ">
            <a href="{{ route('users.index') }}" class="nav-link {!! classActiveSegment(2,'users') !!} {!! classActiveSegment(2,'roles') !!} ">
              <i class="nav-icon la la-users"></i>
              <p>
                Users
              </p>
              <i class="right la la-angle-right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {!! classActiveRoute('users.index')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>

              @if(session('role')==1)
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link  {!! classActiveRoute('roles.index')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>User Roles</p>
                </a>
              </li>
              @endif


            </ul>
          </li>


          <li class="nav-header">RESERVATION</li>


          <li class="nav-item   ">
            <a href="{{ route('reservation_control.index') }}" class="nav-link {!! classActiveRoute('reservation_control.index') !!} {!! classActiveSegment(3,'reservation_transactions') !!} {!! classActiveSegment(3,'reservation_rooms') !!} {!! classActiveSegment(3,'reservation_guests') !!}">
              <i class="nav-icon la la-trophy"></i>
              <p>
                Reservation Details
              </p>
            </a>
          </li>

          @if(session('role')==1)

          <li class="nav-item   ">
                <a href="{{ route('today_checkin_checkout','history') }}" class="nav-link  {!! classActivePath('admin/checkin/history') !!}">
                <i class="la la-book  nav-icon"></i>
                  <p>All bookings</p>
                </a>
              </li>

@endif 



          <li class="nav-item has-treeview  {!! classOpenSegment(3,'upcoming') !!} {!! classOpenSegment(3,'checkin') !!} {!! classOpenSegment(3,'checkout') !!} {!! classOpenSegment(3,'occupied') !!}">

            <a href="#" class="nav-link {!! classActiveSegment(3,'checkin') !!} {!! classActiveSegment(3,'upcoming') !!} {!! classActiveSegment(3,'checkout') !!}  {!! classActiveSegment(3,'occupied') !!}">
              <i class="nav-icon la la-clock-o"></i>
              <p>
                Check IN/OUT
              </p>
              <i class="right la la-angle-right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('today_checkin_checkout','upcoming') }}" class="nav-link {!! classActiveRoute('admin/checkin/upcoming')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Upcoming Checkins</p>
                </a>
              </li>


              <li class="nav-item   ">
                <a href="{{ route('today_checkin_checkout','checkin') }}" class="nav-link {!! classActivePath('admin/checkin/today') !!}">
                <i class="la la-circle  nav-icon"></i>
                  <p>Completed Check-ins</p>
                </a>
              </li>

              <li class="nav-item   ">
                <a href="{{ route('today_checkin_checkout','occupied') }}" class="nav-link  {!! classActivePath('admin/checkin/occupied') !!}">
                <i class="la la-circle  nav-icon"></i>
                  <p>List of Occupied</p>
                </a>
              </li>

              <li class="nav-item   ">
                <a href="{{ route('today_checkin_checkout','checkout') }}" class="nav-link  {!! classActivePath('admin/checkin/checkout') !!}">
                <i class="la la-circle  nav-icon"></i>
                  <p>Completed check-outs</p>
                </a>
              </li>


         






            </ul>
          </li>





          <li class="nav-item   ">
            <a href="{{ route('enquiries.index') }}" class="nav-link {!! classActiveRoute('enquiries.index') !!} ">
              <i class="nav-icon la la-envelope"></i>
              <p>
                Enquiries
              </p>
            </a>
          </li>




          <li class="nav-header">REPORTS</li>

          <li class="nav-item">
                <a href="{{ route('dependonroom','status') }}" class="nav-link {!! classActivePath('admin/dependonroom/status')  !!}">
                  <i class="nav-icon la la-bar-chart"></i>
                  <p>Depend on Room Status</p>
                </a>
          </li>

          <li class="nav-item">
                <a href="{{ route('dependonroom','type') }}" class="nav-link {!! classActivePath('admin/dependonroom/type')  !!}">
                  <i class="la la-bar-chart  nav-icon"></i>
                  <p>Depend on Room Type</p>
                </a>
          </li>




          <li class="nav-item has-treeview {!! classOpenSegment(2,'reports') !!} ">
            <a href="{{ route('settings') }}" class="nav-link {!! classActiveSegment(2,'reports') !!}">
              <i class="nav-icon la la-bar-chart"></i>
              <p>
                Other Reports
              </p>
              <i class="right la la-angle-right"></i>
            </a>
            <ul class="nav nav-treeview">


            




              <li class="nav-item">
                <a href="{{ route('categorywiserooms') }}" class="nav-link {!! classActiveRoute('categorywiserooms')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Categorywise available Rooms</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('guestdetails') }}" class="nav-link {!! classActiveRoute('guestdetails')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Current Guest Details</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{ route('alltransactions') }}" class="nav-link {!! classActiveRoute('alltransactions')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>All transactions</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('monthwisesummary') }}" class="nav-link {!! classActiveRoute('monthwisesummary')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Transaction Summary</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('monthwiseguest') }}" class="nav-link {!! classActiveRoute('monthwiseguest')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Monthwise Guest CheckIn</p>
                </a>
              </li>





            </ul>

          </li>



          @if(session('role')==1)

          <li class="nav-header">SETTINGS</li>
          <li class="nav-item has-treeview {!! classOpenSegment(2,'settings') !!} {!! classOpenSegment(1,'categories') !!} {!! classOpenSegment(1,'categories_data') !!} ">
            <a href="{{ route('settings') }}" class="nav-link {!! classActiveSegment(2,'settings') !!} {!! classActiveSegment(1,'categories') !!} {!! classActiveSegment(1,'categories_data') !!}  !!}">
              <i class="nav-icon la la-cogs"></i>
              <p>
                General
              </p>
              <i class="right la la-angle-right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('settings') }}" class="nav-link {!! classActiveRoute('settings')  !!}">
                  <i class="la la-circle  nav-icon"></i>
                  <p>Settings</p>
                </a>
              </li>
              {{--
              <li class="nav-item">
                <a href="{{ route('preference_categories.index') }}" class="nav-link {!! classActiveRoute('preference_categories.index') !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Preference Categories</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('preferences.index') }}" class="nav-link  {!! classActiveRoute('preferences.index')  !!}">
              <i class="la la-circle nav-icon"></i>
              <p>Preferences</p>
            </a>
          </li>
          --}}
          <li class="nav-item">
            <a href="{{ route('master_settings.index') }}" class="nav-link  {!! classActiveRoute('master_settings.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Settings</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('master_aravind_centres.index') }}" class="nav-link  {!! classActiveRoute('master_aravind_centres.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Aravind Centres</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master_id_proof.index') }}" class="nav-link  {!! classActiveRoute('master_id_proof.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Id Proofs</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master_payments.index') }}" class="nav-link  {!! classActiveRoute('master_payments.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Payments</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master_training.index') }}" class="nav-link  {!! classActiveRoute('master_training.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Training</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master_room_types.index') }}" class="nav-link  {!! classActiveRoute('master_room_types.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Room Types</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master_room_tariff.index') }}" class="nav-link  {!! classActiveRoute('master_room_tariff.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Room Tariff Plan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('master_room_details.index') }}" class="nav-link  {!! classActiveRoute('master_room_details.index')  !!}">
              <i class="la la-circle  nav-icon"></i>
              <p>Master Room Details</p>
            </a>
          </li>


        </ul>
        </li>

        @endif

        <li class="nav-item">
          <a href="{{ URL::to('change_password')}}" class="nav-link ajax-popup">
            <i class="nav-icon la la-key"></i>
            <p>Change Password</p>
          </a>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{--
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
--}}
    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    Copyright &copy; laico
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@stop