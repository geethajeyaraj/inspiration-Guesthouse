@extends('layouts.page')
@section('title', 'Permission')
@section('body_class','')
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ $title }}
                        </h3>
                    </div>
              
                </div>
                <div class="kt-portlet__body">
                      {{ $msg }}
                </div>
    </div>
</div>
</div>
@stop


