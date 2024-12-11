@extends('layouts.compliance_survey')

@section('content')
<div style="display: none;">
<svg display="none">
	
	<symbol width="auto" height="40" viewBox="0 0 576 512" id="comment-box">
  		<path fill="currentColor" d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 7.1 5.8 12 12 12 2.4 0 4.9-.7 7.1-2.4L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64zm32 352c0 17.6-14.4 32-32 32H293.3l-8.5 6.4L192 460v-76H64c-17.6 0-32-14.4-32-32V64c0-17.6 14.4-32 32-32h384c17.6 0 32 14.4 32 32v288zM280 240H136c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h144c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm96-96H136c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h240c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8z" class=""></path>
	</symbol>
	
	<symbol viewBox="0 0 448 512" id="text-box">
		<path fill="currentColor" d="M432 32a16 16 0 0 1 16 16v80a16 16 0 0 1-16 16h-16a16 16 0 0 1-16-16V96H256v336h48a16 16 0 0 1 16 16v16a16 16 0 0 1-16 16H144a16 16 0 0 1-16-16v-16a16 16 0 0 1 16-16h48V96H48v32a16 16 0 0 1-16 16H16a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16z" class=""></path>
	</symbol>
	
</svg>

<style>

.container.full_width { min-width: 100%;max-width: 100%;padding-left: 0px;padding-right: 0px; }

.container.survey_container { min-width: 100%;max-width: 100%; }

svg {
  /*width: 32px;
  height: 32px;
  max-width: 24px;
    max-height: 24px;*/
    fill: currentColor;
    height: 40px;
    width: 40px;
    display: inline-block;
}
svg:hover {
  fill: currentColor;
}


ul#question-type-links {padding: 0px 13px;}
ul#question-type-links li {width: 44%;display: inline-block;margin-right: 2%;margin-left: 2%;margin-bottom: 17px;}
ul#question-type-links li a {position: relative;display: inline-block;padding: 6px 6px;border: solid 1px #dee2e6;width: 100%;min-height: 80px;border-radius: 2px;}
ul#question-type-links li a span.qst_icon { width: 100%; text-align: center; margin-bottom: 6px; }
ul#question-type-links li a span.qst_txt { margin-bottom: 6px; width: 100%; text-align: center; font-weight: 500; color: #242424; }

ul.nav-tabs.question-tabs {width: 100%;}
ul.nav-tabs.question-tabs li {}
ul.nav-tabs.question-tabs li:last-child { margin-right: -1px; }
ul.nav-tabs.question-tabs li a.nav-link { padding: .5rem .7rem; }

