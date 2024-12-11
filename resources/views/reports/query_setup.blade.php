@extends('layouts.compliance')

@section('content')
<style>
table.sponsored_saver_screener { border-collapse: collapse; border: solid 1px #cecece; }

table.bordered.sponsored_saver_screener thead th:first-child { border-radius: 0px; }
table.bordered.sponsored_saver_screener thead th:last-child { border-radius: 0px; }

table.bordered.sponsored_saver_screener tbody tr:first-child td { border-top: 0px; }

table.bordered.sponsored_saver_screener tbody tr td { border: solid 1px #cecece; }

.query-setup-wrapper {  }
.query-setup-wrapper .exp-col-btn { position: relative; }
.query-setup-wrapper .exp-col-btn:before { display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;content: "\f067";color: #fff;background-color: #3e7bc4;text-align: center;font-size: 13px;position: absolute;top: 0px;right: 0px;width: 16px;height: 16px;line-height: 17px;border-radius: 2px;margin-top: -1px; }
.query-setup-wrapper .exp-col-btn[aria-expanded="false"]:before { content: "\f067"; }
.query-setup-wrapper .exp-col-btn[aria-expanded="true"]:before { content: "\f068"; background-color: #afd13f;}


.query-setup-wrapper .gcn-cross-btn { border: solid 1px #3e7bc4; width: 18px; height: 18px; cursor: pointer; 
 display: inline-block; padding: 2px; text-align: center; opacity: 0.91;
 /*font-size: 12px; line-height: 14px;*/
 }
.query-setup-wrapper .gcn-cross-btn:hover { font-weight: 600; opacity: 1.0; border: solid 2px; padding: 1px; }

.query-setup-wrapper .gcn-search-brn { width: 32px; height: 32px; min-width: 32px; align-self: flex-start; }

.select2-container--default .select2-selection--single {
    border: solid 1px #3e7bc4 !important;
    border-radius: 6px;
    height: 32px;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder,
.select2-container--default .select2-selection--single .select2-selection__rendered {
    /*line-height: 30px;*/
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
</style>


<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12">
		<h4 class="elm-left fs-24_ mb-3_ txt-gray-6">Sponsored Savings Screener</h4>
		<div class="date-time elm-right lh-28_ mb-3_">Monday, December 28, 2020 12:36 AM</div>
	</div>
</div>


<div class="row pt-14_">
	<div class="col-sm-12 pl-0 pr-0 compliance-form_ query-setup-wrapper br-rds-6" style="border: solid 1px #cecece;">
		<div class="trow_ wd-100p">
    	    <div class="wd-100p flx-justify-start pos-rel_ p8-12_ bg-d9d9d9">
    	        <div class="txt-blue weight_600 tt_uc_ ">query setup</div>
    	        <span class="cur-pointer weight_600 fs-16_ txt-center exp-col-btn"
    	              style="margin-left: auto;"
    	              data-target="#query-setup1"
    	              data-toggle="collapse"
    	              aria-expanded="true"
    	              style="width: 16px;height: 16px;">
    	         </span>
    	    </div>
    	    <div id="query-setup1" class="collapse show wd-100p flx-justify-start f-wrap pos-rel_ pa-14_ bg-transparent">
    	        <div class="wd-100p flx-justify-start pos-rel_">
        			<div class="field wd-23p fld-practice-name mr-2p">
        				<label class="wd-100p c-dib_">
        				    <span class="wd-100p weight_500">Sponsor Item Name</span>
        				    <span class="wd-100p fs-12_ txt-blue weight_600">(30 characters alphanumeric & special)</span>
        				</label>
        				<select class="wd-100p tt_uc_ txt-blue weight_600" pattern="^[a-zA-Z\d\-_\s]+$" name='drug_name' id='drug_name'>
						</select>
        			</div>
        			
        			<div class="field wd-23p fld-practice-name mr-2p">
        				<label class="wd-100p c-dib_">
        				    <span class="wd-100p weight_500">Sponsor Source</span>
        				    <span class="wd-100p fs-12_ txt-blue weight_600">(50 characters alphanumeric & special)</span>
        				</label>
        				<select class="wd-100p tt_uc_ txt-blue weight_600" pattern="^[a-zA-Z\d\-_\s]+$" name='drug_source' id='drug_source'>
						</select>
        			</div>
    			
        			<div class="field wd-23p fld-practice-name mr-2p">
        				<label class="wd-100p c-dib_">
        				    <span class="wd-100p weight_500">Offer Type</span>
        				    <span class="wd-100p fs-12_ txt-blue weight_600">(10 characters alphanumeric & special)</span>
        				</label>
        				<select class="wd-100p tt_uc_ txt-blue weight_600" name='offer_type' id='offer_type'>
						</select>
        			</div>
        			
        			<div class="field wd-23p fld-practice-name">
        				<label class="wd-100p c-dib_">
        				    <span class="wd-100p weight_500">Offer Link</span>
        				    <span class="wd-100p fs-12_ txt-blue weight_600">(75 characters alphanumeric & special)</span>
        				</label>
        				<select class="wd-100p tt_uc_ txt-blue weight_600" name='offer_link' id='offer_link'>
						</select>
        			</div>
    	        </div>
    	        
    	        <div class="wd-100p flx-justify-start pos-rel_ mt-14_">
        			<div class="wd-23p mr-2p" style="min-width: 300px;">
        				<div class="trow_ wd-100p c-dib_">
        				    <span class="weight_500">Sponsored GCNs</span>
                			<em class="fs-12_ txt-blue weight_600 fs-italic_">(several 5 alpha / digit GCNs)</em>
        				</div>
        				<div class="trow_ wd-100p pa-6_ br-rds-6 mt-7_" style="border: solid 1px #3e7bc4; flex-grow: 2;align-content: flex-start;">
        				    <!-- <input type="text" class="mb-4_ mr-7_" style="width: 140px;"> -->
							<select class="sp_gcn_seq wd-100p tt_uc_ txt-blue weight_600" name='sp_gcn_seq[]' id='sp_gcn_seq' multiple="multiple">
							</select>
        				  <!--  <button type="button" class="gcn-search-brn btn bg-blue-txt-wht weight_500 br-rds-50p cen-center fs-20_ lh-31_ pa-0_ fa fa-search" style="width: 32px; height: 32px;"></button> -->
        				    
        				    <div class="flx-justify-start f-wrap flex-v-center c-mr-7_ ">
            				    <?php /*
                                  for ($x = 0; $x <= 6; $x++) {
                                ?>
                				    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_  p4-8_ br-rds-13">
                				        <span class="txt-blue weight_600 mr-6_">46593</span>
                				        <span class="txt-blue weight_500 br-rds-50p fs-12_ lh-12_ gcn-cross-btn">&#10006;</span> <!--  &#10006; -->
                				    </div>
            				    <?php
                                  }*/
                                ?>
                            </div>
        				</div>
        			</div>
        			<div class="wd-73p" style="flex-grow: 2; display: flex; flex-wrap: wrap; flex-direction: column;">
        				<div class="trow_ wd-100p">
        				    <span class="weight_500">GCNs</span>
                			<em class="fs-12_ txt-blue weight_600 fs-italic_">(allow upto 25 to be selected)</em>
        				</div>
        				<div class="flx-justify-start f-wrap flex-v-center c-mr-7_ wd-100p pa-6_ br-rds-6 mt-7_" style="border: solid 1px #3e7bc4; flex-grow: 2;align-content: flex-start;">
        				   <!-- <input type="text" class="mb-4_" style="width: 140px;"> -->
						   <select class="gcn_seq wd-100p tt_uc_ txt-blue weight_600" name='gcn_seq[]' id='gcn_seq' multiple="multiple">
							</select>
        				   <!-- <button type="button" class="gcn-search-brn btn bg-blue-txt-wht weight_500 br-rds-50p cen-center fs-20_ lh-31_ pa-0_ fa fa-search" style="width: 32px; height: 32px; min-width: 32px;"></button> -->
        				    
        				    <?php
                             /* for ($x = 0; $x <= 24; $x++) {
                            ?>
            				    <div class="bg-gray-d9 flx-justify-start flex-v-center mb-3_ mt-3_ p4-8_ br-rds-13">
            				        <span class="txt-blue weight_600 mr-6_">46593</span>
            				        <span class="txt-blue weight_500 br-rds-50p fs-12_ lh-12_ gcn-cross-btn">&#10006;</span> <!--  &#10006; -->
            				    </div>
        				    <?php
                              }*/
                            ?>
        				</div>
        			</div>
        		</div>
        		
        		<div class="wd-100p flx-justify-start pos-rel_ mt-14_">
        		    
        		    <div class="wd-100p" style="max-width: 580px;">
            		    <div class="trow_ wd-100p c-dib_ c-mr-7_">
            				<span class="weight_500">Minor Reporting Categories</span>
                    		<!-- <em class="fs-12_ txt-blue weight_600 fs-italic_">(allow upto 3 to be selected)</em> -->
            			</div>
            			<select class="wd-100p tt_uc_ txt-blue weight_600" name='minor_categories' id='minor_categories'>
						</select>
        			</div>
        			<button type="button" id="search_btn" class="btn ml-14_ bg-blue-txt-wht weight_500 ml-auto_ fs-14_" style="min-width: 120px; align-self: flex-end;">Search</button>
        		    
        		</div>
    	        
    	    </div>
	    </div>
	    
	    
	</div>
</div>


<div class="row mt-17_">
	<div class="col-sm-12 pl-0">
		<h4 class="elm-left fs-24_ mb-3_ tt_uc_ txt-blue weight_700">Search Results</h4>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		
		<div class="row mt-14_ mb-7_">
			<div class="col-sm-12  pr-0 pl-0 table-responsive">
				<table class="table bordered sponsored_saver_screener" id="data_table" style="min-width: 1024px;">
					<thead>
						<tr class="weight_500-force-childs bg-blue">
							<th class="txt-wht bg-blue">Sponsored Item</th>
							<th class="txt-wht bg-orange" style="background-color: #e2a623 !important; color: #fff !important;">Offer Type</th>
							<th class="txt-wht bg-gr-bl-dk txt-gray-9a " style="background-color: #44546a !important; color: #9a9a9a !important;">GCN</th>
							<th class="txt-wht bg-grn-lk">Prospects</th>
							<th class="txt-wht bg-blue">Links</th>
						</tr>
					</thead>
					<tbody id='drug_records'>
						<tr id='empty_row'><td colspan="5" align='center' style="text-align: center;"><b id='style_content'>No data found!</b></td></tr>                                    
					</tbody>					    
				</table>
			</div>
		</div>
	</div>
</div>

<script src="{{url('/js/jquery/jquery.min.3.4.1.js')}}"></script>
<script src="{{url('/js/select2/select2.min.js')}}"></script>
<script>

$("#search_btn").click(function(){
	var ids = [];
	var drugName = $("#drug_name option:selected").val(); //int value
	var drugSource = $("#drug_source option:selected").val(); //int value
	var offerType = $("#offer_type option:selected").val(); //int value
	var offerLink = $("#offer_link option:selected").val(); //int value
	var minorCats = $("#minor_categories option:selected").val(); //int value
	var spGcnSeq = $(".sp_gcn_seq").val(); //array
	var gcnSeq = $(".gcn_seq").val();//array

	if (drugName != undefined && drugName != null) {
		ids.push(drugName);
	}
	if (drugSource != undefined && drugSource != null) {
		ids.push(drugSource);
	}
	if (offerType != undefined && offerType != null) {
		ids.push(offerType);
	}
	if (offerLink != undefined && offerLink != null) {
		ids.push(offerLink);
	}
	if (minorCats != undefined && minorCats != null) {
		ids.push(minorCats);
	}
	if (spGcnSeq.length>0) {
		ids = ids.concat(spGcnSeq);
	}
	if (gcnSeq.length>0) {
		ids = ids.concat(gcnSeq);
	}
	
	$("#search_btn").prop('disabled', false);
	$.ajax({
                type:'POST',
                url:"{{url('/report/query_setup')}}",
                data: 'drug_ids='+ids,
                success:function(data) {                    
                    if(data != ""){
                        var table = $('#data_table').DataTable({
                            destroy: true,
                            searching: false,
                            "pagingType": "full_numbers",
                            "iTotalRecords": data.total,
                            "iTotalDisplayRecords": 10,
                            "sEcho":10,
                            "aaData" : data.data,
                            "aoColumnDefs":[{
                                    "aTargets":[ 0 ],
                                    "className": "bg-tb-blue-lt2 txt-blue"
                                },{
                                    "aTargets":[ 1 ],
                                    "className": "bg-tb-orange-lt txt-orange"
                                },{
                                    "aTargets":[ 2 ],
                                    "className": "bg-gray-e txt-gray-9a"
                                },{
                                    "aTargets":[ 3 ],
                                    "className": "bg-tb-grn-lt txt-gray-42 cnt-right-force"
                                },{
                                    "aTargets":[ 4 ],
                                    "className": "bg-tb-blue-lt2 txt-blue td_u_"
                                }],
                                select: {
                                    style: 'os',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ]
                        });    
                         
                    }else
                        $("#drug_records").html('<tr id="empty_row"><td colspan="8" align="center" style="text-align: center;"><b style="color:red;">No data found!</b></td></tr>');
                                             
                    $("#search_btn").prop('disabled', false);      
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
             });
});

 $("#drug_name").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Sponsor Item.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
			  type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "sponsor_item",
				  sponsored: "N"
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

		$("#drug_source").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Sponsor Source.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "sponsor_source",
				  sponsored: "N"
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
		
		$("#offer_type").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Offer Type.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "offer_type",
				  sponsored: "N"
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
		
		$("#offer_link").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Offer website.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "offer_website",
				  sponsored: "N"
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

		
		$("#minor_categories").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select reporting categories.'
            },
            minimumInputLength: 2,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "minor_reporting_class",
				  sponsored: "N"
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

		$("#gcn_seq").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select gcn sequence.'
            },
            minimumInputLength: 2,
			maximumSelectionLength: 25,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "gcn_seq",
				  sponsored: "N"
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

		$("#sp_gcn_seq").select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select sponsored gcn sequence.'
            },
            minimumInputLength: 2,
			maximumSelectionLength: 5,
            allowClear: true,
            ajax: { 
              url: "{{url('/get-query-setup-filter')}}",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: '<?php echo csrf_token() ?>',
                  search: params.term, // search term
				  data_field: "gcn_seq",
				  sponsored: "Y"
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
</script>
@endsection