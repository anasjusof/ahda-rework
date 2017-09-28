@extends('layouts.app2')
@section('content') 


<div class="jumbotron text-center bg-1">
<h1 style="color:#ffffff">Kuis Transportation Booking System</h1>
<p style="color:#ffffff">Book KUIS vehicle faster and easier here..</p>
    <a class="btn btn-primary btn-lg" role="button" href="{{ url('check-availability') }}">Check Booking Availability</a>
    <a class="btn btn-primary btn-lg" role="button" href="{{ url('login') }}">Login</a>
    <a class="btn btn-primary btn-lg" role="button" href="{{ route('register') }}">Register</a>
     @if (Auth::guest())
    @else
    <a href="{{ route('logout') }}"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();" class="btn btn-primary btn-lg" role="button">
    Logout
</a>
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
@endif
</div>

</div>

<div class="col-md-12 text-center" style="background-color:#3399ff" >
<div class="container" style="margin-top:18px; margin-bottom:25px;">
  <h1 style="color:#000000">RULES</h1>
  <hr>
  <p style="color:#000000">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint
      occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
      laboris nisi ut aliquip ex ea commodo consequat.</p>
</div>
</div>


  <div class="col-md-12 bg-1" style="background-color:#6699ff">
      <div class="container" style="margin-bottom:20px;">
          <div class="panel-heading text-center" style="color:#ffffff"><h2>FOR MORE INFORMATIONPLEASE CONTACT US ON</h2></div>
          <h3 class="text-center" style="color:#ffffff">Phone: +62 3-8911 700</h3>
          <h3 class="text-center" style="color:#ffffff">Address: Bandar Seri putra, 4300 kajag. Selangor, MALAYSIA</h3>
      </div>
  </div>

  @endsection

