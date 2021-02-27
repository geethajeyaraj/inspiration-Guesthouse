@extends('layouts.page')
@section('title', 'Home Works')
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
      
    @php($hdate="")
    @php($hcount=0)
    

        @foreach($home_works as $key=>$h)

        @if($hdate!=viewDate($h->date_of_homework))
        @php($hcount++)
        @if($hcount>2)
            @break
        @endif
        
        @if($key!=0)
    </table>
        </div>
        </div>
       @endif
        <div class="kt-portlet kt-portlet--head-sm @if($key!=0) kt-portlet--collapsed @endif" data-ktportlet="true" id="homeworks-{{ $key }}">
                    <div class="kt-portlet__head ">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Home Work - {{ viewDate($h->date_of_homework) }}
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-group">
                                <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-angle-down"></i></a>
                                <a href="#" data-ktportlet-tool="remove" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-close"></i></a>
                            </div>
                        </div>
                    </div>

                        <div class="kt-portlet__body">
    
                                <table class="table table-bordered table-hover table-striped">
                                    <tr><th>Course</th><th>Home Work Details</th><th>Attachment</th></tr>
                            @endif 
               
                                <tr><th>{{ $h->name }}</th><td>{{ $h->description }}</td><td>
                                    
                                        @if($h->attachment_location!="")
                                        <a class="btn btn-success btn-sm" target="_blank" href="{{ route("download") }}/?file_location={{ $h->attachment_location }}"><i class="la la-cloud-download"></i></a>
                                        @else
                                       -
                                    @endif
                                    </td></tr>

               {{--
               
               <div class="accordion accordion-light  accordion-toggle-arrow" id="accordion{{ $key }}">
                   
                    <div class="card">
                        <div class="card-header" id="heading{{ $key }}">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                                {{ $h->name }}
                            </div>
                        </div>
                        <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-parent="#accordion{{ $key }}" style="">
                            <div class="card-body">
                                    {{ $h->description }}
                            </div>
                        </div>
                    </div>
                    
                   
                </div>

--}}
                            
                 @php($hdate=viewDate($h->date_of_homework))
              
                
        @endforeach

    </table>
    
    </div>
</div>


</div>
<!-- end:: Content -->
</div>
@stop


