@extends('layouts.front')
@section('title')
<?php
?>
@endsection
@push('pre_css')
@endpush
@push('css')
<style>
.contact input.form-control,textarea.form-control{
    background: #ffffff;
    border: 0px solid lightGrey;
    border-bottom: 1px solid #b9b8b8;
    margin-top: 20px;
}
.contact input.submit-btn{
    background: #8e2927 !important; 
    padding: 10px;
    height: auto;
    color: #fff;
}
.contact label.error{color:red;}
</style>
@endpush
@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
$("#commentForm").validate();
</script>



@endpush
@section('body_class','')
@section('content')
<div class="header-style-1 text-center" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <h2>Contact</h2>
<p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i class="la la-angle-right"></i></a></span> <span>Contact</span></p>

</div>
<section class="contact p-md-5 p-3 bgGray">
    <div class="container" style="background: #fff;padding: 30px;font-size:14px;line-height:28px;">
 

        <div class="row">

                   
        <div class="col-md-6 col-sm-12 active-block">
              
              <h2 class="header-style-2 " style="font-size:24px;margin-bottom:20px;">CONTACT US</h2>
                            If you would like to talk to us or find out more about us please drop us a line or send an email.
              

                            <form class="cmtform" id="commentForm"  method="post" action="{{ url('contact_submit') }}" novalidate="novalidate">

                            @csrf
              
                            <div class="row ">
                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                            <input type="text" name="first_name" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="First Name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                            <input type="text" name="last_name" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Last Name">
                            </div>
                            </div>

                            <div class="s3-sep sep-none" style="margin-top:8px;"></div>
                           
                            <div class="row ">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                           <input type="email" name="email" value="" size="40" class="form-control required email" aria-required="true" aria-invalid="false" placeholder="Email id">

                            </div>
                            </div>
                            <div class="s3-sep sep-none" style="margin-top:8px;"></div>
                            <div class="row ">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                           <input type="text" name="phone_no" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Phone No">
                            </div>
                            </div>
                            <div class="s3-sep sep-none" style="margin-top:8px;"></div>
                            <div class="row ">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                           <textarea rows="3" name="message" value=""  class="form-control required" aria-required="true" aria-invalid="false" placeholder="Message"></textarea>
                            </div>
                            </div>
                            <div class="s3-sep sep-none" style="margin-top:8px;"></div>
                            <div class="row ">
                           
                            <div class="col-xs-12 col-sm-12">
                            <input type="submit" value="SUBMIT" class="form-control submit-btn"><span class="ajax-loader">
                                </div>
                            </div>
                            </form>
                        
                        </div>



                        <div class="col-md-6 col-sm-12">
                   
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3930.139809344911!2d78.13601021479357!3d9.922312192904437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b00c5a373c147cf%3A0xfb8c87886b84f95!2sInspiration%20-%20Aravind%20Trainees%20Hostel!5e0!3m2!1sen!2sin!4v1574321075235!5m2!1sen!2sin"width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>


                </div>



            </div>
            </div>
</section>






@stop