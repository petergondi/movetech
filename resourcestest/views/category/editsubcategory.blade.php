@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Sub-Category</strong>
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
                                                    <th>Category</th>
                                                    <th>Sub-Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_updatedsubcategory') }}">
                                                        {{ csrf_field() }}
                                                    <td> New </td>
                                                    <td>
                                                        
                                                    <input type="hidden" id="id" name="id" value="{{ $result->id }}">
                                                    {{$result->category}}
      
                                                    </td> 
                                                    <td>
                                                        <input type="text" id="subcategory" name="subcategory" value="{{$result->subcategory }}">
      
                                                        @if ($errors->has('subcategory'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('subcategory') }}</font>
                                                        </span>
                                                        @endif
                                                    </td> 
                                                    <td>  
                                                    <button class="btn btn-outline-primary btn-sm" type="submit">Update</button>
                                                
                                                    </td>
                                                    </form>
                                                </tr>
                                                @foreach($subcategorys as $subcategory)
                                                <tr>
                                                    <td> {{$subcategory->id}} </td>
                                                    <td> {{$subcategory->category}}  </td>
                                                    <td> {{$subcategory->subcategory}}  </td>
                                                    <td> 
                                                    
                                                    <a  href="{{route('editsubcategory',['id'=>$subcategory->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> edit </a>
                                                    <a onclick="return deleterecord(this);" href="{{route('deletesubcategory',['id'=>$subcategory->id])}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> delete </a>
                                             
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