.txt-hover-blue:hover * { color: #3e7bc4 !important; }


.radio-button-symbol { width: 40px; height: 40px; position: relative; }
.radio-button-symbol:before { content: ''; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; border: solid 2px; border-color: inherit; border-radius: 50%; }
.radio-button-symbol:after  { content: ''; position: absolute; top: 25%; left: 25%; width: 50%; height: 50%;  border: solid 2px; border-color: inherit; border-radius: 50%; }

#survey_accordian {  }
#survey_accordian .card { margin-bottom: 14px; border: solid 1px #ccc; border-radius: 2px; }
#survey_accordian .card .card-header {  }
#survey_accordian .card .card-header h2 {  }
#survey_accordian .card .card-header h2 .hd-txt {  }
#survey_accordian .card .card-header h2[aria-expanded="false"] .hd-icon:before { content: "\f067"; }
#survey_accordian .card .card-header h2[aria-expanded="true"] .hd-icon:before { content: "\f068"; }


#fb-editor {  }

#fb-editor .form-wrap.form-builder .cb-wrap {display: none;width: 25%;transition: transform 250ms;padding-top: 36px;padding-left: 22px;order: 1;background-color: #f2f2f2;top: auto !important;left: auto !important;right: auto !important;bottom: auto !important;position: relative !important;/* z-index: -100; */ padding-bottom: 24px;}
#fb-editor .form-wrap.form-builder .cb-wrap:before {content: "\f29c";font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;color: #fff;position: absolute;top: 0px;left: 0px;height: 34px;z-index: 999999999999;font-size: 21px;padding: 7px 10px;background-color: #3e7bc4;}
#fb-editor .form-wrap.form-builder .cb-wrap:after {content: "All Question Types";position: absolute;top: 0px;left: 0px;padding: 8px 10px;padding-left: 49px;background-color: #3e7bc4;color: #fff;line-height: 18px;height: 34px;width: 100%;text-align: center;}


#fb-editor .form-wrap.form-builder { position: relative; display: flex; justify-content: flex-end;}
#fb-editor .form-wrap.form-builder .frmb { min-height: 252px; padding: 24px; border-left: solid 1px #cecece; order: 2; position: relative; width: 100%; z-index: 100; }
#fb-editor .form-wrap.form-builder .frmb-control li {cursor: move;list-style: none;margin: 0 0 -1px 0;padding: 10px;text-align: left;background: #fff;
-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;
width: 40%;display: inline-block;margin-right: 2%;margin-left: 2%;margin-bottom: 17px;position: relative;display: inline-block;
padding: 0px;border: solid 1px #dee2e6;min-height: 80px;border-radius: 2px;margin-top: 14px !important;box-shadow: inset 0 0 0 1px #c5c5c5;box-shadow: none;
position: relative;display: inline-flex !important;align-items: flex-end;margin-bottom: 0px !important;}
#fb-editor .form-wrap.form-builder .frmb-control li::before {margin-right: 10px;font-size: 40px;position: absolute;top: 7px;left: 0px;width: 100%;text-align: center;margin: 0px;}
#fb-editor .form-wrap.form-builder .frmb-control li span {width: 100%;display: block;text-align: center;padding-bottom: 4px;font-size: 14px;font-weight: 500;}

ul.frmb stage-wrap pull-right ui-sortable empty{ content: 'left';}
.image-upload > input{ display: none;}
.image-upload img{ width: 80px; cursor: pointer;}


ul#question-type-links li .qst_icon { font: normal normal normal 14px/1 FontAwesome;font-size: 40px;text-rendering: auto;-webkit-font-smoothing: antialiased; }

ul#question-type-links li .icon-select {  }
ul#question-type-links li .icon-select:before { }

ul#question-type-links li .icon-checkbox-group { font: normal normal normal 14px/1 FontAwesome;font-size: 40px;text-rendering: auto;-webkit-font-smoothing: antialiased; }
ul#question-type-links li .icon-checkbox-group:before { content: "\f046"; font: normal normal normal 14px/1 FontAwesome;font-size: 40px;}

ul#question-type-links li .icon-radio-group { width: 40px !important; height: 40px !important; position: relative; }
ul#question-type-links li .icon-radio-group:before { content: '';position: absolute;top: 0px;left: 0px;width: 100%;height: 100%;border: solid 2px;border-color: inherit;border-radius: 50%; margin: 0px;}
ul#question-type-links li .icon-radio-group:after { content: '';position: absolute;top: 25%;left: 25%;width: 50%;height: 50%;border: solid 2px;border-color: inherit;border-radius: 50%; margin: 0px;}

ul#question-type-links li .icon-text {  }
ul#question-type-links li .icon-text:before { font: normal normal normal 14px/1 FontAwesome; font-size: 40px; }

ul#question-type-links li .icon-date { font: normal normal normal 14px/1 FontAwesome;font-size: 40px;text-rendering: auto;-webkit-font-smoothing: antialiased; }
ul#question-type-links li .icon-date:before { content: "\f073"; font: normal normal normal 14px/1 FontAwesome; font-size: 40px; }


ul#question-type-links li .icon-textarea { font: normal normal normal 14px/1 FontAwesome;font-size: 40px;text-rendering: auto;-webkit-font-smoothing: antialiased; }
ul#question-type-links li .icon-textarea:before { font: normal normal normal 14px/1 FontAwesome; font-size: 40px; }

.survey-module ul#question-type-links li a { text-align: center; }
.survey-module ul#question-type-links li a span.qst_txt { margin-top: 4px; margin-bottom: 2px; }


