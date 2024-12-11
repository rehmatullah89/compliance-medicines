<style>
.reporter-enrollment-form {  }
.reporter-enrollment-form label { margin-bottom: 0px; }
.reporter-enrollment-form .field label { text-align: center; margin-bottom: 0px; display: flex; justify-content: center; align-items: center; vertical-align: middle; font-size: 12px; font-size: 11px; }
.reporter-enrollment-form input:not([type="radio"]) { border: 0px; border-radius: 0px; font-size: 14px; padding: 3px 4px;line-height: 1.3em; height: 24px;font-weight:bold;}
.reporter-enrollment-form select { border: 0px; border-radius: 0px; font-size: 14px; padding: 3px 4px; line-height: 1.3em; height: 24px;}
.reporter-enrollment-form .field  input:not([type="radio"]) { border: solid 1px #999; }
.reporter-enrollment-form .field  select { border: solid 1px #999; }
.reporter-enrollment-form .field  textarea { border: solid 1px #999; }
.reporter-enrollment-form .field-nb { border: 0px; }
.reporter-enrollment-form .radio-field { /*display: flex; justify-content: flex-end; flex-wrap: wrap;*/ }
.reporter-enrollment-form .radio-field .radio-field-option { margin-right: 24px; }
.reporter-enrollment-form .radio-field .radio-field-option label { display: flex; justify-content: flex-start; align-items: center; text-align: left; }
.reporter-enrollment-form .radio-field .radio-field-option label input[type="radio"] { width: 17px; height: 17px; margin-right: 7px; margin-top: 0px;}
.reporter-enrollment-form .radio-field .radio-field-option label span { line-height: 1.47em; font-weight: 600;}
.reporter-enrollment-form button.drg-cln-adv { padding: 4px 14px; border: solid 1px #999; border-radius: 3px; background-color: #fff; }
.reporter-enrollment-form button.patient-message { padding: 4px 14px; border: solid 1px #999; border-radius: 3px; background-color: #fff;}
.reporter-enrollment-form button.drg-cln-adv:hover { border: solid 1px #ec1717 !important; }
.reporter-enrollment-form button.patient-message:hover { border: solid 1px #9bc90d !important; }
.reporter-enrollment-form button.clear-form { padding: 4px 14px; border-radius: 24px; }
.reporter-enrollment-form button.submit-form { padding: 6px 14px; border-radius: 24px; }
label.error{ color:#8a1f11 !important; /*display: none !important; */ }
#precription_data label.error{ display: none !important; }
 .select2-selection__clear{ display: none !important; }
input.error, select.error, span.error { border:1px solid #8a1f11 !important; }

</style>

<div class="modal" id="precription_edit_Modal">
    <div class="modal-dialog wd-87p " style="max-width: 750px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header pos-rel_">
                <div class="trow c-dib_">
                    <h4 class="modal-title fs-16 mr-14_">Precription Update</h4>
                </div>
                <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">X</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="reporter-enrollment-form" id="precription_data" action="javascript:void(0);" autocomplete="off" novalidate="novalidate">
                            <input type="hidden" name="id" id="id" />
                            <div class="row mb-14_">
                                    <div class="col-sm-12">
                                    <h6 class="ma-0_ mb-4_ txt-blue fs-16_ elm-left weight_600">Rx ENROLLMENT</h6>
                                </div>
                            </div>
                            <div class="flx-justify-start flds_prt_phrms mb-14_">
                                <div class="field fld-part-pharms mr-1p" style="min-width: 240px;" id="pracetice_area">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57">PARTICIPANT PHARMACIES&nbsp;<span class="fs-10_" style="color: #aaa;">(WITH 15 MILES)</span></label>
                                    <select name="practice_id" required id="practice_id" class="wd-100p">
                                        <option value="">SELECT PHARMACY</option>
                                        @foreach($practices as $par)
                                            <option
                                                @if(Request('practice_name')==$par->id ){{ 'selected' }} @endif value="{{ $par->id }}">{{ $par->practice_name }}</option>
                                        @endforeach
                                    </select>
                                    <input class="wd-100p" type="text" id="Practice_Name" style="display:none;" disabled readonly value="" />
                                </div>


                            </div>


                            <div class="flx-justify-start flds-rxb_gn-str-df mb-14_">

                                    <div class="wd-63p field fld-rx-brand-generic-name mr-1p">
                                    <label class="wd-100p pa-4_ mb-0_ tt_uc_ txt-wht bg-gray-57">RX BRAND OR GENERIC NAME</label>
                                    <input class="wd-100p a-reset" type="text" required name="rx_brand_or_generic" id="rx_brand_or_generic" pattern="^[a-zA-Z\d\-_\s]+$" placeholder="Enter drug name or generic name">
                                </div>

                                <div class="wd-17p field fld-strength mr-1p">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57">STRENGTH</label>
                                    <input type="text" name="strength" required id="strength" pattern="^[a-zA-Z\d\-/,._\s]+$" placeholder="Enter strength" class="wd-100p a-reset" />

                                </div>
                                <div class="wd-22p field fld-dosage_from">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57">DOSAGE FORM</label>
                                    <input name="dosage_form" required id="dosage_form" class="wd-100p a-reset" pattern="^[a-zA-Z\d\-/,._\s]+$" type="text" placeholder="Enter dosage form">                            
                                </div>

                            </div>


                            <div class="flx-justify-start flds-doin-qt-dysp-ref mb-14_">

                                    <div class="wd-63p field fld-doing_instr mr-1p">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57 tt_uc_">DOSING INSTRUCTIONS</label>
                                    <input class="wd-100p cnt-left  a-reset" name="dosing_instructions" id="dosing_instructions" type="text" placeholder="Enter dosaing insructions" >
                                </div>

                                <div class="wd-7p field fld-qty mr-1p" style="min-width:40px;">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57 tt_uc_">QTY</label>
                                    <input class="wd-100p cnt-right  a-reset" required name="quantity" pattern="[0-9]" mask="000000" maxlength="6" id="quantity" type="text" placeholder="Qty" >
                                </div>
                                <div class="wd-12p field fld-days-supply mr-1p">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57 tt_uc_">Days Supply</label>
                                    <input class="wd-100p cnt-right  a-reset" required name="days_supply" pattern="[0-9]" mask="000000" maxlength="6" id="days_supply" type="text" placeholder="Days Supply" >
                                </div>
                                <div class="wd-16p field fld-refills">
                                    <label class="wd-100p pa-4_ mb-0_ txt-wht bg-gray-57 tt_uc_">REFILLS</label>
                                    <input class="wd-100p cnt-right  a-reset" required name="refills" pattern="[0-9]" mask="000000" maxlength="6" id="refills" type="text" placeholder="Refills" >
                                </div>

                            </div>

                            <div class="flx-justify-start flds-reporter-enroll-radio mb-14_">
                                <div class="wd-100p  flx-justify-start flex-vr-center radio-field">
                                    <div class="radio-field-option">
                                        <label class="cur-pointer mb-0_" for="reporter_comment_1">
                                            <input class="" id="reporter_comment_1" value="reporter_comment_1"  name="reporter_comment" type="radio">
                                            <span class="text fs-14_ txt-gray-6" style="width: 100%;">Fill This AS Is</span>
                                        </label>
                                    </div>
                                    <div class="radio-field-option">
                                        <label class="cur-pointer mb-0_" for="reporter_comment_2">
                                            <input class="" id="reporter_comment_2" value="reporter_comment_2"  name="reporter_comment" type="radio">
                                            <span class="text fs-14_ txt-gray-6 tt_uc_" style="width: 100%;">find only <span class="txt-red tt_uc_">economical versions</span> of this drug</span>
                                        </label>
                                    </div>
                                    <div class="radio-field-option">
                                        <label class="cur-pointer mb-0_" for="reporter_comment_3">
                                            <input class="" id="reporter_comment_3" value="reporter_comment_3" name="reporter_comment" type="radio">
                                            <span class="text fs-14_ txt-gray-6 tt_uc_" style="width: 100%;">find all lower patient <span class="txt-red tt_uc_">cost therapuetic</span> alternatives</span>
                                        </label>
                                    </div>
                                </div>




                            </div>

                            <div class="flx-justify-start mb-14_">
                                <div class="wd-33p field fld-call_back_no">
                                    <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_">call back number</label>
                                    <input class="wd-100p a-reset" type="text" name="reporter_cell_number" id="reporter_cell_number" minlength="10" mask="(000) 000-0000" placeholder="(000) 000 0000">
                                </div>
                            </div>

                            <div class="flx-justify-start mb-14_">
                                <div class="flx-justify-start dr-cl-adv_pat-msg_btns-col" style="min-width: 400px;">
                                    <button class="drg-cln-adv txt-red weight_600 tt_uc_ mr-14_" type="button" >&#10010; Drug Clinical Advisory</button>
                                    <button class="patient-message txt-grn-lt weight_600  tt_uc_ " type="button" data-toggle="modal" data-target="#patient_msg-Modal" >Patient Message</button>
                                </div>
                                <div class="flx-justify-end clear-sbmt-btns-col" style="min-width: 170px; margin-left: auto; align-items: center;">
                                    <img id="loading_small_one" src="{{ asset('images/small_loading.gif') }}" style="width: 30px; display: none;">
                                    <button class="clear-form weight_500 tt_uc_ bg-red-txt-wht" type="button" data-dismiss="modal" >cancel</button>
                                    <button class="submit-form weight_500 tt_uc_ ml-14_ bg-dk-grn-txt-wht" id="precription_submit_btn" type="submit">Save</button>
                                </div>
                            </div>

                       {{--  <div class="modal" id="patient_msg-Modal" style="display:none;">
                                <div class="modal-dialog wd-87p-max_w_400">
                                    <div class="modal-content">
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Patient Message</h4>
                                    <button type="button" class="close stick-top-right-circle bw-hover" onclick=" $('#patient_msg-Modal').modal('hide');">X</button>
                                  </div>
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="trow_ pos-rel_" style="">                                      
                                          <textarea pattern="^[a-zA-Z\d\-/_\s]+$" class="trow_ weight_600 a-reset" style="height: 64px" name="patient_message" id="patient_message"> </textarea>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                      <div class="flx-justify-start wd-100p">
                                          <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" onclick="$('#patient_message').val('');  $('#patient_msg-Modal').modal('hide'); return true;">cancel</button>
                                        <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " style="margin-left: auto;" data-dismiss="modal">ADD</button>
                                      </div>
                                  </div>
                                  </div>
                              </div>
                            </div>--}}

                        </form>  					
                        </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer" style="font-size: 1px; visibility: hidden;">
            </div>
        </div>
    </div>
</div>



