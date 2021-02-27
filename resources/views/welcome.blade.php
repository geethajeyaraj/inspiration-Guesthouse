@extends('layouts.page')
@section('title', 'Dashboard')
@push('pre_css')

@endpush
@push('css')


@endpush
@push('js')


@endpush
@section('body_class','')
@section('content')


<div class="container-fluid p-4">
        <div class="s3-content" id="s3_content">
                Welcome {{ auth()->user()->display_name }},
                <div class="row row-no-padding">
                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('today_checkin_checkout','checkin') }}">
                                        <div class="topwidget" style="background:#dc3545;">
                                                @include('icons.users')
                                                <p class="text-center m-0 mt-3">Today CheckIn</p>
                                        </div>
                                </a>

                        </div>

                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('today_checkin_checkout','checkout')  }}">
                                        <div class="topwidget" style="background:#28a745;">
                                                @include('icons.users')

                                                <p class="text-center m-0 mt-3">Today Checkout</p>
                                        </div>
                                </a>
                        </div>

                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('reservation_control.index') }}">
                                        <div class="topwidget" style="background:#fd7e14;">
                                                @include('icons.cart')

                                                <p class="text-center m-0 mt-3">Reservation</p>
                                        </div>
                                </a>

                        </div>

                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('settings') }}">
                                        <div class="topwidget" style="background:#17a2b8;">
                                                @include('icons.settings')
                                                <p class="text-center m-0 mt-3">Settings</p>
                                        </div>
                                </a>
                        </div>

                        @if(session('role')==1)

                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('master_room_types.index') }}">
                                        <div class="topwidget" style="background:#e83e8c;">
                                                @include('icons.room_types')
                                                <p class="text-center m-0 mt-3">Room Types</p>
                                        </div>
                                </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('master_room_tariff.index') }}">
                                        <div class="topwidget" style="background:#6f42c1;">
                                                @include('icons.room_tariff')
                                                <p class="text-center m-0 mt-3">Room Tariff Plan</p>
                                        </div>
                                </a>
                        </div>

                        @else
                        <div class="col-6 col-sm-4 col-md-2 p-2">
                                <a href="{{ route('today_checkin_checkout','occupied') }}">
                                        <div class="topwidget" style="background:#e83e8c;">
                                                @include('icons.room_types')
                                                <p class="text-center m-0 mt-3">Today Occupied</p>
                                        </div>
                                </a>
                        </div>

                        @endif

                </div>
                <div class="row ">
                        <div class="col-6 p-2">
                                <h3 class="text-center">Amount Collected</h3>
                        </div>
                        <div class="col-6 p-2">
                                <h3 class="text-center">Pending payments</h3>
                                <div class="table-responsive">
                                        <table class="table">
                                                <tr>
                                                        <th>Room Number</th>
                                                        <th>Guest Name</th>
                                                        <th>Payment due</th>
                                                </tr>
                                        </table>
                                </div>
                        </div>
                </div>
        </div>
</div>

@stop