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
<link href="{{ url('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}} " />
<link href="{{ url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ url('assets/plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />


<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
    }

    .fileinput .thumbnail > img {
    max-height: 150px;
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

    .select2 {
        width: 100% !important;
    }

    .fileinput {
        display: block;
    }

    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
        width: 100%;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-step:after {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-index: 0;
    }

    .stepwizard-step.last:after {
        width: 0%;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
        width: 25%;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
        position: relative;
        z-index: 1;
    }

    .btn-default {
        background: #ddd;
    }

    #update_form {
        background: #fff;
    }

    .setup-content {
        display: none;
    }

    .form-control {
        height: 38px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .datetimepicker tbody tr td.day.disabled {
    color: #cacaca;
}

</style>
@endpush
@push('js')

<script>
var warning = true;
window.onbeforeunload = function() {  
  if (warning) {  
    return "You have made changes on this page that you have not yet confirmed. If you navigate away from this page you will lose your unsaved changes";  
    }  
}

//$('form').submit(function() {
//   window.onbeforeunload = null;
//});


</script>


<script src="{{ url('assets/plugins/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
  

<script>
    $(document).ready(function() {


        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn'),
            allPrevBtn = $('.prevBtn');
        allWells.hide();
        navListItems.click(function(e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);
            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                $item.removeClass('btn-default');
                allWells.hide();
                $target.show();
                //$target.find('input:eq(0)').focus();
            }
        });
        allPrevBtn.click(function() {
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
            prevStepWizard.removeAttr('disabled').trigger('click');
        });


        allNextBtn.click(function() {
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),

                curInputs = curStep.find("input,select"),
          

                isValid = true;


//alert(curStepBtn );

//$("#"+ curStepBtn + " select").valid();


//console.log(curInputs);

                //var frm = $('#update_form');
                //frm.validate();
                //frm.valid();

                if ($("#"+ curStepBtn + " select,#"+ curStepBtn + " input").valid())
                {
                nextStepWizard.removeAttr('disabled').trigger('click');
                }else{
                    $('html, body').animate({
                    scrollTop: 0
                }, 1000, "easeInOutExpo");

                }

            
         /*   $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].valid()) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }
            
            if (isValid)
             nextStepWizard.removeAttr('disabled').trigger('click');

*/




        });
        $('div.setup-panel div a.btn-primary').trigger('click');
    });






   
    
    


    function view_beneficiaries()
    {
        var frm = $('#update_form');
        var formData = new FormData($('#update_form')[0]);

        $.ajax({
                    type: frm.attr('method'),
                    url: '{{ url('getBeneficiary') }}',
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(response) {

                        $("#beneficiary_details").html(response);


                        
                $('.select2').select2();
        $('select').on('change', function() { // when the value changes
            $(this).valid(); // trigger validation on this element
        });

        $('#userdata').on('change', function() {
                 getuserdata();
             });




                       
                    },
                    error: function(data) {
                       
                    },
                });

    }


    function getFormC(nationality,guest) {
           // var cid = $(this).val();
            if (nationality=="Others") {
            
                   $("#form-c-"+guest).css('display','block');


            }else{

                $("#country-"+guest).val(101);

                
          $("#country-"+guest).select2().trigger('change');


                $("#form-c-"+guest).css('display','none');
            }



        }



        function setGender(cid,guest) {
          
          if(cid=="Mr")
          {
            $("#gender-"+guest).val('Male');
           


          }else if(cid=="Ms")
          {
            $("#gender-"+guest).val('Female');

          }

          $("#gender-"+guest).select2().trigger('change');


        }





  function getState(cid,guest) {
           // var cid = $(this).val();
            if (cid) {
                $.ajax({
                    type: "get",
                    url: "{{ url('get_states') }}/" + cid,
                    success: function(res) {
                        if (res) {
                            $("#state-"+guest).empty();
                            $("#city-"+guest).empty();
                            $("#state-"+guest).append('<option>Select State</option>');
                            $("#city-"+guest).append('<option>Select City</option>');
                            $.each(res, function(key, value) {
                                $("#state-"+guest).append('<option value="' + key + '">' +
                                    value + '</option>');
                            });

                         
                            if ($('#userdata').is(':checked')) {
                                
                                @if(isset(auth()->user()->state))
        $('#state-0').val("{{ auth()->user()->state }}");
        $("#state-0").select2().trigger('change');
        @endif 


                            
                            }




                        }
                    }
                });
            }
        }

 function getCities(sid,guest) {
           
            if (sid) {
                $.ajax({
                    type: "get",
                    url: "{{ url('get_cities') }}/" + sid,
                    success: function(res) {
                        if (res) {
                            $("#city-"+guest).empty();
                            $("#city-"+guest).append('<option>Select City</option>');
                            $.each(res, function(key, value) {
                                $("#city-"+guest).append('<option value="' + key + '">' +
                                    value + '</option>');
                            });

                          
                            if ($('#userdata').is(':checked')) {
                   

        @if(isset(auth()->user()->state))
   
        $('#city-0').val("{{ auth()->user()->city }}");
        $("#city-0").select2().trigger('change');

        @endif 


                            
                            }


                        }
                    }
                });
            }
        }





        function getuserdata(){

         

            if ($('#userdata').is(':checked')) {
                              
           

          $('#title-0').val("{{ auth()->user()->title }}");
          $("#title-0").select2().trigger('change');

          $('#display_name-0').val("{{ auth()->user()->display_name }}");
          $('#email-0').val("{{ auth()->user()->email }}");
          $('#mobile_no-0').val("{{ auth()->user()->mobile_no }}");
          $('#land_line-0').val("{{ auth()->user()->land_line }}");
        
          $('#gender-0').val("{{ auth()->user()->gender }}");
          $("#gender-0").select2().trigger('change');

          $('#nationality-0').val("{{ auth()->user()->nationality }}");
          $("#nationality-0").select2().trigger('change');

          $('#address_line1-0').val("{{ auth()->user()->address_line1 }}");
          $('#address_line2-0').val("{{ auth()->user()->address_line2 }}");
          $('#pincode-0').val("{{ auth()->user()->pincode }}");
        
          $('#id_proof-0').val("{{ auth()->user()->id_proof }}");
          $("#id_proof-0").select2().trigger('change');
          $('#id_proof_no-0').val("{{ auth()->user()->id_proof_no }}");
          
          
          @if(Storage::disk('public')->exists(auth()->user()->id_proof_location))
          $('#id_proof_location_image-0').attr('src',"{{ url(Storage::url(auth()->user()->id_proof_location)) }}");
        @else 
          $('#id_proof_location_image-0').attr('src',"{{ url('assets/media/id_proof.jpg') }}");
         @endif 



          $("#id_proof_location_image-0").removeClass("required");

       

          $('#guest_or_trainee-0').val("{{ auth()->user()->guest_type }}");
          $("#guest_or_trainee-0").select2().trigger('change');



        @if(isset(auth()->user()->country))

        $('#country-0').val("{{ auth()->user()->country }}");
        $("#country-0").select2().trigger('change');

        @endif 
         
     
    }
    else{
        $('#title-0').val("");
        $('#display_name-0').val("");

        $('#display_name-0').val("");
          $('#email-0').val("");
          $('#mobile_no-0').val("");
          $('#land_line-0').val("");
        
          $('#gender-0').val("");
          $("#gender-0").select2().trigger('change');

          $('#nationality-0').val("{{ auth()->user()->nationality }}");
          $("#nationality-0").select2().trigger('change');

          $('#address_line1-0').val("");
          $('#address_line2-0').val("");
          $('#pincode-0').val("");
        
          $('#id_proof-0').val("");
          $("#id_proof-0").select2().trigger('change');
          $('#id_proof_no-0').val("");
       



        $('#id_proof_location_image-0').attr('src',"{{ url('assets/media/id_proof.jpg') }}");
         
         $("#id_proof_location_image-0").addClass("required");





        

    }
  }






    $(document).ready(function() {
        $('.select2').select2();
        $('select').on('change', function() { // when the value changes
            $(this).valid(); // trigger validation on this element
        });

      
        
        $('#no_of_persons').on('change', function() { // when the value changes
            view_beneficiaries();
        });


        view_beneficiaries();



     




        $('#program_purpose').on('change', function() { // when the value changes
            //view_rent();
            if($('#program_purpose').val()=="Trainee")
            {
                $('.training').css('display','block');
                $('.course_name').css('display','block');
                 $('.purpose_of_visit').css('display','none');
    
            }
            else if($('#program_purpose').val()=="Others")
            {

                $('.training').css('display','none');
                $('.course_name').css('display','none');
 
                $('.purpose_of_visit').css('display','block');
 

            }else{

                $('.training').css('display','none');
                $('.course_name').css('display','none');
                $('.purpose_of_visit').css('display','none');
 

            }


        });

      
        $("#update_form").validate({
            ignore: [],
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 1000, "easeInOutExpo");
            },
        });




        // $(".date-picker").datepicker({format: 'dd/mm/yyyy',todayHighlight:!0 ,orientation:"bottom left",autoclose:true});


      /*  $(".date-picker").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: !0,
            orientation: "bottom left",
            autoclose: true,
            startDate: '+2d',
            endDate: "+12m",
            useCurrent: true,
        }).on('changeDate', function(e) {
            // $('#checkout_date').datepicker('startDate',moment().add(50, 'days').format('DD/MM/YYYY'));
            if (days_between() <= 0) {}
        
        });
*/


      //  $('#checkin_date').datepicker('setDate', moment().add(2, 'days').format('DD/MM/YYYY'));
      //  $('#checkout_date').datepicker('setDate', moment().add(3, 'days').format('DD/MM/YYYY'));
      //  $(".time-picker").timepicker();

   


      $(".date-time-picker").datetimepicker({format:"dd/mm/yyyy HH:ii P",
      
      autoclose: true,

        todayBtn: true,

        showMeridian: true,
        initialDate:'today',
        
      pickerPosition:"bottom-right"}).on('changeDate', function(ev){




    


});
      
      
      //$('#checkin_date').datetimepicker('setStartDate', '25/11/2019 09:00 AM');
      //$('#checkout_date').datetimepicker('setStartDate', moment().add(3, 'days').format('DD/MM/YYYY'));


      $('#checkin_date').datetimepicker('setStartDate',  moment().format('YYYY-MM-DD'));
      $('#checkout_date').datetimepicker('setStartDate',  moment().format('YYYY-MM-DD'));
     


     $('#checkin_date').val(moment().format('DD/MM/YYYY hh:mm a'));
      $('#checkout_date').val(moment().format('DD/MM/YYYY hh:mm a'));
    
      //$('#checkout_date').datetimepicker('setStartDate',  moment().add(3, 'days').format('YYYY-MM-DD'));
     


     




       




        $("#update_btn").click(function(event) {
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
                    success: function(response) {
                        $("#update_btn").html('<i class="fa fa-check"></i> Submit Form');
                        $("#update_btn").attr("disabled", false);
                        if (response.status === true) {
                            toastr.success(response.notification);

                            warning=false;
                            

                            window.location.href = "{{  url('myreservations')  }}";

                        } else {
                            $("#update_btn").html(
                                '<i class="fa fa-check"></i> Submit Form');
                            $("#update_btn").attr("disabled", false);
                            toastr.error(response.notification);
                        }
                        $('html, body').animate({
                            scrollTop: 0
                        }, 1000, "easeInOutExpo");
                    },
                    error: function(data) {
                        $("#update_btn").html('<i class="fa fa-check"></i> Submit Form');
                        $("#update_btn").attr("disabled", false);
                        toastr.error("Oops... Something went wrong!" + data);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 1000, "easeInOutExpo");
                    },
                });
            } else {
                $("#update_btn").html('<i class="fa fa-check"></i> Submit Form');
                $("#update_btn").attr("disabled", false);
            }
        });

    //    view_rent();



    });
