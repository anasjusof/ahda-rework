@extends('layouts.master')

@section('head')

@stop

@section('title')
    Booking Management
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="">Home</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="#">Booking Management</a>
    </li>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN BORDERED TABLE PORTLET-->
	    <div class="portlet box blue-dark">
	        <div class="portlet-title">
	            <div class="caption">
	                <i class="icon-calendar font-white"></i>
	                <span class="caption-subject font-white sbold uppercase">Booking Management</span>
	            </div>
	        </div>
	        <div class="portlet-body">
	        	<div class="col-md-12 margin-bottom-15px padding-left-0px">
		        	<div class="col-md-3 padding-left-0px">
	        			<select class="form-control input-sm" id="filter_status" name="filter_status" onchange="myFunction()" placeholder="Filter Status">
	        				<option value="">Filter Status</option>
	        				<option value="">All</option>
	        				<option value="0">Pending</option>
	        				<option value="1">Approved</option>
	        				<option value="2">Rejected</option>
	        			</select>
	        		</div>
	        	</div>

	            <div class="table-scrollable table-bordered table-hover">
	                <table class="table table-hover table-light">
	                    <thead>
	                        <tr class="uppercase">
	                            <th> # </th>
	                            <th> User Name </th>
	                            <th> Car Model </th>
	                            <th> Destination </th>
	                            <th> Purpose </th>
	                            <th> Passenger </th>
	                            <th> Departure Date </th>
	                            <th> Return Date </th>
	                            <th> Booking Date </th>
	                            <th> File </th>
	                            <th></th>
	                            <th> Status </th>
	                            <th> Remarks </th>
	                        </tr>
	                    </thead>
	                    <tbody id="tbody">
	                    	<!--
	                        <tr>
	                            <td> 1 </td>
	                            <td> Zakat Fitrah </td>
	                            <td> 03-03-2017 </td>
	                            <td> <button class="btn btn-transparent yellow-lemon btn-circle btn-sm active"> Download </button> </td>
	                            <td>
	                                <span class="label label-success"> Approved </span>
	                            </td>
	                        </tr>
							-->
							<?php $count = 1; ?>
							@if(count($histories) > 0)
	                        @foreach($histories as $history)
	                        <?php $currentPageTotalNumber = ($histories->currentPage() - 1) * 5; ?>
	                        <tr>
	                        	<td><b>{{$count + $currentPageTotalNumber}}</b></td>
	                        	<td>
	                        		<a href="" class="showUser" data-toggle="modal" data-target="#userModal" data-username="{{ $history->name }}" data-user_email="{{ $history->email }}" data-faculty="{{ $history->faculty }}" data-phone="{{ $history->phone }}" data-matrik="{{ $history->matrik }}"> 
	                        		<i class="fa fa-list"></i>
	                        		{{ $history->name }}
	                        		</a>
	                        	</td>
	                            <td>
	                            	<a href="" class="showVehicle" data-toggle="modal" data-target="#vehicleModal" data-vehicle_model="{{ $history->model }}" data-vehicle_type="{{ $history->type }}" data-vehicle_plate="{{ $history->plate }}"> 
	                            	<i class="fa fa-list"></i>
	                            	{{ $history->model }}
	                            	</a>
	                            </td>
	                            <td> {{ $history->destination }}</td>
	                            <td> {{ $history->purpose }}</td>
	                            <td class="text-center"> {{ $history->total_passenger }}</td>
	                            <td> {{ $history->start_date }}</td>
	                            <td> {{ $history->end_date }}</td>
	                            <td> {{ $history->created_at }}</td>
	                            <td>
		                            <a class="btn btn-transparent grey-mint btn-sm active" href="{{ $directory.$history->filepath }}" download>
		                            	Download
		                            </a>
	                            </td>
	                            <td>
	                            	<a href="{{ route('admin.approve-reject-confirmation', $history->history_id ) }}" class="btn blue btn-sm editBtn">Approve | Reject</a>
	                            </td>
	                            <td>
	                                <span 
	                                	class="label min-width-100px
	                                	@if( $history->approval == 2) {{ 'label-danger' }}
	                                	@elseif ($history->approval == 0){{ 'label-default' }}
	                                	@elseif ($history->approval == 1){{ 'label-success' }}
	                                	@else {{ 'label-danger' }}
	                                	@endif">

	                                	@if( $history->approval == 2) {{ 'Rejected' }}
	                                	@elseif ($history->approval == 0){{ 'Pending' }}
	                                	@elseif ($history->approval == 1){{ 'Approved' }}
	                                	@else {{ 'Rejected' }}
	                                	@endif

	                                </span>
	                            </td>
	                            <td>
	                            	<a href="" class="showRemarks" data-toggle="modal" data-target="#remarksModal" data-remarks="{{ $history->remarks }}"> 
	                            	<i class="fa fa-list"></i>
	                            	View Remarks
	                            	</a>
	                            </td>
	                        </tr>
	                        <?php $count++ ?>
	                        @endforeach
	                        @endif
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	    <!-- END BORDERED TABLE PORTLET-->
	    <div class="row">
        	<div class="col-md-6">
        		{{$histories->render()}}
        	</div>
        	<div class="col-md-6">
        	</div>
        </div>
	</div>

    
