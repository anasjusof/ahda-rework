@extends('layouts.master')

@section('head')

@stop

@section('title')
   Approve / Reject Booking 
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="">Home</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="#">Approve / Reject Booking </a>
    </li>
@stop

@section('content')
<div class="row">
	
	<div class="col-md-12">
		<!-- BEGIN BORDERED TABLE PORTLET-->
	    <div class="portlet box blue-dark">
	        <div class="portlet-title">
	            <div class="caption">
	                <span class="caption-subject font-white sbold uppercase">Approve / Reject Booking </span>
	            </div>
	        </div>
	        <div class="portlet-body">
		        <div class="row">
		        	<div class="col-md-12">
				        <h1>User Form</h1>
					    <p> </p>
					    <hr>	
			        </div>

		        	{!! Form::open(['method'=>'POST', 'action'=>'AdminController@approveReject', 'files'=>true]) !!}

		        		<div class="form-group col-md-12">
					      <label for="name">Name:</label>
					      <input type="text" value="{{ $histories->name }}" class="form-control" name="name" readonly="">
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Email:</label>
					      <input type="text" value="{{ $histories->email }}" class="form-control" name="email" readonly="">
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Purpose:</label>
					      <select class="form-control" name="purpose" readonly>
					        <option value="Conference">{{ $histories->purpose }}</option>
					      </select>
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Destination address:</label>
					      <textarea name="destination" class="form-control" readonly="">{{ $histories->destination }}</textarea>
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Total Passenger:</label>
					      <input type="text" value="{{ $histories->total_passenger }}" class="form-control" name="total_passenger" readonly="">
					    </div>

					    <div class="form-group col-md-12">
				            <label for="inputPassword1" class="control-label">Departure Date</label>
				            <div class="">
				                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
				                	<span class="input-group-btn">
				                        <button class="btn default" type="button">
				                            <i class="fa fa-calendar"></i>
				                        </button>
				                    </span>
				                    <input type="text" class="form-control" readonly name="start_date" value="{{ $start_date }}">
				                </div>
				            </div>
				        </div>

				        <div class="form-group col-md-12">
				            <label for="inputPassword1" class="control-label">Return Date</label>
				            <div class="">
				                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
				                	<span class="input-group-btn">
				                        <button class="btn default" type="button">
				                            <i class="fa fa-calendar"></i>
				                        </button>
				                    </span>
				                    <input type="text" class="form-control" readonly name="end_date" value="{{ $end_date }}">
				                </div>
				            </div>
				        </div>

				        <div class="col-md-12">
				        	<h1>Available Vehicles</h1>
						    <p> </p>
						    <hr>	
				        </div>

					    <div class="col-md-12">
						    <div class="table-scrollable table-scrollable-borderless">
				                <table class="table table-hover table-light">
				                    <thead>
				                        <tr class="uppercase">
				                        	<th> Tick to Book</th>
				                            <th> # </th>
				                            <th> Model </th>
				                            <th> Plate </th>
				                            <th> Type </th>
				                        </tr>
				                    </thead>
				                    <tbody id="tbody">
										<?php $count = 1; ?>
				                        @foreach($available_bookings as $vehicle)
				                        <tr>
				                        	<td><p><input type="radio" name="car_id" value="{{ $vehicle->id }}" style="margin-left: 0px"></p></td>
				                            <td>{{$count}}</td>
				                            <td>{{ $vehicle->model }}</td>
											<td>{{ $vehicle->plate }}</td>
											<td>{{ $vehicle->type }}</td>
				                        </tr>
				                        <?php $count++ ?>
				                        @endforeach
				                    </tbody>
				                </table>
				            </div>
			            </div>

			            <div class="form-group col-md-12">
					      <label for="name">Remarks / Message :</label>
					      <textarea name="remarks" class="form-control" >{{ $histories->remarks }} </textarea>
					    </div>

			            <div>
			            	<div class="form-group col-md-12">
				            <!-- <label for="inputPassword1" class="control-label">Upload file</label> -->
				            	<input type="hidden" name="booking_history_id" value="{{ $histories->history_id }}">
				                <input class="btn btn-primary" id="approve-btn" name="approveReject" type="submit" value="Approve"  style="min-width: 100px">
				                <input class="btn btn-danger" name="approveReject" type="submit" value="Reject" style="min-width: 100px">
				        	</div>
			            </div>
		        	{!! Form::close() !!}
		        </div>
	        </div>
	    </div>
	    <!-- END BORDERED TABLE PORTLET-->
	</div>
</div>
@stop

@section('script')

<script>
	
	function myFunction() {
		
		if($('#filter_status').val() == ''){
			window.location.href = '/user';
		}
		else{
			window.location.href = '/user?status=' + $( "#filter_status" ).val();
		}
	}

	$("#approve-btn").click(function(event){
	    var isValid = true;

	    if($('input[name=car_id]:checked').length<=0)
		{	
		 swal(
		  '',
		  "Please select one vehicle for booking",
		  'error'
		)
		 isValid = false;
		}

	    if (!isValid) {
	        event.preventDefault();
	    }
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

@stop