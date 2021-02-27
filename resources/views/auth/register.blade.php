@extends('layouts.app')
@section('title', 'Login - '.Helpers::settings('site_full_name'))
@section('section_post_css')
<style>  

.login-title{ font-size: 30px; font-weight: 300; color: #4e5a64; }
.login-subtitle { color: #a0a9b4; font-size: 15px; line-height: 22px; }
.form-control{    width: 100%; padding: 10px 0; border: #a0a9b4; border-bottom: 1px solid;
    color: #868e97; font-size: 14px;}
.login-container{width:500px; max-width:100%;}

.login-footer {  position: absolute;  bottom: 0;  width: 100%;   padding-bottom: 10px; 
  width:500px; max-width:100%;
  }
.login-social li {
    display: inline-block;
    list-style: none;
    margin-right: 1em;
}
.login-copyright>p {
    margin: 0;
    font-size: 13px;
    color: #a9b5be;
}

.login-btn{
  font-size: 12px;
    transition: box-shadow .28s cubic-bezier(.4,0,.2,1);
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -ms-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 2px;
    overflow: hidden;
    position: relative;
    user-select: none;
    padding: 8px 14px 7px;
    line-height: 1.44;
    color: #FFF;
    background-color: #32c5d2;
    border-color: #32c5d2;

}


.login-bg{
position: relative; z-index: 0;background:url('http://edu.kalasalingam.ac.in/images/bg3.jpg');background-size:cover;height:auto;padding:40px;
}

.login-container {
   
    padding: 40px;
}
.login-form {  margin-top: 20px;  color: #a4aab2;   font-size: 13px; }
.login-footer{display:none;}

@media (min-width: 767px) 
{
  .login-form {  margin-top: 80px;  color: #a4aab2;   font-size: 13px; }
.login-bg{
position: relative; z-index: 0;background:url('http://edu.kalasalingam.ac.in/images/bg3.jpg');background-size:cover;height:100vh;
}
.login-footer{display:block;}

}


</style>
@stop
@section('section_js')

  <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ url('assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
  
  <script>
    $(document).ready(function() {
            $('.login-form').validate();    
    });		
  </script>

@stop


@section('body')

<div class="s3-login">
    <div class="row m-0" >

      <div class="col-md-6 p-0">
        <div class="login-bg"  >
          
        
        @if(Storage::disk('public')->exists(Helpers::settings('login_logo')))
                        <img alt="Logo" class="login-logo" src="{{ asset(Storage::url(Helpers::settings('login_logo'))) }}" />
                        @else
                        <img alt="Logo" class="login-logo" src="{{ asset('assets/media/logo.png') }}" />
                        @endif

        
    </div>


      </div>
      <div class="col-md-6 d-flex  align-items-center justify-content-center">

        <div class="login-container">
      
        <div class="login-content">
      
          <h1 class="login-title">Login - {{ Helpers::settings('site_full_name') }}</h1>
          <p class="login-subtitle">Reservation System - {{ Helpers::settings('site_short_name') }}</p>

        
             <!--begin::Form-->
             <form action="{{ url('register') }}" method="post" class="kt-form" autocomplete="off">
                                {!! csrf_field() !!}
                

                                <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                          <div class="form-group {{ $errors->has('user_name') ? 'has-danger':'' }}">
                                          {!! Form::input('text','display_name',null, ['class' => 'form-control  required','placeholder' => 'Name'])
                                          !!}
                                          @if ($errors->has('display_name'))
                                               <span class="kt-font-danger ">
                                                      {{ $errors->first('display_name') }}
                                                  </span>
                                              @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                          <div class="form-group {{ $errors->has('password') ? 'has-danger':'' }}">
                                          {!! Form::input('password','password',null, ['class' => 'form-control required',
                                          'placeholder' => 'Password'])
                                          !!}
                                                     @if ($errors->has('password'))
                                                  <span class="kt-font-danger ">
                                                      {{ $errors->first('password') }}
                                                  </span>
                                              @endif
                                          </div>
                                        </div>
                                      </div>


                                  

                                          <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                  <div class="form-group {{ $errors->has('email') ? 'has-danger':'' }}">
                                                  {!! Form::input('text','email',null, ['class' => 'form-control email required',
                                                  'placeholder' => 'Email'])
                                                  !!}
                                                  @if ($errors->has('email'))
                                                       <span class="kt-font-danger ">
                                                              {{ $errors->first('email') }}
                                                          </span>
                                                      @endif
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                  <div class="form-group {{ $errors->has('mobile_no') ? 'has-danger':'' }}">
                                                  {!! Form::input('text','mobile_no',null, ['class' => 'form-control required number',"minlength"=>"10","maxlength"=>"10",
                                                  'placeholder' => 'Mobile no'])
                                                  !!}
                                                             @if ($errors->has('mobile_no'))
                                                          <span class="">
                                                              {{ $errors->first('mobile_no') }}
                                                          </span>
                                                      @endif
                                                  </div>
                                                </div>
                                              </div>



                            <!--begin::Action-->
                            <div class="kt-login__actions">
                                <a href="#" class="kt-link kt-login__link-forgot">
                                  
                                </a>
                                <button id="kt_login_signin_submit" class="btn btn-primary  btn-elevate kt-login__btn-primary">Register</button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->



        </div>
      </div>

      <div class="login-footer">
          <div class="row m-0 p-0">
            <div class="col-md-5">
              <ul class="login-social">
                <li>
                  <a target="_blank" href="https://www.facebook.com/kalasalingamuniversity.klu">
                    <i class="fa fa-facebook"></i>
                  </a>
                </li>
                <li>
                  <a target="_blank" href="https://twitter.com/KLU_official">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li>
                <li>
                  <a target="_blank" href="https://www.youtube.com/channel/UCn7qESyFTyyRbyStJxZYYwg">
                    <i class="fa fa-youtube"></i>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-7">
              <div class="login-copyright text-right">
                <p>Copyright © SDT-KARE</p>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div>
  </div>






                     
@endsection




