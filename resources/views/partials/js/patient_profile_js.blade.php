<script src="{{ url('js/jquery.maskMoney.js') }}" type="text/javascript"></script>
<script>
    
        /*function validateChange(field_id)
        {
            console.log(field_id + '  '+ $('#orderstatusname').text());
            if($('#orderstatusname').text() == `Pt. Requested Refill`){
            var qty1= parseFloat($("#"+field_id).val());
            var qty2= parseFloat($("#"+field_id+"_orig").val());

            if(field_id == 'quantity' && qty1 != qty2){
                $('#mbr-pay').prop('disabled', false);

                if($('#quantity').val() > 0){
                    var OrigPrice = parseFloat($('#drugPrice_orig').val().replace("$", ""));
                    var unitPrice = (OrigPrice/parseFloat($('#quantity_orig').val()));
                    $('#drugPrice').val(unitPrice * $('#quantity').val());
                    $( "#drugPrice" ).blur();
                }                

            }else if($("#"+field_id).val() != $("#"+field_id+"_orig").val()){
                $('#mbr-pay').prop('disabled', false);
            }
            
            if(qty1 == qty2 && $("#daysSupplyFld").val() == $("#daysSupplyFld_orig").val() && $("#RefillsRemaining").val() == $("#RefillsRemaining_orig").val() && $("#drugPrice").val() == $("#drugPrice_orig").val() && $("#thirdPartyPaid").val() == $("#thirdPartyPaid_orig").val() && $("#pocketOut").val() == $("#pocketOut_orig").val() && $("#asistantAuth_orig").val() == $("#asistantAuth_orig").val() ){
                $('#mbr-pay').prop('disabled', true);
            }
            }
        }*/
        function readURL1(input) {
            var _URL = window.URL || window.webkitURL;
          if (input.files && input.files[0]) {
            var image_types=['image/gif', 'image/jpeg', 'image/png']
            if(image_types.includes(input.files[0].type)){

                var img = new Image();

                img.onload = function() {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                      $('#pre-show img').attr('src', e.target.result);
                      $('#pre-show .file-upload').hide();
                      $('#pre-show img').show();
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
                img.src = _URL.createObjectURL(input.files[0]);
            }else{
                var fileReader = new FileReader();
                fileReader.onload = function(e){

                $('#pre-show .file-upload').addClass('fas fa-file').empty().html(input.files[0].name);

    

              };
              fileReader.readAsDataURL(input.files[0]);
              $('#pre-show .file-upload').show();
                $('#pre-show img').hide();  
               
            }
          }
        }

        $("#message_img").change(function() {
          readURL1(this);
        });
        function removeElement(array, elem) {
            var index = array.indexOf(elem);
            if (index > -1) {
                array.splice(index, 1);
            }
        }

        function check_validation() {
            if ($('#datepicker_from').val() != '' && $('#datepicker_to').val() == '') {
                toastr.error( 'Please select the end date.');
                return false;
            } else {
                return true
            }
        }

        function reset_dropdown()
        {
            $("#practice_name").val("").trigger('change');
        }
      
        var allOrderListingIds = [];
        var orderListIds = [];
        var patientListIds = [];
        <?php if(isset($all_order_list)){ ?>
            var allOrderListingIds = JSON.parse('{{$all_order_list}}');
            for(var i = 0; i < allOrderListingIds.length; i++) {
                        var orderItems = allOrderListingIds[i];
                        orderListIds.push(orderItems[0]);
                        patientListIds.push(orderItems[1]);
            }
        <?php } ?>
            console.log("ALL ORDERLIST:"+orderListIds);
            
        function editOrderPopup(orderId,prac_name,o_status,os_id,p_id)
        {    
               
            $('form#clinical_form2 input[name="OrderId"],form#patient_form2 input[name="OrderId"]').val(orderId);
            $('form#clinical_form2 input[name="PatientId"],form#patient_form2 input[name="PatientId"]').val(p_id);
            $('#prev_order_edit').prop( "disabled", false );
            $('#next_order_edit').prop( "disabled", false );
            $('#skip_order').attr('open_next',"true");
           // $('#orig_date_id').hide();
            $('#print_button').hide(); 
            $('#print_button a').attr('href','#');   
            
            $('#pharmacy-txt').text(prac_name + ' PHARMACY')
          $.ajax({
        		url:"{{url('/edit/order')}}",
        		method:'get',
        		data:{order_id: orderId},
        		success:function(response){
        			console.log(response.data);
                    var orderData=response.data[0];
                    var allRefills = orderData.AllRefills;
                    var lowerCostOpt = orderData.lower_cost_opt;
                    var logs = response.history;
                    var activities = response.activities;
                    console.log(lowerCostOpt);
                    if(lowerCostOpt == 0 || os_id == 8 || os_id == 27){
                        $("#lower_cost_drug_button").hide();
                    }else
                        $("#lower_cost_drug_button").show();
                    
                    if(response.base_fee)
                    {
                      console.log("base",response.base_fee.fee)
                      $('#order_edit_Modal #fee-auth-zero').val(response.base_fee.base_fee);
                      $('#order_edit_Modal #fee-auth-nonzero').val(response.base_fee.fee);
                    }
                    if(orderData){
                        $('#barcode').html('');
                        $('#barcode1').html('');
                        $('#under_review_reason_div #under_review_reason_div_span').text('').parent('#under_review_reason_div').hide();
                        $('#pat_mobile').val('');
                        $('#pat_mobile').val(orderData.MobileNumber);
                        $('form#clinical_form2 input[name="PracticeId"],form#patient_form2 input[name="PracticeId"]').val(orderData.PracticeId);
                        $('#lower_rx_ing_cost').html('$'+orderData.unit_price);       

                        //set history values
                        const getAge = birthDate => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e+10)
                        $('#hist_rx_no').html("Rx: "+orderData.RxNumber+"-0"+orderData.RefillCount);
                        $('#hist_drug_stren_dosage').html(orderData.rx_label_name+" "+(orderData.Strength == 'null' || orderData.Strength == null?"":orderData.Strength)+" "+(orderData.DrugType == 'null' || orderData.DrugType == null?"":orderData.DrugType));
                        $('#hist_pharmacy').html(orderData.practiceName);
                        $('#hist_gpi_no').html("GPI-14: "+orderData.generic_pro_id);
                        $('#hist_patient').html(orderData.requested_by);
                        $('#hist_patient_dob').html('DOB: '+GetParsedDate(orderData.BirthDate));
                        $('#hist_patient_age').html(' ('+getAge(orderData.BirthDate)+' yrs)');
                        $('#hist_patient_phone').html(orderData.MobileNumber.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3"));
                        $('#hist_drug_major_cat').html(orderData.major_reporting_cat);
                        $('#hist_drug_minor_cat').html(orderData.minor_reporting_class);

                        var tblRows = "";

                        if(logs.length > 0){
                            var index = logs.length - parseInt(1);
                            $.each(logs,function(key,val){   

                                tblRows += `<tr><td class="txt-black-24 tt_uc_ weight_600">-0`+index+`</td><td class="cnt-left-force">`+(val.service_date == '' || val.service_date == null || val.service_date == 'null' || val.service_date == '00-00-0000'?"":GetParsedDate(val.service_date))+`</td><td class="cnt-left-force">`+orderData.ndc+`</td><td class="cnt-center-force">`+val.Quantity+`</td>`;
                                tblRows += `<td class="cnt-left-force">`+val.DaysSupply+`</td><td class="cnt-right-force">$`+val.RxIngredientPrice+`</td><td class="cnt-right-force">$`+val.RxThirdPartyPay+`</td><td class="cnt-right-force">$`+val.asistantAuth+`</td>`;				
                                tblRows += `<td class="cnt-right-force c-dib_"><span class="mr-4_">$`+val.RxPatientOutOfPocket+`</span><span class="hstr-pref-pl-mn-btn cur-pointer weight_600 fs-16_ txt-center" href="#expand-collpase-tr`+index+`" aria-controls="expand-collpase-tr`+index+`" for="expand-collpase-tr`+index+`" role="button" data-toggle="collapse" aria-expanded="false" style="width: 16px;height: 16px;"></span></td></tr>`;                                
                                
                                var statusLogs = val.statuslogs;
                                if(statusLogs.length > 0){
                                    tblRows += `<tr id="expand-collpase-tr`+index+`" style="padding: 0;" class="collapse" data-parent="#history_preference_table"><td class="" colspan="9" style="padding-left: 6%; padding-right: 6%;"><table class="table bordered hst-prf-inner-table hd-row-green-shade-rounded">`;
                                    tblRows += `<thead><tr class="weight_500-force-childs bg-blue"><th class="txt-wht">Date</th><th class="txt-wht cnt-center-force">Service</th><th class="txt-wht cnt-center-force">Detail</th><th class="txt-wht cnt-center-force">Earned Award</th></tr></thead><tbody>`;

                                    $.each(statusLogs, function(key1, val1){                                        
                                        var index = statusIds.indexOf(val1.status_id);
                                        tblRows += `<tr><td class="cnt-left-force">`+GetFormattedDateOnly(val1.created_at)+`</td><td class="cnt-left-force">`+statusList[index]+`</td><td class="cnt-left-force">`+((val1.status_id == 8?orderData.practiceName:'$'+val.RxFinalCollect))+((val1.status_id == 10?" Compliance Reward Card":""))+` </td><td class="cnt-left-force">`+((val1.status_id == 8?parseFloat(val.asistantAuth/4)+" VGW":""))+`</td></tr>`;
                                    });

                                    $.each(activities, function(key1, val1){                                        
                                        tblRows += `<tr><td class="cnt-left-force">`+GetFormattedDateOnly(val1.Created_On)+`</td><td class="cnt-left-force">Pt. Activity</td><td class="cnt-left-force">`+val1.Activity_Name+`</td><td class="cnt-left-force">$`+val.RxFinalCollect+`</td></tr>`;
                                    });

                                    tblRows += `</tbody></table></td></tr>`;
                                }else{
                                    if(activities.length > 0){
                                        tblRows += `<tr id="expand-collpase-tr`+index+`" style="padding: 0;" class="collapse" data-parent="#history_preference_table"><td class="" colspan="9" style="padding-left: 6%; padding-right: 6%;"><table class="table bordered hst-prf-inner-table hd-row-green-shade-rounded">`;
                                        tblRows += `<thead><tr class="weight_500-force-childs bg-blue"><th class="txt-wht">Date</th><th class="txt-wht cnt-center-force">Service</th><th class="txt-wht cnt-center-force">Detail</th><th class="txt-wht cnt-center-force">Earned Award</th></tr></thead><tbody>`;

                                        $.each(activities, function(key1, val1){                                        
                                            tblRows += `<tr><td class="cnt-left-force">`+GetFormattedDateOnly(val1.Created_On)+`</td><td class="cnt-left-force">Pt. Activity</td><td class="cnt-left-force">`+val1.Activity_Name+`</td><td class="cnt-left-force">$`+val.RxFinalCollect+`</td></tr>`;
                                        });

                                        tblRows += `</tbody></table></td></tr>`;
                                    }else{
                                        tblRows += `<tr id="expand-collpase-tr`+index+`" style="padding: 0;" class="collapse" data-parent="#history_preference_table"><td class="" colspan="9" style="padding-left: 6%; padding-right: 6%;">No History Found!</td></tr>`;
                                    }                                    
                                }
                                index = parseInt(index) - parseInt(1);
                            });    
                            tblRows += `<tr class="td-pad-0"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>`;                        
                        }

                        $("#history_preference_table tbody").html(tblRows);
                        //******************//
                        
                        $('#print_button a').attr('href', function() {
                            return "{{url('print-order?order=')}}" + orderId;
                        });
                        $('#print_button').show();


                        $('#barcode').html(response.barCode);
                        $('#barcode1').html(response.barCode1);
                            if(orderData.OrderStatus == 24)
                            {
                                $('#under_review_reason_div #under_review_reason_div_span').text(orderData.under_review_reason?orderData.under_review_reason:'-').parent('#under_review_reason_div').show();
                                $('#prescriber_div_id').css('margin-top','-60px');
                            }
                            

                            console.log(orderData);

                            if(orderData.RxProfitability > 0){
                                if(document.getElementById("rxProfitability").classList.contains('txt-red')){
                                    document.getElementById('rxProfitability').classList.remove('txt-red');
                                }
                                document.getElementById('rxProfitability').classList.add('txt-grn-lt');
                            }else{
                                if(document.getElementById("rxProfitability").classList.contains('txt-grn-lt')){
                                document.getElementById('rxProfitability').classList.remove('txt-grn-lt');
                                }
                                document.getElementById('rxProfitability').classList.add('txt-red');
                            } 
                    }
                    $('#order_edit_Modal').modal('show');                    
                    /*$.each(allRefills,function(key,val){
                        if(orderId == val){
                            if(key>0){
                                prev =  allRefills[key-1];
                            }
                            
                            if(key<(parseInt(allRefills.length)-parseInt(1))){
                                next =  allRefills[key+1];
                            }
                        }
                        
                        console.log("KEY="+key+",Value="+val+",Len="+allRefills.length);
                    });*/
    
                    var prev = "";
                    var  next = "";                                        
                    for(var i = 0; i < orderListIds.length; i++) {
                        if(orderId == orderListIds[i]){
                            if(i>0){
                                prev =  orderListIds[i-1];
                                p_id1 = patientListIds[i-1];
                            }
                            
                            if(i<(parseInt(orderListIds.length)-parseInt(1))){
                                next =  orderListIds[i+1];
                                p_id2 = patientListIds[i+1];
                            }
                        }
                    }
                    
                    if(prev == "")
                        $('#prev_order_edit').prop( "disabled", true );
                    else{
                        $('form#clinical_form2 input[name="PatientId"],form#patient_form2 input[name="PatientId"]').val(p_id1);
                        $('#prev_order_edit').attr("onclick", "editOrderPopup("+prev+",'"+prac_name+"','"+o_status+"',"+os_id+","+p_id1+")");
                    }
                    if(next == ""){
                        $('#next_order_edit').prop( "disabled", true );
                        $('#skip_order').attr('open_next',"false");
                    }
                    else{
                        console.log("os_id:"+os_id);
                        $('form#clinical_form2 input[name="PatientId"],form#patient_form2 input[name="PatientId"]').val(p_id2);
                       if(os_id == 10)
                            $('#next_order_edit').attr("onclick", "editOrderPopup("+next+",'"+prac_name+"','"+o_status+"',"+os_id+","+p_id2+")");
                        else
                            $('#next_order_edit').attr("onclick", "confirmNextOrder("+next+",'"+prac_name+"','"+o_status+"',"+os_id+","+p_id2+");");
                        $('#copy_next_order_edit').attr("onclick", "editOrderPopup("+next+",'"+prac_name+"','"+o_status+"',"+os_id+","+p_id2+")");
                        $('#skip_order').attr("onclick", "skipOrder(29,"+next+",'"+prac_name+"','"+o_status+"',"+os_id+","+p_id2+");");
                    }
                    
            $.each(orderData,function(key,val){
      
                if(key=="drug_clinical_advise")
                {
                  return "";
                }
                if(key=="attachment")
                {
                  return "";
                }
            /*    if(key == "original_rx_date")
                {
                    if(val){
                    var dateAtr = val.split('-');
                    val = dateAtr[1] + '/' +dateAtr[2] + '/' + dateAtr[0];
                    console.log('or Date:'+val);
                    $('#rx_orig_date').html(val);
                }
                }  */
               

                if(key=="service_date")
                {                  
                  if(val !== '0000-00-00' && val != null) 
                  {
                     var dateAtr = val.split('-');
                      val = dateAtr[1] + '/' +dateAtr[2] + '/' + dateAtr[0];
                      $('#datetimepicker').datepicker('setDate', new Date(val));
                  }else{
                    $('#datetimepicker').datepicker('setDate', 'now');
                  }
                 
                  //$('#datetimepicker').datepicker('setDate', new Date(val));
              
                  //$('input[name="'+key+'"]').val(val);
                }
                else if(key=="rx_label_name")
                {
                  $('input[name="DrugName"]').val(val);
                }
                else if(key=="RxIngredientPrice" || key=="RxThirdPartyPay" || key=="RxPatientOutOfPocket" || key=="asistantAuth" || key=="RxSelling" || key=="RxProfitability")
                {
                    if(window.pharmacyNotification.isEmpty(val)|| window.pharmacyNotification.isBlank(val) )
                    {
                        $('input[name="'+key+'"]').val("$0.00");
                    }else{
                        console.log(val,val.toFixed(2));
                  $('input[name="'+key+'"]').val("$"+window.pharmacyNotification.numberWithCommas(val.toFixed(2)));   
                    }

                }
                else if(key=="Quantity")
                {
                  $('input[name="'+key+'"]').val(window.pharmacyNotification.numberWithCommas(val));                  
                }
                else if(key=="PrescriberPhone")
                {
                  $('input[name="'+key+'"]').val(val.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3"));
                }
                else if(key=="RxNumber")
                {
                  $('input[name="'+key+'"]').val(val+"-0"+orderData.RefillCount);
                }
                else{
        				  $('input[name="'+key+'"]').val(val);
                      }
         
        
              });
              $('#isPIPPatient').val('');
              if(orderData.is_pip_patient == 1){
                $('#mbr-pay').html("BILL TO PIP");
                $('#p-type').html(" - PIP Patient")
                $('#isPIPPatient').val('1');
              }else{
                $('#mbr-pay').html("MBR To PAY"); 
                $('#p-type').html("");              
              }

              ////////////For Mbr payment //////////

                   
            //   if(os_id == 23 && orderData.is_pip_patient == 1){
            //         $('#mbr-pay').prop("disabled",false);
            //     }
            //    if(os_id == 23 && orderData.is_pip_patient != 1){

            //         $('#mbr-pay').prop("disabled",false);
            //     }
                    var qty = parseFloat(orderData.Quantity);                    
                    $('#quantity').val(qty);
                    $('#quantity_orig').val(qty);
                    $('#daysSupplyFld_orig').val(orderData.DaysSupply);
                    $('#RefillsRemaining_orig').val(orderData.RefillsRemaining);
                    $('#drugPrice_orig').val($('#drugPrice').val());
                    $('#thirdPartyPaid_orig').val($('#thirdPartyPaid').val());
                    $('#pocketOut_orig').val($('#pocketOut').val());
                    $('#asistantAuth_orig').val($('#asistantAuth').val());
                    if(orderData.unit_price > 0 && orderData.unit_price != '0.0000')
                        $('#orig_unit_price').val(orderData.unit_price);
                    else{
                        var unitPrice = parseFloat(orderData.RxIngredientPrice/orderData.Quantity)
                        $('#orig_unit_price').val(unitPrice);
                        console.log("UnitPrice:"+unitPrice);
                    }     
               //////////End Mbr Payment/////////////
        	if(orderData.Status_Id && orderData.Status_Name)
                { 
                    if(orderData.Status_Name == 'Cancel')
                        $('#orderstatusname').html('Cancelled');
                    else
                    $('#orderstatusname').html(orderData.Status_Name);
                    console.log("orderst");
                    $('form#orderUpdateData button').each(function(key, val){

                    var dis_stat = $(val).attr('dis-status');
                    if(typeof dis_stat !== typeof undefined && dis_stat !== false) {
                        var dis_stat_arr = JSON.parse(dis_stat);
                        if($.inArray( orderData.Status_Id, dis_stat_arr )!== -1)
                        {
                            $(val).prop( "disabled", true );   //console.log(dis_stat_arr);
                        }
                        else
                        {
                            $(val).prop( "disabled", false ); 
                        }
                       console.log(dis_stat_arr);
                        }
                        if(os_id == 23 && orderData.is_pip_patient == 1){
                    $('#mbr-pay').prop("disabled",false);
                }
                 
                    });
                

                    if(orderData.Status_Name == 'Filled'){
                        $('#cancel_button').css('display','none');
                    }else{
                         $('#cancel_button').css('display','block');
                    }
                }

                if(orderData.OrderStatus == 2)
                        {
                        	var d = new Date();
 							d.setDate(d.getDate()-5);
 							console.log(d);
 							var origDate=orderData.RxOrigDate;
 							var dateAtr1 = origDate.split('-');
                  			origDate = dateAtr1[1] + '/' +dateAtr1[2] + '/' + dateAtr1[0];
 							var od=new Date(orderData.RxOrigDate);
 							if(od<=d)
 							{
 								$('#mbr-pay').prop("disabled",false);
 							}
                        }
                        if(orderData){
                          $('#p-nam').empty().html(orderData.requested_by);
                          $("#patientNameShow").html(orderData.requested_by.toUpperCase());
                          $('#p-gen').empty().html('('+orderData.Gender+')');

                          const getAge = birthDate => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e+10)

                           

                          $('#p-dob').empty().html('DOB: '+orderData.BirthDate+' ('+getAge(orderData.BirthDate)+' Y)' );

                          $('#p-mob').empty().html('Ph: '+orderData.MobileNumber);
                          if(orderData.RxOrigDate){
                            var origDate=orderData.RxOrigDate;
 							var dateAtr1 = origDate.split('-');
                  			origDate = dateAtr1[1] + '/' +dateAtr1[2] + '/' + dateAtr1[0];
 							// var od=new Date(orderData.RxOrigDate);
                             $('#rx_orig_date').empty().html(origDate)
                             $('#datetimepicker').datepicker('setStartDate',new Date(origDate));
                
                          }
                          
                        }
                        
         $('#chat_history').html('');
var prevmsg = '';        
var messages = '<ul data-v-6a49c60d="">';
$.each(response.data,function(key,val){

date = val.message_create;
status = val.message_status;
     if(val.Message){

        if(val.message_status == 'sent'){
messages += `<li data-v-6a49c60d="" class="message sent ma-0_" style="
    padding-bottom: 5px;
    margin: 0px;">
<div class="trow_ mb-2_">
<img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;">
<div class="trow_ txt-sline">
<span class="txt-grn-lt d-ib_ fs-12_ lh-14_">`+'{{auth::user()->name}}'+`</span> 
<span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.message_create)+`</span></div>
</div>
 <div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="
    padding: 4px 6px;
">`+val.Message +`</div>
</li>`;
if(val.attachment)
        {
            var file_ext=val.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext.toLowerCase())){
                messages+=`<div style="width: 170px;height: 80px;overflow: hidden;"><img src="{{asset("/")}}`+val.attachment+`" class="gallery"/></div>`; 
            }else{

                messages+=`<div style="float: left;margin-bottom: 5px;"><a href="{{asset('/')}}`+val.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+val.attachment.split('/').pop()+`</span></a></div>`;
            }
        }
}
else {
messages+= `<li data-v-6a49c60d="" class="message received mt-7_" style="
    padding-bottom: 5px;
    margin: 0px;
    margin-top: 7px;
">

<div class="trow_ mb-2_"><span class="txt-blue d-ib_ fs-12_ lh-14_ elm-right">`+$('#p-nam').text().toUpperCase()+`</span>
<span class="u-info d-ib_ tt_cc_ weight_600 mr-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.message_create)+`</span>
</div>
    <div data-v-6a49c60d="" class="text pa-4_ bg-grn-lk fs-13_ lh-17_" style="
    padding: 4px 6px;
">`+val.Message +`</div></li>
`;
		if(val.attachment)
        {
            var file_ext=val.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext.toLowerCase())){
                messages+=`<div style="width: 170px;height: 80px;overflow: hidden;float: right;"><img src="`+val.attachment+`" class="gallery"/></div>`; 
            }else{

                messages+=`<div style="float: right;margin-bottom: 5px;"><a href="`+val.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+val.attachment.split('/').pop()+`</span></a></div>`;
            }
        }
}


    // if(val.attachment)
    // {
    //  messages+=`<div style="width: 170px;height: 80px;overflow: hidden;margin-top: 8px;"><img src="{{asset("/")}}`+val.attachment+`"/></div>`; 
    // }

       
       
       
        }else{
//             messages +=      `<li data-v-6a49c60d="" class="message" style="
//     border-bottom: solid 1px #666;
//     padding-bottom: 5px;
// "> <div data-v-6a49c60d="" class="text"></div>
// </li>`;
        }
     });  
     messages += '</ul>';
     $('#chat_history').append(messages);    
    



        		},
        		error:function(error){

        		}
        	})
        }

    function lowerCostDrug()
    {
                $('.lower_cost').empty();
                 var low_cost = '';
                  var url3 = '{{url('/search-drug-lower-cost')}}';
                $.ajax({
                    url: url3,
                    data: 'search='+$('#DrugDetailId').val().trim(),
                   // data: 'search='+searchedResult[0].rx_label_name.trim(),
                    method: 'get',
                    success: function(result){
                         low_cost = $.parseJSON(result);

                       if(low_cost)
                       {
                        console.log('lower drug',low_cost);
                        
                        $('#lower_gpi').html((low_cost.generic_pro_id != null? low_cost.generic_pro_id : "-"));
                        $('#lower_dosage_strength').html(low_cost.dosage_form +" "+ low_cost.strength);
                        $('#lower_dea').html('#'+low_cost.dea);
                        $('#lower_drug_name').html(low_cost.rx_label_name);                        
                        $('#lower_gcnseq').html(low_cost.gcn_seq);
                        $('#lower_source').html((low_cost.sponsor_source != "" && low_cost.sponsor_source != null?low_cost.sponsor_source:"-"));
                        $('#lower_item').html(low_cost.id);
                        $('#lower_marketer').html(low_cost.marketer);
                        $('#lower_ndc').html(low_cost.ndc);
                        $('#lower_upc').html(low_cost.upc);
                        $('#lower_ing_cost').html('$'+low_cost.unit_price);
                        $('#lower_order_web_link').html(low_cost.order_web_link);
                        $('#lower_cost_drug_id').val(low_cost.id);
                        $('#lower_cost_drug_strength').val(low_cost.strength);
                        $('#lower_cost_drug_dosage').val(low_cost.dosage_form);
                        $('#lower_cost_drug_brand').val(low_cost.brand_reference);
                        
                      }
                      $('#lower_cost_modal').modal('show');
                    },
                    complete: function() {
                        //   requestSent = false;
            },
                    error: function(data){
                    }
                });

        }

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
		    return month + "-" + day + "-" + year;
	    }

        function GetParsedDate(d)
        {
            dateAr = d.split('-');
            var newDate = dateAr[1] + '-' +dateAr[2] + '-' + dateAr[0];
            return newDate;
        }

        function orderMessage()
        {
            if($('#rx_no').val() && $('#drug').val())
            {
 var str=$('input[name="Strength"]').val();
                $('#pat_mes_info').empty().html(`		  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Order Details:</span>
                	<span class="fs-14_ txt-blue weight_600">Rx No.</span>
                    <span class="fs-14_ txt-blue weight_500">`+$('#rx_no').val()+`</span>
                    <span class="fs-14_ mr-4_ ml-4_">|</span>
                	<span class="fs-14_ txt-blue weight_600">Drug Name:</span>
                    <span class="fs-14_ txt-blue weight_500">`+$('#drug').val()+`</span>
                    <span class="fs-14_ mr-4_ ml-4_">|</span>
                	<span class="fs-14_ txt-blue weight_600">`+str+`</span>
                	<span class="fs-14_ txt-blue weight_500"></span>
			  	</div>
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Patient Detail:</span>
                	<span class="fs-14_ txt-blue weight_600" id="patientNameShow">`+$('#p-nam').text()+`</span>
			  	</div>
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Pharmacy Name:</span>
                    <span class="fs-14_ txt-blue weight_500">`+$('#pharmacy-txt').text()+`</span>
			  	</div>
			  		`);
                // $('#pracPop').text($('#pharmacy-txt').text());
                // $('#rxPop').text($('#rx_no').val());
                

                // var str=$('input[name="Strength"]').val();
                
                // $("#medNamePop").text($('#drug').val()+"   "+str+"   "+$('#PackingDescr').val());


                $('#patientMessage').modal("show");
                $('#orderMessage').val($('#orderMsg').val());
            
            }

        }
     // order question all request question column seprate from Orderpop up sorry for inconvinience :(    
        function orderMessages(Id,RxNo,Drug,Strength,Practice,PracticeId,PatientId,PatientName)
        {
            $('#chat_history').html('');
            $.ajax({
                            url:"{{url('/edit/order')}}",
                            method:'get',
                            data:{order_id: Id},
                            success:function(response){
                                var prevmsg = '';        
                                var messages = '<ul data-v-6a49c60d="">';
                                $.each(response.data,function(key,val){
                                    date = val.message_create;
                                    status = val.message_status;
console.log(val);
                                    if(val.Message){
if(val.message_status == 'sent'){
messages += `<li data-v-6a49c60d="" class="message sent ma-0_" style="
    padding-bottom: 5px;
    margin: 0px;">
<div class="trow_ mb-2_">
<img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;">
<div class="trow_ txt-sline">
<span class="txt-grn-lt d-ib_ fs-12_ lh-14_">`+'{{auth::user()->name}}'+`</span> 
<span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.message_create)+`</span></div>
</div>
 <div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="
    padding: 4px 6px;
">`+val.Message +`</div>
</li>`;
if(val.attachment)
        {
            var file_ext=val.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext.toLowerCase())){
                messages+=`<div style="width: 170px;height: 80px;overflow: hidden;"><img src="{{asset("/")}}`+val.attachment+`" class="gallery"/></div>`; 
            }else{

                messages+=`<div style="float: left;margin-bottom: 5px;"><a href="{{asset('/')}}`+val.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+val.attachment.split('/').pop()+`</span></a></div>`;
            }
        }
}
else {
messages+= `<li data-v-6a49c60d="" class="message received mt-7_" style="
    padding-bottom: 5px;
    margin: 0px;
    margin-top: 7px;
">

<div class="trow_ mb-2_"><span class="txt-blue d-ib_ fs-12_ lh-14_ elm-right">`+PatientName+`</span>
<span class="u-info d-ib_ tt_cc_ weight_600 mr-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.message_create)+`</span>
</div>
    <div data-v-6a49c60d="" class="text pa-4_ bg-grn-lk fs-13_ lh-17_" style="
    padding: 4px 6px;
">`+val.Message +`</div></li>
`;
        if(val.attachment)
        {
            var file_ext=val.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext.toLowerCase())){
                messages+=`<div style="width: 170px;height: 80px;overflow: hidden;float: right;"><img src="`+val.attachment+`" class="gallery"/></div>`; 
            }else{

                messages+=`<div style="float: right;margin-bottom: 5px;"><a href="`+val.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+val.attachment.split('/').pop()+`</span></a></div>`;
            }
        }
}

                               
                                        

                                    }else{
                                      //  messages +=      `<li data-v-6a49c60d="" class="message" style="border-bottom: solid 1px #666;padding-bottom: 5px;"> <div data-v-6a49c60d="" class="text"></div></li>`;
                                    }
                                });  

                                messages += '</ul>';
                                $('#chat_history').append(messages); 
                                $("#chat_history").animate({ scrollTop: $("#chat_history")[0].scrollHeight}, 1000); 
                        }
            });

            $('#pat_mes_info').empty().html(`		  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Order Details:</span>
                	<span class="fs-14_ txt-blue weight_600">Rx No.</span>
                    <span class="fs-14_ txt-blue weight_500">`+RxNo+`</span>
                    <span class="fs-14_ mr-4_ ml-4_">|</span>
                	<span class="fs-14_ txt-blue weight_600">Drug Name:</span>
                    <span class="fs-14_ txt-blue weight_500">`+Drug+`</span>
                    <span class="fs-14_ mr-4_ ml-4_">|</span>
                	<span class="fs-14_ txt-blue weight_600">`+Strength+`</span>
                	<span class="fs-14_ txt-blue weight_500"></span>
			  	</div>
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Patient Detail:</span>
                	<span class="fs-14_ txt-blue weight_600">`+PatientName+`</span>
			  	</div>
			  	
			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Pharmacy Name:</span>
                    <span class="fs-14_ txt-blue weight_500">`+Practice+`</span>
			  	</div>
			  		`);
            
            $('#pracPop').text(Practice);
            $('#medNamePop').text(Drug+" "+Strength);
            $('#rxPop').text(RxNo);
            $('#CAM_OrderId').val(Id);
            $('#CAM_PracticeId').val(PracticeId);
            $('#CAM_PatientId').val(PatientId);
            $('#patientNameShow').html(PatientName);
            $('#patientMessage').modal("show");
        }



 function generalMessages(qId,pName,p_id,PracticeId)
        {
            console.log('hello world!!!'+qId + pName);
            $('#chat_history').html('');
        
            $.ajax({
                            url:"{{url('/general/question-thread')}}",
                            method:'post',
                            data:{q_id: qId},
                            success:function(response){
                                var prevmsg = '';        
                                var messages = '<ul data-v-6a49c60d="">';
                                $.each(response.data,function(key,val){
                                    date = val.message_create;
                                    status = val.message_status;
console.log(val);
                                    if(val.Message){
if(val.message_status == 'sent'){
messages += `<li data-v-6a49c60d="" class="message sent ma-0_" style="
    padding-bottom: 5px;
    margin: 0px;">
<div class="trow_ mb-2_">
<img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;">
<div class="trow_ txt-sline">
<span class="txt-grn-lt d-ib_ fs-12_ lh-14_">`+'{{auth::user()->name}}'+`</span> 
<span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.message_create)+`</span></div>
</div>
 <div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="
    padding: 4px 6px;
">`+val.Message +`</div>
</li>`;
if(val.attachment)
        {
            var file_ext=val.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext.toLowerCase())){
                messages+=`<div style="width: 170px;height: 80px;overflow: hidden;"><img src="{{asset("/")}}`+val.attachment+`" class="gallery"/></div>`; 
            }else{

                messages+=`<div style="float: left;margin-bottom: 5px;"><a href="{{asset('/')}}`+val.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+val.attachment.split('/').pop()+`</span></a></div>`;
            }
        }
}
else {
messages+= `<li data-v-6a49c60d="" class="message received mt-7_" style="
    padding-bottom: 5px;
    margin: 0px;
    margin-top: 7px;
">

<div class="trow_ mb-2_"><span class="txt-blue d-ib_ fs-12_ lh-14_ elm-right">`+pName+`</span>
<span class="u-info d-ib_ tt_cc_ weight_600 mr-7_ lh-14_ fs-11_">`+GetFormattedDateData(val.message_create)+`</span>
</div>
    <div data-v-6a49c60d="" class="text pa-4_ bg-grn-lk fs-13_ lh-17_" style="
    padding: 4px 6px;
">`+val.Message +`</div></li>
`;
if(val.attachment)
        {
            var file_ext=val.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext.toLowerCase())){
                messages+=`<div style="width: 170px;height: 80px;overflow: hidden;float: right;"><img src="`+val.attachment+`" class="gallery"/></div>`; 
            }else{

                messages+=`<div style="float: right;margin-bottom: 5px;"><a href="`+val.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+val.attachment.split('/').pop()+`</span></a></div>`;
            }
        }
}

                               
                                        // if(val.attachment)
                                        // {
                                        //   messages+=`<div style="width: 170px;height: 80px;overflow: hidden;margin-top: 8px;"><img src="{{asset("/")}}`+val.attachment+`"/></div>`; 
                                        // }

                                    }else{
                                      //  messages +=      `<li data-v-6a49c60d="" class="message" style="border-bottom: solid 1px #666;padding-bottom: 5px;"> <div data-v-6a49c60d="" class="text"></div></li>`;
                                    }
                                });  

                                messages += '</ul>';
                                $('#chat_history').append(messages); 
                                $("#chat_history").animate({ scrollTop: $("#chat_history")[0].scrollHeight}, 1000); 
                        }
            });

            $('#pat_mes_info').empty().html(`		  	

			  	<div class="trow_ c-mr-4_ fs-z_ mb-2_ c-dib_">
                    <span class="fs-14_ txt-black-24 weight_600">Patient Detail:</span>
                	<span class="fs-14_ txt-blue weight_600">`+pName+`</span>
			  	</div>

			  		`);

            
            $('#pracPop').text();
            $('#medNamePop').text();
            $('#rxPop').text();
            $('#CAM_OrderId').val('');
            $('#CAM_PracticeId').val(PracticeId);
            $('#CAM_PatientId').val(p_id);
            if($('#patient_form2 input[name="questionId"]').length>0){ $('input[name="questionId"]').remove(); }
            $('#patientMessage  #patient_form2').append('<input type="hidden" name="questionId" id="questionId" value="'+qId+'" />');
            $('#patientNameShow').html(pName);
            $('#patientMessage').modal("show");
        }

