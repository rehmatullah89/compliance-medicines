@extends('layouts.compliance')

@section('content')
<style>


.elm-left-cl { float: left; clear: both; }
.mr-1vw { margin-right: 1vw; }

/*
ul#date-list { display: flex; justify-content: space-between; margin-top: 0px; margin-bottom: 0px; }
ul#date-list:before { content: ''; position: absolute; top: 7px; left: 0px; width: 100%; height: 4px; background-color: #d9d9d9; }
ul#date-list li {  }
ul#date-list li span.vertical-bar { width: 4px; height: 17px; position: relative;}

ul#date-list li:last-child span.vertical-bar:before { content: ''; position: absolute; left: 100%; top: 7px; background-color: #f2f2f2; width: 140px; height: 4px; }
ul#date-list li:first-child span.vertical-bar:before { content: ''; position: absolute; right: 100%; left:auto; top: 7px; background-color: #f2f2f2; width: 140px; height: 4px; }
ul#date-list li span.date {  }
*/

.stats-exp-wrapper:nth-child(odd) ul#date-list li:first-child span.vertical-bar:before { background-color: #f2f2f2; z-index: 10; }
.stats-exp-wrapper:nth-child(odd) ul#date-list li:last-child span.vertical-bar:before { background-color: #f2f2f2; z-index: 10; }

.stats-exp-wrapper:nth-child(even) ul#date-list li:first-child span.vertical-bar:before { background-color: #fff; z-index: 10; }
.stats-exp-wrapper:nth-child(even) ul#date-list li:last-child span.vertical-bar:before { background-color: #fff; z-index: 10; }

