<style>

table.td-pad-tb-10 td { padding-top: 10px; padding-bottom: 10px; }
table.td-pad-tb-10 td,
table.td-pad-tb-10 th {padding-right: 0.3vw; padding-left: 0.3vw;}


.wizard > .steps > ul { display: flex; justify-content: flex-start; }

.wizard > .content > .body input[type="radio"] {display: inline-block;width: 17px;height: 17px;margin-top: 0px;}
.wizard > .content > .body input[type="radio"]:checked { background-color: #3e7bc4; }
.wizard > .content > .body input[type="radio"] + span.text {display: inline-block;line-height: 17px;margin-left: 2px;}
.error{
    color: red !important;
}


/* pop up image style*/
.backdrop {
  position: absolute;
  text-align: center;
  top: 0px;
  left: 0px;
  width: 100%;
  height: 100%;
/*  background: #000;*/
  opacity: .0;
  filter:alpha(opacity=0);
  z-index: 2000;
  display: none;
}

.box {
  top: 20%;
  position: fixed; /* Lightboxes usually use position: fixed. */
  left: 50%;
  transform: translateX(-50%);
  width: auto;
  height: auto;
  background: #ffffff;
  z-index: 3000;
  padding: 2px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  -moz-box-shadow: 0px 0px 5px #444444;
  -webkit-box-shadow: 0px 0px 5px #444444;
  box-shadow: 0px 0px 5px #444444;
  display: none;
  margin-top: 40px;
}

.close {
  position: fixed;
  float: right;
  padding-left: 10px;
  padding-top: 4px;
  margin-top: 4px;
  cursor: pointer;
  font-family: sans-serif;
}

.big_img {
  margin: 5px;
    width: 300px;
    height: auto;
}
.practice_logo_image{
  cursor: pointer;
}
/* end pop up image style*/

.practice-logo-close-btn { border: solid 2px #3e7bc4; padding: 2px; line-height: 13px; font-size: 14px; position: absolute; right: -11px; background-color: #3e7bc4; color: #fff; top: -11px; text-shadow: none; width: 20px; height: 20px; text-align: center; margin-top: 0px; border-radius: 50%; opacity: 1.0; }

.practice-logo-close-btn:hover { background-color: #fff; color: #3e7bc4; }

.file-upload-image span.remove-btn { position: absolute; top: 1px; right: 1px; border: solid 1px #ec1717; font-size: 11px; line-height: 16px; border-radius: 50%; background-color: #ec1717; color: #fff; width: 16px; height: 16px; cursor: pointer; text-align: center; padding-left: 1px;}
.file-upload-image span.remove-btn:hover { background-color: #fff; color: #ec1717; }

#practice-reg-step .wizard > .content { min-heigh: 32em; }

</style>



<div class="backdrop"></div>
<div class="box pos-rel_">
    <div class="close practice-logo-close-btn">&#10006;</div> <!-- &#10006; -->
    <img class="big_img" src="">
</div>


<div class="modal" id="practice-Add-Modal"  tabindex="-1">
    <div class="modal-dialog wd-87p-max_w_700" style="max-width: 900px">
      <form class="modal-content compliance-form_" action="javascript:void(0);"
       id="practice-reg-form" onsubmit="add_update_practice();"
        name="practice_form" method="post" >

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title txt-wht">Add @hasrole('super_admin') Branch @elseif(Session::has('practice')) Branch @else Practice @endhasrole</h4>
            <img id="loading_small_img_one" src="{{asset('images/small_loading.gif')}}" style="width: 40px;margin-top: 15px;margin-left: 30px; display: none;">
            <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body bg-f2f2f2">
            <div class="row">
                <div class="col-sm-12">

                    <div id="practice-reg-step" class="tab-content current">
                       <h4>Practice Detail</h4>
                       <section class="row">
                       		<div class="col-sm-12 pl-0 pr-0">
                                @hasrole('super_admin')
                                   <div class="trow_ pa-5_ mb-14_ c-dib_ bg-yellow-lt cnt-left">
                                    <div class="txt-blue weight_600">
                                         <input type="text" name="branch_name" maxlength="25" required placeholder="Enter Branch Name">
                                         <input type="hidden" name="parent_id" value="{{ @auth::user()->practices->first()->id }}">
                                         <input type="hidden" name="practice_type" value="{{ auth::user()->practices->first()->practice_type }}">
                                         <input type="hidden" name="practice_name" value="{{ auth::user()->practices->first()->practice_name }}">

                                        </div>

                                    <div class="txt-blue weight_500 mr-4_ pa-8_">Practice Type:</div>
                                    <div class="txt-blue weight_600 pa-8_">{{ auth::user()->practices->first()->practice_type }}</div>
                                    <div class="txt-blue weight_500 pa-8_"> &nbsp; &nbsp; &nbsp;</div>
                                    <div class="txt-blue weight_500 pa-8_">Practice Name:</div>
                                    <div class="txt-blue weight_600 pa-8_">{{ auth::user()->practices->first()->practice_name }}</div>




                                </div>
                                @elseif((Session::has('practice') && !auth::user()->hasrole('compliance_admin')))
       <div class="trow_ pa-5_ mb-14_ c-dib_ bg-yellow-lt cnt-left">
                                    <div class="txt-blue weight_600">
                                         <input type="text" name="branch_name" maxlength="25" required placeholder="Enter Branch Name">
                                         <input type="hidden" name="parent_id" value="{{ Session::get('practice')->id }}">
                                         <input type="hidden" name="practice_type" value="{{ Session::get('practice')->practice_type }}">
                                         <input type="hidden" name="practice_name" value="{{ Session::get('practice')->practice_name }}">

                                        </div>

                                    <div class="txt-blue weight_500 mr-4_ pa-8_">Practice Type:</div>
                                    <div class="txt-blue weight_600 pa-8_">{{ Session('practice')->practice_type }}</div>
                                    <div class="txt-blue weight_500 pa-8_"> &nbsp; &nbsp; &nbsp;</div>
                                    <div class="txt-blue weight_500 pa-8_">Practice Name:</div>
                                    <div class="txt-blue weight_600 pa-8_">{{ Session('practice')->practice_name }}</div>




                                </div>
                                @endhasrole
                                <div class="flds-state-zip-phone flx-justify-start mb-14_">
                          <div class="wd-100p field field-modal fld-state mr-1p">
                            <label class="wd-100p">Group</label>
                                        <select class="wd-100p" id="practice_group" name="group_id">
                                            <option value="">Please Select Group</option>
                                        @foreach($groups as $k_group=>$v_group)
                                        <option value="{{ $v_group->id }}">{{ $v_group->group_name }}</option>
                                        @endforeach
                                        </select>
                          </div>

                        </div>
                            @if((auth::user()->hasanyRole('compliance_admin|practice_super_group') || auth::user()->can('all access')))
                       			<div class="flds-prc-type-name flx-justify-start mb-14_">
              						 <div class="wd-33p field field-modal fld-prc_type mr-1p">
              							<label class="wd-100p trow_">Practice Type:</label>
              							<select class="wd-100p" onchange="setUserRoles(this.value, 1);"  name="practice_type" id="practice_type" required>
											<option value="Pharmacy">Pharmacy</option>
											<option value="Law">Law Office</option>
											<option value="Physician">Physician</option>
                                            <!-- <option value="Chiropractor">Chiropractor</option> -->                                             
                                            <!-- <option value="Physical Therapy">Physical Therapy</option> -->
                                             <!-- <option value="Nutritionist">Nutritionist</option>
                                            <option value="Nursing / Home">Nursing / Home</option>
                                            <option value="Health">Health</option> -->
                                        </select>
									   </div>

              						 <div class="wd-32p field field-modal fld-prc_name mr-1p">
              							<label class="wd-100p">Practice Name:</label>
              							<input class="wd-100p" type="text" {{--pattern="^[a-zA-Z\d\-_\s]+$"--}} maxlength="25" name="practice_name" id="practice_name" required maxlength="25" placeholder="">
									  </div>

									  <div class="wd-33p field field-modal fld-prc_name">
										<label class="wd-100p">Practice Code:</label>
										<input class="wd-100p zero_slashes" type="text" {{--pattern="^[a-zA-Z0-9∅\d\-_\s]+$"--}} name="practice_code" id="practice_code" readonly required maxlength="3" placeholder="">
                                               <label id="codeError" class="error" style="display: none;">Practice Code:</label>
									  </div>

              					</div>
                                @endhasrole




                       			<div class="flds-prc_web-lic_iss_no flx-justify-start mb-14_">
              						<div class="wd-33p field field-modal fld-prc_web mr-1p">
              							<label class="wd-100p">Practice Website:</label>
              							<input class="wd-100p" id="practice_website" type="text" name="practice_website" required maxlength="30" />
              						</div>
              						<div class="wd-32p field field-modal fld-licn_issue mr-1p">
              							<label class="wd-100p">License Issuer:</label>
              							<input class="wd-100p" required pattern="^[a-zA-Z\d\-_\s]+$" name="practice_license_issuer" id="practice_license_issuer" type="text" maxlength="20" />
              						</div>
              						<div class="wd-33p field field-modal fld-licn_number">
              							<label class="wd-100p">License Number:</label>
              							<input class="wd-100p" pattern="^[a-zA-Z\d\-_\s]+$" type="text" required id="practice_license_number" name="practice_license_number" maxlength="20" />
              						</div>
              					</div>

              					<div class="flds-prc_addr-city flx-justify-start mb-14_">
              						<div class="wd-66p field field-modal fld-prc_addr mr-1p">
              							<label class="wd-100p">Practice Address:</label>
              							<input class="wd-100p" id="practice_address" {{--pattern="^[a-zA-Z0-9,. ]*$"--}} required name="practice_address" type="text" placeholder="" maxlength="35" />
              						</div>
              						<div class="wd-33p field field-modal fld-prc_addr">
              							<label class="wd-100p">Practice City:</label>
              							<input class="wd-100p" id="practice_city" required name="practice_city" maxlength="20" type="text"  placeholder="" />
              						</div>
              					</div>

              					<div class="flds-state-zip-phone flx-justify-start mb-14_">
              						<div class="wd-33p field field-modal fld-state mr-1p">
              							<label class="wd-100p">State</label>
                                        <select class="wd-100p" id="practice_state" name="practice_state" required>
                                            <option value="">Please Select State</option>
                                        @foreach($state as $k_state=>$v_state)
                                        <option value="{{ $v_state->Abbr }}">{{ $v_state->Abbr }}</option>
                                        @endforeach
                                        </select>
              						</div>
              						<div class="wd-32p field field-modal fld-zip mr-1p">
              							<label class="wd-100p">Zip Code</label>
                                        <input class="wd-100p" name="practice_zip" required minlength="5" maxlength="9" mask="00000-0000" id="practice_zip" type="text"  />
              						</div>
              						<div class="wd-33p field field-modal fld-phone">
              							<label class="wd-100p">Practice Phone No.</label>
                                        <input class="wd-100p" mask="(000) 000-0000" name="practice_phone_number" id="practice_phone_number" type="tel" required minlength="10" />
              						</div>
                        </div>
                        
                        <div class="wd-100p field field-modal fld-state mr-1p">
                          <div class="file-upload-content cnt-center" >

                            <span class="file-upload-image d-ib_ br-rds-4 pa-4_ pos-rel_ mb-14_" id="uploaded_image" alt="your image" style="border: solid 1px #cecece;" >
                              
                            </span>



                          <div class="image-title-wrap">

                            <img id="loading_small" src="{{ url('images/small_loading.gif') }}" style="width: 30px;display: none;">

                            {{-- <button type="button" onclick="removeUpload()" class="remove-image">Remove</button> --}}

                          </div>

                        </div>
                        <span id="practice_log_field" class="wd-32p field field-modal fld-zip mr-1p">
                          <label class="wd-100p">Practice Logo</label>
                          <input class="wd-100p" name="practice_logo" id="practice_logo" type="file" onchange="practice_logo_status()" accept="image/*" />
                        </span>
                        </div>

                    		</div>
                		</section>
                    <h4>Service Offerred</h4>
              <section>
                <div class="trow_ pt-14_">

                  <div class="trow_ question-row">

                    <div class="trow_ c-dib_ question mb-6_ pb-6_ service_offer_div" style="border-bottom: solid 1px #cecece;">

                      <label class="mb-0_ mr-14_ lh-17_">Service Long Term Care and/or Assisted Living Facilities</label>
                      <label class="cur-pointer mb-0_ mr-2p" for="service_long-term_yes">
                                                <input id="service_long-term_yes" name="service_offer[0][service_choice]" type="radio" value="Yes">
                                                <span class="text fs-14_">Yes</span>
                                            </label>
                                            <label class="cur-pointer mb-0_ ml-2p" for="service_long-term_no">
                                                <input id="service_long-term_no" name="service_offer[0][service_choice]" type="radio" value="No">
                                                <span class="text fs-14_">No</span>
                                            </label>

                    </div>

                    <div class="trow_ c-dib_ question mb-6_ pb-6_ service_offer_div" style="border-bottom: solid 1px #cecece;">

                      <label class="mb-0_ mr-14_ lh-17_">Provide Compounding Services</label>
                      <label class="cur-pointer mb-0_ mr-2p" for="compunding_services_yes">
                                                <input id="compunding_services_yes" name="service_offer[1][service_choice]" type="radio" value="Yes">
                                                <span class="text fs-14_">Yes</span>
                                            </label>
                                            <label class="cur-pointer mb-0_ ml-2p" for="compunding_services_no">
                                                <input id="compunding_services_no" name="service_offer[1][service_choice]" type="radio" value="No">
                                                <span class="text fs-14_">No</span>
                                            </label>
                    </div>

                    <div class="trow_ c-dib_ question mb-6_ pb-6_ service_offer_div" style="border-bottom: solid 1px #cecece;">

                      <label class="mb-0_ mr-14_ lh-17_">Drive-thru Available</label>
                      <label class="cur-pointer mb-0_ mr-2p" for="drive-thru-avail_yes">
                                                <input id="drive-thru-avail_yes" name="service_offer[2][service_choice]" type="radio" value="Yes">
                                                <span class="text fs-14_">Yes</span>
                                            </label>
                                            <label class="cur-pointer mb-0_ ml-2p" for="drive-thru-avail_no">
                                                <input id="drive-thru-avail_no" name="service_offer[2][service_choice]" type="radio" value="No">
                                                <span class="text fs-14_">No</span>
                                            </label>
                    </div>

                    <div class="trow_ c-dib_ question mb-6_ pb-6_ service_offer_div" style="border-bottom: solid 1px #cecece;">

                      <label class="mb-0_ mr-14_ lh-17_">Provide Home Infusion Services</label>
                      <label class="cur-pointer mb-0_ mr-2p" for="home-infusion-services_yes">
                                                <input id="home-infusion-services_yes" name="service_offer[3][service_choice]" type="radio" value="Yes">
                                                <span class="text fs-14_">Yes</span>
                                            </label>
                                            <label class="cur-pointer mb-0_ ml-2p" for="home-infusion-services_no">
                                                <input id="home-infusion-services_no" name="service_offer[3][service_choice]" type="radio" value="No">
                                                <span class="text fs-14_">No</span>
                                            </label>
                    </div>

                    <div class="trow_ c-dib_ question mb-6_ pb-6_ service_offer_div" style="border-bottom: solid 1px #cecece;">

                      <label class="mb-0_ mr-14_ lh-17_">24 Hour Pharmacy Services</label>
                      <label class="cur-pointer mb-0_ mr-2p" for="24hour_pharmacy_services_yes">
                                                <input id="24hour_pharmacy_services_yes" name="service_offer[4][service_choice]" type="radio" value="Yes">
                                                <span class="text fs-14_">Yes</span>
                                            </label>
                                            <label class="cur-pointer mb-0_ ml-2p" for="24hour_pharmacy_services_no">
                                                <input id="24hour_pharmacy_services_no" name="service_offer[4][service_choice]" type="radio" value="No">
                                                <span class="text fs-14_">No</span>
                                            </label>
                    </div>

                    <div class="trow_ c-dib_ question mb-6_ pb-6_ service_offer_div" style="border-bottom: solid 1px #cecece;">

                      <label class="mb-0_ mr-14_ lh-17_">Multi Lingual Services Available</label>
                      <label class="cur-pointer mb-0_ mr-2p" for="multi-lingual_services_yes">
                                                <input id="multi-lingual_services_yes" name="service_offer[5][service_choice]" type="radio" value="Yes">
                                                <span class="text fs-14_">Yes</span>
                                            </label>
                                            <label class="cur-pointer mb-0_ ml-2p" for="multi-lingual_services_no">
                                                <input id="multi-lingual_services_no" name="service_offer[5][service_choice]" type="radio" value="No">
                                                <span class="text fs-14_">No</span>
                                            </label>
                    </div>

                  </div>

                </div>
              </section>

                  		<h4>Bank Detail</h4>
                        <section class="row">
                       		<div class="col-sm-12 pl-0 pr-0">
                        		<div class="flds-bnk_ins-loc flx-justify-start mb-14_">
              						<div class="wd-49p field field-modal fld-bnk_ins mr-1p">
              							<label class="wd-100p">Banking Institution:</label>
              							<input class="wd-100p" type="text" maxlength="25" name="bank[practice_banking_institution]"  id="practice_banking_institution" value="" placeholder="">
              						</div>
              						<div class="wd-50p field field-modal fld-bnk_loc">
              							<label class="wd-100p">Banking Location:</label>
              							<input class="wd-100p" maxlength="30" type="text"  name="bank[practice_banking_location]" id="practice_banking_location" placeholder="" />
              						</div>
              					</div>

              					<div class="flds-bnk_st-rt_no-ac_no flx-justify-start mb-14_">
              						<div class="wd-33p field field-modal fld-bnk_state mr-1p">
              							<label class="wd-100p">Bank State</label>
                                        <select class="wd-100p" name="bank[bank_state]" id="bank_state" >
                                            <option value="">Please Select State</option>
                                            @foreach($state as $k_state=>$v_state)
                                            <option value="{{ $v_state->Abbr }}">{{ $v_state->Abbr }}</option>
                                            @endforeach
                                        </select>
              						</div>
              						<div class="wd-32p field field-modal fld-bnk_rt_no mr-1p">
              							<label class="wd-100p">Bank Routing Number</label>
                                        <input class="wd-100p" type="number" name="bank[bank_routing_number]"  id="bank_routing_number" minlength="1" maxlength="15" onKeyPress="return numericOnly(event)" placeholder="" />
              						</div>
              						<div class="wd-33p field field-modal fld-bnk_ac_no">
              							<label class="wd-100p">Bank Account Number</label>
                                        <input class="wd-100p" type="number" name="bank[bank_account_number]" minlength="1" maxlength="15"  id="bank_account_number" numericOnly onKeyPress="return numericOnly(event)" placeholder="" />
              						</div>
              					</div>
                            </div>
                        </section>


                         <h4>Service Fee</h4>
                        <section class="row">
                          <div class="col-sm-12 pl-0 pr-0">
                        <div class="col-sm-12 service_fee_div pl-0 pr-0" id="service_fee">

                          <div class="flds-bnk_st-rt_no-ac_no flx-justify-start mb-14_">
                          <div class="wd-13p field field-modal fld-bnk_state mr-1p">
                            <label class="wd-100p">Start Date</label>
                                        <input id="sf-start-date" class="wd-100p"  type="text" fname="start_date" name="service[0][start_date]" value=""  maxlength="20" placeholder="mm/dd/yyyy" />
                          </div>
                          <div class="wd-13p field field-modal fld-bnk_rt_no mr-1p">
                            <label class="wd-100p">End Date</label>
                                        <input id="sf-end-date" class="wd-100p" type="text" fname="end_date"  name="service[0][end_date]" value=""  maxlength="30" placeholder="mm/dd/yyyy" />
                          </div>
                          <div class="wd-20p field field-modal fld-bnk_state mr-1p">
                            <label class="wd-100p">Base Engagement Fee</label>
                                 <input  class="wd-100p basicAutoComplete" mask="$00.00" fname="base_fee" name="service[0][base_fee]"/>
                          </div>
                          <div class="wd-20p field field-modal fld-bnk_rt_no mr-1p copay-field" style="box-shadow: -3px 1px 13px 3px #ffeb3b;">
                            <label class="wd-100p">CoPAY Assisted Rx's</label>
                                        <input id="fee" class="wd-100p" type="text"   fname="fee"  name="service[0][fee]" value=""  maxlength="6"  />
                          </div>

                          <div class="wd-13p field field-modal fld-bnk_rt_no mr-1p" style="box-shadow: -3px 1px 13px 3px #ffeb3b;">
                            <label class="wd-100p">Profit Share</label>
                            <input class="wd-100p basicAutoComplete" mask="00%"  fname="profit_share"   name="service[0][profit_share]"/>
                          </div>

                          <div class="wd-20p field field-modal fld-bnk_rt_no mr-1p">
                            <label class="wd-100p">Facilitator</label>
                            <select class="wd-100p" fname="facilitator_id"   name="service[0][facilitator_id]">
                            <option value="">Select Facilitator</option>
                            @foreach($facilitator AS $fac)
                            <option value="{{$fac->id}}">{{ strtoupper($fac->first_name) }}</option>
                            @endforeach
                            </select>
                          </div>

                          <div class="wd-13p field field-modal fld-bnk_rt_no mr-1p">
                            <label class="wd-100p">Comission</label>
                            <input class="wd-100p basicAutoComplete" mask="0.00%"  fname="comission"   name="service[0][comission]"/>
                          </div>

      

                        </div>
                              <div class="flx-justify-start mb-14_">
                                    <div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_service_row()">Add <i  class="fa fa-plus-circle"></i></div>
                                </div>
                          </div>

                          </div>

                        </section>


<!---- Start order sheet from here --->
                        {{-- Drug Order listing 10-aug-2020 --}}

                                                    
                        <h4 id="order_sheet_title">Order Sheet Maintenance</h4>
                        <section id="order_sheet_section">
                          <div class="row">
                            <div class="col-sm-12">
                              
                              <div class="flx-justify-start wd-100p">
                                    <div class="txt-blue weight_600 fs-14_ txt-sline tt_uc_ p4-8_" style="padding-left: 0px;"><span class="txt-blue">Order Sheet</span></div>
                                    <div class="fs-14_" style="margin-left: auto;">
                                        <button type="button" class="btn bg-blue-txt-wht weight_500 txt-sline fs-14_" id="add_order_sheet_btn"  onclick="createEditOrderSheet($('#id').val(),0,'','');" >Add Order Sheet</button>
                                    </div>
                                  </div>
<style>
table.bordered.ord_sheet_main_table { border-collapse: separate; border: 0px; }
table.bordered.ord_sheet_main_table thead {  }
table.bordered.ord_sheet_main_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4; background-color: inherit;}
table.bordered.ord_sheet_main_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
table.bordered.ord_sheet_main_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }

table.bordered.ord_sheet_main_table tbody {  }
table.bordered.ord_sheet_main_table tbody tr {  }
table.bordered.ord_sheet_main_table tbody tr td { vertical-align: top; font-size: 14px; background-color: inherit;}
table.bordered.ord_sheet_main_table tbody tr td:first-child { border-left: solid 1px #ccc; }
table.bordered.ord_sheet_main_table tbody tr td:last-child { border-right: solid 1px #ccc; }
table.bordered.ord_sheet_main_table tbody tr:last-child {  }
table.bordered.ord_sheet_main_table tbody tr:last-child td { border-bottom: solid 1px #ccc;  background-color: inherit;}
table.bordered.ord_sheet_main_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
table.bordered.ord_sheet_main_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }

table.bordered.ord_sheet_main_table tbody tr:nth-child(odd) { background-color: #f2f2f2;}
table.bordered.ord_sheet_main_table tbody tr:nth-child(even) { background-color: #fff;}

table.bordered.ord_sheet_main_table tbody tr.highlight { background-color: #fff6e1 !important; }
</style>
                            
                                <div class="row mt-10_ mr-0 ml-0">
                                  <div class="col-sm-12 pl-0 pr-0 table-responsive">
                                    <table class="table bordered ord_sheet_main_table" id="ord_sheet_main_table" style="min-width: 600px;">
                                      <thead>
                                        <tr class="weight_500-force-childs bg-blue">
                                          <th class="txt-wht tt_uc_">Order Sheet</th>
                                          <th class="txt-wht tt_uc_">Details</th>
                                          <th class="txt-wht tt_uc_" style="width: 120px;">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody id="ordersheet_table">
                                            
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </section>
                       


                    {{-- Drug order listing end 10-aug-2020 --}}





                         
                         <h4>Users</h4>
                        <section class="row">
                          <div class="col-sm-12 pl-0 pr-0">
                    		<div class="col-sm-12 primary_site_div pl-0 pr-0" id="primary_site">

                    			<div class="flds-bnk_st-rt_no-ac_no flx-justify-start mb-14_">
              						<div class="wd-25p field field-modal fld-bnk_state mr-1p">
              							<label class="wd-100p">Authorized User</label>
                                        <input class="wd-100p" pattern="^[a-zA-Z\d\-_\s]+$" type="text" fname="name" name="users[0][name]" value="" required maxlength="20">
              						</div>
              						<div class="wd-48p field field-modal fld-bnk_rt_no mr-1p">
              							<label class="wd-100p">User Email</label>
                                        <input class="wd-100p" type="email" fname="email" onblur="validity_check(this);"  name="users[0][email]" value="" required maxlength="42" />
              						</div>
              						<div class="wd-25p field field-modal fld-bnk_ac_no">
              							<label class="wd-100p">Site Role</label>
                                        <select class="wd-100p selectRole" fname="role" name="users[0][role]"  required>
                                           @if((auth::user()->hasanyrole('compliance_admin|practice_super_group') || auth::user()->can('all access')) && !session::has('practice')) <option value="3">Practice Super Admin</option> @endhasrole
                                           <option value="15">Practice Group Owner</option>
                                           <option value="2">Practice Admin</option>
                                            <option value="6">Physician</option>
                                            <option value="8">Reporter</option>
											<option value="9">Law Practice Admin</option>
                                        </select>
              						</div>

              					</div>
                            	<div class="flx-justify-start mb-14_">
                                    <div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row()">Add <i  class="fa fa-plus-circle"></i></div>
                                </div>
                        	</div>

                          </div>

                        </section>



                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal footer >
        <div class="modal-footer">
                <div class="flx-justify-start wd-100p">
                  <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_" data-dismiss="modal">Cancel</button>
                  <button type="button" class="_">RESET</button>
                  <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div-->

      </form>
    </div>
  </div>


{{-- Add Order sheet modal --}}

  <div class="modal" id="add_order_sheet">
    <div class="modal-dialog wd-87p-max_w_1024">
      <form class="modal-content compliance-form_">

        <!-- Modal Header -->
        <div class="modal-header pos-rel_">
            <h4 class="modal-title txt-wht">Order Sheet Maintenance &gt;&gt; Add Order Sheet</h4>
            <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body bg-f2f2f2">
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="practiceId" id="practiceId" value="">
                    <input type="hidden" name="sheetId" id="sheetId" value="">
          <div class="flds-ord_name-name-details flx-justify-start f-wrap">
              <div class="wd-60p field field-modal fld-ord_sheet_name mb-14_ mr-1p">
                <label class="wd-100p txt-gray-6" style="color: #666;">Order Sheet Name:</label>
                <input class="wd-100p txt-gray-6" type="text" name="sheet_title" id="sheet_title" pattern="^[a-zA-Z\d\-_\s]+$" maxlength="40" placeholder="">
                <span id="error_sheet_title" style="display:none; padding: 2px; color: red;">This field is required.</span>
              </div>
              
              <div class="wd-100p field field-modal fld-ord_sheet_details mr-1p">
                <label class="wd-100p txt-gray-6" style="color: #666;">Order Sheet Details:</label>
                <textarea class="wd-100p txt-gray-6" type="text" name="sheet_details" id="sheet_details" maxlength = "150" pattern="^[a-zA-Z\d\-_\s]+$" placeholder="" style="min-height: 74px;overflow-y: auto;resize: none;"></textarea>
              </div>
              
            </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer bg-f2f2f2">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
            {{-- <button type="button" class="btn bg-blue-txt-wht ml-14_ weight_500 fs-14_ " id="reset_order_sheet">RESET</button> --}}
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" onclick="addUpdateOrderSheet();" style="margin-left: auto;" id="ordersheet_add_btn">ADD</button>
          </div>
        </div>

      </form>
    </div>
</div>


{{-- Add order sheet modal end --}}



{{-- Drug Categories listing modal --}}

<div class="modal" id="order_sheet_cat_listing">
  <div class="modal-dialog wd-87p-max_w_1024">
    <form class="modal-content compliance-form_">

        <input type="hidden" name="orderSheetId"  id="orderSheetId" value=""/>
      <!-- Modal Header -->
      <div class="modal-header pos-rel_">
          <h4 class="modal-title txt-wht">Order Sheet Maintenance &gt;&gt; Drug Categories</h4>
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
          <div class="fs-14_ elm-right" style="margin-left: auto;"><a class="bg-lt_blue-txt-wht txt-sline txt-wht br-rds-4 weight_500 d-ib_ p4-8_ tt_cc_ fs-14_" id="add_drug_category_btn"  onclick="createEditDrugCategory($('#orderSheetId').val(),0,'','');">Add Drug Category</a></div>
      </div>

      <!-- Modal body -->
      <div class="modal-body bg-f2f2f2">
          <div class="row">
              <div class="col-sm-12">
              
<style>
table.bordered.ord_sheet_main_table { border-collapse: separate; border: 0px; }
table.bordered.ord_sheet_main_table thead {  }
table.bordered.ord_sheet_main_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4; background-color: inherit;}
table.bordered.ord_sheet_main_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
table.bordered.ord_sheet_main_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }

table.bordered.ord_sheet_main_table tbody {  }
table.bordered.ord_sheet_main_table tbody tr {  }
table.bordered.ord_sheet_main_table tbody tr td { vertical-align: top; font-size: 14px;}
table.bordered.ord_sheet_main_table tbody tr td:first-child { border-left: solid 1px #ccc; }
table.bordered.ord_sheet_main_table tbody tr td:last-child { border-right: solid 1px #ccc; }
table.bordered.ord_sheet_main_table tbody tr:last-child {  }
table.bordered.ord_sheet_main_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
table.bordered.ord_sheet_main_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
table.bordered.ord_sheet_main_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }

table.bordered.ord_sheet_main_table tbody tr:nth-child(odd) { background-color: #f2f2f2;}
table.bordered.ord_sheet_main_table tbody tr:nth-child(even) { background-color: #fff;}

table.bordered.ord_sheet_main_table tbody tr.highlight { background-color: #fff6e1 !important; }
</style>

<div style="display: none;">
<svg display="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" xml:space="preserve">

  <symbol height="17" viewBox="0 0 576 512" id="drug_main">
    <path fill="currentColor" d="M112 32C50.1 32 0 82.1 0 144v224c0 61.9 50.1 112 112 112s112-50.1 112-112V144c0-61.9-50.1-112-112-112zm48 224H64V144c0-26.5 21.5-48 48-48s48 21.5 48 48v112zm139.7-29.7c-3.5-3.5-9.4-3.1-12.3.8-45.3 62.5-40.4 150.1 15.9 206.4 56.3 56.3 143.9 61.2 206.4 15.9 4-2.9 4.3-8.8.8-12.3L299.7 226.3zm229.8-19c-56.3-56.3-143.9-61.2-206.4-15.9-4 2.9-4.3 8.8-.8 12.3l210.8 210.8c3.5 3.5 9.4 3.1 12.3-.8 45.3-62.6 40.5-150.1-15.9-206.4z"></path>
  </symbol>

</svg>

<style>

svg {
  /*width: 32px;
  height: 32px;
  max-width: 24px;
    max-height: 24px;*/
    fill: currentColor;
    height: 1em;
    width: 1em;
    display: inline-block;
}
svg:hover {
  fill: currentColor;
}
</style>
</div>
                          
              <div class="row mr-0 ml-0">
                <div class="col-sm-12 pl-0 pr-0 table-responsive">
                  <table class="table bordered" id="order_sheet_category_table" style="min-width: 600px;">
                    <thead>
                      <tr class="weight_500-force-childs bg-blue">
                        <th class="txt-wht tt_cc_">Drug Category</th>
                        <th class="txt-wht tt_cc_">Details</th>
                        <th class="txt-wht tt_cc_" style="width: 100px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
                  
              </div>
          </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer bg-f2f2f2 pos-rel_" style="margin-top: -7px;">
        <div class="flx-justify-start ma-0_ wd-100p">
          <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
          <!-- button type="button" class="btn bg-blue-txt-wht ml-14_ weight_500 fs-14_ ">RESET</button -->
          <!-- button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button -->
        </div>
      </div>

    </form>
  </div>
</div>

{{-- Drug category listing modal end --}}



{{-- Add drug category  --}}

<div class="modal" id="order_sheet_add_drug_cat">
  <div class="modal-dialog wd-87p-max_w_1024">
    <form class="modal-content compliance-form_">

      <!-- Modal Header -->
      <div class="modal-header pos-rel_">
          <h4 class="modal-title txt-wht">Drug Categories &gt;&gt; Add Drug Category</h4>
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body bg-f2f2f2">
          <div class="row">
              <div class="col-sm-12">
        
            <input type="hidden" name="categoryId" id="categoryId" value="">
            <input type="hidden" name="categorySheetId" id="categorySheetId" value="">
        <div class="flds-ord_name-name-details flx-justify-start f-wrap">
            <div class="wd-60p field field-modal fld-ord_sheet_name mb-14_ mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">Drug Category:</label>
              <input class="wd-100p txt-gray-6" type="text" name="category_title" id="category_title" pattern="^[a-zA-Z\d\-_\s]+$" maxlength="40" placeholder="">
              <span id="error_category_title" style="display:none; padding: 2px; color: red;">This field is required.</span>
            </div>
            
            <div class="wd-100p field field-modal fld-ord_sheet_details mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">Category Details:</label>
              <textarea class="wd-100p txt-gray-6" name="category_details"  id="category_details"  pattern="^[a-zA-Z\d\-_\s]+$" maxlength="150" type="text" placeholder="" style="min-height: 74px;overflow-y: auto;resize: none;"></textarea>
            </div>
            
          </div>
                  
              </div>
          </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer bg-f2f2f2">
        <div class="flx-justify-start wd-100p">
          <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
          {{-- <button type="button" class="btn bg-blue-txt-wht ml-14_ weight_500 fs-14_ ">RESET</button> --}}
          <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" onclick="addUpdateDrugCategory();" style="margin-left: auto;" id="sheetcategory_add_btn">ADD</button>
        </div>
      </div>

    </form>
  </div>
</div>


{{-- Add category modal end --}}


{{-- drugs from order sheet listing --}}

<div class="modal" id="order_sheet_drug_listing">
  <div class="modal-dialog wd-87p-max_w_1024">
    <form class="modal-content compliance-form_" >

        <input type="hidden" name="orderSheetCategoryId"  id="orderSheetCategoryId" value=""/>
      <!-- Modal Header -->
      <div class="modal-header pos-rel_">
          <h4 class="modal-title txt-wht" id="category_title_id">Acne Topical &gt;&gt; Drugs</h4>

          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
          <div class="fs-14_ elm-right" style="margin-left: auto;"><a class="bg-lt_blue-txt-wht txt-sline txt-wht br-rds-4 weight_500 d-ib_ p4-8_ tt_cc_ fs-14_" id="add_drug_category_btn"  onclick="createEditSheetDrug($('#orderSheetCategoryId').val(),0,'');">Add Drug</a></div>      
      </div>

      <!-- Modal body -->
      <div class="modal-body bg-f2f2f2">
          <div class="row">
              <div class="col-sm-12">
        
        
        <style>
table.bordered.acne_topical_drugs_table { border-collapse: separate; border: 0px; }
table.bordered.acne_topical_drugs_table thead {  }
table.bordered.acne_topical_drugs_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4; background-color: inherit;}
table.bordered.acne_topical_drugs_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
table.bordered.acne_topical_drugs_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }

table.bordered.acne_topical_drugs_table tbody {  }
table.bordered.acne_topical_drugs_table tbody tr {  }
table.bordered.acne_topical_drugs_table tbody tr td { vertical-align: top; font-size: 14px; background-color: inherit;}
table.bordered.acne_topical_drugs_table tbody tr td:first-child { border-left: solid 1px #ccc; }
table.bordered.acne_topical_drugs_table tbody tr td:last-child { border-right: solid 1px #ccc; }
table.bordered.acne_topical_drugs_table tbody tr:last-child {  }
table.bordered.acne_topical_drugs_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
table.bordered.acne_topical_drugs_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
table.bordered.acne_topical_drugs_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }

table.bordered.acne_topical_drugs_table tbody tr:nth-child(odd) { background-color: #f2f2f2;}
table.bordered.acne_topical_drugs_table tbody tr:nth-child(even) { background-color: #fff;}

table.bordered.acne_topical_drugs_table tbody tr.highlight { background-color: #fff6e1 !important; }
</style>
                          
              <div class="row mr-0 ml-0">
                <div class="col-sm-12 pl-0 pr-0 table-responsive" style="padding-bottom: 0px !important;">
                  <table class="table bordered acne_topical_drugs_table" id="order_sheet_drug_table" style="min-width: 600px; margin-bottom: 0px !important;">
                    <thead>
                      <tr class="weight_500-force-childs bg-blue">
                        <th class="txt-wht tt_cc_">Medicine Name (Alias)</th>
                        <th class="txt-wht tt_cc_">Generic Name</th>
                        <th class="txt-wht tt_cc_">Dosage Type</th>
                        <th class="txt-wht tt_cc_">Strength</th>
                        <th class="txt-wht tt_cc_">Qty.</th>
                        <th class="txt-wht tt_cc_">NDC No.</th>
                        <th class="txt-wht tt_cc_">GCN No.</th>
                        <th class="txt-wht tt_cc_" style="width: 70px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
        
        
        
                  
              </div>
          </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer bg-f2f2f2">
        <div class="flx-justify-start wd-100p">
          <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
          <!-- button type="button" class="btn bg-blue-txt-wht ml-14_ weight_500 fs-14_ ">RESET</button -->
          <!-- button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button -->
        </div>
      </div>

    </form>
  </div>
</div>

{{-- drugs from order sheet listing end --}}



{{-- Add Drug in order sheet --}}

<div class="modal" id="add_sheet_drug_modal">
  <div class="modal-dialog wd-87p-max_w_700">
    <form class="modal-content compliance-form_" name="cat_drug_form">

      <!-- Modal Header -->
      <div class="modal-header pos-rel_">
          <h4 class="modal-title txt-wht">Drugs &gt;&gt; Add Drug</h4>
          <div class="input-group" style="display: flex;align-items: center;border-radius: 36px;background-color:#fff;padding-left: 17px;padding-right: 27px;position: relative;max-width: 350px;margin-top: 2px;">
            <input type="text" autocomplete="off" id="keyword_drug" class="wd-100p" value="" style="line-height: 1.2em !important;height: 26px;border: 0px;padding-left: 0px;padding-right: 2px;position: relative;" placeholder="Search using drug name, ndc, etc" data-provide="typeahead">
            <div class="input-group-append elm-right" style="height: 26px;background-color:transparent;color:#fff !important;margin: 0px;border-radius: 0px 13px 13px 0px;position: absolute;top: 0px;right: 1px;z-index: 100;">
                <button type="button" class="btn bg-blue-txt-wht btn-circle" style="border-radius: 50%;width: 26px;text-align: center;height: 26px;padding: 0px;transform: scale(0.8);position: relative;z-index: 10;">
                    <i class="fa fa-search" style="line-height: 24px;"></i>
                </button>
            </div>
        </div>
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body bg-f2f2f2">
          <div class="row">
              <div class="col-sm-12">
                      
                  <input type="hidden" name="sheetCategoryId" id="sheetCategoryId" value="">
                   <input type="hidden" name="sheetDrugId" id="sheetDrugId" value="">  
                   <input type="hidden" name="cat_drug_id" id="cat_drug_id" value="">         
        <div class="flds-mdcn-dsg_typ-strn flx-justify-start">
            <div class="field field-modal fld-mdcn_name mb-14_ mr-1p" style="width: 38%;">
              <label class="wd-100p txt-gray-6" style="color: #666;">Medicine Name (Alias):</label>
              <input class="wd-100p txt-gray-6" style="color: #666 !important;" type="text" placeholder=""  maxlength="50" id="rx_label_name" name="rx_label_name" required>              
            </div>
            
            <div class="wd-24p field field-modal fld-ndc_no mb-14_ mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">NDC No:</label>
              <input class="wd-100p txt-gray-6" style="color: #666 !important;" type="text" placeholder="" mask="00000-0000-00" name="ndc" id="ndc" required>
              <span id="duplicate_ndc" style="display:none; padding: 2px; color: red;">Duplicate NDC exist.</span>
            </div>
            
            <div class="wd-33p field field-modal fld-mdcn_name mb-14_ mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">Generic Name:</label>
              <input class="wd-100p txt-gray-6" style="color: #666 !important;" type="text" placeholder="" maxlength="30" id="generic_name" name="generic_name" required>              
            </div>
            
          </div>
          
          <div class="flds-qty-upc-ndc-gcn-alt_ndc flx-justify-start">
            
            <div class="wd-16p field field-modal fld-dsg_type mb-14_ mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">Dosage Type:</label>
              <input class="wd-100p txt-gray-6" type="text" placeholder="" pattern="^[a-zA-Z\d\-_./\(),%'\s]+$" maxlength="21"  id="dosage_form" name="dosage_form">
            </div>
            
            <div class="wd-16p field field-modal fld-strngth mb-14_">
              <label class="wd-100p txt-gray-6" style="color: #666;">Strength:</label>
              <input class="wd-100p txt-gray-6" style="color: #666 !important;" type="text" placeholder="" pattern="^[a-zA-Z\d\-_./\(),%'\s]+$" maxlength="15" name="strength" id="os_strength">
            </div>
              
            <div class="wd-10p field field-modal fld-qty mb-14_ mr-1p" style="min-width: 50px;">
              <label class="wd-100p txt-gray-6" style="color: #666;">Qty:</label>
              <input class="wd-100p txt-gray-6" type="text" placeholder="" maxlength="6" onkeypress="return numericOnly(event,8)" name="default_rx_qty" id="default_rx_qty">
            </div>
            
            <div class="wd-17p field field-modal fld-upc_no mb-14_ mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">UPC No:</label>
              <input class="wd-100p txt-gray-6" type="text" placeholder="" pattern="^[0-9\-_\s]+$" maxlength="20" name="upc" id="upc">
            </div>
            
            
            <div class="wd-17p field field-modal fld-gcn_no mb-14_ mr-1p">
              <label class="wd-100p txt-gray-6" style="color: #666;">GCN No:</label>
              <input class="wd-100p txt-gray-6" type="text" placeholder="" pattern="[0-9]" onkeypress="return numericOnly(event,6)" mask="000000"  name="gcn_seq" id="gcn_seq">
            </div>
            
            <div class="wd-18p field field-modal fld-alt_ndc_no mb-14_">
              <label class="wd-100p txt-gray-6" style="color: #666;">Alt. NDC No:</label>
              <input class="wd-100p txt-gray-6" type="text" placeholder="" mask="00000-0000-00" name="alternate_ndc" id="alternate_ndc">
            </div>
          </div>
          
          
          <div class="flds-ord_name-name-details flx-justify-start">
            <div class="wd-100p field field-modal fld-ord_sheet_details">
              <label class="wd-100p txt-gray-6" style="color: #666;">Instructions:</label>
              <textarea class="wd-100p txt-gray-6" type="text" placeholder=""  name="instructions" pattern="^[a-zA-Z\d\-_\s]+$" maxlength="150"  id="instructions" style="min-height: 74px;overflow-y: auto;resize: none;"></textarea>
            </div>
          </div>
                  
              </div>
          </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer bg-f2f2f2">
        <div class="flx-justify-start wd-100p">
          <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
          {{-- <button type="button" class="btn bg-blue-txt-wht ml-14_ weight_500 fs-14_ ">RESET</button> --}}
          <button type="submit" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;" id="sheetdrug_add_btn">ADD</button>
        </div>
      </div>

    </form>
  </div>
</div>


{{-- add drug in order sheet end --}}

{{-- Order sheet maintenace Category Drugs --}}

<div class="modal" id="order_sheet_view">
  <div class="modal-dialog wd-87p-max_w_1024">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title txt-wht" id="ordersheet_title_id">Dermatology</h4>
          <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button> <!-- &#10006; -->
        </div>
        
        <style>
        
            table.bordered.dermatology-table { border: 1px solid #CCCCCC; border-radius: 2px !important; border-top: solid 1px #CCCCCC; }      
            table.bordered.dermatology-table tbody tr td { border-left: 0px; border-bottom: 1px solid #CCCCCC; }
            table.bordered.dermatology-table tbody tr:last-child td { border-bottom: 0px solid #CCCCCC; }
            
            table.bordered.dermatology-table tbody tr:nth-child(odd) {background-color: #fff;}
            table.bordered.dermatology-table tbody tr:nth-child(even) {background-color: #fff;}
            
            table.bordered.dermatology-table tbody tr input[type="checkbox"].highlight { background-color: #ec1717; }
            table.bordered.dermatology-table tbody tr input[type="checkbox"].highlight:before { color: #fff; border: solid 1px #ec1717; }
            
            
        </style>
        
        
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              
                <div class="flx-justify-start wd-100p" style="max-height: 500px;">
                
                <div class="wd-49p mr-1p "  style="max-height: 70vh; padding-right:3px; overflow-y:auto; overflow-x:hidden;">                  
                    <table class="bordered dermatology-table">
                        <tbody id="drug_table_1">

                        </tbody>
                    </table>                  
                </div>
  
                <div class="wd-50p" style="padding-right:3px; overflow-y:auto; overflow-x:hidden;">
                  <table class="bordered dermatology-table">
                    <tbody id="drug_table_2">
                                    
                    </tbody>
                  </table>
                </div>
                
              </div>
              
            </div>
          </div>
        </div>
        
        
      </div>
  </div>
</div>

{{-- Order sheet maintenace Category Drug End --}}
