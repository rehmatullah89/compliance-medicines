<style type="text/css">
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
   width:500px;
  height:320px;
}
.gallery{
  cursor: pointer;
}
/* end pop up image style*/
</style>



<div class="backdrop"></div>
<div class="box">
    <div class="close">X</div>
    <img class="big_img" src="">
</div>


<div class="modal" id="patientMessage">

	<div class="modal-dialog"
		style="width: 80% !important; max-width: 600px !important;">



		<form class="modal-content" novalidate="novalidate"
			action="javascript:void(0);" id="patient_form2" name="patient_form"
			method="post">



			<!-- Modal Header -->

			<div class="modal-header">

				<h4 class="modal-title">Patient Message</h4>

				<!-- button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button-->

				<button type="button" class="close stick-top-right-circle bw-hover"
					data-dismiss="modal">✖</button>

			</div>



			<!-- Modal body -->

			<div class="modal-body  pa-0_ ">
				
			  <div class="trow_ pl-14_ pr-14_ pt-14_ pb-14_ bg-yellow2" id="pat_mes_info">
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Order Details:</span>
                	<span class="fs-14_ txt-blue weight_600">Rx No.</span>
                    <span class="fs-14_ txt-blue weight_500">T00113-00</span>
                    <span class="fs-14_ mr-4_ ml-4_">|</span>
                	<span class="fs-14_ txt-blue weight_600">Drug Name:</span>
                    <span class="fs-14_ txt-blue weight_500">First/Lansoprazole</span>
                    <span class="fs-14_ mr-4_ ml-4_">|</span>
                	<span class="fs-14_ txt-blue weight_600">Strength:</span>
                	<span class="fs-14_ txt-blue weight_500">3mg/ml SUSP</span>
			  	</div>
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Patient Details:</span>
                	<span class="fs-14_ txt-blue weight_600" id="patientNameShow">Mike Wallace</span>
                    {{-- <span class="fs-14_ txt-blue weight_500">(M)</span>
                    <span class="fs-14_ mr-4_ ml-4_">-</span>
                	<span class="fs-14_ txt-blue weight_600">DOB:</span>
                    <span class="fs-14_ txt-blue weight_500">1/15/1970</span>
                    <span class="fs-14_ mr-4_ ml-4_">-</span>
                	<span class="fs-14_ txt-blue weight_600">Ph:</span>
                	<span class="fs-14_ txt-blue weight_500">(248) 801-9011</span> --}}
			  	</div>
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Pharmacy Name:</span>
                    <span class="fs-14_ txt-blue weight_500">SCRIPT N SAVE PHARMACY</span>
			  	</div>
			  		
			  </div>
			  
			  <div class="trow_  cnt-center mt-7_ fs-z_ c-dib_">
                  <span class="txt-blue tt_uc_ fs-14_ cnt-center weight_600">message history</span>
			  </div>
			  
			  <div class="trow_ pl-14_ pr-14_ mt-7_ mb-14_">

				<div class="row">

					<div class="col-sm-12">

						<input type="hidden" name="OrderId" id="CAM_OrderId" value="" /> <input
							type="hidden" name="PatientId" id="CAM_PatientId" value="" /> <input
							type="hidden" name="PracticeId" id="CAM_PracticeId" value="" /> <input
							name="modal_type" value="patient_message" type="hidden" />

						<div class="trow_ pa-7_ pos-rel_"
							style="border: solid 4px #afd13f;">

							<!-- <span class="fa fa-paperclip txt-blue pos-abs_" style="position: absolute; top: 14px; right: 7px;"></span> -->

							<div class="trow_ mb-7_" style="display: none">
								<span class="weight_600" style="margin-right: 3px;">RE:</span><span
									class="txt-blue tt_uc_" id="rxPop"></span>&nbsp;<span
									class="txt-black-14" id="medNamePop"></span>
							</div>

							<div class="txt-blue weight_900 trow_ mb-7_" style="display: none" >
								<span class="weight_600" id="patientNameShow1"></span> &nbsp; <span
									class="weight_600" id="pracPop"></span>
							</div>

							<div data-v-6a49c60d="" class="col-sm-12 pl-0 pr-0">
								<div data-v-6a49c60d="" id="chat_history"
									class="trow_ pos-rel_ mb-7_ pa-4_ br-rds-2 feed"
									style="border: 1px solid rgb(119, 119, 119); min-height: 40px;">
								</div>
							</div>

							<div>
								
								<div id="pre-show" style="float: left;margin-top: 5px;margin-bottom: 5px;">
									<img src="" style="display: none;width: 170px;height: 80px;overflow: hidden;" />
                                <span class="file-upload" style="display: none;width: 500px;font-size: 15px;">
                                  
                                </span>
                            	</div>
								<p style="float: right;">
									<a class="txt-blue_sh-force td_u_force"
										href="javascript:void(0)" onclick="$('#message_img').click();">Add file</a>
								</p>
								<input id="message_img" type="file" name="attachment"
									style="display: none;" accept="application/pdf,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
							</div>
							{{--<textarea class="trow_ txt-red weight_600" name="Message"
								maxlength="100" style="height: 64px"
								placeholder="type message here" id="orderMessage">
                			</textarea>--}}
                			
                			<input type="text" class="trow_ txt-red p4-8_ weight_600" name="Message" 
                			 maxlength="255" style="" placeholder="type message here" id="orderMessage">

							<label id="error_msg_show" class="error" style="display: none;">This
								field is required.</label>
						</div>

					</div>

				</div>
			  </div>

			</div>



			<!-- Modal footer -->

			<div class="modal-footer">

				<div class="flx-justify-start wd-100p">

					<button type="button"
						class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_"
						data-dismiss="modal">cancel</button>

					<button type="button"
						class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ "
						style="margin-left: auto;" id="sendMessage" onclick="addMessage()">send</button>

				</div>

			</div>



		</form>

	</div>

