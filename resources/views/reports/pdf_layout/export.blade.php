
<table>
    <tr><td colspan="4"><img src="images/logo.png" class="logo"></td><td colspan="4">{{$report_title}}</td></tr>
</table>
<table id="counting_report_table" class="table reports-bordered compliance-user-table data-table mb-4_" style="/*width: 100%;*/ margin-bottom: 2px;">
                    <thead>
                        <tr>
                                                    <th class="bg-blue txt-wht" style="white-space:nowrap;width:80px !important;">Invoice Date</th>
                                                    <th class="bg-orage txt-wht cnt-center" style="width:105px !important;" >Invoice Number</th>
                                                        <th class="bg-gray-1 txt-wht" style="min-width: 70px;">Practice Name</th>
                                                        <th class="bg-gray-1 txt-wht" style="min-width: 70px;">Practice Type</th>
                                                        <th class="bg-gray-1 txt-wht" style="width: 50px;">Rx Facilitated</th>
                            <th class="bg-gray-1 txt-wht" style="white-space:nowrap;width:50px !important;">Phmcy Sales Captured</th>
                                                        <th class="bg-gray-1 txt-wht" style="white-space:nowrap;width:50px !important;">Phmcy Profit Captured</th>
                            <th class="bg-red-dk txt-wht" style="white-space:nowrap;width:50px !important;">Reward Auth.</th>
                                                    @if(!Session::has('practice') AND !isset(auth::user()->practices->pluck('id')))
                                                        <th class="bg-gray-1 txt-wht" style="white-space:nowrap;width:50px !important;">Base Engagement Fee</th>
                                                        <th class="bg-gray-1 txt-wht" style="white-space:nowrap;width:50px !important;">CRwd Profit Share</th>
                                                    @endif
                            <th class="bg-gray-1 txt-wht" style="white-space:nowrap;width:50px !important;">Service Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                                            @if(isset($new_query_data))
                                                @foreach($new_query_data as $keyRes=>$valRes)
                                                    <tr>
                            <td class="bg-tb-blue-lt2 txt-black-24">{{$valRes->invoice_date}}</td>
                                                        <td class="bg-tb-orange-lt txt-orange tt_uc_ cnt-right" style="white-space:nowrap;"><span style="cursor: pointer;" class=" zero_slashes" >{{$valRes->invoice_number}}</span></td>
                                                        <td class="bg-tb-wht-shade2 txt-orange2" >{{$valRes->practice_name}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->practice_type}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->Rx_facilitated}}</td>
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #FF0000;"> {{$valRes->total_sale}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #0070c0;"> {{$valRes->rx_profitability}}</td>
                            <td class="bg-tb-pink2 txt-black-24 cnt-right" style="color: #FF0000;"> {{$valRes->rewardAuth}}</td>
                                                    @if(!Session::has('practice') AND !isset(auth::user()->practices->pluck('id')))
                                                        <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #0070c0;"> {{$valRes->base_fee}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #FF0000;"> {{$valRes->profit_share}}</td>
                                                    @endif
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #0070c0;">{{$valRes->service_fee}}</td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                <tr>
                                                    <td style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
                                                </tr>
                                            @endif
                    </tbody>

                    <tfoot>
                                            @if(!Session::has('practice') AND !isset(auth::user()->practices[0]->id))
                                            <tr>
                                                <th colspan="5" style="text-align:right"></th>

                                                <th style="color: #FF0000;">{{isset($total_sum_sale)?$total_sum_sale:''}}</th>
                                                <th style="color: #0070c0;">{{isset($total_rx_profitability)?$total_rx_profitability:''}}</th>
                                                <th style="color: #FF0000;">{{isset($total_sum_authrewd)?$total_sum_authrewd:''}}</th>
                                                @if(!Session::has('practice') AND !isset(auth::user()->practices[0]->id))                                        
                                                <th style="color: #0070c0;">{{isset($total_sum_base_fee)?$total_sum_base_fee:''}}</th>
                                                <th style="color: #FF0000;">{{isset($total_sum_profit_share)?$total_sum_profit_share:''}}</th> @endif                                         
                                                <th style="color: #0070c0;">{{isset($total_sum_service_fee)?$total_sum_service_fee:''}}</th>
                                            </tr>
                                            @else
                                            <tr>
                                                <th colspan="10" >&nbsp;</th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" style="color:#FF0000;">CREDIT APPLIED FROM VEGA WALLET REWARDS AUTHORIZED</th>
                                                <th style="color: #FF0000;"id="rewar_auth_total">{{ $total_sum_authrewd }}</th>
                                            </tr>
                                             <tr>
                                                <th colspan="8" style="text-align:right"></th>
                                                <th style="color: #FF0000;" id="all_total">@php echo '$'.number_format(   ( str_replace(array('$', ','), '', $total_sum_service_fee))- ( str_replace(array('$', ','), '', $total_sum_authrewd)), 2); @endphp</th>
                                            </tr>
                                            @endif
                                            
                                        </tfoot>
                                        
                </table>