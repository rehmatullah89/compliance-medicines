
<script type="text/javascript">

	$(document).ready(function(){





    $('.overview-datatable').DataTable({
                            processing: false,
                            serverSide: false,
                            Paginate: false,
                            lengthChange: false,
                            pageLength : 5,
                            order:[],
                            bFilter: false,
                            columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                      ]
                        });

        /** practice form steps  */
        var form = $("#practice-reg-form");
        $("#practice-reg-step").steps({

headerTag: "h4",
bodyTag: "section",
transitionEffect: "slideLeft",
enableAllSteps: true,

{{--  enablePagination: false,  --}}
autoFocus: true,
onInit: function(event, currentIndex){
{{--  $(this).append($('#form_btns').html());  --}}
{{--  $('#form_btns').html('');  --}}
},
onStepChanging: function (event, currentIndex, newIndex) {


form.validate().settings.ignore = ":disabled,:hidden";
var isValid = false;
var hadError = false;
var inputs = $(":input, select");
var stepElements = $('#practice-reg-step-p-'+currentIndex).find(inputs);
var count = stepElements.length;
// if (count <= 0) {
// return true;
// }
$(stepElements).each(function (idx) {
console.log($(this));
    console.log(idx);
    if ($(this).valid() == true ) {
        console.log('inside valid');
isValid = $(document.forms[0]).validate().element($(this));
if (!isValid) { hadError = true; }
}
    })

    if(hadError)
    return false;
console.log(hadError);
// console.log(stepElements);
// console.log(stepElements.length);
// console.log("cur",currentIndex,"nex",newIndex)
form.validate().settings.ignore = ":disabled,:hidden";
if (currentIndex > newIndex)
{
return true;
}
return form.valid();
// if (currentIndex > newIndex)
// {

// return true;
// }


},
onFinishing: function (event, currentIndex) {

form.validate().settings.ignore = ":disabled";
console.log("on finishing");
return form.valid();
return true;
},
onFinished: function (event, currentIndex) {
form.submit();

{{--  toastr.success('Success',"Practice has been added successfully");  --}}


}

});



jQuery.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, "Please upload image with extension jpg, jpeg or png.");

var minChar = 14;
        $("#practice-reg-form").validate({

            rules: {

               /* practice_code: {
                        required: true,
                        remote: {
                            url: "{{route('check-practice-code')}}",
                            data:{id: function(){return $('input[name="id"]').val();}},
                            method: 'post',
                            async:false,
                             }
                    },*/
                    practice_logo:{
                      extension: "png|jpe?g"
                    },
               practice_phone_number: {
                        required: true,minlength: minChar,
                        remote: {
                            url: "{{route('check-practice-phone')}}",
                            data:{id: function(){return $('input[name="id"]').val();}},
                            method: 'post',

                            async:false,
                            // complete: function(data){
                            //     console.log(data);

                            //     if(!data.responseJSON)
                            //     {
                            //         $("#practice-reg-step-t-0").get(0).click();
                            //     }else{
                            //       $("#practice-reg-step").find('a[href="#finish-disabled"]').attr("href", '#finish');
                            //     }
                            // }

                        }
                    },
              email: {
                required: true,
                minlength: 6,
                email: true
            },
                      practice_license_number: {
                        required: true,
                        remote: {
                            url: "{{route('check-license')}}",
                            data:{id: function(){return $('input[name="id"]').val();}},
                            method: 'post',

                            async:false,
                            // complete: function(data){
                            //     console.log(data);
                            //     if(!data.responseJSON)
                            //     {
                            //       $("#practice-reg-step-t-0").get(0).click();
                            //     }else{
                            //       $("#practice-reg-step").find('a[href="#finish-disabled"]').attr("href", '#finish');
                            //     }
                            // }

                        }
                    }

            },
            messages: {
                    /* practice_code:{
                        remote: "Practice Code Already Exist"
                    },*/
                    practice_phone_number: {
                        remote: "Practice Phone Already Exist",

                       minlength: function () {
                              return [
                                'Please Enter Min 10 digits'];
                            // return [
                            //     (minChar - parseInt($('#mobilePhone').val().length)) +
                            //     ' more characters to go.'];

                        }
                    },
                     practice_license_number: {
                        remote: "Practice License Already Exist"
                    },
                },
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
        });




	});

   var email_state;
    function add_update_practice()
   {

    toggleButton("finish",   false);
       var checka = [];

       var d_count = 0;
        $('input[fname="email"]').each(function(key, valu){
            checka[d_count] = validity_check(valu);
             d_count++;
        });

        if($.inArray('no', checka)>= 0){ return false; }



       var formSelector = $( "form[name='practice_form']");
       var pdata=  formSelector.serializeArray();
       console.log(formSelector);
       var pfdata= new FormData(formSelector[0]);
      //  console.log(pdata);
      //  console.log(pfdata.entries());
      //  toggleButton("finish",   true);
      //  return;
       $.each(pdata,function(key,val){

       	if(val.name=="practice_code")
       	{
       		val.value=val.value.replace(/Ø/g,'0');
       	}
       	if(val.name.indexOf("service_offer") !== -1)
        {
          
          var lbl_text=$('input[name="'+val.name+'"][type="radio"]').parent().parent().find('label:first-child').text();
          if(lbl_text!="")
          {
            var lbl_name=val.name.replace('service_choice','service_title')
            pfdata.append( lbl_name,  lbl_text);
          }
          
          
        }
       });
       console.log("af",pdata)

      //  return;
       // $( "form[name='practice_form']" ).serialize()
       $('.loader').show();
        $.ajax({
           type:'POST',
           url:"{{url('/practice/add-update')}}",
           data:pfdata,
           contentType: false,
            cache: false,
            processData:false,
           success:function(data) {
toastr.remove();
              if(data.status==false)
              {
              	toggleButton("finish",   true);
                toastr.error(data.msg);
              }else{
               if(data.type=='update')
               {
                  // var FormDataW = $( "form[name='practice_form']" ).serializeArray();
                   //$.each(FormDataW, function(i, field){ FormData[field.name] = field.value;});
                   //$('#tr_'+$('input[name="id"]').val()).html('<td>'+FormData.ndc+'</td><td>'+FormData.rx_label_name+'<span class="strength_form">'+FormData.dosage_form+'('+FormData.strength+')</span></td><td>'+FormData.generic_name+'</td>'
                     //   +' <td>'+FormData.marketer+'</td><td>$ &nbsp'+FormData.unit_price+'</td>'
                      //  +'<td><a href="javascript:edit_practice('+FormData.id+');" title="Edit"><i class="fa fa-edit"></i></a><a title="Delete" href="javascript:practice_del('+FormData.id+')"><i class="fa fa-trash"></i></a></td>');
              toggleButton("finish",   true);

              $("#practice-reg-step-t-0").get(0).click();
// $( "#practice-reg-step" ).steps('reset');
				$('#practice-reg-form')[0].reset();


               }else{
                $( "#practice-reg-step" ).steps('reset');
                $('#practice-reg-form')[0].reset();
                setUserRoles('Physician',0);
               console.log('yes');

               // var myForm = document.getElementsByClassName("practice_form");
               // clearValidation(myForm);

                toggleButton("finish",   true);
                if(data.practice)
                  {
                      var h='<tr data-prid="'+data.practice.id+'"><td><a class="txt-orange_red-force td_u_force" onclick="open_edit_practice('+data.practice.id+')">'+data.practice.practice_type+'</a><a href="{{url("update-session-practice")}}/'+data.practice.id+'" class="elm-right hover-black-child_"><img src="{{asset("images/svg/select-icon.svg")}}" /></a></td><td class="p-name">'+data.practice.practice_name+'</td><td class="p-zip">'+data.practice.practice_zip+'</td><td class="phone_format p-phone">'+data.practice.practice_phone_number+'</td><td class="site-cnt">'+data.site_contact+'</td></tr>';

                      

                      $('#practice_comp_table').DataTable().row.add($(h)).draw();  
                    
                      // console.log($(h));
                  }
                   
               }
               $('.loader').hide();
              // toast.setGravity(Gravity.CENTER, 0, 0);

               toastr.success('Message',data.msg);
                // toggleButton("finish",   true);
                if(data.type=='update'){
                    $('#practice-Add-Modal').modal('hide');
                    if(data.practice)
                    {
                      $('tr[data-prid='+data.practice.id+'] .p-name').text(data.practice.practice_name);
                      $('tr[data-prid='+data.practice.id+'] .p-zip').text(data.practice.practice_zip);
                      $('tr[data-prid='+data.practice.id+'] .p-state').text(data.practice.practice_state);
                      $('tr[data-prid='+data.practice.id+'] .p-phone').text(data.practice.practice_phone_number);
                    }
                    if(data.site_contact)
                    {
                      $('tr[data-prid='+data.practice.id+'] .site-cnt').text(data.site_contact);
                    }
                    // setTimeout(function(){ parent.location.reload(); }, 500);
                 //       var h='<tr data-prid="'+data.practice.id+'"><td><a class="txt-orange_red-force td_u_force" onclick="open_edit_practice('+data.practice.id+')">'+data.practice.practice_type+'</a></td><td class="p-name">'+data.practice.practice_name+'</td><td class="p-zip">'+data.practice.practice_zip+'</td><td class="phone_format p-phone">'+data.practice.practice_phone_number+'</td><td class="site-cnt">'+data.site_contact+'</td></tr>';
                //       $('.practice_datatable').DataTable().row.add($(h)).draw();  
                    
                //       console.log($(h));   
            		}
        		}
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });
   }

   function toggleButton(buttonId, enable)
   {
       if (enable)
       {
           // Enable disabled button
           var button = $("#practice-reg-step").find('a[href="#' + buttonId + '-disabled"]');
               button.attr("href", '#' + buttonId);
               button.parent().removeClass();

       }
       else
       {
           // Disable enabled button
           var button = $("#practice-reg-step").find('a[href="#' + buttonId + '"]');
               button.attr("href", '#' + buttonId + '-disabled');
               button.parent().addClass("disabled");
       }
   }

      function validity_check(input)
    {

        if($(input).is(":valid")) {
            var res =  [];
            var count = 0;
                $('input[fname="email"]').each(function(key, valu){

                    if(IsEmail($(valu).val()))
                    {
                        if(  ($(input).attr('name')!=$(valu).attr('name') ))
                        {
                            if($.trim($(input).val()) == $.trim($(valu).val()))
                            {
                                res[count] = 'yes';
                                count++;
                            }
                        }else
                        {
                            if($('input[name="users['+key+'][id]"]').length > 0 )
                            {
                               return check_email($(valu).val(), $('input[name="users['+key+'][id]"]').val());
                            }
                            else
                            {

                               return check_email($(valu).val());
                           }
                        }
                    }else{
                        // res[count] = 'yes';
                        count++;
                    }
                });
               // console.log(res);
               if($.inArray('yes', res)!= '-1'){
                   //$('#toast-container').remove();
                  // console.log('not work');
                    toastr.error('Email should not be duplicate.');
                    return false;
                }else{
                        return 'yes';
                    }
          }
    }

    function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
      console.log('email issues');
    return false;
  }else{
    return true;
  }
}


   function check_email(email, id=false)
   {
       var msgs;
       var formData = 'email='+email+'&_token={{csrf_token()}}';
       if(id){ formData = formData+'&id='+id }
        $.ajax({
            url: "{{route('check-user-mail')}}",
            method: 'post',
            data: formData,
            async:true,
            success: function(result){
               // console.log(result);
                if(result.status == 400){
                    toastr.error('"'+email+'" already exist in database.');
                    msgs = 'no';
                    // toggleButton('finish', false);
                    toggleButton('finish', true);
                }else{
                   msgs = 'yes';
                   // toggleButton('finish', true);
                }
                //console.log(msgs+' check   1');

            }
        });
        //console.log(msgs+' check    2');
        return msgs;
   }

