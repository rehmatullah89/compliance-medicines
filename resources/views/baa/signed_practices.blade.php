@extends('layouts.compliance')

@section('content')

<style>
table.bordered.baa_mgmt_table { border-collapse: separate; border: 0px; }
table.bordered.baa_mgmt_table thead {  }
table.bordered.baa_mgmt_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4;}
table.bordered.baa_mgmt_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
table.bordered.baa_mgmt_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }

table.bordered.baa_mgmt_table tbody {  }
table.bordered.baa_mgmt_table tbody tr {  }
table.bordered.baa_mgmt_table tbody tr td { vertical-align: middle; }
table.bordered.baa_mgmt_table tbody tr td:first-child { border-left: solid 1px #ccc; }
table.bordered.baa_mgmt_table tbody tr td:last-child { border-right: solid 1px #ccc; }
table.bordered.baa_mgmt_table tbody tr:last-child {  }
table.bordered.baa_mgmt_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
table.bordered.baa_mgmt_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
table.bordered.baa_mgmt_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }

table.bordered.baa_mgmt_table tbody tr td.image-magnify img { position: relative; margin-left: 4px; border: 0px; border: solid 1px #cecece; }
table.bordered.baa_mgmt_table tbody tr td.image-magnify img:hover { transform: scale(3); border: solid 1px #242424;z-index: 400;}

</style>

<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12">
		<h4 class="elm-left fs-24_ mb-3_ txt-gray-6">BAA & RPPA Management</h4>
		<div class="date-time elm-right lh-28_ mb-3_">{{ date('D, M d, Y H:i A')}}</div>
	</div>
</div>

<div class="row pt-14_">
	<div class="col-sm-12 pl-0 pr-0" style="display: flex; align-items: flex-end; justify-content: flex-start;">
	{{--	<form class="elm-left c-dib_ compliance-form_" style="width: inherit">
		<div class="wd-18p mr-1p field-practice_name" style="min-width: 200px;">
                                    <div class="form-group mb-10_">
                                        <label class="weight_600">Practice Name</label>
                                        <select id="practice_name" class="form-control all-results-select-control"
                                                name="practice_name">
                                            <option value="">All</option>
                                            @foreach($practices as $par)
                                                <option value="{{ $par['id'] }}">{{ $par['practice_name'] }} {{ $par['branch_name']?'( '.$par['branch_name'].' )':'' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

								{{-- <div class="wd-18p mr-1p field-service" style="min-width: 200px;">
                                    <div class="form-group mb-10_">
                                        <label class="weight_600">Document Type</label>
                                        <select id="document_name" class="form-control all-results-select-control" name="document_name">
												<option value="">Document Type</option>
												<option value="both">Both</option>
                                                <option value="baa">BAA</option>
												 <option value="rppa">Pharmacy Agreement</option>
                                        </select>
                                    </div>
                                </div> 
		</form>--}}
	</div>
</div>



<div class="row">
	<div class="col-sm-12">

		<div class="row mt-14_ mb-7_ mr-0">
			<div class="col-sm-12  pr-0 pl-0 table-responsive">
				<table class="table bordered baa_mgmt_table datatable" id="baa_table" style="min-width: 1140px;">
					<thead>
						<tr class="weight_500-force-childs bg-blue">
							<th class="txt-wht">Practice Name</th>
							<th class="txt-wht">Signatory Name</th>
							<th class="txt-wht">Document Type</th>
							<th class="txt-wht">Expire Date</th>
							<th class="txt-wht">Date Sign by Practice</th>
							<th class="txt-wht">Signature by Practice</th>
							<th class="txt-wht">Signature by CR</th>
							<th class="txt-wht">Action</th>
						</tr>
					</thead>
					<tbody>
                    @foreach($practices AS $i => $practice)
						<tr>
							<td><a class="txt-blue_sh-force td_u_force" href="javascript:void(0)" onclick="open_edit_practice({{$practice['id']}})">{{ $practice['practice_name'] }} {{ (isset($practice['branch_name']) && $practice['branch_name'])?'( '.$practice['branch_name'].' )':'' }}</a></td>
							<td class="txt-blue">{{ $practice['business_agreement']['accepted_terms_user'] }}</td>
							<td class="txt-blue">{{ ($practice['business_agreement']['accepted_terms'] == 1 && $practice['business_agreement']['rp_accepted_terms'] == 1 ? 'BBA & Pharma' : ($practice['business_agreement']['accepted_terms'] == 1 ? 'BAA' : 'Pharmacy Agreement') ) }}</td>
						    <td class="text-sline">{{ Carbon\Carbon::parse($practice['business_agreement']['accepted_terms_dt'])->addYear()->format('m-d-Y h:m')}}</td>
							<td class="text-sline">{{ date('m/d/Y', strtotime($practice['business_agreement']['accepted_terms_dt'])) }}</td>
							<td class="cnt-left-force image-magnify c-dib_ pt-4_ pb-4_ text-sline" style="min-width: 200px;">
                                @if(Storage::disk('public')->has($practice['business_agreement']['accepted_terms_signature']))
							BAA: <img src="{{asset('storage/'.$practice['business_agreement']['accepted_terms_signature']) }}" class="brdr-1-eee br-rds-4" style="max-width: 70px;">
                            @endif
                            @if(Storage::disk('public')->has($practice['business_agreement']['rp_accepted_terms_signature']))
                            RPPA:<img src="{{asset('storage/'.$practice['business_agreement']['rp_accepted_terms_signature']) }}" class="brdr-1-eee br-rds-4" style="max-width: 70px;">
                        @endif
                        </td>
							<td class="cnt-left-force image-magnify c-dib_ pt-4_ pb-4_ text-sline" style="min-width: 200px;">
                                @if(Storage::disk('public')->has($practice['business_agreement']['crb_accepted_terms_signature']))
                                BAA:<img src="{{asset('storage/'.$practice['business_agreement']['crb_accepted_terms_signature']) }}" class="brdr-1-eee br-rds-4" style="max-width: 70px;">
                                @endif
                                @if(Storage::disk('public')->has($practice['business_agreement']['cr_accepted_terms_signature']))
							RPPA:<img src="{{asset('storage/'.$practice['business_agreement']['cr_accepted_terms_signature']) }}" class="brdr-1-eee br-rds-4" style="max-width: 70px;">
                            @endif
							</td>
                            <td class="cnt-center-force c-dib_ text-sline">
								<a title="View BAA Agreement" href="{{url('view-baa/'.$practice['id'])}}" target="_blank" class="mr-3_ hover-black-child_ txt-blue"><span class="fa fa-eye fs-17_ txt-blue"></span></a>
								<a title="View Retailer Agreement" href="{{url('view-rppa/'.$practice['id'])}}" target="_blank" class="mr-3_ hover-black-child_ txt-blue"><span class="fa fa-eye fs-17_ txt-blue"></span></a>
                                <a title="Edit BAA Agreement" href="{{url('edit-baa/'.$practice['id'])}}" class="mr-3_ hover-black-child_ txt-grn-dk" target="_blank"><span class="fa fa-pencil fs-17_ txt-grn-dk"></span></a>
                                <a title="Edit RPPA Agreement" href="{{url('edit-rppa/'.$practice['id'])}}" class="mr-3_ hover-black-child_ txt-grn-dk" target="_blank"><span class="fa fa-pencil fs-17_ txt-grn-dk"></span></a>
                               	<a title="Download BAA Agreement" href="{{ url('download_agreement/'.$practice['id'].'/baa') }}" class="ml-3_ hover-black-child_ txt-orange"><span class="fs-17_ txt-orange fa fa-arrow-circle-o-down "></span></a>
                               <a title="Download RPPA Agreement" href="{{ url('download_agreement/'.$practice['id'].'/rppa') }}" class="ml-3_ hover-black-child_ txt-orange"><span class="fs-17_ txt-orange fa fa-arrow-circle-o-down "></span></a>

                               <a title="Print BAA Agreement" href="{{url('view-baa/'.$practice['id'].'?print=1')}}" class="ml-3_ hover-black-child_ txt-gray-6" target="_blank"><span class="fa fa-print txt-gray-6 fs-17_"></span></a>
							</td>
						</tr>
                    @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


@include('partials.modal.practice_add')
@endsection

@section('js')
@include('partials.js.practice_js')

<script type="text/javascript">
$(document).ready(function(){
	table = $("#baa_table").DataTable();
});

var practices = JSON.parse('{!! json_encode($practices) !!}');
var new_practices = [];
$("#practice_name, #document_name").change(function(){
	pid = $("#practice_name").val();
	atype = $("#document_name").val();
	console.log(pid, atype);

	filterData(pid, atype);
});

function filterData(p_id, type)
{
	if(p_id || type)
	{
		if(p_id != "")
			new_practices = practices.filter(p => p.id == p_id);
		else
			new_practices = practices;

		if(type)
		{
			console.log('type');
			switch(type)
			{
				case 'baa':
					new_practices = new_practices.filter(p => p.business_agreement.accepted_terms == 1 && p.business_agreement.rp_accepted_terms != 1);
					break;
				case 'rppa':
					new_practices = new_practices.filter(p => p.business_agreement.rp_accepted_terms == 1);
					break;
				case 'both':
					console.log('both');
					new_practices = new_practices.filter(p => p.business_agreement.accepted_terms == 1 && p.business_agreement.rp_accepted_terms == 1);
					break;
				defalt:
					new_practices = new_practices;
					break;
			}

		}

		renderTable(new_practices);
	}
	else
	{
		new_practices = practices;

		renderTable(new_practices);
	}

}

function renderTable(np)
{
	console.log(new_practices);
	table.destroy();

	$("#baa_table tbody").empty();

	np.forEach(function(prac){
		var currentTime = new Date(prac.business_agreement.accepted_terms_dt);
  var day = currentTime.getDate();
  var month = currentTime.getMonth() + 1;
  var year = currentTime.getFullYear() +1;

var h = currentTime.getHours();
var m = currentTime.getMinutes();
  if (day < 10){
  day = "0" + day;
  }

  if (month < 10){
  month = "0" + month;
  }

  var today_date = month + "-" + day + "-" + year +' '+h+':'+m;
//   document.write(today_date.toString());
		$("#baa_table tbody").append(`<tr>
							<td><a class="txt-blue_sh-force td_u_force">${prac.practice_name} ${prac.branch_name ? '( '+prac.branch_name+' )' :'' }</a></td>
							<td class="txt-blue">${prac.business_agreement.accepted_terms_user}</td>
							<td class="txt-blue">${prac.business_agreement.accepted_terms == 1 && prac.business_agreement.rp_accepted_terms == 1 ? 'BBA & Pharma' : (prac.business_agreement.accepted_terms == 1 ? 'BAA' : 'Pharmacy Agreement') }</td>
							<td>${ today_date.toString()}</td>
							<td>${prac.business_agreement.accepted_terms_dt}</td>
							<td class="cnt-left-force c-dib_ pt-4_ pb-4_">
                                BAA: <img src="{{asset('storage')}}/${prac.business_agreement.accepted_terms_signature}" class="brdr-1-eee br-rds-4" style="max-width: 70px;">
                            RPPA:<img src="{{asset('storage')}}/${prac.business_agreement.rp_accepted_terms_signature}" class="brdr-1-eee br-rds-4" style="max-width: 70px;">
                        </td>
							<td class="cnt-left-force c-dib_ pt-4_ pb-4_">
							<img src="{{asset('storage')}}/${prac.business_agreement.cr_accepted_terms_signature}" class="brdr-1-eee br-rds-4" style="max-width: 70px;"></td>
                            <td class="cnt-center-force c-dib_">
								<a title="View BAA Agreement" href="{{url('view-baa')}}/${prac.id}" target="_blank" class="mr-3_ hover-black-child_ txt-blue"><span class="fa fa-eye fs-17_ txt-blue"></span></a>
								<a title="View Retailer Agreement" href="{{url('view-rppa')}}/${prac.id}" target="_blank" class="mr-3_ hover-black-child_ txt-blue"><span class="fa fa-eye fs-17_ txt-blue"></span></a>
                                <a href="{{url('edit-rppa')}}/${prac.id}" class="mr-3_ hover-black-child_ txt-grn-dk" target="_blank"><span class="fa fa-pencil fs-17_ txt-grn-dk"></span></a>
                                <a href="{{url('edit-baa')}}/${prac.id}" class="mr-3_ hover-black-child_ txt-grn-dk" target="_blank"><span class="fa fa-pencil fs-17_ txt-grn-dk"></span></a>
								<a href="#action-download" class="ml-3_ hover-black-child_ txt-orange"><span class="fs-17_ txt-orange fa fa-arrow-circle-o-down "></span></a>
								<a href="{{url('view-baa')}}/${prac.id+'?print=1'}" class="ml-3_ hover-black-child_ txt-gray-6" target="_blank"><span class="fa fa-print txt-gray-6 fs-17_"></span></a>
							</td>
						</tr>`);
	});

	table = $("#baa_table").DataTable();

}
</script>

@endsection
