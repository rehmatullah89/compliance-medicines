<div class="modal" id="practice-Add-Modal"  tabindex="-1">
    <div class="modal-dialog wd-87p-max_w_700">
      <form class="modal-content compliance-form_" action="javascript:void(0);"
       id="practice-reg-form" onsubmit="add_update_practice();"
        name="practice_form" method="post" >

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title txt-wht">Add Practice</h4>
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

                       			<div class="flds-prc-type-name flx-justify-start mb-14_">
              						<div class="wd-49p field field-modal fld-prc_type mr-1p">
              							<label class="wd-100p trow_">Practice Type:</label>
              							<select class="wd-100p"  name="practice_type" id="practice_type" required>
                                            <option value="Pharmacy">Pharmacy</option>
                                            <option value="Chiropractor">Chiropractor</option>
                                             <option value="Physician">Physician</option>
                                            <option value="Physical Therapy">Physical Therapy</option>
                                             <option value="Nutritionist">Nutritionist</option>
                                            <option value="Nursing / Home">Nursing / Home</option>
                                            <option value="Health">Health</option>
                                        </select>
              						</div>
              						<div class="wd-50p field field-modal fld-prc_name">
              							<label class="wd-100p">Practice Name:</label>
              							<input class="wd-100p" type="text" pattern="^[a-zA-Z\d\-_\s]+$" name="practice_name" id="practice_name" required maxlength="35" placeholder="">
              						</div>
              					</div>

                       			<div class="flds-prc_web-lic_iss_no flx-justify-start mb-14_">
              						<div class="wd-46p field field-modal fld-prc_web mr-1p">
              							<label class="wd-100p">Practice Website:</label>
              							<input class="wd-100p" id="practice_website" type="text" name="practice_website" required maxlength="30" />
              						</div>
              						<div class="wd-27p field field-modal fld-licn_issue mr-1p">
              							<label class="wd-100p">License Issuer:</label>
              							<input class="wd-100p" required pattern="^[a-zA-Z\d\-_\s]+$" name="practice_license_issuer" id="practice_license_issuer" type="text" maxlength="20" />
              						</div>
              						<div class="wd-27p field field-modal fld-licn_number">
              							<label class="wd-100p">License Number:</label>
              							<input class="wd-100p" pattern="^[a-zA-Z\d\-_\s]+$" type="text" required id="practice_license_number" name="practice_license_number" maxlength="20" />
              						</div>
              					</div>

              					<div class="flds-prc_addr-city flx-justify-start mb-14_">
              						<div class="wd-66p field field-modal fld-prc_addr mr-1p">
              							<label class="wd-100p">Practice Address:</label>
              							<input class="wd-100p" id="practice_address" pattern="^[a-zA-Z0-9,. ]*$" required name="practice_address" type="text" placeholder="" maxlength="35" />
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

                    		</div>
                		</section>

                  		<h4>Bank Detail</h4>
                        <section class="row">
                       		<div class="col-sm-12 pl-0 pr-0">
                        		<div class="flds-bnk_ins-loc flx-justify-start mb-14_">
              						<div class="wd-49p field field-modal fld-bnk_ins mr-1p">
              							<label class="wd-100p">Banking Institution:</label>
              							<input class="wd-100p" type="text" maxlength="25" name="bank[practice_banking_institution]" required id="practice_banking_institution" value="" placeholder="">
              						</div>
              						<div class="wd-50p field field-modal fld-bnk_loc">
              							<label class="wd-100p">Banking Location:</label>
              							<input class="wd-100p" maxlength="30" type="text" required name="bank[practice_banking_location]" id="practice_banking_location" placeholder="" />
              						</div>
              					</div>

              					<div class="flds-bnk_st-rt_no-ac_no flx-justify-start mb-14_">
              						<div class="wd-20p field field-modal fld-bnk_state mr-1p">
              							<label class="wd-100p">Bank State</label>
                                        <select class="wd-100p" name="bank[bank_state]" id="bank_state" required>
                                            <option value="">Please Select State</option>
                                            @foreach($state as $k_state=>$v_state)
                                            <option value="{{ $v_state->Abbr }}">{{ $v_state->Abbr }}</option>
                                            @endforeach
                                        </select>
              						</div>
              						<div class="wd-37p field field-modal fld-bnk_rt_no mr-1p">
              							<label class="wd-100p">Bank Routing Number</label>
                                        <input class="wd-100p" type="number" name="bank[bank_routing_number]" required id="bank_routing_number" minlength="1" maxlength="15" onKeyPress="return numericOnly(event)" placeholder="" />
              						</div>
              						<div class="wd-39p field field-modal fld-bnk_ac_no">
              							<label class="wd-100p">Bank Account Number</label>
                                        <input class="wd-100p" type="number" name="bank[bank_account_number]" minlength="1" maxlength="15" required id="bank_account_number" numericOnly onKeyPress="return numericOnly(event)" placeholder="" />
              						</div>
              					</div>
                            </div>
                        </section>

                        <h4>Users</h4>
                        <section class="row">
                    		<div class="col-sm-12">
                    			<div class="row" id="primary_site">
                    				<div class="col-sm-12 primary_site_div pl-0 pr-0">
                    					<div class="flds-bnk_st-rt_no-ac_no flx-justify-start mb-14_ data-user">
                      						<div class="wd-27p field field-modal fld-bnk_state mr-1p">
                      							<label class="wd-100p">Authorized User</label>
                                                <input class="wd-100p" pattern="^[a-zA-Z\d\-_\s]+$" type="text" fname="name" name="users[0][name]" value="" required maxlength="20">
                      						</div>
                      						<div class="wd-44p field field-modal fld-bnk_rt_no mr-1p">
                      							<label class="wd-100p">User Email</label>
                                                <input class="wd-100p" type="email" fname="email" onblur="validity_check(this);"  name="users[0][email]" value="" required maxlength="30" />
                      						</div>
                      						<div class="wd-27p field field-modal fld-bnk_ac_no">
                      							<label class="wd-100p">Site Role</label>
                                                <select class="wd-100p" fname="role" name="users[0][role]"  required>
        
                                                    <option value="2">Practice Admin</option>
                                                    <option value="3">Practice User</option>
                                                    <option value="6">Physician</option>
                                                    <option value="8">Reporter</option>
                                                </select>
                      						</div>
                      						
              							</div>
                    				</div>
                    				<div id="add-before-row" style="display: none;"></div>
                    			</div>

                            	<div class="row flx-justify-start mb-14_">
                            		<div class="col-sm-12 pl-0 pr-0">
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
                  <button type="button" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button>
                  <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div-->

      </form>
    </div>
  </div>

