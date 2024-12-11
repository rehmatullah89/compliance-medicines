<td colspan="7" style="padding: 0px;">
    
    <table class="expand-collapse-table">
        <tbody>
            @if($orders)
            @foreach($orders as $mKey=>$mVal)
                @php 
                $countA = 1;
                $arrVal = explode("=", $mKey);
                $case_no = $arrVal[1];
                $patient_name = $arrVal[0]; 
                @endphp 
                    @foreach($mVal as $inKey=>$inVal)
                    
                        @foreach($inVal as $inmKey=>$inmVal)

                        @php 
                        //echo '<pre>';
                        //echo $inmKey;
                        //echo '<br>';
                       // echo $mVal[$inKey][$inmKey]['total_payments'];
                        //echo '<br>';
                        //print_r($inmVal);
                       // exit;
                        @endphp
                        <tr class="bg-white border-less-td">
                            @if($countA==1)
                                <td>{{$countA=1? $case_no : ''}}</td>
                                <td style="font-weight: 600;">{{ucwords($countA=1? $patient_name : '')}}</td>
                            @else 
                                <td></td>
                                <td></td>
                            @endif
                                <td><a href="javascript:void(0);" onclick="get_fax_invoice({{$inmVal['order_id']}}); displayInvoice('{{$inmVal['simple_rx_number']}}', '{{$inmVal['created_at']}}');" class="txt-blue td_u_force">{{$inmVal['rx_number']}}</a></td>
                                 @foreach($quarter_arr as $qval)
                                    @if(isset($mVal[$qval][$inmKey]))
                                        <td><span class="elm-right fs-13_" style="line-height: 1.4em;">${{number_format($mVal[$inKey][$inmKey]['total_payments'], 2)}}</span></td>
                                    @else
                                        <td class="">&nbsp;</td>
                                    @endif
                                @endforeach
                        </tr>
                        @endforeach
                    
                    @php $countA++; @endphp
                    @endforeach
            @endforeach
            @endif
            
        </tbody>
    </table>
</td>
