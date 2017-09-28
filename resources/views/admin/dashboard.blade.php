@extends('layouts.master')

@section('head')

@stop

@section('title')
    Dashboard
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="">Home</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="#">Dashboard</a>
    </li>
@stop

@section('content')
	<div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-car"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="">{{ count($vehicles) }}</span>
                    </div>
                    <div class="desc"> Total Vehicle </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-check"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="">{{ count($approved) }}</span></div>
                    <div class="desc"> Approved Booking </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-close"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="">{{ count($rejected) }}</span>
                    </div>
                    <div class="desc"> Rejected Booking </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 grey" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="">{{ count($pending) }}</span></div>
                    <div class="desc"> Pending Booking </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue-madison" href="{{ route('admin.manage-user') }}">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="89"></div>
                    <div class="desc"> Goto Users Management </div>
                </div>
            </a>
        </div>
         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green-jungle" href="{{ route('admin.manage-vehicle') }}">
                <div class="visual">
                    <i class="fa fa-car"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="89"></div>
                    <div class="desc"> Goto Vehicle Management</div>
                </div>
            </a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow" href="{{ route('admin.manage-booking') }}">
                <div class="visual">
                    <i class="fa fa-list"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="89"></div>
                    <div class="desc"> Goto Booking Management</div>
                </div>
            </a>
        </div>
    </div>
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
    });

</script>

@include('errors.validation-errors')
@include('errors.validation-errors-script')

@stop