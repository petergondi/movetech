                       <?php
							use App\Category;
							use App\Subcategory;
						?>
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

                        
						<div class="brands_products"><!--brands_products-->
						<hr><h3>Brands</h3>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									@foreach($vendors as $vendor)
										@if($vendor->bussinessaliasname=='')

										@else
											<li><a href="{{route('brands',['bussinessaliasname'=>urlencode($vendor->bussinessaliasname)])}}{{$vendor->name}}"> <span class="pull-right">({{$vendor->priority}})</span>{{$vendor->bussinessaliasname}}</a></li>
										@endif
								    @endforeach
									
								</ul>
							</div>
						</div><!--/brands_products-->

                 
						<div class="shipping text-center"><!--shipping-->
							<img src="{{asset('public/frontend/images/home/e5.png')}}" alt="" />
						</div>
						<!--/shipping-->