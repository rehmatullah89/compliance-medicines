@extends('layouts.compliance')

@section('content')


<style>

    .row.cmp-container-sidebar-menu.fullwidth { padding-right: 14px; }
    
</style>

<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12">
		<h4 class="elm-left fs-24_ mb-4_">Sponsored Drugs</h4>
		<div class="date-time elm-right">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
	</div>
</div>

<div class="row mt-17_">
	<div class="col-sm-12">
		<div class="row" style="border: solid 1px #dee2e6;">
			<div class="col-sm-12">
				
				
				<!-- <div class="row pt-14_"> -->
					<!-- <div class="col-sm-12" style="display: flex; align-items: flex-end; justify-content: flex-start;">
                      
						<div style="margin-left: auto; position: relative; top: 14px;">
							
                                                       
                         
                                     
                                            
                                            
                                            
					</div>
				</div> -->
				<div class="row mt-17_ mb-17_ pr-14_ pl-14_">
					<div class="col-sm-12 pr-0 pl-0 table-responsive pb-7_">
                    <table class="table reports-bordered compliance-user-table data-table" >
        <thead>
            <tr >
                <th class="bg-blue txt-wht refill_next" style="white-space:nowrap;">Sponsored</th>
                <th class="bg-orage txt-wht refills_rem" style="white-space:nowrap;">Sponsor Source</th>
                <th class="bg-gr-bl-dk txt-wht cnt-center rx_no" style="white-space:nowrap;">Sponsor Item Number</th>
                <th class="bg-gray-1 txt-wht rx_label_name" style="white-space:nowrap;">Order Web Link</th>
                <th class="bg-gray-1 txt-wht generic_for">GCNSEQ</th>
                <th class="bg-blue txt-wht qty">NDC</th>
                <th class="bg-gray-1 txt-wht days_suppy" style="white-space:nowrap;">UPC</th>
                <th class="bg-gray-80 txt-wht rx_sell_price" style="white-space:nowrap;">Rx Label Name</th>
                <th class="bg-red-dk txt-wht reward_auth" style="white-space:nowrap;">Strength</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">Dosage form</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">ING COST/unit</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">Default Rx QTY</th>
                
            </tr>
        </thead>
        <tbody id="tbodies_data">
            @if(isset($drugs) && count($drugs)>0)
                @foreach($drugs as $keyRes=>$valRes)
                <tr data-did="{{$valRes['id']}}">
                    <td class="bg-tb-blue-lt txt-black-24 cnt-center" >
                    	<a class="td_u_force txt-blue_sh-force" href="javascript:void(0)" onclick="remove_sponsor({{$valRes['id']}})">{{$valRes['sponsored_product']}}</a>
                    </td>
                    <td class="bg-tb-orange-lt txt-orange">{{$valRes['sponsor_source']}}</td>
                    <td class="bg-gray-e txt-wht cnt-left"><span class="txt-gray-9">{{$valRes['sponsor_item']}}</td>
                    <td class="bg-tb-pink-lt txt-blue-force cnt-left weight_600">{{$valRes['order_web_link']}}</td>
                    <td class="bg-tb-grn-lt txt-black-24 ">{{$valRes['gcn_seq']}}</td>
                    <td class="bg-gray-e txt-black-24 ">{{$valRes['ndc']}}</td>
                    <td class="bg-gray-e txt-blue txt-blue">{{$valRes['upc']}}</td>
                    <td class="bg-tb-pink txt-red txt-red">{{$valRes['rx_label_name']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['strength']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['dosage_form']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['unit_price']}}</td>
                    <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['default_rx_qty']}}</td>

                </tr>                                                      
                @endforeach
                @else
                    <tr>
                        <td style="text-align: center;" colspan="12">No data available in table</td>
                    </tr>
                @endif                                                                    
        </tbody>
    </table>
						
					</div>
				</div>
			<!-- </div> -->
		</div>
	</div>