//  this function is to 
  function addMessage()
{

    $('#patientMessage #sendMessage').prop('disabled', true);
    console.log('this send message');

if($('#patientMessage #orderMessage').val() == '')
{

$('#error_msg_show').html('This field is required.').show();
$('#patientMessage #sendMessage').prop('disabled', false);
return false;

}else{

$('#patientMessage #error_msg_show').hide();

}

var formData = new FormData($('form#patient_form2')[0]);

// $('#submitOrder').prop(':disabled', true);

$('#loading_small_login').show();

$.ajax({

    url:"{{ url('clinical-addupdate') }}",

    data: formData,// the formData function is available in almost all new browsers.

    type:"POST",

    cache: false,

    contentType: false,

    processData: false,

    error:function(err){

        console.error(err);

        $('#patientMessage #sendMessage').prop('disabled', false);

        $('#loading_small_login').hide();

    },

    success:function(data){

    //    $('#clinical-Modal').modal('hide');

    if(data.status){

      toastr.success(data.message);
      $('#pre-show .file-upload,#pre-show img').hide();
      $('#message_img').val(null);
      // alert($('#chat_history ul li div:first').html());
      if($('#chat_history ul li div:first').html() == ""){
        $('#chat_history ul ').empty(); 
      }
      var img='';

      if(data.mdata.attachment)
      {
        var file_ext=data.mdata.attachment.split('.').pop();
            var allow_extentions=['gif', 'jpeg', 'png','jpg'];
            if(allow_extentions.includes(file_ext)){
                img=`<div style="width: 170px;height: 80px;overflow: hidden;"><img src="{{asset("/")}}`+data.mdata.attachment+`" class="gallery"/></div>`; 
            }else{

                img=`<div style="float: left;margin-bottom: 5px;"><a href="{{asset('/')}}`+data.mdata.attachment+`" target="_blank"><span class="file-upload fas fa-file" style="width: 500px;font-size: 15px;">`+data.mdata.attachment.split('/').pop()+`</span></a></div>`;
            }
        // img='<div style="width: 170px;height: 80px;overflow: hidden;"><img src="{{asset("/")}}'+data.mdata.attachment+'"/></div>';
      }
      console.log("img",img);
//     var messages = `<li data-v-6a49c60d="" class="message sent" style="
//     border-bottom: solid 1px #666;
//     padding-bottom: 5px;
// ">
// <div class="trow_ mb-4_">
// <img class="elm-left mr-7_" src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="
//     width: 24px;
//     height: 24px;
//     "><span class="u-info tt_cc_ fs-11_" style="
//     line-height: 24px;
// ">`+GetFormattedDate()+`</span>
// </div>
//     <div data-v-6a49c60d="" class="text">`+$('#orderMessage').val() +`</div>`+img+`
// </li>`;
var messages = `<li data-v-6a49c60d="" class="message sent ma-0_" style="
padding-bottom: 5px;
margin: 0px;">
<div class="trow_ mb-2_">
<img class="elm-left mr-7_ " src="http://compliancerewards.ssasoft.com/compliancereward/public/images/user-photo.png" style="width: 24px;height: 24px;display: none;">
<div class="trow_ txt-sline">
<span class="txt-grn-lt d-ib_ fs-12_ lh-14_">Admin</span> 
<span class="u-info d-ib_ tt_cc_ weight_600 ml-7_ lh-14_ fs-11_">`+GetFormattedDate()+`</span></div>
</div>
<div data-v-6a49c60d="" class="text pa-4_ bg-white fs-13_ lh-17_" style="
padding: 4px 6px;
">`+$('#orderMessage').val() +`</div>
</li>`+img;
          $('#chat_history ul').append(messages);   
    
      $('#orderMessage').val('');
      $("#chat_history").animate({ scrollTop: $("#chat_history")[0].scrollHeight}, 1000);
      var table =  $('.compliance-user-table').DataTable();
      if($('#patient_form2 input[name="questionId"]').length>0){ 
         
          if($('#question_btn_'+$('#patient_form2 input[name="questionId"]').val()).closest('tr').attr('data-oid') == 'General_Question' || $('#question_btn_'+$('#patient_form2 input[name="questionId"]').val()).closest('tr').attr('data-oid')){
                                        // $('#question_btn_'+result.id).closest('tr').remove();
                          table.row( $('#question_btn_'+$('#patient_form2 input[name="questionId"]').val()).closest('tr') ).remove().draw();
                                    }
                                    $('input[name="questionId"]').remove();
       }else{

      
      table.row( $('[data-oid="'+data.mdata.OrderId+'"]') ).remove().draw();
       }

    }else{

      toastr.error(data.message);

    }

    // $('#patientMessage #sendMessage').prop('disabled', true);

    },

    complete:function(){

        console.log("Request finished.");

        $('#patientMessage #sendMessage').prop('disabled', false);
        
        
        setTimeout(function() {
            $('#patientMessage').modal("hide");
        }, 2000);
    }

});







    // if($('#orderMessage').val())

    // {

    //     $('#orderMsg').val($('#orderMessage').val());

    //     $('#patientMessage').modal("hide");

    // }

}


        // function addMessage()
        // {
        //     if($('#orderMessage').val())
        //     {
        //         $('#orderMsg').val($('#orderMessage').val());                
        //     }
        //     $('#patientMessage').modal("hide");
        // }
        
        function updateOrder(status)
        {
            var comingStatus = status;
            if ($('#under_review_reason').is(':visible')) {
   // $('#under_review_reason').hide();
}

            $('#print_button').hide();
          
            $('#print_button a').attr('href','#');

            if(!$('#orderUpdateData').valid())
            {
            	$('span.all-order-error').text('Please Fill All Fields');
                var validator = $('#orderUpdateData').validate();
                var lenErr='';
                var remote=false;
            
           
                $.each(validator.errorList, function (index, value) {
                    console.log(value);
                   
                    if(value.element.name=="RxNumber" ||  value.element.name=="Quantity" || value.element.name =="DaysSupply" || value.element.name=="RxIngredientPrice" || value.element.name=="RxThirdPartyPay" || value.element.name=="RxPatientOutOfPocket")
                    {
                        if(value.method=="min" || value.method == "minlength")
                        {
                            lenErr=value.element.name+ ' should be equal or greater than '+value.element.minLength;
                            return false;
                        }
                        if(value.method=="maxlength")
                        {
                          lenErr=value.element.name+ ' should be equal or less than 7';
                          return false;
                        }
                        
                        if(value.method=="check_non_zero")
                        {
                            lenErr=value.element.name+ ' '+ value.message;
                            return false;
                        }

                        if(value.method == 'remote'){
                            remote = true;
                            return false;
                        }
                    }

                

                    if(value.method=="required")
                    {
                        lenErr=value.element.name+' is required';
                        return false;
                    }

                });
                
                if(remote){
                    $('span.all-order-error').text('Duplicate Rx number');
                    $('span.all-order-error').show();
                    setTimeout(function(){  $('span.all-order-error').hide(); }, 4000);
                    return false;
                }

                if(lenErr!='')
                {
                    $('span.all-order-error').text(lenErr);
                }

                $('span.all-order-error').show();
                setTimeout(function(){  $('span.all-order-error').hide(); }, 6000);

                return false;            
            }   
           
            var  order =  $('#orderUpdateData').serializeArray();

            console.log(order);
            var  postData = new FormData();
            postData.append('OrderStatus',status);
            $.each(order, function(i, val) {
                if(val.name== "service_date"){
                    var dateAr = val.value.split('/');
                    var newDate = dateAr[2] + '-' +dateAr[0] + '-' + dateAr[1];
                    console.log(newDate);
                    val.value = newDate;
                }

                if(val.name== "Quantity" || val.name== "RxIngredientPrice" || val.name== "RxPatientOutOfPocket" || val.name=="RxThirdPartyPay" || val.name=="asistantAuth" || val.name=="RxSelling" || val.name=="RxProfitability")
                {
                    if(val.value.indexOf('$') != -1)
                    {
                        val.value=val.value.replace("$", "");
                    }
                    if(val.value.indexOf(',') != -1)
                    {
                        val.value=val.value.replace(",", "");
                    }
                }

                if(val.name=="PrescriberName" && val.value.indexOf('*') != -1)
                {
                    val.value=val.value.replace("*", "");
                }

                if(val.name=="PrescriberPhone")
                {
                    val.value=val.value.replace(/[- )(]/g, '');
                }

            
                        postData.append(val.name, val.value);

            });

            // if($('#drug_clinc_adv')[0].files[0])
            // {
            //      postData.append('drug_clinical_advise',$('#drug_clinc_adv')[0].files[0])
            // }


            $('.status-btn').attr("disabled","disabled");
            console.log(postData);
            $.ajax({
                url: "{{url('/order')}}",
                method: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: postData,
                async:true,
                success: function(result){
                    console.log(result);
                    $('#barcode').html('');
                    $('#barcode1').html('');
                    if($.isEmptyObject(result.error)){

                        $('.loader').hide();
                        if(result.status === true){                            
                           removeElement(orderListIds, result.order.Id); 
                           var InsuranceType = '';
                           if(result.order.InsuranceType == 'Cash')
                                {
                                    InsuranceType = 'SELF PAY';
                                    }else{
                                        InsuranceType = 'PRIVATE PAY';
                                                }

                              if(!result.enrolled){
                                toastr.success('Order has been updated with status '+result.order_status.Name);
                                 // toastr.info('Message','Enrollment message has been sent ' +
                                 //    'Pharmacy will get notice when enrollment will be accepted');


                            }else{
                                if(result.order_status)
                                {
                                    toastr.success('Order has been updated with status '+result.order_status.Name);
                                }
                                
                                // toastr.success('Message','Order has been placed successfully');

                            }

                              //if(result.order.OrderStatus == 8)
                              
                                $('#orderstatusname').empty('').html(result.order_status.Name);

                                $('#print_button a').attr('href', function() {
return "{{url('print-order?order=')}}" + result.order.Id;

});
$('#print_button').show();


                              $('#barcode').html(result.barCode);
                               $('#barcode1').html(result.barCode1);

                          


                            $('[data-oid="'+result.order.Id+'"] td.quantity').text(result.order.Quantity);
                            $('[data-oid="'+result.order.Id+'"] td.assist-auth').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order.asistantAuth).toFixed(2)));
                            if(result.order_status)
                            {
                            $('#rx_check_'+result.order.Id).attr("onclick", "editOrderPopup("+result.order.Id+",'"+$('#rx_check_'+result.order.Id).attr("p-name")+"','"+result.order_status.Name+"',"+result.order.OrderStatus+")");
                            if(result.order_status.Name == 'Cancel')
                        $('[data-oid="'+result.order.Id+'"] span#statusName').text('Cancelled');
                    else
                     $('[data-oid="'+result.order.Id+'"] span#statusName').text(result.order_status.Name);
                          

                            $('[data-oid="'+result.order.Id+'"] td.rewards-auth').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order_status.RxPatientOutOfPocket).toFixed(2)));
                            $('[data-oid="'+result.order.Id+'"] td.rewards-earned').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order_status.CurrentEarnReward).toFixed(2)));
                            $('[data-oid="'+result.order.Id+'"] td.balance').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order_status.CurrentRemainBalance).toFixed(2)));
                            $('[data-oid="'+result.order.Id+'"] td.sell-price').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order_status.RxSelling).toFixed(2)));
                            $('[data-oid="'+result.order.Id+'"] td.ptnt-out-pocket').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order_status.RxPatientOutOfPocket).toFixed(2)));
                            
                            $('[data-oid="'+result.order.Id+'"] td.profit').text("$"+window.pharmacyNotification.numberWithCommas(parseFloat(result.order_status.RxProfitability).toFixed(2)));
                     
 
    }


    
                            $('[data-oid="'+result.order.Id+'"] td.days-supply').text(result.order.DaysSupply);
                            $('[data-oid="'+result.order.Id+'"] td.refill-remain').text(result.order.RefillsRemaining);

           var table =  $('.compliance-user-table').DataTable(); 
