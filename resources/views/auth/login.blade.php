@extends('layouts.compliance')
@section('content')
<div class="col-sm-12 height_fullp">
<div class="row home-page-container">

	<div class="col-sm-6 left-form-col" style="min-height: 600px;">

	    <div class="row" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
			<div class="col-sm-12">
        		<div class="row">
        			<div class="col-sm-12 cnt-center mt-14_">
        				<a class="navbar-brand" href="{{ url('/') }}">
        				 <img
        					src="images/home-assets/logo-big.png" style="max-width: 300px;"
        					alt="Site Logo">
        				</a>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-sm-12">
        				<form method="POST" action="{{ route('login') }}" class="home-login-form elm-center" style="max-width: 380px;" novalidate>
                            @csrf
        					<div class="trow_ mt-40_">
        						<label class="txt-blue weight_600 cnt-left fs-17_">Login Here</label>
        					</div>
        					<div class="trow_ c-dib_ cmp-field_ fld-email_ mt-17_">
        						<!--label class="min-w-100p">Email</label-->
        						<input  class="min-w-100p  @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
        						<span class="fa fa-user"></span>
                                 @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                  @if ($message = Session::get('role_error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        					</div>
        					<div class="trow_ c-dib_ cmp-field_ fld-password_ mt-7_">
        						<!--label class="min-w-100p">Email</label-->
        						<input class="min-w-100p @error('password') is-invalid @enderror" id="pass" type="password" name="password" placeholder="Enter Password" autocomplete="current-password">
        						<span class="fa fa-eye" style="cursor: pointer;" onclick="myFunction()"></span>
                                 @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
        					</div>
        					<div class="trow_ mt-17_">
                                 @if (Route::has('password.request'))
        						<div class="elm-left">
        							<a class="btn btn-link pa-force-0_ td_u_ txt-blue" href="{{ route('password.request') }}">Forgot Password</a>
        						</div>
                                @endif
        						<div class="elm-right">
        							<label class="min-w-100p c-dib_">
                                        <input id="remember" class="mt-0_" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span style="color: #999999;">Remember Me</span>
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
        					<p style="max-width: 380px; color: #909090;">enroll your patients to receive convenient and informative messages and activities to support their treatments - while earning valuable rewards from our network of participating providers!</p>
        				</div>
        				<div class="trow_ cnt-center c-dib_ mt-24_">
        					<p style="max-width: 380px; color: #909090;">&copy; 2020 <span class="txt-blue">COMPLIANCE REWARD</span>. All rights Reserved.</p>
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
                                
                                @php $acount = 1; $img_url = str_replace('/public','',url('')); $bllt=''; @endphp
                                @if($login_page_slider)
                                    @foreach($login_page_slider as $KeyLS=>$ValLS)
                                        @php if($acount==1){ $cllass='active'; $indClass='active';}elseif($acount==2){ $cllass = 'carousel-item-next'; $indClass='';}else{ $cllass=''; } @endphp
                                        <div id="slide_id_{{ $acount }}" class="carousel-item {{ $cllass }}" data-interval="15000"> 
                                            <span class="item-count">{{ $acount }}</span> <img class="d-block w-100" src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}"> 
                                        </div>

                                        @php 
                                        $bllt .= '<li id="bult_id_'.$acount.'" data-target="#home-page-carousel" data-slide-to="'.($acount-1).'" class="'.$indClass.'"></li>'; 
                                            $acount++; 
                                        @endphp


                                    @endforeach
                                @endif                                                               
                            </div>
                            <ol class="carousel-indicators">
                                @php echo $bllt; @endphp
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
        					 @php $bCoun = 1; @endphp
                                                        @if($login_page_simple)
                                                            @foreach($login_page_simple as $KeyLS=>$ValLS)   
                                                                <img
                                                                	id='simple_id_{{ $bCoun }}'
                                                                	src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}"
                                                                	style=" 
                                                                	@if($bCoun==1) {{ 'width: 123px;max-width: 23%;margin-right: 1%;' }} @else {{ 'width: 211px;max-width: 66%;margin-left: 1%;' }} @endif;">
                                                                @php $bCoun++; $acount++; @endphp
                                                            @endforeach
                                                        @endif
        				</div>
        			</div>
        		</div>
        	</div>
	    </div>
	</div>
</div>

</div>









@endsection
@section('js')
<script>
    function myFunction() {

        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endsection
