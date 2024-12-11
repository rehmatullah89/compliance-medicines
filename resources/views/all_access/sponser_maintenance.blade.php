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
                    @can('login page setup')
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#login-page-tab">Login Page</a></li>
                    @endcan
                    @can('enroll search page setup')
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#enroll-search-tab">ENROLL / SEARCH PAGE</a></li>
                    @endcan
                    @can('sponsor drug report view')
                    <li class="nav-item"><a id="spns-tab" class="nav-link" data-toggle="tab" href="#sponsor-drug-tab">Sponsored Drugs Report</a></li>
                    @endcan
                    @can('viewed sponsor drugs report')
                    <li class="nav-item"><a id="spns-tab" class="nav-link" data-toggle="tab" href="#view-sponsor-tab">Viewed Sponsored Drugs</a></li>
                    @endcan
                    @can('survey setup')
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#survey-tab">Survey</a></li>
                    @endcan
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
                                                                        <div id="slide_id_{{ $acount }}" class="carousel-item {{ $cllass }}" data-interval="15000"> 
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
                                            <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width=123 img-height=63' }} @else {{ 'img-width=211 img-height=63' }} @endif >
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
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width=123 img-height=63' }} @else {{ 'img-width=211 img-height=63' }} @endif >
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">&hellip;empty</span> </div>
                                            <div class="elm-right">
                                                <div class="cnt-right c-dib_" image-type="Simple" id="inner_btn_{{ $count }}"> 
                                                    <a href="javascript:void(0);" image-type="Simple" index-count="{{ $count }}" page-id="1" data-toggle="modal" data-target="#sponsors-Modal" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $count++; $bCoun++; $cCoun++; $latter_c++; @endphp
                                    @endfor
                               
                                <div class="trow_ mb-7_ c-dib_ cnt-center"> 
                                    <button type="button" class="bg-blue-txt-wht cnt-center mt-17_ fs-14_" id="save_btn_login" onclick="submit_form();" style="padding: 10px 23px; border-radius: 24px; border: solid 1px #3e7bc4; color: #fff;">Save</button> 
                                    <div style="margin-top: 15px;margin-left: 10px;display: none;" id="loading_small_login"><img src="{{ url('images/loader_trans.gif') }}" style="width: 40px;"></div>
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
                            		<div class="col-sm-12 pos-rel_ pl-0 pr-0" style="min-height: 630px;">
                            			
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
                                                                    <div id="sponsor_main2-page-carousel2" class="carousel slide" data-ride="carousel">
                                                                    	<div class="carousel-inner">
                                                                    	    @php $acount = 1; $img_url = str_replace('/public','',url('')); $bllt=''; @endphp
                                                                                @if($enrol_page_slider)
                                                                                    @foreach($enrol_page_slider as $KeyLS=>$ValLS)
                                                                                        @php if($acount==1){ $cllass='active'; }elseif($acount==2){ $cllass = 'carousel-item-next'; }else{ $cllass=''; } @endphp
                                                                                        <div id="slide_id_{{ $acount }}" class="carousel-item {{ $cllass }}" data-interval="15000"> 
                                                                                            <span class="item-count">{{ $acount }}</span> 
                                                                                            <img class="d-block w-100" src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}"> 
                                                                                        </div>

                                                                                        @php 
                                                                                        $bllt .= '<li id="bult_id_'.$acount.'" data-target="#sponsor_main2-page-carousel2" data-slide-to="'.($acount).'"></li>'; 
                                                                                            $acount++; 
                                                                                        @endphp


                                                                                    @endforeach
                                                                                @endif                                                               
                                                                            </div>
                                                                            <ol class="carousel-indicators">
                                                                                @php echo $bllt; @endphp
                                                                            </ol>
                                                                                                                                           
                                                                        <a class="carousel-control-prev" href="#sponsor_main2-page-carousel2" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only prev-control-txt">Previous</span> </a>
                                                                        <a class="carousel-control-next" href="#sponsor_main2-page-carousel2" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only next-control-txt">Next</span> </a>
                                                                    </div>
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row" style="min-width: 100%; display: flex; align-items: center; margin-top: 14px;">
                                                                
                                                                 @php $bCoun = 1; @endphp
                                                        @if($enrol_page_simple)
                                                            @foreach($enrol_page_simple as $KeyLS=>$ValLS) 
                                                            <div class="col-sm-6">
                                                                    <div class="@if($bCoun==1) {{ 'float-left' }} @else {{ 'float-right' }} @endif;">
                                                                    <img  class="img-fluid"
                                                                	id='simple_id_{{ $bCoun }}'
                                                                	src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}"
                                                                	>
                                                                </div>
                                                            </div>
                                                                @php $bCoun++; $acount++; @endphp
                                                            @endforeach
                                                        @endif
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
                                                            <p class="ma-0_ mt-12_">&copy;2020 <a href="javascript:void(0);">Compliance Reward</a>. All Rights Reserved.</p>
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
                                    @if($enrol_page_slider)
                                        @foreach($enrol_page_slider as $KeyLS=>$ValLS)
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" img-width="444" img-height="254">
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ $count }})</span><span class="weight_600" id="title_cont-{{ $count }}">{{ $ValLS->title }}</span> </div>
                                                <div class="elm-right">
                                                    <div class="cnt-right c-dib_"> 
                                                        <a href="javascript:void(0);" image-type="Slider" dat-title="{{ $ValLS->title }}" is-edit="1" img-src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}" data-edit="{{ $ValLS->id }}" page-id="2" index-count="{{ $count }}" data-toggle="modal" data-target="#sponsors-Modal_enrol" class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a> 
                                                        <a href="javascript:delete_row_enrol({{ $count }}, 'Slider')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a> 
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
                                            <div class="cnt-right c-dib_" image-type="Slider" id="inner_btn_{{ $count }}"> <a href="javascript:void(0);" image-type="Slider"  page-id="2" data-toggle="modal" index-count="{{ $count }}" data-target="#sponsors-Modal_enrol" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> </div>
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
                                    @if($enrol_page_simple)
                                        @foreach($enrol_page_simple as $KeyLS=>$ValLS)  
                                        <div class="trow_ pa-6_ bg-white mb-7_ br-rds-6 pa-6_">
                                            <div class="trow_ mb-11_ pa-4_ weight_600 flx-justify-start"> 
                                                <span class="txt-red mr-4_">{{ $latter_c }}:</span><span>Supports 1, @if($latter_c=='B') {{ '243 x 101' }} @else {{ '243 x 101' }} @endif pixel image in location</span> 
                                            </div>
                                            <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width=243 img-height=101' }} @else {{ 'img-width=243 img-height=101' }} @endif >
                                                <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">{{ $ValLS->title }}</span> </div>
                                                    <div class="elm-right">
                                                        <div class="cnt-right c-dib_"> 
                                                            <a href="javascript:void(0);" image-type="Simple" is-edit="1" index-count="{{ $count }}" dat-title="{{ $ValLS->title }}" img-src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}" data-edit="{{ $ValLS->id }}" page-id="2" data-toggle="modal" data-target="#sponsors-Modal_enrol"  class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a> 
                                                            <a href="javascript:delete_row_enrol({{ $count }}, 'Simple')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a> 
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
                                            <span class="txt-red mr-4_">{{ $latter_c }}:</span><span>Supports 1, @if($latter_c=='B') {{ '243 x 101' }} @else {{ '243 x 101' }} @endif pixel image in location</span> 
                                        </div>
                                        <div class="trow_ mb-7_ bg-gray-e3 p6-12_ br-rds-13" tab-val="{{ $count }}" id="row_{{ $count }}" @if($latter_c=='B') {{ 'img-width=243 img-height=101' }} @else {{ 'img-width=243 img-height=101' }} @endif >
                                            <div class="elm-left"> <span class="txt-blue mr-4_">{{ ($cCoun) }})</span><span class="weight_600" id="title_cont-{{ $count }}">&hellip;empty</span> </div>
                                            <div class="elm-right">
                                                <div class="cnt-right c-dib_" image-type="Simple" id="inner_btn_{{ $count }}"> 
                                                    <a href="javascript:void(0);" image-type="Simple" index-count="{{ $count }}" page-id="2" data-toggle="modal" data-target="#sponsors-Modal_enrol" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $count++; $bCoun++; $cCoun++; $latter_c++; @endphp
                                    @endfor
                               
                                <div class="trow_ mb-7_ c-dib_ cnt-center"> 
                                    <button type="button" id="save_btn_enrol" class="bg-blue-txt-wht cnt-center mt-17_ fs-14_" onclick="submit_form_enrol();" style="padding: 10px 23px; border-radius: 24px; border: solid 1px #3e7bc4; color: #fff;">Save</button> 
                                    <div style="margin-top: 15px;margin-left: 10px;display: none;" id="loading_small_enrol"><img src="{{ url('images/loader_trans.gif') }}" style="width: 40px;"></div>
                                </div>
                                
                                
                            </div>
                            
                            <div class="triangle-left" style="position: absolute;top: 24px;right: 100%;border: solid 1.2vw transparent;border-right: solid 1.4vw #cecece;"></div>
                            
                            
                        </div>
                    </div>
                    
                    <form name="hidden_form_enrol" id="hidden_form_enrol" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" name="page_id" value="2" />
                    </form>
                    <div id="sponsor-drug-tab" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
                        <div class="row" >
                            <div class="col-sm-12" style="border: solid 1px #dee2e6; margin-top: 0px;">
                                
                                <div class="row">
                                    <div class="col-sm-12 pos-rel_ pl-0 pr-0">
                                      
            
                
           
             
                 <!-- <p class="cnt-right txt-blue" style="cursor: pointer;" data-toggle="modal" data-target="#sponsors-import-drug">Import Excel<i class="far fa-file-excel-o fs-18_"></i></p> -->

             <div class="trow_ mt-14_ pl-14_ pr-14_">
                 

	                 <span class="elm-left fs-17_ weight_600 txt-blue" style="line-height: 33px;">Sponsor Drug</span><a class="elm-right txt-blue no-wrap-text c-dib_" data-toggle="modal" data-target="#sponsors-import-drug">
	    				<span class="txt-blue weight_600 fs-15_" style="line-height: 31px;">Import Excel</span>
					<span class="excel-icon weight_600 fs-20_ cnt-center pa-4_" style="color:#08763b;border: solid 3px #08763b;line-height: 21px;padding: 0px 1px;transform: scale(0.8);">&#10006;</span>
					</a>
             </div>

                <div class="row mt-7_ mb-17_ mr-0 ml-0 pr-14_ pl-14_">
                    <div class="col-sm-12 pr-0 pl-0 table-responsive pb-7_">
                    <table class="table reports-bordered compliance-user-table data-table" >
        <thead>
            <tr >
                <th class="bg-blue txt-wht refill_next" style="white-space:nowrap;">Sponsored</th>
                <th class="bg-orage txt-wht refills_rem" style="white-space:nowrap;">Sponsor Source</th>
                <th class="bg-gr-bl-dk txt-wht cnt-center rx_no" style="white-space:nowrap;">Sponsor Item Number</th>
                <th class="bg-gray-1 txt-wht rx_label_name" style="white-space:nowrap;">Order Web Link</th>
                <th class="bg-gray-1 txt-wht generic_for">GCNSEQ</th>
                <th class="bg-blue txt-wht qty">NDC</th>
                <th class="bg-gray-1 txt-wht days_suppy" style="white-space:nowrap;">UPC</th>
                <th class="bg-gray-80 txt-wht rx_sell_price" style="white-space:nowrap;">Rx Label Name</th>
                <th class="bg-red-dk txt-wht reward_auth" style="white-space:nowrap;">Strength</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">Dosage form</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">ING COST/unit</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">Default Rx QTY</th>
                
            </tr>
        </thead>
        <tbody id="tbodies_data">
            @if(isset($drugs) && count($drugs)>0)
                @foreach($drugs as $keyRes=>$valRes)
                <tr data-did="{{$valRes['id']}}">
                    <td class="bg-tb-blue-lt txt-black-24 cnt-center" >
                        <a class="td_u_force txt-blue_sh-force sp_sts" href="javascript:void(0)" onclick="remove_sponsor({{$valRes['id']}},'{{$valRes['sponsored_product']}}')">{{$valRes['sponsored_product']}}</a>
                    </td>
                    <td class="bg-tb-orange-lt txt-orange sp_src">{{$valRes['sponsor_source']}}</td>
                    <td class="bg-gray-e txt-wht cnt-left"><span class="txt-gray-9 sp_itm">{{$valRes['sponsor_item']}}</span></td>
                    <td class="bg-tb-pink-lt txt-blue-force cnt-left weight_600 sp_lnk">{{$valRes['order_web_link']}}</td>
                    <td class="bg-tb-grn-lt txt-black-24 ">{{$valRes['gcn_seq']}}</td>
                    <td class="bg-gray-e txt-black-24 ">{{$valRes['ndc']}}</td>
                    <td class="bg-gray-e txt-blue txt-blue">{{$valRes['upc']}}</td>
                    <td class="bg-tb-pink txt-red txt-red">{{$valRes['rx_label_name']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['strength']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['dosage_form']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ing_pc cnt-right">{{$valRes['unit_price']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ cnt-right">{{$valRes['default_rx_qty']}}</td>

                </tr>                                                      
                @endforeach
                @else
                    <tr>
                        <td style="text-align: center;" colspan="12">No data available in table</td>
                    </tr>
                @endif                                                                    
        </tbody>
    </table>
                        
                    </div>
                </div>
            <!-- </div> -->
      
    
        
                                        
                                                
                                    </div>
                                </div>
                                
                            </div>
                         </div>
                      
                    </div>

                    <div id="view-sponsor-tab" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
                        <div class="row" >
                            <div class="col-sm-12" style="border: solid 1px #dee2e6; margin-top: 0px;">
                                
                                <div class="row">
                                    <div class="col-sm-12 pos-rel_ pl-0 pr-0">
							             <div class="trow_ mt-14_ pl-14_ pr-14_">
							                 <span class="elm-left fs-17_ weight_600 txt-blue" style="line-height: 33px;">Viewed Sponsor Drug</span>
							             </div>

				                <div class="row mt-7_ mb-17_ mr-0 ml-0 pr-14_ pl-14_">
				                    <div class="col-sm-12 pr-0 pl-0 table-responsive pb-7_">
				                    <table class="table reports-bordered compliance-user-table data-table" >
							        <thead>
							            <tr> 
							                <th class="bg-gray-1 txt-wht generic_for">GCNSEQ</th>
							                <th class="bg-blue txt-wht refill_next" style="white-space:nowrap;">Pop Up Presented</th>
							                <th class="bg-gray-80 txt-wht rx_sell_price" style="white-space:nowrap;">Rx Label Name</th>
							                <th class="bg-gr-bl-dk txt-wht cnt-center rx_no" style="white-space:nowrap;">Generic For</th>
							                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">ING COST/unit</th>
							                <th class="bg-orage txt-wht therap_cat" style="white-space:nowrap;">Manufactuer</th>   
							            </tr>
							        </thead>
				        <tbody id="tbodies_data">
				        	@if(isset($view_drugs) && count($view_drugs)>0)
				        	@foreach($view_drugs as $key=>$val)
				        	<tr>
				        		<td class="bg-tb-grn-lt txt-black-24 ">{{$val['gcn_seq']}}</td>
				        		<td class="bg-tb-blue-lt txt-black-24 cnt-center" >{{$val['popup_presented']}}</td>
				        		<td class="bg-tb-pink txt-red txt-red" >{{$val['rx_label_name']}}</td>
				        		<td class="bg-tb-pink-lt generic-for-report tt_uc_ cnt-left">{{$val['brand_reference']}}</td>
				        		<td class="bg-tb-pink-lt cnt-left txt-black-24 ing_pc cnt-right">{{$val['unit_price']}}</td>
				        		<td class="bg-tb-orange-lt txt-orange cnt-left tt_uc_ ">{{$val['marketer']}}</td>
				        	</tr>
				        	@endforeach
				        	@else
				        	<tr><td style="text-align: center;" colspan="6">No Records Found</td></tr>
				        	@endif
				                                                                              
				        </tbody>
				    </table>
				                        
				                    </div>
				                </div>
          
      
    
        
                                        
                                                
                                    </div>
                                </div>
                                
                            </div>
                         </div>
                      
                    </div>
                    <div id="survey-tab" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
                        @include('partials.modal.survey_tab')
                      
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
<div class="hide" style="display: none;" id="empty_clon_enrol">
    <div class="elm-left"> <span class="txt-blue mr-4_" id="count_text">Replace_Str</span><span class="weight_600" id="title_cont-rep_index_count">&hellip;empty</span> </div>
    <div class="elm-right">
        <div class="cnt-right c-dib_" id="inner_btn_rep_index_count"><a href="javascript:void(0);"  index-count="rep_index_count" image-type='rep_type' page-id="2" data-toggle="modal" data-target="#sponsors-Modal_enrol" class="mr-3_ txt-blue hover-black-child_ weight_600">+ Add</a> </div>
    </div>
</div>

<div class="modal" id="drug-Unspons-Modal" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog wd-87p-max_w_700">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht" id="spons-modal-heading">Remove Sponsored Drug</h4>
    
           
           <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
        </div>
        <form  novalidate="novalidate" action="javascript:void(0);" id="product_form2" name="drug_form" method="post" >
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                <span class="site-red-color fs-14_ all-order-error" style="display: none;font-weight: bold;"> Please fill required fields </span>
            </div>
            </div>
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="flds-rxl-ndc-gbc flx-justify-start mb-14_">
                                <div class="wd-62p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">Rx Label Name:</label>
                                    <input class="wd-100p trow_" type="text" required
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="rx_label_name" id="rx_label_name" maxlength="25" disabled>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-21p field field-modal fld-ndc">
                                    <label class="wd-100p">NDC:</label>
                                    <input class="wd-100p" placeholder="xxxxx-xxxx-xx" mask="00000-0000-00" type="text" name="ndc" id="ndc" required disabled>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-30p field field-modal fld-mrc">
                                  <label class="wd-100p">UPC:</label>
                                  <input class="wd-100p" type="text"  id="upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc" disabled>
                                </div>
                                <!-- <div class="wd-15p field field-modal fld-ndc">
                                    <label class="wd-100p">G/ B/ CMP:</label>
                                    <input class="wd-100p" type="text" required maxlength="3" minlength="1" pattern="^[a-zA-Z\-_\s]+$"
                                     name="generic_or_brand" id="generic_or_brand">
                                </div> -->
                                
                            </div>

                            <div class="flds-st-df-ing-rxq flx-justify-start mb-14_">
                                <div class="wd-23p field field-modal fld-strength">
                                    <label class="wd-100p">Strength:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text" pattern="^[a-zA-Z\d\-_./\(),'\s]+$" name="strength" maxlength="15" id="strength" required disabled>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-38p field field-modal fld-dosage-form">
                                    <label class="wd-100p">Dosage Form:</label>
                                    <input class="wd-100p" type="text" required  pattern="^[a-zA-Z\-_.\s]+$" id="dosage_form" maxlength="21" name="dosage_form" disabled>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-16p field field-modal fld-gcnseq">
                                    <label class="wd-100p">GCNSEQ:<span class="txt-red"></span></label>
                                    <input class="wd-100p" type="text"  id="gcnseq_drgmnt" name="gcn_seq" pattern="[0-9]" mask="000000" onKeyPress="return numericOnly(event,6)" disabled>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-18p field field-modal fld-ing-cost-unit">
                                    <label class="wd-100p">ING Cost / Unit:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text"  name="unit_price" maxlength="8" required  id="unit_price">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-18p field field-modal fld-df-rx-qty">
                                    <label class="wd-100p">Default Rx Qty:</label>
                                    <input class="wd-100p" type="number" name="default_rx_qty" required pattern="[0-9]" mask="000000" maxlength="6" onKeyPress="return numericOnly(event,6)" id="default_rx_qty" disabled>
                                </div>
                            </div>

                            <!-- <div class="flds-dea-gcn-br-mrc flx-justify-start mb-14_"> -->
                                <!-- <div class="wd-14p field field-modal fld-dea">
                                    <label class="wd-100p">DEA Class:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" name="dea" pattern="[0-9]" mask="0000" required minlength="1" onKeyPress="return numericOnly(event,4)" id="dea" type="number">
                                </div> -->
                                <!-- <div class="wd-1p"></div> -->
                                <!-- <div class="wd-16p field field-modal fld-gcnseq">
                                    <label class="wd-100p">GCNSEQ:<span class="txt-red"></span></label>
                                    <input class="wd-100p" type="text"  id="gcnseq_drgmnt" name="gcn_seq" pattern="[0-9]" mask="000000" onKeyPress="return numericOnly(event,6)">
                                </div> -->
                                <!-- <div class="wd-1p"></div> -->
                                <!-- <div class="wd-29p field field-modal fld-br-ref">
                                    <label class="wd-100p"><span class="txt-red">Brand Reference:</span></label>
                                    <input class="wd-100p" type="text" required name="brand_reference" pattern="^[a-zA-Z\-_.\s]+$" maxlength="26" id="brandReference-drgmnt">
                                </div> -->
                                <!-- <div class="wd-1p"></div> -->
                                <!-- <div class="wd-38p field field-modal fld-mg-rp-cs">
                                    <label class="wd-100p">Major Reporting Class:</label>
                                    <input class="wd-100p" type="text" autocomplete="off" pattern="^[a-zA-Z\-_.\s]+$" maxlength="50" id="major_reporting_cat" name="major_reporting_cat" required>
                                </div> -->
                            <!-- </div> -->

                            <!-- <div class="flds-dea-gcn-br-mrc flx-justify-start mb-14_"> -->

                                <!-- <div class="wd-30p field field-modal fld-marketer">
                                    <label class="wd-100p">Marketer:<span class="txt-red">*</span></label>
                                  <input class="wd-100p" type="text"  pattern="^[a-zA-Z\-_.\s]+$" maxlength="20"  required name="marketer" id="marketer">
                              </div>
                              <div class="wd-1p"></div>
                              <div class="wd-40p field field-modal fld-mrc">
                                  <label class="wd-100p">Minor Reporting Class:</label>
                                  <input class="wd-100p" type="text" required id="minor_reporting_class" pattern="^[a-zA-Z\-_.\s]+$" maxlength="50" autocomplete="off" name="minor_reporting_class">
                              </div> -->
                                 <!-- <div class="wd-1p"></div> -->
                              <!-- <div class="wd-30p field field-modal fld-mrc">
                                  <label class="wd-100p">UPC:</label>
                                  <input class="wd-100p" type="text"  id="upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc">
                              </div> -->
                          <!-- </div> -->

                          <div class="flds-rxl-ndc-gbc flx-justify-start mb-14_">
                                <div class="wd-20p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">Sponsor Source:</label>
                                    <input class="wd-100p trow_ spon_field" type="text" 
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="sponsor_source" maxlength="15">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-18p field field-modal fld-ndc">
                                    <label class="wd-100p">Sponsor Item #:</label>
                                    <input class="wd-100p spon_field"  type="text" name="sponsor_item" id="ndc"  maxlength="10" pattern="^[a-zA-Z\d\-_\s]+$">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-60p field field-modal fld-ndc">
                                    <label class="wd-100p">Order Web Link:</label>
                                    <input class="wd-100p spon_field" type="text"  maxlength="50"
                                     name="order_web_link" >
                                </div>
                                <input name="sponsored_product" type="hidden" value="" />
                            </div>

                          <!-- <div class="flds-sponsor flx-justify-start">

                                <div class="field field-modal fld-sponsor">
                                    <label class="wd-100p cur-pointer"><input type="checkbox" class="circled large" id="sponsored" name="sponsored_product" value="Y"><span class="txt-blue">Sponsored</span></label>
                              </div>

                          </div> -->

                        </div>
                    </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
                <div class="flx-justify-start wd-100p">
                  
                  <button id="submitOrder1" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">Unsponsored</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>
  
@include('partials.modal.sponsors_maintenance')

@endsection


@section('js')

	@include('partials.js.sponsor_js')
    @include('partials.js.sponsor_js_enrol')
    @include('partials.js.drug_js')

        

@endsection

