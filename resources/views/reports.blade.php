@extends('layouts.page')
@section('title', $title)
@push('pre_css')
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


<script>
    $.fn.dataTable.ext.errMode = 'throw';


    $(function () {


        var table =  $('#s-table').DataTable({
		columnDefs: [
            

            { targets: [], visible: false },


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
      
      
      "processing": true,


      "responsive": true,
    

        "serverSide":false,
 
      

    		"lengthMenu": [
                    [5,10,20, 30, 50, 100, -1],
                    [5,10,20, 30, 50, 100, "All"]
            ],
            "pageLength": 5,
          
			"sDom": '<"row"<"col-sm-6"B><"col-sm-6"f>><"clear">rt<"row"<"col-sm-5"li><"col-sm-7"p>>',
        });

    });
    
</script>
@endpush
@section('content')

<div class="container-fluid p-4">
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

                                            
											</div>
										</div>
									</div>
								</div>
                                <div class="s3-portlet-body">



<div id="s3_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
<div class="row">
<div class="col-sm-12">
<div class="table-responsive">
<table id="s-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" >
<thead>
<tr>
<th>S.No</th><th>Room type</th><th>No of Rooms</th>
</tr>
</thead>
<tbody>
@php($inc=1)
@foreach($report as $r)

<tr>
<td>{{ $inc++ }}</td>
<td>{{ $r->room_type }}</td>
<td>{{ $r->no_of_rooms}}</td>
</tr>

@endforeach
</tbody>


</table>
</div>
</div>
</div>
</div>




</div>
</div>
</div>

@stop