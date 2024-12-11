
<div class="trow_ top-row-stats">
        <div class="elm-left left-heading">PT. out of pocket</div>
</div>

<div class="trow_ pb-6_ refills-overdue-stats" style="overflow-x: auto;">
    <div class="days-list flx-justify-start" style="width:{{($total_delays*10)}}px;">

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

                        @if($val['notifications'] and count($val['notifications'])>0)

                            @if(count($val['notifications'])<12)
                                @for($i=0; $i < (15-( (count($val['notifications'])*2)+count($val['notifications']))); $i++)
                                    <div class="day blue-bg length20 pos-rel_ "></div>
                                @endfor
                            @endif

                            @foreach($val['notifications'] as $nmVal)

                                <div class="day blue-bg length20 pos-rel_ "></div>

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

                        <div class="day blue-bg length30 pos-rel_ "></div>
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
                        <div class="day blue-bg length10 pos-rel_ "></div>

                        @endif

                    </div>
                @endif

        @if($val['s_type']=='refill_delay')     
        <div class="flx-justify-start pos-rel_ days-container 10">
            <div class="days-overdue">&hellip; <span class="days-value">{{ $val['delay'] }}</span> days overdue &hellip; </div>
            <div class="day red-bg length10 pos-rel_ ">
                <div class="refill-info" title="Refill Date Was : {{ $val['refill_date_should_be'] }}">
                    <span class="refill-price">&nbsp;</span>
                </div>
                <div class="date-box">
                    <span class="date-value txt-black-24">{{ $val['refill_date_should_be'] }}</span>
                </div>
            </div>
             @if($val['notifications'] and count($val['notifications'])>0)

                @foreach($val['notifications'] as $nmVal)

                    <div class="day red-bg length20 pos-rel_ "></div>

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

            <div class="day red-bg length30 pos-rel_ "></div>
            <div class="day red-bg length10 pos-rel_ "></div>
            <div class="day red-bg length10 pos-rel_ "></div>
            <div class="day red-bg length30 pos-rel_ "></div>
            <div class="day red-bg length20 pos-rel_ "></div>
            <div class="day red-bg length10 pos-rel_ "></div>
            <div class="day red-bg length30 pos-rel_ "></div>
            <div class="day red-bg length10 pos-rel_ "></div>
            <div class="day red-bg length10 pos-rel_ "></div>
            <div class="day red-bg length30 pos-rel_ "></div>
            <div class="day red-bg length20 pos-rel_ "></div>
            <div class="day red-bg length10 pos-rel_ "></div>

            @endif
        </div>
        @endif

     @endforeach
  @endif
    </div>
</div>