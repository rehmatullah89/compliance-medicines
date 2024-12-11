@extends('layouts.compliance')

@section('content')

<style>
.dataTables_wrapper table.reports-bordered th { padding: 0.3vw !important; padding-left: 14px !important; }
.dataTables_wrapper table.dataTable thead .sorting { background-position: left 4px; }
</style>

<div class="row">

<div class="col-sm-12 col-lg-12">

    <div class="row mt-7_ ml-0 mr-0 " style="border-bottom: solid 1px #cecece;">

            <div class="col-sm-12 pl-0 pr-0">

                <h4 class="elm-left fs-24_ mb-3_">Rx's Refillable Now & Refills Remaining</h4>

                <div class="elm-right" id="download_icon">


                    <form action="{{ url('report/generate') }}" method="post" style="float:right">

                        {{ csrf_field()  }}

                        <input type="hidden" name="report_type" value="rx_refill_due_and_remaining" />

                        <input type="hidden" name="number_of_days" value="30" />

                        <input type="hidden" name="order_by" />

                        <input type="hidden" name="type" />

                        <input type="hidden" name="export_by" value="pdf" />

                        <!--<button type="button" disabled="" class="btn clean_"><span class="fa fa-print txt-blue fs-24_"></span></button>-->

                        <button title="Export this report detail in PDF" type="submit"  class="btn clean_"><span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span></button>

                    </form>

                                



                </div>
				<div class="elm-right cnt-left">
                    <button class="btn bg-dk-grn-txt-wht fs-14_ tt_cc_ pa-4_ mr-14_" style="line-height: 14px; padding:6px; color: white;" id="send_refill_reminders" title="Resend Refill Reminder">Resend Refill Reminder</button>
    		
                                <!-- <a class="btn bg-blue-txt-wht fs-14_ tt_cc_ pa-4_ mr-14_" style="line-height: 14px; padding:6px; color: white;" onclick="sendBulkSurvey();" title="Send Bulk Survey">Send Survey</a> -->
    			</div>

            </div>

        </div>



        <div class="row mt-17_">

            <div class="col-sm-12">



                <div class="trow_ "> {{-- compliance-tabs all-request-search-fields --}}

                    

    			</div>



                <div class="row pr-14_ pl-14_" id="report_table_data">

                            <div class="col-sm-12 mb-7_ pb-7_ pl-0 pr-0 table-responsive">

                                <table class="table reports-bordered compliance-user-table aa-client-dashboard-bld-table19mar-l99 @if(count($result)==0) {{'empty-table'}} @endif" style="min-width: 700px;">

                                    <thead>

                                        <tr>
											<th class="cnt-center select-col_ noSort" style="background-color:white;">
                                                <input value="" type="checkbox" id="selectAll" style="margin-right: 0px !important;" title="Select All" />
                                            </th>
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

                                         <tr class="L122">

                                             @php

                                             $keys = [];

                                             $keys = array_keys($valRes);

                                             @endphp

												<td class=" cnt-center select-col_">
                                                <input name="selectedPatient" class="selectBox" value="<?=$valRes['PatientId']?>" {{($valRes['RefillMessage']=='disabled' || $valRes['Refillable']=='no' )?'disabled checked':''}} data-orderid="{{$valRes['oid']}}" type="checkbox" />
                                                </td>
                                             @for($i=0; $i < count($keys); $i++)
												@if($keys[$i] != 'PatientId' && $keys[$i] != 'oid' && $keys[$i] != 'Refillable'  && $keys[$i] != 'RefillMessage')
                                                    <td class="L129  {{$keys[$i]}}@if(isset($col_style[$i])) {{ $col_style[$i] }} @else {{ 'bg-tb-blue-lt txt-blue' }} @endif @if($valRes[$keys[$i]] && is_numeric($valRes[$keys[$i]])  &&  $valRes[$keys[$i]] <= 0) txt-red @endif">
                                                        @if($keys[$i] != 'rxprofit1')
                                                        {!! $valRes[$keys[$i]] !!} 
                                                        @else 
                                                        {{ '$ '.number_format($valRes[$keys[$i]], 2)  }} 
                                                        @endif
                                                    </td>
												@endif
                                             @endfor

                                         </tr>

                                         @endforeach



                                         @else                                    <script>

                                       var no_data = true;

                                        </script>



                                         <tr>

                                             <td id="main_report_noData" style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>

                                         </tr>

                                         @endif

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            @for($i=0; $i < count($total_row); $i++)
                                           
                                        <th style="text-align: <?=($i)?'right':'center';?>; font-weight:bold;">
                                          @if($i == 1)
                                            @if(is_numeric($total_row[$i]) && $total_row[$i] <= 0)
                                               <span class="txt-red"> $ {{number_format($total_row[$i],2)}} </span>
                                                @else 
                                                <span class="txt-green"> $ {{number_format($total_row[$i],2)}} </span>
                                               @endif
                                                @else 
                                          {{$total_row[$i]}}
                                          @endif
                                        </th>
                                             @endfor
                                             <th></th>
                                            </tr>
                                    </tfoot>

                                </table>

                            </div>

                        </div>



            </div>

        </div>

