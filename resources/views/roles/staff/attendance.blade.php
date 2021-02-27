@extends('layouts.page')
@section('title', 'Attendance')
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
                           Attendance Details
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
                    <th>Staff Name</th>
                </tr>
                
            </table>
        </div>

    </div>
</div>
</div>
<!-- end:: Content -->
</div>
@stop


