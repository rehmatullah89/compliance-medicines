@extends('layouts.compliance')

@section('content')


<style>

    .row.cmp-container-sidebar-menu.fullwidth { padding-right: 14px; }
    
</style>

<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12">
		<h4 class="elm-left fs-24_ mb-4_">Program Activity</h4>
		<div class="date-time elm-right">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
	</div>
</div>

<div class="row mt-17_">
	<div class="col-sm-12">
		<div class="row" style="border: solid 1px #dee2e6;">
			<div class="col-sm-12">
				<div class="row pt-14_">
					<div class="col-sm-12 c-dib_ ">
						<span class="weight_600 txt-blue tt_uc_ fs-16_ elm-left">{{ucfirst(str_replace ("_", " ", $report_title))}}</span>
					</div>
				</div>
				
				<div class="row pt-14_">
					<div class="col-sm-12" style="display: flex; align-items: flex-end; justify-content: flex-start;">
                            <form action="{{ url('report/all_cwp_act') }}" id="main_reports" name="main_reports" method="post" class="elm-left c-dib_ compliance-form_" style="width:90%;">
                            {{ csrf_field() }}
                            <input type="hidden" id="menustate" name="mstate" value="<?= Request::input('mstate') ?>" >
							<div class="field wd-100p fld-practice-reports mr-14_ pos-rel_ bg-white" style="max-width: 240px;">
								<label class="wd-100p">From Date</label>
                                <input type="text" class="wd-100p" style="position: relative;z-index: 100;background-color: transparent;"
                                        placeholder="" data-provide="typeahead" required
                                        autocomplete="off" value="{{ $table_dates['start_date'] }}"
                                        id="datepicker_from" name="from_date">
                                <span id="pa_from_icon"  class="fa fa-calendar" style="position: absolute;right:7px;top: 29px;z-index:40;"></span>
							</div>
                            <div class="field wd-100p fld-practice-reports mr-14_ pos-rel_ bg-white" style="max-width: 240px;">
								<label class="wd-100p">End Date</label>
                                <input type="text" class="wd-100p" style="position: relative;z-index: 100;background-color: transparent;"
                                        placeholder="" data-provide="typeahead" required
                                        autocomplete="off" value="{{ $table_dates['end_date'] }}"
                                        id="datepicker_to" name="to_date">
                                <span class="fa fa-calendar pa_to_icon" style="position: absolute;right:7px;top: 29px;z-index:40;"></span>
							</div>
                            <div class="wd-11p field-buttons" style="min-width: 170px;margin-top: 17px;background-color: white;justify-content: flex-start;">
                                <button type="button" class="btn bg-red-txt-wht btn-clear_"  style="height: 36px; border-radius:0px;margin-left: 7px;" onclick="window.location='{{ url('report/all_cwp_act') }}'" >Clear</button>
                                <button type="submit" class="btn bg-blue-txt-wht btn-search_" style="height: 36px; border-radius:0px;margin-left: 7px;">Search</button>
                            </div>
						</form>
						@if($result)
						<div style="margin-left: auto; position: relative; top: 14px;">
							
                                                        <!-- <button disabled="" type="button" class="btn clean_">
								<span class="fa fa-print txt-blue fs-24_"></span>
							</button> -->
                            <form action="{{ url('report/generate')}}" method="post" style="float:right">
                        {{ csrf_field()  }}
                        <input type="hidden" name="report_type" value="cr_program_activity">
                        <input type="hidden" required value="@if(request()->get('from_date')){{ request()->get('from_date') }} @else {{ $table_dates['start_date'] }} @endif" name="from_date">
                        <input type="hidden"  value="@if(request()->get(request()->get('to_date'))){{ request()->get('to_date') }} @else {{ $table_dates['end_date'] }} @endif" name="to_date">
                        <input type="hidden" name="export_by" value="pdf">
                
                        <button  type="submit" class="btn clean_ pa-0_">
                                <span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span>
                            </button>
                    </form>
                                                        
						</div>
                             @endif               
                                            
                                            
                                            
					</div>
				</div>
				<div class="row mt-17_ mb-17_ pr-14_ pl-14_">
					<div class="col-sm-12 pr-0 pl-0 table-responsive pb-7_">
                    <table class="table compliance-user-table reports-bordered mb-7_" style="min-width:1024px; margin-bottom: 7px;">                                    
                        <thead>
                            <tr>
                               @if($tab_title)
                                @foreach($tab_title as $keyTab=>$valTab)
                                @php 
                                $style = ''; 
                                $class = '';
                                if(is_array($valTab)){ 
                                    if(isset($valTab['style'])) { $style = $valTab['style']; } 
                                    if(isset($valTab['class'])) { $class = $valTab['class']; } 
                                    $valTab = $valTab['title']; 
                                } 
                                @endphp
                                <th style="{{ $style }}" class="{{ $class }}">{{ $valTab }}</th>
                                 @endforeach                  
                               @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($result)
                            @foreach($result as $keyRes=>$valRes)
                             <tr>
                                 @php 
                                 $keys = []; 
                                 $keys = array_keys($valRes);            
                                 @endphp
        
                                 @for($i=0; $i < count($keys); $i++)
                                 <td class="@if(isset($col_style[$i])) {{ $col_style[$i] }} @else {{ 'bg-tb-blue-lt txt-blue' }} @endif">{{ $valRes[$keys[$i]] }}</td>
                                 @endfor
                             </tr>
                             @endforeach
        
                             @else
                        <script>
                           var no_data = true;
                            </script>
        
                             <tr>
                                 <td style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
                             </tr>
                             @endif
                        </tbody>                                  
                    </table>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

@include('partials.js.reports_js')

<script type="text/javascript">
    $(document).ready(function(){
            // var flg=true;
            
$('#datepicker_from').datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy',
                });
           $('#datepicker_to').datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy',
                }); 
//             $('#datepicker_from').click(function(e){

//          	console.log($(document).find(".datepicker-dropdown").is(":visible"));
//          	if($(document).find(".datepicker-dropdown").is(":visible"))
//          	{
//          		$('#datepicker_from').datepicker("hide");
//          	}else{
                
//                 $('#datepicker_from').datepicker({
//                 autoclose: true,
//                 format: 'mm/dd/yyyy',
//                 });
//                 $('#datepicker_from').datepicker("show");
//             }
//          });

//         $('#datepicker_to').click(function(e){

//             console.log($(document).find(".datepicker-dropdown").is(":visible"));
//             if($(document).find(".datepicker-dropdown").is(":visible"))
//             {
//                 $('#datepicker_to').datepicker("hide");
//             }else{
                
//                 $('#datepicker_to').datepicker({
//                 autoclose: true,
//                 format: 'mm/dd/yyyy',
//                 });
//                 $('#datepicker_to').datepicker("show");
//             }
//          });

//         $('body').click(function(evt){    
//        if(evt.target.id != "datepicker_from"){
//         console.log("s");
//           $('#datepicker_from').datepicker("hide");
//        }
       
// });

         if(no_data==true)
         {
             //alert('adfad');
             $('.compliance-user-table').removeClass('dataTable');
         }
         

         
         
       });
    </script>
    
    
@endsection