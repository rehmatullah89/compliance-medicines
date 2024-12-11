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
    		<h4 class="elm-left fs-24_ mb-3_">Update Module</h4>
            {{--<div class="date-time elm-right lh-28_ mb-3_">Monday, January 27, 2020 12:36 AM</div><!-- &#10133; +  -->--}}
    	</div>
    </div>
    
    <div class="row">
		<div class="col-sm-12">
		
			<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12">
    				
    				<div class="practice new_pad_edit">
                        @foreach($errors->all() as $message)
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @endforeach
                        <form class="compliance-form_ trow_" method="post" action="{{ url('modules/'.$module->id) }}" >
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            
                            <div class="flds_module_name flx-justify-start mb-14_">
          						<div class="wd-70p field fld-module_name mr-1p">
          							<label class="wd-100p txt-gray-6" style="color: #666;">Name <span class="text-danger">*</span></label>
          							<input type="text" class="wd-100p" name="name" required placeholder="Enter module name" value="{{$module->name}}" maxlength="30">
          							
          						</div>
                            </div>
                            
                            
                            <div class="trow_ cnt-left">
                                <div class="trow_ cnt-left continue">
                                    <button type="button"  class="btn btn-xs btn-danger" style="min-width: 120px;" onclick="window.location='{{ url("/modules") }}'">Cancel</button>&nbsp;
                                    <button type="submit" id="save-module" class="btn bg-blue-txt-wht weight_500 fs-14_" style="min-width: 120px;">Update</button>
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
@endsection
