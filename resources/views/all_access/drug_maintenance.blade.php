@extends('layouts.compliance')

@section('content')


<style>

table.bordered.drug_main_table { border-collapse: separate; border: 0px; }
table.bordered.drug_main_table thead {  }
table.bordered.drug_main_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4;}
table.bordered.drug_main_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
table.bordered.drug_main_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }

table.bordered.drug_main_table tbody {  }
table.bordered.drug_main_table tbody tr {  }
table.bordered.drug_main_table tbody tr td { vertical-align: top; }
table.bordered.drug_main_table tbody tr td:first-child { border-left: solid 1px #ccc; }
table.bordered.drug_main_table tbody tr td:last-child { border-right: solid 1px #ccc; }
table.bordered.drug_main_table tbody tr:last-child {  }
table.bordered.drug_main_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
table.bordered.drug_main_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
table.bordered.drug_main_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }

</style>

<div class="row" style="border-bottom: solid 1px #cecece;">
							<div class="col-sm-12">
								<h4 class="elm-left fs-24_ mb-4_">Drug Maintenance</h4>
								<div class="date-time elm-right">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
							</div>
						</div>
@can('drugs list view')						
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="elm-left c-mr-4_ mt-7_ mb-7_ fs-17-force-child_">
					<span class="txt-blue weight_700 " style="line-height: 28px;">RECENT
						PRACTICE ADDED PRODUCTS</span>
				</div>
				<div class="elm-right c-mr-4_ mt-7_ mb-7_ ">
					<button class="btn bg-orange-txt-wht weight_600 fs-14_ tt_uc_ " id="view_similar_drugs" 
					style="line-height: 20px; padding: .1rem .75rem;">View / similar drugs</button>
                    <button class="btn bg-blue-txt-wht weight_700 fs-14_"
                    data-toggle="modal" data-target="#drug-Add-Modal"
						style="line-height: 20px;padding: .16rem .75rem;padding-bottom: 0px;" onclick="add_drug()">+ Add Drug</button>
				</div>
				<!-- <div class="elm-right c-mr-4_ mt-7_ mb-7_ ">
                    <button class="btn bg-orange-txt-wht weight_700 fs-14_"
                    data-toggle="modal" data-target="#drug-Add-Modal"
						style="line-height: 20px;padding: .16rem .75rem;padding-bottom: 0px;">similar Drugs</button>
				</div> -->
				<!-- <div class="elm-right c-mr-4_ mt-7_ mb-7_ ">
                    <button class="btn bg-lt-grn-txt-wht weight_700 fs-14_"
                    data-toggle="modal" data-target="#drug-view-Modal"
						style="line-height: 20px;padding: .16rem .75rem;padding-bottom: 0px;">View Drugs</button>
				</div> -->
			</div>
		</div>
		<div class="row pl-14_ pr-14_">
			<div class="col-sm-12 pl-0 pr-0 table-responsive">
				<table class="table bordered drug_main_table" style="min-width: 700px;" id="drug_main_table">
					<thead>
						<tr class="weight_500-force-childs bg-blue">
							<th class="txt-wht" style="width: 140px;">NDC</th>
							<th class="txt-wht" style="width: 22%;">Drug Label Name</th>
							<th class="txt-wht" style="width: 100px;">Generic for</th>
							<th class="txt-wht">Strength</th>
							<th class="txt-wht">Marketer</th>
							<th class="txt-wht" style="width:114px;">Ingredient Cost</th>
							<th class="txt-wht" style="width:84px;">M/G/CMP</th>
							<th class="txt-wht" style="width:210px;">Added By</th>
						</tr>
					</thead>
					<tbody>
                        @if(isset($drug) && count($drug)>0)
                        @foreach($drug as $KeyDg=>$ValDg)
                        <tr id="drug_list_{{ $ValDg->id }}">
						
                            @can('edit drug db maintenance')
                                <td class="text-sline"><a class="txt-blue_sh-force td_u_force" href="javascript:void(0)" onclick='open_edit_drugs({{$ValDg->id}})'>{{ $ValDg->ndc }}</a></td>
                                <td><a class="txt-blue_sh-force td_u_force" href="javascript:void(0)" onclick='open_edit_drugs({{$ValDg->id}})'>{{ $ValDg->rx_label_name }}</a></td>
                            @else
                                <td class="text-sline"><a>{{ $ValDg->ndc }}</a></td>
                                <td><a>{{ $ValDg->rx_label_name }}</a></td>
                            @endcan
                            <td>{{ $ValDg->generic_or_brand }}</td>
                            <td>{{ $ValDg->strength }}</td>
                            <td>{{ $ValDg->marketer }}</td>
                            <td class="cnt-right-force">$ {{ number_format($ValDg->unit_price,2) }}</td>
                            <td>{{ $ValDg->generic_or_brand }}</td>
                            <td>{{ $ValDg->practice_name }}</td>
                        </tr>
                        @endforeach
                    @endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endcan


@include('partials.modal.drug_maintenance')


@endsection
@section('js')
	@include('partials.js.drug_js')
@endsection
