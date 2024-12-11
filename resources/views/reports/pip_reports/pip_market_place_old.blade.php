@extends('layouts.compliance')

@section('content')




<style>


tr.border-less-td td { border: 0px !important; }


table.parent-table td.cols_1 { width: 17%; }
table.parent-table td.cols_2 { width: 17%; }
table.parent-table td.cols_3 { width: 17%; }
table.parent-table td.cols_4 { width: 17%; }
table.parent-table td.cols_5 { width: 16%; }
table.parent-table td.cols_6 { width: 16%; }

table.parent-table th[colspan="3"].pharmacy-name { width: 51%; }
table.parent-table th[colspan="3"].rx-originating-period { width: 49%; }

table.parent-table td[colspan="3"] { width: 51%; }


table.expand-collapse-table td:nth-child(1) { width: 17%; }
table.expand-collapse-table td:nth-child(2) { width: 17%; }
table.expand-collapse-table td:nth-child(3) { width: 17%; }
table.expand-collapse-table td:nth-child(4) { width: 17%; }
table.expand-collapse-table td:nth-child(5) { width: 16%; }
table.expand-collapse-table td:nth-child(6) { width: 16%; }
tr.collapse.show { display: table-row !important; }


</style>


<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12 pl-0">
		<h4 class="elm-left fs-24_ mb-3_">Reports</h4>
		<div class="date-time elm-right lh-28_ mb-3_">Monday, January 27, 2020
			12:36 AM</div>
	</div>
</div>

<div class="row pt-17_ mb-17_">
	<div class="col-sm-8" style="flex: 1 1 0%;">
		<div class="trow_">
			<span class="txt-blue weight_700">Personal Injury</span> <span class="txt-gray-9 weight_700">MarketPlace</span> <span class="txt-gray-6 weight_700">(5)</span>
		</div>
		
		<div class="trow_">
			
			<div class="row pos-rel_ mt-17_ mb-17_">
            	<div class="col-sm-12">
            		<div class="row mb-17_ pr-14_ pl-14_">
            			<div class="col-sm-12 pl-0 pr-0 table-responsive">
            				<table class="bordered-hd-blue-shade parent-table" border="1" style="border-collapse: collapse;">
            					<tbody>
            						<tr class="weight_500-force-childs" style="background-color: #3b7ec4;">
            							<th colspan="3" class="txt-wht pharmacy-name">Pharmacy Name</th>
            							<th colspan="3" class="text-center txt-wht rx-originating-period">RX's Originating Period</th>
            						</tr>
            						<tr>
            							<td colspan="3"></td>
										@php $i = 4; @endphp
										@foreach($quarter_arr as $key=>$val)
            								<td class="cols_{{$i}} cnt-right-force weight_600">{{$val}}</td>
										@php $i++; @endphp
										@endforeach
            						</tr>
									@if($pip_data)
										@foreach($pip_data as $pkey=>$pval)
										@php $practice = explode('=', $pkey); @endphp
										<tr class="bg-white">
											<td colspan="3">
												<a href="javascript:void(0);" target-tr="#law_order_detail_{{$practice[1]}}" target-id="{{$practice[1]}}"  class="col-sap txt-blue_sh-force td_u_force">{{$practice[0]}}</a>
											</td>
											
											@php $ab = 4; @endphp
											@foreach($quarter_arr as $qval)
												@if(isset($pval[$qval]))
													<td class="cols_{{$ab}} ">
														<span class="elm-left circle-bgred-colorwht mr-4_">{{$pval[$qval]['total_number']}}</span>
														<span class="elm-right weight_600 fs-13_" style="line-height: 1.4em;">${{$pval[$qval]['total_payments']}}</span>
													</td>
												@else
													<td class="cols_{{$ab}} "></td>
												@endif

												@php $ab++; @endphp
											@endforeach
											
										</tr>
										<tr id="law_order_detail_{{$practice[1]}}" class="collapse" style=""></tr>
										@endforeach
									@endif
            						
            					</tbody>
            				</table>
            			</div>
            		</div>
            	</div>
            </div>
			
		</div>
		
	</div>









	<div class="col-sm-4" id="search_screen" style="min-width: 360px;flex-shrink: 2;flex: 1 1 auto;display:none;">


		<div class="trow_">
			<div class="text-center">
				<span class="txt-blue weight_700"><span style="color: #0009a8;">PIP</span>
					- <span id="pip_pharmacy"></span></span>
			</div>
		</div>



		<div class="trow_ mt-17_ pa-14_" style="background-color: #d9d9d9; padding: 14px 4px; ">
			<div class="trow_  mb-7_">
				<div class="">
					<label style="font-size: 10px">FROM: Miller</label> <label style="font-size: 10px">MILLER PROF&nbsp;</label> <label style="font-size: 10px">ASSOCIATES</label> <label style="font-size: 10px">(972) 861-2565&nbsp;</label> <label style="font-size: 10px">MAR 02 2020</label> <label style="font-size: 10px">13:25&nbsp;</label>
				</div>
			</div>
			<div class="trow_">
				<p class="weight_600 fs-32_ pos-rel_" style="font-size: 32px; font-weight: 600;">
					FAX <span style="font-size: 17px;position: absolute;top: 20%;left: 57px;padding-top: 3px;font-weight: 500;">PRESCRIPTION
						&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;&dash;</span>
				</p>
			</div>
			<div class="trow_ pa-7_" style="background-color: #d9d9d9;">
				<div class="trow_ mb-14_">
					<span style="color: #4b5c70; font-weight: 600;">ROBERT JONES (M)
						01-25-1975</span>
				</div>
				<div class="trow_ mb-7_">

					<div style="display: inline-block;">
						<span style="font-size: 11px; float: left; color: #939aa4; padding-left: 25px;">PROPRANOLOL&nbsp;&nbsp;&nbsp;&nbsp;80MG&nbsp;&nbsp;&nbsp;&nbsp;TAB</span>
					</div>
					<div style="display: inline;">
						<span style="font-size: 11px; float: right; color: #939aa4;">generic
							for: <span style="color: #f53d3d;">INDERAL</span>
						</span>
					</div>
				</div>
				<div class="trow_ mb-7_">
					<span style="color: #939aa4; font-size: 11px; padding-left: 30px;">QTY:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5
						REFILS</span><br> <span style="color: #939aa4; font-size: 11px; padding-left: 30px;">TAKE
						AS DIRECTED</span>
				</div>
				<div class="trow_ mb-14_">
					<span class="v-spacer-47"></span>
				</div>
				<div class="trow_ ">
					<span style="color: #939aa4; padding-left: 30px;">PAUL MILLER D.O.</span><br>
					<span style="font-weight: 600; color: #4b5c70; padding-left: 30px;">MILLER
						ASSOCIATES</span>
				</div>
			</div>
		</div>
		
		<div class="trow_  mt-17_ pa-14_">
			@include('reports.pip_reports.invoice_view') 
		</div>

	</div>
