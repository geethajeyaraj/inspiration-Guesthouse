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

        
    <div class="s3-portlet">
								<div class="s3-portlet-head">
									<div class="s3-portlet-head-label">
										<h3 class="s3-portlet-head-title">
                                        Depend on Room Type Report
                    </h3>
                </div>
              
            </div>
            <div class="s3-portlet-body">
              

            <table width="100%" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <th>Room type</th><th>Vacant</th><th>Occupied</th>
            </tr>
        
                @foreach($room_types as $key=>$r)
                <tr style="background:{{ $room_types[$key]['color_code'] }}">
                <td >{{ $key }}</td>
                <td>{{ $room_types[$key]['vacant'] }}</td>
                <td>{{ $room_types[$key]['occupied'] }}</td>
                </tr>

                @endforeach 
        </table> <br><br>
    

        <table width="100%" border="1" cellspacing="0" cellpadding="6">
            <tr>
                <th>Room No</th>
                <th>Guest Name</th>
                <th>Room No</th>
                <th>Guest Name</th>
                <th>Room No</th>
                <th>Guest Name</th>
        

            @php($inc=0)
            @foreach($report as $r)

            @if($inc%3==0)
</tr><tr>
@endif 


<td style="background:{{ $r->color_code }}" >
@if($r->id!="")
<a href="{{ url(route('view_invoice',[$r->id, md5('laicokey'.$r->id)] )) }}" target="_blank">{{ $r->room_no }}</a>
@else
{{ $r->room_no }}
@endif 
</td>
<td  style="background:{{ $r->color_code }}" >{{ $r->display_name }}</td>


@php($inc++)

    @endforeach 

</tr>

        </table>


</div>
</div>




        





        </div>
</div>






@stop