</div>
<div class="modal" id="drug-Unspons-Modal" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog wd-87p-max_w_700">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht">Remove Sponsored Drug</h4>
    
           
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
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="rx_label_name" id="rx_label_name" maxlength="25">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-21p field field-modal fld-ndc">
                                    <label class="wd-100p">NDC:</label>
                                    <input class="wd-100p" placeholder="xxxxx-xxxx-xx" mask="00000-0000-00" type="text" name="ndc" id="ndc" required>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-30p field field-modal fld-mrc">
                                  <label class="wd-100p">UPC:</label>
                                  <input class="wd-100p" type="text"  id="upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc">
                              	</div>
                                <!-- <div class="wd-15p field field-modal fld-ndc">
                                    <label class="wd-100p">G/ B/ CMP:</label>
                                    <input class="wd-100p" type="text" required maxlength="3" minlength="1" pattern="^[a-zA-Z\-_\s]+$"
                                     name="generic_or_brand" id="generic_or_brand">
                                </div> -->
                                
                            </div>

                            <div class="flds-st-df-ing-rxq flx-justify-start mb-14_">
                                <div class="wd-23p field field-modal fld-strength">
                                    <label class="wd-100p">Strength:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text" pattern="^[a-zA-Z\d\-_./\(),'\s]+$" name="strength" maxlength="15" id="strength" required>
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-38p field field-modal fld-dosage-form">
                                    <label class="wd-100p">Dosage Form:</label>
                                    <input class="wd-100p" type="text" required  pattern="^[a-zA-Z\-_.\s]+$" id="dosage_form" maxlength="21" name="dosage_form">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-16p field field-modal fld-gcnseq">
                                    <label class="wd-100p">GCNSEQ:<span class="txt-red"></span></label>
                                    <input class="wd-100p" type="text"  id="gcnseq_drgmnt" name="gcn_seq" pattern="[0-9]" mask="000000" onKeyPress="return numericOnly(event,6)">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-18p field field-modal fld-ing-cost-unit">
                                    <label class="wd-100p">ING Cost / Unit:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" type="text"  name="unit_price" maxlength="8" required  id="unit_price">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-18p field field-modal fld-df-rx-qty">
                                    <label class="wd-100p">Default Rx Qty:</label>
                                    <input class="wd-100p" type="number" name="default_rx_qty" required pattern="[0-9]" mask="000000" maxlength="6" onKeyPress="return numericOnly(event,6)" id="default_rx_qty" >
                                </div>
                            </div>

                            <!-- <div class="flds-dea-gcn-br-mrc flx-justify-start mb-14_"> -->
                                <!-- <div class="wd-14p field field-modal fld-dea">
                                    <label class="wd-100p">DEA Class:<span class="txt-red">*</span></label>
                                    <input class="wd-100p" name="dea" pattern="[0-9]" mask="0000" required minlength="1" onKeyPress="return numericOnly(event,4)" id="dea" type="number">
                                </div> -->
                                <!-- <div class="wd-1p"></div> -->
                                <!-- <div class="wd-16p field field-modal fld-gcnseq">
                                    <label class="wd-100p">GCNSEQ:<span class="txt-red"></span></label>
                                    <input class="wd-100p" type="text"  id="gcnseq_drgmnt" name="gcn_seq" pattern="[0-9]" mask="000000" onKeyPress="return numericOnly(event,6)">
                                </div> -->
                                <!-- <div class="wd-1p"></div> -->
                                <!-- <div class="wd-29p field field-modal fld-br-ref">
                                    <label class="wd-100p"><span class="txt-red">Brand Reference:</span></label>
                                    <input class="wd-100p" type="text" required name="brand_reference" pattern="^[a-zA-Z\-_.\s]+$" maxlength="26" id="brandReference-drgmnt">
                                </div> -->
                                <!-- <div class="wd-1p"></div> -->
                                <!-- <div class="wd-38p field field-modal fld-mg-rp-cs">
                                    <label class="wd-100p">Major Reporting Class:</label>
                                    <input class="wd-100p" type="text" autocomplete="off" pattern="^[a-zA-Z\-_.\s]+$" maxlength="50" id="major_reporting_cat" name="major_reporting_cat" required>
                                </div> -->
                            <!-- </div> -->

                            <!-- <div class="flds-dea-gcn-br-mrc flx-justify-start mb-14_"> -->

                                <!-- <div class="wd-30p field field-modal fld-marketer">
                                    <label class="wd-100p">Marketer:<span class="txt-red">*</span></label>
                                  <input class="wd-100p" type="text"  pattern="^[a-zA-Z\-_.\s]+$" maxlength="20"  required name="marketer" id="marketer">
                              </div>
                              <div class="wd-1p"></div>
                              <div class="wd-40p field field-modal fld-mrc">
                                  <label class="wd-100p">Minor Reporting Class:</label>
                                  <input class="wd-100p" type="text" required id="minor_reporting_class" pattern="^[a-zA-Z\-_.\s]+$" maxlength="50" autocomplete="off" name="minor_reporting_class">
                              </div> -->
                                 <!-- <div class="wd-1p"></div> -->
                              <!-- <div class="wd-30p field field-modal fld-mrc">
                                  <label class="wd-100p">UPC:</label>
                                  <input class="wd-100p" type="text"  id="upc" pattern="^[0-9\-_\s]+$" maxlength="20" autocomplete="off" name="upc">
                              </div> -->
                          <!-- </div> -->

                          <div class="flds-rxl-ndc-gbc flx-justify-start mb-14_">
                                <div class="wd-20p field field-modal fld-rx-label">
                                    <label class="wd-100p trow_">Sponsor Source:</label>
                                    <input class="wd-100p trow_" type="text" 
                                    pattern="^[a-zA-Z\d\-_\s]+$" name="sponsor_source" maxlength="15">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-18p field field-modal fld-ndc">
                                    <label class="wd-100p">Sponsor Item #:</label>
                                    <input class="wd-100p"  type="text" name="sponsor_item" id="ndc"  maxlength="10" pattern="^[a-zA-Z\d\-_\s]+$">
                                </div>
                                <div class="wd-1p"></div>
                                <div class="wd-60p field field-modal fld-ndc">
                                    <label class="wd-100p">Order Web Link:</label>
                                    <input class="wd-100p" type="text"  maxlength="50"
                                     name="order_web_link" >
                                </div>
                            </div>

                          <!-- <div class="flds-sponsor flx-justify-start">

                                <div class="field field-modal fld-sponsor">
                                    <label class="wd-100p cur-pointer"><input type="checkbox" class="circled large" id="sponsored" name="sponsored_product" value="Y"><span class="txt-blue">Sponsored</span></label>
                              </div>

                          </div> -->

                        </div>
                    </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
                <div class="flx-justify-start wd-100p">
                  
                  <button id="submitOrder1" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">Unsponsored</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>

@endsection
@section('js')


@include('partials.js.drug_js')


   
    
@endsection