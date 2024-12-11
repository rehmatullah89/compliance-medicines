@extends('layouts.compliance')
@section('content')
<div class="row home-page-container">
	
	<div class="col-sm-6 left-form-col" style="min-height: 600px;">
	  
	    <div class="row" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
			<div class="col-sm-12">
        		<div class="row">
        			<div class="col-sm-12 cnt-center mt-14_">
        				<a class="navbar-brand" href="javascript:void(0);">
        				 <img
        					src="img/home-assets/logo-big.png" style="max-width: 300px;"
        					alt="Site Logo">
        				</a>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-sm-12">
        				<form class="home-login-form elm-center" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" style="max-width: 380px;">
                        @csrf
        					<div class="trow_ mt-40_">
        						<label class="txt-blue weight_600 cnt-left fs-17_">Login Here</label>
        					</div>
        					<div class="trow_ c-dib_ cmp-field_ fld-email_ mt-17_">
        						<!--label class="min-w-100p">Email</label-->
                                <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="min-w-100p{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                <span class="fa fa-user"></span>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
        					</div>
        					<div class="trow_ c-dib_ cmp-field_ fld-password_ mt-7_">
        						<!--label class="min-w-100p">Email</label-->
                                <input id="password" placeholder="{{ __('Password') }}" type="password" class="min-w-100p{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                <span class="fa fa-eye"></span>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

        					</div>
        					<div class="trow_ mt-17_">
        						<div class="elm-left">
        							<a class="btn btn-link pa-force-0_ td_u_ txt-blue" href="{{ route('password.request') }}">Forgot Username/Password</a>
        						</div>
        						<div class="elm-right">
        							<label class="min-w-100p">
                                        <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span style="color: #999999;">{{ __('Remember Me') }}</span>
                                        
                                    </label>
                                    
        						</div>
        					</div>
        					<div class="trow_ cnt-center mt-36_">
        						<button type="submit" class="signin-button site-blue-btn fs-17_">Sign In</button>
        					</div>
        				</form>
        			</div>
        		</div>
        		<div class="row mt-14_">
        			<div class="col-sm-12">
        				<div class="trow_ cnt-center c-dib_ mt-50_">
        					<p style="max-width: 380px; color: #909090;">enroll your most at risk patients to receive convenient and informative messages and activities to support their treatments - while earning valuable rewards from our network of participating providers!</p>
        				</div>
        				<div class="trow_ cnt-center c-dib_ mt-24_">
        					<p style="max-width: 380px; color: #909090;">&copy; 2020 <span class="txt-blue">Compliance Reward</span>. All rights Reserved.</p>
        				</div>
        			</div>
        		</div>
        	</div>
	    </div>
		
	</div>
	<div class="col-sm-6 right-slider-column" style="min-height: 600px;">
	    <div class="row" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
	    	<div class="col-sm-12">
        		<div class="row">
        			<div class="col-sm-12">
            			<div id="home-page-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-interval="2000">
                                	<span class="item-count">1</span>
                                	<img class="d-block w-100" src="img/home-assets/slide-img1.png">
                                </div>
                                <div class="carousel-item" data-interval="2000">
                                	<span class="item-count">2</span>
                                	<img class="d-block w-100" src="img/home-assets/slide-img2.png">
                                </div>
                                <div class="carousel-item" data-interval="2000">
                                	<span class="item-count">3</span>
                                	<img class="d-block w-100" src="img/home-assets/slide-img3.png">
                                </div>
                                <div class="carousel-item" data-interval="2000">
                                	<span class="item-count">4</span>
                                	<img class="d-block w-100" src="img/home-assets/slide-img4.png">
                                </div>
                            </div>
                            <ol class="carousel-indicators">
                                <li data-target="#home-page-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#home-page-carousel" data-slide-to="1"></li>
                                <li data-target="#home-page-carousel" data-slide-to="2"></li>
                                <li data-target="#home-page-carousel" data-slide-to="3"></li>
                            </ol>
                        	<a class="carousel-control-prev" href="#home-page-carousel" role="button" data-slide="prev">
                        		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        		<span class="sr-only prev-control-txt">Previous</span>
                        	</a>
                        	<a class="carousel-control-next" href="#home-page-carousel" role="button" data-slide="next">
                        		<span class="carousel-control-next-icon" aria-hidden="true"></span>
                        		<span class="sr-only next-control-txt">Next</span>
                        	</a>
                        </div>
                    </div>
        		</div>
		
        		<div class="row">
        			<div class="col-sm-12">
        				<div class="trow_ c-dib_ cnt-center">
        					<img src="img/home-assets/home-total-img.png" style="max-width: 123px; margin-right: 3px;">
        					<img src="img/home-assets/home-well-img.png"  style="max-width: 211px; margin-left: 3px;">
        				</div>
        			</div>
        		</div>
        	</div>
	    </div>
	</div>
</div>
@endsection