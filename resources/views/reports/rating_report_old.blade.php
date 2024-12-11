@extends('layouts.compliance')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/jqueyDatatables/jquery.dataTables.min.css')}}">

<style>
.stats-exp-col-row { overflow: hidden; }
.stats-exp-col-row:after {display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;content: "\f067";color: #fff;background-color: #3e7bc4;text-align: center;font-size: 13px;position: absolute;top: 6px;right: 7px;width: 17px;height: 17px;line-height: 17px;border-radius: 2px;}
.stats-exp-col-row[aria-expanded="false"]:after { content: "\f067"; }
.stats-exp-col-row[aria-expanded="true"]:after { content: "\f068"; }

.stats-exp-wrapper:nth-child(odd) { background-color: #f2f2f2; }
.stats-exp-wrapper:nth-child(even) { background-color: #fff; }

.stats-exp-col-row .action-buttons_txt-eml-cl { margin-left: auto; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-text_ { position: relative; border: solid 1px transparent !important; color: #3e7bc4; background-color: transparent; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-email_ { position: relative; border: solid 1px transparent !important; color: #3e7bc4; background-color: transparent; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-call_ { position: relative; border: solid 1px transparent !important; color: #3e7bc4; background-color: transparent; }

.stats-exp-col-row .action-buttons_txt-eml-cl button { max-width: 40px; padding: 0px; margin-bottom: 0px; }
.stats-exp-col-row .action-buttons_txt-eml-cl button .btn-ico_ {font-size: 14px;font-weight: 600 !important;border: solid 2px transparent;padding: 2px 2px;width: 24px;height: 24px;line-height: 14px; }
.stats-exp-col-row .action-buttons_txt-eml-cl button .btn-txt_ { margin-top: 3px; }

.stats-exp-col-row .action-buttons_txt-eml-cl button:hover .btn-ico_ { font-weight: 400 !important; }
.stats-exp-col-row .action-buttons_txt-eml-cl button:hover .btn-txt_ { font-weight: 600 !important; }

.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-text_ .btn-ico_ { border: solid 2px #d69812; line-height: 15px; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-email_ .btn-ico_ { border: solid 2px #9bc90d; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-call_ .btn-ico_ { border: solid 2px #7964b9; line-height: 17px; }


.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-text_:hover .btn-ico_ { background-color: #d69812; color: #fff; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-email_:hover .btn-ico_ { background-color: #9bc90d; color: #fff !important;}
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-call_:hover .btn-ico_ { background-color: #7964b9; color: #fff !important; }


.elm-left-cl { float: left; clear: both; }
.mr-1vw { margin-right: 1vw; }


ul#date-list { display: flex; justify-content: space-between; margin-top: 0px; margin-bottom: 0px; }
ul#date-list:before { content: ''; position: absolute; top: 7px; left: 0px; width: 100%; height: 4px; background-color: #d9d9d9; z-index: 7; }
ul#date-list li {  }
ul#date-list li span.vertical-bar { width: 4px; height: 17px; position: relative;}

ul#date-list li:first-child span.vertical-bar:before { content: ''; position: absolute; right: 100%; top: 7px; background-color: #f2f2f2; width: 140px; height: 4px; }
ul#date-list li:last-child span.vertical-bar:after { content: ''; position: absolute; left: 100%; top: 7px; background-color: #f2f2f2; width: 140px; height: 4px; }
ul#date-list li span.date {  }


.stats-exp-wrapper:nth-child(odd) ul#date-list li:first-child span.vertical-bar:before { background-color: #f2f2f2; z-index: 10; }
.stats-exp-wrapper:nth-child(odd) ul#date-list li:last-child span.vertical-bar:before { background-color: #f2f2f2; z-index: 10; }

.stats-exp-wrapper:nth-child(even) ul#date-list li:first-child span.vertical-bar:before { background-color: #fff; z-index: 10; }
.stats-exp-wrapper:nth-child(even) ul#date-list li:last-child span.vertical-bar:before { background-color: #fff; z-index: 10; }


.top-row-stats {  }
.top-row-stats .left-heading {color: #9bc90d;font-weight: 600;text-transform: uppercase;}
.top-row-stats .right-score {  }
.top-row-stats .right-score .title_ {float: left;font-size: 12px;line-height: 12px;font-weight: 500;margin-right: 4px;}
.top-row-stats .right-score .value_ {float: right;}


#refill-stats {display: flex;justify-content: center;padding-top: 40px;margin-top: -7px;padding-left: 16px;}
#refill-stats li { min-width: 16%; position: relative;}
#refill-stats li.red-stats {  }
#refill-stats .red-stats .red-line {width: 100%;height: 11px;background-color: #ec1717;min-height: 11px;display: inline-block;}
#refill-stats .red-stats .red-line + .tri-angle { border: solid 11px transparent;border-bottom-color: brown;position: absolute;left: 40%;left: 24px;top: 3px;width: 20px;border-bottom-width: 24px; }
#refill-stats .red-stats .overdue-days {color: #ec1717;text-align: center;width: 100%;display: inline-block;font-size: 14px;font-weight: 600;line-height: 28px;}
#refill-stats li.blue-stats {  }
#refill-stats .blue-stats .refill-info {position: absolute;width: 80px;top: -27px;left: -16px;height: 47px;}
#refill-stats .blue-stats .refill-info .refill-price {color: #9bc90d;width: 100%;display: inline-block;font-weight: bold;}
#refill-stats .blue-stats .refill-info .refill-circle {width: 32px;height: 32px;background-color: #d1d1d1;display: inline-block;text-align: center;border-radius: 50%;font-size: 22px;font-weight: 600;line-height: 32px;margin-top: 0px;}
#refill-stats .blue-stats .blue-line {width: 100%;height: 11px;background-color: #3e7bc4;min-height: 11px;display: inline-block;}
#refill-stats .blue-stats .blue-line + .tri-angle { border: solid 11px transparent;border-bottom-color: brown;position: absolute;right: 17%;right: 24px;top: 3px;width: 20px;border-bottom-width: 24px; }


ul#refill-stats-mrd {display: flex;justify-content: center;padding-top: 40px;padding-top: 17px;padding-top: 0px;margin-top: -7px;padding-left: 16px;padding-bottom:17px; }
ul#refill-stats-mrd:before { content: '';width: 100%;position: absolute;bottom: 22px;left: 0px;height: 4px;background-color: #ddd;border-radius: 4px; }
ul#refill-stats-mrd:after {  }
ul#refill-stats-mrd li { min-width: 16%; position: relative;}
ul#refill-stats-mrd li.red-stats {  }
ul#refill-stats-mrd .red-stats .red-line {width: 100%;height: 11px;background-color: #ec1717;min-height: 11px;display: inline-block;}
ul#refill-stats-mrd .red-stats .overdue-days {color: #ec1717;text-align: center;width: 100%;display: inline-block;font-size: 14px;font-weight: 600;line-height: 28px;margin-top: -7px;}
ul#refill-stats-mrd li.blue-stats {  }
ul#refill-stats-mrd .blue-stats .refill-info {position: relative;top: 25px;left: -16px;}
ul#refill-stats-mrd .blue-stats .refill-info .refill-price {color: #9bc90d;width: 100%;display: inline-block;font-weight: bold;}
ul#refill-stats-mrd .blue-stats .refill-info .refill-circle {width: 32px;height: 32px;background-color: #d1d1d1;display: inline-block;text-align: center;border-radius: 50%;font-size: 22px;font-weight: 600;line-height: 32px;margin-top: 0px;}
ul#refill-stats-mrd .blue-stats .refill-info .refill-date { position: relative; left: -7px; bottom: 0px; }
ul#refill-stats-mrd .blue-stats .refill-info .refill-date:before { content: ''; }
ul#refill-stats-mrd .blue-stats .refill-info .refill-date:after { content: '';position: absolute;width: 4px;height: 17px;background-color: #ddd;border-radius: 4px;left: 50%;margin-left: -3px;bottom: 100%; }
ul#refill-stats-mrd .blue-stats .blue-line {width: 100%;height: 11px;background-color: #3e7bc4;min-height: 11px;display: inline-block;}

ul#refill-stats-mrd li.first_li { min-width: 10px;position: absolute;bottom: 0px;left: 7px; }
ul#refill-stats-mrd li.first_li .refill-date { position: relative; }
ul#refill-stats-mrd li.first_li .refill-date:before { content: '';position: absolute;right: 60%;top: -11px;background-color: #f2f2f2;width: 70px;height: 7px; }
ul#refill-stats-mrd li.first_li .refill-date:after { content: '';position: absolute;width: 4px;height: 17px;background-color: #ddd;border-radius: 4px;left: 43%;margin-left: -3px;bottom: 100%; }
ul#refill-stats-mrd li.last_li { min-width: 10px;position: absolute;bottom: 0px;right: 10px; }
ul#refill-stats-mrd li.last_li .refill-date { position: relative; }
ul#refill-stats-mrd li.last_li .refill-date:before { content: '';position: absolute;left: 43%;top: -11px;background-color: #f2f2f2;width: 70px;height: 7px;}
ul#refill-stats-mrd li.last_li .refill-date:after { content: '';position: absolute;width: 4px;height: 17px;background-color: #ddd;border-radius: 4px;left: 43%;margin-left: -3px;bottom: 100%; }

</style>
{{--<div class="col-sm-3 col-lg-2 sidebar-item"> --}}
  {{--  @include('includes.left_menu') --}}
{{-- </div> --}}


{{--<div class="col-sm-9 col-lg-10"> --}}
    <div class="row mt-7_ ml-0 mr-0 " style="border-bottom: solid 1px #cecece;">
        <div class="col-sm-12 pl-0 pr-0">
            <h4 class="elm-left fs-24_ mb-3_">Compliance Rate by Drug</h4>
        </div>
    </div>

    <div class="row mt-17_">
        <div class="col-sm-12">
            <div class="flx-justify-start f-wrap pt-14_">	
                <div class="wd-100p br-rds-1 mb-24_ stats-exp-wrapper" style="border: solid 1px #cecece;">						
                    <div  data-target="#expand-collpase-div{{$pat->RxNumber}}" data-toggle="collapse" aria-expanded="true" order-id="{{$pat->order_id}}" rx-number="{{$pat->RxNumber}}" class="trow_ cur-pointer stats-exp-col-row cnt-left pos-rel_ collapsed">							
                        <div id="expand-collpase-div{{$pat->RxNumber}}" class="trow_ pos-rel_ p8-12_ collapse show" style="padding-right: 40px; min-height: 70px; border-bottom: solid 1px #cecece;">								
                            <div class="trow_ top-row-stats">
                                <div class="elm-left left-heading">Pt. out of pocket</div>
                                {{--<div class="elm-right right-score">
                                        <span class="txt-red title_">Total<br>Score</span>
                                        <span class="txt-red value_ fs-24_ weight_600">@if(count($statistics)>0){{number_format($total_delays/(count($statistics)+1), 2)}}@else{{ '0' }}@endif</span>
                                </div>--}}
                            </div>								
                            <ul id="refill-stats">
        @if($statistics)
                @foreach($statistics as $stat)

             
                       @php 
                                $dates[] = $stat->LastRefillDate;
                                $dates[] = $stat->refill_date;
                        @endphp
                        {{-- <li class="first_li"><span class="refill-date ">{{ date('m/d/y' , strtotime($stat->LastRefillDate))}}</span></li>
                        --}}
                        @if(isset($stat->delay) and $stat->delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->delay/$total_days)*100}}%">
                                <span class="red-line"></span>
                                <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->delay}}</span> Days Overdue..</span>
                        </li>
                        @endif
                        @if(isset($stat->total_days) and $stat->total_days  > 0)
                        <li class="blue-stats"  style="width: {{($stat->refillDays/$total_days)*100}}%;">
                                <div class="refill-info" title="Refill Date : {{$stat->refill_date}}">
                                        <span class="refill-price">${{$stat->RxPatientOutOfPocket}}</span>
                                        <span class="refill-circle">R</span>
                                        {{-- <span class="refill-date">{{ date('m/d/y' , strtotime($stat->refill_date))}}</span> --}}
                                </div>
                                <span class="blue-line"></span>
                        </li>
                        @endif
                        @if(isset($stat->end_delay) and $stat->end_delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->end_delay/$total_days)*100}}%">
                                
                                <span class="red-line"></span>
                                <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->end_delay}}</span> Days Overdue..</span>
                        </li>
                        @endif
                @endforeach
                
               
                
        @endif
</ul>			





<ul id="refill-stats-mrd">
        @if($statistics)
                @foreach($statistics as $stat)

             
                       @php 
                                $dates[] = $stat->LastRefillDate;
                                $dates[] = $stat->refill_date;
                        @endphp
                         <li class="first_li"><span class="refill-date ">{{ date('m/d/y' , strtotime($stat->LastRefillDate))}}</span></li>
                        @if(isset($stat->delay) and $stat->delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->delay/$total_days)*100}}%">
                                {{-- <span class="red-line"></span> --}}
                                {{-- <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->delay}}</span> Days Overdue..</span> --}}
                        </li>
                        @endif
                        @if(isset($stat->total_days) and $stat->total_days  > 0)
                        <li class="blue-stats"  style="width: {{($stat->refillDays/$total_days)*100}}%;">
                                <div class="refill-info" title="Refill Date : {{$stat->refill_date}}">
                                        {{-- <span class="refill-price">${{$stat->RxPatientOutOfPocket}}</span> --}}
                                        {{-- <span class="refill-circle">R</span> --}}
                                        <span class="refill-date">{{ date('m/d/y' , strtotime($stat->refill_date))}}</span>
                                </div>
                                {{-- <span class="blue-line"></span> --}}
                        </li>
                        @endif
                        @if(isset($stat->end_delay) and $stat->end_delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->end_delay/$total_days)*100}}%">
                                
                                {{-- <span class="red-line"></span> --}}
                                {{-- <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->end_delay}}</span> Days Overdue..</span> --}}
                        </li>
                        @endif
                @endforeach
                
                <li class="last_li"><span class="refill-date ">@php echo date('m/d/Y'); @endphp</span></li>

                
        @endif
