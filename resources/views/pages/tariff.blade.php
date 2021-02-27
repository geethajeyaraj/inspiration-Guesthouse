@extends('layouts.front')
@section('title')
<?php
?>
@endsection
@push('pre_css')
@endpush
@push('css')

@endpush
@push('js')

@endpush
@section('body_class','')
@section('content')
<div class="header-style-1 text-center" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <h2>TARIFF</h2>
    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i class="la la-angle-right"></i></a></span>
        <span>Tariff</span></p>

</div>
<section class="about p-md-5 bgGray">
    <div class="container p-0" >


            <ul class="nav nav-pills  no-gutters row row-eq-height">
                    <li class="nav-item  col-6">
                      <a class="nav-link active"  data-toggle="tab" href="#room_tariff">Room Tariff</a>
                    </li>
                    <li class="nav-item   col-6">
                      <a class="nav-link" data-toggle="tab" href="#meals_tariff">Meal Tariff</a>
                    </li>
  
                </ul>



                  <div class="info tab-content  pl-3 pr-3" style="background: #fff;padding: 30px;font-size:14px;line-height:28px;">
                    <div id="room_tariff" class="tab-pane fade in active show">
                      
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
                    <div id="meals_tariff" class="tab-pane fade">
                     


                            <h3>Meals Tariff</h3>
                        
                                                <h4> Inspiration welcomes you to join our Meal plan </h4>
                                          
                                                <div class="clearpix"> </div>
                                                <h5>Tariff: </h5>
                                            <div class="clearpix"> </div>
                                                <p>
                                                    <span class="la la-arrow-right mr-2"></span>The cost of food
                                                    (Lunch and Dinner) is calculated on daily basis as Rs. 189/- (including 5%
                                                    tax) <br>
                                                    <span class="la la-arrow-right mr-2"></span>Meal charges will be
                                                    excluded for following scenarios:<br>
        
                                                    <span class="la la-arrow-right mr-2"></span>On Sundays (Lunch
                                                    &amp; Dinner will not be served on Sundays) <br>
                                                    <span class="la la-arrow-right mr-2"></span>If your check-in time
                                                    is after 9 PM on check-in date <br>
                                                    <span class="la la-arrow-right mr-2"></span>If your checkout time
                                                    is before 1 PM on check-out date
        
                                                </p>
                                            <div class="clearpix"> </div>
        
        
                                                <h5>Payment: </h5>
                                            <div class="clearpix"> </div>
                                                <p>
                                                    <span class="la la-arrow-right mr-2"></span>Payment for meal plan
                                                    should be paid along with the room rent at the time of advance payment /
                                                    check-in <br>
                                                    <span class="la la-arrow-right mr-2"></span>Once you opt for meal
                                                    plan, you will be charged irrespective of whether you have the meals at
                                                    Inspiration or not <br>
                                                    <span class="la la-arrow-right mr-2"></span>Payment will not be
                                                    refunded if you withdraw meal plan during your stay. <br>
                                                </p>
                                                <h5>Menu: </h5>
                                            <div class="clearpix"> </div>
                                                <p>
                                                    <span class="la la-arrow-right mr-2"></span>Standard breakfast
                                                    includes Eggs, Porridge, Toast, one Indian delicacy with a fruit &amp;
                                                    Coffee / Tea<br>
                                                    <span class="la la-arrow-right mr-2"></span>Lunch and Dinner will
                                                    mainly consists of Indian dishes with roti<br>
                                                    <span class="la la-arrow-right mr-2"></span>One non-vegetarian
                                                    dish will be served at lunch, 5 days a week<br>
                                                </p>
                                           
             <h5>Meal Timing: </h5>
                                            <div class="clearpix"> </div>
                                                <p>Meals are served at fixed timings, Monday through Saturday </p>
                                                <table border="2" class="table table-bordered text-center">
                                                    <tbody>
                                                        <tr>
                                                            <td> Breakfast </td>
                                                            <td>7.00 am – 8.00 am </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Lunch </td>
                                                            <td>12.30 pm – 02.00 pm </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Dinner </td>
                                                            <td>7.00 pm – 8.00 pm </td>
                                                        </tr>
        
                                                    </tbody>
                                                </table>
                                                <p>On Sundays, only breakfast will be served from 8.00 am – 9.00 am </p>
                                                <p>
                                                    <span class="la la-arrow-right mr-2"></span>Nutritious and healthy
                                                    meals prepared in a clean environment are served at reasonable rates by the
                                                    Inspiration staff.<br>
                                                    <span class="la la-arrow-right mr-2"></span>Complimentary
                                                    breakfast will be served every day. Lunch and Dinner will be served on all
                                                    days except Sunday.<br>
                                                    <span class="la la-arrow-right mr-2"></span>Food will be served at
                                                    the Dining hall only. Taking food and beverages to the guest rooms are
                                                    strictly prohibited.<br>
                                                </p>
                                           





                    </div>
                   
                  </div>








    </div>
</section>






@stop