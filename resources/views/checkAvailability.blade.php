@extends('layouts.app2')
@section('content') 


<div class="jumbotron text-center bg-1" >
  <h1 style="color:#ffffff">Kuis Transportation Booking System</h1>
  <p style="color:#ffffff">Enter departure and return date.</p>
   <p><a class="btn btn-primary btn-lg" role="button" href="{{ url('homepage') }}">HOME</a></p>
</div>

        @if (Session::has('Failed'))

        <div class="alert alert-danger" role="alert">
            <strong>Failed:</strong> {{ Session::get('Failed') }}
        </div>

        @endif

<div style="Background-color:#3399ff;">
<div class="container">
  <div class="row"  style="margin-top:25px; margin-bottom:25px;">
    <div class="col-md-12" style="color:#ffffff">
      <div class="col-md-4 col-md-offset-4">
      <form method="POST" action="/check" enctype="multipart/form-data">
         {{ csrf_field() }}

         <div class="form-group">
          <label for="name">Departure date:</label>
          <input type="text" data-date-format='yyyy-mm-dd' id="datepicker5" class="form-control" name="start_date">
        </div>
        <div class="form-group">
          <label for="name">Return date:</label>
          <input type="text" data-date-format='yyyy-mm-dd' id="datepicker6" class="form-control" name="end_date">
        </div>
        <button type="submit" class="btn btn-default">Check</button>
      </form>
    </div>
  </div>
</div>
</div>
</div>



@endsection 