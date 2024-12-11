@extends('layouts.compliance')

@section('content')
<div class="row" style="border-bottom: solid 1px #cecece;">
    <div class="col-sm-12">
        <h4 class="elm-left fs-24_ mb-4_">Client Data</h4>
        <div class="date-time elm-right lh-28_ mb-3_">Monday, January 27, 2020 12:36 AM</div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="row mt-17_">
            <div class="col-sm-12">
                <ul class="nav nav-tabs reports-tabs">
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#practice-reports">Practice Reports</a></li>
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#web-que-stats">Web Queue Statistics</a></li>
                </ul>
                <div class="tab-content" style="border: solid 1px #dee2e6; margin-top: -1px;">
                    <div id="practice-reports" class="container tab-pane fade" style="min-width: 100%; max-width: 100%;">
                        <div class="row pt-17_ mb-17_">
                            <div class="col-sm-12">
                                <p>Web Queue Statistics content</p>
                            </div>
                        </div>
                    </div>
                    <div id="web-que-stats" class="container tab-pane fade in active show" style="min-width: 100%; max-width: 100%;">
                        <div class="row pt-17_">
                            <div class="col-sm-12">
                                <form class="trow_ c-dib_ compliance-form_">
                                    <div class="field wd-100p fld-practice-reports mr-14_ pos-rel_" style="max-width: 200px;">
                                        <label class="wd-100p">Practice Reports</label>
                                        <select class="wd-100p custom-select-arrow">
                                            <option selected disabled>Top Products By Sales</option>
                                            <option>Practice Report 1</option>
                                            <option>Practice Report 2</option>
                                            <option>Practice Report 3</option>
                                            <option>Practice Report 4</option>
                                            <option>Practice Report 5</option>
                                            <option>Practice Report 6</option>
                                        </select>
                                        <span class="fa fa-caret-down" style="position: absolute;top: 29px;right: 9px;"></span>
                                    </div>
                                    <div class="field wd-100p fld-time period mr-14_ pos-rel_" style="max-width: 120px;">
                                        <label class="wd-100p">Select Time Period</label>
                                        <select class="wd-100p custom-select-arrow">
                                            <option selected>Past 10 Days</option>
                                            <option>Past 15 Days</option>
                                            <option>Past 20 Days</option>
                                            <option>Past 25 Days</option>
                                            <option>Past 30 Days</option>
                                            <option>Past 35 Days</option>
                                            <option>Past 40 Days</option>
                                        </select>
                                        <span class="fa fa-caret-down" style="position: absolute;top: 29px;right: 9px;"></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-24_ mb-7_">
                            <div class="col-sm-12">
                                <div class="elm-left c-mr-4_ fs-17-force-child_" style="line-height: 24px; margin-top: 10px; display: inline-block;"> <span class="txt-blue weight_600 tt_uc_">TOP PRODUCTS</span> <span class="txt-red weight_600 tt_uc_">BY % PROFITABILITY &hellip;</span> <span class="txt-blue weight_600">AS OF 01-15-2020</span> </div>
                                <div class="elm-right">
                                    <!-- button class="btn bg-blue-txt-wht weight_600 fs-14_" data-toggle="modal" data-target="#practice-Add-Modal" style="line-height: 20px; padding: .1rem .75rem;">+ Add</button-->
                                    <button type="button" class="btn clean_"><span class="fa fa-print txt-blue fs-24_"></span></button>
                                    <button type="button" class="btn clean_"><span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table class="table reports-bordered">
                                    <thead>
                                        <tr>
                                            <th class="bg-gray-1 txt-wht">% Gross Margin</th>
                                            <th class="bg-orage txt-wht">Rx Profit(s) </th>
                                            <th class="bg-gr-bl-dk txt-wht">GCN_SEQ</th>
                                            <th class="bg-gray-1 txt-wht">Total QTY</th>
                                            <th class="bg-blue txt-wht">Rx Label Name</th>
                                            <th class="bg-gray-1 txt-wht">Dosage Form</th>
                                            <th class="bg-gray-80 txt-wht">Strength</th>
                                            <th class="bg-grn-lk txt-wht">Prescriptions</th>
                                            <th class="bg-gray-1 txt-wht">Rx ING Cost</th>
                                            <th class="bg-gray-80 txt-wht">Rx Sales</th>
                                            <th class="bg-red-dk txt-wht">Reward Authorized</th>
                                            <th class="bg-gray-1 txt-wht">Major Reporting Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">86.69%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 6,896.10</td>
                                            <td class="bg-gr_bl txt-wht">03560</td>
                                            <td class="bg-gray-e txt-blue cnt-center">4,875</td>
                                            <td class="bg-tb-blue-lt txt-blue">CLINDAMYCIN PHOS</td>
                                            <td class="bg-gray-e txt-black-24">CREAM</td>
                                            <td class="bg-gray-ce txt-black-24">0.02</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">25</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 3,733.80</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 16,413.62</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 1,540.33</td>
                                            <td class="bg-tb-wht-shade txt-black-24">n/a</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">79.70%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 4,512.30</td>
                                            <td class="bg-gr_bl txt-wht">16927</td>
                                            <td class="bg-gray-e txt-blue cnt-center">3,375</td>
                                            <td class="bg-tb-blue-lt txt-blue">ISOSORB DINIT/HYDRALAZIL</td>
                                            <td class="bg-gray-e txt-black-24">TAB</td>
                                            <td class="bg-gray-ce txt-black-24">20/37.5 MG</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">105</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 3,391.20</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 15,327.74</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 1,633.90</td>
                                            <td class="bg-tb-wht-shade txt-black-24">Cardovascular</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">75.57%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 14,256.08</td>
                                            <td class="bg-gr_bl txt-wht">03561</td>
                                            <td class="bg-gray-e txt-blue cnt-center">4,020</td>
                                            <td class="bg-tb-blue-lt txt-blue">WARFARIN SOD</td>
                                            <td class="bg-gray-e txt-black-24">GEL</td>
                                            <td class="bg-gray-ce txt-black-24">3% - 5%</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">97</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 3,243.00</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 14,256.08</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 1,400.69</td>
                                            <td class="bg-tb-wht-shade txt-black-24">n/a</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">74.11%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 13,595.32</td>
                                            <td class="bg-gr_bl txt-wht">06562</td>
                                            <td class="bg-gray-e txt-blue cnt-center">5,462</td>
                                            <td class="bg-tb-blue-lt txt-blue">FLUOCINONDE</td>
                                            <td class="bg-gray-e txt-black-24">TAB</td>
                                            <td class="bg-gray-ce txt-black-24">5 MG</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">590</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 3,021.00</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 13,788.95</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 1,795.38</td>
                                            <td class="bg-tb-wht-shade txt-black-24">Cardovascular</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">73.78%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 12,008.00</td>
                                            <td class="bg-gr_bl txt-wht">29967</td>
                                            <td class="bg-gray-e txt-blue cnt-center">15,990</td>
                                            <td class="bg-tb-blue-lt txt-blue">ATORYVASTATIN</td>
                                            <td class="bg-gray-e txt-black-24">GEL</td>
                                            <td class="bg-gray-ce txt-black-24">0.0005</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">530</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 5,225.00</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 13,595.32</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 1,625.96</td>
                                            <td class="bg-tb-wht-shade txt-black-24">Cardovascular</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">73.75%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 11,327.74</td>
                                            <td class="bg-gr_bl txt-wht">29968</td>
                                            <td class="bg-gray-e txt-blue cnt-center">15,922</td>
                                            <td class="bg-tb-blue-lt txt-blue">HCTZ (Hydrochlorothiazide)</td>
                                            <td class="bg-gray-e txt-black-24">TAB</td>
                                            <td class="bg-gray-ce txt-black-24">40 MG</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">490</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 3,733.00</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 12,008.00</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 1,156.54</td>
                                            <td class="bg-tb-wht-shade txt-black-24">Cardovascular</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray-ed txt-black-24 cnt-center">71.66%</td>
                                            <td class="bg-tb-orange-lt txt-orange cnt-center">$ 11,256.33</td>
                                            <td class="bg-gr_bl txt-wht">05025</td>
                                            <td class="bg-gray-e txt-blue cnt-center">1,850</td>
                                            <td class="bg-tb-blue-lt txt-blue">METRONIDAZOLE</td>
                                            <td class="bg-gray-e txt-black-24">CAP</td>
                                            <td class="bg-gray-ce txt-black-24">500 MG</td>
                                            <td class="bg-tb-grn-lt txt-black-24 cnt-right">890</td>
                                            <td class="bg-gray-e txt-gray-7e cnt-center">$ 3,391.00</td>
                                            <td class="bg-gray-e txt-blue cnt-center">$ 11,327.74</td>
                                            <td class="bg-tb-pink txt-red-dk cnt-center">$ 88.12</td>
                                            <td class="bg-tb-wht-shade txt-black-24">Cardovascular</td>
                                        </tr>
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
@endsection