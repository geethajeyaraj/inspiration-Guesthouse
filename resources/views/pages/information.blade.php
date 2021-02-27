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
    <h2>General Information</h2>
<p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i class="la la-angle-right"></i></a></span> <span>General Information</span></p>

</div>
<section class="about p-md-5 bgGray">
    <div class="container p-0" >
 
        
            <ul class="nav nav-pills  no-gutters row row-eq-height">
                    <li class="nav-item  col-4">
                      <a class="nav-link active"  data-toggle="tab" href="#general_information">General Information</a>
                    </li>
                    <li class="nav-item   col-4">
                      <a class="nav-link" data-toggle="tab" href="#guidelines">Guidelines</a>
                    </li>
                    <li class="nav-item   col-4">
                            <a class="nav-link" data-toggle="tab" href="#for_international_guests">For International Guests</a>
                          </li>
                          
  
                </ul>

                <div class="info  tab-content  pl-3 pr-3" style="background: #fff;padding: 30px;font-size:14px;line-height:28px;">
                        <div id="general_information" class="tab-pane fade in active show">
                          <h3>Front Desk</h3>
                                        
                                        <ul>
                                            <li>Front Desk is open from 8.00am – 6.00pm to facilitate checking in and out, for enquiries, room
                                        booking, and receiving messages for the occupants. Services are not available on Sundays.</li>
                                             <li><b>Reservation</b>
                                        The reservation should be done by submitting the completed Reservation form. Please download
                                        the Reservation Form here and submit through your contact person / training co-ordinator at
                                        Aravind.</li>
                                              <li><b>Check-in</b>
                                        While checking-in, you are requested to submit the official letter from Aravind Eye Care System
                                        confirming your registration. Those who are checking-in after 6.00pm and on Sundays, keys will be
                                        kept ready with the Security.</li>
                                               <li><b>Check-out</b>
                                        24 hours check-out. Check-out will be done based on the completion of all payments. Formalities
                                        can be done before 3.30pm for those who are checking out after 6.00pm and on Sundays should
                                        complete the check-out formalities on Saturday evening.</li>
                                                <li><b>PAYMENT</b>
                                        Short term (staying for less than a month)
                                        Payments for the room and board for the entire period
                                        of stay should be fully paid at the time of check-in, if
                                        not done earlier</li>
                                                 <li><b>TELEPHONE</b>
                                        An intercom is provided in each room for connecting
                                        to the front desk and the hospital staff. Other public
                                        calls will have to be made from STD/ISD phone
                                        booths located near the Guest House</li>
                                                  <li>Long Term (staying for more than a month)
                                        Payments for the room and board for the entire period
                                        can be made along with the course fee either by cheque/
                                        DD or wire transfer. If not, payment for at least one
                                        month must be made along with the course fee. For the
                                        subsequent months, monthly payment should be made
                                        on the first working day of the month.</li>
                                                   <li>Those who have paid in advance through wire transfer
                                        should produce proof of the same at the time of check-in.</li>
                                                    <li>Payment can be made through credit/debit card (Visa/
                                        Master card). Appropriate service tax will be added to the
                                        payment.</li>
                                                     <li>Direct cash payment at the time of check-in will be
                                        accepted only for those staying less than a week.</li>
                                                      <li>Cheques will be accepted only from long term guests.
                                        Cheque/DD should be in the name of “LAICO Trainees
                                        hostel”,payable at Madurai.</li>
                                                       <li>At the time of payment, always ensure that you get a
                                        receipt.</li>
                                                    <li>Sponsored trainees should produce the proof of
                                        sponsorship at the time of check-in.</li>
                                                     <li>NOTE
                                        There is no payment facility at Inspiration</li>
                                                     
                                        </ul>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                        </div>

                        <div id="guidelines" class="tab-pane fade in">

                                        <h2>Guidelines </h2>
                                        <ul>
                                            <li>To ensure safety and comfort of the trainees and guests,
                                        inspiration has laid out the following guidelines. All inmates
                                        have to abide by these during their entire stay here.</li>
                                            <li>All occupants should be in the guest house by 10.00 pm
                                        Alcohol and Smoking are strictly prohibited in the guest house
                                        premises.</li>
                                            <li>Visitors can meet the guests at the reception only. They are not
                                        allowed in the rooms at any time.</li>
                                            <li>Food served at ‘Inspiration’ has to be taken only in the dining
                                        hall. It should not be carried to the guest rooms.</li>
                                            <li>For the convenience of the guests, a list with contact
                                        information of several vendors (travel, money exchange etc.)
                                        is provided in the information folder kept in the room. Please
                                        note that the Aravind management and staff are not liable for
                                        disagreements / disputes with any of these vendors. The guests
                                        should make payments directly and deal with them on their
                                        own discretion.</li>
                                            <li>Tips to the employees is strictly prohibited at Aravind.
                                        Occupants are discouraged to have any financial transaction
                                        with employees. Management is not liable for the same.</li>
                                           
                                            
                                            
                                        </ul>
                                        
                          
                            </div>

                            <div id="for_international_guests" class="tab-pane fade in">
<h2>For International Guests</h2>
                                            <ul>
                                                <li>As per the rule of Govt. of India, Form “C” should be filled-in
                                            and submitted at the front desk</li>
                                                 <li>Copy of passport and visa details should be enclosed. Ensure
                                            that you have minimum of three photocopies of passport details
                                            and your passport size photos</li>
                                                  <li> If required, documents should be presented to the local police
                                            commissioner office in person (refer registration guidelines - for
                                            more details).</li>
                                                 
                                            </ul>
                                             
                          
                                </div>
        
                            

                </div>    




    </div>
</section>






@stop