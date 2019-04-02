@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Update Category</strong>
                                        
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
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_updatedcategory') }}">
                                                        {{ csrf_field() }}
                                                    <td> New </td>
                                                    <td>
                                                        <input type="hidden" id="id" name="id" value="{{ $result->id }}">
      
                                                        <input type="text" id="category" name="category" value="{{ $result->category }}">
      
                                                        @if ($errors->has('category'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('category') }}</font>
                                                        </span>
                                                        @endif
                                                    <td>  
                                                    <button class="btn btn-outline-primary btn-sm" type="submit">Update</button>
                                                
                                                    </td>
                                                    </form>
                                                </tr>
                                                @foreach($categorys as $category)
                                                <tr>
                                                    <td> {{$category->id}} </td>
                                                    <td> {{$category->category}}  </td>
                                                    <td>  
                                                    
                                                    <a  href="{{route('editcategory',['id'=>$category->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> edit </a>
                                                    <a onclick="return deleterecord(this);" href="{{route('deletecategory',['id'=>$category->id])}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> delete </a>
                                             
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