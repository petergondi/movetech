                        <?php
							use App\Category;
							use App\Subcategory;
							use Illuminate\Support\Facades\Cache;
						?>
<header id="header"><!--header-->
<?php
							$allproducts = Cache::get('cartproducts');
							if($allproducts){
								$count=count($allproducts);
							}else{
								$count=0;
							}
							
						?>
		@if( Auth::check() )
			<div class="header-middle"><!--header-middle-->
				<div class="container">
					<div class="row">
						<div class="col-sm-7">
							<div class="logo pull-left">
								<a href="{{route('home')}}"><img src="{{asset('frontend/images/home/logo.png')}}" alt="" /></a>
							</div>
							
							<div class="btn-group pull-right">
								<form action="#" class="searchform">
									<div class="btn-group">
										
											<input type="text" placeholder="Search" />
											
									</div>
									<div class="btn-group">
										<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
										
									</div>
								</form>
								
							</div>
							
						</div>
						<div class="col-sm-5">
						
							<div class="shop-menu pull-right">
								<ul class="nav navbar-nav">
									<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
									<!-- <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li> -->
									<li><a href="{{route('proceedtocheckout')}}"><i class="fa fa-crosshairs"></i> Checkout</a></li>
									<li><a href="{{route('viewcart')}}"><i class="fa fa-shopping-cart"></i> Cart({{$count}})</a></li>
									<li><a href="{{route('customer_logout')}}"><i class="fa fa-lock"></i> Logout</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				
			</div><!--/header-middle-->

		@else
			<div class="header-middle"><!--header-middle-->
				<div class="container">
					<div class="row">
						<div class="col-sm-7">
							<div class="logo pull-left">
								<a href="{{route('home')}}"><img src="{{asset('frontend/images/home/logo.png')}}" alt="" /></a>
							</div>
							
							<div class="btn-group pull-right">
								<form action="" class="searchform">
									<div class="btn-group">
										
											<input type="text" placeholder="Search" />
											
									</div>
									<div class="btn-group">
										<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
										
									</div>
								</form>
								
							</div>
							
						</div>
						<div class="col-sm-5">
							<div class="shop-menu pull-right">
								<ul class="nav navbar-nav">
									<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
									<!-- <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li> -->
									<li><a href="{{route('proceedtocheckout')}}"><i class="fa fa-crosshairs"></i> Checkout</a></li>
									<li><a href="{{route('viewcart')}}"><i class="fa fa-shopping-cart"></i> Cart({{$count}})</a></li>
									<li><a href="{{route('show_loginform')}}"><i class="fa fa-lock"></i> Login</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				
			</div><!--/header-middle-->
		@endif

	<div class="zigzagline"></div>
	</header><!--/header-->