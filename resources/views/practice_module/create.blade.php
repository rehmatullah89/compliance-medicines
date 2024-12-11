@extends('layouts.compliance')

@section('content')


<style>


input#dobpicker { margin-bottom: 0px !important; }
input#dobpicker + label.error { background-color: #f2f2f2;padding-top: 6px !important;margin-top: -2px !important;margin-left: -4px;padding-left: 7px;min-width: 107%;padding-bottom: 4px;margin-bottom: 0px; }



</style>

<div class="row pt-14_">

  <div class="col-sm-12">

  	<div class="row">

  		<div class="left_col_44p col-sm-12 col-md-12 col-lg-6">
                    <form id="patient_detail" autocomplete="off">
  			<div class="row">
  				<div class="col-sm-12">

  					<div class="bg-grn-lk mb-0_ bg-grk" style=" color: #fff; padding: 0.3rem 1rem; font-size: 20px;overflow: hidden; ">
              <h4 style="float: left;" class="mb-0_">Active Profile</h4>
              <div class="modal_edit" style="float: right;display: none" id="editIcon">

                <button type="button" class="" onclick="editForm()" style="margin-top: 5px">
                  <i class="fas fa-edit"></i>
              </button>
              </div>

            </div>

  				</div>
  			</div>

  			<div class="row">
  				<div class="col-sm-12 compliance-form_  ">
  					<div  class="bg-gray-f2 trow_ pa-14_">
                         
                                        @if(!isset(auth::user()->practices[0]->id) || auth::user()->hasrole('practice_super_group') || auth::user()->hasrole('compliacne_admin'))
                                        @if(!Session::has('practice'))
                                        @if(isset($pharmacies) && count($pharmacies) > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Select Pharmacy</label>
                                                    <select required name="practice_Id" class="form-control" id="pracId">
                                                        <option value="">Select Pharmacy</option>
                                                        @foreach($pharmacies as $pharm)
                                                            <option value="{{$pharm->id}}">{{$pharm->practice_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                           
                            @hasanyrole('super_admin')

                            @if(!Session::has('practice'))
                            @if(isset($pharmacies) && count($pharmacies) > 0)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Pharmacy</label>
                                        <select required name="practice_Id" class="form-control" id="pracId">
                                            <option value="">Select Pharmacy</option>
                                            @foreach($pharmacies as $pharm)
                                                <option value="{{$pharm->id}}">{{$pharm->practice_name }} {{ $pharm->branch_name?"( ".$pharm->branch_name." )":'' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif

                            @endhasrole
      					<div class="flds-fn-ln-sfx flx-justify-start mb-14_">
      						<div class="wd-43p field fld-fname mr-1p">
      							<label class="wd-100p">First Name:</label>
                                                        <input class="wd-100p" name="FirstName" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" placeholder="Enter First Name" required maxlength="30">
      						</div>
      						<div class="wd-43p field fld-lname mr-1p">
      							<label class="wd-100p">Last Name:</label>
                                                        <input class="wd-100p" name="LastName" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" placeholder="Enter Last Name" required maxlength="30">
      						</div>
      						<div class="wd-12p field fld-suffix">
      							<label class="wd-100p v-hidden">Suffix:</label>
      							<input class="wd-100p" name="Suffix" value="" onkeypress="return blockSpecialChar(event)" autocomplete="off" type="text" placeholder="Suffix" maxlength="5">
      						</div>
      					</div>

      					<div class="flds-dob-sx-mbph-em flx-justify-start mb-14_">
      						<div class="wd-23p field fld-dob mr-1p pos-rel_">
      							<label class="wd-100p">Date of Birth:</label>
      							<div class="trow_" style="background-color: #fff; border-radius:8px;">
          							<input name="BirthDate"  type="text"
    									maxlength="10" id="dobpicker" autocomplete="off" required
                                        value="" placeholder="mm/dd/yyyy"
                                        mask="99/99/9999"
                                        {{-- onkeyup="addSlashes(this)" onkeypress="return IsDigit(event)" --}}
    									class="wd-100p" style="padding-right: 27px; position: relative; z-index: 100; background-color: transparent;margin-bottom: 0px !important;"/>
    								<span class="fa fa-calendar" style="position: absolute;top: 29px;right: 9px; z-index: 40;"></span>
								</div>
      						</div>
      						<div class="wd-7p field fld-sx mr-1p" style="min-width: 51px;">
      							<label class="wd-100p">Sex:</label>
      							<select name="Gender" type="text" style="padding-right: 0px;-webkit-appearance: none;-moz-appearance: none;line-height: 19px;padding-left: 3px;"
                                                                autocomplete="off" required value="" class="wd-100p form-control">
                                                                <option value="M">Male</option>
                                                                <option value="F">Female</option>
                                                        </select>
      						</div>
      						<div class="wd-23p field fld-mb_phone mr-1p">
      							<label class="wd-100p">Mobile Phone:</label>
      							<input name="MobileNumber" required
                                                            type="text" autocomplete="off" value=""
                                                            class="wd-100p" id="mobilePhone"
                                                            mask="(000) 000-0000"
                                                            placeholder="Enter Mobile No" minlength="10">
      						</div>
      						<div class="wd-44p field fld-mb_phone">
      							<label class="wd-100p">Email Address:</label>
      							<input name="EmailAddress" required
									type="email" autocomplete="off" value="" id="check-email"
									class="wd-100p"
									placeholder="Enter Email">
      						</div>
      					</div>


      					<div class="flds-addr flx-justify-start mb-14_">
      						<div class="wd-100p field fld-address">
      							<label class="wd-100p">Address:</label>
      							<input name="Address" required
                                                            type="text" value="" class="wd-100p"
                                                            autocomplete="off" placeholder="Enter Address" maxlength="80">
      						</div>
      					</div>

      					<div class="flds-cty-st-zp flx-justify-start mb-14_">
      						<div class="wd-44p field fld-city mr-1p">
      							<label class="wd-100p">City:</label>
      							<input name="City" required type="text" value="" class="wd-100p" autocomplete="off" placeholder="Enter City" maxlength="30">
      						</div>
      						<div class="field fld-state mr-1p" style="width: 105px;">
      							<label class="wd-100p">State:</label>
      							<select name="State" required class="form-control">
								<option value="" >Select State</option>
                                                                    @foreach($states as $st)
                                                                        <option value="{{$st->Id}}">{{$st->Abbr}}</option>
                                                                    @endforeach
							</select>
      						</div>
      						<div class="field fld-zip" style="width: 100px;">
      							<label class="wd-100p">Zip:</label>
      							<input name="ZipCode" required type="text" value="" autocomplete="off" minlength="5" maxlength="10" mask="00000-0000"
								id="zip" class="wd-100p" placeholder="Enter Zip Code">
      						</div>
                                            <input name="preffered_method_contact"  value="Text" type="hidden">
      					</div>
  					</div>
  				</div>
  			</div>

  			<div class="row">
  				<div class="col-sm-12 ">
  					<div class="trow_ bg-gray-f2 v-spacer-47"></div>
  				</div>
  			</div>

  			<div class="row">
  				<div class="col-sm-12">
  					<div class="trow_ bg-gray-f2 pa-14_">
  						<div class="elm-right">
    						<button type="submit" class="btn bg-blue-txt-wht weight_600 fs-17_ tt_uc_" id="enrollPatient1" style="line-height: 20px; padding: .6rem .75rem;">continue <span style=" line-height: inherit; font-size: 20px; font-weight: 500; letter-spacing: -3px;">&#10095;&#10095;</span></button>

                <button type="submit" class="btn bg-blue-txt-wht weight_600 fs-20_ tt_uc_" id="updatePatient" style="line-height: 20px; padding: .6rem .75rem; display: none;">update <span style=" line-height: inherit; font-size: 20px; font-weight: 500; letter-spacing: -3px;">&#10095;&#10095;</span></button>
    					</div>
    				</div>
  				</div>
  			</div>

                    </form>
  		</div>

  		<div class="right_col_56p col-sm-12 col-md-6" id="enrollmentMessage1" style="display:none">

  			<div class="row height_fullp" style="align-items: center; min-height: 320px;">
  				<div class="col-sm-12 mt-24m_" style="display:flex;flex-wrap: wrap;">
  					<div class="trow_ c-dib_ cnt-center mb-24_"><img src="{{url('/images/tick-circle.png')}}" style="max-width:73px;"/></div>
  					<div class="trow_ c-dib_ cnt-center green-color-force_childs fs-17_"><span class="user-name weight_600 fs-17_" id="patienData"></span> has been added to the system</div>
  					<div class="trow_ c-dib_ cnt-center green-color-force_childs fs-14_"><span class="user-name weight_600 fs-14_">An enrollment message has been sent</span></div>
  					<div class="trow_ c-dib_ cnt-center fs-17_ mt-7_"><span class="txt-blue weight_600 fs-17_">Now Opening the reward services screen &hellip;</span></div>
  				</div>
  			</div>

          </div>

          <div class="right_col_56p col-sm-12 col-md-6 col-lg-6 content_center right-pr-drg-details pl-0 pr-0" id="notEnrollmentMessage1">

          	<div class="row height_fullp" style="align-items: center;min-height: 320px;">

              <div class="col-sm-12 mt-24m_" style="display:flex;flex-wrap: wrap;">
                <div class="trow_ c-dib_ cnt-center mb-24_"><img src="{{asset('images/gree_tick.png')}}" style="max-width:73px;"></div>

                <div class="trow_ c-dib_ cnt-center green-color-force_childs fs-14_"><span class="user-name weight_600 fs-14_">Please Enroll New Patient</span></div>

              </div>
        	</div>

        </div>


        <div class="right_col_56p col-sm-12 col-md-12 col-lg-6" id="showPrescription" style="display: none">
            @include('practice_module.prescription')
        </div>


  	</div>

  </div>





</div>
@endsection

@section('js')
@include('partials.js.order_prescription')
<script type="text/javascript">

        function blockSpecialChar(e)
        {
            var k;
            k = e.keyCode;
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==45 || k == 32 || (k >= 48 && k <= 57));
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

        function editForm(){
            $('#patient_detail').find('input,select').not("[name=EmailAddress], [name=MobileNumber], [name=BirthDate]").prop('disabled',false);
            $('#enrollPatient1').hide();
            $('#updatePatient').show();
        }
        $(document).ready(function() {

          $('#updatePatient').click(function(e){
               if (!$('#patient_detail').valid()) {
                  console.log("herere3");
                  return false;
              }
              e.stopImmediatePropagation();
              e.preventDefault();
                  var updatedPatient=$('#patient_detail').serializeArray();
                  var patientId=updatedPatient.find(v=>v.name==='PatientId');
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
                          $('#patient_detail').find('input,select').attr('disabled',true);
                          $('#enrollPatient1').show();
                          toastr.success('',response.message);
                        }
                      },
                      error:function(error){
                        console.log(error)
                        toastr.error('',"Cannot updated");
                      }
                  });
          });

                $('#patient_detail').submit(function (event) {
                    console.log("herere2");


                    if (!$(this).valid()) {
                        console.log("herere3");
                        $('#enrollPatient1').removeAttr("disabled");
                        return false;
                    }
                    $('.loader').show();
                    $('#enrollPatient1').attr("disabled", "disabled");
                    event.stopImmediatePropagation();
                    event.preventDefault();
                    var practice = $(this).serializeArray();
                    var postData = new FormData();
                    $.each(practice, function (i, val) {
                        console.log(val);
                        if (val.name == "MobileNumber") {
                            var newStr = val.value.replace(/[- )(]/g, '');
                            val.value = newStr;
                        }
                        if (val.name == "BirthDate") {
                            // var newDob = val.value.replace(/[/]/g,'-');
                            // var date = new Date(newDob);
                            var dateAr = val.value.split('/');
                            var newDate = dateAr[2] + '-' + dateAr[0] + '-' + dateAr[1];
                            // console.log(newDob);
                            console.log(newDate);
                            val.value = newDate;
                        }
                        postData.append(val.name, val.value);
                    });

                    $.ajax({
                        url: "{{url('/patient')}}",
                        method: 'post',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: postData,
                        async: true,
                        success: function (result) {
                            if ($.isEmptyObject(result.error)) {
                                $('#enrollPatient1').attr('disabled', "disabled");
                                $('#patient_detail').find('input').attr('disabled',"disabled");
                                $('#patient_detail').find('select').attr('disabled', true);

                                $('#patient_detail').find('input[type="radio"]').attr('disabled', "disabled");
                                $("#dobpicker").attr('disabled', 'disabled');
                                if(!result.status){
                                    toastr.error('', result.message);
                                    $('#enrollPatient1').removeAttr("disabled");
                                    $('#patient_detail').find('input').removeAttr('readonly');
                                   $('#patient_detail').find('select').removeAttr('disabled');

                                    return false;
                                }
                                if (result.enrollment) {
                                    $('#notEnrollmentMessage1').hide();
                                    $('#enrollmentMessage1').show();
                                    $('.loader').hide();
                                    toastr.success('', result.message);
                                    $(this).parents('form').find('input').attr("disabled", "disabled");
                                    console.log("result ",result)
                                    if (result.patient) {
                                        var gender;
                                        if (result.patient.Gender == 'M') {
                                            gender = '(M)';
                                        } else {
                                            gender = '(F)';
                                        }
                                        $('#patienData').html($("input[name=FirstName]").val() + ' ' + $("input[name=LastName]").val() + ' ' + gender + ' ' + $("input[name=BirthDate]").val());
                                        setTimeout(function () {
                                            $('#enrollmentMessage1').hide();
                                            $('#PatientId').val(result.patient.Id);
                                            // $('#orderForm').show();
                                            if($('#pracId').length)
                                            {
                                            	var selectedPhar=$('#pracId :selected').text().toUpperCase().replace(/PHARMACY/g, '');
                                            	console.log("slec ",selectedPhar);
                                            	$('#pharmacy-txt').text(selectedPhar + " PHARMACY");
                                            }
                                            $('#showPrescription').show();
                                        }, 2000);

                                        //means patient succussfully enrolled show edit icon
                                        $('#editIcon').show();
                                        $('#patient_detail').append('<input type="hidden" name="PatientId" value='+result.patient.Id+'>');
                                    }

                                }
                            } else {
                                $('.loader').hide();
                                //              toastr.error('Danger', 'Patient could not be enrolled');
                                // printErrorMsg(result.error);
                                $('#enrollPatient1').removeAttr("disabled");
                                $('#patient_detail').find('input').removeAttr('readonly');
                             $('#patient_detail').find('select').removeAttr('disabled');
                            }

                            // $('.alert').show();
                            // $('.alert').html(result.success);
                        },
                        error: function (data) {
                            $('.loader').hide();
                            $('#enrollPatient1').removeAttr("disabled");
                            $('#patient_detail').find('input').removeAttr('readonly');
                                   $('#patient_detail').find('select').removeAttr('disabled');
                            toastr.error('error', 'Something went wrong');
                            console.log(data)
                        }
                    });
                    // return false;
                });


            // $('input[name="MobileNumber"]').usPhoneFormat();
            jQuery.validator.addMethod("validate_email", function (value, element) {
                // if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,4})+$/.test(value))
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(value) && value.length <= 30 ) {
                    return true;
                } else {
                    return false;
                }
            }, "Please enter a valid email address.");

            $.validator.addMethod("minAge", function (value, element, min) {
                var today = new Date();
                var birthDate = new Date(value);
                var age = today.getFullYear() - birthDate.getFullYear();

                if (age > min + 1) {
                    return true;
                }

                var m = today.getMonth() - birthDate.getMonth();

                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age >= min;
            }, "You are not old enough!");

            $('#enrollmentMessage1').hide();

            var minChar = 14;
            $('#patient_detail').validate({
                rules: {
                    BirthDate: {
                        required: true, minAge: 16
                    },
                    EmailAddress: {
                        required: true, email: true, minlength: 5, maxlength: 100, validate_email: true,
                        remote: {
                            url: "{{route('check-email')}}",
                            method: 'post',
                            async: false
                        }
                    },
                    ZipCode: {
                        required: true, minlength: 5, maxlength: 10
                        //  remote: {
                        //     url: "{{route('check-zip')}}",
                        //     method: 'post',
                        // }
                    },
                    MobileNumber: {
                        required: true, minlength: minChar, remote: {
                            url: "{{route('check-phone')}}",
                            method: 'post',
                            async: false,
                            data: {
                                MobileNumber: function () {
                                    var newStr1 = $("#mobilePhone").val().replace(/[- )(]/g, '');
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
                        remote: "MobileNumber Already Exist",
                           minlength: function () {
                              return [
                                'Please Enter Min 10 digits'];
                            // return [
                            //     (minChar - parseInt($('#mobilePhone').val().length)) +
                            //     ' more characters to go.'];

                        }
                    },
                    ZipCode: {
                        // remote: "Please Enter Valid Zip Code",
                        minlength: "Please Enter At Least 5 digits.",
                        maxlength:  "Please Enter At Least 9 digits."
                    }, BirthDate: {
                        minAge: "Age must be equal or greater than 16 years"
                    }
                }
            });


            function printErrorMsg(error) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(error, function (key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }

            var backDate=new Date().setFullYear(new Date().getFullYear() - 16);
            var n=new Date (backDate);

            $("#dobpicker").datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy',
                startView: 2,
                // startDate:new Date(n.getFullYear(), n.getMonth(), n.getDate()),
                endDate:new Date(n.getFullYear(), n.getMonth(), n.getDate()),
                 orientation: "bottom",

                defaultViewDate: new Date(n.getFullYear(), n.getMonth(), n.getDate())
            });
            $('#dobpicker').datepicker('setDate', new Date(n.getFullYear(), n.getMonth(), n.getDate()));
            $('#dobpicker').val('');

              $('#pracId').select2();
        });

</script>
@endsection
