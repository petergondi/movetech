
                        <?php
							use App\Category;
							use App\Subcategory;
						?>
@extends('viewproductslayout')
@section('content')  
   
                <div class='row' >
                    <div class="col-sm-3" >
                        <h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
								@foreach($leftcategories as $leftcategory)
									<?php
									$leftcategorys=$leftcategory->category;
									$id=$leftcategory->id;
									$subcategorycheck=Subcategory::where('category',$leftcategorys)->first();
									$subcategories=Subcategory::where('category',$leftcategorys)->get();			
									?>
									@if($subcategorycheck)
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordian" href="{{'#'.$id}}">
															<span class="badge pull-right"><i class="fa fa-plus"></i></span>
															{{$leftcategorys}}
														</a>
													</h4>
												</div>
												<div id="{{$id}}" class="panel-collapse collapse">
													<div class="panel-body">
														<ul>
														@foreach($subcategories as $subcategory)
															<li><a href="{{route('subcategory',['category'=>urlencode($subcategory->category),'subcategory'=>urlencode($subcategory->subcategory)])}}">{{$subcategory->subcategory}} </a></li>
														@endforeach
														</ul>
													</div>
												</div>
											</div>
									@else
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title"><a href="{{route('category',['category'=>urlencode($leftcategory->category)])}}">{{$leftcategory->category}}</a></h4>
												</div>
											</div>
									@endif
									
									
										
							@endforeach
						
						</div><!--/category-products-->
                    </div>
                    <div class="col-sm-9" >
                            <div class="row" >
                                       <div class="col-sm-7" >
                                            <div class="row" >
                                                <div  class="col-sm-4" ><center>
                                                <br><br><br><img style="height:400px;width:250px;margin-left:120px;" src="{{asset("imageupload/".$products->imageurl)}}" alt="" />
                                                    </center>
                                                </div>
                                                <div  class="col-sm-8" >
                                                    <img style="padding-left: 10px;padding-right: 10px;height:100%;width:100%;padding-top: 10px;padding-bottom: 10px;" src="{{asset("public/imageupload/".$products->imageurl)}}" alt="" />
                                                </div>
                                            </div>
                                       </div>
                                       <div   class="col-sm-5" >

                                            <font style="font-size:17px"><p><b>{{$products->productname}}</b></p></font>
                                            <hr>
                                            <font style="font-size:13px"><p><b>Key Features</b></p></font>
                                                <?php
                                                    $productfeatures = explode(",", $products->productfeatures);
                                                    $previuscost=$products->previuscost;
                                                    $productdescription=$products->productdescription;
                                                ?>
                                                <font style="font-size:13px"><p>: {{$products->modelnumber}}</p></font>
                                                @foreach($productfeatures as $productfeature)
                                                    <font style="font-size:13px"><p>: {{$productfeature}}</p></font>

                                                @endforeach

                                                @if($productdescription=='')

                                                @else
                                                  
                                                   <font style="font-size:13px"><p>: {{$productdescription}}</p></font>
                                                @endif
                                                
                                                
						                        <form action="#" >
                                                <input type="hidden" name='idd' id='idd' value="{{$products->id}}"/>
                                                <div class="row" >
                                                    <div  class="col-sm-2" >
                                                        <font style="font-size:13px;"><p><b>Size:</b></p></font> 
                                                    </div>
                                                    <div  class="col-sm-4" >
                                                        <input type="text" name='size' id='size' />
                                                    </div>
                                                </div>
                                                <div class="row" >
                                                    <div  class="col-sm-2" >
                                                        <font style="font-size:13px;"><p><b>Color:</b></p></font> 
                                                    </div>
                                                    <div  class="col-sm-4" >
                                                        <input type="text" name='color' id='color' />
                                                    </div>
                                                </div>
                                                
                                                <div class="row" >
                                                    <div  class="col-sm-2" >
                                                        <font style="font-size:13px;"><p><b>Pieces:</b></p></font> 
                                                    </div>
                                                    <div  class="col-sm-4" >
                                                        <input type="text" name='pieces' id='pieces' />
                                                    </div>
                                                </div>
                                                
                                                </form>
                                                  <div class="row" >
                                                    <div  class="col-sm-2" >
                                                        <font style="font-size:13px;"><p><b>Instock:{{$products->productcount}}</b></p></font> 
                                                    </div>
                                                </div>
                                                
                                            <hr>
                                            <div class="row" >
                                                <div  class="col-sm-4" >

                                                    <font style="font-size:17px"><p><b>Ksh {{number_format($products->currentcost)}}</b></p></font>
                                                    <strike><font style="font-size:13px"><p>
                                                                        @if($previuscost!='')
                                                                            Ksh   {{number_format($previuscost)}}
                                                                        @else
                                                                            Ksh 1000
                                                                        @endif
                                                    </p></font></strike>
                                                      <a href="/share">share</a>
                                                </div>
                                                <div  class="col-sm-4" >
                                                    
                                                </div>
                                                <div  class="col-sm-4" >
                                                    <a onclick="addtocart({{$products->id}})" style="background-color:#FE980F;" class="btn btn-default add-to-cart"><font style="color:white;font-size:20px"><i class="fa fa-shopping-cart"></i>Add to cart</font></a>
                                                   
                                                </div>
                                            </div>
                                       </div>
                            </div>
                    </div>
                </div>
              

                
                <div class='row' >
                    <center><h2>Similar Products </h2></center>
                    <hr>        
                               @foreach($results as $result)
                                       <?php
                                           $previuscost=$result->previuscost;
                                       ?>
                                       <div class="col-sm-3" >
                                           <div class="product-image-wrapper">
                                               <div class="single-products">
                                                   <div class="productinfo text-center">
                                                        <a href="{{route('singleitempick',['productname'=>urlencode($result->productname),'id'=>$result->id])}}"><div> 
                                                            <img src="{{asset("public/imageupload/".$result->imageurl)}}" alt="" />
                                                                
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
                function addtocart(id){
                    var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
                    if (loggedIn){

                        var size=$('#size').val();
                        var color=$('#color').val();
                        var pieces =$('#pieces').val();
                        var idd =id;//$('#idd').val();
                     
                        $.ajax({
                            url:'{{route('addproducttocart')}}',
                            type:'get',
                            data:{size: size,color:color,pieces:pieces,idd:idd},
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