@extends('layouts.compliance_survey')

@section('content')

<style>

.container.full_width { min-width: 100%;max-width: 100%;padding-left: 0px;padding-right: 0px; }

.container.survey_container { min-width: 100%;max-width: 100%; }

.select2-container--default .select2-selection--single {
    border: solid 1px #3e7bc4 !important;
    border-radius: 6px;
    height: 32px;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder,
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 30px;
    color: #3e7bc4 !important;
    font-weight: 600;
    text-transform: uppercase;
}

.select2-container--default .select2-results>.select2-results__options
{
    color: #3e7bc4 !important;
    text-transform: uppercase;
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    margin-top: 5px;    
}


.form-wrap.form-builder .stage-wrap.empty:after {
    content: 'Click a field from left to add this area.' !important;
}

.loader {
    border: 5px solid #f3f3f3;
    -webkit-animation: spin 1s linear infinite;
    animation: spin 1s linear infinite;
    border-top: 5px solid #555;
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}




</style>


<div class="row">

	<div class="col-sm-12">


        <div class="row bg-gray-f2">
        	<div class="col-sm-12">
        		<div class="container">
        			<h4 class="wd-100p cnt-left fs-18_ pt-8_ pb-7_ mb-3_ txt-blue weight_600">Selection Criterion:</h4>
        		</div>
        	</div>
        </div>
        
        <div class="row bg-gray-f2">
            <div class="col-sm-12" >
				<div class="container">
        				
    				<div class="flx-justify-start compliance-form_ mb-14_" style="align-items: flex-end;">
    					
    					<div class="field wd-19p mr-1p">
    						<select class="wd-100p tt_uc_ txt-blue weight_600" name='practice_type' id='practice_type'>
                                                    <option value="">Select Practice Type</option>
                                                    @foreach($practices as $practice)
                                                        <option value="{{$practice->practice_type}}">{{$practice->practice_type}}</option>
                                                    @endforeach
    						</select>
    					</div>
    					
    					<div class="field wd-19p mr-1p">
    						<select class="wd-100p tt_uc_ txt-blue weight_600" name='practice_name' id='practice_name'>
                                                    <option value="">Select Practice Name</option>
                                                </select>
    					</div>
    					
    					<div class="field wd-19p mr-1p">
                                                <select class="wd-100p tt_uc_ txt-blue weight_600" name='drug_name' id='drug_name'>
                                                </select>
    					</div>
    					
    					<div class="field wd-19p mr-1p">
    						<select class="wd-100p tt_uc_ txt-blue weight_600" name='drug_marketer' id='drug_marketer'>
                                                </select>
    					</div>
    					
    					<div class="field wd-20p">
                                                <select class="wd-100p tt_uc_ txt-blue weight_600" name='minor_theraputic' id='minor_theraputic'>
                                                </select>
    					</div>
    					
    				</div>
    				
				</div>
			</div>
		</div>
		
		
		
        
        
        
    <!--    <div class="row bg-gray-f2">
        	<div class="col-sm-12">
        		<div class="container">
        			<h4 class="wd-100p cnt-left fs-18_ pt-8_ pb-7_ mb-3_ txt-blue weight_600">Simple Attrbiutes:</h4>
        		</div>
        	</div>
        </div> -->
    	
		<div class="row bg-gray-f2">
			<div class="col-sm-12">
				<div class="container">
        				
    				<div class="flx-justify-start compliance-form_ mb-14_" style="align-items: flex-end;">
    					
    					<div class="field wd-19p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Rx Selection:</label>
                                                <select class="wd-100p tt_uc_ txt-blue weight_600" name='rx_number' id='rx_number'>
                                                </select>    					
    					</div>
    					
    					<div class="field wd-19p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Refills Remaining:</label>
    						<select class="wd-100p tt_uc_ txt-blue weight_600" name='refills_remaining' id='refills_remaining'>
                                                </select>
    					</div>
    					
    					<div class="field wd-19p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Missed Refills:</label>
    						<select class="wd-100p tt_uc_ txt-blue weight_600" type="text">
    							<option>Completed 1+ Activities</option>
    							<option>Completed 1+ Activities1</option>
    							<option>Completed 1+ Activities2</option>
    						</select>
    					</div>
    					
    					<div class="field wd-19p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Sales Dimensions:</label>
    						<select class="wd-100p tt_uc_ txt-blue weight_600" type="text">
    							<option>All Rxs</option>
    							<option>All Rxs1</option>
    							<option>All Rxs2</option>
    						</select>
    					</div>
    					
    					<div class="field wd-20p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Prescriber Name:</label>
                                                <select class="wd-100p tt_uc_ txt-blue weight_600" name='prescriber_name' id='prescriber_name'>
                                                </select>
    					</div>
    					
    				</div>
        				
				</div>
			</div>
		</div>
		
		<div class="row bg-gray-f2">
			<div class="col-sm-12">
				<div class="container">
					<div class="flx-justify-start  mb-14_">
    					<button type="button" id="search_patients" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">search patients</button>
                                        &nbsp;&nbsp;&nbsp;<button type="button" href="javascript:void(0)" onclick='sendTestSurvey();' class="btn bg-wht-txt-red weight_500 fs-14_ tt_uc_">Send Test Survey</button>
                                        &nbsp;&nbsp;&nbsp;<button id="form-preview" class="btn btn-warning">Survey Preview</button>
    				</div>
    			</div>
    		</div>
    	</div>
    	
    	
    	
    	<div class="row bg-white">
			<div class="col-sm-12">
				<div class="container">                                    
                	<div class="row mt-20_ mb-17_ pr-14_ pl-14_">
                            <div class="loader" id="toggle_loader"  style="display: none; float: none; margin: 0px auto; margin-bottom: 17px; "></div>
                            <div class="col-sm-12 pr-0 pl-0 table-responsive">
                            <table class="table reports-bordered mb-4_" id="data_table" style="min-width:1024px;">
                                <thead>
                                    <tr>
                                        <th class="bg-gray-1 txt-wht" style="min-width: 93px !important;">Select All &nbsp; <input type="checkbox" name='toggle_all' value="1" id='toggle_all'></th>
                                        <th class="bg-blue txt-wht" style="min-width: 100px;">Patient Name</th>
                                        <th class="bg-gr-bl-dk txt-wht" style="background-color: #076678;">Practice</th>
                                        <th class="bg-gray-1 txt-wht">Patient Email</th>
                                        <th class="bg-orage txt-wht" style="background-color: #427b58;">DOB</th>
                                        <th class="bg-grn-lk txt-wht">Phone</th>
                                        <th class="bg-gray-80 txt-wht">Gender</th>
                                        <th class="bg-red-dk txt-wht" >Zip</th>
                                    </tr>
                                </thead>
                                <tbody id='patient_records'>
                                    <tr id='empty_row'><td colspan="8" align='center'><b id='style_content'>No patient selected!</b></td></tr>                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row bg-white">
			<div class="col-sm-12">
				<div class="container">
        
                    <div class="flx-justify-start  mb-24_">
                        <input type="hidden" name="hidden_patients" id="hidden_patients" value="">
                        <input type="hidden" name="survey_id" id="survey_id" value="{{$survey->id}}">
                        <input type="hidden" name="question_details" id="question_details" value="{{$survey->details}}" >
                        <button id="back" class="btn btn-warning">Back</button>&nbsp;
                        <button id="cancel_btn" type="button" class="btn bg-wht-txt-red weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
                    	<button type="button" id="send_survey" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">send survey</button>
                    </div>
                </div>
            </div>
        </div>        
		@include('survey.modal')
	</div>
