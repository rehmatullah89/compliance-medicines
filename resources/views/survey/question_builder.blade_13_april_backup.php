@extends('layouts.compliance')

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

#fb-editor .form-wrap.form-builder .cb-wrap {width: 25%;transition: transform 250ms;padding-top: 36px;padding-left: 12px;order: 1;background-color: #f2f2f2;top: auto !important;left: auto !important;right: auto !important;bottom: auto !important;position: relative !important;/* z-index: -100; */ padding-bottom: 24px;}
#fb-editor .form-wrap.form-builder .cb-wrap:before {content: "\f29c";font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;color: #fff;position: absolute;top: 0px;left: 0px;height: 34px;z-index: 999999999999;font-size: 21px;padding: 7px 10px;background-color: #3e7bc4;}
#fb-editor .form-wrap.form-builder .cb-wrap:after {content: "All Question Types";position: absolute;top: 0px;left: 0px;padding: 8px 10px;padding-left: 49px;background-color: #3e7bc4;color: #fff;line-height: 18px;height: 34px;width: 100%;text-align: center;}


#fb-editor .form-wrap.form-builder { position: relative; display: flex; justify-content: flex-end;}
#fb-editor .form-wrap.form-builder .frmb { min-height: 252px; padding: 24px; border-left: solid 1px #cecece; order: 2; position: relative; width: 100%; z-index: 100; }
#fb-editor .form-wrap.form-builder .frmb-control li {cursor: move;list-style: none;margin: 0 0 -1px 0;padding: 10px;text-align: left;background: #fff;
-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;
width: 45%;display: inline-block;margin-right: 2%;margin-left: 2%;margin-bottom: 17px;position: relative;display: inline-block;
padding: 0px;border: solid 1px #dee2e6;min-height: 80px;border-radius: 2px;margin-top: 14px !important;box-shadow: inset 0 0 0 1px #c5c5c5;box-shadow: none;
position: relative;display: inline-flex !important;align-items: flex-end;margin-bottom: 0px !important;}
#fb-editor .form-wrap.form-builder .frmb-control li::before {margin-right: 5px;font-size: 40px;position: absolute;top: 7px;left: 0px;width: 100%;text-align: center;margin: 0px;}
#fb-editor .form-wrap.form-builder .frmb-control li span {width: 100%;display: block;text-align: center;padding-bottom: 4px;font-size: 12px;font-weight: 500;}

.image-upload > input{
    display: none;
}

.image-upload img{
    width: 80px;
    cursor: pointer;
}


</style>
</div>

<div class="row survey-module">

	<div class="col-sm-12">

        <div class="row bg-gray-f2">
        	<div class="col-sm-12">
        		<div class="container">
        			<h4 class="wd-100p cnt-center fs-20_ pt-14_ pb-7_ mb-3_ txt-blue weight_600">Delivery Satisfaction Survey:</h4>
        		</div>
        	</div>
        </div>
        
        
    	
    	<div class="row bg-white">
            <div class="col-sm-1"></div>
			<div class="col-sm-10">
                <div class="container" style="padding: 10px; min-width: 100%; max-width: 100%;">
                	 <form method="POST" id='question_form' action="{{ url('survey/'.$survey->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH')}}
                                <input type="hidden" name="survey_id" id="survey_id" value=" {{$survey->id}}" >
                                <input type="hidden" name="question_details" id="question_details" value="{{$survey->details}}" >
                        	
                    <div class="trow_ survey-accord-row">
                    	
                    	<div class="accordion" id="survey_accordian">
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
                                        @php $header_image_path = (!empty($theme->header_image)?"/images/".$theme->header_image:''); @endphp
                                        
                                        <div class="col-md-2" id="disp_image_div" style='margin-top: 10px; {{ (isset($theme) && $theme->header_image != "")?"":"display:none;" }}'>
                                            <img id="logo_image_preview"   src="{{ !empty($header_image_path)? url($header_image_path): ''}}" alt="Header Logo" />
                                            <a style="color: red; margin-left: 20px;" del_img="1" class="removeImage" href="javascript:void(0)">Remove</a>                                    
                                        </div>
                                        
                                        <div class="trow_ cnt-center mt-24_" id='image_body' style='{{ (isset($theme) && $theme->header_image != "")?"display:none;":"" }}'>
                                        	<div>Click the upload icon below to upload survey logo of size 380x80 of type (.jpg, .jpeg, .gif or .png only!).</div>
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
                            <div class="card">
                                <div class="card-header pa-0_" id="survey_header">
                                    <h2 class="trow_ mb-0 fs-16_ weight_400 pa-14_ cur-pointer" data-target="#survey_header_content" aria-expanded="false" data-toggle="collapse" >
                                        <span class="elm-left hd-txt">Survey Header</span>
                                        <span class="elm-right hd-icon fa"></span>
                                    </h2>
                                </div>
                                <div id="survey_header_content" class="collapse" aria-labelledby="survey_header" data-parent="#survey_accordian">
                                    <div class="card-body">
                                        <p>Survey Header Content: &nbsp; <input type="text" class="form-control" name="header_content" value="{{isset($theme->header_text)?$theme->header_text:''}}" maxlength="150" size="150"/></p>
                                    </div>
                                </div>
                            </div>
                            
                           <div id="fb-editor"></div>   <br/>
                            
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
                                
                      
                        
                       </form> 
                                
                </div>
                
                <div class="new-action-buttons" style="margin:10px;">
                    <button id="back" class="btn btn-primary save-template">Back</button>
                    <button id="trash" class="clear-all btn btn-danger" > Clear all</button>
                    <button id="build_report" class="btn btn-primary save-template">Next</button>
                </div>
                      
                
            </div>
            <div class="col-sm-1"></div>
        </div>
        
        
        
	</div>
</div>
@endsection
@section('script')
<script src="{{url('/js/popper.js')}}"></script>
    <script src="{{url('/js/bootstrap.js')}}"></script>
  <script>
        
         jQuery(function($) {
            var fbEditor = document.getElementById('fb-editor');            
            remove = document.getElementsByClassName('del-button');
            trash = document.getElementById('trash');
            back = document.getElementById('back');
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
                icon: '&#9734;'
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

                $('#question_details').val(question_details);
                $('#question_form').submit();
            };

            trash.onclick = function(){
                if(confirm('Are you sure, you want to clear board?'))
                {
                    formBuilder.actions.clearFields()
                }
            };
            
            back.onclick = function(){
                window.location.href = "{{ url()->previous() }}";
            };
            
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
                            if(this.width != 380 || this.height != 80)
                            {
                                alert("Please select image file of size 380x80.");
                                $("#logo_image").val("");
                                return false;
                            }
                            else{
                                if(del_img==1)
                                    $('.removeImage').attr('del_img',0);
                                    readURL(preview_id);
                            }
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

    </script>
    
  @endsection
  




















