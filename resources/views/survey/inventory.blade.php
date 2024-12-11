@extends('layouts.compliance_survey')

@section('content')

<style>
.container.full_width { min-width: 100%;max-width: 100%;padding-left: 0px;padding-right: 0px; }

.container.survey_container { min-width: 100%;max-width: 100%; }


.file-upload {
  background-color: #ffffff;
  width: 600px;
  margin: 0 auto;
  padding: 0 20px;
}

.file-upload-btn {
  width: 100%;
  margin: 0;
  color: #fff;
  background: #1FB264;
  border: none;
  padding: 10px;
  border-radius: 4px;
 /* border-bottom: 4px solid #15824B;*/
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.file-upload-btn:hover {
  background: #1AA059;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.file-upload-btn:active {
  border: 0;
  transition: all .2s ease;
}

.file-upload-content {
  display: none;
  text-align: center;
}

.file-upload-input {
  position: absolute !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;
  height: 100% !important;
  outline: none !important;
  opacity: 0 !important;
  cursor: pointer !important;
}

.image-upload-wrap {
  margin-top: 20px;
  border: 2px dashed #1FB264;
  position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
  background-color: #1FB264; 
  border: 2px dashed #ffffff;
}

.image-title-wrap {
  padding: 0 15px 15px 15px;
  color: #222;
}

.drag-text {
  text-align: center;
}

.drag-text h3 {
  font-weight: 100;
  text-transform: uppercase;
  color: #15824B;
  padding: 60px 0;
}

.file-upload-image {
  max-height: 200px;
  max-width: 200px;
  margin: auto;
  padding: 20px;
}

.remove-image {
  width: 200px;
  margin: 0;
  color: #fff;
  background: #cd4535;
  border: none;
  padding: 10px;
  border-radius: 4px;
 /* border-bottom: 4px solid #b02818;*/
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.remove-image:hover {
  background: #c13b2a;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.remove-image:active {
  border: 0;
  transition: all .2s ease;
}
</style>

<div class="row">

	<div class="col-sm-12">


        <div class="row bg-gray-f2">
        	<div class="col-sm-12">
        		<div class="container">
        			<h4 class="wd-100p cnt-left fs-20_ pt-14_ pb-7_ mb-3_ txt-blue weight_600">Survey List:</h4>
        		</div>
        	</div>
        </div>
        
    	
    	
    	<div class="row bg-white">
			<div class="col-sm-12">
				<div class="container">
                	<div class="row mt-24_ mb-17_ pr-14_ pl-14_">
                        <div class="col-sm-12 pr-0 pl-0 table-responsive">
                            
                            <table class="table reports-bordered mb-4_" id="data_table" style="min-width:1024px;">
                                <thead>
                                    <tr>
                                        <th class="bg-gr-bl-dk txt-wht">#</th>
                                        <th class="bg-blue txt-wht" style="min-width:200px;">Survey Title</th>
                                        <th class="bg-gr-bl-dk txt-wht" >Category\ Folder</th>
                                        <th class="bg-orage txt-wht"  >Created By</th>
                                        <th class="bg-gray-1 txt-wht" style="width:80px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>     
                                    @foreach($surveys as $survey)
                                        <tr><td class="bg-gray-e txt-blue cnt-center">{{$survey->id}}</td>
                                        <td class="bg-tb-wht-shade2 txt-blue cnt-left"><a href="{{ url('/survey/'.$survey->id) }}">{{$survey->title}}</a></td>  
                                        <td class="bg-tb-blue-lt2 txt-blue cnt-left">{{$survey->Category->title}}</td>  
                                        <td class="bg-gray-e txt-blue cnt-left">{{(isset($survey->User)?$survey->User->name:"")}}</td>
                                        <td class="bg-grn-lk2 txt-gray-6 cnt-center"><a href="{{ url('/survey/'.$survey->id) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a onclick="return confirm('Are you sure you want to delete this survey?');" href="{{ url('/survey/delete-survey/'.$survey->id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
										
										<a class="elm-right txt-blue no-wrap-text c-dib_" href='javascript:void(0)' onclick="sendSurvey({{$survey->id}});" ><i style="color:green;" title="Import patients for sending survey" class="fa fa-file-excel-o" aria-hidden="true"></i></a>
										</td>
										</tr>
                                    @endforeach
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		
	</div>
</div>

<!------------ Import Patient list for sending survey ---------->
 <div class="modal" id="survey-import-patient-list">
    <div class="modal-dialog wd-87p-max_w_700" style="max-width:630px !important;">
      <div class="modal-content compliance-form_" >

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title txt-wht">Import Patient List</h4>
          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
          <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">X</button>
         
        </div>
        <form  novalidate="novalidate" action="javascript:void(0);" id="survey_patient_import_form"  method="post" >
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                <span class="site-red-color fs-14_ all-order-error" style="display: none;font-weight: bold;"> Please fill required fields </span>
            </div>
            </div>
                    <div class="row">
                        <div class="col-sm-12">
                        <div id="form_raw_data"></div>
                        

                       <div class="file-upload">
                            <button class="file-upload-btn" style="display: none;" type="button" onclick="$('#survey-import-patient-list .file-upload-input').trigger( 'click' )">Add Excel File</button>
                            <a href="{{ url('/templates/survey-patients-template.xlsx')  }}" target="_blank">Download Sample Template</a>
                            <label id="error_msg_show" class="error" style="display:none;">This field is required.</label>
                            <div class="image-upload-wrap">
                              <input type="hidden" name="survey_id" id="survey_id" value=""/>
                              <input name="import_file" id="import_file" class="file-upload-input" type='file' onchange="readURLSurveyPatients(this);" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                              <div class="drag-text">

                              <h3>Drag & drop/ Select an excel file</h3> 
                              </div>
                            </div>
                            <div class="file-upload-content">
                                <span class="file-upload-image fa fa-file-excel-o" id="uploaded_file"  ></span>
                              <div class="image-title-wrap">
                                 <button type="button" onclick="removeUpload();" class="remove-image">Remove</button>
                              </div>
                            </div>
                          </div>                         

                        </div>
                    </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
                <div class="flx-justify-start wd-100p">
                  <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_" data-dismiss="modal">Cancel</button>
                  <!-- <button type="button" id="undo_btn" onclick="" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button> -->
                  <button id="submitPatientImport" onclick="import_patients()" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">Import & Send Survey</button>
              </div>
        </div>

      </form>
    </div>
    </div>
  </div>
<!---------------------Survey Import End ----------------------->

@endsection


@section('script')
  <script>
        
          
    $("#back").click(function(){
        window.location.href = "{{ url()->previous() }}";
    });
   
    $("#save_btn").click(function(){        
          $("#question_form").submit();
    });
    
    $('#data_table').DataTable({
        pagingType: "full_numbers",
        processing: false,
        serverSide: false,
        Paginate: false,
        lengthChange: false,
        pageLength : 10,
        order:[],
        bFilter: false,
        columnDefs: [
                    { targets: 'no-sort', orderable: false }
                  ]
    });
    

   function sendSurvey(Id)
  {
    $('#survey_id').val(Id);
	$('#import_file').val("");
	$('#survey-import-patient-list .image-upload-wrap').show();
	$('#survey-import-patient-list .file-upload-image').html("");
	$('#survey-import-patient-list .file-upload-content').hide();	 
    $('#survey-import-patient-list').modal('show');
  } 

	function readURLSurveyPatients(input) 
	{
        var $preview =  $('#survey-import-patient-list .file-upload-image');
        console.log(input);
        console.log(input.files);

       var _URL = window.URL || window.webkitURL;
       if (input.files && input.files[0]) {
			var _validFileExtensions = ["xls", "xlsx"];
			var ext=input.files[0].name.split('.').pop();
			if(_validFileExtensions.includes(ext.toLowerCase()))
			{
				var files = input.files;
				var fileReader = new FileReader();
				console.log('outside on load');

				fileReader.onload = function(e){
					console.log(e);
					$('#survey-import-patient-list .image-upload-wrap').hide();
					$('#survey-import-patient-list .file-upload-image').html(files[0].name);
					$('#survey-import-patient-list .file-upload-content').show();
					console.log('inside on load');

					$preview.on('click',function(){
						  console.log('hit click event');
						  //window.location.href=e.target.result;
					});
					//$preview.attr("href", e.target.result);
					$preview.show();
				};
				fileReader.readAsDataURL(files[0]);
			}else{
			  toastr.error("Only file extensions (xls and xlsx) are allowed.");
			}
		} 
		else {
			 removeUpload();
		}
    }
	
	function import_patients()
  {
    $('#toast-container').remove();
    $('.file-upload-btn,.remove-image').hide();
        var formData = new FormData($('form#survey_patient_import_form')[0]);
        $('#submitPatientImport').prop('disabled', true);

        $.ajax({
            url:"{{ url('import/survey-patients') }}",
            data: formData,
            type:"POST",
            cache: false,
            contentType: false,
            processData: false,
            error:function(err){
                console.error(err);
                $('#submitPatientImport').prop('disabled', false);
                $('#loading_small_login').hide();
            },

            success:function(data){
				if(data.status){
					toastr.success(data.message);				          
				}else{
					/*var str='';
					$.each(data.error,function(k,value){                
						var keys=Object.keys(value);                
						keys.forEach(function(key){                  
							value[key].forEach(function(v){
							console.log(v)
							str+=v+ '<br />'
							});                  
						});
					});   */           
              toastr.error("No patient record found or there is some template mismatch.");
            }
					$('#import_file').val("");
					$('#survey-import-patient-list .image-upload-wrap').show();
					$('#survey-import-patient-list .file-upload-image').html("");
					$('#survey-import-patient-list .file-upload-content').hide();	  
		},
            complete:function(){
                console.log("Request finished.");
                $('#submitPatientImport').prop('disabled', false);
                $('.remove-image').show();
            },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });

    }

  function removeUpload() 
  {
    $('#import_file').val("");
    $(".file-upload-btn").hide();
    $('#survey-import-patient-list .image-upload-wrap').show();
    $('#survey-import-patient-list .file-upload-image').html("");
    $('#survey-import-patient-list .file-upload-content').hide();	  
  }
 
   </script>
    
  @endsection
















