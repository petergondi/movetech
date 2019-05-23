<?php
     use App\Product;                                           
?>
@extends('viewproductslayout')
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
                            <center><h2> Payment   </h2></center>
                            <div class="col-sm-2" >
                            </div>
                            <div class="col-sm-8" >
                            <div class="checkoutform" >
                                <?php
                                 $totalcost=round(0.25*$cachedtotalcost);
                                 if(!($totalcost==$cachedtotalcost)){
                                     $additional=$cachedtotalcost-($totalcost*4);
                                 }
                                 else {
                                     $additional=0;
                                 }
                                 $balances=[$totalcost,$totalcost,($totalcost+$additional)];
                                 $Date1= date("Y-m-d");
                                 $Date2=date('Y-m-d', strtotime($Date1. ' + 14days'));
                                 $Date3=date('Y-m-d', strtotime($Date1. ' + 28days'));
                                 $Date4=date('Y-m-d', strtotime($Date1. ' + 42days'));
                                 $dates=[$Date2,$Date3,$Date4];
                                ?>
                                <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                
                                                      <font color='red'>  {{ Session::get('alert-' . $msgfin) }} </font> 
                                                @endif
                                            @endforeach          
                                </center>
                                <br><br>
                               <center> Payamble amount is <b>Ksh {{number_format($totalcost)}} </b>.
                               Remaining amount should be Paid after every two weeks.<center>
                                <br><br>
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('confirm_order') }}">
                                                        {{ csrf_field() }}
                                                
                                                <div class="row" >
                                                    <div  class="col-sm-4" >
                                                        <font style="font-size:13px;"><p><b>Delivery Location:</b></p></font> 
                                                    </div>
                                                    <div  class="col-sm-6" >
                                                        <input type="text"  class="form-control" name='location' id='location'  value="{{ old('location') }}" required/>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row" >
                                                        <div  class="col-sm-4" >
                                                            <font style="font-size:13px;"><p><b>Amount:</b></p></font> 
                                                        </div>
                                                        <div  class="col-sm-6" >
                                                            <input type="text"  class="form-control" name='amount' id='amount'  value="{{$totalcost}}" required/>
                                                        </div>
                                                    </div>
                                                    <div  class="col-sm-6" >
                                                            <input hidden type="hidden"  class="form-control" name='min' id='min'  value="{{$totalcost}}" required/>
                                                        </div>
                                                <table class="table">
                                                <thead>
                                                        <tr>
                                                          <th scope="col">#</th>
                                                          <th scope="col">Date</th>
                                                          <th scope="col">Amount</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        @foreach($balances as $key=>$balance)
                                                        <tr>
                                                          <th scope="row">Next</th>
                                                          <td>{{$dates[$key]}}</td>
                                                        <td>{{$balance}}</td>
                                                        </tr>
                                                        @endforeach
                                                      </tbody>
                                                    </table>
                                                <div class="row" >
                                                    <div  class="col-sm-4" >
                                                        
                                                    </div>
                                                    <div  class="col-sm-6" >
                                                    <br><br><button class="btn btn-primary" type="submit">confirm</button>
                                                    </div>
                                                </div>
                                                
                                                </form>
                                    </div>
                            </div>
                            <div class="col-sm-2" >
                            </div>                        
                    </div>
        </div>
@endsection