@extends('adminlayout')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ asset('public/style/js/cropie.js')}}"></script>

<style>
   

</style>
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Slide Products</strong>
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
                                                    <th>Image</th>
                                                    <th>Product Name</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <form  name="form1" id='form1' class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('admin4slides_images') }}">
                                                            {{ csrf_field() }}
                                                            @if($result)
                                                                <input type="hidden" id="id" value="{{ $result->id }}" name="id" >
                                                            @else
                                                                <input type="hidden" id="id" value="{{ old('id') }}" name="id" >
                                                            @endif

                                                    <td></td>
                                                    <td>
                                                                                @if($result) 
                                                                                    <img style="width:90%;height:90%" src="{{asset("/imageupload/".$result->imageurl)}}"  alt="No Image">
                                                                            
                                                                                @else
                                                                                    
                                                                                @endif

                                                                                <input style="border:none"  class="form-control" type="file" name="imageurl" >
                                                
                                                
                                                                            <small class="form-text text-muted">
                                                                            
                                                                                @if ($errors->has('imageurl'))
                                                                                        <span class="help-block">
                                                                                            <font color='red'>{{ $errors->first('imageurl') }}</font>
                                                                                        </span>
                                                                                @endif
                                                                            
                                                                            </small>
                                                    </td>
                                                    <td>
                                                                    @if($result)  
                                                                        <textarea cols=20 rows=3 id="productname" name="productname" >{{ $result->productname }}</textarea>
                                                                    @else
                                                                        <textarea cols=20 rows=3 id="productname" name="productname" ></textarea>
                                                                    @endif
                                                    
                                                    </td>
                                                    <td>
                                                                    @if($result)  
                                                                        <textarea cols=20 rows=3 id="title" name="title" >{{ $result->title }}</textarea>
                                                                    @else
                                                                        <textarea cols=20 rows=3 id="title" name="title" ></textarea>
                                                                    @endif
                                                    
                                                    </td>
                                                    <td>
                                                                    @if($result)  
                                                                        <textarea cols=20 rows=3 id="description" name="description" >{{ $result->description }}</textarea>
                                                                    @else
                                                                        <textarea cols=20 rows=3 id="description" name="description" ></textarea>
                                                                    @endif
                                                    
                                                    </td>
                                                    <th>
                                                    
                                                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                                        <i class="fa fa-lock fa-lg"></i>&nbsp;
                                                                        <span id="payment-button-amount">Update</span>
                                                                            
                                                                    </button>
                                                    
                                                    </th>

                                                    </form>
                                                </tr>
                                                @foreach($results as $result)
                                                <tr>
                                                    <td> {{$result->id}} </td>
                                                    <td> <img style="width:90%;height:90%" src="{{asset("/imageupload/".$result->imageurl)}}"  alt="No Image">  </td>
                                                    <td> {{$result->productname}} </td>
                                                    <td> {{$result->title}} </td>
                                                    <td> {{$result->description}}  </td>
                                                    <td> 
                                                        <a  href="{{route('admineditslideproduct',['id'=>$result->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> view </a>
                                                        <a onclick="return deleterecord(this);" href="{{route('admindeleteslideproduct',['id'=>$result->id])}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> delete </a>
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
           
                function categorychange(){

                    var sto=document.getElementById("subcategory");
                    for(var st = sto.options.length - 1 ; st >= 0 ; st--)
                    {
                        sto.remove(st);
                    }
                    var s = document.getElementById('category');
                    var category = s.options [s.selectedIndex] .value;

                    var select = document.getElementById("subcategory");
                        $.ajax
                        ({
                                url: '{{ route('admingetsubcategory') }}',
                                type:'get',
                                data: {category:category},
                                success: function(data)
                                {   
                                   
                                                var myobject = data['subcategorys'];
                                                for(index in myobject) {
                                                    select.options[select.options.length] = new Option(myobject[index], myobject[index]);
                                                }
                                        
                                }
                         });

                }

                function deleterecord() {
                    if (confirm("Delete This Record")) {
                        $('#pleaseWaitDialog').modal('show');
                    } else {
                        return false;
                    }
                }

              

            </script>
        
@endsection