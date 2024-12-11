<div class="modal" id="order_edit_Modal">
    <div class="modal-dialog wd-87p " style="max-width: 700px;">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header pos-rel_">
  
          <div class="trow c-dib_"><h4 class="modal-title fs-16 mr-14_">Order Status Update</h4>
          <span class="mt-2_" id="orderstatusname" style="
              background-color: #559928;
              padding: 2px 4px;
              border-radius: 24px;
              min-width: 60px;
              text-align: center;
              padding-top: 3px;
          "></span></div>

          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 compliance-drug-form_">
                <form class="compliance-drug-form_ " id="orderUpdateData" autocomplete="off" novalidate="novalidate">
                  <input type="hidden" id="PatientId" name="PatientId" value="">
                  <input type="hidden" id="drugRxExpire" value="">
                  <input type="hidden" name="Id" value="">
                    <div class="row">
                        <div class="col-sm-12 cnt-center">
                            {{--<h6 class="ma-0_ mb-4_ txt-blue fs-16_ elm-left weight_600">Rx ENROLLMENT</h6>--}}
      
                            <span class="site-red-color fs-14_ all-order-error" style="display: none;"></span>
      
                        </div>
                    </div>
                    <div class="flx-justify-start flds_rxn-orxd-ph_txt-ndb mb-14_">
                        <div class="field fld-rx_number mr-1p" style="width: 130px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 cnt-left mb-0_" >Rx No.</label>
                        <input class="wd-100p tt_uc_" id="rx_no" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" name="RxNumber" value="" placeholder="-" minlength="5" maxlength="15" required="" disabled>
                        </div>
                        <div class="field fld-original_rx mr-1p pos-rel_" style="background-color: #fff; width:130px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">ORIGINAL Rx DATE</label>
                            <input class="wd-100p" id="datetimepicker" data-type="rem-dis" name="RxOrigDate" type="text" placeholder="MM/DD/YYYY" maxlength="10" mask="99/99/9999" value="" onblur="window.pharmacyNotification.calculateNextRefillDate(this.value);" required="" autocomplete="off" style="padding-right: 27px; background-color: transparent; position: relative; z-index:100;">
                            <span class="fa fa-calendar" style="position: absolute;top: 25px;right: 9px;z-index:40;"></span>
                        </div>
                        <div class="flds-ph_name-add_button pos-rel_" style="display:flex;align-items: center;">
                            <span class="wd-100p olympus_phar-txt fs-16 weight_600 cnt-right tt_uc_" id="pharmacy-txt">CLINIX RX PHARMACY</span>
                        </div>
                        <div style="display: flex; align-items: center">
                            <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_" type="button" id="drug_button" style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showDrug()">add new drug</button>
                        </div>
                        
                        <div class="ml-14_" style="display: flex; align-items: center; margin-left: auto;">
                            <button class="weight_500 tt_uc_ mr-4_ br-rds-13 bg-wht-txt-red status-btn pa1-8_" dis-status="[1,27]" type="button" onclick="updateOrder(27)" style="width: 80px;padding: 4px 8px;">Cancel</button>
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
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">Rx LABEL NAME OR NDC #</label>
                            <input class="wd-100p" id="drug" placeholder="Please Search Medicine" type="text" autocomplete="foo" onkeypress="return blockSpecialChar(event)" name="DrugName" value="" required="" disabled>
                                             </div>
                        <div class="wd-50p field fld-marketer">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">PRODUCT MARKETER</label>
                                                 <!--  <select class="wd-100p" placeholder="-" id="product_marketer" name="marketer" value="" required="">
      
                            </select> -->
                            <input class="wd-100p" type="text" name="marketer" id="product_marketer" disabled>
                                              </div>
                    </div>
      
      
                    <div class="flx-justify-start flds-str-df-br mb-14_">
                        <div class="wd-33p field fld-strength mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_" >STRENGTH</label>
                            
                                                  <div id="strengthFieldId">
                                                    <!-- <select id="dosage_strength" name="Strength" value="" class="form-control" placeholder="-"></select>
  
   -->                                            
                                                      <input type="text" name="Strength" class="form-control" id="dosage_strength" disabled>    
                                                  </div>
                                              </div>
                        <div class="wd-32p field fld-dosage_from mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">DOSAGE FORM</label>
                            <input class="wd-100p" type="text" name="DrugType" readonly="" id="PackingDescr" value="" placeholder="-">
                        </div>
                        <div class="wd-33p field fld-brand_ref">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ cnt-left mb-0_">Brand Reference</label>
                            <input class="wd-100p txt-red" type="text" name="BrandReference" readonly="" id="brandReference" value="" placeholder="-">
                        </div>
                    </div>
      
      
                    <div class="flx-justify-start flds-qt-ds-rr-ric-pop-pp-pi-aa flds-qt-ds-rr-ric-3pp-pc-rx_sl-rx_pr mb-14_">
                        <div class="field fld-qty mr-1p" style="width:76px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">QTY</label>
                            <input class="wd-100p cnt-right" type="text" data-type="rem-dis" name="Quantity" minlength="1" data-type="quantity" onkeypress="return numericOnly(event,8)" value="" placeholder="-" id="quantity" required>
                        </div>
                        <div class="wd-10p field fld-days-supply mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">Days Supply</label>
                            <input class="wd-100p cnt-right"  min="1" data-type="rem-dis" name="DaysSupply" value="" placeholder="-" onkeypress="return numericOnly(event,3)" id="daysSupplyFld" maxlength="3" minlength="1" onkeyup="window.pharmacyNotification.calculateNextRefillDate($('#datetimepicker').val());" required>
                        </div>
                        <div class="wd-12p field fld-refills-remain mr-1p" style="width: 60px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">REFILLS REMAIN</label>
                            <input class="wd-100p cnt-right" type="text" onkeypress="return IsDigit(event)" maxlength="2" minlength="1" name="RefillsRemaining" value="" placeholder="-" required>
                        </div>
                        <div class="wd-13p field fld-rx-ingr-cost  mr-1p highlight-red " style="width: 76px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">Rx INGR COST</label>
      
                            <input class="wd-100p cnt-right" name="RxIngredientPrice" data-type="rem-dis"
                             onkeypress="return IsDigit(event)" data-type="currency" 
                             type="text"  
                             onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" value="" placeholder="$0.00" id="drugPrice" required maxlength="10">
                        </div>
                        <div class="wd-16p field fld-thrd-party-pay mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">3<sup class="fs-f11_">rd</sup>&nbsp;PARTY PAID</label>
                            <input class="wd-100p cnt-right" data-type="currency" data-type="rem-dis" type="text" id="thirdPartyPaid" name="RxThirdPartyPay" placeholder="$0.00"  value="" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" required maxlength="10">
                        </div>
                        <div class="wd-14p field fld-patient-out-pocket mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">PATIENT OUT OF POCKET</label>
                            <input class="wd-100p cnt-right" type="text" data-type="rem-dis" name="RxPatientOutOfPocket"
                             placeholder="$0.00" data-type="currency"  value="" id="pocketOut"
                              onkeypress="return IsDigit(event)"
                               onblur="window.pharmacyNotification.calculateRxProfitability(this.value);" 
                               required maxlength="10">
                        </div>
      
                        <input type="hidden" name="InsuranceType">
                        
                        <div class="wd-13p field fld-assist-auth" style="width: 90px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">ASSISTANCE AUTHORIZED</label>
                            <input class="wd-100p cnt-right" data-type="currency" data-type="rem-dis" name="asistantAuth" minlength="1"
                             type="text" value="" placeholder="$0.00" maxlength="10"
                             onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());">
                        </div>
                        
                        <div class="wd-14p field fld-rx_sell mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ mb-0_">Rx Selling </label>
                            <input class="wd-100p cnt-right" type="text" name="RxSelling"  id="RxSelling" 
                            value=""
                             onblur="window.pharmacyNotification.calculateProfitabilityWithSelling(this.value);" 
                             placeholder="-" maxlength="11">
                        </div>
                        <div class="wd-14p field fld-rx_profit">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ mb-0_">Rx Profitability </label>
                            <input class="wd-100p cnt-right" type="text" name="RxProfitability" readonly="" id="rxProfitability" value="" placeholder="-" maxlength="13">
                        </div>
                        
                    </div>
      
                    <div class="flx-justify-start flds-rs_sl-rs_prf mb-14_">
                    
                        <div class="wd-33p field fld-pres_name">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left mb-0_">Prescriber Name </label>
                            <input type="hidden" name="prescriber_id">
                            <input class="wd-100p" type="text" id="basicAutoSelect" data-type="rem-dis" name="PrescriberName" placeholder="Search Prescriber" value="" autocomplete="off" required>
                        </div>
                        
                        
                    </div>
      
      
      
                    <div class="flx-justify-start mb-14_">
                        <div class="wd-33p field fld-pres_phone mr-13p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left mb-0_">Prescriber Phone </label>
                            <input class="wd-100p" name="PrescriberPhone" data-type="rem-dis" mask="(000) 000-0000" minlength="10" type="text" value="" placeholder="-" maxlength="14" required>
                        </div>
                        
                        <div id="barcode" style="margin-left: auto; max-height: 46px;"></div>
                        
                    </div>
      
                    <div class="flx-justify-start mb-14_">
                        <div class="flx-justify-start dr-cl-adv_pat-msg_btns-col wd-100p" style="min-width: 400px;">
                            <button class="weight_600 tt_uc_ mr-4_ drg-cln-adv txt-red pa-4f_  " type="button" {{--onclick="$('#drug_clinc_adv').click()"--}} data-toggle="modal" data-target="#clinical-Modal" style="width: 180px;">&#10010; Drug Clinical Advisory</button>
                            <input type="file" name="drug_clinical_advise" style="display: none;" id="drug_clinc_adv">
                            <input type="hidden" name="order_message" id="orderMsg">
                            <button class="weight_600  tt_uc_ mr-7_ patient-message txt-grn-lt pa-4f_" type="button" data-toggle="modal" data-target="#patient_msg-Modal" onclick="orderMessage()" style="width: 130px;">Patient Message</button>
                        </div>
                    </div>
                    
                    <div class="flx-justify-start flex-v-center">
                    	
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-red-txt-wht status-btn p4-12_" dis-status="[1,8,25,10,11]" type="button" onclick="updateOrder(25)" >Assistance D/C</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-red-txt-wht status-btn p4-12_" type="button" dis-status="[1,8,10,11]"  style="min-width: 80px;" onclick="updateOrder(11)">D/C-PT</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-orange-txt-wht status-btn p4-12_ " dis-status="[1,8,24,10]" type="button" onclick="updateOrder(24)" >Under Review</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-dk-grn-txt-wht status-btn p4-12_ " dis-status="[1,2,8,10]" type="button" onclick="updateOrder(2)" id="mbr-pay">MBR to Pay</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-dk-grn-txt-wht status-btn p4-12_ " dis-status="[1,2,8,11,25,23,27]" type="button" onclick="updateOrder(8)" id="filled">Filled</button>
                    	
                    	<button class="weight_500 tt_uc_ ml-auto_ br-rds-13 bg-wht-txt-blue p4-12_" type="button" style="width: 132px;">send app download link</button>
                    </div>
      
      
                </form>
            </div>
          </div>
        </div>
  
        <!-- Modal footer -->
        {{--<div class="modal-footer" style="font-size: 1px; visibility: hidden;">
        </div>--}}
  
      </div>
    </div>
  </div>


  @include('practice_module.patient_order_request.modal.clinical_advisory_modal')