</div>
@endsection

@section('script')
    <script src="{{url('/js/form-render.min.js')}}"></script> 
    <script src="{{url('/js/control_plugins/starRating.js')}}"></script> 
<!--    <script src="{{url('/js/jquery/jquery.modal.min.js')}}"></script>
    <link href="{{ asset('css/jquery.modal.min.css') }}" rel="stylesheet" type="text/css" />--> 
    @php $header_image_path = (!empty($theme->header_image)?"/images/".$theme->header_image:''); @endphp
<script>
        var HeaderImgPath = '{{$header_image_path}}';
        console.log("PTH:"+HeaderImgPath);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        back = document.getElementById('back');
        
        back.onclick = function(){
            window.location.href = "{{ url('/survey/'.$survey->id) }}";
        };
            
        $("#practice_name").prop('disabled', true);    
        $("#practice_type").on('change',function() {
            var ptype = this.value;
            
            if(ptype != "")
            {
                $("#practice_name").prop('disabled', false);            
                 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                 
                $("#practice_name").select2({
                    placeholder: {
                        id: '-1', // the value of the option
                        text: 'Select Practice Names.'
                    },
                    minimumInputLength: 2,
                    allowClear: true,
                    ajax: { 
                      url: "{{url('/get-pracatices')}}",
                      type: "post",
                      dataType: 'json',
                      delay: 250,
                      data: function (params) {
                        return {
                          _token: CSRF_TOKEN,
                          search: params.term, // search term
                          ptype : $("#practice_type option:selected").val()
                        };
                      },
                      processResults: function (response) {
                        return {
                          results: response
                        };
                      },
                      cache: true
                    }

                  });
                
            }else{
                 $("#practice_name").prop('disabled', true);
            }
        }); 
        
        $("#drug_name").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Drug Names.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-drugs')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
    
        $("#drug_marketer").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Drug Marketer.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-marketer')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
    
        $("#minor_theraputic").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Minor Theraputic.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-minor-theraputic')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
        
        $("#prescriber_name").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Prescriber Name.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-prescriber')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
        
        $("#rx_number").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Rx Number.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-rxno')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
        
        $("#refills_remaining").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Refills Remaining.'
            },
            minimumInputLength: 1,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-refills')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
        
        
         $("#phone_number").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Phone Number.'
            },
            minimumInputLength: 1,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-phonenumbers')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });

        $("#search_patients").click(function(){
            var practiceType = $("#practice_type option:selected").val(); //string value
            var practiceName = $("#practice_name option:selected").val(); //int value
            var drugName = $("#drug_name option:selected").val(); //int value
            var drugMarketer = mTrim($("#drug_marketer option:selected").val()); //string value            
            var minorTheraputic = mTrim($("#minor_theraputic option:selected").val()); //string value
            var rxNumber = mTrim($("#rx_number option:selected").val()); //string value
            var refillsRemaining = mTrim($("#refills_remaining option:selected").val()); //string value
            var prescriberName = mTrim($("#prescriber_name option:selected").val()); //string value
            $("#search_patients").prop('disabled', true);      
            $("#send_survey").prop('disabled', true);      

            $("#empty_row").hide();
            $("#patient_records").html('<tr id="loader_row"><td colspan="8" align="center"><div class="loader"></div></td></tr>');
            
            
            $.ajax({
                type:'POST',
                url:"{{url('/get-patient-records')}}",
                data: 'practice_type='+practiceType.trim()+'&practice_name='+practiceName+'&drug_name='+drugName+'&drug_marketer='+drugMarketer+'&minor_theraputic='+minorTheraputic+'&rx_number='+rxNumber+'&refills_remaining='+refillsRemaining+'&prescriber_name='+prescriberName,
                success:function(data) {
                    /*$("#patient_records").html(data);*/
                    
                    if(data != ""){
                        var table = $('#data_table').DataTable({
                            destroy: true,
                            searching: false,
                            "pagingType": "full_numbers",
                            "iTotalRecords": data.total,
                            "iTotalDisplayRecords": 10,
                            "sEcho":10,
                            "aaData" : data.data,
                            "aoColumnDefs":[{
                                    'targets': 0,
                                    'searchable': false,
                                    'orderable': false,
                                    'className': 'dt-body-center',
                                    'render': function (data, type, full, meta){
                                        return '<input type="checkbox" name="patientId[]" class="checkbox" value="'+data+'">';
                                    }
                                },{
                                    "aTargets":[ 1 ],
                                    "className": "bg-tb-blue-lt2 txt-blue cnt-left"
                                },{
                                    "aTargets":[ 2 ],
                                    "className": "bg-gray-e txt-blue cnt-left"
                                },{
                                    "aTargets":[ 3 ],
                                    "className": "bg-tb-wht-shade2 txt-gray-6 cnt-left"
                                },{
                                    "aTargets":[ 4 ],
                                    "className": "bg-tb-orange-lt txt-gray-6"
                                },{
                                    "aTargets":[ 5 ],
                                    "className": "bg-grn-lk2 txt-gray-6"
                                },{
                                    "aTargets":[ 6 ],
                                    "className": "bg-gray-e txt-blue weight_600 cnt-left"
                                },{
                                    "aTargets":[ 7 ],
                                    "className": "bg-tb-pink2 txt-red cnt-center"
                                }],
                                select: {
                                    style: 'os',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ]
                        });    
                        
                        $('#toggle_all').on('click', function(){
                            var rows = table.rows({ 'search': 'applied' }).nodes();
                            $('input[type="checkbox"]', rows).prop('checked', this.checked);
                            
                            var selected = [];
                            var rowcollection =  table.$(".checkbox:checked", {"page": "all"});
                            rowcollection.each(function(index,elem){
                                selected.push($(elem).val());
                            });
                            console.log(selected);
                            $("#hidden_patients").val(selected);
                        });
                        
                        $('#data_table tbody').on('change', 'input[type="checkbox"]', function(){
                            if(!this.checked){
                               var el = $('#toggle_all').get(0);
                               if(el && el.checked && ('indeterminate' in el)){
                                  el.indeterminate = true;
                               }
                            }
                            
                            var selected = [];
                            var rowcollection =  table.$(".checkbox:checked", {"page": "all"});
                            rowcollection.each(function(index,elem){
                                selected.push($(elem).val());
                            });
                            console.log(selected);
                            $("#hidden_patients").val(selected);
                        });
                         
                    }else
                        $("#patient_records").html('<tr id="empty_row"><td colspan="8" align="center"><b style="color:red;">No patient selected!</b></td></tr>');
                    
                         
                    $("#search_patients").prop('disabled', false);      
                    $("#send_survey").prop('disabled', false);      
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
             });
             
        });
        
        $("#send_survey").on('click',function(){
            if(validatePatients())
            {
                /*var selected = [];
                $.each($("input[name='patientId[]']:checked"), function(){
                    selected.push($(this).val());
                });*/
                var selected = $("#hidden_patients").val();
                $("#search_patients").prop('disabled', true);      
                $("#send_survey").prop('disabled', true);   
                $("#toggle_loader").show();

                $.ajax({
                type:'POST',
                url:"{{url('survey/send-survey')}}",
                data: 'survey_id='+$("#survey_id").val()+'&patients='+selected,
                success:function(data) {
                    
                        if(data == 1){
                            $('#survey_success').modal('show');                          
                        }else
                           $('#survey_failure').modal('show');

                        $("#search_patients").prop('disabled', false);      
                        $("#send_survey").prop('disabled', false);      
                        $("#toggle_loader").hide();

                    },
                     headers: {
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                
                //alert("Survey Sent");
            }
        });
        
        $("#cancel_btn").click(function(){
            window.location = "{{ url('/survey') }}";//here double curly bracket
        });
   
        /*$("#toggle_all").change(function(){  //"select all" change 
            var status = this.checked; // "select all" checked status
            $('.checkbox').each(function(){ //iterate all listed checkbox items
                    this.checked = status; //change ".checkbox" checked status
            });
        });*/

        function validatePatients(){
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
            if(checkboxes.length == 0){
                alert("Please select at least one patient to send survey.");
                return false;
            }            
            return true;
        }
        
        jQuery(function($) {
            formPreview = document.getElementById('form-preview');
            formPreview.onclick = function (){
                showPreview();
            };
             
            function showPreview(formData) {
                var formData =  $('#question_details').val();
                 let formRenderOpts = {
                    dataType: 'json',
                    formData
                  };
                  let $renderContainer = $('<form/>');
                  $renderContainer.formRender(formRenderOpts);
                  let html = `<!doctype html><title>Form Preview</title><body class="container bg-white">`;
                      if(HeaderImgPath != "")
                        html += `<div style="text-align:center;"><img src="{{ !empty($header_image_path)? url($header_image_path): ''}}" style="max-width: 200px; margin:20px 0px;"></div>`;
                    html += `<div class="trow_ cnt-center c-dib_ mt-14_ mb-14_"><span class="fs-24_ pa-4_ tt_cc_ txt-grn-lt weight_600 br-top-blue-w1 br-bottom-blue-w1 pl-2_ pr-2_">{{$survey->title}}</span>`;
                    html += `</div><span class="fs-17_ tt_cc_ txt-blue weight_600" style="text-align:center;">{{isset($theme->header_text)?$theme->header_text:''}}</span>`;
                    //html += `<div class="trow_ cnt-center c-dib_ mt-24_ mb-14_"><span class="fs-17_ tt_cc_ txt-blue weight_600">This is the first activity to fulfill your obligation in Compliance Reward. Please provide feedback about your experience.</span></div>`;
                    html += `<hr>${$renderContainer.html()}<h4 style="text-align:center; color:blue;">{{isset($theme)?$theme->footer_text:''}}</h4><div class="trow_ mt-14_">`;
                    html += `<button class="wd-100p btn bg-yellow-txt-gray weight_600 fs-17_ tt_uc_ pa-12_ mb-7_ cnr-center " style="line-height: 14px;">submit questionnaire</button>`;
                    html += `</div></body></html>`;
                  var formPreviewWindow = window.open('', 'formPreview', 'height=550,width=500,padding=20,toolbar=no,scrollbars=yes');

                  formPreviewWindow.document.write(html);
                  var style = document.createElement('link');
                  style.setAttribute('href', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
                  style.setAttribute('rel', 'stylesheet');
                  style.setAttribute('type', 'text/css');
                  formPreviewWindow.document.head.appendChild(style);
                  
                  var style1 = document.createElement('link');
                  style1.setAttribute('href', "{{ asset('css/generic-survey-mobile.css') }}");
                  style1.setAttribute('rel', 'stylesheet');
                  style1.setAttribute('type', 'text/css');
                  formPreviewWindow.document.head.appendChild(style1);
            }            
        });
        
        function sendTestSurvey(){
            $('#test_survey_modal').modal('show');
        }
        
        $("#send_test_survey").click(function(){
            if($("#phone_number").val() == "")
                $("#error_phone_number").show(); 
            else{
                $("#error_phone_number").hide(); 
                $('#test_survey_modal').modal('hide');
                $("#toggle_loader").show();
                
                    var selected = [];
                    selected.push($("#phone_number option:selected").val());
                    
                    $.ajax({
                    type:'POST',
                    url:"{{url('survey/send-survey')}}",
                    data: 'survey_id='+$("#survey_id").val()+'&patients='+selected,
                    success:function(data) {

                            if(data == 1){
                                $('#survey_success').modal('show');                          
                            }else
                               $('#survey_failure').modal('show');
                           
                           $("#toggle_loader").hide();
                        },
                         headers: {
                             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
            }

        });
        
        function mTrim(x) {
            if(x != null && x != "" && x != 'undefined')
                return x.trim();
            else
                return x;
        }

</script>
@endsection


















