@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">SMS Settings</strong>
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
                                                    <th>Sender ID</th>
                                                    <th>User Name</th>
                                                    <th>API Key</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('usersubmit_smssettings') }}">
                                                        {{ csrf_field() }}
                                                    <td>

                                                    @if($result)
                                                    <input type="text" id="senderid" name="senderid" value="{{ $result->senderid }}">

                                                    @else
                                                    <input type="text" id="senderid" name="senderid" value="{{ old('senderid') }}">
    
                                                    @endif
                                                        @if ($errors->has('senderid'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('senderid') }}</font>
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
                                                        <input type="text" id="apikey" name="apikey" value="{{ $result->apikey }}">
                                                        @else
                                                        <input type="text" id="apikey" name="apikey" value="{{ old('apikey') }}">
                                                        @endif
                                                        @if ($errors->has('apikey'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('apikey') }}</font>
                                                        </span>
                                                        @endif
                                                    
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </td>
                                                </form>
                                                </tr>
                                                
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