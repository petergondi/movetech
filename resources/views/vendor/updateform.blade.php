@extends('loginlayout')
@section('content')

<!-- Sing in  Form -->
<section class="sign-in" >
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset("/login/images/signin-image.jpg")}}" alt="sing up image"></figure>
                        
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Update Password</h2>
                        
                        <center>           
                            <div class="flash-message" style='color:red'><!--'danger', 'warning', 'success'-->
                                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                    @if(Session::has('alert-' . $msg))
                                    <div class="alert alert-{{ $msg }}" role="alert">
                                        <!-- <p class="alert alert-{{ $msg }}"> -->
                                        {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <!-- </p> -->
                                    </div>
                                    @endif
                                @endforeach
                            </div> <!-- end .flash-message -->
                        </center>

                        <form class="register-form" id="login-form"method="POST" action="{{ route('submit_update_account') }}">
                            {{ csrf_field() }}
                                <input type="hidden" name="token" id="token" value="{{$token}}" />
                            
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="New Password"/>
                                @if ($errors->has('password'))
                                        <span class="help-block">
                                        <font color='red'>{{ $errors->first('password') }}</font>
                                    </span>
                                    @endif
                            </div>


                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password"/>
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Update"/>
                            </div>
                        </form>
                        <div class="social-login">
							<p>Not registered?<a class="btn btn-link" href="{{ route('vendorregister') }}">
											Create new Account
										</a></p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>





@endsection
