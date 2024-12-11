@extends('layouts.compliance') @section('content')



<style>

table#counting_report_table th.pharmacy-sales-captured {

	width: 100px !important;

}



table#counting_report_table th.pharmacy-profit-captured {

	width: 100px !important;

}



table#counting_report_table th.base-engagement-fee {

	width: 100px !important;

}
table#counting_report_table th.pharmacy-reward-auth {

	width: 90px !important;

}
table#counting_report_table th.invoice-date {

	width: 90px !important;

}
table#counting_report_table th.invoice-number {

	width: 90px !important;

}

</style>







<div class="row" style="border-bottom: solid 1px #cecece;">

	<div class="col-sm-12 pl-0 page-heading-row">

		<h4 class="elm-left fs-24_ mb-4_">Accounting</h4>

		<div class="date-time elm-right lh-28_ mb-3_">{{

			now('America/Chicago')->isoFormat('LLLL') }}</div>

	</div>

</div>



<div class="row pt-17_ mb-17_">



	<div class="col-sm-12 pos-rel_">

		  <form class="flx-justify-start" action="{{ url('report/accounting') }}" method="post" >



			<div class="wd-25p mr-7_ srx-field-row">

        		<div class="wd-100p flx-justify-start">

        			<label class="mr-7_"

        				style="min-width: 72px; line-height: 36px; margin-bottom: 0px;">Search Rx #</label>

        			<div class=" input-group c-dib_"

        				style="padding: 2px; border-radius: 6px; background-color: #fff; border: solid 1px #afbcc2;">

        				<input type="text" class="wd-100p form-control fs-16_"

        					name="rx_number" id="rx_field"

        					style="line-height: 1.2em !important; height: 30px; border: 0px; padding-left: 6px;"

        					placeholder="" data-provide="typeahead" autocomplete="off" maxlength="12">

        				<div class="input-group-append"

        					style="background-color: #fff; color: #fff !important; margin: 0px; border-radius: 0px 13px 13px 0px;">

        					<button type="button" id="search_report_btn"

        						class="btn bg-blue-txt-wht"

        						style="border-radius: 6px; width: 32px; text-align: center; height: 30px; padding: 0px;">

        						<i class="fa fa-search fs-16_ " style="line-height: 24px;"></i>

        					</button>

        					<img id="loading_small" src="{{ url('images/small_loading.gif') }}" style="width: 30px; display: none;">

        				</div>

        			</div>

        			<button type="button" id="back_button"

        				class="btn bg-blue-txt-wht weight_600 ml-14_ fs-14_"

        				data-toggle="modal" data-target="#drug-Add-Modal"

        				style="line-height: 20px; padding: .1rem .75rem; min-width: 70px; display: none;">&#10094;Back</button>



        		</div>

        	</div>



        	<div class="wd-25p mr-7_ srx-field-row datepicker-area">

        		{{ csrf_field() }}

        		<div class="wd-100p flx-justify-start" style="background-color: #fff;">

        			<label class="mr-7_"

        				style="min-width: 75px; line-height: 36px; margin-bottom: 0px;">Invoice Date :</label>

        			<div class=" input-group c-dib_ bh-white pos-rel_"

        				style="padding: 2px; border-radius: 6px; background-color: #fff; border: solid 1px #afbcc2;">

        				<input type="text" class="wd-100p form-control fs-16_"

        					style="line-height: 1.2em !important; height: 30px; border: 0px; padding-left: 6px; padding-right: 24px; background-color: transparent; z-index: 100;"

        					placeholder="" data-provide="typeahead" required autocomplete="off"

        					value="{{ $table_dates['invoice_date'] }}" id="invoice_date"

        					name="invoice_date">

        				<span class="fa fa-calendar pos-abs_" style="right: 7px; top: 10px; z-index: 40;"></span>

        			</div>

        		</div>

        	</div>



        	{{--

        	<div class="wd-30p mr-7_ srx-field-row datepicker-area">

        		<div class="wd-100p flx-justify-start" style="background-color: #fff;">

        			<label class="mr-7_"

        				style="min-width: 60px; line-height: 36px; margin-bottom: 0px;">To Date</label>

        			<div class=" input-group c-dib_"

        				style="padding: 2px; border-radius: 6px; background-color: #fff; border: solid 1px #afbcc2;">

        				<input type="text" class="wd-100p form-control fs-16_"

        					style="line-height: 1.2em !important; height: 30px; border: 0px; padding-left: 6px;"

        					placeholder="" data-provide="typeahead" required autocomplete="off"

        					value="{{ $table_dates['end_date'] }}" id="datepicker_to"

        					name="to_date"> <span class="fa fa-calendar"

        					style="position: absolute; right: 7px; top: 10px; z-index: 40;"></span>

        			</div>

        		</div>

        	</div>

        	--}}



        	<div class="wd-20p srx-field-row datepicker-area">

        		<div class="wd-11p field-buttons"

        			style="min-width: 170px; display: flex; align-items: flex-end; background-color: white; justify-content: flex-start;">

        			@if(Request::has('invoice_date'))

        			<button type="reset" onclick="window.location='{{ url("

        				report/accounting") }}';" class="btn bg-red-txt-wht btn-clear_ mb-10_"

        				style="height: 36px; border-radius: 0px; margin-left: 7px;">Clear</button>

        			@endif

        			<button type="submit" onclick="submit_date_form();"

        				class="btn bg-blue-txt-wht btn-search_ mb-10_"

        				style="height: 36px; border-radius: 0px; margin-left: 7px;">Search</button>

        		</div>

        	</div>





		</form>



		<div class="pos-abs_" id="stat_icons" style="top: 0px; right: 14px;">

    		<form action="{{ url('accounting/export') }}" method="post"

    			style="float: right">

    			{{ csrf_field() }} <input type="hidden" name="invoice_date"

    				value="{{ request()->get('invoice_date') }}" /> <input type="hidden"

    				name="export_by" value="pdf" />



    			<button title="Export this report" type="submit" class="btn clean_">

    				<span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span>

    			</button>

    		</form>

    	</div>



	</div>























