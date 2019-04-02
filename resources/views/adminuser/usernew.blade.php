@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">New User</strong>
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
                                                    <th>Fullname</th>
                                                    <th>User Name</th>
                                                    <th>Password</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_newuser') }}">
                                                        {{ csrf_field() }}
                                                <tr>
                                                   
                                                    <td>
      
                                                        <input type="text" id="fname" name="fname" value="{{ old('fname') }}">
      
                                                        @if ($errors->has('fname'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('fname') }}</font>
                                                        </span>
                                                        @endif
                                                    </td> 
                                                    <td>
                                                        <input type="text" id="name" name="name" value="{{ old('name') }}">
      
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('name') }}</font>
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
                                                    <td>   </td>
                                                    
                                                </tr>
                                                
                                                <tr>
                                                    
                                                    <td><b>Email</b></td>
                                                    <td><b>Phone Number</b></td>
                                                    <td><b>Confirm password</b></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                   
                                                   <td>
     
                                                       <input type="email" id="email" name="email" value="{{ old('email') }}">
     
                                                       @if ($errors->has('email'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('email') }}</font>
                                                       </span>
                                                       @endif
                                                   </td> 
                                                   <td>
                                                       <input type="text" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') }}">
     
                                                       @if ($errors->has('phonenumber'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('phonenumber') }}</font>
                                                       </span>
                                                       @endif
                                                   </td> 
                                                    <td>
                                                        <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
      
                                                    </td>
                                                   <td>  
                                                   <button class="btn btn-outline-primary " type="submit">Add</button>
                                               
                                                   </td>
                                                   
                                               </tr>
                                                </form>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                </div>
               <br> <br> <br> 
            </div>
            <!-- .animated -->
        
@endsection