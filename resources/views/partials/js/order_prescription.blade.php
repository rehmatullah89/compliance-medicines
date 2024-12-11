<script src="{{ url('js/jquery.maskMoney.js') }}" type="text/javascript"></script>
<script>

  function order_popup(){
  $('#lower_cost').modal('hide');
   $('#orderSubmit').modal('show');
}


    function addZeroes(num) {
        const dec = num.split('.')[1]
        num = Number(num)
        return !dec || dec.length < 3 ? num.toFixed(2) : num
    }

                function addSlashes(input) {
                    var v = input.value;
                    if (v.match(/^\d{2}$/) !== null) {
                        input.value = v + '/';
                    } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
                        input.value = v + '/';
                    }
                }


                function marketer_add()
                {    
                     $('#new_marketer_form label.error').remove();
                    var error_msg = false;
                    if($('#mark_marketer').val()=='')
                    {
                        $('div[forA="mark_marketer"]').append('<label class="error">This field is required.</label>');
                        error_msg = true;
                    }
                    if($('#mark_ndc').val()=='' && $('#mark_upc').val()=='')
                    {
                        $('div[forA="mark_ndc"]').append('<label class="error">This field is required.</label>');     
                        error_msg = true;
                    }
                    if( $('#mark_ndc').val()!='' && $('#mark_ndc').val().length<13)
                    {
                        $('div[forA="mark_ndc"]').append('<label class="error">NDC is not correct.</label>');
                        error_msg = true;
                    }  
                    if($('#mark_strength').val()=='')
                    {
                        $('div[forA="mark_strength"]').append('<label class="error">This field is required.</label>');     
                        error_msg = true;
                    }
                    if($('#mark_dosage_form').val()=='')
                    {
                        $('div[forA="mark_dosage_form"]').append('<label class="error">This field is required.</label>');     
                        error_msg = true;
                    }
                    if(error_msg == false)
                    {
                        var rx_label_title = $('form#orderFormData input#drug').val();
                        if($('#mark_rx_label_name').val()!='')
                        {
                            $('form#orderFormData input#drug').val($('#mark_rx_label_name').val());
                            var rx_label_title = $('#mark_rx_label_name').val();
                        }
                        $('#new_marketer_form label.error').remove();
                        
                        
                        $('#loading_small_img_one').show();
                        
                        $.ajax({
                            type:'POST',
                            url:"{{url('/drug/add-update')}}",
                            data:'rx_label_name='+rx_label_title+'&ndc='+$('#mark_ndc').val()+'&marketer='+$('#mark_marketer').val()+'&strength='+$('#mark_strength').val()+'&dosage_form='+$('#mark_dosage_form').val()+'&'+
                                            'added_from_pharmacy='+$('input[name="added_from_pharmacy"]').val(),
                            success:function(data) {
                                $('#loading_small_img_one').hide();
                                if(data.status==2){
                                    $('div[forA="mark_ndc"]').append('<label class="error">'+data.msg+'</label>');
                                }
                                else
                                {
                                
                                
                                $("#product_marketer option:last").before(new Option($('#mark_marketer').val(), data.last_id)).prop('selected', true);
                       
                                $('#product_marketer option[value="'+data.last_id+'"]').prop('selected', true);
                                $('#product_marketer').trigger("change");
                                $('#mark_ndc').val('');
                                $('#mark_rx_label_name').val('');
                                $('#mark_marketer').val('');
                                $('#mark_strength').val('');
                                $('#mark_dosage_form').val('');
                                $('#addMarketer').modal('hide');
                                // $('#strengthFieldId').html('<input type="text"  name="Strength" id="Strength" class="form-control" value="" placeholder="-">');
                                toastr.success('Marketer added successfully.');
                            }
                               
                            },
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                            }
                        });
                    }
                }


               $(document).ready(function(){
               
               $('#addMarketer').on('hidden.bs.modal', function (e) {
                        if($('#product_marketer').val()=='add_new_marketr'){ $('#product_marketer').val(''); }
                      });
               
                   $('#mark_marketer').change(function(){ 
                       if($('#mark_marketer').val()!=''){ $('div[forA="mark_marketer"] label.error').remove(); }
                       else{ $('div[forA="mark_marketer"]').append('<label class="error">This field is required.</label>'); }
                   });
                   // $('form#orderFormData input#drug').attr('autocomplete', 'off');
                   $('form#orderFormData select#product_marketer').change(function(){
                      if($(this).val()=='add_new_marketr') 
                      {
                          $('#product_marketer').val('');
                          $('#mark_rx_label_name').val($('form#orderFormData input#drug').val());
                          $('#addMarketer').modal('show');
                      }
                   });
                   
                   $('#mark_ndc').on('change keyup keydown', function(){
                      if($(this).val().length==13)
                      {
                          $('div[forA="mark_ndc"] label.error').remove();
                          console.log($(this).val().length);
                      } 
                   });
                   
                   
                });

                 function select_practice(data)
                {

                    $.ajax({
                            type:'POST',
                            url:"{{url('/update_session_practice')}}",
                            data: 'practice_ids='+data,
                            success:function(data) {
                               // location.reload();
                               if(data==1){ window.location = '{{ url("report/client_home") }}'; }
                               if(data==2){ window.location = '{{ url("report/client_dashboard") }}'; }
                               console.log(data);
                            },
                             headers: {
                                 'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                             }
                         });
                }

                function addPaySubmitOrder(txt)
                {
                    // $('input[name="InsuranceType"][value='+txt+']').prop('checked',true);
                    $('input[name="InsuranceType"]').val(txt);
                    $('input[name="asistantAuth"]').val($('#asistantAuthPop').val());
                    $('#orderSubmit').modal('hide');
                    $('#submitOrder').attr("disabled","disabled");
                        $('.loader').show();

                        var  order =  $('#orderFormData').serializeArray();

                        console.log(order);
                        var  postData = new FormData();

                        $.each(order, function(i, val) {
                            if(val.name== "RxOrigDate"){
                                // var newDob = val.value.replace(/[/]/g,'-');
                                // var date = new Date(newDob);
                                var dateAr = val.value.split('/');
                                var newDate = dateAr[2] + '-' +dateAr[0] + '-' + dateAr[1];
                                // console.log(newDob);
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
                     
                         
                        if($('#drug_clinc_adv')[0].files.length>0)
                        {
                          for (var index = 0; index < $('#drug_clinc_adv')[0].files.length; index++) {
                            postData.append("drug_clinical_advise[]", $('#drug_clinc_adv')[0].files[index]);
                          }
                        }
                        // if($('#drug_clinc_adv')[0].files[0])
                        // {
                        //      postData.append('drug_clinical_advise',$('#drug_clinc_adv')[0].files[0])
                        // }



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
                                if($.isEmptyObject(result.error)){

                                    $('.loader').hide();
                                    if(result.status){
                                       var InsuranceType = '';
                                       if(result.order.InsuranceType == 'Cash')
                                            {
                                                InsuranceType = 'SELF PAY';
                                                }else{
                                                    InsuranceType = 'PRIVATE PAY';
                                                            }

                                          if(!result.enrolled){
                                            toastr.success('Order has been placed successfully. <br> <span class="tt_uc_"> RX # '+result.order.RxNumber+'</span><br> Not Enrolled <br> <b>CHARGE TO PAYMENT CARD</b> <br> <span style="color:blue">$ '+window.pharmacyNotification.numberWithCommas(parseFloat(result.order.asistantAuth).toFixed(2))+'</span> <br>'+InsuranceType);
                                             // toastr.info('Message','Enrollment message has been sent ' +
                                             //    'Pharmacy will get notice when enrollment will be accepted');


                                        }else{
                                            toastr.success('Order has been placed successfully. <br> <span class="tt_uc_"> RX # '+result.order.RxNumber+'</span><br> Enrolled <br> <b>CHARGE TO PAYMENT CARD</b> <br>$ '+window.pharmacyNotification.numberWithCommas(parseFloat(result.order.asistantAuth).toFixed(2))+' <br> '+InsuranceType);
                                            // toastr.success('Message','Order has been placed successfully');

                                        }
                                        setTimeout(function(){
                                            $('#submitOrder').removeAttr('disabled');
                                            $('#orderFormData')[0].reset();
                                            // form reset is not working on select2 below line also works same
                                            $('#submitOrder').parents('form').find('input').val('');
                                            $('#submitOrder').parents('form').find('select').val('');
                                            $("#drug").val('').trigger('change') ;
                                            $("#pres").val('').trigger('change') ;
                                            $('#PatientId').val(result.order.PatientId);
                                        },3000);
                                    }else{
                                      toastr.error(result.message);
                                    }
                                }else{
                                    $('.loader').hide();
                                    toastr.error('Message','sorry please try again something went wrong');
                                }

                                // $('.alert').show();
                                // $('.alert').html(result.success);
                            },
                            error: function(data){
                                $('.loader').hide();

                                 $('#submitOrder').removeAttr('disabled');
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



                // order =========================



    // =====================  Drug use in enroll file ==============

               var selectedDrugData;
               var isNdcSelected=0;
           // alert(params.term);
           var url = '{{url('/drug-search')}}';

                   $(document).ready(function(){
            
                                  
   

                    $(document).on('keyup', '#drug', function (e) {
                        console.log('inside keyup drug');
                        if(!$('#drug').val())
                        {
                          $('#drug_button').hide();
                          $('#saving_offers').hide();
                        }else{
                          $('#drug_button').show();
                          $('#saving_offers').hide();
                        }
                       
                    });
//< =================== using select 2 ============>
                        /*    $('#drug').select2({
                           // tags: true,
                           minimumInputLength: 3,
                           ajax: {
                               url: url,
                               data: function (params) {
                                   var query = {
                                       name: params.term,
                                   }

                                   // Query parameters will be ?search=[term]&type=public
                                   return query;
                               },
                               processResults: function (data) {
                                   // Transforms the top-level key of the response object from 'items' to 'results'
                                   console.log(data['drugData']);
                                   console.log(data['allDrugData']);
                                   selectedDrugData = data['allDrugData'];
                                   
                                   return {
                                       results: data['drugData']
                                   };
                                   
                                   $(this).valid();
                               }
                           },
                //            language: {
                   // 			noResults: function(){
             //   					return "No Results Found <a href='#' class='btn btn-danger'>Use it anyway</a>";
                   // 			}
                   // 			},
                   // 			escapeMarkup: function(markup) {
                      // 			return markup;
                            // },
                           // templateResult: formatRepo
                       });
  end of drug using select 2
  */
                       // <=============== END using select 2 ============>

                       // function formatRepo (repo) {
                       //      console.log("formatrep",repo)
                       //      if(typeof repo.id === 'number')
                       //      {
                       //      	var rt=repo.text;
                       //      	return rt;
                       //      }

                       //  }

                 /*     
                 
                 
                 var presWithPhone=[]
                    $('#basicAutoSelect').autoComplete({
                        minLength:1,
                        resolverSettings: {
                            url: "{{url('/get_pres_name')}}"
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
                    });*/



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


                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                 $("#datetimepicker").datepicker({
                    autoclose: true,
                    format: 'mm/dd/yyyy',
                    orientation: 'bottom',
                    todayHighlight:'true',
                    setDate:new Date(),
                    maxDate:new Date(),
                    endDate: '+0d'
                    // defaultViewDate: today
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
            $('#strengthFieldId').html(strengthSelectField);
            var searchedResult = {};
            $('#drug').on("autocomplete.select",function(evt,item){
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
                   $('#drug_button').hide();
                   $('#saving_offers').show();
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
                    $('#product_marketer')[0].options.length = 0;
                    $('#DrugDetailId').val(searchedResult[0].id);
                    qty = searchedResult[0].default_rx_qty;
                    if($.trim(qty) > 0){
                        $('#quantity').val(qty).valid();
                        $('#drugPrice').val('$'+numberWithCommas(qty * $.trim(parseFloat(searchedResult[0].unit_price).toFixed(2)))).valid();
                        console.log('greater than 0');
                    }else{
                        $('#quantity').val(qty);
                        $('#drugPrice').val($.trim(parseFloat(searchedResult[0].unit_price).toFixed(2))).valid();
                    }
                    $("#drugPrice").attr("readonly", false);
                    //$('#orig_drug_unit_price').val(searchedResult[0].unit_price);
                    //$('#PackingDescr').val(searchedResult[0].dosage_form).valid();
                    $('#drugRxExpire').val(searchedResult[0].rx_expire).valid();
                    $('#brandReference').val(searchedResult[0].brand_reference).valid();
                    $('#strengthFieldId').html(strengthSelectField);
                    toggleReadOnlyFields($('#drugPrice').val());
                    
                    console.log("NDC-VALUE:"+isNdcSelected);
                    if(isNdcSelected == true)
                    {
                        console.log("MySearchResult:"+searchedResult[0]);
                        $("#product_marketer").empty().append(new Option(searchedResult[0].marketer, searchedResult[0].id));
                        $("#dosage_strength").empty().append(new Option(searchedResult[0].strength, searchedResult[0].id));
                        $("#PackingDescr").val(searchedResult[0].dosage_form);
                    }
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
                    //**********Select Strength****************//
                    jsonDataObject = null;
                    var requestSent = false;
                    $('#product_marketer').on('change',function(event){
                        event.preventDefault();
                        event.stopPropagation();
                        event.stopImmediatePropagation();
                        // if(!requestSent) {
                        //     requestSent = true;
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
  
                                var listLen = Object.keys(jsonObject).length;
                                var keyValue = "";
                                $.each(jsonObject, function (key, value) {
                                    keyValue = key;
                                    if(value.trim() != "")                                        
                                        $("#dosage_strength").append(new Option(value,key));
                                });
                                console.log("SUNNY-len:"+listLen);
                                if(listLen == 1)
                                    $('#PackingDescr').val(jsonDataObject[keyValue].dosage_form).valid();
                              
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
                                        $('#drugPrice').val('$'+numberWithCommas(qty2 * $.trim(parseFloat(searchedMarDrug[0].unit_price).toFixed(2)))).valid();
                                        console.log('greater than 0');
                                    }else{
                                        $('#quantity').val(qty2);
                                        $('#drugPrice').val($.trim(parseFloat(searchedMarDrug[0].unit_price).toFixed(2))).valid();
                                    }
                                     
                                    // $('#drugPrice').val(jsonDataObject[selectedVal].unit_price).valid();
                                    if(searchedMarDrug[0].dosage_form != undefined)
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
                            $('#drugPrice').val(parseFloat(jsonDataObject[selectedVal2].unit_price).toFixed(2)).valid();
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





function lower_cost(){

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
                               if(low_cost){
                                console.log('lower drug',low_cost);
                                $('#lower_rx_ing_cost').html($('#drugPrice').val());
                                $('#lower_gpi').html((low_cost.generic_pro_id != null? low_cost.generic_pro_id : "-"));
                                $('#lower_dosage_strength').html(low_cost.dosage_form+" "+low_cost.strength);
                                $('#lower_dea').html('#'+low_cost.dea);
                                $('#lower_drug_name').html(low_cost.rx_label_name);                        
                                $('#lower_gcnseq').html(low_cost.gcn_seq);
                                $('#lower_source').html((low_cost.sponsor_source != "" && low_cost.sponsor_source != null?low_cost.sponsor_source:"-"));
                                $('#lower_item').html(low_cost.id);
                                $('#lower_marketer').html(low_cost.marketer);
                                $('#lower_ndc').html(low_cost.ndc);
                                $('#lower_upc').html(low_cost.upc);
                                $('#lower_cost_drug_id').val(low_cost.id);
                                $('#lower_ing_cost').html('$'+low_cost.unit_price);
                                $('#lower_order_web_link').html(low_cost.order_web_link);
                                $('#lower_cost_drug_strength').val(low_cost.strength);
                                $('#lower_cost_drug_dosage').val(low_cost.dosage_form);
                                $('#lower_cost_drug_brand').val(low_cost.brand_reference);

                                if($('#lower_set').val() == 0){
                                    $('#lower_set').val(1)
                                    $('#lower_cost').modal('show');
                                }else
                                    $('#orderSubmit').modal('show');                              
                              }else{
                                 $('#orderSubmit').modal('show');
                              }
                            },
                            complete: function() {
                                //   requestSent = false;
         },
                            error: function(data){
                            }
                        });

}


                $('#orderFormData').submit(function(e){
                        e.preventDefault();

                       
                        if(!$(this).valid())
                        {
                            $('span.all-order-error').text('Please Fill All Fields');
                            var validator = $(this).validate();
                            var lenErr='';
                            var remote=false;
                        
                       
                            $.each(validator.errorList, function (index, value) {
                                console.log(value);
                               
                                if(value.element.name=="RxNumber" || value.element.name=="Quantity" || value.element.name =="DaysSupply" || value.element.name=="RxIngredientPrice" || value.element.name=="RxThirdPartyPay" || value.element.name=="RxPatientOutOfPocket")
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
                                    if(value.method == 'remote'){

                                        remote = true;
                                        return false;

                                    }
                                    if(value.method=="check_non_zero")
                                    {
                                        lenErr=value.element.name+ ' '+ value.message;
                                        return false;
                                    }
                                }
                                if(value.method=="required")
                                {
                                    if(value.element.name=="DrugDetailId")
                                    {
                                        lenErr='Please select drug';
                                    }else{
                                        lenErr=value.element.name+' is required';
                                    }
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
                        }else{
                            $('#rxNoPop').text('Rx # '+$('input[name="RxNumber"]').val());
                            // $('#asistantAuthPop').val('$ '+parseFloat($('input[name="asistantAuth"]').val().replace('/$|,/g','')).toFixed(2));
                            $('#asistantAuthPop').val($('input[name="asistantAuth"]').val());
                            console.log(parseFloat($('input[name="asistantAuth"]').val().replace('$','')).toFixed(2));
                            console.log(addZeroes($('input[name="asistantAuth"]').val().replace('$','')));
                            // console.log(parseFloat($('input[name="asistantAuth"]').val()));
                            console.log($('input[name="asistantAuth"]').val());
                            // console.log(addZeroes(parseFloat($('input[name="asistantAuth"]').val())));
                            lower_cost();
                           
                        }
                        {{--var patient = {!! isset($patient) ?$patient: 0 !!};--}}
                        {{--var pid = $('#PatientId').val();--}}
                        {{--if(patient && !pid){--}}
                      {{--$('#PatientId').val(patient.Id);--}}
                            {{--console.log('enroll page'+patient.Id);--}}
                        {{--}--}}
                        {{--else{--}}
                           {{--console.log('create page '+pid);--}}
                        {{--}--}}


                        // $('#submitOrder').attr("disabled","disabled");
                        // $('.loader').show();

                        // var  order =  $(this).serializeArray();

                        // console.log(order);
                        // var  postData = new FormData();

                        // $.each(order, function(i, val) {
                        //     if(val.name== "RxOrigDate"){
                        //         // var newDob = val.value.replace(/[/]/g,'-');
                        //         // var date = new Date(newDob);
                        //         var dateAr = val.value.split('/');
                        //         var newDate = dateAr[2] + '-' +dateAr[0] + '-' + dateAr[1];
                        //         // console.log(newDob);
                        //         console.log(newDate);
                        //         val.value = newDate;
                        //     }

                        //     if(val.name== "RxIngredientPrice" || val.name== "RxPatientOutOfPocket" || val.name=="RxThirdPartyPay" || val.name=="asistantAuth" || val.name=="RxSelling" || val.name=="RxProfitability")
                        //     {
                        //         if(val.value.indexOf('$') != -1)
                        //         {
                        //             val.value=val.value.replace("$", "");
                        //         }
                        //     }

                        //     if(val.name=="PrescriberPhone")
                        //     {
                        //         val.value=val.value.replace(/[- )(]/g, '');
                        //     }
                        //     postData.append(val.name, val.value);
                        //     // console.log(val.value);
                        // });

                        // if($('#drug_clinc_adv')[0].files[0])
                        // {
                        //      postData.append('drug_clinical_advise',$('#drug_clinc_adv')[0].files[0])
                        // }



                        /*  for (var key of postData.entries()) {
                        console.log(key[0] + ', ' + key[1]);
                        } */

                        // console.log(practice);
                        // console.log(postData);
                        // $.ajax({
                        //     url: "{{url('/order')}}",
                        //     method: 'post',
                        //     cache: false,
                        //     contentType: false,
                        //     processData: false,
                        //     data: postData,
                        //     async:true,
                        //     success: function(result){
                        //         console.log(result);
                        //         if($.isEmptyObject(result.error)){
                        //             // alert(result);
                        //             // console.log(result);
                        //             $('.loader').hide();
                        //             if(result.status){



                        //                   if(!result.enrolled){
                        //                     toastr.success('Order has been placed successfully. <br> RX # '+result.order.RxNumber+'<br> not enrolled <br> <b>ASSISTANCE REQUESTED</b> <br> <span style="color:blue">$'+result.order.RxPatientOutOfPocket+'</span> <br> SELF PAY ');
                        //                      // toastr.info('Message','Enrollment message has been sent ' +
                        //                      //    'Pharmacy will get notice when enrollment will be accepted');


                        //                 }else{
                        //                     toastr.success('Order has been placed successfully. <br> RX # '+result.order.RxNumber+'<br> enrolled <br> <b>ASSISTANCE REQUESTED</b> <br> '+result.order.RxPatientOutOfPocket+' <br> SELF PAY ');
                        //                     // toastr.success('Message','Order has been placed successfully');

                        //                 }
                        //                 setTimeout(function(){
                        //                     $('#submitOrder').removeAttr('disabled');
                        //                     $('#orderFormData')[0].reset();
                        //                     // form reset is not working on select2 below line also works same
                        //                     $('#submitOrder').parents('form').find('input').val('');
                        //                     $('#submitOrder').parents('form').find('select').val('');
                        //                     $("#drug").val('').trigger('change') ;
                        //                     $("#pres").val('').trigger('change') ;
                        //                     $('#PatientId').val(result.order.PatientId);
                        //                 },3000);
                        //             }
                        //         }else{
                        //             $('.loader').hide();
                        //             toastr.error('Message','sorry please try again something went wrong');
                        //         }




                        //         // $('.alert').show();
                        //         // $('.alert').html(result.success);
                        //     },
                        //     error: function(data){
                        //         $('.loader').hide();

                        //          $('#submitOrder').removeAttr('disabled');
                        //          console.log(data.data)
                        //          if(data.status == 422)
                        //          {
                        //             var errors = $.parseJSON(data.responseText);
                        //             var st='';
                        //             for(var key in errors)
                        //             {
                        //                 console.log("out",errors[key])
                        //                 var value=errors[key]
                        //                 for(var val in value)
                        //                 {
                        //                     if(typeof value === 'object')
                        //                     {
                        //                        console.log('iner',value[val])
                        //                     st+=value[val];
                        //                     }

                        //                 }
                        //             }
                        //             toastr.error('',st);
                        //          }

                        //     }
                        // });
                    // return false;
                    });

                   var allPres=[];
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
                    })

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

                    $('#orderFormData').validate({
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
                            RxOrigDate:{
                                required:true
                            },
                            Quantity:{
                                required: true,check_non_zero: true
                            },
                            DaysSupply:{
                                required: true
                            },
                            RefillsRemaining:{
                                required: true
                            },
                            RxPatientOutOfPocket:{
                                required: true
                            },
                            RxThirdPartyPay:{
                                required: true
                            },
                            asistantAuth:{
                                required: true
                            },
                            PrescriberPhone:{
                                required: true,minlength: minCharPhone
                            },
                            DrugDetailId:{
                                required: true
                            },


                            PrescriberName:{
                                required: true
                            }
                        },
                        messages:{
                            RxNumber:{
                                remote:"Duplicate Rx number"
                            },
                             PrescriberPhone: {
                               minlength: function () {
                                  return [
                                    'Please Enter Min 10 digits'];
                                // return [
                                //     (minChar - parseInt($('#mobilePhone').val().length)) +
                                //     ' more characters to go.'];

                            }
                        },
                        },
                        errorPlacement: function (error, element) {

                          /*  if($(element).attr('name') == 'RxNumber' && error.text().indexOf('Duplicate') !== -1)
                            {
                                    error.insertAfter(element);
                            } */
                            // console.log(error.text().indexOf("required") !== -1)
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

                   //end of doc ready
                });












                // =============== validations =========================


                   $('#pocketOut').on('keyup',function(){
                    $('input[name="asistantAuth"]').val($(this).val());
                   });






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

                function IsDigit(n) {
                    console.log(n.target.readOnly);
                    if(n.target.readOnly){
                        return false;
                    }
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
                            // var vl=n.target.value;
                            // if(vl.indexOf('$') != -1)
                            // {
                            //   vl=vl.replace("$", "");
                            // }
                            // if(vl.indexOf(',') != -1)
                            // {
                            //   vl=vl.replace(",", "");
                            // }
                            // if(vl.indexOf('.') != -1)
                            // {
                            //   vl=vl.replace(".", "");
                            // }
                            // if(vl.length!=7)
                            // {
                            //   console.log(vl,vl.length);
                            //   return true;
                            // }
                            // else{
                            //   console.log("fls",vl,vl.length)
                            //   // $('input[name="RxIngredientPrice"]').maskMoney('destroy');
                            //   return false;
                            // }
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

                document.querySelectorAll('#drugPrice,#pocketOut,#thirdPartyPaid').forEach(item => {
                  item.addEventListener('paste', (event) => {
                     var paste = (event.clipboardData || window.clipboardData).getData('text');
                        console.log(paste)

                        if (!isNaN(paste)) {
                            return true;

                        } else{

                             event.preventDefault();
                        }
                  })
                })

                function maxVal(n)
                {
                    // var temp=n.target.value;
                    // if(temp.indexOf('$') !== -1)
                    // {
                    //     temp=n.target.value.replace("$", "");
                    // }
                    // console.log("temp",temp)
                    // if(parseFloat(temp) > 9999)
                    // {
                    //     return false;
                    // }else{
                    //     return true;
                    // }
                }

                function addSlashes(input)
                {
                    var v = input.value;
                    if (v.match(/^\d{2}$/) !== null)
                    {
                        input.value = v + '/';
                    } else if (v.match(/^\d{2}\/\d{2}$/) !== null)
                    {
                        input.value = v + '/';
                    }
                }


                $("#prescription-order-form1").steps({
                    headerTag: "h4",
                    bodyTag: "section",
                    transitionEffect: "slideLeft",
                    enableAllSteps: true,
                    enablePagination: false,
                    autoFocus: true,
                    onInit: function(event, currentIndex){

                    }
                });



                // ========================== Ajax request ===================

                function ajax__method(data)
                {
                    $('.loader').show();
                    $.ajax({
                        type:'POST',
                        url:"{{url('/drug/add-update')}}",
                        data:$( "form[name='drug_form']" ).serialize(),
                        success:function(data) {
                            if(data.type=='update')
                            {
                                var FormDataW = $( "form[name='drug_form']" ).serializeArray();

                                $.each(FormDataW, function(i, field){ window.DrugsVal[$('input[name="id"]').val()][field.name] = field.value; FormData[field.name] = field.value;});
                                $('#tr_'+$('input[name="id"]').val()).html('<td>'+highlight(FormData.ndc, $('#keyword').val())+'</td><td>'+highlight(FormData.rx_label_name, $('#keyword').val())+'<span class="strength_form">'+highlight(FormData.dosage_form, $('#keyword').val())+'('+highlight(FormData.strength, $('#keyword').val())+')</span></td><td>'+highlight(FormData.generic_name, $('#keyword').val())+'</td>'
                                    +' <td>'+highlight(FormData.marketer, $('#keyword').val())+'</td><td>$ &nbsp'+FormData.unit_price+'</td>'
                                    +'<td><a href="javascript:edit_drug('+FormData.id+');" title="Edit"><i class="fa fa-edit"></i></a><a title="Delete" href="javascript:drug_del('+FormData.id+')"><i class="fa fa-trash"></i></a></td>');

                            }
                            $( "#cancel_drug" ).trigger( "click" );
                            $('.loader').hide();
                            toastr.success('Message',data.msg);
                        },
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                        }
                    });
                }



    $(document).ready(function() {

        $('form[name="product_form2"] input[required]').blur(function(){
            if( !$(this).val() ){
                $(this).addClass('order-error');
                $(this).prev('label').addClass('star');
            }
        });


        $('form[name="product_form2"] input[required]').on('keypress change', function(){

            $('label.error').hide();
            if($(this).valid()){
                $(this).removeClass('order-error');
                $(this).prev('label').removeClass('star');
            }else
            {
                $(this).addClass('order-error');
                $(this).prev('label').addClass('star');
            }
        });
        $('#product_form2').validate({

        			rules:{
        				ndc:{
        					remote:{
        						param:{url:"{{route('check_ndc_number')}}",
        							method:"get"
        						}
        					}
        				}
        			},
        			messages:{
        				ndc:{
        					remote:"Duplicate NDC Number"
        				}
        			},
                       errorPlacement: function (error, element) {


                         },

                        highlight: function(element, errorClass, validClass) {
                            $(element).parent('div').find('input').addClass('order-error');
                            $(element).parent('div').find('label:first').addClass('star');

                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).parent('div').find('input').removeClass('order-error');
                            $(element).parent('div').find('label:first').removeClass('star');

                        },

                    })

        $('#orderSubmit').on('hidden.bs.modal',function(){
            $('#asistantAuthPop').prop('disabled',true);
        })
      });
               function add_product(selector ,form,event,url,method){


                    event.preventDefault();
                    if(!$('#'+selector).valid())
                    {
                        $('label.error').hide();

                        $('#'+selector+' input[required].error').addClass('order-error');
                        $('#'+selector+' input[required].error').prev('label').addClass('star');




                        // $('div.all-drug-error').text('Please Fill All Fields');
                            var validator = $('#'+selector).validate();
                            console.log(validator);
                            var lenErr='';
                            $.each(validator.errorList, function (index, value) {
                                console.log(value);
                                if(value.element.name=="ndc" )
                                {
                                    if(value.method=="min" || value.method == "minlength")
                                    {
                                        // lenErr = value.message;
                                        if(value.element.name == 'ndc'){
                                        lenErr='NDC should be equal or greater than 11';
                                    }else{
                                        lenErr=value.element.name+ ' should be equal or greater than '+value.element.minLength;
                                        return false;
                                    }
                                    }
                                    else if(value.method=="required"){
                                        lenErr='NDC is required';
                                        return false;
                                    }
                                   else if(value.method="remote")
                                    {
                                		lenErr='Duplicate NDC number';
                                		return false;
                                    }

                                }
                                if(value.method=="required")
                                {
                                    if(value.element.name == 'rx_label_name'){
                                        lenErr='Rx Label Name is required';
                                        $('input[name="'+value.element.name+'"]').focus();
                                    }
                                   else{
                                    lenErr=value.element.name+' is required';
                                    return false;
                                    }
                                }
                            });

                            if(lenErr!='')
                            {
                                $('div.all-drug-error').text(lenErr);
                            }

                            $('div.all-drug-error').show();
                            setTimeout(function(){  $('div.all-drug-error').hide(); }, 6000);


                        return false;



                   }else{
                       $('#'+selector+' input[required]').removeClass('order-error');
                        $('#'+selector+' input[required]').prev('label').removeClass('star');
                   }

                    console.log(event);
                    console.log($(this));
                    console.log(url,method);
                    console.log( $('#product_form2').serializeArray() );
                    $('#'+selector+' button:last').prop('disabled',true);
                    var formData = $(this).serializeArray();
                    console.log(formData);
                   var formData2 = $('#'+selector).serializeArray();
                   console.log(formData2);

                    $.each(formData2,function(key,val){
                      console.log(key,val);
                      if(val.name=="unit_price" || val.name=="default_rx_qty")
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
                      
                   });

                   // $('#'+selector).serialize();
                   var params = $.extend({}, doAjax_params_default);
                   params['url'] = url;
                   params['data'] = formData2;
                   params['requestType'] = method;
                   params['successCallbackFunction'] = `your success callback function`
                  callAjaxMethod(params,selector);
               }

                String.prototype.endsWith = function(suffix) {
                    return this.indexOf(suffix, this.length - suffix.length) !== -1;
                };
                var doAjax_params_default = {
                    'url': null,
                    'requestType': "GET",
                    'contentType': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'dataType': 'json',
                    'data': {},
                    'beforeSendCallbackFunction': null,
                    'successCallbackFunction': null,
                    'completeCallbackFunction': null,
                    'errorCallBackFunction': null,
                };


                function callAjaxMethod(doAjax_params,selector) {
                    $('.loader').show();
                    var url = doAjax_params['url'];
                    var requestType = doAjax_params['requestType'];
                    var contentType = doAjax_params['contentType'];
                    var dataType = doAjax_params['dataType'];
                    var data = doAjax_params['data'];
                    var beforeSendCallbackFunction = doAjax_params['beforeSendCallbackFunction'];
                    var successCallbackFunction = doAjax_params['successCallbackFunction'];
                    var completeCallbackFunction = doAjax_params['completeCallbackFunction'];
                    var errorCallBackFunction = doAjax_params['errorCallBackFunction'];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    //make sure that url ends with '/'
                    /*if(!url.endsWith("/")){
                     url = url + "/";
                    }*/

                    $.ajax({
                        url: url,
                       // crossDomain: true,
                        type: requestType,
                       // contentType: contentType,
                        dataType: dataType,
                        data: data,
                        beforeSend: function(jqXHR, settings) {
                            if (typeof beforeSendCallbackFunction === "function") {
                                beforeSendCallbackFunction();
                            }
                        },
                        success: function(data, textStatus, jqXHR) {
                            console.log(data);
                            $('.loader').hide();
                            if(data.status==1)
                            {
                            $('#'+selector+' button:last').prop('disabled',false);


                            
                    $('#DrugDetailId').val(data.last_id);
drug_unit_price = $('#unit_price').val();
 if(drug_unit_price.indexOf('$') != -1)
                                {
                                    drug_unit_price=drug_unit_price.replace("$", "");
                                }
                                if(drug_unit_price.indexOf(',') != -1)
                                {
                                    drug_unit_price=drug_unit_price.replace(",", "");
                                }


                    qty = $('#default_rx_qty').val();
                    if(window.pharmacyNotification.isEmpty(qty) || window.pharmacyNotification.isBlank(qty)){
                      qty = 0;
                    }
                     if(window.pharmacyNotification.isEmpty(drug_unit_price) || window.pharmacyNotification.isBlank(drug_unit_price)){
                      drug_unit_price = 0;
                    }
                    if($.trim(qty) > 0){
                        $('#quantity').val(qty).valid();
                        $('#drugPrice').val('$'+window.pharmacyNotification.numberWithCommas(qty * $.trim(parseFloat(drug_unit_price).toFixed(2)))).valid();
                        console.log('greater than 0');
                    }else{
                        $('#quantity').val(qty);
                        $('#drugPrice').val('$'+window.pharmacyNotification.numberWithCommas($.trim(parseFloat(drug_unit_price).toFixed(2)))).valid();
                    }
                    $("#drugPrice").attr("readonly", false);

                    //$('#PackingDescr').val(searchedResult[0].dosage_form).valid();
                    $('#drug').val($('#rx_label_name').val());
                    $('#drugRxExpire').val('365').valid();
                    $("#product_marketer").empty().append(new Option($('#marketer').val(), data.last_id));
                    // $("#product_marketer").append(new Option("+ ADD NEW", "add_new_marketr"));
                    $("#dosage_strength").empty().append(new Option($('#strength').val(), data.last_id));
                     $('#brandReference').val($('#brandReference-drg').val()).valid();
                    $("#PackingDescr").val($('#dosage_form').val());


                           // toastr.success('Message',data.msg);
                        //  var ndc_val =  $('#product_form2 #ndc').val();
                        console.log('drug js from order_prescription ===');
                        var found_str =  $('#product_form2 #ndc').val().includes('99999-');
                        console.log(found_str);
                        var g_or_b = $('#product_form2 #b_gen-drg').val();
                        console.log(g_or_b);
                        if(g_or_b){
                            if(g_or_b.toLowerCase().includes('g')){
                                $('#product_added_msg-Modal #pro_or_cmp').empty().text('New * Generic * Product');  
                      console.log('inside gen');
                            }

                            if(!found_str && !g_or_b.toLowerCase().includes('g')){
                            $('#product_added_msg-Modal #pro_or_cmp').empty().text('New * Drug *'); 
                            console.log('inside drug');
                        }

                        }
                        if(found_str){
                            $('#product_added_msg-Modal #pro_or_cmp').empty().text('New * Compound * Product');  
                            console.log('inside cmp');
                        }
 

                        if($('#product_form2 #upc').val()){
                            $('#product_added_msg-Modal #pro_or_cmp').empty().text('New * OTC TREATMENT *'); 
                            console.log('inside drug');
                        }

                        $('#drug_button').hide();
                        $('#saving_offers').show();
                        toggleReadOnlyFields(true);
                            $('#'+selector)[0].reset();

                            $('#product_added_msg-Modal').modal('show');
                            showDrug();
                        }
                        if(data.status==2)
                        {
                            $('#'+selector+' button:last').prop('disabled',false);
                            $('#'+selector+' input#ndc').addClass('order-error');
                            $('#'+selector+' input#ndc').prev('label').addClass('star');
                            $('div.all-drug-error').text(data.msg).show();
                            setTimeout(function(){  $('div.all-drug-error').hide(); }, 4000);
                           // toastr.error('Message',data.msg);
                        }

                            if (typeof successCallbackFunction === "function") {
                                successCallbackFunction(data);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (typeof errorCallBackFunction === "function") {
                                errorCallBackFunction(errorThrown);
                            }

                        },
                        complete: function(jqXHR, textStatus) {
                            if (typeof completeCallbackFunction === "function") {
                                completeCallbackFunction();
                            }
                        }
                    });
                }

                $("#product_form2 #upc").on('change', function(){
    if($(this).val() || $(this).val() != ''){
        $("#product_form2 #ndc").removeAttr("required").removeClass('error').next('label').remove(); 
    }else
        $("#product_form2 #ndc").attr("required", true);     
});

                function showDrug()
                {
                    $('#rxForm').toggle();
                    $('#drug_form').toggle();
                }

                
                function showSavingOffers()
                {                    
                    $.ajax({
                        url: "{{url('/get-saving-offers')}}",
                        data: 'drug_id='+$('#DrugDetailId').val().trim()+'&title='+$('#drug').val().trim(),
                        method: 'get',
                        success: function(result){
                            var sameDrug = result.same_drugs;
                            var similarDrug = result.similar_drugs;
                            var sameDrugHtml = '';
                            var similarDrugHtml = '';

                            if(similarDrug.length > 0)
                                $("#generic_name_id").html(similarDrug[0].generic_name);

                            $.each(sameDrug, function (key, value) {
                                localStorage.setItem(value['id'], JSON.stringify(value));
                                sameDrugHtml +=  '<tr><td class="txt-black-24 tt_uc_ weight_600"><div class="flx-justify-start"><span class="txt-black-24 weight_900 tt_uc_ mr-4_ fs-12_">'+value['brand_reference']+' sponsor opportunity:</span>';
                                sameDrugHtml += '<span class="txt-black-24 weight_400 tt_uc_ fs-12_ mr-4_">'+value['rx_label_name']+' ('+value['strength']+')</span><span class="txt-black-24 weight_400 fs-12_">PAY NO MORE THAN $'+value['unit_price']+' PER dosage</span>';
                                sameDrugHtml += '</div></td><td><span class="txt-red weight_600 tt_uc_" style="cursor: pointer;" onclick="setOfferValues('+value['id']+');" data-dismiss="modal">offer link-'+(parseInt(key)+parseInt(1))+'</span></td></tr><tr class="td-pad-0"><td></td><td></td></tr>';
                            });
                            $("#same_drug_count").html('SAME DRUG ('+sameDrug.length+')');
                            $("#same_drugs_table tbody").html(sameDrugHtml);

                            $.each(similarDrug, function (key, value) {
                                localStorage.setItem(value['id'], JSON.stringify(value));
                                similarDrugHtml +=  '<tr><td class="txt-black-24 tt_uc_ weight_600"><div class="flx-justify-start"><span class="txt-black-24 weight_900 tt_uc_ mr-4_ fs-12_">'+value['brand_reference']+' sponsor opportunity:</span>';
                                similarDrugHtml += '<span class="txt-black-24 weight_400 tt_uc_ fs-12_ mr-4_">'+value['rx_label_name']+' ('+value['strength']+')</span><span class="txt-black-24 weight_400 fs-12_">PAY NO MORE THAN $'+value['unit_price']+' PER dosage</span>';
                                similarDrugHtml += '</div></td><td><span class="txt-red weight_600 tt_uc_" style="cursor: pointer;" onclick="setOfferValues('+value['id']+');" data-dismiss="modal">offer link-'+(parseInt(key)+parseInt(1))+'</span></td></tr><tr class="td-pad-0"><td></td><td></td></tr>';
                            });
                            $("#similar_drug_count").html('SIMILAR DRUG ('+similarDrug.length+')');
                            $("#similar_drugs_table tbody").html(similarDrugHtml);
                            
                            $("#saving_offers_count").html('Saving Offers ('+(parseInt(similarDrug.length)+parseInt(sameDrug.length))+')');
                            $('#saving_offers-Modal').modal("show");
                        },
                        complete: function() {
                            //   requestSent = false;
                        },
                        error: function(data){
                        }
                    });
                    //console.log("DDI:"+$('#DrugDetailId').val());
                }

                function setOfferValues(id)
                {
                    var list = JSON.parse(localStorage.getItem(id));
                    //alert(list['rx_label_name']);
                    $('#drug').val(list['rx_label_name']);
                    $('#product_marketer').find('option').remove().end().append('<option value=""></option>').append('<option value="'+id+'">'+list['marketer']+'</option>').val("");
                    $('#PackingDescr').val(list['dosage_form']);
                    $('#brandReference').val(list['brand_reference']);
                    $('#drugPrice').val('$'+parseFloat(parseFloat(list['unit_price'])*parseFloat($('#quantity').val())));
                    window.pharmacyNotification.calculateRxProfitability($('#thirdPartyPaid').val());
                }

                function clearForm(form)
                {
                    $('#'+form)[0].reset();
                    $('#'+form+' input[required]').removeClass('order-error');
                    $('#'+form+' input[required]').prev('label').removeClass('star');
                    $('#'+form+' select').empty();
                    if($('#'+form+' #drug'))
                    {
                        $('#'+form+' #drug').val('').trigger('change') ;
                    }
                     if($('#'+form+' #pres'))
                    {
                        $('#'+form+' #pres').val('').trigger('change') ;
                    }

                }
                // var dash=true;
                // $("#rx_no").keyup(function() {
                //     if($(this).val().length==2 && $(this).val().match(/^[A-Za-z]+$/))
                //     {
                //         if(dash)
                //         {
                //            $(this).val(($(this).val()+'-'));
                //            dash=false;
                //         }
                //         if($(this).val().indexOf('-') == -1)
                //         {
                //             dash=true;
                //         }



                //     }
                // });

                function checkDaySupply()
                {


                    if(parseInt($('#quantity').val()) < parseInt($('#daysSupplyFld').val()))

                    {
                        toastr.error('','Quantity should be greater than days supply');
                    }
                }

                function orderMessage()
                {
                    if($('#rx_no').val() && $('#drug').val())
                    {
                        $('#pracPop').text($('#pharmacy-txt').text());
                        $('#rxPop').text($('#rx_no').val());
                        // var medicine=$("#medNamePop").contents().filter(function(){
                        //         return this.nodeType == 3; //return text nodes
                        // }).text();
                        // console.log(medicine)

                        var str=($('select[name="Strength"] :selected').text()) ? $('select[name="Strength"] :selected').text() : $('input[name="Strength"]').val();
                        if(str==undefined)
                        {
                            str='';
                        }
                        $("#medNamePop").text(" "+$('#drug :selected').text()+" "+str+" "+$('#PackingDescr').val());


                        $('#patientMessage').modal("show");
                        $('#orderMessage').val($('#orderMsg').val());
                    }

                }
                function addMessage()
                {
                    if($('#orderMessage').val())
                    {
                        $('#orderMsg').val($('#orderMessage').val());
                        $('#patientMessage').modal("hide");
                    }
                }

                function toggleReadOnlyFields(value){
                    if(value){
                        $("#pocketOut").attr("readonly", false);
                        $("#thirdPartyPaid").attr("readonly", false);
                    }else{
                        $("#pocketOut").attr("readonly", true);
                        $("#thirdPartyPaid").attr("readonly", true);
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
    if(event.target.name=='Quantity' || event.target.name=='default_rx_qty')
    {
        if(event.target.value.indexOf('.') == -1 &&  charCode==46)
        {
            return true;
        }
        // else if(event.target.value.length == 0 && charCode==48)
        // {
        //     return false;
        // }
        
    }
    if (!charStr.match(/^[0-9]+$/)){
        event.preventDefault();
    }

      }

        </script>
<script>
    $("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    }
    // blur: function() { 
    //   formatCurrency($(this), "blur");
    // }
});


$("input[data-type='quantity']").on({
    keyup: function() {
        formatQuantity($(this));
    }
    // blur: function() { 
    //     formatQuantity($(this), "blur");
    // }
});

function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}
/*
$("#drugPrice").maskMoney({ decimal:'.', allowZero:true, prefix: '$'});
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
    (parseFloat(this.value.replace(',', '.')).toFixed(2)).replace('.', ',');
    formatCurrency($(this), "blur");
});
$('input[name="asistantAuth"]').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});
$('#asistantAuthPop').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});;
$('input[name="Quantity"]').mask('9Z#Z#Z#Z#.9', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatQuantity($(this), "blur");
});
$("#RxSelling").mask('9Z#Z#Z#Z#.9', {translation:  {'Z': {pattern: /[.]/, optional: true}}}).blur(function(){
  formatCurrency($(this), "blur");
});
$("#unit_price").maskMoney({ decimal:'.', allowZero:true, prefix: '$',precision:4});
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
      console.log("bluring with deci",right_side)
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
      console.log("bluring no deci",input_val)
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
  // input[0].setSelectionRange(caret_pos, caret_pos);
}
function enableField()
{
    if($('#asistantAuthPop').prop('disabled')){
        $('#asistantAuthPop').prop('disabled',false);
        $('#asistantAuthPop').focus();
    }else{
        $('#asistantAuthPop').prop('disabled',true);
    }
}


$('#alter_order_drug').click(function(){
      //$('#product_marketer').val($('#lower_marketer').html());
      //$('#Strength').val($('#lower_cost_drug_strength').val());
      $('#PackingDescr').val($('#lower_cost_drug_dosage').val());
      $('#brandReference').val($('#lower_cost_drug_brand').val());
      //$('#drugPrice').val($('#lower_ing_cost').html()*$('#quantity').val());
      $('#drugPrice').val('$'+parseFloat(parseFloat($('#lower_ing_cost').html().replace('$', ''))*parseFloat($('#quantity').val())));
      window.pharmacyNotification.calculateRxProfitability($('#thirdPartyPaid').val());
      var rx_profitability = $('#rxProfitability').val().replace("$", "");
      var drug_price = $('#drugPrice').val().replace("$", "");
      console.log('Old:'+$('#DrugDetailId').val()+':New'+$('#lower_cost_drug_id').val());
            $.ajax({
                url: "{{url('/alter-order-lower-cost')}}",
                data: 'old_drug_id='+$('#DrugDetailId').val().trim()+'&new_drug_id='+$('#lower_cost_drug_id').val().trim()+'&order_id='+$('#Id').val()+'&brand_reference='+$('#lower_cost_drug_brand').val()+'&strength='+$('#lower_cost_drug_strength').val()+'&drug_price='+drug_price+'&rx_profitability='+rx_profitability,
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


// prescription file ndc and upc filed optional

$("#mark_upc").on('change', function(){
    // alert('a');
    if($(this).val() || $(this).val() != ''){
        $("#mark_ndc").removeAttr("required").removeClass('error').next('label').remove(); 
    }else
        $("#mark_ndc").attr("required", true);     
});

</script>

