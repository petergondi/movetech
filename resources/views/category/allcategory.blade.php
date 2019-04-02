@extends('adminlayout')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Category</strong>
                                        
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
                                                    <th>Priority</th>
                                                    
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submit_category') }}">
                                                        {{ csrf_field() }}
                                                    <td> New </td>
                                                    <td>
                                                        <input type="text" id="category" name="category" value="{{ old('category') }}">
      
                                                        @if ($errors->has('category'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('category') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>  </td>
                                                    <td>  
                                                    <button class="btn btn-outline-primary btn-sm" type="submit">Add</button>
                                                
                                                    </td>
                                                    </form>
                                                </tr>
                                                @foreach($categorys as $category)
                                                <tr>
                                                    <td> {{$category->id}} </td>
                                                    <td> {{$category->category}}  </td>
                                                    <td> ({{$category->priority}})  </td>
                                                    <td>  

                                                    <a  href="{{route('editcategory',['id'=>$category->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> edit </a>
                                                    <a onclick="return deleterecord(this);" href="{{route('deletecategory',['id'=>$category->id])}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> delete </a>
                                             <a  data-toggle="modal" data-target="#mediumModal" onclick="showform({{$category->id}})" class="btn btn-outline-danger btn-sm"><i class="fa fa-lightbulb-o"></i> update priority </a>
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

            
            <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Priority (Stars)</h5>
                            <a  href='{{route("categorysettings")}}'  class="close"  aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal " name="form1"  method="post" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id" >
                                    <div class="row">
                                        <div class="col-2"> </div>
                                        <div class="col-6">
                                            <input name="priority" id="priority"  class="form-control">
                                        </div>
                                        <div class="col-2">
                                            <button onclick="submitform()" type="button" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div class="col-2">
                                        
                                            <div class="overlay" style="display:none">
                                                <div id="loading-img"> <center><img alt=""  src="{{asset("/img/4.gif")}}"></center>

                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>

                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>


            <script>

            function showform(id){
                var el_t = document.getElementById('id');
                el_t.value = id;
            }

            $('#priority').on('input', function (event) { 
                this.value = this.value.replace(/[^0-9.]/g, '');
                });

                function submitform(){
                    var priority = $('#priority').val();
                    var id = $('#id').val();
                    $(".overlay").show();
                    $.ajax({
                        url:'{{route('categoryupdated_priority')}}',
                        type:'get',
                        data:{priority: priority,id:id},
                        success:function(data) {
                            $(".overlay").hide();

                            if(data.error){
                                alert('Priority cannot be Empty.')
                            }else{
                                alert('Success')
                            }

                            

                        },
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