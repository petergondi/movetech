
@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">System User</strong>
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
                                                    <th>#</th>
                                                    <th>Full name</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($results as $result)
                                                <tr>
                                                    <td> {{$result->id}} </td>
                                                    <td> {{$result->fname}}  </td>
                                                    <td> {{$result->name}}  </td>
                                                    <td> {{$result->email}}  </td>
                                                    <td> {{$result->phonenumber}}  </td>
                                                    <td> 
                                                    <a  href="{{route('edituser',['id'=>$result->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> edit </a>
                                                    <a onclick="return deleterecord(this);" href="{{route('deleteuser',['id'=>$result->id])}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> delete </a>
                                             
                                                     </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                </div>
               <br> <br> <br> 
            </div>
            <!-- .animated -->

            <script>

                
                function deleterecord() {
                    if (confirm("Delete This Record")) {
                        $('#pleaseWaitDialog').modal('show');
                    } else {
                        return false;
                    }
                }

            </script>
        
@endsection