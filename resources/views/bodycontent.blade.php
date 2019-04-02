<?php

use Illuminate\Support\Facades\Cache;

use App\Subcategory;
use App\Product;
?>

				<?php 
					
						//$categorys =Cache::get('category');
					
				?>
<hr>
			<div class="row" >
				<div class="col-sm-3" >
						<div class="brands_products"><!--brands_products-->
							<hr>
                            <h2>{{$category->category}}</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
                                <?php 
                                    $categoryname=$category->category;
                                    if (Cache::has($categoryname)){
                                        $subcategorys =Cache::get($categoryname);
                                    } else {
                                        
                                       $subcategories=Subcategory::where('category',$categoryname)->orderBy('subcategory','asc')->get();
                                        Cache::put($categoryname, $subcategories, 10);//in minutes 10.
                                        $subcategorys =Cache::get($categoryname);
                                    }
                                      
								?>
                                @foreach($subcategorys as $subcategory)
                                    <li><a href="{{route('subcategory',['category'=>urlencode($subcategory->category),'subcategory'=>urlencode($subcategory->subcategory)])}}"> {{$subcategory->subcategory}}</a></li>	
                                @endforeach
                                
								</ul>
							</div>
						</div><!--/brands_products-->
                    
				</div>
				<div class="col-sm-9">
                    
                                <?php 
                                    $categoryname=$category->category;
                                    
                                    if (Cache::has('products')){
                                        
                                        $producties=Product::where('username','4PAY')->where('category',$categoryname)->groupBy('subcategory')->orderBy('id','asc')->take(8)->get();
                                        Cache::put('products', $producties, 10);
                                        $products =Cache::get('products');
                                    } else {
                                        
                                       $producties=Product::where('username','4PAY')->where('category',$categoryname)->groupBy('subcategory')->orderBy('id','asc')->take(8)->get();
                                        Cache::put('products', $producties, 10);//in minutes 10.
                                        $products =Cache::get('products');
                                    }
                                      
                                ?>
                                 
                                <div class='row' >
                               
                                @foreach($products as $product)
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
			</div>