.form-wrap.form-builder .frmb .form-elements .input-wrap .fld-label { line-height: 1em !important; }
.form-wrap.form-builder .frmb .form-elements .input-wrap .fld-label * { line-height: 1em !important; }


.form-wrap.form-builder .frmb label.field-label  { line-height: 1em !important; }
.form-wrap.form-builder .frmb label.field-label  * { line-height: 1em !important; }
.form-wrap.form-builder .frmb li { padding: 17px !important; }

.form-wrap.form-builder .frmb .form-elements .input-wrap>input[type='checkbox'] + label { margin-top: 7px; margin-bottom: 0px; }


</style>
</div>

<div class="row survey-module">

	<div class="col-sm-12">

        <div class="row bg-gray-f2">
        	<div class="col-sm-12">
        		<div class="container">
        			<h4 class="wd-100p cnt-center fs-20_ pt-14_ pb-7_ mb-3_ txt-blue weight_600">{{ucfirst($survey->title)}} Survey</h4>
        		</div>
        	</div>
        </div>
        
        
    	
    	<div class="row bg-white">
            
			<div class="col-sm-12">
                <div class="container" style="padding-right: 30px; padding-left: 30px; max-width: 90%;">
                	
                	<div class="row mt-24_ mb-17_ pr-14_ pl-14_">
                        
                        <div class="col-sm-12 pr-0 pl-0">
                        <form method="POST" id='question_form' action="{{ url('survey/'.$survey->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH')}}
                            <input type="hidden" name="survey_id" id="survey_id" value=" {{$survey->id}}" >
                            <input type="hidden" name="question_details" id="question_details" value="{{$survey->details}}" >
                        	
                        	<div class="trow_ pos-rel" style="padding-left: 300px; min-height: 480px;">
                        		
                        		<div class="pos-abs_" style="position: absolute; top: 0px; left: 0px; width: 270px; min-height: 400px;">
                        		
                                    <ul class="nav nav-tabs question-tabs">
                                        <li class="nav-item wd-100p">
                                        	<a class="nav-link active" data-toggle="tab" href="#question-types"><span class="fa fa-question-circle-o"></span>&nbsp;Question Types</a>
                                        </li>
                                        {{--<li class="nav-item">
                                        	<a class="nav-link" data-toggle="tab" href="#all-question-bank">
                                        		<span class="c-dib_ fs-z_">
                                        			<span class="c-dib_">
                                        			<span class="fs-10_ mt-3_ elm-left fa fa-question"></span>
                                        			<span class="fs-14_ elm-left fa fa-question"></span>
                                        			<span class="fs-10_ elm-left mt-3_ ml-1_ fa fa-question" style="vertical-align: baseline;"></span>
                                        		</span>
                                        		</span>&nbsp;All Question Bank</a>
                                        </li>--}}
                                    </ul>
                                    <div class="tab-content" style="border: solid 1px #dee2e6; margin-top: -1px;">
                                        <div id="question-types" class="tab-pane fade in active show" style="min-width: 100%; max-width: 100%;">
                                            <div class="trow weight_600 pl-14 pr-14_" style="
                                                        padding: 14px 17px 0px 20px;
                                                    ">Click any of below item to add Question of that type.</div>
                                            <div class="trow_ pt-17_ mb-17_">
                                                <ul id="question-type-links">
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="icon-select">
                                                			<span class="trow_ icon-select  qst_icon cnt-center c-dib_ fs-40_ txt-gray-6"></span>
                                                			<span class="trow_ qst_txt">Select</span>
                                                		</a>
                                                	</li>
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="icon-checkbox-group">
                                                			<span class="trow_ qst_icon cnt-center c-dib_ icon-checkbox-group fs-40_ txt-gray-6">
                                                			</span>
                                                			<span class="trow_ qst_txt">Check Box</span>
                                                		</a>
                                                	</li>
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="icon-radio-group">
                                                			<span class="trow_ qst_icon cnt-center c-dib_ icon-radio-group fs-40_ txt-gray-6">
                                                			</span>
                                                			<span class="trow_ qst_txt">Radio Button</span>
                                                		</a>
                                                	</li>
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="icon-text">
                                                			{{--<span class="trow_ qst_icon cnt-center c-dib_ icon-text fs-40_ txt-gray-6">
                                                			</span>--}}
                                                			<span class="trow_ qst_icon cnt-center c-dib_ fs-40_ txt-gray-6">
                                                				<svg style="border: solid 2px;padding: 2px;border-color: inherit;"><use xlink:href="#text-box" /></svg>
                                                			</span>
                                                			<span class="trow_ qst_txt">Text Box</span>
                                                		</a>
                                                	</li>
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="icon-date" style="padding-bottom: 10px;">
                                                			<span class="trow_ qst_icon cnt-center c-dib_ icon-date fs-40_ txt-gray-6">
                                                			</span>
                                                			<span class="trow_ qst_txt">Date Field</span>
                                                		</a>
                                                	</li>
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="icon-textarea">
                                                			{{--<span class="trow_ qst_icon cnt-center c-dib_ icon-textarea fs-40_ txt-gray-6">
                                                			</span>--}}
                                                			<span class="trow_ qst_icon cnt-center c-dib_ fs-40_ txt-gray-6">
                                                				<svg><use xlink:href="#comment-box" /></svg>
                                                			</span>
                                                			<span class="trow_ qst_txt">Comments</span>
                                                		</a>
                                                	</li>
                                                	<li>
                                                		<a href="javascript:void(0)" class="txt-hover-blue" data-action="star-rating">
                                                			<span class="trow_ qst_icon cnt-center c-dib_ fa fa-star-o star-rating fs-40_ txt-gray-6">
                                                			</span>
                                                			<span class="trow_ qst_txt">Star Rating</span>
                                                		</a>
                                                	</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="all-question-bank" class="tab-pane fade " style="min-width: 100%; max-width: 100%;">
                                            
                                            
                                            <div class="row pt-17_ mb-17_">
                                                <div class="col-sm-12">
                                                    <p>All Question Bank Content</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        			
                        		
                                <div class="trow_ survey-accord-row">
                                	
                                	<div class="accordion" id="survey_accordian">
                                            
                                        <div class="card">
                                            <div class="card-header pa-0_" id="survey_header">
                                                <h2 class="trow_ mb-0 fs-16_ weight_400 pa-14_ cur-pointer" data-target="#survey_name" aria-expanded="false" data-toggle="collapse" >
                                                    <span class="elm-left hd-txt">Survey Name</span>
                                                    <span class="elm-right hd-icon fa"></span>
                                                </h2>
                                            </div>
                                            <div id="survey_name" class="collapse" aria-labelledby="survey_header" data-parent="#survey_accordian">
                                                <div class="card-body">
                                                    <p>Survey Name: &nbsp; <input type="text" maxlength="50" class="form-control" id="survey_name_id" name="survey_name" value="{{$survey->title}}"/></p>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="card">
                                            <div class="card-header pa-0_" id="survey_logo">
                                                <h2 class="trow_ mb-0 fs-16_ weight_400 pa-14_ cur-pointer" data-target="#survey_logo_content" aria-expanded="false" data-toggle="collapse" >
                                                    <span class="elm-left hd-txt">Survey Logo</span>
                                                    <span class="elm-right hd-icon fa"></span>
                                                </h2>
                                            </div>
                                            <div id="survey_logo_content" class="collapse" aria-labelledby="survey_logo" data-parent="#survey_accordian">
                                                <div class="card-body">
                                                    <div class="trow_"></div>
                                                    <div class="trow_ cnt-center">
                                                    	@php $header_image_path = (!empty($theme->header_image)?"/images/".$theme->header_image:''); @endphp
                                        
                                                            <div class="col-md-2-" id="disp_image_div" style='margin-top: 2px; {{ (isset($theme) && $theme->header_image != "")?"":"display:none;" }}'>
                                                                <img id="logo_image_preview" style="height:auto; width: 200px;"  src="{{ !empty($header_image_path)? url($header_image_path): ''}}" alt="Header Logo" />
                                                                <a style="color: red; margin-left: 20px;" del_img="1" class="removeImage" href="javascript:void(0)">Remove</a>                                    
                                                            </div>

                                                            <div class="trow_ cnt-center mt-24_" id='image_body' style='{{ (isset($theme) && $theme->header_image != "")?"display:none;":"" }}'>
                                                                    <div>Click the upload icon below to upload survey logo of type (.jpg, .jpeg, .gif or .png only!).</div>
                                                                    <div class="image-upload">
                                                                        <label for="logo_image">
                                                                            <img src="https://goo.gl/pB9rpQ"/>
                                                                        </label>
                                                                        <input  class="form-control upload-image" name="logo_image" type="file" id="logo_image" value="{{ isset($theme)?$theme->header_image : ''}}">                                                   
                                                                    </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header pa-0_" id="survey_header">
                                                <h2 class="trow_ mb-0 fs-16_ weight_400 pa-14_ cur-pointer" data-target="#survey_header_content" aria-expanded="false" data-toggle="collapse" >
                                                    <span class="elm-left hd-txt">Survey Header</span>
                                                    <span class="elm-right hd-icon fa"></span>
                                                </h2>
                                            </div>
                                            <div id="survey_header_content" class="collapse" aria-labelledby="survey_header" data-parent="#survey_accordian">
                                                <div class="card-body">
                                                    <p>Survey Header Content: &nbsp; <textarea class="form-control" name="header_content">{{isset($theme->header_text)?$theme->header_text:'This is the first activity to fulfill your obligation in Compliance Reward. Please provide feedback about your experience.'}}</textarea></p>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="card">
                                            <div class="card-header pa-0_" id="survey_body">
                                                <h2 class="trow_ mb-0 fs-16_ weight_400 pa-14_ cur-pointer" data-target="#survey_body_content" aria-expanded="true" data-toggle="collapse" >
                                                    <span class="elm-left hd-txt">Survey Body</span>
                                                    <span class="elm-right hd-icon fa"></span>
                                                </h2>
                                            </div>
                                            <div id="survey_body_content" class="collapse show" aria-labelledby="survey_body" data-parent="#survey_accordian">
                                                <div class="card-body">
                                                    
                                                    <div id="fb-editor"></div>   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="card">
                                            <div class="card-header pa-0_" id="survey_footer">
                                                <h2 class="trow_ mb-0 fs-16_ weight_400 pa-14_ cur-pointer" data-target="#survey_footer_content" aria-expanded="false" data-toggle="collapse" >
                                                    <span class="elm-left hd-txt">Survey Footer</span>
                                                    <span class="elm-right hd-icon fa"></span>
                                                </h2>
                                            </div>
                                            <div id="survey_footer_content" class="collapse" aria-labelledby="survey_footer" data-parent="#survey_accordian">
                                                <div class="card-body">
                                                    <p>Survey Footer Content: &nbsp; <input type="text" class="form-control"  value="{{isset($theme)?$theme->footer_text:''}}" name="footer_content" maxlength="150" size="150"/></p>
                                                </div>
                                            </div>
                                        </div>
                                            
                                            
                                    </div>
                                	
                                </div>
                                
                      		</div>
                        </form>
                        </div>
                    </div>
                        <div class="new-action-buttons" style="margin:40px; padding-top: 30px;">
                            <!-- <button id="back" class="btn btn-primary save-template">Back</button>-->
                            <button id="trash" class="clear-all btn btn-danger" > Clear all</button>
                            <button id="form-preview" class="btn btn-warning">Preview</button>
                            <button id="build_report" class="btn btn-primary save-template">Save & Next</button>
                        </div>      
                </div>
                
            </div>
                
        </div>
        
        
        
	</div>
