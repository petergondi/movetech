@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Email Setting</strong>
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                                            
                                                        {{ Session::get('alert-' . $msgfin) }} 
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                @endif
                                            @endforeach
                                            
                                        </center>

                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Host</th>
                                                    <th>User Name</th>
                                                    <th>Password</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('usersubmit_emailsettings') }}">
                                                        {{ csrf_field() }}
                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="host" name="host" value="{{ $result->host }}">
                                                        @else
                                                        <input type="text" id="host" name="host" value="{{ old('host') }}">
                                                        @endif
                                                        @if ($errors->has('host'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('host') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="username" name="username" value="{{ $result->username }}">
                                                        @else
                                                        <input type="text" id="username" name="username" value="{{ old('username') }}">
                                                        @endif
                                                        @if ($errors->has('username'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('username') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="password" name="password" value="{{ $result->password }}">
                                                        @else
                                                        <input type="text" id="password" name="password" value="{{ old('password') }}">
                                                        @endif
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('password') }}</font>
                                                        </span>
                                                        @endif
                                                    
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td><b>From Address</b></td>
                                                    <td><b>From Name</b></td>
                                                    <td><b>Action</b></td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="fromaddress" name="fromaddress" value="{{ $result->fromaddress }}">
                                                        @else
                                                        <input type="text" id="fromaddress" name="fromaddress" value="{{ old('fromaddress') }}">
                                                        @endif
                                                        @if ($errors->has('fromaddress'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('fromaddress') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="fromname" name="fromname" value="{{ $result->fromname }}">
                                                        @else
                                                        <input type="text" id="fromname" name="fromname" value="{{ old('fromname') }}">
                                                        @endif
                                                        @if ($errors->has('fromname'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('fromname') }}</font>
                                                        </span>
                                                        @endif
                                                    
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </td>
                                                    </tr>
                                                </form>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                </div>
               <br> <br> <br> <br> <br> <br> <br> <br>
            </div>
            <!-- .animated -->
        
@endsection