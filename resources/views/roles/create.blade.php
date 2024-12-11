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
		
		
		table.bordered.roles_table { border-collapse: separate; border: 0px; }
        table.bordered.roles_table thead {  }
        table.bordered.roles_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4;}
        table.bordered.roles_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
        table.bordered.roles_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }
        
        table.bordered.roles_table tbody {  }
        table.bordered.roles_table tbody tr {  }
        table.bordered.roles_table tbody tr td { vertical-align: top; }
        table.bordered.roles_table tbody tr td:first-child { border-left: solid 1px #ccc; }
        table.bordered.roles_table tbody tr td:last-child { border-right: solid 1px #ccc; }
        table.bordered.roles_table tbody tr:last-child {  }
        table.bordered.roles_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
        table.bordered.roles_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
        table.bordered.roles_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }
		
		
		
		
		
		
		#roles_create-edit_table thead th { padding: 7px 0.3vw !important; padding-left: 14px !important; border: 0px !important; }
		
		#roles_create-edit_table thead th.module_td { width:200px !important; }
		#roles_create-edit_table thead th.module_td input[type="checkbox"] { margin: 0px; }
		#roles_create-edit_table thead th.module_td input[type="checkbox"]:before { border:none; }
		#roles_create-edit_table thead th.module_td input[type="checkbox"]:checked:before {  }
		#roles_create-edit_table thead th.module_td input[type="checkbox"] + span { line-height: 1.4em;  }
		
		#roles_create-edit_table tbody td.module_td { vertical-align: middle; /*background-color: #dce8f6;*/ border-bottom: solid 1px #d0d8e3; padding-left: 14px !important; }
		#roles_create-edit_table tbody td.module_td input[type="checkbox"] { margin: 0px; }
		#roles_create-edit_table tbody td.module_td input[type="checkbox"]:before { border: solid 1px #3e7bc4; color: #3e7bc4; text-transform: uppercase; }
		#roles_create-edit_table tbody td.module_td input[type="checkbox"]:checked:before {  }
		#roles_create-edit_table tbody td.module_td input[type="checkbox"] + span { line-height: 1.4em; text-transform: uppercase; }
		#roles_create-edit_table tbody td.module_td input[type="checkbox"] + label { line-height: 1.4em; text-transform: uppercase; /*color: #242424;*/ cursor: pointer; margin-bottom: 0px;}
		
		#roles_create-edit_table tbody tr:nth-child(odd) {  }
		#roles_create-edit_table tbody tr:nth-child(even) { background-color: #f0f0f0; }
		
		#roles_create-edit_table tbody td { padding: 4px 0.3vw !important; }
		
		#roles_create-edit_table tbody td.permission-list { padding-bottom: 0px !important; /*background-color: #e5ead3;*/ border-bottom: solid 1px #d6dbc7; }
		#roles_create-edit_table tbody td.permission-list div.permission { margin-bottom: 0px; cursor: pointer; font-size:12px; padding: 2px 4px; width: 224px; margin-right: 6px;}
		#roles_create-edit_table tbody td.permission-list div.permission input[type="checkbox"] { margin: 0px; }
		#roles_create-edit_table tbody td.permission-list div.permission input[type="checkbox"]:before { border: solid 1px #3e7bc4; color: #3e7bc4; text-transform: uppercase; }
		#roles_create-edit_table tbody td.permission-list div.permission input[type="checkbox"]:checked:before {  }
		#roles_create-edit_table tbody td.permission-list div.permission input[type="checkbox"] + span { font-size: 12px; line-height: 1.4em; text-transform: uppercase; }
		#roles_create-edit_table tbody td.permission-list div.permission input[type="checkbox"] + label { font-size: 12px; line-height: 1.4em; text-transform: uppercase; /*color: #242424;*/ cursor: pointer; margin-bottom: 0px;}
	
		@media only screen and (max-width: 1410px)
		{
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(4n-3) label { color: #3e7bc4; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(4n-2) label { color: #dda600 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(4n-1) label { color: #a5cb29 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(4n) label { color: #f04214 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(4n) + div { clear: left !important; }
		}
		
		@media only screen and (max-width: 1730px) and (min-width: 1411px)
		{
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(5n-4) label { color: #3e7bc4; clear: none !important;}
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(5n-3) label { color: #dda600 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(5n-2) label { color: #a5cb29 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(5n-1) label { color: #f04214 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(5n) label { color: #00cab0 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(5n) + div { clear: left !important; }
		}
		
		@media only screen and (max-width: 1980px) and (min-width: 1731px)
		{
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n-5) label { color: #3e7bc4; clear: none !important;}
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n-4) label { color: #dda600 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n-3) label { color: #a5cb29 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n-2) label { color: #f04214 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n-1) label { color: #00cab0 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n) label { color: #b858c6 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(6n) + div { clear: left !important; }
		}
		
		@media only screen and (max-width: 2220px) and (min-width: 1981px)
		{
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n-6) label { color: #3e7bc4; clear: none !important;}
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n-5) label { color: #dda600 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n-4) label { color: #a5cb29 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n-3) label { color: #f04214 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n-2) label { color: #00cab0 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n-1) label { color: #b858c6 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n) label { color: #4dd146 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(7n) + div { clear: left !important; }
		}
		
		
		@media only screen and (max-width: 2470px) and (min-width: 2221px)
		{
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-7) label { color: #3e7bc4; clear: none !important;}
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-6) label { color: #dda600 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-5) label { color: #a5cb29 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-4) label { color: #f04214 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-3) label { color: #00cab0 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-2) label { color: #b858c6 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n-1) label { color: #4dd146 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n) label { color: #5c6ec6 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(8n) + div { clear: left !important; }
		}
		
		@media only screen and (min-width: 2471px) 
		{
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-8) label { color: #3e7bc4; clear: none !important;}
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-7) label { color: #dda600 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-6) label { color: #a5cb29 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-5) label { color: #f04214 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-4) label { color: #00cab0 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-3) label { color: #b858c6 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-2) label { color: #4dd146 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n-1) label { color: #5c6ec6 !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n) label { color: #3ab6cc !important; }
			#roles_create-edit_table tbody td.permission-list div.permission:nth-child(9n) + div { clear: left !important; }
		}
        
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
                            
                            <div class="flds_rol_nm-lgn_acs flx-justify-start mb-14_">
          						<div class="wd-70p field fld-role_name mr-2p">
          							<label class="wd-100p txt-gray-6" style="color: #666;">Enter New Role Name <span class="text-danger">*</span></label>
          							<input type="text" class="wd-100p" name="name" required placeholder="Enter New Role Name" value="" maxlength="30">
          						</div>
								<div class="wd-30p field fld-login-access" style="min-width: 224px;">
										<label class="wd-100p txt-gray-6" style="color: #666;">Login access for </label>
										<div class="flx-justify-start wd-100p flex-vr-center" style="height: 30px;">
											<div class="radio-field cur-pointer mr-14_">
												<input type="radio" class="size-20_" id="all_access" name="permission[]" value="46" checked="" style="margin:0px;">
												<label for="all_access" style="margin:0px; line-height: 20px;">All Access</label>
											</div>
											<div class="radio-field cur-pointer">
												<input type="radio"  class="size-20_" id="practice_admin" name="permission[]" value="47" style="margin:0px;">
												<label for="practice_admin" style="margin:0px; line-height: 20px;">Practice Admin</label>
											</div>
										</div>
								</div>
							</div>
							
							
							<div class="trow_ table-responsive-1024 table-responsive">
								<table id="roles_create-edit_table" class="table bordered roles_table " style="width: 100%;">
									<thead>
										<tr class="weight_500-force-childs bg-blue">
											<th class="txt-wht module_td"><input type="checkbox" id="select-all"> Modules</th>
											<th class="txt-wht bg-blue">Permissions</th>
										</tr>
									<tbody>
										@foreach($modules as $ind_key => $module)
										<tr class=@if($ind_key % 2 == 0) "bg-gray-f2" @elseif ($ind_key % 2 != 0) "bg-white" @endif>
											<td class="module_td text-sline">
												<input type="checkbox" class="module"
																		 id="{{ $module->id }}"> {{ $module->name }}
											</td>
											<td class="permission-list">
											@foreach ($permissions as $permission)
											  @if ($permission->module_id == $module->id)
											  <div class="d-ib_ p4-12_ txt-wht permission">
												<input type="checkbox" name="permission[]"
													   value="{{ $permission->name }}" id="permission{{$permission->id}}"
													   class="{{ $module->id }} abc"
													   data-id="{{ $module->id }}"
												> <label for="permission{{$permission->id}}">{{ $permission->name }}</label>
											  </div>
											  @endif
											@endforeach
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							
							<div class="trow_ mt-7_">
                                <button type="button"  class="elm-left btn btn-xs btn-danger" style="min-width:120px;" onclick="window.location='{{ url("/roles") '">Cancel</button>&nbsp;
                                <button type="submit" id="save-module" class="elm-right btn bg-blue-txt-wht weight_500 fs-14_" style="min-width: 120px;">Save</button>
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
