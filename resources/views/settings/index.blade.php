@extends('layouts.page')
@section('title', 'Dashboard - SIS')
@push('pre_css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}} " />
<style>
.fileinput { display: block; }
</style>
@endpush
@push('js')
<script src="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush
@section('content')
<div class="container-fluid p-5">
    <!-- begin:: Content -->
  
    @if(Session::has('success'))
        <div class="alert alert-success fade show" role="alert">
            <div class="alert-text">{{ Session::get('success','') }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                    </button>
            </div>
        </div>
        @endif
        <!--begin::Form-->
        {!! Form::model($settings, ['route' => ['update_settings'],'enctype'=>'multipart/form-data', 'method' => 'post','id'=>'update_form', 'class' => 's3-form validate_form'])
        !!}


<div class="row">
        <div class="col-md-12 col-sm-12">

        <div class="s3-portlet">
                                        <div class="s3-portlet-head">
                                            <div class="s3-portlet-head-label">

                                                <h3 class="s3-portlet-head-title">
                                                     General Settings
                                                </h3>
                                            </div>
                                            <div class="s3-portlet-head-toolbar">
                                                <div class="s3-portlet-head-wrapper">
                                                    <div class="s3-portlet-head-actions">
                                                            @if(Helpers::has_permission('edit_settings'))
                                                                        <button class="btn btn-primary"><i class="fa fa-check"></i> Submit Settings</button>
                                                                        @endif
                                                     </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>




        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="s3-portlet">
                    <div class="s3-portlet-head">
                        <div class="s3-portlet-head-label">
                            <h3 class="s3-portlet-head-title">
                                Site Settings
                            </h3>
                        </div>
                    </div>
                    <div class="s3-portlet-body">
                        <div class="form-group">
                            <label for="site_full_name">School Name</label> {!! Form::input('text', 'site_full_name',null,
                            ['class' => 'form-control required', 'placeholder' => 'Site Full name']) !!} @if ($errors->has('site_full_name'))
                            <span class="help-block help-block-error">{{ $errors->first('site_full_name') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label for="site_short_name">School Short Name</label> {!! Form::input('text', 'site_short_name',null,
                            ['class' => 'form-control required', 'placeholder' => 'Site Full name']) !!} @if ($errors->has('site_short_name'))
                            <span class="help-block help-block-error">{{ $errors->first('site_short_name') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label for="">Email Id</label> {!! Form::input('text', 'email_id',null, ['class' => 'form-control
                            required email', 'placeholder' => 'Email id']) !!} @if ($errors->has('email_id'))
                            <span
                                class="help-block help-block-error">{{ $errors->first('email_id') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label for="">Phone number</label> {!! Form::input('text', 'phone',null, ['class' =>
                            'form-control required', 'placeholder' => 'Phone no']) !!} @if ($errors->has('phone'))
                            <span class="help-block help-block-error">{{ $errors->first('phone') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label for="">Website Name</label> {!! Form::input('text', 'website',null, ['class' => 'form-control
                            required', 'placeholder' => 'Website']) !!} @if ($errors->has('website'))
                            <span
                                class="help-block help-block-error">{{ $errors->first('website') }}</span> @endif
                        </div>

                        <div class="form-group">
                            <label for="">Street Name</label> {!! Form::input('text', 'street',null, ['class' =>
                            'form-control required', 'placeholder' => 'Street Name']) !!} 
                            @if ($errors->has('street'))
                            <span class="help-block help-block-error">{{ $errors->first('street') }}</span> @endif
                        </div>
                        <div class="form-group">
                            <label for="">City</label> {!! Form::input('text', 'city',null, ['class' => 'form-control
                            required', 'placeholder' => 'City name']) !!} @if ($errors->has('city')) <span class="help-block help-block-error">{{ $errors->first('city') }}</span>                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">State</label> {!! Form::input('text', 'state',null, ['class' => 'form-control
                            required', 'placeholder' => 'State Name']) !!} @if ($errors->has('state')) <span class="help-block help-block-error">{{ $errors->first('state') }}</span>                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Country</label> {!! Form::input('text', 'country',null, ['class' => 'form-control
                            required', 'placeholder' => 'Country']) !!} @if ($errors->has('country')) <span class="help-block help-block-error">{{ $errors->first('country') }}</span>                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Pincode</label> {!! Form::input('text', 'pincode',null, ['class' => 'form-control
                            required', 'placeholder' => 'Pincode']) !!} @if ($errors->has('pincode')) <span class="help-block help-block-error">{{ $errors->first('pincode') }}</span>                            @endif
                        </div>


                    </div>

                </div>
            </div>
            <!-- end:: Content -->
            <div class="col-md-6 col-sm-12">

            <div class="s3-portlet">
                    <div class="s3-portlet-head">
                        <div class="s3-portlet-head-label">
                            <h3 class="s3-portlet-head-title">
                              Login Logo
                            </h3>
                        </div>
                    </div>
                    <div class="s3-portlet-body">
                        <div class="form-group">

                                <div class="fileinput fileinput-new  text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: auto;">
                                           @if(isset($settings->login_logo))
                                            @if(Storage::disk('public')->exists($settings->login_logo))
                                            <img src="{{ asset(Storage::url($settings->login_logo)) }}" style="max-width:150px;max-height:150px;" class="mw-100" alt="Logo">
                                            @else
                                            <img src="{{  asset('assets/media/logo.png') }}" class="mw-100" alt="Logo Image">
                                            @endif
                                            @else
                                            <img src="{{  asset('assets/media/logo.png') }}" class="mw-100" alt="Logo Image">
                                           @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:150px; max-height:150px;">
                                        </div>
                                        <div>
                                            <span class="btn btn-sm btn-primary btn-file">
                                                <span class="fileinput-new">
                                                    Select image </span>
                                                <span class="fileinput-exists">
                                                    Change </span>
                                                <input type="file" id="login_logo" name="login_logo">
                                            </span>
                                            <a href="#" class="btn btn-sm  btn-danger fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>


                        </div>
                    </div>
                </div>


                <div class="s3-portlet">
                    <div class="s3-portlet-head">
                        <div class="s3-portlet-head-label">
                            <h3 class="s3-portlet-head-title">
                              Dashboard Logo
                            </h3>
                        </div>
                    </div>
                    <div class="s3-portlet-body">
                        <div class="form-group">

                                <div class="fileinput fileinput-new  text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: auto;">
                                           @if(isset($settings->dashboard_logo))
                                           @if(Storage::disk('public')->exists($settings->dashboard_logo))
                                          <img src="{{ asset(Storage::url($settings->dashboard_logo)) }}" style="max-width:150px;max-height:150px;" class="" alt="Logo">
                                            @else
                                            <img src="{{  asset('assets/media/logo.png') }}" class="mw-100" alt="Logo Image">
                                            @endif
                                            @else
                                            <img src="{{  asset('assets/media/logo.png') }}" class="mw-100" alt="Logo Image">
                                           @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:150px; max-height:150px;">
                                        </div>
                                        <div>
                                            <span class="btn btn-sm btn-primary btn-file">
                                                <span class="fileinput-new">
                                                    Select image </span>
                                                <span class="fileinput-exists">
                                                    Change </span>
                                                <input type="file" id="dashboard_logo" name="dashboard_logo">
                                            </span>
                                            <a href="#" class="btn btn-sm  btn-danger fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>


                        </div>
                    </div>
                </div>
                <div class="s3-portlet">
                        <div class="s3-portlet-head">
                            <div class="s3-portlet-head-label">
                                <h3 class="s3-portlet-head-title">
                                   Update Favicon
                                </h3>
                            </div>
                        </div>
                        <div class="s3-portlet-body">
                            <div class="form-group">


                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 150px; height: auto;">
                                               @if(isset($settings->favicon))

                                               @if(Storage::disk('public')->exists($settings->favicon))
                                       
                                                <img src="{{ asset(Storage::url($settings->favicon)) }}" style="max-width:150px;max-height:150px;" class="" alt="Logo" />

                                                @else
                                                <img src="{{  asset('assets/media/logo.png') }}" class="mw-100" alt="Logo Image" />
                                                @endif
                                                @else
                                                <img src="{{  asset('assets/media/logo.png') }}" class="mw-100" alt="Logo Image" />
                                               @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:150px; max-height:150px;">
                                            </div>
                                            <div>
                                                <span class="btn btn-sm btn-primary btn-file">
                                                    <span class="fileinput-new">
                                                        Select image </span>
                                                    <span class="fileinput-exists">
                                                        Change </span>
                                                    <input type="file" id="favicon" name="favicon">
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
        {{ Form::close() }}
        <!--end::Form-->
   
</div>
@stop
