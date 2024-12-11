@extends('layouts.compliance')

@section('content')

<!--    <div class="user-report-head">
            <span>PATIENT REQUESTS</span>
        </div> -->

        <style>
            .reporter_prescription_buttons {float: right;}
            .all-request-search-table table.compliance-user-table tr:nth-of-type(odd) { background: #ededed;}
            .all-request-search-table table.compliance-user-table thead tr th {font-size: 12px; color: #fff; padding: 0.6em !important; padding-left: 14px !important; border-right: solid 1px rgba(255, 255, 255, 0.6); vertical-align: top; line-height: 1.2em; padding-top: 6px !important; }
            .all-request-search-table table.compliance-user-table tr th { font-size: 13px; color: #fff; font-weight: 600; letter-spacing: 0.6px; text-shadow: none; vertical-align: middle;}
            .all-request-search-table table.compliance-user-table tr td { vertical-align: middle; padding: 0.3vw !important; font-size: 12px; color: #444 !important; border-right: solid 1px rgba(36, 36, 36, 0.13); line-height: 1.2em;}
            .all-request-search-table table.compliance-user-table tr td * { font-size: 12px; }
            .select2-container--default .select2-selection--single { border: solid 1px #aaa; border-radius: 4px;}
            .select2-container--default .select2-selection--single .select2-selection__rendered { color: #444; line-height: 36px;}
            .select2-container--default .select2-selection--single {background-color: #fff;border: 1px solid #aaa !important;border-radius: 4px;height: 36px !important;}
            .select2-container--default .select2-selection--single .select2-selection__arrow {height: 24px;position: absolute;top: 6px;right: 1px;width: 20px;}
            .all-request-search-table table.compliance-user-table {  }
            .all-request-search-table table.compliance-user-table thead {  }
            .all-request-search-table table.compliance-user-table thead th.date { width: 40px !important; }
            .all-request-search-table table.compliance-user-table thead th.request_by { }
            .all-request-search-table table.compliance-user-table thead th.practice_name { }
            .all-request-search-table table.compliance-user-table thead th.medication { }
            .all-request-search-table table.compliance-user-table thead th.qty { width: 47px !important;  }
            .all-request-search-table table.compliance-user-table thead th.new { width: 47px !important; }
            .all-request-search-table table.compliance-user-table thead th.rx_number { width: 100px !important; }
            .all-request-search-table table.compliance-user-table thead th.service { width: 144px !important; }
            .all-request-search-table table.compliance-user-table thead th.assist-auth { width: 80px !important; }
            .all-request-search-table table.compliance-user-table thead th.status { width: 80px !important; }
            .all-request-search-table table.compliance-user-table thead th.mark_process { width:110px !important; }
            button:disabled{ pointer-events: none;background-color: lightgray; }

            .main-page-content { display: flex; flex-wrap: wrap; align-items: flex-end; }
            .compliance-tabs.all-request-search-fields{ margin-top: 0px; vertical-align: top; align-self: flex-start; min-width: 100%;}
      
      
    .all-request-search-table table.compliance-user-table tr td .renewal-details {  }
    .all-request-search-table table.compliance-user-table tr td .renewal-details .eye-btn {z-index: 200;}
    .all-request-search-table table.compliance-user-table tr td .renewal-details .inner-rw-details { display: none; border: solid 1px #242424; min-width: 159px;z-index: 400;}
    .all-request-search-table table.compliance-user-table tr td .renewal-details:hover .inner-rw-details { display: block; }
    .all-request-search-table table.compliance-user-table tr td .renewal-details .inner-rw-details:before {position: absolute;content: '';width: 0px;height: 0px;border-left: 12px solid transparent;border-right: 12px solid transparent;border-bottom: 12px solid #242424;bottom: 100%;left: 50%;margin-left: -18px;}
    .all-request-search-table table.compliance-user-table tr td .renewal-details .inner-rw-details:after {position: absolute;content: '';width: 0px;height: 0px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid #f2ebb9;bottom: 100%;left: 50%;margin-left: -16px;}

      
      
        </style>

<input type="hidden" name="orig_unit_price" id="orig_unit_price" value="">
<input type="hidden" name="quantity_orig" id="quantity_orig" value="">
<input type="hidden" name="daysSupplyFld_orig" id="daysSupplyFld_orig" value="">
<input type="hidden" name="RefillsRemaining_orig" id="RefillsRemaining_orig" value="">
<input type="hidden" name="drugPrice_orig" id="drugPrice_orig" value="">
<input type="hidden" name="thirdPartyPaid_orig" id="thirdPartyPaid_orig" value="">
<input type="hidden" name="pocketOut_orig" id="pocketOut_orig" value="">
<input type="hidden" name="asistantAuth_orig" id="asistantAuth_orig" value="">

        <div class="compliance-tabs all-request-search-fields">
            <form action="javascript:void(0);" onsubmit="return check_validation();" id="request_filter" name="request_filter" method="post" class="compliance-form_">
                
                <div class="row mt-7_">
                    {{--<div class="col-sm-12"><h4>Filter by :</h4></div>--}}
                    <div class="col-sm-12">
                    	<div class="flx-justify-start">
                            <div class="wd-17p mr-1p field-fromdate" style="min-width: 147px;">
                                <div class="form-group mb-10_" style="position: relative;">
                                    <label class="weight_600">Rx Number/Patient Name</label>
                                    <input style="min-height: 36px;border: solid 1px #aaa;border-radius: 4px;"  type="text" autoComplete="off" id="srch" class="form-control" name="keyword" value="@if(Request('keyword')!='' ){{ Request('keyword') }} @endif">

                                </div>
                            </div>
                            <div class="wd-17p mr-1p field-fromdate" style="min-width: 100px;max-width: 100px;background-color: #fff;">
                                <div class="form-group mb-10_" style="position: relative;">
                                    <label class="weight_600">From Date</label>
                                    <input style="min-height: 36px;border: solid 1px #aaa;border-radius: 4px;position: relative; z-index: 100; background-color: transparent;" value="@if(Request('from_date')!='' ){{ Request('from_date') }} @endif" type="text" autoComplete="off" id="datepicker_from" class="form-control datepicker" name="from_date">
                                    <span class="fa fa-calendar" style="position: absolute;right: 7px;top: 32px;z-index:40;"></span>
                                </div>
                            </div>
                            <div class="wd-17p mr-1p field-todate" style="min-width: 100px;max-width: 100px;background-color: #fff;">
                                <div class="form-group mb-10_" style="position: relative;">
                                    <label class="weight_600">To Date</label>
                                    <input style="min-height: 36px;border: solid 1px #aaa;border-radius: 4px;position: relative; z-index: 100; background-color: transparent;" value="@if(Request('to_date')!='' ){{ Request('to_date') }} @endif" type="text" autoComplete="off" id="datepicker_to" class="form-control datepicker" name="to_date">
                                    <span class="fa fa-calendar" style="position: absolute;right: 7px;top: 32px;z-index:40;"></span>
                                </div>
                            </div>
                             @if(!auth::user()->hasRole('practice_admin') && !auth::user()->can('practice admin'))
                                <div class="wd-18p mr-1p field-practice_name" style="min-width: 200px;">
                                    <div class="form-group mb-10_">
                                        <label class="weight_600">Practice Name</label>
                                        <select id="practice_name" class="form-control all-results-select-control"
                                                name="practice_name">
                                            <option value="ALL">All</option>
                                            @foreach($practices as $par)
                                                <option
                                                    @if(Request('practice_name')==$par->id ){{ 'selected' }} @endif value="{{ $par->id }}">{{ $par->practice_name }} {{ $par->branch_name?'( '.$par->branch_name.' )':'' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="wd-18p mr-1p field-service" style="min-width: 200px;">
                                <div class="form-group mb-10_">
                                    <label class="weight_600">Service</label>
                                    <select class="form-control all-results-select-control" id="selectServic" name="service">

                                        @foreach($service as $key => $val)
                                            <option @if(Request('service') == $key ){{ 'selected' }} @endif value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="wd-11p field-buttons" style="min-width: 170px;display: flex;align-items: flex-end;background-color: white;justify-content: flex-start;">
                                {{--<label class="wd-100p">&nbsp;</label>--}}
                                <button type="button" class="btn bg-red-txt-wht btn-clear_ mb-10_"  style="height: 36px; border-radius:0px;margin-left: 7px;" onclick="resetField();" >Clear</button>
                                <button type="submit" class="btn bg-blue-txt-wht btn-search_ mb-10_" style="height: 36px; border-radius:0px;margin-left: 7px;" id="filter_btn">Search</button>
                                 {{-- onclick="resetField()" --}}
                            </div>
                    </div>
                </div>
            </form>
    </div>

    <div class="table-box all-request-search-table table-responsive" style="min-height: 400px">
        <table class="compliance-user-table table" style="min-width: 770px;">
            <thead>
                <tr>
                    <th class="date" scope="col" style="width:40px;">DATE</th>
                    <th class="status" scope="col" style="min-width:80px;">STATUS</th>
                    <th class="rx_number text-sline" scope="col" style="width:40px;">Rx NUMBER</th>
                    <th class="order_by text-sline" scope="col" style="width:65px;">Ordered BY</th>
                     <th class="pat_name text-sline" scope="col" style="width:65px;">PATIENT NAME</th>
                    <th class="medication text-sline" scope="col">Rx LABEL NAME</th>
                    <th class="new text-sline" scope="col">GENERIC FOR</th>
                    <th class="qty" scope="col" class="no-sort">QTY</th>
                    <th class="assist-auth text-sline" scope="col" style="min-width:80px;">ASSIST. AUTH</th>
                    <th class="status" scope="col" style="min-width:130px;">QUESTION</th>
                    @if(!auth::user()->hasRole('practice_admin') && !auth::user()->can('practice admin'))
                    <th class="practice_name text-sline" scope="col">PRACTICE NAME</th>
                @endif
                    {{-- <th class="new" scope="col">NEW</th> --}}
                    {{-- <th class="mark_process" scope="col" style="min-width:110px" class="no-sort text-center">MARK AS PROCESS</th> --}}
                </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
<button class="submit-form weight_500 tt_uc_ ml-14_ bg-dk-grn-txt-wht" type="button" data-toggle="modal" data-target="#order_edit_Modal" style="display:none;">Show New Modal</button>
<script>
    var statusIds = new Array();
    var statusList = new Array();
    @foreach($service as $key => $val)
        statusIds.push({{$key}});
        statusList.push(<?="'".$val."'"?>);
    @endforeach
</script>
@include('practice_module.patient_order_request.modal.orderstatus_modal')
@include('practice_module.patient_order_request.modal.patient_message_modal')
<!-- Remove  if condition for $requests_two -->

@include('practice_module.patient_order_request.modal.precription_detail_modal')

<!-- Remove  if condition for $requests_two -->
@endsection

@section('js')




 @include('partials.js.patient_profile_js')

<!-- <script type="text/javascript" src="{{asset('js/bootstrap-autocomplete/bootstrap-autocomplete.min.js')}}"></script>  -->
<script type="text/javascript" src="{{asset('js/typeahead.js')}}"></script>

    @if(Request::has('outside_link'))
    <script type="text/javascript">
           $(document).ready(function(){
              $( "#rx_check_{{ Request::get('outside_link') }}" ).trigger( "click" );
           });
    </script>
    @endif



    <!-- Remove  if condition for $requests_two -->
<script type="text/javascript">


$(document).ready(function(){

//------------- Patient Precription Add ---------------
$('#precription_submit_btn').click(function(){
    if($('#practice_id').val()==''){  $('#practice_id').next('span').addClass('error'); }

});
$('#practice_id').on("select2:select", function (e) { if($('#practice_id').val()!='') { $('label#practice_id-error').next('span').removeClass('error'); } });

            $('#precription_data').submit(function(e){
                if (!$('#precription_data').valid()) {
                    return false;
                }

                    $('#loading_small_one').show();
                    $('#precription_submit_btn').attr("disabled", "disabled");
                    var formData  = $('#precription_data').serializeArray();
                    formData.find(item => item.name === 'reporter_cell_number').value = $('#reporter_cell_number').cleanVal();
                    formData = $.param(formData);
                    e.preventDefault();
                    $.ajax({
                        url: "{{ url('add-reporter-precritption') }}",
                        method: 'post',
                        data: formData,
                        async: true,
                        success: function (result) {

                            $('#loading_small_one').hide();
                            $('#precription_submit_btn').removeAttr("disabled");
                            if(result.status==true)
                            {
                                toastr.success(result.message);
                            }else
                            {
                                toastr.error(result.message);
                            }

                        },
                        error: function (data) {
                            $('#loading_small_one').hide();
                            $('#precription_submit_btn').removeAttr("disabled");
                            toastr.error('error', 'Something went wrong');
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    // return false;
            });

//------------Patient Precription Add End -------------


//--------------Drug search---------------------------


        $('#rx_brand_or_generic').autoComplete({

                resolverSettings: {
                    url: "{{url('/get-drug-for-reporter')}}",

                },
                events: {
                    searchPost: function (drugs) {
                        if(drugs.length>0)
                        {
                            var drug_list = [];
                            window.full_drug = [];
                            window.dosage_form = [];
                            window.strength = [];
                        $.each(drugs, function(ind, val){
                            var text_con = '';
                            text_con = $.trim(val.rx_label_name);
                            if(val.generic_name!=''){ text_con =  text_con+'  ( '+$.trim(val.generic_name)+' )'; }
                            if(val.strength!=''){ text_con = text_con+'   '+$.trim(val.strength); }
                            if(val.dosage_form!=''){ text_con = text_con+'   '+$.trim(val.dosage_form); }

                            drug_list.push({ 'id': val.id, 'text': $.trim(text_con), 'fullData': val });

                            window.dosage_form.push($.trim(val.dosage_form));
                            window.strength.push($.trim(val.strength));
                        });
                        window.strength = window.strength.filter(item => item).filter(function(elem, index, self) { return index === self.indexOf(elem); });
                        window.dosage_form = window.dosage_form.filter(item => item).filter(function(elem, index, self) { return index === self.indexOf(elem); });
                        }else{
                            $('#drug_id').remove();
                        }
                        return drug_list;
                    }
                }
        });

        $('#rx_brand_or_generic').on("autocomplete.select",function(evt, item){
            console.log(window.dosage_form);
            console.log(window.strength);

            $('#rx_brand_or_generic').val($.trim(item.fullData.rx_label_name));
            $('#strength').typeahead({
                        minLength:0,
                        source:window.strength,
                        showHintOnFocus:true
                });
                $('#dosage_form').typeahead({
                        minLength:0,
                        source:window.dosage_form,
                        showHintOnFocus:true
                });

                $('#strength').val($.trim(item.fullData.strength));
                $('#dosage_form').val($.trim(item.fullData.dosage_form));

                $('#precription_data').append('<input type="hidden" name="drug_id" id="durg_id" value="'+item.id+'" />');

        });
    });
//-------------End Drug Search ------------------

//---------------------END Patient precription script area ----------------------------


    function get_pricription(id)
    {
        var al_exist = false;
        $('#precription_edit_Modal').modal('show');
        $('#loading_small_one').show();
        $('#precription_submit_btn').attr("disabled", "disabled");
        $.ajax({
            url: "{{url('get-precription')}}",
            method: 'post',
            data: 'precription_id='+id,
            async: true,
            success: function (result) {
                $('#precription_edit_Modal').modal('show');
                 $('#loading_small_one').hide();
                $('#precription_submit_btn').removeAttr("disabled");
                if(result.data)
                {
                    $.each(result.data, function(ind, val){
                        if(ind=='reporter_comment')
                        {
                            $('#precription_data #'+val).attr('checked', true);
                        }
                        if(ind=='practice_name' && val!=null)
                        {
                            //alert(val)
                            al_exist = val;

                        }
                        else{ $('#precription_data #'+ind).val(val); }

                    });

                    if(al_exist==false)
                    {
                        $('#practice_id').show();
                        $("#practice_id").select2({
                            placeholder: "Select Practice",
                            allowClear: true
                        });
                        $('#pracetice_area #Practice_Name').hide();
                    }
                    else
                    {
                        //console.log($('span.select2').length);
                        if($('span.select2').length>2)
                        {
                            $('#practice_id').select2('destroy');
                        }
                        $('#practice_id').hide();
                        $('#pracetice_area #Practice_Name').val(al_exist).show();
                    }
                     $('#reporter_cell_number').mask($('#reporter_cell_number').attr('mask')).trigger('input');


                }else{
                    toastr.error('error', 'You are not authorized.');
                }


            },
            error: function (data) {
                $('#loading_small_one').hide();
                $('#precription_submit_btn').removeAttr("disabled");
                toastr.error('error', 'Something went wrong');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }







    //     get order detail on pop up
function confirm_order_reporter(id)
{
    toastr.options.fadeOut = 500000;
            toastr.error("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Do u really want move to next order?',
            {
                closeButton: false,
                timeOut: 500000,
                allowHtml: true,
                onShown: function (toast) {
                    $("#confirmationYes").click(function(){
                      toastr.clear();
                      get_order_reporter(id);
                    });
                    $("#confirmationNo").click(function(){
                      toastr.clear();
                    });
                  }
            });
}

function get_order_reporter(OrderId)
{
    var order_id = OrderId;
    $('#print_button').hide();
    $('#prev_order_edit').prop( "disabled", false );
    $('#next_order_edit').prop( "disabled", false );
    $('#pharmacy_comments_area').val("");
    //$('#date_label_id').html("ORIGINAL Rx DATE:");
    //$('#orig_date_id').html("");
    $('#sent_edits_to_hcp_btn').hide();
    //Alternate##
    $('#HcpOrderId').val(OrderId);
    $('#order_tmp_id').html(OrderId);
    $('#HCP_OrderId').html(OrderId);
    $('#send_edits_to_hcp_btn').hide();
    $('#hcp_comment_area').hide();
    $('#delete_order').show();
    $('#history_btn').hide();

    var prev = "";
    var  next = "";
    //var allOrderList=[]; now defined globaly to assign value from complete of datatable
    // I remove php if cond isset on $all_order_list aroud it
    // var allOrderList = JSON.parse('php var -> all_order_list');
    for(var i = 0; i < allOrderList.length; i++) {
        var orderItems = allOrderList[i];
        //console.log("orderId:"+orderItems[0]+"patId:"+orderItems[1]);
        if(OrderId == orderItems[0]){
            if(i>0){
                prev =  allOrderList[i-1][0];
            }

            if(i<(parseInt(allOrderList.length)-parseInt(1))){
                next =  allOrderList[i+1][0];
            }
        }
    }

    if(prev == "")
        $('#prev_order_edit').prop( "disabled", true );
    else
        $('#prev_order_edit').attr("onclick", "confirm_order_reporter("+prev+")");

    if(next == "")
        $('#next_order_edit').prop( "disabled", true );
    else
        $('#next_order_edit').attr("onclick", "confirm_order_reporter("+next+")");

    $('#copy_next_order_edit').attr("onclick", "get_order_reporter("+next+")");    

    if($('#PracticeId')){
$('#PracticeId').remove();
    }
     if($('#reporter_prescription_id')){
        $('#reporter_prescription_id').remove()
    }
        if($('#barcode')){
$('#barcode').hide();
$('#barcode1').hide();
    }
     if($('#reporter_prescription_id')){
        $('#reporter_prescription_id').remove()
    }

    if($('input[name="prescriber_id"]').val()){
        $('input[name="prescriber_id"]').val('');
    } 

    $('#orderUpdateData').append('<input type="hidden" id="PracticeId" name="PracticeId" value="">');
    $('#orderUpdateData').append('<input type="hidden" id="reporter_prescription_id" name="reporter_prescription_id" value="">');

      $('.toggle_items').remove();
      $('.reporter_prescription').remove();
      $('#strengthFieldId').empty();
      $('input:disabled').removeAttr('disabled');
      $('#orderUpdateData #pat_mobile').before(`<div class="flx-justify-start flex-v-center reporter_prescription"><button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-grn-lk txt-black-24 status-btn p4-12_ reporter_prescription_buttons" onclick="viewEdits($('#HcpOrderId').val());" type="button" id="sent_edits_to_hcp_btn" style="border: solid 1px transparent;line-height: 17px; display:none;">View Previous Edits</button><div class="btn-group" role="group" aria-label="Save Edits" id="send_edits_to_hcp_btn" style="display:none;"><button class="btn btn-danger btn-sm" style="border-top-left-radius:13px; border-bottom-left-radius:13px;" type="button" data-dismiss="modal" onclick="sendEditsToHcp($('#DrugDetailId').val(), 1)" style="">SEND EDITS TO HCP</button><button class="btn btn-warning  btn-sm" style="border-top-right-radius:13px; border-bottom-right-radius:13px;" type="button" onclick="sendEditsToHcp($('#DrugDetailId').val(), 0);">SAVE CHANGES ONLY</button></div><button class="weight_500 tt_uc_ mr-6_ br-rds-13 bg-dk-grn-txt-wht status-btn p4-12_ reporter_prescription_buttons" type="button" onclick="processMbrToPay();" id="mbr-pay" style="margin-left: auto;">MBR to Pay</button></div>`);

$('#orderUpdateData input').val('');
$('#orderUpdateData #product_marketer').remove();
$('#select_product_marketer').append(' <input class="wd-100p" type="text" name="marketer" id="product_marketer" >');

$('#strengthFieldId').append(' <input class="wd-100p" onchange="strengthChangeTrigger(this);" type="text" name="Strength" id="dosage_strength" >');

        $('#order_edit_Modal').modal('show');
$('#orderstatusname').text('New Order');

$('#under_review_reason_div #under_review_reason_div_span').text('').parent('#under_review_reason_div').hide();

    //  $('#pharmacy-txt').text(prac_name + ' PHARMACY')
          $.ajax({
                url:"{{url('/get-order-reporter')}}",
                method:'get',
                data:{order_id: OrderId},
                success:function(response){
                    console.log(response.data);
                    var orderData=response.data;
                    var alternateData = response.alternate;
                    console.log(alternateData);
                    
                    if(response.pres){
                        $('input[name="prescriber_id"]').val(response.pres.prescribr_practice_id);
                        $('#HCP_Name').val(response.pres.prescriber_name);       
                        $('#basicAutoSelect').val(response.pres.practice_name);
                        $(" #basicAutoSelect2").val(response.pres.practice_phone_number);
                    }
                    $(" #basicAutoSelect2").removeAttr('required');
                    $('#isPIPPatient').val('');
                    if(orderData.is_pip_patient == 1){
                        $('#mbr-pay').html("BILL TO PIP");
                        $('#p-type').html(" - PIP Patient");
                        $('#isPIPPatient').val('1');
                       
                    }else{
                        $('#mbr-pay').html("MBR To PAY");
                        $('#p-type').html(""); 
                      
                    }

                    if(orderData){
                            $('#Pharmacy_Name').val(orderData.practice_name);                  
                            $('#p-nam').empty().html(orderData.requested_by);
                            $('#p-gen').empty().html('('+orderData.Gender+')');
                            $('#p-dob').empty().html('DOB: '+orderData.BirthDate );
                            $('#p-mob').empty().html('Ph: '+orderData.MobileNumber );
                            $('#hcp_order').empty().html('( HCP ORDER )' );
                            $('#HcpOrderId').val(OrderId);
                            $('#under_review_reason_div #under_review_reason_div_span').text(orderData.dosing_instructions).parent('#under_review_reason_div').show();
                            $('#prescriber_div_id').css('margin-top','-60px');

                            if(orderData.unit_price > 0 && orderData.unit_price != '0.0000')
                                $('#orig_unit_price').val(orderData.unit_price);
                            else{
                                var unitPrice = parseFloat(orderData.RxIngredientPrice/orderData.Quantity)
                                $('#orig_unit_price').val(unitPrice);
                                console.log("UnitPrice:"+unitPrice);
                            }    
     
                
                            if(orderData.Quantity > 0){
                                var ingPrice = parseFloat(orderData.Quantity) * parseFloat(orderData.unit_price); 
                                $('input[name="RxIngredientPrice"]').val("$"+ingPrice.toFixed(2));  
                        
                            }else{
                                $('input[name="RxIngredientPrice"]').val("$0.00");
                            }
                            
                            if(orderData.alternate_drug == 'Y')
                                $('#mbr-pay').prop("disable", true);

                            console.log("Length:"+alternateData.length);    
                            if(alternateData.length >0){                               
                                $('#position_buttons').css({"min-width": "209px", " margin-left": "auto;"});
                                $('#sent_edits_to_hcp_btn').show();
                                //$('#pharmacy_comments_area').val(alternateData.phrmacy_comments);

                                var hcpDrugs = "";
                                var phDrugs = "";
                                $.each(alternateData,function(index,obj){
                                
                                    if(obj.prescriber_type == 'hcp')
                                    {
                                        $('#hcp_title').html(obj.created_by);
                                        hcpDrugs += '<div class="trow_ pb-6_ mb-6_ pr-6_" style="border-bottom: solid 1px #cecece"><div class="trow_"><div class="elm-left c-dib_ text-sline">';
                                        hcpDrugs += '<div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">'+obj.rx_label_name+'</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.strength+' - '+obj.dosage_form+'</div></div>';
                                        hcpDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-11_ lh-13 txt-gray-6 weight_500">'+obj.hcp_prescribed_at+'</div></div></div>';
                                        hcpDrugs += '<div class="trow_"><div class="elm-left c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_500 tt_uc_ mr-4_">refills remain:</div><div class="fs-13_ txt-blue weight_500 tt_uc_">'+obj.refills_remain+'</div></div>';
                                        hcpDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">qty</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.quantity+'</div></div></div></div>';
                                    }
                                    else{
                                        $('#pharmacy_title').html(obj.practice_name);
                                        phDrugs += '<div class="trow_ pb-6_ mb-6_ pr-6_" style="border-bottom: solid 1px #cecece"><div class="trow_"><div class="elm-left c-dib_ text-sline">';
                                        phDrugs += '<div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">'+obj.rx_label_name+'</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.strength+' - '+obj.dosage_form+'</div></div>';
                                        phDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-11_ lh-13 txt-gray-6 weight_500">'+obj.created_at+'</div></div></div>';
                                        phDrugs += '<div class="trow_"><div class="elm-left c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_500 tt_uc_ mr-4_">refills remain:</div><div class="fs-13_ txt-blue weight_500 tt_uc_">'+obj.refills_remain+'</div></div>';
                                        phDrugs += '<div class="elm-right c-dib_ text-sline"><div class="fs-13_ txt-black-24 weight_600 tt_uc_ mr-4_">qty</div><div class="fs-13_ txt-blue weight_600 tt_uc_">'+obj.quantity+'</div></div></div></div>';
                                    }
                                    
                                });
                                if(os_id == 23 && orderData.is_pip_patient == 1){
                                 $('#mbr-pay').prop("disabled",false);
                                 }
                                
                                $('#hcp_drug_info').html(hcpDrugs);
                                $('#pharmacy_drug_info').html(phDrugs);
                                  
                            }
                    }

                    if(orderData){
                        $('#pharmacy-txt').text('');
                     $('#pharmacy-txt').text(orderData.practice_name +" "+ orderData.practice_type);
                     $('#datetimepicker').datepicker('setDate', 'now');
                     console.log($('#datetimepicker').val());
                           $('#rx_orig_date').html(GetFormattedDateOnly(new Date()));
                    
                    $('#order_edit_Modal').modal('show');
                    $.each(orderData,function(key,val){
                        if(key=="Quantity")
                        {
                          $('input[name="'+key+'"]').val(window.pharmacyNotification.numberWithCommas(val));
                        }
                        else{
                          $('input[name="'+key+'"]').val(val);
                        }

                        if(key == 'gcn_seq' || key == 'Strength' || key == 'dosage_form')
                            localStorage.setItem(key,JSON.stringify(val));
                    });

              window.pharmacyNotification.calculateNextRefillDate( $('#datetimepicker').val());
             
        }

                },
                error:function(error){

                }
            });
}

    $('#hcpPharmacyMessages').on('show.bs.modal', function (e) {
        $('#order_edit_Modal').addClass('v-hidden-opacity');
    });
    
    $("#hcpPharmacyMessages").on('hidden.bs.modal', function(){
        $('#order_edit_Modal').removeClass('v-hidden-opacity');
   });

   $('#modal-dashboard-history-preferences').on('show.bs.modal', function (e) {
        $('#order_edit_Modal').addClass('v-hidden-opacity');
    });
    
    $("#modal-dashboard-history-preferences").on('hidden.bs.modal', function(){
        $('#order_edit_Modal').removeClass('v-hidden-opacity');
   });
    
    function viewEdits(Id)
    {
        $('#HCP_OrderId').val(Id);
        $('#hcpPharmacyMessages').modal('show');
            $.ajax({
                url: "{{ url('get-hcp-comments') }}/"+Id,
                method: 'GET',
                async: false,
                success: function (result) {
                    $('#hcp_chat_history').html('');
                    var messages = '<ul data-v-6a49c60d="">';
                                $.each(result.messages,function(key,val){
                                    if(val.message){
                                        if(val.sender_type == 'hcp'){
                                            messages += `<li data-v-6a49c60d="" class="message sent ma-0_" style="padding-bottom: 5px; margin: 0px;"><div class="trow_ mb-2_"><img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;"><div class="trow_ txt-sline"><span class="txt-grn-lt d-ib_ fs-12_ lh-14_ hcp_sent">`+result.hcp+`</span><span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.date_time)+`</span></div></div><div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="padding: 4px 6px;">`+val.message +`</div></li>`;
                                        }
                                        else {
                                            messages+= `<li data-v-6a49c60d="" class="message received mt-7_" style="padding-bottom: 5px; margin: 0px; margin-top: 7px;"><div class="trow_ mb-2_"><span class="txt-blue d-ib_ fs-12_ lh-14_ elm-right pharmacy_received">`+result.pharmacy+`</span><span class="u-info d-ib_ tt_cc_ weight_600 mr-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.date_time)+`</span></div><div data-v-6a49c60d="" class="text pa-4_ bg-grn-lk fs-13_ lh-17_" style="padding: 4px 6px;">`+val.message +`</div></li>`;
                                        }  
                                    }
                                });
                                messages += '</ul>';
                                $('#hcp_chat_history').append(messages); 
                                $("#hcp_chat_history").animate({ scrollTop: $("#hcp_chat_history")[0].scrollHeight}, 1000);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
    }
    
    function addHcpMessage()
    {
        if($('#hcpOrderMessage').val().trim() != "")
        {
            $('#hcpOrderMessage').css("border", "1px solid black");
            $('#hcpPharmacyMessages').modal('show');
                $.ajax({
                    url: "{{ url('/add-hcp-comments') }}",
                    method: 'POST',
                    data: 'order_id='+$('#HCP_OrderId').val()+'&message='+$('#hcpOrderMessage').val(),
                    async: true,
                    success: function (result) {
                        $('#hcp_chat_history').html('');
                        var messages = '<ul data-v-6a49c60d="">';
                                    $.each(result,function(key,val){
                                        if(val.message){
                                            if(val.sender_type == 'hcp'){
                                                messages += `<li data-v-6a49c60d="" class="message sent ma-0_" style="padding-bottom: 5px; margin: 0px;"><div class="trow_ mb-2_"><img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;"><div class="trow_ txt-sline"><span class="txt-grn-lt d-ib_ fs-12_ lh-14_">`+$('#HCP_Name').val()+`</span><span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.date_time)+`</span></div></div><div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="padding: 4px 6px;">`+val.message +`</div></li>`;
                                            }
                                            else {
                                                messages+= `<li data-v-6a49c60d="" class="message received mt-7_" style="padding-bottom: 5px; margin: 0px; margin-top: 7px;"><div class="trow_ mb-2_"><span class="txt-blue d-ib_ fs-12_ lh-14_ elm-right">`+$('#Pharmacy_Name').val()+`</span><span class="u-info d-ib_ tt_cc_ weight_600 mr-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.date_time)+`</span></div><div data-v-6a49c60d="" class="text pa-4_ bg-grn-lk fs-13_ lh-17_" style="padding: 4px 6px;">`+val.message +`</div></li>`;
                                            }  
                                        }
                                    });
                                    messages += '</ul>';
                                    $('#hcp_chat_history').append(messages); 
                                    $("#hcp_chat_history").animate({ scrollTop: 9999 }, 'slow');
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#hcpOrderMessage').val("");
            }else{
                $('#hcpOrderMessage').css("border", "1px solid red");
            }
    }
    
    $("#hcpOrderMessage").keyup(function(event) { 
            if (event.keyCode === 13) { 
                $("#sendMessage").click(); 
            } 
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
function GetFormattedDateOnly(d) {
    var todayTime = new Date(d);
    var month = todayTime.getMonth() + 1;
    var day = todayTime.getDate();
    var year = todayTime.getFullYear();
   var  hour = todayTime.getHours();
       var  minute = todayTime.getMinutes();
       var  second = todayTime.getSeconds();
    return month + "/" + day + "/" + year;
}
    function reloadOrder(OrderId)
    {
        get_order_reporter(OrderId);
    }

    function sendEditsToHcp(NewDrugId, sendStatus)
    {
        var url = '{{url('/send-edits-to-hcp')}}';
        $.ajax({
            url: url,
            data: 'order_id='+$('#HcpOrderId').val()+'&new_drug_id='+NewDrugId+'&quantity='+$('#quantity').val()+'&drug_label='+$('#drug').val()+'&comments='+$('#pharmacy_comments_area').val()+'&marketer='+$("#product_marketer option:selected").text()+'&strength='+$("#dosage_strength option:selected").text()+'&dosage_form='+$('#PackingDescr').val()+'&days_supply='+$('#daysSupplyFld').val()+'&refills='+$('#RefillsRemaining').val()+'&ingr_cost='+$('#drugPrice').val()+'&send_status='+sendStatus,
            method: 'post',
            success: function(result){
                toastr.success("Message sent successfully.");
            },
            error: function(data){
            }
            });
            
        if(sendStatus == 0){
            $('#mbr-pay').prop("disabled", false);
        }    
    }
    
    $('#delete_order').click(function(){        
            toastr.options.fadeOut = 500000;
            toastr.error("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Do u really want move to delete this order?',
            {
                closeButton: false,
                timeOut: 500000,
                allowHtml: true,
                onShown: function (toast) {
                    $("#confirmationYes").click(function(){
                      toastr.clear();
                            var url = "{{url('/delete-hcp-order')}}";
                            $.ajax({
                                url: url,
                                data: 'order_id='+$('#HcpOrderId').val(),
                                method: 'post',
                                success: function(result){
                                    toastr.error("Order deleted successfully.");
                                    var table =  $('.compliance-user-table').DataTable();
                                    table.row( $('[data-oid="'+$('#HcpOrderId').val()+'"]') ).remove().draw();
                                },
                                    error: function(data){
                                }
                                });
                            });
                    $("#confirmationNo").click(function(){
                      toastr.clear();
                    });
                  }
            });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function reset_precription_form()
    {
        $('.a-reset').val('');
    }
</script>
    <!-- End Remove if condition for $requests_two -->
<script type="text/javascript">
    $(document).ready(function(){
        if($.fn.DataTable.isDataTable( '.compliance-user-table' )){  $('.compliance-user-table').DataTable().destroy(); }
        var ordr_url='{{url("order-listing")}}';
        @if(Request("service")!=null)
        ordr_url='{{ url("order-listing")}}?service={{Request("service")}}';
        @endif

        @if(Request("pId")!=null)
        ordr_url='{{ url("order-listing")}}?pId={{Request("pId")}}';
        @endif

        $('.compliance-user-table').DataTable({
            processing: true,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            pageLength: 10,
            "language": {
    "infoFiltered": "",
  },
            ajax: {
                "type": "post",
                "url": ordr_url,
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "orders",
                "data": function(data){
                    
                },
                "complete": function(response){
                    console.log(JSON.parse(response.responseText).orders);
                    //below variables defined globaly patient_profile.js
                    if(JSON.parse(response.responseText).all_order_list_ids){
                        orderListIds=[];
                        patientListIds=[];
                    allOrderListingIds=JSON.parse(response.responseText).all_order_list_ids;
                        for(var i = 0; i < allOrderListingIds.length; i++) {
                            var orderItems = allOrderListingIds[i];
                            orderListIds.push(orderItems[0]);
                            patientListIds.push(orderItems[1]);
                        }
                    }
                    console.log("ALL ORDERLIST v2:"+orderListIds);

                     // insert HCP order ids in allOrderList

                    if(JSON.parse(response.responseText).new_order_list)
                    {
                        allOrderList=JSON.parse(response.responseText).new_order_list;
                    }
                    console.log("ALL ORDERLIST new HCP",allOrderList);
                    
                }
            },
            columns: [
            {'data': 'order_created_at', 'render': function(bdate,type,full){
                if(bdate){
                    var o_date;
                    if(full.Message && full.Message!=null && (full.message_status == 'received' || full.message_status == 'sent'))
                    {
                        o_date=full.msgTime;
                    }else{
                        o_date=bdate;
                    }
                    var d = new Date(o_date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear().toString().substr(-2);

                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                    day = '0' + day;
                    var hours = d.getHours();
                    var minutes = d.getMinutes();
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    var strTime = hours + ':' + minutes + ' ' + ampm;

                    return '<span class="trow_ fs13-lh13_ cnt-center" style="max-width:70px;display:block;">'+[ month, day,year].join('/')+'</span><span class="trow_ fs9-lh11_ cnt-center" style="max-width:70px;display:block;margin-top:4px;font-size: 10px;">'+strTime+'</span>';
                }
                else if ('reporter_id' in full){
                    var d = new Date(full.created_at),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear().toString().substr(-2);

                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                    day = '0' + day;
                    var hours = d.getHours();
                    var minutes = d.getMinutes();
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    var strTime = hours + ':' + minutes + ' ' + ampm;

                    return '<span class="trow_ fs13-lh13_ cnt-center" style="max-width:70px;display:block;">'+[ month, day,year].join('/')+'</span><span class="trow_ fs9-lh11_ cnt-center" style="max-width:70px;display:block;margin-top:4px;font-size: 10px;">'+strTime+'</span>';
                }else{
                    return '';
                }
                }
            },
            {'data': 'orderStatusName','render':function(status_name,type,full){
                if(status_name)
                {
                    if(status_name=='Cancel')
                    {
                       return '<span id="statusName" class="txt-sline txt-blue">Cancelled</span>' 
                   }else{
                    return '<span id="statusName" class="txt-sline txt-blue">'+status_name+'</span>'
                   }
               }else if('reporter_id' in full){
                return '<span id="statusName" class="txt-blue">New Rx</span>';
               }else{
                return '';
               }
                
            }},
            {'data': 'RxNumber','render':function(rx, type, full){
              
                if(rx)
                {
                    @can('order status popup')
                   return '<a class="td_u_" href="javascript:void(0)" p-name="'+full.p_name+'" id="rx_check_'+full.order_id+'" onclick="editOrderPopup('+full.order_id+',\''+full.p_name+'\',\''+full.orderStatusName+'\','+full.OrderStatus+','+full.p_id+')">'+rx+'</a>';
                   @else 
                    return rx;
                   @endcan 
               }else if('reporter_id' in full){
                    @can('order status popup')
                    return '<a href="javascript:get_order_reporter('+full.id+');">UNASSIGNED</a>';
                    @else
                        return 'UNASSIGNED';
                    @endcan
               }else{
                return '';
               }
                
            }},
            {'data': 'reporter_name','render':function(rp_name,type,full){
                if(rp_name)
                {
                    return '<span class="txt-sline">'+rp_name.toUpperCase()+' - <span class="txt-blue weight_600">  HCP</span></span>';
                }else{
                    return '';
                }
            }},
            {'data': 'requested_by','render':function(req_by,type,full){
                if(req_by)
                {
                    if('reporter_id' in full)
                    {
                        return '<span>'+req_by.toUpperCase()+'</span>';
                    }else{
                        @can('patient detail view page')
                       return '<a class="td_u_" href="{{url("specific-patient-orders")}}/'+full.Id+'"><span>'+req_by.toUpperCase()+(full.is_pip_patient == 'Y'?' -PIP':'')+'</span></a>'; 
                       @else
                        return req_by.toUpperCase();
                       @endcan
                    }
                    
                }else{
                    return '';
                }
            }},
            {'data': 'rx_label_name','render':function(rx_label_name,type,full){
                if(full.orderStatusName=='General_Question')
                {
                    return 'Patient General Question';
                }else if(rx_label_name){
                    if('reporter_id' in full)
                    {
                        return rx_label_name;
                    }else{
                        return rx_label_name+' '+(full.strength==null ? "": full.strength)+' '+full.dosage_form;
                    }
                }else{
                    return '';
                }
                
            }},
            {'data': 'brand_reference','render':function(brand_reference){
                if(brand_reference)
                {
                    return brand_reference;
                }else{
                    return '';
                }
            }},
            {'data': 'Quantity','render':function(qty,type,full){
                if(qty)
                {
                    return qty;
                }else if('reporter_id' in full){
                    return full.quantity;
                }else{
                    return '';
                }
            }},
            {'data': 'asistantAuth','render':function(assis_auth,type,full){
                if(full.orderStatusName=='General_Question')
                {
                    return '';
                }
                if(assis_auth)
                {
                    assis_auth=assis_auth;
                }else{
                    assis_auth=0;
                }
                return '$ '+assis_auth.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }},
            {'data': 'Message','render':function(message,type,full){

                if(full.viewStatus == 'HcpReq_Created'){
console.log(full);
return  `<span id="question_td_1033">
                					<a class="txt-red" id="question_btn_1033">Renewel Request:</a>
                				</span>
                				<div class="d-ib_ elm-right pos-rel_  renewal-details">
                                            
                                    <div class="fa fa-eye eye-btn pos-rel_ cur-pointer txt-blue fs-18-force_ "></div>
                                    <div class="inner-rw-details br-rds-6 p8-12_ pos-abs_ bg-yellow2" style="left: -62px;top:27px;">
                                        <div class="trow_ pb-7_ " style="border-bottom: solid 1px #cecece;">
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">`+full.requested_by+` (`+full.Gender+`)</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_500">dob: `+full.BirthDate+`</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_400">Ph: `+full.MobileNumber.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3")+`</div>
                                        
                                        </div>
                                        <div class="trow_ pb-7_ pt-7_" style="border-bottom: solid 1px #cecece;">
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">prescriber name:</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_cc_ weight_500">`+full.PrescriberName+`</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">prescriber phone:</div>
                                        <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_cc_ weight_500">Ph: `+full.PrescriberPhone.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3")+`</div>
                                        
                                        </div><div class="trow_ pb-7_ pt-7_" style="border-bottom: solid 1px #cecece;">
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">drug name:</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 weight_500">`+(full.rx_label_name== null?"":full.rx_label_name)+' '+(full.strength==null ? "": full.strength)+' '+(full.dosage_form==null ? "": full.dosage_form)+`</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">generic for:</div>
                                        <div class="trow_ fs-13_ cnt-left_ txt-black-24 weight_500">`+(full.brand_reference== null?"":full.brand_reference)+`</div>
                                        
                                        </div>
                                                    
                                        <div class="trow_">
                                            <div class="flx-justify-start">
                                            <a class="flx-justify-start flex-vr-center" href="javascript:refillRequestOrder('`+full.nextRefillDate+`',`+full.order_id+`)"  data-forRefillOrder="`+full.order_id+`">
                                                <span class="txt-blue mr-4_">&#10004;</span>
                                                <span class="txt-blue" >Create Refill</span>
                                            </a></div>
                                        </div>
                                    </div>
                                </div>`;
                                
                                            // <a class="ml-auto flx-justify-start flex-vr-center">
                                            //     <span class="txt-red mr-4_" style="border: solid 1px #ec1717; border-radius: 50%; min-width: 16px; text-align: center; font-size: 10px; line-height: 14px;">&#10005;</span>
                                            //     <span class="txt-red">Decline</span>
                                            // </a>
                                            
return  `Renewel Request: <a href="javascript:refillRequestOrder('`+full.nextRefillDate+`',`+full.order_id+`)"    class="elm-right hover-black-child_"  data-forRefillOrder="`+full.order_id+`">
                      <span class="rd_"><img style="height: auto; width: 24px;" src="{{asset("images/icon/rd_icon.png")}}"></span>
         </a>`;

}


                if(full.orderStatusName!="General_Question" && message && message!=null && full.qId)
                {
                    @can('patient messages')
                    return '<span id="question_td_'+full.qId+'"><a class="'+(full.message_status!='received' ?"txt-green":"blink-icon txt-red")+'" id="question_btn_'+full.qId+'" onclick="orderMessages('+full.order_id+',\''+full.RxNumber+'\',`'+full.rx_label_name+' '+(full.major_reporting_cat==null ? "" : full.major_reporting_cat)+'`,\''+(full.strength==null ? "" : full.strength)+'\',\''+full.p_name+'\','+full.PracticeId+','+full.p_id+',\''+full.requested_by+'\')" title="'+message+'" class="td_u_" href="javascript:void(0);">'+message+'</a></span>';
                    @else
                        return message;
                    @endcan
                }
                else if(full.orderStatusName=="General_Question" && full.qId)
                {
                    @can('patient messages')
                    return '<span id="question_td_'+full.qId+'"><a class="'+(full.message_status!='received' ?"txt-green":"blink-icon txt-red")+'" id="question_btn_'+full.qId+'" onclick="generalMessages('+full.qId+',\''+full.requested_by+'\','+full.p_id+','+full.Practice_ID+')"  title="'+full.Question+'" class="td_u_" href="javascript:void(0);">'+(full.Question.length > 50 ? full.Question.substring(0,50)+"..." :  full.Question )+'</a></span>';
                    @else
                        return (full.Question.length > 50 ? full.Question.substring(0,50)+"..." :  full.Question );
                    @endcan
                }
                // else if(full.message_status == 'received'){
                //     return '<span id="question_td_'+full.qId+'"><a class="blink-icon txt-red" id="question_btn_'+full.qId+'" onclick="orderMessages('+full.order_id+',\''+full.RxNumber+'\',\''+full.rx_label_name+' '+(full.major_reporting_cat==null ? "" : full.major_reporting_cat)+'\',\''+(full.strength==null ? "" : full.strength)+'\',\''+full.p_name+'\','+full.PracticeId+','+full.p_id+',\''+full.requested_by+'\')" title="'+message+'" class="td_u_" href="javascript:void(0);">'+message+'</a></span>';
                // }
                else{
                    return '';
                }
            }},
            @if(!auth::user()->hasRole('practice_admin') && !auth::user()->can('practice admin'))
            {'data':'p_name','render':function(p_name,type,full){
                if(p_name)
                {
                    return p_name;
                }else if('reporter_id' in full){
                    return full.practice_name;
                }
                else{
                    return '';
                }
            }}

            @endif

            ],
            'createdRow': function(row, d, di){
            if('reporter_id' in d)
            {
                $(row).attr("data-oid", d.id);
            }else if(d.orderStatusName=='General_Question'){
                    $(row).attr("data-oid", d.orderStatusName);
            }else{
                $(row).attr("data-oid", d.order_id);
            }
          $(row).children(':nth-child(3)').addClass('tt_uc_ cnt-right txt-sline');
          $(row).children(':nth-child(5)').addClass('txt-sline');
          if(d.orderStatusName=="General_Question")
          {
            $(row).children(':nth-child(6)').css('text-align','center');
          }else{
            $(row).children(':nth-child(6)').addClass('txt-sline');
           }
          $(row).children(':nth-child(7)').addClass('txt-sline').attr('style', 'color: #9d9292c9 !important');
          $(row).children(':nth-child(8)').addClass('cnt-right quantity');
          $(row).children(':nth-child(9)').addClass('cnt-right assist-auth');
            }

        });
    $('#filter_btn').on('click',function(e){
        e.preventDefault();
        if($.fn.DataTable.isDataTable( '.compliance-user-table' )){  $('.compliance-user-table').DataTable().destroy(); }

        $('.compliance-user-table').DataTable({
            processing: true,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            pageLength: 10,
            "language": {
    "infoFiltered": ""
  },
            ajax: {
                "type": "post",
                "url": '{{ url("order-listing") }}?'+$('#request_filter').serialize(),
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "orders",
                "data": function(data){
                    
                },
                "complete": function(response){
                    console.log(response);
                    if(JSON.parse(response.responseText).all_order_list_ids){
                        orderListIds=[];
                        patientListIds=[];
                    allOrderListingIds=JSON.parse(response.responseText).all_order_list_ids;
                        for(var i = 0; i < allOrderListingIds.length; i++) {
                            var orderItems = allOrderListingIds[i];
                            orderListIds.push(orderItems[0]);
                            patientListIds.push(orderItems[1]);
                        }
                    }
                    console.log("ALL ORDERLIST simple v2:"+orderListIds);
                    
                    // insert HCP order ids in allOrderList

                    if(JSON.parse(response.responseText).new_order_list)
                    {
                        allOrderList=JSON.parse(response.responseText).new_order_list;
                    }
                    console.log("ALL ORDERLIST new HCP",allOrderList);


                }
            },
            columns: [
            {'data': 'order_created_at', 'render': function(bdate,type,full){
                if(bdate){
                    var o_date;
                    if(full.Message && full.Message!=null && (full.message_status == 'received' || full.message_status == 'sent'))
                    {
                        o_date=full.msgTime;
                    }else{
                        o_date=bdate;
                    }
                    var d = new Date(o_date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear().toString().substr(-2);

                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                    day = '0' + day;
                    var hours = d.getHours();
                    var minutes = d.getMinutes();
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    var strTime = hours + ':' + minutes + ' ' + ampm;

                    return '<span class="trow_ fs13-lh13_ cnt-center" style="max-width:70px;display:block;">'+[ month, day,year].join('/')+'</span><span class="trow_ fs9-lh11_ cnt-center" style="max-width:70px;display:block;margin-top:4px;font-size: 10px;">'+strTime+'</span>';
                }
                else if ('reporter_id' in full){
                    var d = new Date(full.created_at),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear().toString().substr(-2);

                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                    day = '0' + day;
                    var hours = d.getHours();
                    var minutes = d.getMinutes();
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    var strTime = hours + ':' + minutes + ' ' + ampm;

                    return '<span class="trow_ fs13-lh13_ cnt-center" style="max-width:70px;display:block;">'+[ month, day,year].join('/')+'</span><span class="trow_ fs9-lh11_ cnt-center" style="max-width:70px;display:block;margin-top:4px;font-size: 10px;">'+strTime+'</span>';
                }else{
                    return '';
                }
                }
            },
            {'data': 'orderStatusName','render':function(status_name,type,full){
                if(status_name)
                {
                    if(status_name=='Cancel')
                    {
                       return '<span id="statusName" class="txt-sline txt-blue">Cancelled</span>' 
                   }else{
                    return '<span id="statusName" class="txt-sline txt-blue">'+status_name+'</span>'
                   }
               }else if('reporter_id' in full){
                return '<span id="statusName" class="txt-blue">New Rx</span>';
               }else{
                return '';
               }
                
                
            }},
            {'data': 'RxNumber','render':function(rx, type, full){
              
                if(rx)
                {
                    @can('order status popup')
                   return '<a class="td_u_" href="javascript:void(0)" p-name="'+full.p_name+'" id="rx_check_'+full.order_id+'" onclick="editOrderPopup('+full.order_id+',\''+full.p_name+'\',\''+full.orderStatusName+'\','+full.OrderStatus+','+full.p_id+')">'+rx+'</a>';
                   @else
                        return rx; 
                   @endcan
               }else if('reporter_id' in full){
                    @can('order status popup')
                    return '<a href="javascript:get_order_reporter('+full.id+');">UNASSIGNED</a>';
                    @else 
                        return 'UNASSIGNED';
                    @endcan
               }else{
                return '';
               }

            }},
            {'data': 'reporter_name','render':function(rp_name,type,full){
                if(rp_name)
                {
                    return '<span class="txt-sline">'+rp_name.toUpperCase()+' - <span class="txt-blue weight_600">  HCP</span></span>';
                }else{
                    return '';
                }
            }},
            {'data': 'requested_by','render':function(req_by,type,full){
                if(req_by)
                {
                    if('reporter_id' in full)
                    {
                        return '<span>'+req_by.toUpperCase()+'</span>';
                    }else{
                        @can('patient detail view page')
                       return '<a class="td_u_" href="{{url("specific-patient-orders")}}/'+full.Id+'"><span>'+req_by.toUpperCase()+(full.is_pip_patient == 'Y'?' -PIP':'')+'</span></a>';
                       @else 
                        return req_by.toUpperCase();
                       @endcan 
                    }
                    
                }else{
                    return '';
                }
            }},
            {'data': 'rx_label_name','render':function(rx_label_name,type,full){
                if(full.orderStatusName=='General_Question')
                {
                    return 'Patient General Question';
                }else if(rx_label_name){
                    if('reporter_id' in full)
                    {
                        return rx_label_name;
                    }else{
                        return rx_label_name+' '+(full.strength==null ? "": full.strength)+' '+(full.dosage_form==null ? "": full.dosage_form);
                    }
                }else{
                    return '';
                }
            }},
            {'data': 'brand_reference','render':function(brand_reference){
                if(brand_reference)
                {
                    return brand_reference;
                }else{
                    return '';
                }
            }},
            {'data': 'Quantity','render':function(qty,type,full){
                if(qty)
                {
                    return qty;
                }else if('reporter_id' in full){
                    return full.quantity;
                }else{
                    return '';
                }
            }},
            {'data': 'asistantAuth','render':function(assis_auth,type,full){
                if(full.orderStatusName=='General_Question')
                {
                    return '';
                }
                if(assis_auth)
                {
                    assis_auth=assis_auth;
                }else{
                    assis_auth=0;
                }
                return '$ '+assis_auth.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }},
            {'data': 'Message','render':function(message,type,full){

                if(full.viewStatus == 'HcpReq_Created'){
console.log(full);
                  return  `<span id="question_td_1033">
                					<a class="txt-red" id="question_btn_1033">Renewel Request:</a>
                				</span>
                				<div class="d-ib_ elm-right pos-rel_  renewal-details">
                                            
                                    <div class="fa fa-eye eye-btn pos-rel_ cur-pointer txt-blue fs-18-force_ "></div>
                                    <div class="inner-rw-details br-rds-6 p8-12_ pos-abs_ bg-yellow2" style="left: -62px;top:27px;">
                                        <div class="trow_ pb-7_ " style="border-bottom: solid 1px #cecece;">
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">`+full.requested_by+` (`+full.Gender+`)</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_500">dob: `+full.BirthDate+`</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_400">Ph: `+full.MobileNumber.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3")+`</div>
                                        
                                        </div>
                                        <div class="trow_ pb-7_ pt-7_" style="border-bottom: solid 1px #cecece;">
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">prescriber name:</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_cc_ weight_500">`+full.PrescriberName+`</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">prescriber phone:</div>
                                        <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_cc_ weight_500">Ph: `+full.PrescriberPhone.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3")+`</div>
                                        
                                        </div><div class="trow_ pb-7_ pt-7_" style="border-bottom: solid 1px #cecece;">
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">drug name:</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 weight_500">`+(full.rx_label_name== null?"":full.rx_label_name)+' '+(full.strength==null ? "": full.strength)+' '+(full.dosage_form==null ? "": full.dosage_form)+`</div>
                                            <div class="trow_ fs-13_ cnt-left_ txt-black-24 tt_uc_ weight_600">generic for:</div>
                                        <div class="trow_ fs-13_ cnt-left_ txt-black-24 weight_500">`+(full.brand_reference== null?"":full.brand_reference)+`</div>
                                        
                                        </div>
                                                    
                                        <div class="trow_">
                                            <div class="flx-justify-start">
                                            <a class="flx-justify-start flex-vr-center" href="javascript:refillRequestOrder('`+full.nextRefillDate+`',`+full.order_id+`)"  data-forRefillOrder="`+full.order_id+`">
                                                <span class="txt-blue mr-4_">&#10004;</span>
                                                <span class="txt-blue" >Create Refill</span>
                                            </a></div>
                                        </div>
                                    </div>
                                </div>`;
                                
                                            // <a class="ml-auto flx-justify-start flex-vr-center">
                                            //     <span class="txt-red mr-4_" style="border: solid 1px #ec1717; border-radius: 50%; min-width: 16px; text-align: center; font-size: 10px; line-height: 14px;">&#10005;</span>
                                            //     <span class="txt-red">Decline</span>
                                            // </a>
                                            
return  `Renewel Request: <a href="javascript:refillRequestOrder('`+full.nextRefillDate+`',`+full.order_id+`)"    class="elm-right hover-black-child_"  data-forRefillOrder="`+full.order_id+`">
                      <span class="rd_"><img style="height: auto; width: 24px;" src="{{asset("images/icon/rd_icon.png")}}"></span>
         </a>`;

}

                if(full.orderStatusName!="General_Question" && message && message!=null && full.qId)
                {
                    @can('patient messages')
                    return '<span id="question_td_'+full.qId+'"><a class="'+(full.message_status!='received' ?"txt-green":"blink-icon txt-red")+'" id="question_btn_'+full.qId+'" onclick="orderMessages('+full.order_id+',\''+full.RxNumber+'\',`'+full.rx_label_name+' '+(full.major_reporting_cat==null ? "" : full.major_reporting_cat)+'`,\''+(full.strength==null ? "" : full.strength)+'\',\''+full.p_name+'\','+full.PracticeId+','+full.p_id+',\''+full.requested_by+'\')" title="'+message+'" class="td_u_" href="javascript:void(0);">'+message+'</a></span>';
                    @else
                        return message;
                    @endcan
                }
                else if(full.orderStatusName=="General_Question" && full.qId)
                {
                    @can('patient messages')
                    return '<span id="question_td_'+full.qId+'"><a class="'+(full.message_status!='received' ?"txt-green":"blink-icon txt-red")+'" id="question_btn_'+full.qId+'" onclick="generalMessages('+full.qId+',\''+full.requested_by+'\','+full.p_id+','+full.Practice_ID+')"  title="'+full.Question+'" class="td_u_" href="javascript:void(0);">'+(full.Question.length > 50 ? full.Question.substring(0,50)+"..." :  full.Question )+'</a></span>';
                    @else
                        return (full.Question.length > 50 ? full.Question.substring(0,50)+"..." :  full.Question );
                    @endcan
                }
                // else if(full.message_status == 'received'){
                //     return '<span id="question_td_'+full.qId+'"><a class="blink-icon txt-red" id="question_btn_'+full.qId+'" onclick="orderMessages('+full.order_id+',\''+full.RxNumber+'\',\''+full.rx_label_name+' '+(full.major_reporting_cat==null ? "" : full.major_reporting_cat)+'\',\''+(full.strength==null ? "" : full.strength)+'\',\''+full.p_name+'\','+full.PracticeId+','+full.p_id+',\''+full.requested_by+'\')" title="'+message+'" class="td_u_" href="javascript:void(0);">'+message+'</a></span>';
                // }
                else{
                    return '';
                }
            }},
            @if(!auth::user()->hasRole('practice_admin') && !auth::user()->can('practice admin'))
            {'data':'p_name','render':function(p_name,type,full){
                if(p_name)
                {
                    return p_name;
                }else if('reporter_id' in full){
                    return full.practice_name;
                }
                else{
                    return '';
                }
            }}

            @endif

            ],
            'createdRow': function(row, d, di){
                if('reporter_id' in d)
                {
                    $(row).attr("data-oid", d.id);
                }else if(d.orderStatusName=='General_Question'){
                    $(row).attr("data-oid", d.orderStatusName);
                }else{
                   $(row).attr("data-oid", d.order_id); 
                }
          $(row).children(':nth-child(3)').addClass('tt_uc_ cnt-right txt-sline');
          $(row).children(':nth-child(5)').addClass('txt-sline');
          if(d.orderStatusName=="General_Question")
          {
            $(row).children(':nth-child(6)').css('text-align','center');
          }else{
            $(row).children(':nth-child(6)').addClass('txt-sline');
           }
         
          $(row).children(':nth-child(7)').addClass('txt-sline').attr('style', 'color: #9d9292c9 !important');
          $(row).children(':nth-child(8)').addClass('cnt-right quantity');
          $(row).children(':nth-child(9)').addClass('cnt-right assist-auth');
            }

        });
    });

    });

    $('#history_btn').click(function(){

    });

    function refillRequestOrder(nextRefill,oid){

$('a[data-forRefillOrder="'+oid+'"]').hide();
// return;
console.log(nextRefill);

var q = new Date();
console.log(q);
var m = q.getMonth()+1;
var d = q.getDay();
var y = q.getFullYear();

var date = new Date();
console.log(date);
  var nextrefill = new Date (nextRefill);
  console.log(nextrefill);
//   var today = new Date(y,m,d);
// alert(date + '=>' + nextRefill );
// return false;
// var url = '{{url("create-refill-order/")}}'+'/'+oid+'/'+stoken;
if(date <= nextrefill){
    console.log('current date is smaller early refill request');
    toastr.remove();
    toastr.clear();
    toastr.options = {
timeOut: 0,
extendedTimeOut: 0
// ,
// tapToDismiss: false
};

 toastr.info("This patient has not consumed 83% of medicine.Do you really want to generate refill?<br/>\
 <button onclick='enableRefillButton("+oid+")' type='button' class='btn clear toast-hov'>No</button> <button onclick='sendRefillRequest("+oid+");' type='button' class='btn clear toast-hov'>Yes</button>");
//  onclick="window.location.href = '+url+'"
toastr.options = {
timeOut: 5000,
extendedTimeOut: 1000
// ,
// tapToDismiss: false
};   
}
else{
   sendRefillRequest(oid);
//    $('a[data-forRefillOrder="'+oid+'"]').closest('tr').remove();
    // window.location.href = '{{url("create-refill-order/")}}'+'/'+oid+'/'+stoken;
    // alert('no');
}
  console.log(date);
 
}


function enableRefillButton(oid){
$('a[data-forRefillOrder="'+oid+'"]').show();
return false;
}

function sendRefillRequest(oid)
{
$.ajax({
        url: '{{url("create-refill-order/")}}',
        data: 'order_id='+oid+'&renewel_req=ture',
        method: 'post',
        success: function(result){
            if(result.refillDone){
                toastr.success(result.refillMessage);
                $('a[data-forRefillOrder="'+oid+'"]').closest('tr').remove();
            }else{
                toastr.error(result.refillMessage); 
                $('a[data-forRefillOrder="'+oid+'"]').show();
            }
            
        },
        error: function(data){
        }
        });
// alert('no');
//  window.location ='{{url("create-refill-order/")}}'+'/'+oid+'/'+stoken;
}



    /*function validateChange(field_id)
    {
        if(field_id == 'quantity'){
            if($('#quantity').val() > 0){
                $('#drugPrice').val($('#orig_unit_price').val() * $('#quantity').val());
                $( "#drugPrice" ).blur();
            }                
        }
    }*/
    function validateChange(field_id)
    {
            console.log(field_id + '  '+ $('#orderstatusname').text());
           // if($('#orderstatusname').text() == `Pt. Requested Refill` || $('#orderstatusname').text() == `New Order`){
                var qty1= parseFloat($("#"+field_id).val());
                var qty2= parseFloat($("#"+field_id+"_orig").val());

                if(field_id == 'quantity' && qty1 != qty2){
                    $('#mbr-pay').prop('disabled', true);

                    if($('#quantity').val() > 0){
                        //var OrigPrice = parseFloat($('#drugPrice_orig').val().replace("$", ""));
                        //var unitPrice = (OrigPrice/parseFloat($('#quantity_orig').val()));
                        $('#drugPrice').val($('#orig_unit_price').val() * $('#quantity').val());
                        $( "#drugPrice" ).blur();
                    }                

                }else if($("#"+field_id).val() != $("#"+field_id+"_orig").val()){
                    $('#mbr-pay').prop('disabled', false);
                }
                
                if(qty1 == qty2 && $("#daysSupplyFld").val() == $("#daysSupplyFld_orig").val() && $("#RefillsRemaining").val() == $("#RefillsRemaining_orig").val() && $("#drugPrice").val() == $("#drugPrice_orig").val() && $("#thirdPartyPaid").val() == $("#thirdPartyPaid_orig").val() && $("#pocketOut").val() == $("#pocketOut_orig").val() && $("#asistantAuth_orig").val() == $("#asistantAuth_orig").val() ){
                    $('#mbr-pay').prop('disable', true);
                }
            //}
    }

    function strengthChangeTrigger(obj){
                console.log('dosage strength changed....');
                
                //on strength change send edits to hcp
                if(localStorage.getItem('Strength') != obj.value){
                    $('#mbr-pay').prop("disable", true);
                    $('#hcp_comment_area').show();
                    $('#send_edits_to_hcp_btn').show();
                    $('#pharmacy_comments_area').val("");
                }else{
                    $('#mbr-pay').prop("disable", false);
                    $('#hcp_comment_area').hide();
                    $('#send_edits_to_hcp_btn').hide();
                    $('#sent_edits_to_hcp_btn').hide();
                }
    }
</script>
@endsection
