@extends('reports.pdf_layout.header')
@section('pdf_content')
<main>
<div class="Table-block">
    @isset($export_check )
    <form action="{{ url('report/generate') }}" method="post" style="float:right">
        {{ csrf_field()  }}
        <input type="hidden" name="report_type" value="{{ request()->get('report_type') }}" />
        <input type="hidden" name="number_of_days" value="{{ request()->get('number_of_days') }}" />
        <input type="hidden" name="order_by" />
        <input type="hidden" name="type" />
        <input type="hidden" name="export_by" value="pdf" />
        <button class="btn btn-success" type="submit">Export</button>
    </form>
    @endisset 
    <h5>{{ucfirst(str_replace ("_", " ", $report_title))}}</h5>
    
    <table style="margin-bottom: 10px;border:none;">
        <tr style="color: blue;">
            <td colspan="2" style="color:blue;"><strong>Current Date : </strong>11/29/2019</td>
        </tr>
        <tr style="background-color: #f6f6f6;">
            <td style="width:50%;"><strong>Cycle Beginning : </strong> 8/1/2019</td>
            <td style="width:50%;"><strong>Cycle Ending : </strong> 8/1/2019</td>
        </tr>
    </table>
    
   
    <table class="data-table">
        <thead>
            <tr>
               @if($tab_title)
                @foreach($tab_title as $keyTab=>$valTab)
                @php $style = ''; if(is_array($valTab)){ if(isset($valTab['style'])) { $style = $valTab['style']; } $valTab = 

$valTab['title']; } @endphp
                 <th {{ $style }}>{{ $valTab }}</th>
                 @endforeach                  
               @endif
            </tr>
        </thead>
        <tbody>
       @if($result)
       @foreach($result as $keyRes=>$valRes)
        <tr>
            <td>{{ ($keyRes+1) }}</td>
            @php 
            $keys = []; 
            $keys = array_keys($valRes);            
            @endphp
            
            @for($i=0; $i < count($keys); $i++)
                <td align="right">{{ $valRes[$keys[$i]] }}</td>
            @endfor
        </tr>
        @endforeach
        
        @else
        
        <tr>
            <td style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
        </tr>
        @endif
                   
        </tbody>
    </table>






</div>
@endsection

</main>