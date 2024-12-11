

<style>


.compliance-drug-form_ {  }
.compliance-drug-form_ label { text-align: left !important; margin-bottom: 0px !important;}
.compliance-drug-form_ .flds-rs_sl-rs_prf .fld-rx_sell input { border: 0px !important; }
.compliance-drug-form_ .flds-rs_sl-rs_prf .fld-rx_profit input { border: 0px !important; }


.compliance-drug-form_ .flds-str-df-br {  }
.compliance-drug-form_ .flds-str-df-br .fld-brand_ref {  }
.compliance-drug-form_ .flds-str-df-br .fld-brand_ref label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500; }
.compliance-drug-form_ .flds-str-df-br .fld-brand_ref input { bordeR: 0px; }

.compliance-drug-form_ .fld-brand_ref label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500; }
.compliance-drug-form_ .fld-brand_ref input { border: 0px !important; }

.compliance-drug-form_ .fld-rx_sell label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500; }
.compliance-drug-form_ .fld-rx_sell input { border: 0px !important; }

.compliance-drug-form_ .fld-rx_profit label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500;     color: #9bc90d !important}
.compliance-drug-form_ .fld-rx_profit input { border: 0px !important;   }

.compliance-drug-form_ .fld-rx-ingr-cost label { color: #ec1717 !important; border: solid 1px #ec1717 !important;  background-color: transparent !important; }
.compliance-drug-form_ .fld-rx-ingr-cost input { border: solid 1px #ec1717 !important; color: #ec1717 !important; border-top: 0px !important;}

.compliance-drug-form_ .fld-thrd-party-pay label { color: #242424 !important;border: solid 1px #999 !important;  background-color: transparent !important;}
.compliance-drug-form_ .fld-thrd-party-pay input { border-top: 0px !important; }


.compliance-drug-form_ .fld-patient-out-pocket label { color: #242424 !important;border: solid 1px #999 !important; background-color: transparent !important;}
.compliance-drug-form_ .fld-patient-out-pocket input { border-top: 0px !important;  }

.compliance-drug-form_ .flds-qt-ds-rr-ric-3pp-pc-rx_sl-rx_pr label { text-align: center !important; justify-content: center !important; }
select#product_marketer option:last-child{ color: blue; font-weight: bold; }

#new_marketer_form label.error{ color: #8a1f11;display: inline-block;font-weight: 400;margin-left: 2px;font-size: 12px; margin-top: 3px; }

button.disable_grey{ pointer-events: none;background-color: lightgray; }

#dosage-reminder .daily-weekly-list {  }
#dosage-reminder .daily-weekly-list .dw-choice {position: relative;}
#dosage-reminder .daily-weekly-list .dw-choice span {position: relative;z-index: 10; cursor: pointer; margin-left: 0px;}
#dosage-reminder .daily-weekly-list .dw-choice input[type="checkbox"] {position: absolute;min-width: 100% !important;min-height: 100% !important;top: 0px;left: 0px;border: 0px !important;cursor: pointer;z-index: 20;}
#dosage-reminder .daily-weekly-list .dw-choice input[type="checkbox"]:checked + span { background-color: #afd13f; }
#dosage-reminder .daily-weekly-list .dw-choice input[type="checkbox"]:before { display: none; }

#dosage-reminder .daily-weekly-list .dw-choice input[type="radio"] {position: absolute;min-width: 100% !important;min-height: 100% !important;top: 0px;left: 0px;border: 0px !important;cursor: pointer;z-index: 20;}
#dosage-reminder .daily-weekly-list .dw-choice input[type="radio"]:checked + span { background-color: #afd13f; }
#dosage-reminder .daily-weekly-list .dw-choice input[type="radio"]:before { display: none; }


</style>


    <div class="row" >
        <div class="col-sm-12" id="rxForm">
            <input type="hidden" name="fee" id="fee-auth-zero" value="{{isset($base_fee)?$base_fee->base_fee:''}}">
            <input type="hidden" name="fee" id="fee-auth-nonzero" value="{{isset($base_fee)?$base_fee->fee:''}}">
            <input type="hidden" id="lower_cost_drug_id" name="lower_cost_drug_id" value="">
             <input type="hidden" id="lower_set" name="lower_set" value="0">

            <form class="compliance-drug-form_ " id="orderFormData" autocomplete="off">
                <input type="hidden" id="PatientId" name="PatientId" value="{{isset($patient)?$patient->Id:(isset($order)?$order->PatientId:'')}}">
                <input type="hidden"  id="drugRxExpire" value="">
            <input type="hidden" name="Id" value="{{$order->Id??''}}"/>
              <div class="row">
                  <div class="col-sm-12 cnt-center">
                      <h6 class="ma-0_ mb-4_ txt-blue fs-16_ elm-left weight_600">Rx ENROLLMENT</h6>

                      <span class="site-red-color fs-14_ all-order-error" style="display: none;">Please Fill All Fields</span>

                  </div>
              </div>
              <div class="flx-justify-start flds_rxn-orxd-ph_txt-ndb mb-14_">
                  <div class="field fld-rx_number mr-1p" style="width: 130px;">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 cnt-left">Rx No.</label>
                  <input class="wd-100p tt_uc_" id="rx_no" autocomplete="off"
                  onkeypress="return blockSpecialChar(event)" type="text"
                  name="RxNumber"  value="{{old('RxNumber',$order->RxNumber??'')}}"
                      placeholder="-" minlength="5" maxlength="15" required
                       {{isset($order->RxNumber)? "disabled='disabled'":''}}>
                  </div>
                  <div class="field fld-original_rx mr-1p pos-rel_" style="background-color: #fff; width:130px;">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left">ORIGINAL Rx DATE</label>
                      <input class="wd-100p" id="datetimepicker"  name="RxOrigDate" type="text" placeholder="MM/DD/YYYY"
                       maxlength="10" mask="99/99/9999"
                      value="{{isset($order->RxOrigDate)?\Carbon\Carbon::parse($order->RxOrigDate)->format('m/d/Y'):''}}"  onchange="window.pharmacyNotification.calculateNextRefillDate(this.value);" required autocomplete="off" style="padding-right: 27px; background-color: transparent; position: relative; z-index:100;">
                      <span class="fa fa-calendar" style="position: absolute;top: 25px;right: 9px;z-index:40;"></span>
                  </div>
                  <div class="flds-ph_name-add_button pos-rel_" style="display:flex;align-items: center;">{{--margin-left: auto;--}}
                      <span class="wd-100p olympus_phar-txt fs-16 weight_600 cnt-right" id="pharmacy-txt">
                          {{isset(auth()->user()->practice->practice_name)?str_replace("PHARMACY"," ",strtoupper(auth()->user()->practice->practice_name)).' '.(isset(auth()->user()->practice->branch_name)?" (".strtoupper(auth()->user()->practice->branch_name)." ) ":'') .' '.strtoupper(auth()->user()->practice->practice_type):(isset($patient->practice->practice_name)?str_replace("PHARMACY"," ",strtoupper($patient->practice->practice_name)).' '.(isset($patient->practice->branch_name)?" (".strtoupper($patient->practice->branch_name)." ) ":'').' '.strtoupper($patient->practice->practice_type):(Session::has('practice')!=null?str_replace("PHARMACY"," ",strtoupper(Session::get('practice')->practice_name)).' '.(isset(Session::get('practice')->branch_name)?" (".strtoupper(Session::get('practice')->branch_name)." ) ":'').' '.strtoupper(Session::get('practice')->practice_type):''))}}</span>
                  </div>


                  <div style="display: flex; align-items: center">
                      <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_  blink-icon"
                         type="button" id="drug_button"
                         style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showDrug()">add new drug</button>&nbsp;

                         <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_ "
                         type="button" id="saving_offers"
                         style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showSavingOffers()">Saving Offers</button>
                  </div>



              </div>

             {{--  hidden fields --}}
             <input type="hidden" id="DrugDetailId" name="DrugDetailId"
              value="{{old('DrugDetailId',$order->DrugDetailId??'')}}">
              
              <div class="col-sm-12 col-md-6 col-lg-3" style="display: none">
                 <div class=""> <label class="red_custom">Rx Expiry Date</label> <input id="rxExpiredDate" name="RxExpiryDate" class="form-control red_bord" value="{{old('RxExpiryDate',$order->RxExpiryDate??'')}}" placeholder="mm-dd-yyyy" readonly/> </div></div>

              <div class="col-sm-12 col-md-6 col-lg-3" style="display: none">
                 <div class=""> <label class="green_custom">Next Refill Date</label> <input type="text" name="nextRefillDate" id="nextRefillDate" class="form-control green" value="{{old('nextRefillDate',$order->nextRefillDate??'')}}" placeholder="mm-dd-yyyy" readonly/> </div></div>

              <div class="col-sm-6 col-md-6 col-lg-2" style="display: none" >
                 <table cellspacing="0" cellpadding="0"> <tbody> <tr> <th>
                     <label class="red_custom_bottom"> Activity Multiplier </label>
                    </th> </tr><tr> <td> <input type="text" id="activityMultiplier" hidden name="RxActivityMultiplier" class="red_bottom extra_width_sec" value="{{old('RxActivityMultiplier',$order->RxActivityMultiplier??'')}}" placeholder="-"> </td></tr></tbody> </table> </div>

              <div class="col-sm-6 col-md-6 col-lg-2" style="display: none">
                <table cellspacing="0" hidden cellpadding="0"> <tbody>
                     <tr> <th>
                          <label class="black_custom_bottom"> Final Collect $ </label>
                        </th> </tr><tr> <td>
                            <input type="text" hidden name="RxFinalCollect"
                             id="finalCollect" class="black_bottom"
                              value="{{old('RxFinalCollect',$order->RxFinalCollect??'')}}"
                              placeholder="-"> </td></tr></tbody> </table> </div>




              {{--  end hidden fields --}}

              <div class="flx-justify-start flds-rxl_ndc-mrkt mb-14_">
                  <div class="wd-49p field fld-rx_label_ndc mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left">Rx LABEL NAME/ UPC/ NDC #</label>
                     @if(!isset($order)) <input class="wd-100p" id="drug" placeholder="Please Search Medicine" type="text" autocomplete="off" onkeypress="return blockSpecialChar(event)"  name="DrugName" value="" required />
                     @else
                      <input class="wd-100p"  autocomplete="off"  onkeypress="return blockSpecialChar(event)" {{isset($order->rx_label_name)? "disabled='disabled'":''}}  name="DrugName" value="{{old('DrugName',$order->rx_label_name??'')}}" required/>

                      @endif
                  </div>
                  <div class="wd-50p field fld-marketer">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left">PRODUCT MARKETER</label>
                      @if(isset($order))

                      <input class="wd-100p" placeholder="-" id="product_marketer" {{isset($order->marketer)? "disabled='disabled'":''}} name="marketer" value="{{old('marketer',$order->marketer??'')}}" required/>


                      @else
                      <select class="wd-100p" placeholder="-" id="product_marketer"  name="marketer" value="" required>

                      </select>
                      @endif
                  </div>
              </div>


              <div class="flx-justify-start flds-str-df-br mb-14_">
                  <div class="wd-38p field fld-strength mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left">STRENGTH</label>
                      {{-- <select class="wd-100p" placeholder="-" name="Strength" id="Strength" readonly>
                      </select> --}}
                      @if(isset($order))
                      <input type="text" {{--onkeypress="return blockSpecialChar(event)"--}} name="Strength"
                      id="Strength" class="form-control"
                      {{old('Strength',$order->Strength??'')}}
                     disabled='disabled'

                       value="" placeholder="-">
                      @else
                      <div id="strengthFieldId"></div>
                      @endif
                  </div>
                  <div class="wd-37p field fld-dosage_from mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left">DOSAGE FORM</label>
                      <input class="wd-100p" type="text" name="DrugType" {{isset($order->DrugType)? "disabled='disabled'":''}} id="PackingDescr" value="{{old('DrugType',$order->DrugType??'')}}" placeholder="-">
                  </div>
                  <div class="wd-13p field fld-brand_ref">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ cnt-left">Brand Reference</label>
                      <input class="wd-100p txt-red" type="text" name="BrandReference" {{isset($order->BrandReference)? "disabled='disabled'":''}}  id="brandReference" value="{{old('BrandReference',$order->BrandReference??'')}}" placeholder="-">
                  </div>
              </div>
              
              <div class="flx-justify-start flds-dsg_inst mb-14_">
                  
                  <div class="wd-76p field fld-dosage_instr mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left">DOSAGE INSTRUCTIONS</label>
                      <input class="wd-100p" type="text" name="dosage_instruction" placeholder="OPTIONAL - not required">
                  </div>
                  
              </div>


              <div class="flx-justify-start flds-qt-ds-rr-ric-pop-pp-pi-aa flds-qt-ds-rr-ric-3pp-pc-rx_sl-rx_pr mb-14_">
                  <div class="field fld-qty mr-1p" style="width:70px;">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_">QTY</label>
                      <input class="wd-100p cnt-right" type="text" name="Quantity"  minlength="1" data-type='quantity'  onKeyPress="return numericOnly(event,8)"
                       value="{{old('Quantity',$order->Quantity??'')}}" placeholder="-" id="quantity" maxlength="8">
                  </div>
                  <div class="wd-10p field fld-days-supply mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_">Days Supply</label>
                      <input class="wd-100p cnt-right" type="text" min="1" name="DaysSupply"
                      value="{{old('DaysSupply',$order->DaysSupply??'')}}" placeholder="-"
                      onKeyPress="return numericOnly(event,3)" id="daysSupplyFld" maxlength="3" minlength="1"
                      onkeyup="window.pharmacyNotification.calculateNextRefillDate($('#datetimepicker').val());" >
                  </div>
                  <div class="wd-12p field fld-refills-remain mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_">REFILLS REMAIN</label>
                      <input class="wd-100p cnt-right" type="text" onkeypress="return IsDigit(event)"
                       maxlength="2" minlength="1" name="RefillsRemaining"
                        type="text" value="{{old('RefillsRemaining',$order->RefillsRemaining??'')}}"
                        placeholder="-" >
                  </div>
                  <div class="wd-13p field fld-rx-ingr-cost  mr-1p highlight-red ">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_">Rx INGR COST</label>

                      <input class="wd-100p cnt-right" id="drugPrice" data-type='currency' name="RxIngredientPrice" maxlength="10"
                       onkeypress="return IsDigit(event)"
                        type="text" {{isset($order->RxIngredientPrice)? "":"readonly=readonly"}}
                     onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());"
                     class="form-control" value="{{old('RxIngredientPrice',$order->RxIngredientPrice??'')}}" placeholder="$0.00"  >
                  </div>
                  <div class="wd-16p field fld-thrd-party-pay mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_">3<sup class="fs-f11_">rd</sup>&nbsp;PARTY PAID</label>
                      <input class="wd-100p cnt-right" data-type='currency' type="text" id="thirdPartyPaid"
                       name="RxThirdPartyPay"  type="text" placeholder="$0.00" maxlength="10"
                       {{isset($order->RxThirdPartyPay)? "":"readonly=readonly"}} value="{{old('RxThirdPartyPay',$order->RxThirdPartyPay??'')}}"
                        onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" >
                  </div>
                  <div class="wd-14p field fld-patient-out-pocket mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_">PATIENT OUT OF POCKET</label>
                      <input class="wd-100p cnt-right" type="text" name="RxPatientOutOfPocket" placeholder="$0.00"
                         type="text" data-type='currency' maxlength="10"  {{isset($order->RxPatientOutOfPocket)? "":"readonly=readonly"}}
                       value="{{old('RxPatientOutOfPocket',$order->RxPatientOutOfPocket??'')}}" id="pocketOut" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability(this.value);" >
                  </div>


                  {{--<div class="wd-16p field-nb fld-prv-insurance radio-field radio-field-insurance mr-1p" style="min-width: 140px;">
                      <div class="wd-100p radio-field-option">
                          <label class="cur-pointer" for="private_insurance" style="margin-top: 2px; margin-bottom: 2px;">
                              <input id="private_insurance INS" name="InsuranceType" type="radio" onclick="window.pharmacyNotification.selfPayEvent()" value="Commercial" style="margin-top: 0px;">
                              <span class="text fs-14_ " style="margin: 0px; font-size: 12px;">PRIVATE INSURANCE</span>
                          </label>
                      </div>
                      <!-- <div class="wd-100p radio-field-option">
                          <label class="cur-pointer" for="public_insurance" style="margin-top: 2px; margin-bottom: 2px;">
                              <input id="public_insurance radio-a" name="InsuranceType" type="radio" onclick="window.pharmacyNotification.selfPayEvent()" value="Public" style="margin-top: 0px;">
                              <span class="text fs-14_"><span class="txt-red fs-14_">PUBLIC</span>&nbsp;<span >INSURANCE</span></span>
                          </label>
                      </div> -->
                      <div class="wd-100p radio-field-option">
                          <label class="cur-pointer" for="self_pay" style="margin-top: 2px; margin-bottom: 2px;">
                              <input id="self_pay radio-b" name="InsuranceType" type="radio" value="Cash" onclick="window.pharmacyNotification.selfPayEvent()" style="margin-top: 0px;">
                              <span class="text fs-14_ c-dib_"  style="margin: 0px;">
                                  <span class="txt-red fs-14_ " style="font-size: 12px;">SELF</span>&nbsp;<span style="font-size: 12px;">PAY</span></span>
                          </label>
                      </div>
                  </div>--}}

                  <input type="hidden" name="InsuranceType">

                  <div class="wd-14p field fld-assist-auth mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_">ASSISTANCE AUTHORIZED</label>
                      <input class="wd-100p cnt-right" data-type='currency'   name="asistantAuth" maxlength="10"
                       minlength="1" type="text"  value="{{old('asistantAuth',$order->asistantAuth??'')}}" placeholder="$0.00"
                       onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" >
                  </div>

                  <div class="wd-14p field fld-rx_sell mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_">Rx Selling </label>
                      <input class="wd-100p cnt-right" type="text" name="RxSelling" maxlength="11" data-type='currency' onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateProfitabilityWithSelling(this.value);" id="RxSelling"  value="{{old('RxSelling',$order->RxSelling??'')}}" placeholder="-">
                  </div>
                  <div class="wd-14p field fld-rx_profit">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_">Rx Profitability </label>
                      <input class="wd-100p cnt-right" type="text"  name="RxProfitability"
                       readonly id="rxProfitability"  value="{{old('RxProfitability',$order->RxProfitability??'')}}" placeholder="-" maxlength="13">
                  </div>

              </div>

              <div class="flx-justify-start flds-prs_nm-prs_ph mb-14_">

                  <div class="wd-38p field fld-pres_name mr-1p" >
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left">Prescriber Name </label>
                      <input type="hidden" name="prescriber_id">
                      <input class="wd-100p"  type="text"  id="basicAutoSelect" name="PrescriberName"
                       placeholder="Search Prescriber" value="{{old('PrescriberName',$order->PrescriberName??'')}}" autocomplete="off">
                  </div>
                  
                  <div class="wd-37p field fld-pres_phone">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left">Prescriber Phone </label>
                      <input class="wd-100p" name="PrescriberPhone"  mask="(000) 000-0000"
                       minlength="10" type="text" value="{{old('PrescriberPhone',$order->PrescriberPhone??'')}}" placeholder="-">
                  </div>


              </div>


              <div class="flx-justify-start mb-14_">
                  <div class="flx-justify-start dr-cl-adv_pat-msg_btns-col" style="min-width: 400px;">
                      {{-- <button class="drg-cln-adv weight_600 tt_uc_ mr-14_ disable_grey" style="background-color:lightgray !important;" type="button" onclick="$('#drug_clinc_adv').click()">&#10010; Drug Clinical Advisory</button> --}}
                      {{-- <input type="file" name="drug_clinical_advise" style="display: none;" id="drug_clinc_adv" multiple> --}}
                            <input type="hidden" name="order_message" id="orderMsg">
                      {{-- <button class="patient-message weight_600  tt_uc_ disable_grey" style="background-color:lightgray !important;" type="button" data-toggle="modal" data-target="#patient_msg-Modal" onclick="orderMessage()">Patient Message</button> --}}
                  </div>
                  <div class="flx-justify-end clear-sbmt-btns-col" style="min-width: 170px; margin-left: auto; align-items: center;">
                    @if(isset($order) && !is_null($order))
                    <button class="submit-form weight_500 tt_uc_ ml-14_ bg-dk-grn-txt-wht " type="submit" id="submitOrder">process</button>

                  @else
                  <button class="clear-form weight_500 tt_uc_ bg-red-txt-wht" type="button" onclick="clearForm('orderFormData')">clear</button>
                  <button class="submit-form weight_500 tt_uc_ ml-14_ bg-dk-grn-txt-wht" type="submit" id="submitOrder">submit</button>
                  @endif
                    </div>
              </div>


          </form>

        </div>




{{-- drug add form --}}


<div class="col-sm-12 col-md-12" style="display: none;" id="drug_form">

    <div class="row">
        <div class="col-sm-12">

            <form class="compliance-drug-form_ " novalidate="novalidate" action="javascript:void(0);" onsubmit="add_product('product_form2',this,event,'{{url('/drug/add-update')}}','POST');" id="product_form2"  name="product_form2" method="post">
                <input type="hidden" name="added_from_pharmacy" value="{{isset(auth()->user()->practice->id)? auth()->user()->practice->id:(isset($patient->practice->id)?$patient->practice->id:'')}}" />
                <div class="row mb-14_">
                  <div class="col-sm-12 cnt-center">
                      <h6 class="ma-0_ mb-4_ txt-blue fs-16_ elm-left weight_600">ADD PRODUCT</h6>

                      {{--<span class="site-red-color fs-14_ all-drug-error" style="display: none;">Please Fill All Fields</span>--}}
                      <div class="wd-48p flds-ph_name-add_button pos-rel_ elm-right" style="padding-right: 126px;display: flex;align-items: center;">
                          <span class="wd-100p olympus_phar-txt fs-16 weight_600 cnt-right">{{isset(auth()->user()->practice->practice_name)?str_replace("PHARMACY"," ",strtoupper(auth()->user()->practice->practice_name)) .' '.strtoupper(auth()->user()->practice->practice_type):(isset($patient->practice->practice_name)?str_replace("PHARMACY"," ",strtoupper($patient->practice->practice_name)).' '.strtoupper($patient->practice->practice_type):(Session::has('practice')!=null?str_replace("PHARMACY"," ",strtoupper(Session::get('practice')->practice_name)).' '.strtoupper(Session::get('practice')->practice_type):''))}}</span>

                          <button class="pos-abs_ btn bg-blue-txt-wht field fld-add_drug tt_uc_" type="button" style="top: 50%;right: 0px;border-radius: 24px;padding: 2px 10px;margin-top: -13px;" onclick="showDrug()">Rx Enrollment</button>
                      </div>
                  </div>
              </div>

              <div class="row" style="position: relative;margin-top: -12px;margin-bottom: 7px;">
                  <div class="col-sm-12">
                      <div class="site-red-color fs-14_ all-drug-error " style="width: 100%;display: none;">Please Fill All Fields</div>
                  </div>
              </div>

              <div class="flx-justify-start flds-ndc-rx_ln-mrk mb-14_">

                  <div class="wd-26p field fld-ndc mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_">NDC</label>
                      <input class="wd-100p" mask="00000-0000-00" minlength="13" type="text" name="ndc" id="ndc"  value="99999-" placeholder="" required>
                  </div>

                  <div class="wd-26p field fld-ndc mr-1p">
                    <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_">UPC</label>
                    <input class="wd-100p" type="text"  id="upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc">
              
                </div>

                  <div class="wd-36p field fld-rx_label_name mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_">RX LABEL NAME</label>
                      <input class="wd-100p autoCompForm" type="text" pattern="^[a-zA-Z\d\-_\s]+$" name="rx_label_name" id="rx_label_name" placeholder="" required maxlength="40">
                  </div>
                  <div class="wd-36p field fld-marketer">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_">MARKETER </label>
                      <input class="wd-100p" pattern="^[a-zA-Z\d\-_\/.'|,\s]+$" type="text" name="marketer" id="marketer"  maxlength="20">
                  </div>
              </div>

              <div class="flx-justify-start flds_str-df-bgc-gcn-br mb-14_">

                  <div class="wd-26p field fld-strength mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">STRENGTH</label>
                      <input class="wd-100p tt-uc_"  pattern="^[a-zA-Z\d\-_\/.'|,%\s]+$" name="strength" id="strength" type="text" placeholder="" maxlength="15">
                  </div>
                  <div class="wd-23p field fld-dosage_from mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">DOSAGE FORM</label>
                      <input class="wd-100p" type="text" pattern="^[a-zA-Z\d\-_\/.'|,\s]+$"  id="dosage_form" name="dosage_form" maxlength="15">
                  </div>
                  <div class="wd-14p field fld-B_GEN_CMP mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">B / GEN / CMP</label>
                      <input class="wd-100p tt-uc_" type="text" required id="b_gen-drg"  name="generic_or_brand" placeholder="" pattern="^[a-zA-Z\-_\s]+$" maxlength="3" minlength="1" value="CMP">
                  </div>
                  <div class="wd-10p field fld-GCNSEQ mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">GCNSEQ </label>
                      <input class="wd-100p" type="text"  id="gcnseq_drg" name="gcn_seq"pattern="[0-9]" mask="000000" onkeypress="return numericOnly(event,6)" maxlength="6">
                  </div>
                  <div class="wd-23p field fld-brand_ref">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_">Brand Reference </label>
                      <input class="wd-100p" type="text" name="brand_reference" id="brandReference-drg" value="" placeholder="-"  maxlength="26" pattern="^[a-zA-Z\-_.\s]+$">
                  </div>
              </div>


              <div class="flx-justify-start flds_mrc-icu-df_rx_qty-dea mb-14_">

                  <div class="wd-49p field fld-major_report_class mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">MAJOR REPORTING CLASS</label>
                      <input class="wd-100p tt-uc_" type="text" placeholder=""  id="major_reporting_cat" name="major_reporting_cat" maxlength="20">
                  </div>
                  <div class="wd-16p field fld-ing_cost_unit mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">ING COST / UNIT</label>
                      <input class="wd-100p cnt-right" name="unit_price" maxlength="12"   id="unit_price" type="text"  >
                  </div>
                  <div class="wd-16p field fld-def_rx_qty mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">DEFAULT Rx QTY</label>
                      <!-- <input class="wd-100p cnt-right tt-uc_" name="default_rx_qty" pattern="[0-9]" mask="000000"  id="default_rx_qty" type="number"  maxlength="6" onKeyPress="return numericOnly(event,6)"> -->
                      <input class="wd-100p cnt-right tt-uc_" name="default_rx_qty" id="default_rx_qty" type="text" data-type="quantity"  maxlength="8" onKeyPress="return numericOnly(event,8)">
                  </div>
                  <div class="wd-9p field fld-dea mr-1p">
                      <label class="wd-100p pa-4_ txt-wht bg-gray-57">DEA</label>
                      <input class="wd-100p cnt-right" name="dea" pattern="[0-9]" mask="0000" minlength="1" id="dea" type="number"  onKeyPress="return numericOnly(event,4)">
                  </div>
              </div>


              <div class="flx-justify-start mb-14_">
                  <div class="flx-justify-start clear-sbmt-btns-col" style="min-width: 170px; align-items: center;">
                      <button class="clear-form weight_500 tt_uc_ bg-red-txt-wht" type="button" id="cancel_drug" onclick="clearForm('product_form2')">clear</button>
                      <button class="submit-form weight_500 tt_uc_ ml-14_ bg-dk-grn-txt-wht" type="submit" id="submit_drug" style="min-width: 70px;">add</button>
                  </div>
              </div>


          </form>

        </div>
    </div>

</div>




    </div>





<div class="modal" id="patientMessage">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Patient Message</h4>
        <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">X</button>
        <!-- button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button-->
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">

            <div class="trow_ pa-14_ pos-rel_" style="border: solid 4px #afd13f;">
              <!-- <span class="fa fa-paperclip txt-blue pos-abs_" style="position: absolute; top: 14px; right: 7px;"></span> -->
              <div class="trow_ mb-7_" ><span class="weight_600" style="margin-right: 3px;">RE:</span><span class="txt-blue tt_uc_" id="rxPop"></span><span class="txt-black-14" id="medNamePop"></span></div>

              <div class="trow_ mb-7_">LJ <span class="weight_600" id="pracPop"></span></div>

              <textarea class="trow_ txt-red weight_600" style="height: 64px" id="orderMessage">
              </textarea>
               <!--  <span class="weight_600">This is a new Rx that replaces your old prescription</span> - Our supplier was unable to get your
                usual version - it's in short supply - substituted this - but rest assured - It's the <span class="weight_600">same -- only in YELLOW</span> -->

            </div>

          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal">cancel</button>
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " style="margin-left: auto;" onclick="addMessage()">send</button>
          </div>
      </div>

    </form>
  </div>
</div>




<!-- <div class="modal fade new_edit_modal_parent " id="patientMessage" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content edit_new_modal">
                <div class="modal-header">
                    <h4 class="modal-title">Patient Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body new_pad_edit">
                    <div class="row">
                        <div class="col-md-3" id="rxPop"></div>
                        <div class="col-md-9" id="medNamePop"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="pracPop"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Please type message</label>
                                <textarea style="overflow-y: hidden;padding-top: 0px;padding-bottom: 0px;margin: 0px 3.05556px 7.98611px 0px;width: 763px;height: 33px;min-height: 32px;"   class="custom_add_inputs form-control" id="orderMessage"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="address_save" onclick="addMessage()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div> -->


<div class="modal" id="addMarketer">
    <div class="modal-dialog wd-87p-max_w_400" style="max-width:700px;">
        <form class="modal-content" name="new_marketer_form" id="new_marketer_form">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Marketer</h4>
        <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">X</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="flx-justify-start compliance-form_">
                <div class="wd-33p mr-1p field-fromdate" style="" forA="mark_marketer">
                        <label class="weight_600">Marketer</label>
                        <input class="wd-100p" pattern="^[a-zA-Z\d\-_\s]+$" type="text" name="mark_marketer" id="mark_marketer" required maxlength="20" />
                </div>
                <div class="wd-33p field fld-mb_phone mr-1p" style="background-color: #fff;" forA="mark_ndc">
                        <label class="weight_600">NDC</label>
                        <input class="wd-100p" mask="00000-0000-00" value="" minlength="10" type="text" name="mark_ndc" id="mark_ndc" required />
                </div>
                <div class="wd-33p field fld-mb_phone mr-1p" style="background-color: #fff;" forA="mark_rx_label_name">
                        <label class="weight_600">RX LABEL NAME</label>
                        <input class="wd-100p" type="text" pattern="^[a-zA-Z\d\-_\s]+$" name="mark_rx_label_name" id="mark_rx_label_name" maxlength="25" />
                </div>
            </div>
          </div>
            <div class="col-sm-12 mt-2">
            <div class="flx-justify-start compliance-form_">
                <div class="wd-33p mr-1p field-fromdate" style="" forA="mark_strength">
                        <label class="weight_600">Strength</label>
                        <input class="wd-100p" pattern="^[a-zA-Z\d\-_./\(),%'\s]+$" type="text" name="mark_strength" id="mark_strength" required maxlength="20" />
                </div>
                <div class="wd-33p field fld-mb_phone mr-1p" style="background-color: #fff;" forA="mark_dosage_form">
                        <label class="weight_600">Dosage Form</label>
                        <input class="wd-100p" pattern="^[a-zA-Z\d\-_\/.'|,\s]+$" minlength="2" type="text" name="mark_dosage_form" id="mark_dosage_form" required />
                </div>

                 <div class="wd-30p field field-modal fld-mrc">
                                  <label class="wd-100p">UPC:</label>
                                  <input class="wd-100p" type="text"  id="mark_upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc">
                              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal">cancel</button>
            <button type="reset" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_" style="margin-left:10px;">reset</button>
            <img id="loading_small_img_one" src="{{ url('images/small_loading.gif') }}" style="width: 40px;margin-top: 15px;margin-left: 30px;display: none;margin: auto;">
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " style="margin-left: auto;" onclick="marketer_add();">add</button>
          </div>
      </div>

    </form>
  </div>

</div>



<div class="modal" id="orderSubmit">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">Enroll Modal</span></h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">X</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">

            <div class="trow_ cnt-center c-dib_ mb-14_"><span class="txt-red weight_600 fs-24_ tt_uc_" id="rxNoPop"></span><span class="txt-red weight_600 fs-24_ tt_uc_" style="margin-left: 5px">Enrolled</span></div>
            <div class="trow_ cnt-center c-dib_ mb-14_"><span class="txt-black-24 weight_700 tt_uc_ fs-24_">CHARGE TO PAYMENT CARD</span></div>
            <div class="trow cnt-center c-dib_ mb-4_">
                <!-- <span class="txt-black-24 weight_700 tt_uc fs-24 mr-4_">$</span><span class="txt-blue weight_700 tt_uc_ fs-24_">40.29</span> -->
				<input type="text" class="w-50 form-control cnt-right fs-17_ weight_600 "
					data-type="currency" name="" id="asistantAuthPop" disabled=""
					style="padding-top: 2px; padding-bottom: 2px; height: auto; max-width: 100px;" maxlength="10" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val(),this.value);">
					<i class="btn bg-wht-txt-blue weight_500 fs-17_ tt_uc fa fa-pencil mt-0_" style="cursor:pointer;width: 31px;line-height: 29px;border: solid 1px #cecece;padding: 0px;" aria-hidden="true" onclick="enableField()"></i>
			</div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <div class="flx-justify-center wd-100p pb-14_">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" onclick="addPaySubmitOrder('Cash')">self pay</button>
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ ml-14_ " onclick="addPaySubmitOrder('Commercial')">private pay</button>
          </div>
      </div>

    </form>
  </div>
</div>


<!--  Lower cost option modal  -->

<div class="modal" id="lower_cost">
  <div class="modal-dialog wd-87p-max_w_700">
    <form class="modal-content compliance-form_">

      
      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">Lower Ingredient Cost Option</span></h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal" style="z-index:100;">&#10006;</button> <!-- &#10006; -->
      </div>
      
      <!-- Modal body -->
		<div class="modal-body" style="padding-top: 6px;">
  			<div class="row">
  				<div class="col-sm-12">
  					
  					<div class="trow_ br-rds-4 p8-12_" style="border: solid 2px #3e7bc4;">
  					
  						<div class="trow_ cnt-center c-dib_">
  						    <span class="txt-blue weight_600 fs-32_ tt_uc_">lower ingredient cost option</span>
  						</div>
  						
  						<div class="trow_ cnt-center c-dib_ mt-10_">
                            <div class="bg-gray-ce c-dib_ br-rds-13 p6-12_ mr-7_">
                            	<label class="tt_uc_ ma-0_ weight_600 txt-black-24 mr-4_" style="margin:0px; color: #242424;">gpi:</label>
                            	<span class="weight_600 txt-black-24" id="lower_gpi"></span>
                            </div>
                            <div class="bg-gray-ce c-dib_ weight_600 txt-black-24 br-rds-13 p6-12_ mr-7_">
                            	<label class="tt_uc_ ma-0_ weight_600 txt-black-24 mr-4_" style="margin:0px; color: #242424;"></label>
                            	<span class="weight_600 txt-black-24" id="lower_dosage_strength"></span>
                            </div>
                            <div class="bg-gray-ce c-dib_ weight_600 txt-black-24 br-rds-13 p6-12_ mr-7_">
                            	<span class="weight_600 txt-black-24" id="lower_dea"></span>
                            </div>
                        </div>
                        
                        <div class="trow_ cnt-center c-dib_ mt-10_">
  						    <span class="txt-blue weight_500 fs-17_ tt_uc_" id="lower_drug_name"></span>
  						</div>
  						
  						<div class="flx-justify-center wd-100p mt-10_">
  						    <div class="trow_ c-dib_ br-rds-4 p6-12_ mr-14_" style="border: solid 3px #ec1717;flex-basis: 0;">
  						    	<div class="wd-100p txt-red weight_600 fs-21_" id="lower_rx_ing_cost"></div>
  						    	<div class="wd-100p tt_uc_ txt-sline txt-black-24 fs-21_" >rx ing cost</div>
  						    </div>
  						    <div class="trow_ c-dib_ br-rds-4 p6-12_ mr-14_" style="border: solid 3px #559928;flex-basis: 0;">
  						    	<div class="wd-100p txt-grn-dk weight_600 fs-21_" id="lower_ing_cost"></div>
  						    	<div class="wd-100p txt-sline tt_uc_ txt-black-24 fs-21_">ing cost / unit</div>
  						    </div>
  						</div>
  						
  						<div class="trow_ mt-10_">
  						    <table>
  						    	<tbody>
  						    		<tr>
  						    		  <td><div class="wd-100p p4-8_ txt-black-24 weight_600" style="background-color: #c6d7e9;">Source:</div></td>
  						    		  <td><div class="wd-100p p4-8_ txt-sline weight_600 txt-blue" style="background-color: #f2eab9;" id="lower_source"></div></td>
  						    		  </tr>
  						    		<tr>
  						    		  <td><div class="wd-100p p4-8_ txt-black-24 weight_600" style="background-color: #c6d7e9;">Marketer:</div></td>
  						    		  <td><div class="wd-100p p4-8_ txt-sline weight_600 txt-blue" style="background-color: #f2eab9;" id="lower_marketer"></div></td>
  						    		  </tr>
  						    		<tr>
  						    		  <td><div class="wd-100p p4-8_ txt-black-24 weight_600" style="background-color: #c6d7e9;">NDC:</div></td>
  						    		  <td><div class="wd-100p p4-8_ txt-sline weight_600 txt-blue" style="background-color: #f2eab9;" id="lower_ndc"></div></td>
  						    		  </tr>
  						    		<tr>
  						    		  <td><div class="wd-100p p4-8_ txt-black-24 weight_600" style="background-color: #c6d7e9;">Offer Web Link:</div></td>
  						    		  <td><div class="wd-100p p4-8_ txt-sline weight_600 txt-blue" style="background-color: #f2eab9;" id="lower_order_web_link"></div></td></tr>
  						    		<tr>
  						    		  <td><div class="wd-100p p4-8_ txt-black-24 weight_600" style="background-color: #c6d7e9;">Item No:</div></td>
  						    		  <td><div class="wd-100p p4-8_ txt-sline weight_600 txt-blue" style="background-color: #f2eab9;" id="lower_item"></div></td></tr>
  						    		<tr>
  						    		  <td><div class="wd-100p p4-8_ txt-black-24 weight_600" style="background-color: #c6d7e9;">Offer Expires:</div></td>
  						    		  <td><div class="wd-100p p4-8_ txt-sline weight_600 txt-blue" style="background-color: #f2eab9;">-</div></td>
  						    		</tr>
  						    	</tbody>
  						    </table>
  						</div>
  						
  						<div class="flx-justify-start wd-100p mt-10_">
                    		<button type="button" class="btn bg-red-txt-wht weight_600 fs-14_ tt_uc_" data-dismiss="modal">decline</button>
                    		<button type="button" class="btn bg-dk-grn-txt-wht weight_600 fs-14_ tt_uc_ " style="margin-left: auto;" id='alter_order_drug' data-dismiss="modal">select offer</button>
                    	</div>
  						
  					</div>
  					
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <!-- div class="modal-footer">
      		<div class="flx-justify-start wd-100p">
      			<button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
        		<button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">SAVE</button>
        	</div>
      </div-->

    </form>
  </div>
</div>

<!--  end lower cost option modal -->



<div class="modal" id="product_added_msg-Modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title">
          <span style="visibility: hidden; font-size: 1px;">Enroll Modal</span>
        </h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="trow_ c-dib_ cnt-center mb-24_"><img src="{{url('/images/tick-circle.png')}}" style="max-width:73px;"/></div>
            <div class="trow_ cnt-center c-dib_ mb-7_"><span class="txt-red weight_600 fs-24_" id="pro_or_cmp">New * Compound * Product</span></div>
            <div class="trow_ cnt-center c-dib_ mb-4_"><span class="txt-gray-6 weight_700 tt_lc_ fs-17_">has been successfully added</span></div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; visibility: hidden;">
      </div>

    </form>
  </div>
</div>



<button class="submit-form weight_500 tt_uc_ ml-14_ bg-dk-grn-txt-wht" type="button" data-toggle="modal" data-target="#drug_form-Modal" style="display:none;">Show New Modal</button>
<div class="modal" id="drug_form-Modal">
  <div class="modal-dialog wd-87p " style="max-width: 700px;">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title">
          <span style="visibility: hidden; font-size: 1px;">Enroll Modal</span>
        </h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">X</button-->
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 compliance-drug-form_">
              <form class="compliance-drug-form_ " id="orderFormData" autocomplete="off" novalidate="novalidate">
                <input type="hidden" id="PatientId" name="PatientId" value="335">
                <input type="hidden" id="drugRxExpire" value="">
                <input type="hidden" name="Id" value="">
                  <div class="row">
                      <div class="col-sm-12 cnt-center">
                          <h6 class="ma-0_ mb-4_ txt-blue fs-16_ elm-left weight_600">Rx ENROLLMENT</h6>

                          <span class="site-red-color fs-14_ all-order-error" style="display: none;">Please Fill All Fields</span>

                      </div>
                  </div>
                  <div class="flx-justify-start flds_rxn-orxd-ph_txt-ndb mb-14_">
                      <div class="field fld-rx_number mr-1p" style="width: 130px;">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 cnt-left mb-0_" >Rx No.</label>
                      <input class="wd-100p tt_uc_" id="rx_no" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" name="RxNumber" value="99999-" placeholder="-" minlength="5" maxlength="15" required="">
                      </div>
                      <div class="field fld-original_rx mr-1p pos-rel_" style="background-color: #fff; width:130px;">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">ORIGINAL Rx DATE</label>
                          <input class="wd-100p" id="datetimepicker" name="RxOrigDate" type="text" placeholder="MM/DD/YYYY" maxlength="10" mask="99/99/9999" value="" onchange="window.pharmacyNotification.calculateNextRefillDate(this.value);" required="" autocomplete="off" style="padding-right: 27px; background-color: transparent; position: relative; z-index:100;">
                          <span class="fa fa-calendar" style="position: absolute;top: 25px;right: 9px;z-index:40;"></span>
                      </div>
                      <div class="flds-ph_name-add_button pos-rel_" style="display:flex;align-items: center;">
                          <span class="wd-100p olympus_phar-txt fs-16 weight_600 cnt-right" id="pharmacy-txt">CLINIX RX PHARMACY</span>
                      </div>
                                        <div style="display: flex; align-items: center">
                          <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_" type="button" id="drug_button" style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showDrug()">add new drug</button>&nbsp;
                          <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_ "
                         type="button" id="saving_offers"
                         style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showSavingOffers()">Saving Offers</button>
                      </div>


                  </div>


                 <input type="hidden" id="DrugDetailId" name="DrugDetailId" value="">

                  <div class="col-sm-12 col-md-6 col-lg-3" style="display: none">
                     <div class=""> <label class="red_custom">Rx Expiry Date</label> <input id="rxExpiredDate" name="RxExpiryDate" class="form-control red_bord" value="" placeholder="mm-dd-yyyy" readonly=""> </div></div>

                  <div class="col-sm-12 col-md-6 col-lg-3" style="display: none">
                     <div class=""> <label class="green_custom">Next Refill Date</label> <input type="text" name="nextRefillDate" id="nextRefillDate" class="form-control green" value="" placeholder="mm-dd-yyyy" readonly=""> </div></div>

                  <div class="col-sm-6 col-md-6 col-lg-2" style="display: none">
                     <table cellspacing="0" cellpadding="0"> <tbody> <tr> <th>
                         <label class="red_custom_bottom"> Activity Multiplier </label>
                        </th> </tr><tr> <td> <input type="text" id="activityMultiplier" hidden="" name="RxActivityMultiplier" class="red_bottom extra_width_sec" value="" placeholder="-"> </td></tr></tbody> </table> </div>

                  <div class="col-sm-6 col-md-6 col-lg-2" style="display: none">
                    <table cellspacing="0" hidden="" cellpadding="0"> <tbody>
                         <tr> <th>
                              <label class="black_custom_bottom"> Final Collect $ </label>
                            </th> </tr><tr> <td>
                                <input type="text" hidden="" name="RxFinalCollect" id="finalCollect" class="black_bottom" value="" placeholder="-"> </td></tr></tbody> </table> </div>






                  <div class="flx-justify-start flds-rxl_ndc-mrkt mb-14_">
                      <div class="wd-49p field fld-rx_label_ndc mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">Rx LABEL NAME/ UPC/ NDC #</label>
                          <input class="wd-100p" id="drug" autocomplete="off" placeholder="Please Search Medicine" type="text" onkeypress="return blockSpecialChar(event)" name="DrugName" value="" required="">
                                           </div>
                      <div class="wd-50p field fld-marketer">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">PRODUCT MARKETER</label>
                            <select class="wd-100p" placeholder="-" id="product_marketer" name="marketer" value="" required="">

                          </select>
                                            </div>
                  </div>


                  <div class="flx-justify-start flds-str-df-br mb-14_">
                      <div class="wd-33p field fld-strength mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_" >STRENGTH</label>

                                                <div id="strengthFieldId"><select id="dosage_strength" name="Strength" value="" class="form-control" placeholder="-"></select></div>
                                            </div>
                      <div class="wd-32p field fld-dosage_from mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">DOSAGE FORM</label>
                          <input class="wd-100p" type="text" name="DrugType" readonly="" id="PackingDescr" value="" maxlength="20" placeholder="-">
                      </div>
                      <div class="wd-33p field fld-brand_ref">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ cnt-left mb-0_">Brand Reference</label>
                          <input class="wd-100p txt-red" type="text" name="BrandReference"  id="brandReference" maxlength="20" value="" placeholder="-">
                      </div>
                  </div>


                  <div class="flx-justify-start flds-qt-ds-rr-ric-pop-pp-pi-aa flds-qt-ds-rr-ric-3pp-pc-rx_sl-rx_pr mb-14_">
                      <div class="field fld-qty mr-1p" style="width:70px;">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">QTY</label>
                          <input class="wd-100p cnt-right" type="text" name="Quantity" minlength="1" data-type="quantity" onkeypress="return numericOnly(event,8)" value="" placeholder="-" id="quantity">
                      </div>
                      <div class="wd-10p field fld-days-supply mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">Days Supply</label>
                          <input class="wd-100p cnt-right" type="number" min="1" name="DaysSupply" value="" placeholder="-" onkeypress="return numericOnly(event,3)" id="daysSupplyFld" maxlength="3" minlength="1" onkeyup="window.pharmacyNotification.calculateNextRefillDate($('#datetimepicker').val());">
                      </div>
                      <div class="wd-12p field fld-refills-remain mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">REFILLS REMAIN</label>
                          <input class="wd-100p cnt-right" type="text" onkeypress="return IsDigit(event)" maxlength="2" minlength="1" name="RefillsRemaining" value="" placeholder="-">
                      </div>
                      <div class="wd-13p field fld-rx-ingr-cost  mr-1p highlight-red ">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">Rx INGR COST</label>

                          <input class="wd-100p cnt-right" name="RxIngredientPrice" onkeypress="return IsDigit(event)" data-type="currency" type="text" readonly="&quot;&quot;" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" value="" placeholder="$0.00" id="drugPrice">
                      </div>
                      <div class="wd-16p field fld-thrd-party-pay mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">3<sup class="fs-f11_">rd</sup>&nbsp;PARTY PAID</label>
                          <input class="wd-100p cnt-right" data-type="currency" type="text" id="thirdPartyPaid" name="RxThirdPartyPay" placeholder="$0.00" readonly="&quot;&quot;" value="" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());">
                      </div>
                      <div class="wd-14p field fld-patient-out-pocket mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">PATIENT OUT OF POCKET</label>
                          <input class="wd-100p cnt-right" type="text" name="RxPatientOutOfPocket" placeholder="$0.00" data-type="currency" readonly="&quot;&quot;" value="" id="pocketOut" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability(this.value);">
                      </div>




                      <input type="hidden" name="InsuranceType">

                      <div class="wd-13p field fld-assist-auth">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">ASSISTANCE AUTHORIZED</label>
                          <input class="wd-100p cnt-right" data-type="currency" name="asistantAuth" minlength="1" type="text" value="" placeholder="$0.00">
                      </div>

                      <div class="wd-14p field fld-rx_sell mr-1p">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ mb-0_">Rx Selling </label>
                          <input class="wd-100p cnt-right" type="text" name="RxSelling" readonly="" id="RxSelling" value="" placeholder="-">
                      </div>
                      <div class="wd-14p field fld-rx_profit">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ mb-0_">Rx Profitability </label>
                          <input class="wd-100p cnt-right" type="text" name="RxProfitability" readonly="" id="rxProfitability" value="" placeholder="-" maxlength="13">
                      </div>

                  </div>

                  <div class="flx-justify-end flds-rs_sl-rs_prf mb-14_">

                      <div class="wd-33p field fld-pres_name" style="margin-right: auto;">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left mb-0_">Prescriber Name </label>
                          <input type="hidden" name="prescriber_id">
                          <input class="wd-100p" type="text" id="basicAutoSelect" name="PrescriberName" placeholder="Search Prescriber" value="" autocomplete="off">
                      </div>


                  </div>



                  <div class="flx-justify-start mb-14_">
                      <div class="wd-33p field fld-pres_phone">
                          <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left mb-0_">Prescriber Phone </label>
                          <input class="wd-100p" name="PrescriberPhone" mask="(000) 000-0000" minlength="10" type="text" value="" placeholder="-" maxlength="14">
                      </div>
                  </div>

                  <div class="flx-justify-start mb-14_">
                      <div class="flx-justify-start dr-cl-adv_pat-msg_btns-col" style="min-width: 400px;">
                          <button class="drg-cln-adv txt-red weight_600 tt_uc_ mr-14_" type="button" onclick="$('#drug_clinc_adv').click()" style="width: 140px;">&#10010; Drug Clinical Advisory</button>
                          <input type="file" name="drug_clinical_advise" style="display: none;" id="drug_clinc_adv">
                          <input type="hidden" name="order_message" id="orderMsg">
                          <button class="patient-message txt-grn-lt weight_600  tt_uc_ mr-14_" type="button" data-toggle="modal" data-target="#patient_msg-Modal" onclick="orderMessage()" style="width: 100px;">Patient Message</button>
                          <button class="weight_500 tt_uc_ mr-14_ br-rds-4 bg-dk-grn-txt-wht" type="button" onclick="clearForm('orderFormData')">Assistance D/C</button>
                          <button class="weight_500 tt_uc_ mr-14_ br-rds-4 bg-dk-grn-txt-wht" type="button" id="" style="min-width: 60px;">D/C-PT</button>
                          <button class="weight_500 tt_uc_ mr-14_ br-rds-4 bg-dk-grn-txt-wht" type="button" id="">Under Review</button>
                          <button class="weight_500 tt_uc_ br-rds-4 bg-dk-grn-txt-wht" type="button" id="">Filled</button>
                      </div>
                  </div>


              </form>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; visibility: hidden;">
      </div>

    </form>
  </div>
</div>

<!------------------------------------------------------------------------->
<!---------------****** Saving offers Modal Start *******------------------>
<!------------------------------------------------------------------------->

<div class="modal" id="saving_offers-Modal">
  <div class="modal-dialog wd-87p-max_w_700">
    <form class="modal-content compliance-form_">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title wd-100p">
            <span class="elm-left fs-20_" id="saving_offers_count">Saving Offers </span>
            <span class="elm-right fs-20_ tt_uc_ pr-14_" id="generic_name_id">sedactive / hypnotics</span>
        </h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button> <!-- &#10006; -->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					
      				<style>
      				    
      				    
      				    table.drug-data-table {  }
                  table.drug-data-table.hd-row-blue-shade-rounded > tbody.show { display: table-row-group; }
      				    table.drug-data-table tr.td-pad-0 {  }
      				    table.drug-data-table tr.td-pad-0 td { padding: 0px !important; }
      				    
      				    table.drug-data-table tr th .same-drug-hd-pl-mn-btn { position: relative; }
      				    table.drug-data-table tr th .same-drug-hd-pl-mn-btn:before { display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;content: "\f067";color: #fff;background-color: #3e7bc4;text-align: center;font-size: 16px;position: absolute;top: 0px;right: 0px;width: 16px;height: 16px;line-height: 17px;border-radius: 2px;margin-top: -1px; }
      				    table.drug-data-table tr th .same-drug-hd-pl-mn-btn[aria-expanded="false"]:before { content: "\f067"; }
      				    table.drug-data-table tr th .same-drug-hd-pl-mn-btn[aria-expanded="true"]:before { content: "\f068"; background-color: #3e7bc4;}
      				    
      				    table.drug-data-table tr th { border-left: 0px; }
      				    table.drug-data-table tr td { border-left: 0px; }
      				    table.drug-data-table tbody tr:nth-child(odd) { background-color: #fff; }
      				    table.drug-data-table tbody tr:nth-child(even) { background-color: #fff; }
      				    table.drug-data-table tbody tr td { border-bottom: solid 1px #cecece; }
      				    table.drug-data-table tbody tr:last-child td { border-bottom: solid 0px #cecece; }

                  
      				    
      				</style>
      				
      				<div class="row mt-7_">
            			<div class="col-sm-12  table-responsive">
            				<table class="table drug-data-table bordered hd-row-blue-shade-rounded" id="same_drugs_table">
            					<thead>
            						<tr class="weight_500-force-childs bg-blue">
            							<th class="txt-wht tt_uc_" id="same_drug_count">same drug </th>
            							<th class="txt-wht cnt-right-force c-dib_ pos-rel_" style="width: 100px;">
            							    <span class="same-drug-hd-pl-mn-btn cur-pointer weight_600 fs-16_ txt-center collapsed"
            								  data-target="#expand-collapse-samedrugs"
            								  data-toggle="collapse"
            								  aria-expanded="false"
            								  style="width: 16px;height: 16px;"></span>
            							</th>
            						</tr>
            					</thead>
            					<tbody id="expand-collapse-samedrugs" class="collapse">
            						
            						
            					</tbody>
            				</table>
            			</div>
            		</div>
            		
            		
            		
            		<div class="row mt-7_">
            			<div class="col-sm-12  table-responsive">
            				<table class="table drug-data-table bordered hd-row-blue-shade-rounded" id="similar_drugs_table">
            					<thead>
            						<tr class="weight_500-force-childs bg-blue">
            							<th class="txt-wht tt_uc_" id="similar_drug_count">similar drug </th>
            							<th class="txt-wht cnt-right-force c-dib_ pos-rel_" style="width: 100px;">
            							    <span class="same-drug-hd-pl-mn-btn cur-pointer weight_600 fs-16_ txt-center collapsed"
            								  data-target="#expand-collpase-tbody1"
            								  data-toggle="collapse"
            								  aria-expanded="false"
            								  style="width: 16px;height: 16px;"></span>
            							</th>
            						</tr>
            					</thead>
            					<tbody id="expand-collpase-tbody1" class="collapse">
            						
            					</tbody>
            				</table>
            			</div>
            		</div>
  					
  					
  				</div>
  			</div>
      </div>
    </form>
  </div>
</div>
<!------------------------------------------------------------------------->
<!---------------****** Saving offers Modal End *******------------------>
<!------------------------------------------------------------------------->






<!------------------------------------------------------------------------->
<!---------------****** Dosage Reminders Modal Start *******------------------>
<!------------------------------------------------------------------------->


<div class="modal" id="dosage-reminder" aria-modal="true" style="display: block; padding-left: 9px; background-color: rgba(0,0,0,0.4); ">
  <div class="modal-dialog wd-87p-max_w_700 ">
    
    <form class="modal-content" style="background-color:#f2f2f2">
      <div class="modal-header">
          <h4 class="modal-title">Suggest Dose Reminder</h4>
          <!-- button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button-->
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 compliance-form_ ">
            <div class="flx-justify-start f-wrap flex-vr-end mb-14_">
              <div class="field wd-100p mr-14_" style=" max-width: 170px;">
                <label class="wd-100p c-dib_ mb-2_  weight_500">Select Start Date</label>
                <input class="wd-100p" type="date">
              </div>
              <div class="c-dib_ c-mr-4_">
                <label class="cur-pointer mr-14_" for="with_me" style=" margin-right: 14px;">
                  <input class="size-17_ mt-0_" id="with_me" name="InsuranceType" type="radio" value="Commercial" style="margin-top: 0px;">
                  <span class="text fs-14_">With Me</span>
                </label>
                <label class="cur-pointer" for="without_me">
                  <input class="size-17_ mt-0_" id="without_me" name="InsuranceType" type="radio" value="Commercial" style="margin-top: 0px;">
                  <span class="text fs-14_">WithOut Me</span>
                </label>
              </div>  
            </div>  
            <div class="flx-justify-start f-wrap flex-vr-end ">
              <div class="wd-49p field fld-rx-brand-generic-name mr-auto"style="background-color:#fff">
                <div class="trow_ wd-100p pa-5_ br-rds-0 mt-0_" style="border: solid 1px #cecece; align-content: flex-start;">
                <div class="flx-justify-start f-wrap flex-v-center ">
                    <label class="cur-pointer mr-14_" for="daily" style="margin-bottom: 0px;">
                      <input class="size-17_ mt-0_" id="daily" name="InsuranceType" type="radio" value="Commercial" style="margin-top: 0px;">
                      <span class="text fs-14_ txt-red weight_600">DAILY</span>
                    </label>
                    <label class="cur-pointer" for="week" style="margin-bottom: 0px;">
                      <input class="size-17_ mt-0_" id="week" name="InsuranceType" type="radio" value="Commercial" style="margin-top: 0px;">
                      <span class="text fs-14_ txt-blue weight_600">WEEK</span>
                    </label>	      
                  </div>
                </div>      
                <div class="trow_ wd-100p pa-6_ br-rds-0 mt-0_" style="border: solid 1px #cecece; align-content: flex-start; margin-top: -1px;">
                  <div class="flx-justify-start f-wrap flex-v-center c-mr-7_ daily-weekly-list" >
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="sunday">
                      <span class="txt-gary weight_600 p4-8_ ">SUN</span>
                      
                    </div>
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="monday">
                      <span class="txt-gray weight_600 p4-8_ ">MON</span>
                      
                    </div>
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="tuesday">
                      <span class="txt-gray weight_600 p4-8_ ">TUS</span>
                      
                    </div>
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="wednesday">
                      <span class="txt-gray weight_600 p4-8_ " >WED</span>
                      
                    </div>
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="thursday">
                      <span class="txt-gray weight_600 p4-8_ ">THU</span>
                      
                    </div>
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="friday">
                      <span class="txt-gray weight_600 p4-8_ ">FRI</span>
                      
                    </div>
                    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ br-rds-0 dw-choice">
                      <input type="checkbox" name="saturday">
                      <span class="txt-gray weight_600 p4-8_ ">SAT</span>
                      
                    </div>
                  </div>	
                </div>
              </div>
              <div class="wd-49p field fld-rx-brand-generic-name"style="background-color:#fff">
                <div class="trow_ wd-100p pa-6_ br-rds-0 mt-0_" style="border: solid 1px #cecece; align-content: flex-start;">
                  <div class="flx-justify-start f-wrap flex-v-center c-mr-7_ ">
                    <span class="txt-red weight_600 mr-4_">PICK TIME</span>				      
                  </div>
                </div>
                <div class="trow_ wd-100p pa-6_ br-rds-0 mt-0_" style="border: solid 1px #cecece; align-content: flex-start;margin-top: -1px;">
                  <div class="flx-justify-start f-wrap flex-v-center c-mr-7_ ">
                    <div class="c-dib_ c-mr-4_">
                      <label class="cur-pointer mr-14_" for="break_fast" style=" margin-right: 10px;">
                        <input class="size-17_ mt-0_" id="break_fast" name="InsuranceType" type="checkbox" value="Commercial" style="margin-top: 0px;">
                        <span class="text fs-14_  weight_600  ">BREAKFAST (8AM)</span>
                      </label>
                      <label class="cur-pointer" for="dinner">
                        <input class="size-17_ mt-0_" id="dinner" name="InsuranceType" type="checkbox" value="Commercial" style="margin-top: 0px;">
                        <span class="text fs-14_ weight_600 ">DINNER (8PM)</span>
                      </label>
                    </div>
                    <div class="c-dib_ c-mr-4_">
                      <label class="cur-pointer mr-14_" for="lunch" style=" margin-right: 14px;">
                        <input class="size-17_ mt-0_" id="lunch" name="InsuranceType" type="checkbox" value="Commercial" style="margin-top: 0px;">
                        <span class="text fs-14_  weight_600 ">LUNCH (1PM)</span>
                      </label>
                      <label class="cur-pointer" for="bed_time">
                        <input class="size-17_ mt-0_" id="bed_time" name="InsuranceType" type="checkbox" value="Commercial" style="margin-top: 0px;">
                        <span class="text fs-14_  weight_600 ">BEDTIME (10PM)</span>
                      </label>
                    </div>          
                  </div>
                </div>      
              </div>
            </div>
          </div>
        </div>
      </div> <!-- .modal-body -->
      <div class="modal-footer">
        <div class="flx-justify-start wd-100p">
          <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_" data-dismiss="modal">CANCEL</button>
          <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">OK</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!------------------------------------------------------------------------->
<!---------------****** Dosage Reminder Modal End *******------------------>
<!------------------------------------------------------------------------->
