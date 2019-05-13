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
                                <h4 class="fa fa-money bg-primary">Amount Paid:<font color="green"> ksh.400</font></h4><br/>
                                <h4 class="fa fa-money bg-primary">Remaining Amount:<font color="red"> ksh.800</font></h4>
                              <h5 >
                              <font color="green"> Remaining amount should be Paid after every two weeks. using paybill <b>483473</b>
                              </font></h5>
                                <br><br>  
                                                <table class="table">
                                                <thead>
                                                        <tr>
                                                          <th scope="col">Schedule</th>
                                                          <th scope="col">Date</th>
                                                          <th scope="col">Amount</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr>
                                                          <th scope="row">Next payment</th>
                                                          <td>122</td>
                                                        <td>433</td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
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