@extends('layouts.compliance')
@section('content')

<div class="row home-page-container">

	<div class="col-sm-6 left-form-col" style="min-height: 600px; padding-top: 100px;">

		<div class="row">
			<div class="col-sm-12 cnt-center">
				<a class="navbar-brand" href="http://compliancerewards.ssasoft.com/compliance_html_30jan/?path=home">
				 <img
					src="images/home-assets/logo-big.png" style="max-width: 300px;"
					alt="Site Logo">
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<form method="POST" action="{{ route('login') }}" class="home-login-form elm-center" style="max-width: 380px;">
                    @csrf
                    <div class="trow_ mt-40_">
						<label class="txt-blue weight_600 cnt-left fs-17_">Login Here</label>
					</div>
					<div class="trow_ c-dib_ cmp-field_ fld-email_ mt-17_">
						<!--label class="min-w-100p">Email</label-->
                        <input class="min-w-100p @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email"  value="{{ old('email') }}" required autocomplete="email" autofocus>

                        <span class="fa fa-user"></span>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
					</div>
					<div class="trow_ c-dib_ cmp-field_ fld-password_ mt-7_">
						<!--label class="min-w-100p">Email</label-->
						<input class="min-w-100p @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter Password" required autocomplete="current-password">
                        <span class="fa fa-eye"></span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
					</div>
					<div class="trow_ mt-17_">
                        @if (Route::has('password.request'))
						<div class="elm-left">
							<a class="btn btn-link pa-force-0_" href="{{ route('password.request') }}">Forgot Username/Password</a>
                        </div>
                        @endif
						<div class="elm-right">
							<label class="min-w-100p c-dib_">
                                <input class="mt-4_" type="checkbox"name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Remember</span>
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
	<div class="col-sm-6 right-slider-column" style="min-height: 600px; padding-top: 100px;">

		<div class="row">
			<div class="col-sm-12">
    			<div id="home-page-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-interval="2000">
                        	<span class="item-count">1</span>
                        	<img class="d-block w-100" src="images/home-assets/slide-img1.png">
                        </div>
                        <div class="carousel-item" data-interval="2000">
                        	<span class="item-count">2</span>
                        	<img class="d-block w-100" src="images/home-assets/slide-img2.png">
                        </div>
                        <div class="carousel-item" data-interval="2000">
                        	<span class="item-count">3</span>
                        	<img class="d-block w-100" src="images/home-assets/slide-img3.png">
                        </div>
                        <div class="carousel-item" data-interval="2000">
                        	<span class="item-count">4</span>
                        	<img class="d-block w-100" src="images/home-assets/slide-img4.png">
                        </div>
                    </div>
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
					<img src="images/home-assets/home-total-img.png" style="max-width: 123px;">
					<img src="images/home-assets/home-well-img.png"  style="max-width: 211px;">
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