</ul>	
                        </div>
                        
                        <div class="pos-abs_ flx-justify-end txt-sline right-score" style="top: 4px;right: 40px;">
                            <span class="txt-red title_ pt-2_ fs-13_ lh-12_" style="width: 40px;white-space: normal;">Total Score</span>
                            <span class="txt-red value_ fs-24_ weight_600">@if(count($statistics)>0){{number_format($total_delays/(count($statistics)+1), 2)}}@else{{ '0' }}@endif</span>
                        </div>
                        
                        <div class="row mr-0 ml-0 mt-7_">
                            <div class="col-sm-12 pr-0 pl-0">
                                <div class="flx-justify-start f-wrap ml-10_" style="align-items: stretch;">
                                    <div class="flx-justify-start f-wrap flex-vr-center bg-yellow2 user-info c-dib_ pl-6_ pr-6_" style="background-color: #f2e1b6; border-right: solid 1px #cecece; width: 17%; align-content:center;">
                                        <div class="wd-100p user-name fs-15_ weight_600 tt_uc_ no-wrap-text">{{$pat->patient_name}}</div>
                                        <div class="wd-100p mt-2_ no-wrap-text c-dib_">
                                            <span class="gender d-ib_ fs-13_">{{$pat->Gender}}</span>
                                            <span class="fs-10_ d-ib_" style="vertical-align: baseline;">DOB:</span>
                                            <span class="dob d-ib_ no-wrap-text fs-13_"> {{$pat->dob}} ({{$pat->age}} Years)</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flx-justify-start f-wrap flex-vr-center rx-info bg-grn-lt2 c-dib_ txt-blue pl-6_ pr-6_" style="background-color: #e5f1c1; border-right: solid 1px #cecece; width: 20%; align-content:center;">
                                        <span class="wd-100p  rx-no fs-13_ no-wrap-text">Rx# {{$pat->RxNumber}}</span>
                                        <div class="wd-100p mt-2_ rx-no ">
                                        	<span class="trow_ c-dib_ fs-13_ no-wrap-text weight_600">{{$pat->rx_label_name}}</span>
                                        	<span class="trow_ c-dib_ fs-13_ no-wrap-text" >{{$pat->strength_dosage}}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flx-justify-start f-wrap flex-vr-center generic-info bg-blue-lt2 txt-blue tt_lc_ pl-6_ pr-6_ c-dib_ fs-13_ mrf-0_" style="background-color: #dcedff; border-right: solid 1px #cecece; width: 23%;align-content:center;">
                                        <span class="wd-100p ">(Minor Cat: <span class="txt-red tt_cc_ fs-13_">{{$pat->minor}}</span>)</span>
                                        <span class="wd-100p mt-2_ ">(generic for: <span class="txt-red tt_cc_ fs-13_">{{$pat->marketer}}</span>)</span>
                                    </div>
                                    
                                    <div class="flx-justify-center f-wrap flex-vr-center pl-6_ pr-6_ pt-4_ bg-gray-e" style="width: 23%;max-width: 220px;align-content:center;">
                                    	<button class="btn bg-wht-txt-blue weight_500 tt_uc_ pr-4_ pl-4_ mr-4_ mb-4_ no-wrap-text fs-11_" style="width: 100px;">qty: {{$pat->quantity}}</button>
                                    	<button class="btn bg-wht-txt-blue weight_500 tt_uc_ pr-4_ pl-4_ mr-4_ mb-4_ no-wrap-text fs-11_" style="width: 100px;">days supply: {{$pat->DaysSupply}}</button>
                                    	<button class="btn bg-wht-txt-blue weight_500 tt_uc_ pr-4_ pl-4_ mr-4_ mb-4_ no-wrap-text fs-11_" style="width: 100px;">refills remain: {{$pat->RefillsRemaining}}</button>
                                    	<button class="btn bg-wht-txt-red weight_500 pr-4_ pl-4_ mr-4_ mb-4_ no-wrap-text fs-11_" style="width: 100px;">Rx EXP: {{$pat->RxExpiryDate}}</button>
                                    </div>
                                    
                                    <div class="flx-justify-end flex-vr-end pl-6_ bg-gray-e action-buttons_txt-eml-cl" style="width: 17%;flex-grow:4;">								
                                        <button class="ab-email_ pa-0_ mt-7_ pos-rel_ mr-1p" title="Send Survey" id="send_survey" pat_id="{{$pat->PatientId}}">
											<span class="trow_ btn-ico_ txt-grn-lt br-rds-50p"><i class="fa fa-list-ol"></i></span>
											<span class="trow_ btn-txt_ txt-blue weight_500 fs-11_ tt_uc_">Survey</span>
										</button>
										
                                        <button class="ab-text_ pa-0_ mt-7_ pos-rel_ mr-1p" title="Send Message">
                                                <span class="trow_ btn-ico_ fa fa-commenting-o txt-orange br-rds-50p" onclick="orderMessages({{$pat->order_id}}, '{{$pat->RxNumber}}',`{{$pat->rx_label_name." ".$pat->major_reporting_cat}}`,'{{$pat->strength}}','{{$pat->p_name}}',{{$pat->PracticeId}},{{$pat->PatientId}}, '{{$pat->patient_name}}')"></span>
                                                <span class="trow_ btn-txt_ txt-blue weight_500 fs-11_ tt_uc_" >message</span>
                                        </button>
										
                                        <button class="ab-call_ pa-0_ mt-7_ pos-rel_ fs-11_ patient_phone" title="{{$pat->phone_no}}">
                                                <span class="trow_ btn-ico_ fa fa-phone txt-purple br-rds-50p"></span>
                                                <span class="trow_ btn-txt_ txt-blue weight_500 fs-11_ tt_uc_">call</span>
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>


                    </div>
                </div>               
            </div>

        </div>
    </div>
{{--</div> --}}



