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
        
        input[type="checkbox"]:not(.circled):before { background-color: #fff; }
        
    </style>
    
    <div class="row" style="border-bottom: solid 1px #cecece;">
    	<div class="col-sm-12">
    		<h4 class="elm-left fs-24_ mb-3_">Add Role</h4>
            {{--<div class="date-time elm-right lh-28_ mb-3_">Monday, January 27, 2020 12:36 AM</div><!-- &#10133; +  -->--}}
    	</div>
    </div>
    
    <div class="row">
		<div class="col-sm-12">
		
			<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12">
    				
    				<div class="trow_" id="patient_data">
                        {{-- <h5>Module Detail</h5>--}}
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form class="compliance-form_ trow_" method="post" action="{{url('roles')}}" id="m_form_1">
                            {!! csrf_field() !!}
                            
                            <div class="flds_name flx-justify-start mb-14_">
          						<div class="wd-70p field fld-perm_name mr-1p">
          							<label class="wd-100p txt-gray-6" style="color: #666;">Name <span class="text-danger">*</span></label>
          							<input type="text" class="wd-100p" name="name" required placeholder="Enter user name" value=""maxlength="30">
          						</div>
                            </div>

                            <div class="trow_ table-responsive-1024 table-responsive">
                                <table id="roles_create-edit_table" class="table table-bordered " style="width: 100%;">
                                    <thead>
                                    	<tr class="weight_500-force-childs bg-blue">
                                            <th class="txt-wht"><input type="checkbox" id="select-all"> Modules</th>
                                            <th class="txt-wht">Permissions</th>
                                            <th class="txt-wht"></th>
                                            <th class="txt-wht"></th>
                                            <th class="txt-wht"></th>
                                            <th class="txt-wht"></th>
                                            <th class="txt-wht"></th>
                                        </tr>
                                    <tbody>
                                        @foreach($modules as $module)
                                        <tr>
                                            <td class="module_td">
                                            	<input type="checkbox" class="module"
                                                                         id="{{ $module->id }}"> {{ $module->name }}
                                            </td>
                                            @foreach ($permissions as $permission)
                                              @if ($permission->module_id == $module->id)
                                              <td>
                                              	<input type="checkbox" name="permission[]"
                                                       value="{{ $permission->name }}" id="permissions"
                                                       class="{{ $module->id }} abc"
                                                       data-id="{{ $module->id }}"> {{ $permission->name }}
                                              </td>
                                              @endif
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="trow_ mt-7_">
                                <button type="button"  class="btn btn-xs btn-danger" style="min-width: 120px;" onclick="window.location='{{ url("/roles") }}'">Cancel</button>&nbsp;
                                <button type="submit" id="save-module" class="btn bg-blue-txt-wht weight_500 fs-14_" style="min-width: 120px;">Save</button>
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

        $("#m_form_1").validate();

        $('.module').change(function () {

            var id = $(this).attr('id');

            var result = $(this).prop('checked');

            $('.' + id).prop('checked', result);

        });


        $('input[name="permission[]"]').on('click', function () {

            var data_id = $(this).data('id');

            if ($('input[data-id=' + data_id + ']:checked').length == $('input[data-id=' + data_id + ']').length) {

                $('#' + data_id).prop('checked', true);

            } else {

                $('#' + data_id).prop('checked', false);

            }

        });

        $('#select-all').change(function () {

            var result = $(this).prop('checked');

            $('input[type="checkbox"]').prop('checked', result);

        });


        $('input[name="permission[]"]').on('click', function () {

            var data_id = $(this).data('id');

            if ($('.abc:checked').length == $('.abc').length) {

                $('#select-all').prop('checked', true);

            } else {

                $('#select-all').prop('checked', false);

            }


        })


    </script>
@endsection
