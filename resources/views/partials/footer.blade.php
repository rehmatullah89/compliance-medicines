<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="display: flex;justify-content: flex-start;">
                <ul class="ma-0_ footer-left-links">
				<li><a href="{{url('our-terms')}}">Offer Terms</a></li>
				<li><a href="{{url('privacy-policy')}}">Privacy Policy</a></li>
                </ul>
                <div class="footer-text text-right" style="min-width: 280px;margin-left: auto;">
                    <p class="ma-0_ mt-12_">&copy;2020 <a href="#" class="tt_uc_">Compliance Reward</a>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
@can('view menu profit_check')
<div class="modal" id="profit-check-Modal" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog wd-87p-max_w_700" style="
    max-width: 220px;
    background-color: transparent;
">
    <div class="modal-content compliance-form_" style="background-color: transparent;">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: transparent; border: 0px;">        
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal" style="z-index: 1000; top: -13px; right: -13px;">✖</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body" style="margin-top:-10px;padding: 0px;">
  			<div id="price-ui-wrapper" style="/* position: fixed; */top: 140px;right: -188px;width: 220px;padding-left: 32px;z-index: 99999999;" class="center">
				<div id="price-ui-details" style="position: relative;z-index: 100;">
					<div class="trow_ bg-white pos-rel_ pa-8_" style="min-height: 140px;border: solid 1px #0367ae;border-radius: 6px;padding-bottom: 32px;">
						<div class="trow_ mb-7_ pa-6_" style="border: solid 2px #3e7bc4;border-radius: 4px;padding-bottom: 2px;">
							<div class="trow_ tt_uc_ fs-14_ txt-gray-6 weight_600 cnt-left">patient co-pay</div>
							<div class="trow_ tt_uc_ ">
								<input type="text" onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());" id="pop" data-type="currency" class="wd-100p txt-blue weight_600 fs-14_ cnt-right" value="" placeholder="$0.00" style="border: 0px;">
							</div>
						</div>
						<div class="trow_ mb-7_ pa-6_" style="border: solid 2px #3e7bc4;border-radius: 4px;padding-bottom: 2px;">
							<div class="trow_ tt_uc_ fs-14_ txt-gray-6 weight_600 cnt-left">3rd PARTY PAID</div>
							<div class="trow_  "><input type="text" onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());" data-type="currency" id="tpp" class="wd-100p txt-blue weight_600 fs-14_ cnt-right" value="" placeholder="$0.00" style="border: 0px;"></div>
						</div>
						<div class="trow_ mb-7_ pa-6_" style="border: solid 2px #3e7bc4;border-radius: 4px;padding-bottom: 2px;">
							<div class="trow_ tt_uc_ fs-14_ txt-red weight_600 cnt-left">pkg ingr cost</div>
							<div class="trow_ tt_uc_ "><input type="text" id="pic" placeholder="$0.00" onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());" data-type="currency" class="wd-100p txt-red weight_600 fs-14_ cnt-right" value="" style="border: 0px;"></div>
						</div>
						<div class="trow_ mb-7_ ">
							<div class="flx-justify-start  ">
								<div class="wd-57p" style="border: solid 2px #3e7bc4;border-radius: 4px; margin-right: 2%;">
									<div class="trow_ fs-14_ txt-gray-6 weight_600 cnt-left pa-6_" style="padding-bottom: 0px;">QTY (per Unit)</div>
									<div class="trow_ tt_uc_ pa-6_" style="padding-bottom: 2px;">
									  <input type="text" id="drug_qty" data-type="quantity" placeholder="0" onblur="window.pharmacyNotification.drugMultipliaction(this.value);" class="wd-100p txt-blue weight_600 fs-14_ cnt-right" value="" style="border: 0px;">
									</div>
								</div>
								<div class="wd-43p" style="border: solid 2px #3e7bc4;border-radius: 4px;" id="pkg-div">
									<div class="trow_ fs-14_ txt-gray-6 weight_600 tt_uc_ cnt-left pa-6_" style="padding-bottom: 0px;">pkg size</div>
									<div class="trow_ tt_uc_ pa-6_" style="padding-bottom: 2px;">
									  <input type="text" maxlength="3" class="wd-100p txt-blue weight_600 fs-14_ cnt-right" onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());" value="" id="psize" style="border: 0px;">
									</div>
								</div>
							</div>
						</div>
						<div class="trow_ ">
							<div class="flx-justify-start  ">
								<div class="wd-57p" style="display: flex;align-items: flex-end;">
									<div class="wd-100p tt_uc_" style="padding-bottom: 2px;display: flex;align-items: flex-end;justify-content: center;flex-wrap: wrap;">
										<div class="wd-100p cnt-center txt-black-24 weight_600" id="rx_ing_cost">$0.00</div>
										<div class="wd-100p cnt-center txt-black-24 fs-11_ weight_600">Rx ING Cost</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="trow_ mt-7_ pos-abs_" style="bottom: 0px;left: 0px;width: 100%;">
							<div class="flx-justify-start flex-v-center  bg-blue pa-6_ txt-wht weight_600">
								<span style="margin-top: 2px;"><span id="rx_profit1">$0.00</span> Est. Rx Profit</span> 
								<span class="fs-17_ ml-auto_ elm-right fa " id="rx_profit" style=""></span>
							</div>
						</div>
					</div>
				</div>
				<div id="" style="position: absolute;top: 0px;left: 0px;background-color: #003b78;width: 100%;height: 137px;border-radius: 6px;z-index: 80;">
					<span id="expand-collapse-button" style="transform: rotate(89deg);color: #fff;font-weight: bold;position: absolute;left: -41px;top: 59px;letter-spacing: 1px; cursor: pointer;">Rx PROFIT CHECK</span>
				</div>
				
			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="display: none;">
      </div>

    </div>
  </div>
</div>
@endcan

<style>

#price-ui-wrapper.center { right: 43% !important; }


</style>