</div>
@endsection
@section('script')
@php $header_image_path = (!empty($theme->header_image)?"/images/".$theme->header_image:''); @endphp
    <script src="{{url('/js/form-render.min.js')}}"></script> 
    <script src="{{url('/js/control_plugins/starRating.js')}}"></script> 
  <script>
        
         jQuery(function($) {
            var fbEditor = document.getElementById('fb-editor');            
            remove = document.getElementsByClassName('del-button');
            trash = document.getElementById('trash');
            //back = document.getElementById('back');
            formPreview = document.getElementById('form-preview');
            buildReport =  document.getElementById('build_report');
            var questionsTemplate =  $('#question_details').val();

            var options = {
                showActionButtons: false, // defaults: `true`
                dataType: 'json', // json|xml default: 'json'
                editOnAdd: true,
                disableHTMLLabels: false,
                controlPosition: 'left',
                disabledAttrs: ['multiple'],
                disabledSubtypes: {
                    text: ['password','color'],
                    text: ['password','color']
                },
                onSave: function(evt, formData){
                    showPreview(formData)
                },

                disableFields: [
                    'autocomplete',
                    'button',
                    'hidden',
                    'paragraph',
                    'header',
                    'file',
                    'number',
                ],                
                controlOrder: [                    
                ],
               fields : [{
                label: 'Star Rating',
                attrs: {
                      type: 'starRating'
                },
                icon: '*'
              }],
                templates : {
                    starRating: function(fieldData) {
                          return {
                            field: '<span id="'+fieldData.name+'">',
                            onRender: function() {
                                  $(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
                            }
                          };
                    }
                  },
              disabledFieldButtons: {
                   /*textarea: ['edit','copy'],*/
                },  
  
                /*onAddField: function(fieldId) {
                    checkCounter();
                },*/

                formData:questionsTemplate
            };
            
            formBuilder =  $(fbEditor).formBuilder(options);
            
            
            buildReport.onclick = function(){

                var question_details = formBuilder.actions.getData('json');
                
                if($("#survey_name_id").val() != ""){
                    $('#question_details').val(question_details);
                    $('#question_form').submit();
                }else{
                    alert("Survey name cannot be empty.");
                }
            };

            trash.onclick = function(){
                if(confirm('Are you sure?'))
                {
                    formBuilder.actions.clearFields()
                }
            };
            
            /*back.onclick = function(){
                window.location.href = "{{ url()->previous() }}";
            };*/
            
            formPreview.onclick = function (){
                showPreview();
            };
             
            function showPreview(formData) 
            {
                var headerText = $("textarea[name=header_content]").val();
                var footerText = $("input[name=footer_content]").val();
                var del_img = $('.removeImage').attr('del_img');                
                formData = formBuilder.actions.getData('json');
                
                let formRenderOpts = {
                  dataType: 'json',
                  formData
                };
                
                    var imgPath = '{{$header_image_path}}';
                    let $renderContainer = $('<form/>');
                    $renderContainer.formRender(formRenderOpts);
                    let html = `<!doctype html><title>Form Preview</title><body class="container bg-white"><div style="text-align:center;">`;

                    if(del_img == 1 && imgPath != "")
                      html += `<img style="max-width: 200px; margin:20px 0px;" id="live_image" src="{{ !empty($header_image_path)? url($header_image_path): ''}}">`;
                    else if($("#logo_image").val() != "" && del_img == 0)
                    {
                          input = document.getElementById("logo_image");
                          if (input.files && input.files[0]) {
                               
                                html += `<img style="max-width: 200px; margin:20px 0px;" id="live_image" src="`+$("#logo_image_preview").attr("src")+`">`;
                          }
                    }

                    html += `</div><div class="trow_ cnt-center c-dib_ mt-14_ mb-14_">`;
                    html += `<span class="fs-24_ pa-4_ tt_cc_ txt-grn-lt weight_600 br-top-blue-w1 br-bottom-blue-w1 pl-2_ pr-2_">{{$survey->title}}</span>`;
                   // html += `</div><h4 style="text-align:center; color:blue;">`+headerText+`</h4><div class="trow_ cnt-center c-dib_ mt-24_ mb-14_">`;
                    html += `<span class="wd-100p mt-17_ fs-17_ tt_cc_ txt-blue weight_600">`+headerText+`</span>`;
                    html += `</div><hr>${$renderContainer.html()}<h4 style="text-align:center; color:blue;">`+footerText+`</h4><div class="trow_ mt-14_">`;
                    html += `<button class="wd-100p btn bg-yellow-txt-gray weight_600 fs-17_ tt_uc_ pa-12_ mb-7_ cnr-center  " style="line-height: 14px;">submit questionnaire</button>`;
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
        
        var _URL = window.URL || window.webkitURL;
            $("#logo_image").on('change', function (e) {
           
                var imgPath = this.value;    
                
                var preview_id = $(this).attr("id");
                var del_img = $('.removeImage').attr('del_img');
                var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                
                if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
                {
                    var file, img;
                    if ((file = this.files[0])) {
                        img = new Image();
                        var objectUrl = _URL.createObjectURL(file);
                        
                        img.onload = function () {
                            /*if(this.width != 380 || this.height != 80)
                            {
                                alert("Please select image file of size 380x80.");
                                $("#logo_image").val("");
                                return false;
                            }*/
                            
                            if(del_img==1)
                                $('.removeImage').attr('del_img',0);
                            readURL(preview_id);

                            _URL.revokeObjectURL(objectUrl);
                        };
                        img.src = objectUrl;
                    }                
                }
                else
                    alert("Please select image file (jpg, jpeg, png).");
            
            });
        
        $('.removeImage').click(function () {
               var conf = confirm("Do you really want to remove this image?");
               if (conf === true) 
               {
                    var file_name = $('#logo_image').attr('name');
                    var  del_img =  $(this).attr('del_img');
                   
                    if(del_img==1)
                    {
                        var  report_id= '{{ isset($theme)?$theme->id:""}}';
                        $.ajax({
                            url: "{{ url('survey/delete-image') }}",
                            type: 'POST',
                            data: {id: report_id, file_name: file_name},
                            success: function (data) {
                                // console.log(data);
                                //$('.business_rules').html(data);
                            },
                                headers: {
                                    'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                            }
                        });     
                    }
                    $('#disp_image_div').hide();
                    $('#image_body').show();
                    $("#logo_image").val("");
                }
            });
            
        function readURL(preview_id) {
            input = document.getElementById("logo_image");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                reader.onload = function (e) {
                    $('#'+preview_id+'_preview').attr('src', e.target.result);
                };
                $('#disp_image_div').show();
                $('#image_body').hide();
                //$("#logo_image").val("");
            }
        }

         jQuery(function($) {


        	/*$("#question-type-links a").live("click", function(event_control){*/
        	$('#question-type-links').on('click', 'a', function(event_control){

        		/*console.log('400--click event captured');*/
				/*alert('401--captured click event');*/

				target_element = event_control.target;

				console.log("399--target element classes >> " + $(target_element).attr('class'));

             	/*event_control.preventDefault();
             	event_control.stopPropagation();*/

             	console.log("###387----control click detected for " + $(this).data("action") + '--' + $(target_element).attr("data-action"));


             	var surver_body_expanded = "";

             	surver_body_expanded = $('#survey_body').find('h2').attr("aria-expanded");

             	if(surver_body_expanded == "false") { $('#survey_body').find('h2').trigger('click'); }

             	switch($(this).data("action"))
             	{
             		case "icon-select":         $('#fb-editor').find('li[data-type="select"]').trigger("click"); break;
             		case "icon-checkbox-group": $('#fb-editor').find('li[data-type="checkbox-group"]').trigger("click"); break;
             		case "icon-radio-group":    $('#fb-editor').find('li[data-type="radio-group"]').trigger("click"); break;
             		case "icon-text":           $('#fb-editor').find('li[data-type="text"]').trigger("click"); break;
             		case "icon-date":           $('#fb-editor').find('li[data-type="date"]').trigger("click"); break;
             		case "icon-textarea":       $('#fb-editor').find('li[data-type="textarea"]').trigger("click"); break;
             		case "star-rating":         $('#fb-editor').find('li[data-type="starRating"]').trigger("click"); break;
             	}

             	/*$('#fb-editor').find('li[data-type="select"]').trigger("click");*/


             	return false;
                 
             });
             


         });


         


    </script>
    
  @endsection
  




