</div>



<div id="main_screen" class="row pos-rel_ mb-17_"

	style="padding-left: 284px; min-height: 400px;">

	<div class="pos-abs_"

		style="position: absolute; top: 0px; left: 14px; width: 270px;">

		<div class="trow_ bg-gray-2 pa-14_">

			<div class="trow_ tt_uc_ weight_600 txt-black-24 fs-17_ mb-7_">all

				invoice summary</div>

			<div class="trow_"

				style="border-top: solid 1px #b6b6b6; border-bottom: solid 1px #b6b6b6; padding: 5px 0px;">

				<div class="elm-left tt_uc_ txt-gray-6 wd-49p cnt-right">period

					beginning</div>

				<div class="elm-right txt-gray-6 cnt-right">{{

					$table_dates['start_date'] }}</div>

			</div>

			<div class="trow_ mb-17_"

				style="border-bottom: solid 1px #b6b6b6; padding: 5px 0px;">

				<div class="elm-left tt_uc_ txt-orange3 wd-49p cnt-right">end</div>

				<div class="elm-right txt-orange3 cnt-right">{{

					$table_dates['end_date'] }}</div>

			</div>

			<div class="trow_ pa-14_ bg-white" style="border: solid 1px #b6b6b6;">

				<div class="trow_ mb-14_">

					<div class="elm-left tt_uc_ txt-grn-lt  wd-45p cnt-right">{{$unique_clients}}</div>

					<div class="elm-right txt-grn-lt wd-52p cnt-left">Clients</div>

				</div>

				<div class="trow_ mb-7_">

					<div

						class="elm-left tt_uc_ txt-black-24 weight_600  wd-45p cnt-right">{{$total_transactions}}</div>

					<div class="elm-right txt-black-24 wd-52p cnt-left">Transactions</div>

				</div>

				<div class="trow_ mb-7_">

					<div

						class="elm-left tt_uc_ txt-black-24 weight_500  wd-45p cnt-right">

						{{$total_sum_sale}}</div>

					<div class="elm-right txt-black-24 wd-52p cnt-left">Rx Sales

						Facilitated</div>

				</div>

				<div class="trow_ mb-14_">

					<div

						class="elm-left tt_uc_ txt-black-24 weight_500  wd-45p cnt-right"

						id="reward_authorized__">{{$total_sum_authrewd}}</div>

					<div class="elm-right txt-black-24 wd-52p cnt-left">Rewards

						Authorized</div>

				</div>

				<div class="trow_ ">

					<div

						class="elm-left tt_uc_ txt-grn-lt weight_600  wd-45p cnt-right"

						style="border: solid 1px #242424; padding: 4px; position: relative; right: -4px; top: -4px;"

						id="service_fee__">{{$total_sum_system_fee}}</div>

					<div class="elm-right txt-grn-lt wd-52p cnt-left weight_600">Service

						Fees</div>

				</div>

				<div class="trow_ mb-4_">

					<div

						class="elm-left tt_uc_ txt-black-24 weight_600  wd-45p cnt-right"

						style="border: solid 1px #242424; padding: 4px; position: relative; right: -4px; top: -5px;">{{$total_sum_system_fee}}</div>

					<div class="elm-right txt-black-24 wd-52p weight_600 cnt-left">ALL

						Current Due</div>

				</div>

			</div>

		</div>

	</div>

	<div class="col-sm-12">

		<div class="row mb-17_ pr-14_ pl-14_">

			<div class="col-sm-12 pl-0 pr-0 table-responsive"

				style="padding-bottom: 4px;">



				<div class="col-sm-12 " id="invoice_detail_table"

					style="display: none;">

					<div class="row notification-row-parent mb-24_">

						<div class="col-sm-12 min-w-640 pl-0">

							<div class="compliance-notification-row">

								<div class="nt-close" id="nt-close">&#10008;</div>

								<table class="compliance-notification-table">

									<thead>

										<th>RX#</th>

										<th>PATIENT NAME</th>

										<th>DOB</th>

										<th>SEX</th>

										<th>CLIENT</th>

										<th>CLIENT USER</th>

										<th>INS TYPE</th>

									</thead>

									<tbody>

										<td id="pt_rx_no">HW-30785</td>

										<td id="pt_name">Janelle Roth</td>

										<td id="pt_dob">5/15/1971</td>

										<td id="pt_sex">F</td>

										<td id="pt_pharmacy">OLYMPUS PHARMACY</td>

										<td id="pt_client">MARK SIMPSON</td>

										<td id="pt_ins_type">COMMERCIAL</td>

									</tbody>

								</table>

							</div>

						</div>

					</div>

				</div>



				<table id="counting_report_table"

					class="table reports-bordered compliance-user-table data-table mb-4_"

					style="margin-bottom: 2px; min-width: 1000px;">

					<thead>

						<tr>

							<th class="bg-blue txt-wht invoice-date"

								style="white-space: nowrap; width: 80px !important;">Invoice

								Date</th>

							<th class="bg-orage txt-wht cnt-center invoice-number"

								style="width: 105px !important;">Invoice Number</th>

                                                        @if(!Session::has('practice') AND !isset(auth::user()->practice_id))

							<th class="bg-gr-bl-dk txt-wht" style="min-width: 70px;">Practice

								Name</th> @endif

							<!-- <th class="bg-gray-1 txt-wht" style="min-width: 70px;">Practice

								Type</th> -->

							<th class="bg-gray-80 txt-wht" style="width: 50px;">Rx

								Facilitated</th>

							<th class="bg-gray-1 txt-wht pharmacy-sales-captured">Phmcy Sales

								Captured</th>

							<th class="bg-grn-lk txt-wht pharmacy-profit-captured">Phmcy

								Profit Captured</th>

							<th class="bg-red-dk txt-wht pharmacy-reward-auth"

								style="white-space: nowrap; width: 50px !important;">Reward

								Auth.</th> @if(!Session::has('practice') AND

							!isset(auth::user()->practice_id))

							<th class="bg-gray-1 txt-wht base-engagement-fee">Base Engagement

								Fee</th>

							<th class="bg-blue txt-wht"

								style="white-space: nowrap; width: 50px !important;">CRwd Profit

								Share</th>

							<th class="bg-blue txt-wht"

								style="white-space: nowrap; width: 50px !important;">CRwd Service Fee</th>

								@endif

							<th class="bg-gray-1 txt-wht"

								style="white-space: nowrap; width: 50px !important;">Payment System Fee</th>

						</tr>

					</thead>

					<tbody>

						@if(isset($new_query_data)) @foreach($new_query_data as

						$keyRes=>$valRes)

						<tr>

							<td class="bg-tb-blue-lt2 txt-black-24">{{$valRes->invoice_date}}</td>

							<td class="bg-tb-orange-lt txt-orange tt_uc_ cnt-right"

								style="white-space: nowrap;"><span style="cursor: pointer;"

								class=" zero_slashes">{{$valRes->invoice_number}}</span></td>

                                                                @if(!Session::has('practice') AND !isset(auth::user()->practice_id))

							<td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->practice_name}}</td>

                                                        @endif

							<!-- <td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->practice_type}}</td> -->

							<td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->Rx_facilitated}}</td>

							<td class="bg-tb-wht-shade2 txt-black-24 cnt-right">

								{{$valRes->total_sale}}</td>

							<td class="bg-tb-wht-shade2 txt-black-24 cnt-right">

								{{$valRes->rx_profitability}}</td>

							<td class="bg-tb-pink2 txt-black-24 cnt-right">

								{{$valRes->rewardAuth}}</td>

                                                        @if(!Session::has('practice') AND !isset(auth::user()->practice_id))

							<td class="bg-tb-wht-shade2 txt-black-24 cnt-right">

								{{$valRes->base_fee}}</td>

							<td class="bg-tb-wht-shade2 txt-black-24 cnt-right">

								{{$valRes->profit_share}}</td>

							<td class="bg-tb-wht-shade2 txt-black-24 cnt-right">

								{{$valRes->cr_service_fee}}</td> @endif

							<td class="bg-tb-wht-shade2 txt-black-24 cnt-right">{{$valRes->system_fee}}</td>

						</tr>

						@endforeach @else

						<tr>

							<td style="text-align: center;" colspan="{{ $count_field }}">No

								Record Found</td>

						</tr>

						@endif

					</tbody>

					<tfoot>

						@if(!Session::has('practice') AND !isset(auth::user()->practice_id))

						<tr>

							<th colspan="3" style="text-align: right"></th>

							<th style="text-align: left; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>

							<th style="text-align: right; font-weight: bold;"></th>



						</tr>

						<tr>

							<th colspan="10" style="text-align: right"></th>

							<th style="text-align: right; color: red; font-weight: bold;"

								id="all_total"></th>

						</tr>

						@else

						<tr>

							<th colspan="7">&nbsp;</th>

						</tr>

						<tr>

							<th colspan="5" style="text-align: right; color: red;">CREDIT

								APPLIED FROM VEGA WALLET REWARDS AUTHORIZED</th>

							<th style="text-align: right; color: red; font-weight: bold;"

								id="rewar_auth_total">{{ $total_sum_authrewd }}</th>
							<th></th>

						</tr>

						<tr>

							<th colspan="6" style="text-align: right;color: #5070a8;">AMOUNT DUE TO COMPLIANCE REWARD THIS PERIOD</th>

							<!-- <th style="text-align: right; color: red; font-weight: bold;"

								id="all_total">@php echo '$'.number_format( (

								str_replace(array('$', ','), '', $total_sum_system_fee))- (

								str_replace(array('$', ','), '', $total_sum_authrewd)), 2);

								@endphp</th> -->

							<th style="text-align: right; color: #3a5e9c; font-weight: bold;"

								id="all_total">@php echo $total_sum_system_fee; @endphp</th>
						</tr>

						@endif



					</tfoot>

				</table>

			</div>

		</div>

	</div>

