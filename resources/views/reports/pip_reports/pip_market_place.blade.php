@extends('layouts.compliance')

@section('content')




<style>


tr.border-less-td td { border: 0px !important; }


table.parent-table td.col-1 { width: 16%; }
table.parent-table td.col-2 { width: 16%; }
table.parent-table td.col-3 { width: 16%; }
table.parent-table td.col-4 { width: 13%; }
table.parent-table td.col-5 { width: 13%; }
table.parent-table td.col-6 { width: 13%; }
table.parent-table td.col-7 { width: 13%; }
table.parent-table th[colspan="4"] { width: 51%; }
table.parent-table td[colspan="4"] { width: 51%; }

table.expand-collapse-table td:nth-child(1) { width: 16%; }
table.expand-collapse-table td:nth-child(2) { width: 16%; }
table.expand-collapse-table td:nth-child(3) { width: 16%; }
table.expand-collapse-table td:nth-child(4) { width: 13%; }
table.expand-collapse-table td:nth-child(5) { width: 13%; }
table.expand-collapse-table td:nth-child(6) { width: 13%; }
table.expand-collapse-table td:nth-child(7) { width: 13%; }
tr.collapse.show { display: table-row !important; }


</style>


<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12 pl-0">
		<h4 class="elm-left fs-24_ mb-3_">Reports</h4>
		<div class="date-time elm-right lh-28_ mb-3_">{{ now('America/Chicago')->isoFormat('LLLL') }}</div>
	</div>
</div>

<div class="row pt-17_ mb-17_">
	<div class="col-sm-8" style="flex: 1 1 0%;">
		<div class="trow_">
			<span class="txt-blue weight_700">Personal Injury</span> <span class="txt-gray-9 weight_700">MarketPlace</span> <span class="txt-gray-6 weight_700">({{count($pip_data)}})</span>
		</div>
		
		<div class="trow_">
			
			<div class="row pos-rel_ mt-17_ mb-17_">
            	<div class="col-sm-12">
            		<div class="row mb-17_ pr-14_ pl-14_">
            			<div class="col-sm-12 pl-0 pr-0 table-responsive">
            				<table class="bordered-hd-blue-shade parent-table" border="1" style="border-collapse: collapse;">
            					<tbody>
            						<tr class="weight_500-force-childs" style="background-color: #3b7ec4;">
            							<th colspan="3" class="txt-wht">Pharmacy Name</th>
            							<th colspan="4" class="text-center txt-wht">RX's Originating Period</th>
            						</tr>
            						<tr>
            							<td colspan="3"></td>
										@php $i = 4; @endphp
										@foreach($quarter_arr as $key=>$val)
            								<td class="col-{{$i}} cnt-right-force weight_600">{{$val}}</td>
										@php $i++; @endphp
										@endforeach
            						</tr>
									@if($pip_data)
										@foreach($pip_data as $pkey=>$pval)
										@php $practice = explode('=', $pkey); @endphp
										<tr class="bg-white">
											<td colspan="3" id="for-loading-{{$practice[1]}}">
												<a href="javascript:void(0);" target-tr="#law_order_detail_{{$practice[1]}}" target-id="{{$practice[1]}}"  class="col-sap txt-blue_sh-force td_u_force">{{$practice[0]}}</a>
											</td>
											
											@php $ab = 4; @endphp
											@foreach($quarter_arr as $qval)
												@if(isset($pval[$qval]))
													<td class="col-{{$ab}} ">
														<span class="elm-left circle-bgred-colorwht mr-4_">{{$pval[$qval]['total_number']}}</span>
														<span class="elm-right weight_600 fs-13_" style="line-height: 1.4em;">${{number_format($pval[$qval]['total_payments'], 2)}}</span>
													</td>
												@else
													<td class="col-{{$ab}} "></td>
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









	<div class="col-sm-4" id="search_screen" style="min-width: 420px !important;flex-shrink: 2;flex: 1 1 auto;display:none;">


		<div class="trow_">
			<div class="text-center">
				<span class="txt-blue weight_700"><span style="color: #0009a8;">PIP</span>
					- <span id="pip_pharmacy"></span></span>
			</div>
		</div>



		<div class="trow_ mt-17_ pa-14_" style="background-color: #d9d9d9; padding: 14px 4px;padding-left:10px;padding-right:10px; " id="fax_view_invoice">			
		</div>
		
		<div class="trow_  mt-17_ pa-14_" style="padding: 14px 0px;">
			@include('reports.pip_reports.invoice_view') 
		</div>

	</div>
