@extends('layouts.app3')

@section('content')
<h2 class="text-center" style="color:#ffffff">Enter departure and return date</h2>
<hr>
<!-- BEGIN BOTTOM ABOUT BLOCK -->
<div class="col-md-12" style="color:#ffffff; padding-bottom: 15px;">
  <div class="col-md-4 col-md-offset-4">
  <form method="POST" action="/check" enctype="multipart/form-data">
     {{ csrf_field() }}

    <div class="form-group col-md-12">
        <label for="inputPassword1" class="col-md-12 control-label">Departure Date</label>
        <div class="col-md-12">
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
        <label for="inputPassword1" class="col-md-12 control-label">End Date</label>
        <div class="col-md-12">
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
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-default text-center">Check</button>
    </div>
    
  </form>
</div>
</div>
@endsection
