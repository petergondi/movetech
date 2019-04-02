@extends('adminlayout')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">All Vendors</strong>
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
                                                    <!-- <th>Bussiness Name</th> -->
                                                    <th>User Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                    <th>Physical Address</th>
                                                    <th>Kra Pin</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vendors as $vendor)
                                                <tr>
                                                    <td> {{$vendor->id}} </td>
                                                    <!-- <td> {{$vendor->bussinessname}}  </td> -->
                                                    <td> {{$vendor->name}}  </td>
                                                    <td> {{$vendor->phonenumber}} </td>
                                                    <td> {{$vendor->email}}  </td>
                                                    <td> {{$vendor->physicaladdress}}  </td>
                                                    <td> {{$vendor->krapin}}  </td>
                                                    <td> ({{$vendor->priority}}) </td>
                                                    <td> {{$vendor->status}}  </td>
                                                     <td>
                                                    <!-- <input type="checkbox"   name="checkbox5" id="checkbox5" onclick = "updatepriority()" /> update priority -->
                                                       
                                                    <a  href="{{route('editvendor',['id'=>$vendor->id])}}" class="badge badge-primary btn-sm"><i class="fa fa-pencil"></i> edit </a>
                                                    <a onclick="return deleterecord(this);" href="{{route('deletevendor',['id'=>$vendor->id])}}" class="badge badge-danger btn-sm"><i class="fa fa-times"></i> delete </a>
                                                        @if($vendor->status!='active')
                                                        <a onclick="return suspendrecord(this);" href="{{route('approvevendor',['id'=>$vendor->id])}}" class="badge badge-success btn-sm"><i class="fa fa-times"></i> approve </a>
                                                        
                                                        @else
                                                        <a onclick="return suspendrecord(this);" href="{{route('suspendvendor',['id'=>$vendor->id])}}" class="badge badge-warning btn-sm"><i class="fa fa-times"></i> suspend </a>
                                                        
                                                        @endif
                                                        <a  href="{{route('viewvendorproducts',['id'=>$vendor->id])}}" class="badge badge-info btn-sm"><i class="fa fa-lightbulb-o"></i> products </a>
                                                        <a  data-toggle="modal" data-target="#mediumModal" onclick="showform({{$vendor->id}})" class="badge badge-info btn-sm"><i class="fa fa-lightbulb-o"></i> update priority </a>
                                                         
                                                         <!-- <a target="_blank" href="{{route('vend_or_login',['name'=>$vendor->name])}}" class="badge badge-secondary btn-sm"><i class="fa fa-magic"></i> login </a>
                                                      -->
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

            <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Priority (Stars)</h5>
                            <a  href='{{route("all_vendors")}}'  class="close"  aria-label="Close">
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
            
            $('#priority').on('input', function (event) { 
                this.value = this.value.replace(/[^0-9.]/g, '');
                });

                function submitform(){
                    var priority = $('#priority').val();
                    var id = $('#id').val();
                    $(".overlay").show();
                    $.ajax({
                        url:'{{route('saveupdated_priority')}}',
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

        function showform(id){
            var el_t = document.getElementById('id');
            el_t.value = id;
        }

                        
        function deleterecord() {
            if (confirm("Delete This Record")) {
                $('#pleaseWaitDialog').modal('show');
            } else {
                return false;
            }
        }

        function suspendrecord(){
            if (confirm("Change Status")) {
                $('#pleaseWaitDialog').modal('show');
            } else {
                return false;
            }
        }

</script>
        
@endsection