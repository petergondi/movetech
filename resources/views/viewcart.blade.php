<?php
     use App\Product;                                           
?>
@extends('viewproductslayout')

@section('content')  
 
        <div class='row' >
                    <div class="col-sm-12" >
                    <center><h2> CART  
                    @if($allproducts=='')
                            0 Item(s)
                    @else
                      {{$count}} Item(s)
                    @endif
                    </h2></center>
                    
                                <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                
                                                      <font color='red'>  {{ Session::get('alert-' . $msgfin) }} </font> 
                                                        
                                               
                                                @endif
                                            @endforeach
        
                                            
                                </center>
                            
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Item</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Quantity</th>
                                        <th>Unit/Piece</th>
                                        <th>Sub-Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($allproducts=='')
                           
                                    @else
                                                @foreach($allproducts as $allproduct)
                                                <?php
                                                        $result=Product::where('id',$allproduct->id)->first();
                                                        if($result){
                                                            $imageurl=$result->imageurl;
                                                        }else{
                                                            $imageurl='';
                                                        }
                                                ?>
                                                    <tr>
                                                        <td> 
                                                        @if($imageurl=='')

                                                        @else
                                                            <img  style="width:25%;height:25%" src="{{asset("public/imageupload/".$imageurl)}}" alt="" />
                                                        @endif
                                                        </td>
                                                        <td> {{$allproduct->productname}}-{{$allproduct->modelnumber}} </td>
                                                        <td> {{$allproduct->size}} </td>
                                                        <td> {{$allproduct->color}} </td>
                                                        <td> {{$allproduct->pieces}} </td>
                                                        <td> <b>Ksh {{number_format($allproduct->costperpiece)}} </b></td>
                                                        <td><b> Ksh {{number_format($allproduct->totalcost)}} </b></td>
                                                    </tr>
                                                @endforeach
                                                
                                                <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Sub-Total </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($cachedtotalcost)}} </b></td>
                                                <tr>
                                                <tr>
                                                        <?php
                                                        $taxamount=round((0.16*$cachedtotalcost),2);
                                                        $cap=Auth::user()->cap;
                                                        $balance=Auth::user()->balance;
                                                        if($balance==''){
                                                            $capbalance=$cap-$cachedtotalcost;
                                                            $maxcap=$cap;
                                                        }else{
                                                            $capbalance=$balance-$cachedtotalcost;
                                                            $maxcap=$balance;
                                                        }
                                                        ?>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Tax </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($taxamount)}} </b></td>
                                                <tr>
                                                <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Total </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($cachedtotalcost)}} </b></td>
                                                <tr>
                                                <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Capping </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($maxcap)}} </b></td>
                                                <tr>
                                                <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Balance </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($capbalance)}} </b></td>
                                                <tr>
                                                <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3><div style="background-color:#CC6600;"><center> <a  href="{{route('home')}}" class="btn btn-outline-info"><font color='white'>  Continue Shopping </font> </a>
                                                        </center></div> </td>
                                                        <td colspan=2><div style="background-color:#FE980F;"><center> <a  href="{{route('proceedtocheckout')}}" class="btn btn-outline-info"><font color='white'>Proceed To CheckOut</font> </a>
                                                        </center></div> 
                                                         </td>
                                                <tr>
                                    @endif
                                    </tbody>
                                </table>
                    </div>
        </div>

        
@endsection