</div>

<style>

.highlight {

	background: yellow;

}



button:disabled {

	pointer-events: none;

	background-color: lightgray;

}



.pric_selected {

	background: antiquewhite !important;

}

</style>

@include('reports.accounting2') @endsection @section('js')

<script

	src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="{{ url('js/divjs.js') }}"></script>

<link rel="stylesheet"

	href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

        function currencyFormat(num) {

            return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

        }



       function submit_date_form()

       {



       }



function IsEmail(email) {

  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if(!regex.test(email)) {

    return false;

  }else{

    return true;

  }

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

                url: "{{ url ('report/email-invoice-accounting')}}",

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



function getLastDayOfYearAndMonth(year, month)

{

    return(new Date((new Date(year, month + 1, 1)) - 1)).getDate();

}

        $(document).ready(function(){



            $('#invoice_date').datepicker({

                    autoclose: true,

                    format: 'mm/dd/yyyy',

                     maxDate: new Date("{{ $table_dates['end_bill_date'] }}"),

                    beforeShowDay: function (date) {

                    //getDate() returns the day (0-31)

                    if (date.getDate() == 15 || date.getDate() == 1) {

                        return [true, ''];

                    }

                    return [false, ''];

                    }

            });

            $('#datepicker_to').datepicker({

                autoclose: true,

                format: 'mm/dd/yyyy',

                maxDate:  new Date("{{-- $current_dates['end_date'] --}}"),

                beforeShowDay: function(date)

                {

                    console.log(date);

                    if (date.getDate() == 15 || date.getDate() == getLastDayOfYearAndMonth(date.getFullYear(), date.getMonth()))

                    {

                        return [true, ''];

                    }



                    return [false, ''];

                }

            });



             $("#datetimepicker").datepicker({

                    autoclose: true,

                    format: 'mm/dd/yyyy',

                    orientation: 'bottom'

                });







            $('.compliance-user-table').DataTable({

            footerCallback: function ( row, data, start, end, display ) {



                    var api = this.api(), data;



                    // Remove the formatting to get integer data for summation

                    var intVal = function ( i ) {

                        return typeof i === 'string' ?

                            i.replace(/[\$,]/g, '')*1 :

                            typeof i === 'number' ?

                                i : 0;

                    };



                    // Total over this page







    @if(!Session::has('practice') AND !isset(auth::user()->practice_id))



                     pageTotal = api

                        .column( 3, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = (pageTotal);

                    $( api.column( 3 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 4, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 4 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 5, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 5 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 6, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 6 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 7, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 7 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 8, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 8 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 9, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 9 ).footer() ).html(

                        pageTotal

                    );



                    pageTotal = api

                        .column( 10, { page: 'current'} )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                    pageTotal = currencyFormat(pageTotal);

                    $( api.column( 10 ).footer() ).html(

                        pageTotal

                    );



                    // Total over all pages

                    reward = api

                        .column( 8 )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );



                    reward = currencyFormat(reward);



                    total = api

                        .column( 10 )

                        .data()

                        .reduce( function (a, b) {

                            return intVal(a) + intVal(b);

                        }, 0 );

                        total = currencyFormat(total);



                        $('#reward_authorized').html(reward);



                        $('#all_total').html(total);

                        $('#service_fee').html(total);



            @endif



                },

                processing: false,

                serverSide: false,

                Paginate: false,

                lengthChange: false,

                order:[],

                bFilter: false,



            });





        });



        $('#back_button').click(function(){

            $('#search_screen').hide();

            $('#back_button').hide();

            $('.datepicker-area').show();

            $('#main_screen').show();

            $('#rx_field').val("");

            $('#back_button').hide();

            $('#stat_icons').show();

        });



        $('#nt-close').click(function(){

            $('#invoice_detail_table').hide();

        });



        function getPatientInfo(patientId,RxNumber)

        {

            $('#invoice_detail_table').hide();



            $.ajax({

                type:'GET',

                url:"{{url('/get-patient-details')}}",

                data: 'patientId='+patientId,

                success:function(data) {



                   dataObj = JSON.parse(data);

                   $('#pt_rx_no').html(RxNumber);

                   $('#pt_name').html(dataObj.FirstName);

                   $('#pt_dob').html(dataObj.BirthDate);

                   $('#pt_sex').html(dataObj.Gender);

                   $('#pt_pharmacy').html(dataObj.Client);

                   $('#pt_client').html(dataObj.UserType);

                   $('#pt_ins_type').html(dataObj.ClientType);



                   $('#invoice_detail_table').show();



                },

                 headers: {

                     'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'

                 }

             });

        }



        function displayInvoice(RxNumber, date, sel_row=false)

        {

            if(date == '')

                $('#invoice_screen1').hide();



            $('#invoice_screen2').hide();

            $('#screen2_dub').hide();



                $.ajax({

                        url: "{{ url ('report/search-rx-details')}}",

                        method: 'post',

                        data:{rx_number: RxNumber, created_at:date},

                        success: function(result){

                            if(result.orders && result.orders !== null && result.status)

                            {

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



     function highlight(string, text) {

            if(text != ''){

                   var index = string.toLowerCase().indexOf(text.toLowerCase());

                   var innerHTML = string;

                   if (index >= 0) {



                           innerHTML = innerHTML.substring(0,index) + "<span class='highlight'>" + innerHTML.substring(index,index+text.length) + "</span>" + innerHTML.substring(index + text.length);

                       }



                   return innerHTML;

                    }

        }

    function submitSearchForm()

    {



                if($('#rx_field').val() != "")

                {

                    $('#loading_small').show();

                    $('#search_report_btn').hide();

                    $('#invoice_screen1').hide();

                    $('#invoice_screen2').hide();

                    $('.datepicker-area').hide();

                    $('#stat_icons').hide();



                    $.ajax({

                            url: "{{ url ('report/search-rxno')}}",

                            method: 'post',

                            data:{rx_number: $('#rx_field').val()},

                            success: function(result){

                                var matchesHtml="";

                                $('#loading_small').hide();

                                $('#search_report_btn').show();

                                if(result.data && result.data !== null && result.status)

                                {

                                    $.each(result.data, function(index, value) {

                                        matchesHtml += '<div class="trow_ '+(index%2==0?'bg-white':'')+' p4-8_ mb-4_" style="border-top: solid 1px #b6b6b6;"><div class="elm-left wd-48p tt_uc_ zero_slashes cnt-right">'+highlight(value.RxNumber, $('#rx_field').val())+'<span class="font-weight-bold">-0'+value.RefillCount+'</span></div><div class="elm-right wd-48p"><a class="txt-blue-force" onclick="displayInvoice(\''+value.RxNumber+'\',\'\');">'+value.practice.practice_name+'</a></div></div>';

                                    });



                                    $('#matches_list').html(matchesHtml);

                                    $('#main_screen').hide();

                                    $('#search_screen').show();

                                    $('#back_button').show();

                                }else{



                                }

                            },



                            error: function(data){



                            }

                        });

               }

               else{

                    $('#main_screen').show();

                   $('#search_screen').hide();

               }

    }



    $('#search_report_btn').click(function (e) {



        submitSearchForm();

    });



$('#patient_button').click(function(){

    $('#invoice_screen2').css('background-color', '#d9d9d9');

    $('#invoice_screen2').printElement();

});



    $("#rx_field").bind("keypress", {}, keypressInBox);



    function keypressInBox(e)

    {

        var code = (e.keyCode ? e.keyCode : e.which);

        if (code == 13) {

            e.preventDefault();

            submitSearchForm();

        }

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



   function getFormattedDate(date) {

    var date = new Date(date);

    var year = date.getFullYear();



    var month = (1 + date.getMonth()).toString();

    month = month.length > 1 ? month : '0' + month;



    var day = date.getDate().toString();

    day = day.length > 1 ? day : '0' + day;



    return month + '/' + day + '/' + year;

  }



   function checkTime(i) {

    if (i < 10) {

      i = "0" + i;

    }

    return i;

  }
  
     

    function showDrugMessages()
    {
        $('#hcpPharmacyMessages').modal('show');
            $.ajax({
                url: "{{ url('get-hcp-comments') }}/"+$('#OrderId').val(),
                method: 'GET',
                async: false,
                success: function (result) {
                    var prescript = result.prescription;
                    console.log("Prescript:"+prescript);
                    $('#hcp_chat_history').html('');
                    
                    <!-------- Fax table ------------->                    
                    $('#fax_sndr_dtls').html(result.pharmacy);
                    //$('#fax_phone_no').html();
                    $('#fax_date').html(prescript.created_at);
                    //$('#fax_time').html(prescript.);
                    $('#fax_dosage_form').html(prescript.rx_brand_or_generic+" "+prescript.dosage_form);
                    $('#fax_quantity').html(prescript.quantity);
                    $('#fax_comments').html(prescript.dosing_instructions);
                    $('#fax_hcp_prescriber').html(result.hcp+'<br><span class="weight_700 fs-19_">'+result.pharmacy+'</span>');
                    <!------- End fax table ---------->
                    var messages = '<ul data-v-6a49c60d="">';
                                $.each(result.messages,function(key,val){
                                    if(val.message){
                                        if(val.sender_type == 'hcp'){
                                            messages += `<li data-v-6a49c60d="" class="message sent ma-0_" style="padding-bottom: 5px; margin: 0px;"><div class="trow_ mb-2_"><img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;"><div class="trow_ txt-sline"><span class="txt-grn-lt d-ib_ fs-12_ lh-14_">`+result.hcp+`</span><span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.date_time)+`</span></div></div><div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="padding: 4px 6px;">`+val.message +`</div></li>`;
                                        }
                                        else {
                                            messages+= `<li data-v-6a49c60d="" class="message received mt-7_" style="padding-bottom: 5px; margin: 0px; margin-top: 7px;"><div class="trow_ mb-2_"><span class="txt-blue d-ib_ fs-12_ lh-14_ elm-right">`+result.pharmacy+`</span><span class="u-info d-ib_ tt_cc_ weight_600 mr-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.date_time)+`</span></div><div data-v-6a49c60d="" class="text pa-4_ bg-grn-lk fs-13_ lh-17_" style="padding: 4px 6px;">`+val.message +`</div></li>`;
                                        }  
                                    }
                                });
                                messages += '</ul>';
                                $('#hcp_chat_history').append(messages); 
                                $("#hcp_chat_history").animate({ scrollTop: $("#hcp_chat_history")[0].scrollHeight}, 1000);
                                
                                var hcpDrugs = "";
                                var phDrugs = "";
                                $.each(result.drugs,function(key,obj){
                                    if(obj.prescriber_type == 'hcp')
                                    {
                                        $('#hcp_title').html(result.hcp);
                                        hcpDrugs += '<div class="trow_ pb-6_ mb-6_ pr-6_" style="border-bottom: solid 1px #cecece"><div class="trow_"><div class="elm-left c-dib_ text-sline">';
                                        hcpDrugs += '<div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">'+obj.rx_label_name+'</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.strength+' - '+obj.dosage_form+'</div></div>';
                                        hcpDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-11_ lh-13 txt-gray-6 weight_500">'+prescript.created_at+'</div></div></div>';
                                        hcpDrugs += '<div class="trow_"><div class="elm-left c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_500 tt_uc_ mr-4_">refills remain:</div><div class="fs-13_ txt-blue weight_500 tt_uc_">'+obj.refills_remain+'</div></div>';
                                        hcpDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">qty</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.quantity+'</div></div></div></div>';
                                    }
                                    else{
                                        $('#pharmacy_title').html(result.pharmacy);
                                        phDrugs += '<div class="trow_ pb-6_ mb-6_ pr-6_" style="border-bottom: solid 1px #cecece"><div class="trow_"><div class="elm-left c-dib_ text-sline">';
                                        phDrugs += '<div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">'+obj.rx_label_name+'</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.strength+' - '+obj.dosage_form+'</div></div>';
                                        phDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-11_ lh-13 txt-gray-6 weight_500">'+obj.created_at+'</div></div></div>';
                                        phDrugs += '<div class="trow_"><div class="elm-left c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_500 tt_uc_ mr-4_">refills remain:</div><div class="fs-13_ txt-blue weight_500 tt_uc_">'+obj.refills_remain+'</div></div>';
                                        phDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">qty</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.quantity+'</div></div></div></div>';
                                    }
                                });
                                
                                $('#hcp_drug_info').html(hcpDrugs);
                                $('#pharmacy_drug_info').html(phDrugs);                              
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
    }
    
    function openFaxModal()
    {        
        $('#modal-fax-prescription').modal('show');
    }
    
    $('#modal-fax-prescription').on('show.bs.modal', function (e) {
        $('#hcpPharmacyMessages').addClass('v-hidden-opacity');
    });


    $("#modal-fax-prescription").on('hidden.bs.modal', function(){
        $('#hcpPharmacyMessages').removeClass('v-hidden-opacity');
   });
    
    function GetFormattedDateData(d) {
    var todayTime = new Date(d);
    var month = todayTime.getMonth() + 1;
    var day = todayTime.getDate();
    var year = todayTime.getFullYear();
   var  hour = todayTime.getHours();
       var  minute = todayTime.getMinutes();
       var  second = todayTime.getSeconds();
    return month + "/" + day + "/" + year +' '+hour+':'+minute+':'+second;
}

    </script>

@endsection

