@extends('adminlayout')
<link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}">
<script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css')}}"/>
@section('content')   
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header alert alert-success" role="alert">
        <h5 class="modal-title" id="exampleModalLabel">Export All Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-inline">
  <div class="form-group col-3">
     <label for="staticEmail2">From</label>
    <input type="text" class="form-control" name="date" id="date" placeholder="yy/mm/dd">
  </div>
  <div class="form-group col-3">
     <label for="staticEmail2">To</label>
    <input type="text" class="form-control" name="date1" id="date1" placeholder="yy/mm/dd">
  </div>
   <div class="form-group col-3">
     <label for="staticEmail2">File type</label>
    <select class="form-control-sm">
  <option value="" selected="selected">Select</option>
  <option value="2">PDF</option>
  <option value="3">EXCEL</option>
</select>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn  btn-sm btn-secondary" data-dismiss="modal">Close</button>
      <a href="{{route('admin.vendors.export')}}"><button type="button" id="export" class="btn  btn-sm btn-primary"><i class="fa fa-download"></i>Save</button></a>
      </div>
    </div>
  </div>
</div>
<!--endmodal-->
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
 <button type="button" class="btn btn-sm btn-create pull-right bg-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file"></i>Export</button>
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
 var options={
            format: 'yyyy/mm/dd',
            todayHighlight: true,
            autoclose: true,
          orientation: 'top auto'
        };

    $('#date').datepicker(options);
    $('#date1').datepicker(options);
    $('#export').on('click', function(e) {
    e.preventDefault();
       var from = $('#date').val();
       var to = $('#date1').val();
       var type = $('#type').val();
       $.ajax({
           type: "get",
           url:'{{URL::to('admin/vendors/export')}}',
           data: {from:from, to:to,type:type,_token: '{!! csrf_token() !!}'},
          xhrFields: {
                responseType: 'blob'
            },
            success: function (response, status, xhr) {
           var filename = "";                   
                var disposition = xhr.getResponseHeader('Content-Disposition');

                 if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                } 
                var linkelem = document.createElement('a');
                try {
                    var blob = new Blob([response], { type: 'application/octet-stream' });                        

                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);

                        if (filename) { 
                            // use HTML5 a[download] attribute to specify filename
                            var a = document.createElement("a");

                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                window.location = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.location = downloadUrl;
                        }
                    }   

                } catch (ex) {
                    console.log(ex);
                } 
        }
        });
       });
</script>
        
@endsection