</script>
@endpush
@section('body_class','')
@section('content')
<div class="header-style-1 text-center">
    <div class="overlay"></div>
    <h2>RESERVATION</h2>
</div>
<section class="about p-5 bgGray">
    <div class="container">
        <div class="stepwizard mb-3">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" class="btn btn-primary btn-circle">1</a>
                    <p>Reservation</p>
                </div>

            
                <div class="stepwizard-step last">
                    <a href="#step-2" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p>Guest Information</p>
                </div>
            </div>
        </div>
        {{ Form::open(['url' => url('reservation'),'id'=>'update_form', 'files' => true,'class'=>'form-vertical
                validate_form p-5', 'method' => 'post','autocomplete'=>'off']) }}
        <div class="setup-content" id="step-1">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Check In Date*</label>
                        <div class="input-group">
                            {!! Form::input('text','checkin_date',null, ['class' => 'form-control view_rent date-time-picker m-input required',
                            'placeholder' => 'Checkin Date', 'autocomplete'=>"nope",'id'=>'checkin_date' ])
                            !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Check Out Date*</label>
                        <div class="input-group">
                            {!! Form::input('text','checkout_date',null, ['class' => 'form-control view_rent date-time-picker m-input required',
                            'placeholder' => 'Checkout Date', 'autocomplete'=>"nope",'id'=>'checkout_date' ])
                            !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                            <div class="form-group   ">
                                <label for="gender">No of Persons*</label>
                                {!! Form::select('no_of_persons',range(0,30),1, ['class' => 'form-control number view_rent select2  m-input required',
                                'placeholder' => 'No of Persons','id'=>'no_of_persons', 'autocomplete'=>"nope" ])
                                !!}
                            </div>
                </div>
                  



              
            </div>
           



    

            
        <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Program Purpose*</label>
                        <div class="input-group">
                        {!! Form::select('program_purpose',$program_purpose,null, ['class' => 'form-control m-input
                            select2 required', 'placeholder' => 'Select Program Purpose','id'=>'program_purpose' ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Organization</label>
                        <div class="input-group">
                        {!! Form::input('text', 'organization',null, ['class' => 'form-control m-input
                            ', 'placeholder' => 'Organization','id'=>'organization' ]) !!}
                        
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                <div class="form-group   ">
                        <label for="checkin_date">Additonal Informtion</label>
                        <div class="input-group">
                        {!! Form::input('text', 'additional_information',null, ['class' => 'form-control m-input
                            ', 'placeholder' => 'Additional Information','id'=>'additional_information' ]) !!}
                        
                        </div>
                    </div>
                </div>



                
            </div>


            <div class="row">
               
                
                <div class="col-md-4">
                    <div class="form-group  training" style="display:none;">
                        <label for="gender">Training Details</label>
                        <div class="input-group">
                        {!! Form::select('training_id', $training ,null, ['class' => 'form-control  m-input
                            select2 ', 'placeholder' => 'Select Training Details','id'=>'training_details' ]) !!}
                      
                        </div>
                    </div>

                    <div class="form-group  purpose_of_visit" style="display:none;">
                        <label for="gender">Purpose of Visit</label>
                        <div class="input-group">
                            {!! Form::input('text','purpose_of_visit',null, ['class' => 'form-control m-input ',
                            'placeholder' => 'Purpose of Visit', 'autocomplete'=>"nope",'id'=>'purpose_of_visit' ])
                            !!}
                      
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group course_name" style="display:none;">
                        <label for="checkin_date">Course Name</label>
                        <div class="input-group">
                            {!! Form::input('text','course_name',null, ['class' => 'form-control m-input ',
                            'placeholder' => 'Course Name', 'autocomplete'=>"nope",'id'=>'course_name' ])
                            !!}
                        </div>
                    </div>
                </div>
               

            </div>

            

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Contact Person at Aravind*</label>
                        <div class="input-group">
                        {!! Form::input('text', 'contact_person',null, ['class' => 'form-control m-input required', 'placeholder' => 'Contact Person at Aravind','id'=>'contact_person' ]) !!}
                        
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Contact Person MobileNo*</label>
                        <div class="input-group">
                        {!! Form::input('text', 'contact_person_mobileno',null, ['class' => 'form-control m-input required', 'placeholder' => 'Contact person mobileno','id'=>'contact_person_mobileno' ]) !!}
                        
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="checkin_date">Contact Person Email Id*</label>
                        <div class="input-group">
                        {!! Form::input('text', 'contact_person_email',null, ['class' => 'form-control email m-input required
                            ', 'placeholder' => 'Contact person email','id'=>'contact_person_email' ]) !!}
                        
                        </div>
                    </div>
                </div>





            </div>






            <div class="row">
            <div class="col-md-4 offset-md-8">
                    <div class="form-group   ">
                        <label for="meal_needed">&nbsp;</label>
                        <button class="btn btn-primary nextBtn  form-control" type="button">Next</button>
                    </div>
                </div>
            </div>





            <div id="room_tariff" class="mt-5">
                      
                            <h3>Room Tariff(in Indian Rupees) :</h3>


                            <div class="table-responsive">
            
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Period </th>
                                            <th colspan="2">Non A/C </th>
                                            <th colspan="2">A/C </th>
                                        </tr>
            
                                        <tr>
                                            <th>*Twin Sharing Non AC </th>
                                            <th>Single Non AC </th>
                                            <th>*Twin Sharing AC</th>
                                            <th>Single AC </th>
                                        </tr>
            
                                    </thead>
                                    <tbody>
            
                                        <tr>
                                            <td> Daily Tariff </td>
                                            <td> 350</td>
                                            <td> 500</td>
                                            <td> 700</td>
                                            <td> 1000</td>
                                        </tr>
            
                                        <tr>
                                            <td> Weekly (Applicable for stay &gt;=7 days, &lt;30days</td>
                                            <td> 300</td>
                                            <td> 425</td>
                                            <td> 600 </td>
                                            <td>850 </td>
                                        </tr>
            
                                        <tr>
                                            <td> Monthly (Applicable stay &gt;=30days </td>
                                            <td> 245</td>
                                            <td> 350</td>
                                            <td> 490</td>
                                            <td> 700</td>
                                        </tr>
            
                                    </tbody>
                                </table>
                            </div>
            
            
                            <p> * Rates are per occupant </p>
                            <p>
                                <span class="la la-arrow-right mr-2"></span>Above rates are inclusive of room rent, free
                                internet and complimentary breakfast<br>
                                <span class="la la-arrow-right mr-2"></span>No further discounts will be given <br>
                                <span class="la la-arrow-right mr-2"></span>Payment for entire stay or one month needs to
                                be paid in advance at the time of confirmation / check-in <br>
            
                            </p>
            
            
            

                            


                    </div>




            
            



        </div>
     










        <div class="setup-content" id="step-2">

            
<div id="beneficiary_details">
          

</div>



            <div class="row">
                <div class="col-md-12">
                    <div class="form-group   ">
                        <button class="btn btn-primary prevBtn pull-left" type="button">Previous</button>
                        <button class="btn btn-primary   pull-right" type="submit" id="update_btn">Submit Form</button>
                    </div>
                </div>
            </div>




        </div>

        {{ Form::close() }}
    </div>
    </div>
</section>
@stop