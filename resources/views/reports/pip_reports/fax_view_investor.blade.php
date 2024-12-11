@if(isset($print_view))
    
<!DOCTYPE html>
<html lang="en">
<head>
<style>
		hom
		    body { color: #242424; font-family: Arial, sans-serif; }
			
			.wrapper_print { background-color:#d9d9d9; padding: 14px; width:100%;max-width:700px; }
			
			* { margin:0px;padding:0px;box-sizing: border-box; vertical-align: top; font-family: Arial, sans-serif; }
			.trow_ { display: inline-block; width: 100%; }
			.c-dib_ > * { display: inline-block; }
			.c-mr-14 > * { margin-right: 14px; }
			.c-mr-14 > *:last-child { margin-right: 0px; }
			.c-fw-600 >* { font-weight: 600; }
			.c-fw-500 >* { font-weight: 500; }
			.fw-500 { font-weight: 500; }
			.fw-600 { font-weight: 600; }
			.fw-700 { font-weight: 700; }
			
			.fs-40 { font-size: 40px; }
			.fs-24 { font-size: 24px; }
			.fs-19 { font-size: 19px; }
			
			.lh-19 { line-height: 19px; }
			.lh-43 { line-height:43px; }
			
			.d-ib { display: inline-block; }
			
			.pt-7 { padding-top: 7px; }
			.pb-7 { padding-bottom: 7px; }
			.pb-10 { padding-bottom: 7px; }
			.pa-7 { padding: 7px; }
			.mr-14 { margin-right: 14px; }
			
			.fax_prsc_txt { position: relative;  overflow: hidden; }
			.fax_prsc_txt .hd-txt { font-family: Georgia, sans-serif; position: relative; z-index:200; background-color: 
			#d9d9d9; display: inline-block; padding-right: 7px;}
			.fax_prsc_txt .hd-txt > * { font-family: Georgia, sans-serif; }
			.fax_prsc_txt:before { content: ''; position: absolute; left:0px; top:50%; margin-top: -1px; width: 100%; border: dashed 2px #242424; z-index: 100; }
			
			
			.txt-gray-blue { color: #435369; }
			
			.fax_prsc_table { width: 100%; }
			.fax_prsc_table td { width: 50%; }
			
			.txt-left { text-align: left; }
			.txt-center { text-align: center; }
			.txt-right { text-align: right; }
			
			.txt-red { color: #ec1717; }
			
			.txt-sline { white-space: no-wrap; }
			
			.bg-white { background-color: #fff; }
			
			.opcty-87-100 { opacity: 0.7; }
			.opcty-87-100:hover { opacity: 1.0; }
			
			
			.cur-pointer { cursor: pointer; }
			
			.br-rds-6 { border-radius: 6px; }
			.opcty-87 { opacity: 0.87; }
			
			a .svg-ico { height: 24px; width: auto; }
			
			@media    print {
				* {
					-webkit-print-color-adjust: exact; 
				}
			}
			
		</style>
</head>
<body onload="window.print();" onfocus="window.close();" onmouseover="window.close();" cz-shortcut-listen="true">
    <div class="wrapper_print">
@endif
<div class="trow_ txt-black-20 c-dib_ c-mr-13_ c-fw-400 c-fw-400" >
    <span id="fax_sndr_dtls">FROM:{{strtoupper($precription->law_practice_name)}}
    <span id="fax_phone_no">{{$precription->reporter_cell_number}}
    <span id="fax_date">{{Carbon\Carbon::parse($precription->created_at)->format('M d Y')}} 
    <span id="fax_time">{{Carbon\Carbon::parse($precription->created_at)->format('H:i')}}</span></span></span></span>
 
</div>
<!-- <div class="trow_" style="height:47px;"></div> -->
<div class="trow_ fax_prsc_txt lh-43_">
    <div class="hd-txt flx-justify-start">
        <span class="d-ib_ fs-30_ lh-43_ mr-14_ mr-4_ weight_400">FAX</span>
        <span class="d-ib_ fs-15_ pt-7_ lh-43_ mr-4_ weight_400">PRESCRIPTION REQUEST -----------------------</span>
        <span class="d-ib_ fs-15_ pt-7_ lh-43_ mr-4_ weight_400 "id="Pharmacy" >{{--$precription->practice_name--}}</span>

        <!-- <span class="d-ib_ fs-24_ pt-7_ lh-43_ mr-4_ weight_600" style="flex-grow: 7;"><span class="wd-100p d-ib_" style="border-bottom: dashed 3px;padding-top: 1.7em;hrloooo" ></span></span></span> -->
    </div>
    
</div>
<!-- <div class="trow_" style="height: 24px;"></div> -->
<div class="trow_"> 
    
    <table class="txt-gray-blue bg-transparent wd-100p">
        
            <tbody>
                <tr>
                    <td class="weight_700 cnt-center  fs-16_ pb-10_" id="fax_patient_id"></td>
                   
                </tr>
                <tr>
                    <span colspan="2" class="pb-10 txt-left fs-16_" style="z-index: 20000; display: block;letter-spacing: 1px;">For:{{ucwords($precription->p_name)}} ({{$precription->Gender}}) {{Carbon\Carbon::parse($precription->BirthDate)->format('m/d/Y')}} ({{intval(substr(date('Ymd') - date('Ymd', strtotime($precription->BirthDate)), 0, -4))  }}) {{$precription->reporter_cell_number}}</span> 

                </tr>
                <div style="text-align:center;">
                <div class="trow_" style="height: 24px;"></div>
            <!-- static deta -->
                <span  class="pb-10_ cnt-left fs-16_" id="rx_label_name">{{--$precription->rx_label_name--}} </span> 
                <span  class="pb-10_cnt-center  fs-16_" id="Strength">{{--$precription->Strength--}}</span>
                <span class="pb-10 txt-right fs-16_" id="fax_dosage_form">{{$precription->dosage_form}}</span>
                </div>
            
                <td class=" cnt-left txt-sline">
                    <span class="lh-19_ opcty-87">GENERIC FOR: </span>
                    <span class="fs-15_ txt-red" id="fax_generic_for">{{$precription->brand_reference}}</span>
                </td>
            </tr>

            <tr><td class="pb-10_ cnt-center fs-16_" id="fax_comments">{{$precription->dosing_instructions}}</td><td></td></tr>
            <tr><td class="pb-10_ cnt-center fs-16_ " id="fax_quantity">{{$precription->quantity}}<td class="pb-10_ cnt-center fs-16_" id="RefillCount">{{--$precription->RefillCount--}}</td></td></tr><td></td></tr>
            <!--  add new field-->
            <!-- <tr><td class="pb-10_ cnt-center fs-16_" id="RefillCount">{{--$precription->RefillCount--}}</td></tr> -->

            <tr>
                <td class="cnt-left fs-16_" id="fax_hcp_prescriber">{{$precription->law_user_name}}<td class=" fs-16_ cnt-right">{{$precription->reporter_cell_number}}</td></td>
            </tr>
            <tr >
                @if(!isset($print_view))
                <td colspan="2" class="cnt-center wd-100p" style="vertical-align: middle;">
                <div class="trow_ mt-14_ c-dib_ pa-7_ bg-white cnt-center c-mr-14_" style=" max-width: 150px;">
                        <form action="{{url('report/get_fax_view')}}" id="form_fax_view_print" method="get" target="_blank">
                            <input type="hidden" name="order_id" value="{{$order_id}}" />
                        </form>
                        <a class="opct-87_1 cur-pointer" id="fax_btn_abc" href="javascript:PrintElem();">
                            <svg class="svg-ico" viewBox="0 0 512 512"><path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z" class=""></path></svg>
                        </a>
                        <a class="opct-87_1 cur-pointer" href="javascript:void(0);" data-toggle="modal" data-target="#pat_prescription_modal">
                            <svg class="svg-ico" viewBox="0 0 512 512"><path fill="currentColor" d="M464 4.3L16 262.7C-7 276-4.7 309.9 19.8 320L160 378v102c0 30.2 37.8 43.3 56.7 20.3l60.7-73.8 126.4 52.2c19.1 7.9 40.7-4.2 43.8-24.7l64-417.1C515.7 10.2 487-9 464 4.3zM192 480v-88.8l54.5 22.5L192 480zm224-30.9l-206.2-85.2 199.5-235.8c4.8-5.6-2.9-13.2-8.5-8.4L145.5 337.3 32 290.5 480 32l-64 417.1z" class=""></path></svg>
                        </a>
                        <a href="javascript:delete_faxview();" class="opct-87_1 cur-pointer txt-red">
                            <svg class="svg-ico" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>
                        </a>
                    </div>
                </td>
                @endif
            </tr>
            
        </tbody>
    </table>
    
</div>


@if(isset($print_view))
    </div>
</body>
</html>
@endif


