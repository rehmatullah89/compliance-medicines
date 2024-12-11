<script type="text/javascript">
	$(document).ready(function(){

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
return form.valid();
return true;
},
onFinished: function (event, currentIndex) {
form.submit();

{{--  toastr.success('Success',"Practice has been added successfully");  --}}


}

});

var minChar = 14;
        $("#practice-reg-form").validate({

            rules: {

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

        if($.inArray('no', checka)>= 0){ return false;  }




       $('.loader').show();
        $.ajax({
           type:'POST',
           url:"{{url('/practice/add-update')}}",
           data:$( "form[name='practice_form']" ).serialize(),
           success:function(data) {
toastr.remove();
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

               }else{
                $( "#practice-reg-step" ).steps('reset');
                $('#practice-reg-form')[0].reset();
               console.log('yes');

               // var myForm = document.getElementsByClassName("practice_form");
               // clearValidation(myForm);

                toggleButton("finish",   true);
               }
               $('.loader').hide();
              // toast.setGravity(Gravity.CENTER, 0, 0);

               toastr.success('Message',data.msg);
                // toggleButton("finish",   true);
                if(data.type=='update'){
                    $('#practice-Add-Modal').modal('hide');
                    setTimeout(function(){ parent.location.reload(); }, 500);

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
                $('#primary_site input[fname="email"]').each(function(key, valu){

                    if(IsEmail($(valu).val()))
                    {
                        if(  ($(input).attr('name')!= $(valu).attr('name') ))
                        {
                            console.log('inside if'+$(valu).val()+$(input).val());
                            if($.trim($(input).val()) == $.trim($(valu).val()))
                            {
                                res[count] = 'yes';
                                count++;
                            }
                        }else
                        {
                             console.log('inside else of IF');
                            if($('input[name="users['+key+'][id]"]').length > 0 )
                            {

                               return check_email($(valu).val(), $('input[name="users['+key+'][id]"]').val(),foo);

                            }
                            else
                            {
                            return check_email($(valu).val(),'',foo);

                           }
                        }
                    }else{

                         toastr.error('Message', 'Wrong Email Syntax.');
                       // res[count] = 'yes';
                       // count++;
                       return false;
                    }
                });

               if($.inArray('yes', res)!= '-1'){
                    toastr.error('Message', 'Email should not be duplicate.');
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


function check_email(email, id=false,callback)
   {
       var msgs;
       var formData = 'email='+email+'&_token={{csrf_token()}}';
       if(id){ formData = formData+'&id='+id }
        $.ajax({
            url: "{{route('check-user-mail')}}",
            method: 'post',
            data: formData,
            async:false,
            success: function(result){
                toastr.remove();
                if(result.status == 400){
                    toastr.error('Message', '"'+email+'" already exist in database.');
                    msgs = 'no';
                    toggleButton('finish', false);
                    return false;

                }else{
                   msgs = 'yes';
                   toggleButton('finish', true);
                }
                //console.log(msgs+' check   1');
                return msgs;
                // callback(msgs);
            }
        });
        //console.log(msgs+' check    2');

   }

function foo(res){
    // alert(res);
    return res;
}



function edit_practice(id)
   {
    // $("#practice-reg-step").find('a[href="#finish"]').attr("href", '#finish-disabled');

        $("#cancel_practice").trigger("click");
       $('.hupdate').text('EDIT PRACTICE');
       $('#append_field > tr').removeClass('selected_row');
       $('#tr_'+id).addClass('selected_row');
       $('form[name="practice_form"]').append('<input name="id" type="hidden" value="'+id+'" />');
       $('input[name="ndc"]').attr('readonly', 'readonly');
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
                    $('input[name="'+key+'"]').val(val);
                    $('select[name="'+key+'"] > option[value="'+val+'"]').prop('selected', true);
                });
                if(data.bankDetail)
                {
                    $('form[name="practice_form"]').append('<input name="bank[id]" type="hidden" value="" />');
                    $.each(data.bankDetail, function( keyb, valb ) {
                        $('input[name="bank['+keyb+']"]').val(valb);
                       $('select[name="bank['+keyb+']"] > option[value="'+valb+'"]').prop('selected', true);
                    });
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

                     $('.primary_site_div:nth-child('+(keyu+1)+')').find('select[name="users['+keyu+']['+innerKey+']"] > option[value="'+innerVal+'"]').prop('selected', true);
                     $('.primary_site_div:nth-child('+(keyu+1)+')').find('input[name="users['+keyu+']['+innerKey+']"]').val(innerVal);
                   });

                });

                        $('.loader').hide();
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });

   }

 function open_edit_practice($id){
$('#practice-Add-Modal .modal-title').text('Edit Practice');
$('#practice-Add-Modal').modal('show');
edit_practice($id);
}

$("[data-dismiss]").click(function () {
    if($('.modal-title').text() == 'Edit PracticeEdit Practice'){
        if(!confirm("Changes made, do you really want to discard changes?"))
          return false;
    }
});

$('#practice-Add-Modal').on('hidden.bs.modal', function () {

    $(this).find('form').trigger('reset');
            //    $( "#practice-reg-step" ).steps('reset');
               $('#practice-reg-form')[0].reset();
               clearValidation('#practice-reg-form');
               $('#practice-Add-Modal .modal-title').text('Add Practice');

               $("#practice-reg-step-t-0").get(0).click();

               //remove multiple users rows

               if($('.primary_site_div').length!=1)
               {
                  $('.primary_site_div').not('#primary_site').remove();
                  $('.primary_site_div').append('<div class="row" ><div class="col-sm-12 c-dib_ cnt-left"><div class="btn bg-blue-txt-wht" style="text-align:right;padding: 5px 7px;line-height: 17px;" onclick="add_row()">Add <i  class="fa fa-plus-circle"></i></div></div></div>');
               }

})

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

</script>
