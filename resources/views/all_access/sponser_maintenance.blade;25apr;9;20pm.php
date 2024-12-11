@extends('layouts.compliance') 
@section('content')

<div class="row" style="border-bottom: solid 1px #cecece;">
    <div class="col-sm-12">
        <h4 class="elm-left fs-24_ mb-4_">Sponsor Maintenance</h4>
        <div class="date-time elm-right">{{ now('America/Chicago')->isoFormat('LLLL') }}</div>
    </div>
</div>



<div class="row">
    <div class="col-sm-12">
        <div class="row mt-17_ mb-17_" style="position: relative;">
            <div class="col-sm-12">
                <ul class="nav nav-tabs reports-tabs" style="border: 0px;">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#login-page-tab">Login Page</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#enroll-search-tab">ENROLL / SEARCH PAGE</a></li>
                </ul>
                <div class="tab-content pos-rel_" style="">
                    <div id="login-page-tab" class="container tab-pane fade in active show" style="min-width: 100%; max-width: 100%;">
                        <div class="row" style="padding-right: 24vw;">
                            <div class="col-sm-12" style="border: solid 1px #dee2e6; margin-top: 0px;">
                                <div class="row sponsor_main2-page-container">
                                    <div class="col-sm-6 left-form-col" style="min-height: 600px;padding-bottom: 47px;">
                                        <div class="row" style="display: flex; justify-content: center; align-items: center; min-height: 100%;">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12 cnt-center mt-14_">
                                                        <a class="navbar-brand" href="javascript:void(0);"> 
                                                            <img src="images/home-assets/logo-big.png" style="max-width: 180px;" alt="Site Logo"> 
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form class="sponsor_main2-login-form elm-center" style="max-width: 380px;">
                                                            <div class="trow_ mt-40_">
                                                                <label class="txt-blue weight_600 cnt-left fs-17_">Login Here</label>
                                                            </div>
                                                            <div class="trow_ c-dib_ cmp-field_ fld-email_ mt-17_">
                                                                <!--label class="min-w-100p">Email</label-->
                                                                <input class="min-w-100p" type="email" disabled name="email23424" placeholder="Enter Email"> <span class="fa fa-user"></span> </div>
                                                            <div class="trow_ c-dib_ cmp-field_ fld-password_ mt-7_">
                                                                <!--label class="min-w-100p">Email</label-->
                                                                <input class="min-w-100p" type="password" disabled name="passwordasdfa" placeholder="Enter Password"> <span class="fa fa-eye"></span> </div>
                                                            <div class="trow_ mt-17_">
                                                                <div class="elm-left"> <a class="btn btn-link pa-force-0_ td_u_ txt-blue" href="javascript:void(0);">Forgot Username/Password</a> </div>
                                                                <div class="elm-right">
                                                                    <label class="min-w-100p">
                                                                        <input class="" type="checkbox" disabled name="remember"> <span style="color: #999999;">Remember</span> </label>
                                                                </div>
                                                            </div>
                                                            <div class="trow_ cnt-center mt-36_">
                                                                <button type="button" disabled class="signin-button site-blue-btn fs-17_">Sign In</button>
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
                                                            <p style="max-width: 380px; color: #909090;"> &copy; 2020 <span class="txt-blue">Compliance Reward</span>. All rights Reserved. </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 right-slider-column" style="min-height: 600px;">
                                        <div class="row" style="display: flex; justify-content: center; align-items: center; min-height: 100%;">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="sponsor_main2-page-carousel" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                @php $acount = 1; $img_url = str_replace('/public','',url('')); $bllt=''; @endphp
                                                                @if($login_page_slider)
                                                                    @foreach($login_page_slider as $KeyLS=>$ValLS)
                                                                        @php if($acount==1){ $cllass='active'; }elseif($acount==2){ $cllass = 'carousel-item-next'; }else{ $cllass=''; } @endphp
                                                                        <div id="slide_id_{{ $acount }}" class="carousel-item {{ $cllass }}" data-interval="2000"> 
                                                                            <span class="item-count">{{ $acount }}</span> <img class="d-block w-100" src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}"> 
                                                                        </div>
                                                                        
                                                                        @php 
                                                                        $bllt .= '<li id="bult_id_'.$acount.'" data-target="#sponsor_main2-page-carousel" data-slide-to="'.($acount).'"></li>'; 
                                                                            $acount++; 
                                                                        @endphp
                                                                        
                                                                        
                                                                    @endforeach
                                                                @endif                                                               
                                                            </div>
                                                            <ol class="carousel-indicators">
                                                                @php echo $bllt; @endphp
                                                            </ol>
                                                            <a class="carousel-control-prev" href="#sponsor_main2-page-carousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only prev-control-txt">Previous</span> </a>
                                                            <a class="carousel-control-next" href="#sponsor_main2-page-carousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only next-control-txt">Next</span> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 pl-0 pr-0">
                                                        <div class="trow_ c-dib_ cnt-center" id="below_images" style="display: flex; justify-content: center;"> 
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
                        </div>
                        
                        <div class="" style="position: absolute; top: 0px; right: 0vw; width: 23vw; height: 100%; border-radius: 0px 0px 7px 7px;">
                            <div style="background-color: #cecece; padding: 7px; border-radius: 7px; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;">
                                <div class="trow_ pa-6_ bg-white mb-11_ br-rds-6 pa-6_" id="slider_data_container">
                                    
                                    <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> <span class="txt-red mr-4_">A:</span><span>Supports UP to 4, 444 x 254 pixel images (scrolling) in location</span> </div>
                                    @php 
                                        $total_slider_images = 4;
                                        $img_url = str_replace('/public','',url(''));
                                        $count = 1;
                                    @endphp
                                    @if($login_page_slider)
                                        @foreach($login_page_slider as $KeyLS=>$ValLS)
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" img-width="444" img-height="254">
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ $count }})</span><span class="weight_600" id="title_cont-{{ $count }}">{{ $ValLS->title }}</span> </div>
                                                <div class="elm-right">
                                                    <div class="cnt-right c-dib_"> 
                                                        <a href="javascript:void(0);" image-type="Slider" dat-title="{{ $ValLS->title }}" is-edit="1" img-src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}" data-edit="{{ $ValLS->id }}" page-id="1" index-count="{{ $count }}" data-toggle="modal" data-target="#sponsors-Modal" class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a> 
                                                        <a href="javascript:delete_row({{ $count }}, 'Slider')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a> 
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            @php 
                                                $total_slider_images--; 
                                                $count++;
                                            @endphp
                                        @endforeach                                    
                                    @endif
                                    
                                    @for($i=0; $i<$total_slider_images; $i++)
                                    <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" img-width="444" img-height="254">
                                        <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($count) }})</span><span class="weight_600" id="title_cont-{{ $count }}">&hellip;empty</span> </div>
                                        <div class="elm-right">
                                            <div class="cnt-right c-dib_" image-type="Slider" id="inner_btn_{{ $count }}"> <a href="javascript:void(0);" image-type="Slider"  page-id="1" data-toggle="modal" index-count="{{ $count }}" data-target="#sponsors-Modal" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> </div>
                                        </div>
                                    </div>
                                    @php $count++; @endphp
                                    @endfor
                                    
                                </div>
                                
                                
                                
                                    
                                    @php 
                                    $bCoun = 1; 
                                    $latter_c = 'B';
                                    $total_simple_images = 2;
                                    $cCoun = 1;
                                    @endphp
                                    @if($login_page_simple)
                                        @foreach($login_page_simple as $KeyLS=>$ValLS)  
                                        <div class="trow_ pa-6_ bg-white mb-7_ br-rds-6 pa-6_">
                                            <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> 
                                                <span class="txt-red mr-4_">{{ $latter_c }}:</span><span>Supports 1, @if($latter_c=='B') {{ '123 x 63' }} @else {{ '211 x 63' }} @endif pixel image in location</span> 
                                            </div>
                                            <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width="123" img-height="63"' }} @else {{ 'img-width="211" img-height="63"' }} @endif >
                                                <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">{{ $ValLS->title }}</span> </div>
                                                    <div class="elm-right">
                                                        <div class="cnt-right c-dib_"> 
                                                            <a href="javascript:void(0);" image-type="Simple" is-edit="1" index-count="{{ $count }}" dat-title="{{ $ValLS->title }}" img-src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}" data-edit="{{ $ValLS->id }}" page-id="1" data-toggle="modal" data-target="#sponsors-Modal"  class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a> 
                                                            <a href="javascript:delete_row({{ $count }}, 'Simple')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a> 
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                            @php 
                                                $total_simple_images--; 
                                                $bCoun++;
                                                $count++;
                                                $cCoun++;
                                                $latter_c++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    @php  
                                    $latter_c = 'B';
                                    $cCoun = 1; 
                                    @endphp
                                    @for($i=0; $i<$total_simple_images; $i++)
                                    <div class="trow_ pa-6_ bg-white mb-7_ br-rds-6 pa-6_">
                                        <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> 
                                            <span class="txt-red mr-4_">{{ $latter_c }}:</span><span>Supports 1, @if($latter_c=='B') {{ '123 x 63' }} @else {{ '211 x 63' }} @endif pixel image in location</span> 
                                        </div>
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width="123" img-height="63"' }} @else {{ 'img-width="211" img-height="63"' }} @endif >
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">&hellip;empty</span> </div>
                                            <div class="elm-right">
                                                <div class="cnt-right c-dib_" image-type="Simple" id="inner_btn_{{ $count }}"> 
                                                    <a href="javascript:void(0);" image-type="Simple" index-count="{{ $count }}" page-id="1" data-toggle="modal" data-target="#sponsors-Modal" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $count++; $bCoun++; $cCoun++; $letter_c++; @endphp
                                    @endfor
                               
                                <div class="trow_ mb-7_ c-dib_ cnt-center"> 
                                    <a class="bg-blue-txt-wht cnt-center mt-17_ fs-14_" href="javascript:submit_form();" style="padding: 10px 23px; border-radius: 24px; border: solid 1px #3e7bc4; color: #fff;">Save</a> 
                                </div>
                                
                                
                            </div>
                            
                            <div class="triangle-left" style="position: absolute;top: 24px;right: 100%;border: solid 1.2vw transparent;border-right: solid 1.4vw #cecece;"></div>
                            
                            
                        </div>
                    </div>
                    <form name="hidden_form" id="hidden_form_login" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" name="page_id" value="1" />
                    </form>
                    <div id="enroll-search-tab" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
                        <div class="row" style="padding-right: 24vw;">
                            <div class="col-sm-12" style="border: solid 1px #dee2e6; margin-top: 0px;">
                            	
                            	<div class="row">
                            		<div class="col-sm-12 pos-rel_ pl-0 pr-0" style="min-height: 600px;">
                            			
		                                <header class="site-header">
                                            <div class="trow_">
                                                <div class="row mt-7_ ml-0 mr-0">
                                                    <div class="col-sm-6 col-md-6" style="display: flex; align-items: center;">
                                                        <a class="navbar-brand" >
                                                            <img src="{{ url('images/logo.png') }}" alt="Site Logo">
                                                        </a> <span class="page-top-left-title txt-gray-9a-force-child tt_uc_">Pharmacy Name</span>
                                                    </div>
        
                                                    <div class="col-sm-6 col-md-6" style="display: flex; align-items: center; justify-content: flex-end;">
                                                        <div class="elm-right c-dib_ pt-8_" style="max-height: 40px; ">
                                                            <span class="user-photo mt-m8_">
                                                                                        <img src="{{ url('images/user-photo.png') }}" style="border-radius: 50%; max-height: 39px; border: solid 1px #eee;">
                                                                                </span>
                                                            <div class="dropdown compliance-dropdown_">
                                                                <a class="dropdown-toggle weight_700 fs-17_" data-toggle="dropdown" aria-expanded="false"> Hello, <span class="txt-blue fs-17_">Laura Jones</span>
                                                                                        </a>
                                                                <ul class="dropdown-menu" style="" disabled onclick="javascript:void(0);">
                                                                    
                                                                </ul>
                                                            </div>
                                                            <a href="#Logout" class="txt-red weight_500 fs-17_"> <i class="fa fa-sign-out" aria-hidden="true" style="line-height: 24px; margin-left: 7px;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row bg-blue  mt-7_ mr-0 ml-0">
                                                <div class="col-sm-12">
                                                    <div class="trow_">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <nav class="navbar pa-0_">
                                                                    <ul class="nav nav-tabs txt-wht-child">
                                                                        <li class="nav-item active"><a href="javascript:void(0);" class="nav-link" >Dashboard</a></li>
                                                                        <li class="nav-item "><a href="javascript:void(0);" class="nav-link" >Reports</a></li>
                                                                    </ul>
                                                                </nav>
                                                            </div>
        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </header>
        
                                        <!-- End: Header Section -->
                                        
                                        <section class="trow_">
                                            <div class="row mr-0 ml-0">
                                                <div class="col-sm-12">
                                                    <div class="row pt-14_" style="display: flex; min-height: 100%;">
                                                        <div class="col-sm-12" style="display: flex; flex-wrap: wrap;">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="trow_ mb-14_">
                                                                        <div class="fs-17_ weight_600">Welcome Laura</div>
                                                                    </div>
                                                                    <div class="trow_ mb-24_">
                                                                        <p class="ma-0_ fs-16_" style="line-height: 1.7em;">You are securely connected to Compliance Reward?, where you enroll your most valuable patients to receive convenient and informative messages and activities to support their treatments!</p>
                                                                    </div>
                                                                    <div class="trow_ mb-14_">
                                                                        <div class="fs-17_ txt-blue weight_600">Patient Search</div>
                                                                    </div>
                                                                    <div class="trow_">
                                                                        <form class="" style="width: 70%; min-width: 270px;">
                                                                            <div class="input-group c-dib_" style="padding: 7px; border-radius: 6px; background-color: #fff; border: solid 1px #afbcc2;">
                                                                                <input disabled type="text" class="form-control fs-16_" name="query" id="query" style="line-height: 1.2em !important; height: 36px; border: 0px; padding-left: 0px; padding-left: 6px;" placeholder="All Practice type and All Clients" data-provide="typeahead" autocomplete="off">
                                                                                <div class="input-group-append" style="background-color: #fff; color: #fff !important; margin: 0px; border-radius: 0px 13px 13px 0px;">
                                                                                    <button disabled type="submit" class="btn bg-blue-txt-wht" style="border-radius: 6px; width: 40px; text-align: center; height: 36px; padding: 0px;">
                                                                                        <i class="fa fa-search fs-20_ " style="line-height: 24px;"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                	{{--
                                                                	<div class="table-box" id="patientSlider">
                                                                        <div class="user-report-head">
                                                                            <span>&nbsp;</span>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="trow_ cnt-center">
                                                                                    <img src="images/blue_ad.png" style="width:80%;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    --}}
                                                                    
                                                                    <div id="sponsor_main2-page-carousel2" class="carousel slide" data-ride="carousel">
                                                                    	<div class="carousel-inner">
                                                                    	    <div id="slide_id_1" class="carousel-item active carousel-item-left" data-interval="2000"> 
                                                                                <span class="item-count">1</span> <img class="d-block w-100" src="http://compliancerewards.ssasoft.com/compliancereward/storage/app/sponsors/blue_ad-(2).png"> 
                                                                            </div>
                                                                            <div id="slide_id_2" class="carousel-item carousel-item-next carousel-item-left" data-interval="2000"> 
                                                                                <span class="item-count">2</span> <img class="d-block w-100" src="http://compliancerewards.ssasoft.com/compliancereward/storage/app/sponsors/blue_ad-(2).png"> 
                                                                            </div>
                                                                        </div>
                                                                        <ol class="carousel-indicators">
                                                                            <li id="bult_id_1" data-target="#sponsor_main2-page-carousel2" data-slide-to="1" class=""></li>
                                                                            <li id="bult_id_2" data-target="#sponsor_main2-page-carousel2" data-slide-to="2" class="active"></li>
                                                                        </ol>
                                                                        <a class="carousel-control-prev" href="#sponsor_main2-page-carousel2" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only prev-control-txt">Previous</span> </a>
                                                                        <a class="carousel-control-next" href="#sponsor_main2-page-carousel2" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only next-control-txt">Next</span> </a>
                                                                    </div>
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row" style="min-width: 100%; display: flex; align-items: center; margin-top: 14px;">
                                                                <div class="col-sm-6">
                                                                    <div class="float-left">
                                                                        <img src="http://compliancerewards.ssasoft.com/compliance_html_30jan/images/well.png" class="img-fluid">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="float-right">
                                                                        <img src="http://compliancerewards.ssasoft.com/compliance_html_30jan/images/total.png" class="img-fluid">
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                        </section>
                                        
                                        <footer class="wd-100p site-footer pos-abs_" style="bottom: 0px;left: 0px;">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <ul class="ma-0_ footer-left-links">
                                                            <li><a href="javascript:void(0);" >Offer Terms</a></li>
                                                            <li><a  href="javascript:void(0);">Privacy Policy</a></li>
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
                                        <!-- jQuery library -->
                                    			
                            		</div>
                            	</div>
                                
                            </div>
                         </div>
                        
                        
                        <div class="" style="position: absolute; top: 0px; right: 0vw; width: 23vw; height: 100%; border-radius: 0px 0px 7px 7px;">
                            <div style="background-color: #cecece; padding: 7px; border-radius: 7px; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;">
                                <div class="trow_ pa-6_ bg-white mb-11_ br-rds-6 pa-6_" id="slider_data_container">
                                    
                                    <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> <span class="txt-red mr-4_">A:</span><span>Supports UP to 4, 444 x 254 pixel images (scrolling) in location</span> </div>
                                    @php 
                                        $total_slider_images = 4;
                                        $img_url = str_replace('/public','',url(''));
                                        $count = 1;
                                    @endphp
                                    @if($login_page_slider)
                                        @foreach($login_page_slider as $KeyLS=>$ValLS)
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" img-width="444" img-height="254">
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ $count }})</span><span class="weight_600" id="title_cont-{{ $count }}">{{ $ValLS->title }}</span> </div>
                                                <div class="elm-right">
                                                    <div class="cnt-right c-dib_"> 
                                                        <a href="javascript:void(0);" image-type="Slider" dat-title="{{ $ValLS->title }}" is-edit="1" img-src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}" data-edit="{{ $ValLS->id }}" page-id="2" index-count="{{ $count }}" data-toggle="modal" data-target="#sponsors-Modal" class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a> 
                                                        <a href="javascript:delete_row({{ $count }}, 'Slider')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a> 
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            @php 
                                                $total_slider_images--; 
                                                $count++;
                                            @endphp
                                        @endforeach                                    
                                    @endif
                                    
                                    @for($i=0; $i<$total_slider_images; $i++)
                                    <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" img-width="444" img-height="254">
                                        <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($count) }})</span><span class="weight_600" id="title_cont-{{ $count }}">&hellip;empty</span> </div>
                                        <div class="elm-right">
                                            <div class="cnt-right c-dib_" image-type="Slider" id="inner_btn_{{ $count }}"> <a href="javascript:void(0);" image-type="Slider"  page-id="2" data-toggle="modal" index-count="{{ $count }}" data-target="#sponsors-Modal" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> </div>
                                        </div>
                                    </div>
                                    @php $count++; @endphp
                                    @endfor
                                    
                                </div>
                                
                                
                                
                                    
                                    @php 
                                    $bCoun = 1; 
                                    $latter_c = 'B';
                                    $total_simple_images = 2;
                                    $cCoun = 1;
                                    @endphp
                                    @if($login_page_simple)
                                        @foreach($login_page_simple as $KeyLS=>$ValLS)  
                                        <div class="trow_ pa-6_ bg-white mb-7_ br-rds-6 pa-6_">
                                            <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> 
                                                <span class="txt-red mr-4_">{{ $latter_c }}:</span><span>Supports 1, @if($latter_c=='B') {{ '123 x 63' }} @else {{ '211 x 63' }} @endif pixel image in location</span> 
                                            </div>
                                            <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width="123" img-height="63"' }} @else {{ 'img-width="211" img-height="63"' }} @endif >
                                                <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">{{ $ValLS->title }}</span> </div>
                                                    <div class="elm-right">
                                                        <div class="cnt-right c-dib_"> 
                                                            <a href="javascript:void(0);" image-type="Simple" is-edit="1" index-count="{{ $count }}" dat-title="{{ $ValLS->title }}" img-src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}" data-edit="{{ $ValLS->id }}" page-id="2" data-toggle="modal" data-target="#sponsors-Modal"  class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a> 
                                                            <a href="javascript:delete_row({{ $count }}, 'Simple')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a> 
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                            @php 
                                                $total_simple_images--; 
                                                $bCoun++;
                                                $count++;
                                                $cCoun++;
                                                $latter_c++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    @php  
                                    $latter_c = 'B';
                                    $cCoun = 1; 
                                    @endphp
                                    @for($i=0; $i<$total_simple_images; $i++)
                                    <div class="trow_ pa-6_ bg-white mb-7_ br-rds-6 pa-6_">
                                        <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> 
                                            <span class="txt-red mr-4_">{{ $latter_c }}:</span><span>Supports 1, @if($latter_c=='B') {{ '123 x 63' }} @else {{ '211 x 63' }} @endif pixel image in location</span> 
                                        </div>
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width="123" img-height="63"' }} @else {{ 'img-width="211" img-height="63"' }} @endif >
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">&hellip;empty</span> </div>
                                            <div class="elm-right">
                                                <div class="cnt-right c-dib_" image-type="Simple" id="inner_btn_{{ $count }}"> 
                                                    <a href="javascript:void(0);" image-type="Simple" index-count="{{ $count }}" page-id="2" data-toggle="modal" data-target="#sponsors-Modal" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $count++; $bCoun++; $cCoun++; $letter_c++; @endphp
                                    @endfor
                               
                                <div class="trow_ mb-7_ c-dib_ cnt-center"> 
                                    <a class="bg-blue-txt-wht cnt-center mt-17_ fs-14_" href="javascript:submit_form();" style="padding: 10px 23px; border-radius: 24px; border: solid 1px #3e7bc4; color: #fff;">Save</a> 
                                </div>
                                
                                
                            </div>
                            
                            <div class="triangle-left" style="position: absolute;top: 24px;right: 100%;border: solid 1.2vw transparent;border-right: solid 1.4vw #cecece;"></div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide" style="display: none;" id="empty_clon">
    <div class="elm-left"> <span class="txt-blue mr-4_" id="count_text">Replace_Str</span><span class="weight_600" id="title_cont-rep_index_count">&hellip;empty</span> </div>
    <div class="elm-right">
        <div class="cnt-right c-dib_" id="inner_btn_rep_index_count"><a href="javascript:void(0);"  index-count="rep_index_count" image-type='rep_type' page-id="1" data-toggle="modal" data-target="#sponsors-Modal" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> </div>
    </div>
</div>
@include('partials.modal.sponsors_maintenance')

@endsection


@section('js')

	@include('partials.js.sponsor_js')
@endsection