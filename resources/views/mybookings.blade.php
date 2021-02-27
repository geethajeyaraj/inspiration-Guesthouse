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
    <h2>MY-BOOKING STATUS</h2>
</div>
<section class="about p-5 bgGray">
    <div class="container">
 

             <div class="row clearfix" style="background:#fff;">
                <div class="col-md-12 p-5">

                <div class="table-responsive">
                   <table class="table table-bordered">
                      
                   <tr><th>Booking ID</th>
                    <th>CheckIn</th>
                    <th>CheckOut</th>
              
                
                    <th>Total Bill Amount</th>
                    <th>Paid</th>
                    <th>Balance to be Paid</th>
                    <th>Pay now</th>
                   
                
            
                    <th>Details</th>

                    <th>Invoice</th>
                </tr>

                   @foreach($reservations as $b )

<tr><td>#B{{ $b->id }}</td>
    
    <td>{{ viewDatewithTime($b->checkin_date) }}</td>
    <td>{{ viewDatewithTime($b->checkout_date) }}</td>



    <td>{{ $b->total_amount }}</td>
    <td>{{ $b->paid }}</td>
    <td>{{ $b->balance_to_be_paid }}</td>
                    


    <td  class="text-center">@if($b->balance_to_be_paid>0)    
        
    @if(Helpers::no_of_days($b->checkin_date,$b->checkout_date)<31)
    
    <a href="{{ url(route('paynow',$b->id)) }}?amount={{ $b->balance_to_be_paid }}" class="btn btn-danger btn-sm">Pay Now</a>
   @else
    <a href="{{ url(route('partialamount',$b->id)) }}?amount={{ $b->balance_to_be_paid }}" class="ajax-popup btn btn-danger btn-sm">Pay Now</a>
@endif 


    @endif     
    </td>

    


<td  class="text-center"><a href="{{ url(route('view_receipt',$b->reservation_id)) }}" class="btn btn-primary btn-sm  ajax-popup">View Details</a></td>

<td  class="text-center"><a target="_blank" href="{{ url(route('view_invoice',[$b->id, md5('laicokey'.$b->id)] )) }}" class="btn btn-warning btn-sm ">View Invoice</a></td>



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