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
    		<h4 class="elm-left fs-24_ mb-3_">Add Permission</h4>
            {{--<div class="date-time elm-right lh-28_ mb-3_">Monday, January 27, 2020 12:36 AM</div><!-- &#10133; +  -->--}}
    	</div>
    </div>
    
    <div class="row">
		<div class="col-sm-12">
		
			<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12">
    				
    				<div class="trow_" id="patient_data">
                    	<div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                {{--                                <h5>Module Detail</h5>--}}
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    @foreach($errors->all() as $message)
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @endforeach
                                </div>
                                <form class="compliance-form_ trow_" method="post" action="{{url('permissions')}}" id="m_form_1">
                                    {!! csrf_field() !!}
                                    
                                    <div class="flds_name flx-justify-start mb-14_">
                  						<div class="wd-70p field fld-perm_name mr-1p">
                  							<label class="wd-100p txt-gray-6" style="color: #666;">Enter New Permission Name <span class="text-danger">*</span></label>
                  							<input type="text" class="wd-100p" name="name" required placeholder="Enter permission name" value=""maxlength="30">
                  						</div>
                                    </div>
                                    
                                    
                                    <div class="wd-70p field fld-module_name mb-14_">
              							<label class="wd-100p txt-gray-6" style="color: #666;">Module Name <span class="text-danger">*</span></label>
              							<select  class="wd-100p" id="for"  name="module_id" required="">
              								<option selected disabled>Please Select</option>
              								@foreach($modules as $module)
                                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                                            @endforeach
              							</select>
              						</div>
                                    
                                    
                                    <div class="trow_ cnt-left">
                                        <button type="button" style="min-width: 120px;" class="btn btn-xs btn-danger" onclick="window.location='{{ url("/permissions") }}'">Cancel</button>&nbsp;
                                        <button type="submit" id="save-module"  class="btn bg-blue-txt-wht weight_500 fs-14_" style="min-width: 120px;">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
