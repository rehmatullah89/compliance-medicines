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
              "></span> <div class="mt-2_ ml-14_" id="orig_date_id">&nbsp; ORIGINAL Rx DATE:&nbsp;&nbsp;<span id="rx_orig_date"></span></div>              
          </div>
          <button class="btn bg-blue-txt-wht weight_500 fs-12 br-rds-13 tt_cc p4-8_" id="history_btn" data-toggle="modal" data-target="#modal-dashboard-history-preferences" type="button" style="line-height: 14px;min-width: 80px;margin-right: 3%;border: solid 1px #fff;margin-left: auto;">History / Preferences</button>
           <button class="mt-2_ bg-red-txt-wht" style="float:right; border-radius: 13px; text-align: center; line-height: 1em; font-size: 16px; display: none;" data-dismiss="modal" type="button" id="delete_order">Delete</button> 
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 compliance-drug-form_">



  <div class="trow_ pa-14_ c-dib_ bg-yellow-lt cnt-left">
                <div class="txt-black-24 weight_600 mr-4_ tt_uc_" id="p-nam"> </div>
                <div class="gender txt-blue weight_600" id="p-gen"></div>
                <div class="gender txt-blue weight_600">-</div>
                <div class="gender txt-black-24 weight_600" id="p-dob"></div>
                <div class="gender txt-blue weight_600">-</div>
                <div class="gender txt-blue weight_600" id="p-mob"></div>
                <div class="txt-red weight_600" id="p-type"></div>
                 <div class="txt-blue weight_600 elm-right" id='hcp_order'></div>
     </div>

              <input type="hidden" name="fee" id="fee-auth-zero" value="">
              <input type="hidden" name="fee" id="fee-auth-nonzero" value="">
              
              <input type="hidden" id="lower_cost_drug_id" name="lower_cost_drug_id" value="">
              <input type="hidden" id="lower_cost_drug_strength" name="lower_cost_drug_strength" value="">
              <input type="hidden" id="lower_cost_drug_dosage" name="lower_cost_drug_dosage" value="">
              <input type="hidden" id="lower_cost_drug_brand" name="lower_cost_drug_brand" value="">
              
              
                <form class="compliance-drug-form_ " id="orderUpdateData" autocomplete="off" novalidate="novalidate">
                  <input type="hidden" id="PatientId" name="PatientId" value="">
                  <input type="hidden" id="drugRxExpire" value="">
                  <input type="hidden" id="isPIPPatient" value="">
                  <input type="hidden" name="Id" id="Id" value="">
                  <input type="hidden" name="HcpOrderId" id="HcpOrderId" value="">
                    <div class="row">
                        <div class="col-sm-12 cnt-center">
                            {{--<h6 class="ma-0_ mb-4_ txt-blue fs-16_ elm-left weight_600">Rx ENROLLMENT</h6>--}}
      
                            <span class="site-red-color fs-14_ all-order-error" style="display: none; color: red"></span>
      
                        </div>
                    </div>
                    <div class="flx-justify-start flds_rxn-orxd-ph_txt-ndb mb-14_">
                        <div class="field fld-rx_number mr-1p" style="width: 130px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 cnt-left mb-0_" >Rx No.</label>
                        <input class="wd-100p tt_uc_ cnt-right" id="rx_no" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" name="RxNumber" value="" placeholder="-" minlength="5" maxlength="15" required="" disabled>
                        </div>
                        <div class="field fld-original_rx mr-1p pos-rel_" style="background-color: #fff; width:130px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_" id='date_label_id'>SERVICE DATE</label>
                            <input class="wd-100p" id="datetimepicker" data-type="rem-dis" name="service_date" type="text" placeholder="MM/DD/YYYY" maxlength="10" mask="99/99/9999" value="" onchange="window.pharmacyNotification.calculateNextRefillDate(this.value);" required="" autocomplete="off" style="padding-right: 27px; background-color: transparent; position: relative; z-index:100;">
                            <span class="fa fa-calendar" style="position: absolute;top: 25px;right: 9px;z-index:40;"></span>
                        </div>
                        <div class="flds-ph_name-add_button pos-rel_" style="display:flex;align-items: center;">
                            <span class="wd-100p olympus_phar-txt fs-16 weight_600 cnt-right tt_uc_" id="pharmacy-txt">CLINIX RX PHARMACY</span>
                        </div>
                        <div style="display: flex; align-items: center">
                            <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_" type="button" id="drug_button" style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showDrug()">add new drug</button>
                        </div>
                        
                        
                         
                         <div style="display: flex; justify-content: flex-start; align-items: center; margin-left: auto;" >
                            
                            <div class="ml-7_" id="print_button">
                               <a href="" target="_blank"> <button class="weight_500 tt_uc_ mr-4_ br-rds-13 bg-wht-txt-grnd status-btn pa1-8_" type="button" style="width: 80px;padding: 4px 8px;"><span class="fa fa-print mr-4_"></span>Print</button></a>
                            </div>
                            
                            <div class="ml-7_ reporter_prescription" id="cancel_button">
                                <button class="weight_500 tt_uc_ mr-4_ br-rds-13 bg-wht-txt-red status-btn pa1-8_" dis-status="[1,2,8,11,24,25,27]" type="button" onclick="validateCancelRequest();" style="width: 80px;padding: 4px 8px;">Cancel</button>
                             </div>
                            
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
                            <input class="wd-100p" id="drug" placeholder="Please Search Medicine" type="text" autocomplete="off" onkeypress="return blockSpecialChar(event)" name="DrugName" value="" required="" autocomplete="off" disabled>
                                             </div>
                        <div class="wd-50p field fld-marketer" id="select_product_marketer">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">PRODUCT MANUFACTURER</label>
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
                            <input class="wd-100p cnt-right" type="text" data-type="rem-dis" name="Quantity" minlength="1" data-type="quantity" onkeypress="return numericOnly(event,8);" onchange="validateChange(this.id);" value="" placeholder="-" id="quantity" required>
                        </div>
                        <div class="wd-10p field fld-days-supply mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">Days Supply</label>
                            <input class="wd-100p cnt-right"  min="1" data-type="rem-dis" name="DaysSupply" value="" placeholder="-" onkeypress="return numericOnly(event,3)" onchange="validateChange(this.id);" id="daysSupplyFld" maxlength="3" minlength="1" onkeyup="window.pharmacyNotification.calculateNextRefillDate($('#datetimepicker').val());" required>
                        </div>
                        <div class="wd-12p field fld-refills-remain mr-1p" style="width: 60px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">REFILLS REMAIN</label>
                            <input class="wd-100p cnt-right" type="text" onkeypress="return IsDigit(event)" maxlength="2" minlength="1" name="RefillsRemaining" onchange="validateChange(this.id);" id='RefillsRemaining' value="" placeholder="-" required>
                        </div>
                        <div class="wd-13p field fld-rx-ingr-cost  mr-1p highlight-red " style="box-shadow: -3px 1px 13px 3px #ffeb3b;width: 76px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">Rx INGR COST</label>
      
                            <input class="wd-100p cnt-right" name="RxIngredientPrice" onchange="validateChange(this.id);" data-type="currency"  data-type="rem-dis"
                             onkeypress="return IsDigit(event)"  type="text"  onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" value="" placeholder="$0.00" id="drugPrice" required maxlength="10">
                        </div>
                        <div class="wd-16p field fld-thrd-party-pay mr-1p" style="box-shadow: -3px 1px 13px 3px #ffeb3b;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">3<sup class="fs-f11_">rd</sup>&nbsp;PARTY PAID</label>
                            <input class="wd-100p cnt-right" data-type="currency" data-type="rem-dis" type="text" id="thirdPartyPaid" onchange="validateChange(thi
                            s.id);" name="RxThirdPartyPay" placeholder="$0.00"  value="" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" required maxlength="10">
                        </div>
                        <div class="wd-14p field fld-patient-out-pocket mr-1p" style="box-shadow: -3px 1px 13px 3px #ffeb3b;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">PATIENT OUT OF POCKET</label>
                            <input class="wd-100p cnt-right" type="text" data-type="currency" data-type="rem-dis" onchange="validateChange(this.id);" name="RxPatientOutOfPocket"
                             placeholder="$0.00"   value="" id="pocketOut"
                              onkeypress="return IsDigit(event)"
                               onblur="window.pharmacyNotification.calculateRxProfitability(this.value);" 
                               required maxlength="10">
                        </div>
      
                        <input type="hidden" name="InsuranceType">
                        
                        <div class="wd-13p field fld-assist-auth mr-1p" style="box-shadow: 0px 1px 13px 3px #ffeb3b;width: 90px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">ASSISTANCE AUTHORIZED</label>
                            <input class="wd-100p cnt-right" data-type="currency" data-type="rem-dis" name="asistantAuth" id="asistantAuth" onchange="validateChange(this.id);" minlength="1"
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
                        <div id="under_review_reason_div" class="br-rds-1 ml-7_ p4-8_ tt_cc_ txt-red weight_600" style="border: solid 1px #cecece;"><span class="trow_ txt-sline txt-red mb-4_" style="
                        vertical-align: top;
                    ">Dosing Instructions: </span><span id="under_review_reason_div_span" class="trow_ txt-sline txt-gray-6" style="
                        vertical-align: top; width: 300px; height: 70px; white-space: initial;"></span></div>
                        
                    </div>
      
      
      
                    <div class="flx-justify-start mb-14_ prescriber_buttons" id="prescriber_div_id">
                        <div class="wd-33p field fld-pres_phone mr-13p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left mb-0_">Prescriber Phone </label>
                            <input class="wd-100p" id="basicAutoSelect2" name="PrescriberPhone" data-type="rem-dis" mask="(000) 000-0000" type="text" value="" placeholder="-" >
                        </div>
                        
                        <div id="barcode" style="margin-left: auto; max-height: 46px; margin-right: 5px;align-self: center;"></div>
                        <div id="barcode1" style="margin-bottom: 10px; max-height: 46px;"></div>
                    </div>
      
                    <div class="flx-justify-start flex-vr-center mb-7_ ">
                                            
                        <div class="trow_ comment-box c-dib_" id="hcp_comment_area" style="display:none; width: 1500px;">
                            <div class="trow_ text-sline"><span class="tt_uc_ fs-11_ txt-gray-9 mr-4_">pharmacy</span><span class="tt_uc_ fs-11_ txt-black-24 weight_600">comments to HCP</span></div>
                            <div class="trow_"><textarea class="wd-100p bg-tb-pink" cols="20" style="border: solid 1px #eee; resize: none;  padding: 4px; " maxlength="100" id="pharmacy_comments_area" aria-invalid="false"></textarea></div>
                        </div>

                        <div class="flx-justify-start dr-cl-adv_pat-msg_btns-col wd-100p" id='position_buttons' style="min-width: 400px;">
                            <button class="weight_600 tt_uc_ mr-4_ drg-cln-adv txt-red pa-4f_  toggle_items" type="button" {{--onclick="$('#drug_clinc_adv').click()"--}} data-toggle="modal" data-target="#clinical-Modal" style="width: 180px;">&#10010; Drug Clinical Advisory</button>
                            <input type="file" name="drug_clinical_advise" style="display: none;" id="drug_clinc_adv">
                            <input type="hidden" name="order_message" id="orderMsg">
                            <button class="weight_600  tt_uc_ mr-7_ patient-message txt-grn-lt pa-4f_ toggle_items" type="button" data-toggle="modal" data-target="#patient_msg-Modal" onclick="orderMessage()" style="width: 130px;">Patient Message</button>
                            <button class="weight_600 tt_uc_ mr-4_ drg-cln-adv txt-red pa-4f_ toggle_items" type="button" id="lower_cost_drug_button" onclick="lowerCostDrug()" style="width: 130px;">Lower Cost Drug</button>
                            
                            <button class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ p6-12_ mr-7_" id="prev_order_edit" name="prev_order_edit" type="button" style="line-height: 14px; min-width: 80px; margin-left: auto;">&#10094; previous</button>
                            <button class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ p6-12_ mr-7_" id="next_order_edit" name="next_order_edit" type="button" style="line-height: 14px; min-width: 80px;">next &#10095;</button>
                            <button  id="copy_next_order_edit" name="copy_next_order_edit" type="button" style="display: none;"></button>
                            <button id="skip_order" type="button" style=""><i class="fa fa-fast-forward" aria-hidden="true"></i></button>                            
                        </div>
                    </div>
                    
                   <div class="flx-justify-start flex-v-center reporter_prescription">
                    	
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-red-txt-wht status-btn p4-12_" dis-status="[1,8,25,10,11,27,28]" type="button" onclick="updateOrder(25)" >Assistance D/C</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-red-txt-wht status-btn p4-12_" type="button" dis-status="[1,8,10,11,27,28]"  style="min-width: 80px;" onclick="updateOrder(11)">D/C-PT</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-orange-txt-wht status-btn p4-12_ " dis-status="[1,8,24,10,27,28]" type="button" data-toggle="modal" data-target="#under_review_reason" >Under Review</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-dk-grn-txt-wht status-btn p4-12_ " dis-status="[1,2,23,8,10,27,28]" type="button" onclick="processMbrToPay();" id="mbr-pay"enable>MBR to Pay</button>
                        <button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-dk-grn-txt-wht status-btn p4-12_ " dis-status="[1,2,8,11,24,25,27]" type="button" onclick="updateOrder(8)" id="filled">Filled</button>
                    	
                    	<button class="weight_500 tt_uc_ ml-auto_ br-rds-13 bg-wht-txt-blue p4-12_" type="button" id="send_download_link" style="width: 132px;">send app download link</button>
                    </div>
             
                      <input type="hidden" id="pat_mobile" >
      
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


 <!-- Start Lower cost option modal -->

 <div class="modal" id="lower_cost_modal">
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

