@extends('layouts.compliance')

@section('content')



<style>

.profile_lable_input {  }
.profile_lable_input table tbody tr td:nth-child(1) {  }
.profile_lable_input table tbody tr td:nth-child(2) {  }
.profile_lable_input table tbody tr td:nth-child(3) {  }
.profile_lable_input table tbody tr td:nth-child(4) { text-align: center; } /*center align days supply column*/
.profile_lable_input table tbody tr td:nth-child(5) { text-align: center; } /*center align auntity column*/
.profile_lable_input table tbody tr td:nth-child(6) {  }
.profile_lable_input table tbody tr td:nth-child(7) {  }
.profile_lable_input table tbody tr td:nth-child(8) {  }

</style>



<div class="row pt-14_">

    <div class="col-sm-12">

        <div class="row">

            <div id="practice_admin_left_col" class="left_col_44p col-sm-12 col-md-12 col-lg-6">
                      <form id="updatePatientForm" autocomplete="off" novalidate>
                        <input type="hidden" name="PatientId" value="{{$patient->Id}}">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="bg-grn-lk mb-0_ bg-grk" style=" color: #fff; padding: 0.3rem 1rem; font-size: 20px;overflow: hidden;">
                            <h4 style="float: left;" class="mb-0_">Active Profile</h4>
                            <div class="modal_edit" style="float: right;">
                                <i style="margin-top: 5px;cursor: pointer;" onclick="editForm(event)" class="fa fa-edit"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12 compliance-form_  ">
                        <div  class="bg-gray-f2 trow_ pa-14_">
                            <div class="flds-fn-ln-sfx flx-justify-start mb-14_">
                                <div class="wd-43p field fld-fname mr-1p">
                                    <label class="wd-100p">First Name:</label>
                                                          <input class="wd-100p tt_cc_" name="FirstName" value="{{$patient->FirstName}}" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" placeholder="Enter First Name" disabled maxlength="30" required>
                                </div>
                                <div class="wd-43p field fld-lname mr-1p">
                                    <label class="wd-100p">Last Name:</label>
                                                          <input class="wd-100p tt_cc_" name="LastName" autocomplete="off" value="{{$patient->LastName }}" onkeypress="return blockSpecialChar(event)" type="text" placeholder="Enter Last Name" disabled maxlength="30" required>
                                </div>
                                <div class="wd-12p field fld-suffix">
                                    <label class="wd-100p v-hidden">Suffix:</label>
                                    <input class="wd-100p" name="Suffix"  onkeypress="return blockSpecialChar(event)" value="{{$patient->Suffix }}"  autocomplete="off" type="text" placeholder="Suffix" disabled maxlength="5">
                                </div>
                            </div>

                            <div class="flds-dob-sx-mbph-em flx-justify-start mb-14_">
                                <div class="wd-23p field fld-dob mr-1p">
                                    <label class="wd-100p">Date of Birth:</label>
                                    <input name="BirthDate" value="{{$patient->BirthDate }}"  type="date"
                                      maxlength="10" id="dobpicker" autocomplete="off" required
                                       placeholder="mm/dd/yyyy" onkeyup="addSlashes(this)"
                                      onkeypress="return IsDigit(event)"
                                      class="wd-100p" disabled>
                                </div>
                                <div class="wd-7p field fld-sx mr-1p" style="min-width:54px;">
                                    <label class="wd-100p">Sex:</label>
                                    <select disabled name="Gender" type="text" style="padding-right: 0px;-webkit-appearance: none;-moz-appearance: none;line-height: 19px;padding-left: 3px;"
                                                                  autocomplete="off"  class="wd-100p form-control">
                                                                  <option value="M" {{ $patient->Gender == 'M'?'selected':''}}>Male</option>
                                                                  <option value="F" {{ $patient->Gender == 'F'?'selected':''}}>Female</option>
                                                          </select>
                                </div>
                                <div class="wd-23p field fld-mb_phone mr-1p">
                                    <label class="wd-100p">Mobile Phone:</label>
                                    <input name="MobileNumber" required
                                                              type="text" autocomplete="off"
                                                              class="wd-100p" id="mobilePhone"
                                                              mask="(000) 000-0000"
                                                              value="{{$patient->MobileNumber }}"
                                                              placeholder="Enter Mobile No" minlength="10" disabled>
                                                               <input  type="hidden"  value="{{$patient->EmailAddress }}"  class="custom_add_inputs" id="prevEmail">

                        <input id="prevPhone" mask="(000) 000-0000"  type="hidden" value="{{$patient->MobileNumber }}"  class="custom_add_inputs"
                                       >

                                </div>
                                <div class="wd-44p field fld-mb_phone">
                                    <label class="wd-100p">Email Address:</label>
                                    <input name="EmailAddress" required
                                      type="email" autocomplete="off"  id="check-email"
                                      class="wd-100p"
                                      value="{{$patient->EmailAddress }}"
                                      placeholder="Enter Email" disabled>
                                </div>
                            </div>


                            <div class="flds-addr flx-justify-start mb-14_">
                                <div class="wd-100p field fld-address">
                                    <label class="wd-100p">Address:</label>
                                    <input name="Address" required value="{{$patient->Address }}"
                                                              type="text"  class="wd-100p"
                                                              autocomplete="off" placeholder="Enter Address" disabled maxlength="80">
                                </div>
                            </div>

                            <div class="flds-cty-st-zp flx-justify-start mb-14_">
                                <div class="wd-44p field fld-city mr-1p">
                                    <label class="wd-100p">City:</label>
                                    <input name="City" required type="text" value="{{$patient->City }}"  class="wd-100p" autocomplete="off" placeholder="Enter City" disabled maxlength="30">
                                </div>
                                <div class="field fld-state mr-1p" style="width: 60px;">
                                    <label class="wd-100p">State:</label>
                                    <select name="State" required class="form-control" disabled>
                                    	@foreach($states as $st)
                                        	<option value="{{$st->Id}}" {{ $patient->StateId == $st->Id ? 'selected="selected"' : '' }}>{{$st->Abbr}}</option>
                                    	@endforeach
                              		</select>
                                </div>
                                <div class="field fld-zip" style="width: 100px;">
                                    <label class="wd-100p">Zip:</label>
                                    <input name="ZipCode" required type="text" value="{{$patient->ZipCode }}" autocomplete="off" minlength="5" maxlength="10" mask="00000-0000"
                                  id="zip" class="wd-100p" placeholder="Enter Zip Code" disabled minlength="5" maxlength="10">
                                </div>
                                              <input name="preffered_method_contact"  value="Text" type="hidden">
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($patient->enrollment->enrollment_status) && $patient->enrollment->enrollment_status =="New")
                <div class="row">
                <div class="col-sm-12">
                    <div class="trow_ pl-14_ bg-gray-f2" style="padding-bottom: 24px;"><span class="txt txt-grn-lt tt_cc_ mb-17_">Patient Has Not Approved Terms & Conditions <br><font style="font-size: 10px;">(<?=date("m-d-Y H:i:s",strtotime($patient->enrollment->updated_at))?>)</font></span></div>
                    <div class="trow_ pa-14_ bg-gray-f2">
                        <div class="elm-left mt-24_">
