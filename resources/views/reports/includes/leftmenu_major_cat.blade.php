@if($filtered_result)
<ul class="submenu_ver-l1">
 @foreach($filtered_result as $key=>$value)
    <li>
        <div class="trow_ c-dib_ collapsed exp-col-ico cur-pointer weight_500 fs-14_ txt-blue" data-toggle="collapse" data-target="#{{Str::slug($key, '-')}}" aria-expanded="false">{{$key}}</div>
            
        <ul class="wd-100p submenu-ver-l2 collapse" id="{{Str::slug($key, '-')}}">
        @foreach($value as $nKey=>$nValue)
                    <li class="subMenu-hover" id="{{Str::slug($nValue->minor_reporting, '-')}}">
                    <span onmouseover="get_orders_by_minor_reproting('{{str_replace(' ', '--',$nValue->minor_reporting)}}', '{{Str::slug($nValue->minor_reporting, '-')}}')" class="drug-subcat-name">{{$nValue->minor_reporting}}</span> 
                    <span onmouseover="get_orders_by_minor_reproting('{{str_replace(' ', '--',$nValue->minor_reporting)}}', '{{Str::slug($nValue->minor_reporting, '-')}}')" class="dsn-counter ">({{$nValue->total_orders}})</span>


                    
                            <div class="submenu-hor-l3" id="show-{{Str::slug($nValue->minor_reporting, '-')}}">
                                    <!--<ul>
                                            <li><span class="p-score">compliance score</span> <span class="p-name">product</span></li>
                                            <li><span class="p-score">85.0</span> <span class="p-name">Dummay Product</span></li>
                                    </ul>-->
                            </div>
                    </li>
        @endforeach
            </ul>
    </li>	
 @endforeach						
</ul>
@endif