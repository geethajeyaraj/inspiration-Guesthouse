@extends('layouts.front')
@section('title')
<?php
?>
@endsection
@push('pre_css')
@endpush
@push('css')

<style>
.table td, .table th {
    padding: .75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}
.table th {
    text-align:center;
}
</style>


@endpush
@push('js')

@endpush
@section('body_class','')
@section('content')
<div class="header-style-1 text-center">
    <div class="overlay"></div>
    <h2>MY-RESERVATION STATUS</h2>
</div>
<section class="about p-5 bgGray">
    <div class="container">
 

             <div class="row clearfix" style="background:#fff;">
                <div class="col-md-12 p-5">

                <div class="table-responsive">
                   <table class="table table-bordered">
                      
                   <tr><th>Reservation ID</th>
                   <th>Date of Booking</th>
                   <th>Name</th>
                    <th>gender</th>
                    <th>Program Purpose</th>
                    <th>CheckIn</th>
                    <th>CheckOut</th>
                 
               
                   
                     <th>Status</th>
               
                </tr>

                   @foreach($reservations as $b )

<tr><td>#R{{ $b->id }}</td>
<td  class="text-center">{{ viewDate($b->created_at) }}</td>
 

<td  class="text-center">{{ $b->title }}. {{ $b->display_name }}</td>

<td  class="text-center">{{ $b->gender }}</td>

<td  class="text-center">{{ $b->program_purpose }}</td>
    
    <td>{{ viewDatewithTime($b->checkin_date) }}</td>
    <td>{{ viewDatewithTime($b->checkout_date) }}</td>

  



       
<td> @if( $b->status==0) 
   <span class="badge badge-info">Waiting</span>

   @elseif( $b->status==1) 
   <span class="badge badge-info">Confirmed</span>

   @elseif( $b->status==3) 
   <span class="badge badge-success">CheckIn</span>

   @elseif( $b->status==4) 
   <span class="badge badge-success">Check Out</span>

   @elseif( $b->status==5) 
   <span class="badge badge-danger">Cancelled</span>

   @endif 
</td>


</tr>
                   @endforeach 

                   @if(count($reservations)==0)

<tr><td colspan="10"  class="text-center">No Data</td></tr>
                   @endif 

                   </table>
                </div>


                {{ $reservations->links() }}

                   


                </div>
             </div>




    </div>
</section>






@stop