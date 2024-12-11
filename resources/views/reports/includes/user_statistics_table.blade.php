<table class="table reports-bordered compliance-user-table data-table @if(count($result)==0) {{'empty-table'}} @endif" >
        <thead>
            <tr>
                <th class="bg-blue txt-wht refill_next" style="white-space:nowrap;">Refill. Next</th>
                <th class="bg-orage txt-wht refills_rem" style="white-space:nowrap;">Refills Rem.</th>
                <th class="bg-gr-bl-dk txt-wht cnt-center rx_no" style="text-align: center !important;">Rx #</th>
                <th class="bg-gray-1 txt-wht rx_label_name">Rx Label Name</th>
                <th class="bg-gray-1 txt-wht generic_for">Generic For</th>
                <th class="bg-blue txt-wht qty">Qty</th>
                <th class="bg-gray-1 txt-wht days_suppy" style="white-space:nowrap;">Days Supply</th>
                <th class="bg-gray-80 txt-wht rx_sell_price" style="white-space:nowrap;">Rx Sell. Price</th>
                <th class="bg-red-dk txt-wht reward_auth" style="white-space:nowrap;">Reward Auth.</th>
                <th class="bg-gray-9 txt-wht therap_cat" style="white-space:nowrap;">Therapeutic Category</th>
            </tr>
        </thead>
        <tbody id="tbodies_data">
                @if(isset($result) && count($result)>0)
                    @foreach($result as $keyRes=>$valRes)
                    <tr>
                        <td class="bg-tb-blue-lt txt-black-24 cnt-center">{{$valRes['nextRefillDate']}}</td>
                        <td class="bg-tb-orange-lt txt-orange cnt-center">{{$valRes['RefillsRemaining']}}</td>
                        <td class="bg-gray-e txt-wht cnt-right"><span class="txt-gray-9 zero_slashes ">{{$valRes['Rx']}}</td>
                        <td class="bg-tb-pink-lt txt-blue-force cnt-left weight_600">{{$valRes['rx_label_name']}}</td>
                        <td class="bg-tb-pink-lt txt-blue-force cnt-left weight_600" style='color: #9d9292c9 !important;'>{{$valRes['brand_reference']}}</td>
                        <td class="bg-tb-grn-lt txt-black-24 cnt-center">{{$valRes['qty']}}</td>
                        <td class="bg-gray-e txt-black-24 cnt-center">{{$valRes['DaysSupply']}}</td>
                        <td class="bg-gray-e txt-blue cnt-right txt-blue">$ {{isset($valRes['RxSelling'])?$valRes['RxSelling']:'0'}}</td>
                        <td class="bg-tb-pink txt-red cnt-right txt-red">$ {{isset($valRes['rewardAuth'])?$valRes['rewardAuth']:'0'}}</td>
                        <td class="bg-tb-pink-lt cnt-left txt-black-24 tt_uc_ ">{{$valRes['minor_reporting_class']}}</td>
                    </tr>                                                      
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center;" colspan="10">No data available in table</td>
                    </tr>
                @endif                                                                            
        </tbody>
    </table>

<div id="stats_area_from" style="display: none;">
    <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">{{ $stats[0]->unique_users??'0' }}</span> <span class="txt-gray-6 fs-13_ ">Unique Patients</span> </div>
    <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">{{ $stats[0]->unique_prescriptions??"0" }}</span> <span class="txt-gray-6 fs-13_ ">Unique Prescriptions</span> </div>
    <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">$ {{ isset($stats[0]->client_sales)?number_format($stats[0]->client_sales, 2):'0.00' }}</span> <span class="txt-gray-6 fs-13_ ">Client Sales</span> </div>
    <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">$ {{ isset($stats[0]->client_sales)?number_format($stats[0]->client_profitablility, 2):'0.00' }}</span> <span class="txt-gray-6 fs-13_ ">Client Profitability</span> </div>
</div>