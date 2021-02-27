@extends('layouts.page')
@section('title', 'Profile')
@push('pre_css')

@endpush
@push('css')
<style>
.kt-widget__img{max-width:100px;max-height:100px;}
</style>
@endpush
@push('js')
<script>
</script>
@endpush
@section('body_class','')
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <div class="row">
                <div class="col-md-6">
        
            <div class="kt-portlet kt-portlet--mobile  kt-portlet--height-fluid ">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                           Profile                        
                        </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td rowspan="4" class="text-center">
                            @if(isset($student->image_location ))
                                    @if(file_exists(storage_path().'/app/'.$student->image_location ))
                                    <img src="{{ url($student->image_location ) }}" class="kt-widget__img" alt="User Image">
                                    @else
                                    <img src="{{ url('assets/media/user.jpg') }}" class="kt-widget__img" alt="User Image">
                                    @endif
                                    @else
                                    <img src="{{ url('assets/media/user.jpg') }}" class="kt-widget__img" alt="User Image">
                                   @endif
                    </td>
                    <td>Name</td>
                    <td>{{ $student->name }}</td>
                </tr>
                <tr><td>Class</td><td>{{ $student->grade }}</td></tr>
              
                <tr><td>Gender</td><td>{{ $student->gender }}</td></tr>
                <tr><td>Date of Birth</td><td>{{ $student->date_of_birth }}</td></tr>
               
                <tr><td>Height</td><td>{{ $student->height }}</td></tr>
                <tr><td>Weight</td><td>{{ $student->weight }}</td></tr>
                <tr><td>Date of Joining</td><td  colspan=2>{{ $student->date_of_joining }}</td></tr>
                <tr><td>Community</td><td  colspan=2>{{ $student->community }}</td></tr>
              
            </table>
        </div>

    </div>
</div>
</div>

<div class="col-md-6">
     
        <div class="kt-portlet kt-portlet--mobile  kt-portlet--height-fluid ">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                       Address Info                   
                    </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
                <tr><td>Email</td><td>{{ $student->email }}</td></tr>
                <tr><td>Mobile No</td><td>{{ $student->mobile_no }}</td></tr>
           
            <tr><td>Address Line 1</td><td>{{ $student->address1 }}</td></tr>
            <tr><td>Address Line 2</td><td>{{ $student->address2 }}</td></tr>
            <tr><td>District</td><td>{{ $student->district }}</td></tr>
            <tr><td>State</td><td>{{ $student->state }}</td></tr>
            <tr><td>Country</td><td>{{ $student->country }}</td></tr>
            <tr><td>Pincode</td><td>{{ $student->pincode }}</td></tr>
            
          
        </table>
    </div>

</div>
</div>  
    

</div> 
</div>
      


    </div>
    <!-- end:: Content -->
</div>


@stop


