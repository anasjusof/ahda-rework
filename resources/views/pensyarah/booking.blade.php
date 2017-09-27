@extends('layouts.master')

@section('head')

@stop

@section('title')
    Booking History
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="">Home</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="#">Booking History</a>
    </li>
@stop

@section('content')
<div class="row">
	
	<div class="col-md-12">
		<!-- BEGIN BORDERED TABLE PORTLET-->
	    <div class="portlet box blue-dark">
	        <div class="portlet-title">
	            <div class="caption">
	                <span class="caption-subject font-white sbold uppercase">Book with 3 simple step</span>
	            </div>
	        </div>
	        <div class="portlet-body">
		        <div class="row">
		        	<div class="col-md-12">
				        <h1>First step</h1>
					    <p> Fill the form</p>
					    <hr>	
			        </div>

		        	{!! Form::open(['method'=>'POST', 'action'=>'LecturerController@booking', 'files'=>true]) !!}

		        		<div class="form-group col-md-12">
					      <label for="name">Name:</label>
					      <input type="text" value="{{ Auth::user()->name }}" class="form-control" name="name" readonly="">
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Email:</label>
					      <input type="text" value="{{ Auth::user()->email }}" class="form-control" name="email" readonly="">
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Purpose:</label>
					      <select class="form-control" name="purpose">
					        <option value="Conference">Conference</option>
					        <option value="Camp">Camp</option>
					        <option value="Trip">Trip</option>
					      </select>
					    </div>

					    <div class="form-group col-md-12">
					      <label for="name">Destination address:</label>
					      <textarea name="destination" class="form-control"></textarea>
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
					        <h1>Second step</h1>
						    <p>Upload your documents</p>
						    <hr>	
				        </div>
					    
					     <div class="form-group col-md-12">
				            <!-- <label for="inputPassword1" class="control-label">Upload file</label> -->
				                <input class="form-control input-line input-medium" type="file" name="attachment" id="fileToUpload">
				        </div>

				        <div class="col-md-12">
					        <h1>Third step</h1>
						    <p>Check if vehicle is available</p>
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
				                        	<td><p><input type="checkbox" name="car_id" value="{{ $vehicle->id }}"></p></td>
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

			            <div>
			            	<div class="form-group col-md-12">
				            <!-- <label for="inputPassword1" class="control-label">Upload file</label> -->
				                <input class="btn btn-primary" type="submit" value="Book Now">
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