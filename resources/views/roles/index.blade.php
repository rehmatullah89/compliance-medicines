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
		
		td.wd-adjust > span{ float: left;margin-right: 4px;width: 190px; display: inline-block; font-size: 12px; margin-bottom: 4px;}
		
		table.roles_table thead th.modules-td { width: 137px !important; }
		@media only screen and (max-width: 1246px)
		{
			table.roles_table tbody tr td > span:nth-child(4n-3) { color: #3e7bc4; }
			table.roles_table tbody tr td > span:nth-child(4n-2) { color: #dda600 !important; }
			table.roles_table tbody tr td > span:nth-child(4n-1) { color: #a5cb29 !important; }
			table.roles_table tbody tr td > span:nth-child(4n) { color: #f04214 !important; }
			table.roles_table tbody tr td > span:nth-child(4n) + span { clear: left !important; }
		}
		
		@media only screen and (max-width: 1440px) and (min-width: 1247px)
		{
			table.roles_table tbody tr td > span:nth-child(5n-4) { color: #3e7bc4; clear: none !important;}
			table.roles_table tbody tr td > span:nth-child(5n-3) { color: #dda600 !important; }
			table.roles_table tbody tr td > span:nth-child(5n-2) { color: #a5cb29 !important; }
			table.roles_table tbody tr td > span:nth-child(5n-1) { color: #f04214 !important; }
			table.roles_table tbody tr td > span:nth-child(5n) { color: #00cab0 !important; }
			table.roles_table tbody tr td > span:nth-child(5n) + span { clear: left !important; }
		}
		
		@media only screen and (max-width: 1786px) and (min-width: 1441px)
		{
			table.roles_table tbody tr td > span:nth-child(6n-5) { color: #3e7bc4; clear: none !important;}
			table.roles_table tbody tr td > span:nth-child(6n-4) { color: #dda600 !important; }
			table.roles_table tbody tr td > span:nth-child(6n-3) { color: #a5cb29 !important; }
			table.roles_table tbody tr td > span:nth-child(6n-2) { color: #f04214 !important; }
			table.roles_table tbody tr td > span:nth-child(6n-1) { color: #00cab0 !important; }
			table.roles_table tbody tr td > span:nth-child(6n) { color: #b858c6 !important; }
			table.roles_table tbody tr td > span:nth-child(6n) + span { clear: left !important; }
		}
		
		@media only screen and (max-width: 2060px) and (min-width: 1787px)
		{
			table.roles_table tbody tr td > span:nth-child(7n-6) { color: #3e7bc4; clear: none !important;}
			table.roles_table tbody tr td > span:nth-child(7n-5) { color: #dda600 !important; }
			table.roles_table tbody tr td > span:nth-child(7n-4) { color: #a5cb29 !important; }
			table.roles_table tbody tr td > span:nth-child(7n-3) { color: #f04214 !important; }
			table.roles_table tbody tr td > span:nth-child(7n-2) { color: #00cab0 !important; }
			table.roles_table tbody tr td > span:nth-child(7n-1) { color: #b858c6 !important; }
			table.roles_table tbody tr td > span:nth-child(7n) { color: #4dd146 !important; }
			table.roles_table tbody tr td > span:nth-child(7n) + span { clear: left !important; }
		}
		
		
		@media only screen and (max-width: 2300px) and (min-width: 2061px)
		{
			table.roles_table tbody tr td > span:nth-child(8n-7) { color: #3e7bc4; clear: none !important;}
			table.roles_table tbody tr td > span:nth-child(8n-6) { color: #dda600 !important; }
			table.roles_table tbody tr td > span:nth-child(8n-5) { color: #a5cb29 !important; }
			table.roles_table tbody tr td > span:nth-child(8n-4) { color: #f04214 !important; }
			table.roles_table tbody tr td > span:nth-child(8n-3) { color: #00cab0 !important; }
			table.roles_table tbody tr td > span:nth-child(8n-2) { color: #b858c6 !important; }
			table.roles_table tbody tr td > span:nth-child(8n-1) { color: #4dd146 !important; }
			table.roles_table tbody tr td > span:nth-child(8n) { color: #5c6ec6 !important; }
			table.roles_table tbody tr td > span:nth-child(8n) + span { clear: left !important; }
		}
		
		@media only screen and (min-width: 2301px) 
		{
			table.roles_table tbody tr td > span:nth-child(9n-8) { color: #3e7bc4; clear: none !important;}
			table.roles_table tbody tr td > span:nth-child(9n-7) { color: #dda600 !important; }
			table.roles_table tbody tr td > span:nth-child(9n-6) { color: #a5cb29 !important; }
			table.roles_table tbody tr td > span:nth-child(9n-5) { color: #f04214 !important; }
			table.roles_table tbody tr td > span:nth-child(9n-4) { color: #00cab0 !important; }
			table.roles_table tbody tr td > span:nth-child(9n-3) { color: #b858c6 !important; }
			table.roles_table tbody tr td > span:nth-child(9n-2) { color: #4dd146 !important; }
			table.roles_table tbody tr td > span:nth-child(9n-1) { color: #5c6ec6 !important; }
			table.roles_table tbody tr td > span:nth-child(9n) { color: #3ab6cc !important; }
			table.roles_table tbody tr td > span:nth-child(9n) + span { clear: left !important; }
		}
		
		
		
		
		
		
    </style>
    
    
    <div class="row" style="border-bottom: solid 1px #cecece;">
    	<div class="col-sm-12">
    		<h4 class="elm-left fs-24_ mb-3_">Roles</h4>
        	{{-- <button data-toggle="modal" data-target="#modal-add-new-role" class="btn bg-blue-txt-wht elm-right weight_600 ml-14_ fs-14_" style="line-height: 24px;padding: 0px .75rem;">+ Add New Role</button> --}}
            
            <div class="add-role elm-right ml-14_"><a class="btn bg-blue-txt-wht  weight_600  fs-14_" href="{{ url("roles/create") }}" style="line-height: 24px;padding: 0px .75rem;">+ Add New Role</a></div>
            <div class="date-time elm-right lh-28_ mb-3_">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
            <button class="btn elm-right bg-lt-grn-txt-wht weight_600 mr-14_ fs-14_" onclick="show_facilitator_modal_listing()" style="line-height: 24px;padding: .16rem .75rem;padding-bottom: 0px;">Facilitator Management</button>
            <!-- &#10133; +  -->
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-sm-12">
    		
    		<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12  table-responsive">
    				
    				<table class="table bordered roles_table" id="role_table" style="min-width: 1024px;">
    					<thead>
    						<tr class="weight_500-force-childs bg-blue">
    							
    							<th class="txt-wht bg-blue modules-td" scope="col">Modules</th>
                                <th class="txt-wht bg-blue cnt-center" scope="col">Permissions</th>
                                <th class="txt-wht bg-blue cnt-center-force" scope="col" style="width:50px;">Action</th>
    							
    						</tr>
    					</thead>
    					
    					
    					<tbody>
                            <?php
                            $col_class= array(
                                "txt-blue",
                                "txt-orange7j",
                                "txt-grn-lt-7j",
                                "txt-red-7j",
                                "txt-cyan-7j",
                                "txt-purple-7j",
                                "txt-grn-shn-7j",
                                "txt-blue-dk-7j",
                                "txt-cyan2-7j"
                            ) ; 
                            ?>

                            @foreach($permissions as $ind_key => $value)
                            <tr id="role_{{$value->id}}" data-key=""
							class=@if($ind_key % 2 == 0) "bg-gray-f2" @elseif ($ind_key % 2 != 0) "bg-white" @endif>
                                <!--   <th>#</th> -->
                                <td class="txt-blue tt_uc_  weight_600" style="border-bottom: solid 1px #d0d8e3;">{{ $value->name }} </td>
								<!-- bg-tb-blue-lt bg-tb-grn-lt bg-tb-blue-lt-->
                                <td class="txt-gray-7e tt_uc_ wd-adjust  weight_500 fs-12_" style="border-bottom: solid 1px #d6dbc7">
                                    <?php $i=0; ?>
                                    @foreach($value->permissions  as $index => $permiss)
                                        @if($index < 50)
                                        @if($i>8)
                                            <?php $i=0;?>
                                        @endif
                                           <span class="{{$col_class[$i]}}"> {{ $permiss->name }} ,</span>
                                           @if(strlen($permiss->name) > 30) 
                                           &nbsp 
										   @else
										   {{--&nbsp &nbsp &nbsp &nbsp &nbsp --}}
										   @endif
										   {{--@if($index % 2 == 0)  @elseif ($index % 3 == 0) <br>  @endif--}}
                                  @endif
                                  <?php $i++; ?>
                                    @endforeach
                                </td>
                                <td class="cnt-center-force  c-dib_" style="border-bottom: solid 1px #e4cac9">
                                    <div class="action-links text-sline">
                                        <a class="hover-black-child_ txt-grn-dk mr-7_" href="{{ url('roles/'.$value->id.'/edit') }}"><span class="fa fa-pencil fs-17_ txt-grn-dk "></span></a>
                                        <a class="hover-black-child_ txt-red" href="javascript:void(0);" {{-- onclick="practice_del({{$value->id}});" --}}><span class="fa fa-trash-o txt-red fs-17_"></span></a>
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
@include('partials.modal.add_show_facilitators')
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
        function practice_del(id) {
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

            var $toast = toastr.error('Do you really want to remove this Role?<br /><button onclick="delete_record(' + id + ');" type="button" class="btn clear">Yes</button>');
            $toastlast = $toast;
        }
        function delete_record(id) {
            toastr.clear();
            var url = "{{url('roles')}}";
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
@include('partials.js.facilitator_js')
@endsection
