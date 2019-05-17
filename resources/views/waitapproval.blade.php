<?php
     use App\Product;                                           
?>
@extends('account')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{('http://code.jquery.com/jquery-3.3.1.min.js')}}">
      </script>
      <script src="{{asset('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js')}}"></script>
<style>
.checkoutform{
    border: 1px solid #FE980F;
    padding-left: 60px;
    padding-right: 60px;
}
</style>
@section('content')  
<!-- Modal -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Payment Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <center>
            <div class="panel panel-default alert alert-info">
                <div class="panel-body"> 
                  Your Payment Has been Processed Please 
                check your <a href="{{route('account')}}">Account</a> to check your next date of payment
                </div>
              </div>
              <a href="{{route('account')}}"><button type="button" class="fa fa-check-circle bg-primary">OK</button></a>
         </center>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>
 
        <div class='row' >
                    <div class="col-sm-12" >
                            <center><h2>Please Wait for Your payment to be processed...</h2></center>
                            
                                                
                                                <div class="row" >
                                                    <div  class="col-sm-4" >
                                                        
                                                    </div>
                                                </div>
                                    </div>
                            </div>
                            <div class="col-sm-2" >
                            </div>                        
                    </div>
        </div>
@endsection
<script>
(function poll() {
  setTimeout(function(){
  $.getJSON('order', function (response) {
    if (response.state=="success") {
      $('#confirm').modal('show');
    }
    else if(response.state=="timeout"){
      window.location.href = "/check-out";
    }
    setTimeout(poll, 15000);
  });
}, 15000);
}());
  </script>