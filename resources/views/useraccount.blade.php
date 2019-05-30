<?php
     use App\Product;                                           
?>
@extends('account')
<style>
.checkoutform{
    border: 1px solid #FE980F;
    padding-left: 60px;
    padding-right: 60px;
}
</style>
  <link rel="stylesheet" href="{{asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css')}}">
	<script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js')}}"></script>
	<script src="{{asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js')}}"></script>
@section('content')  
 <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subsequent Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><button type="button" class="btn btn-sm btn-secondary pull-right" data-dismiss="modal">Close</button></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="usr">Enter Mpesa Confirmation Code:</label>
          <input type="text" class="form-control" id="code" placeholder="MFDHSXXXXXX" required/>
        </div>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-sm btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
        <div class='row' >
                    <div class="col-sm-12" >
                            <center><h2>Payment Details</h2></center>
                            <div class="col-sm-2" >
                            </div>
                            <div class="col-sm-8" >
                            <div class="checkoutform" >
                                <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                
                                                      <font color='red'>  {{ Session::get('alert-' . $msgfin) }} </font> 
                                                @endif
                                            @endforeach          
                                </center>
                                <br><br>
                                <h4 class="fa fa-user">Name:<font color="green"> {{$user}}</font></h4><br/>
                              <h4 class="fa fa-money">Amount Paid:<font color="green"> ksh.{{$amount}}</font></h4><br/>
                              <h4 class="fa fa-money">Total Cost:<font color="red"> ksh.{{$total}}</font></h4><br/>
                              <h4 class="fa fa-money">Remaining Due Amount:<font color="red"> ksh.{{$total_not_paid}}</font></h4>
                              <h3>
                              <font color="green"> Remaining amount should be Paid after every two weeks. using paybill <b>483473</b>
                              </font></h4>
                            <a href="{{route('subsequentpay')}}"><button class="btn btn-primary"  >Mae Payment Next Installment</button></a>
                                <br><br>  
                                                <table class="table table-dark bg-primary">
                                                <thead>
                                                        <tr>
                                                          <th  scope="col">Schedule</th>
                                                          <th  scope="col">Date</th>
                                                          <th  scope="col">Amount</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        @foreach($next_payments as $payment)
                                                        <tr>
                                                        <td>{{$payment->schedule}} Payment</td>
                                                        <td>{{$payment->date}}</td>
                                                        <td>Ksh.{{$payment->amount}}</td>
                                                        </tr>
                                                        @endforeach
                                                      </tbody>
                                                    </table>
                            
                              <?php
                              $products=App\Cart::where('cartorder',$payment->CartNo)->get();
                              ?>
                                <a  class="list-group-item list-group-item-action active">
                                {{count($products)}} Products 
                                  </a>
                              <ul class="list-group">
                                @foreach ($products as $product)
                                <li class="list-group-item disabled">{{$product->productname}}</li>
                                @endforeach
                                </ul>
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
