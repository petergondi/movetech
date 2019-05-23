	
<?php
use App\Slide;
?>

	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				<?php
					   
					   $firstslide=Slide::orderBy('id','asc')->first();
					   $allslides=Slide::orderBy('id','asc')->take(10)->skip(1)->get();
				   
			   ?>
				

					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
						<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
						@foreach($allslides as $slide)
							
							<li data-target="#slider-carousel" data-slide-to="{{(($slide->id)-1)}}"></li>
						@endforeach	
						</ol>

						<?php
								$slideone=Slide::orderBy('id','asc')->first();
								$slidetwo=Slide::orderBy('id','asc')->skip(1)->first();
								$slidethree=Slide::orderBy('id','asc')->skip(2)->first();
						?>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>4</span>-PAY</h1>
									<h2>{{$firstslide->title}}</h2>
									<p>{{$firstslide->description}}</p>
									<a href="{{route('trendingproductview',['productname'=>urlencode($firstslide->productname),'id'=>$firstslide->id])}}" class="btn btn-default get">View More</a>
								</div>
								<div class="col-sm-6">
								<a href="{{route('trendingproductview',['productname'=>urlencode($firstslide->productname),'id'=>$firstslide->id])}}"><img style="width:100%;height:100%" src="{{asset("imageupload/".$firstslide->imageurl)}}" class="girl img-responsive" alt="" /></a>
									<!-- <img src="{{asset('public/frontend/images/home/pricing.png')}}"  class="pricing" alt="" /> -->
								</div>
							</div>
							@foreach($allslides as $slidetwo)
								<div class="item">
									<div class="col-sm-6">
										<h1><span>4</span>-PAY</h1>
										<h2>{{$slidetwo->title}}</h2>
										<p>{{$slidetwo->description}}</p>
										<a href="{{route('trendingproductview',['productname'=>urlencode($slidetwo->productname),'id'=>$slidetwo->id])}}" class="btn btn-default get">View More</a>
									</div>
									<div class="col-sm-6">
									<a href="{{route('trendingproductview',['productname'=>urlencode($slidetwo->productname),'id'=>$slidetwo->id])}}"><img style="width:100%;height:100%" src="{{asset("imageupload/".$slidetwo->imageurl)}}" class="girl img-responsive" alt="" /></a>
										<!-- <img src="{{asset('frontend/images/home/pricing.png')}}"  class="pricing" alt="" /> -->
									</div>
								</div>
							@endforeach	
							<!-- <div class="item">
								<div class="col-sm-6">
								<h1><span>4</span>-PAY</h1>
									<h2>{{$slidethree->title}}</h2>
									<p>{{$slidethree->description}}</p>
									<a href='' class="btn btn-default get">View More</a>
								</div>
								<div class="col-sm-6">
									<img style="width:100%;height:100%" src="{{asset("imageupload/".$slidethree->imageurl)}}" class="girl img-responsive" alt="" />
									 -->
									<!-- <img src="{{asset('public/frontend/images/home/pricing.png')}}"  class="pricing" alt="" /> -->
								<!-- </div>
							</div> -->
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->