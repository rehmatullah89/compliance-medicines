

<style>

.file-upload {

    background-color: #ffffff;

    width: 600px;

    margin: 0 auto;

    padding: 0 20px;

  }

  

  .file-upload-btn {

    width: 100%;

    margin: 0;

    color: #fff;

    background: #1FB264;

    border: none;

    padding: 10px;

    border-radius: 4px;

   /* border-bottom: 4px solid #15824B;*/

    transition: all .2s ease;

    outline: none;

    text-transform: uppercase;

    font-weight: 700;

  }

  

  .file-upload-btn:hover {

    background: #1AA059;

    color: #ffffff;

    transition: all .2s ease;

    cursor: pointer;

  }

  

  .file-upload-btn:active {

    border: 0;

    transition: all .2s ease;

  }

  

  .file-upload-content {

    display: none;

    text-align: center;

  }

  

  .file-upload-input {

    position: absolute !important;

    margin: 0 !important;

    padding: 0 !important;

    width: 100% !important;

    height: 100% !important;

    outline: none !important;

    opacity: 0 !important;

    cursor: pointer !important;

  }

  

  .image-upload-wrap {

    margin-top: 20px;

    border: 2px dashed #1FB264;

    position: relative;

  }

  

  .image-dropping,

  .image-upload-wrap:hover {

    background-color: #1FB264; 

    border: 2px dashed #ffffff;

  }

  

  .image-title-wrap {

    padding: 0 15px 15px 15px;

    color: #222;

  }

  

  .drag-text {

    text-align: center;

  }

  

  .drag-text h3 {

    font-weight: 100;

    text-transform: uppercase;

    color: #15824B;

    padding: 60px 0;

  }

  

  .file-upload-image {

    max-height: 200px;

    max-width: 200px;

    margin: auto;

    padding: 20px;

  }

  

  .remove-image {

    width: 200px;

    margin: 0;

    color: #fff;

    background: #cd4535;

    border: none;

    padding: 10px;

    border-radius: 4px;

   /* border-bottom: 4px solid #b02818;*/

    transition: all .2s ease;

    outline: none;

    text-transform: uppercase;

    font-weight: 700;

  }

  

  .remove-image:hover {

    background: #c13b2a;

    color: #ffffff;

    transition: all .2s ease;

    cursor: pointer;

  }

  

  .remove-image:active {

    border: 0;

    transition: all .2s ease;

  }

  </style>

  

  







<div class="modal" id="clinical-Modal">

    <div class="modal-dialog wd-87p-max_w_700">

      <div class="modal-content compliance-form_" >



        <!-- Modal Header -->

        <div class="modal-header">

          <h4 class="modal-title txt-wht">Clinical Advisory</h4>

          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->

         

          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>

        </div>

        <form  novalidate="novalidate" action="javascript:void(0);" id="clinical_form2" name="clinical_form" method="post" >

        <!-- Modal body -->

        <div class="modal-body">

            <div class="row">

                <div class="col-sm-12">

                <span class="site-red-color fs-14_ all-order-error" style="display: none;font-weight: bold;"> Please fill required fields </span>

            </div>

            </div>

                    <div class="row">

                        <div class="col-sm-12">

                        <div id="form_raw_data"></div>

                        <div class="flds-rxl-ndc-gbc flx-justify-start mb-14_">

                            <input type="hidden" name="OrderId" />

                            <input type="hidden" name="PatientId" />

                             <input type="hidden" name="PracticeId" />

                            <input name="modal_type" id="modal-type" value="clinical_advisory" type="hidden" />

                             <div class="wd-62p field field-modal fld-rx-label" style="margin: 0 auto; width:83%;">

                                 <label class="wd-100p trow_">Message:</label>

                                 <input class="wd-100p trow_" onkeydown="check_validate(this.value);" onkeyup="check_validate(this.value);" maxlength="100" type="text" required pattern="^[a-zA-Z\d\-_\s]+$" name="Message" id="clinical_message">

                                 <label id="banner_error_msg_title" class="error" style="display:none;">This field is required.</label>

                             </div>

                             

                         </div> 



                       <div class="file-upload">

                            <button class="file-upload-btn" type="button" onclick="$('#clinical-Modal .file-upload-input').trigger( 'click' )">Add File</button>

                            <label id="error_msg_show" class="error" style="display:none;">This field is required.</label>

                            {{-- <canvas id="pdfViewer"></canvas> --}}

                            <div class="image-upload-wrap">

                                

                              <input class="file-upload-input" name="CustomDocument" type='file' onchange="readURL(this);" accept="application/pdf,image/*" />

                              <div class="drag-text">

                              <h3>Drag and drop a file or select add file</h3> 

                              </div>

                            </div>

                            <div class="file-upload-content">

                                <span class="file-upload-image" id="uploaded_image" alt="your image" >
                                  
                                </span>



                              <div class="image-title-wrap">

                                <img id="loading_small" src="{{ url('images/small_loading.gif') }}" style="width: 30px;display: none;">

                                <button type="button" onclick="removeUpload()" class="remove-image">Remove</button>

                              </div>

                            </div>

                          </div>                         



                        </div>

                     </div>



        </div>



        <!-- Modal footer -->

        <div class="modal-footer">

                <div class="flx-justify-start wd-100p">

                  <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_" data-dismiss="modal">Cancel</button>

                  {{-- <button type="button" id="undo_btn" onclick="reset_form();" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button> --}}

                  <button id="submitOrder" onclick="submit_form();" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>

              </div>

        </div>



      </form>

    </div>

    </div>

  </div>