if(!$('#reporter_prescription_id').val()){ 
 /**
           Order remove from table af any status 6-7-2020 Ken requirement 
           if ($(location).attr('pathname').indexOf("/orders") > -1 && (result.order.OrderStatus == 8 || result.order.OrderStatus == 11 || result.order.OrderStatus == 25)) {
           */              
 if ($(location).attr('pathname').indexOf("/orders") > -1) {
       table.row( $('[data-oid="'+result.order.Id+'"]') ).remove().draw();
      console.log('this is orders',$(location).attr('pathname'));
    }else if($('#selectServic').val() != result.order.OrderStatus){
         // $('[data-oid="'+result.order.Id+'"]').remove();

         table.row( $('[data-oid="'+result.order.Id+'"]') ).remove().draw();
    }

   
        
    }else{
       table.row( $('[data-oid="'+$('#reporter_prescription_id').val()+'"]') ).remove().draw(); 
    }

                            console.log('this is orders',$(location).attr('pathname'));

                              if(result.order.OrderStatus != 8 && result.order.OrderStatus != 2 && (result.order.OrderStatus != 29 || $('#skip_order').attr('open_next')=="false") ){ 
                                $('.status-btn').removeAttr("disabled");
                            $('#order_edit_Modal').modal('hide');
                        }else{
                             $('.status-btn').attr( "disabled", "disabled" );
                        }
                        //result.order.OrderStatus
                        console.log("Status:"+comingStatus);
                            if(comingStatus == 2 || comingStatus == 8 || comingStatus == 11 || comingStatus == 24 || comingStatus == 25)
                            {   
                                console.log("Triggering next....");
                                $('#copy_next_order_edit').trigger('click');                                
                            }

                        }
                        else{
                        $('.loader').hide();
                        toastr.error(result.message);
                    }
                    }else{
                        $('.loader').hide();
                        toastr.error(result.message);
                    }

                },
                error: function(data){
                  $('.status-btn').removeAttr("disabled");
                    $('.loader').hide();

                     
                     console.log(data.data)
                     if(data.status == 422)
                     {
                        var errors = $.parseJSON(data.responseText);
                        var st='';
                        for(var key in errors)
                        {
                            console.log("out",errors[key])
                            var value=errors[key]
                            for(var val in value)
                            {
                                if(typeof value === 'object')
                                {
                                   console.log('iner',value[val])
                                st+=value[val];
                                }

                            }
                        }
                        toastr.error('',st);
                     }

                }
            });

          }
          
        function processMbrToPay()
        {
            if($('#isPIPPatient').val())
               updateOrder(28);
            else
              updateOrder(2);
        }
        
        function confirmNextOrder(next, prac_name, o_status, os_id, p_id2)
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
                      editOrderPopup(next,prac_name,o_status,os_id,p_id2);
                    });
                    $("#confirmationNo").click(function(){
                      toastr.clear();
                    });
                  }
            });
        }
        
        function validateCancelRequest()
        {
            toastr.options.fadeOut = 500000;
            toastr.warning("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Are you sure you want to cancel this order?',
            {
                closeButton: false,
                timeOut: 500000,
                allowHtml: true,
                onShown: function (toast) {
                    $("#confirmationYes").click(function(){
                      toastr.clear();
                      updateOrder(27);
                    });
                    $("#confirmationNo").click(function(){
                      toastr.clear();
                    });
                  }
            });
        }
        function skipOrder(skip_status,next_id,prac_name,o_status,os_id,patient_id)
        {
            updateOrder(skip_status);
            if($('#skip_order').attr('open_next')=="true")
            {
              editOrderPopup(next_id,prac_name,o_status,os_id,patient_id);  
            }
            
        }
        
        $(document).ready(function () {
        	 $.validator.addMethod("check_non_zero", function (value, element) {
                        console.log(value);
                        if(value==0)
                        {
                            return false;
                        }else{
                            return true;
                        }
                    }, "should be greater than 1");

                    $.validator.setDefaults({
                        ignore: []
                    });
        	 var minCharPhone = 14;

                    $('#orderUpdateData').validate({
                        rules:{
                             RxNumber:{
                                remote: {
                                   param:{ url: "{{route('check_rx_number')}}",
                                    method: 'get',
                                    data: {
                                      PatientId:  function () {
                                          var newStr1 = $("#PatientId").val();
                                          return newStr1;
                                      },
                                      RxNumber:  function () {
                                          var newStr = $("#rx_no").val();
                                          return newStr;
                                      },
                                      PracticeId:  function () {
                                          var newStr = $("#PracticeId").val();
                                          return newStr;
                                      }
                                    }
                                },
                                depends: function(element) {
                //    @if(isset($order))
                //    return false;
                //    @else
                //    return true;
                //    @endif

                   var rx = '{{isset($order)?$order->RxNumber:""}}';
                   console.log($(element).val()+'=>'+rx);
                    if($(element).val() !== rx){
                        console.log('yes');
                        return true;
                    }else{
                        console.log('no');
                        return false;
                    }

                }
                            }
                            },
                            Quantity:{
                                required: false,check_non_zero: true
                            },
                            
                            PrescriberPhone:{
                                required: false,
                                // minlength: minCharPhone
                            },
                        },
                        messages:{
                            RxNumber:{
                                remote:"Duplicate Rx number"
                            },
                            // PrescriberPhone: {
                            //    minlength: function () {
                            //       return [
                            //         'Please Enter Min 10 digits'];
                            // 	}
                        	// },
                        },
                        errorPlacement: function (error, element) {
                         },
                        highlight: function(element, errorClass, validClass) {
                            $(element).parent('div').find('input,.select2-selection').addClass('order-error');
                            $(element).parent('div').find('label:first').addClass('star');

                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).parent('div').find('input,.select2-selection').removeClass('order-error');
                            $(element).parent('div').find('label:first').removeClass('star');
                        },
                    })
            // if($('#no_data_div').length <= 0)
            // {
            // $('.compliance-user-table').DataTable({
            //                 processing: false,
            //                 serverSide: false,
            //                 Paginate: false,
            //                 lengthChange: false,
            //                 order:[],
            //                 bFilter: false,
            //                 columnDefs: [
            //                             { targets: 'no-sort', orderable: false }
            //                           ]
            //             });
            // }
            // $('#datepicker_from').datetimepicker({
            //     timepicker: false,
            //     format: 'm/d/Y',
            //     maxDate: 0

            // });
            // $('#datepicker_to').datetimepicker({
            //     timepicker: false,
            //     format: 'm/d/Y',
            //     maxDate: 0,
            //     defaultDate: new Date()
            // });
            $('#datepicker_from').datepicker({
            autoclose: true,
            format: 'mm/dd/yyyy',
            // endDate: new Date()
            }).on('changeDate', function(){
            // set the "toDate" start to not be later than "fromDate" ends:
            // $('#datepicker_to').val("").datepicker("update");
            $('#datepicker_to').datepicker('setStartDate', new Date($(this).val()));
            });
            $('#datepicker_to').datepicker({
            autoclose: true,
            format: 'mm/dd/yyyy',
            // startDate: new date($('#datepicker_from').val())
            }).on('changeDate', function(){
            // set the "fromDate" end to not be later than "toDate" starts:
            // $('#datepicker_from').val("").datepicker("update");
            $('#datepicker_from').datepicker('setEndDate', new Date($(this).val()));
            });

            $("#practice_name").select2({
                placeholder: "Select Practice",
                allowClear: true
            });
            $("#selectServic").select2({
                placeholder: "Select Service",
                allowClear: true
            });


             $("#datetimepicker").datepicker({
                    autoclose: true,
                    maxDate: 0,
                    format: 'mm/dd/yyyy',
                    orientation: 'bottom'
                });

             var presWithPhone=[]
                    $('#basicAutoSelect').autoComplete({
                        resolverSettings: {
                            url: "{{url('/get-pres-name')}}"
                        },
                        events: {
                            searchPost: function (resultFromServer) {
                                console.log("from ser",resultFromServer)
                                if(resultFromServer.pres_names.length>0)
                                {
                                    presWithPhone=resultFromServer.pres_names;
                                }else{
                                    $('input[name="PrescriberPhone"]').val('');
                                    $('input[name="PrescriberPhone"]').attr('readonly',false);
                                    $('input[name="prescriber_id"]').val('');
                                }
                                return resultFromServer.formatPresName;
                            }
                        }
                    });  

                    $('#basicAutoSelect').on("autocomplete.select",function(evt,item){
                        var selectPres=presWithPhone.filter(function(x){
                                return x.id == item.value
                            });
                        if(selectPres.length>0)
                        {

                            if(selectPres[0].practice_phone_number)
                            {
                                $('input[name="prescriber_id"]').val(selectPres[0].id);
                                var tm=selectPres[0].practice_phone_number.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3")
                                $('input[name="PrescriberPhone"]').val(tm);
                                $('input[name="PrescriberPhone"]').attr('readonly',true);
                            }
                        }
                    });
                    
                   
        });

        $('.clickPatientCheck').on('click', 'checkbox', function () {
            console.log($(this).val())
        });

        function clickPatientCheck(v) {
            console.log(v.target.value);

            data = v.target.value;
            var url = '{{url('patient/request-process')}}';
            url.replace(':id',v.target.value);
            $.ajax({

                url: url,
                method: 'post',
                data: {ids: data},
                success: function (result) {
                    if (result.status) {
                        // window.location.reload();
                        $(v.target).attr("disabled", "disabled");
                        $(v.target).parent().parent().find('#statusName').text("Filled");
                    }
                    console.log(result);
                    // $('.alert').show();
                    // $('.alert').html(result.success);
                },
                error: function (data) {

                }
            });

        }

        function resetField()
        {
           // $('#selectServic option:selected').removeAttr('selected');
           // $("#selectServic").val("").trigger('change');
           // reset_dropdown();
            $('#request_filter')[0].reset();
            window.location = window.location;
            //$("#datepicker_from").val('');
            //$("#datepicker_to").val('');
           // $("#datepicker_from").attr("value", '');
           // $("#practice_name option:selected").prop("selected", false)
          //  $("#datepicker_to").attr("value", '');
          //  console.log("--clearing the respective fields");
           // $('#datepicker_from').val("").datepicker("update");
           // $('#datepicker_to').val("").datepicker("update");
           // $('.btn-search_').trigger('click');
        }


        $("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    }
    // ,
    // blur: function() { 
    //   formatCurrency($(this), "blur");
    // }
});


