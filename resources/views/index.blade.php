@extends('layouts.page')
@section('title', $title)
@push('pre_css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}} " />
<link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
select { height: calc(2.95rem + 2px) !important; }
tfoot { display: table-header-group; }
.select2-container {
    min-width: 120px;
}
.form-control-feedback {
        color: red;
    }
    .fileinput {
        display: block;
    }
.dt-button-collection.dropdown-menu
{
    max-height: 250px;overflow-y: scroll; 
}    
</style>
@endpush
@push('js')


<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>


@if(isset($delete_url))
<script>
    $.fn.dataTable.ext.errMode = 'throw';

function deletefun(id)
{
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
            var url = '{{ $delete_url }}';
            url = url.replace('delete_id', id);

            $.ajax({
                type : 'DELETE',
                url: url,
                data: {"_token": "{{ csrf_token() }}"},
                success : function(response) {
                    if(response.status === true){
                        toastr.success(response.notification);
                         $('#s-table').DataTable().ajax.reload();
                    }
                    else{
                        toastr.error("Oops... Something went wrong!");
                     }
                    }
            });
            } else {
                toastr.error("Action Cancelled!");
            }
        });



}


</script>
@endif

<script>
    $(function () {


        $( document ).ajaxComplete(function() {
        //    $('.ajax-popup').magnificPopup({type: 'ajax', midClick: true,modal: true  });
        });



        $(".select2").select2();

        $(".date-picker").datepicker({format: 'dd/mm/yyyy',todayHighlight:!0 ,orientation:"bottom left",autoclose:true});

        $('.time-picker').timepicker({
            minuteStep: 5,
        });


        $('#s-table tfoot th').each( function () {
        var title = $(this).text();
        if($(this).attr('search')==1)
        $(this).html( '<input type="text" class="form-control filter" placeholder="'+title+'" />' );
        else if($(this).attr('search')==0)
        $(this).html('');
        });


        var table =  $('#s-table').DataTable({


		columnDefs: [
            { targets: [@if(isset($hide_columns))  {{ $hide_columns }} @endif ], visible: false },
        ],
	    buttons: [     {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible'
                }
            },  {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible'
                }
            },  {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            }, 'colvis' ],
      

     @if(isset($order_id))
     "order": [[ {{ $order_id }} , "{{ $order_status }}"  ]] ,
     @endif 
      

      "processing": true,


      @if(isset($responsive))
      "responsive": {{ $responsive }},
      @endif 


        @if(!isset($serverside))
        "serverSide": true,
        @else
        "serverSide":{{ $serverside }},
        @endif

        "drawCallback": function( settings ) {
            $('.ajax-popup').magnificPopup({type: 'ajax', midClick: true,modal: true ,  });
        },

        ajax: {
                 url: "{{  url($data_url) }}",
                 'type': '{{  $post_type }}',
                 data: function (d) {
                    @foreach($fields as $f)
                    @if(isset($f['is_date']) || isset($f['is_custom_search']) )
                     d.{{ $f['id'] }} = $('#{{ $f['id'] }}').val();
                    @endif
                    @endforeach



                    
	              }
        },

    		"lengthMenu": [
                    [5,10,20, 30, 50, 100, -1],
                    [5,10,20, 30, 50, 100, "All"]
            ],
            "pageLength": 5,
            columns: [

                 @foreach($fields as $f)

                 {data: '{{ $f['id'] }}',name: '{{ $f['name'] }}'
                   @if(isset($f['orderable']))
                   ,orderable: {{ $f['orderable'] }}
                   @endif
                   @if(isset($f['searchable']))
                   ,searchable: {{ $f['searchable'] }}
                   @endif
                    @if(isset($f['condition']))
                    ,render: function (data, type, row, meta) {
                    @php($inc=0)
                    @foreach($f['condition'] as $c)
                        @if($inc==0)
                        if ( {{ $c['field_name'] }} ==  {!! $c['field_name_equal'] !!}) {
                            return "{!! $c['display_name'] !!}";
                        }
                        @else
                        else if({{ $c['field_name'] }} == {!! $c['field_name_equal'] !!}) {
                            return "{!! $c['display_name'] !!}";
                        }
                        @endif
                    @endforeach
                    else{
                        return '';
                      }
                    }
                 @endif
                 },
                 @endforeach
            ],
			"sDom": '<"row"<"col-sm-6"B><"col-sm-6"f>><"clear">rt<"row"<"col-sm-5"li><"col-sm-7"p>>',
        });

         table.columns().every( function () {
         var that = this;
         $( '.filter', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
          });
        });


        table.search('').columns().search('').draw();


@if(isset($approval_column))

$('#select-all').click(function(event) {

   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;
        });
    }
});


 $('body').on("click", ".checkids", function () {
    var n = $('input:checkbox:checked').length;
    $("#m_datatable_selected_number").html(n);
        if (n > 0) {
        $("#m_datatable_group_action_form_1").collapse("show");
        } else {
        $("#m_datatable_group_action_form_1").collapse("hide");
        }
   });

 $("#approve-form").submit(function (event) {
    $("#submitreason").attr("disabled", true);
            $("#submitreason").toggleClass("kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light");

            event.preventDefault();

            var frm = $('#approve-form');

var formData = new FormData($('#approve-form')[0]);

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
        $("#submitreason").toggleClass("kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light");
        $("#submitreason").attr("disabled", false);

        if (response.status === true) {
            toastr.success(response.notification);
            $("#m_datatable_group_action_form_1").collapse("hide");
            $("#select-all"). prop("checked", false);
         
            $('#s-table').DataTable().ajax.reload();
        } else {

            toastr.error(response.notification);
        }

    },
    error: function (data) {
        $("#submitreason").toggleClass("kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light");
        $("#submitreason").attr("disabled", false);
        toastr.error("Oops... Something went wrong!" + data);
    },
});


    }else{
        $("#submitreason").toggleClass("kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light");
        $("#submitreason").attr("disabled", false);
    }



        });