</div>









<!-- Start Question model -->

<div class="modal fade new_edit_modal_parent " id="myModal"
	role="dialog">

	<div class="modal-dialog modal-sm">

		<div class="modal-content edit_new_modal">

			<div class="modal-header">

				<h4 class="modal-title">Reply To Question</h4>

				<button type="button" class="close stick-top-right-circle bw-hover"
					data-dismiss="modal">✖</button>

			</div>

			<div class="modal-body new_pad_edit">

				<label id="practice_patient_name"
					class="weight_600 mb-7_ tt_cc_ txt-blue"></label><br> <label>Question:</label>

				<p id="modalQues" class="weight_600 mb-7_ tt_cc_"></p>

				<div class="row">

					<div class="col-sm-12 col-md-12 col-lg-12 mb-10_" id="quesImg"
						style="height: 80px; overflow: hidden; display: none;"></div>

					<div class="col-sm-12 col-md-12 col-lg-12">

						<div class="form-group">

							{{--<label>Answer</label>--}}

							<textarea placeholder="Answer Here"
								style="overflow: auto; padding-top: 0px; padding-bottom: 0px; margin: 0px 3.05556px 7.98611px 0px; width: 763px; height: 65px; min-height: 65px; max-width: 100%; padding-top: 4px;"
								name="answer_to_question" class="custom_add_inputs form-control"
								id="answer_to_question" maxlength="255"></textarea>

						</div>

					</div>

					<div class="col-sm-12" id="ansEr"></div>

				</div>

			</div>

			<div class="modal-footer">

				<div class="flx-justify-start wd-100p">

					<button type="button" class="btn bg-red-txt-wht weight_500 tt_uc_"
						data-dismiss="modal">cancel</button>

					<button type="button" class="btn bg-blue-txt-wht weight_500 tt_uc_"
						id="address_save" onclick="saveAnswer2()"
						style="margin-left: auto;">SEND</button>

				</div>

			</div>

		</div>

	</div>

</div>



<!--  end question model ----------->