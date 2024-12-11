      <!-- Start Patient Message model -->

      <div class="modal fade new_edit_modal_parent " id="myPatientModal" role="dialog">

        <div class="modal-dialog modal-sm">

            <div class="modal-content edit_new_modal">

                <div class="modal-header">

                    <h4 class="modal-title">Send Message</h4>

                    <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>

                </div>

                <div class="modal-body new_pad_edit">
                    
                        <label id="practice_patient_name" class="weight_600 mb-7_ tt_cc_ txt-blue"></label><br>
                    
                    <label>Message:</label>

                     <p id="modalQues" class="weight_600 mb-7_ tt_cc_"></p>

                    <div class="row">

                        <div class="col-sm-12 col-md-12 col-lg-12 mb-10_" id="quesImg" style="height: 80px;overflow: hidden;display: none;">

                            

                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12">

                            <div class="form-group">

                                {{--<label>Answer</label>--}}

                                <textarea placeholder="PLease enter text to send to patient" style="overflow:auto;padding-top: 0px;padding-bottom: 0px;margin: 0px 3.05556px 7.98611px 0px;width: 763px;height: 65px;min-height: 65px; max-width: 100%;padding-top: 4px;" name="message_to_patient"  class="custom_add_inputs form-control" id="message_to_patient" maxlength="255"></textarea>

                            </div>

                        </div>

                        <div class="col-sm-12" id="messageEr"></div>

                    </div>

                </div>

                <div class="modal-footer">

                	<div class="flx-justify-start wd-100p">

                    	<button type="button" class="btn bg-red-txt-wht weight_500 tt_uc_" data-dismiss="modal">cancel</button>

                    	<button type="button" class="btn bg-blue-txt-wht weight_500 tt_uc_" id="address_save" onclick="sendMessageToPatient()" style="margin-left: auto;">SEND</button>

                    </div>

                </div>

            </div>

        </div>

    </div>
