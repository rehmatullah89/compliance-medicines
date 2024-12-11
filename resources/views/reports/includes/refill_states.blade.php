
<div class="trow_ top-row-stats">
        <div class="elm-left left-heading">PT. out of pocket</div>
</div>

<div class="trow_ pb-13_ refills-overdue-stats" style="overflow-x: auto;">
    <div class="days-list flx-justify-start" style="width:{{($blue_red_count)+120}}px;">
            @php
            $prev_delay=0;
            @endphp
            @if($statistics)
                @foreach($statistics as $val)
                                                            
                    @if($val['s_type']=='order')
                        <div class="flx-justify-start pos-rel_ days-container 10">
                            <div class="day blue-bg length10 pos-rel_ ">
                                <div class="refill-info" title="@if($val['order_type']=='Refill') {{ 'Refill Date : '.$val['service_date'] }} @else {{ 'Order Date : '.$val['service_date'] }} @endif">
                                    <span class="refill-price">${{ $val['order_payment'] }}</span>
                                   <span class="refill-circle">@if($val['order_type']=='Refill') {{ 'R' }} @else {{ 'O' }} @endif</span>
                                </div>
                                <div class="date-box">
                                    <span class="date-value txt-black-24">{{ $val['service_date'] }}</span>
                                </div>
                            </div>
                            @php 
                            $next_day=$val['service_date'];
                            @endphp
                            @for($i=0;$i<=$val['blue_delay'];$i++)
                           @php
                           if($val['notifications'] && count($val['notifications'])>0)
                           {
                                
                                
                                $dt_index=array_search($next_day,array_column($val['notifications'], 'sending_date'));
                                if($dt_index===false)
                                {
                            @endphp
                                    <div class="day blue-bg length30 pos-rel_ less-width "></div>
                            @php
                    
                                }else{
                            
                            @endphp
                                @if($val['notifications'][$dt_index]['notification_type']=='survey')
                                    
                                    <div class="day blue-bg length10 pos-rel_ wid-15">
                                        <div class="date-box">
                                            <div class="symbol">
                                                <span class="txt-grn-lt tickmark">&#10003;</span>
                                                    <div class="date-value txt-grn-lt" title="{{$val['notifications'][$dt_index]['title']}}">{{ $val['notifications'][$dt_index]['sending_date'] }}</div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    @else
                                    
                                    <div class="day blue-bg length10 pos-rel_ wid-15">
                                        <div class="date-box">
                                            <div class="symbol">
                                                <span class="txt-red triangle">&#9650;</span>
                                                <div class="date-value txt-red" title="{{$val['notifications'][$dt_index]['title']}}">{{ $val['notifications'][$dt_index]['sending_date'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @endif
                                    <div class="day blue-bg length20 pos-rel_ wid-10"></div>


                            @php
                                }
                            }else{
                            @endphp
                                <div class="day blue-bg length30 pos-rel_ less-width no-notification"></div>
                            @php
                            }
                            $next_day=date('m/d/Y',strtotime($next_day. ' +1 day')); 
                           @endphp
                                
                                
                                
                            @endfor

                            {{-- start comment logic change
                            @if($val['notifications'] and count($val['notifications'])>0)
                                
                               
                            
                                @foreach($val['notifications'] as $nmVal)
                                
                                    <!-- <div class="day blue-bg length20 pos-rel_ "></div> -->
                                    
                                    @if($nmVal['survayID']!='')
                                    
                                    <div class="day blue-bg length10 pos-rel_ ">
                                        <div class="date-box">
                                            <div class="symbol">
                                                <span class="txt-grn-lt tickmark">&#10003;</span>
                                                    <div class="date-value txt-grn-lt">{{ $nmVal['sending_date'] }}</div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    @else
                                    
                                    <div class="day blue-bg length10 pos-rel_">
                                        <div class="date-box">
                                            <div class="symbol">
                                                <span class="txt-red triangle">&#9650;</span>
                                                <div class="date-value txt-red">{{ $nmVal['sending_date'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @endif
                                    <div class="day blue-bg length20 pos-rel_ "></div>
                                @endforeach
                            @else
                            
                            <!-- <div class="day blue-bg length30 pos-rel_ "></div>
                            <div class="day blue-bg length10 pos-rel_ "></div>
                            <div class="day blue-bg length10 pos-rel_ "></div>
                            <div class="day blue-bg length30 pos-rel_ "></div>
                            <div class="day blue-bg length20 pos-rel_ "></div>
                            <div class="day blue-bg length10 pos-rel_ "></div>
                            <div class="day blue-bg length30 pos-rel_ "></div>
                            <div class="day blue-bg length10 pos-rel_ "></div>
                            <div class="day blue-bg length10 pos-rel_ "></div>
                            <div class="day blue-bg length30 pos-rel_ "></div>
                            <div class="day blue-bg length20 pos-rel_ "></div>
                            <div class="day blue-bg length10 pos-rel_ "></div> -->
                            
                            @endif
                           end comment logic change --}}
                        </div>
                    @endif
                                
                    @if($val['s_type']=='refill_delay')     
                    <div class="flx-justify-start pos-rel_ days-container 10 @if($val['delay']<10) {{'min-wid bg-red'}} @endif">
                        <div class="days-overdue">&hellip; <span class="days-value">{{ $val['delay'] }}</span> days overdue &hellip; </div>
                        <div class="day red-bg length10 pos-rel_ ">
                            <div class="refill-info" title="Refill Date Was : {{ $val['refill_date_should_be'] }}">
                                <span class="refill-price">&nbsp;</span>
                            </div>
                            <div class="date-box">
                                <span class="date-value txt-black-24">{{ $val['refill_date_should_be'] }}</span>
                            </div>
                        </div>
                        @php 
                        $red_next_day=$val['refill_date_should_be'];
                    
                        @endphp
                        @for($i=0;$i<=$val['delay'];$i++)
                        @php
                        if($val['notifications'] && count($val['notifications'])>0)
                        {
                            
                            $rd_dt_index=array_search($red_next_day,array_column($val['notifications'], 'sending_date'));
                            if($rd_dt_index===false)
                            {
                        @endphp
                               <div class="day red-bg length30 pos-rel_ less-width"></div> 
                        @php
                            }else{
                        @endphp
                                @if($val['notifications'][$rd_dt_index]['notification_type']=='survey')

                                <div class="day red-bg length10 pos-rel_ wid-15 ">
                                    <div class="date-box">
                                        <div class="symbol">
                                            <span class="txt-grn-lt tickmark">&#10003;</span>
                                                <div class="date-value txt-grn-lt" title="{{$val['notifications'][$rd_dt_index]['title']}}">{{ $val['notifications'][$rd_dt_index]['sending_date'] }}</div>
                                        </div>
                                    </div>

                                </div>

                                @else

                                <div class="day red-bg length10 pos-rel_ wid-15">
                                    <div class="date-box">
                                        <div class="symbol">
                                            <span class="txt-red triangle">&#9650;</span>
                                            <div class="date-value txt-red" title="{{$val['notifications'][$rd_dt_index]['title']}}">{{ $val['notifications'][$rd_dt_index]['sending_date'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                @endif
                                <div class="day red-bg length20 pos-rel_ wid-10"></div>
                        @php
                            }
                        }else{
                        @endphp
                            <div class="day red-bg length30 pos-rel_ less-width no-notification"></div>
                        @php
                        }
                        $red_next_day=date('m/d/Y',strtotime($red_next_day. ' +1 day'));
                        @endphp
                        @endfor
                        
                        {{-- start comment logic change
                         @if($val['notifications'] and count($val['notifications'])>0)
                                    
                            @foreach($val['notifications'] as $nmVal)

                                <!-- <div class="day red-bg length20 pos-rel_ "></div> -->

                                @if($nmVal['survayID']!='')

                                <div class="day red-bg length10 pos-rel_ ">
                                    <div class="date-box">
                                        <div class="symbol">
                                            <span class="txt-grn-lt tickmark">&#10003;</span>
                                                <div class="date-value txt-grn-lt">{{ $nmVal['sending_date'] }}</div>
                                        </div>
                                    </div>

                                </div>

                                @else

                                <div class="day red-bg length10 pos-rel_">
                                    <div class="date-box">
                                        <div class="symbol">
                                            <span class="txt-red triangle">&#9650;</span>
                                            <div class="date-value txt-red">{{ $nmVal['sending_date'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                @endif
                                <div class="day red-bg length20 pos-rel_ "></div>
                            @endforeach
                        @else

                        

                        @endif
                        end comment logic change --}}
                        </div>
                       
                        @endif
                        
                     @endforeach
                  @endif
    </div>
</div>