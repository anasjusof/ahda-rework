@extends('layouts.master')

@section('head')

@stop

@section('title')
    Manage Vehicle
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="">Home</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="#">Manage Vehicle</a>
    </li>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN BORDERED TABLE PORTLET-->
	    <div class="portlet box blue-dark">
	        <div class="portlet-title">
	            <div class="caption">
	                <i class=""></i>
	                <span class="uppercase">List of Vehicle</span>
	            </div>
	        </div>
	        <div class="portlet-body">
	            <div class="table-scrollable table-scrollable-borderless">
	                <table class="table table-hover table-light">

			        	<div class="col-md-12">
			        		<a href="" class="btn btn-sm green-jungle pull-right" id="createButton" data-toggle="modal" data-target="#createModal">Create New Vehicle</a>
			        	</div>
	                    <thead>
	                        <tr class="uppercase">
	                        	<th> <input id="checkall-checkbox" type="checkbox"> </th>
	                            <th> # </th>
	                            <th> Model </th>
	                            <th> Plate </th>
	                            <th> Type </th>
	                            <th> </th>
	                            <th> </th>
	                        </tr>
	                    </thead>
	                    <tbody id="tbody">
							<?php $count = 1; ?>
	                        @foreach($vehicles as $vehicle)
	                        <?php $currentPageTotalNumber = ($vehicles->currentPage() - 1) * 5; ?>
	                        <tr>
	                        	<td> <input class="single-checkbox" type="checkbox" name="vehicle_id[]" form="form_update_status" value="{{ $vehicle->id }}"> </td>
	                            <td>{{$count + $currentPageTotalNumber}}</td>
	                            <td> {{ $vehicle->model }}</td>
	                            <td> {{ $vehicle->plate }}</td>
	                            <td> {{ $vehicle->type }}</td>
	                            <td> 
	                            	<a href="{{ route('admin.view-vehicle-histories', $vehicle->id ) }}" class="btn blue btn-sm editBtn">View Booking History</a>
	                            </td>
	                            <td>
	                            <a href="" class="btn blue btn-sm editBtn" data-toggle="modal" data-target="#editModal" data-vehicle_id="{{ $vehicle->id }}" data-vehicle_model="{{ $vehicle->model }}" data-vehicle_type="{{ $vehicle->type }}" data-vehicle_plate="{{ $vehicle->plate }}">Edit</a>
	                            </td>
	                        </tr>
	                        <?php $count++ ?>
	                        @endforeach
	                    </tbody>
	                </table>
	            </div>

	            <div class="row">
		        	<div class="col-md-6">
		        		{!! Form::open(['method'=>'DELETE', 'action'=>['AdminController@deleteVehicle'], 'id'=>'form_update_status']) !!}
		        			<button class="btn btn-sm btn-danger deleteBtn">Delete</button>
		        		{!! Form::close() !!}
		        	</div>
		        	<div class="col-md-6">
		        		<div class="pull-right">
		        			{{$vehicles->render()}}
		        		</div>
		        	</div>
	        </div>

	        
	    </div>
	    <!-- END BORDERED TABLE PORTLET-->
	</div>
	

<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Info</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      	{!! Form::open(['method'=>'PATCH', 'action'=>'AdminController@editVehicle']) !!}
      		<div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Model</label>
	            <div class="col-md-8">
	                    <input type="text" name="model" class="form-control input-line" id="m_vehicle_model">
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Plate</label>
	            <div class="col-md-8">
	                    <input type="text" name="plate" class="form-control input-line" id="m_vehicle_plate">
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label for="inputPassword1" class="col-md-4 control-label">Type</label>
	            <div class="col-md-8">
	                    <input type="text" name="type" class="form-control input-line" id="m_vehicle_type">
	            </div>
	        </div>
	        
	        <input type="hidden" name="id" id="m_vehicle_id">
	    
	  	</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       {!! Form::close() !!}
      </div>
    </div>

  </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Vehicle</h4>
      </div>
      <div class="modal-body">
      	<div class="table-scrollable table-scrollable-borderless">
            {!! Form::open(['method'=>'POST', 'action'=>'AdminController@createVehicle']) !!}
            	<div class="form-group col-md-12">
		            <label for="inputPassword1" class="col-md-4 control-label">Model</label>
		            <div class="col-md-8">
		                    <input type="text" name="model" class="form-control input-line" id="vmodel" value="{{ old('model') }}">
		            </div>
		        </div>
		        <div class="form-group col-md-12">
		            <label for="inputPassword1" class="col-md-4 control-label">Plate</label>
		            <div class="col-md-8">
		                    <input type="text" name="plate" class="form-control input-line" id="vplate" value="{{ old('plate') }}">
		            </div>
		        </div>
		        <div class="form-group col-md-12">
		            <label for="inputPassword1" class="col-md-4 control-label">Type</label>
		            <div class="col-md-8">
		                    <input type="text" name="type" class="form-control input-line" id="vplate" value="{{ old('type') }}">
		            </div>
		        </div>
        </div>
      </div>
      <div class="modal-footer">
      	<button class="btn btn-transparent blue btn-sm active submitVehicleBtn"> Submit </button>
        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
       {!! Form::close() !!}
      </div>
    </div>

  </div>
</div>
<!-- End modal -->

@stop

@section('script')

<script>
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

       $('.editBtn').click(function(){

       		var roles_id = $(this).data('roles_id');
       		var faculties_id = $(this).data('faculties_id');

       		$("#m_vehicle_id").val($(this).data('vehicle_id'));
		 	$("#m_vehicle_model").val($(this).data('vehicle_model'));
		 	$("#m_vehicle_plate").val($(this).data('vehicle_plate'));
		 	$("#m_vehicle_type").val($(this).data('vehicle_type'));
       });

    });
</script>

@if(Session::has('create_message'))
    <script>
    	alertify.success("{{Session::get('create_message')}}");
    </script>
@endif

@if(Session::has('delete_message'))
    <script>
    	alertify.warning("{{Session::get('delete_message')}}");
    </script>
@endif

@if(Session::has('update_message'))
    <script>
    	alertify.success("{{Session::get('update_message')}}");
    </script>
@endif

@include('errors.validation-errors')
@include('errors.validation-errors-script')

@stop