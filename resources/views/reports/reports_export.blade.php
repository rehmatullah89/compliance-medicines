

    
 <table>
    <tr><td colspan="4"><img src="images/logo.png" class="logo"></td><td colspan="10"><b>{{$report_title}}</b></td></tr>
</table>
 
    <table class="data-table">
        <thead>
            <tr>
               @if($tab_title)
                @foreach($tab_title as $keyTab=>$valTab)
                 @php $style = ''; if(is_array($valTab)){ if(isset($valTab['style'])) { $style = $valTab['style']; } $valTab = 

$valTab['title']; } @endphp
                 <th style="{{$style}}"><b>{{ $valTab }}</b></th>
                 @endforeach                  
               @endif
            </tr>
        </thead>
        <tbody>
       @if($result)
       @foreach($result as $keyRes=>$valRes)
        <tr>
            <!--   this will show serial number in excel
             <td style="background-color: #f2f2f2;">{{ ($keyRes+1) }}</td> -->
            @php 
            $keys = []; 
            $keys = array_keys($valRes);            
            @endphp
            
            @for($i=0; $i < count($keys); $i++)
                <td style="@if(isset($col_style[$i])){{$col_style[$i]}}@endif">{{ $valRes[$keys[$i]] }}</td>
            @endfor
        </tr>
        @endforeach
        <tr></tr>
        
        <tr><td></td><td></td><td></td>
            <td style="text-align:right;color: #FF0000;">@if(isset($for_sum_igred_cost)){{$for_sum_igred_cost}}@else{{''}}@endif</td>
            <td style="text-align:right;color: #0070c0;">@if(isset($for_sum_selling_price)){{$for_sum_selling_price}}@else{{''}}@endif</td>
            <td style="text-align:right;">@if(isset($for_sum_reward_auth)){{$for_sum_reward_auth}}@else{{''}}@endif</td>

        </tr>
      
        @else
        
        <tr>
            <td style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
        </tr>
        @endif
                   
        </tbody>
    </table>