@endif

$( '.is_custom_search').on( 'keyup change', function () {
    $('#s-table').DataTable().ajax.reload();
});


});
</script>
@endpush
@section('content')

<div class="container-fluid p-4">

<form id="approve-form"  action="{{ isset($approval_url) ? $approval_url : '' }}" method="post" class="form-horizontal" autocomplete="off">
        {{ csrf_field() }}
<div class="s3-content" id="s3_content">
<div class="s3-portlet">
								<div class="s3-portlet-head">
									<div class="s3-portlet-head-label">
										<h3 class="s3-portlet-head-title">
										{!! $title !!}
										</h3>
									</div>
									<div class="s3-portlet-head-toolbar">
										<div class="s3-portlet-head-wrapper">
                                            <div class="s3-portlet-head-actions">

                                                <button onclick="window.history.go(-1); return false;" type="button" name="back" class="btn btn-clean btn-icon-sm"><i class="la la-long-arrow-left"></i> Back</button>
                                                @if(isset($permission))
                                                @if(Helpers::has_permission('add_'.$permission))
                                                <a  href="{{ url($create_url) }}" class="btn btn-brand btn-elevate btn-icon-sm @if(isset($is_ajax_create)) ajax-popup @endif">
                                                <i class="la la-plus"></i> New Record</a>
                                                @endif
                                                @endif
											</div>
										</div>
									</div>
								</div>
                                <div class="s3-portlet-body">


                                @if(isset($approval_column))

                                @if(isset($approval_blade))

                                @include($approval_blade)

                                @else
                              
 <div style="background: #f4f4f4;padding: 10px 10px;" class="kt-form kt-form--label-align-right mt-3 mb-3 collapse hide" id="m_datatable_group_action_form_1" style="">
                <div class="row align-items-center">
                    <div class="col-xl-12">
                        <div class="s3-form-group">
                            <div class="s3-form-label">
                                <label class="">Selected
                                    <span id="m_datatable_selected_number">0</span> record(s):</label>
                            </div>
                            <div class="s3-form-control">
                                <div class="btn-toolbar">
        <div class="row" style="width:100%;">
          
        
           <div class="@if(isset($approval_reason)) col-md-4  @else col-md-6 @endif">
             <select name="approve_status" id="approve_status" class="form-control select2 required" aria-placeholder="Select Status">
                <option value="">Select Status</option>
                @foreach($approval_conditions as $key=>$value)
                <option value="{{ $key }}">{{ $value }}</option>
                 @endforeach
               </select>
            </div>
            @if(isset($approval_reason))
            <div class="col-md-4">
               <input type="text" placeholder="Reason..." name="approval_reason" id="approve_reason" class="form-control" />
            </div>
            @endif

            <div class="@if(isset($approval_reason)) col-md-4  @else col-md-6 @endif">


            <button type="submit" id="submitreason"  name="submitreason" class="btn btn-primary" style="width:100%;">Submit</button>
                        </div>
                        </div>
                        </div>
              </div>
                </div>
            </div>
            </div>
        </div>

        @endif
@endif


<div id="s3_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
<div class="row">
<div class="col-sm-12">
<div class="table-responsive">
<table id="s-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" >
<thead>
<tr>
        @foreach($fields as $f)
        <th>{{ $f['display_name'] }}</th>
        @endforeach
</tr>
</thead>
<tfoot>
<tr>
@foreach($fields as $f)

@if($f['id']=="select")
<th search="2">  <label class="s3-checkbox"><input type="checkbox" class="checkids" id="select-all" name="select-all">&nbsp;<span></span></label> </th>
@elseif(isset($f['search_items']))
<td search="2">
@if(isset($f['is_custom_search']))
<select class="form-control is_custom_search select2" name="{{ $f['id']}}" id="{{ $f['id'] }}">
@else 
<select class="form-control filter select2" >
@endif 
   <option value="">Select...</option>
    @foreach($f['search_items'] as $key=>$value)
<option value="{{ $key }} ">{{ $value  }}</option>

        @endforeach
</select>
</td>

@elseif(isset($f['is_date']))
<th search="2">
<input type="text" name="{{ $f['id']}}" id="{{ $f['id'] }}" class="form-control is_custom_search date-picker"
/>
</th>

@elseif(isset($f['is_date_range']))
<th search="2" >

<div class="row " >
    <div class="col-md-12">

<input  type="text" placeholder="From Date" name="{{ $f['id'] }}_from" id="{{ $f['id'] }}_from" class="form-control mb-3  is_custom_search date-picker"
/>
    </div>

    <div class="col-md-12">
<input type="text" placeholder="To Date" name="{{ $f['id'] }}_to" id="{{ $f['id'] }}_to" class="form-control   is_custom_search date-picker"
/>
    </div>


</div>


</th>


@else
@if(isset($f['searchable']))
<th search="0">{{ $f['display_name']}} </th>
@else
<th search="1">{{ $f['display_name']}} </th>
@endif
@endif


@endforeach
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>




</div>
</div>
</form>
</div>

@stop