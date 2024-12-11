@extends('layouts.compliance')

@section('content')

<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12">
		<h4 class="elm-left fs-24_ mb-4_">Search Results</h4>
		<div class="date-time elm-right lh-28_ mb-3_">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
    <button class="btn elm-right bg-lt-grn-txt-wht weight_600 mr-14_ fs-14_" onclick="show_groups_modal_listing()" style="line-height: 24px;padding: .16rem .75rem;padding-bottom: 0px;">Enterprise Owner Management</button>

	</div>
</div>
<div class="row">
	<div class="col-sm-12">

		<div class="row">

			<div class="col-sm-6">
        @if(isset($patients))
        <div>
				<div class="row mt-7_ mb-7_">
                    <div class="col-sm-12">
                        <div class="elm-left c-mr-4_ fs-17-force-child_">
                            <span class="txt-blue weight_700 tt_uc_" style="line-height: 28px;">best patient match(es)</span>
                        </div>
                        <div class="elm-right">
        					<button class="btn bg-blue-txt-wht weight_600 fs-14_" style="line-height: 24px;padding: .16rem .75rem;padding-bottom: 0px;" onclick="window.location.href = '{{url("patient/create")}}'">+ Add Patient</button>
        				</div>
                    </div>
                </div>

                <div class="row">
        			<div class="col-sm-12 table-responsive">
        				<table class="table bordered data-table" id="patient_comp_table">
        					<thead>
        						<tr class="weight_500-force-childs">
        							<th class="txt-blue">First Name</th>
        							<th class="txt-blue">Last Name</th>
        							<th class="txt-blue">Gender</th>
        							<th class="txt-blue">DOB</th>
        							<th class="txt-blue">Phone</th>
        							<th class="txt-blue">Zip</th>
        						</tr>
        					</thead>
        					<tbody id="append_field_patients">
                                                    @if(!empty($patients))
                                                        @foreach($patients as $keyPat=>$valPat)
                                                        <tr onclick="select_patient({{ $valPat->Id }});">
                                                            <td class="hilight-flag"><a class="txt-blue_sh-force td_u_force">{{ $valPat->first_name }}{{($valPat->pip_count>0?" -PIP":"")}}</a></td>
                                                            <td class="hilight-flag">{{ $valPat->last_name }}</td>
                                                            <td >{{ $valPat->Gender }}</td>
                                                            <td >{{ $valPat->dob }}</td>
                                                            <td class="phone_format hilight-phone">{{ $valPat->mobile_number }}</td>
                                                            <td class=" hilight-flag">{{ $valPat->ZipCode }}</td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="6" style="text-align:center;">Patient Not Found</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
        				</table>
        			</div>
        		</div>
          </div>
            @endif
			</div>


			<div class="col-sm-6">
        @if(isset($practices))
        <div>
				<div class="row mt-7_ mb-7_">
                    <div class="col-sm-12">
                        <div class="elm-left c-mr-4_ fs-17-force-child_">
                            <span class="txt-orange_red weight_700 tt_uc_" style="line-height: 28px;">best practice @hasrole('super_admin') & branch @endhasrole match(es)</span>
                        </div>
                        <div class="elm-right">
        					<button class="btn bg-orange_red-txt-wht weight_600 fs-14_" style="line-height: 24px; padding: .1rem .75rem;" onclick="viewAddPractice();">+  Add @hasrole ('super_admin') Branch @else Practice @endhasrole</button>
        				</div>
                    </div>
                </div>

                <div class="row">
        			<div class="col-sm-12 table-responsive">
        				<table class="table bordered data-table practice_datatable" id="practice_comp_table">
        					<thead>
        						<tr class="weight_500-force-childs">
                                    @hasrole('super_admin')<th class="txt-orange_red">Branch Name</th>@endhasrole
                                    @if(auth::user()->hasanyrole('compliance_admin|practice_super_group') || auth::user()->can('all access'))<th class="txt-orange_red">Type</th>@endif
        							<th class="txt-orange_red">Name</th>
        							<th class="txt-orange_red">Zip</th>
        							<th class="txt-orange_red">Phone</th>
        							<th class="txt-orange_red">Site Contact</th>
        						</tr>
        					</thead>
                                                <tbody id="append_field_practices">
                                                @if(!empty($practices))
                                                    @foreach($practices as $keyPra=>$valPra)
                                                    <tr data-prid="{{$valPra->id}}">
                                                        <td  class="col-type">
                                                            @hasrole('super_admin')<a class="txt-orange_red-force td_u_force" onclick="open_edit_practice({{$valPra->id}})">{{ $valPra->branch_name?$valPra->branch_name:$valPra->practice_name." (Main)" }}</a>@endhasrole
                                                            @if(auth::user()->hasanyrole('compliance_admin|practice_super_group') || auth::user()->can('all access'))<a class="txt-orange_red-force td_u_force" onclick="open_edit_practice({{$valPra->id}})">{{ $valPra->practice_type }}</a>@endif
                                                            <a href="javascript:void(0)" onclick="window.location.href = '{{url("update-session-practice/".$valPra->id)}}'" class="elm-right hover-black-child_">
                                                                <img src="{{asset('images/svg/select-icon.svg')}}" />
                                                            </a>
                                                            {{--<a href="javascript:void(0)" onclick="open_edit_practice({{$valPra->id}})" class="elm-right hover-black-child_">
                                                                <span class="fa fa-pencil fs-17_ txt-grn-dk"></span>
                                                            </a>--}}



                                                        </td>
                                                        <td class="col-name hilight-flag p-name">{{ $valPra->practice_name }} {{ $valPra->branch_name?"(".$valPra->branch_name.")":'' }}</td>
                                                        <td class="col-zip hilight-flag p-zip">{{ $valPra->practice_zip }}</td>
                                                        <td class="col-phone phone_format hilight-phone p-phone">{{ $valPra->practice_phone_number }}</td>
                                                        <td class="col-site-content site-cnt">@if(isset($valPra->users[0]->name)){{ $valPra->users[0]->name }} @else {{ 'N/A' }} @endif</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="5" style="text-align:center;">Practice Not Found</td>
                                                </tr>
                                                @endif
                                            </tbody>

        				</table>
        			</div>
        		</div>
          </div>
        @endif
			</div>

		</div>


	</div>
