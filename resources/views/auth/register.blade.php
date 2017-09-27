@extends('layouts.app2')

@section('content')

<div class="jumbotron text-center bg-1">
  <h1 style="color:#ffffff">Kuis Transportation Booking System</h1>
  <p style="color:#ffffff">Book KUIS vehicle faster and easier here..</p>
  <p><a class="btn btn-primary btn-lg" role="button" href="/homepage">Home</a></p>
</div>
<div class="container col-md-12" >
    <div class="row" style="background-color:#3399ff">
                <h2 class="text-center" style="color:#ffffff">Register</h2>
                <hr>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label" style="color:#ffffff">Name</label>

                            <div class="col-md-5">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label" style="color:#ffffff">E-Mail Address</label>

                            <div class="col-md-5">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label" style="color:#ffffff">Password</label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label" style="color:#ffffff">Confirm Password</label>

                            <div class="col-md-5">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label for="name" class="col-md-4 control-label" style="color:#ffffff">Staff/matrik number:</label>
                          <div class="col-md-5">
                              <input type="text" class="form-control" name="matrik">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="name" class="col-md-4 control-label" style="color:#ffffff">Phone:</label>
                          <div class="col-md-5">
                              <input type="text" class="form-control" name="phone">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="sel1" class="col-md-4 control-label" style="color:#ffffff">Select Faculty:</label>
                          <div class="col-md-5">
                              <select class="form-control" name="faculty">
                                <option value="FSTM">FSTM</option>
                                <option value="FPM">FPM</option>
                                <option value="FP">FP</option>
                                <option value="FSU">FSU</option>
                                <option value="PA">PA</option>
                                <option value="FPPI">FPPI</option>
                                <option value="PPT">PPT</option>
                                <option value="PPS">PPS</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-default">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@endsection
