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
	                <i class="icon-calendar font-white"></i>
	                <span class="caption-subject font-white sbold uppercase">Booking History</span>
	            </div>
	        </div>
	        <div class="portlet-body">
	        	<div class="col-md-10 margin-bottom-15px padding-left-0px">

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
	        	<div class="col-md-2 margin-bottom-15px padding-right-0px">
	        		<a href="" class="btn btn-sm green-jungle pull-right" id="createButton" data-toggle="modal" data-target="#createModal">Booking</a>
	        	</div>
	            <div class="table-scrollable table-bordered table-hover">
	                <table class="table table-hover table-light">
	                    <thead>
	                        <tr class="uppercase">
	                            <th> # </th>
	                            <th> Car Model </th>
	                            <th> Destination </th>
	                            <th> Purpose </th>
	                            <th> Departure Date </th>
	                            <th> Return Date </th>
	                            <th> Booking Date </th>
	                            <th> File </th>
	                            <th> Status </th>
	                            <th> Remarks </th>
	                        </tr>
	                    </thead>
	                    <tbody>
							<?php $count = 1; ?>
							@if(count($histories) > 0)
	                        @foreach($histories as $history)
	                        <?php $currentPageTotalNumber = ($histories->currentPage() - 1) * 5; ?>
	                        <tr>
	                            <td><b>{{$count + $currentPageTotalNumber}}</b></td>
	                            <td> {{ $history->model }}</td>
	                            <td> {{ $history->destination }}</td>
	                            <td> {{ $history->purpose }}</td>
	                            <td> {{ $history->start_date }}</td>
	                            <td> {{ $history->end_date }}</td>
	                            <td> {{ $history->created_at }}</td>
	                            <td>
		                            <a class="btn btn-transparent grey-mint btn-sm active" href="{{ $directory.$history->filepath }}" download>
		                            	Download
		                            </a>
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
	        	<div class="col-md-12">
	        		<div class="pull-right">
	        			{{$histories->render()}}
	        		</div>
	        	</div>
	    </div>
	    <!-- END BORDERED TABLE PORTLET-->
	</div>
</div>

<!-- Modal -->
<div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Departure and Return Date</h4>
      </div>
      <div class="modal-body">
      	<div class="table-scrollable table-scrollable-borderless">
            {!! Form::open(['method'=>'POST', 'action'=>'UserController@showAvailableBooking', 'files'=>true]) !!}
		        
		        <div class="form-group col-md-12">
		            <label for="inputPassword1" class="col-md-4 control-label">Departure Date</label>
		            <div class="col-md-8">
		                <div class="input-group date date-picker border-grey-navy" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
		                	<span class="input-group-btn">
		                        <button class="btn default" type="button">
		                            <i class="fa fa-calendar"></i>
		                        </button>
		                    </span>
		                    <input type="text" class="form-control" readonly="" name="start_date" value="" required=""  id="s_date">
		                </div>
		            </div>
		        </div>

		        <div class="form-group col-md-12">
		            <label for="inputPassword1" class="col-md-4 control-label">End Date</label>
		            <div class="col-md-8">
		                <div class="input-group date date-picker border-grey-navy" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
		                	<span class="input-group-btn">
		                        <button class="btn default" type="button">
		                            <i class="fa fa-calendar"></i>
		                        </button>
		                    </span>
		                    <input type="text" class="form-control" readonly="" name="end_date" value="" required="" id="e_date">
		                    
		                </div>
		            </div>
		        </div>
        </div>
      </div>
      <div class="modal-footer">
      	<button class="btn btn-transparent blue btn-sm active submitDate"> Submit </button>
        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
       {!! Form::close() !!}
      </div>
    </div>

  </div>
</div>
<!-- End modal -->

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

<script>
	
	function myFunction() {
		
		if($('#filter_status').val() == ''){
			window.location.href = '/user';
		}
		else{
			window.location.href = '/user?status=' + $( "#filter_status" ).val();
		}
	}

	$(document).ready(function(){
       $('.showRemarks').click(function(){
		 	$("textarea#m_remarks").val($(this).data('remarks'));
       });

       	$(".submitDate").click(function(event){
		    var isValid = true;

		    if($('#e_date').val() == '' || $('#s_date').val() == '')
			{	
			 $('#createModal').modal('toggle'); 
			 swal(
			  '',
			  "Please select date!",
			  'error'
			)
			 isValid = false;
			}

		    if (!isValid) {
		        event.preventDefault();
		    }
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

@stop