</div>

</div>

<div class="modal" id="bulk_survey_modal">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">
        
      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">
  					<div class="col-sm-12 modal-header">
                                            <h4 class="modal-title" style="color:white;">Send Bulk Survey</h4>
                                        </div>
                                        <div id="practice-reg-step" class="tab-content current">
                                                    <div class="col-sm-12 pl-0 pr-0">
                                                            <div class="flds-prc-type-name flx-justify-start mb-14_ mt-36_ ml-7_">
                                                                <div class="field">
                                                                        <label class=" mb-4_ txt-gray-6 cnt-left">Search Survey:</label>
                                                                        <select class="wd-100p tt_uc_ txt-blue weight_600" name='survey_id' id='survey_id'>
                                                                            <option value="">Select Survey</option>
                                                                            @foreach($survey_data as $cData)
                                                                            <optgroup label="{{$cData->title}}">
                                                                                @foreach($cData->Survey as $sData)
                                                                                    <option value="{{$sData->id}}">{{$sData->title}}</option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                            @endforeach
                                                                        </select>
                                                                </div>       
                                                                @foreach($survey_data as $cData)                                                                            
                                                                    @foreach($cData->Survey as $sData)
                                                                        <input type="hidden" id='detail{{$sData->id}}' value="{{$sData->details}}">
                                                                    @endforeach
                                                                @endforeach
                                                            </div>
                                                            <span id='error_phone_number' style='display:none; color:red; margin-left: 10px;'>Please Select a Survey.</span>
                                                    </div>
                                                <div class="container mt-36_" style="padding-left: 5px;">        
                                                    <button type="button" id="send_bulk_survey" data-dismiss="modal" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">Send Survey</button>
                                                    <button type="button" id="preview_survey" class="btn bg-yellow weight_500 fs-14_ tt_uc_" style="display:none;">Preview</button>
                                                    <button id="cancel_btn" type="button" data-dismiss="modal" class="btn bg-red-txt-wht weight_500 fs-14_ mr-7_ tt_uc_">Cancel</button>
                                                </div>
                                        </div>
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="font-size: 1px; display: none;">
      </div>

    </form>
  </div>
</div>
@endsection



@section('js')

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
<script src="{{url('/js/form-render.min.js')}}"></script> 
<script src="{{url('/js/control_plugins/starRating.js')}}"></script> 

