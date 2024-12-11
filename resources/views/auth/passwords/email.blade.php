@extends('layouts.compliance')

@section('content')

<div id="recover-password" class="col-sm-12 wp-100p home-page-container">
	
	<div class="trow_ left-form-col" style="min-height: 600px;">
	  
	    <div class="row" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
			<div class="col-sm-12">
        		<div class="row">
        			<div class="col-sm-12 cnt-center mt-14_">
        				<a class="navbar-brand" href="http://compliancerewards.ssasoft.com/">
        				 <img src="http://compliancerewards.ssasoft.com/compliancereward/public/images/home-assets/logo-big.png" style="max-width: 300px;" alt="Site Logo">
        				</a>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-sm-12">
        				@if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
        				<form class="home-login-form elm-center" style="max-width: 380px;" method="POST" action="{{ route('password.email') }}">
                            <div class="trow_ mt-40_">
        						<label class="txt-blue weight_600 cnt-left fs-17_">Reset Password</label>
        					</div>
                            @csrf
                            <div class="trow_ c-dib_ cmp-field_ fld-email_ mt-17_ pass_in">
                                <input id="email" type="email" placeholder="Please enter email" class="min-w-100p custom_add_inputs  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                <span class="fa fa-user" style="line-height: 32px;"></span>
                                @error('email')
                                <span class="invalid-feedback error-recover-pass" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="trow_ cnt-center mt-36_">
                                <button type="submit" class="site-blue-btn fs-17_ Srch_btn_new">Send</button>
                            </div>
                        </form>
        			</div>
        		</div>
        		<div class="row mt-14_">
        			<div class="col-sm-12">
        				
        				<div class="trow_ cnt-center c-dib_ mt-24_">
        					<p style="max-width: 380px; color: #909090;">&copy; 2020 <span class="txt-blue">Compliance Reward</span>. All rights Reserved.</p>
        				</div>
        			</div>
        		</div>
        	</div>
	    </div>
		
	</div>
	
</div>


@endsection
