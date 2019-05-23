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
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css">
<script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js"></script>
@section('content')  
 
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
                              <button class="btn btn-primary" type="submit">Pay Next Installment</button>
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