@extends('layouts.compliance')

@section('content')

    <style>
        .error {
            border-color: red !important;
        }
    </style>
    <section>
        <div class="container_new_inner">
            <div class="inner_content_practice">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table_content_cont">
                            <div class="practice_search">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6 col-md-6 float-left">
                                        <h2 class="spacing_left_zero">Permissions</h2>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-md-6 top-ad-nw-rl-links cnt-right float-right">
                                        <button onclick="window.location='{{ url("permissions/create") }}'" class="pull-right ad-nw-perm"><i class="fa fa-plus"></i>Add New Permission</button>
                                        {{--<button onclick="window.location='{{ url("roles") }}'" class="pull-right roles__">Roles</button>--}}
                                        {{--<button onclick="window.location='{{ url("modules") }}'" class="pull-right modules__">Modules</button>--}}
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <table id="searchPracticeResult" class="table table-striped table-responsive w-100 d-block d-md-table">
                                                <thead>
                                                <tr>
                                                    {{-- <th scope="col">#</th>--}}
                                                    <th class="name-col" scope="col">Name</th>
                                                    <th class="perm-col" scope="col">Permission For Module</th>
                                                    <th class="action-col" scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $data)
                                                    <tr id="module_{{$data->id}}">
                                                        <td class="name-col Name_img">{{ $data->name }} </td>
                                                        <td class="perm-col Name_img">{{ $data->modules['name'] }} </td>
                                                        <td class="action-col Name_img">
                                                            <form id="del-form" action="{{ url('permissions/'.$data->id) }}" method="POST" style="">
                                                                {{ csrf_field() }}
                                                                {{ method_field('delete')}}
                                                                <a href="{{ url('permissions/'.$data->id.'/edit') }}" class="fa fa-edit btn edit_btn_"><span>Edit</span></a>
                                                                <a id="{{$data->id}}" onclick="practice_del(this.id)" class="btn fa fa-trash-o trash_btn_" ><span>Delete</span></a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

            var $toast = toastr.error('Do you want remove this Module?<br /><button onclick="delete_record(' + id + ');" type="button" class="btn clear">Yes</button>');
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
                    toastr.success('Message', 'Permission delete succesfully');
                },
                headers: {
                    'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                }
            });
        }
    </script>
@endsection
