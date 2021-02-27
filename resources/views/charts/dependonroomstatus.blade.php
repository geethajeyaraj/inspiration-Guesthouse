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
                                        Depend on Room Status Report
                    </h3>
                </div>
              
            </div>
            <div class="s3-portlet-body">
              

            <table width="100%" border="1" cellspacing="0" cellpadding="10" style="text-align:center;">
          
            <tr>
                <th style="width:20%;background:#87dde8;"><b>Vacant</b></th>
                <th style="width:20%;background:#e3ec82;"><b>Occupied</b></th>
</tr><tr>
                <th style="width:20%;background:#87dde8;">{{ $vacant }}</th>
    
                <th style="width:20%;background:#e3ec82;">{{ $occupied }}</th>
            </tr>
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


<td @if($r->display_name=="") style="background:#87dde8" @else style="background:#e3ec82" @endif  >
   
@if($r->id!="")
<a href="{{ url(route('view_invoice',[$r->id, md5('laicokey'.$r->id)] )) }}" target="_blank">{{ $r->room_no }}</a>
@else
{{ $r->room_no }}
@endif 



</td>
<td  @if($r->display_name=="") style="background:#87dde8" @else style="background:#e3ec82" @endif >{{ $r->display_name }}</td>


@php($inc++)

    @endforeach 

</tr>

        </table>


</div>
</div>




        





        </div>
</div>






@stop


