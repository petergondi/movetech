<?php

use Illuminate\Support\Facades\Cache;

use App\Subcategory;
use App\Product;
?>

					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">New Items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
								<?php 
                                    
                                    if (Cache::has('trendingproducts')){
                                        Cache::forget('trendingproducts');
                                        $producties=Product::where('username','4PAY')->where('category','New')->orderBy('id','asc')->take(4)->get();
                                        Cache::put('trendingproducts', $producties, 10);
                                        $newproducts =Cache::get('trendingproducts');
                                    } else {
                                        
                                       $producties=Product::where('username','4PAY')->where('category','New')->orderBy('id','asc')->take(4)->get();
                                        Cache::put('trendingproducts', $producties, 10);//in minutes 10.
                                        $newproducts =Cache::get('trendingproducts');
                                    }
                                      
                                ?>
									
							@foreach($newproducts as $product)
                                        <?php
                                            $previuscost=$product->previuscost;
                                        ?>
									<div class="col-sm-3" >
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        
                                                       <img src="{{asset("public/imageupload/".$product->imageurl)}}" alt="" />
                                                          
                                                        <h2>Ksh {{number_format($product->currentcost)}}&nbsp;&nbsp;
                                                            <strike><font style="font-size:10px" color='black'> 
                                                                @if($previuscost!='')
                                                                    {{number_format($previuscost)}}
                                                                @else

                                                                @endif
                                                                </font>
                                                            </strike></h2>
                                                              
                                                        <p><b>{{$product->productname}}</b></p>
                                                        <!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                     -->
                                                    </div>
                                                    <a href="{{route('trendingproductview',['productname'=>urlencode($product->productname),'id'=>$product->id])}}"><div class="product-overlay ">
                                                        <div class="overlay-content">
                                                             
                                                    
                                                        </div>
                                                    </div></a>
                                                    
                                                </div>
                                            </div>
                                        </div>
							
							@endforeach
									
								</div>

								<div class="item ">
								<?php 
                                    
                                    if (Cache::has('trendingproducts')){
                                        Cache::forget('trendingproducts');
                                        $producties=Product::where('username','4PAY')->where('category','New')->orderBy('id','asc')->take(4)->skip(4)->get();
                                        Cache::put('trendingproducts', $producties, 10);
                                        $newproducts =Cache::get('trendingproducts');
                                    } else {
                                        
                                       $producties=Product::where('username','4PAY')->where('category','New')->orderBy('id','asc')->take(4)->skip(4)->get();
                                        Cache::put('trendingproducts', $producties, 10);//in minutes 10.
                                        $newproducts =Cache::get('trendingproducts');
                                    }
                                      
                                ?>
									
							@foreach($newproducts as $product)
                                        <?php
                                            $previuscost=$product->previuscost;
                                        ?>
									<div class="col-sm-3" >
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        
                                                       <img src="{{asset("public/imageupload/".$product->imageurl)}}" alt="" />
                                                          
                                                        <h2>Ksh {{number_format($product->currentcost)}}&nbsp;&nbsp;
                                                            <strike><font style="font-size:10px" color='black'> 
                                                                @if($previuscost!='')
                                                                    {{number_format($previuscost)}}
                                                                @else

                                                                @endif
                                                                </font>
                                                            </strike></h2>
                                                              
                                                        <p><b>{{$product->productname}}</b></p>
                                                        <!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                     -->
                                                    </div>
                                                    <a href="{{route('trendingproductview',['productname'=>urlencode($product->productname),'id'=>$product->id])}}"><div class="product-overlay ">
                                                        <div class="overlay-content">
                                                             
                                                    
                                                        </div>
                                                    </div></a>
                                                    
                                                </div>
                                            </div>
                                        </div>
							
							@endforeach
									
								</div>

								
								
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->