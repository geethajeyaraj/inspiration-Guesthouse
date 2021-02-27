@extends('layouts.page')
@section('title', 'Courses')
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
                           Assigned Courses
                        </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>S.No</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Grade</th>
                    <th>Section</th>
                    
                </tr>
                @foreach($courses as $key=>$c)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $c->code }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->grade}}</td>
                    <td>{{ $c->section}}</td>
                    
                </tr>
                @endforeach
            </table>
        </div>

    </div>
</div>


    </div>
    <!-- end:: Content -->
</div>


@stop


