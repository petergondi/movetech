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
                                    $cachedtotalcost=(0.25*$cachedtotalcost);
                                ?>
                                <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                
                                                      <font color='red'>  {{ Session::get('alert-' . $msgfin) }} </font> 
                                                        
                                               
                                                @endif
                                            @endforeach
        
                                            
                                </center>
                                <br><br>
                               <center> Payamble amount is <b>Ksh {{number_format($cachedtotalcost)}} </b>.
                               Remaining amount should be Paid after every two weeks.<center>
                                <br><br>
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('confirm_order') }}">
                                                        {{ csrf_field() }}
                                                
                                                <div class="row" >
                                                    <div  class="col-sm-4" >
                                                        <font style="font-size:13px;"><p><b>Delivery Location:</b></p></font> 
                                                    </div>
                                                    <div  class="col-sm-6" >
                                                        <input type="text"  class="form-control" name='location' id='location'  value="{{ old('location') }}" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row" >
                                                    <div  class="col-sm-4" >
                                                        
                                                    </div>
                                                    <div  class="col-sm-6" >
                                                    <br><br><button class="btn btn-primary" type="submit">Confirm Order</button>
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