
<style>
.page-heading-row {
	padding-left: 14px !important;
}

.rx-field-row {
	padding-left: 14px !important;
}

.feed[data-v-6a49c60d] {
	background: #f0f0f0;
	height: 100%;
	max-height: 260px;
	overflow: scroll;
	overflow-x: unset;
}

.br-rds-2 {
	border-radius: 2px;
}

.feed ul[data-v-6a49c60d] {
	list-style-type: none;
	padding: 2px 0;
}

.feed ul li.message.received[data-v-6a49c60d] {
	text-align: right;
}

.feed ul li.message.sent[data-v-6a49c60d] {
	text-align: left;
}

.feed ul li.message[data-v-6a49c60d] {
	margin: 5px 0;
	width: 100%;
}

.feed ul li.message.received .text[data-v-6a49c60d] {
	background: lightgreen;
}

.feed ul li.message.sent .text[data-v-6a49c60d] {
	background: #81c4f9;
}

.feed ul li.message .text[data-v-6a49c60d] {
	/* max-width: 200px; */
	border-radius: 5px;
	padding: 4px 6px;
	display: inline-block;
}
</style>

	<div id="invoice_screen2" class="" style="">

		<div class="trow_ bg-gray-d9 pa-c-14-0_ pt-14_ fs-13-force-child_">

			<div class="trow_ c-dib_ mb-7_ cnt-center">
				<div class="elm-left" id="date_created">2019-12-12 18:31:20</div>
				<div class="elm-right" id="time_created">18:31</div>
			</div>
			<div class="trow_ mb-2_ c-dib_ cnt-center">
				<div class="cnt-left fs-16_ mb-3_ mr-4_ weight_600" id="pharmacy_name">OLYMPUS Rx</div>
				<!-- <div class="cnt-right fs-13_ mb-3_ weight_600 tt_uc_">pharmacy</div> -->
			</div>

			<div class="trow_ mb-2_">
				<div class="trow_ c-dib_ cnt-center fs-16_ weight_500">
					<span class="mr-4_" id="practice_address">house123 test</span> 
					<span class=" cnt-left fs-13_ mb-3_ weight_500 tt_uc_" id="pharmacy_address">LEWISVILLE, CA 48188-5</span>
				</div>
			</div>

			<div class="trow_ c-dib_ cnt-center">
				<div class="cnt-left fs-16_ mb-3_ mr-4_ weight_500" id="practice_email">http://testing.com.pk</div>
				<div class="cnt-left fs-13_ mb-3_ weight_500 tt_uc_" id="practice_phone">333-333-3333</div>
			</div>


			<div class="trow_ fs-zero mt-7_ mb-7_"
				style="height: 0px; border: dashed 1px #3e7bc4;"></div>
                    
                        <div class="trow_ mb-4_">
                            <div class="elm-left tt_uc_" id="pat_name_invo"></div>
			</div>
                    
			<div class="trow_ mb-4_">
				<div class="">
					<div class="">
                            <span class="weight_600 mr-4_ ">Rx# </span><span class="tt_uc_" id="rx_value">786876</span>
                    </div>
					<div class="elm-left">
						<span id="drugname1"></span>
					</div>
					<div class="elm-right">
						<span class="tt_uc_" id="patient_name"></span>
					</div>
				</div>
				<div class="elm-right wd-70px weight_600 cnt-right pr-3_" id="rx_sale_1">$ 28.10</div>
			</div>
			
			<div class="trow_ mb-4_ mb-7_">
				<div class="elm-left tt_uc_ weight_600 pt-4_">amount due</div>
				<div class="elm-right wd-70px weight_600 cnt-right pt-2_ pr-3_" style="border-top: solid 1px #242424;" id="rx_sale_2">$ 28.10</div>
			</div>

			<div class="trow_">
				<span class="tt_uc_ mr-4_">items:</span> <span class="tt_uc_" id="total_items">1</span>
			</div>
			
			<div class="trow_">
				<span class="tt_uc_ mr-4_">register:</span> <span class="tt_uc_ ">Pharmacy Department</span>
			</div>

			<div class="trow_ fs-zero mt-7_ mb-7_"
				style="height: 0px; border: dashed 1px #3e7bc4;"></div>

			<div class="trow_ mb-4_">
				<div class="elm-left cnt-left">
					<span class="tt_uc_">payment card:</span>
				</div>
				<div class="elm-right cnt-right">
                    <span class="tt_uc_">number ending in </span> <span class="weight_600" id="cardNumber_div">9424</span>
				</div>
			</div>
			
			<div class="trow_ cnt-center c-dib_">
                <span class="tt_uc_ mr-4_">auth:</span><span id="auth_number">54156</span>
			</div>
			<div class="trow_ mb-7_">
				<p class="ma-0_ tt_uc_"
					style="text-align: justify; font-size: 10px !important;">i agree to
					pay the above charges &amp; i certify that i have received the
					medication(s) referenced by this ticket #; and i authorize all
					related information necessary for payment purposes</p>
			</div>
			<div class="trow_ mb-7_ cnt-center c-dib_">
				
				<div class="trow_ cnt-center" style="background-color: #fff;">
                    <img id="PaymentSignature" style="object-fit: cover;object-position: 0 0px;width: auto;height: 64px;" src="">
                </div>
				
			</div>
			
		</div>
		
		<div class="trow_ mt-14_ cnt-center c-dib_">
                    <a class="tt_cc_ p6-12_ txt-blue mr-14_ txt-hover-black_24" title="Download as PDF" id="inovice_down_btn" href="javascript:void(0);"><span class="fs-24_ fa fa-download"></span></a>
                    <a class="tt_cc_ p6-12_ txt-blue mr-14_ txt-hover-black_24" title="Print Invoice" target="_blank" id="btn-print_receipt"><span class="fs-24_ fa fa-print"></span></a>
                    <a class="tt_cc_ p6-12_ txt-grn-lt mr-14_ txt-hover-black_24" title="Send Email" href="javascript:void(0);" data-toggle="modal" data-target="#pat_invoice_modal"><span class="fs-24_ fa fa-paper-plane"></span></a>
                    <a href="javascript:delete_invoice();" class="opct-87_1 cur-pointer txt-red"> 
                        <svg class="svg-ico" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>
                    </a>
		</div>
		

