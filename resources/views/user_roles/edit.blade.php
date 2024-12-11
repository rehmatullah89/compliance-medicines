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
		
		
		
		table.bordered.user_roles_table { border-collapse: separate; border: 0px; }
        table.bordered.user_roles_table thead {  }
        table.bordered.user_roles_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4; border: 0px !important;}
        table.bordered.user_roles_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
        table.bordered.user_roles_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }
        
        table.bordered.user_roles_table tbody {  }
        table.bordered.user_roles_table tbody tr {  }
        table.bordered.user_roles_table tbody tr td { vertical-align: top; }
        table.bordered.user_roles_table tbody tr td:first-child { border-left: solid 1px #ccc; }
        table.bordered.user_roles_table tbody tr td:last-child { border-right: solid 1px #ccc; }
        table.bordered.user_roles_table tbody tr:last-child {  }
        table.bordered.user_roles_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
        table.bordered.user_roles_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
        table.bordered.user_roles_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }
		
		
		
		#roles_create-edit_table thead th { padding: 7px 0.3vw !important; padding-left: 14px !important; border: 0px !important; }
		#roles_create-edit_table thead th input[type="checkbox"] { margin: 0px; }
		#roles_create-edit_table thead th input[type="checkbox"]:before { border: solid 1px #3e7bc4; color: #3e7bc4; text-transform: uppercase; }
		#roles_create-edit_table thead th input[type="checkbox"]:checked:before {  }
		#roles_create-edit_table thead th input[type="checkbox"] + span { line-height: 1.4em;  }
		#roles_create-edit_table thead th input[type="checkbox"] + label { line-height: 1.4em; cursor: pointer; }
		
		#roles_create-edit_table tbody td { vertical-align: middle; padding-left: 14px !important; }
		#roles_create-edit_table tbody td input[type="checkbox"] { margin: 0px; }
		#roles_create-edit_table tbody td input[type="checkbox"]:before { border: solid 1px #3e7bc4; color: #3e7bc4; text-transform: uppercase; }
		#roles_create-edit_table tbody td input[type="checkbox"]:checked:before {  }
		#roles_create-edit_table tbody td input[type="checkbox"] + span { line-height: 1.4em; text-transform: uppercase; }
		#roles_create-edit_table tbody td input[type="checkbox"] + label { line-height: 1.4em; text-transform: uppercase; color: #242424; cursor: pointer; }
		
		
		
        
    </style>
<?php
        $userId = 0;
        $userName = "";
        foreach($data as $key => $value){
            $userId = $key;
            $userName = $value;
        }
?>
    <div class="row" style="border-bottom: solid 1px #cecece;">
    	<div class="col-sm-12">
    		<h4 class="elm-left fs-24_ mb-3_">Update User Roles</h4>
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
                        <form class="compliance-form_ trow_" method="post" action="{{ url('user-roles/'.$userId) }}" id="m_form_1">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            
                            <div class="flds_name flx-justify-start mb-14_">
          						<div class="wd-70p field fld-perm_name mr-1p">
          							<label class="wd-100p txt-gray-6" style="color: #666;">User Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="wd-100p" name="name" placeholder="Enter user name" value="{{$userName}}" readonly="" maxlength="30">          							
          						</div>
                            </div>

                            
                            <div class="trow_ table-responsive-1024 table-responsive">
                                <table id="roles_create-edit_table" class="table user_roles_table table bordered " style="width: 100%;">
                                    <thead>
                                    <tr class="weight_500-force-childs bg-blue" style="border-radius: 6px 6px 0px 0px !important;">
                                        <th class="txt-wht bg-grn-lk" style="border-radius: 6px 6px 0px 0px !important;"><input type="checkbox" id="select-all"> <label for="select-all">Roles</label> </th>
                                    </tr>
                                    <tr>
                                    <tbody>
                                    	@foreach($roles as $roleId => $role)                                            
                                        <tr>
                                              <td class="bg-tb-grn-lt" style="border-bottom: solid 1px #d6dbc7">
                                              	<input type="checkbox" name="roles[]"
                                                       value="{{ $role }}" id="roless{{ $roleId }}"
                                                       class="{{ $roleId }} abc"
                                                       data-id="{{ $roleId }}" {{in_array($roleId, $selected_roles)?'checked':''}} > <label for="roless{{ $roleId }}">{{ $role }}</label>
                                              </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            
                            <div class="trow_ mt-7_ cnt-left">
                                <button type="button"  class="elm-left btn btn-xs btn-danger" style="min-width: 120px;" onclick="window.location='{{ url("/user-roles") }}'">Cancel</button>&nbsp;
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

       /* $('.module').change(function () {

            var id = $(this).attr('id');

            var result = $(this).prop('checked');

            $('.' + id).prop('checked', result);

        });


        $('input[name="roles[]"]').on('click', function () {

            var data_id = $(this).data('id');

            if ($('input[data-id=' + data_id + ']:checked').length == $('input[data-id=' + data_id + ']').length) {

                $('#' + data_id).prop('checked', true);

            } else {

                $('#' + data_id).prop('checked', false);

            }

        });*/

        $('#select-all').change(function () {

            var result = $(this).prop('checked');

            $('input[type="checkbox"]').prop('checked', result);

        });


        $('input[name="roles[]"]').on('click', function () {

            var data_id = $(this).data('id');

            if ($('.abc:checked').length == $('.abc').length) {

                $('#select-all').prop('checked', true);

            } else {

                $('#select-all').prop('checked', false);

            }


        })


    </script>
@endsection