$("input[data-type='quantity']").on({
    keyup: function() {
        formatQuantity($(this));
    }
    // ,
    // blur: function() { 
    //     formatQuantity($(this), "blur");
    // }
});

function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

/*$("#drugPrice").maskMoney({ decimal:'.', allowZero:true, prefix: '$'});
$("#thirdPartyPaid").maskMoney({ decimal:'.', allowZero:true, prefix: '$'});
$("#pocketOut").maskMoney({ decimal:'.', allowZero:true, prefix: '$'}).blur(function() 
{
    $('input[name="asistantAuth"]').val(this.value);
    //(parseFloat(this.value.replace(',', '.')).toFixed(2)).replace('.', ',');
     });
$('input[name="asistantAuth"]').maskMoney({decimal:'.', allowZero:true, prefix: '$'});
$("#asistantAuthPop").maskMoney({ decimal:'.', allowZero:true, prefix: '$'});
$("#thirdPartyPaid").maskMoney({ decimal:'.', allowZero:true, prefix: '$'});
$("#RxSelling").maskMoney({ decimal:'.', allowZero:true, prefix: '$'});*/
$('#drugPrice').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});
$('#thirdPartyPaid').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});
$('#pocketOut').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function() 
{
    $('input[name="asistantAuth"]').val(this.value);
    //(parseFloat(this.value.replace(',', '.')).toFixed(2)).replace('.', ',');
    formatCurrency($(this), "blur");
     });
