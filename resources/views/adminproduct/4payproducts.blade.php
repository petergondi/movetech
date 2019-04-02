@extends('adminlayout')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">4-PAY Products</strong>
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
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Sub-Category</th>
                                                    <th>Current Cost</th>
                                                    <th>Previus Cost</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($results as $result)
                                                <tr>
                                                    <td> {{$result->id}} </td>
                                                    <td> {{$result->productname}}  </td>
                                                    <td> {{$result->category}} </td>
                                                    <td> {{$result->subcategory}}  </td>
                                                    <td> {{$result->currentcost}}  </td>
                                                    <td> {{$result->previuscost}}  </td>
                                                    <td> 
                                                    <a  href="{{route('4payadmineditproduct',['id'=>$result->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> view </a>
                                                    <a onclick="return deleterecord(this);" href="{{route('admin4paydeleteproduct',['id'=>$result->id])}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> delete </a>
                                                    <a  data-toggle="modal" data-target="#mediumModal" onclick="showform({{$result->id}})" class="btn btn-outline-info btn-sm"><i class="fa fa-lightbulb-o"></i> up. cost </a>
                                                         
                                                     </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan='7'> 
                                                                    <center>
                                                                        {{ $results->links('pagination.bootstrap-4') }}
                                                                    </center>
                                                     </td> 
                                                </tr>
                                                
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
                            <h5 class="modal-title" id="mediumModalLabel">New Cost</h5>
                            <a  href='{{route("products_vendor")}}'  class="close"  aria-label="Close">
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
                        url:'{{route('saveupdated_pricecost')}}',
                        type:'get',
                        data:{cost: priority,id:id},
                        success:function(data) {
                            $(".overlay").hide();

                            if(data.errorcost){
                                alert('Cost is Empty.')
                            }else if(data.norecorderror){
                                alert('No Record Was Found.')
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