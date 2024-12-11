<div class="modal" id="test_survey_modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <!-- <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">Send Test Survey</span></h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					<div class="col-sm-12 modal-header">
                                            <h4 class="modal-title">Send Test Survey</h4>
                                        </div>
                                        <div id="practice-reg-step" class="tab-content current">
                                                    <div class="col-sm-12 pl-0 pr-0">
                                                            <div class="flds-prc-type-name flx-justify-start mb-14_ mt-36_ ml-7_">
                                                                <div class="field">
                                                                        <label class=" mb-4_ txt-gray-6 cnt-left">Search Patient Phone #:</label>
                                                                        <select class="wd-100p tt_uc_ txt-blue weight_600" name='phone_number' id='phone_number'>
                                                                            <option value="">Select Phone Number</option>
                                                                        </select>
                                                                </div>                                                                
                                                            </div>
                                                            <span id='error_phone_number' style='display:none; color:red; margin-left: 10px;'>Please Search /Select a Phone number.</span>
                                                    </div>
                                                <div class="container mt-36_" style="padding-left: 5px;">        
                                                    <button type="button" id="send_test_survey" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">send Test survey</button>
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

<div class="modal" id="survey_success">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">Survey Success Modal</span></h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button-->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					<div class="trow_ c-dib_ cnt-center mb-24_"><img src="{{url('/images/tick-circle.png')}}" style="max-width:73px;"/></div>
  					<div class="trow_ cnt-center c-dib_ mb-7_"><span class="txt-blue weight_600 fs-24_">Survey has been sent</span></div>
  					<div class="trow_ cnt-center c-dib_ mb-4_"><span class="txt-grn-lt weight_600 tt_lc_ fs-24_">successfully</span></div>
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; display: none;">
      </div>

    </form>
  </div>
</div>

<div class="modal" id="survey_failure">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">Survey Failure Modal</span></h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button-->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					<div class="trow_ c-dib_ cnt-center mb-24_"><img src="{{url('/images/cross-circle.png')}}" style="max-width:73px;"/></div>
  					<div class="trow_ cnt-center c-dib_ mb-7_"><span class="txt-blue weight_600 fs-24_">There is some error occurred,</span></div>
  					<div class="trow_ cnt-center c-dib_ mb-4_"><span class="txt-red weight_600 tt_lc_ fs-24_">while sending survey</span></div>
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; display: none;">
      </div>

    </form>
  </div>
</div>

