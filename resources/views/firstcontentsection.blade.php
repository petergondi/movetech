<?php

use Illuminate\Support\Facades\Cache;

use App\Subcategory;
use App\Product;
?>


                                <?php 
                                    
                                    if (Cache::has('trendingproducts')){
                                        Cache::forget('trendingproducts');
                                        $producties=Product::where('username','4PAY')->where('category','Trending This Week')->orderBy('id','disc')->take(8)->get();
                                        Cache::put('trendingproducts', $producties, 10);
                                        $trendingproducts =Cache::get('trendingproducts');
                                    } else {
                                        
                                       $producties=Product::where('username','4PAY')->where('category','Trending This Week')->orderBy('id','disc')->take(8)->get();
                                        Cache::put('trendingproducts', $producties, 10);//in minutes 10.
                                        $trendingproducts =Cache::get('trendingproducts');
                                    }
                                      
                                ?>
				
				<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Trending This Week</h2>

						<div class='row' >
							@foreach($trendingproducts as $product)
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
						
						
					</div><!--features_items-->