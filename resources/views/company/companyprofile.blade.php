@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Company Profile</strong>
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
                                                    <th>Company Name</th>
                                                    <th>Address</th>
                                                    <th>Phone Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_companysettings') }}">
                                                        {{ csrf_field() }}
                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="company" name="company" value="{{ $result->company }}">
                                                        @else
                                                        <input type="text" id="company" name="company" value="{{ old('company') }}">
                                                        @endif
                                                        @if ($errors->has('company'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('company') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="address" name="address" value="{{ $result->address }}">
                                                        @else
                                                        <input type="text" id="address" name="address" value="{{ old('address') }}">
                                                        @endif
                                                        @if ($errors->has('address'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('address') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="phonenumber" name="phonenumber" value="{{ $result->phonenumber }}">
                                                        @else
                                                        <input type="text" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') }}">
                                                        @endif
                                                        @if ($errors->has('phonenumber'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('phonenumber') }}</font>
                                                        </span>
                                                        @endif
                                                    
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td><b>Email</b></td>
                                                    <td></td>
                                                    <td><b>Action</b></td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="email" name="email" value="{{ $result->email }}">
                                                        @else
                                                        <input type="text" id="email" name="email" value="{{ old('email') }}">
                                                        @endif
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('email') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                    
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