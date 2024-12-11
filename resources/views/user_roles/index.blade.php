@extends('layouts.compliance')

@section('content')

    <style>
        .error {
            border-color: red !important;
        }

        table.bordered.roles_table { border-collapse: separate; border: 0px; }
        table.bordered.roles_table thead {  }
        table.bordered.roles_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4; border: 0px !important; }
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
        
        
        
        #modal-permission-assign input[type="checkbox"]:not(.circled):before { background-color: #fff; }
        #modal-permission-assign .modal-body table.bordered th:first-child { border-radius: 0px 0px 0px 0px; }
        #modal-permission-assign .modal-body table.bordered th:last-child { border-radius: 0px 0px 0px 0px; }
        #modal-permission-assign .modal-body table.bordered.roles_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 0px; }
        #modal-permission-assign .modal-body table.bordered.roles_table tbody tr:last-child td:last-child { border-radius: 0px 0px 0px 0px; }
        #modal-permission-assign .modal-body .table-responsive { padding-bottom: 0px !important; }
        #modal-permission-assign .modal-body table.bordered.roles_table { margin-bottom: 0px !important; }

    </style>
    
    
    <div class="row" style="border-bottom: solid 1px #cecece;">
    	<div class="col-sm-12">
    		<h4 class="elm-left fs-24_ mb-3_">User Roles</h4>
        	{{-- <button data-toggle="modal" data-target="#modal-add-new-role" class="btn bg-blue-txt-wht elm-right weight_600 ml-14_ fs-14_" style="line-height: 24px;padding: 0px .75rem;">+ Add New Role</button> --}}
            {{-- <div class="add-role elm-right ml-14_"><a class="btn bg-blue-txt-wht  weight_600  fs-14_" href="{{ url("roles/create") }}" style="line-height: 24px;padding: 0px .75rem;">+ Add New Role</a></div> --}}
            <div class="date-time elm-right lh-28_ mb-3_">{{  now('America/Chicago')->isoFormat('LLLL') }}</div><!-- &#10133; +  -->
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-sm-12">
    		
    		<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12  table-responsive">
    				
    				<table class="table bordered roles_table" id="role_table" style="min-width: 1024px;">
    					<thead>
    						<tr class="weight_500-force-childs bg-blue">
    							
								<th class="txt-wht bg-tb-blue" scope="col" style="width:120px;">Name</th>
								<th class="txt-wht bg-orange" scope="col"  style="width:150px;">Email</th>
                                <th class="txt-wht bg-grn-lk" scope="col">Roles</th>
                                <th class="txt-wht bg-red cnt-center-force" scope="col"  style="width:50px;">Action</th>
    						</tr>
    					</thead>
    					
    					
    					<tbody>
                            @foreach($data as $value)                           
                            <tr id="role_{{$value->id}}">
                                <!--   <th>#</th> -->
                                <td class="txt-blue bg-tb-blue-lt tt_uc_ weight_600"  style="border-bottom: solid 1px #d0d8e3;">{{ $value->name }} </td>
                                <td class="txt-blue bg-tb-orange-lt tt_uc_ weight_600" style="border-bottom: solid 1px #d6dbc7">{{ $value->email }} </td>
                                
                                <td class="txt-gray-7e bg-tb-grn-lt tt_uc_ weight_600" style="border-bottom: solid 1px #d6dbc7">
                                    @foreach($value->roles  as $index => $role)
                                        @if($index < 5)
                                            {{ $role->name }},
                                        @endif
                                    @endforeach
                                </td>
                                <td class="cnt-center-force bg-tb-pink2 c-dib_" style="border-bottom: solid 1px #e4cac9">
                                    <div class="action-links">
                                        <a class="hover-black-child_ txt-grn-dk mr-7_" href="{{ url('user-roles/'.$value->id.'/edit') }}"><span class="fa fa-pencil fs-17_ txt-grn-dk"></span></a>
                                       {{-- <a class="hover-black-child_ txt-red" href="javascript:void(0);" onclick="userRoleDel({{$value->id}});"><span class="fa fa-trash-o txt-red fs-17_"></span></a> --}}
                                    </div>
                                    <form id="del-form" action="{{ url('roles/'.$value->id) }}" method="POST" style="">
                                        {{ csrf_field() }}
                                        {{ method_field('delete')}}
                                    </form>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
    					
    				</table>
    				
    			</div>
    		</div>
    		
    	</div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function(){
                @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
            @endif
            
            $("#role_table").DataTable({
                            processing: false,
                            serverSide: false,
                            Paginate: false,
                            lengthChange: false,
                            pageLength : 10,
                            order:[],
                            bFilter: false,
                            columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                      ]
                        });
        });
        function userRoleDel(id) {
            event.preventDefault();
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": 0,
                "extendedTimeOut": 0,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            }

            var $toast = toastr.error('Do you really want to remove this user role?<br /><button onclick="delete_record(' + id + ');" type="button" class="btn clear">Yes</button>');
            $toastlast = $toast;
        }
        function delete_record(id) {
            toastr.clear();
            var url = "{{url('user-roles')}}";
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: url+'/'+id,
                data: {
                    id: id,
                    _method: 'DELETE'
                },
                success: function (data) {
                    toastr.clear();
                    $('#role_' + id).fadeOut("slow", function () {
                        $(this).remove();
                    });
                    $('#toast-container').remove();
                    toastr.success('Message', 'Module deleted succesfully', { 'timeOut': 3000 });
                },
                headers: {
                    'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                }
            });
        }
    </script>

@endsection