</div>




<div class="modal" id="pat_invoice_modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
          <h4 class="modal-title" style="color:#fff;">Send Receipt To Patient Email</h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">X</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">

            <div class="wd-100p flx-justify-start" style="background-color: #fff;">
                    <label class="mr-7_" style="min-width: 30px;line-height: 36px;margin-bottom: 0px;">To:</label>
                    <div class=" input-group c-dib_" style="padding: 2px; border-radius: 6px; background-color: #fff; border: solid 1px #afbcc2; ">
                        <input type="text" value="" class="wd-100p form-control fs-16_" style="line-height: 1.2em !important; height: 30px; border: 0px; padding-left: 6px;" required id="invoice_email_add" name="invoice_email_add">
                        
                    </div>
                </div>
              <label id="email_error_invoice_title" class="error" style="margin-left: 40px;margin-top: 5px;color: red;"></label>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal">Cancel</button>
            <img id="loading_small_inovice" src="{{ url('images/small_loading.gif') }}" style="width: 30px;display: none;margin-left: auto;">
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " style="margin-left: auto;" id="btn-send_receipt">Send RECEIPT</button>
          </div>
      </div>

    </form>
  </div>
</div>

<div class="modal" id="pat_invoice_detail">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
          <h4 class="modal-title" style="color:#fff;">Detail information</h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">X</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">

          	<div id="invoice_screen1"
								class="wd-100p pa-14_ txt-gray-6 mb-17_"
								style="border: solid 1px #d3dee5; display: none;">
								<div class="trow_ txt-blue weight_600 tt_uc_ mb-7_"
									id="patient_value"></div>
								<div class="trow_ c-dib_ mb-4_ txt-gray-6">
									<div class="wd-100p weight_600" style="max-width: 140px;"
										id="drug_value"></div>
									<div class="wd-100p weight_600" style="max-width: 100px;"
										id="drug_strength"></div>
									<div class="float-right cnt-right weight_600"
										id="refills_remained">#0</div>
								</div>
								<div class="trow_ c-dib_ mb-4_">
									<div class="wd-100p" style="max-width: 140px;"
										id="drug_marketer">Westward - Pharma</div>
									<div class="wd-100p" style="max-width: 140px;" id="drug_ndc">613392
										- 0422 - 03</div>
									<div class="float-right cnt-right"></div>
								</div>
                                                                

								<div class="trow_ pb-3_ mt-2_ mb-4_"
									style="border-bottom: solid 1px #b6b6b6;">
									<div class="elm-left">Ing Cost</div>
									<div class="elm-right cnt-right" id="rx_cost">$ 72.16</div>
								</div>

                                                                <div class="trow_ pb-3_ mb-4_"
									style="border-bottom: solid 1px #b6b6b6;">
									<div class="elm-left">Sales Price</div>
									<div class="elm-right cnt-right " id="rx_sale">$
										256.44</div>
								</div>
								
                                                                <div class="trow_ pb-3_ mb-4_"
									style="border-bottom: solid 1px #b6b6b6;">
									<div class="elm-left">Rx Profitability</div>
									<div class="elm-right cnt-right" id="RxProfitability">$ 28.10</div>
								</div>

								<div class="trow_ pb-3_ mb-4_"
									style="border-bottom: solid 1px #b6b6b6;">
									<div class="elm-left">Pt Out of Pocket</div>
									<div class="elm-right cnt-right weight_600" id="out_of_pocket">$ 28.10</div>
								</div>
                                                            
								<div class="trow_ mt-7_ mb-4_">
									<div class="elm-left txt-red weight_600" id="fills_count">(2)
										Fills</div>
									<div class="elm-right">
										<img src="{{asset('images/logo.png')}}"
											style="height: 19px; width: auto;" />
									</div>
								</div>

								<div id="list_dates"></div>

							</div>
            
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <!-- <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal">Cancel</button>
            <img id="loading_small_inovice" src="{{ url('images/small_loading.gif') }}" style="width: 30px;display: none;margin-left: auto;">
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " style="margin-left: auto;" id="btn-send_receipt">Send RECEIPT</button>
          </div> -->
      </div>

    </form>
  </div>