$('input[name="asistantAuth"]').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});
$('#asistantAuthPop').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});
$('input[name="Quantity"]').mask('9Z#Z#Z#Z#.9', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatQuantity($(this), "blur");
});
$("#RxSelling").mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});

function formatQuantity(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }

//    str = input_val.replace(/(\$|,)/gi,'');
 /*  str = input_val.replace(/[$,.]+/g,'');
   console.log(str);
   console.log(str.length);
  if(str.length == 7){
    console.log('length added'); 
    return false;

  }  */
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "0";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 1);

    // join number by .
    input_val =  left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val =  input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".0";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
 // input[0].setSelectionRange(caret_pos, caret_pos);
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }

//    str = input_val.replace(/(\$|,)/gi,'');
 /*  str = input_val.replace(/[$,.]+/g,'');
   console.log(str);
   console.log(str.length);
  if(str.length == 7){
    console.log('length added'); 
    return false;

  }  */
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = "$" + left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = "$" + input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
//  input[0].setSelectionRange(caret_pos, caret_pos);
}
function IsDigit(n) {
                    console.log(n);
                    var charCode = (n.which) ? n.which : n.keyCode;

                    if(!isNaN(n.key) ){
                        console.log('inside if');
                        if((n.target.name=='RxPatientOutOfPocket' || n.target.name =="RxThirdPartyPay" || n.target.name == "RxIngredientPrice") && n.target.value.indexOf('$') === -1)
                        {
                            console.log(n.target.value)
                            if(n.target.value == "0")
                            {
                                n.target.value="";
                            }
                            n.target.value='$'+n.target.value;
                        }else{
                           console.log('a');
                        }

                        return true;

                    }
                    else if((n.target.name=='RxPatientOutOfPocket' || n.target.name =="RxThirdPartyPay" || n.target.name == "RxIngredientPrice") && charCode == 46)
                    {

                            if(n.target.value.indexOf('.') === -1)
                            {
                                return true;
                            }else{
                                return false;
                            }


                    }
                    else
                    {
                         return false;
                    }
                }
                 function numericOnly(event,allowLen){ // restrict e,+,-,E characters in  input type number
        //     if(event.target.value.length == allowLen) return false;
        //     console.log(event);
        //     const charCode = (event.which) ? event.which : event.keyCode;
        // if (charCode == 101 || charCode == 69 || charCode == 45 || charCode == 43) {
        //   return false;
        // }
        // return true;
        if(event.target.value.length == allowLen) return false;
      var charCode = event.which  ? event.which : event.keyCode;
      var charStr = String.fromCharCode(charCode);
    console.log(charCode,charStr)
    if(event.target.name=='Quantity')
    {
        if(event.target.value.indexOf('.') == -1 &&  charCode==46)
        {
            return true;
        }
      
        
    }
    if (!charStr.match(/^[0-9]+$/)){
        event.preventDefault();
    }

      }




    function openQuestionPopup(ques,qId,img){
            if(img)
            {
                $('#quesImg').html('<img src='+img+' />');
                $('#quesImg').show();
            }else{
                $('#quesImg').html('');
                $('#quesImg').hide(); 
            }
            $('#modalQues').text(ques);
            $('#modalQues').attr('data-qId', qId);
            $('#myModal').modal('show');

        }
        
        function saveAnswer2()
        {
            var ans=$('#answer_to_question').val();
            if(ans!='')
            {
                var postData={
                'qId': $('#modalQues').attr('data-qId'),
                'ans': ans,
                'pId': $('#modalQues').attr('data-pId')
                }
                $.ajax({
                        url:'{{route('save-answer')}}',
                        method:"post",
                        data:postData,
                        success:function (result) {
                            if(result.status == 200){
                                if(result.data)
                                {
                                    $('#myModal').modal('hide');
                                    if(result.id){
                                       if($('#question_btn_'+result.id).hasClass('blink-icon')){
                                           $('#question_btn_'+result.id).removeClass('blink-icon');
                                       }

                                       if($('#question_btn_'+result.id).hasClass('txt-red')){
                                           $('#question_btn_'+result.id).removeClass('txt-red');
                                           $('#question_btn_'+result.id).addClass('txt-green');
                                       }
                                       // $('#question_btn_'+result.id).text('');
                                    }
                                    $('textarea[name="answer_to_question"]').val('');
                                    toastr.success('Answer Sent Successfully');
                                     var table =  $('.compliance-user-table').DataTable();
                                      /**
           Order pending question either general or simple question remove from table af any status 6-7-2020 Ken requirement 
          if($('#question_btn_'+result.id).closest('tr').attr('data-oid') == 'General_Question'){
           */   
                                    if($('#question_btn_'+result.id).closest('tr').attr('data-oid') == 'General_Question' || $('#question_btn_'+result.id).closest('tr').attr('data-oid')){
                                        // $('#question_btn_'+result.id).closest('tr').remove();
                          table.row( $('#question_btn_'+result.id).closest('tr') ).remove().draw();
                                    }
                                }
                            }
                        },
                        error:function (data) {

                        }
                    });
            }else{
                $('#ansEr').html('<label class="txt-red">Please enter answer</label>')
            }

        }






        function close_box()
    {
        $('.backdrop, .box').animate({'opacity':'0'}, 300, 'linear', function(){
                $('.backdrop, .box').css('display', 'none');
            });
    }

        $(document).ready(function() {

            $('#chat_history').on('click','.gallery',function(){
            $('.backdrop, .box').animate({'opacity':'.50'}, 300, 'linear');
            $('.box').animate({'opacity':'1'}, 300, 'linear');
            $('.big_img').attr('src',$(this).attr('src'));
            $('.backdrop, .box').css('display', 'block');
        });

        $('.close').click(function(){
            close_box();
        });

        $('.backdrop').click(function(){
            close_box();
        })

            
            
            
            if($('#no_data_div').length <= 0)
            {
            $('.compliance-user-table').DataTable({
                            processing: false,
                            serverSide: false,
                            Paginate: false,
                            lengthChange: false,
                            order:[],
                            bFilter: false,
                            columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                      ]
                        });
            }

            
            $('.modal').on('hidden.bs.modal', function(e)
            {
                $(this).removeData();
                // $('#order_edit_Modal #fee-auth-zero').val(null);
            });
            $('.old_allergiest').on("change",'.show-del',function(event){
            
                // console.log($(this).is(":checked"))
                $(this).parent().find('a.del-icon').toggle();
                // var aler_name=$(this).find('span').text();
                // $('#new-allergy').val(aler_name);
                // $('#new-allergy').attr('data-id',aler_id);
            });
            $('.old_allergiest').on("click",'.del-icon',function(){
                if(confirm("Are you sure to remove this allergy?"))
                {
                    var al_id=$(this).attr('data-id');
                    $.ajax({
                            url:'{{route('update-patient-info')}}',
                            method:'get',
                            data:{aler_id:al_id,type:'allergis'},
                            success:function(result){
                                if(result.status == 200){
                                   $('.old_allergiest [data-aler='+al_id+']').remove();
                                   console.log($('.old_allergiest > div').length);
                                   $('button.green_rounded:eq(1) > span').html('(' +$('.old_allergiest > div').length+')');
                                   console.log($('.old_allergiest > div').length);
                                   toastr.success( result.data);
                                }
                            },
                            error:function(error){
                                toastr.error('Error', error);
                            }
                    });

                }
                
            })

        });
        function deleteCard(id)
        {
            console.log(id);
            $.ajax({
                url: '{{url('delete-card')}}',
                method: 'get',
                data:{'id': id},
                success:function(response)
                {
                    if(response.status)
                    {
                        $('#old_cards [data-cardid='+id+']').remove();
                    }
                },
                error:function(error)
                {

                }
            });
        }
        
       
            
        // this is using in general question    
        
        function openQuestionPopup(ques,qId,img,pid,practice_name,patient_full_name){
            // alert('yes');
            if(img)
            {
                $('#quesImg').html('<img src='+img+' />');
                $('#quesImg').show();
            }else{
                $('#quesImg').html('');
                $('#quesImg').hide(); 
            }
            $('#practice_patient_name').text('');
            $('#practice_patient_name').text('Patient Name :'+patient_full_name);
            $('#modalQues').text(ques);
            $('#modalQues').attr('data-qId', qId);
            $('#modalQues').attr('data-pId', pid);
            $('#myModal').modal('show');

        }
        
        function saveAnswer()
        {
            var ans=$('#answer_to_question').val();
            if(ans!='')
            {
                var postData={
                'qId': $('#modalQues').attr('data-qId'),
                'ans': ans
                }
                $.ajax({
                        url:'{{route('save-answer')}}',
                        method:"post",
                        data:postData,
                        success:function (result) {
                            if(result.status == 200){
                                if(result.data)
                                {
                                    $('#myModal').modal('hide');
                                    if(result.id){
                                        if($('#'+result.id).hasClass('blink-icon')){
                                            $('#'+result.id).removeClass('blink-icon');
                                        }

                                        if($('#'+result.id).hasClass('txt-red')){
                                            $('#'+result.id).removeClass('txt-red');
                                            $('#'+result.id).addClass('txt-green');
                                        }
                                    }
                                    $('textarea[name="answer_to_question"]').val('');
                                    toastr.success( 'Answer Sent Successfully');
                                }
                            }
                        },
                        error:function (data) {

                        }
                    });
            }else{
                $('#ansEr').html('<label class="txt-red">Please enter answer</label>')
            }

        }
        function updatePatientInfoModal(id,type) {
            var patient_id = id;
            var checkType = type;
            if(checkType == 'email_phone'){
                $('#patient_new_email').val('');
                $('#patient_new_phone').val('');
                $.ajax({
                    url:'{{route('get-patient-info')}}',
                    method:"get",
                    data:{patient_id:patient_id,checkType:checkType},
                    success:function (result) {
                        if(result.status == 200){
                            $('#oldEmail').val(result.data.email);
                            $('#oldPhone').val(result.data.mobile_number);
                            $('#email_phone').modal('show');
                        }
                    },
                    error:function (data) {

                    }
                });
                // $('#email_phone').modal('show');
            }else if(checkType == 'address'){
                // $('#new_address').val('');
                // $('#new_city').val('');
                // $('#new_zip').val('');
                // $('#new_state').val('');
                $('.new_edit_modal_parent').not('#address').removeClass('fade');
                $.ajax({
                    url:'{{route('get-patient-info')}}',
                    method:"get",
                    data:{patient_id:patient_id,checkType:checkType},
                    success:function (result) {
                        console.log(result);
                        if(result.status == 200){
                            $('#old_address').text(result.data.address);
                            $('#old_city').val(result.data.City);
                            $('#old_zip').val(result.data.zipCode);
                            $('#old_state').val(result.data.state);
                            $('.new_edit_modal_parent').not('#address').modal('hide');
                            $('#address').modal('show');
                            // $('.new_edit_modal_parent').not('#address').addClass('fade');
                        }
                    },
                    error:function (data) {

                    }
                });
                // $('#address').modal('show');
            }
            else if(checkType == 'allergies'){
                // $('#address').removeClass('fade');
                $('.new_edit_modal_parent').not('#allergis').removeClass('fade');
                $('.add-alr').hide();
                $.ajax({
                    url:'{{route('get-patient-info')}}',
                    method:"get",
                    data:{patient_id:patient_id,checkType:checkType},
                    success:function (result) {
                        if(result.status == 200){
                            $('.old_allergiest').empty();

                            var old_allegies_html = '';
                            
                                /*

                              <div class="col-sm-2"><label class="cur-pointer editAlergy" style="min-width: 100px;"><input type="checkbox" class="mt-4_ check_marg blue_redio check_color" checked><span class="blue_span_check v-al-top weight_500" data-id='+val.Id+'>'+val.Allergies+'</span></label></div>
                                */
                             if(result.data.length>0)
                             {
                                $.each(result.data, function (i, val) {

                                    old_allegies_html += '<div class="c-dib_ alr-modal-label" style="margin-bottom: .5rem;" data-aler='+val.Id+'><input type="checkbox" class="ma-0_ mt-4_ border-blue show-del"><span class="ma-0_ tt_cc_ mlf-0_" >'+val.Allergies+'</span><a class="ml-7_ mt-2_ fa fa-times-circle-o fs-20_ weight_300 txt-red hover-black_ del-icon" style="display: none;" data-id='+val.Id+'></a></div>';
                                });
                            }else{
                                old_allegies_html='No allergies found';
                            }
                             

                            $('.old_allergiest').append(old_allegies_html);

                            // if($('#address').is(':visible'))
                            // {
                            //     $('#address').modal('hide');
                            // }
                            $('.new_edit_modal_parent').not('#allergis').modal('hide');
                            $('#allergis').modal('show');
                            // $('#address').addClass('fade');
                            // $('.new_edit_modal_parent').not('#allergis').addClass('fade');
                            }
                        },
                    error:function (data) {

                    }
                });
            }
            else if(checkType == 'insurance_cards'){
                $('.new_edit_modal_parent').not('#insurance_cards').removeClass('fade');
                $('.insurace').hide();
                $.ajax({
                    url:'{{route('get-patient-info')}}',
                    method:"get",
                    data:{patient_id:patient_id,checkType:checkType},
                    success:function (result) {
                        if(result.status == 200){
                            if(result.data.length>0)
                            {
                                var old_card_images='';
                                 $.each(result.data, function (i, val) {
                                    if(fileExists(val.InsuranceFrontCardPath) || fileExists(val.InsuranceBackCardPath))
                                    {

                                        old_card_images += '<div class="col-lg-6 col-md-6 mb-14_ card-row"  data-cardId='+val.Id+' style="padding-top: 10px;border: 1px solid;"><div class="row">';
                                        if(val.InsuranceFrontCardPath)
                                        {
                                            old_card_images+='<div class="col-md-6 col-lg-6"><div style="max-height: 200px;overflow: hidden;"><img src="{{asset("/")}}'+val.InsuranceFrontCardPath+'" style="width: 100%"/></div></div>';
                                        }
                                        if(val.InsuranceBackCardPath)
                                        {
                                            old_card_images+='<div class="col-md-6 col-lg-6"><div style="max-height: 200px;overflow: hidden;"><img src="{{asset("/")}}'+val.InsuranceBackCardPath+'" style="width: 100%"/></div></div>';

                                        }
                                        old_card_images+='</div><span class="fa fa-times-circle-o fs-20_ weight_300 txt-red hover-black_ del-crd" style="position: absolute;top: -10px;right: 7px;" onclick="deleteCard('+val.Id+')"></span></div>';
                                    }

                                    });
                                 if(old_card_images!='')
                                 {
                                    $('#old_cards').html(old_card_images);
                                }else{
                                    $('#old_cards').html('No Insurace Card Found!');
                                }
                                 
                            }
                            $('.new_edit_modal_parent').not('#insurance_cards').modal('hide');
                            $('#insurance_cards').modal('show');
                            // $('.new_edit_modal_parent').not('#insurance_cards').addClass('fade');
                                

                        }
                    },
                    error:function (data) {

                    }
                });
            }
        }

        function saveUpdatedPatientInfo(id,type,e) {
            var patient_id = id;
            if(type== 'email_phone'){
                var new_email = $('#patient_new_email').val();
                var new_phone = $('#patient_new_phone').val();
                $.ajax({
                    url:'{{route('update-patient-info')}}',
                    method:'get',
                    data:{new_email:new_email, new_phone:new_phone,patient_id:patient_id,type:type},
                    success:function(result){
                        console.log(result)
                        if(result.status == 200){
                            $('#email_phone').modal('hide');
                            toastr.success( result.data);
                        }
                    },
                    error:function(error){
                        toastr.error('Error', error);
                    }
                });
            }
            else if(type == 'address'){
                if($('#address_form').valid())
                {
                    var new_address = $('#old_address').val();
                    var new_city = $('#old_city').val();
                    var new_zip = $('#old_zip').val();
                    var new_state = $('#old_state').val();
                    $.ajax({
                        url:'{{route('update-patient-info')}}',
                        method:'get',
                        data:{new_address:new_address,new_city:new_city, new_zip:new_zip,new_state:new_state,
                            patient_id:patient_id,type:type},
                        success:function(result){
                            // console.log(result)
                            if(result.status == 200){
                                $('#address').modal('hide');
                                toastr.success( result.data);
                            }
                        },
                        error:function(error){
                            toastr.error('Error', error);
                        }
                    });
                }
            }
            else if(type == 'allergis'){
                // var allergiesArray = [];
                // if($('.old_allergy_dynmaic').length > 0){
                //     $('.old_allergy_dynmaic').each(function() {
                //         var allergy = $(this).val();
                //         allergiesArray.push(allergy);
                //     });
                // }else{
                //     var new_allergy = $('.new_allergy_dynmaic').val();
                //     allergiesArray.push(new_allergy);
                // }
                // $.ajax({
                //     url:'{{route('update-patient-info')}}',
                //     method:'get',
                //     data:{alleriesArray:allergiesArray,patient_id:patient_id,type:type},
                //     success:function(result){
                //         if(result.status == 200){
                //             $('#allergis').modal('hide');
                //             toastr.success('Message', result.data);
                //         }
                //     },
                //     error:function(error){
                //         toastr.error('Error', error);
                //     }
                // });
                var allergiesArray = [];

                    var new_allergy = $('.new_allergy_dynmaic').val();
                    if(new_allergy)
                    {
                        allergiesArray.push(new_allergy);
                        // if($('.new_allergy_dynmaic').attr('data-id'))
                        // {
                        //     var al_id=$('.new_allergy_dynmaic').attr('data-id');
                        //     allergiesArray.push(al_id);
                        // }
                        $.ajax({
                            url:'{{route('update-patient-info')}}',
                            method:'get',
                            data:{alleriesArray:allergiesArray,patient_id:patient_id,type:type},
                            success:function(result){
                                if(result.status == 200){
                                    // $('.new_allergy_dynmaic').val('')
                                    // if($('.new_allergy_dynmaic').attr('data-id'))
                                    // {
                                    //     $('.new_allergy_dynmaic').removeAttr('data-id')
                                    // }
                                    // $('#allergis').modal('hide');
                                    toastr.success( result.data);
                                    if($('.old_allergiest > div').length == 0)
                                    {
                                        $('.old_allergiest').empty();
                                    }
                                    var added_allergy='<div class="c-dib_ alr-modal-label" style="margin-bottom: .5rem;" data-aler='+result.id+'><input type="checkbox" class="ma-0_ mt-4_ border-blue show-del"><span class="ma-0_ tt_cc_ mlf-0_" >'+new_allergy+'</span><a class="ml-7_ mt-2_ fa fa-times-circle-o fs-20_ weight_300 txt-red hover-black_ del-icon" style="display: none;" data-id='+result.id+'></a></div>';

                                    $('.old_allergiest').append(added_allergy);
                                    $('.new_allergy_dynmaic').val('');
                                    $('button.green_rounded:eq(1) > span').html('(' +$('.old_allergiest > div').length+')');
                                    
                                }
                            },
                            error:function(error){
                                toastr.error('Error', error);
                            }
                        });
                    }

            }else if(type == 'insurance_cards'){
                console.log($('#insCard1')[0].files[0])
                console.log($('#insCard2')[0].files[0])
                if($('#insCard1')[0].files[0] && $('#insCard2')[0].files[0])
                {
                    var _validFileExtensions = ["jpg", "jpeg", "png"];
                    var formData= new FormData();
                    formData.append('id',id);
                    // if($('#card-row').attr('data-cardId'))
                    // {
                    //     formData.append('insId',$('#card-row').attr('data-cardId'));
                    // }
                    if($('#insCard1')[0].files[0])
                    {
                        var ext1=$('#insCard1')[0].files[0].name.split('.').pop();
                        if(_validFileExtensions.includes(ext1.toLowerCase()))
                        {
                            formData.append('card1',$('#insCard1')[0].files[0]);
                        }else{
                            $('#insCard1').val('');
                            toastr.error('Error', "Only JPG, JPEG and PNG allowed");
                            return false;
                        }

                    }
                    if($('#insCard2')[0].files[0])
                    {
                        var ext2=$('#insCard2')[0].files[0].name.split('.').pop();
                        if(_validFileExtensions.includes(ext2.toLowerCase()))
                        {
                            formData.append('card2',$('#insCard2')[0].files[0]);
                        }else{
                            $('#insCard2').val('');
                            toastr.error('Error', "Only JPG, JPEG and PNG allowed");
                            return false;
                        }

                    }

                    console.log(formData);
                    $.ajax({
                        url:'{{route('save-card-image')}}',
                        method:'post',
                        data:formData,
                        processData: false,
                        contentType: false,
                        success:function(result){
                            if(result.status == 200){
                                $('#insCard1').val('');
                                $('#insCard2').val('');
                                updatePatientInfoModal(id,type);
                                // $('#insurance_cards').modal('hide');

                                toastr.success(result.data);

                            }
                        },
                        error:function(error){

                        }
                    });
                }else{
                    toastr.error('','Please choose both images');
                }
            }
        }


        function fileExists(file)
        {
        	if(file!=null)
        	{
        		 var fullpath="{{asset('/')}}"+file;
	            console.log(fullpath);
	            var status=false;
	            $.get({
	            	url: fullpath,
	            	async:false
	            }).done(function() { 
	                 // Do something now you know the image exists.
	                 console.log("exist");
	                 status=true;
	            }).fail(function() { 
	                console.log("not exist");
	                 // Image doesn't exist - do something else.
	                 status=false;

	             });
	            return status;
        	}  
        }