<button id="ResendEnrollBtn" pat_id="{{$patient->Id}}" class="btn bg-lt-grn-txt-wht weight_500 fs-20_ tt_uc_" style="line-height: 20px;padding: 6px;font-size: 17px;">
    <span class="fa fa-refresh"></span>&nbsp;resend enrollment message <span style=" line-height: inherit; font-size: inherit; font-weight: 500; letter-spacing: -3px;">&#10095;&#10095;</span></button>
</div>

                    </div>
                </div>
            </div>
@endif
                @if(isset($patient->enrollment->enrollment_status) && $patient->enrollment->enrollment_status =="Enrolled")
                <div class="row">
                <div class="col-sm-12">
                    <div class="trow_ pl-14_ bg-gray-f2" style="padding-bottom: 24px;"><span class="txt txt-grn-lt tt_cc_ mb-17_">Patient Approved Terms & Conditions<br><font style="font-size: 10px;">(<?=date("m-d-Y H:i:s",strtotime($patient->enrollment->updated_at))?>)</font></span></div>
                    <div class="trow_ pa-14_ bg-gray-f2">

                        <div class="elm-right">
                            <div class="cnt-center mb-7_">
                                <span class="txt txt-blue weight_600 tt_uc_ fs-14_ mb-17_ mr-4_" style="line-height:17px;">savings to date</span>
                                <span class="txt-blue weight_600 fs-17_" style="line-height:17px;">(${{isset($total)?number_format($total,2):''}})</span>
                            </div>
                            <div class="cnt-center mt-7_">
                                <button type="button" class="btn mr-14_ bg-blue-txt-wht weight_600 c-dib_ " style="line-height: 20px; padding: .6rem .75rem;" disabled id="RefillBtn" pat_id="{{$patient->Id}}">
                                    <span class="mr-4_ cnt-left fs-12_">Rx's Due<br>To Refill Now</span>
                                    <span class="fs-20_" style=" line-height: 1.4em; font-weight: 500; letter-spacing: -3px;">&#10095;</span>
                                </button>
                                <button class="btn bg-blue-txt-wht weight_600 c-dib_ " style="line-height: 20px; padding: .6rem .75rem;" type="button" onclick="window.location.href='{{url("orders?pId=$patient->Id")}}'"  >
                                    <span class="mr-4_ cnt-left fs-12_" style=" line-height: 1.4em;">Program Rx's<br>(Compliance Reward)</span>
                                    <span class="fs-20_ circle-bgred-colorwht" style="font-size: 17px;margin-top: 4px;margin-right: 7px;">{{$totalOrder??'0'}}</span>
                                    <span class="fs-20_" style=" line-height: 1.4em; font-weight: 500; letter-spacing: -3px;">&#10095;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endif

                <div class="row">
                    <div class="col-sm-12">
                        <div class="trow_ bg-gray-f2 pa-14_">

                            <div class="elm-right">
                              <button type="submit" class="btn bg-blue-txt-wht weight_600 fs-17_ tt_uc_" id="updatePatient" style="line-height: 20px; padding: .6rem .75rem; display: none;">update <span style=" line-height: inherit; font-size: 20px; font-weight: 500; letter-spacing: -3px;">&#10095;&#10095;</span></button>
                          </div>
                      </div>
                    </div>
                </div>

                      </form>
            </div>

            <div class="right_col_56p col-sm-12 col-md-12 col-lg-6" id="enrollmentStatusPatient">

                <div class="row height_fullp" style="align-items: center; min-height: 320px;">
                    <div class="col-sm-12 mt-24m_" style="display:flex;flex-wrap: wrap;">
                        <div class="trow_ c-dib_ cnt-center mb-24_"><img src="{{url('/images/tick-circle.png')}}" style="max-width:73px;"/></div>
                        <div class="trow_ c-dib_ cnt-center green-color-force_childs fs-17_"><span class="user-name weight_600 fs-17_">{{$patient->FirstName}}-{{$patient->LastName}} ({{ucfirst(substr($patient->Gender,0,1))}}) {{ date('m-d-Y', strtotime($patient->BirthDate))}}</span> enrolled in system.</div>
                        <div class="trow_ c-dib_ cnt-center green-color-force_childs fs-14_"><span class="user-name weight_600 fs-14_">An enrollment status of current patient is {{(isset($patient->enrollment->enrollment_status) && $patient->enrollment->enrollment_status =="New")?"Not Accept Terms and Conditions":"Enrolled"}}.</span></div>
                        <div class="trow_ c-dib_ cnt-center fs-17_ mt-7_"><span class="txt-blue weight_600 fs-17_">Now Opening the reward services screen &hellip;</span></div>
                    </div>
                </div>

            </div>

            <div class="right_col_56p col-sm-12 col-md-12 col-lg-6  pl-lg-0" id="enrollshowPrescription" style="display: none">
            	@include('practice_module.prescription')
        	</div>

            <div class="right_col_56p col-sm-12 col-md-6 col-lg-6 pr-0 pl-0 right-pr-drg-details" id="refill_main" style="display: none">
                <div id="prescription-order-form" class="tab-content current">

                    <section id="rxForm">
                        <div id="orderForm" class="col-sm-12 content_center_profile">
                            <div class="table_content_cont_add_prac">
                                    <div class="green_heading">
                                        <div class="row">
                                            <div class="col-sm-12">
                                            	<div class="bg-grn-lk mb-0_ bg-grk" style=" color: #fff; padding: 0.3rem 1rem; font-size: 20px;overflow: hidden;">
                                                    <h4 class="elm-left disp_blck mb-0_ tt_cc_">Rx's due to refill now</h4>
                                                    <button class="pos-abs_ btn bg-blue-txt-wht field fld-add_drug tt_uc_" style="top: 50%;right: 24px;border-radius: 24px;padding: 2px 10px;margin-top: -13px;" onclick="toggleOrder()">Back</button>
                                            	</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile_lable_input">
                                        <div id="refill_table" class="table-responsive"></div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>





        </div>

    </div>





  </div>

