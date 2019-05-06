	<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{('http://code.jquery.com/jquery-3.3.1.min.js')}}">
      </script>
      <script src="{{asset('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js')}}"></script>
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">About Us</a></li>
								<li><a href="">Contact Us</a></li>
								<!-- <li><a href="#">Order Status</a></li> -->
								<!-- <li><a href="#">Change Location</a></li> -->
							 <li><a href="">FAQ’s</a></li> 
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Top Shops</h2>
							<ul class="nav nav-pills nav-stacked">
								
								@foreach($vendors as $vendor)
										@if($vendor->bussinessaliasname=='')

										@else
											<li><a href="{{route('brands',['bussinessaliasname'=>urlencode($vendor->bussinessaliasname)])}}{{$vendor->name}}">{{$vendor->bussinessaliasname}}</a></li>
										@endif
								@endforeach
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>4 PAY  Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Terms of Use</a></li>
								<li><a href="">Privacy Policy</a></li>
								<li><a href="">Refund Policy</a></li>
								<li><a href="">Billing Process</a></li>
								<!-- <li><a href="#">Ticket System</a></li> -->
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">4-Pay Information</a></li>
								<li><a href="">Careers</a></li>
								
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>New to 4-PAY</h2>
							<form action="#" class="searchform">
								<input type="text" id="email" placeholder="Your email address" />
								<button type="submit" id="subscribe" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Subscribe to our communications to receive special offers and latest news!  </p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-right">Copyright © 2018 4 PAY ltd. All rights reserved.</p>
					<!-- <p class="pull-right">Designed by <span><a target="_blank" href="https://www.movetechsolutions.com">movetech</a></span></p> -->
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	<script>
 $('#subscribe').on('click', function(e) {
    e.preventDefault();
       var email = $('#email').val();
       $.ajax({
           type: "POST",
           url:'{{URL::to('subscribe')}}',
           data: {email:email,_token: '{!! csrf_token() !!}'},
           success:function(data){
           alert(data);
        }
       });
   });
</script>