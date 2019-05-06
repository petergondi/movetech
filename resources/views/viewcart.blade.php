<?php
     use App\Product;                                           
?>
@extends('viewproductslayout')

@section('content')  
<script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css')}}"/>
 
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
                                        <th>Remove</th>
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
                                                          <td><b>{{number_format($allproduct->id)}} </b></td>
                                                         <td><button class="btn btn-danger btn-xs remove" data-id="{{$allproduct->id}}" data-title="remove" data-toggle="modal" data-target="#remove" ><span class="glyphicon glyphicon-remove"></span></button></td>
                                                    </tr>
                                                @endforeach
                                                
                                                <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Sub-Total </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($cachedtotalcost)}} </b></td>
                                                <tr>
                                                 <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td colspan=3> <center>Admin Fee </center> </td>
                                                        <td colspan=2> <b>Ksh {{number_format($adminfee)}} </b></td>
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
        <script>
          $(".remove").click(function(){
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var tr = $(this).closest('tr');
        var confirmation = confirm("are you sure you want to remove this item from cart?");
        //if ( confirm("Do you want to Delete?")) {
    // If you pressed OK!";
     if (confirmation) {

        $.ajax(
        {
            type: 'get',
           url:'{{URL::to('remove')}}',
            data: {id:id,_token: '{!! csrf_token() !!}'},
            success: function (data)
          {
               //$('#del').text(data.totalcost);
               console.log(data);
                tr.fadeOut(1000, function(){
                        $(this).remove();
                    });
            },
        });
         }
    });
        </script>

        
@endsection