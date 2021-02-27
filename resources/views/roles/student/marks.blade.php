@extends('layouts.page')
@section('title', 'Marks')
@push('pre_css')

@endpush
@push('css')

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
                                Mark Details
                            </h3>
                        </div>                       
                    </div>
            <div class="kt-portlet__body">


                    <div class="table-responsive">
                            <table id="s-table" class="table table-striped- table-bordered table-hover m-0">
                            <thead class="thead-dark">
                            <tr>
                                <th> <i class="la la-arrow-down"></i> Exam  | Code <i class="la la-arrow-right"></i> </th>
                                @foreach($courses as $c)        
                                <th>{{ $c->code }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                                @php($inc=1)

                                @foreach($exams as $e)
                                <tr><td>{{ $e->name }}</td>
                      
                               
                                        @foreach($courses as $c)
                                        @if(isset($data[$e->id][$c->id]))
                                            <td>{{ $data[$e->id][$c->id] }}</td>
                                            @else
                                            <td></td>
                                            @endif
                                       
                          
                                @endforeach
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


