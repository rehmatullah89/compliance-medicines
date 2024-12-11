@extends('layouts.compliance')

@section('content')

    <style>
        .error {
            border-color: red !important;
        }
        
        
        table.bordered.permissions_table { border-collapse: separate; border: 0px; }
        table.bordered.permissions_table thead {  }
        table.bordered.permissions_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4; border: 0px !important; }
        table.bordered.permissions_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
        table.bordered.permissions_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }
        
        table.bordered.permissions_table tbody {  }
        table.bordered.permissions_table tbody tr {  }
        table.bordered.permissions_table tbody tr td { vertical-align: top; }
        table.bordered.permissions_table tbody tr td:first-child { border-left: solid 1px #ccc; }
        table.bordered.permissions_table tbody tr td:last-child { border-right: solid 1px #ccc; }
        table.bordered.permissions_table tbody tr:last-child {  }
        table.bordered.permissions_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
        table.bordered.permissions_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
        table.bordered.permissions_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }

        
        
    </style>
    
    
    <div class="row" style="border-bottom: solid 1px #cecece;">
    	<div class="col-sm-12">
    		<h4 class="elm-left fs-24_ mb-3_">Permissions</h4>
            {{--<button data-toggle="modal" data-target="#modal-add-permissions" class="btn bg-blue-txt-wht  weight_600 ml-14_ fs-14_" style="line-height: 24px;padding: 0px .75rem;">+ Add New Permission</button>--}}
            <div class="add-role elm-right ml-14_"><a class="btn bg-blue-txt-wht  weight_600  fs-14_" href="{{ url("permissions/create") }}" style="line-height: 24px;padding: 0px .75rem;">+ Add New Permission</a></div>
            <div class="date-time elm-right lh-28_ mb-3_">{{  now('America/Chicago')->isoFormat('LLLL') }}</div><!-- &#10133; +  -->
    	</div>
    </div>
    
    <div class="row">
		<div class="col-sm-12">
		
			<div class="row mt-14_ mb-7_">
    			<div class="col-sm-12  table-responsive">
    
                    <table class="table bordered permissions_table" id="permission_table" style="min-width: 1024px;">
                        <thead>
                            <tr class="weight_500-force-childs bg-blue">
                                <th class="txt-wht bg-blue"  scope="col">Name</th>
    							<th class="txt-wht bg-grn-lk tt_uc_ " scope="col">Permission for Module</th>
    							<th class="txt-wht bg-red cnt-center-force" scope="col" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	
                        	@foreach($data as $data)
                                <tr id="module_{{$data->id}}">
                                    <td class="txt-blue bg-tb-blue-lt tt_uc_ weight_600" style="border-bottom: solid 1px #d0d8e3;">{{ $data->name }} </td>
                                    <td class="txt-gray-7e bg-tb-grn-lt tt_uc_ weight_600" style="border-bottom: solid 1px #d6dbc7">{{ $data->modules['name'] }} </td>
                                    <td class="bg-tb-pink2 cnt-center-force  c-dib_" style="border-bottom: solid 1px #e4cac9">
                                        <div class="action-links">
                                            <a class="mr-7_ hover-black-child_ txt-grn-dk" href="{{ url('permissions/'.$data->id.'/edit') }}"><span class="fa fa-pencil fs-17_ txt-grn-dk"></span></a> {{-- <i  class="far fa-edit"></i> --}}
                                            <a class="hover-black-child_ txt-red" href="javascript:void(0);" {{--onclick="practice_del({{$data->id}})"--}} ><span class="fa fa-trash-o txt-red fs-17_"></span></a>
                                        </div>
                                        <form id="del-form" action="{{ url('permissions/'.$data->id) }}" method="POST" style="">
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
            
            $("#permission_table").DataTable({
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


            var $toast = toastr.error('Do you really want to remove this Permission?<br /><button onclick="delete_record(' + id + ');" type="button" class="btn clear">Yes</button>');

            $toastlast = $toast;
        }
        function delete_record(id) {
            toastr.clear();
            var url = "{{url('permissions')}}";
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
                    $('#module_' + id).fadeOut("slow", function () {
                        $(this).remove();
                    });
                    $('#toast-container').remove();
                    toastr.success('Message', 'Permission deleted succesfully', { 'timeOut': 3000 });
                },
                headers: {
                    'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                }
            });
        }
        
    </script>
@endsection
