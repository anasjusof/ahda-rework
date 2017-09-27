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
      
      <table class="table table-bordered">
        <thead>
          <tr>
            <th> # </th>
            <th> Model </th>
            <th> Plate </th>
            <th> Type </th>
          </tr>
        </thead>
        <tbody>
        <?php $count = 1; ?>
        @foreach($available_bookings as $vehicle)
        <tr>
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
</div>
</div>



@endsection 