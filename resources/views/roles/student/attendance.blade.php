@extends('layouts.page')
@section('title', 'Attendance')
@push('pre_css')

@endpush
@push('css')
<style>
    #s-table tr td,#s-table tr th{ font-size: 12px;}

    </style>
@endpush
@push('js')
<script>
</script>
@endpush
@section('body_class','')
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                           Attendance Details
                            </h3>
                        </div>
                        
                    </div>
                    <div class="kt-portlet__body">

       
                        <div class="table-responsive">
                            <table id="s-table" class="table table-striped- table-bordered table-hover m-0">
                            <thead class="thead-dark">
                            <tr>
                                <th rowspan=2 style="font-size:10px;vertical-align:middle;">Months</th>
                                <th colspan="{{ $days_in_month }}" style="font-size:10px"> Date  @include('icons.arrow_right')</th>
                            </tr><tr>
                                @for($i=1;$i<=$days_in_month;$i++)
                                <th>{{ $i }}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                                @php($inc=1)
                                @foreach($data as $key=>$value)
                                 <tr>
                    
                                 <td>{{  $key }}</td>
                    
                                 @for($i=1;$i<=$days_in_month;$i++)
                                 @if(isset($data[$key][$i]))
                                    <td> @if($data[$key][$i]=="A") <span class="kt-badge kt-badge--danger">{{ $data[$key][$i] }}</span> @else <span class="kt-badge kt-badge--success">{{ $data[$key][$i] }}</span> @endif</td>
                                    @else
                                    <td></td>
                                    @endif
                                 @endfor
                    
                                 </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



    </div>
</div>


    </div>
    <!-- end:: Content -->
</div>


@stop


