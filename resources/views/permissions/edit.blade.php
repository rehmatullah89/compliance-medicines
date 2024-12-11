@extends('layouts.compliance')
@section('content')
    <style>
        .error {
            color:red !important;
            border-color: red !important;
        }
        .label-error {
            color: red !important;
        }
    </style>
    
    <div class="row" style="border-bottom: solid 1px #cecece;">
    	<div class="col-sm-12">
    		<h4 class="elm-left fs-24_ mb-3_">Update Permission</h4>
            {{--<div class="date-time elm-right lh-28_ mb-3_">Monday, January 27, 2020 12:36 AM</div><!-- &#10133; +  -->--}}
    	</div>
    </div>
    
    <div class="row">
		<div class="col-sm-12">
		
			<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12">
    				
    				<div class="trow_ practice new_pad_edit">
                        {{--                                <h5>Module Detail</h5>--}}
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            @foreach($errors->all() as $message)
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @endforeach
                        </div>
                        <form class="compliance-form_ trow_" method="post" action="{{ url('permissions/'.$data->id) }}" id="m_form_1" >
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            
                            
                            <div class="flds_name flx-justify-start mb-14_">
          						<div class="wd-70p field fld-perm_name mr-1p">
          							<label class="wd-100p txt-gray-6" style="color: #666;">Edit Permission <span class="text-danger">*</span></label>
          							<input type="text" class="wd-100p" name="name" required placeholder="Enter permission
                                     name" value="{{ $data->name }}" maxlength="30">
          							
          						</div>
                            </div>
                            
                            
                            <div class="wd-70p field fld-module_name mb-14_">
      							<label class="wd-100p txt-gray-6" style="color: #666;">Module Name <span class="text-danger">*</span></label>
  							    <select id="for" class="wd-100p" name="module_id" required="">
  								<option selected disabled>Please Select</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" @if( $module_id == $module->id) selected @endif>{{ $module->name }}</option>
                                    @endforeach
                                </select>
  							
      						</div>
                            
                            <div class="trow_">
                                <div class="trow- cnt-left continue">
                                    <button type="button"  class="btn btn-xs btn-danger" style="min-width: 120px;" onclick="window.location='{{ url("/permissions") }}'">Cancel</button>&nbsp;
                                    <button type="submit" id="save-module"  class="btn bg-blue-txt-wht weight_500 fs-14_" style="min-width: 120px;">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
    				
    				
    			</div>
    		</div>
    		
    	</div>
    </div>


@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <script type="text/javascript">
        //== Class definition
        $("#m_form_1").validate();
    </script>

@endsection
