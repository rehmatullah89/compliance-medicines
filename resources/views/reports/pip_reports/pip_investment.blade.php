@extends('layouts.compliance')

@section('content')

<style>


tr.border-less-td td { border: 0px !important; }
table.bordered-hd-blue-shade tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}
#checkout_area input{ width:100%;border:1px solid; }
label.error{ color: red;font-size: 10px;text-transform: initial !important; }

</style>


<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12 pl-0">
		<h4 class="elm-left fs-24_ mb-3_">Reports</h4>
		<div class="date-time elm-right lh-28_ mb-3_">{{ now('America/Chicago')->isoFormat('LLLL') }}</div>
	</div>
</div>

<div class="row pt-17_ mb-17_">
	<div class="col-sm-12">
		<div class="trow_">
			<span class="txt-blue weight_700">Personal Injury</span> <span class="txt-gray-9 weight_700">MarketPlace</span> <span class="txt-gray-6 weight_700">({{count($pip_data)}})</span>
		</div>
		<div class="trow_ pt-17_">
            <form class="trow_ c-dib_ compliance-form_">
                <div class="field wd-100p fld-practice-reports mr-14_" style="max-width: 200px;">
                    <label class="wd-100p">MATURITY</label>
                    <select name="maturity_date" id="maturity_date" class="wd-100p">
                        <option value="" selected>Maturity Date</option>
                        @foreach($future_quarter_arr as $fqaKey=>$fqaVal)
                        <option value="{{$fqaVal}}">{{$fqaVal}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field wd-100p fld-time period mr-14_" style="max-width: 120px;">
                    <label class="wd-100p">Interest (% APR)</label>
                    <select name="interest_apr" id="interest_apr"  class="wd-100p">
						<option selected value="">Interest %</option>
						@php $instData = 10.0;  @endphp
						@while($instData<=35.0)
                        	<option value="{{number_format($instData, 1)}}">{{number_format($instData, 1)}} %</option>
						@php $instData = ($instData + 2.5); @endphp
						@endwhile
                    </select>
                </div>
            </form>
        </div>
        <div class="trow_ pt-17_">
     		<div class="row ">
    			<div class="col-sm-8 ">
					<div class="row mb-17_ pr-14_ pl-14_">
    					<div class="col-sm-12 mb-17_ pl-0 pr-0 table-responsive">
    						<table id="statistic_area" class="bordered-hd-blue-shade" border="1" style="border-collapse: collapse;">
    							<tbody>
    								<tr class="weight_500-force-childs" style="background-color: #3b7ec4;">
    									<th colspan="3" class="txt-wht">Pharmacy Name</th>
    									<th colspan="4" class="text-center txt-wht">RX's Originating Period</th>
            						</tr>
            						<tr>
            							<td colspan="3"></td>
										@foreach($quarter_arr as $key=>$val)
            								<td class="cnt-right-force weight_600">{{$val}}</td>
										@endforeach
            						</tr>

                                                        @if($pip_data)
                                                            @php $investment_quarter = ''; @endphp
                                                            @foreach($pip_data as $pkey=>$pval)
                                                            @php $practice = explode('=', $pkey);  @endphp
                                                            <tr class="{{ $pval == reset($pip_data) ? 'bg-white' : '' }}">
                                                                <td colspan="3" class="col-sap txt-blue_sh-force">{{$practice[0]}}</td>

                                                                    @foreach($quarter_arr as $qval)
                                                                            @if(isset($pval[$qval]))	
                                                                                   @php if(floor($pval[$qval]["remaining_amount"])<=0) { $myclass = ''; } else{ $myclass = 'not_empty_val'; } @endphp
                                                                                    <td class="col-{{$qval}} {{$myclass}}" order-ids="{{$pval[$qval]["orders_ids"]}}" t-name="{{$practice[0]}}" t-quart="{{$qval}}" t-price="{{$pval[$qval]["remaining_amount"]}}" pr-id="{{$practice[1]}}">
                                                                                            <span class="elm-left circle-bgred-colorwht mr-4_">{{$pval[$qval]['total_number']}}</span>
                                                                                            <span class="elm-right weight_600 fs-13_" style="line-height: 1.4em;"> $@php if($pval[$qval]['remaining_amount']==0) { echo number_format($pval[$qval]['total_payments'], 2); } else { echo number_format($pval[$qval]['remaining_amount'],2); } @endphp </span>
                                                                                    </td>

                                                                                    @php if($pval[$qval]["remaining_amount"]>0 and $investment_quarter==''){ $investment_quarter = $qval; }  @endphp
                                                                            @else
                                                                                    <td class="col-{{$qval}}"></td>
                                                                            @endif
                                                                    @endforeach

                                                            </tr>
                                                            @endforeach
                                                    @endif

            					</tbody>
            				</table>
    					</div>
					</div>
    			</div>

                <div class="col-sm-4 mb-17_">
                	<form method="post" action="#" id="investment_form" >
            		<div class="row mb-17_" id="cart_area" style="display:none;">
                    	<div class="col-sm-12">
            				<ul class="nav nav-tabs reports-tabs" style="border: 0px;">
            					<li class="nav-item"><a  style="cursor: initial !important;" class="nav-link active" id="title_cart" data-toggle="tab" href="#q221-tab">Q2 21</a></li>
            					<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#maturity-tab">MATURITY</a></li>-->
            				</ul>
            				<div class="tab-content pos-rel_" style="">
            					<div id="q221-tab" class="container tab-pane fade in active show" style="min-width: 100%; max-width: 100%;">
            						<div class="row">
            							<div class="col-sm-12 pt-14_ pb-14_" style="border: solid 1px #dee2e6; margin-top: 0px;">
            								<table>
            									<tbody id="cart_rows">
            									</tbody>
            								</table>
            							</div>
            						</div>
            						
            					</div>
            					<div id="maturity-tab" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
            						<div class="row">
            							<div class="col-sm-12 pt-14_ pb-14_" style="border: solid 1px #dee2e6; margin-top: 0px;">
            								MATURITY CONTENT
            							</div>
            						</div>
            					</div>
            				</div>
                    	</div>
                    </div>

                
            		<div class="row mb-17_" id="checkout_area" style="display:none;" >
                    	<div class="col-sm-12">
            				<ul class="nav nav-tabs reports-tabs" style="border: 0px;">
                                            <li class="nav-item"><a class="nav-link active" style="cursor: initial !important;" data-toggle="tab" href="#checkout-tab">Checkout</a></li>
            					<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#other2nd-tab">Other 2nd Tab</a></li>-->
            				</ul>
            				<div class="tab-content pos-rel_" style="">
            					<div id="checkout-tab" class="container tab-pane fade in active show" style="min-width: 100%; max-width: 100%;">
            						<div class="row">
            							<div class="col-sm-12 pt-14_ pb-14_" style="border: solid 1px #dee2e6; margin-top: 0px;">
                                                                    <div class="trow_ mb-4_ weight_600 tt_uc_"><input type="text" required class="pa-6_ bg-f2f2f2" name="investor_name" placeholder="INVESTOR NAME" /></div>
            								<div class="trow_ mb-4_ weight_600 tt_uc_"><input type="text" required class="pa-6_ bg-f2f2f2" name="investor_address" placeholder="INVESTOR ADDRESS" /></div>
            								<div class="trow_ mb-4_">
            									<div class="flx-justify-start">
            										
                    								<div class="trow_ mb-4_ weight_600 tt_uc_ mr-2p"><input required type="text" class="pa-6_ bg-f2f2f2" placeholder="CITY" name="investor_city" /></div>
                                                                                <div class="trow_ mb-4_ weight_600 tt_uc_ cnt-center mr-2p" style="max-width:70px;"><input required placeholder="STATE" class="pa-6_ bg-f2f2f2" type="text" name="investor_state" /></div>
                    								<div class="trow_ mb-4_ weight_600 tt_uc_" style="max-width:100px;"><input required type="text" placeholder="ZIP CODE" maxlength="9" class="pa-6_ bg-f2f2f2" name="investor_zip" /></div>
            										
            									</div>
            								</div>
            								<div class="trow_ c-dib_ mt-7_">
            									<div class="wd-100p c-dib_ c-mr-7_ txt-center">
                									<div class="txt-blue-dk-7j elm-left tt_uc_ weight_600">maturity:</div>
                									<div class="txt-red tt_uc_ elm-left weight_600" id="maturity_shw_chkout">q221</div>
                									<div class="txt-grn-dk tt_uc_ weight_600 " id="invest_apr_shw_chkout">30%</div>
                									<div class="txt-grn-dk tt_uc_ weight_500 ">apr</div>
                									<div class="c-dib_ txt-sline elm-right">
														<!-- <div class="txt-gray-9a mr-7_ tt_uc_ weight_300">coupon</div> -->
														<div class="txt-black-24 elm-right weight_600" id="total_investment_amount"></div>
													</div>
                									
                								</div>
            								</div>
            								
            								<div class="trow_ c-dib_ mt-14_">
                								<div class="flx-justify-start wd-100p">
                                            		<button type="reset" onclick="cancel_form();" class="btn bg-red-txt-wht weight_500 tt_uc_ fs-14_">cancel</button>
                                            		<button type="button" onclick="submit_investment();" class="btn bg-blue-txt-wht weight_500 tt_uc_ fs-14_" style="margin-left: auto;">reserve now</button>
                                            	</div>
            								</div>
            							</div>
            						</div>
            					</div>
            					<!--<div id="other2nd-tab" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
            						<div class="row">
            							<div class="col-sm-12 pt-14_ pb-14_" style="border: solid 1px #dee2e6; margin-top: 0px;">
            								OTHER SECOND TAB CONTENT
            							</div>
            						</div>
            					</div>-->
            				</div>
                    	</div>
                    </div>


					</form>

            	</div>
    		</div>
        </div>
	</div>
</div>

 @endsection

@section('js')

<script>
	//window.investment_quarter = 'Q2-2020';
	window.investment_quarter = '{{$investment_quarter}}';
	$(document).ready(function(){
		
		$('#maturity_date').change(function(){
			if($(this).val()!="")
			{ $('#cart_area').show(); $('#title_cart').html($(this).val()); }
			else{ $('#cart_area').hide(); $("#checkout_area").hide(); $('#interest_apr').val('').trigger('change');  }

			$('#maturity_shw_chkout').html($('#maturity_date').val());
		});

		$('#interest_apr').change(function(){
			var first_none_mature = window.investment_quarter;
			console.log(first_none_mature);
			if($(this).val()!="")
			{
				if($('input[type="checkbox"]').parents('td.col-'+first_none_mature).length==0)
				{ 
                                  //  var abcdef = $('td.not_empty_val.col-'+first_none_mature).attr('t-price');
                                   // if(Math.floor(abcdef)<=0){ var disableed = 'disabled'; }else{ var disableed = ''; }
                                    $('td.not_empty_val.col-'+first_none_mature).prepend('<input type="checkbox" onclick="onclickCK(this);" class="elm-right selectInv ml-4_" />');
				}
				//$('td.not_empty_val:not(.col-'+first_none_mature+")").children().hide();
			}else
			{
				$('td.not_empty_val').children('input[type="checkbox"]').remove();
				$('td.not_empty_val').children().show();
				$('#cart_rows').html('');
			}

			$('#invest_apr_shw_chkout').html($('#interest_apr').val()+' %');
		});

		
	});

	function percentage_select(practice_id_law, quarter, elem)
	{
                var value_per = $(elem).val();
		console.log(value_per);
                if (value_per < 0) { 
                    value_per = value_per * -1; 
                    $(elem).val(value_per);
                    
                } 
                if (value_per > 100) { 
                    $(elem).val(100);                    
                } 
		var need_to_invest = $('td[t-quart="'+quarter+'"][pr-id="'+practice_id_law+'"]').attr('t-price');
		var invest_amount = ((parseFloat(need_to_invest.replace(/\,/g,''))/100)*value_per);

		$('#amount_show_'+practice_id_law+'_'+quarter).html('$'+formatMoney(invest_amount));
                
		$('#ia_'+practice_id_law+'_'+quarter).val(invest_amount.toFixed(2));
		$('#ip_'+practice_id_law+'_'+quarter).val(value_per);
		update_total_amount();
	}

	function onclickCK(inputC)
	{
		var parTD = $(inputC).parents('td');
		if($(inputC).is(':checked'))
		{		
			var percentage_applied = 10;
			var quartdsf = "'"+$(parTD).attr('t-quart')+"'";
			var invest_amount = ((parseFloat($(parTD).attr('t-price').replace(/\,/g,''))/100)*percentage_applied).toFixed(2);	
			$('#cart_rows').append('<tr class="bg-white" id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'">'+
            							'<td class="txt-blue_sh-force td_u_force">'+$(parTD).attr('t-name')+'</td>'+
											'<td class="txt-red">'+
												'<input type="number" min="1" max="100" onchange="percentage_select('+$(parTD).attr('pr-id')+', '+quartdsf+', this)" style="width:50px;" value="10" class="txt-red weight_500">%'+
											'</td>'+
											'<td class="txt-black-24 weight_600 invest-amount" id="amount_show_'+$(parTD).attr('pr-id')+'_'+$(parTD).attr('t-quart')+'">$'+formatMoney(invest_amount)+'</td>'+
											'<td class=""><span onclick="delete_row(this);" class="fa fa-trash-o txt-red weight_400 fs-21_ opct-87_1 cur-pointer"></span></td>'+
										'</tr>');
			//console.log();
			//---------------------add form -----------------------------
			var tr_count = $('#cart_rows > tr').length;
			$('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').append('<input type="hidden" name="investment_detail['+tr_count+'][practice_id_law]" value="'+$(parTD).attr('pr-id')+'" />');
                        $('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').append('<input type="hidden" name="investment_detail['+tr_count+'][order_ids]" value="'+$(parTD).attr('order-ids')+'" />');
			$('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').append('<input type="hidden" id="ia_'+$(parTD).attr('pr-id')+'_'+$(parTD).attr('t-quart')+'" name="investment_detail['+tr_count+'][amount_invest]" value="'+(invest_amount.replace(/\,/g,''))+'" />');
			$('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').append('<input type="hidden"  name="investment_detail['+tr_count+'][total_amount_practice]" value="'+parseFloat($(parTD).attr('t-price')).toFixed(2)+'" />');
			$('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').append('<input type="hidden" id="ip_'+$(parTD).attr('pr-id')+'_'+$(parTD).attr('t-quart')+'" name="investment_detail['+tr_count+'][percentage_paid]" value="'+percentage_applied+'" />');

			//--------------------end add form --------------------------
		}else
		{
			console.log($('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]'));
			if($('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').length>0)
			{
				$('tr[id="'+$(parTD).attr('pr-id')+'='+$(parTD).attr('t-quart')+'"]').remove();
			}
			console.log('not');
		}
		
		//----------check if cart empty or not -------------
			if($('#cart_rows > tr').length>0)
			{ $("#checkout_area").show(); }
			else{ $("#checkout_area").hide(); }

			update_total_amount();
 
		
	}

	function delete_row(Dthis)
	{
		var parentD = $(Dthis).parents('tr');
		var parAttr = $(parentD).attr('id').split('=');
		$('td[pr-id="'+parAttr[0]+'"][t-quart="'+parAttr[1]+'"] > input[type="checkbox"]').prop('checked', false);
		$(parentD).remove();
		update_total_amount();
	}

	function update_total_amount()
	{
		var total_amount = 0.00;
		$('td.invest-amount').each(function(key, val){
			var MyVal = $(val).html().replace('$', '');
			total_amount = (parseFloat(total_amount) + parseFloat(MyVal.replace(/\,/g,'')));
		});
                 
		$('#total_investment_amount').html('$'+formatMoney(total_amount));
	}


	function submit_investment()
	{
            if(!$("#investment_form").valid())
            { return false; }
		//console.log($('#investment_form').serialize());
		var formData = $('#investment_form').serialize();
			formData =  formData+'&investment_on_quarter='+window.investment_quarter;
			formData =  formData+'&maturity_quarter='+$('#maturity_date').val();
			formData =  formData+'&interest_apr='+$('#interest_apr').val();
			formData =  formData+'&total_invest_amount='+parseFloat($('#total_investment_amount').html().replace(/\,/g,'').replace('$', '')); 

		$.ajax({
				url: "{{ url ('report/submit_investment')}}",
				method: 'post',
				data:formData,
				success: function(result){
					result = JSON.parse(result);
					if(result.status==1)
					{
						$('#cart_rows').append('<tr><td colspan="4"><h3 style="color:red;text-align: center;font-size: 20px;margin-top:30px;">'+$('#total_investment_amount').html()+' PLACED</td></h3></tr>');
						$('#cart_rows').append('<tr><td colspan="4"><h3 style="color:red;text-align: center;font-size: 20px;">'+$('input[name="investor_name"]').val()+'</td></h3></tr>');
						 $("#checkout_area").hide(); 
						
						setTimeout(function(){ 
							 $("#checkout_area > input").val('');
							 $('#cart_rows').html('');
							 $('#interest_apr').val('').trigger('change'); 
							 $('#maturity_date').val('').trigger('change')
							location.reload();
							}, 9999);

						
					}
					else
					{
						alert(result.message);
					}
				},
				error: function(data){

				}
			});
	}

	function cancel_form()
	{
		$('#checkout_area > input').val('');
	}
        
        function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
            try {
              decimalCount = Math.abs(decimalCount);
              decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

              const negativeSign = amount < 0 ? "-" : "";

              let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
              let j = (i.length > 3) ? i.length % 3 : 0;

              return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
            } catch (e) {
              console.log(e)
            }
          }

</script>

@endsection