</div>

<!--------------- hcp comments modal --------------------------->
<div class="modal" id="hcpPharmacyMessages">
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

						<input type="hidden" name="OrderId" id="OrderId" value="" />
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

							<div data-v-6a49c60d="" class="col-sm-12 pl-0 pr-0">
								<div data-v-6a49c60d="" id="hcp_chat_history"
									class="trow_ pos-rel_ mb-7_ pa-4_ br-rds-2 feed"
									style="border: 1px solid rgb(119, 119, 119); height: 140px;">
								</div>
							</div>
                			
                			<!-- <input type="text" class="trow_ txt-red p4-8_ weight_600" name="Message" maxlength="100" style="" placeholder="type message here" id="hcpOrderMessage"> -->
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
                                        <a class="tt_cc_ p6-12_ txt-blue mr-14_ txt-hover-black_24" style="margin-left: auto;" title="Fax View" onclick="openFaxModal();"><span class="fs-24_ fa fa-fax"></span></a>    
					<!--<button type="button"
						class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ "
						style="margin-left: auto;" id="sendMessage" onclick="addHcpMessage()">send</button>
-->
				</div>
			</div> 
		</form>
	</div>
</div>
<!-------- HCP comments end-------------> 

<!---- Fax Modal ----------->
<div class="modal" id="modal-fax-prescription">
  <div class="modal-dialog wd-87p-max_w_700">
    <div class="modal-content compliance-form_">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Fax Prescription</h4>
        <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
      </div>
      
      <style>
        
        .opcty-87 { opacity: 0.87; }
			
			a .svg-ico { height: 24px; width: auto; }
        
      </style>
      
      <!-- Modal body -->
      <div class="modal-body pa-0_">
  			<div class="row">
  				<div class="col-sm-12">
  				
  					<div class="trow_  bg-white pa-7_">
  						
  						<div class="trow_ bg-f2f2f2 pa-14_">
  							
  							<div class="trow_ txt-black-24 c-dib_ c-mr-14_ c-fw-600 c-fw-500">
                				<div id="fax_sndr_dtls">Care value pharmacy</div>
                				<div id="fax_phone_no">(236) 589-5654</div>
                				<div id="fax_date">2020-07-28 07:17:11</div>
                				<div id="fax_time">13:25</div>
                			</div>
                			<div class="trow_" style="height:47px;"></div>
                			<div class="trow_ fax_prsc_txt lh-43_">
                				<div class="hd-txt flx-justify-start">
                					<span class="d-ib_ fs-40_ lh-43_ mr-14_ mr-4_ weight_600">FAX</span>
                					<span class="d-ib_ fs-24_ pt-7_ lh-43_ mr-4_ weight_600">PRESCRIPTION</span>
                					<span class="d-ib_ fs-24_ pt-7_ lh-43_ mr-4_ weight_600" style="flex-grow: 7;"><span class="wd-100p d-ib_" style="border-bottom: dashed 4px;padding-top: 0.7em;"></span></span>
                				</div>
                			</div>
                			<div class="trow_" style="height: 24px;"></div>
                			<div class="trow_">
                				
                				<table class="txt-gray-blue bg-transparent wd-100p">
                					
                					<tbody>
                						<tr>
                							<td class="weight_700 cnt-center  fs-19_ pb-10_" id="fax_patient_id"></td>
                							<td></td>
                						</tr>
                					<tr>
                						<td class="pb-10 txt-center fs-19_" id="fax_dosage_form">PENICILLIN V K V tab</td>
                						<td class=" cnt-center txt-sline">
                							<span class="lh-19_ opcty-87">generic for: </span>
                                            <span class="fs-19_ txt-red" id="fax_generic_for">INDERAL</span>
                                        </td>
                					</tr>
                
                					<tr><td class="pb-10_ cnt-center fs-19_" id="fax_quantity">QTY: 0 1 REFILLS</td><td></td></tr>
                					<tr><td class="pb-10_ cnt-center fs-19_" id="fax_comments">Twice a day</td><td></td></tr>
                
                					<tr>
                						<td class="cnt-center fs-19_" id="fax_hcp_prescriber">Qamar Jamil
                						</td>
                						<td class="" style="vertical-align: middle;">
                							<div class="trow_ c-dib_ pa-7_ bg-white cnt-center c-mr-14_">
                								<a class="opct-87_1 cur-pointer" target="_blank" id="fax_btn">
                									<svg class="svg-ico" viewBox="0 0 512 512"><path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z" class=""></path></svg>
                								</a>
                								<a class="opct-87_1 cur-pointer">
                									<svg class="svg-ico" viewBox="0 0 512 512"><path fill="currentColor" d="M464 4.3L16 262.7C-7 276-4.7 309.9 19.8 320L160 378v102c0 30.2 37.8 43.3 56.7 20.3l60.7-73.8 126.4 52.2c19.1 7.9 40.7-4.2 43.8-24.7l64-417.1C515.7 10.2 487-9 464 4.3zM192 480v-88.8l54.5 22.5L192 480zm224-30.9l-206.2-85.2 199.5-235.8c4.8-5.6-2.9-13.2-8.5-8.4L145.5 337.3 32 290.5 480 32l-64 417.1z" class=""></path></svg>
                								</a>
                								<a class="opct-87_1 cur-pointer txt-red" data-dismiss="modal">
                									<svg class="svg-ico" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>
                								</a> 
                                                                                
                							</div>
                						</td>
                					</tr>
                					
                				</tbody></table>
                				
                			</div>
  							
  						</div>
  						
  					</div>
  					
  					
  				</div>
  			</div>
      </div>

      <!-- Modal footer >
      <div class="modal-footer bg-f2f2f2">
      		<div class="flx-justify-start wd-100p">
      			<button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
        		<button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;"><span class="fa fa-fax fs-22_"></span></button>
        	</div>
      </div-->

    </div>
  </div>
</div>

<!--- Fax modal end ----->