</div>
@endsection

@section('js')

<script>
	$(document).ready(function(){
		$(".col-sap").click(function(){
			var targetid = $(this).attr('target-tr');
			console.log(targetid);
			$(targetid).collapse('toggle');
		});

		 $(".collapse").on('shown.bs.collapse', function(){
			 console.log($('a[target-tr="#'+$(this).attr('id')+'"]').attr('target-id'));
			 $(this).html('<div style="text-align: center;"><img id="loading_small_img_one" src="{{asset('images/loader_trans.gif')}}" style="width: 100px;"></div>');
			 var where_to_show = this;
			$.ajax({
                url: "{{ url ('report/get_law_orders')}}",
                method: 'post',
                data:'pr_id='+$('a[target-tr="#'+$(this).attr('id')+'"]').attr('target-id'),
                success: function(result){
					console.log(where_to_show);
					$(where_to_show).html(result);
                },
                error: function(data){
                }
            });
		});
	});


	function displayInvoice(RxNumber, date, sel_row=false)

        {

            //if(date == '')

              //  $('#invoice_screen1').hide();



           // $('#invoice_screen2').hide();

          //  $('#screen2_dub').hide();



                $.ajax({

                        url: "{{ url ('report/search-rx-details')}}",

                        method: 'post',

                        data:{rx_number: RxNumber, created_at:date},

                        success: function(result){

                            if(result.orders && result.orders !== null && result.status)

                            {
								$('#search_screen').show();
                                var matchesHtml="";

                                var value = result.orders;

                                var practice = result.orders.practice;

                                var clerk = "";

                                var patients = result.orders.patient;

                                var payment_recived = result.orders.payment_recived;

                                if(practice.users[0].name !== null)

                                    clerk = practice.users[0].name;



                                $('#patient_value').html(value.name);

                                $('#clerk_id').html(clerk);

                                $('#refills_remained').html('#'+value.RefillsRemaining);

                                $('#drug_value').html(value.drug.rx_label_name);

                                $('#drug_strength').html(value.drug.Strength);

                                $('#drug_marketer').html(value.drug.marketer);
                                
                                $('#drug_ndc').html(value.drug.ndc);
                                /*/////////////Drug History//////////////*/
                                $('#rx_label_generic ').html(value.drug.rx_label_name);
                                $('#strength_value').html(value.drug.Strength);
                                $('#dosage_value').html(value.drug.dosage_form);
                                $('#quantity_value').html(value.Quantity);                                  
                                $('#OrderId').val(value.Id);

                                
                                var str='',dos_fm='';
                                if(value.drug.strength)
                                {
                                	str=value.drug.strength;
                                }
                                if(value.drug.dosage_form)
                                {
                                	dos_fm=value.drug.dosage_form;
                                }

                                $('#drugname1').html(value.drug.rx_label_name+' '+ str+' '+dos_fm);

                                $('#rx_sale').html('$ '+value.RxFinalCollect.toFixed(2));

                                $('#RxProfitability').html('$ '+value.RxProfitability.toFixed(2));

                                $('#rx_sale_1').html('$ '+value.RxPatientOutOfPocket.toFixed(2));

                                $('#rx_sale_2').html('$ '+value.RxPatientOutOfPocket.toFixed(2));

                                $('#pat_name_invo').html(value.name);





                                $('#invoice_email_add').val(value.EmailAddress);



                                //$('#PaymentSignature ').html('$ '+value.PaymentSignature.toFixed(2));



                                $('#rx_cost').html('$ '+value.RxIngredientPrice.toFixed(2));

                                $('#out_of_pocket').html('$ '+value.RxPatientOutOfPocket.toFixed(2));

                                $('#fills_count').html('('+result.fill_count+') Fills');



                                var reFillNo = "";

                                var totalCount = result.fill_count;

                                $.each(result.dates, function(index, value) {

                                    totalCount = parseInt(totalCount) - parseInt(1);

                                    if(totalCount == 0)

                                        reFillNo = "NRx";

                                    else

                                        reFillNo = "Refill #"+totalCount;

                 // background: antiquewhite;  pric_selected  '+(index%2==0?'bg-gray-2':'')+'



                                    matchesHtml += '<div class="trow_ c-dib_  p4-8_ mb-4_ bg-gray-2" id="pr_centr_'+(index+1)+'" ><div class="wd-100p" style="max-width:100px;"><a class="txt-blue-force">'+(value.simple_date).split('-').join('/')+'</a></div><div class="wd-100p" style="max-width:60px;"><a class="txt-blue-force" >'+reFillNo+'</a></div><div class="elm-right cnt-right"><a class="fa-17_ txt-grn-lt weight_600"><span onclick="displayInvoice(\''+RxNumber+'\',\''+value.full_date+'\', '+(index+1)+');" class="fa fa-eye"></span></a></div></div>';

                                });

                                $('#list_dates').html(matchesHtml);



                                //receipt

                                $('#pharmacy_name').html(practice.practice_name);
								$('#pip_pharmacy').html(practice.practice_name);


                                $('#date_created').html(getFormattedDate(value.created_at));

                                $('#time_created').html(startTime(value.created_at));

                                $('#practice_address').html(practice.practice_address);

                                $('#pharmacy_address').html(practice.practice_city+', '+practice.practice_state+' '+ practice.practice_zip);

                                $('#practice_email').html(practice.practice_website);

                                $('#practice_phone').html(practice.practice_phone_number);

                                /*$('#patient_name').html(value.name); */

                                if(patients.cardNumber!=''){

                                    $('#cardNumber_div').html(patients.cardNumber);

                                }else{ $('#cardNumber_div').html(''); }



                                if(payment_recived!=null){ $('#auth_number').html(payment_recived.auth_number); }

                                else{  $('#auth_number').html('xxxx'); }

                                $('#rx_value').html(value.RxNumber);

                                // $('#total_items').html(value.Quantity);

                                $('#patient_button').html(value.name);

                                $('#PaymentSignature').attr("src",value.signature);

                                $('#invoice_screen1').show();

                                if(value.OrderStatus==10 || value.OrderStatus==8)

                                {

                                    $('#invoice_screen2').show();

                                }else

                                {

                                    $('input#str_keyword').val(value.RxNumber);

                                    $('input#outside_link').val(value.Id);

                                    $('#screen2_dub').show();

                                }

                               if(sel_row!=false)

                               {

                                $('div#list_dates trow_').removeClass('pric_selected');

                                $('#pr_centr_'+sel_row).addClass('pric_selected');

                                }

                                var keys = '?rx_number='+value.RxNumber+'&date='+value.created_at;

                                $('#btn-send_receipt').attr("onclick", "send_invoice('rx_number="+value.RxNumber+"&date="+value.created_at+"')");

                                $("#btn-print_receipt").attr("href", '<?=url('/report/print-invoice-accounting');?>'+keys+'');
                                $("#fax_btn").attr("href", '<?=url('/report/print-fax-accounting');?>/'+value.reporter_prescription_id);



                                $("#inovice_down_btn").attr("href", '<?=url('/report/download-invoice');?>'+keys+'');

                                $("#patient_button").attr("href", '<?=url('/report/download-invoice');?>'+keys+'');

                            }else{



                            }

                        },



                        error: function(data){



                        }

                });

        }


   function getFormattedDate(date) {

    var date = new Date(date);

    var year = date.getFullYear();



    var month = (1 + date.getMonth()).toString();

    month = month.length > 1 ? month : '0' + month;



    var day = date.getDate().toString();

    day = day.length > 1 ? day : '0' + day;



    return month + '/' + day + '/' + year;

  }
    function startTime(date) {

            var today = new Date(date);

            var h = today.getHours();

            var m = today.getMinutes();

            var s = today.getSeconds();

            m = checkTime(m);

            s = checkTime(s);

        return h + ":" + m;

   }
   function checkTime(i) {

    if (i < 10) {

      i = "0" + i;

    }

    return i;

  }
</script>

@endsection