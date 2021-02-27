@extends('layouts.page')
@section('title', $collection->get('display_name').' - KARE') 
@push('pre_css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}} " />
<style>
    .form-control-feedback {
        color: red;
    }
    .fileinput {
        display: block;
    }
</style>

@endpush 
@push('js')

@if($collection->get('custom_scripts')!="")
@include("custom.question")
@endif 

<script src="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script>
    $(function () {

        
    $("#update_form").validate({
        ignore: [],
        invalidHandler: function(event, validator) {
      
        $('html, body').animate({
                    scrollTop: 0
                }, 1000, "easeInOutExpo");
      
            },
    });


    $(".select2").select2();
    $(".date-picker").datepicker({format: 'dd/mm/yyyy',todayHighlight:!0 ,orientation:"bottom left",autoclose:true});

    $(".time-picker").timepicker();


    $(".date-time-picker").datetimepicker({format:"dd/mm/yyyy HH:ii P",todayHighlight:!0,autoclose:true,pickerPosition:"bottom-right"});



    @foreach($rows as $row)
    @foreach($row as $r)
    @if(isset($r['url']))
    $('#{{$r['id']}}').select2({
        placeholder: "{{ $r['placeholder'] }}",
        minimumInputLength: 2,
        ajax: {
            url: '{{ url($r['url']) }}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    @endif
    @endforeach
    @endforeach


    $("#delete_btn").click(function (event) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure want to delete?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',


        }).then((result) => {
            if (result.value) {
                $('#delete_form').submit();
            } else {
                Swal.fire("Cancelled", "", "error");
            }
        });
    });


    $("#update_btn").click(function (event) {
        event.preventDefault();
        $("#update_form").submit();
    });

});

</script>

@endpush


@section('content')


<div class="container-fluid p-4">

    @if($collection->get('form_type')=="Create")
     @if(isset($model_name)) 
     {{ Form::model($model_name,['url' => $collection->get('url'),'id'=>'update_form','enctype'=>'multipart/form-data','class'=>'form-vertical
    validate_form', 'method' => 'post','autocomplete'=>'off']) }} 
    @else 
    {{ Form::open(['url' => $collection->get('url'),'id'=>'update_form','enctype'=>'multipart/form-data','class'=>'form-vertical
    validate_form', 'method' => 'post','autocomplete'=>'off']) }} 
    @endif 
    @else 
    
    @if($collection->get('include_delete')=="yes")

    @if($collection->get('delete_url')!="")
          {!! Form::open(['method' => 'DELETE','id'=>'delete_form', 'url' => $collection->get('delete_url')  ])
       !!} 
    @else 
    {!! Form::open(['method' => 'DELETE','id'=>'delete_form', 'route' => [$collection->get('url').'.destroy', $model_name->id]])
    !!} 
    @endif 

    {{ Form::close() }}


    @endif 


    @if($collection->get('update_url')!="")
     {!! Form::model($model_name, ['url' => $collection->get('update_url') ,'enctype'=>'multipart/form-data', 'method' =>'put','id'=>'update_form', 'class' => 'form-horizontal validate_form','autocomplete'=>'off']) !!} 

    @else 
    {!! Form::model($model_name, ['route' => [$collection->get('url').'.update', $model_name->id],'enctype'=>'multipart/form-data',
    'method' =>'put','id'=>'update_form', 'class' => 'form-horizontal validate_form','autocomplete'=>'off']) !!} 
  
    @endif 

    @endif

    <div class="container-fluid p-4">

    <div class="s3-content" id="s3_content">

    <div class="s3-portlet">
								<div class="s3-portlet-head">
									<div class="s3-portlet-head-label">
										<h3 class="s3-portlet-head-title">
                        {{ $collection->get('form_type') }} {{ $collection->get('display_name') }}
                    </h3>
                </div>
                <div class="s3-portlet-head-toolbar">
										<div class="s3-portlet-head-wrapper">
                                            <div class="s3-portlet-head-actions">


                            <button onclick="window.history.go(-1); return false;" type="button" name="back" class="btn btn-clean btn-icon-sm"><i class="la la-long-arrow-left"></i> Back</button>                      
                            
                            
                            @if($collection->get('form_type')=="Create") @if(Helpers::has_permission('add_'.$collection->get('form_name')))
                            <button class="btn btn-primary"><i class="la la-check"></i> Create</button> @endif @else @if(Helpers::has_permission('edit_'.$collection->get('form_name')))
                            <button id="update_btn" class="btn btn-primary"><i class="fa fa-check"></i> Update</button> @endif
                            @if($collection->get('include_delete')=="yes") @if(Helpers::has_permission('delete_'.$collection->get('form_name')))
                            <button id="delete_btn" class="btn btn-danger ">x Delete</button> @endif @endif @endif


                            </ul>



                        </div>
                    </div>
                </div>
            </div>
            <div class="s3-portlet-body">
                @if ($errors->any())
                <div class="alert alert-outline-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <ul style="margin: 0px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @include("form")
            </div>
        </div>
    </div>

    {{ Form::close() }}

</div>

</div>

@endsection
