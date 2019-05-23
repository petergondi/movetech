@extends('layouts.errorapp')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"><br><br><br><br>

                <div class="flash-message">
                    @foreach (['danger'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Enter new Password Here</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{route('submit_pass_reset')}}">
                            {{ csrf_field() }}


                            <input  type="hidden" value="{{$emails}}" class="form-control" name="email" >
                            <input  type="hidden" value="{{$tokens}}" class="form-control" name="token" >

                            <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">New Password</label>

                                <div class="col-md-6">
                                    <input id="newpassword" type="password" class="form-control" name="newpassword" required>

                                    @if ($errors->has('newpassword'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('confirmpassword') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="confirmpassword" type="password" class="form-control" name="confirmpassword" required>

                                    @if ($errors->has('confirmpassword'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('confirmpassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
