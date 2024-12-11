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



<div class="modal" id="sponsors-Modal">
    <div class="modal-dialog wd-87p-max_w_700">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht">Sponsor Maintenance</h4>
          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">?</button>
         
        </div>
        <form  novalidate="novalidate" action="javascript:void(0);" id="product_form2" name="drug_form" method="post" >
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
                             <div class="wd-62p field field-modal fld-rx-label" style="margin: 0 auto; width:83%;">
                                 <label class="wd-100p trow_">Image Title:</label>
                                 <input class="wd-100p trow_" onkeydown="check_validate(this.value);" onkeyup="check_validate(this.value);" type="text" required pattern="^[a-zA-Z\d\-_\s]+$" name="banner_title_name" id="banner_title_name">
                                 <label id="banner_error_msg_title" class="error" style="display:none;">This field is required.</label>
                             </div>
                             
                         </div> 

                       <div class="file-upload">
                            <button class="file-upload-btn" type="button" onclick="$('#sponsors-Modal .file-upload-input').trigger( 'click' )">Add Image</button>
                            <label id="error_msg_show" class="error" style="display:none;">This field is required.</label>
                            <div class="image-upload-wrap">
                              <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                              <div class="drag-text">
                              <h3>Drag and drop a file or select add Image</h3> 
                              </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" id="uploaded_image" src="#" alt="your image" />
                              <div class="image-title-wrap">
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
                  <button type="button" id="undo_btn" onclick="reset_form();" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button>
                  <button id="submitOrder" onclick="add_file();" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>




<div class="modal" id="sponsors-Modal_enrol">
    <div class="modal-dialog wd-87p-max_w_700">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht">Sponsor Maintenance</h4>
          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">?</button>
         
        </div>
        <form  novalidate="novalidate" action="javascript:void(0);" id="product_form2_enrol" name="drug_form" method="post" >
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
                             <div class="wd-62p field field-modal fld-rx-label" style="margin: 0 auto; width:83%;">
                                 <label class="wd-100p trow_">Image Title:</label>
                                 <input class="wd-100p trow_" onkeydown="check_validate_enrol(this.value);" onkeyup="check_validate_enrol(this.value);" type="text" required pattern="^[a-zA-Z\d\-_\s]+$" name="banner_title_name" id="banner_title_name">
                                 <label id="banner_error_msg_title" class="error" style="display:none;">This field is required.</label>
                             </div>
                             
                         </div> 

                       <div class="file-upload">
                            <button class="file-upload-btn" type="button" onclick="$('#sponsors-Modal_enrol .file-upload-input').trigger( 'click' )">Add Image</button>
                            <label id="error_msg_show" class="error" style="display:none;">This field is required.</label>
                            <div class="image-upload-wrap">
                              <input class="file-upload-input" type='file' onchange="readURL_enrol(this);" accept="image/*" />
                              <div class="drag-text">
                              <h3>Drag and drop a file or select add Image</h3> 
                              </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" id="uploaded_image" src="#" alt="your image" />
                              <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload_enrol()" class="remove-image">Remove</button>
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
                  <button type="button" id="undo_btn" onclick="reset_form_enrol();" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button>
                  <button id="submitOrder" onclick="add_file_enrol();" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>

  <div class="modal" id="sponsors-import-drug">
    <div class="modal-dialog wd-87p-max_w_700">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht">Import Drugs</h4>
          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">X</button>
         
        </div>
        <form  novalidate="novalidate" action="javascript:void(0);" id="drug_import_form"  method="post" >
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
                        

                       <div class="file-upload">
                            <button class="file-upload-btn" type="button" onclick="$('#sponsors-import-drug .file-upload-input').trigger( 'click' )">Add Excel File</button>
                            <label id="error_msg_show" class="error" style="display:none;">This field is required.</label>
                            <div class="image-upload-wrap">
                              <input name="import_file" class="file-upload-input" type='file' onchange="readURL_drug(this);" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                              <div class="drag-text">

                              <h3>Drag and drop a file or select add File</h3> 
                              </div>
                            </div>
                            <div class="file-upload-content">
                                <span class="file-upload-image fa fa-file-excel-o" id="uploaded_file"  ></span>
                              <div class="image-title-wrap">
                                <!-- <button type="button" onclick="" class="remove-image">Remove</button> -->
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
                  <!-- <button type="button" id="undo_btn" onclick="" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button> -->
                  <button id="submitOrder2" onclick="import_drug()" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>