</div>

<!-- Modal -->
<div id="userModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Info</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Name</label>
	            <div class="col-md-8">
	                    <input type="text" name="name" class="form-control input-line" id="m_username" disabled>
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Email</label>
	            <div class="col-md-8">
	                    <input type="email" name="email" class="form-control input-line" id="m_email" disabled>
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Staff/matrik number</label>
	            <div class="col-md-8">
	                    <input type="text" name="matrik" class="form-control input-line" id="m_matrik" disabled>
	            </div>
	        </div>

	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Phone</label>
	            <div class="col-md-8">
	                    <input type="text" name="phone" class="form-control input-line" id="m_phone" disabled>
	            </div>
	        </div>

	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Faculty</label>
	            <div class="col-md-8">
	                    <select class="form-control" name="faculty" id="m_faculty" disabled>
                            <option value="FSTM">FSTM</option>
                            <option value="FPM">FPM</option>
                            <option value="FP">FP</option>
                            <option value="FSU">FSU</option>
                            <option value="PA">PA</option>
                            <option value="FPPI">FPPI</option>
                            <option value="PPT">PPT</option>
                            <option value="PPS">PPS</option>
                        </select>
	            </div>
	        </div>
	  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div id="vehicleModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vehicle Info</h4>
      </div>
      <div class="modal-body">
      	<div class="row">

      		<div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Model</label>
	            <div class="col-md-8">
	                    <input type="text" name="model" class="form-control input-line" id="m_vehicle_model" disabled>
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Plate</label>
	            <div class="col-md-8">
	                    <input type="text" name="plate" class="form-control input-line" id="m_vehicle_plate" disabled>
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Type</label>
	            <div class="col-md-8">
	                    <input type="text" name="type" class="form-control input-line" id="m_vehicle_type" disabled>
	            </div>
	        </div>
	    
	  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div id="remarksModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Remarks / Message</h4>
      </div>
      <div class="modal-body">
      	<div class="row">

      		<div class="form-group col-md-12">
		      <textarea id="m_remarks" class="form-control" readonly=""></textarea>
		    </div>
	    
	  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Modal -->
@stop

@section('script')

<script src="../../assets/global/plugins/icheck/icheck.min.js"></script>

<script src="../../assets/admin/pages/scripts/form-icheck.js"></script>

<script> FormiCheck.init();  </script>

<script>
	function myFunction() {
		if($('#filter_status').val() == ''){
			window.location.href = '/admin/manage-booking';
		}
		else{
			window.location.href = '/admin/manage-booking/?status=' + $( "#filter_status" ).val();
		}
	}

	$(document).ready(function(){
       $('#checkall-checkbox').click(function(){
            if(this.checked){
                $('.checker').find('span').addClass('checked');
                $("input.single-checkbox").prop('checked', true).show();
            }
            else{
                $('.checker').find('span').removeClass('checked');
                $("input.single-checkbox").prop('checked', false);
            }
       });

        $('.showUser').click(function(){
       		var faculty = $(this).data('faculty');

       		$("#m_user_id").val($(this).data('user_id'));
		 	$("#m_username").val($(this).data('username'));
		 	$("#m_email").val($(this).data('user_email'));
		 	$("#m_matrik").val($(this).data('matrik'));
		 	$("#m_phone").val($(this).data('phone'));
		 	$("#m_faculty").val(faculty);

       });

       $('.showVehicle').click(function(){

		 	$("#m_vehicle_model").val($(this).data('vehicle_model'));
		 	$("#m_vehicle_plate").val($(this).data('vehicle_plate'));
		 	$("#m_vehicle_type").val($(this).data('vehicle_type'));
       });

       $('.showRemarks').click(function(){
		 	$("textarea#m_remarks").val($(this).data('remarks'));
       });
    });

</script>

@if(Session::has('message'))
    <script>
    	swal(
		  '',
		  "{{Session::get('message')}}",
		  'success'
		)
    </script>
@endif

@include('errors.validation-errors')
@include('errors.validation-errors-script')

@stop