</div>



<div class="modal" id="sponsor-Add-Modal">
  <div class="modal-dialog wd-87p-max_w_700">
    <form class="modal-content compliance-form_">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Banner</h4>
        <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
      </div>

      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">

  					<div class="flds-ttl-typ-pos flx-justify-start mb-14_">
  						<div class="wd-33p field field-modal fld-title mr-1p">
  							<label class="wd-100p" class="trow_">Title:</label>
  							<input class="wd-100p" class="trow_" type="text">
  						</div>
  						<div class="wd-32p field field-modal fld-type mr-1p">
  							<label class="wd-100p">Type:</label>
  							<select class="wd-100p">
                              <option selected disabled>Select Type</option>
                              <option>Type1</option>
                              <option>Type2</option>
                              <option>Type3</option>
                            </select>
  						</div>
  						<div class="wd-32p field field-modal fld-position">
  							<label class="wd-100p">Position:</label>
  							<select class="wd-100p">
                              <option selected disabled>Select Position</option>
                              <option>Position1</option>
                              <option>Position2</option>
                              <option>Position3</option>
                            </select>
  						</div>
  					</div>

  					<div class="flds-pg_loc-up_img flx-justify-start">

  						<div class="wd-33p field field-modal fld-marketer mr-1p">
          					<label class="wd-100p">Page Location:</label>
                            <select class="wd-100p">
                              <option selected disabled>Select Location</option>
                              <option>Location1</option>
                              <option>Location2</option>
                              <option>Location3</option>
                            </select>
                        </div>
                        <div class="wd-32p field field-modal fld-mrc">
                            <label class="wd-100p">Upload Image:</label>
                            <input class="wd-100p" type="file">
                        </div>
                    </div>
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      		<div class="flx-justify-start wd-100p">
        		<button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">ADD</button>
        		<button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ ml-14_ " data-dismiss="modal">CANCEL</button>
        	</div>
      </div>

    </form>
  </div>
