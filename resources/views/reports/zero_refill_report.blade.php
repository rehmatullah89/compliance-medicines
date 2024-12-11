@extends('layouts.compliance')

@section('content')


<style>

.dataTables_wrapper table.reports-bordered th { padding: 0.3vw !important; padding-left: 14px !important; }
.dataTables_wrapper table.dataTable thead .sorting { background-position: left 4px; }

table.reports-bordered thead th.select-col_ { padding-left: 0.3vw !important; padding-right:0.3vw !important; vertical-align: middle;}
table.reports-bordered thead th.select-col_ input[type="checkbox"] { margin-right: 0px; }

table.reports-bordered tbody td.select-col_ { vertical-align: middle; }
table.reports-bordered tbody td.select-col_ input[type="checkbox"] { margin-right: 0px; }



</style>
<div class="row">
<div class="col-sm-12 col-lg-12">
    <div class="row mt-7_ ml-0 mr-0 " style="border-bottom: solid 1px #cecece;">
            <div class="col-sm-12 pl-0 pr-0">
                <h4 class="elm-left fs-24_ mb-3_">Rx's with 0 Refills Remaining</h4>
                <div class="elm-right cnt-left">
                                <a class="btn bg-blue-txt-wht fs-14_ tt_cc_ pa-4_ mr-14_" style="line-height: 14px; padding:6px; color: white;" onclick="sendBulkSurvey();" title="Send Bulk Survey">Send Survey</a>
    				<!-- <a class="btn bg-blue-txt-wht fs-14_ tt_cc_ pa-4_ mr-14_" style="line-height: 14px; padding:6px;" href="#authorize-refill" title="Authorize Refill">Authorize Refill</a>-->
    				<a class="btn bg-blue-txt-wht fs-14_ tt_cc_ pa-4_" style="line-height: 14px; padding:6px;" href="{{ url('reporter/report/zero_refill/download') }}" title="Download this report in Excel">Download</a>
    			</div>
                {{--<div class="date-time elm-right lh-28_ mb-3_">{{ now('America/Chicago')->isoFormat('LLLL') }}</div>--}}
            </div>
        </div>

        <div class="row mt-17_">
            <div class="col-sm-12">

                <div class="row pr-14_ pl-14_">
                    <div class="col-sm-12 pr-0 pl-0 table-responsive">
                        <table class="table reports-bordered mb-4_ reporter_reports" style="min-width:1024px;">
                            <thead>
                                <tr>
                                    <th class="bg-gray-e txt-wht cnt-center select-col_ noSort">
                                        <input value="" type="checkbox" id="selectAll" style="margin-right: 0px !important;" title="Select All" />
                                    </th>
                                    <th class="bg-blue txt-wht">Refillable Next</th>
                                    <th class="bg-gr-bl-dk txt-wht">Patient Name</th>
                                    <th class="bg-gray-80 txt-wht">Pharmacy Rx #</th>
                                    <th class="bg-orage txt-wht">Rx Expires</th>
                                    <th class="bg-gray-1 txt-wht">Rx Label Name</th>
                                    <th class="bg-orange-md txt-wht">Strength</th>
                                    <th class="bg-grn-lk txt-wht">Dosage Form</th>
                                    <th class="bg-tb-cyan txt-wht">Rx Qty</th>
                                    <th class="bg-red2 txt-wht">Last Fill Patient CoPay</th>
                                    <th class="bg-purple txt-wht">Last Fill Insurance Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($orders_data)
                                @foreach($orders_data as $orders_data)
                                <tr>
                                    <td class="bg-gray-e cnt-center select-col_"><input name="selectedPatient" class="selectBox" value="{{$orders_data->pat_id}}" type="checkbox" /></td>
                                    <td class="bg-tb-blue-lt2 txt-black-24">{{ $orders_data->nextRefillDate }}</td>
                                    <td class="bg-gray-e txt-blue">{{ $orders_data->PatName }}</td>     
                                    <td class="bg-tb-wht-shade2 txt-blue tt_uc_ zero_slashes">{{ $orders_data->RxNumber }}</td>
                                    <td class="bg-tb-orange-lt txt-black-24">{{ $orders_data->RxExpiryDate }}</td>
                                    <td class="bg-purple2 txt-black-24 cnt-left">{{ $orders_data->rx_label_name }}</td>
                                    <td class="bg-pnk-lt txt-black-24 cnt-left">{{ $orders_data->strength }}</td>            
                                    <td class="bg-tb-grn-lt txt-black-24 tt_uc_ cnt-left">{{ $orders_data->dosage_form }}</td>
                                    <td class="bg-cyan-lt txt-black-24 cnt-left">{{ $orders_data->qty }}</td>
                                    <td class="bg-tb-pink2 txt-black-24 cnt-right">${{ $orders_data->RxPatientOutOfPocket }}</td> 
                                    <td class="bg-purple2 txt-black-24 cnt-right">${{ $orders_data->RxThirdPartyPay }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="14" style="text-align:center;">No Record Found</td>
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
                                                                        @foreach($survey_data as $cData)                                                                            
                                                                            @foreach($cData->Survey as $sData)
                                                                                <input type="hidden" id='detail{{$sData->id}}' value="{{$sData->details}}">
                                                                            @endforeach
                                                                        @endforeach
                                                                </div>                                                                
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
        @if($orders_data)
        var oTable = $('.reporter_reports').DataTable({
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            stateSave: true,
            aoColumnDefs: [{
                'bSortable': false,
                'aTargets': ['noSort']
            }]
        });
         var allPages = oTable.rows().nodes();
        @endif

        $("#selectAll").click(function(){
            $('input.selectBox', allPages).not(this).prop('checked', this.checked);
        });
    });
        
    function sendBulkSurvey(){
            var selected = [];            
            $("input:checkbox[name=selectedPatient]:checked").each(function(){
                selected.push($(this).val());
            });
            
            if(selected.length == 0){
                toastr.error('Please select atleast on patient.');
            }else            
                $('#bulk_survey_modal').modal('show');
    }
    
    $('#send_bulk_survey').on('click', function(){
        
        var selected = [];            
        $("input:checkbox[name=selectedPatient]:checked").each(function(){
            selected.push($(this).val());
        });
        
        if($("#survey_id option:selected").val() == ""){
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