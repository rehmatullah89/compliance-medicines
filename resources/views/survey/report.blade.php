@extends('layouts.compliance_survey')

@section('content')

<style>

.container.full_width { min-width: 100%;max-width: 100%;padding-left: 0px;padding-right: 0px; }

.container.reporter_container { min-width: 100%;max-width: 100%; }


.chart-box { border: solid 1px #cecece; box-shadow: 0px 4px 7px 1px #ccc; padding: 14px 24px; border-radius: 7px;}
.chart-box .chart-text { max-width: 240px; }
.chart-box .chart-details-list {  }
.chart-box .chart-details-list li .blue-rect { width: 1em; height: 1em; border-radius: 2px; background-color: #218ac4; }
.chart-box .chart-details-list li .green-rect { width: 1em; height: 1em; border-radius: 2px; background-color: #71b739; }
.chart-box .chart-details-list li .orange-rect { width: 1em; height: 1em; border-radius: 2px; background-color: #e89714; }
.chart-box .chart-details-list li .purple-rect { width: 1em; height: 1em; border-radius: 2px; background-color: #b327d1; }
.chart-box .chart-details-list li .red-rect { width: 1em; height: 1em; border-radius: 2px; background-color: #d12727; }


.select2-container--default .select2-selection--single {
    border: solid 1px #3e7bc4 !important;
    border-radius: 6px;
    height: 32px;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder,
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 30px;
    color: #3e7bc4 !important;
    font-weight: 600;
    text-transform: uppercase;
}

.select2-container--default .select2-results>.select2-results__options
{
    color: #3e7bc4 !important;
    text-transform: uppercase;
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    margin-top: 5px;    
}

.loader {
    border: 5px solid #f3f3f3;
    -webkit-animation: spin 1s linear infinite;
    animation: spin 1s linear infinite;
    border-top: 5px solid #555;
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<div class="row">

	<div class="col-sm-12" id="survey-report-board">


        <div class="row bg-gray-f2">
        	<div class="col-sm-12 mb-14_">
        		<div class="container">
        			<h4 class="elm-left cnt-left fs-20_ pt-14_ pb-7_ mb-3_ txt-blue weight_600">Search Criterion:</h4>
                                <div class="elm-right c-dib_ mt-14_" style="margin-right:40px;">
        				<div class="bg-gray-d9 txt-blue weight_600 br-rds-13 mr-14_ p6-12_ tt_uc_">total surveys sent : {{$totalSent}}</div>
        				<div class="bg-gray-d9 weight_600 txt-blue br-rds-13 p6-12_ tt_uc_">total responses : {{$totalResponse}}</div>
        			</div>
        		</div>
        	</div>
        </div>
        
		<div class="row bg-gray-f2">
			<div class="col-sm-12 mb-14_">
				<div class="container">
        				
    				<div class="flx-justify-start compliance-form_ mb-14_" style="align-items: flex-end;">
    					
                                        <div class="field wd-16p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Select Category:</label>
                                                <select class="wd-100p tt_uc_ txt-blue weight_600" type="text" name="category" id="category">
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $key => $category)
    							<option value="{{$key}}">{{$category}}</option>
                                                    @endforeach    
    						</select>
    					</div>
    					
    					<div class="field wd-16p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Survey Name: <span id='error_survey_name' style='display:none; font-weight: bold; color:red;'> (Required Field)</span></label>
                                                <select class="wd-100p tt_uc_ txt-blue weight_600" type="text" name="survey_name" id="survey_name" required="">
    						</select>
    					</div>
    					
    					<div class="field wd-16p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Practice Name:</label>
    						<select class="wd-100p tt_uc_ txt-blue weight_600" name='practice_name' id='practice_name'>
                                                </select>
    					</div>
    					
    					<div class="field wd-16p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Created By:</label>
    						<select class="wd-100p tt_uc_ txt-blue weight_600" type="text" name="created_by" id="created_by">
                                                    <option value="">Select User Name</option>
                                                    @foreach($users as $key => $user)
    							<option value="{{$key}}">{{$user}}</option>
                                                    @endforeach    
    						</select>
    					</div>
    					
    					<div class="field wd-16p mr-1p">
    						<label class="wd-100p mb-4_ txt-gray-6 cnt-left">Chart View:</label>
    						<select class="wd-100p tt_uc_ txt-blue weight_600" type="text" name="chart_type" id="chart_type">
                                                    <option value="">Select Chart Type</option>
                                                    <option value="I" selected="">Individual</option>
                                                    <option value="S" disabled="">Summary</option>
    						</select>
    					</div>
    					
    					<div class="field wd-14p">
    						<button type="button" id="generate_report" class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_">generate report</button>
    					</div>
    					
    				</div>
        				
				</div>
			</div>
		</div>
		
    	
    	<div class="row bg-white">
			<div class="col-sm-12">
				<div class="container">
                	<div class="row mt-24_ mb-17_ pr-14_ pl-14_">
                        <div class="col-sm-12 pr-0 pl-0 table-responsive">
                            <table class="table reports-bordered mb-4_" style="min-width:1024px;">
                                <thead>
                                    <tr>
                                        <th class="bg-blue txt-wht">Practice Name</th>
                                        <th class="bg-gr-bl-dk txt-wht">Survey Name</th>
                                        <th class="bg-red txt-wht">No. of Survey Sent</th>
                                        <th class="bg-orage txt-wht">Survey Source</th>
                                        <th class="bg-grn-lk txt-wht">Time Stamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    	<td class="bg-tb-blue-lt2 txt-blue cnt-left" id="practice_data">-</td>
                                    	<td class="bg-gray-e txt-blue cnt-left" id="survey_data">-</td>
                                    	<td class="bg-tb-pink2 txt-red cnt-center" id="count_data">-</td>
                                    	<td class="bg-tb-orange-lt txt-gray-6">Mobile</td>
                                    	<td class="bg-tb-grn-lt txt-gray-6" id="time_data">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row bg-white">
            <div class="col-sm-12">
                    <div class="loader" id="toggle_loader"  style="display: none; float: none; margin: 0px auto; margin-bottom: 17px; "></div>
                    <div class="container">
                        
                        <div class="flx-justify-start f-wrap" id="charts_data">
                            
                            <!--<div class="chart-box wd-31p mr-2p mb-24_ pos-rel_">
                    		<div class="trow_">
                    			<div class="chart-text wd-80p fs-16_ weight_600 mb-14_">On a scale from 1 to 5 how would you rate easiness of application?</div>
                    		</div>
                    		<div class="trow_">
	                    		<div class="elm-left">
                        			<ul class="chart-details-list">
                        				<li class="mb-4_ c-dib_"><span class="blue-rect"></span> <span class="txt-gray-6 weight_500">5: Very Good (45), 41.7%</span></li>
                        				<li class="mb-4_ c-dib_"><span class="green-rect"></span> <span class="txt-gray-6 weight_500">4: Good (22), 19.7%</span></li>
                        				<li class="mb-4_ c-dib_"><span class="orange-rect"></span> <span class="txt-gray-6 weight_500">3: Okay (27), 21.9%</span></li>
                        				<li class="mb-4_ c-dib_"><span class="purple-rect"></span> <span class="txt-gray-6 weight_500">2: Bad (13), 8.7%</span></li>
                        				<li class="mb-4_ c-dib_"><span class="red-rect"></span> <span class="txt-gray-6 weight_500">1: Very Bad (9), 7.6%</span></li>
                        			</ul>
                        		</div>
                        		<canvas id="chart1-pie" class="elm-right" style="height: 140px; width: 140px !important;"></canvas>
                        	</div>
                            </div>-->


                        </div>
                    </div>
            </div>
        </div>
		
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<script  type="text/javascript" >
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#category').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Category.'
            },
            tags: true,
                insertTag: function (data, tag) {
                // Insert the tag at the end of the results
                //data.push(tag);
                //console.log(data[0].id);
            }

        });
        
        $("#category").on('change',function() {
            console.log("changeddd");
            $("#survey_name").val('').trigger('change');
        });
        
        $("#practice_name").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Practice Names.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-pracatices')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                  ptype : ""
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
        
        $("#survey_name").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Survey Name.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-surveys')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: CSRF_TOKEN,
                  search: params.term, // search term
                  category : $("#category option:selected").val()
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

        });
        
        $('#created_by').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select User.'
            },
            tags: true,
                insertTag: function (data, tag) {
                // Insert the tag at the end of the results
                //data.push(tag);
                //console.log(data[0].id);
            }

        });
        
        $('#chart_type').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Chart Type.'
            },
            tags: true,
                insertTag: function (data, tag) {
                // Insert the tag at the end of the results
                //data.push(tag);
                //console.log(data[0].id);
            }

        });
    
        $("#generate_report").on('click', function(){
          
           if($("#survey_name").val() == "" || $("#survey_name").val() == null){
               $("#error_survey_name").show();
           }else{
               $("#error_survey_name").hide();
               $("#toggle_loader").show();
               $("#charts_data").html("");
               $.ajax({
                    type:'POST',
                    url:"{{url('survey/get-report-data')}}",
                    data: 'survey_id='+$("#survey_name").val()+'&created_by='+$('#created_by').val()+'&practice='+$('#practice_name').val(),
                    success:function(data) {
                        
                            $("#practice_data").html(data.practice);
                            $("#survey_data").html(data.title);
                            $("#count_data").html(data.count);
                            $("#time_data").html(data.time);
                            $("#charts_data").html(data.chart_html);
                                
                                setTimeout(function () {
                                    loadChartData(data.total_questions,data.labels,data.option_data);
                                }, 5000);
                           
                           $("#toggle_loader").hide();
                        },
                         headers: {
                             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                });
           }
           
        });
        
        function loadChartData(total,labels,opt_data)
        {
            for(let i=1; i<=total; i++)
            {
                    var configs = {
                        type: 'pie',
                        data: {
                                datasets: [{
                                        data: opt_data[i],
                                        backgroundColor: [
                                                "#218ac4",
                                                "#71b739",
                                                "#e89714",
                                                "#b327d1",
                                                "#d12727"
                                        ],
                                        label: 'Dataset 1'
                                }],
                                labels: labels[i]
                        },
                        options: {
                                responsive: false,
                                legend: {
                                        position: 'right',
                                        display: false,
                                },
                                title: {
                                        display: false,
                                        text: '20 min* 73 max*',
                                        position: 'bottom',
                                },
                                animation: {
                                        animateScale: true,
                                        animateRotate: true
                                },

                                //To draw full circle chart
                                circumference: 2 * Math.PI,
                                //rotation: -Math.PI / 120
                                rotation: 1.4
                        }
                };
                
                var context = 'chart'+i+'-pie';
                pie_chart = new Chart(context, configs);
            }
        }
       

</script>

@endsection

