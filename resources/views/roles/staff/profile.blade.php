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
                            @if(isset($staff->image_location ))
                                    @if(file_exists(storage_path().'/app/'.$staff->image_location ))
                                    <img src="{{ url($staff->image_location ) }}" class="kt-widget__img" alt="User Image">
                                    @else
                                    <img src="{{ url('assets/media/user.jpg') }}" class="kt-widget__img" alt="User Image">
                                    @endif
                                    @else
                                    <img src="{{ url('assets/media/user.jpg') }}" class="kt-widget__img" alt="User Image">
                                   @endif
                    </td>
                    <td>Name</td>
                    <td>{{ $staff->name }}</td>
                </tr>
               
                <tr><td>Gender</td><td>{{ $staff->gender }}</td></tr>
                <tr><td>Date of Birth</td><td>{{ $staff->date_of_birth }}</td></tr>
               
                <tr><td>Date of Joining</td><td>{{ $staff->date_of_joining }}</td></tr>


                <tr><td>Community</td><td  colspan=2>{{ $staff->community }}

                <tr><td>Hostel/Transport/self</td><td  colspan=2>{{ $staff->hostel_or_transport_or_self }}</td></tr>
                <tr><td>Identification mark1</td><td  colspan=2>{{ $staff->identification_mark1 }}</td></tr>
                <tr><td>Identification mark2</td><td  colspan=2>{{ $staff->identification_mark2 }}</td></tr>





              
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




                <tr><td>Email</td><td>{{ $staff->email }}</td></tr>
                <tr><td>Mobile No</td><td>{{ $staff->mobile_no }}</td></tr>
           
            <tr><td>Address Line 1</td><td>{{ $staff->address1 }}</td></tr>
            <tr><td>Address Line 2</td><td>{{ $staff->address2 }}</td></tr>
            <tr><td>District</td><td>{{ $staff->district }}</td></tr>
            <tr><td>State</td><td>{{ $staff->state }}</td></tr>
            <tr><td>Country</td><td>{{ $staff->country }}</td></tr>
            <tr><td>Pincode</td><td>{{ $staff->pincode }}</td></tr>
            
          
        </table>
    </div>

</div>
</div>  
    

</div> 
</div>


<div class="row">
    <div class="col-md-6">

             
            <div class="kt-portlet kt-portlet--mobile  kt-portlet--height-fluid ">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                           Other Details                   
                        </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
    
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                    <tr><td>Height</td><td  colspan=2>{{ $staff->height }}</td></tr>
                    <tr><td>Weight</td><td  colspan=2>{{ $staff->weight }}</td></tr>
    
                    <tr><td>Marital Status</td><td>{{ $staff->marital_status }}</td></tr>
                    <tr><td>Academic Qualification</td><td>{{ $staff->academic_qualification }}</td></tr>
               
                    <tr><td>Personal Qualification</td><td>{{ $staff->personal_qualification }}</td></tr>
                    <tr><td>Special Achievement</td><td>{{ $staff->special_achievement }}</td></tr>
                    <tr><td>Computer Knowledge</td><td>{{ $staff->computer_knowledge }}</td></tr>
                    <tr><td>Computer Skills</td><td>{{ $staff->computer_skills }}</td></tr>
               
                
  

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
                                Bank Account Details               
                        </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
    
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                
            <tr><td>PAN No</td><td>{{ $staff->pan_no }}</td></tr>
            <tr><td>Bank Account No</td><td>{{ $staff->bank_account_no }}</td></tr>
            <tr><td>Bank IFSC Code</td><td>{{ $staff->bank_ifsc_code }}</td></tr>
            <tr><td>Bank Name</td><td>{{ $staff->bank_name }}</td></tr>
            <tr><td>Bank Branch</td><td>{{ $staff->bank_branch }}</td></tr>
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