</div>

<div class="modal" id="pat_prescription_modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
          <h4 class="modal-title" style="color:#fff;">Send Prescription Email</h4>
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">X</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">

            <div class="wd-100p flx-justify-start" style="background-color: #fff;">
                    <label class="mr-7_" style="min-width: 30px;line-height: 36px;margin-bottom: 0px;">To:</label>
                    <div class=" input-group c-dib_" style="padding: 2px; border-radius: 6px; background-color: #fff; border: solid 1px #afbcc2; ">
                        <input type="text" value="" class="wd-100p form-control fs-16_" style="line-height: 1.2em !important; height: 30px; border: 0px; padding-left: 6px;" required id="prescription_email_add" name="prescription_email_add">
                        
                    </div>
                </div>
              <label id="email_error_prescription_title" class="error" style="margin-left: 40px;margin-top: 5px;color: red;"></label>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal">Cancel</button>
            <img id="loading_small_prescription" src="{{ url('images/small_loading.gif') }}" style="width: 30px;display: none;margin-left: auto;">
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ " style="margin-left: auto;" id="btn-send_prescription">Send Prescription</button>
          </div>
      </div>

    </form>
  </div>
</div>

@endsection

@section('js')

<script>
	$(document).ready(function(){
		$(".col-sap").click(function(){
			var targetid = $(this).attr('target-tr');
			$(targetid).collapse('toggle');
		});
        
        $(".collapse").on('show.bs.collapse', function(){
             var pr_id = $('a[target-tr="#'+$(this).attr('id')+'"]').attr('target-id');   
             $('#for-loading-'+pr_id).append('<img id="loading_small_img_one" src="{{asset('images/loader_trans.gif')}}" style="width: 24px;margin: -10px 0 -10px 10px;">');
        });


		 $(".collapse").on('shown.bs.collapse', function(){
             var pr_id = $('a[target-tr="#'+$(this).attr('id')+'"]').attr('target-id');            
			
			 var where_to_show = this;
			$.ajax({
                url: "{{ url ('report/get_law_orders')}}",
                method: 'post',
                data:'pr_id='+pr_id,
                success: function(result){
                    
                    $('#loading_small_img_one').remove();
		$(where_to_show).html(result);
                },
                error: function(data){
                    $('#loading_small_img_one').remove();
                }
            });
		});
	});


    function get_fax_invoice(id)
    {
        $.ajax({
                url: "{{ url('report/get_fax_view')}}",
                method: 'post',
                data:'order_id='+id,
                success: function(result){                    
                    $('#fax_view_invoice').html(result);
                    $("#fax_phone_no").html(($("#fax_phone_no").html().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3")));
                    $('#fax_view_invoice').show();
                },
                error: function(data){
                    $('#fax_view_invoice').html('<h3>Prescription not available</h3>');
                    $('#fax_view_invoice').show();
                }
            });
    }

	function displayInvoice(RxNumber, date, sel_row=false)
        { 
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
            // console.log(value);
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
            $('#RefillCount').html(value.RefillCount); 
            $('#rx_label_name').html(value.drug.rx_label_name);   
            $('#Strength').html(value.Strength); 
            $('#Pharmacy').html(value.practice.practice_name);
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
            $('#rx_sale_1').html('$ '+value.RxFinalCollect.toFixed(2));
            $('#rx_sale_2').html('$ '+value.RxFinalCollect.toFixed(2));
            $('#pat_name_invo').html(value.name);
            $('#invoice_email_add').val(value.EmailAddress);
            $('#prescription_email_add').val(value.EmailAddress);
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
            $('#btn-send_prescription').attr("onclick", "send_prescription('order_id="+value.Id+"')");
            
            $("#btn-print_receipt").attr("href", '<?=url('/report/pip_invoice_print');?>'+keys+'');
            $("#fax_btn").attr("href", '<?=url('/report/print-fax-accounting');?>/'+value.reporter_prescription_id);
            $("#inovice_down_btn").attr("href", '<?=url('/report/pip_invoice_download');?>'+keys+'');
            $("#patient_button").attr("href", '<?=url('/report/download-invoice');?>'+keys+'');
            $('#invoice_screen2').show();
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

    //var myMonth = date.getFullMonth();
    

    var month = (1 + date.getMonth()).toString();

    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];
    
    month = month.length > 1 ? month : '0' + month;



    var day = date.getDate().toString();

    day = day.length > 1 ? day : '0' + day;



    //return month + '/' + day + '/' + year;
    
    return monthNames[date.getMonth()]+' '+day+' '+year;

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
  
  
  function delete_invoice()
  {
      $('#invoice_screen2').hide();
      if($('#invoice_screen2').css('display')=='none' && $('#fax_view_invoice').css('display')=='none' )
      {
            $('#search_screen').hide();
      }
      
  }
  
  function delete_faxview()
  {
      $('#fax_view_invoice').html('');
      $('#fax_view_invoice').hide();
      if($('#invoice_screen2').css('display')=='none' && $('#fax_view_invoice').css('display')=='none' )
      {
            $('#search_screen').hide();
      }
  }
  
function PrintElem()
{
    $('#form_fax_view_print').submit();
}

function send_invoice(formData)

{



    if($('#invoice_email_add').val()=='')

    {

        $('#email_error_invoice_title').html('This field is required.').show();

    }

    if(IsEmail($('#invoice_email_add').val())==false)

    {

        $('#email_error_invoice_title').html('Invalid email format.').show();

    }

    else

    {

        $('#btn-send_receipt').prop(':disabled', true);

        $('#email_error_invoice_title').hide();

        $('#loading_small_inovice').show();

     $.ajax({

                url: "{{ url ('report/email-invoice-pip')}}",

                method: 'post',

                data:formData+'&email_to='+$('#invoice_email_add').val(),

                success: function(result){



                    if(result.this.statuscode==1)

                    {

                        $('#loading_small_inovice').hide();

                        $('#btn-send_receipt').attr("onclick", "toastr.error('Message', 'Already sent email.');");

                        $('#pat_invoice_modal').modal('hide');

                        toastr.success('Message', result.this.statusdesc);

                    }else{

                        toastr.error('Message', result.this.statusdesc);

                    }

                },



                error: function(data){



                }

            });

        }

}

function send_prescription(formData)

{



    if($('#prescription_email_add').val()=='')

    {

        $('#email_error_prescription_title').html('This field is required.').show();

    }

    if(IsEmail($('#prescription_email_add').val())==false)

    {

        $('#email_error_prescription_title').html('Invalid email format.').show();

    }

    else

    {

        $('#btn-send_receipt').prop(':disabled', true);

        $('#email_error_prescription_title').hide();

        $('#loading_small_prescription').show();

     $.ajax({

                url: "{{ url ('report/email_prescription')}}",

                method: 'post',

                data:formData+'&email_to='+$('#prescription_email_add').val(),

                success: function(result){



                    if(result.this.statuscode==1)

                    {

                        $('#loading_small_prescription').hide();


                        $('#pat_prescription_modal').modal('hide');

                        toastr.success('Message', result.this.statusdesc);

                    }else{

                        toastr.error('Message', result.this.statusdesc);

                    }

                },



                error: function(data){



                }

            });

        }

}

function IsEmail(email) {

  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if(!regex.test(email)) {

    return false;

  }else{

    return true;

  }

}
</script>

@endsection