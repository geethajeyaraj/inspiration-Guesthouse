<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
	<title>@yield('title', config('sis.title', 'Dashboard'))</title>
	<meta name="description" content="@yield('description', config('sis.description', ''))">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	@if(Storage::disk('public')->exists(Helpers::settings('favicon')))
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset(Storage::url(Helpers::settings('favicon'))) }}" />
	@else
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/logo/favicon.png') }}" />
	@endif



    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!--begin::Fonts -->
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
   
	@yield('section_pre_css')
    <!--begin:: Global Mandatory Vendors -->
	<link href="{{ url('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/fonts/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/theme/App.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

<style>

</style>
@yield('section_post_css')
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed    @yield('body_class')">


@yield('body')


@yield('section_js')
</body>
</html>