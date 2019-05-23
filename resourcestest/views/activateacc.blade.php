@extends('viewproductslayout')

@section('content')  
   
<section id="form"><!--form-->
		<div class="container">
			<div class="row">

                                        <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                
                                                      <font color='red'>  {{ Session::get('alert-' . $msgfin) }} </font> 
                                                        
                                               
                                                @endif
                                            @endforeach
        
                                            
                                        </center>

				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Activate your account</h2>
						<form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('customer_activateacc') }}">
                                                        {{ csrf_field() }}
                            <input type="hidden" name='id' value="{{$id}}"/>
                            <input type="hidden" name='name' value="{{$name}}"/>
							<input type="text" placeholder="SMS Code" name='smstoken'/>
                                                       @if ($errors->has('smstoken'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('smstoken') }}</font>
                                                       </span>
                                                       @endif
							
							<button type="submit" class="btn btn-default">Activate</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

        
@endsection