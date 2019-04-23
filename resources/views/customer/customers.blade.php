@extends('adminlayout')
@section('content')  
<link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}">
<script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css')}}"/> 
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header alert alert-success" role="alert">
        <h5 class="modal-title" id="exampleModalLabel">Export Customers</h5>
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
      <a href="{{route('admin.customers.export')}}"><button type="button" id="export" class="btn  btn-sm btn-primary"><i class="fa fa-download"></i>Save</button></a>
      </div>
    </div>
  </div>
</div>
            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">All Customers</strong>
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
                                                    <th>Full Name</th>
                                                    <th>User Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                    <th>ID NO.</th>
                                                    <th>Location</th>
                                                    <th>Cap</th>
                                                    <th>Balance</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($results as $result)
                                                <tr>
                                                    <td> {{$result->id}} </td>
                                                    <td> {{$result->fname}}  </td>
                                                    <td> {{$result->name}}  </td>
                                                    <td> {{$result->phonenumber}} </td>
                                                    <td> {{$result->email}}  </td>
                                                    <td> {{$result->idno}}  </td>
                                                    <td> {{$result->location}}  </td>
                                                    <td> {{$result->cap}}  </td>
                                                    <td> {{$result->balance}}  </td>
                                                    <td> {{$result->status}}  </td>
                                                    <td>  </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan='5'> 
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
            
            <script>

                        
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
            format: 'mm/dd/yyyy',
            todayHighlight: true,
            autoclose: true,
          orientation: 'top auto'
        };

    $('#date').datepicker(options);
    $('#date1').datepicker(options);

</script>
        
@endsection