<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.4.4.1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/font-awesome.min.css') }}">
    <link href="{{ asset('css/compliance-custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/compliance-generic.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/compliance-responsive.css') }}" rel="stylesheet" type="text/css" />  
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />      
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />  
    
    <!-- toaster -->
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">

    <!-- Scripts -->
    <script src="{{url('/js/jquery/2.1.4-jquery.min.js')}}"></script>
    <script src="{{url('/js/jquery/1.11.4-jquery-ui.min.js')}}"></script>
    <script src="{{url('/js/form-builder.min.js')}}"></script>
    
        <!-- Latest compiled and minified JavaScript -->
    <script src="{{url('/js/jquery.rateyo.min.js')}}"></script> 
    <!-- Latest compiled and minified CSS -->
   <link href="{{ asset('css/jquery.rateyo.min.css') }}" rel="stylesheet" type="text/css" />  
  
    <script src="{{url('/js/jquery/jquery.validate.js')}}"></script>
    <script src="{{url('/js/jquery/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/js/popper.js')}}"></script>
    <script src="{{url('/js/bootstrap.js')}}"></script>
    <script src="{{url('/js/select2.min.js')}}"></script>
    
    <!-- Toaster -->
	<script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<style>
    .form-wrap.form-builder .stage-wrap.empty:after {
            content: 'Click a field from left to add this area.' !important;
     }
#toast-container > .toast-success {
    background-image: none;
    background-color: green;
    color: white;
}
#toast-container > .toast-error {
    background-image: none;
    background-color: red;
    color: white;
}
        </style>
</head>
<body id="app">
    <header class="site-header">
        <div class="container">
                <div class="row mt-7_">
                        <div class="col-sm-6 col-md-6" style="display: flex; align-items: center;">
                                <a class="navbar-brand" href="{{ url('survey/home') }}">
                                        <img src="http://compliancerewards.ssasoft.com/comprewards/public/new/images/logo.png" alt="Site Logo">
                                </a> <span class="page-top-left-title txt-gray-9a-force-child tt_uc_">Survey Tool</span>
                        </div>

                        <div class="col-sm-6 col-md-6" style="display: flex; align-items: center; justify-content: flex-end;">
                                <div class="elm-right c-dib_ pt-8_" style="max-height: 40px; ">
                                        <span class="user-photo mt-m8_">
                                                <img src="{{ asset('images/user-photo.png') }}" style="border-radius: 50%; max-height: 39px; border: solid 1px #eee;">
                                        </span>
                                        <div class="dropdown compliance-dropdown_">
                                                <a class="dropdown-toggle weight_700 fs-17_" data-toggle="dropdown" aria-expanded="false"> Hello, <span class="txt-blue fs-17_">{{ Auth::user()->name }}</span>
                                                </a>
                                                <ul class="dropdown-menu" style="">
                                                        <li class="dropdown-item"><a href="#profile">Profile</a></li>
                                                        <li class="dropdown-item"><a href="#settings">Settings</a></li>
                                                        <li class="dropdown-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                </ul>
                                        </div>
                                        <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="txt-red weight_500 fs-17_"> <i class="fa fa-sign-out" aria-hidden="true" style="line-height: 24px; margin-left: 7px;"></i>
                                        </a>
                                </div>
                        </div>
                </div>
        </div>
        <div class="row bg-blue  mt-7_   ">
                <div class="col-sm-12">
                        <div class="container">
                                <div class="row">
                                        <div class="col-sm-6">
                                                <nav class="navbar pa-0_">
                                                        <ul class="nav nav-tabs txt-wht-child">
                                                                 <li class=@if(strpos(url()->current(),'report') == false)
									'nav-item active' @else 'nav-item' @endif><a class="nav-link"
									href="{{url('survey/home')}}">Dashboard</a>
								</li>
                                                                <li class=@if(strpos(url()->current(),'report') !== false)
									'nav-item active' @else 'nav-item' @endif><a class="nav-link"
									href="{{url('survey/report')}}">Reports</a>
								</li>                 
                                                                <li class="nav-item "><a class="nav-link" href="{{url('overview')}}">All Access Module</a>
                                                                </li>
                                                        </ul>
                                                </nav>
                                        </div>

										<!-- <div class="col-sm-6" style="margin-top:10px; color:white;">{{  now('America/Chicago')->isoFormat('LLLL') }}</div> -->
                                </div>
								
                        </div>
                </div>
        </div>
    </header>
  
<section class="main-wrapper">
    <div class="container height_fullp full_width">
        <div class="row height_fullp">
            
            @if(str_contains(url()->current(), 'survey/report'))

                <div class="col-sm-3 col-lg-2 sidebar-item">
                    @include ("partials.sidebar-survey")
                </div>

                <div class="col-sm-9 col-lg-10 main-page-content">
                    @yield('content')
                </div>

            @else

            <div class="col-sm-12 main-page-content">
                @yield('content')
            </div>

            @endif
        </div>
    </div>    
</section>
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="ma-0_ footer-left-links">
                        <li><a href="http://compliancerewards.ssasoft.com/comprewards/public/offer-terms">Offer Terms</a></li>
                        <li><a href="http://compliancerewards.ssasoft.com/comprewards/public/privacy-policy">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="footer-text text-right">
                        <p class="ma-0_ mt-12_">&copy;2020 <a href="#">Compliance Reward</a>. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @yield('script')
</body>
</html>
