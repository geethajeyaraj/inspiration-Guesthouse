@extends('layouts.front')
@section('title')
<?php
?>
@endsection
@push('pre_css')
@endpush
@push('css')
<style>
    .contact input.form-control,
    textarea.form-control {
        background: #ffffff;
        border: 0px solid lightGrey;
        border-bottom: 1px solid #b9b8b8;
        margin-top: 20px;
    }

    .contact input.submit-btn {
        background: #8e2927 !important;
        padding: 10px;
        height: auto;
        color: #fff;
    }

    .contact label.error {
        color: red;
    }
</style>
@endpush
@push('js')

@endpush
@section('body_class','')
@section('content')

<div class="header-style-1 text-center" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <h2>Success</h2>
</div>
<section class="contact p-md-5 p-3 bgGray">
<div class="container text-center" style="background: #fff;padding: 30px;font-size:14px;line-height:28px;">
        We received your enquiry. we will update your query shortly
</div>
</section>

@stop