/*  added for reporter order */



                function blockSpecialChar(e){
                    var k;
                    k = e.keyCode;
                    // allow underscore and dash
                    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==45 || k == 32 || (k >= 48 && k <= 57));

                      // return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
                }

                function blockSpecialCharPhone(e){
                    var k;
                    k = e.keyCode;
                    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==45 || k==95 || k == 32 || k == 40 || k == 41 || (k >= 48 && k <= 57));
                }



               var selectedDrugData;
               var isNdcSelected=0;
           // alert(params.term);
           var url = '{{url('/drug-search')}}';

                    $('#drug').autoComplete({
                        resolverSettings: {
                            url: url
                        },
                        events: {
                            searchPost: function (resultFromServer) {
                                console.log("from ser",resultFromServer)
                                if(resultFromServer.allDrugData.length==0)
                                {
                                     $('#DrugDetailId').val(null);
                                    $('#drugPrice').val(null);
                                    $('#PackingDescr').val(null);
                                    $('#drugRxExpire').val(null);
                                    $('#brandReference').val(null);
                                }
                                
                                if(resultFromServer.isNdc == 1){
                                    isNdcSelected = true;
                                    console.log("Hippy it is Ndc.");
                                }else
                                    isNdcSelected = false;
                                
                                selectedDrugData = resultFromServer.allDrugData;
                                return resultFromServer.drugData;
                            }
                        }
                       });





                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                 $("#datetimepicker").datepicker({
                    autoclose: true,
                    format: 'mm/dd/yyyy',
                    orientation: 'bottom',
                    todayHighlight:'true',
                    endDate: '+0d',
                    defaultViewDate: today,
                    maxDate: new Date()
                }).on('hide', function () {
  $('#drug').focus();
});

                 $('#datetimepicker').datepicker('setDate', 'now');
                //  $('#datetimepicker').data("DateTimePicker").date(new Date());

                //   $('#datetimepicker').val('');

                // var strengthTextField = '<input type="text" onkeypress="return blockSpecialChar(event)" name="Strength" id="Strength" class="form-control" value="" placeholder="-">';
            var strengthTextField = '<input type="text"  name="Strength" id="Strength" class="form-control" value="" placeholder="-">';
            var strengthSelectField = '<select id="dosage_strength" name="Strength" value="" class="form-control" placeholder="-"></select>';
            var qty;
            var jsonDataObject;
            var selectedTxt;
            var selectedVal;
            var searchedMarDrug;
            var qty2;
            $('#strengthFieldId').html(strengthTextField);
            var searchedResult = {};

    $('#drug').on("autocomplete.select",function(evt,item){
            if($("#product_marketer").is("select")) {
                console.log('its select');
            }

            if($("#dosage_strength").is("input")) { 
                $('#dosage_strength').remove();
            $('#strengthFieldId').append('<select class="wd-100p" placeholder="-" id="dosage_strength" name="Strength" value="" required=""></select>');
            }

            if($("#product_marketer").is("input")) { 
                $('#product_marketer').remove();
            $('#select_product_marketer').append('<select class="wd-100p" placeholder="-" id="product_marketer" name="marketer" value="" required=""></select>');
            }

                searchedResult = {};
                jsonDataObject=null;
                qty = 0;
                    // alert(search);
                    console.log(item,evt);
                    // var search = $(this).val();  this will give id
                    var search = item.id;
                    console.log('this is selected', item);
                    console.log(search);
                    if(!search){
                        return false;
                   }
                   
                   // $('#drug_button').hide();
                    console.log(selectedDrugData);
                    console.log(selectedDrugData);
                    searchedResult =   selectedDrugData.filter(function(x){
                        // console.log(x);
                        return x.id == search;
                    });
                    
                    if($("#dosage_strength").length)
                    {
                       $('#dosage_strength')[0].options.length = 0;
                    }
                    if($("#product_marketer").length)
                    {
                        $('#product_marketer')[0].options.length = 0;
                    }
                    $('#DrugDetailId').val(searchedResult[0].id);
                    qty = searchedResult[0].default_rx_qty;
                    
                    if($.trim(qty) > 0){
                        $('#quantity').val(qty).valid();
                        $('#drugPrice').val('$'+numberWithCommas(qty * $.trim(searchedResult[0].unit_price))).valid();
                        console.log('greater than 0');
                    }else{
                        $('#quantity').val(qty);
                        $('#drugPrice').val($.trim(searchedResult[0].unit_price)).valid();
                    }
                    $("#drugPrice").attr("readonly", false);

                    //$('#PackingDescr').val(searchedResult[0].dosage_form).valid();
                    $('#drugRxExpire').val(searchedResult[0].rx_expire).valid();
                    $('#brandReference').val(searchedResult[0].brand_reference).valid();
                    $('#strengthFieldId').html(strengthSelectField);
                    
                    console.log("NDC-VALUE:"+isNdcSelected);
                    if(isNdcSelected == true)
                    {
                        console.log("MySearchResult:"+searchedResult[0]);
                        $("#product_marketer").empty().append(new Option(searchedResult[0].marketer, searchedResult[0].id));
                        $("#dosage_strength").empty().append(new Option(searchedResult[0].strength, searchedResult[0].id));
                        $("#PackingDescr").val(searchedResult[0].dosage_form);
                    }

                    //$('#Strength').val(searchedResult[0].strength).valid();
                    //$('#product_marketer').val(searchedResult[0].marketer);
                    ///***********Select marketer*************///
                    if(isNdcSelected == 0)
                    {
                        var url2 = '{{url('/search-drug-marketer')}}';
                        $.ajax({
                            url: url2,
                            data: 'search='+searchedResult[0].rx_label_name,
                            method: 'get',
                            success: function(result){
                                var jsonObject = $.parseJSON(result);
                                $("#product_marketer").append(new Option("", ""));

                                $.each(jsonObject, function (key, value) {
                                    if(key != "" && value != "")
                                        $("#product_marketer").append(new Option(key, value));
                                });
                                $("#product_marketer").append(new Option("+ ADD NEW", "add_new_marketr"));
                            },
                                error: function(data){
                            }});
                    }
                    /////////////////Alternate## Drug////////////////////                  
                    var gcnVal = '"'+searchedResult[0].gcn_seq+'"';
                    $('#sent_edits_to_hcp_btn').hide();
                    if(localStorage.getItem('gcn_seq') != gcnVal){
                        $('#mbr-pay').prop("disabled", true);
                        $('#hcp_comment_area').show();
                        $('#send_edits_to_hcp_btn').show();
                        $('#pharmacy_comments_area').val("");
                    }else{
                        $('#mbr-pay').prop("disabled", false);
                        $('#hcp_comment_area').hide();
                        $('#send_edits_to_hcp_btn').hide();
                        $('#sent_edits_to_hcp_btn').hide();
                    }
                    ///////////////////////////////////
                    //**********Select Strength****************//
                    jsonDataObject = null;
                    var requestSent = false;
                    $('#product_marketer').on('change',function(event){
                        event.preventDefault();
                        event.stopPropagation();
                        event.stopImmediatePropagation();                        
                        console.log($("#dosage_strength").length);
                        if($("#dosage_strength").length)
                        {
                            $('#dosage_strength')[0].options.length = 0;
                        }
                        if(!$(this).val()){
                            return false;
                        }
                        $('#strengthFieldId').html(strengthSelectField);
                         selectedTxt = $("#product_marketer option:selected").text();
                         selectedVal = $("#product_marketer option:selected").val();
                        console.log('___________________Q1');
                        console.log(selectedVal,selectedTxt);
                        console.log(searchedResult[0]);
                        console.log('___________________Q2');
                        var url3 = '{{url('/search-drug-strength')}}';
                        $.ajax({
                            url: url3,
                            data: 'search='+searchedResult[0].rx_label_name.trim()+'&marketer='+selectedTxt.trim(),
                           // data: 'search='+searchedResult[0].rx_label_name.trim(),
                            method: 'get',
                            success: function(result){
                                var jsonObject = $.parseJSON(result.list);
                                jsonDataObject = $.parseJSON(result.data);
                                //$("#dosage_strength").append(new Option("", ""));
                                
                                $.each(jsonObject, function (key, value) {
                                    if(value.trim() != "")
                                        
                                        $("#dosage_strength").append(new Option(value,key));
                                });
                                
                              
                                console.log("str drop ",$("#dosage_strength").html());
                                if(jsonDataObject != ""){
                                    $('#DrugDetailId').val(selectedVal);
                                    if($("#dosage_strength").length > 0){
                                        console.log($("#dosage_strength option:selected").val());
                                        console.log('inside console strengt');
                                        $('#DrugDetailId').val($("#dosage_strength option:selected").val());
                                    }
                                    //console.log(jsonDataObject[selectedVal]);
                                   // console.log(selectedVal);
                                   // console.log(jsonDataObject);
                                    console.log(selectedDrugData);
                                     searchedMarDrug =   selectedDrugData.filter(function(x){
                                            return x.id == selectedVal;
                                        });
                                    console.log('___________________');
                                    console.log(searchedMarDrug[0]);
                                    
                                   // searchedMarDrug = searchedMarDrug[0];
                                    if(searchedMarDrug[0].default_rx_qty > 0)
                                    {
                                        qty2 = searchedMarDrug[0].default_rx_qty;
                                    }else{ qty2 = 0; }
                                    
                                    if($.trim(qty2) > 0){
                                        $('#quantity').val(qty2).valid();
                                        $('#drugPrice').val('$'+numberWithCommas(qty2 * $.trim(searchedMarDrug[0].unit_price))).valid();
                                        console.log('greater than 0');
                                    }else{
                                        $('#quantity').val(qty2);
                                        $('#drugPrice').val($.trim(searchedMarDrug[0].unit_price)).valid();
                                    }                                        
                                    // $('#drugPrice').val(jsonDataObject[selectedVal].unit_price).valid();
                                    $('#PackingDescr').val(searchedMarDrug[0].dosage_form).valid();
                                    $('#drugRxExpire').val(searchedMarDrug[0].rx_expire).valid();
                                    $('#brandReference').val(searchedMarDrug[0].brand_reference).valid();
                                }
                                else{
                                    $('#strengthFieldId').html(strengthTextField);
                                }
                            },
                            complete: function() {
                                //   requestSent = false;
         },
                            error: function(data){
                            }
                        });
                            toggleReadOnlyFields($('#drugPrice').val());

        //   }

                    $('#dosage_strength').on('change',function(){
                        var selectedVal2 = $("#dosage_strength option:selected").val();
                        console.log('this is str value qamar'+selectedVal2);
                        console.log(jsonDataObject);

                        if(jsonDataObject != "" && selectedVal2 !=""){
                            $('#DrugDetailId').val(selectedVal2);
                            $('#drugPrice').val(jsonDataObject[selectedVal2].unit_price).valid();
                            $('#PackingDescr').val(jsonDataObject[selectedVal2].dosage_form).valid();
                            $('#drugRxExpire').val(jsonDataObject[selectedVal2].rx_expire).valid();
                            $('#brandReference').val(jsonDataObject[selectedVal2].brand_reference).valid();
                             $('#brandReference').val(jsonDataObject[selectedVal2].brand_reference).valid();
                             $('#quantity').val(jsonDataObject[selectedVal2].default_rx_qty);
                        }
                        toggleReadOnlyFields($('#drugPrice').val());
                    });
                    
            });


                  

                    function numberWithCommas(x) {
                      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                         }

                  

                    $(this).valid();
                    if($('#thirdPartyPaid').val())
                    {
                        window.pharmacyNotification.calculateRxProfitability($('#thirdPartyPaid').val());
                    }


                });




                 /*  var allPres=[];
                    $('#pres').select2({
                        tags: true,
                        closeOnSelect: true,
                    minimumInputLength: 2,
                    ajax: {
                        url: "{{url('/get_pres_name')}}",
                        data: function (params) {
                            var query = {
                                name: params.term,
                            }

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function (data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            console.log(data);
                            if(data.pres_names)
                            {
                                allPres=data.pres_names;
                            }
                            return {
                                results: data.formatPresName
                            };



                        }
                    }
                });


                    $('#pres').on('change',function(){
                        var selectValue=$(this).val();
                        if(!selectValue)
                        {
                            return false;
                        }
                        var selectedPres=allPres.filter(function(x){
                            return selectValue == x.id
                        })
                        console.log(selectedPres);
                        if(selectedPres.length>0)
                        {

                            if(selectedPres[0].practice_phone_number)
                            {
                                $('input[name="PrescriberPhone"]').val(selectedPres[0].practice_phone_number);
                                $('input[name="PrescriberPhone"]').attr('readonly',true);
                            }else{
                                $('input[name="PrescriberPhone"]').val('');
                                $('input[name="PrescriberPhone"]').attr('readonly',false);
                            }

                            $('input[name="PrescriberName"]').val(selectedPres[0].practice_name);

                        }else{
                            $('input[name="PrescriberName"]').val(selectValue);
                            $('input[name="PrescriberPhone"]').val('');
                            $(this).val(null);
                            $('input[name="PrescriberPhone"]').attr('readonly',false);
                        }
             $(this).valid();
                    })  */