<div class="modal" id="survey_modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">
        
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					<div class="col-sm-12 modal-header">
                                            <h4 class="modal-title" style="color:white;">Send Survey</h4>
                                        </div>
                                        <div id="practice-reg-step" class="tab-content current">
                                                    <div class="col-sm-12 pl-0 pr-0">
                                                            <div class="flds-prc-type-name flx-justify-start mb-14_ mt-36_ ml-7_">
                                                                <div class="field">
                                                                        <label class=" mb-4_ txt-gray-6 cnt-left">Search Survey:</label>
                                                                        <select class="wd-100p tt_uc_ txt-blue weight_600" name='survey_id' id='survey_id'>
                                                                            <option value="">Select Survey</option>
                                                                            @foreach($survey_data as $cData)
                                                                            <optgroup label="{{$cData->title}}">
                                                                                @foreach($cData->Survey as $sData)
                                                                                    <option value="{{$sData->id}}">{{$sData->title}}</option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                            @endforeach
                                                                        </select>
                                                                </div>                                                                
                                                            </div>
                                                            <span id='error_phone_number' style='display:none; color:red; margin-left: 10px;'>Please Select a Survey.</span>
                                                    </div>
                                                <div class="container mt-36_" style="padding-left: 5px;">        
                                                    <button type="button" id="send_survey_btn" data-dismiss="modal" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">Send Survey</button>
                                                    <button type="button" id="preview_survey" class="btn bg-yellow weight_500 fs-14_ tt_uc_" style="display:none;">Preview</button>
                                                    <button id="cancel_btn" type="button" data-dismiss="modal" class="btn bg-red-txt-wht weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
                                                </div>
                                        </div>
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; display: none;">
      </div>

    </form>
  </div>
