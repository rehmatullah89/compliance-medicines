
<table>
    <tr><td colspan="4"><img src="images/logo.png" class="logo"></td><td colspan="4">{{$report_title}}</td></tr>
</table>
@if(isset(auth::user()->practice_id) || Session::has('practice'))
@if(isset($current_practice))
<table>
    <tr><td colspan="2">INVOICE# {{$current_practice->practice_code}}-{{$invoice_number}}</td></tr>
    <tr><td>Practice type</td><td>{{$current_practice->practice_type}}</td></tr>
    <tr><td>Client</td><td>{{$current_practice->practice_name}}</td>
        <td></td><td>{{$current_practice->practice_license_issuer}}</td><td>{{$current_practice->practice_license_number}}</td><td></td>
        <td>Date Begining</td><td>{{isset($start_date)?$start_date:''}}</td>
        <td>Date Ending</td><td>{{isset($end_date)?$end_date:''}}</td>
    </tr>
    <tr><td>Address</td><td>{{$current_practice->practice_address}}</td></tr>
    <tr><td>City State Zip</td><td>{{$current_practice->practice_city}} {{$current_practice->state}} {{$current_practice->practice_zip}}</td></tr>
    <tr><td>Site Contact</td><td>{{$current_practice->users[0]->name}}</td></tr>


</table>
@endif
@endif
<table id="counting_report_table" class="table reports-bordered compliance-user-table data-table mb-4_" style="/*width: 100%;*/ margin-bottom: 2px;">
    <thead>
        <tr>
        <th  style="background-color: #808080;color:#FFFFFF;">Date of Service</th>
        <th class="bg-orage txt-wht cnt-center" style="background-color: #808080;color:#FFFFFF;" >Pharmacy Rx Number</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">New or Refill</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Patient Name</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">DOB</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Sex</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">NDC</th>
        <th class="bg-red-dk txt-wht" style="background-color: #808080;color:#FFFFFF;">Marketer</th>                    
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">GCN_SEQ</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Rx Label Name</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Dosage Form</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Strength</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">QTY</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Insured?</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Rx Ingredient Cost</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">3RD Party Paid</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFF00;"><b>Patient Out Of Pocket</b></th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;"><b>Assistance Authoized</b></th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFF00;"><b>Reward Authorized</b></th>
        <th class="bg-gray-1 txt-wht" style="background-color: #acb9ca;color:#042666;"><b>1/4 Activity Distribution</b></th>
        <th class="bg-gray-1 txt-wht" style="background-color: #acb9ca;color:#fff2cc;">Activity Number</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFF00;"><b>Rx Selling Price</b></th>
        <th class="bg-gray-1 txt-wht" style="background-color: #808080;color:#FFFFFF;">Rx Profitability</th>
        <th class="bg-gray-1 txt-wht" style="background-color: #eeece1;color: #1f497d;"><b>Compliance Reward Base Fee</b></th>

        <th class="bg-gray-1 txt-wht" style="background-color: #00b04f;color: #FFFFFF;"><b>Compliance Reward Profit Share</b></th>
        
        <th class="bg-gray-1 txt-wht" style="background-color: #00b04f;color:#FFFFFF;"><b>Compliance Reward Service Fee</b></th>
        <th class="bg-gray-1 txt-wht" style="background-color: #00b04f;color:#FFFFFF;"><b>Total Payment System FEES</b></th>
                        </tr>
                    </thead>
                    <tbody>
                                            @if(isset($new_query_data))
                                                @foreach($new_query_data as $keyRes=>$valRes)
                                                    <tr>
                            <td class="bg-tb-blue-lt2 txt-black-24">{{$valRes->date_service}}</td>
                                                        <td style="white-space:nowrap;text-align: right;"><span style="cursor: pointer;" class=" zero_slashes" >{{$valRes->rx_number}}</span></td>
                                                        <td class="bg-tb-wht-shade2 txt-orange2" >{{$valRes->order_type}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->PatName}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-orange2">{{$valRes->dob}}</td>
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #FF0000;"> {{$valRes->gender}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #0070c0;"> {{$valRes->ndc}}</td>
                            <td class="bg-tb-pink2 txt-black-24 cnt-right" style="color: #FF0000;"> {{$valRes->marketer}}</td>
                                                    
                                                        <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #0070c0;"> {{$valRes->gcn_seq}}</td>
                                                        <td class="bg-tb-wht-shade2 txt-black-24 cnt-right" style="color: #FF0000;"> {{$valRes->rx_label_name}}</td>
                                                  
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right">{{$valRes->dosage_form}}</td>
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right">{{$valRes->strength}}</td>
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right">{{$valRes->Quantity}}</td>
                            <td class="bg-tb-wht-shade2 txt-black-24 cnt-right"><b>{{$valRes->InsuranceType}}</b></td>
                            <td  style="text-align: right;">{{$valRes->rxIngcost}}</td>
                            <td  style="text-align: right;">{{$valRes->rx_third_pay}}</td>
                            <td  style="color: #FF0000;text-align: right;">{{$valRes->patient_out_pocket}}</td>
                            <td  style="text-align: center;">{{$valRes->assist_auth}}</td>
                            <td  style="color: #FF0000;text-align: right;">{{$valRes->rewardAuth}}</td>
                            <td  style="background-color: #acb9ca;color: #042666;text-align: right;">{{$valRes->acti_dis}}</td>
                            <td  style="background-color: #acb9ca;color:#fff2cc;">{{$valRes->activity_count}}</td>
                            <td  style="text-align: right;">{{$valRes->rx_selling}}</td>
                            <td  style="text-align: right;">{{$valRes->rx_profitability}}</td>
                            <td  style="background-color: #eeece1;text-align: right;">{{$valRes->base_fee}}</td>
                            <td  style="background-color: #00b04f;text-align: right;color: #FFFFFF;">{{$valRes->profit_share}}</td>
                            <td  style="background-color: #00b04f;text-align: right;color: #FFFFFF;">{{$valRes->cr_service_fee}}</td>
                            <td  style="background-color: #00b04f;color: #FFFFFF;text-align: right;">{{'$ '.number_format($valRes->system_fee,2)}}</td>



                                                    </tr>
                                                @endforeach

                                            @else
                                                <tr>
                                                    <td style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
                                                </tr>
                                            @endif
                    </tbody>

                    <tfoot>
                                           <tr></tr>
                                            <tr>
                                                <th colspan="18" style="text-align:right"></th>

                                                <th style="color: #FF0000;text-align: right;">{{isset($total_sum_authrewd)?$total_sum_authrewd:''}}</th>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right;">{{isset($total_rx_selling)?$total_rx_selling:''}}</th>
                                                <th style="text-align: right;">{{isset($total_rx_profitability)?$total_rx_profitability:''}}</th>
                                                <th></th>                          
                                                <th style="text-align: right;">{{isset($total_sum_profit_share)?$total_sum_profit_share:''}}</th>
                                                <th style="text-align: right;">{{isset($total_sum_cr_service_fee)?$total_sum_cr_service_fee:''}}</th>                                         
                                                
                                            </tr>
                                            
                                           
                                            <tr></tr>
                                            <tr></tr>
                                             <tr>
                                                <th colspan="20" style="text-align:right"></th>
                                                <th colspan="2"><img src="images/logo.png" class="logo"></th>
                                                <th colspan="2" style="background-color: #FFFF00;">Total due</th>
                                                <th colspan="3" style="background-color: #FFFF00;text-align:right;;" >{{isset($total_sum_service_fee)?$total_sum_service_fee:''}}</th>
                                            </tr>
                                           
                                            
                                        </tfoot>
                                        
                </table>