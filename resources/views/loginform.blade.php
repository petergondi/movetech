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
						<h2>Login to your account</h2>
						<form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('customer_login') }}">
                                                        {{ csrf_field() }}
                            @if($id!='')
                            <input type="hidden" name='id' value="{{$id}}"/>
                            @else
                            <input type="hidden" name='id' value=""/>
                            @endif
							<input type="text" placeholder="Name" name='username'/>
                                                       @if ($errors->has('username'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('username') }}</font>
                                                       </span>
                                                       @endif
							<input type="password" placeholder="Password" name='password' />
                                                       @if ($errors->has('password'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('password') }}</font>
                                                       </span>
                                                       @endif
							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New Customer</h2>
						<form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('customer_register') }}">
                                                        {{ csrf_field() }}
                            
                            @if($id!='')
                            <input type="hidden" name='id' value="{{$id}}"/>
                            @else
                            <input type="hidden" name='id' value=""/>
                            @endif
                            <input type="text" placeholder="Full Name" name='fname' />
                                                       @if ($errors->has('fname'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('fname') }}</font>
                                                       </span>
                                                       @endif
							<input type="text" placeholder="UserName" name='name' />
                                                       @if ($errors->has('name'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('name') }}</font>
                                                       </span>
                                                       @endif
                            <input type="text" placeholder="phonenumber" name='phonenumber' />
                                                       @if ($errors->has('phonenumber'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('phonenumber') }}</font>
                                                       </span>
                                                       @endif
							<input type="email" placeholder="Email Address" name='email'/>
                                                       @if ($errors->has('email'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('email') }}</font>
                                                       </span>
                                                       @endif
                            <input type="text" placeholder="Location" name='location' />
                                                       @if ($errors->has('location'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('location') }}</font>
                                                       </span>
                                                       @endif
                            <input type="text" placeholder="ID NO." name='idno' />
                                                       @if ($errors->has('idno'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('idno') }}</font>
                                                       </span>
                                                       @endif
							<input type="password" placeholder="Password"  name='password'/>
                                                       @if ($errors->has('password'))
                                                           <span class="help-block">
                                                           <font color='red'>{{ $errors->first('password') }}</font>
                                                       </span>
                                                       @endif
                            <input type="password" placeholder="Password Confirmation" name='password_confirmation'/>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

        
@endsection