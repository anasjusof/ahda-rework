@extends('layouts.app3')

@section('content')
<h2 class="text-center" style="color:#ffffff">Available Vehicle</h2>
<hr>
<!-- BEGIN BOTTOM ABOUT BLOCK -->
<div class="col-md-12" style="color:#ffffff; padding-bottom: 15px;">
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
@endsection