</div>

<div class="modal" id="phoneShow" style="display:none;">
    <div class="modal-dialog" style="min-width:800px">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Patient Phone Number</h4>
        <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">X</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" >  
                <h2>Phone Number : <span style="vertical-align: middle;" id="phoneListing">(979) 797-9797</span></h2>        
        </div>
        <!-- Modal footer -->
        <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal" id="hcp_message_modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">
        
      <!-- Modal body -->
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12 modal-header">
                                            <h4 class="modal-title" style="color:white;">Pharmacy Message</h4>
                                        </div>
                                        <div id="practice-reg-step" class="tab-content current">
                                                    <div class="col-sm-12 pl-0 pr-0">
                                                            <div class="flds-prc-type-name flx-justify-start mb-14_ mt-36_ ml-7_">
                                                                
                                                                <div class="field wd-100p">
                                                                        
                                                                        <textarea class="wd-100p" style="height: 80px;"></textarea>
                                                                </div>                                                                
                                                            </div>
                                                            
                                                    </div>
                                                <div class="container mt-36_" style="padding-left: 5px;">        
                                                    <button type="button" data-dismiss="modal" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">Send</button>
                                                    <button id="cancel_btn" type="button" data-dismiss="modal" class="btn bg-red-txt-wht weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
                                                </div>
                                        </div>
                </div>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; display: none;">
      </div>

    </form>
  </div>
