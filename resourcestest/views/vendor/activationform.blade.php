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
                        <h2 class="form-title">Activate Account</h2>
                        
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

                        <form class="register-form" id="login-form"method="POST" action="{{ route('submit_vendor_activation') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" id="token" value="{{$token}}" >
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="smstoken" id="smstoken" placeholder="SMS Code"/>
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Submit"/>
                            </div>
                        </form>
                        <div class="social-login">
							<p>Already have an Acc?<a class="btn btn-link" href="{{ route('vendorlogin') }}">
											Click here to login
										</a></p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>





@endsection
