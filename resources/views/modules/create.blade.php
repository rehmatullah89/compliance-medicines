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
    		<h4 class="elm-left fs-24_ mb-3_">Add Module</h4>
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
                                {{-- <h5>Module Detail</h5>--}}
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <form class="compliance-form_ trow_" method="post" action="{{url('modules')}}" >
                                    {!! csrf_field() !!}
                                    
                                    <div class="flds_module_name flx-justify-start mb-14_">
                  						<div class="wd-70p field fld-module_name mr-1p">
                  							<label class="wd-100p txt-gray-6" style="color: #666;">Name <span class="text-danger">*</span></label>
                  							<input type="text" class="wd-100p" name="name" required placeholder="Enter module name" value=""maxlength="30">
                  							
                  						</div>
                                    </div>

                                    <div class="trow_ cnt-left">
                                        <button type="button"  class="btn btn-xs btn-danger" style="min-width: 120px;" onclick="window.location='{{ url("/modules") }}'">Cancel</button>&nbsp;
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
@endsection
