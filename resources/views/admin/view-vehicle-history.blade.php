@extends('layouts.master')

@section('head')

@stop

@section('title')
    Vehicle Booking History
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="">Home</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="#">Vehicle Booking History</a>
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
	                <span class="caption-subject font-white sbold uppercase">Vehicle Booking History : {{ $vehicle->model }}</span>
	            </div>
	        </div>
	        <div class="portlet-body">

	            <div class="table-scrollable table-bordered table-hover">
	                <table class="table table-hover table-light">
	                    <thead>
	                        <tr class="uppercase">
	                            <th> # </th>
	                            <th> User Name </th>
	                            <th> Car Model </th>
	                            <th> Destination </th>
	                            <th> Purpose </th>
	                            <th> Departure Date </th>
	                            <th> Return Date </th>
	                            <th> File </th>
	                            <th> Booking Date </th>
	                            <th> Status </th>
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
	                        	<td> {{ $history->name }}</td>
	                            <td> {{ $history->model }}</td>
	                            <td> {{ $history->destination }}</td>
	                            <td> {{ $history->purpose }}</td>
	                            <td> {{ $history->start_date }}</td>
	                            <td> {{ $history->end_date }}</td>
	                            <td>
		                            <a class="btn btn-transparent grey-mint btn-sm active" href="{{ $directory.$history->filepath }}" download>
		                            	Download
		                            </a>
	                            </td>
	                            <td> {{ $history->created_at }}</td>
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
    });

</script>


@include('errors.validation-errors')
@include('errors.validation-errors-script')

@stop