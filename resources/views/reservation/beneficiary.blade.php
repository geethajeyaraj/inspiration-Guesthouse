
@for($i=0;$i<$no_of_persons;$i++)
<div class="row mb-5">
<div class="col-md-12">
<h4>Guest Detail #{{ ($i+1) }}</h4>
@if($i==0)  <input class="" id="userdata" type="checkbox">
<label class="" for="userdata">I want to include my data</label> 
@endif 
<hr>
<div class="row">
                <div class="col-md-4">
                        <div class="row">
                                <div class="col-md-3 col-4">
                                        <div class="form-group   ">
                                                <label for="title">Title*</label>
                   
                        {!! Form::select('title[]',['Mr'=>'Mr','Ms'=>'Ms','Dr'=>'Dr'],null, ['class' => 'form-control m-input
                select2 required', 'placeholder' => 'Title','id'=>'title-'.$i, 'onchange'=>'setGender(this.value,'.$i.')' ]) !!}

                                        </div> 
                    </div> 
                    <div class="col-md-9 col-8">

                            <div class="form-group   ">
                                    <label for="title">Name*</label>
                   
                            {!! Form::input('text','display_name[]',null, ['class' => 'form-control m-input required',
                            'placeholder' => 'Enter your name', 'autocomplete'=>"nope", 'id' =>'display_name-'.$i ])
                            !!}

                            </div>
                    </div>
                        </div>
                                  </div>
              
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="email">Email*</label>


                        <div class="input-group">

                                {!! Form::input('text','email[]',null, ['class' => 'form-control m-input email required',
                                'placeholder' => 'Enter your email', 'autocomplete'=>"nope", 'id'=>'email-'.$i ])
                                !!}
                        </div>


                        
                    </div>
                </div>

                <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="mobile_no">Phone Mobile*</label>
    
    
                            <div class="input-group">
    
                                    {!! Form::input('text','mobile_no[]',null, ['class' => 'form-control m-input required',
                                    'placeholder' => 'Enter your Mobile No', 'autocomplete'=>"nope",'id'=>'mobile_no-'.$i   ])
                                    !!}
    
                            </div>
    
    
                           
                        </div>
                    </div>


            </div>


                  
            <div class="row">
               
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="land_line">Payment Mode</label>
                        <div class="input-group">
                        {!! Form::select('payment_mode_id[]',$payments,null, ['class' => 'form-control m-input
                        select2 required', 'placeholder' => 'Select Payment Mode','id'=>'payment_mode_id-'.$i ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="land_line">Room type</label>
                        <div class="input-group">
                        {!! Form::select('room_type_id[]',$room_types,null, ['class' => 'form-control m-input
                        select2 required', 'placeholder' => 'Select Room Type','id'=>'room_type_id-'.$i ]) !!}
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="land_line">Meal Needed</label>
                        <div class="input-group">
                        {!! Form::select('meal_needed[]',[1=>"Yes",0=>"No"],null, ['class' => 'form-control m-input
                        select2 required', 'placeholder' => 'Select Meal Needed','id'=>'meal_needed-'.$i ]) !!}
                        </div>
                    </div>
                </div>




            </div>


            <div class="row">
               
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="land_line">Phone Land Line</label>


                        <div class="input-group">

                                {!! Form::input('text','land_line[]',null, ['class' => 'form-control m-input',
                                'placeholder' => 'Enter your Landline No', 'autocomplete'=>"nope",'id'=>'land_line-'.$i ])
                                !!}

                        </div>


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="gender">Gender*</label>

                        {!! Form::select('gender[]', ['Male'=>'Male','Female'=>'Female','Transgender'=>'Transgender'],null, ['class' => 'form-control m-input
                        select2 required', 'placeholder' => 'Select Gender','id'=>'gender-'.$i ]) !!}

                       
                    </div>
                </div>

                <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="nationality">Nationality*</label>
    
                            {!! Form::select('nationality[]',['Indian'=>'Indian','Others'=>'Others'],null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Nationality','id'=>'nationality-'.$i , 'onchange'=>'getFormC(this.value,'.$i.')' ]) !!}
    
    
                        </div>
                    </div>


            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="country">Country*</label>

                        {!! Form::select('country[]',$countries,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Country','id'=>'country-'.$i, 'onchange'=>'getState(this.value,'.$i.')' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="state">State*</label>

                        {!! Form::select('state[]',$states,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select State','id'=>'state-'.$i , 'onchange'=>'getCities(this.value,'.$i.')' ]) !!}


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group   ">
                        <label for="city">City*</label>
                        {!! Form::select('city[]',$cities,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select City','id'=>'city-'.$i ]) !!}



                    </div>
                </div>
            </div>

            <div class="row">
              
                    <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="address_line_1">Address Line 1*</label>
    
    
                            <div class="input-group">
    
                                    {!! Form::input('text','address_line1[]',null, ['class' => 'form-control m-input required',
                                    'placeholder' => 'Enter your address line 1', 'autocomplete'=>"nope",'id'=>'address_line1-'.$i  ])
                                    !!}
    
                            </div>
    
    
                          
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group   ">
                            <label for="address_line_2">Address Line 2</label>
    
    
                            <div class="input-group">
    
                                    {!! Form::input('text','address_line2[]',null, ['class' => 'form-control m-input',
                                    'placeholder' => 'Enter your address line 2', 'autocomplete'=>"nope",'id'=>'address_line2-'.$i ])
                                    !!}
                            </div>
    
    
                          
                        </div>
                    </div>

                    <div class="col-md-4">
                            <div class="form-group   ">
                                <label for="pincode">Pincode*</label>
        
        
                                <div class="input-group">
        
                                        {!! Form::input('text','pincode[]',null, ['class' => 'form-control m-input required',
                                        'placeholder' => 'Enter your pincode', 'autocomplete'=>"nope",'id'=>'pincode-'.$i ])
                                        !!}
                                </div>
        
        
                              
                            </div>
                        </div>



                </div>


                <div class="row">
               
               <div class="col-md-4">
                   <div class="form-group   ">
                       <label for="land_line">Guest/Trainee*</label>


                       <div class="input-group">

                       {!! Form::select('guest_or_trainee[]', ['Guest'=>'Guest','Trainee'=>'Trainee'],null, ['class' => 'form-control m-input
                       select2 required', 'placeholder' => 'Select Guest or Trainee','id'=>'guest_or_trainee-'.$i ]) !!}

                       </div>


                   </div>
               </div>
               <div class="col-md-4">
                   <div class="form-group   ">
                       <label for="gender">Id Proof*</label>

                       {!! Form::select('id_proof[]',$id_proofs,null, ['class' => 'form-control m-input  select2 required', 'placeholder' => 'Select Id Proof','id'=>'id_proof-'.$i ]) !!}
   

                      
                   </div>
               </div>

               <div class="col-md-4">
                       <div class="form-group   ">
                           <label for="nationality">Id Proof Number*</label>
   
                    
                           {!! Form::input('text','id_proof_no[]',null, ['class' => 'form-control m-input required',
                                        'placeholder' => 'Enter Id Proof No', 'autocomplete'=>"nope",'id'=>'id_proof_no-'.$i ])
                                        !!}
   
                       </div>
                   </div>
                   </div>

                   

                   <div class="row">
                   <div class="col-md-4">
                            <div class="form-group   ">
                                <label for="centre_id">Id Proof*</label>
        

            <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: auto;">
                        <img id="id_proof_location_image-{{ $i }}" src="{{ url('assets/media/id_proof.jpg') }}" class="" alt="User Image">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:200px; max-height:200px;">
                    </div>
                    <div>
                        <span class="btn btn-sm btn-primary btn-file">
                            <span class="fileinput-new">
                                Select image </span>
                            <span class="fileinput-exists">
                                Change </span>
                            <input type="file" id="id_proof_location-{{ $i }}" name="id_proof_location[]">
                        </span>
                        <a href="#" class="btn btn-sm  btn-danger fileinput-exists" data-dismiss="fileinput">
                            Remove </a>
                    </div>
                </div>
            </div>


        </div>




        <div class="col-md-4" id="form-c-{{ $i }}">
                            <div class="form-group   ">
                                <label for="centre_id">Form C Proof*</label>
        

            <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: auto;">
                        <img src="{{ url('assets/media/id_proof.jpg') }}" class="" alt="User Image">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:200px; max-height:200px;">
                    </div>
                    <div>
                        <span class="btn btn-sm btn-primary btn-file">
                            <span class="fileinput-new">
                                Select image </span>
                            <span class="fileinput-exists">
                                Change </span>
                            <input type="file" id="formc_proof_location-{{ $i }}" name="formc_proof_location[]">
                        </span>
                        <a href="#" class="btn btn-sm  btn-danger fileinput-exists" data-dismiss="fileinput">
                            Remove </a>
                    </div>
                </div>
            </div>


        </div>







           </div>

           


</div>
</div>


@endfor
