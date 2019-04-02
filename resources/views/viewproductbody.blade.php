@extends('viewproductslayout')

@section('content')  
   
                <div class='row' >
                               
                               @foreach($results as $result)
                                       <?php
                                           $previuscost=$result->previuscost;
                                       ?>
                                       <div class="col-sm-3" >
                                           <div class="product-image-wrapper">
                                               <div class="single-products">
                                                   <div class="productinfo text-center">
                                                        <a href="{{route('singleitempick',['productname'=>urlencode($result->productname),'id'=>$result->id])}}"><div> 
                                                            <img src="{{asset("imageupload/".$result->imageurl)}}" alt="" />
                                                                
                                                            <h2>Ksh {{number_format($result->currentcost)}}&nbsp;&nbsp;
                                                                <strike><font style="font-size:10px" color='black'> 
                                                                    @if($previuscost!='')
                                                                        {{number_format($previuscost)}}
                                                                    @else

                                                                    @endif
                                                                    </font>
                                                                </strike></h2>
                                                                    
                                                            <p><b>{{$result->productname}}</b></p>
                                                            <p><font color='blue'><b>{{$result->bussinessname}}</b> </font></p>
                                                        </div> </a>
                                                       <hr>
                                                       <a onclick="addtocartone({{$result->id}})" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                   
                                                   </div>
                                                   
                                                   
                                               </div>
                                           </div>
                                       </div>
                                  
                               @endforeach
                               
                              
                </div>

        <script>

function addtocartone(id){
    var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
    if (loggedIn){

        var size='';
        var color='';
        var pieces =1;
     
        $.ajax({
            url:'{{route('addproducttocart')}}',
            type:'get',
            data:{size: size,color:color,pieces:pieces,idd:id},
            success:function(data) {
               // $('#pleaseWaitDialog').modal('hide');
                
                    if(data.error){
                          alert(data.error)
                    }
            
               
            },
        });
    }else{
        
        let url = "{{ route('getloginusercapping', 'id') }}";
        url = url.replace('id', id);
        document.location.href=url;
    }

}

</script>
        
@endsection