<!-- End Lower cost option modal-->


 <!-- Start Under review model -->
      <div class="modal fade new_edit_modal_parent " id="under_review_reason" role="dialog">

        <div class="modal-dialog modal-sm">

            <div class="modal-content edit_new_modal">

                <div class="modal-header">

                    <h4 class="modal-title">Under Review Reason</h4>

                    <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>

                </div>

                <div class="modal-body new_pad_edit">

                    <div class="row">


                        <div class="col-sm-12 col-md-12 col-lg-12">

                            <div class="form-group">

                                <label>Enter under Review Reason:</label>

                                <textarea placeholder="Write Reason Here" style="overflow:auto;padding-top: 0px;padding-bottom: 0px;margin: 0px 3.05556px 7.98611px 0px;width: 763px;height: 65px;min-height: 65px; max-width: 100%;padding-top: 4px;" name="under_review_textarea" required onblur="$('#under_review_reason').val(this.value);"  class="custom_add_inputs form-control"  id="under_review_textarea" maxlength="255"></textarea>

                            </div>

                        </div>

                       

                    </div>

                </div>

                <div class="modal-footer">

                  <div class="flx-justify-start wd-100p">

                      <button type="button" class="btn bg-red-txt-wht weight_500 tt_uc_" data-dismiss="modal">cancel</button>

                      <button type="button" class="btn bg-blue-txt-wht weight_500 tt_uc_" data-dismiss="modal"  onclick="updateOrder(24)" style="margin-left: auto;">SAVE</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    <!--  end under review model ----------->
    
