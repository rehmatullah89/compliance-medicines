     <td colspan="6">          
                	<table class="bordered-hd-blue-shade">
                		<thead>
                		</thead>
                		<tbody>
                        @if($invest_detail)
                            @foreach($invest_detail as $kOne=>$vOne)
                                @php $count_ord = 0; @endphp
                                @foreach($vOne as $myabd) @php $count_ord = $count_ord + count($myabd); @endphp @endforeach
                                <tr>
                                    <td class="txt-blue td_u_force weight_700" colspan="5">{{$kOne}} <span class="ml-2_ circle-bgred-colorwht mr-4_">{{$count_ord}}</span></td>
                                    <td class="txt-red td_u_force weight_700 cnt-right-force">${{number_format($invt_d[$kOne]->amount_invest, 2)}}</td>
                                    </tr>
                                @if($vOne)
                                    
                                    @foreach($vOne as $kTwo=>$vTwo)
                                        @php 
                                        $countA = 1;
                                        @endphp
                                        @if($vTwo)
                                        @foreach($vTwo as $kThree=>$vThree)
                                        <tr class="">
                                            @if($countA==1)
                                                <td class="txt-blue td_u_force">{{$vThree['case_no']}}</td>
                                                <td class="txt-black-24 tt_uc_ weight_600">{{$vThree['p_name']}}</td>
                                            @else 
                                                <td></td>
                                                <td></td>
                                            @endif
                                            
                                            @php
                                            
                                                if(!empty($prv_percent))
                                                {
                                                    if(isset($prv_percent[$invt_d[$kOne]->practice_id_law]))
                                                    {
                                                       $remaining_amount = ($vThree['total_payments']-(($vThree['total_payments']/100)*$prv_percent[$invt_d[$kOne]->practice_id_law]));
                                                        
                                                        $total_paymet_duct = (($remaining_amount/100)* $invt_d[$kOne]->percentage_paid);
                                                    }
                                                    else{
                                                        $total_paymet_duct = (($vThree['total_payments']/100)*$invt_d[$kOne]->percentage_paid);
                                                    }
                                                }
                                                else
                                                {
                                                    $total_paymet_duct = (($vThree['total_payments']/100)*$invt_d[$kOne]->percentage_paid);
                                                }
                                            
                                            @endphp
                                            
                                            
                                            
                                            
                                            <td class="tt_uc_">{{$vThree['rx_number']}}</td>
                                            <td class="tt_uc_">{{$vThree['pharmacy_name']}}</td>
                                            <td class="td_u_ cnt-right-force">${{number_format($total_paymet_duct, 2)}}</td>
                                        </tr>
                                        @php $countA++; @endphp
                                        @endforeach
                                        @endif
                                    
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
    					
    					</tbody>
    				</table>

</td> 
                    