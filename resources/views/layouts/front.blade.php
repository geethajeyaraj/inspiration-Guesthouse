<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Document Meta
    ============================================= -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--IE Compatibility Meta-->
    <meta name="author" content="Selvakumar Sankaravel" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
     @yield('title', 'Home - LAICO ')
  
     @if(Storage::disk('public')->exists(Helpers::settings('favicon')))
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset(Storage::url(Helpers::settings('favicon'))) }}" />
	@else
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/logo/favicon.png') }}" />
    @endif
    

  
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    @stack('pre_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link href="{{ url('assets/fonts/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('fassets/css/plugins.css?ver=1.3') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('fassets/css/style.css?ver=1.4') }}" rel="stylesheet" type="text/css" />
   
    <style>
    .nav-link{
        cursor: pointer;
    }
    .logo {
    padding: 2px 0px;
    max-height: 80px;
    background: rgba(255, 255, 255, 0.8);
    border-radius:10px;
    }
    .header {
    background-color: rgba(142,41,39,100);
    }
    .main-footer .widgets-section {
    background: #231F20;
    }
    span.help-text {
    font-weight: 300;
    }
    .header-style-1{
    font-size:24px;margin:0px;color:#f4f4f4;background-image:url("{{ asset('fassets/images/bg_1.jpg') }}");padding-top:30px;padding-bottom:30px;text-shadow: 1px 1px 5px #000;
    position: relative;
  background-size: cover;
  background-attachment: fixed;
  background-position: 50% 0;
  background-repeat: no-repeat;

    }

    .overlay{
        position: absolute;top:0;bottom:0;width:100%;background: rgba(142,41,39,100);opacity:0.8;zindex:0;
    }
    .header-style-1 h2{
    position: relative;margin: 0px;font-weight: 300;letter-spacing: 3px;
    }

    .navbar-brand {
    padding-top: 10px;
    padding-bottom: 10px;
    }

    @media (max-width:767.98px) {
    .logo {
     max-height: 50px; 
}
.about.p-5 {
    padding: 1rem 0.5rem!important;
}

    }

    </style>

    @stack('css')

</head>

<body class="@yield('body_class')">

    <div id="page" class="page clearfix">
        <header class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand scroll" href="{{ url('/') }}">
                    @if(Storage::disk('public')->exists(Helpers::settings('dashboard_logo')))
                    <img src="{{ asset(Storage::url(Helpers::settings('dashboard_logo')))  }}" class="logo " />
					@else
					<img alt="Logo" src="{{ asset('assets/media/logo.png') }}" class="logo" />
                    @endif
                    </a>


                    <button class="navbar-toggler theme-bg" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="primary-menu">
                        <ul class="navbar-nav ml-auto" id="login_status">
                          
                     
                         @include('login_status')


                        </ul>

                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>


                    </div>
                </nav>
            </div>
        </header>



        @yield('content')

        <footer class="main-footer footer-style-two text-center">

        <div class="widgets-section p-60">
             <div class="container">
                 
                <div class="row clearfix">
                   <!--Footer Column-->
                   <div class="footer-column col-md-4 col-sm-6 col-xs-12">
                      <div class="footer-widget about-widget">
                         <div class="widget-content">
                            <div class="text mt-5">
                           
                            <img src="{{ url('fassets/images/fb.jpg') }}" />
                            
                        </div>
                              
                            <ul class="social-links">
                                  <li><a href="#"><span class="fa fa-facebook-f"></span></a></li>
                                  <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                  <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                                  <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
                                  <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                               </ul>

                             </div>
                         </div>
                     </div><!--End Footer Column-->
                     
                     <!--Footer Column-->
                     <div class="footer-column col-md-4 col-sm-6 col-xs-12">
                         <div class="footer-widget contact-widget">
                             <h3 class="bottom-line-center">Contact Us</h3>
                             <div class="widget-content">
                                 <ul class="contact-info">
                                     <li>Phone: +91 452-4356800 | Fax: +91 452-4356 810</li>
                                     <li><b>Email:</b> inspiration_reception@aravind.org</li>
                                     
                                     
                                 </ul>
                             </div>
                         </div>
                     </div><!--End Footer Column-->
                     
                     <!--Footer Column-->
                     <div class="footer-column col-md-4 col-sm-12 col-xs-12">
                         <div class="footer-widget  links-widget ">
                             <h3 class="bottom-line-center">Important Links</h3>
                             <div class="widget-content">

                             <ul class="list">
                                 <li><a href="{{ url('terms_and_conditions') }}">Terms and Conditions</a></li>
                                 <li><a href="{{ url('policy') }}">Policy</a></li>
                           
                             </ul>
                              
                           

                             </div>
                         </div>
                     </div><!--End Footer Column-->
                     
                 </div>
             </div>
         </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="copyright-text">
                        <div class="row">
                            <div class="col-md-12">
                                Copyright © 2019. All Rights Reserved By <a href="#">Laico</a>
                            </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </footer>



    </div>
    <script src="{{ url('fassets/js/plugins.js?ver=1') }}"></script>
    
    <script src="{{ url('fassets/js/functions.js?ver=1') }}"></script>

<script> 

toastr.options = {
"closeButton": true,
"newestOnTop": true,
"progressBar": true,
};

@if (session('message'))
toastr.success('{{ session('message') }}');
@endif

@if(session('status'))
toastr.success('{{ session('status') }}');
@endif


@if(session('errormsg'))
  toastr.error("{{ session('errormsg') }}");
  @endif
  



</script>

 @stack('js')

</body>

</html>