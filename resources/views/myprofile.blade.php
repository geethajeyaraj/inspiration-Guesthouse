@extends('layouts.front')
@section('title')
<?php
//$seotools->setTitle('Sel-Jegat');
//$seotools->setDescription('Label Manufacturer and Sticker Manufacture for customers from diverse industries. We have in place, a dynamic quality management system which is ISO 9001:2008 certified, by TUV SUD, India');
//$seotools->opengraph()->setUrl(url('/'));
//$seotools->setCanonical(url('/'));
//$seotools->opengraph()->addProperty('type', 'WebPage');
//$seotools->jsonLd()->addImage(url('assets/images/logo.png'));
//echo $seotools->generate();
?>
@endsection
@push('pre_css')
@endpush
@push('css')
<link href="{{ url('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}} " />

<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .invalid-feedback {
        position: absolute;
        bottom: 0px;
    }

    .form-control.is-invalid {
        margin-bottom: 20px;
    }

    .form-group {
        margin-top: 10px;
    }

    .is-invalid .select2-container--default .select2-selection--single {
        border: 1px solid #F44336;
    }

    .s3-section-title {
        font-size: 18px;
        border-top: 1px solid #ececec;
        border-bottom: 1px solid #ececec;
        background: #f4f4f4;
        padding: 10px;
    }

    .select2{
        width: 100% !important;

    }

    .fileinput {
   
    display: block;
}
</style>
@endpush
@push('js')
<script src="{{ url('assets/plugins/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>

