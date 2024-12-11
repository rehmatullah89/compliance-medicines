@extends('layouts.compliance_survey')

@section('content')

<style>

.select2-container--default .select2-selection--single {
    border: solid 1px #3e7bc4 !important;
    border-radius: 6px;
    height: 32px;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder,
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 30px;
    font-weight: 600;
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    margin-top: 5px;
}

</style>
<div class="row">
	<div class="col-sm-12">
		<div class="trow_" style="background-color: #f2f2f2; padding: 14px 0px;">
			<h4 class="wd-100p cnt-center fs-24_ mb-3_ txt-blue weight_600">Edit\ Copy Survey</h4>
		</div>
	</div>
</div>

<div class="row mt-24_">

	<div class="col-sm-12">
		
		<div class="row">
                    <div class="col-sm-1">&nbsp;</div>
			<div class="col-sm-10">
                                <form class="compliance-form_" method="POST"  action="{{ url('/survey/edit-copy') }}" id='survey_form' >
                                    @csrf
    				<div class="flx-justify-start  mb-24_" style="align-items: flex-end;">
    					<div class="field wd-100p mr-7_" style="max-width: 240px;">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Survey Name:</label>
                                                <select class="form-control" name="survey_name" id="survey_name" required>
                                                    <option value="">Select Survey</option>
                                                    @foreach($surveys as $survey )
                                                        <option value="{{$survey->id}}">{{$survey->title}}</option>
                                                    @endforeach
                                                </select>
                                                <span id='error_survey_name' style='display:none;  color:red;'>Survey name can not be empty.</span>
    					</div>
    					<!-- <button class="btn bg-wht-txt-red weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
    					<button class="btn bg-wht-txt-blue weight_500 fs-14_ tt_uc_">Save</button> -->
    				</div>
    				
    				<div class="flx-justify-start  mb-24_" style="align-items: flex-end;">
    					
    					<div class="field wd-100p mr-7_" style="max-width: 240px;">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Action:</label>
                                                <select class="wd-100p" type="text" name="edit_type" id="edit_type" required>
                                                    <option value="edit">Edit Survey</option>
                                                    <option value="copy">Copy Survey</option>
                                                </select>
    					</div>
    					
    				</div>
                                    
                                <div id="new_survey_id" class="flx-justify-start  mb-24_" style="align-items: flex-end; display:none;">
    					<div class="field wd-100p mr-7_" style="max-width: 240px;">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">New Survey Name:</label>
                                                    <input class="form-control" type="text" name="new_survey_name" id="new_survey_name" maxlength="30"/>
                                                <span id='error_new_survey_name' style='display:none;  color:red;'>New Survey name can not be empty.</span>
                                                <span id='error_exist_survey_name' style='display:none;  color:red;'>Survey name already taken, Please select another name.</span>
    					</div>
    				</div>
    				
    				<div class="flx-justify-start  mb-24_">
                                        <button id="cancel_btn" type="button" class="btn bg-wht-txt-red weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
    					<button id="save_btn" type="button" class="btn bg-blue-txt-wht weight_500 fs-14_">START</button>
    				</div>
    				
    			</form>
				
			</div>
                    <div class="col-sm-1">&nbsp;</div>
		</div>
	
	</div>
</div>
<script type="text/javascript">
    
    function checkSurveyName(newName)
    {
<?php
        foreach($surveys as $survey ){
?>
        surveyTitle = "<?=$survey->title?>";
            if(newName == surveyTitle)
                return true;
<?php   } ?>
        return false;
    }
    
   $("#cancel_btn").click(function(){
       window.location = "{{ url('/survey') }}";//here double curly bracket
   });
   
   
   $("#edit_type").on('change',function(){       
        if(this.value == 'copy'){
            $("#new_survey_id").show(500);
        }else
            $("#new_survey_id").hide();
   });
   
   $("#save_btn").click(function(){
       var error = false;
        if($("#survey_name").val() == ""){
           $("#error_survey_name").show();
           error = true;
        }else
            $("#error_survey_name").hide(); 
        
        if($("#edit_type option:selected").val() == 'copy' && $("#new_survey_name").val() == ""){
            $("#error_new_survey_name").show(); 
            error = true;
        }else
            $("#error_new_survey_name").hide(); 
        
        if($("#edit_type option:selected").val() == 'copy' && checkSurveyName($("#new_survey_name").val()) == true){
            $("#error_exist_survey_name").show(); 
            error = true;
        }else
            $("#error_exist_survey_name").hide(); 
         
        if(error == false)    
          $("#survey_form").submit();
   });
   
   $('#survey_name').select2({
            tags: true,
            insertTag: function (data, tag) {
            // Insert the tag at the end of the results
            //data.push(tag);
            //console.log(data[0].id);
        }

    });
    
    $('#edit_type').select2({
            tags: true,
            insertTag: function (data, tag) {
            // Insert the tag at the end of the results
            //data.push(tag);
            //console.log(data[0].id);
        }

    });
</script>
@endsection
