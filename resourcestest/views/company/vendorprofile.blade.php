@extends('vendorlayout')
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
                                                    <th> Username</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_companyupdatedvendor') }}">
                                                        {{ csrf_field() }}
                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input readonly type="text" id="name" name="name" value="{{ $result->name }}">
                                                        @else
                                                        <input readonly type="text" id="name" name="name" value="{{ old('name') }}">
                                                        @endif
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('name') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input readonly type="email" id="email" name="email" value="{{ $result->email }}">
                                                        @else
                                                        <input readonly type="email" id="email" name="email" value="{{ old('email') }}">
                                                        @endif
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('email') }}</font>
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
                                                    <td><b>Kra Pin</b></td>
                                                    <td><b>Bussiness Name</b></td>
                                                    <td><b>Bussiness Aliasname</b></td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="krapin" name="krapin" value="{{ $result->krapin }}">
                                                        @else
                                                        <input type="text" id="krapin" name="krapin" value="{{ old('krapin') }}">
                                                        @endif
                                                        @if ($errors->has('krapin'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('krapin') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                    
                                                        @if($result)
                                                        <input type="text" id="bussinessname" name="bussinessname" value="{{ $result->bussinessname }}">
                                                        @else
                                                        <input type="text" id="bussinessname" name="bussinessname" value="{{ old('bussinessname') }}">
                                                        @endif
                                                        @if ($errors->has('bussinessname'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('bussinessname') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($result)
                                                        <input type="text" id="bussinessaliasname" name="bussinessaliasname" value="{{ $result->bussinessaliasname }}">
                                                        @else
                                                        <input type="text" id="bussinessaliasname" name="bussinessaliasname" value="{{ old('bussinessaliasname') }}">
                                                        @endif
                                                        @if ($errors->has('bussinessaliasname'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('bussinessaliasname') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Bussiness Address</b></td>
                                                        <td><b>Physical Address</b></td>
                                                        <td><b>Bank Account</b></td>
                                                    </tr>
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
                                                        <input type="text" id="bankaccount" name="bankaccount" value="{{ $result->bankaccount }}">
                                                        @else
                                                        <input type="text" id="bankaccount" name="bankaccount" value="{{ old('bankaccount') }}">
                                                        @endif
                                                        @if ($errors->has('bankaccount'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('bankaccount') }}</font>
                                                        </span>
                                                        @endif
                                                        
                                                    </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><b>Action</b></td>
                                                        <td><button class="btn btn-primary" type="submit">Update</button> </td>
                                                        <td></td>
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