function foo(res){
    // alert(res);
    return res;
}

$('#reset_order_sheet').click(function(){
   $('#sheet_title').val("");
   $('#sheet_details').val("");
});

//Global Lists
var OrderSheetsList = [];
var OSCategoriesList = [];
var OSDrugsList = [];

   function edit_practice(id)
   {
    // $("#practice-reg-step").find('a[href="#finish"]').attr("href", '#finish-disabled');
       $('#practiceId').val(id);
       $("#cancel_practice").trigger("click");
       $('.hupdate').text('EDIT PRACTICE');
       $('#append_field > tr').removeClass('selected_row');
       $('#tr_'+id).addClass('selected_row');
       $('form[name="practice_form"]').append('<input name="id" type="hidden" value="'+id+'" />');
       $("#practice-reg-step").steps('unskip', 4);
       $("ul[role='tablist'] li:nth-child(5)").show();
       $("#practice-reg-step-t-5").children("span").text("6");       
    //    $('input[name="ndc"]').attr('readonly', 'readonly');
       $('#submit_practice').text('UPDATE');
      $('.loader').show();
       $.ajax({
           type:'GET',
           url:"{{url('/get-practice/')}}/"+id,
           success:function(data) {
               toastr.clear();
                $('.loader').hide();
                console.log(data);
                $.each(data.practice, function( key, val ) {

                  if(key == 'practice_logo'){
                    $('#logo_updates').remove();
                 
                    if(val)
                    {
                      $('#uploaded_image').empty();
                      $('#uploaded_image').append('<img style="height:100px;width:100px" class="practice_logo_image" src="{{asset('/')}}'+val+'" ><span onclick="removeUpload()" class="remove-btn">&#10006;</span>');
                      $('#practice_log_field').hide();
                      $('.file-upload-content').show();
                      $('#practice_logo').append('<input type="hidden" name="logo_updates" id="logo_updates" value="added" />');
                      return true;
                      
                    }else{
                      $('#uploaded_image').empty();
                      $('#practice_log_field').show();
                      $('.file-upload-content').hide();
                      $('#practice_logo').append('<input type="hidden" name="logo_updates" id="logo_updates" value="removed" />');
                 
                      return true;
                  }
                  }
                	
                      if(key == 'practice_type'){
                        setUserRoles(val,0);
                      }

                    	$('input[name="'+key+'"]').val(val);
                    	$('select[name="'+key+'"] > option[value="'+val+'"]').prop('selected', true);
                        @hasrole('super_admin')
                        if(key == 'parent_id' && !val){
                            $('form[name="practice_form"] input[name="branch_name"]').removeAttr('required').attr('disabled',true).val('').attr("placeholder", "MAIN BRANCH");
                        }

@endhasrole
                	// }
                });
                if(data.bankDetail)
                {
                    $('form[name="practice_form"]').append('<input name="bank[id]" type="hidden" value="" />');
                    $.each(data.bankDetail, function( keyb, valb ) {
                        $('input[name="bank['+keyb+']"]').val(valb);
                       $('select[name="bank['+keyb+']"] > option[value="'+valb+'"]').prop('selected', true);
                    });
                }

   // if(data.services[0])
   //              {
   //                  $('form[name="practice_form"]').append('<input name="service[0][id]" type="hidden" value="" />');
   //                  $.each(data.services[0], function( keyb, valb ) {
   //                    if(keyb=='start_date'|| keyb=='end_date')
   //                    {
   //                      var dateAtr = valb.split('-');
   //                valb = dateAtr[1] + '/' +dateAtr[2] + '/' + dateAtr[0];
   //                $('input[name="service[0]['+keyb+']"]').datepicker('setDate', new Date(valb));
   //              }else{
   //                      $('input[name="service[0]['+keyb+']"]').val(valb);
   //                     $('select[name="service[0]['+keyb+']"] > option[value="'+valb+'"]').prop('selected', true);
   //                   }
   //                  });
   //              }

                $.each(data.services,function(keyb,valb){
                  if(keyb>0){add_service_row();}
                  $('.service_fee_div:nth-child('+(keyb+1)+')').prepend('<input fname="id" name="service['+keyb+'][id]" type="hidden" value="" />')
                  $.each(valb, function(innerKey, innerVal){
                    console.log("innr",innerVal);
                    if(innerVal){
                       if(innerKey=='start_date'|| innerKey=='end_date')
                        {
                          var dateAtr = innerVal.split('-');
                         innerVal = dateAtr[1] + '/' +dateAtr[2] + '/' + dateAtr[0];
                      $('.service_fee_div:nth-child('+(keyb+1)+')').find('input[name="service['+keyb+']['+innerKey+']"]').datepicker('setDate', new Date(innerVal));
                      }else if(innerKey=="fee" || innerKey=="base_fee")
                      {
                        $('.service_fee_div:nth-child('+(keyb+1)+')').find('input[name="service['+keyb+']['+innerKey+']"]').val("$"+innerVal);
                      }else if(innerKey=="profit_share")
                      {
                        $('.service_fee_div:nth-child('+(keyb+1)+')').find('input[name="service['+keyb+']['+innerKey+']"]').val(innerVal+"%");
                      }
                      else if(innerKey=="facilitator_id")
                      {
                        console.log('facccc');
                        $('.service_fee_div:nth-child('+(keyb+1)+')').find('select[name="service['+keyb+'][facilitator_id]"]').val(innerVal);
                      }
                      else if(innerKey=="comission")
                      {
                        console.log('comission');
                        $('.service_fee_div:nth-child('+(keyb+1)+')').find('input[name="service['+keyb+'][comission]"]').val(innerVal+"%");
                      }
                      else{
                       // $('.service_fee_div:nth-child('+(keyb+1)+')').find('select[name="service['+keyb+']['+innerKey+']"] > option[value="'+innerVal+'"]').prop('selected', true);
                       $('.service_fee_div:nth-child('+(keyb+1)+')').find('input[name="service['+keyb+']['+innerKey+']"]').val(innerVal);
                     }
                    }
                   });
                });

if(!data.practice.parent_id){
    @hasrole('super_admin')
$('.primary_site_div:nth-child(1)').find('select[name="users[0][role]"]').prepend(`<option value="3">Practice Super Admin</option>`);
@endhasrole
}else{
    $(".primary_site_div:nth-child(1)").find('select[name="users[0][role]"] option[value="3"] ').remove();
}
                $.each(data.users, function( keyu, valu ) {
                   if(keyu>0){ add_row(); }
console.log(keyu);
console.log(valu);
                   if($('.primary_site_div:nth-child('+(keyu+1)+') > input[type="hidden"]').length){

                        $('.primary_site_div:nth-child('+(keyu+1)+') > input[type="hidden"]').remove();
                   }

                   $('.primary_site_div:nth-child('+(keyu+1)+')').prepend('<input fname="id" name="users['+keyu+'][id]" type="hidden" value="" />');

                    $.each(valu, function(innerKey, innerVal){
                      if(innerKey == 'role'){
                        innerVal = valu.roles[0].id;

                      }

                     $('.primary_site_div:nth-child('+(keyu+1)+')').find('select[name="users['+keyu+']['+innerKey+']"] > option[value="'+innerVal+'"]').prop('selected', true);
                     $('.primary_site_div:nth-child('+(keyu+1)+')').find('input[name="users['+keyu+']['+innerKey+']"]').val(innerVal);
                   });

                });
                var i=0;
                $.each(data.services_offered,function(keys,vals){
                  // console.log(keys,vals);
                  
                  // $.each(vals,function(key,val){
                  //   console.log($('.service_offer_div:nth-child('+(keys+1)+')'));
                  //   if(key=="service_choice")
                  //   {
                  //     $('.service_offer_div:nth-child('+(keys+1)+')').find('input[name="service_offer['+keys+']['+key+']"][value="'+val+'"]').prop('checked',true);
                  //   }
                    
                  // });
                  i=0;
                  $(".service_offer_div").each(function(){
                      var text = $(this).find("label:first-child").text();
                      if(text==vals.service_title)
                      {
                        if($(this).find('input[type="hidden"]').length>0)
                        {
                          $(this).find('input[type="hidden"]').remove();
                        }
                          $(this).find('input[type="radio"][value="'+vals.service_choice+'"]').prop('checked',true);
                          $(this).append('<input type="hidden" value="'+vals.id+'" name="service_offer['+i+'][id]" />')
                      }
                      i++;
                  });
                });
                
                var rowCount = 0;   
                var ordersheetTable = '';
                OrderSheetsList = [];
                $.each(data.order_sheet, function( index, obj){
                        OrderSheetsList.push(obj.title.toLowerCase());
                        rowCount = parseInt(rowCount)+parseInt(1);
                        ordersheetTable += '<tr><td class="txt-black-24 tt_uc_ weight_500">'+obj.title+'</td>';
                        ordersheetTable += '<td class="txt-black-24 tt_uc_ weight_500">'+(obj.details == null?"":obj.details)+'</td>';
                        ordersheetTable += '<td class="txt-black-24 tt_cc_ weight_500"><div class="wd-100p" style="display: flex; justify-content: space-around;">';
                        ordersheetTable += `<a href="#action-qrcode" class="mr-3_ hover-black-child_" onclick="orderSheetCategories(`+obj.id+`)"><span class="fa fa-qrcode fs-17_ txt-gray-6"></span></a>`;
                        ordersheetTable += `<a href="#action-view" class="mr-3_ hover-black-child_"><span class="fa fa-eye fs-17_ txt-gray-6" onclick="orderSheetView(`+obj.id+`,'`+obj.title+`')"></span></a>`;
                        ordersheetTable += `<a  class="mr-3_ hover-black-child_" onclick="createEditOrderSheet(`+id+`,`+obj.id+`,'`+obj.title+`','`+obj.details+`')"><span class="fa fa-pencil fs-17_ txt-grn-shn-7j"></span></a><a onclick="deleteOrderSheet(`+obj.id+`)" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a></div></td></tr>`;  
                });                
                
                $('#add_order_sheet_btn').prop('disabled', false);
                if(rowCount>3){
                    $('#add_order_sheet_btn').prop('disabled', true);
                }

                $('#ordersheet_table').html(ordersheetTable);

                $('.loader').hide();
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });

   }


function removeUpload() {

$('.file-upload-content').hide();

$('#practice_log_field').show();

$('#practice_logo').val('');

$('#logo_updates').val('removed');
             
}



$(document).ready(function(){
  function practice_logo_status (){
  $('#logo_updates').val('added');
}
})
function practice_logo_status (){
  $('#logo_updates').val('added');
}


function close_box()
    {
        $('.backdrop, .box').animate({'opacity':'0'}, 300, 'linear', function(){
                $('.backdrop, .box').css('display', 'none');
            });
    }

        $(document).ready(function() {

            $('#uploaded_image').on('click','.practice_logo_image',function(){
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

        });  
            

 function open_edit_practice($id)
 {
    @hasrole('super_admin')
      $('#practice-Add-Modal .modal-title').text('Edit Branch');
    @else 
      $('#practice-Add-Modal .modal-title').text('Edit Practice');
    @endhasrole
      $('#practice-Add-Modal').modal('show');
    
    edit_practice($id);

    /*if($('#practice_type option:selected').val() != ""){
      setUserRoles($('#practice_type option:selected').val());
    }*/
}

$("[data-dismiss]").click(function () {
    if($('.modal-title').text() == 'Edit PracticeEdit Practice'){
        if(!confirm("Changes made, do you really want to discard changes?"))
          return false;
    }
});
$('#practice-Add-Modal').on('shown.bs.modal', function (e) {
	if($('#practice-show-modal').is(':visible')){
  		$('#practice-show-modal').modal('hide');
	}
});
$('#practice-Add-Modal').on('hidden.bs.modal', function () {
                      $('#uploaded_image').empty();
                      $('#practice_log_field').show();
                      $('.file-upload-content').hide();

$('form[name="practice_form"] input[name="id"]').remove();
$('form[name="practice_form"] input[name="bank[id]"]').remove();
@hasrole('super_admin')
$('form[name="practice_form"] input[name="parent_id"]').val('{{ @auth::user()->practices[0]->id }}');
$('form[name="practice_form"] input[name="branch_name"]').attr('required',true).removeAttr('disabled').attr("placeholder", "Enter Branch Name");
$(".primary_site_div:nth-child(1)").find('select[name="users[0][role]"] option[value="3"] ').remove();
@endhasrole
              $(this).find('form').trigger('reset');
            //    $( "#practice-reg-step" ).steps('reset');
               $('#practice-reg-form')[0].reset();
               clearValidation('#practice-reg-form');
               @hasrole('super_admin')
               $('#practice-Add-Modal .modal-title').text('Add Branch');
@else 
 $('#practice-Add-Modal .modal-title').text('Add Practice');
@endhasrole
               $("#practice-reg-step-t-0").get(0).click();

               //remove multiple users rows

               if($('.primary_site_div').length!=1)
               {
                  $('.primary_site_div').not('#primary_site').remove();
                  $('.primary_site_div').append('<div class="row" ><div class="col-sm-12 c-dib_ cnt-left"><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row()">Add <i  class="fa fa-plus-circle"></i></div></div></div>');
               }
               if($('.service_fee_div').length!=1)
               {
                  $('.service_fee_div').not('#service_fee').remove();
                  $('.service_fee_div').append('<div class="flx-justify-start mb-14_"><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_service_row()">Add <i  class="fa fa-plus-circle"></i></div></div>');
               }
               if($('.service_offer_div').length>0)
               {
               	$('.service_offer_div > input[type="hidden"]').remove();
               }
               if($('.service_fee_div').length>0)
               {
               	$('.service_fee_div > input[type="hidden"]').remove();
               }

});

function clearValidation(formElement){
 //Internal $.validator is exposed through $(form).validate()
 var validator = $(formElement).validate();
 //Iterate through named elements inside of the form, and mark them as error free
 $('[name]',formElement).each(function(){
     if(this.id){
   validator.successList.push(this);//mark as error free
//    $(this).next('label').remove();
//    console.log('#'+this.id);

//    $('label#'+this.id+'-error').remove();
   validator.showErrors();//remove error messages if present
//    $('#'+this.id).removeClass("error");
}
 });
 $("input.error,select.error").removeClass("error");
 validator.resetForm();//remove error class on name elements and clear history
 validator.reset();//remove all error and success data
}

var allow_user = 5;
var allow_srvc=3;
    function del_row(id)
    {
        var del_allow = allow_user;
        $('.primary_site_div:nth-child('+id+')').remove();
           total_field = $('.primary_site_div').length;
        if(total_field != 1)
        {
            var  add_btn_html = $('.primary_site_div:last > div:last-child').clone();
            var plus_minus_btn = '<i onclick="del_row('+(total_field)+')" class="fa fa-minus-circle" style="padding-right:5px;"></i><div  class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row()">Add <i  class="fa fa-plus-circle"></i></div>';
            $('.primary_site_div:last > div:last-child').html(plus_minus_btn);
        }else
        {


            $('.primary_site_div').append('<div class="row" ><div class="col-sm-12 c-dib_ cnt-left"><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row()">Add <i  class="fa fa-plus-circle"></i></div></div></div>');
        }

        set_index();

    }

    function add_row()
    {
        var error;
        var add_allow = allow_user;
        toastr.remove();
        $('.primary_site_div').find('input:visible, select').each(function(abkey, abval){

            if($(abval).val()==''){
                $(abval).addClass('error');
                //toastr.error('Message', 'Please enter the '+$(abval).attr('fname')+'.');
                error = 'no';
            }else{ $(abval).removeClass('error'); }

            });
            if(error=='no'){ return false; }

            if($('.primary_site_div').length < add_allow)
            {
              var  del_btn_html = $('.primary_site_div:last > div:last-child').clone();
              console.log($('.primary_site_div:last > div:last-child'))

              var minus_btn = $(del_btn_html).html('<i onclick="del_row('+$('.primary_site_div').length+')" class="fa fa-minus-circle"></i>');
              minus_btn = minus_btn[0].outerHTML;
              var plus_minus_btn = $(del_btn_html).html('<i onclick="del_row('+($('.primary_site_div').length+1)+')" class="fa fa-minus-circle" style="padding-right:5px;"></i><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row()">Add <i  class="fa fa-plus-circle"></i></div>');
              plus_minus_btn = plus_minus_btn[0].outerHTML;


                if($('.primary_site_div').length==1){

                   $('.primary_site_div:nth-child(1) > div:last-child').remove(); }

                var inhtml = $('#primary_site').html();

                $('.primary_site_div:last').after('<div class="col-sm-12 primary_site_div pl-0 pr-0">'+inhtml+'</div>');

                $('.primary_site_div:last > input[type="hidden"]').remove();
                if($('.primary_site_div').length==add_allow){

                   $('.primary_site_div:nth-child('+(add_allow-1)+') > div:last-child').html(minus_btn);
                   minus_btn_a = minus_btn.replace((add_allow-1), add_allow);
                   $('.primary_site_div:nth-child('+(add_allow)+')').append(minus_btn_a);

                }

                if(($('.primary_site_div').length < add_allow ) && ($('.primary_site_div').length >= 2))
                {
                    var childr = ($('.primary_site_div').length - 1);
                    if($('.primary_site_div').length>2)
                    {
                        $('.primary_site_div:nth-child('+childr+') > div:last-child').remove();
                        $('.primary_site_div:nth-child('+childr+')').append(minus_btn);
                    }
                    $('.primary_site_div:nth-child('+$('.primary_site_div').length+')').append(plus_minus_btn);

                    //inhtml = inhtml+plus_minus_btn;
                }
                    // $('.primary_site_div:nth-child('+$('.primary_site_div').length+')').addClass('row');
            }

            set_index();

        }

    function set_index(){
            var count = 2;

            $('.primary_site_div').each(function(index, value){
                        $(value).find('input, select').each(function(ind, val){
                            $(val).attr('name', 'users['+index+']['+$(val).attr('fname')+']');
                        });
               if($(value).find('i.fa-minus-circle').length>0)
               {
                   $(value).find('i.fa-minus-circle').attr('onclick', 'del_row('+count+')' );
                   count++;
                }
            });
       }

       function add_service_row()
       {
          var error;
        var add_srv = allow_srvc;


            if($('.service_fee_div').length < add_srv)
            {
              var  del_btn_html = $('.service_fee_div:last > div:last-child').clone();
              console.log($('.service_fee_div:last > div:last-child'))

              var minus_btn = $(del_btn_html).html('<i onclick="del_row_srvc('+$('.service_fee_div').length+')" class="fa fa-minus-circle"></i>');
              minus_btn = minus_btn[0].outerHTML;
              var plus_minus_btn = $(del_btn_html).html('<i onclick="del_row_srvc('+($('.service_fee_div').length+1)+')" class="fa fa-minus-circle" style="padding-right:5px;"></i><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_service_row()">Add <i  class="fa fa-plus-circle"></i></div>');
              plus_minus_btn = plus_minus_btn[0].outerHTML;


                if($('.service_fee_div').length==1){

                   $('.service_fee_div:nth-child(1) > div:last-child').remove(); }

                var inhtml = $('#service_fee').html();

                $('.service_fee_div:last').after('<div class="col-sm-12 service_fee_div pl-0 pr-0">'+inhtml+'</div>');

                $('.service_fee_div:last > input[type="hidden"]').remove();
                if($('.service_fee_div').length==add_srv){

                   $('.service_fee_div:nth-child('+(add_srv-1)+') > div:last-child').html(minus_btn);
                   minus_btn_a = minus_btn.replace((add_srv-1), add_srv);
                   $('.service_fee_div:nth-child('+(add_srv)+')').append(minus_btn_a);

                }

                if(($('.service_fee_div').length < add_srv ) && ($('.service_fee_div').length >= 2))
                {
                    var childr = ($('.service_fee_div').length - 1);
                    if($('.service_fee_div').length>2)
                    {
                        $('.service_fee_div:nth-child('+childr+') > div:last-child').remove();
                        $('.service_fee_div:nth-child('+childr+')').append(minus_btn);
                    }
                    $('.service_fee_div:nth-child('+$('.service_fee_div').length+')').append(plus_minus_btn);


                }

                 $('input[fname="start_date"]').datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy',
                defaultDate: new Date()

                })
              .on('changeDate', function(){
                // set the "toDate" start to not be later than "fromDate" ends:
                // $('#datepicker_to').val("").datepicker("update");
                $('input[fname="end_date"]').datepicker('setStartDate', new Date($(this).val()));
                });
      $('input[fname="end_date"]').datepicker({
              autoclose: true,
              format: 'mm/dd/yyyy',
              })
             .on('changeDate', function(){
              // set the "fromDate" end to not be later than "toDate" starts:
              // $('#datepicker_from').val("").datepicker("update");
              $('input[fname="start_date"]').datepicker('setEndDate', new Date($(this).val()));
              });

               $('input[fname="fee"]').mask('$99.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}});
               $('input[fname="base_fee"]').mask('$99.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}});
               $('input[fname="profit_share"]').mask('00%');
            }
            // $('input[fname="start_date"],input[fname="end_date"]').datepicker({
            //     autoclose: true,
            //     format: 'mm/dd/yyyy',
            //      orientation: "bottom",
            // });
            set_service_index();

       }
       function set_service_index()
       {
          var count = 2;

            $('.service_fee_div').each(function(index, value){
                        $(value).find('input, select').each(function(ind, val){
                            $(val).attr('name', 'service['+index+']['+$(val).attr('fname')+']');
                        });
               if($(value).find('i.fa-minus-circle').length>0)
               {
                   $(value).find('i.fa-minus-circle').attr('onclick', 'del_row_srvc('+count+')' );
                   count++;
                }
            });
       }
       function del_row_srvc(id)
        {
            var del_allow = allow_srvc;
            $('.service_fee_div:nth-child('+id+')').remove();
               total_field = $('.service_fee_div').length;
            if(total_field != 1)
            {
                var  add_btn_html = $('.service_fee_div:last > div:last-child').clone();
                var plus_minus_btn = '<i onclick="del_row_srvc('+(total_field)+')" class="fa fa-minus-circle" style="padding-right:5px;"></i><div  class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_service_row()">Add <i  class="fa fa-plus-circle"></i></div>';
                $('.service_fee_div:last > div:last-child').html(plus_minus_btn);
            }else
            {


                $('.service_fee_div').append('<div class="flx-justify-start mb-14_"><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_service_row()">Add <i  class="fa fa-plus-circle"></i></div></div>');
            }

            set_service_index();

        }
    function numericOnly(event){ // restrict e,+,-,E characters in  input type number
    //     if(event.target.value.length==15) return false;
    //     console.log(event);
    //     const charCode = (event.which) ? event.which : event.keyCode;
    // if (charCode == 101 || charCode == 69 || charCode == 45 || charCode == 43) {
    //   return false;
    // }
    // return true;
    if(event.target.value.length == 15) return false;
  var charCode = event.which  ? event.which : event.keyCode;
  var charStr = String.fromCharCode(charCode);
  if (!charStr.match(/^[0-9]+$/))
    event.preventDefault();

  }

  $(document).ready(function(){
      var requestCount=0;
      var stringCount=0;
      var stringLength = 0;

    $('#practice_name').blur(function(){
    	if($(this).val()!=""){

      	var str = $(this).val().trim().replace(/i|_|-| /g, "");
          // str = str.replace(/Ø/g,'0');
          console.log(str);
          stringLength = str.length;
          if(stringLength < 3){
              toastr.error('Message', 'Please enter more than three practice name characters.');

              return;
          }
      	// var random = makeid(3,str);
      	// console.log('blur prac',str);

      	// console.log('blur prac',random);
          $('#codeError').hide();
         var loop = Math.floor( stringLength/3);
         console.log('_____________');
         console.log(loop);
      	if(requestCount != loop )
     	{
            start = requestCount * 3;
            end =  3;
            console.log(start,end);
            var random = str.substr(start,end);
            console.log('blur prac',random);
			$.ajax({
			    url: "{{route('check-practice-code')}}",
			    method:'post',
			    data:{'practice_code':random,id:$('input[name="id"]').val()},
			    success:function(data){
                    // random = random.replace(/0/g,'Ø');
					if(!data){
					    $('#practice_code').addClass('error');
                        requestCount++;
                        $('#practice_code').val('');
					    $('#practice_code').val(random.toUpperCase());
					    $('#practice_name').blur();
					}else{
						requestCount=0;
						$('#practice_code').removeClass('error');
					    $('#practice_code').val(random.toUpperCase());
					    $('#practice_code').prop("readonly",true);
					}
			    }
			});
		}else{
			$('#practice_code').prop("readonly",false);

			requestCount=0;
			$('#codeError').text('Code already exists. Please change');
			$('#codeError').show();
		}
		}
 	});
 	$('#practice_code').blur(function(){
      	var code =$(this).val();
      	if(code!=""){
      	$('#codeError').hide();
		$.ajax({
		    url: "{{route('check-practice-code')}}",
		    method:'post',
		    data:{'practice_code':code,id:$('input[name="id"]').val()},
		    success:function(data){
				if(!data){
				    $('#practice_code').addClass('error');
				    $('#codeError').text('Code already exists. Please change');
				    $('#codeError').show();

				}else{

				    $('#practice_code').val(code.toUpperCase());
				}
		    }
		});
	}
 	});

  // $('input[fname="start_date"],input[fname="end_date"]').datepicker({
  //               autoclose: true,
  //               format: 'mm/dd/yyyy',
  //                orientation: "bottom",
  //           });

     $('input[fname="start_date"]').datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy'

                })
              .on('changeDate', function(){
                // set the "toDate" start to not be later than "fromDate" ends:
                // $('#datepicker_to').val("").datepicker("update");
                $('input[fname="end_date"]').datepicker('setStartDate', new Date($(this).val()));
                });
      $('input[fname="end_date"]').datepicker({
              autoclose: true,
              format: 'mm/dd/yyyy',
              })
             .on('changeDate', function(){
              // set the "fromDate" end to not be later than "toDate" starts:
              // $('#datepicker_from').val("").datepicker("update");
              $('input[fname="start_date"]').datepicker('setEndDate', new Date($(this).val()));
              });

             $('input[fname="fee"]').mask('$99.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}});
//              var tags=[
//     "25",
//     "30",
//     "45",
//     "765"
// ];
//     $(".basicAutoComplete").autoComplete(('set', { value: 20, text: "20" }));


 });
 // $(function() {
    // var availableTags = [
    //   "ActionScript",
    //   "AppleScript",
    //   "Asp",
    //   "BASIC",
    //   "C",
    //   "C++",
    //   "Clojure",
    //   "COBOL",
    //   "ColdFusion",
    //   "Erlang",
    //   "Fortran",
    //   "Groovy",
    //   "Haskell",
    //   "Java",
    //   "JavaScript",
    //   "Lisp",
    //   "Perl",
    //   "PHP",
    //   "Python",
    //   "Ruby",
    //   "Scala",
    //   "Scheme"
    // ];
    // $( "#yyy" ).autocomplete({
    //   source: availableTags,
    //   autoFocus:true
    // });
    // $( "#yyy" ).autocomplete( "option", "appendTo", ".eventInsForm" );
  // });
  function makeid(length,value) {
   var result           = '';
   var characters       = value;
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   console.log(result);
   return result;
}
function acknowledge(pid,type)
{
  $.ajax({
    method: 'GET',
    url: '{{url("practice/acknowledge")}}/'+pid+'/'+type,
    success:function(response)
    {
      if(response.status)
      {
        $('tr[data-prid='+pid+']').remove();
        console.log(response);

        // var str='';
        // $.each(response.data,function(key,val){
        //   str+='<tr data-prid='+val.id+'><td><a class="txt-blue_sh-force td_u_force p-name" href="javascript:void(0)" onclick="open_edit_practice('+val.id+')">'+val.practice_name+'</a><i class="fa fa-check elm-right cur-pointer" aria-hidden="true" onclick="acknowledge('+val.id+',\''+val.practice_type+'\')"></i></td><td class="p-zip"> '+val.practice_zip+'</td><td class="p-state">'+val.practice_state+'</td><td class="site-cnt">'+val.users[0].name+'</td><td>{{auth()->user()->name}}</td></tr>';
        // })
        if(type=="Pharmacy")
        {
          $('#pharmacy-count').html(response.count);
        }else if(type=="Physician")
        {
          $('#physician-count').html(response.count);
        }else if(type=="Law"){
          $('#law-practice-count').html(response.count);
        }



      }

    },
    error:function(error)
    {

    }
  })
}
function show_practies_modal(p_type){
        $('#practice-show-modal').modal('show');
        if(p_type=="pharmacy")
        {
            $('.modal_phy_count').hide();
            $('.modal_law_count').hide();
            $('.modal_phr_count').show();
            $('#modal-label').text('new '+p_type);
        }
        else if(p_type=="physician")
        {
            $('.modal_phr_count').hide();
            $('.modal_law_count').hide();
            $('.modal_phy_count').show();
            $('#modal-label').text('new '+p_type);
        }
        else if(p_type=='law_practice')
        {
            $('.modal_phr_count').hide();
            $('.modal_phy_count').hide();
            $('.modal_law_count').show();
            $('#modal-label').text('new law practice');
        }

        if(p_type=='physician' || p_type=='law_practice')
        {
          $('#modal-prc-type').text('Practice Name');
        }else{
          $('#modal-prc-type').text('Pharmacy Name');
        }

          $('#modal-pharmacies').dataTable( {
           "ajax": {
            "url": "{{url('get-pharmacies')}}",
            "data":{'type':p_type},
            "dataSrc": function ( json ) {
              for ( var i=0; i<json.data.length ;  i++ ) {
                // json.data[i]=json.data[i];
                if(json.data[i].created_by)
                {
                  json.data[i].cr_rep=json.data[i].created_by.name;
                }else{
                  json.data[i].cr_rep='';
                }
                
                if(json.data[i].users)
                {
                  // console.log(json.data[i].users.length>0);
                  if(json.data[i].users.length>0)
                  {
                    json.data[i].users=json.data[i].users[0].name;
                  }else{
                    json.data[i].users='';
                  }

                }
              }
              return json.data;
            }
          },
          aoColumns: [
                        { mData: 'practice_name',render: function (dataField,type, row) { return '<a class="td_u_force txt-blue_sh-force" href="javascript:void(0)" onclick="open_edit_practice('+row.id+')">'+dataField+'</a>'; } },
                        { mData: 'practice_zip' },
                        { mData: 'practice_state' },
                        {mData: 'users'},
                        {mData:'cr_rep'}
                ],

              lengthChange: false,
              pageLength : 10,
              order:[],
              bFilter: false,
              "bDestroy": true

        });
      }

function add_edit_branch(id,action){
  console.log(id +'=====>'+action);
  $('#practice-Add-Modal').modal('show');
}

/** ENterprise listing */
/* Group user */
// $("#group-reg-step").steps({

// headerTag: "h4",
// bodyTag: "section",
// transitionEffect: "slideLeft",
// enableAllSteps: true,
// autoFocus: true,

// onFinished: function (event, currentIndex) {
// $('#enterprise-reg-form').submit();
// }
// });
// var allow_grp_user=3;
// function del_row_group(id)
//     {
//         var del_allow = allow_grp_user;
//         $('.primary_site_group:nth-child('+id+')').remove();
//            total_field = $('.primary_site_group').length;
//         if(total_field != 1)
//         {
//             var  add_btn_html = $('.primary_site_group:last > div:last-child').clone();
//             var plus_minus_btn = '<i onclick="del_row_group('+(total_field)+')" class="fa fa-minus-circle" style="padding-right:5px;"></i><div  class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row_group()">Add <i  class="fa fa-plus-circle"></i></div>';
//             $('.primary_site_group:last > div:last-child').html(plus_minus_btn);
//         }else
//         {


//             $('.primary_site_group').append('<div class="flx-justify-start mb-14_" ><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row_group()">Add <i  class="fa fa-plus-circle"></i></div></div>');
//         }

//         set_index_group();

//     }
// function add_row_group()
//     {
//         var error;
//         var add_allow = allow_grp_user;
//         toastr.remove();
//         $('.primary_site_group').find('input:visible, select').each(function(abkey, abval){

//             if($(abval).val()==''){
//                 $(abval).addClass('error');
//                 //toastr.error('Message', 'Please enter the '+$(abval).attr('fname')+'.');
//                 error = 'no';
//             }else{ $(abval).removeClass('error'); }

//             });
//             if(error=='no'){ return false; }

//             if($('.primary_site_group').length < add_allow)
//             {
//               var  del_btn_html = $('.primary_site_group:last > div:last-child').clone();
//               console.log($('.primary_site_group:last > div:last-child'))

//               var minus_btn = $(del_btn_html).html('<i onclick="del_row_group('+$('.primary_site_group').length+')" class="fa fa-minus-circle"></i>');
//               minus_btn = minus_btn[0].outerHTML;
//               var plus_minus_btn = $(del_btn_html).html('<i onclick="del_row_group('+($('.primary_site_group').length+1)+')" class="fa fa-minus-circle" style="padding-right:5px;"></i><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row_group()">Add <i  class="fa fa-plus-circle"></i></div>');
//               plus_minus_btn = plus_minus_btn[0].outerHTML;


//                 if($('.primary_site_group').length==1){

//                    $('.primary_site_group:nth-child(1) > div:last-child').remove(); }

//                 var inhtml = $('#primary_group').html();

//                 $('.primary_site_group:last').after('<div class="col-sm-12 primary_site_group pl-0 pr-0">'+inhtml+'</div>');

//                 $('.primary_site_group:last > input[type="hidden"]').remove();
//                 if($('.primary_site_group').length==add_allow){

//                    $('.primary_site_group:nth-child('+(add_allow-1)+') > div:last-child').html(minus_btn);
//                    minus_btn_a = minus_btn.replace((add_allow-1), add_allow);
//                    $('.primary_site_group:nth-child('+(add_allow)+')').append(minus_btn_a);

//                 }

//                 if(($('.primary_site_group').length < add_allow ) && ($('.primary_site_group').length >= 2))
//                 {
//                     var childr = ($('.primary_site_group').length - 1);
//                     if($('.primary_site_group').length>2)
//                     {
//                         $('.primary_site_group:nth-child('+childr+') > div:last-child').remove();
//                         $('.primary_site_group:nth-child('+childr+')').append(minus_btn);
//                     }
//                     $('.primary_site_group:nth-child('+$('.primary_site_group').length+')').append(plus_minus_btn);

               
//                 }
                    
//             }

//             set_index_group();

//         }

//     function set_index_group(){
//             var count = 2;

//             $('.primary_site_group').each(function(index, value){
//                         $(value).find('input, select').each(function(ind, val){
//                             $(val).attr('name', 'users['+index+']['+$(val).attr('fname')+']');
//                         });
//                if($(value).find('i.fa-minus-circle').length>0)
//                {
//                    $(value).find('i.fa-minus-circle').attr('onclick', 'del_row_group('+count+')' );
//                    count++;
//                 }
//             });
//        }
/* End Group user */
function show_groups_modal_listing(){
  
        $('#modal-enterprise-management-listing').modal('show');
    

          $('#enterprise-listing-table').dataTable( {
           "ajax": {
            "url": "{{url('get-all-groups')}}",
            "dataSrc": function ( json ) {
              
              return json.data;
            }
          },
          createdRow: function( row, data, dataIndex ) {
        // Set the data-status attribute, and add a class
          console.log("creatrow",row);
          console.log("data",data);
          $(row).attr("grp-id",data.id);
          $(row).children(':nth-child(2)').addClass('own-fname');
          $(row).children(':nth-child(3)').addClass('own-lname');
          $(row).children(':nth-child(4)').addClass('own-adres');
          $(row).children(':nth-child(5)').addClass('own-zip');
          $(row).children(':nth-child(6)').addClass('own-email');
          $(row).children(':nth-child(7)').addClass('own-phn');
          },
          aoColumns: [
                        { mData: 'group_name',render: function (dataField,type, row) { return '<a class="td_u_force txt-blue_sh-force own-gname" href="javascript:void(0)" onclick="open_edit_group('+row.id+')">'+dataField+'</a>'; } },
                        { mData: 'owner_first_name' },
                        { mData: 'owner_last_name' },
                        {mData: 'owner_address'},
                          { mData: 'zip' },
                        { mData: 'email' },
                        {mData: 'owner_phone_number'}
                ],

              lengthChange: false,
              pageLength : 10,
              order:[],
              bFilter: false,
              "bDestroy": true

        });
      }




    function add_update_group()
   {

  



       var pdata=$( "form[name='enterprise_form']" ).serializeArray();
       console.log(pdata);
      
       // $( "form[name='practice_form']" ).serialize()
       $('.loader').show();
        $.ajax({
           type:'POST',
           url:"{{url('/group/add-update')}}",
           data:pdata,
           success:function(data) {
            if(data.status)
            {
              toastr.success(data.message);
              $( "#enterprise-reg-form" )[0].reset();
              /* Group user */
              
              // $( "#group-reg-step" ).steps('reset');
              /* end Group user */
              $('#modal-enterprise-management-add-new').modal('hide');
              if(data.type=="add" && data.group)
              {
                var grp='<tr grp-id="'+data.group.id+'"><td><a class="td_u_force txt-blue_sh-force own-gname" onclick="open_edit_group('+data.group.id+')">'+data.group.group_name+'</a></td><td>'+data.group.owner_first_name+'</td><td>'+data.group.owner_last_name+'</td><td>'+data.group.owner_address+'</td><td>'+data.group.zip+'</td><td>'+data.group.email+'</td><td>'+data.group.owner_phone_number+'</td></tr>';

                      

                      $('#enterprise-listing-table').DataTable().row.add($(grp)).draw();
              }
              if(data.type=="update" && data.group)
              {
                  $('[grp-id="'+data.group.id+'"] .own-gname').text(data.group.group_name);
                  $('[grp-id="'+data.group.id+'"] .own-fname').text(data.group.owner_first_name);
                  $('[grp-id="'+data.group.id+'"] .own-lname').text(data.group.owner_last_name);
                  $('[grp-id="'+data.group.id+'"] .own-adres').text(data.group.owner_address);
                  $('[grp-id="'+data.group.id+'"] .own-zip').text(data.group.zip);
                  $('[grp-id="'+data.group.id+'"] .own-email').text(data.group.email);
                  $('[grp-id="'+data.group.id+'"] .own-phn').text(data.group.owner_phone_number);
              }
              

            }
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });
   }



function open_edit_group($id){
  
$('#modal-enterprise-management-add-new').modal('show');
edit_group($id);
}


function edit_group(id)
   {
    // $("#practice-reg-step").find('a[href="#finish"]').attr("href", '#finish-disabled');

        $("#cancel_practice").trigger("click");
       $('.hupdate_ent').text('Edit Group');
       $('#append_field > tr').removeClass('selected_row');
       $('#tr_'+id).addClass('selected_row');
       $('form[name="enterprise_form"]').append('<input name="id" type="hidden" value="'+id+'" />');
       $('#submit_group').text('UPDATE');
      $('.loader').show();
       $.ajax({
           type:'GET',
           url:"{{url('/get-group-detail/')}}/"+id,
           success:function(data) {
               toastr.clear();
                $('.loader').hide();
                console.log(data);
                $.each(data.group, function( key, val ) {
                  // if(key=="practice_code" && val)
                  // {
                     // $('input[name="'+key+'"]').val(val.replace(/0/g,'Ø'));
                  // }else{
                      $('input[name="'+key+'"]').val(val);
                      // $('select[name="'+key+'"] > option[value="'+val+'"]').prop('selected', true);

                  // }
                });
                /*Group user*/
//                 $.each(data.users,function(keyu,valu){
//                   if(keyu>0){ add_row_group(); }
// console.log(keyu);
// console.log(valu);
//                    if($('.primary_site_group:nth-child('+(keyu+1)+') > input[type="hidden"]').length){

//                         $('.primary_site_group:nth-child('+(keyu+1)+') > input[type="hidden"]').remove();
//                    }

//                    $('.primary_site_group:nth-child('+(keyu+1)+')').prepend('<input fname="id" name="users['+keyu+'][id]" type="hidden" value="" />');
//                   $.each(valu,function(in_key,in_val){
//                     if(in_key=="roles")
//                     {
//                       in_val=in_val[0].id;
//                     }
//                     $('.primary_site_group:nth-child('+(keyu+1)+')').find('input[name="users['+(keyu)+']['+in_key+']"]').val(in_val);
//                     $('.primary_site_group:nth-child('+(keyu+1)+')').find('select[name="users['+(keyu)+']['+in_key+']"] > option[value="'+in_val+'"]').prop('selected',true);
//                   })
//                 })
/*end Group user*/

              
                

                        
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
       });

   }
   $('#modal-enterprise-management-add-new').on('hidden.bs.modal', function () {
    $('#enterprise-reg-form')[0].reset();
     /* Group user */
    // $("#group-reg-step-t-0").get(0).click();
     /* end Group user */
    if($('#enterprise-reg-form > input[type="hidden"]').length>0)
    {
      $('#enterprise-reg-form > input[type="hidden"]').remove();
    }
    /* Group user */
    // if($('.primary_site_group').length!=1)
    //  {
    //     $('.primary_site_group').not('#primary_group').remove();
    //     $('.primary_site_group').append('<div class="row" ><div class="col-sm-12 c-dib_ cnt-left"><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row_group()">Add <i  class="fa fa-plus-circle"></i></div></div></div>');
    //  }
    //  if($('.primary_site_group').length>0)
    //  {

    //   $('.primary_site_group > input[type="hidden"]').remove();
    //  }
     /* end Group user */
    $('#modal-enterprise-management-listing').modal('show');
   });
   $('#modal-enterprise-management-add-new').on('shown.bs.modal', function () {
    $('.hupdate_ent').text('Add New Group');
    $('#modal-enterprise-management-listing').modal('hide');
   });





function orderSheetCategoryDrugs(CategoryId, CategoryName)
{
    OSDrugsList = [];
    $('#orderSheetCategoryId').val(CategoryId);

    $.ajax({
                type:'GET',
                url: "{{ url('get-sheetcategory-drugs') }}/"+CategoryId,
                success:function(data) {
                    if(data != ""){
                        var table = $('#order_sheet_drug_table').DataTable({
                            destroy: true,
                            searching: false,
                            rowReorder: {selector: 'td:nth-child(1)'},
                            "pagingType": "full_numbers",
                            "iTotalRecords": data.data.length,
                            "iTotalDisplayRecords": 5,
                            "sEcho":5,
                            "aaData" : data.data,
                            "aoColumnDefs":[
                                 { orderable: false, targets: [ 1,2,3 ] },
                                {
                                    'targets':0,
                                    'className':'drug-title reorder',
                                    'render': function (data, type, row){
                                        return data;
                                    }
                                },
                                {
                                    'targets': 7,
                                    'searchable': false,
                                    'orderable':false,
                                    'className': 'dt-body-center no-sort',
                                    'render': function (data, type, row){
                                       return `<div class="wd-100p" style="display: flex; justify-content: space-around;"><a onclick="createEditSheetDrug(`+CategoryId+`,`+data+`,'`+row+`');" class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-grn-shn-7j"></span></a><a onclick="deleteSheetDrug(`+data+`,'`+CategoryName+`')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a></div>`;
                                    }
                                }]
                        });                            
                                                
                        table.on( 'row-reorder', function ( e, diff, edit ) {  
                            var drugSeq = [];
                            var orderSeq = [];
                            table.order( [ 1, 'asc' ] ).draw();
                            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {                                
                                //var rowData = table.row( diff[i].node ).data();
                                drugSeq.push(diff[i].newData);                                
                                orderSeq.push(diff[i].oldPosition);                                
                            }
                            
                            if(drugSeq != ""){
                                $.ajax({
                                    url: "{{url('update-drug-position')}}",
                                    method:'post',
                                    data: 'cat_id='+CategoryId+'&drug_ids='+drugSeq+'&sequences='+orderSeq,
                                    success:function(data){
                                        toastr.success("Drug position updated successfully."); 
                                    }
                                });
                            }
                            console.log(edit);
                            console.log(diff);
                            console.log('Drugs Seq:<br>'+ drugSeq);
                            console.log('Order Seq:<br>'+ orderSeq);
                        });
                        
                    }                         
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
             });    
    $('#category_title_id').html(CategoryName+" >> Drugs");         
    $('#order_sheet_drug_listing').modal('show');
    
    setTimeout(function(){ 
                var elts = document.getElementsByClassName('drug-title');
                for (var i = 0; i < elts.length; ++i){ 
                    OSDrugsList.push(elts[i].innerHTML.toLowerCase());
                }
                console.log("Drugs:"+OSDrugsList); 
            }, 1000);
}

function orderSheetCategories(sheetId)
{
    OSCategoriesList = []; 
    $('#orderSheetId').val(sheetId);
    $.ajax({
                type:'GET',
                url: "{{ url('get-sheetcategories') }}/"+sheetId,
                success:function(data) {
                    if(data != ""){
                        var table = $('#order_sheet_category_table').DataTable({
                            destroy: true,
                            searching: false,
                            "pagingType": "full_numbers",
                            "iTotalRecords": data.data.length,
                            "iTotalDisplayRecords": 5,
                            "sEcho":5,
                            "aaData" : data.data,
                            "aoColumnDefs":[{
                                    'targets':0,
                                    'className':'cat-title',
                                    'render': function (data, type, row){
                                        return data;
                                    }
                                },{
                                    'targets':2,
                                    'searchable': false,
                                    'orderable': false,
                                    'className': 'dt-body-center',
                                    'render': function (data, type, row){
                                        //return '<input type="checkbox" name="patientId[]" class="checkbox" value="'+data+'">';
                                        return `<div class="wd-100p" style="display: flex; justify-content: space-around;"><a onclick="orderSheetCategoryDrugs(`+data+`,'`+row[0]+`');" class="mr-3_ hover-black-child_"><span class="" style="transform: rotate(45deg);display: inline-block;"><svg><use xlink:href="#drug_main"></use></svg></span></a><a onclick="createEditDrugCategory(`+sheetId+`,`+data+`,'`+row[0]+`','`+row[1]+`'`+`);" class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-grn-shn-7j"></span></a><a onclick="deleteSheetCategory(`+data+`)" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a></div>`;
                                    }
                                }],
                                select: {
                                    style: 'os',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ]
                        });    
                        
                    }                         
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
             });    
             
            $('#order_sheet_cat_listing').modal('show');
            
            setTimeout(function(){ 
                var elts = document.getElementsByClassName('cat-title');
                for (var i = 0; i < elts.length; ++i){ 
                    OSCategoriesList.push(elts[i].innerHTML.toLowerCase());
                }
                console.log("categories:"+OSCategoriesList); 
            }, 1000);
}

function addUpdateOrderSheet()
{    
    $('#ordersheet_add_btn').prop("disabled", true);
    if($('#sheet_title').val().trim() != "")
    {
        if(OrderSheetsList.indexOf($('#sheet_title').val().toLowerCase().trim()) > -1){
            toastr.error("Order sheet title already exists."); 
            return;
        }
        
        var rowCount = 0;
        $('.loader').show();
        $('#error_sheet_title').hide();
        
        $.ajax({
            url: "{{url('add-ordersheet')}}",
            method:'post',
            data: 'practice_id='+$('#practiceId').val()+'&sheet_id='+$('#sheetId').val()+'&title='+$('#sheet_title').val()+'&details='+$('#sheet_details').val(),
            success:function(data){
                var ordersheetTable = '';
                $.each(data.order_sheet, function( index, obj){
                        rowCount = parseInt(rowCount)+parseInt(1);
                        ordersheetTable += '<tr><td class="txt-black-24 tt_uc_ weight_500">'+obj.title+'</td>';
                        ordersheetTable += '<td class="txt-black-24 tt_uc_ weight_500">'+(obj.details==null?"":obj.details)+'</td>';
                        ordersheetTable += '<td class="txt-black-24 tt_cc_ weight_500"><div class="wd-100p" style="display: flex; justify-content: space-around;">';
                        ordersheetTable += '<a href="#action-qrcode" class="mr-3_ hover-black-child_" onclick="orderSheetCategories('+obj.id+')"><span class="fa fa-qrcode fs-17_ txt-gray-6"></span></a>';
                        ordersheetTable += `<a href="#action-view" class="mr-3_ hover-black-child_"><span class="fa fa-eye fs-17_ txt-gray-6" onclick="orderSheetView(`+obj.id+`,'`+obj.title+`')"></span></a>`;
                        ordersheetTable += `<a  class="mr-3_ hover-black-child_" onclick="createEditOrderSheet(`+$('#practiceId').val()+`,`+obj.id+`,'`+obj.title+`','`+obj.details+`')"><span class="fa fa-pencil fs-17_ txt-grn-shn-7j"></span></a><a onclick="deleteOrderSheet(`+obj.id+`)" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a></div></td></tr>`;  
                });                
                
                $('#ordersheet_table').html(ordersheetTable);
                $('.loader').hide();
                
                if($('#sheetId').val() > 0)
                    toastr.success("Record updated successfully.");   
                else
                    toastr.success("Record added successfully.");   
                
                if(rowCount>3)
                    $('#add_order_sheet_btn').prop('disabled', true);
            }
        });
        $('#add_order_sheet').modal('hide');
    }else{
        $('#error_sheet_title').show();
        $('#sheet_title').css("border", "1px solid red");
    }
}

$('#category_title').change(function(){
    $('#sheetcategory_add_btn').prop("disabled", false);
});

function addUpdateDrugCategory()
{
    $('#sheetcategory_add_btn').prop("disabled", true);
    if($('#category_title').val().trim() != "")
    {
        if(OSCategoriesList.indexOf($('#category_title').val().toLowerCase().trim()) > -1 && $('#categoryId').val() == 0){
            toastr.error("Category title already exists."); 
            return;
        }
        
        var rowCount = 0;
        $.ajax({
            url: "{{url('add-drugcategory')}}",
            method:'post',
            data: 'sheet_id='+$('#categorySheetId').val()+'&category_id='+$('#categoryId').val()+'&title='+$('#category_title').val()+'&details='+$('#category_details').val(),
            success:function(data){
                orderSheetCategories($('#categorySheetId').val());
                if($('#categoryId').val() >0)
                    toastr.success("Record updated successfully."); 
                else
                    toastr.success("Record added successfully."); 
            }
        });
        $('#order_sheet_add_drug_cat').modal('hide');
    }else{
        $('#error_category_title').show();
        $('#category_title').css("border", "1px solid red");
    }
}

function addUpdateOrderSheetDrug()
{    
    if($('#drug_name').val().trim() != "")
    {
        if(OSDrugsList.indexOf($('#drug_name').val().toLowerCase().trim()) > -1 && $('#sheetDrugId').val() == 0){
            toastr.error("Drug title already exists."); 
            return;
        }
        
        var rowCount = 0;
        $.ajax({
            url: "{{url('add-ordersheet-drug')}}",
            method:'post',
            data: 'category_id='+$('#sheetCategoryId').val()+'&drug_id='+$('#sheetDrugId').val()+'&drug_name='+$('#drug_name').val()+'&dosage_type='+$('#dosage_type').val()+'&strength='+$('#os_strength').val()+'&quantity='+$('#quantity').val()+'&upc_number='+$('#upc_number').val()+'&ndc_number='+$('#ndc_number').val()+'&gcn_number='+$('#gcn_number').val()+'&alt_ndc_number='+$('#alt_ndc_number').val()+'&instructions='+$('#instructions').val(),
            success:function(data){
                orderSheetCategoryDrugs($('#sheetCategoryId').val(),"Drug Category");
                
                if($('#sheetDrugId').val() >0)
                    toastr.success("Record updated successfully."); 
                else
                    toastr.success("Record added successfully."); 
            }
        });
        $('#add_sheet_drug_modal').modal('hide');
    }else{
        $('#error_drug_name').show();
        $('#drug_name').css("border", "1px solid red");
    }
}

function deleteSheetCategory(id)
{
    toastr.options.fadeOut = 500000;
            toastr.error("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Are you sure you want to delete this order sheet category?',
            {
                closeButton: false,
                timeOut: 500000,
                allowHtml: true,
                onShown: function (toast) {
                    $("#confirmationYes").click(function(){
                      toastr.clear();
                        var rowCount = 0;
                        $.ajax({
                                url: "{{url('delete-sheetcategory')}}/"+id,
                                method:'get',
                                success:function(data){
                                    orderSheetCategories($('#categorySheetId').val());
                                    toastr.success("Record deleted successfully."); 
                                }
                            });
                    });
                    $("#confirmationNo").click(function(){
                      toastr.clear();
                    });
                  }
            });
}

function deleteSheetDrug(drugId, CategoryName)
{
    toastr.options.fadeOut = 500000;
            toastr.error("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Are you sure you want to delete this order sheet drug?',
            {
                closeButton: false,
                timeOut: 500000,
                allowHtml: true,
                onShown: function (toast) {
                    $("#confirmationYes").click(function(){
                      toastr.clear();
                        var rowCount = 0;
                        $.ajax({
                                url: "{{url('delete-sheetdrug')}}/"+drugId,
                                method:'get',
                                success:function(data){
                                    orderSheetCategoryDrugs($('#orderSheetCategoryId').val(), CategoryName);
                                    toastr.success("Record deleted successfully."); 
                                }
                            });
                    });
                    $("#confirmationNo").click(function(){
                      toastr.clear();
                    });
                  }
            });    
}

function deleteOrderSheet(id)
{
    toastr.options.fadeOut = 500000;
    toastr.error("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Are you sure you want to delete this order sheet?',
    {
        closeButton: false,
        timeOut: 500000,
        allowHtml: true,
        onShown: function (toast) {
            $("#confirmationYes").click(function(){
              toastr.clear();
              var rowCount = 0;
                $.ajax({
                        url: "{{url('delete-ordersheet')}}/"+id,
                        method:'get',
                        success:function(data){
                            var ordersheetTable = '';
                            $.each(data.order_sheet, function( index, obj){
                                    rowCount = parseInt(rowCount)+parseInt(1);
                                    ordersheetTable += '<tr><td class="txt-black-24 tt_uc_ weight_500">'+obj.title+'</td>';
                                    ordersheetTable += '<td class="txt-black-24 tt_uc_ weight_500">'+(obj.details == null?"":obj.details)+'</td>';
                                    ordersheetTable += '<td class="txt-black-24 tt_cc_ weight_500"><div class="wd-100p" style="display: flex; justify-content: space-around;">';
                                    ordersheetTable += '<a href="#action-qrcode" class="mr-3_ hover-black-child_" onclick="orderSheetCategories('+obj.id+')"><span class="fa fa-qrcode fs-17_ txt-gray-6"></span></a>';
                                    ordersheetTable += `<a href="#action-view" class="mr-3_ hover-black-child_"><span class="fa fa-eye fs-17_ txt-gray-6" onclick="orderSheetView(`+obj.id+`,'`+obj.title+`')"></span></a>`;
                                    ordersheetTable += `<a  class="mr-3_ hover-black-child_" onclick="createEditOrderSheet(`+$('#practiceId').val()+`,`+obj.id+`,'`+obj.title+`','`+obj.details+`')"><span class="fa fa-pencil fs-17_ txt-grn-shn-7j"></span></a><a onclick="deleteOrderSheet(`+obj.id+`)" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a></div></td></tr>`;  
                            });                

                            $('#ordersheet_table').html(ordersheetTable);
                            toastr.success("Record deleted successfully.");

                            if(rowCount<4)
                                $('#add_order_sheet_btn').prop('disabled', false);
                        }
                    });
            });
            $("#confirmationNo").click(function(){
              toastr.clear();
            });
          }
    });
}

function orderSheetView(id, title)
{
    $('#drug_table_1').html("");
    $('#drug_table_2').html("");
    
    $('#ordersheet_title_id').html(title);
    $.ajax({
        url: "{{url('view-ordersheet')}}/"+id,
        method:'get',
        success:function(data){
            $('#drug_table_1').html(data.first_table);
            $('#drug_table_2').html(data.second_table);
        }
    });
    
    $('#order_sheet_view').modal('show');
}

function createEditSheetDrug(categoryId, drugId, Elements)
{    
    var List = Elements.split(',');
    console.log(List);

    //$('#ndc').removeClass('order-error');
    $('#ndc-error').hide();
    $('#duplicate_ndc').hide();
    $('#generic_name-error').hide();
    $('#sheetdrug_add_btn').prop("disabled", false);
    $('#sheetCategoryId').val(categoryId);
    $('#sheetDrugId').val(List[List.length -1]);
    $('#cat_drug_id').val(drugId);
    
    if(drugId){
      edit_drugs(List[List.length -1]);
      $('#sheetdrug_add_btn').text('Update');
    }else{
        $('#sheetdrug_add_btn').text('Add');  
    }

    $('#rx_label_name-error').hide();
    $('#os_strength-error').hide();
    $('#rx_label_name').css({'color':"#666"});
    $('#ndc').css({'color':"#666"});
    $('#generic_name').css({'color':"#666"});
    $('#os_strength').css({'color':"#666"});
    $('#add_sheet_drug_modal').modal('show');
}

function createEditDrugCategory(sheetId,categoryId,title,details)
{    
    $('#error_category_title').hide();
    $('#sheetcategory_add_btn').prop("disabled", false);
    $('#category_title').css("border", "1px solid lightskyblue");
    
    if(categoryId > 0)
        $('#sheetcategory_add_btn').html("Update");
    else
        $('#sheetcategory_add_btn').html("Add");
    
    $('#categorySheetId').val(sheetId);    
    $('#categoryId').val(categoryId);    
    $('#category_title').val(title);
    $('#category_details').val((details=="null"?"":details));
    $('#order_sheet_add_drug_cat').modal('show');
}

$('#sheet_title').change(function(){
    $('#ordersheet_add_btn').prop("disabled", false);
});

$('#rx_label_name,#ndc').change(function(){
   $('#sheetdrug_add_btn').prop("disabled", false); 
   $('#duplicate_ndc').hide();
});

function createEditOrderSheet(pharmacyId,sheetId,title,details)
{        
    $('#ordersheet_add_btn').prop("disabled", false);
    $('#error_sheet_title').hide();
    $('#sheet_title').css("border", "1px solid lightskyblue");
        
    if(sheetId > 0)
        $('#ordersheet_add_btn').html("Update");
    else
        $('#ordersheet_add_btn').html("Add");
    
    if(pharmacyId != null)
        $('#practiceId').val(pharmacyId);
    
    $('#sheetId').val(sheetId);    
    $('#sheet_title').val(title);
    $('#sheet_details').val((details=="null"?"":details));
    $('#add_order_sheet').modal('show');
}



$("form[name='cat_drug_form']").validate();
/** ADD DRUG */

   $( "form[name='cat_drug_form']" ).submit(function(e){
        e.preventDefault();
        if(!$(this).valid()){
            return false;
        }
        
       var duplicateDrug = false; 
       $('#sheetdrug_add_btn').prop("disabled", true);
       var drugData=$( "form[name='cat_drug_form']" ).serializeArray();
       
        $.each(drugData,function(key,val){
          console.log(key,val);
          if( val.name=="default_rx_qty" )
          {
            if(val.value.indexOf(',') != -1)
            {
                val.value=val.value.replace(",", "");
            }
          }
          
          if( val.name=="rx_label_name" ){
                if(OSDrugsList.indexOf(val.value.toLowerCase().trim()) > -1 && $('#sheetDrugId').val().length == 0){
                    duplicateDrug = true;
                }
          }
          
       });
       
       if(duplicateDrug){
           toastr.error("Drug title already exists."); 
           return;
       }
       
        drugData = drugData.concat(
          $('form[name="cat_drug_form"] input[type=checkbox]:not(:checked)').map(function() {
                return {"name": this.name, "value": null}
              }).get()
          );
  
       console.log(drugData)
       $('.loader').show();
        $.ajax({
           type:'POST',
           url:"{{url('/drug/add-update')}}",
           data:drugData,
           success:function(data) {

               $('.loader').hide();
               toastr.options = {
                        "preventDuplicates": true,
                        "preventOpenDuplicates": true
                        };
                if(data.status==1)
                {
                     toastr.success('Message',data.msg);
                     $('#sheetdrug_add_btn').prop("disabled", false);
                }
                /*else{
                    $('#ndc').addClass('order-error');
                    //$('#ndc').prev('label').addClass('star');
                    $('#duplicate_ndc').show();
                    $('span.all-order-error').text(data.msg).show();
                    setTimeout(function(){  $('span.all-order-error').hide(); }, 6000);
                    
                    return false;
                }*/

                $('#add_sheet_drug_modal').modal('hide');
                orderSheetCategoryDrugs($('#sheetCategoryId').val(), "Sheet Category");

           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });
   });



   /** Edit Drug */


    function edit_drugs(id)
    {
    
            $('input[name="sheetDrugId"]').val('');
    
                $.ajax({
                type:'GET',
                url:"{{url('/drug-search-maintenance')}}",
                data:'id='+id,
                success:function(data) {
                    if(data!='NULL')
                    {
                            window.edit_drug = data[0];
                            $('form[name="cat_drug_form"] #sheetDrugId').val(id);

                            if(data[0].upc){
                                    $("#ndc").removeAttr("required");  
                            }

                            $.each(data[0], function( key, val ) {
                                if(key == 'instructions'){
                                    $('#'+key).val(val);
                                }
                                else if($('input[name="'+key+'"]').attr('type')!='checkbox')
                                {
                                    var newValue = $.trim(val);
                                    $('input[name="'+key+'"]').val(newValue);
                                }else{ $('input[name="'+key+'"][value="'+val+'"]').prop('checked', true); }
                            });
                   }
                   },
                       headers: {
                           'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                   }
                   });
   }



    /**  AutoComplete on drug search , major and minor reporting class    */


    $('#keyword_drug').autoComplete({
        resolverSettings: {
        url: "{{url('/drug-search-maintenance')}}"
        }
    });

    $('#keyword_drug').on('change', function() {
        console.log('eventsAutoComplete change');

    });

    $('#keyword_drug').on('autocomplete.select', function(evt, item) {
        //  console.log('eventsAutoComplete autocomplete.select');
        //console.log(item.value);
        edit_drugs(item.value);
    });

    $('#keyword_drug').on('autocomplete.freevalue', function(evt, item) {
        console.log('eventsAutoComplete autocomplete.freevalue');
        //eventsCodeContainer.text(eventsCodeContainer.text() + 'fired autocomplete.freevalue. item: ' + item + ' value: ' + $(this).val() + '\n');
    });

















/**       Custom Validation Error



var validator = {};

function addError(e) {
    validator.showErrors({
        "FirstName": "test error"
    });
}

function removeError(e) {
    validator.showErrors({
        "FirstName": null
    });
    fixValidFieldStyles($("form"), validator);
}

$(document).ready(function() {
    var $form = $("#experiment");
    // prevent form submission
    $form.submit(function(e) {
        e.preventDefault();
        return false;
    });
    $("#add").click(addError);
    $("#remove").click(removeError);
    $("#debug").html("<h1>Validator properties:</h1>");
    validator = $form.validate();
    validator.settings.showErrors = showErrors;
    for (var i in validator) {
        var row = $("<span></span>").html(i).append("<br/>");
        $("#debug").append(row);
    }
});


function showErrors(errorMessage, errormap, errorlist) {
    var val = this;
    errormap.forEach(function(error, index) {
        val.settings.highlight.call(val, error.element, val.settings.errorClass, val.settings.validClass);
        $(error.element).siblings("span.field-validation-valid, span.field-validation-error").html($("<span></span>").html(error.message)).addClass("field-validation-error").removeClass("field-validation-valid").show();
    });
}

function fixValidFieldStyles($form, validator) {
    var errors = {};
    $form.find("input,select").each(function(index) {
        var name = $(this).attr("name");
        errors[name] = validator.errorsFor(name);
    });
    validator.showErrors(errors);
    var invalidFields = $form.find("." + validator.settings.errorClass);
    if (invalidFields.length) {
        invalidFields.each(function(index, field) {
            if ($(field).valid()) {
                $(field).removeClass(validator.settings.errorClass);
            }
        });
    }
}

 */

/*   show all together modal just back will fade
 $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 200000 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });  */

 $('#add_order_sheet').on('shown.bs.modal', function (e) {    // order sheet maint -> add order sheet
	if($('#add_order_sheet').is(':visible')){
  		$('.modal:not(#add_order_sheet)').addClass('v-hidden-opacity');
	}
});
$('#add_order_sheet').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
  		$('.modal').removeClass('v-hidden-opacity');
	
});


$('#order_sheet_cat_listing').on('shown.bs.modal', function (e) {  // order sheet maint -> drug cat

  		$('#practice-Add-Modal').addClass('v-hidden-opacity');
	
});
$('#order_sheet_cat_listing').on('hidden.bs.modal', function () {

  		$('#practice-Add-Modal').removeClass('v-hidden-opacity');
	
});

$('#order_sheet_view').on('shown.bs.modal', function (e) {  // order sheet maint -> drug cat

  		$('#practice-Add-Modal').addClass('v-hidden-opacity');
	
});
$('#order_sheet_view').on('hidden.bs.modal', function () {

  		$('#practice-Add-Modal').removeClass('v-hidden-opacity');
	
});




$('#order_sheet_add_drug_cat').on('shown.bs.modal', function (e) {      // add drug cat
    // if($('#order_sheet_add_drug_cat').hasClass('v-hidden-opacity'))
                //   $('#order_sheet_add_drug_cat').removeClass('v-hidden-opacity');
            
  		$('#order_sheet_cat_listing').addClass('v-hidden-opacity');
	
});

$('#order_sheet_add_drug_cat').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
  		$('#order_sheet_cat_listing').removeClass('v-hidden-opacity');
	
});


$('#order_sheet_drug_listing').on('shown.bs.modal', function (e) {
    // if($('#order_sheet_add_drug_cat').hasClass('v-hidden-opacity'))
                //   $('#order_sheet_add_drug_cat').removeClass('v-hidden-opacity');
            
  		$('#order_sheet_cat_listing').addClass('v-hidden-opacity');
	
});

$('#order_sheet_drug_listing').on('hidden.bs.modal', function () {

  		$('#order_sheet_cat_listing').removeClass('v-hidden-opacity');
	
});


$('#add_sheet_drug_modal').on('shown.bs.modal', function (e) {
    // if($('#order_sheet_add_drug_cat').hasClass('v-hidden-opacity'))
                //   $('#order_sheet_add_drug_cat').removeClass('v-hidden-opacity');
            
  		$('#order_sheet_drug_listing').addClass('v-hidden-opacity');
	
});

$('#add_sheet_drug_modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();

  		$('#order_sheet_drug_listing').removeClass('v-hidden-opacity');
	
});

function viewAddPractice()
{
      $('#practice-Add-Modal').modal('show');
      $("#practice-reg-step").steps('skip', 4);      
      $("#practice-reg-step").steps('unskip', 1);
      $("#practice-reg-step").steps('unskip', 2);
      $("ul[role='tablist'] li:nth-child(2)").show();
      $("ul[role='tablist'] li:nth-child(3)").show();
      $("ul[role='tablist'] li:nth-child(5)").hide();
      $("#practice-reg-step-t-5").children("span").text("5");   
}
       
  $(document).ready(function(){




    $('#pharmacy_table').DataTable({
            processing: false,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            pageLength: 5,
            "language": {
              "infoFiltered": "",
            },
            ajax: {
                "type": "post",
                "url": '{{url("practice-drug-listing")}}?type=pharmacy',
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "pharmacies",
                "data": function(data){
                    
                },
                "complete": function(response){
                    console.log(JSON.parse(response.responseText).pharmacies); 
                }
            },
            columns: [
            {'data':'practice_name','render':function(practice_name,type,full){
              @can('edit pharmacy')
                return '<a class="txt-blue_sh-force td_u_force p-name" href="javascript:void(0)" onclick="open_edit_practice('+full.id+')">'+practice_name+'</a><i class="fa fa-check elm-right cur-pointer"  aria-hidden="true" onclick="acknowledge('+full.id+',\'Pharmacy\')"></i>';
                @else
                  return '<a class="p-name">'+practice_name+'</a>';
                @endcan
            }},
            {'data':'practice_zip','render':function(practice_zip,type,full){
                return practice_zip;
            }},
            {'data':'practice_state','render':function(practice_state,type,full){
                return practice_state;
            }},
            {'data':'users','render':function(users,type,full){
                // if(users && users.length > 0)
                if(users)
                {
                  return users;  
                }else{
                  return '';
                }
                
            }},
            {'data':'created_by','render':function(created_by,type,full){
              if(created_by)
              {
                // return created_by.name;
                return created_by;
              }else{
                return '';
              }
            }}
            ],
            'createdRow': function(row, d, di){
              $(row).attr("data-prid",d.id)
              $(row).children(':nth-child(2)').addClass("p-zip");
              $(row).children(':nth-child(3)').addClass("p-state");
              $(row).children(':nth-child(4)').addClass("site-cnt");
            }

        });

        $('#physician_table').DataTable({
            processing: false,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            pageLength: 5,
            "language": {
              "infoFiltered": "",
            },
            ajax: {
                "type": "post",
                "url": '{{url("practice-drug-listing")}}?type=physician',
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "physicians",
                "data": function(data){
                    
                },
                "complete": function(response){
                    console.log(JSON.parse(response.responseText).physicians); 
                }
            },
            columns: [
            {'data':'practice_name','render':function(practice_name,type,full){
              @can('edit physician')
                return '<a class="txt-blue_sh-force td_u_force p-name" href="javascript:void(0)" onclick="open_edit_practice('+full.id+')">'+practice_name+'</a><i class="fa fa-check elm-right cur-pointer"  aria-hidden="true" onclick="acknowledge('+full.id+',\'Physician\')"></i>';
                @else
                  return '<a class="p-name">'+practice_name+'</a>';
                @endcan
                
            }},
            {'data':'practice_zip','render':function(practice_zip,type,full){
                return practice_zip;
            }},
            {'data':'practice_state','render':function(practice_state,type,full){
                return practice_state;
            }},
            {'data':'practice_state','render':function(practice_state,type,full){
                return '';
            }},
            {'data':'users','render':function(users,type,full){
                // if(users && users.length > 0)
                if(users)
                {
                  // return users[0].name;
                  return users;  
                }else{
                  return '';
                }
                
            }},
            {'data':'created_by','render':function(created_by,type,full){
              if(created_by)
              {
                // return created_by.name;
                return created_by;
              }else{
                return '';
              }
            }}
            ],
            'createdRow': function(row, d, di){
              $(row).attr("data-prid",d.id)
              $(row).children(':nth-child(2)').addClass("p-zip");
              $(row).children(':nth-child(3)').addClass("p-state");
              $(row).children(':nth-child(5)').addClass("site-cnt");
            }

        });

        $('#law_practice_table').DataTable({
            processing: false,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            pageLength: 5,
            "language": {
              "infoFiltered": "",
            },
            ajax: {
                "type": "post",
                "url": '{{url("practice-drug-listing")}}?type=law',
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "law_practices",
                "data": function(data){
                    
                },
                "complete": function(response){
                    console.log(JSON.parse(response.responseText).law_practices); 
                }
            },
            columns: [
            {'data':'practice_name','render':function(practice_name,type,full){
              @can('edit practice law')
                return '<a class="txt-blue_sh-force td_u_force p-name" href="javascript:void(0)" onclick="open_edit_practice('+full.id+')">'+practice_name+'</a><i class="fa fa-check elm-right cur-pointer"  aria-hidden="true" onclick="acknowledge('+full.id+',\'Law\')"></i>';
              @else
                return '<a class="p-name">'+practice_name+'</a>';
              @endcan
                
              }},
            {'data':'practice_zip','render':function(practice_zip,type,full){
                return practice_zip;
            }},
            {'data':'practice_state','render':function(practice_state,type,full){
                return practice_state;
            }},
            {'data':'users','render':function(users,type,full){
                // if(users && users.length > 0)
                if(users)
                {
                  return users;  
                }else{
                  return '';
                }
                
            }},
            {'data':'created_by','render':function(created_by,type,full){
              if(created_by)
              {
                // return created_by.name;
                return created_by;
              }else{
                return '';
              }
            }}
            ],
            'createdRow': function(row, d, di){
              $(row).attr("data-prid",d.id)
              $(row).children(':nth-child(2)').addClass("p-zip");
              $(row).children(':nth-child(3)').addClass("p-state");
              $(row).children(':nth-child(4)').addClass("site-cnt");
            }

        });

        $('#drug_tbl').DataTable({
            processing: false,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            pageLength: 5,
            "language": {
              "infoFiltered": "",
            },
            ajax: {
                "type": "post",
                "url": '{{url("practice-drug-listing")}}?type=drug',
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "drugs",
                "data": function(data){
                    
                },
                "complete": function(response){
                    console.log(JSON.parse(response.responseText).drugs); 
                }
            },
            columns: [
            {'data':'ndc','render':function(ndc,type,full){
              if(ndc)
              {
                @can('edit drug')
                  return '<a class="txt-blue_sh td_u_" href="javascript:void(0)" onclick="open_edit_drugs('+full.id+')">'+ndc+'</a>';
                @else
                  return '<a class="td_u_" >'+ndc+'</a>';
                @endcan
              }else{
                return '';
              }
            }},
            {'data':'rx_label_name','render':function(rx_label_name,type,full){
              if(rx_label_name)
              {
                @can('edit drug')
                  return '<a class="txt-blue_sh-force td_u_force" href="javascript:void(0)" onclick="open_edit_drugs('+full.id+')">'+rx_label_name+'</a>';
                  @else
                    return '<a>'+rx_label_name+'</a>';
                  @endcan
              }else{
                return '';
              }
            }},
            {'data':'brand_reference','render':function(brand_reference,type,full){
                return brand_reference;
            }},
            {'data':'strength'},
            {'data':'marketer'},
            {'data':'unit_price','render':function(unit_price,type,full){
              var price;
              if(unit_price)
              {
                price=parseFloat(unit_price);
               
              }else{
                price=parseFloat("0");
              }
               return '$ '+price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }},
            {'data':'generic_or_brand'},
            {'data':'practice_name','render':function(practice_name,type,full){
                return practice_name;
            }}
            ],
            'createdRow': function(row, d, di){
         
              $(row).children(':nth-child(1)').addClass("text-sline");
              $(row).children(':nth-child(6)').addClass("cnt-right-force");
             
            }

        });
  });
  
	if($('#practice_type option:selected').val() != ""){
		setUserRoles($('#practice_type option:selected').val(),0);
	}

	function setUserRoles(practiceVal,EditType)
	{
		if(practiceVal == 'Physician'){
			$('.selectRole').each(function(key, val){
				$(val).empty().append('<option value="6">Physician</option><option value="8">Reporter</option>');            
            });				
		}else if(practiceVal == 'Law'){
			$('.selectRole').each(function(key, val){
				$(val).empty().append('<option value="9">Law Practice Admin</option>');            
            });            
		}else{
			$('.selectRole').each(function(key, val){
					$(val).empty().append('<option value="3">Practice Super Admin</option><option value="15">Practice Group Owner</option><option value="2">Practice Admin</option>');
            });
		}			
    
    if(practiceVal == 'Law'){
      $("#practice-reg-step").steps('skip', 1);
      $("#practice-reg-step").steps('skip', 2);
      $("#practice-reg-step").steps('skip', 4);
      $("ul[role='tablist'] li:nth-child(2)").hide();
      $("ul[role='tablist'] li:nth-child(3)").hide();
      $("ul[role='tablist'] li:nth-child(5)").hide();
      $("#practice-reg-step-t-3").children("span").text("2");
      $("#practice-reg-step-t-5").children("span").text("3");
      $('.copay-field').hide();
    }else{
      $('.copay-field').show();
      $("#practice-reg-step").steps('unskip', 1);
      $("#practice-reg-step").steps('unskip', 2);
      $("#practice-reg-step").steps('unskip', 4);
      $("ul[role='tablist'] li:nth-child(2)").show();
      $("ul[role='tablist'] li:nth-child(3)").show();
      $("ul[role='tablist'] li:nth-child(5)").show();
      $("#practice-reg-step-t-3").children("span").text("4");
      //******input id will be used for checking if pharmacy is in create form and dont show the ordersheet setup******/
      //console.log($('input[name="id"]').val());
      if($('input[name="id"]').val() > 0){
        console.log("editmode ....");
        $("#practice-reg-step").steps('unskip', 4);
          $("ul[role='tablist'] li:nth-child(5)").show();
          //$("#practice-reg-step-t-5").children("span").text("5");  
      }else{
        console.log("createmode ....");
          $("#practice-reg-step").steps('skip', 4);
          $("ul[role='tablist'] li:nth-child(5)").hide();
          $("#practice-reg-step-t-5").children("span").text("5"); 
      }

    }

	}

</script>
