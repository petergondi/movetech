@extends('vendorlayout')
@extends('report.base')
@section('content')   
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header alert alert-success" role="alert">
        <h5 class="modal-title" id="exampleModalLabel">All Vendors</h5>
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
      <a href="{{route('admin.all-order.export')}}"><button type="button" id="export" class="btn  btn-sm btn-primary"><i class="fa fa-download"></i>Save</button></a>
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
                                        <strong class="card-title">ALl Orders</strong>
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
                                                    <th>Order No.</th>
                                                    <th>Model No.</th>
                                                    <th>Product Name</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Pieces</th>
                                                    <th>Cost/Piece</th>
                                                    <th>Total Cost</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($results as $result)
                                                <tr>
                                                    <td> {{$result->id}} </td>
                                                    <td> {{$result->datetime}}  </td>
                                                    <td> {{$result->cartorder}}  </td>
                                                    <td> {{$result->modelnumber}} </td>
                                                    <td> {{$result->productname}}  </td>
                                                    <td> {{$result->size}}  </td>
                                                    <td> {{$result->color}}  </td>
                                                    <td> {{$result->pieces}}  </td>
                                                    <td> {{$result->costperpiece}}  </td>
                                                    <td> {{$result->totalcost}}  </td>
                                                    <td> {{$result->status}}  </td>
                                                    <td>  </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan='12'> 
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
       $.ajax({
           type: "get",
           url:'{{URL::to('admin/all-order/export')}}',
           data: {from:from, to:to,_token: '{!! csrf_token() !!}'},
           success:function(data){
            // $('#date').val("");
            //$('#date1').val("");
            console.log(data);
        }
        });
       });

</script>
        
@endsection