.top-row-stats {  }
.top-row-stats .left-heading {color: #9bc90d;font-weight: 600;text-transform: uppercase;}
.top-row-stats .right-score {  }
.top-row-stats .right-score .title_ {float: left;font-size: 12px;line-height: 12px;font-weight: 500;margin-right: 4px;}
.top-row-stats .right-score .value_ {float: right;}

/*
#refill-stats {display: flex;justify-content: center;padding-top: 40px;margin-top: -7px;padding-left: 16px;}
#refill-stats li { min-width: 16%; position: relative;}
#refill-stats li.red-stats {  }
#refill-stats .red-stats .red-line {width: 100%;height: 11px;background-color: #ec1717;min-height: 11px;display: inline-block;}
#refill-stats .red-stats .overdue-days {color: #ec1717;text-align: center;width: 100%;display: inline-block;font-size: 14px;font-weight: 600;line-height: 28px;}
#refill-stats li.blue-stats {  }
#refill-stats .blue-stats .refill-info {position: absolute;width: 80px;top: -27px;left: -16px;height: 47px;}
#refill-stats .blue-stats .refill-info .refill-price {color: #9bc90d;width: 100%;display: inline-block;font-weight: bold;}
#refill-stats .blue-stats .refill-info .refill-circle {width: 32px;height: 32px;background-color: #d1d1d1;display: inline-block;text-align: center;border-radius: 50%;font-size: 22px;font-weight: 600;line-height: 32px;margin-top: 0px;}
#refill-stats .blue-stats .blue-line {width: 100%;height: 11px;background-color: #3e7bc4;min-height: 11px;display: inline-block;}
*/
.stats-exp-wrapper:nth-child(odd) { background-color: #f2f2f2; }
.stats-exp-wrapper:nth-child(even) { background-color: #fff; }

.stats-exp-wrapper:nth-child(odd) .user-info-row { background-color: #f2f2f2; }
.stats-exp-wrapper:nth-child(even) .user-info-row { background-color: #f2f2f2; }

.stats-exp-col-row { overflow: hidden; }
/*.stats-exp-col-row:after {display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;content: "\f067";color: #fff;background-color: #3e7bc4;text-align: center;font-size: 13px;position: absolute;top: 10px;right: 7px;width: 17px;height: 17px;line-height: 17px;border-radius: 2px;}
.stats-exp-col-row[aria-expanded="false"]:after { content: "\f067"; }
.stats-exp-col-row[aria-expanded="true"]:after { content: "\f068"; }
*/

.stats-exp-col-row .total-score .plus-minus-symbol { width: 17px; height: 17px; margin-left: 6px; }
.stats-exp-col-row .total-score .plus-minus-symbol:after {display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;content: "\f067";color: #fff;background-color: #3e7bc4;text-align: center;font-size: 13px;position: absolute;top: 0px;right: 0px;width: 17px;height: 17px;line-height: 17px;border-radius: 2px;}
.stats-exp-col-row .total-score .plus-minus-symbol[aria-expanded="false"]:after { content: "\f067"; }
.stats-exp-col-row .total-score .plus-minus-symbol[aria-expanded="true"]:after { content: "\f068"; }


.stats-exp-col-row .refills-overdue-stats {  }
.stats-exp-col-row .refills-overdue-stats div.days-list { padding-top: 40px; padding-bottom: 49px; padding-left: 20px; padding-right: 20px; }

.stats-exp-col-row .refills-overdue-stats div.days-list div.days-container {  }
.stats-exp-col-row .refills-overdue-stats div.days-list div.days-container .days-overdue { position: absolute; bottom: 100%; padding-bottom: 4px; width: 100%; text-align: center; white-space: nowrap; color: #ec1717; font-weight: 600; font-size: 11px; line-height: 24px;}
.stats-exp-col-row .refills-overdue-stats div.days-list div.days-container .days-overdue .days-value { 
    /*font-size: 21px;*/
    font-size: 15px; line-height: 20px;}

.stats-exp-col-row .refills-overdue-stats div.days-list div.days-container div.day { width: 20px; height: 11px; }
.stats-exp-col-row .refills-overdue-stats div.days-list div.days-container div.day.blue-bg { background-color: #3e7bc4; }
.stats-exp-col-row .refills-overdue-stats div.days-list div.days-container div.day.red-bg { background-color: #ec1717; }

.stats-exp-col-row .refills-overdue-stats div.days-list div.day .refill-info {position: absolute; width: auto; top: -27px; left: -16px; height: 53px; z-index: 10;}
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .refill-info .refill-price {color: #9bc90d;width: 100%;display: inline-block;font-weight: bold;}
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .refill-info .refill-circle {width: 24px; 
     height: 24px;
    background-color: #d1d1d1;
    display: inline-block;
    text-align: center;
    border-radius: 50%;
    font-size: 14px;
    font-weight: 600;
    line-height: 25px;
    margin-top: 4px;}

.stats-exp-col-row .refills-overdue-stats div.days-list div.day .refill-info + .date-box .date-value { padding-top: 26px !important; left: 8px; }

.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box { position: absolute; top: 100%; left: 0px; z-index: 40; }
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .symbol { color: #7bc70d; color: #242424; color: #ec1717; }
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .symbol .triangle {  }
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .symbol .tickmark {position: relative;font-size: 10px;font-weight: bold;width: 14px;height: 13px;border: solid 1px #242424;display: inline-block;text-align: center;margin-top: 3px;padding-top: 1px;border-radius: 1px;}
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .symbol .tickmark:before {content: '';position: absolute;height: 4px;width: 80%;border: solid 1px #242424;top: -3px;left: 10%;}
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .date-value { position: absolute; font-weight: 600; transform: rotate(50deg); top: 100%; left: 6px; padding-top: 10px; font-size: 11px; }
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .triangle + .date-value { padding-top: 14px; }
.stats-exp-col-row .refills-overdue-stats div.days-list div.day .date-box .tickmark + .date-value { padding-top: 18px; }

.stats-exp-col-row .action-buttons_txt-eml-cl { margin-left: auto; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-text_ { position: relative; border: solid 1px transparent !important; color: #3e7bc4; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-email_ { position: relative; border: solid 1px transparent !important; color: #3e7bc4; }
.stats-exp-col-row .action-buttons_txt-eml-cl button.ab-call_ { position: relative; border: solid 1px transparent !important; color: #3e7bc4; }

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


ul#sidebar-menu li.comp-rate-drug-cat-menu {  }
ul#sidebar-menu li.comp-rate-drug-cat-menu > a { padding-left: 3px; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu_ver-l1 { background-color: #fff; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu_ver-l1 > li { border-bottom: 0px; text-transform: uppercase; background-color: #fff; color: #3e7bc4; padding: 2px 2px 2px 4px;}
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu_ver-l1 > li .exp-col-ico { position: relative; padding-left:17px; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu_ver-l1 > li .exp-col-ico:before { position: absolute;top: 0px;left: 0px;border: solid 1px #3e7bc4;width: 14px;height: 14px;border-radius: 50%;text-align: center;line-height: 11px;font-size: 9px;}
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu_ver-l1 > li .exp-col-ico[aria-expanded="false"]:before { content: '\2795'; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu_ver-l1 > li .exp-col-ico[aria-expanded="true"]:before { content: '\2796'; }

ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 { width: 100%; background-color: #fff;}
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 > li { cursor: pointer; position: relative; white-space: nowrap; text-transform: capitalize;display: inline-flex;width: 100%; border: 0px; padding: 2px;color: #242424;font-weight: 500;}
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 > li:hover { background-color: #afd13f; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 > li.active { background-color: #afd13f; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 > li .drug-subcat-name { margin-right: 6px; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 > li .dsn-counter { margin-left: auto; color: #ec1717; font-weight: 600; }

ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 { display: none; padding-left: 6px; position: absolute; top: 0px; left: 100%; width: 100%; z-index: 9999; }
ul#sidebar-menu li.comp-rate-drug-cat-menu ul.submenu-ver-l2 > li:hover div.submenu-hor-l3 { display: block; }
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul { background-color: #fff; border: solid 2px #fff; border-radius: 3px; box-shadow: 0px 4px 7px 1px #ccc; }
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li { cursor: pointer; display: flex; justify-content: flex-end;width: 100%; border-bottom: solid 1px #cecece; padding: 2px; }
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li .p-score { width: 86px;text-align: right;color: #ec1717;font-weight: 600;padding: 2px;text-transform: uppercase;padding-right: 10px;}
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li .p-name { text-align: left; color: #242424; font-weight: 500; margin-left: auto;padding: 2px;text-transform: uppercase; font-weight: 500;flex-grow: 1; text-align: left;}
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li:hover { background-color: #afd13f; }
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li:hover .p-name { font-weight: 600; }


ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li:first-child { background-color: #3e7bc4; color: #fff; }
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li:first-child .p-score { background-color: #3e7bc4;color: #fff;font-weight: 500 !important;white-space: break-spaces;text-align: left;}
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li:first-child .p-name { background-color: #3e7bc4; color: #fff; font-weight: 500 !important;}
ul#sidebar-menu li.comp-rate-drug-cat-menu div.submenu-hor-l3 > ul li:last-child { border-bottom: 0px; }
.less-width{
    width: 6px !important;
}
.wid-10{
    width: 2px !important;
}
.wid-15{
    width: 11px !important;
}
.min-wid{
    min-width: 104px;
}
.min-wid div.days-overdue { text-align: left !important;; }

</style>
{{-- <div class="col-sm-3 col-lg-2 sidebar-item">
    @include('includes.left_menu')
</div> --}}
<div class="col-sm-12 col-lg-12">
    <div class="row mt-7_ ml-0 mr-0 " style="border-bottom: solid 1px #cecece;">
        <div class="col-sm-12 pl-0 pr-0">
            <h4 class="elm-left fs-24_ mb-3_">Rx Compliance Reports</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="flx-justify-start f-wrap pt-14_">	
            @if($requests)
                @foreach($requests as $pat)
                
                  <div class="wd-100p br-rds-1 mb-14_ bg-gray-f2 odd-row stats-exp-wrapper" style="border: solid 1px #cecece;">  
                
                    <div class="trow_ cur-pointer stats-exp-col-row cnt-left pos-rel_ collapsed" order-id="{{$pat->order_id}}" rx-number="{{$pat->RxNumber}}">
			<div class="total-score pos-abs_ txt-sline" style="top: 4px; right: 7px; z-index: 100; display: flex; align-items: center;">
                            <span class="txt-red title_ mr-4_">Total Score:</span>
                            <span class="txt-red value_ fs-17_ weight_600" style="vertical-align: top;">@if($pat->oc>0){{number_format($pat->total_delay_in_days/($pat->oc), 2)}}@else{{ '0' }}@endif</span>
                            <span class="plus-minus-symbol" data-target="#order_{{$pat->order_id}}" order-id="{{$pat->order_id}}" rx-number="{{$pat->RxNumber}}" data-toggle="collapse" aria-expanded="false"></span>
                        </div>
                	
                	<div id="order_{{$pat->order_id}}" class="trow_ pos-rel_ p8-12_ collapse" style="min-height: 70px; border-bottom: 1px solid rgb(206, 206, 206);">
                            <div class="trow_ top-row-stats">
                                    <div class="elm-left left-heading">pt. out of pocket</div>
                            </div>
						
                            <div class="trow_ pb-13_ refills-overdue-stats" style="overflow-x: auto;">
				<div class="days-list flx-justify-start" style="width:1200px;">
                                    
                                    
                                </div>
                            </div>
			</div>
					
			<div class="row mt-0_ mr-0 ml-0 user-info-row">
                        <div class="col-sm-12 pr-0 pl-0">
                            <div class="flx-justify-start f-wrap ml-10_" style="align-items: stretch;">
                                <div class="flx-justify-start f-wrap flex-vr-center bg-yellow2 user-info c-dib_ pl-6_ pr-6_" style="background-color: #f2e1b6; border-right: solid 1px #cecece; width: 17%; align-content:center;">
                                    <div class="wd-100p user-name fs-15_ weight_600 tt_uc_ no-wrap-text">{{$pat->patient_name}}</div>
                                    <div class="wd-100p mt-2_ no-wrap-text c-dib_">
                                        <span class="gender d-ib_ fs-13_">{{$pat->Gender}}</span>
                                        <span class="fs-10_ d-ib_" style="vertical-align: baseline;">DOB:</span>
                                        <span class="dob d-ib_ no-wrap-text fs-13_"> {{$pat->dob}} ({{$pat->age}} Years) </span>
                                    </div>
                                </div>
                                <div class="flx-justify-start f-wrap flex-vr-center rx-info bg-grn-lt2 c-dib_ txt-blue pl-6_ pr-6_" style="background-color: #e5f1c1; border-right: solid 1px #cecece; width: 20%; align-content:center;">
                                    <span class="wd-100p  rx-no fs-13_ no-wrap-text">Rx# {{$pat->pc_rxNumber}}</span>
                                    <div class="wd-100p mt-2_ rx-no ">
                                    	<span class="trow_ c-dib_ fs-13_ no-wrap-text weight_600">{{$pat->rx_label_name}}</span>
                                    	<span class="trow_ c-dib_ fs-13_ no-wrap-text">{{$pat->strength_dosage}}</span>
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
                                	<button class="btn bg-wht-txt-red  weight_500 pr-4_ pl-4_ mr-4_ mb-4_ no-wrap-text fs-11_" style="width: 100px;">Rx EXP: {{$pat->RxExpiryDate}}</button>
                                </div>
                                <div class="flx-justify-start flex-vr-end action-buttons_txt-eml-cl">
                                    <button class="ab-text_ pa-0_ mt-7_ pos-rel_ mr-1p" title="Send Survey" id="send_survey" pat_id="{{$pat->PatientId}}">
                                        <span class="trow_ btn-ico_ fa fa-list-ol txt-orange br-rds-50p"></span>
                                        <span class="trow_ btn-txt_ txt-blue weight_500 fs-11_ tt_uc_">Survey</span>
                                    </button>
                                    <button class="ab-text_ pa-0_ mt-7_ pos-rel_ mr-1p" onclick="orderMessages({{$pat->order_id}}, '{{$pat->RxNumber}}',`{{$pat->rx_label_name." ".$pat->major_reporting_cat}}`,'{{$pat->strength}}','{{$pat->p_name}}',{{$pat->PracticeId}},{{$pat->PatientId}}, '{{$pat->patient_name}}')">
                                            <span class="trow_ btn-ico_  fa fa-commenting-o txt-orange br-rds-50p"></span>
                                            <span class="trow_ btn-txt_ txt-blue weight_500 fs-11_ tt_uc_">Message</span>
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
                
                @endforeach
                {{ $requests->links() }}
            @else

                <div class="wd-100p br-rds-1 mb-24_ bg-gray-f2" style="border: solid 1px #cecece;">						
                    <div class="trow_ cur-pointer cnt-left pos-rel_ ">					
                        <div class="row mt-14_ p8-12_">                            
                            <div class=" elm-left user-info mr-1vw mb-14_ c-dib_" style="text-align: center;width: 100%;">
                                <span class="user-name fs-24_ weight_600 tt_uc_ no-wrap-text">No Record Found</span>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            </div>

        </div>
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
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function(){
        $(".collapsed").on('show.bs.collapse', function(){
            $('#order_'+$(this).attr('order-id')).html('<div id="loading_div" style="text-align:center;"><img id="loading_small_one" src="{{ asset('images/small_loading.gif') }}" style="width: 60px;"></div>');
        });
        $(".collapsed").on('shown.bs.collapse', function(){
            console.log(this);
            console.log($(this).attr('rx-number')+'    '+$(this).attr('order-id'));
            get_statistics($(this).attr('rx-number'), $(this).attr('order-id'));
        });


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
        
    });


    function get_statistics(rx_number, order_id)
    {
       // e.preventDefault();
        $.ajax({
            url: "{{ url('report/get_report_statistics') }}/"+rx_number,
            method: 'get',
            data: '',
            async: true,
            success: function (result) {                
                $('#loading_div').remove(); 
                $('#order_'+order_id).html(result);                
            },
            error: function (data) {
                $('#loading_div').remove(); 
                toastr.error('error', 'Internet packet loss please try again.');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
</script>
@endsection