<!--------- Drug Detail Modal Start-----------------------
  <div class="modal" id="alternate_drug_modal">
      <div class="modal-dialog" style="max-width:500px;">
    <form class="modal-content bg-white" style="border: solid 1px #cecece;box-shadow: 0px 1px 7px 1px #cecece;">

      
      <div class="modal-header pa-14_ f-wrap bg-transparent-force pos-rel_" style="font-size: 1px; padding: 14px;">
        
        <h4 class="trow_ modal-title cnt-center">
        	<span class="txt-blue weight_600 fs-24_ tt_uc_" >Original Drug Details</span>
        </h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button>
      </div>
	  
      
      <div class="modal-body pa-0_ pl-14_ pr-14_">
        <div class="row">
          <div class="col-sm-12">
              <div class="trow_ cnt-left c-dib_ mb-6_">
              	  <div class="elm-left c-dib_ cnt-left">
              	  	<span class="txt-black-24 fs-17_ weight_700 txt_uc_">RX BRAND/ GENERIC:</span>
              	  	<span class="txt-red fs-16_ weight_600 tt_uc_ fs-16_ lh-20_  " id="rx_label_generic"></span>
              	  </div>              	  
              </div>
			  
			  <div class="trow_ cnt-left c-dib_ mb-6_">
              	  <div class="elm-left c-dib_ cnt-left">
              	  	<span class="txt-black-24 fs-17_ weight_700 txt_uc_">DOSAGE FORM:</span>
              	  	<span class="txt-red fs-16_ weight_600 tt_uc_ fs-16_ lh-20_  " id="dosage_value"></span>
              	  </div>
              </div>
			  
			  <div class="trow_ cnt-left c-dib_ mb-6_">
              	  <div class="elm-left c-dib_ cnt-left">
              	  	<span class="txt-black-24 fs-17_ weight_700 txt_uc_">STRENGTH:</span>
              	  	<span class="txt-red fs-16_ weight_600 tt_uc_ fs-16_ lh-20_  " id="strength_value"></span>
              	  </div>
              </div>
              
              <div class="trow_ cnt-left c-dib_ mb-6_">
              	  <div class="elm-left c-dib_ cnt-right">
              	  	<span class="txt-black-24 fs-17_ weight_700 txt_uc_">QUANTITY:</span>
              	  	<span class="txt-red fs-16_ weight_600 tt_uc_ fs-16_ lh-20_  " id="quantity_value"></span>
              	  </div>
              </div>

             <div class="trow_ cnt-left c-dib_ mb-0_">
				<div class="elm-left c-dib_ cnt-right">
              	  	<span class="txt-black-24 fs-16_ weight_700 txt_uc_">REFILLS:</span>
              	  	<span class="txt-red fs-16_ weight_600 tt_uc_ fs-16_ lh-20_  " id="refills_value"></span>
              	  </div>
            </div>
              
            {{-- <div class="trow_ cnt-left c-dib_ mb-0_">
				<div class="elm-left c-dib_ cnt-right">
              	  	<span class="txt-black-24 fs-16_ weight_700 txt_uc_">HCP Comments:</span>
              	  	<span class="txt-red fs-16_ weight_600 tt_uc_ fs-16_ lh-20_  " id="comments_value"></span>
              	  </div>
            </div>  --}}

          </div>
        </div>
      </div>

      <div class="modal-footer pa-0_ pb-14_">
          <div class="flx-justify-center wd-100p">
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-16_ p4-8_ tt_uc_" style="min-width: 80px;" data-dismiss="modal" >OK</button>
          </div>
      </div>

    </form>
  </div>
