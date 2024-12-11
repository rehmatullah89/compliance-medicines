@extends('layouts.compliance')

@section('content')


<style>

table.bordered.overview_table { border-collapse: separate; border: 0px; }
table.bordered.overview_table thead {  }
table.bordered.overview_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4;background-color: inherit;}
table.bordered.overview_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
table.bordered.overview_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }

table.bordered.overview_table tbody {  }
table.bordered.overview_table tbody tr {  }
table.bordered.overview_table tbody tr td:first-child { border-left: solid 1px #ccc; }
table.bordered.overview_table tbody tr td:last-child { border-right: solid 1px #ccc; }
table.bordered.overview_table tbody tr:last-child {  }
table.bordered.overview_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
table.bordered.overview_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
table.bordered.overview_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }


</style>


<div class="row" style="border-bottom: solid 1px #cecece;">
							<div class="col-sm-12">
								<h4 class="elm-left fs-24_ mb-4_">Overview</h4>
								<div class="date-time elm-right">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
							</div>
						</div>

 @can('new pharmacy list view')
<div class="row">
    <div class="col-sm-12">


        <div class="row">
            <div class="col-sm-12">
                <div class="row mt-7_ mb-7_">
                    <div class="col-sm-12">
                        <div class="elm-left c-mr-4_ fs-17-force-child_">
                            <span class="circle-bgred-colorwht" id="pharmacy-count">{{count($practices)??'0'}}</span>
                            <span class="txt-blue weight_700">NEW PHARMACY</span>
                            <span class="txt-gray-9 weight_700">Practice Enrollments</span>
                            <span style="cursor: pointer;"  onclick="show_practies_modal('pharmacy')">({{$practices_count??'0'}})</span>
                        </div>
                        <div class="elm-right">
                            @if(Session::has('practice') && !isset(Session::get('practice')->parent_id))
                            <!--  <button class="btn bg-blue-txt-wht weight_600 fs-14_"  style="line-height: 20px;padding: .16rem .75rem;padding-bottom: 0px;" data-toggle="modal" data-target="#practice-Add-Modal" >+ Add Branch</button> -->
                             @endif
                             @can('add patient')
                            <button class="btn bg-blue-txt-wht weight_600 fs-14_"  style="line-height: 20px;padding: .16rem .75rem;padding-bottom: 0px;" onclick="window.location.href = '{{url("patient/create")}}'" >+ Add Patient</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pr-14_ pl-14_">
            <div class="col-sm-12 pl-0 pr-0 table-responsive">
                <table class="table bordered overview_table overview-datatable1 practice_datatable" style="min-width: 700px;" id="pharmacy_table">
                    <thead>
                        <tr class="weight_500-force-childs bg-blue">
                            <th class="txt-wht" style="width:36%;">Pharmacy Name</th>
                            <th class="txt-wht" style="width:100px;">Zip</th>
                            <th class="txt-wht" style="width:40px;">State</th>
                            <th class="txt-wht" style="width:22%;">Site Contact</th>
                            <th class="txt-wht" style="width:22%;">CR Rep User</th>
                        </tr>
                    </thead>
                    <tbody id="pharmacies">
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endcan



@can('practice added drugs list view')
<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12">
                <div class="trow_ c-mr-4_ fs-19_ fs-17-force-child_ mt-14_ mb-7_">
                    <span class="circle-bgred-colorwht">{{isset($drug)?count($drug):'0'}}</span>
                    <span class="txt-blue weight_700">PHARMACY ADDED DRUGS</span>
                </div>
            </div>
        </div>

        <div class="row pr-14_ pl-14_">
            <div class="col-sm-12 pl-0 pr-0 table-responsive">
                <table class="table bordered overview_table overview-datatable4" id="drug_tbl" style="min-width: 700px;">
                    <thead>
                        <tr class="weight_500-force-childs bg-blue">
                            <th class="txt-wht" style="width: 140px;">NDC</th>
                            <th class="txt-wht" style="width: 22%;">Drug Label Name</th>
                            <th class="txt-wht" style="width: 100.3333px;">Generic For</th>
                            <th class="txt-wht">Strength</th>
                            <th class="txt-wht">Marketer</th>
                            <th class="txt-wht" style="width:114px;">ING Cost</th>
                            <th class="txt-wht" style="width:84px;">M/G/CMP</th>
                            <th class="txt-wht" style="width: 210px;">Added By</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endcan



@can('new physician list view')
<div class="row">
    <div class="col-sm-12">


        <div class="row">
            <div class="col-sm-12">
                <div class="trow_ c-mr-4_ fs-19_ fs-17-force-child_ mt-14_ mb-7_">
                    <span class="circle-bgred-colorwht" id="physician-count">{{count($physician)??'0'}}</span>
                    <span class="txt-blue weight_700">NEW PHYSICIAN</span>
                    <span class="txt-gray-9 weight_700">Practice Enrollments</span>
                    <span onclick="show_practies_modal('physician')" style="cursor: pointer;">({{$physician_count??'0'}})</span>
                </div>
            </div>
        </div>

        <div class="row pr-14_ pl-14_">
            <div class="col-sm-12 pl-0 pr-0 table-responsive">
                <table class="table bordered overview_table overview-datatable2" style="min-width: 700px;" id="physician_table">
                    <thead>
                        <tr class="weight_500-force-childs bg-blue">
                            <th class="txt-wht" style="width:36%;">Practice Name</th>
                            <th class="txt-wht" style="width:100px;">Zip</th>
                            <th class="txt-wht" style="width: 40px;">State</th>
                             <th class="txt-wht" style="width: 40px;">SPECIALTY</th>
                             <th class="txt-wht" style="width:22%;">Site Contact</th>
                            <th class="txt-wht" style="width:22%;">CR Rep User</th>
                        </tr>
                    </thead>
                    <tbody id="physicians">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endcan

@can('new law practice view')
<div class="row">
    <div class="col-sm-12">


        <div class="row">
            <div class="col-sm-12">
                <div class="trow_ c-mr-4_ fs-19_ fs-17-force-child_ mt-14_ mb-7_">
                    <span class="circle-bgred-colorwht" id="law-practice-count">{{count($law_practices)??'0'}}</span>
                    <span class="txt-blue weight_700">NEW LAW PRACTICE</span>
                    <span class="txt-gray-9 weight_700">Practice Enrollments</span>
                    <span onclick="show_practies_modal('law_practice')" style="cursor: pointer;">({{$law_practices_count??'0'}})</span>
                </div>
            </div>
        </div>

        <div class="row pr-14_ pl-14_">
            <div class="col-sm-12 pl-0 pr-0 table-responsive">
                <table class="table bordered overview_table overview-datatable3" style="min-width: 700px;" id="law_practice_table">
                    <thead>
                        <tr class="weight_500-force-childs bg-blue">
                            <th class="txt-wht" style="width:36%;">Practice Name</th>
                            <th class="txt-wht" style="width:100px;">Zip</th>
                            <th class="txt-wht" style="width: 40px;">State</th>
                            <th class="txt-wht" style="width:22%;">Site Contact</th>
                            <th class="txt-wht" style="width:22%;">CR Rep User</th>
                        </tr>
                    </thead>
                    <tbody id="physicians">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endcan





@include('partials.modal.show_practices')

@include('partials.modal.drug_maintenance')

@include('partials.modal.practice_add')

@endsection
@section('js')
@include('partials.js.drug_js')
@include('partials.js.practice_js')
@endsection