<script type="text/javascript">

    $(document).ready(function(){

        var oTable = $('.compliance-user-table').DataTable({

            processing: false,

            serverSide: false,

            Paginate: false,

            lengthChange: false,

            autoWidth: false,

            order:[],

            bFilter: true,

            aoColumnDefs: [{

                'bSortable': false,

                'aTargets': ['noSort']

            }]

        });

		var allPages = oTable.rows().nodes();
        
        $("#selectAll").click(function(){
            $('input.selectBox', allPages).not(":disabled").not(this).prop('checked', this.checked);
        });


        $('#send_refill_reminders').on('click', function(){
        
        
            $("#send_refill_reminders").prop('disabled', true);

        var orderIds = [];           
        $("input:checkbox[name=selectedPatient]:checked").not(":disabled").each(function(){
            orderIds.push($(this).data('orderid'));
        });

  
// return false;
        console.log(orderIds);
        if(orderIds.length == 0){
            toastr.remove();
            toastr.clear();
            toastr.error('Please select at least one Rx.');
            $("#send_refill_reminders").prop('disabled', false);
            return false;
        }else{
             $.ajax({
                type:'POST',
                url:"{{url('/send-refill-bulk-reminders')}}",
                data: 'orderIds='+orderIds,
                success:function(data) {
                    
                        if(data == 1){
                            toastr.success('Refill Reminder sent successfully.'); 
                            $.each( orderIds, function( index, value ){
   $('input[data-orderid="'+value+'"]').attr('disabled',true);
});           
                        }else{
                           toastr.error('There is some error occured while sending refill reminder.');      
                        }
                        
                        $("#send_refill_reminders").prop('disabled', false);      
                    },
                     headers: {
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
        }
        
    });


    });

	function sendBulkSurvey(){
            var selected = [];            
            $("input:checkbox[name=selectedPatient]:checked").not(":disabled").each(function(){
                selected.push($(this).val());
            });
            
            if(selected.length == 0){
                toastr.error('Please select at least one Rx.');
            }else            
                $('#bulk_survey_modal').modal('show');
    }

	$('#send_bulk_survey').on('click', function(){
        
        var selected = []; 
        var orderIds = [];           
        $("input:checkbox[name=selectedPatient]:checked").each(function(){
            selected.push($(this).val());
            orderIds.push($(this).data('orderid'));
        });
        console.log($("input:checkbox[name=selectedPatient]:checked"));
        console.log($("input:checkbox[name=selectedPatient]:checked").val());
console.log(selected);
        // return false;
        
        if($("#survey_id option:selected").val() == ""){
            toastr.remove();
            toastr.clear();
            toastr.error('Please select a survey.');
            
        }else{
             $.ajax({
                type:'POST',
                url:"{{url('/send-bulk-surveys')}}",
                data: 'survey_id='+$("#survey_id option:selected").val()+'&patients='+selected,
                success:function(data) {
                    
                        if(data == 1){
                            toastr.success('Survey sent successfully.');                
                        }else{
                           toastr.error('There is some error occured while sending survey.');      
                        }
                        
                        $("#send_bulk_survey").prop('disabled', false);      
                    },
                     headers: {
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
        }
        
    });




    
    $('#survey_id').change(function(){
        var selected = $("#survey_id option:selected").val();  
        console.log("Selected:"+selected);
        if(selected != ""){
            $('#preview_survey').show();
        }else{
            $('#preview_survey').hide();
        }
    });
    
    $('#preview_survey').click(function(){
       var selected = $("#survey_id option:selected").val();
       showPreview($('#detail'+selected).val());
    });
    
    function showPreview(formData) 
    {
        var HeaderImgPath = "";
        var selected = $("#survey_id option:selected").val();
        var formData =  $('#detail'+selected).val();
         let formRenderOpts = {
            dataType: 'json',
            formData
          };
          let $renderContainer = $('<form/>');
          $renderContainer.formRender(formRenderOpts);
          let html = `<!doctype html><title>Form Preview</title><body class="container">`;
              if(HeaderImgPath != "")
                html += `<div style="text-align:center;"><img src="{{ !empty($header_image_path)? url($header_image_path): ''}}" style="max-width: 200px; margin:20px 0px;"></div>`;
            html += `<div class="trow_ cnt-center c-dib_ mt-14_ mb-14_"><span class="fs-24_ tt_cc_ txt-grn-lt weight_600 br-top-blue-w1 br-bottom-blue-w1 pl-2_ pr-2_">`+$("#survey_id option:selected").text()+`</span>`;
            html += `</div><h4 style="text-align:center; color:blue;">{{isset($theme->header_text)?$theme->header_text:''}}</h4><div class="trow_ cnt-center c-dib_ mt-24_ mb-14_">`;
            html += `<span class="fs-17_ tt_cc_ txt-blue weight_600">This is the first activity to fulfill your obligation in Compliance Reward. Please provide feedback about your experience.</span>`;
            html += `</div><hr>${$renderContainer.html()}<h4 style="text-align:center; color:blue;">{{isset($theme)?$theme->footer_text:''}}</h4><div class="trow_ mt-14_">`;
            html += `<button class="wd-100p btn bg-lt-grn-txt-wht weight_600 fs-17_ tt_uc_ pa-12_ mb-7_ cnr-center " style="line-height: 14px;">submit questionnaire</button>`;
            html += `</div></body></html>`;
          var formPreviewWindow = window.open('', 'formPreview', 'height=550,width=500,padding=20,toolbar=no,scrollbars=yes');

          formPreviewWindow.document.write(html);
          var style = document.createElement('link');
          style.setAttribute('href', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
          style.setAttribute('rel', 'stylesheet');
          style.setAttribute('type', 'text/css');
          formPreviewWindow.document.head.appendChild(style);

          var style1 = document.createElement('link');
          style1.setAttribute('href', "{{ asset('css/generic-survey-mobile.css') }}");
          style1.setAttribute('rel', 'stylesheet');
          style1.setAttribute('type', 'text/css');
          formPreviewWindow.document.head.appendChild(style1);
    } 
</script>

@endsection