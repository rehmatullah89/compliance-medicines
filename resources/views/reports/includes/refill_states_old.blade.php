<div class="trow_ top-row-stats">
    <div class="elm-left left-heading">put out of pocket</div>
    <div class="elm-right right-score" style="display: none;">
            <span class="txt-red title_">Total<br>Score</span>
            <span class="txt-red value_ fs-24_ weight_600">@if(count($statistics)>0){{number_format($total_delays/(count($statistics)+1), 2)}}@else{{ '0' }}@endif</span>
    </div>
</div>								
<ul id="refill-stats">
        @if($statistics)
                @foreach($statistics as $stat)

             
                       @php 
                                $dates[] = $stat->LastRefillDate;
                                $dates[] = $stat->refill_date;
                        @endphp
                        {{-- <li class="first_li"><span class="refill-date ">{{ date('m/d/y' , strtotime($stat->LastRefillDate))}}</span></li>
                        --}}
                        @if(isset($stat->delay) and $stat->delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->delay/$total_days)*100}}%">
                                <span class="red-line"></span>
                                <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->delay}}</span> Days Overdue..</span>
                        </li>
                        @endif
                        @if(isset($stat->total_days) and $stat->total_days  > 0)
                        <li class="blue-stats"  style="width: {{($stat->refillDays/$total_days)*100}}%;">
                                <div class="refill-info" title="Refill Date : {{$stat->refill_date}}">
                                        <span class="refill-price">${{$stat->RxPatientOutOfPocket}}</span>
                                        <span class="refill-circle">R</span>
                                        {{-- <span class="refill-date">{{ date('m/d/y' , strtotime($stat->refill_date))}}</span> --}}
                                </div>
                                <span class="blue-line"></span>
                        </li>
                        @endif
                        @if(isset($stat->end_delay) and $stat->end_delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->end_delay/$total_days)*100}}%">
                                
                                <span class="red-line"></span>
                                <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->end_delay}}</span> Days Overdue..</span>
                        </li>
                        @endif
                @endforeach
                
               
                
        @endif
</ul>			





<ul id="refill-stats-mrd">
        @if($statistics)
                @foreach($statistics as $stat)

             
                       @php 
                                $dates[] = $stat->LastRefillDate;
                                $dates[] = $stat->refill_date;
                        @endphp
                         <li class="first_li"><span class="refill-date ">{{ date('m/d/y' , strtotime($stat->LastRefillDate))}}</span></li>
                        @if(isset($stat->delay) and $stat->delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->delay/$total_days)*100}}%">
                                {{-- <span class="red-line"></span> --}}
                                {{-- <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->delay}}</span> Days Overdue..</span> --}}
                        </li>
                        @endif
                        @if(isset($stat->total_days) and $stat->total_days  > 0)
                        <li class="blue-stats"  style="width: {{($stat->refillDays/$total_days)*100}}%;">
                                <div class="refill-info" title="Refill Date : {{$stat->refill_date}}">
                                        {{-- <span class="refill-price">${{$stat->RxPatientOutOfPocket}}</span> --}}
                                        {{-- <span class="refill-circle">R</span> --}}
                                        <span class="refill-date">{{ date('m/d/y' , strtotime($stat->refill_date))}}</span>
                                </div>
                                {{-- <span class="blue-line"></span> --}}
                        </li>
                        @endif
                        @if(isset($stat->end_delay) and $stat->end_delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->end_delay/$total_days)*100}}%">
                                
                                {{-- <span class="red-line"></span> --}}
                                {{-- <span class="c-dib_ overdue-days no-wrap-text">..<span class="fs-24_">{{$stat->end_delay}}</span> Days Overdue..</span> --}}
                        </li>
                        @endif
                @endforeach
                
                <li class="last_li"><span class="refill-date ">@php echo date('m/d/Y'); @endphp</span></li>

                
        @endif
</ul>			


{{-- <ul id="date-list" class="pos-rel_">
        @foreach($dates as $val)
        <li class="c-dib_ cnt-center"><span class="vertical-bar bg-gray-d9"></span><span class="trow_ date txt-blue mt-4_">{{$val}}</span></li>
        @endforeach
</ul> --}}

{{-- 
<ul id="date-list" class="pos-rel_">
        @if($statistics)
                @foreach($statistics as $stat)
                <span class="vertical-bar bg-gray-d9"></span>
                {{ date('m/d/y' , strtotime($stat->LastRefillDate))}}
                        @if(isset($stat->delay) and $stat->delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->delay/$total_days)*100}}%">
                                <span class="red-line"></span>
                                <span class="overdue-days no-wrap-text"><span class="fs-24_"></span></span>
                        </li>
                        @endif
                        @if(isset($stat->total_days) and $stat->total_days  > 0)
                        <li class="blue-stats"  style="width: {{($stat->refillDays/$total_days)*100}}%;">
                                <div class="refill-info" >
                                        <span class="vertical-bar bg-gray-d9"></span>
                                           <span class="">{{ date('m/d/y' , strtotime($stat->refill_date))}}</span>
                                </div>
                                <span class="blue-line"></span>
                        </li>
                        @endif
                        @if(isset($stat->end_delay) and $stat->end_delay and $stat->total_days > 0)
                        <li class="red-stats" style="width: {{($stat->end_delay/$total_days)*100}}%">
                                <span class="red-line"></span>
                                <span class="overdue-days no-wrap-text"><span class="fs-24_"></span> </span>
                        </li>
                        @endif
                @endforeach
             
                {{ date('m/d/y' )}}
        @endif
        
</ul> --}}