@endsection

@section('js')

@include('partials.js.order_prescription')

    <script>
            function blockSpecialChar(e)
            {
                var k;
                k = e.keyCode;
                return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==45 || k == 32 || (k >= 48 && k <= 57));
            }

            function toggleOrder(){
            $('#refill_main').hide();
            $('#enrollshowPrescription').show();

           }
        $(document).ready(function() {

            $('#datetimepicker').keydown(function(e) {
           console.log('keyup called');
           var code = e.keyCode || e.which;
           if (code == '9') {
             $('#drug').focus();

           return false;
           }

        });
            setTimeout(function ()
            {
                $('#enrollmentStatusPatient').hide();
                $('#enrollshowPrescription').show();
                $('#RefillBtn').removeAttr('disabled');
            }, 3000);

            $("#dobpicker").datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy',

                 orientation: "bottom",
            });



            $('#ResendEnrollBtn').click(function (e){
            	$(this).attr("disabled", true);
                e.preventDefault();
                $.ajax({
                url: '{{ url("/resend-enrollment/") }}'+'/'+$(this).attr('pat_id'),
                method: 'get',
                success: function(result){

                   if(result.status)
                           {
                                  console.log(result.message);
                            toastr.success(result.message);
                        }
                            else{
                            toastr.danger(result.message);
                           }
                           $('#ResendEnrollBtn').removeAttr("disabled");
                },
                error: function(data){

                },
                       headers: {
                           'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                   }
                   });

            });




            $('#RefillBtn').click(function (e){
                $('#refill_table').html('');
               e.preventDefault();
                $.ajax({
                url: '{{ url("patient/refill") }}',
                method: 'POST',
                data: 'patient_id='+$('#RefillBtn').attr('pat_id'),
                success: function(result){
                    $('#enrollshowPrescription').hide();

                   $('#refill_table').html(result);

                   $('#refill_main').show();
                },
                error: function(data){

                },
                       headers: {
                           'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                   }
                   });

            });

            var minChar = 14;
            $('form[id="updatePatientForm"]').validate({
                rules: {
                    BirthDate: {
                        required: true
                    },
                    EmailAddress: {
                        required: true, email: true, minlength: 5, maxlength: 100,
                        remote: {
                            url: "{{route('check_email_update')}}",
                            method: 'post',
                            data: {
                                PrevEmailAddress:  $("#prevEmail").val(),
                                EmailAddress:$("#check-email").val()
                            }
                        }
                    },
                    ZipCode: {
                        required: true, minlength: 5, maxlength: 9
                    },
                    MobileNumber: {
                        required: true, minlength: minChar,
                        remote: {
                            url: "{{route('check_phone_update')}}",
                            method: 'post',
                            data: {
                                MobileNumber: function () {
                                    var newStr1 = $("#mobilePhone").val().replace(/[- )(]/g, '');
                                    return newStr1;
                                },
                                PrevPhoneNumber:  function () {
                                    var newStr1 = $("#prevPhone").val().replace(/[- )(]/g, '');
                                    return newStr1;
                                }
                            }
                        }
                    },
                },
                messages: {
                     EmailAddress: {
                        remote: "Email Already Exist"
                    },
                    MobileNumber: {
                       remote: "Phone Number Already Exist",
                       minlength: function () {
                          return ['Please Enter Min 10 digits'];
                        }
                    },
                    ZipCode: {
                        minlength: "Please Enter At Least 5 digits."
                    }
                }
            });
            // $('form[id="editPatientDetail"]').submit(function(event){
            //     // event.preventDefault();
            //     if(!$(this).valid())
            //     {
            //         return false;
            //     }else{
            //         $("#mobilePhone").val($("#mobilePhone").val().replace(/[- )(]/g, ''));
            //         return true;
            //     }
            // });
            $('#updatePatient').click(function(e){
                e.stopImmediatePropagation();


                     if (!$('form[id="updatePatientForm"]').valid()) {
                        console.log("herere3");
                        return false;
                    }

                    e.preventDefault();
                    var updatedPatient=$('#updatePatientForm').serializeArray();
                    var patientId=updatedPatient.find(v=>v.name==='PatientId');
                     var postData = new FormData();
                       $.each(updatedPatient, function (i, val) {
                        console.log(val);
                        if (val.name == "MobileNumber") {
                            var newStr = val.value.replace(/[- )(]/g, '');
                            val.value = newStr;
                        }
                      /*  if (val.name == "BirthDate") {
                            // var newDob = val.value.replace(/[/]/g,'-');
                            // var date = new Date(newDob);
                            var dateAr = val.value.split('/');
                            var newDate = dateAr[2] + '-' + dateAr[0] + '-' + dateAr[1];
                            // console.log(newDob);
                            console.log(newDate);
                            val.value = newDate;
                        }*/
                        // postData.append(val.name, val.value);
                    });
                    console.log(patientId.value);
                    $.ajax({
                        url:"{{url('patient')}}/"+patientId.value,
                        method: 'PUT',
                        data:updatedPatient,
                        success:function(response){
                            if(response.status)
                            {
                                console.log(response.data);
                                $('#updatePatient').hide();
                                $('#updatePatientForm').find('input,select').attr('disabled',true);
                                toastr.success('',response.message);

                                $('#updatePatientForm .modal_edit i').removeClass('fa-remove');
                                 $('#updatePatientForm .modal_edit i').addClass('fa-edit');
                            }else{
                                toastr.error('',response.message);
                                console.log(response.data);
                            }
                        },
                        error:function(error){
                            console.log(error)
                            toastr.error('',"Cannot updated");
                        }
                    });

            });
        });
        function editForm(event){
            if(event.target.classList.contains("fa-edit"))
            {
                $('#updatePatientForm').find('input,select').not("[name=BirthDate]").prop('disabled',false);
                $('#updatePatient').show();
                event.target.classList.remove('fa-edit');
                event.target.classList.add('fa-remove');
            }else{
                $('#updatePatient').hide();
                $('#updatePatientForm').find('input,select').attr('disabled',true);
                event.target.classList.remove('fa-remove');
                event.target.classList.add('fa-edit');
            }

        }

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
 <button onclick='enableRefillButton("+oid+")'  type='button' class='btn clear toast-hov'>No</button> <button onclick='sendRefillRequest("+oid+");' type='button' class='btn clear toast-hov'>Yes</button>");
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
        data: 'order_id='+oid,
        method: 'post',
        success: function(result){
            if(result.refillDone){
                toastr.success(result.refillMessage);
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

function openUrl(oid,stoken)
{
    // alert('no');
 window.location ='{{url("create-enrollment-refill-order/")}}'+'/'+oid+'/'+stoken;
}

// });


    @if ($message = Session::get('refillMessage'))
    // alert('a');
        $(document).ready(function() {

         toastr.success('Refill Order has been placed');
         $('.alert').delay(1000).fadeOut();
    });
    @endif
    </script>

@endsection
