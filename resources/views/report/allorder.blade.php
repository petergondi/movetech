@extends('adminlayout')
@extends('report.base')
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
    <select id="type" class="form-control-sm">
  <option value="pdf">PDF</option>
  <option value="csv">CSV</option>
</select>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn  btn-sm btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" id="export" class="btn  btn-sm btn-primary"><i class="fa fa-download"></i>Save</button>
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
                                        <strong class="card-title">ALl Cart Order</strong>
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
                                                    <th>Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                    <th>Location</th>
                                                    <th>Total Cost</th>
                                                    <th>Status</th>
                                                    <th>Date of Payment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($results as $result)
                                                <tr>
                                                    <td> {{$result->id}} </td>
                                                    <td> {{$result->datetime}}  </td>
                                                    <td> {{$result->customername}}  </td>
                                                    <td> {{$result->phonenumber}} </td>
                                                    <td> {{$result->email}}  </td>
                                                    <td> {{$result->location}}  </td>
                                                    <td> {{$result->totalcost}}  </td>
                                                    <td> {{$result->status}}  </td>
                                                    <td>  </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan='9'> 
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
    $('#export').on('click', function(e) {
    e.preventDefault();
       var from = $('#date').val();
       var to = $('#date1').val();
       var type = $('#type').val();
       $.ajax({
           type: "get",
           url:'{{URL::to('admin/all-order/export')}}',
           data: {from:from, to:to,type:type,_token: '{!! csrf_token() !!}'},
           success:function(data){
            $('#date').val("");
            $('#date1').val("");
            var blob=new Blob([data]);
    var link=document.createElement('a');
    link.href=window.URL.createObjectURL(blob);
    link.download="all-orders.csv";
    link.click();
        }
        });
       });

</script>
        
@endsection