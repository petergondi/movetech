@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">New Vendor</strong>
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
                                                    <th>Bussiness Address</th>
                                                    <th>Physical Address</th>
                                                    <th>User Name</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_newvendor') }}">
                                                        {{ csrf_field() }}
                                                        
                                                        @if($result)
                                                        <input type="hidden" id="id" name="id" value="{{ $result->id }}">
                                                        @else
                                                        <input type="hidden" id="id" name="id" value="{{ old('id') }}">
                                                        @endif
                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="bussinessaddress" name="bussinessaddress" value="{{ $result->bussinessaddress }}">
                                                        @else
                                                        <input type="text" id="bussinessaddress" name="bussinessaddress" value="{{ old('bussinessaddress') }}">
                                                        @endif
                                                        @if ($errors->has('bussinessaddress'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('bussinessaddress') }}</font>
                                                        </span>
                                                        @endif

                                                    </td>
                                                    <td>

                                                        @if($result)
                                                        <input type="text" id="physicaladdress" name="physicaladdress" value="{{ $result->physicaladdress }}">
                                                        @else
                                                        <input type="text" id="physicaladdress" name="physicaladdress" value="{{ old('physicaladdress') }}">
                                                        @endif
                                                        @if ($errors->has('physicaladdress'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('physicaladdress') }}</font>
                                                        </span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="name" name="name" value="{{ $result->name }}">
                                                        @else
                                                        <input type="text" id="name" name="name" value="{{ old('name') }}">
                                                        @endif
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('name') }}</font>
                                                        </span>
                                                        @endif
                                                    
                                                    </td>
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
                                                    </tr>
                                                    <tr>
                                                    <td><b>Phone Number</b></td>
                                                    <td><b>Password</b></td>
                                                    <td><b>Confirm Password</b></td>
                                                    <td><b>Action</b></td>
                                                    </tr>

                                                    <tr>
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
                                                    <td>

                                                        <input type="password" id="password" name="password" value="{{ old('password') }}">
                                                       
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('password') }}</font>
                                                        </span>
                                                        @endif
                                                    
                                                    </td>
                                                    <td>
                                                        <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                       
                                                    
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" type="submit">Add</button>
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