</div>
			---------- Drug Detail Modal End

--------------->
  
<!--------------- hcp comments modal --------------------------->
<div class="modal" id="hcpPharmacyMessages" style="margin-top: 35px;">

	<div class="modal-dialog" style="width: 80% !important; max-width: 700px !important;">



		<form class="modal-content" novalidate="novalidate" action="javascript:void(0);" id="patient_form3" name="patient_form3" method="post">
			<!-- Modal Header -->

			<div class="modal-header">
				<h4 class="modal-title">Edit Drug History</h4>
				<button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body  pa-0_ ">
                            
                            <div class="col-sm-12">
                                <div class="flx-justify-start" style="margin-top:5px;">
                                
                                <div class="wd-49p bg-white">
                                        <div class="trow_ bg-blue txt-wht pa-4_ weight_500" id="hcp_title">Dr. George</div>
                                        <div class="trow_ pa-6_ ">
                                                <div class="trow_ " style="overflow-y: auto; max-height: 140px;" id="hcp_drug_info">

                                                </div>
                                        </div>
                                </div>
                                <div class="wd-49p bg-yellow2 ml-auto">
                                        <div class="trow_ bg-blue txt-wht pa-4_ weight_500" id="pharmacy_title">Clinix</div>
                                        <div class="trow_ pa-6_ ">
                                                <div class="trow_ " style="overflow-y: auto; max-height: 140px;" id="pharmacy_drug_info">

                                                

                                                </div>
                                        </div>
                                </div>
  						
  					</div>
  					
			  
			  <div class="trow_  cnt-center mt-7_ fs-z_ c-dib_">
                                <span class="txt-blue tt_uc_ fs-14_ cnt-center weight_600">message history</span>
			  </div>
			  
			  <div class="trow_ pl-14_ pr-14_ mt-7_ mb-14_">

				<div class="row">

					<div class="col-sm-12">

						<input type="hidden" name="OrderId" id="HCP_OrderId" value="" />
                                                <input type="hidden" name="HCP_Name" id="HCP_Name" value="" />
                                                <input type="hidden" name="Pharmacy_Name" id="Pharmacy_Name" value="" />
                                                <div class="trow_ pa-7_ pos-rel_" style="border: solid 4px #afd13f; height: 160px;">

							<!-- <span class="fa fa-paperclip txt-blue pos-abs_" style="position: absolute; top: 14px; right: 7px;"></span> -->
							<div class="trow_ mb-7_" style="display: none">
								<span class="weight_600" style="margin-right: 3px;">RE:</span>
                                                                <span class="txt-blue tt_uc_" id="rxPop"></span>&nbsp;
                                                                <span class="txt-black-14" id="medNamePop"></span>
							</div>

							<div class="txt-blue weight_900 trow_ mb-7_" style="display: none" >
								<span class="weight_600" id="patientNameShow1"></span> &nbsp; <span
									class="weight_600" id="pracPop"></span>
							</div>

                                                    <div data-v-6a49c60d="" class="col-sm-12 pl-0 pr-0" style="height: 110px;">
								<div data-v-6a49c60d="" id="hcp_chat_history"
									class="trow_ pos-rel_ mb-7_ pa-4_ br-rds-2 feed"
									style="border: 1px solid rgb(119, 119, 119); min-height: 40px;">
								</div>
							</div>
                			
                			<input type="text" class="trow_ txt-red p4-8_ weight_600" name="Message" maxlength="100" style="" placeholder="type message here" id="hcpOrderMessage">
					<label id="error_msg_show" class="error" style="display: none;">This field is required.</label>
						</div>
					</div>
				</div>
			  </div>
                       
                    </div>
                 </div> 
			<!-- Modal footer -->
			<div class="modal-footer">
				<div class="flx-justify-start wd-100p">
					<button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal">cancel</button>

					<button type="button"
						class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ "
						style="margin-left: auto;" id="sendMessage" onclick="addHcpMessage()">send</button>

				</div>
			</div>
		</form>
	</div>
