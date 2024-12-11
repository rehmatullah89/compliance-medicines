<style>

    </style>


<div class="modal" id="drug-Add-Modal" style="z-index: 1100" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog wd-87p-max_w_700">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht">Drug Database Maintenance</h4>
          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
          {{-- <input type="text" autocomplete="off" id="keyword" style="border: 4px #575757 solid; height: unset !important; padding-right: 24px;"
           class="form-control pr-24_"  placeholder="Drug Name, NDC, or GCN sequence"> --}}
           <div class="input-group" style="display: flex;align-items: center;border-radius: 36px;background-color:#fff;padding-left: 17px;padding-right: 27px;position: relative;max-width: 350px;margin-top: 2px;">
            <input type="text" autocomplete="off" id="keyword" class="wd-100p" value="" style="line-height: 1.2em !important;height: 26px;border: 0px;padding-left: 0px;padding-right: 2px;position: relative;" placeholder="Search using drug name, ndc, etc" data-provide="typeahead">
            <div class="input-group-append elm-right" style="height: 26px;background-color:transparent;color:#fff !important;margin: 0px;border-radius: 0px 13px 13px 0px;position: absolute;top: 0px;right: 1px;z-index: 100;">
                <button type="button" class="btn bg-blue-txt-wht btn-circle" style="border-radius: 50%;width: 26px;text-align: center;height: 26px;padding: 0px;transform: scale(0.8);position: relative;z-index: 10;">
                    <i class="fa fa-search" style="line-height: 24px;"></i>
                </button>
            </div>
        </div>
           <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">✖</button>
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

                            <div class="flds-rxl-ndc-gbc flx-justify-start mb-14_">
                                <div class="wd-62p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">Rx Label Name:</label>
                                    <input class="wd-100p trow_" type="text" required
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="rx_label_name" id="rx_label_name" maxlength="40">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-21p field field-modal fld-ndc">
                                    <label class="wd-100p">NDC:</label>
                                    <input class="wd-100p" placeholder="xxxxx-xxxx-xx" mask="00000-0000-00" type="text" name="ndc" id="ndc" required>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-15p field field-modal fld-ndc">
                                    <label class="wd-100p">G/ B/ CMP:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text" required maxlength="3" minlength="1" pattern="^[a-zA-Z\-_\s]+$"
                                     name="generic_or_brand" id="generic_or_brand">
                                </div>
                                <div class="wd-1p"></div>
                              <div class="wd-30p field field-modal fld-mrc">
                                  <label class="wd-100p">UPC:</label>
                                  <input class="wd-100p" type="text"  id="upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc">
                              </div>
                            </div>

                            <div class="flds-st-df-ing-rxq flx-justify-start mb-14_">
                                <div class="wd-22p field field-modal fld-strength">
                                    <label class="wd-100p">Strength:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text" required pattern="^[a-zA-Z\d\-_./\(),%'\s]+$" name="strength" maxlength="15" id="strength" >
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-30p field field-modal fld-dosage-form">
                                    <label class="wd-100p">Dosage Form:</label>
                                    <input class="wd-100p" type="text" required  pattern="^[a-zA-Z\d\-_./\(),%'\s]+$" id="dosage_form" maxlength="21" name="dosage_form">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-15p field field-modal fld-ing-cost-unit">
                                    <label class="wd-100p">ING Cost / Unit:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text"  name="unit_price" maxlength="12" required  id="unit_price">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-15p field field-modal fld-ing-cost-unit">
                                    <label class="wd-100p">AWP Unit Price:</label>
                                    <input class="wd-100p" type="text"  name="awp_unit_price" maxlength="12"  id="awp_unit_price">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-10p field field-modal fld-gcnseq">
                                    <label class="wd-100p">GCN:</label>
                                    <input class="wd-100p" type="text"  id="gcnseq_drgmnt" name="gcn_seq"  pattern="[0-9]" mask="000000" onKeyPress="return numericOnly(event,6)">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-10p field field-modal fld-gcnseq">
                                    <label class="wd-100p">PKG Size:</label>
                                    <input class="wd-100p" type="text"  id="pkg_size" name="pkg_size"  pattern="[0-9]" maxlength="7"  onKeyPress="return numericOnly(event,6)">
                                </div>
                                <div class="wd-18p field field-modal fld-df-rx-qty" style="display:none;">
                                    <label class="wd-100p">Default Rx Qty:</label>
                                    <!-- <input class="wd-100p" type="number" name="default_rx_qty" required pattern="[0-9]" mask="000000" maxlength="6" onKeyPress="return numericOnly(event,6)" id="default_rx_qty" > -->
                                    <input class="wd-100p" type="text" name="default_rx_qty"  data-type="quantity" maxlength="8" onKeyPress="return numericOnly(event,8)" id="default_rx_qty" >
                                </div>
                            </div>

                            <div class="flds-dea-gcn-br-mrc flx-justify-start mb-14_">
                                <div class="wd-10p field field-modal fld-dea">
                                    <label class="wd-100p">DEA:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" name="dea" pattern="[0-9]" min="0" mask="0000" required minlength="1" onKeyPress="return numericOnly(event,4)" id="dea" type="number">
                                </div>
                                
                                <div class="wd-1p"></div>
                                <div class="wd-12p field field-modal fld-br-ref">
                                    <label class="wd-100p">Maintenance:</label>
                                    <input size="6" type="text" name="maintenance" pattern="[1-2]" maxlength="1" id="maintenance">
                                </div>
                                
                                <div class="wd-1p"></div>
                                <div class="wd-29p field field-modal fld-br-ref">
                                    <label class="wd-100p">GPI-14:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text" pattern="^[a-zA-Z\d\s]+$" name="generic_pro_id" required  maxlength="14" id="generic_pro_id">
                                </div>
                                
                                <div class="wd-1p"></div>
                                <div class="wd-29p field field-modal fld-br-ref">
                                    <label class="wd-100p"><span class="txt-red">Brand Reference:</span></label>
                                    <input class="wd-100p" type="text" name="brand_reference" pattern="^[a-zA-Z\d\-_./\()&,%'\s]+$" maxlength="26" id="brandReference-drgmnt">
                                </div>
                                
                                <div class="wd-1p"></div>
                                <div class="wd-29p field field-modal fld-br-ref">
                                    <label class="wd-100p">Generic Name:</label>
                                    <input class="wd-100p" type="text" name="generic_name" pattern="^[a-zA-Z\d\-_./\()&,%'\s]+$" maxlength="40" id="generic_name">
                                </div>
                                
                            </div>

                            <div class="flds-dea-gcn-br-mrc flx-justify-start mb-14_">

                                <div class="wd-30p field field-modal fld-marketer">
                                    <label class="wd-100p">Marketer:<span class="txt-red"></span></label>
                                  <input class="wd-100p" type="text" required  pattern="^[a-zA-Z\d\-_./\(),%'\s]+$" maxlength="20"   name="marketer" id="marketer">
                              </div>
                              
                                <div class="wd-1p"></div>
                                <div class="wd-38p field field-modal fld-mg-rp-cs">
                                    <label class="wd-100p">Major Reporting Class:</label>
                                    <input class="wd-100p" type="text" autocomplete="off" required pattern="^[a-zA-Z\-_.\s]+$" maxlength="50" id="major_reporting_cat" name="major_reporting_cat" >
                                </div>
                              
                                <div class="wd-1p"></div>
                              <div class="wd-40p field field-modal fld-mrc">
                                  <label class="wd-100p">Minor Reporting Class:</label>
                                  <input class="wd-100p" type="text"  id="minor_reporting_class" required pattern="^[a-zA-Z\-_.\s]+$" maxlength="50" autocomplete="off" name="minor_reporting_class">
                              </div>
                                 
                          </div>

                          <div class="flds-rxl-ndc-gbc flx-justify-start mb-14_">
                                <div class="wd-15p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">Sponsor Source:</label>
                                    <input class="wd-100p trow_" type="text"
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="sponsor_source" maxlength="15">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-14p field field-modal fld-ndc">
                                    <label class="wd-100p">Sponsor Item #:</label>
                                    <input class="wd-100p" type="text" name="sponsor_item" id="ndc"  maxlength="10" pattern="^[a-zA-Z\d\-_\s]+$">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-57p field field-modal fld-ndc">
                                    <label class="wd-100p">Order Web Link:</label>
                                    <input class="wd-100p" type="text"  maxlength="50"
                                     name="order_web_link" >
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-10p field field-modal fld-rx-label">
                                <label class="wd-100p">Units/Pkg</label>
                                    <input class="wd-100p trow_" type="text"
                                     autocomplete="off" id="unit_per_pkg" name="unit_per_pkg" maxlength="7">
                                </div>
                            </div>

                          <div class="flds-spsr-altr flx-justify-start mb-14_">

                                <div class="field field-modal fld-sponsor mr-14_">
                                    <label class="wd-100p cur-pointer" style="margin: 0px;"><input type="checkbox" class="large" id="sponsored" name="sponsored_product" value="Y" style="border: 0px;"><span style="line-height: 1.3em;" class="txt-blue">Sponsored</span></label>
                              </div>
							  <div class="field field-modal fld-alternate mr-14_">
                                    <label class="wd-100p cur-pointer" style="margin: 0px;"><input type="checkbox" class="large" id="alternate" name="alternate" value="Y" style="border: 0px;"><span style="line-height: 1.3em;" class="txt-blue">Alternate</span></label>
                              </div>
                              
                              <div class="field field-modal fld-discount_offer mr-14_">
                                    <label class="wd-100p cur-pointer" style="margin: 0px;"><input type="checkbox" class="large" id="discount_offer" name="discount_offer" value="Y" style="border: 0px;"><span style="line-height: 1.3em;" class="txt-blue">Discount Offer</span></label>
                              </div>
                              
                              <div class="field field-modal txt-blue fld-discount_date mr-14_">
                                  <label class="elm-right cur-pointer txt-gray-6 fs-14_ weight_500" style="margin: 0px;font-weight: 400 !important;">Expiration Date</label><input id="discount_date" size="10" type="text" name="discount_date" readonly="" value="" maxlength="20" placeholder="mm-dd-yyyy" class="valid txt-blue pa-0_ weight_600" aria-invalid="false" style="
                                        padding: 0px;
                                        padding-bottom: 2px;
                                        height: auto;
                                        border: 0px;
                                        border-radius: 0px;
                                        border-bottom: solid 1px #3e7bc4;
                                        width: auto;
                                    ">

                              </div>
                              

                          </div>

                          <!-- <div class="flds-rxl-ndc-gbc flx-justify-start ">
                                <div class="wd-62p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">Alternante Rx Label Name:</label>
                                    <input class="wd-100p trow_" type="text" 
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="alternate_rx_label_name" id="alternate_rx_label_name" maxlength="40">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-21p field field-modal fld-ndc">
                                    <label class="wd-100p">Alternate NDC:</label>
                                    <input class="wd-100p" placeholder="xxxxx-xxxx-xx" mask="00000-0000-00" type="text" name="alternate_ndc" id="alternate_ndc" >
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-15p field field-modal fld-ndc">
                                    <label class="wd-100p">Alternate Rx Qty:</label>
                                    <input class="wd-100p" type="text" name="alternate_qty"  data-type="quantity" maxlength="8" onKeyPress="return numericOnly(event,8)" id="alternate_qty" >
                                </div>
                            </div> -->
                             
                            <div class="flds-rxl-ndc-gbc flx-justify-start ">
                                
                                
                                <div class="wd-30p field field-modal fld-ndc">
                                    <label class="wd-100p">MFR Discount Offer Description:</label>
                                    <input class="wd-100p" maxlength="50" type="text" name="offer_description" id="offer_description" >
                                </div>
                                
                                <div class="wd-1p"></div>
                                <div class="wd-62p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">MFR Discount Offer Website:</label>
                                    <input class="wd-100p trow_" type="text" 
                                     name="offer_website" id="offer_website" maxlength="100">
                                </div>
                                
                                <div class="wd-1p"></div>
                                <div class="wd-15p field field-modal fld-ndc">
                                    <label class="wd-100p">Offer Type:</label>
                                    <input class="wd-100p" type="text" name="offer_type" maxlength="20" id="offer_type" >
                                </div>
                            </div>


                        </div>
                    </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
                <div class="flx-justify-start wd-100p">
                  <button type="button"  class="btn bg-red-txt-wht weight_500 fs-14_" id="cancel_btn">CANCEL</button>
                  <button type="button" id="del_drug_btn" style="display:none;" onclick="drug_del();" class="btn ml-14_ bg-red-txt-wht weight_500 fs-14_" >DELETE DRUG</button>
                  <button type="button" id="undo_btn" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button>
                  <button id="submitOrder" type="submit" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>






  <div class="modal" id="modal-view_drugs">
  <div class="modal-dialog wd-87p-max_w_1024">
    <div class="modal-content compliance-form_">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title fs-17_ lh-21_">View Drugs</h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button> <!-- &#10006; -->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
                  <form action="javascript:void(0);"  id="drug_request_filter" name="drug_request_filter" method="post" class="compliance-form_">
     			
				  <div class="flds-ndc-gcn-gpi flx-justify-start mb-14_">
						<div class="field fld-ndc mr-2p">
							<label class="wd-100p">NDC</label>
							<input class="wd-100p" type="text" mask="00000-0000-00" name="ndc" placeholder="xxxx-xxxx-xx">
						</div>
						<div class="field fld-gcn mr-2p">
							<label class="wd-100p">GCN</label>
							<input class="wd-100p txt-blue weight_600" name="gcn" type="text" pattern="[0-9]" mask="000000" onKeyPress="return numericOnly(event,6)" placeholder="xxxxxx">
						</div>
						<div class="field fld-gpi-14 mr-2p">
							<label class="wd-100p">GPI-14:</label>
							<input class="wd-100p" type="text" name="gpi" pattern="^[a-zA-Z\d\s]+$"  maxlength="14" placeholder="xxxxxxxxxxxxxx">
						</div>
						<div class="field view-search-button" id="drug_filter_btn" style="align-self: flex-end;">
						    <button type="submit" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ ">search / view</button>
						</div>
					</div>
                  </form>
					<div class="row">
						<div class="col-sm-12 table-responsive">
							<table class="table bordered hd-row-blue-shade-rounded drug_filter_table">
								<thead>
									<tr class="weight_500-force-childs">

										<th class="txt-wht bg-blue">NDC</th>
										<th class="txt-wht bg-blue">Drug Label Name</th>
										<th class="txt-wht bg-blue">Generic For</th>
										<th class="txt-wht bg-blue">Strength</th>
										<th class="txt-wht bg-blue">Marketer</th>
										{{-- <th class="txt-wht bg-blue">Ingredient Cost</th> --}}
										<th class="txt-wht bg-blue">B/G/CMP</th>
										<th class="txt-wht bg-blue">Major Therapuetic Category</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="9" style="text-align: center">Please search for similar drugs</td>
								
								
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

          </div>
  </div>
</div>
