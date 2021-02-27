<div class="modal-dialog @if(isset($modal_class)) {{ $modal_class }} @endif" role="document" id="ajax-container">

<div class="modal-content">

@if($collection->get('form_type')=="Create")
@if(isset($model_name)) {{ Form::model($model_name,['url' => $collection->get('url'),'id'=>'update_form', 'files' => true,'class'=>'form-vertical
validate_form', 'method' => 'post','autocomplete'=>'off']) }} 
@else {{ Form::open(['url' => $collection->get('url'),'id'=>'update_form', 'files' => true,'class'=>'form-vertical
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

<div class="modal-header">
            <h5 class="modal-title">{{ $collection->get('display_name') }}</h5>
            <button title="Close (Esc)" type="button" class="mfp-close" style="color:#bcbcbc">×</button>
        </div>
        <div class="modal-body">
                @include("form")
        </div>
        <div class="modal-footer">

                <button type="button" class="btn btn-clean pull-left ajax-close" >Close</button>
                @if($collection->get('form_type')=="Create") @if(Helpers::has_permission('add_'.$collection->get('form_name')))
                <button id="update_btn" type="submit"  class="btn btn-primary"><i class="la la-check"></i> @if($collection->get('button_name')!="") {{ $collection->get('button_name') }} @else Create @endif</button> @endif @else @if(Helpers::has_permission('edit_'.$collection->get('form_name')))
                <button id="update_btn" type="submit" class="btn btn-primary "><i class="fa fa-check"></i> @if($collection->get('button_name')!="") {{ $collection->get('button_name') }} @else Update @endif</button> @endif

                {{--@if($collection->get('include_delete')=="yes")
                @if(Helpers::has_permission('delete_'.$collection->get('form_name')))
                <button id="delete_btn" class="btn btn-danger ">x Delete</button>
                @endif
                @endif--}}

                @endif


        </div>


        {{ Form::close() }}

                </div>      </div>
<script>
    $(function () {


        $('.ajax-popup').magnificPopup({
    type: 'ajax',
    midClick: true,
	modal: true
    });



        $("#update_form").validate({
            ignore: []
        });


        $(".select2").select2();


            $(".date-picker").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: !0,
            orientation: "bottom left",
            autoclose: true
        });

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

            $("#update_btn").attr("disabled", true);
            $("#update_btn").toggleClass("s3-spinner");

            event.preventDefault();

            var frm = $('#update_form');

            var formData = new FormData($('#update_form')[0]);

            if (frm.valid())
                {
                $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData:false, // To send DOMDocument or non processed data file it is set to false

                success: function (response) {
                    $("#update_btn").toggleClass("s3-spinner");
                    $("#update_btn").attr("disabled", false);

                    if (response.status === true) {
                        toastr.success(response.notification);

                        if (response.hasOwnProperty('reload')) {
                            location.reload();
                        }

                        $.magnificPopup.close();


                        $('#s-table').DataTable().ajax.reload();
                    } else {

                      

                        toastr.error(response.notification);
                    }

                },
                error: function (data) {
                    $("#update_btn").toggleClass("s3-spinner");
                    $("#update_btn").attr("disabled", false);
                    toastr.error("Oops... Something went wrong!" + data);
                },
            });


                }else{
                    $("#update_btn").toggleClass("s3-spinner");
                    $("#update_btn").attr("disabled", false);
                }


        });






    });

</script>


@if(isset($custom_scripts))
@include($custom_scripts)
@endif