</div>
<!-------- HCP comments end------------->  

<!-------- Order History Modal Start------------->  

<div class="modal" id="modal-dashboard-history-preferences">
  <div class="modal-dialog wd-87p-max_w_1024">
    <form class="modal-content compliance-form_">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">History / Preferences</h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button> <!-- &#10006; -->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					
  					<div class="flx-justify-start ">
  						
  						<div class="txt-blue weight_600 " style="margin-right: 4%;" id="hist_rx_no">Rx: APT-0001</div>
  						<div class="txt-blue weight_600 " style="margin-right: 4%;" id="hist_drug_stren_dosage">INDAPAMIDE 1.25MG TAB</div>
  						<div class="txt-blue weight_600 " style="margin-right: 4%;" id="hist_pharmacy">PARSONS LAB</div>
  						
  						
              <div class="txt-blue weight_500 c-dib_" style="margin-left: auto; margin-right: 6%;">
                  <div class="txt-blue tt_uc_ mr-4_ weight_600" style="margin-right: 4%; width:100%;" id="hist_gpi_no">GPI-14: 45689608489103</div>
              </div>
  					</div>
  					
  					<div class="row" style="margin:0px  -14px;">
  						<div class="col-sm-12 pr-0 pl-0">
          					<div class="mt-4_ mb-14_ flx-justify-start bg-yellow-lt p8-12_ ">
          						
          						<div class="txt-blue weight_500 c-dib_">
          							<div class="txt-black-24 tt_uc_ mr-4_ weight_600" id="hist_patient">conny burket</div>
          							<div class="txt-blue tt_uc_ mr-4_" id="hist_patient_dob">DOB: 11/21/1966</div>
          							<div class="txt-black-24 tt_lc_ mr-4_ weight_600" id="hist_patient_age">(54 yrs)</div>
          							<div class="txt-blue tt_uc_ mr-4_" id="hist_patient_phone"> - (248) 801-9011</div>
          						</div>
          						
          						<div class="txt-blue weight_500 c-dib_" style="margin-left: auto; margin-right: 6%;">
          							
          							<div class="txt-black-24 tt_uc_ mr-4_ weight_600" id="hist_drug_major_cat">cardiovascular</div>
          							<div class="txt-blue tt_uc_ mr-4_" id="hist_drug_minor_cat">potas sparing diurutics</div>
          							
          						</div>
          						
          					</div>
          				</div>
      				</div>
      				
      				<style>
      				    
      				    
      				    table.history_preference_table tr.td-pad-0 {  }
      				    table.history_preference_table tr.td-pad-0 td { padding: 0px !important; }
      				    
                  table.history_preference_table tr.show { display: table-row !important;}

      				    table.history_preference_table tr td .hstr-pref-pl-mn-btn { position: relative; }
      				    table.history_preference_table tr td .hstr-pref-pl-mn-btn:before { display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;content: "\f067";color: #fff;background-color: #3e7bc4;text-align: center;font-size: 13px;position: absolute;top: 0px;right: 0px;width: 16px;height: 16px;line-height: 17px;border-radius: 2px;margin-top: -1px; }
      				    table.history_preference_table tr td .hstr-pref-pl-mn-btn[aria-expanded="false"]:before { content: "\f067"; }
      				    table.history_preference_table tr td .hstr-pref-pl-mn-btn[aria-expanded="true"]:before { content: "\f068"; background-color: #afd13f;}
      				    
      				    
      				    table.history_preference_table table.hst-prf-inner-table {margin-bottom: 4px !important; margin-top: 7px !important;}
      				    table.history_preference_table table.hst-prf-inner-table tr {  }
      				    table.history_preference_table table.hst-prf-inner-table tr td { border: 0px; border-bottom: solid 1px #cecece; }
      				    table.history_preference_table table.hst-prf-inner-table tr:last-child { border-bottom: solid 0px #cecece; }
      				    table.history_preference_table table.hst-prf-inner-table tr:nth-child(odd){ background-color: #fff; }
      				    table.history_preference_table table.hst-prf-inner-table tr:nth-child(even){ background-color: #fff; }
      				    
      				    
      				</style>
      				
      				<div class="row mt-14_ mb-7_">
            			<div class="col-sm-12  table-responsive">
            				<table id="history_preference_table" class="table history_preference_table bordered hd-row-blue-shade-rounded">
            					<thead>
            						<tr class="weight_500-force-childs bg-blue">
            							<th class="txt-wht">Fill#</th>
            							<th class="txt-wht cnt-center-force">Date of Service</th>
            							<th class="txt-wht cnt-center-force">NDC</th>
            							<th class="txt-wht cnt-center-force">Qty</th>
            							<th class="txt-wht cnt-center-force">Days Supply</th>
            							<th class="txt-wht cnt-center-force">ING Cost</th>
            							<th class="txt-wht cnt-center-force">3rd Party Paid</th>
            							<th class="txt-wht cnt-center-force">Orig PT Co-Pay</th>
            							<th class="txt-wht cnt-center-force">Final PT Out of Pocket</th>
            						</tr>
            					</thead>
            					<tbody>
            						<tr>
            							<td class="txt-black-24 tt_uc_ weight_600">-01</td>
            							<td class="cnt-left-force">5-15-20</td>
            							<td class="cnt-left-force">00026-0307-02</td>
            							<td class="cnt-left-force">90</td>
            							<td class="cnt-left-force">90</td>
            							<td class="cnt-right-force">$17.85</td>
            							<td class="cnt-right-force">$415.36</td>
            							<td class="cnt-right-force">$75.00</td>
            							<td class="cnt-right-force c-dib_">
            								<span class="mr-4_">$0.00</span>
            								<span class="hstr-pref-pl-mn-btn cur-pointer weight_600 fs-16_ txt-center collapsed"
            								  data-target="#expand-collpase-tr1"
            								  data-toggle="collapse"
            								  aria-expanded="false"
            								  style="width: 16px;height: 16px;"></span>
            							</td>
            						</tr>
            						
            						<tr id="expand-collpase-tr1" class="collapse">
            							<td class="" colspan="9" style="padding-left: 6%; padding-right: 6%;">
            								
            								<table class="table bordered hst-prf-inner-table hd-row-green-shade-rounded">
                            					<thead>
                            						<tr class="weight_500-force-childs bg-blue">
                            							<th class="txt-wht">Date</th>
                            							<th class="txt-wht cnt-center-force">Service</th>
                            							<th class="txt-wht cnt-center-force">Detail</th>
                            							<th class="txt-wht cnt-center-force">Earned Award</th>
                            						</tr>
                            					</thead>
                            					<tbody>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">MBR to Pay</td>
                            							<td class="cnt-left-force">$75.00</td>
                            							<td class="cnt-left-force">&nbsp;</td>
                            						</tr>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">MBR Paid</td>
                            							<td class="cnt-left-force">$75.00 Compliance Reward Card</td>
                            							<td class="cnt-left-force">&nbsp;</td>
                            						</tr>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">Pharmacy Filled</td>
                            							<td class="cnt-left-force">Script n' Save</td>
                            							<td class="cnt-left-force">18.75 <span class="txt-red tt_uc_">vgw</span></td>
                            						</tr>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">PT. Activity</td>
                            							<td class="cnt-left-force">Body Mass (26.4 BMI)</td>
                            							<td class="cnt-left-force">18.75 <span class="txt-red tt_uc_">vgw</span></td>
                            						</tr>
                            					</tbody>
                            				</table>
            							</td>
            						</tr>
            						
            						<tr>
            							<td class="txt-black-24 tt_uc_ weight_600">-00</td>
            							<td class="cnt-left-force">5-15-20</td>
            							<td class="cnt-left-force">00026-0307-02</td>
            							<td class="cnt-left-force">90</td>
            							<td class="cnt-left-force">90</td>
            							<td class="cnt-right-force">$17.85</td>
            							<td class="cnt-right-force">$415.36</td>
            							<td class="cnt-right-force">$75.00</td>
            							<td class="cnt-right-force c-dib_">
            								<span class="mr-4_">$0.00</span>
            								<span class="hstr-pref-pl-mn-btn cur-pointer weight_600 fs-16_ txt-center collapsed"
            								  data-target="#expand-collpase-tr2"
            								  data-toggle="collapse"
            								  aria-expanded="false"
            								  style="width: 16px;height: 16px;"></span>
            							</td>
            						</tr>
            						
            						<tr id="expand-collpase-tr2" class="collapse">
            							<td class="" colspan="9" style="padding-left: 6%; padding-right: 6%;">
            								
            								<table class="table bordered hst-prf-inner-table hd-row-green-shade-rounded">
                            					<thead>
                            						<tr class="weight_500-force-childs bg-blue">
                            							<th class="txt-wht">Date</th>
                            							<th class="txt-wht cnt-center-force">Service</th>
                            							<th class="txt-wht cnt-center-force">Detail</th>
                            							<th class="txt-wht cnt-center-force">Earned Award</th>
                            						</tr>
                            					</thead>
                            					<tbody>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">MBR to Pay</td>
                            							<td class="cnt-left-force">$75.00</td>
                            							<td class="cnt-left-force">&nbsp;</td>
                            						</tr>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">MBR Paid</td>
                            							<td class="cnt-left-force">$75.00 Compliance Reward Card</td>
                            							<td class="cnt-left-force">&nbsp;</td>
                            						</tr>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">Pharmacy Filled</td>
                            							<td class="cnt-left-force">Script n' Save</td>
                            							<td class="cnt-left-force">18.75 <span class="txt-red tt_uc_">vgw</span></td>
                            						</tr>
                            						<tr>
                            							<td class="cnt-left-force">5-15-20</td>
                            							<td class="cnt-left-force">PT. Activity</td>
                            							<td class="cnt-left-force">Body Mass (26.4 BMI)</td>
                            							<td class="cnt-left-force">18.75 <span class="txt-red tt_uc_">vgw</span></td>
                            						</tr>
                            					</tbody>
                            				</table>
            								
            							</td>
            						</tr>
            						<tr class="td-pad-0">
            							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            						</tr>
            						
            					</tbody>
            				</table>
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
<!-------- Order History Modal End-------------> 