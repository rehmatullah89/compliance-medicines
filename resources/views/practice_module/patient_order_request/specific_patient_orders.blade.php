@extends('layouts.compliance')

@section('content')


<style>
.specific-patient-orders-table-wrapper17jan table th {border: none;background: #256fbd;color: #fff;padding: 4px 10px;text-transform: uppercase;letter-spacing: 0.5px;font-size: 12px;}
.specific-patient-orders-table-wrapper17jan table tr:nth-of-type(odd),
.specific-patient-orders-table-wrapper17jan table.compliance-user-table tr:nth-of-type(odd) {background: #ededed;}

.specific-patient-orders-table-wrapper17jan table tr td { vertical-align: middle; font-size: 11px; }
.specific-patient-orders-table-wrapper17jan .compliance-user-table tbody td { font-size: 11px; }

.fs11-lh13_ { font-size: 11px !important; line-height: 13px !important; }

table.compliance-user-table tbody td { border-right: solid 1px rgba(36, 36, 36, 0.17);}
table.compliance-user-table thead th { border-right: solid 1px rgba(255, 255, 255, 0.6); vertical-align: top;}

.alr-modal-label { border: solid 1px #cecece;border-radius: 2px;padding: 1px 6px 0px 2px; background-color: #f2f2f2;}

#refil-anchor-hover img:hover {color: #a50010;font-weight: normal;}

.toast-hov:hover{ background-color: #f9fafa !important;}

</style>

 <div class="trow_ mt-14_ mb-14_ user-report-head c-dib_">
    <span class="mr-4_ weight_600 txt-blue tt_uc_ fs-18_">PATIENT PROFILE</span><span class="txt-gray-9 weight_600 mt-4_ heading_para">COMPLIANCE REWARD activities will be recorded here</span>
</div>
<div class="row specific-patient-orders-header17jan">
    <div class="col-sm-12">
        <div class="green_back pt-force-4_ pb-force-4_">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-7 links-row1-17jan">
                    <div class="flx-justify-start " style="align-items: center;">
                        <h4 class="tt_uc_ mb-0_">{{$patient->FirstName.' '.$patient->LastName}}</h4>
                        <span class="green_back_spn" style="display: inline-flex;min-height: 100%;align-items: center;min-width: 100px;line-height: 30px;">
                            {{( $patient->Gender == "M" ||  $patient->Gender == "m")?"(M)":"(F)"}} {{date('m/d/Y',strtotime( $patient->BirthDate))}}&nbsp;&nbsp;<span class="red tt_uc_">{{$orders[0]->NickName??' '}}</span> <span class="ml-4_">{{preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', 
                    '($1) $2-$3'." \n", $patient->MobileNumber)}}</span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-5 links-row2-17jan">
                    <div class="flx-justify-end " style="align-items: center;">
                          <button class="green_rounded" onclick="window.location='{{ url('patient/order/'. $patient->Id) }}'"  type="button" data-id="{{ $patient->Id}}"  onclick="updatePatientInfoModal({{ $patient->Id}},'address')" style="margin-right: 7px !important;padding: 5px !important;max-width: 140px;text-transform: none !important;">ENROLL Rx</button>
                        <button class="green_rounded" id="{{ $patient->Id}}" type="button" data-id="{{ $patient->Id}}"  onclick="updatePatientInfoModal({{ $patient->Id}},'address')" style="margin-right: 7px !important;padding: 5px !important;max-width: 140px;">Address on file</button>
                        <button class="green_rounded" id="{{ $patient->Id}}" type="button" data-id="{{ $patient->Id}}" onclick="updatePatientInfoModal({{ $patient->Id}},'allergies')" style="margin-right: 7px !important;padding: 5px !important;max-width: 140px;">Allergies<span>({{$aler_count??0}})</span></button>
                        <button class="green_rounded" id="{{ $patient->Id}}" type="button" data-id="{{ $patient->Id}}" onclick="updatePatientInfoModal({{ $patient->Id}},'insurance_cards')" style="margin-right: 7px !important;padding: 5px !important;max-width: 140px;">insurance cards</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @include('flash-message') --}}
<div class="row" style="margin-bottom: 40px;">
	<div class="col-sm-12">
        <div class="table-box specific-patient-orders-table-wrapper17jan">
            <table class="compliance-user-table pat_prof">
            <thead>
                <tr>
                    <th class="service-date r-space" scope="col">DATE</th>

                    <th class="rx-number" scope="col" style="text-transform: none;">Rx NUMBER</th>
                    {{-- <th class="practice r-space" scope="col">PRACTICE</th> --}}
                    <th class="medication" scope="col" style="text-transform: none;">Rx LABEL NAME</th>
                     <th style="text-transform: none;">MAINTENANCE Rx</th>
                    <th class="generic-for" scope="col">GENERIC FOR</th>
                    <th class="qty" scope="col">QTY</th>
                    <th class="days-supply" scope="col">DAYS SUPPLY</th>
                    <th class="refill-remain" scope="col">REFILL REMAIN</th>
                    <th class="refill-due" scope="col">NEXT REFILL DUE</th>
                    <th class="next-refill r-space" scope="col">DAYS TILL REFILL</th>
                    <th class="next-refill r-space" scope="col">Comp Score</th>
                    <th class="rewards-auth" scope="col">RWD AUTH</th>
                    <th class="rewards-earned" scope="col">RWD EARNED</th>
                    <th class="balance" scope="col">REMAINING CARD BALANCE</th>
                    <th class="patient-activity r-space" scope="col">PATIENT ACTIVITY </th>

                    <th class="sell-price" scope="col">SELLING PRICE</th>
                    <th class="profit" scope="col">PROFIT</th>
                    <th class="ptnt-out-pocket" scope="col">Orig. PT OOP</th>
                    <th class="message" scope="col">MESSAGE</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr data-oid="{{$order->order_id}}">
                        <td class="service-date r-space"><span class="trow_ fs11-lh13_ cnt-center" style="max-width:70px;display:block;">{{date('m/d/y',strtotime($order->order_created_at))}}</span><span class="trow_ fs9-lh11_ cnt-center" style="max-width:70px;display:block;margin-top:4px;">{{date('H:i A',strtotime($order->order_created_at))}}</span></td>

                        <td class="rx-number tt_uc_">
                            @can('order status popup')
                            <a class="td_u_ fs-12_ cnt-right" href='javascript:void(0)' p-name="{{$order->p_name}}" id="rx_check_{{$order->order_id}}" onclick='editOrderPopup({{$order->order_id}},"{{$order->p_name}}","{{$order->orderStatusName }}",{{$order->OrderStatus}},{{$order->p_id}})'>
                                {!! $order->RxNumber !!}
                            </a>
                            @else
                                {!! $order->RxNumber !!}
                            @endcan
                        </td>
                        {{-- <td class="practice r-space">{!! $order->practice_name !!}</td> --}}

                        {{-- <td>OLYMPUS <span>LAURA JONES</span></td> --}}
                        <td class="medication">{!! $order->rx_label_name !!} {{$order->strength}} {{$order->dosage_form}}</td>
                        <td>@if(isset($order) && $order == '2') Y @else N @endif</td>
                        <td  class="generic-for cnt-right" style='color: #9d9292c9 !important;'>{{$order->brand_reference}}</td>
                        <td class="quantity qty cnt-right">{!! number_format($order->Quantity,1) !!}</td>
                        <td class="days-supply cnt-center">
                       
                        {!! $order->DaysSupply !!}
                    </td>
                        <td class="refill-remain cnt-center">{!! $order->RefillsRemaining !!}</td>
                        <td class="refill-due ">{!! date('m/d/Y',strtotime($order->nextRefillDate)) !!}</td>
                        <td class="next-refill cnt-left">
                            {{--$order->refillable--}}
                        {{--  @if($order->refillable == 'yes')  --}}
                                @can('refill order process')
                           
                                    <a href="javascript:refillRequestOrder(`{{$order->nextRefillDate}}`,{{$order->order_id}})"  @if($order->ViewStatus == 'Refill_Created') onclick="toastr.remove(); toastr.error('Already refill order placed.'); return false;" @endif id="refil-anchor-hover" data-forRefillOrder="{{$order->order_id}}" @if($order->ViewStatus == 'Refill_Created') title="Refill has been already created for this prescription"  @else title="Create Refill for this prescription"  @endif   class="elm-right hover-black-child_">
                                        <span class="rd_"><img style="height: auto; width: 24px;" src="{{asset("images/icon/rd_icon.png")}}"></span>
                                    </a>
                                @endcan
                        {{--    @endif  --}}
                            {{-- {{(\Carbon\Carbon::parse($order->nextRefillDate)->format('d'))??0}} --}}

@php
$nextRefill = \Carbon\Carbon::parse($order->nextRefillDate);
$difference = $nextRefill->diffInDays(now(),false);
// echo $difference;
$refillDays = \Carbon\Carbon::now()->startOfDay()->diffInDays($nextRefill->addHours(23)->startOfDay(), false);
$class = 'blu_back';
if($refillDays < 0){
    $class = 'bg-red pa-6_';
}
echo '<span class="fs-11_ '.$class.'" style="color:#fff54d !important; font-weight:600 !important;">';
echo $refillDays;
echo "</span>";
// echo \Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($nextRefill), false);
// $now = \Carbon\Carbon::now();
// $difference = ($nextRefill->diff($now)->days < 1)
//     ? 'today'
//     : $nextRefill->diffForHumans($now);

     @endphp
                        </td>
<td>{{number_format(($order->total_delay_in_days/$order->OC),2)}}</td>
                        <td class="rewards-auth txt-sline cnt-right">$ {{ number_format(floatval($order->RxPatientOutOfPocket)??0,2)}}</td>
                        <td class="rewards-earned txt-sline cnt-right">$ {{ number_format(floatval($order->CurrentEarnReward)??0,2)}}</td>
                        <td class="balance txt-sline cnt-right">$ {{ number_format(floatval($order->CurrentRemainBalance)??0,2)}}</td>
                        <td class="patient-activity cnt-center r-space">{{$order->ActivityCount??0}} of 4</td>
                        {{-- <td class="sell-price txt-sline cnt-right">$ {!! number_format(abs(floatval($order->RxThirdPartyPay)) + (abs($order->RxPatientOutOfPocket)),2) !!}</td> --}}
                        <td class="sell-price txt-sline cnt-right">$ {!! number_format((floatval($order->RxThirdPartyPay))+ ($order->RxPatientOutOfPocket),2) !!}</td>
                        <td class="profit txt-sline cnt-right {{(trim($order->RxProfitability) > 0)?'txt-grn-lt':'txt-red'}}"> $ {!! number_format(floatval($order->RxProfitability),2) !!}</td>
                        <td class="ptnt-out-pocket txt-sline cnt-right">$ {!! number_format(floatval($order->RxPatientOutOfPocket) ,2)!!}</td>
                        {{-- <td><a href="#"><i class="fa fa-comment" onclick="openQuestionPopup()"></i></a></td> --}}
                        <td class="message cnt-center">
                            <a href="javascript:void(0)">
                                 @if(isset($order->qId))
                                    @can('patient messages')
                                    <i class="fa fa-comment  {{(isset($order->Message) && $order->Message != null && $order->message_status != 'received')?'txt-green':'blink-icon txt-red'}}" id="{{$order->qId}}" onclick="orderMessages({{$order->order_id}}, '{{$order->RxNumber}}','{{$order->DrugName." ".$order->DrugType}}','{{$order->Strength}}','{{$order->practice_name}}',{{$order->PracticeId}},{{$order->PatientId}}, '{{decrypted_attr($orders[0]->FirstName)." ".decrypted_attr($orders[0]->LastName)}}')"></i>                                 
                                    @endcan
                                 @endif
                            </a>
                        </td>
                    </tr>
            
                @endforeach
                </tbody>
            </table>
        </div>
	</div>
</div>

    
    <div class="modal fade new_edit_modal_parent" id="email_phone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content edit_new_modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Email & Phone</h5>
                    <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
                </div>
                <div class="modal-body new_pad_edit">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Old Email</label>
                                <input name="patient_old_email" id="oldEmail" type="text" readonly value="" class="custom_add_inputs form-control" >
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Old Phone:</label>
                                <input name="patient_old_phone" id="oldPhone" type="text" readonly value="" class="custom_add_inputs form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Update Email</label>
                                <input name="patient_new_email" id="patient_new_email" type="text" value="" class="custom_add_inputs form-control" >
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Update Phone:</label>
                                <input name="patient_new_phone" id="patient_new_phone" type="text"  value="" class="custom_add_inputs form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save_email_phone" onclick="saveUpdatedPatientInfo({{ $patient->Id}},'email_phone',this)">Save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade new_edit_modal_parent" id="address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content edit_new_modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Address</h5>
                    <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
                </div>
                <div class="modal-body new_pad_edit">
                    <div class="row compliance-form_">
                    	
                    	<div class="col-sm-12">
                    		<form id="address_form">
                    		<div class="flx-justify-start">
                    			
                    			<div class="wd-100p form-group">
                                    <label>Current Address</label>
                                    <textarea style="overflow-y: hidden;padding-top: 0px;padding-bottom: 0px;margin: 0px 3.05556px 7.98611px 0px;width: 763px;height: 60px;min-height: 60px; max-width:100%;padding-top: 4px;" name="old_address"  class="custom_add_inputs form-control" id="old_address" required></textarea>
                                </div>
                                
                            </div>
                            
                            <div class="flx-justify-start">
                                
                                <div class="form-group mr-7_">
                                    <label>Current City</label>
                                    <input name="old_city"  class="custom_add_inputs form-control" value="" id="old_city" required>
                                </div>
                                
                                <div class="form-group mr-7_ pos-rel_" style="width: 80px;">
                                    <label class="wd-100p">Current State</label>
                                    {{--                            <input name="old_state"  class="custom_add_inputs" id="old_state" value="" >--}}
                                    <select name="old_state" id="old_state" class="wd-100p custom-select-arrow form-control">
                                        @if(isset($states))
                                            @foreach($states as $st)
                                                <option value="{{$st->Id}}">{{$st->Abbr}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="fa fa-caret-down" style="position: absolute;top: 29px;right: 6px;z-index:60;"></span>
                                </div>
                                
                                <div class="form-group" style="width: 100px;">
                                    <label class="wd-100p">Current Zip</label>
                                    <input name="old_zip"  class="wd-100p custom_add_inputs form-control" value="" id="old_zip" required>
                                </div>
                                
                    		</div>
                    		</form>
                    	</div>
                    	
                    </div>

                    <div class="modal-footer text-right" style="padding: 0px;">
                        <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal" style="margin: 0px;margin-right: auto;">Cancel</button>
                        <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " id="address_save" onclick="saveUpdatedPatientInfo({{ $patient->Id}},'address',this)" style="margin: 0px;">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade new_edit_modal_parent" id="allergis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content edit_new_modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Allergies</h5>
                    <button class="btn bg-lt-grn-txt-wht weight_500 fs-14_ tt_cc_" style="padding: 3px 10px;" onclick="$('.add-alr').show()">+ Add Allergy</button>
                    <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
                </div>
                <div class="modal-body new_pad_edit">
                    <div class="row add-alr">
                        <div class="col-sm-12" >
                            <label style="line-height: 20px;margin-bottom: 5px;">Add Allergy</label>
                        </div>
						<div class="col-sm-12" style="margin-bottom: 12px;">

                            <input id="new-allergy" type="text" placeholder="Please Enter Allergy" class="custom_add_inputs new_allergy_dynmaic" style="min-width: 100%;height: 30px;line-height: 30px;border-radius: 4px;border: solid 1px #3e7bc4;padding: 4px 6px;margin-left: 14px;margin: 0px;">

                        </div>
                    </div>
                    <div class="row">
						<div class="col-sm-12">
                            <div class="trow_ c-dib_ c-mr-14_ old_allergiest">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 disp_inht old_allergiest1 row" style="margin-bottom: 14px;">

                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 0px;">
                        <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal" style="margin: 0px;margin-right: auto;">Cancel</button>
                        <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ add-alr" onclick="saveUpdatedPatientInfo({{ $patient->Id}},'allergis',this)" style="margin: 0px;">Save</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade new_edit_modal_parent" id="insurance_cards" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content edit_new_modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Insurance Cards</h5>
                    <button class="btn bg-lt-grn-txt-wht weight_500 fs-14_ tt_cc_" style="padding: 3px 10px;" onclick="$('.insurace').show()">+ Add Card</button>
                    <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
                </div>
                <div class="modal-body new_pad_edit">

					<div class="row mb-14_">
						<div class="col-sm-12">
                            <div class="trow_ insurace">

                       
                                <input class="float-left mb-14_" type="file" name="card1" id="insCard1">
                           
                                <input type="file" name="card2" id="insCard2" class=".float-right mb-14_">
                            </div>
							<!-- <label>Card History</label>
                            <div class="trow_ insurace">
                                <label class="float-left w-50 font-weight-bold">Front Side</label>
                                <label class="float-right w-50 font-weight-bold">Back Side</label>
                            </div> -->
                            <div class="row mb-14_" id="old_cards">

							</div>
							
						</div>
					</div>


                    <div class="modal-footer" style="padding: 0px;">
                        <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal" style="margin: 0px;margin-right: auto;">Cancel</button>
                        <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ insurace" id="insurace_card_update" onclick="saveUpdatedPatientInfo({{ $patient->Id}},'insurance_cards',this)" style="margin: 0px;">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
.green_back {background-color: #b7cf65;padding: 10px 5px;}
.blu_back {background-color: #0072bb;padding: 6px 6px;color: #fff54d !important;font-weight: 600 !important;}
.practice_search button {font-size: 15.96px;color: #fff;background-color: #3b82cd;padding: 10px 10px;margin: 10px 0;cursor: pointer;border: none;border-radius: 4px;}
.red {color: #d30000;border: 0;font-size: 18.64px;font-weight: 600;}
.green_rounded {background-color: #9bc11a !important;border-radius: 35px !important;padding: 6px 5px !important;text-align: center !important;font-weight: bold !important;
               text-transform: uppercase !important;font-size: 12.48px !important;width: 100%;margin: 0 !important;border: solid 1px transparent !important;color: #fff;}
.green_rounded span {font-size: 12.48px;color: #1263b9;padding-left: 3px;}
.green_back h4 {font-size: 18.64px;font-weight: 600;color: #fff;padding: 3px 10px;margin-bottom: 0px;}
.green_back_spn {    color: #fff; }
.pat_prof i {    font-size: 20px;color: #75b007;}
span.heading_para { font-size: 13.26px; color: #949599; padding: 0 15px; }
button:disabled{ pointer-events: none;background-color: lightgray; }
   </style>
   <link rel="stylesheet" type="text/css" href="{{asset('new/css/bootstrap-modal.css')}}"/>
   @include('practice_module.patient_order_request.modal.orderstatus_modal')
   @include('practice_module.patient_order_request.modal.patient_message_modal')

@endsection

@section('js')
<script>
// $(document).ready(function(){


function refillRequestOrder(nextRefill,oid){

    $('a[data-forRefillOrder="'+oid+'"]').hide();
    // return;
    console.log(nextRefill);

var q = new Date();
console.log(q);
var m = q.getMonth()+1;
var d = q.getDay();
var y = q.getFullYear();

var date = new Date();
console.log(date);
      var nextrefill = new Date (nextRefill);
      console.log(nextrefill);
    //   var today = new Date(y,m,d);
    // alert(date + '=>' + nextRefill );
    // return false;
    // var url = '{{url("create-refill-order/")}}'+'/'+oid+'/'+stoken;
    if(date <= nextrefill){
        console.log('current date is smaller early refill request');
        toastr.remove();
        toastr.clear();
        toastr.options = {
    timeOut: 0,
    extendedTimeOut: 0
    // ,
    // tapToDismiss: false
};

     toastr.info("This patient has not consumed 83% of medicine.Do you really want to generate refill?<br/>\
     <button onclick='enableRefillButton("+oid+")' type='button' class='btn clear toast-hov'>No</button> <button onclick='sendRefillRequest("+oid+");' type='button' class='btn clear toast-hov'>Yes</button>");
    //  onclick="window.location.href = '+url+'"
    toastr.options = {
    timeOut: 5000,
    extendedTimeOut: 1000
    // ,
    // tapToDismiss: false
};   
}
    else{
        sendRefillRequest(oid);
        // window.location.href = '{{url("create-refill-order/")}}'+'/'+oid+'/'+stoken;
        // alert('no');
    }
      console.log(date);
     
}
function enableRefillButton(oid){
    $('a[data-forRefillOrder="'+oid+'"]').show();
    return false;
}
function sendRefillRequest(oid)
{
    $.ajax({
            url: '{{url("create-refill-order/")}}',
            data: 'order_id='+oid,
            method: 'post',
            success: function(result){
                if(result.refillDone){
                    toastr.success(result.refillMessage);
                }else{
                    toastr.error(result.refillMessage); 
                    $('a[data-forRefillOrder="'+oid+'"]').show();
                }
                
            },
            error: function(data){
            }
            });
    // alert('no');
//  window.location ='{{url("create-refill-order/")}}'+'/'+oid+'/'+stoken;
}

// });


    @if ($message = Session::get('refillMessage'))
    // alert('a');
        $(document).ready(function() {
            toastr.remove();
        toastr.clear();
         toastr.success('Refill Order has been placed');
         $('.alert').delay(1000).fadeOut();
    });
    @endif



</script>
    @include('partials.js.patient_profile_js')
@endsection