/*  end added for reporter order */


 $('#under_review_reason').on('show.bs.modal', function (e) {
    $('#under_review_textarea').val('');
          $('#orderUpdateData').append('<input type="hidden" id="under_review_reason" name="under_review_reason" />')

        $('#order_edit_Modal').addClass('v-hidden-opacity');

    });


$("#under_review_reason").on('hidden.bs.modal', function(){

       // console.log('hide call');
        $('#under_review_textarea').val('');
        $('#orderUpdateData #under_review_reason').remove();
        $('#order_edit_Modal').removeClass('v-hidden-opacity');

   });
   
   
   $('#alter_order_drug').click(function(){
      $('#product_marketer').val($('#lower_marketer').html());
      $('#Strength').val($('#lower_cost_drug_strength').val());
     // $('#PackingDescr').val($('#lower_cost_drug_dosage').val());
      $('#brandReference').val($('#lower_cost_drug_brand').val());
      $('#drugPrice').val(parseFloat($('#lower_ing_cost').html().replace('$', ''))*parseFloat($('#quantity').val()));
      console.log("QTY:"+$('#quantity').val()+":::"+parseFloat($('#lower_ing_cost').html()));
      window.pharmacyNotification.calculateRxProfitability($('#thirdPartyPaid').val());
      var rx_profitability = $('#rxProfitability').val().replace("$", "");
      var drug_price = $('#drugPrice').val().replace("$", "");
            $.ajax({
                url: "{{url('/alter-order-lower-cost')}}",
                data: 'old_drug_id='+$('#DrugDetailId').val().trim()+'&new_drug_id='+$('#lower_cost_drug_id').val().trim()+'&order_id='+$('#Id').val()+'&brand_reference='+$('#lower_cost_drug_brand').val()+'&strength='+$('#lower_cost_drug_strength').text()+'&drug_price='+drug_price+'&rx_profitability='+rx_profitability,
                method: 'post',
                success: function(result){
                    toastr.success( 'Order successfully altered with lower cost drug.');
                },
                complete: function() {
                    //   requestSent = false;
        },
                error: function(data){
                }
            });
   });
  
    </script>


@include('practice_module/patient_order_request/modal/js/clinical_adv_js')