<script>
    $(document).ready(function () {

        $('.select2').select2();

        $('select').on('change', function () { // when the value changes
            $(this).valid(); // trigger validation on this element
        });


        $('#staff_type').on('change', function () { 

            if($(this).val() =="Staff")
            {
                $("#staff_details").css('display','block');
            }else{
                $("#staff_details").css('display','none');
          
            }

        });


        if($("#staff_type").val() =="Staff")
            {
                $("#staff_details").css('display','block');
            }else{
                $("#staff_details").css('display','none');
          
            }




        $('#country').change(function () {
            var cid = $(this).val();
            if (cid) {
                $.ajax({
                    type: "get",
                    url: "{{ url('get_states') }}/" + cid,
                    success: function (res) {
                        if (res) {
                            $("#state").empty();
                            $("#city").empty();
                            $("#state").append('<option>Select State</option>');
                            $("#city").append('<option>Select City</option>');

                            $.each(res, function (key, value) {
                                $("#state").append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        }
                    }

                });
            }
        });


        $('#state').change(function () {
            var sid = $(this).val();
            if (sid) {
                $.ajax({
                    type: "get",
                    url: "{{ url('get_cities') }}/" + sid,
                    success: function (res) {
                        if (res) {
                            $("#city").empty();
                            $("#city").append('<option>Select City</option>');

                            $.each(res, function (key, value) {
                                $("#city").append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        }
                    }

                });
            }
        })





        $("#update_form").validate({
            ignore: [],

            invalidHandler: function(event, validator) {
      
      $('html, body').animate({
                  scrollTop: 0
              }, 1000, "easeInOutExpo");
    
          },


        });


        $("#update_btn").click(function (event) {

           

            $("#update_btn").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );
            $("#update_btn").toggleClass("s3-spinner");


            event.preventDefault();
            var frm = $('#update_form');
            var formData = new FormData($('#update_form')[0]);
            if (frm.valid()) {
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function (response) {
                        $("#update_btn").html('<i class="fa fa-check"></i> Submit Profile');
                        $("#update_btn").attr("disabled", false);
                        if (response.status === true) {
                            toastr.success(response.notification);

                        } else {
                            $("#update_btn").html(
                                '<i class="fa fa-check"></i> Submit Profile');
                            $("#update_btn").attr("disabled", false);
                            toastr.error(response.notification);
                        }

                        $('html, body').animate({
                    scrollTop: 0
                }, 1000, "easeInOutExpo");


                    },
                    error: function (data) {
                        $("#update_btn").html('<i class="fa fa-check"></i> Submit Profile');
                        $("#update_btn").attr("disabled", false);
                        toastr.error("Oops... Something went wrong!" + data);

                        $('html, body').animate({
                    scrollTop: 0
                }, 1000, "easeInOutExpo");



                    },
                });
            } else {



                $("#update_btn").html('<i class="fa fa-check"></i> Submit Profile');
                $("#update_btn").attr("disabled", false);
            }
        });
    });
</script>



@endpush
@section('body_class','')
@section('content')
<div class="header-style-1 text-center">
    <div class="overlay"></div>
    <h2>PROFILE</h2>
</div>

<section class="about p-5">
    <div class="container">

        {{ Form::model($model_name,['url' => url('myprofile'),'id'=>'update_form', 'files' => true,'class'=>'form-vertical
                validate_form', 'method' => 'post','autocomplete'=>'off']) }}


        <fieldset class="form-horizontal  ">

                <div class="row">
                        <div class="col-md-12">
                            <div class="row">
        
                                <div class="col-lg-12">
                                    <h3 class="s3-section-title">Basic Info</h3>
                                </div>
                            </div>
                        </div>
                    </div>


            <div class="row">
                <div class="col-md-4">
                        <div class="row">
                                <div class="col-3">
                                        <div class="form-group   ">
                                                <label for="title">title</label>
                   
                        {!! Form::select('title',['Mr'=>'Mr','Ms'=>'Ms','Dr'=>'Dr'],null, ['class' => 'form-control m-input
                select2 required', 'placeholder' => 'Title','id'=>'title' ]) !!}

                                        </div> 
                    </div> 
                    <div class="col-9">

                            <div class="form-group   ">
                                    <label for="title">Name</label>
                   
                            {!! Form::input('text','display_name',null, ['class' => 'form-control m-input required',
                            'placeholder' => 'Enter your name', 'autocomplete'=>"nope" ])
                            !!}

                            </div>
                    </div>
                        </div>
                                  </div>
              
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="email">Email</label>


                        <div class="input-group">

                                {!! Form::input('text','email',null, ['class' => 'form-control m-input email required',
                                'placeholder' => 'Enter your email', 'autocomplete'=>"nope" ])
                                !!}
                        </div>


                        
                    </div>
                </div>

                <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="mobile_no">Phone Mobile</label>
    
    
                            <div class="input-group">
    
                                    {!! Form::input('text','mobile_no',null, ['class' => 'form-control m-input required',
                                    'placeholder' => 'Enter your Mobile No', 'autocomplete'=>"nope" ])
                                    !!}
    
                            </div>
    
    
                           
                        </div>
                    </div>


            </div>
            <div class="row">
               
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="land_line">Phone Land Line</label>


                        <div class="input-group">

                                {!! Form::input('text','land_line',null, ['class' => 'form-control m-input',
                                'placeholder' => 'Enter your Landline No', 'autocomplete'=>"nope" ])
                                !!}

                        </div>


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="gender">Gender</label>

                        {!! Form::select('gender', ['Male'=>'Male','Female'=>'Female','Transgender'=>'Transgender'],null, ['class' => 'form-control m-input
                        select2 required', 'placeholder' => 'Select Gender','id'=>'gender' ]) !!}

                       
                    </div>
                </div>

                <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="nationality">Nationality</label>
    
                            {!! Form::select('nationality',['Indian'=>'Indian','Others'=>'Others'],null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Nationality','id'=>'nationality' ]) !!}
    
    
                        </div>
                    </div>


            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="country">Country</label>

                        {!! Form::select('country',$countries,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Country','id'=>'country' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="state">State</label>

                        {!! Form::select('state',$states,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select State','id'=>'state' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="city">City</label>
                        {!! Form::select('city',$cities,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select City','id'=>'city' ]) !!}



                    </div>
                </div>
            </div>

            <div class="row">
              
                    <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="address_line_1">Address Line 1</label>
    
    
                            <div class="input-group">
    
                                    {!! Form::input('text','address_line1',null, ['class' => 'form-control m-input required',
                                    'placeholder' => 'Enter your address line 1', 'autocomplete'=>"nope" ])
                                    !!}
    
                            </div>
    
    
                          
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="address_line_2">Address Line 2</label>
    
    
                            <div class="input-group">
    
                                    {!! Form::input('text','address_line2',null, ['class' => 'form-control m-input',
                                    'placeholder' => 'Enter your address line 2', 'autocomplete'=>"nope" ])
                                    !!}
                            </div>
    
    
                          
                        </div>
                    </div>

                    <div class="col-md-4">
                            <div class="form-group   ">
                                <label for="pincode">Pincode</label>
        
        
                                <div class="input-group">
        
                                        {!! Form::input('text','pincode',null, ['class' => 'form-control m-input',
                                        'placeholder' => 'Enter your pincode', 'autocomplete'=>"nope" ])
                                        !!}
                                </div>
        
        
                              
                            </div>
                        </div>



                </div>
           
                
                <div class="row">
                        <div class="col-md-12">
                            <div class="row">
        
                                <div class="col-lg-12">
                                    <h3 class="s3-section-title">Guest Type Details</h3>
                                </div>
                            </div>
                        </div>
                    </div>



            <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="guest_type">Guest/Trainee</label>

                        {!! Form::select('guest_type',['Guest'=>'Guest','Trainee'=>'Trainee'],null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Guest Type','id'=>'guest_type' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="staff_type">Staff Type</label>

                        {!! Form::select('staff_type',['Staff'=>'Staff','Others'=>'Others'],null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Staff Type','id'=>'staff_type' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>

            <div id="staff_details">
            

            <div class="row">
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-lg-12">
                            <h3 class="s3-section-title">Staff Details</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="centre_id">Centre Id</label>

                        {!! Form::select('center_id',$centres,null, ['class' => 'form-control m-input  select2', 'placeholder' => 'Select Centre','id'=>'centre_id' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="department">Department</label>


                        <div class="input-group">
                                {!! Form::input('text','department',null, ['class' => 'form-control m-input',
                                'placeholder' => 'Enter your Department', 'autocomplete'=>"nope" ])
                                !!}

                        </div>


                        <span class="s3-form-help vaild-feedback"> </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="designation">Designation</label>


                        <div class="input-group">
                                {!! Form::input('text','designation',null, ['class' => 'form-control m-input',
                                'placeholder' => 'Enter your Designation', 'autocomplete'=>"nope" ])
                                !!}

                        </div>


                        <span class="s3-form-help vaild-feedback"> </span>
                    </div>
                </div>
            </div>
            </div>



            <div class="row">
                    <div class="col-md-12">
                        <div class="row">
    
                            <div class="col-lg-12">
                                <h3 class="s3-section-title">Id Proof Details</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="centre_id">Id Proof</label>
    
                            {!! Form::select('id_proof',$id_proofs,null, ['class' => 'form-control m-input  select2', 'placeholder' => 'Select Id Proof','id'=>'id_proof' ]) !!}
    
    
                        </div>
                    </div>

                    <div class="col-md-4">
                            <div class="form-group   ">
                                <label for="centre_id">Id Proof Number</label>

                                {!! Form::input('text','id_proof_no',null, ['class' => 'form-control m-input',
                                'placeholder' => 'Enter Proof No', 'autocomplete'=>"nope" ])
                                !!}

        
                            </div>
                        </div>


                    
                    <div class="col-md-4">
                            <div class="form-group   ">
                                <label for="centre_id">Id Proof</label>
        

            <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: auto;">
                       
                      

                       @if(isset($model_name->id_proof_location))
                       @if(Storage::disk('public')->exists($model_name->id_proof_location))
                        <img src="{{ asset(Storage::url( $model_name->id_proof_location )) }}" style="max-width:200px;max-height:200px;" class="" alt="User Image">
                        @else
                        <img src="{{ url('assets/media/id_proof.jpg') }}" class="" alt="User Image">
                        @endif
                        @else
                        <img src="{{ url('assets/media/id_proof.jpg') }}" class="" alt="User Image">
                       @endif
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:200px; max-height:200px;">
                    </div>
                    <div>
                        <span class="btn btn-sm btn-primary btn-file">
                            <span class="fileinput-new">
                                Select image </span>
                            <span class="fileinput-exists">
                                Change </span>
                            <input type="file" id="id_proof_location" name="id_proof_location">
                        </span>
                        <a href="#" class="btn btn-sm  btn-danger fileinput-exists" data-dismiss="fileinput">
                            Remove </a>
                    </div>
                </div>
            </div>


        </div>


</div>



        </fieldset>






        <button type="submit" id="update_btn" class="form-control btn btn-primary mt-5">Submit Profile</button>

        {{ Form::close() }}



    </div>
</section>





@stop