</div>
@include('practice_module.patient_order_request.modal.patient_message_modal')
@endsection

@section('js')
@include('partials.js.patient_profile_js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
<script src="{{url('/js/form-render.min.js')}}"></script> 
<script src="{{url('/js/control_plugins/starRating.js')}}"></script> 
<script type="text/javascript">
    $(document).ready(function(){

        $('.patient_phone').each(function(){
            console.log($(this).attr('title'));
            var pho = $(this).attr('title');
            $(this).attr('title', pho.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3'));
        });

        
         $('.patient_phone').click(function(e){
            e.preventDefault();
            $('#phoneListing').html($(this).attr('title'));
            $('#phoneShow').modal('show');
            return false;
            
        });
        
        $('#send_survey').click(function(e){
            e.preventDefault();
            $('#survey_modal').modal('show');
            return false;
            
        });

        $('#message_icon').click(function(e){
            e.preventDefault();
            $('#hcp_message_modal').modal('show');
            return false;
            
        });
		
        $('.patient_name').click(function(e){
            e.preventDefault();
            location.href="{{url('specific-patient-orders')}}/"+$(this).attr('patient_id');
            return false;
        });

        $('#send_survey_btn').on('click', function(){
        
        var selected = [];            
        selected.push($('#send_survey').attr('pat_id'));
        
        if($("#survey_id option:selected").val() == ""){
            toastr.error('Please select a survey.');
        }else{
             $.ajax({
                type:'POST',
                url:"{{url('/send-bulk-surveys')}}",
                data: 'survey_id='+$("#survey_id option:selected").val()+'&patients='+selected,
                success:function(data) {
                    
                        if(data == 1){
                            toastr.success('Survey sent successfully.');                
                        }else{
                           toastr.error('There is some error occured while sending survey.');      
                        }
                        
                        $("#send_bulk_survey").prop('disabled', false);      
                    },
                     headers: {
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
        }
        
        });

        $('#survey_id').change(function(){
        var selected = $("#survey_id option:selected").val();  
        console.log("Selected:"+selected);
        if(selected != ""){
            $('#preview_survey').show();
        }else{
            $('#preview_survey').hide();
        }
    });
    
    $('#preview_survey').click(function(){
       var selected = $("#survey_id option:selected").val();
       showPreview($('#detail'+selected).val());
    });
    
    function showPreview(formData) 
    {
        var HeaderImgPath = "";
        var selected = $("#survey_id option:selected").val();
        var formData =  $('#detail'+selected).val();
         let formRenderOpts = {
            dataType: 'json',
            formData
          };
          let $renderContainer = $('<form/>');
          $renderContainer.formRender(formRenderOpts);
          let html = `<!doctype html><title>Form Preview</title><body class="container">`;
              if(HeaderImgPath != "")
                html += `<div style="text-align:center;"><img src="{{ !empty($header_image_path)? url($header_image_path): ''}}" style="max-width: 200px; margin:20px 0px;"></div>`;
            html += `<div class="trow_ cnt-center c-dib_ mt-14_ mb-14_"><span class="fs-24_ tt_cc_ txt-grn-lt weight_600 br-top-blue-w1 br-bottom-blue-w1 pl-2_ pr-2_">`+$("#survey_id option:selected").text()+`</span>`;
            html += `</div><h4 style="text-align:center; color:blue;">{{isset($theme->header_text)?$theme->header_text:''}}</h4><div class="trow_ cnt-center c-dib_ mt-24_ mb-14_">`;
            html += `<span class="fs-17_ tt_cc_ txt-blue weight_600">This is the first activity to fulfill your obligation in Compliance Reward. Please provide feedback about your experience.</span>`;
            html += `</div><hr>${$renderContainer.html()}<h4 style="text-align:center; color:blue;">{{isset($theme)?$theme->footer_text:''}}</h4><div class="trow_ mt-14_">`;
            html += `<button class="wd-100p btn bg-lt-grn-txt-wht weight_600 fs-17_ tt_uc_ pa-12_ mb-7_ cnr-center " style="line-height: 14px;">submit questionnaire</button>`;
            html += `</div></body></html>`;
          var formPreviewWindow = window.open('', 'formPreview', 'height=550,width=500,padding=20,toolbar=no,scrollbars=yes');

          formPreviewWindow.document.write(html);
          var style = document.createElement('link');
          style.setAttribute('href', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
          style.setAttribute('rel', 'stylesheet');
          style.setAttribute('type', 'text/css');
          formPreviewWindow.document.head.appendChild(style);

          var style1 = document.createElement('link');
          style1.setAttribute('href', "{{ asset('css/generic-survey-mobile.css') }}");
          style1.setAttribute('rel', 'stylesheet');
          style1.setAttribute('type', 'text/css');
          formPreviewWindow.document.head.appendChild(style1);
    } 
        
    });
</script>
@endsection