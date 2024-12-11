@extends('layouts.compliance_survey')

@section('content')


<div class="row">
	<div class="col-sm-12">
		<div class="trow_" style="background-color: #f2f2f2; padding: 14px 0px;">
			<h4 class="wd-100p cnt-center fs-24_ mb-3_ txt-blue weight_600">Create New Survey</h4>
		</div>
	</div>
</div>

<div class="row mt-24_">

	<div class="col-sm-12">
		
		<div class="row">
                    <div class="col-sm-1">&nbsp;</div>
			<div class="col-sm-10">
                                    <form class="compliance-form_" method="POST"  action="{{ url('/survey') }}" id='survey_form' >
    				@csrf
    				<div class="flx-justify-start  mb-24_" style="align-items: flex-end;">
    					<div class="field wd-100p mr-7_" style="max-width: 240px;">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Survey Name:</label>
                                                <input class="wd-100p" type="text" value="{{Request::session()->get('survey_name')}}" placeholder="" maxlength="30" name="survey_name" id="survey_name" required>
                                                <span id='error_survey_name' style='display:none;  color:red;'>Survey name can not be empty.</span>
    					</div>
    					<!-- <button class="btn bg-wht-txt-red weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
    					<button class="btn bg-wht-txt-blue weight_500 fs-14_ tt_uc_">Save</button> -->
    				</div>
    				
    				<div class="flx-justify-start  mb-24_" style="align-items: flex-end;">
    					
    					<div class="field wd-100p mr-7_" style="max-width: 240px;">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Category\ Folder:</label>
                                                <select class="wd-100p" type="text" name="category" id="category" required>
                                                    <option value="">Select Category\ Folder</option>
                                                    @foreach($categories as $id => $category)
                                                        <option <?=(Request::session()->get('category') == $id)?'selected':''?> value="{{$id}}">{{$category}}</option>
                                                    @endforeach    
    						</select>
                                                <span id='error_category' style='display:none; color:red;'>Folder name can not be empty.</span>
    					</div>
    					
    					<div class="field wd-100p mr-7_" style="max-width: 140px;">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Primary Language:</label>
                                                <select class="wd-100p" type="text" name="language">
    							<option value="eng">English</option>
    							<option value="fr">French</option>
                                                        <option value="de">German</option>
    						</select>
    					</div>
    					
    					<div class="field wd-100p ml-14_" style="margin-left: 24px;">
    						<label class="wd-100p cur-pointer mb-0_">
                                                    <input type="checkbox" name="questions_ready" class="large mt-7_" id="question-ready" style="-webkit-appearance: unset; border: 0px;">
    							<span class="txt-blue mt-4_ fs-16_ weight_500">I have questions ready to copy and paste</span>
    						</label>
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
   $("#cancel_btn").click(function(){
       window.location = "{{ url('/survey') }}";//here double curly bracket
   });
   
   $("#save_btn").click(function(){       
        if($("#survey_name").val() == ""){
           $("#error_survey_name").show(); 
        }else if($("#category").val() == ""){
            $("#error_category").show(); 
        }else   
          $("#survey_form").submit();
   });
</script>
@endsection