</div>
<style>
    /*#dob_col{ width:110px !important; }*/
    #append_field_patients tr { cursor:pointer; }
    #append_field_practices tr { cursor:pointer; }
    </style>

    @include('partials.modal.practice_add')
    @include('partials.modal.add_show_groups')
@endsection
@section('js')
 <script>
     /*
           $(document).ready( function () {
        $('#patient_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('admin/search-all') }}",
           columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'Gender', name: 'Gender' },
                    { data: 'dob', name: 'dob' },
                    { data: 'mobile_number', name: 'mobile_number' },
                    { data: 'ZipCode', name: 'ZipCode' }
                 ]
        });
     });
      */
 function highlight(string, text) {
 if(text != ''){
        var index = string.toLowerCase().indexOf(text.toLowerCase());
        var innerHTML = string;
        if (index >= 0) {

                innerHTML = innerHTML.substring(0,index) + "<span class='highlight'>" + innerHTML.substring(index,index+text.length) + "</span>" + innerHTML.substring(index + text.length);
            }

        return innerHTML;
         }
    }

    function highlight1(string, text) {

         var newstring = string.toLowerCase().replace(/[(-)-\s]/g, "");
         var newtext = text.toLowerCase().replace(/[(-)-\s]/g, "");
         var index = newstring.indexOf(newtext);
       //var index = newstring.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3");
      // console.log(index);
        var innerHTML = newstring;
        if (index >= 0) {

            innerHTML = "<span class='highlight'>" + innerHTML.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3") + "</span>" ;

           // innerHTML = innerHTML.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3");

            }else{ innerHTML = innerHTML.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3"); }
        return innerHTML;
    }

    $(document).ready(function(){

        toastr.options = {
            "preventDuplicates": true,
            "preventOpenDuplicates": true
            };

    $('#patient_comp_table').DataTable({
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
             columns: [

            { data: 'FIRST' },
            { data: 'LAST' },
            { data: 'GENDER' },
            { data: 'DOB' },
            { data: 'Mobile', render: function (data, type, row) {
                return data.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3");
            } },
               { data: 'ZIP' },
        ],
        });

      $('#practice_comp_table').DataTable({
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
             columns: [

            { data: 'TYPE' },
            { data: 'NAME' },
            { data: 'ZIP' },
            { data: 'PHONE', render: function (data, type, row) {
                return data.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3");
            } },
               { data: 'SITE CONTACT' },
        ],
        });


        // $('td.hilight-flag').each(function(key, val){
        //      // $(this).html(highlight1($(this).html(), $('.phone_format').val()));
        //     var searchQuery = $('#keyword_search_all').val();
        //      if(Number.isInteger($('#keyword_search_all').val())){
        //          alert('yes number');
        //         searchQuery =  $('#keyword_search_all').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3");
        //      }
        //     $(this).html(highlight($(this).html(),searchQuery ));

        // });

        // $('.hilight-phone').each(function(key, val){
        //     //console.log($(this).text());
        //    // highlight1($(this).html(), $('#keyword_search_all').val());
        //     $(this).html(highlight1($(this).html(), $('#keyword_search_all').val()));
        // });

         // $('.phone_format').val($('.phone_format').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3"));

    });

    function select_practice(id)
    {
        $.ajax({
                type:'POST',
                url:"{{url('/update_session_practice')}}",
                data: 'practice_ids='+id,
                success:function(data) {
                   // location.reload();
                  // window.location = "{{ url('report/client_dashboard') }}";
                   if(data==1){ window.location = '{{ url("report/client_home") }}'; }
                   if(data==2){ window.location = '{{ url("report/client_dashboard") }}'; }
                   console.log(data);
                },
                 headers: {
                     'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                 }
             });
    }

function select_patient(id)
{
    //alert(id);
    window.location = '{{ url("patient/order") }}/'+id ;
}
</script>
@include('partials.js.practice_js')
@endsection
