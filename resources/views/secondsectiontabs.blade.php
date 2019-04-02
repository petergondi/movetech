<div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								
								@foreach($categorys as $category)
								<?php $categoryname=$category->category;?>
								<li ><a href="{{$categoryname}}" data-toggle="tab">{{$categoryname}}</a></li>	
								@endforeach
								
								<!-- <li><a href="#blazers" data-toggle="tab">Blazers</a></li>
								<li><a href="#sunglass" data-toggle="tab">Sunglass</a></li>
								<li><a href="#kids" data-toggle="tab">Kids</a></li>
								<li><a href="#poloshirt" data-toggle="tab">Polo shirt</a></li> -->
							</ul>
						</div>
						<div class="tab-content">
						@foreach($categorys as $category)
							<?php $categoryname=$category->category;?>
							<div class="tab-pane fade active in" id="{{$categoryname}}" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('public/frontend/images/home/gallery1.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo uuu Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
											
										</div>
									</div>
								</div>
								
							</div>
							
							@endforeach
						</div>
					</div><!--/category-tab-->